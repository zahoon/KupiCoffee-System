<?php
include("dbconn.php");
session_start();
if (isset($_SESSION['username'])) {
    $orderID = $_POST['orderID'];
    $orderStatus = $_POST['orderStatus'];

    // Update the order status in the database
    $sql = "UPDATE orders SET orderStatus = '$orderStatus' WHERE orderID = $orderID";
    mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));

    header("Location: staffDash.php");
    exit;
} else {
    header("Location: Login.html");
    exit;
}
mysqli_close($dbconn);
?>
