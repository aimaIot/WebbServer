<?php
session_start();
include_once 'header.php';

if(isset($_SESSION["userId"])) {
    echo '<form class="postTweetContainer" method="POST" action="includes/postTweet-inc.php">
    <label for="tweetInput"></label>
    <textarea class="tweetTextInput" name="tweetInput" rows="4" id="" maxlength="250" required="true"></textarea>
    <input class="submitPost" type="submit" name="submit" value="Tweet">';

    if(!isset($_GET["tweetPost"])) {return;}

    switch($_GET["tweetPost"]) {
        case "tweetAlreadyExists":
            echo '<p class="errorMsg">You have already posted this tweet!</p>';
            break;
        case "tweetCreated":
            echo '<p class="feedbackMsg">Posted!</p>';
            break;
    }
    echo '</form>';
}


?>
