<?php

    if (isset($_SESSION["useruid"])) {
        echo '<form id="comment-form" action="../includes/add-blog-comment.inc.php" method="post" name="addCommentForm" enctype="multipart/form-data">';
        echo '<input type="hidden" id="form-post-id" name="form-post-id">';
        echo '<div class="form-group">';
        echo '<div class="comment-form-profile-img">';
        echo '<img src="https://champschance.s3.us-east-2.amazonaws.com/assets/avatars/' . $_SESSION["userAvatar"] . '" alt="Profile" class="profile-img">';
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