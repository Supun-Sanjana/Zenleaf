<?php

$DBServer = "localhost";
$DBUser = "root";
$DBPass = "";
$DBName = "zenleaf";




$con = mysqli_connect($DBServer, $DBUser, $DBPass, $DBName);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>