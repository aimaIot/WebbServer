<?php
$pdo = new PDO('sqlite:data.db');

function emptyFields($fields) {
    foreach($fields as $field) {
        if (empty($field)) {
            return(false);
        }
    }
}

function invalidUsername($username) {
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username) || strlen($username) > 20) {
        return false;
    }
}

function checkRepeatedPassword($password, $repeatedPassword) {
    if($password != $repeatedPassword) {
       return false; 
    }
}

function dataExists($table, $arrayData, $action, $additionalData) {
    global $pdo;

    foreach($arrayData as $key => $value) {
        $statement = $pdo->prepare("SELECT * FROM $table WHERE $key = :value");
        $statement->execute(array(":value" => $value));
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        if($data) {
            foreach ($data as $row) {
                if($action == "login") {
                    if(password_verify($additionalData["password"], $row["password"])) {
                        return [$row["id"], $row["username"]];
                    }
                }
                elseif($action == "signup") {
                    return $key;
                }
                elseif($action == "comment") {
                    return true;
                }
            }
        }
    }
    
    return false;
}

function createUser($username, $password, $email) {
    global $pdo;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users(username, password, email) VALUES(?, ?, ?);");
    $stmt->execute([$username, $hashedPassword, $email]);
}

function tweetExists($userId, $tweetContent) {
    global $pdo; 

    $statement = $pdo->prepare("SELECT * FROM tweets WHERE content = :tweetContent AND ownerId = :userId;");
    $statement->execute(array(":userId" => $userId, ":tweetContent" => $tweetContent));
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    if($data) {
        return true;
    }

    return false;
}

function postTweet($userId, $tweetContent) {
    global $pdo;
    $time = time();

    $statement = $pdo->prepare("INSERT INTO tweets(ownerId, content, time) VALUES(?, ?, ?);");
    $statement->execute([$userId, $tweetContent, $time]);

    return true;
}

function addComment($userId, $postId, $comment) {
    global $pdo;
    $time = time();

    $statement = $pdo->prepare("INSERT INTO comments(commentUserId, tweetId, commentText, time) VALUES(?, ?, ?, ?);");
    $statement->execute([$userId, $postId, $comment, $time]);

    return true;
}

function toggleLike($localUserId, $postId, $isComment) {
    global $pdo;

    $search_stmt = $pdo->prepare("SELECT * FROM likes WHERE userId = ? AND postId = ? AND isComment = ?");
    $search_stmt->execute([$localUserId, $postId, $isComment]);
    $data = $search_stmt->fetchAll(PDO::FETCH_ASSOC);

    if($data) {
        $action_stmt = $pdo->prepare("DELETE FROM likes WHERE userId = ? AND postId = ? AND isComment = ?");
        $action_stmt->execute([$localUserId, $postId, $isComment]);
    }
    else {
        $action_stmt = $pdo->prepare("INSERT INTO likes(userId, postId, isComment) VALUES(?, ?, ?)");
        $action_stmt->execute([$localUserId, $postId, $isComment]);
    }
}

function userLiked($userId, $postId, $isComment) {
    global $pdo;

    $likedPost_stmt = "";

    if($isComment == 1) {
        $likedPost_stmt = $pdo->prepare("SELECT * FROM likes WHERE userId = :userId AND postId = :postId AND isComment = 1;");
    }
    elseif($isComment == 0) {
        $likedPost_stmt = $pdo->prepare("SELECT * FROM likes WHERE userId = :userId AND postId = :postId AND isComment = 0;");
    }

    $likedPost_stmt->execute([$userId, $postId]);
    $likedPost = $likedPost_stmt->fetchAll(PDO::FETCH_ASSOC);

    return $likedPost;
}


function getLikeAmount($tweetId, $isComment) {
    global $pdo;

    $sumLikes_stmt = $pdo->prepare("SELECT COUNT(postId) AS likes FROM likes WHERE postId = $tweetId AND isComment = $isComment;");
    $sumLikes_stmt->execute();
    $likes = $sumLikes_stmt->fetchAll(PDO::FETCH_ASSOC);
   
    return $likes[0]["likes"];
}

function fillInTemplates($text, $arrayData) {
    foreach ($arrayData as $key => $stringReplace) {
        $text = str_replace("{" . $key . "}", $stringReplace, $text);
    }

    return $text;
}

function secondsToDate($time) {
    $dateTime;
    $time = ceil($time);

    if(($dateTime = $time / 31556926)  >= 1) {    // YEARS
        return ceil($dateTime) . "y";
    }
    elseif(($dateTime = $time / 2629744) >= 1) {  // MONTHS
        if(ceil($dateTime == 1)) {
            return "1y";
        }
        return ceil($dateTime) . "m";
    }
    elseif(($dateTime = $time / 604800) >= 1) {   // WEEKS
        if(ceil($dateTime == 52)) {
            return "1m";
        }
        return ceil($dateTime) . "w";
    }
    elseif(($dateTime = $time / 86400) >= 1) {    // DAYS
        if(ceil($dateTime == 7)) {
            return "1w";
        }
        return ceil($dateTime) . "d";
    }
    elseif(($dateTime = $time / 3600) >= 1) {     // HOURS
        if(ceil($dateTime == 24)) {
            return "1d";
        }
        return ceil($dateTime) . "h";
    }
    elseif(($dateTime = $time / 60) >= 1) {       // MINUTES
        if(ceil($dateTime == 60)) {
            return "1h";
        }
        return ceil($dateTime) . "min";
    }
    else{                                         // SECONDS
        return "Recently";
    }
}

function checkFollow($follower, $followee) {
    global $pdo;

    $checkStatement = $pdo->prepare("SELECT * FROM followers WHERE follower = :follower AND followee = :followee");
    $checkStatement->execute(array(":follower" => $follower, ":followee" => $followee));
    $data = $checkStatement->fetchAll(PDO::FETCH_ASSOC);

    if($data) {
        return true;
    }
    else {
        return false;
    }
}

function followUser($follower, $followee) {
    global $pdo;

    if($follower == $followee) {return;}

    $alreadyFollowing = checkFollow($follower, $followee);

    if(!$alreadyFollowing) {
        $statement = $pdo->prepare("INSERT INTO followers(follower, followee) VALUES(?, ?);");
        $statement->execute([$follower, $followee]);
    }
}

function constructFollowButton($localUserId, $postOwnerId) {
    global $followingHTML;

    if($postOwnerId != $localUserId) {
        $isFollowing = checkFollow($localUserId, $postOwnerId);
        $followButtonText = "Follow";

        if($isFollowing) {
            $isFollowing = "followButtonTrue";
            $followButtonText = "Following";
        }
        else{
            $isFollowing = "followButton";
        }
        return fillInTemplates($followingHTML, ["IS_FOLLOWING" => $isFollowing, "USER_ID" => $postOwnerId, "FOLLOW_TEXT" => $followButtonText]);
    }
}