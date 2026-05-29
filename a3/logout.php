<?php
require_once 'includes/functions.inc';

session_unset();
session_destroy();

header('Location: index.php');
exit;