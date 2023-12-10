<?php
$servername = "3.106.116.196";
$username = "admin";
$password = "Aa123456";
$dbname = "new_perpus";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
