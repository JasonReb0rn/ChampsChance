<?php
// Start the session
session_start();

// Include the database connection file
include_once 'dbh.inc.php';

// Check if post_id is set and not empty
if(isset($_POST['post_id']) && !empty($_POST['post_id'])) {
    // Sanitize the post_id to prevent SQL injection
    $post_id = intval($_POST['post_id']);

    // Get the user_id from the session if it exists
    $user_id = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

    $view_ip = $_SERVER['REMOTE_ADDR'];

    // Prepare the SQL statement to insert into the views table
    $sql = "INSERT INTO views (user_id, post_id, view_ip) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "iis", $user_id, $post_id, $view_ip);
        
        // Execute the statement
        if(mysqli_stmt_execute($stmt)) {
            // Return success status
            http_response_code(200);
            echo "Views incremented successfully.";
        } else {
            // Return error status
            http_response_code(500);
            echo "Error incrementing views: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // Return error status
        http_response_code(500);
        echo "Error preparing statement: " . mysqli_error($conn);
    }
} else {
    // Return error status if post_id is not set or empty
    http_response_code(400);
    echo "Invalid post ID.";
}
?>
