<?php
session_start();

unset($_SESSION["userId"]);
unset($_SESSION["username"]);

header("location: ../index.php");