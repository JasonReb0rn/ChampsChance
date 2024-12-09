<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Buddy Boy - Champs Chance</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css?v=052523">
    <link rel="icon" type="image/png" href="../img/favicon.png">
    <link rel="icon" type="image/png" href="../img/favicon-16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="../img/favicon-32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="../img/favicon-48.png" sizes="48x48">
    <link rel="icon" type="image/png" href="../img/favicon-64.png" sizes="64x64">
    <link rel="icon" type="image/png" href="../img/favicon-128.png" sizes="128x128">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="node_modules/@glidejs/glide/dist/css/glide.core.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2819146659782493"
    crossorigin="anonymous"></script>
</head>

<body>
    
    <?php include_once '../header.php'; ?>

    <script src="../js/breadcrumbs.js"></script>

    <div class="main-content">

        <div class="blog-content-container">
            <div class="blog-posts-container" id="blog-post-container" data-post-id="1">
                <!-- this 'blog-posts-container' container gets dynamically populated later -->
                <div class="blog-post">
                    <div class="blog-img-container">
                        <img src="../img/blog/imgs/buddyboy-01.jpg" alt="Buddy Boy">
                    </div>
                    <div class="blog-info-container">
                        <a href="../blog.php?search=medical_spotlight" class="category-link"><h1 class="post-category">Medical Spotlight</h1></a>
                        <h2 class="article-title">Buddy Boy</h2>
                        <div class="post-meta article">By <span class="author">jasonchoate</span> | Posted on <span class="post-date">March 31st 2024 at 07:17pm</span></div>
                        <div class="post-content">
                            <p><p>Poor sweet Buddy Boy was found as a stray, wandering the streets of North Florida when a neighbor found him and called us. Estimated to be about four years old, he may not be able to tell us his story but its clear that he hasn't had it easy. He appeared to have an injured leg, which turned out to be a problem with a ligament which we have had surgically repaired. But none of this hardship has affected that smile! His foster mom says he is the very best dog. We would love for you to meet him and see if you have room to give this boy a great home. He will give you nothing but love in return!</p></p>
                        </div>
                        
                        <?php if (isset($_SESSION["usersperm"]) && $_SESSION["usersperm"] == 1): ?>
                            <form action="../includes/delete-blog-post.inc.php" method="post">
                                <input type="hidden" name="post_id" value="1">
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
                            <li><a href="">Error</a></li>
                        </ul>
                    </div>
                </div>
                <div class="blog-categories-ad-container">
                    <img src="../img/ad_spot.png" alt="Ads support us so much!">
                </div>
            </div>
        </div>
    
    
    <?php include_once '../footer.php'; ?>
        
    </div>
</body>
</html>

<script src="../js/article-container.js"></script>
<script src="../js/track-view.js"></script>
