<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db_name = "KenanginKopi";

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function generateID($prefix) {
    return $prefix . rand(1000, 9999);
}
?>