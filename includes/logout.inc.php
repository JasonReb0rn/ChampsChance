<?php
// Include the necessary files
include_once 'dbh.inc.php'; // Assuming this file contains the database connection
include_once 'create-log.inc.php'; // Assuming this file contains the insertLog function

// Start session
session_start();

// Log the logout action
if (isset($_SESSION["userid"])) {
    $user_id = $_SESSION["userid"];
    $log_ip = $_SERVER['REMOTE_ADDR'];
    $log_action = "User logged out";
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // Call the insertLog function to create the log entry
    insertLog($conn, $user_id, $log_ip, $log_action, $user_agent);
}

// Unset and destroy session
session_unset();
session_destroy();

// Redirect to home page
header("location: ../home.php");
exit();
?>
