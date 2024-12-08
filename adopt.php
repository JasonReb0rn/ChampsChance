<?php
  // Set session cookie parameters to make it accessible across all directories
  session_set_cookie_params(0, '/');
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Adopt</title>
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
                    <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/adopt_img.png" alt="Adopt Today!">
                </div>
                <div class="content-block-flex-content">
                    <h3>The Adoption Process</h3>
                    <p>At Champs Chance, we're committed to finding loving forever homes for dogs. Our adoption process is simple: browse our website to find your perfect match, fill out an application detailing your lifestyle and experience, and our team will review it carefully. Once approved, we'll schedule a meeting with your potential new furry friend. If all goes well, finalize the adoption with a fee and paperwork, and welcome your new family member home!</p>
                    <p>For those considering fostering to adopt, we offer that option too. After applying and following the same steps, you can foster your potential companion before making it official. This allows time for medical needs or getting comfortable together. We provide post-adoption support to ensure a happy, healthy life for all our dogs with their new families.</p>
                    <a class="adptbtn" href="https://www.cognitoforms.com/ChampsChanceInc1/ChampsChanceIncApplication" target="_blank"><button>Click Here To Apply!</button></a>
                </div>
            </div>
        </div>

        <div class="adopt-header">
            <h3>OUR DOGS</h3>
            <?php
                if (isset($_SESSION["usersperm"]) && $_SESSION["usersperm"] == 1) {
                    echo "<button class=\"edit-adopt\"><i class=\"fa-regular fa-pen-to-square\"></i>Edit</button>";
                }
                else {

                }
            ?>
        </div>
        
        <div class="adopt_search_parent_div">
            <div class="search_container">
                <input type="text" id="search-bar" placeholder="Search...">
            </div>
        </div>

        <div class="adopt-content">
            <!-- JSON: id, name, photo (filename), desc, status, breed, age, color, gender, size, gw-dog, gw-cat, gw-kid, fee -->
            <!-- this 'adopt-content' container gets dynamically populated later -->
            
        </div>

        <script src="node_modules/@glidejs/glide/dist/glide.min.js"></script>
        <script>

            var glide = new Glide('.glide', {
              autoplay: 5000,
              hoverpause: true,
              type: 'carousel',
              focusAt: 'center',
              perView: 1
            });

            glide.mount();

        </script>
    
    <?php
        include_once 'footer.php';
    ?>
        
    </div>
</body>
</html>

<script src="js/adopt-modal-functions.js"></script>
<script src="js/adopt_container.js"></script>