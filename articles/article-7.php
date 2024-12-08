<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Test! - Champs Chance</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
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
    
    <?php include_once '../header.php'; ?>

    <script src="../js/breadcrumbs.js"></script>

    <div class="main-content">

        <div class="blog-content-container">
            <div class="blog-posts-container" id="blog-post-container" data-post-id="7">
                <!-- this 'blog-posts-container' container gets dynamically populated later -->
                <div class="blog-post">
                    <div class="blog-img-container">
                        <img src="https://champschance.s3.us-east-2.amazonaws.com/blog/img/Jenkins_1_667f4d99b714c.jpg" alt="Test!">
                    </div>
                    <div class="blog-info-container">
                        <a href="../blog.php?search=success_story" class="category-link"><h1 class="post-category">Success Story</h1></a>
                        <h2 class="article-title">Test!</h2>
                        <div class="post-meta article">By <span class="author">jasonchoate</span> | Posted on <span class="post-date">December 6th 2024 at 03:02pm</span></div>
                        <div class="post-content">
                            <p><h1>Test!</h1><p>Test... test test test.</p></p>
                        </div>
                        
                        <?php if (isset($_SESSION["usersperm"]) && $_SESSION["usersperm"] == 1): ?>
                            <form action="../includes/delete-blog-post.inc.php" method="post">
                                <input type="hidden" name="post_id" value="7">
                                <button type="submit" name="delete" class="delete-post-btn"><i class="fa-solid fa-trash"></i> Delete Article</button>
                            </form>
                        <?php endif; ?>
                        
                    </div>
                </div>

                <div class="comment-section">
                    <h2>Comments</h2>
                    <div class="comments" id="comments">
                        <!-- Comments will be dynamically added here -->
                        <div class="no-comments-yet">No comments yet. Feel free to change that!</div>
                    </div>

                    <?php include_once '../comment-form.php'; ?>

                </div>
            </div>


            <div class="blog-categories-container">

                <div class="blog-categories-navigation-container">
                    <div class="search_container">
                        <input type="text" id="search-bar" placeholder="Search...">
                    </div>
                    <div class="blog-categories">
                        <h2>Categories</h2>
                        <ul id="blog-categories-list">
                        </ul>
                    </div>
                </div>
                <div class="blog-categories-sponsor-container">
                    <img src="https://champschance.s3.us-east-2.amazonaws.com/assets/sponsor_spot.png" alt="Ads support us so much!">
                </div>
            </div>
        </div>
    
    
    <?php include_once '../footer.php'; ?>

    </div>
</body>
</html>

<script src="../js/article-container.js"></script>
<script src="../js/track-view.js"></script>

