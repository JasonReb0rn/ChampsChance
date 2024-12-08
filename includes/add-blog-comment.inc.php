<?php

session_start();

if (isset($_POST["submit"])) {
    // Get form data

    // Check if user is logged in
    if (!isset($_SESSION["userid"])) {
        // Handle the case where user is not logged in
        header("Location: ../login.php?error=notloggedin");
        exit();
    }

    // Retrieve user_id from session
    $userId = $_SESSION["userid"];

    // Get post_id from the form data
    $postId = $_POST["form-post-id"];
    
    // Get comment content and sanitize it
    $commentContent = htmlspecialchars($_POST["comment-text"]);

    // Include database connection
    require_once 'dbh.inc.php';

    // Insert data into database
    $sql = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "iis", $postId, $userId, $commentContent);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redirect to the article page after adding comment
        header("Location: ../articles/article-" . $postId . ".php?comment-added=success");
        exit();
    } else {
        // Error handling if SQL statement fails
        header("Location: ../articles/article-" . $postId . ".php?error=sqlerror");
        exit();
    }
} else {
    // Redirect back if form was not submitted properly
    header("Location: ../articles/article-" . $postId . ".php");
    exit();
}

?>
