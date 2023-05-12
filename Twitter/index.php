<?php
session_start();
include_once 'header.php';

require_once 'includes/functions-inc.php';
require_once 'includes/templates-inc.php';

$localUserId = 0;

if(isset($_SESSION["userId"])) {
    $localUserId = $_SESSION["userId"];
}

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
    global $pdo, $localUserId, $tweetPostHTML, $commentIntroHTML, $followingHTML, $commentHTML, $commentOutroHTML;

    $getTweets_stmt = $pdo->prepare("SELECT tweets.id AS tweetId, users.id AS userId, users.username, tweets.content, tweets.time FROM tweets JOIN users ON tweets.ownerId = users.id;");
    $getTweets_stmt->execute();
    $tweets = $getTweets_stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<div class="tweetsWrapper">';

    foreach($tweets as $tweet) {
        // TWEET DATA

        $username = $tweet["username"];
        $tweetOwnerUserId = $tweet["userId"];
        $tweetId = $tweet["tweetId"];
        $tweetContent = $tweet["content"];
        $tweetTimeCreated = $tweet["time"];

        // TIMESTAMP

        $timeDiff = time() - $tweetTimeCreated;
        $timeDiff = secondsToDate($timeDiff);

        // LIKES
        
        $likeAmount = getLikeAmount($tweetId, 0);
        $likedPost = userLiked($localUserId, $tweetId, 0);

        if($likedPost) {
            $buttonClass = "True";
        }
        else {
            $buttonClass = "";
        }

        // FOLLOWING
        $finishedFollowButton = "";
        
        if($localUserId) {
            $finishedFollowButton = constructFollowButton($localUserId, $tweetOwnerUserId);
        }
        
        $fillData = ["USERNAME" => $username, "USER_ID" => $localUserId, "TWEET_CONTENT" => $tweetContent, "TWEET_ID" => $tweetId, "LIKE_COUNT" => $likeAmount, "LIKED_POST" => $buttonClass, "TIMESTAMP" => $timeDiff, "FOLLOW_HTML" => $finishedFollowButton];
        echo fillInTemplates($tweetPostHTML, $fillData);

        // COMMENTS
    
        $commentsExist_stmt = $pdo->prepare("SELECT users.username, comments.id, comments.tweetId, comments.commentUserId, comments.commentText, comments.time FROM comments JOIN users ON comments.commentUserId = users.id WHERE tweetId = $tweetId;");
        $commentsExist_stmt->execute();
        $commentData = $commentsExist_stmt->fetchAll(PDO::FETCH_ASSOC);

        if($commentData) {
            echo $commentIntroHTML;

            foreach($commentData as $comment) {
                $commentUsername = $comment["username"];
                $commentOwnerId = $comment["commentUserId"];
                $commentId = $comment["id"];
                $commentContent = $comment["commentText"];
                $commentCreated = $comment["time"];

                $commentTimeDiff = time() - $commentCreated;
                $commentTimeDiff = secondsToDate($commentTimeDiff);

                $likeCount = getLikeAmount($comment["id"], 1);
                $likedPost = userLiked($localUserId, $commentId, 1);

                if (count($likedPost) > 0) {
                    $commentButtonClass = "True";
                }
                else {
                    $commentButtonClass = "";
                }

                if($localUserId) {
                    $finishedFollowButton = constructFollowButton($localUserId, $commentOwnerId);
                }
                

                $fillData = ["USERNAME" => $commentUsername, "LIKE_COUNT" => $likeCount, "LIKED_POST" => $commentButtonClass, "COMMENT_CONTENT" => $commentContent, "COMMENT_ID" => $commentId, "TIMESTAMP" => $commentTimeDiff, "FOLLOW_HTML" => $finishedFollowButton];
                echo fillInTemplates($commentHTML, $fillData);
            }

        }
        else{
            echo '</div>';
        }

        echo $commentOutroHTML;
    }

    echo '</div></div></div>';
}

?>

<form method="GET" id="postSorterContainer">
    <label for="sortPosts">Sort by</label>
    <select name="sortPosts" id="postSorterDropDown" onchange="submitForm()">
        <option value="recency">Recency</option>
        <option value="mostLiked">Most Liked</option>
        <option value="usersIFollow">Users I follow</option>
    </select>
</form> 


<?php
retrievePosts();

?>