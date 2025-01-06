<?php
include("dbconn.php");
session_start();
$orderID = $_GET['orderID'];
$orderType = $_GET['orderType'];
if (isset($_SESSION['username'])) {
    /* execute SQL statement */
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM payment WHERE orderID = '$orderID'";
    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error());
    $row = mysqli_num_rows($query);
    if ($row == 0) {
        echo "No record found";
    } else {
        $r = mysqli_fetch_assoc($query);
        $paymentID = $r['paymentID'];
        $orderBranch = $r['orderBranch'];
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Coffee For Go!</title>
            <style>
                body {
                    background-color: #DFE6F0;
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

                #receipt {
                    position: fixed;
                    top: 40%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    border-radius: 45px;
                    width: 650px;
                    height: 700px;
                    background-color: orange;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
                    z-index: 100;
                }

                .table-container {
                    max-height: 420px;
                    min-height: 420px;
                    padding: 10px;
                    overflow-y: scroll;
                }

                .title {
                    font-size: 35px;
                    color: #181444;
                    font-weight: bold;
                    text-align: center;
                    animation: transitionIn 1s;
                    line-height: 10px;
                }

                .text1 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 35px;
                    color: black;
                    font-weight: none;
                    text-align: center;
                    line-height: 20px;
                    animation: transitionIn 1s;
                }

                .text2 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    color: black;
                    font-weight: none;
                    line-height: 1px;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .menu {
                    font-family: 'Poppins', sans-serif;
                    font-size: 19px;
                    color: #000000;
                    font-weight: bold;
                    line-height: 20px;
                    animation: transitionIn 1s;
                }

                .type {
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    color: #000000;
                    font-weight: bold;
                    line-height: 5px;
                    margin-left: 30px;
                    animation: transitionIn 1s;
                }

                .quantity {
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    color: #000000;
                    font-weight: bold;
                    line-height: 5px;
                    margin-left: 30px;
                    animation: transitionIn 1s;
                }

                .price {
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    color: #000000;
                    font-weight: bold;
                    text-align: right;
                    animation: transitionIn 1s;
                }

                .table1 {
                    height: 10px;
                    width: 550px;
                    margin-left: 45px;
                }

                .table2 {
                    margin-left: 55px;
                    margin-top: 0px;
                    height: 20%;
                    width: 550px;
                }

                .branch {
                    font-family: 'Poppins', sans-serif;
                    font-size: 14px;
                    color: #000000;
                    font-weight: bold;
                    margin-left: 40px;
                    animation: transitionIn 1s;
                }

                .totalprice {
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    color: #000000;
                    font-weight: bold;
                    text-align: right;
                    animation: transitionIn 1s;
                }

                .delivery {
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    color: #000000;
                    font-weight: bold;
                    text-align: right;
                    animation: transitionIn 1s;
                }

                .grand {
                    font-family: 'Poppins', sans-serif;
                    font-size: 30px;
                    color: #000000;
                    font-weight: bold;
                    text-align: right;
                    animation: transitionIn 1s;
                }

                .back {
                    position: fixed;
                    width: 150px;
                    height: 60px;
                    border-radius: 40px;
                    background-color: orange;
                    margin-top: 900px;
                    margin-left: 915px;
                    color: #ffffff;
                    font-family: 'Poppins', sans-serif;
                    font-size: 15px;
                    font-weight: bold;
                    transition: box-shadow 0.2s ease-in-out;
                    border: none;
                    outline: none;
                    animation: transitionIn 1s;
                }

                .back:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }
            </style>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
            <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
        </head>

        <body>

            <?php
            include("dbconn.php");

            $sql = "SELECT * FROM orders WHERE orderID= '$orderID'";
            $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error());
            $row = mysqli_num_rows($query);
            if ($row == 0) {
                echo "No record found";
            } else {
                $r = mysqli_fetch_assoc($query);
                $orderdate = $r['orderDateTime'];
                $orderType = $r['orderType'];
                ?>

                <div id="receipt">
                    <p class="title">Coffee For Go</p>
                    <p class="text1">Thank your for placing the order</p>
                    <p class="text2">Order Date :
                        <?php echo $orderdate; ?>
                    </p>
                    <p class="text2">Order ID :
                        <?php echo $orderID; ?>
                    </p>
                    <p class="text2">Invoice ID :
                        <?php echo $paymentID; ?>
                    </p>
                    <p class="text2">Order Type :
                        <?php echo $orderType; ?>
                    </p>

                    <?php
            }
            ?>

                <div class="table-container">

                    <?php
                    include("dbconn.php");

                    // Fetch the item records from the database
                    $query = "SELECT * FROM `order details` WHERE orderID = '$orderID'";
                    $result = mysqli_query($dbconn, $query);

                    // Iterate over the records and generate table columns dynamically
                    while ($row = mysqli_fetch_assoc($result)) {
                        $menuID = $row['menuID'];
                        $quantity = $row['orderQty'];

                        $query2 = "SELECT * FROM menu WHERE menuID = '$menuID'";
                        $result2 = mysqli_query($dbconn, $query2);

                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            $menuName = $row2['menuName'];
                            $menuType = $row2['menuType'];
                            $menuPrice = $row2['menuPrice'];

                            $total = $menuPrice * $quantity;
                            $totalFormat = number_format($total, 2);
                            ?>

                            <table border="0" class="table1">
                                <td>
                                    <p class="menu">
                                        <?php echo $menuName; ?>
                                    </p>
                                    <p class="type">Type :
                                        <?php echo $menuType; ?>
                                    </p>
                                    <p class="quantity">Quantity :
                                        <?php echo $quantity; ?>
                                    </p>
                                </td>

                                <td>
                                    <p class="price">RM
                                        <?php echo $totalFormat; ?>
                                    </p>
                                </td>
                            </table>

                            <?php
                        }
                    }
                    ?>

                </div>

                <p class="branch">Branch :
                    <?php echo $orderBranch; ?>
                </p>

                <?php
                include("dbconn.php");

                $query = "SELECT * FROM payment WHERE orderID = '$orderID'";
                $result = mysqli_query($dbconn, $query);
                $row = mysqli_fetch_assoc($result);
                $totalprice = $row['TotalPrice'];

                if ($orderType === 'Delivery') {
                    $deliveryCharges = 5.00;
                } elseif ($orderType === 'Pickup') {
                    $deliveryCharges = 0;
                } else {
                    $deliveryCharges = 'N/A';
                }

                $deliveryChargesFormat = number_format($deliveryCharges, 2);

                $nofees = $totalprice - $deliveryCharges;
                $nofeesFormat = number_format($nofees, 2);

                ?>

                <table border="0" class="table2">
                    
                    <!-- <td>
                        <img src="image/paid.png" class="img">
                    </td> -->

                    <td>
                        <p class="totalprice">Total Price : RM
                            <?php echo $nofeesFormat; ?>
                        </p>
                        <p class="delivery">Delivery Charges : RM
                            <?php echo $deliveryChargesFormat; ?>
                        </p>
                        <p class="grand">Grand Total : RM
                            <?php echo $totalprice; ?>
                        </p>
                    </td>
                </table>

            </div>

            <button onclick="goBack()">Back</button>

        </body>

        </html>

        <?php
    }
} else {
    header("Location: Login.html");
}
?>