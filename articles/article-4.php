<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Noodle - Champs Chance</title>
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
            <div class="blog-posts-container" id="blog-post-container" data-post-id="4">
                <!-- this 'blog-posts-container' container gets dynamically populated later -->
                <div class="blog-post">
                    <div class="blog-img-container">
                        <img src="../img/blog/imgs/noodle-01.jpg" alt="Noodle">
                    </div>
                    <div class="blog-info-container">
                        <a href="../blog.php?search=medical_spotlight" class="category-link"><h1 class="post-category">Medical Spotlight</h1></a>
                        <h2 class="article-title">Noodle</h2>
                        <div class="post-meta article">By <span class="author">jasonchoate</span> | Posted on <span class="post-date">March 31st 2024 at 07:22pm</span></div>
                        <div class="post-content">
                            <p><p>Noodle is a calm and sweet dog who was rescued along with his siblings. Although two of his siblings have found their forever homes, Noodle is still waiting for his own. He enjoys playing with other dogs and toys and has an optimistic attitude despite never having his own home. Unfortunately, Noodle has been diagnosed with a Grade 5 heart murmur, and local vets have given him an estimated 6-12 months to live. However, there is a $5000 procedure available at Auburn University that can potentially save his life.</p><p><br></p><p>Despite his heart condition, Noodle remains a playful and go-with-the-flow dog. He enjoys spending time with humans and other dogs and is often relaxed. Noodle is ready for a loving home, but in the meantime, he continues to enjoy life as he knows it and loves to play with his sister and kennel-mate. With the potential for life-saving treatment available, Noodle's future is uncertain, but his sweet personality and playful spirit continue to shine.</p></p>
                        </div>
                        
                        <?php if (isset($_SESSION["usersperm"]) && $_SESSION["usersperm"] == 1): ?>
                            <form action="../includes/delete-blog-post.inc.php" method="post">
                                <input type="hidden" name="post_id" value="4">
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
