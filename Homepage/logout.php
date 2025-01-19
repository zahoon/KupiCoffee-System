<?php
// Include the session management file
require_once '../Homepage/session.php';

// Destroy the session using the destroySession function
destroySession();

// Redirect to the login page or home page
header("Location: ../Customer/c.login.php");
exit();
?>