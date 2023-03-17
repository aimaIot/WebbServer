<?php
session_start();
include_once 'header.php';

require_once 'includes/functions-inc.php';

$pdo = new PDO('sqlite:includes/data.db');

if(isset($_SESSION["userId"])) {
    echo '<form class="postTweetContainer" method="POST" action="includes/postTweet-inc.php">
    <label for="tweetInput"></label>
    <textarea class="tweetTextInput" name="tweetInput" rows="4" id="" maxlength="250" required="true"></textarea>
    <input class="submitPost" type="submit" name="submit" value="Tweet">';

    if(isset($_GET["tweetPost"])) {
        switch($_GET["tweetPost"]) {
            case "tweetAlreadyExists":
                echo '<p class="errorMsg">You have already posted this tweet!</p>';
                break;
            case "tweetCreated":
                echo '<p class="feedbackMsg">Posted!</p>';
                break;
        }
    }

    echo '</form>';
    echo '<hr class="divider">';
}

function retrievePosts() {
    global $pdo;

    $getTweets_stmt = $pdo->prepare("SELECT * FROM tweets;");
    $getTweets_stmt->execute();
    $tweets = $getTweets_stmt->fetchAll(PDO::FETCH_ASSOC);

    

    foreach($tweets as $tweet) {
        $getUsername_stmt = $pdo->prepare("SELECT name FROM users WHERE name = :ownerId;");
        $getUsername_stmt->execute(array(":ownerId" => $tweet["ownerId"]));
        $username = $getUsername_stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<div class="tweetContainer">';
        echo '<p class="tweetOwnerUsername">@' . $tweet["ownerId"] . '</p>';
        echo '<hr class="tweetLine">';
        echo '<p class="tweetText">' . $tweet["content"] . "</p>";
        echo '</div>';
    }
}

$posts = retrievePosts();

?>

<div class="tweetsWrapper">
    <div class="tweetContainer">
        <p class="tweetOwnerUsername">@username</p>
        <hr class="tweetLine">
        <p class="tweetText">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eos, ducimus impedit officia reprehenderit voluptas maxime possimus, commodi, iusto eaque ab vero explicabo id unde cumque esse? Reiciendis porro est nam?</p>
    </div>

    <div class="tweetContainer">
        <p class="tweetOwnerUsername">@Username</p>
        <hr class="tweetLine">
        <p class="tweetText">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia sit sequi molestias illo voluptas, tempora, necessitatibus ex, fugit eligendi ut excepturi numquam aut sapiente quo qui consectetur maiores non! Odit.</p>
    </div>
</div>