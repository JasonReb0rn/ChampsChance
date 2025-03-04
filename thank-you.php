<?php
  // Set session cookie parameters to make it accessible across all directories
  session_set_cookie_params(0, '/');
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Thank You!</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=052523">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon.png">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-48.png" sizes="48x48">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-64.png" sizes="64x64">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-128.png" sizes="128x128">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    
    <?php
        include_once 'header.php';
    ?>
    <script src="js/breadcrumbs.js"></script>
    

    <div class="main-content">

    <?php
        require 'vendor/autoload.php';
        require 'includes/dbh.inc.php';

        $stripeApiKey = $_ENV['STRIPE_API_KEY'];
        if (!$stripeApiKey) {
            throw new Exception('Stripe API key not set in environment variables.');
        }

        \Stripe\Stripe::setApiKey($stripeApiKey);
        
        $session_id = $_GET['session_id'] ?? '';

        if ($session_id) {
            try {
                // Retrieve the session details
                $session = \Stripe\Checkout\Session::retrieve($session_id);
            
                // Get the payment intent ID or subscription ID
                $payment_intent_id = $session->payment_intent ?? null;
                $subscription_id = $session->subscription ?? null;
            
                if ($payment_intent_id) {
                    // Retrieve the payment intent
                    $payment = \Stripe\PaymentIntent::retrieve($payment_intent_id);
                    $payment_status = $payment->status;
                } elseif ($subscription_id) {
                    // Retrieve the subscription
                    $subscription = \Stripe\Subscription::retrieve($subscription_id);
                
                    // Get the latest invoice
                    $latest_invoice = \Stripe\Invoice::retrieve($subscription->latest_invoice);
                
                    // Check the payment status of the latest invoice
                    $payment_status = $latest_invoice->status;
                } else {
                    echo "No payment intent or subscription found.";
                    exit();
                }
            
                // Handle payment status accordingly
                $payment_status = match ($payment_status) {
                    'paid', 'succeeded' => 'successful',
                    'requires_action', 'requires_confirmation' => 'pending_verification',
                    'processing' => 'pending',
                    'open' => 'pending',
                    default => 'failed',
                };
            
                // Get the dedication text from the metadata
                $dedication_text = $session->metadata->dedication_text ?? null;
                $donation_user = $session->metadata->user_id ?? null;
                $donation_freq = $session->metadata->freq;

                // Ensure dedication_text is NULL if it's an empty string
                if (empty($dedication_text)) {
                    $dedication_text = null;
                }
            
                // Check if the session ID already exists in the database
                $check_stmt = $conn->prepare("SELECT COUNT(*) FROM donations WHERE donation_session_id = ?");
                $check_stmt->bind_param("s", $session_id);
                $check_stmt->execute();
                $check_result = $check_stmt->get_result()->fetch_assoc();
            
                if ($check_result['COUNT(*)'] == 0) {
                    // Insert dedication text into the database with payment status
                    $stmt = $conn->prepare("INSERT INTO donations (donation_session_id, donation_subscription_id, donation_user, donation_dedication_text, donation_payment_status, donation_freq) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssisss", $session_id, $subscription_id, $donation_user, $dedication_text, $payment_status, $donation_freq);
                
                    if ($stmt->execute()) {
                        echo "Donation recorded successfully! Payment status: " . $payment_status;
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                
                    // Close insert statement
                    $stmt->close();
                } else {
                    echo "Donation already exists in the database. Payment status: $payment_status";
                }
            
                // Close check statement and database connection
                $check_stmt->close();
                $conn->close();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "No session ID provided.";
        }
    ?>

        <div class="content-container-solid">
            <div class="content-block-flex-container">
                <div class="content-block-flex-photo">
                    <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/donation_1.png" alt="Spotlight your business!">
                </div>
                <div class="content-block-flex-content" style="display: flex; flex-direction: column; align-items: center;">
                    <?php  
                        if ($payment_status === 'successful') {
                            echo("<h3>Thank you for your donation!</h3>");

                        } elseif ($payment_status === 'pending' || $payment_status === 'pending_verification') {
                            echo("<h3>Your donation is being processed!</h3>");

                        } else {
                            echo("<h3>Oops, something went wrong!</h3>");
                        }

                    ?>

                    <div style="max-width: 80%; margin-bottom: 40px;">
                        <?php  
                            if ($payment_status === 'successful') {
                                echo("<p>Your donation was successfully processed! Your donation will go directly towards helping dogs in need. You're such an amazing person, the world needs more people like you.</p>");
                                
                                if (!empty($dedication_text)) {
                                    echo("<ul><li><p>You can find your dedication to $dedication_text <a href=\"dedicated-donations.php\">here on the donate page.</a></p></li>");
                                }

                                if ($donation_freq === 'monthly') {
                                    echo("<li><p>You can manage your monthly donation from your <a href=\"profile.php\">profile page.</a></p></li></ul>");
                                }
                                

                                echo("<a href=\"home.php\"><button>Go Home</button></a>");

                            } elseif ($payment_status === 'pending' || $payment_status === 'pending_verification') {
                                echo("<p>Thank you so much for starting the donation process. Your information was processed, but you'll need to take additional steps before your donation goes through.<br><br>You'll receive an email with more instructions, you've not yet been charged.</p>");
                                
                                if (!empty($dedication_text)) {
                                    echo("<ul><li><p>You'll be able to find your dedication to $dedication_text <a href=\"dedicated-donations.php\">here</a> once your payment is processed.</p></li>");
                                }

                                if ($donation_freq === 'monthly') {
                                    echo("<li><p>Once processed, you'll be able to manage your monthly donation from your <a href=\"profile.php\">profile page.</a></p></li></ul>");
                                }

                                echo("<a href=\"home.php\"><button>Go Home</button></a>");

                            } else {
                                echo("<p>We're sorry, but your donation could not be processed. Please try again, and if the error perisists, please reach out to us and let us know.</p>");
                                echo("<p>Your support means the world to us and the dogs we rescue, and we apologize for any inconvenience.</p>");
                            }

                        ?>
                    </div>
                    
                </div>
            </div>
        </div>
        
        
    </div>

    <script>
        // JavaScript code here
        function getQueryParamValue(param) {
            let params = new URLSearchParams(window.location.search);
            return params.get(param);
        }

        let sessionId = getQueryParamValue('session_id');

        if (sessionId !== null) {
            let inputElement = document.getElementById('session_id');
            if (inputElement) {
                inputElement.value = sessionId;
            } else {
                console.warn("Element with id 'session_id' not found.");
            }
        } else {
            console.warn("session_id parameter not found in the URL.");
        }
    </script>
    
    <?php
        include_once 'footer.php';
    ?>

        
    </div>
</body>

</html>