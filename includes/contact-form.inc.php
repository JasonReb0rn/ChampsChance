<?php
ob_start();

require '../vendor/autoload.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;
use Dotenv\Dotenv;

// Helper function to check if we're running locally
function isLocalEnvironment() {
    return (
        $_SERVER['SERVER_NAME'] === 'champschance' || 
        $_SERVER['SERVER_NAME'] === 'localhost' ||
        $_SERVER['REMOTE_ADDR'] === '127.0.0.1'
    );
}

// Load environment variables from .env file if it exists
if (file_exists(__DIR__ . '/../.env')) {
    try {
        $dotenv = Dotenv::createImmutable(realpath(__DIR__ . '/..'));
        $dotenv->load();
    } catch (Exception $e) {
        error_log('Dotenv error: ' . $e->getMessage());
    }
}

$recaptcha_secret = $_ENV['CC_CAPTCHAv3_SECRET'] ?? null;

// Input validation
if (!isset($_POST['g-recaptcha-response']) || 
    !isset($_POST['name']) || 
    !isset($_POST['subject']) || 
    !isset($_POST['mail']) || 
    !isset($_POST['message'])) {
    error_log('Missing POST fields: ' . 
              'recaptcha=' . isset($_POST['g-recaptcha-response']) . 
              ', name=' . isset($_POST['name']) .
              ', subject=' . isset($_POST['subject']) .
              ', mail=' . isset($_POST['mail']) .
              ', message=' . isset($_POST['message']));
    header("Location: ../contact.php?contact-error=missing-fields");
    exit();
}

// Sanitize inputs
$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
$subject = htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8');
$mailFrom = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
$recaptcha_response = $_POST['g-recaptcha-response'];

// Verify reCAPTCHA token with Google
$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
$recaptcha_data = [
    'secret' => $recaptcha_secret,
    'response' => $recaptcha_response,
    'remoteip' => $_SERVER['REMOTE_ADDR']
];

$recaptcha_options = [
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => http_build_query($recaptcha_data)
    ]
];

$recaptcha_context = stream_context_create($recaptcha_options);
$recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);

if ($recaptcha_result === FALSE) {
    error_log('Failed to contact reCAPTCHA server');
    header("Location: ../contact.php?contact-error=recaptcha-connection-failed");
    exit();
}

$recaptcha_response = json_decode($recaptcha_result);

if (json_last_error() !== JSON_ERROR_NONE) {
    error_log('Failed to parse reCAPTCHA response: ' . json_last_error_msg());
    header("Location: ../contact.php?contact-error=recaptcha-parse-failed");
    exit();
}

// Check if reCAPTCHA verification was successful and score is acceptable
if ($recaptcha_response->success) {
    if (!isset($recaptcha_response->score)) {
        error_log('No score in reCAPTCHA response');
        header("Location: ../contact.php?contact-error=recaptcha-no-score");
        exit();
    }
    
    if ($recaptcha_response->score >= 0.3) { // Lowered threshold for testing
        $ses_key = $_ENV['AWS_CC_KEY'] ?? null;
        $ses_secret = $_ENV['AWS_CC_SECRET'] ?? null;

        // Base configuration for AWS SES
        $config = [
            'version' => 'latest',
            'region' => 'us-east-1',
            'credentials' => [
                'key' => $ses_key,
                'secret' => $ses_secret,
            ]
        ];

        // Add SSL verification path only for local environment
        if (isLocalEnvironment()) {
            $config['http'] = [
                'verify' => 'C:/wamp64/cacert.pem'
            ];
        }

        try {
            $client = SesClient::factory($config);

            $result = $client->sendEmail([
                'Source' => 'noreply@champschance.org',
                'Destination' => [
                    'ToAddresses' => ['champschance01@outlook.com'],
                ],
                'Message' => [
                    'Subject' => [
                        'Data' => $subject,
                        'Charset' => 'UTF-8',
                    ],
                    'Body' => [
                        'Text' => [
                            'Data' => "You've received an email from " . $name . " at " . $mailFrom . " using the contact form on champschance.org!\n\n" . $message,
                            'Charset' => 'UTF-8',
                        ],
                    ],
                ],
            ]);

            if ($result['MessageId']) {
                header("Location: ../contact.php?contact-success=sent");
                exit();
            } else {
                error_log('SES send failed - no MessageId returned');
                header("Location: ../contact.php?contact-error=failed");
                exit();
            }
        } catch (AwsException $e) {
            // Log the error safely without exposing details to the user
            error_log('AWS SES Error: ' . $e->getMessage());
            header("Location: ../contact.php?contact-error=failed");
            exit();
        }
    } else {
        error_log('reCAPTCHA score too low: ' . $recaptcha_response->score);
        header("Location: ../contact.php?contact-error=recaptcha-low-score");
        exit();
    }
} else {
    // Log specific error codes from reCAPTCHA
    $error_codes = isset($recaptcha_response->{'error-codes'}) ? implode(', ', $recaptcha_response->{'error-codes'}) : 'no error codes provided';
    error_log('reCAPTCHA verification failed. Error codes: ' . $error_codes);
    header("Location: ../contact.php?contact-error=recaptcha-failed&errors=" . urlencode($error_codes));
    exit();
}

ob_end_flush();