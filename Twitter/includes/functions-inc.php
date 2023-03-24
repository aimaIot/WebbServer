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
    
    $statement = $pdo->prepare("INSERT INTO tweets(ownerId, content) VALUES(?, ?);");
    $statement->execute([$userId, $tweetContent]);

    return true;
}