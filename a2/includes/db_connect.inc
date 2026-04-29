<?php
$host = "localhost";
$user = "root";
$password = "root";
$database = "petconnect";
$port = 8889;

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>