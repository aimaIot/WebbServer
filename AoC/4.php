<?php
$input = "yzbqklnj";
$i = 1;

while (true) {
    $newString = $input . $i;
    $md5 = md5($newString);

    if(substr($md5, 0, 6 ) === "000000") {
        echo "MD5 found, i = " . $i . " | " . $newString . " | " . $md5 . "\n";
        break;
    }

    $i += 1;
}
?>