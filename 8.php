<?php

while (true) {
    $input = readline("Insert your text: ");
    $input = strtolower(str_replace(" ", "", $input));

    if ($input == strrev($input)) {
        echo "Your text is a palindrom!\n";
    }
    else {
        echo "Your text is not a palindrom.\n";
    }
}

?>