<?php
  // Set session cookie parameters to make it accessible across all directories
  session_set_cookie_params(0, '/');
  session_start();

  // Check if the user is logged in and has admin rights
  if (!(isset($_SESSION["usersperm"]) && $_SESSION["usersperm"] == 1)) {
      // Redirect the user to a different page or display an error message
      header("Location: login.php");
      exit();
  }
?>




<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Admin Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=051623">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="icon" type="image/png" href="img/favicon-16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="img/favicon-32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="img/favicon-48.png" sizes="48x48">
    <link rel="icon" type="image/png" href="img/favicon-64.png" sizes="64x64">
    <link rel="icon" type="image/png" href="img/favicon-128.png" sizes="128x128">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
</head>

<body>
    
    <?php
        include_once 'header.php';
    ?>
    <script src="js/breadcrumbs.js"></script>

    <div class="main-content">

        <div class="adopt-content-header">
            <button class="addDog" id="addDog" style="display: block;"><i class="fa-solid fa-paw"></i> Add Dog</button>
        </div>

        <div class="add-animal-container" style="display: none;">
            <h3>Add a New Animal: </h3>
            <form action="includes/add-animal.inc.php" method="POST" name="addAnimalForm" enctype="multipart/form-data">
                <input type="text" name="dogName" placeholder="Dog's name" required>
                <textarea id= "dogDescription" name="dogDescription" class="text" rows="10" cols="30" maxlength="1024" placeholder="Type a brief description... be nice!" required></textarea> 
                <select name="dogStatus" required>
                    <option value="Available">Available</option>
                    <option value="Available / In Foster Home">Available / In Foster Home</option>
                    <option value="On hold / Unavailable">On hold / Unavailable</option>
                </select>
                <input type="text" name="dogBreed" placeholder="Breed" required>
                <select name="dogAge" required>
                    <option value="Puppy">Puppy</option>
                    <option value="Young">Young</option>
                    <option value="Adult">Adult</option>
                </select>
                <input type="text" name="dogColor" placeholder="Color" required>
                <select name="dogGender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <select name="dogSize" required>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
                
                <div class="dogMedicalNeeds-container">
                    <input type="checkbox" name="dogMedicalNeeds" id="dogMedicalNeeds">
                    <label for="dogMedicalNeeds">Medical Spotlight?</label>
                </div>
                
                <div class="dogFee-container">
                    <h2>$</h2>
                    <input type="text" name="dogFee" placeholder="Fee" required>
                </div>

                <input type="file" id="imageInput" name="dogImage" accept="image/jpeg, image/jpg, image/png" required>
                <input type="file" id="imageInput" name="dogImage2" accept="image/jpeg, image/jpg, image/png" style="display: none;">
                <input type="file" id="imageInput" name="dogImage3" accept="image/jpeg, image/jpg, image/png" style="display: none;">
                
                <button type="submit" name="submit">Add Animal</button>
                
                <script>
                    const fileInputs = document.querySelectorAll('input[type="file"]');

                    for (let i = 0; i < fileInputs.length; i++) {
                        fileInputs[i].addEventListener('change', function() {
                            if (this.files && this.files[0]) {
                                if (i < fileInputs.length - 1) {
                                    fileInputs[i + 1].style.display = 'block';
                                }
                            } else {
                                for (let j = i + 1; j < fileInputs.length; j++) {
                                    fileInputs[j].style.display = 'none';
                                    fileInputs[j].value = null;
                                }
                            }
                        });
                    }
                </script>

                <textarea name="dogNotes" class="text" rows="4" cols="30" maxlength="512" placeholder="Use this space to write down any administrative notes about the dog. This will NOT be publicly seen, is not required, and is only for internal use."></textarea>

            </form>
        </div>

        <div class="adopt-content-header">
            <!-- <h2>Edit dogs</h2> -->
            <p>Click any of the dogs below to edit an existing dog.</p>
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

        <div class="divider">
            <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/pawprint_divider.png" alt="super cute pawprint divider">
        </div>

        <div class="edit-carousel" id="edit-carousel">

            <h3>Edit Homescreen Image Carousel</h3>
            <p>Use this section to replace the images inside the image carousel on the homescreen.</p>
            <p>There's no support for rearranging images. If you want to change the position of an image, you must first download it <b>(right click > 'Save Image As')</b>, then re-upload it to the desired spot.</p>
            <p><b>To summarize:</b> add an image using the file browser under one of the 3 images, then press the "Replace Image" button.</p>

            <div class="carousel-image-edit-container">
                <div class="carousel-container 1">
                    <h2>First Image</h2>
                    <img id="carousel-image-1" src="" alt="">
                    <form action="includes/edit-carousel.inc.php" method="post" name="addAnimalForm" enctype="multipart/form-data">
                        <input type="file" id="imageInput1" name="replaceCarouselImg" accept="image/jpeg, image/jpg, image/png" required>
                        <input type="hidden" name="submitValue" value="1">
                        <button type="submit" name="submit">Replace Image</button>
                    </form>
                </div>

                <div class="carousel-container 2">
                    <h2>Second Image</h2>
                    <img id="carousel-image-2" src="" alt="">
                    <form action="includes/edit-carousel.inc.php" method="post" name="addAnimalForm" enctype="multipart/form-data">
                        <input type="file" id="imageInput2" name="replaceCarouselImg" accept="image/jpeg, image/jpg, image/png" required>
                        <input type="hidden" name="submitValue" value="2">
                        <button type="submit" name="submit">Replace Image</button>
                    </form>
                </div>

                <div class="carousel-container 3">
                    <h2>Third Image</h2>
                    <img id="carousel-image-3" src="" alt="">
                    <form action="includes/edit-carousel.inc.php" method="post" name="addAnimalForm" enctype="multipart/form-data">
                        <input type="file" id="imageInput3" name="replaceCarouselImg" accept="image/jpeg, image/jpg, image/png" required>
                        <input type="hidden" name="submitValue" value="3">
                        <button type="submit" name="submit">Replace Image</button>
                    </form>
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

<script src="js/admin-container.js"></script>
<script src="js/carousel-edit.js"></script>

