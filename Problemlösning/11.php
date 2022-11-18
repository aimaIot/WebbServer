<?php

$playerOne;
$playerTwo;

function printGrid() {
    global $grid, $playerOne, $playerTwo;
    $letters = ["A", "B", "C"];

    echo "\n";

    for($i = 0; $i < 3; $i++) {
        for($index = 1; $index < 4; $index++) {
            $key = strval($letters[$i]) . $index;

            switch($grid[$key]) {
                case $playerOne:
                    echo "| X ";
                    break;
                case $playerTwo:
                    echo "| O ";
                    break;
                case "":
                    echo "|   ";
                    break;
            }
        }

        echo "|\n";
    }
    echo "\n";
}

function checkForWinner() {
    global $grid, $playerOne, $playerTwo;
    $letters = ["A", "B", "C"];

    // Horizontal Win

    foreach($letters as $char) {
        if(($grid[$char . "1"] == $grid[$char . "2"] and $grid[$char . "2"] == $grid[$char . "3"]) and $grid[$char . "1"] !== "") {
            return $grid[$char . "1"];
        }
    }

    // Vertical Win

    for($i = 1; $i < 3; $i++) {
        if(($grid["A" . $i] == $grid["B" . $i] and $grid["B" . $i] == $grid["C" . $i]) and $grid["A" . $i] !== "") {
            return $grid["A" . $i];
        }
    }

    // Diagonal Win

    if((($grid["B2"] == $grid["A1"] and $grid["B2"] == $grid["C3"]) or ($grid["B2"] == $grid["A3"] and $grid["B2"] == $grid["C1"])) and $grid["B2"] !== "") {
        return $grid["B2"];
    }

    // Tie

    if(!in_array("", $grid)) {
        return "Tie";
    }

    return null;
}

while (true) {
    $grid = [
        "A1" => "",
        "A2" => "",
        "A3" => "",
        "B1" => "",
        "B2" => "",
        "B3" => "",
        "C1" => "",
        "C2" => "",
        "C3" => "",
    ];

    $playerOne = readline("Player one name: ");
    $playerTwo = readline("Player two name: ");
    $turn = $playerOne;

    printGrid();

    while(true) {
        echo $turn . "'s turn | Row/Column (example 'B2')\n";
        $tile = strtoupper(readline());
        
        if(array_key_exists($tile, $grid) and $grid[$tile] == "") {
            $grid[$tile] = $turn;

            if($turn == $playerOne) {
                $turn = $playerTwo;
            }
            else {
                $turn = $playerOne;
            }

            printGrid();
            
            // Handle winner
            $winner = checkForWinner();

            if($winner == $playerOne or $winner == $playerTwo) {
                echo $winner . " won!\n\n";
                break;
            }
            elseif($winner == "Tie") {
                echo "It's a tie!\n\n";
                break;
            }
        }
        else {
            echo "Tile is either taken or non-existant\n";
        }
    }
}

?>