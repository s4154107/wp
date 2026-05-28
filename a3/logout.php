<?php
require_once 'includes/functions.inc';

session_unset();
session_destroy();

session_start();
flash('success', 'You have logged out.');

header('Location: index.php');
exit;
?>