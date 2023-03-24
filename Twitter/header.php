<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twitter</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/32e08052b2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">

</head>
<header>
    <a href="index.php"><img src="imgs/logo.png" alt="logo" height="7.5%" width="3.75%"></a>
    <div class="headerButtons">
        <?php
            if (isset($_SESSION["userId"])) {
                echo '<a href="#">Profile</a>';
                echo '<a href="includes/logout-inc.php">Logout</a>';
            }
            else{
                echo '<a href="login.php">Login</a>';
                echo '<a href="signup.php">Sign up</a>';
            }
        ?>
    </div>
    
</header>
<body>
    
</body>
</html>