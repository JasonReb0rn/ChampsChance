<?php

require '../vendor/autoload.php';
require 'dbh.inc.php';

$stripeApiKey = $_ENV['STRIPE_API_KEY'];
if (!$stripeApiKey) {
    throw new Exception('Stripe API key not set in environment variables.');
}

\Stripe\Stripe::setApiKey($stripeApiKey);

$endpoint_secret = $_ENV['STRIPE_ENDPOINT_SECRET'];

// Retrieve the request's body and parse it as JSON
$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

try {
    $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
} catch (\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
    http_response_code(400);
    exit();
}

// Handle the event
if ($event->type == 'payment_intent.succeeded' || $event->type == 'invoice.payment_succeeded') {
    $payment_intent_id = $event->data->object->payment_intent ?? null;
    $session_id = $event->data->object->metadata->session_id ?? null;
    $subscription_id = $event->data->object->subscription ?? null;



    if ($payment_intent_id) {
        // Update payment status based on payment intent
        // Update database table 'donations' where 'donation_session_id' = $payment_intent_id
        $stmt = $conn->prepare("UPDATE donations SET donation_payment_status = 'successful' WHERE donation_session_id = ?");
        $stmt->bind_param("s", $session_id);

        if ($stmt->execute()) {
            // Optionally, you can perform additional actions here
        } else {
            echo "Error: " . $stmt->error;
        }
    } elseif ($subscription_id) {
        // Update payment status based on subscription
        // Update database table 'donations' where 'donation_subscription_id' = $subscription_id
        $stmt = $conn->prepare("UPDATE donations SET donation_payment_status = 'successful' WHERE donation_subscription_id = ?");
        $stmt->bind_param("s", $subscription_id);

        if ($stmt->execute()) {
            // Optionally, you can perform additional actions here
        } else {
            echo "Error: " . $stmt->error;
        }
    }


    // Close connections
    $stmt->close();
    $conn->close();
}

http_response_code(200);

?>

