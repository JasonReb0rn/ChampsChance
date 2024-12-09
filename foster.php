<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Foster</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon.png">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-48.png" sizes="48x48">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-64.png" sizes="64x64">
    <link rel="icon" type="image/png" href="https://champschance.s3.us-east-2.amazonaws.com/assets/favicon-128.png" sizes="128x128">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="node_modules/@glidejs/glide/dist/css/glide.core.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2819146659782493"
     crossorigin="anonymous"></script>
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
                    <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/adopt_img.png" alt="Adopt Today!">
                </div>
                <div class="content-block-flex-content">
                    <h3>Foster an Animal</h3>
                    <p>At Champs Chance Inc, we understand that not everyone is ready to commit to adopting a dog long-term. That's why we offer a fostering program for individuals who want to provide a temporary home for our dogs. Our fostering program is an essential part of our mission to help dogs find loving and safe homes. Fostering a dog allows us to rescue more dogs, as we can only take in as many dogs as we have space for in our shelter.</p>
                    
                </div>
            </div>
            <div class="content-block-flex-container foster">
                <div class="content-block-flex-content">
                    <p>The fostering process begins with interested individuals filling out a fostering application, which asks about their living situation, lifestyle, and experience with pets. Once the application is approved, we work with the foster family to match them with a dog that will fit their living situation and lifestyle. We provide all necessary supplies, such as food and medical care, and support throughout the fostering period. Fostering a dog can be a rewarding experience that not only helps a dog in need but also allows individuals to experience the joys of pet ownership without the long-term commitment.</p>
                    <a class="adptbtn" href="https://www.cognitoforms.com/ChampsChanceInc1/ChampsChanceIncApplication"><button>Click Here To Apply!</button></a>
                    <a class="adptbtn" href="img/foster_contract.pdf"><button>Foster Contract</button></a>
                </div>
            </div>
        </div>


        <div class="adopt-header">
            <h3>Still looking for a foster home:</h3>
        </div>

        <div class="adopt-content">
            <!-- JSON: id, name, photo (filename), desc, status, breed, age, color, gender, size, gw-dog, gw-cat, gw-kid, fee -->
            
        </div>

    </div>
    
    <?php
        include_once 'footer.php';
    ?>

    <script>initializeModalFunctionality();</script>
        
    </div>
</body>
</html>

<script src="js/adopt-modal-functions.js"></script>
<script src="js/foster_container.js"></script>