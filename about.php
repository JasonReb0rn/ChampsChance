<?php
  // Set session cookie parameters to make it accessible across all directories
  session_set_cookie_params(0, '/');
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>About Us</title>
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
                <div class="content-block-flex-photo">
                    <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/alicia.png" alt="Alicia Bopp">
                </div>

                <div class="content-block-flex-content">
                    <h3>Who We Are</h3>
                    <p>At Champ's Chance, we are a dedicated team of volunteers driven by a passion for giving dogs the opportunity they deserve. Founded by Alicia, our rescue is built on the stories of Champ and Chance, two dogs whose resilience inspired us to break away from the norm and create a haven for dogs in need. We believe that every dog, regardless of their medical condition or background, deserves a chance at a happy and fulfilling life.</p>
                    <br>
                    <p>Champs Chance Inc was founded with the goal to help dogs with the greatest need. Dogs are often turned away from rescues or euthanized in shelters if they require too much care or medical attention. Through advocating, rehabilitating, and adoption, Champs Chance Inc aims to fill this gap in the region.</p>
                </div>
            </div>
        </div>


        <div class="content-block-flex-container" id="rev">
            <div class="content-block-flex-content">
                <h3>Mission Statement</h3>
                <p>Our mission at Champ's Chance is simple yet profound: to provide a second chance for dogs that are often overlooked or turned away by traditional shelters. We are committed to rescuing dogs with medical conditions requiring extensive care, offering them the love, support, and resources they need to thrive. Through our unwavering dedication, we strive to create a community where every dog is valued and cherished.</p> 
            </div>
        </div>


        <div class="content-container-solid">
            <div class="content-block-flex-container">
                <div class="content-block-flex-photo">
                    <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/about-photo-2.jpg" alt="The cutest dog you've ever seen!">
                </div>

                <div class="content-block-flex-content">
                    <h3>How You Can Help</h3>
                    <p>You can make a difference in the lives of dogs in need by joining us on our mission. Whether it's through volunteering your time, fostering a dog, making a donation, or spreading awareness about our cause, every contribution helps us save more lives. Together, we can give dogs like Champ and Chance the chance they deserve and build a brighter future for them one paw at a time.</p>
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