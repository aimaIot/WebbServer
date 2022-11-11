<?php

while (true) {
    $size = readline("Size of your pyramid: ");

    $tags = "";
    for ($i = $size; $i > 0; $i--) {

        if ($i == $size) {
            $tags = "#";
        }
        else {
            $tags = $tags . "##";
        }

        echo str_pad($tags, 10, " ", STR_PAD_BOTH);
        echo "\n";
    }
}

?>