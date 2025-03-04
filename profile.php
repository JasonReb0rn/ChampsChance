<?php
  // Set session cookie parameters to make it accessible across all directories
  session_set_cookie_params(0, '/');
  session_start();

  // Check if the user is logged in and has admin rights
  if (!(isset($_SESSION["useruid"]))) {
    // Redirect the user to a different page or display an error message
    header("Location: login.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Profile</title>
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
    <link rel="stylesheet" href="node_modules/@glidejs/glide/dist/css/glide.core.min.css">
    <!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
</head>

<body>
    
    <?php
        include_once 'header.php';
    ?>
    <script src="js/breadcrumbs.js"></script>

    <div class="main-content">
        <div class="content-container-solid">
                
        <div class="content-block-flex-container">
            <div class="content-block-flex-content">
                <div class="profile-edit-header">
                    <?php echo "<h3>Hello " . $_SESSION["useruid"] . ".</h3>"; ?>
                    <p>Use this page to edit your profile.</p>
                </div>
            </div>
        </div>


        <div class="edit-profile-container">
            <div class="edit-avatar-container">
                <h2>Edit Profile Picture:</h2>
                <h3>Choose a picture:</h3>
                <div class="avatar-icon-container">
                    <div class="avatar-option" data-value="default_dog_1.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_1.png" alt="Avatar 1"></div>
                    <div class="avatar-option" data-value="default_dog_2.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_2.png" alt="Avatar 2"></div>
                    <div class="avatar-option" data-value="default_dog_3.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_3.png" alt="Avatar 3"></div>
                    <div class="avatar-option" data-value="default_dog_4.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_4.png" alt="Avatar 4"></div>
                    <div class="avatar-option" data-value="default_dog_5.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_5.png" alt="Avatar 5"></div>
                    <div class="avatar-option" data-value="default_dog_6.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_6.png" alt="Avatar 6"></div>
                    <div class="avatar-option" data-value="default_dog_7.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_7.png" alt="Avatar 7"></div>
                    <div class="avatar-option" data-value="default_dog_8.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_8.png" alt="Avatar 8"></div>
                    <div class="avatar-option" data-value="default_dog_9.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_9.png" alt="Avatar 9"></div>
                    <div class="avatar-option" data-value="default_dog_10.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_10.png" alt="Avatar 10"></div>
                    <div class="avatar-option" data-value="default_dog_11.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_11.png" alt="Avatar 11"></div>
                    <div class="avatar-option" data-value="default_dog_12.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_12.png" alt="Avatar 12"></div>
                    <div class="avatar-option" data-value="default_dog_13.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_13.png" alt="Avatar 13"></div>
                    <div class="avatar-option" data-value="default_dog_14.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_14.png" alt="Avatar 14"></div>
                    <div class="avatar-option" data-value="default_dog_15.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_15.png" alt="Avatar 15"></div>
                    <div class="avatar-option" data-value="default_dog_16.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_16.png" alt="Avatar 16"></div>
                    <div class="avatar-option" data-value="default_dog_17.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_17.png" alt="Avatar 17"></div>
                    <div class="avatar-option" data-value="default_dog_18.png"><img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/default_dog_18.png" alt="Avatar 18"></div>
                </div>
                
                <div class="avatar-img-credits">
                    <a href="https://www.freepik.com/free-vector/illustration-dogs-collection_2800643.htm#query=dog%20avatar&position=4&from_view=keyword&track=ais&uuid=78aa013a-0c72-4489-a052-9aa64c98f46b">Images by rawpixel.com</a>
                    <p>on Freepik</p>
                </div>
                

                <h2>Or upload one of your own!</h2>
                <form id="avatarForm" action="includes/edit-profile-avatar.inc.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="avatarValue" name="avatarValue" value="default_dog_1.png">
                    <input type="file" name="avatarFile" accept="image/jpeg, image/jpg, image/png">
                    <button type="submit">Submit</button>
                </form>
            </div>

            <div class="subscription-manager-container">
                <h3>Manage Subscriptions:</h3>
                <p>If you have selected to donate on a monthly subscription, you can use this section to cancel your subscription.</p>
            
                <?php

                    require 'vendor/autoload.php';
                    require 'includes/dbh.inc.php';

                    \Stripe\Stripe::setApiKey($_ENV['STRIPE_API_KEY']);

                    $user_id = $_SESSION['userid'];

                    $query = $conn->prepare("SELECT donation_subscription_id, donation_dedication_text FROM donations WHERE donation_user = ? AND donation_freq = 'monthly' AND donation_payment_status != 'cancelled'");
                    $query->bind_param("s", $user_id);
                    $query->execute();
                    $result = $query->get_result();
                
                    if ($result->num_rows > 0) {

                        echo $result->num_rows > 1 ? "<h1>Your Subscriptions:</h1>" : "<h1>Your Subscription:</h1>";
                        
                        while ($row = $result->fetch_assoc()) {
                            $subscription_id = $row['donation_subscription_id'];
                            try {
                                $subscription = \Stripe\Subscription::retrieve($subscription_id);
                                $price_id = $subscription->items->data[0]->price->id;
                                $price = \Stripe\Price::retrieve($price_id);
                                echo "<div class=\"subscription-card\">";
                                echo "<h2>$" . $price->unit_amount / 100 . " per " . ucfirst($price->recurring->interval) . "</h2>";

                                if ($row['donation_dedication_text'] != null) {
                                    echo "<p>Dedicated to " . $row['donation_dedication_text'] . "</p>";
                                }
                                
                                echo "<p>Subscription ID: " . $subscription->id . "</p>";
                                echo "<p>Status: " . $subscription->status . "</p>";
                                echo "<form action='includes/cancel-subscription.inc.php' method='POST'>";
                                echo "<input type='hidden' name='subscription_id' value='" . $subscription->id . "'>";
                                echo "<button type='submit'>Cancel Subscription</button>";
                                echo "</form>";
                                echo "</div>";
                            } catch (Exception $e) {
                                echo "<p>Error retrieving subscription: " . $e->getMessage() . "</p>";
                            }
                        }
                    } else {
                        echo "<p>You have no active subscriptions.</p>";
                    }
                    
                    $query->close();
                    $conn->close();
                ?>
            
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const avatarOptions = document.querySelectorAll('.avatar-option');
                    const avatarInput = document.getElementById('avatarValue');
                    const fileInput = document.querySelector('input[name="avatarFile"]');
                
                    // Function to remove 'active' property from all avatar options
                    function removeActive() {
                        avatarOptions.forEach(option => {
                            option.classList.remove('active');
                        });
                    }
                
                    // Event listener for clicking on avatar options
                    avatarOptions.forEach(option => {
                        option.addEventListener('click', function() {
                            const selectedAvatar = this.getAttribute('data-value');
                            avatarInput.value = selectedAvatar;
                            removeActive(); // Remove 'active' property from all avatar options
                            this.classList.add('active'); // Add 'active' property to the selected avatar option
                        });
                    });
                
                    // Event listener for changes in file input
                    fileInput.addEventListener('change', function() {
                        removeActive(); // Remove 'active' property from all avatar options when a file is selected
                    });
                });
            </script>
        </div>
        </div>
    </div>

    <?php
        include_once 'footer.php';
    ?>

</body>
</html>
