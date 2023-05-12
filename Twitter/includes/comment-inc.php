<?php

session_start();

if(!isset($_SESSION["userId"])) {
    header("location: ../login.php");
    exit();
}

if(!isset($_POST["submitComment"])) {
    header("location: ../index.php");
    exit();
}

session_start();
require_once("functions-inc.php");

$comment = $_POST["comment"];
$postId = $_POST["submitComment"];

echo $comment;
echo $postId;

if(dataExists("comments", ["commentText" => $comment], "comment", null) !== false) {
    header("location: ../index.php");
    exit();
}

addComment($_SESSION["userId"], $postId, $comment);
header("location: ../index.php");
exit();