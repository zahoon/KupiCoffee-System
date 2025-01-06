<!-- Emergency Delete -->
<!-- DELETE FROM order_items WHERE ORDER_ID = '$orderID' -->

<?php
include("dbconn.php");
session_start();

$totalprice = $_GET['totalprice'];
$services = $_GET['services'];
$branch = $_GET['branch'];

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Step 1: Retrieve cart items for the specific customer
    $cartItemsQuery = "SELECT * FROM cart WHERE custUsername = '$username'";
    $cartItemsResult = mysqli_query($dbconn, $cartItemsQuery);

    if (!$cartItemsResult) {
        die("Error: " . mysqli_error($dbconn));
    }

    function generateOrderID(){
        // Generate random number between 1 and 1000000;

        $orderID = rand(1,1000000);


        //return order 
        return $orderID;
    }
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $time = time();
    $adminID = ['1', '4'];
    $randomIndex = array_rand($adminID);
    $orderID = generateOrderID();
    $orderdate = date('Y-m-d H:i:s',$time);
    $orderstatus = 'Pending';
    $adminID= $adminID[$randomIndex];

    $paymentID = generateOrderID();
    // Begin transaction
    mysqli_begin_transaction($dbconn);

    try {
        // Insert the order details
        $insertOrderQuery = "INSERT INTO `orders` (orderID, orderDateTime, orderStatus, adminID, orderType, orderBranch,custUsername) 
        VALUES ('$orderID', '$orderdate', '$orderstatus', '$adminID','$services', '$branch','$username')";
        $insertOrderResult = mysqli_query($dbconn, $insertOrderQuery);

        if (!$insertOrderResult) {
            throw new Exception("Error: " . mysqli_error($dbconn));
        }

        $insertReceipt = "INSERT INTO payment (paymentID, TotalPrice, orderID , adminID, orderType, orderBranch) 
        VALUES ('$paymentID', '$totalprice', '$orderID', '$adminID', '$services', '$branch')";
        $insertReceiptResult = mysqli_query($dbconn, $insertReceipt);

        if (!$insertReceiptResult) {
            die("Error: " . mysqli_error($dbconn));
        }

        // Insert the cart items into the order table
        while ($cartItem = mysqli_fetch_assoc($cartItemsResult)) {
            $menuID = $cartItem['menuID'];
            $quantity = $cartItem['quantity'];

            $insertCartItemQuery = "INSERT INTO `order details` (orderQty , orderID , menuID) 
            VALUES ('$quantity', $orderID,$menuID)";
            $insertCartItemResult = mysqli_query($dbconn, $insertCartItemQuery);

            if (!$insertCartItemResult) {
                throw new Exception("Error: " . mysqli_error($dbconn));
            }
        }

        // Commit the transaction
        mysqli_commit($dbconn);

        // Clear the cart for the specific customer
        $clearCartQuery = "DELETE FROM cart WHERE custUsername = '$username'";
        $clearCartResult = mysqli_query($dbconn, $clearCartQuery);

        if (!$clearCartResult) {
            throw new Exception("Error: " . mysqli_error($dbconn));
        }

        echo "<div id='donepay'>
        <h1>Congratulations!</h1>
        <p>Payment Successful!</p>
        <p class='small'>You can check your<br> Order in your Profile</p>
        <a href='HomeCust.php'>
            <button>Back To Home</button>
        </a>
    </div>
    <div id='cover' style='display:block'></div>";

    } catch (Exception $e) {
        // Rollback the transaction if an error occurred
        mysqli_rollback($dbconn);
        die($e->getMessage());
    }
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: Login.html");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee For Go</title>
    <style>
        body {
            background-image: url(image/bg.png);
        }

        @keyframes transitionIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* animation: transitionIn 1s; */

        .rounded-square2 {
            margin-left: 100px;
            width: 600px;
            height: 205px;
            border-radius: 20px;
            background-color: #DFE6F0;
            padding-top: 50px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            animation: transitionIn 1s;
        }

        #cover {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 99;
        }

        #donepay {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 25px;
            width: 800px;
            height: 680px;
            margin-top: 15px;
            background-color: orange;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        #donepay h1 {
            text-align: center;
            color: brown;
            font-size: 70px;
            margin-top: 140px;
            animation: transitionIn 1s;
        }

        #donepay p:not(.small) {
            font-family: 'Poppins', sans-serif;
            font-size: 40px;
            color: brown;
            text-align: center;
            font-weight: bold;
            animation: transitionIn 1s;
        }

        .small {
            font-family: 'Poppins', sans-serif;
            font-size: 30px;
            color: brown;
            text-align: center;
            font-weight: bold;
            animation: transitionIn 1s;
        }

        #donepay button {
            width: 200px;
            height: 50px;
            background-color: black;
            border-radius: 25px;
            font-weight: bold;
            color: orange;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            margin-top: 30px;
            margin-left: 305px;
            border: none;
            outline: none;
            transition: box-shadow 0.2s ease-in-out;
            animation: transitionIn 1s;
        }

        #donepay button:hover {
            box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
        }

        #donepay img {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin-left: 300px;
            animation: transitionIn 1s;
        }
    </style>
    <script>

        function showDonePay() {
            document.getElementById("completed").style.display = "block";
            document.getElementById("cover").style.display = "block";
        }

    </script>
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>

    <!-- <div id='donepay'>
        <h1>Congratulation!</h1>
        <p>Payment Successful!</p>
        <p class='small'>You can check your<br> Order and Receipt in your Profile</p>
        <a href='mainPage1.php'>
            <button>Back To Home</button>
        </a>
    </div>
    <div id='cover' style='display:block'></div> -->

</body>

</html>