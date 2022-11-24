<?php

$currentNum = 1;
$previousNum = 0;

for ($i = 0; $i < 26; $i++) {
    $newNum = $currentNum + $previousNum;
    $previousNum = $currentNum;
    $currentNum = $newNum;
    echo "#" . $i . " = " . $newNum . "\n";
}

?>