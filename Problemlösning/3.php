<?php

$num1 = rand(1, 100);
$num2 = rand(1, 10);
$result = $num1 / $num2;

if(strpos($result, ".")) {
    echo $num1 . " % " . $num2 . " | " . $result;
}
else {
    echo "Number does not have a %";
}



?>