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
        $custUsername = $r['custUsername'];
        $menuID = $_GET['menuID'];

        // Check if the item already exists in the cart for the customer
        $checkQuery = "SELECT * FROM cart WHERE menuID = '$menuID' AND custUsername = '$custUsername'";
        $checkResult = mysqli_query($dbconn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Item already exists in the cart
            // You can update the quantity or perform any other desired action
            // For example:
            $updateQuery = "UPDATE cart SET quantity = quantity + 1 WHERE custUsername = '$custUsername' AND menuID = '$menuID'";
            mysqli_query($dbconn, $updateQuery);
        } else {
            // Generate a random numeric Cart ID
            function generateOrderID(){
                // Generate random number between 1 and 1000000;
        
                $orderID = rand(1,1000000);
        
                //Convert random number to a string
        
                $orderIDStr = strval($orderID);
        
                //return pastry ID string.
                return $orderIDStr;
            }

            // Usage
            $cartID = generateOrderID(11);

            // Item does not exist in the cart, insert a new entry
            $insertQuery = "INSERT INTO cart (cartID, menuID , quantity, custUsername) VALUES ($cartID, $menuID, 1, '$custUsername')";
            mysqli_query($dbconn, $insertQuery);
        }

        // Close the database connection
        mysqli_close($dbconn);
        header("Location: MenuCust.php");
    }
} else {
    header("Location: Login.html");
}
?>