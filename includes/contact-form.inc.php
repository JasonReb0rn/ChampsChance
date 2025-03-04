<?php
ob_start();

require '../vendor/autoload.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;
use Dotenv\Dotenv;

function isLocalEnvironment() {
    return (
        $_SERVER['SERVER_NAME'] === 'champschance' || 
        $_SERVER['SERVER_NAME'] === 'localhost' ||
        $_SERVER['REMOTE_ADDR'] === '127.0.0.1'
    );
}

if (file_exists(__DIR__ . '/../.env')) {
    try {
        $dotenv = Dotenv::createImmutable(realpath(__DIR__ . '/..'));
        $dotenv->load();
    } catch (Exception $e) {
        error_log('Configuration error');
        header("Location: ../contact.php?contact-error=config");
        exit();
    }
}

$recaptcha_secret = $_ENV['CC_CAPTCHAv3_SECRET'] ?? null;
$ses_key = $_ENV['AWS_CC_KEY'] ?? null;
$ses_secret = $_ENV['AWS_CC_SECRET'] ?? null;

if (!$recaptcha_secret || !$ses_key || !$ses_secret) {
    error_log('Configuration error');
    header("Location: ../contact.php?contact-error=config");
    exit();
}

if (!isset($_POST['g-recaptcha-response'], $_POST['name'], $_POST['subject'], $_POST['mail'], $_POST['message'])) {
    error_log('Missing required fields');
    header("Location: ../contact.php?contact-error=missing-fields");
    exit();
}

$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
$subject = htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8');
$mailFrom = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
$recaptcha_response = $_POST['g-recaptcha-response'];

$recaptcha_options = [
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => http_build_query([
            'secret' => $recaptcha_secret,
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ])
    ]
];

$recaptcha_context = stream_context_create($recaptcha_options);
$recaptcha_result = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $recaptcha_context);

if ($recaptcha_result === FALSE) {
    error_log('Verification error');
    header("Location: ../contact.php?contact-error=recaptcha-connection-failed");
    exit();
}

$recaptcha_response = json_decode($recaptcha_result);

if (!$recaptcha_response || json_last_error() !== JSON_ERROR_NONE) {
    error_log('Verification error');
    header("Location: ../contact.php?contact-error=recaptcha-parse-failed");
    exit();
}

if (!$recaptcha_response->success || !isset($recaptcha_response->score)) {
    error_log('Verification error');
    header("Location: ../contact.php?contact-error=recaptcha-failed");
    exit();
}

if ($recaptcha_response->score >= 0.3) {
    $config = [
        'version' => 'latest',
        'region' => 'us-east-1',
        'credentials' => [
            'key' => $ses_key,
            'secret' => $ses_secret,
        ]
    ];

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
                'ToAddresses' => ['jasonchoate97@gmail.com', 'champschance01@outlook.com'],
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

        if (isset($result['MessageId'])) {
            header("Location: ../contact.php?contact-success=sent");
            exit();
        }
        
        error_log('Service error');
        header("Location: ../contact.php?contact-error=failed");
        exit();
        
    } catch (AwsException $e) {
        error_log('Service error');
        header("Location: ../contact.php?contact-error=service");
        exit();
    }
} else {
    error_log('Verification error');
    header("Location: ../contact.php?contact-error=recaptcha-low-score");
    exit();
}

ob_end_flush();