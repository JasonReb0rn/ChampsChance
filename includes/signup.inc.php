<?php

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) !== false) {
        header("location: ../login.php?register-error=empty-input");
        exit();
    }
    
    if (invalidUsername($username) !== false) {
        header("location: ../login.php?register-error=invalid-username");
        exit();
    }

    if (invalidEmail($email) !== false) {
        header("location: ../login.php?register-error=invalid-email");
        exit();
    }

    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("location: ../login.php?register-error=password-mismatch");
        exit();
    }

    if (getUserByLoginCredentials($conn, $username, $email) !== false) {
        header("location: ../login.php?register-error=username-email-taken");
        exit();
    }

    createUser($conn, $name, $email, $username, $pwd);

}
else {
    header("location: ../login.php");
    exit;
}