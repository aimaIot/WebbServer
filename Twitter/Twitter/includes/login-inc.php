<?php
require_once "db-inc.php";
require_once "functions-inc.php";

$usernameInput = $_POST["username"];
$passwordInput = $_POST["password"];

if(!isset($_POST["submit"])) {
    header("location: ../login.php");
    exit();
}

if (emptyFields([$usernameInput, $passwordInput]) === false) {
    header("location: ../login.php?error=empty");
    exit();
}

$userData = dataExists("users", ["username" => $usernameInput, "email" => $usernameInput], "login", ["password" => $passwordInput]);
if(!$userData) {
    header("location: ../login.php?error=invalidCred");
    exit();  
}

$userId = $userData[0];
$username = $userData[1];

session_start();
$_SESSION["userId"] = $userId;
$_SESSION["username"] = $username;

header("location: ../index.php");