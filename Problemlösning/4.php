<?php
$conditions = [["rock", "scissors"], ["paper", "rock"], ["scissors", "rock"]];
while(true) {
    $playerChoice = strtolower(readline("Rock, paper or scissors: "));
    $computerChoice = rand(1, 3);
    
    if($computerChoice == 1) {
        $computerChoice = "rock";
    }
    elseif($computerChoice == 2) {
        $computerChoice = "paper";
    }
    else {
        $computerChoice = "scissors";
    }
    
    $playerWin = false;
    if($playerChoice == $computerChoice){
        $playerWin = "Tie";
    }
    else{
        foreach($conditions as $condition) {
            if($condition[0] == $playerChoice and $condition[1] == $computerChoice) {
                $playerWin = "Win";
                break;
            }
        }
    }

    if($playerWin == "Win") {
        echo "You won! | Computer: " . $computerChoice . "\n\n";
    }
    elseif($playerWin == "Tie"){
        echo "Tie!\n\n";
    }
    else{
        echo "You lost! | Computer: " . $computerChoice . "\n\n";
    }
}

?>