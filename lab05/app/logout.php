<?php
require_once __DIR__ . '/common/auth.php';
$_SESSION = [];
session_destroy();
header('Location: login.php');
exit;
