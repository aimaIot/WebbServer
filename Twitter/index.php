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
            <p class="tweetOwnerUsername">@username</p>
            <hr class="tweetLine">
            <p class="tweetText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt quisquam iste eligendi voluptatum tempore, officia quia libero, dolor dolorum nulla deserunt numquam voluptate eveniet. Non, autem nihil? Placeat, provident similique?</p>
        </div>
        <form class="commentWrapper" action="" method="POST">
            <input class="commentInput" type="text" name="comment">
        </form>
    </div>

    <div class="postContainer">
        <div class="tweetContainer">
            <p class="tweetOwnerUsername">@username</p>
            <hr class="tweetLine">
            <p class="tweetText">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt quisquam iste eligendi voluptatum tempore, officia quia libero, dolor dolorum nulla deserunt numquam voluptate eveniet. Non, autem nihil? Placeat, provident similique?</p>
        </div>
        <div class="commentWrapper">
            <form action="" method="POST">
                <input class="commentInput" type="text" name="comment">
            </form>
        </div>

    </div>


</div>