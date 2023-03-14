<?php
session_start();

require_once "db-inc.php";
require_once "functions-inc.php";

if(!isset($_POST["submit"])){
    header("location: ../signup.php");
    exit();
}

$username = $_POST["username"];
$password = $_POST["password"];
$repeatedPassword = $_POST["repeatedPassword"];
$email = $_POST["email"];

if(emptyFields([$username, $password, $repeatedPassword, $email]) === false) {
    header("location: ../signup.php?error=empty");
    exit();
}

if(invalidUsername($username) === false) {
    header("location: ../signup.php?error=invalidName");
    exit();
}

if(checkRepeatedPassword($password, $repeatedPassword) === false) {
    header("location: ../signup.php?error=incorrectPass");
    exit();
}

$dataExists = dataExists("users", ["username" => $username, "email" => $email], "signup", null);

if ($dataExists !== false) {
    header("location: ../signup.php?error=" . $dataExists . "Taken");
    exit();
}

createUser($username, $password, $email);


header("location: ../signup.php?msg=created");
exit();