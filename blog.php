<?php
  // Set session cookie parameters to make it accessible across all directories
  session_set_cookie_params(0, '/');
  session_start();

?>

<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Blog</title>
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
    <!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.3/dist/quill.snow.css" rel="stylesheet" />
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


        <div class="blog-header">
            <?php
            if (isset($_SESSION["usersperm"]) && $_SESSION["usersperm"] == 1) {
                echo "<button id=\"addBlogPost\" class=\"addBlogPost\"><i class=\"fa-regular fa-pen-to-square\"></i>Add Blog Post</button>";
            }
            ?>

            <?php
            if (isset($_SESSION["usersperm"]) && $_SESSION["usersperm"] == 1) {
                echo '<div class="add-animal-container" style="display: none;">';
                echo '<h3>New Blog Post: </h3>';
                echo '<form id="addBlogPostForm" action="includes/add-blog-post.inc.php" method="post" name="addBlogPostForm" enctype="multipart/form-data">';
                echo '<input type="text" name="postTitle" placeholder="Post Title" required autocomplete="off">';
                echo '<select name="postCategory" required>';
                echo '<option value="blog_post" selected>Blog Post</option>';
                echo '<option value="pet_adoption">Pet Adoption</option>';
                echo '<option value="pet_health_&_wellness">Pet Health & Wellness</option>';
                echo '<option value="pet_life">Pet Life</option>';
                echo '<option value="dog_training">Dog Training</option>';
                echo '<option value="latest_rescues">Latest Rescues</option>';
                echo '<option value="medical_spotlight">Medical Spotlight</option>';
                echo '<option value="success_story">Success Story</option>';
                echo '</select>';
                echo '<div id="editor"></div>';
                echo '<input type="hidden" id="postContent" name="postContent" required>';
                echo '<label for=""></label>';
                echo '<input type="file" id="imageInput" name="postImage" accept="image/jpeg, image/jpg, image/png" required>';
                echo '<button type="submit" name="submit">Post Article</button>';
                echo '</form>';
                echo '</div>';
            }
            ?>
        </div>

        <!-- Include the Quill library -->
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.3/dist/quill.js"></script>

        <!-- Initialize Quill editor -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const quill = new Quill('#editor', {
                    modules: {
                        toolbar: [
                            [{ header: [1, 2, false] }],
                            ['bold', 'italic'],
                            ['link', 'blockquote', 'image', 'video'],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                        ],
                    },
                    theme: 'snow',
                });
            
                // Submit form with Quill content
                const form = document.getElementById('addBlogPostForm');
                form.addEventListener('submit', function(event) {
                    const postContentInput = document.getElementById('postContent');
                    const quillHTMLContent = quill.root.innerHTML; // Get HTML content directly
                    console.log("Quill HTML Content:", quillHTMLContent);
                    postContentInput.value = quillHTMLContent;
                });
            });
        </script>

        <div class="blog-content-container">
            <div class="blog-posts-container" id="blog-posts-container">
                <!-- this 'blog-posts-container' container gets dynamically populated later -->

            </div>


            <div class="blog-categories-container">

                <div class="blog-categories-navigation-container">
                    <div class="search_container">
                        <input type="text" id="search-bar" placeholder="Search...">
                    </div>
                    <div class="blog-categories">
                        <h2>Categories</h2>
                        <ul id="blog-categories-list">
                            <li><a href="">Error Loading Categories</a></li>
                        </ul>
                    </div>
                </div>
                <div class="blog-categories-sponsor-container">
                    <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/sponsor_spot.png" alt="Ads support us so much!">
                </div>
            </div>
        </div>

        <div id="blog-pages-container">
            <ul class="page-numbers">
                <li class="arrow"><a href="#">&lt;</a></li>
                <li><a href="#">1</a></li>
                <li class="arrow"><a href="#">&gt;</a></li>
            </ul>
        </div>

        
        <?php
            include_once 'footer.php';
        ?>
        
    </div>
</body>
</html>

<script src="js/blog-container.js"></script>