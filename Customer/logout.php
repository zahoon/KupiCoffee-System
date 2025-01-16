<?php
// Include the session management file
include("session.php");

// Destroy the session
destroySession();

// Redirect to the login page or home page
header("Location: testlogin.php");
exit();
?>