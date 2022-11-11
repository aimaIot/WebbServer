<?php

echo "    __1_____2_____3_____4_____5_____6_____7_____8_____9____10____11____12__\n";

for($row = 1; $row < 13; $row++) {
    echo str_pad($row, 2, " ", STR_PAD_RIGHT) . " |";

    for ($column = 1; $column <13; $column++) {
        echo str_pad($row * $column, 5, " ", STR_PAD_BOTH) . "|";
    }
    echo "\n";
}

?>