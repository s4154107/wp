<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function h($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

function logged_in() {
    return isset($_SESSION['user_id']);
}

function current_user() {
    return $_SESSION['username'] ?? null;
}

 function pet_img($path) {
    return 'assets/images/pets/' . $path;
}
function get_pet($conn, $id) {
    $sql = "SELECT p.*, u.username, u.email, u.phone, u.location
            FROM pets p
            JOIN users u ON p.user_id = u.user_id
            WHERE p.pet_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}