<?php
require_once 'functions-inc.php';
session_start();

if(!isset($_SESSION["userId"])) {
    header("location: ../login.php");
    exit();
}

$localUserId = $_SESSION["userId"];

if(isset($_POST["like_post"])) {
    $postId = $_POST["like_post"];
    toggleLike($localUserId, $postId, 0);

    header("location: ../index.php");
    exit();
}
elseif(isset($_POST["like_comment"])) {
    $postId = $_POST["like_comment"];
    toggleLike($localUserId, $postId, 1);
    
    header("location: ../index.php");
    exit();
}
elseif(isset($_POST["follow"])) {
    followUser($localUserId, $_POST["follow"]);

    header("location: ../index.php");
    exit();
}