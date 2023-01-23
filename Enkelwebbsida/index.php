<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tools</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@500&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Tools</h1>
    </header>

    <nav>
    <form method="GET">
        <input type="hidden" name="site" value="calculator">
        <button type="submit">Calculator</button>
    </form>

    <form method="GET">
        <input type="hidden" name="site" value="daysLived">
        <button type="submit">Days Lived</button>
    </form>

    <form method="GET">
        <input type="hidden" name="site" value="site2">
        <button type="submit">Site3</button>
    </form>
    </nav>

    <main>

        <form method="GET">
            <label for="NumberOne">Number One</label>
            <input type="text" name="NumberOne" value="">

            <label for="NumberTwo">Number Two</label>
            <input type="text" name="NumberTwo" value="">

            <label for="Operator">Operator</label>
            <input type="text" name="Operator" value="">

            <button type="submit">Calculate</button>
        </form>

    </main>

</body>
</html>


<?php


$calculatorHTML = '

';

$daysLivedHTML = '
<main>
<form method="GET">
    <label for="birthdate">Birthday (YYYY/MM/DD)</label>
    <br></br>
    <input type="text" name="birthdate" placeholder="YYYY/MM/DD">
    <input type="submit" name="submit_birthdate" value="Submit">
</form>
</main>
';

if (isset($_GET["site"])){
    if($_GET["site"] == "calculator"){
        echo $calculatorHTML;
    }
    elseif($_GET["site"] == "daysLived"){
        echo $daysLivedHTML;
    }
}


// PAGE HANDLERS \\

// CALCULATOR

// DAYS LIVED
if(isset($_GET["submit_birthdate"])){
    $birthdate = $_GET["birthdate"];

    $totalDays = date("Y") * 365.24 + date("m") * 30.4 + date("d");
    $birthdateArray = explode("/", $birthdate);
    $daysAlive = floor($totalDays - ($birthdateArray[0] * 365.24 + $birthdateArray[1] * 30.4 + $birthdateArray[2]));

    echo "<p class=DaysLivedp>You have been alive for " . $daysAlive . " days!</p>";
}
?>
