<?php
  // Set session cookie parameters to make it accessible across all directories
  session_set_cookie_params(0, '/');
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Donate</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=05282024">
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

        <div class="content-container-solid">
            <div class="content-block-flex-container">
                <div class="content-block-flex-photo">
                    <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/donation_1.png" alt="Spotlight your business!">
                    <p>Your donations go directly towards helping the rescue.</p>
                </div>
                <div class="content-block-flex-content" style="max-width: 100%;">
                    <h3>Make a donation:</h3>
                    
                    <?php
                        if (isset($_GET["error"])) {
                            if ($_GET["error"] == "not-logged-in") {
                                echo "<div class=\"error-message\"><i class=\"fa-solid fa-triangle-exclamation\"></i> To make a monthly donation, you must be logged in.</div>";
                            }
                            if ($_GET["error"] == "no-donation-freq") {
                                echo "<div class=\"error-message\"><i class=\"fa-solid fa-triangle-exclamation\"></i> You must choose a donation frequency.</div>";
                            }
                        }
                        else if (isset($_GET["success"])) {
                            if ($_GET["success"] == "createdaccount") {
                                echo "<div class=\"success-message\">You've successfully signed up! You can now sign in.</div>";
                            }
                        }
                    ?>

                    <div class="stripe-donate-form">
                        <div class="donate-freq-container">
                            <button class="freq-button active" data-frequency="one-time">One Time</button>
                            <button class="freq-button" data-frequency="monthly">Monthly<i class="fa-solid fa-heart"></i></button>
                        </div>

                        <div class="donate-amount-buttons-container">
                            <div class="amount-option"><button class="amount-button" data-amount="5">$5</button></div>
                            <div class="amount-option"><button class="amount-button" data-amount="10">$10</button></div>
                            <div class="amount-option"><button class="amount-button" data-amount="25">$25</button></div>
                            <div class="amount-option"><button class="amount-button" data-amount="50">$50</button></div>
                            <div class="amount-option"><button class="amount-button" data-amount="100">$100</button></div>
                            <div class="amount-option"><button class="amount-button" data-amount="250">$250</button></div>
                        </div>

                        <div class="donate-form-container">
                            <form action="includes/stripe-donation.inc.php" class="donate-form" method="POST">
                                <input type="hidden" name="amount" id="donate-amount" value="10">
                                <input type="hidden" name="frequency" id="donate-frequency" value="one-time">

                                <div id="donate-custom-amount-text" class="donate-text-custom-container" style="display: flex;">
                                    <span>$</span>
                                    <input type="text" id="donate-custom-amount" class="donate-custom-amount" name="donate-custom-amount" placeholder="Custom amount">
                                </div>

                                
                                <div class="donate-dedication-container">
                                    <div class="donate-dedication-checkbox">
                                        <input type="checkbox" id="dedication-checkbox" class="donate-dedication-checkbox">
                                        <label for="dedication-checkbox">Dedicate this donation</label>
                                    </div>
                                    
                                    <div id="donate-dedication-text" class="donate-dedication-checkbox" style="display: none;">
                                        <div class="donate-text-custom-container">
                                            <input type="text" id="dedication-text" class="donate-dedication-text" name="dedication-text" placeholder="Honoree name">
                                        </div> 
                                    </div>
                                </div>
                                

                                <div class="donate-submit-btn">
                                    <button type="submit" name="submit">Donate</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script src="js/donate.js"></script>
        

        <script>
          function redirectTo(url) {
            window.open(url, '_blank');
          }
        </script>

        <div class="donate-card-container">
            <div class="donate-card">
                <a href="https://venmo.com/code?user_id=2358799922888704369&created=1676533113.439282">
                    <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/payment_venmo.png" alt="venmo">
                    <label>Venmo</label>
                    <p>@champschance</p>
                </a>
            </div>
            <div class="donate-card">
                <a href="https://www.paypal.com/qrcodes/managed/6a900714-4c6b-4b16-aba4-b536dbce2098?utm_source=InPersonHome">
                    <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/payment_paypal.png" alt="paypal">
                    <label>PayPal</label>
                    <p>champschance01@outlook.com</p>
                </a>
            </div>
            <div class="donate-card">
                <a href="https://cash.app/$champschance?qr=1">
                    <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/payment_cashapp.png" alt="cashapp">
                    <label>CashApp</label>
                    <p>@champschance</p>
                </a>
            </div>
        </div>

        <div class="content-container-solid">
            <div class="content-block-flex-container">
                <div class="content-block-flex-photo">
                    <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/sponsor_spotlight_img.png" alt="Spotlight your business!">
                </div>
                <div class="content-block-flex-content">
                    <h3>Advertise with Us and Support Our Cause!</h3>
                    <p>Are you passionate about supporting animal rescue efforts while also reaching a broader audience for your business or organization? Consider advertising with us! By purchasing ad space on our website, you not only promote your brand but also directly contribute to our mission of finding loving homes for dogs in need. Your support enables us to cover the costs of running this website, ensuring that more resources can be allocated towards rescuing and caring for our furry friends.</p>
                    <br>
                    <p>If you're interested in learning more about our advertising opportunities, please <a href="ad-sales.php">click here</a> to visit our ad sales page.</p>
                </div>
            </div>
        </div>

        <div class="content-container-solid">
            <div class="content-block-flex-container">
                <div class="content-block-flex-photo">

                </div>
                <div class="content-block-flex-content">
                    <h3>We can also use...</h3>
                    <p>As a non-profit, we rely on the generosity of people like you to help us provide care and support for the dogs in our care. While monetary donations are <i>always</i> appreciated, we also greatly value in-kind donations of supplies and items.</p>
                    <h2>These include...</h2>
                </div>
            </div>
        </div>
        
        <div class="content-block-flex-container">
            <div class="content-block-flex-content">
                <ul>
                    <li>Volunteer time</li>
                    <li>Pet food (canned or dry) and treats</li>
                    <li>Toys for dogs (squeaky toys, balls, etc.)</li>
                    <li>Collars, leashes, and harnesses</li>
                    <li>Bedding (blankets, pillows, etc.)</li>
                    <li>Cleaning supplies (paper towels, disinfectant, etc.)</li>
                    <li>Grooming supplies (brushes, combs, shampoo, etc.)</li>
                    <li>Carriers and crates for transporting animals</li>
                    <li>Donations of gently used towels, blankets, and other linens</li>
                    <li>Gift cards to pet supply stores or online retailers</li>
                    <li>Heating pads for newborn animals</li>
                    <li>Vaccines and flea/tick medication.</li>
                </ul>

                <p>We understand that not everyone is able to make a financial contribution, but donating items such as pet food, toys, bedding, and cleaning supplies can make a huge difference in the lives of the dogs we care for. These donations help us provide a comfortable and safe environment for the dogs in our care, and allow us to direct more of our funds towards vital medical care and other important expenses.</p>
            </div>
        </div>
           
        
        
    </div>
    
    <?php
        include_once 'footer.php';
    ?>

        
    </div>
</body>

</html>