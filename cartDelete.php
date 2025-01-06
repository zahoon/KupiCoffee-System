<?php
include("dbconn.php");
session_start();
if (isset($_SESSION['username'])) {
    /* execute SQL statement */
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM customer WHERE custUsername= '$username'";
    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
    $row = mysqli_num_rows($query);
    if ($row == 0) {
        echo "No record found";
    } else {
        $r = mysqli_fetch_assoc($query);
        $customerusername = $r['custUsername'];

        if (isset($_POST['Delete'])) {
            $menuID = $_POST['menuID'];

            $sql2 = "DELETE FROM cart WHERE menuID = '$menuID' AND custUsername = '$username'";

            mysqli_query($dbconn, $sql2) or die("Error: " . mysqli_error($dbconn));

        } elseif (isset($_POST['DeleteAll'])) {

            $sql2 = "DELETE FROM cart WHERE custUsername = '$username'";

            mysqli_query($dbconn, $sql2) or die("Error: " . mysqli_error($dbconn));

        } else {

        }

        // Close the database connection
        mysqli_close($dbconn);
        header("Location: cartDeliver.php");

    }
}
?>