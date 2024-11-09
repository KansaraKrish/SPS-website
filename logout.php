<?php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the specified file (e.g., home or login page)
header("Location: index.php");
exit();
?>
