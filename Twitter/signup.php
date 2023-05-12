<?php

include_once 'header.php';

?>

<form class="accountFormContainer" action="includes/signup-inc.php" method="POST">

    <div class="inputWrapper">
        <label for="username">Username</label>
        <input class="accountFormInput" type="text" name="username" placeholder="Enter your username">
        <p class="formInfo">Alphabetic letters and numbers only | 20 characters max</p>
    </div>


    <div class="inputWrapper">
        <label for="password">Password</label>
        <input class="accountFormInput" type="password" name="password" placeholder="Enter your password">
    </div>

    <div class="inputWrapper">
        <label for="confirmPassword">Confirm Password</label>
        <input class="accountFormInput" type="password" name="repeatedPassword" placeholder="Repeat your password">
        <p class="formInfo">Repeat password</p>
    </div>

    <div class="inputWrapper">
        <label for="email">Email</label>
        <input class="accountFormInput" type="text" name="email" placeholder="Enter your email">
    </div>

    <input type="submit" class="submitBase" name="submit" value="Create account">

    <?php
    if(isset($_GET["error"])) {
        $error = $_GET["error"];
        
        switch($error) {
            case 'empty':
                $text = "Fill in all forms";
                break;
            case 'invalidName':
                    $text = "Invalid username";
                    break;
            case 'incorrectPass':
                    $text = "Passwords do not match";
                    break;
            case 'usernameTaken':
                    $text = "Username is already taken";
                    break;
            case 'emailTaken':
                    $text = "Email is already used";
                    break;
        }

        echo '<p class="errorMsg">' . $text . '</p>';
    }
    ?>
</div>