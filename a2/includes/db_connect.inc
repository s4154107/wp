<?php
$host = "talsprddb02.int.its.rmit.edu.au";
$user = "s4154107";
$password = "root";
$database = "s4154107";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>