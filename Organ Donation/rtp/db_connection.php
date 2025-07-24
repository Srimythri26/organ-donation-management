<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "organdonation";
$port=3060;

$conn = new mysqli($servername, $username, $password, $dbname,$port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
