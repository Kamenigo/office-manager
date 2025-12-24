<?php
require_once __DIR__ . '/../../lib/auth_guard.php';

om_start_session();

// Destroy session
$_SESSION = [];
session_destroy();

// Redirect to login
header('Location: /office-manager/login.php');
exit;