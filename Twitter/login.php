<?php

include_once 'header.php';

?>

<form class="accountFormContainer" action="includes/login-inc.php" method="POST">

    <div class="inputWrapper">
        <label for="username">Username/Email</label>
        <input class="accountFormInput" type="text" name="username" placeholder="Enter your username/email">
    </div>

    <div class="inputWrapper">
        <label for="password">Password</label>
        <input class="accountFormInput" type="password" name="password" placeholder="Enter your password">
    </div>

    <input type="submit" name="submit" value="Login">

    <?php
    if(isset($_GET["error"])) {
        $error = $_GET["error"];
        
        switch($error) {
            case 'empty':
                $text = "Fill in all forms";
                break;
            case 'invalidCred':
                    $text = "Invalid credentials";
                    break;
        }

        echo '<p class="errorMsg">' . $text . '</p>';
    }
    ?>
</div>