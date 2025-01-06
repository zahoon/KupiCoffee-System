<?php
include("dbconn.php");
session_start();
if (isset($_SESSION['username'])) {
    $menuID = $_POST['menuID'];
    $menuStatus = $_POST['menuStatus'];

    if ($menuStatus == 'AVAILABLE') {
        $sql = "UPDATE menu SET menuStatus = 'UNAVAILABLE' WHERE menuID = '$menuID'";
        // Execute the SQL statement
        mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
        header("Location: adminDash.php");
    } else {
        $sql = "UPDATE menu SET menuStatus = 'AVAILABLE' WHERE menuID = '$menuID'";
        // Execute the SQL statement
        mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
        header("Location: adminDash.php");
    }

} else {
    header("Location: Login.html");
}
mysqli_close($dbconn);
?>