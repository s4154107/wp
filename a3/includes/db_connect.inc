<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$server = $_SERVER['SERVER_NAME'] ?? '';

if ($server === 'localhost' || $server === '127.0.0.1') {
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = 'root';
    $db_name = 'petconnect';
} else {
    $db_host = 'talsprddb02.int.its.rmit.edu.au';
    $db_user = 's4154107';
    $db_pass = '14492008Ks';
    $db_name = 's4154107';
}

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
mysqli_set_charset($conn, 'utf8mb4');
?>