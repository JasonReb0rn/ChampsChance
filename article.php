
<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title><?php echo htmlspecialchars($shortenedTitle); ?> - Champs Chance</title>
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
    
    <!--HEADER-->

    <script src="../js/breadcrumbs.js"></script>

    <div class="main-content">

        <div class="blog-content-container">
            <div class="blog-posts-container" id="blog-post-container" data-post-id="<?php echo htmlspecialchars($post['post_id']); ?>">
                <!-- this 'blog-posts-container' container gets dynamically populated later -->
                <div class="blog-post">
                    <div class="blog-img-container">
                        <img src="https://champschance.s3.us-east-2.amazonaws.com/blog/img/<?php echo htmlspecialchars($post['photo']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    </div>
                    <div class="blog-info-container">
                        <a href="../blog.php?search=<?php echo htmlspecialchars($post['category']); ?>" class="category-link"><h1 class="post-category"><?php echo htmlspecialchars($cleanedCategory); ?></h1></a>
                        <h2 class="article-title"><?php echo htmlspecialchars($post['title']); ?></h2>
                        <div class="post-meta article">By <span class="author"><?php echo htmlspecialchars($post['usersUid']); ?></span> | Posted on <span class="post-date"><?php echo htmlspecialchars($cleanedCreatedAt); ?></span></div>
                        <div class="post-content">
                            <p><?php echo $post['content']; ?></p>
                        </div>

                        <!--DELETE-BUTTON-->

                    </div>
                </div>

                <div class="comment-section">
                    <h2>Comments</h2>
                    <div class="comments" id="comments">
                        <!-- Comments will be dynamically added here -->
                        <div class="no-comments-yet">No comments yet. Feel free to change that!</div>
                    </div>

                    <!--COMMENT-->

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
    
    
    <!--FOOTER-->

    </div>
</body>
</html>

<script src="../js/article-container.js"></script>
<script src="../js/track-view.js"></script>

