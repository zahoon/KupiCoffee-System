<?php
//redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: s_login.php");
    exit();
}

//if logged in, go to s.manageOrder
if (isset($_SESSION['username'])) {
    header("Location: s.manageOrder.php");
    exit();
}
?>