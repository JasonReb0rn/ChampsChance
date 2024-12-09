<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Medical Spotlight</title>
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
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2819146659782493"
     crossorigin="anonymous"></script>
</head>

<body>
    
    <?php
        include_once 'header.php';
    ?>
    <script src="js/breadcrumbs.js"></script>

    <div class="main-content">
        <div class="medical-spotlight-container">
            
            <div class="content-container-solid">
                <div class="medical-spotlight-description">
                    <h3><i class="fa-solid fa-heart"></i> Medical Spotlight</h3>
                    <p>These dogs have all come to Champs Chance with a variety of medical conditions that required extensive care. Our Medical Spotlight page showcases the stories of these brave dogs and the extraordinary efforts our team put in to nurse them back to health. From surgeries to medication and rehabilitation, we spared no effort to provide the best care possible. The page not only highlights the remarkable resilience of these dogs but also serves as a reminder of the importance of proper medical attention. Without this care, many of these dogs would have lived shorter lives. We hope that by showcasing these animals in particular, we can get them into the homes they deserve.</p>
                </div>
                
                <h2 class="med-spotlight-meet-header">Meet our dogs...</h2>
    
            </div>

        </div>


    </div>

    <div class="blog-content-container">
        <div class="blog-posts-container" id="blog-posts-container">
            <!-- this 'blog-posts-container' container gets dynamically populated later -->
        </div>
    </div>

    <div id="blog-pages-container">
        <ul class="page-numbers">
        
        </ul>
    </div>
    
    <?php
        include_once 'footer.php';
    ?>

        
    </div>
</body>
</html>

<script src="js/medical-spotlight-container.js"></script>