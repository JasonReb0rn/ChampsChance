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
                <h3>Dedicated Donations:</h3>
                <p>This space is dedicated to recognizing the loved ones in whose honor donations have been made to support our dog rescue efforts. Each name listed represents a heartfelt tribute and a generous act that helps us provide care and a loving home for dogs in need.<br><br>Thank you for helping us make a difference!</p>

                <div class="dedicated-donations-container">

                    <?php

                    require 'includes/dbh.inc.php';

                    $user_id = $_SESSION['userid'];

                    $query = $conn->prepare("
                        SELECT donation_dedication_text 
                        FROM donations 
                        WHERE (donation_payment_status = 'successful' OR donation_payment_status = 'cancelled') 
                        AND donation_dedication_text IS NOT NULL
                    ");
                    $query->execute();
                    $result = $query->get_result();

                    if ($result->num_rows > 0) {
                    
                        while ($row = $result->fetch_assoc()) {
                            $dedication_text = $row['donation_dedication_text'];
                            try {
                            
                                echo "<div class=\"dedication-card\">";

                                echo "<i class=\"fa-solid fa-heart\"></i>";
                            
                                if ($row['donation_dedication_text'] != null) {
                                    echo "<p>Dedicated to " . $row['donation_dedication_text'] . "</p>";
                                }
                            
                                echo "</div>";
                            } catch (Exception $e) {
                                echo "<p>Error retrieving dedicated donations: " . $e->getMessage() . "</p>";
                            }
                        }
                    } else {
                        echo "<p>There haven't been any dedicated donations yet. You could be the first!</p>";
                    }
                
                    $query->close();
                    $conn->close();
                    ?>

                </div>

                <div style="margin-top: 40px;">
                    <h2>Want to add your own dedicated donation?</h2>
                    <a href="donate.php"><button>Donate Now!</button></a>
                </div>

            </div>
          </div>
        </div>
    
    <?php
        include_once 'footer.php';
    ?>

        
    </div>
</body>

</html>