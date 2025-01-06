<?php 
include("dbconn.php");
session_start();

if(isset($_SESSION['username'])){
    //exec sql statement
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM admin WHERE adminName = '$username'";
    $q = mysqli_query($dbconn,$sql) or die ("Error: ".mysqli_error($dbconn));
    $row = mysqli_num_rows($q);
    if($row == 0){
        echo "No record is found";
    }else{
        $r = mysqli_fetch_assoc($q);
        $staffUsername = $r['adminName'];

?>
<!DOCTYPE html>
<html>
    <head>
        
        <link rel="stylesheet" href="staffdash.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
        <title>Staff Dashboard</title>
        <script>
            function showCustomerOrder() {
                    document.getElementById("customerorder").style.display = "block";
                }

                function closeCustomerOrder() {
                    document.getElementById("customerorder").style.display = "none";
                }

                function submitForm(formId) {
                    document.getElementById(formId).submit();
                }
        </script>
    </head>
    <body>
        <body>

            <div class="topbar">
                <p class="name">Hello, <?php echo $username; ?></p>
                <ul>
                    <li><a onclick="showCustomerOrder()">Customer Order</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>


            <div id="customerorder">
                <h1>Customer Order</h1>
                <div class="table-container">
                    <table border="1" class="tableCustomerOrder">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Order Date</th>
                            <th>Order Status</th>
                            <th>Staff ID</th>
                            <th>Order Type</th>
                            <th>Branch</th>
                            <th>Receipt</th>
                            <th>Press when ready</th>
                        </tr>
                        <?php
                        include("dbconn.php");
                        /* execute SQL statement */
                        $username = $_SESSION['username'];
                        $sql = "SELECT * FROM orders";
                        $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));

                        while ($r = mysqli_fetch_assoc($query)) {
                            $orderID = $r['orderID'];
                            $orderDateTime = $r['orderDateTime'];
                            $orderStatus = $r['orderStatus'];
                            $orderType = $r['orderType'];
                            $orderBranch = $r['orderBranch'];
                            $custUsername = $r['custUsername'];
                            $adminID = $r['adminID'];
                            
                            ?>

                            <tr>
                                <td>
                                    <?php echo $orderID; ?>
                                </td>
                                <td>
                                    <?php echo $custUsername; ?>
                                </td>
                                <td>
                                    <?php echo $orderDateTime; ?>
                                </td>
                                <td
                                class="<?php echo strtolower($orderStatus); ?>">
                                    <?php echo $orderStatus; ?>
                                </td>
                                <td>
                                    <?php echo $adminID; ?>
                                </td>
                                <td>
                                    <?php echo $orderType; ?>
                                </td>
                                <td>
                                    <?php echo $orderBranch; ?>
                                </td>
                                <td>
                                <a href="receipt.php?orderID=<?php echo $orderID; ?>&orderType=<?php echo $orderType; ?>">
                                        View
                                    </a>
                                </td>
                                <td>
                                <form id="status-form-<?php echo $orderID; ?>" method="post" action="orderStatus.php">
                                        <input type="hidden" name="orderID" value="<?php echo $orderID; ?>">
                                        <div class="listbox-container">
                                            <select name="orderStatus" class="change"
                                                onchange="submitForm('status-form-<?php echo $orderID; ?>')">
                                                <option value="Ready" <?php if ($orderStatus == 'Ready')
                                                    echo 'selected'; ?>>Ready
                                                </option>
                                                <option value="Pending" <?php if ($orderStatus == 'Pending')
                                                    echo 'selected'; ?>>Pending
                                                </option>
                                                <option value="Cancel" <?php if ($orderStatus == 'Cancel')
                                                    echo 'selected'; ?>>Cancel
                                                </option>
                                            </select>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <button onclick="closeCustomerOrder()">Close</button>
            </div>

            <div id="customerorder" hidden>
                <h1>Customer Order</h1>
                <table class="tableCustomerOrder">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Order Status</th>
                        <th>Staff ID</th>
                    </tr>

                    <?php
                    include("dbconn.php");
                    /* execute SQL statement */
                    $username = $_SESSION['username'];
                    $sql = "SELECT * FROM orders";
                    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));

                    while ($r = mysqli_fetch_assoc($query)) {
                        $orderID = $r['orderID'];
                        $custUsername = $r['custUsername'];
                        $orderDateTime = $r['orderDateTime'];
                        $orderStatus = $r['orderStatus'];
                        $adminID = $r['adminID'];
                        $orderType = $r['orderType'];
                        $orderBranch = $r['orderBranch'];

                        ?>

                        <tr>
                            <td>
                                <?php echo $orderID; ?>
                            </td>
                            <td>
                                <?php echo $custUsername; ?>
                            </td>
                            <td>
                                <?php echo $orderDateTime; ?>
                            </td>
                            <td
                                    class="<?php echo ($orderStatus == 'Pending') ? 'status-pending' : ($orderStatus == 'Ready' ? 'status-ready' : 'status-cancel'); ?>">
                                    <?php echo $orderStatus; ?>
                            </td>
                            <td>
                                    <?php echo $adminID; ?>
                                </td>
                                <td>
                                    <?php echo $orderType; ?>
                                </td>
                                <td>
                                    <?php echo $orderBranch; ?>
                                </td>
                                <td>
                                    <a href="receipt.php?orderid=<?php echo $orderID; ?>&service=<?php echo $services; ?>">
                                        View
                                    </a>
                                </td>
                                <td>
                                    <form id="status-form-<?php echo $orderID; ?>" method="post" action="status.php">
                                        <input type="hidden" name="order_id" value="<?php echo $orderID; ?>">
                                        <div class="listbox-container">
                                            <select name="order_status" class="change"
                                                onchange="submitForm('status-form-<?php echo $orderID; ?>')">
                                                <option value="Ready" <?php if ($orderStatus == 'Ready')
                                                    echo 'selected'; ?>>Ready
                                                </option>
                                                <option value="Pending" <?php if ($orderStatus == 'Pending')
                                                    echo 'selected'; ?>>Pending
                                                </option>
                                                <option value="Cancel" <?php if ($orderStatus == 'Cancel')
                                                    echo 'selected'; ?>>Cancel
                                                </option>
                                            </select>
                                        </div>
                                    </form>
                                </td>
                        </tr>

                        <?php
                    }
                    ?>
                </table>
            </div>
    </body>
</html>
<?php 
}
}else{
    header("Location: Login.html");
}