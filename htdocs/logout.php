<?php
// Start or resume the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect the user back to the login page or another page
header("Location: index.php");
exit();
?>
