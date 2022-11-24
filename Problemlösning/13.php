<?php
$alphabet = str_split("abcdefghijklmnopqrstuvwxyz123456789");
$amountOfChars = count($alphabet);

function getData() {
    echo "\nEnter your string\n";
    $userString = strtolower(readline());

    while(true) {
        echo "\nEnter your key\n";
        $key = readline();

        if(is_numeric($key)) {
            return [$userString, $key];
        }
    }
}

function encrypt($string, $key) {
    global $alphabet, $amountOfChars;

    $encryptedString = "";

    foreach(str_split($string) as $char) {
        $newIndexPos = array_search($char, $alphabet) + $key;
        if ($newIndexPos >= $amountOfChars) {
            $newIndexPos = $newIndexPos - $amountOfChars;
        }

        $encryptedString = $encryptedString . $alphabet[$newIndexPos];
    }

    return $encryptedString;
}

while(true) {
    $data = getData();
    $string = $data[0];
    $key = $data[1];

    $result = encrypt($string, $key);
    echo "Result: " . $result . "\n";
}

?>