<?php

$vowels = ["a", "e", "i", "o", "u"];

while(true) {
    $input = readline("Enter your string: ");

        foreach(str_split($input) as $char) {
            if(in_array($char, $vowels)) {
            $word1 = substr($input, 0, strpos($input, $char) + 1) . "kon";
            $word2 = "fi" . substr($input, strpos($input, $char) + 1);
            
            echo $word2 . " | " . $word1 . " | ";
            break;
            }
    }
    echo "\n";
}


// car

// ca r

// r ca

// fir cakon
?>