<?php
session_start();

require_once "functions-inc.php";

if(!isset($_POST["submit"])) {
    header("location: ../index.php");
    exit();
}

$userId =  $_SESSION["userId"];
$tweetContent = $_POST["tweetInput"];

if(tweetExists($userId, $tweetContent)) {
    header("location: ../index.php?tweetPost=tweetAlreadyExists");
    exit();
}

if(postTweet($userId, $tweetContent)) {
    header("location: ../index.php?tweetPost=tweetCreated");
    exit();
}