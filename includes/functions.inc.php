<?php

function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) {
    $result = false;
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    
    return $result;
}

function invalidUsername($username) {
    $result = false;
    if (!preg_match("/^[a-zA-Z0-9.@]*$/", $username)) {
        $result = true;
    }
    else {
        $result = false;
    }
    
    return $result;
}

function invalidEmail($email) {
    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    
    return $result;
}

function invalidPassword($pwd) {
    $result = false;
    if (!$pwd < 5) {
        $result = true;
    }
    else {
        $result = false;
    }
    
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result = false;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    
    return $result;
}

function createUser($conn, $name, $email, $username, $pwd) {
    // Array of default avatar options
    $avatarOptions = array(
        "default_dog_1.png",
        "default_dog_2.png",
        "default_dog_3.png",
        "default_dog_4.png",
        "default_dog_5.png",
        "default_dog_6.png",
        "default_dog_7.png",
        "default_dog_8.png",
        "default_dog_9.png",
        "default_dog_10.png",
        "default_dog_11.png",
        "default_dog_12.png",
        "default_dog_13.png",
        "default_dog_14.png",
        "default_dog_15.png",
        "default_dog_16.png",
        "default_dog_17.png",
        "default_dog_18.png"
    );

    // Select a random avatar from the options
    $randomAvatar = $avatarOptions[array_rand($avatarOptions)];

    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd, usersAvatar) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../login.php?register-error=stmt-fail");
        exit();
    }

    $hashPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $username, $hashPwd, $randomAvatar); // Bind the random avatar
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Log the account creation action
    $user_id = mysqli_insert_id($conn); // user ID of newly created user
    $log_ip = $_SERVER['REMOTE_ADDR'];
    $log_action = "User account created";
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    include_once 'create-log.inc.php';

    // Create the log entry
    insertLog($conn, $user_id, $log_ip, $log_action, $user_agent);

    header("location: ../login.php?success=created-account");
    exit();
}


function emptyInputLogin($username, $pwd) {
    $result = false;
    if (empty($username) || empty($pwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    
    return $result;
}

//LOGIN STUFF
function getUserByLoginCredentials($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../login.php?register-error=stmt-fail");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultsData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultsData)) {
        mysqli_stmt_close($stmt);
        return $row;
    }
    else {
        $result = false;
        mysqli_stmt_close($stmt);
        return $result;
    }
}

function loginUser($conn, $username, $pwd) {

    include_once 'dbh.inc.php';
    include_once 'create-log.inc.php';

    $getUserByLoginCredentials = getUserByLoginCredentials($conn, $username, $username);

    if ($getUserByLoginCredentials === false) {
        header("location: ../login.php?login-error=wrong-login");
        exit();
    }

    // Verify password
    $pwdHashed = $getUserByLoginCredentials["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login.php?login-error=wrong-password");
        exit();
    } else if ($checkPwd === true) {

        // Start session
        session_start();

        // Set session variables
        $_SESSION["userid"] = $getUserByLoginCredentials["usersId"];
        $_SESSION["useruid"] = $getUserByLoginCredentials["usersUid"];
        $_SESSION["usersperm"] = $getUserByLoginCredentials["usersPerm"];
        $_SESSION["userAvatar"] = $getUserByLoginCredentials["usersAvatar"];

        // Log the login action
        $user_id = $_SESSION["userid"];
        $log_ip = $_SERVER['REMOTE_ADDR'];
        $log_action = "User logged in";
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        // Create the log entry
        insertLog($conn, $user_id, $log_ip, $log_action, $user_agent, '', '', '');

        header("location: ../home.php?loggedin");
        exit();
    }
}