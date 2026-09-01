<?php
require_once __DIR__ . '/../includes/auth.php';
logout();
// Return to the public website after signing out
header('Location: ../index.php');
exit;
