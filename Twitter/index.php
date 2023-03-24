<?php
session_start();
include_once 'header.php';

require_once 'includes/functions-inc.php';

$pdo = new PDO('sqlite:includes/data.db');

if(isset($_SESSION["userId"])) {
    echo '<form class="postTweetContainer" method="POST" action="includes/postTweet-inc.php">
    <label for="tweetInput"></label>
    <textarea class="tweetTextInput" name="tweetInput" rows="4" id="" maxlength="250" required="true"></textarea>
    <input class="submitBase" type="submit" name="submit" value="Tweet">';

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

    echo '<div class="tweetsWrapper">';

    foreach($tweets as $tweet) {
        $getUsername_stmt = $pdo->prepare("SELECT username FROM users WHERE id = :ownerId;");
        $getUsername_stmt->execute(array(":ownerId" => $tweet["ownerId"]));
        $data = $getUsername_stmt->fetchAll(PDO::FETCH_ASSOC);
        $username = $data[0]["username"];

        

        // echo '<div class="tweetContainer">';
        // echo '<p class="tweetOwnerUsername">@' . $username . '</p>';
        // echo '<hr class="tweetLine">';
        // echo '<p class="tweetText">' . $tweet["content"] . "</p>";
        // echo '</div>';
    }

    // echo '</div>';
}

$posts = retrievePosts();

?>


<div class="postContainer">
        <div class="tweetContainer">
            <div class="tweetTopContainer">
                <a href="#" class="tweetOwnerUsername">@username</a>
                <form action="" method="POST">
                    <button class="followButton" name="follow" value="1" type="submit">Follow</button>
                    <button class="fa-regular fa-heart likeButton"></button> <!-- FILLED HEART | fa-solid -->
                </form>
            </div>
            <hr class="tweetLine">
            <p class="tweetText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt quisquam iste eligendi voluptatum tempore, officia quia libero, dolor dolorum nulla deserunt numquam voluptate eveniet. Non, autem nihil? Placeat, provident similique?</p>
        </div>
        <div class="commentWrapper">
            <form action="" class="userCommentWrapper" method="POST">
                <textarea class="commentInput" name="comment" type="text" placeholder="Enter comment here" rows="2.5" columns="60" maxlength="150"></textarea>
                <input type="submit" class="commentSubmit" name="submitComment" value="Comment" placeholder="Comment">
            </form>
        </div>
    </div>

</div>