<?php

$primeNumbers = [];
$currentNum = 1;

do{
    $isPrimeNumber = true;

    for ($i = 2; $i <= $currentNum; $i++) {
        if($currentNum % $i == 0 and $i !== $currentNum) {
            $isPrimeNumber = false;
            break;
        }
    }
    
    if($isPrimeNumber == true) {
       array_push($primeNumbers, $currentNum);
    }
    
    $currentNum++; 
} while($currentNum < 1010);

print_r($primeNumbers);

?>