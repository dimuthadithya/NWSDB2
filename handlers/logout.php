<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the login page (adjust the URL as needed)
header("Location: ../index.php?logout=success");
exit();
