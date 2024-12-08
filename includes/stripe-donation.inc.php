<?php

require '../vendor/autoload.php';

use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

$stripeApiKey = $_ENV['STRIPE_API_KEY'];
if (!$stripeApiKey) {
    throw new Exception('Stripe API key not set in environment variables.');
}

\Stripe\Stripe::setApiKey($stripeApiKey);

session_start();
$donation_frequency = $_POST['frequency'];
$dedication = $_POST['dedication-text'];

// Ensure the donation amount is cast to a float
$donation_amount = isset($_POST['donate-custom-amount']) && $_POST['donate-custom-amount'] !== '' 
    ? (float)$_POST['donate-custom-amount'] 
    : (float)$_POST['amount'];

$user = $_SESSION['userid'];

// Calculate processing fee if cover fees is checked
$fee_percentage = 0.029;
$fixed_fee = 0.30;
$admin_fee = 0.015;
$gross_amount = ($donation_amount + $fixed_fee) / (1 - ($fee_percentage + $admin_fee));


// Convert the final donation amount to cents and ensure it's an integer
$donation_amount_in_cents = round($gross_amount * 100);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($donation_frequency == "one-time") {
        // Create a one-time payment Checkout Session
        try {
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card', 'us_bank_account'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'One-time Donation',
                        ],
                        'unit_amount' => $donation_amount_in_cents,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://champschance.org/thank-you.php?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => 'http://champschance.org/donate.php?error=cancel',
                'metadata' => ['dedication_text' => $dedication, 'user_id' => $user, 'freq' => $donation_frequency],
            ]);
            header("Location: " . $session->url);
            exit();
        } catch (Exception $e) {
            echo "Error creating one-time payment session: " . $e->getMessage();
        }
    } elseif ($donation_frequency == "monthly") {
        // Create a recurring payment (subscription) Checkout Session
        if ($user == null) {
            header("Location: ../donate.php?error=not-logged-in");
            exit();
        }
        try {
            $price = \Stripe\Price::create([
                'unit_amount' => $donation_amount_in_cents,
                'currency' => 'usd',
                'recurring' => ['interval' => 'month'],
                'product_data' => ['name' => 'Monthly Donation'],
            ]);

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card', 'us_bank_account'],
                'line_items' => [[
                    'price' => $price->id,
                    'quantity' => 1,
                ]],
                'mode' => 'subscription',
                'success_url' => 'http://champschance.org/thank-you.php?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => 'http://champschance.org/donate.php?error=cancel',
                'metadata' => ['dedication_text' => $dedication, 'user_id' => $user, 'freq' => $donation_frequency],
            ]);

            header("Location: " . $session->url);
            exit();
        } catch (Exception $e) {
            echo "Error creating subscription session: " . $e->getMessage();
        }
    } else {
        header("Location: /home.php?error=no-donation-freq");
    }
}
?>
