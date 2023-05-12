<?php

$tweetPostHTML = '
<div class="postContainer">
    <div class="tweetContainer">
        <div class="tweetTopContainer">
            <a href="#" class="tweetOwnerUsername">@{USERNAME}</a>
            <form action="includes/actions-inc.php" method="POST">
                <p class="timestamp">{TIMESTAMP}</p>
                {FOLLOW_HTML}
                <p class="likeCount">{LIKE_COUNT}</p>
                <button class="likeButton{LIKED_POST}" name="like_post" value="{TWEET_ID}">❤</button>
            </form>
        </div>
        <hr class="tweetLine">
        <p class="tweetText">{TWEET_CONTENT}</p>
    </div>

    <div class="commentWrapper">
        <form action="includes/comment-inc.php" class="userCommentWrapper" method="POST">
        <textarea class="commentInput" name="comment" type="text" placeholder="Enter comment here" rows="2.5" columns="60" maxlength="150"></textarea>
        <button class="commentSubmit" name="submitComment" value="{TWEET_ID}">Comment</button>
        </form>';


$followingHTML = '
<button class="{IS_FOLLOWING}" name="follow" value="{USER_ID}" type="submit">{FOLLOW_TEXT}</button>
';

$commentIntroHTML = '
<div class="viewCommentsContainer">
    <hr class="commentIndent">
    <div class="commentSection">
';

$commentHTML = '
    <div class="postComment">
        <div class="tweetTopContainer">
            <a href="#" class="commentUsername">@{USERNAME}</a>
            <p class="timestamp">{TIMESTAMP}</p>
            <form action="includes/actions-inc.php" method="POST">
                {FOLLOW_HTML}
                <p class="likeCount">{LIKE_COUNT}</p>
                <button class="likeButton{LIKED_POST}" name="like_comment" value="{COMMENT_ID}">❤</button> 
            </form>
        </div
        <hr class="tweetLine">
        <p class="commentText">{COMMENT_CONTENT}</p>
    </div>
';

$commentOutroHTML = '
</div>
</div>
';