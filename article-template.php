<?php
  // Set session cookie parameters to make it accessible across all directories
  session_set_cookie_params(0, '/');
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Template Article - Champs Chance</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css?v=052523">
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

        <div class="blog-content-container">
            <div class="blog-posts-container" id="blog-post-container">
                <!-- this 'blog-posts-container' container gets dynamically populated later -->
                <div class="blog-post">
                    <div class="blog-img-container">
                        <img src="../img/blog/imgs/IMG_4807.jpg" alt="photo">
                    </div>
                    <div class="blog-info-container">
                        <a href="../blog.php?search=blog_post" class="category-link"><h1 class="post-category">Blog Post</h1></a>
                        <h2 class="article-title">Template Article Title</h2>
                        <div class="post-meta article">By <span class="author">Author Name</span> | Posted on <span class="post-date">2024-03-18 22:37:23</span></div>
                        <div class="post-content">
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Blanditiis, inventore. Voluptates ipsam necessitatibus, placeat dolorem sequi maxime autem incidunt numquam optio maiores pariatur repellendus! Amet, officiis maiores inventore eligendi aperiam mollitia numquam sunt modi atque optio libero distinctio iure fuga, minus asperiores eveniet dicta veniam laudantium aliquam facilis. Quasi alias perferendis explicabo distinctio odit libero necessitatibus commodi minima ab non consequuntur, sint possimus culpa saepe reiciendis, optio consequatur error repudiandae veritatis assumenda enim sapiente aliquam tenetur! Reprehenderit dolore nesciunt officiis beatae facilis adipisci qui nemo repellat commodi inventore, libero quod expedita quos tempora quo provident, explicabo omnis reiciendis! Iste, ullam hic a nisi obcaecati adipisci deleniti suscipit architecto, nemo consectetur assumenda dolorum? Magni, nihil. Iusto amet repellat ut beatae eum ipsum porro id enim ullam! Atque ea voluptate debitis natus incidunt magni quisquam, repellendus sit. Vero nulla corporis earum praesentium nobis, porro deleniti nostrum amet corrupti provident magni voluptates distinctio. Voluptatibus aperiam similique optio vero consequuntur rem fugiat est aspernatur repellat et voluptates repellendus molestiae veritatis velit architecto cumque incidunt maxime dolor aliquam deleniti quo, dolorum rerum eius. Pariatur, ipsa! Dolore perspiciatis veritatis nulla optio assumenda, corporis corrupti deleniti ex fugiat veniam voluptatum adipisci odio et quas ducimus odit sed.</p>
                        </div>
                    </div>
                </div>

                <div class="comment-section">
                    <h2>Comments</h2>
                    <div class="comments">
                        <!-- Comments will be dynamically added here -->
                        <div class="no-comments-yet">No comments yet. Feel free to change that!</div>
                    </div>
                    <?php
                    if (isset($_SESSION["useruid"])) {
                        echo '<form id="comment-form" action="../includes/add-blog-comment.inc.php" method="post" name="addCommentForm" enctype="multipart/form-data">';
                        echo '<input type="hidden" id="form-post-id" name="form-post-id">';
                        echo '<div class="form-group">';
                        echo '<div class="comment-form-profile-img">';
                        echo '<img src="../img/default_user.jpg" alt="Profile" class="profile-img">';
                        echo '</div>';
                        echo '<div class="comment-text-area-container">';
                        echo '<textarea id="comment-text" name="comment-text" rows="4" placeholder="Comment..." required></textarea>';
                        echo '<button id="comment-submit-button" type="submit" name="submit"><i class="fa-solid fa-reply"></i></button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                    } else {
                        echo '<a href="../login.php"><button>Log In</button></a>';
                    }
                    ?>
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
                            <li><a href="">Category 1</a></li>
                            <li><a href="">Category 2</a></li>
                            <li><a href="">Category 3</a></li>
                        </ul>
                    </div>
                </div>
                <div class="blog-categories-ad-container">
                    <img src="/img/ad_spot.png" alt="Ads support us so much!">
                </div>
            </div>
        </div>

        <div class="comment-section">
            <h2>Comments</h2>
            <div class="comments">
                <!-- Comments will be dynamically added here -->

                <div class="comment-container">
                    <!-- The base parent comment -->
                    <div class="comment">
                        <div class="comment-meta">
                            <img src="img/default_user.jpg" alt="Profile Photo" class="profile-img">
                            <div class="meta-info-container">
                                <span class="comment-author">John Doe</span>
                                <span class="comment-date">2024-03-20 14:30:00</span>
                            </div>
                        </div>
                        <div class="comment-content">
                            <p>This is an example comment. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>

                    <div class="comment-reply-container">
                        <!-- ALL the replies go here -->
                        <div class="reply-thread">
                            <!-- The marker on the left of the reply -->
                            <div class="reply-thread-marker-top"></div>
                            <!-- The actual reply -->
                            <div class="reply">
                                <div class="reply-meta">
                                    <img src="img/default_user.jpg" alt="Profile Photo" class="profile-img">
                                    <div class="meta-info-container">
                                        <span class="comment-author">John Doe</span>
                                        <span class="comment-date">2024-03-20 14:30:00</span>
                                    </div>

                                </div>
                                <div class="comment-content">
                                    <p>This is an example REPLY to a comment. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="reply-parent-container">
                        <div class="reply-btn-container">
                            <a href=""><i class="fa-solid fa-reply"></i>reply</a>
                        </div>
                    </div>

                </div>

                <div class="comment-container">
                    <!-- The base parent comment -->
                    <div class="comment">
                        <div class="comment-meta">
                            <img src="img/default_user.jpg" alt="Profile Photo" class="profile-img">
                            <div class="meta-info-container">
                                <span class="comment-author">John Doe</span>
                                <span class="comment-date">2024-03-20 14:30:00</span>
                            </div>
                        </div>
                        <div class="comment-content">
                            <p>This is an example comment. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>

                    <div class="comment-reply-container">
                        <!-- ALL the replies go here -->
                        <div class="reply-thread">
                            <!-- The marker on the left of the reply -->
                            <div class="reply-thread-marker-top"></div>
                            <div class="reply-thread-marker-bottom"></div>
                            <!-- The actual -->
                            <div class="reply">
                                <div class="reply-meta">
                                    <img src="img/default_user.jpg" alt="Profile Photo" class="profile-img">
                                    <div class="meta-info-container">
                                        <span class="comment-author">John Doe</span>
                                        <span class="comment-date">2024-03-20 14:30:00</span>
                                    </div>

                                </div>
                                <div class="comment-content">
                                    <p>This is an example REPLY to a comment. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </div>

                        <div class="reply-thread">
                            <!-- The marker on the left of the reply -->
                            <div class="reply-thread-marker-top"></div>
                            <!-- The actual -->
                            <div class="reply">
                                <div class="reply-meta">
                                    <img src="img/default_user.jpg" alt="Profile Photo" class="profile-img">
                                    <div class="meta-info-container">
                                        <span class="comment-author">John Doe</span>
                                        <span class="comment-date">2024-03-20 14:30:00</span>
                                    </div>

                                </div>
                                <div class="comment-content">
                                    <p>This is an example REPLY to a comment. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <form id="reply-form" action="includes/add-blog-reply.inc.php" method="post" name="addReplyForm" enctype="multipart/form-data">
                        <div class="reply-form-container">

                            <div class="reply-form-profile-img">
                                <img src="img/default_user.jpg" alt="Profile" class="profile-img">
                            </div>

                            <div class="reply-text-area-container">
                                <textarea id="reply-text" name="reply" rows="4" placeholder="Reply to $USERNAME..." required></textarea>
                                <button type="submit"><i class="fa-solid fa-reply"></i></button>
                            </div>
                        </div>

                        <div class="reply-btn-container">
                            <a href=""><i class="fa-solid fa-reply"></i>reply</a>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    
    <?php
        include_once 'footer.php';
    ?>
        
    </div>
</body>
</html>

<script src="../js/article-container.js"></script>