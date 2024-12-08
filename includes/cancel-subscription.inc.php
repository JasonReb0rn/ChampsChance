<?php
session_start();
require '../vendor/autoload.php';
require_once 'dbh.inc.php';

$stripeApiKey = $_ENV['STRIPE_API_KEY'];
if (!$stripeApiKey) {
    throw new Exception('Stripe API key not set in environment variables.');
}

\Stripe\Stripe::setApiKey($stripeApiKey);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subscription_id = $_POST['subscription_id'];
    $user_id = $_SESSION['userid'];

    try {
        // Cancel the subscription
        $subscription = \Stripe\Subscription::retrieve($subscription_id);
        $subscription->cancel();

        // Update the payment status in the database to 'cancelled'
        $stmt = $conn->prepare("UPDATE donations SET donation_payment_status = 'cancelled' WHERE donation_subscription_id = ? AND donation_user = ?");
        $stmt->bind_param("ss", $subscription_id, $user_id);
        if ($stmt->execute()) {
            //echo "Subscription cancelled successfully.";
            $stmt->close();
            header("Location: ../profile.php?success");
            exit();
        } else {
            //echo "Error updating subscription status in the database: " . $stmt->error;
            $stmt->close();
            header("Location: ../profile.php?error=db-update-error");
            exit();
        }

        

    } catch (Exception $e) {
        //echo "Error cancelling subscription: " . $e->getMessage();
    }
} else {
    header("Location: ../profile.php?error=invalid-request");
    exit();
}

$conn->close();
?>
