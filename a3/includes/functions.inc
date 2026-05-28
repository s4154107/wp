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