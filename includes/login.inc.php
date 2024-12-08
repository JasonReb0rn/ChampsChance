<?php
if (isset($_POST["submit"])) {
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // Log the login attempt
    $log_ip = $_SERVER['REMOTE_ADDR']; // Get the user's IP address
    $log_action = "Attempted log in with username: $username"; // Log the attempted username
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // Include the necessary file
    require_once 'create-log.inc.php'; // Assuming this file contains the insertLog function

    // Call the insertLog function to create the log entry
    insertLog($conn, null, $log_ip, $log_action, $user_agent);

    if (emptyInputLogin($username, $pwd) !== false) {
        header("location: ../login.php?login-error=empty-login");
        exit();
    }

    if (invalidUsername($username) !== false) {
        header("location: ../login.php?login-error=invalid-username");
        exit();
    }

    loginUser($conn, $username, $pwd);
} else {
    header("location: ../login.php");
    exit();
}
?>
