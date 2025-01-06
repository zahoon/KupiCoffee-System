<?php
include("dbconn.php");
session_start();
if (isset($_SESSION['username'])){
    //Exec SQL Statement
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM ADMIN WHERE adminUsername = '$username' ";
    $q = mysqli_query($dbconn,$sql) or die ("Error :" . mysqli_error($dbconn));
    $r = mysqli_num_rows($q);
    if ($r == 0){
        echo "No record exist";
    }else{
        $f = mysqli_fetch_assoc($q);
        $adminUsername = $f['adminUsername'];
        $adminName = $f['adminName'];
        ?>

        <?php
        include ("dbconn.php");
        $sql = "SELECT * FROM CUSTOMER";
        $q = mysqli_query($dbconn,$sql) or die ("Error " . mysqli_error($dbconn));
        $r = mysqli_num_rows($q);
        if($r == 0){
            echo "No record exist";
        }else{
            echo "";
            echo "<div id='customerdata' hidden>";
            echo "<h1>Customer Data</h1>";
            echo "<table border=1 class='tableCustomerData'>";
            echo "<tr>";
            echo "<th>Customer Username</th>";
            echo "<th>Customer Phone Number</th>";
            echo "<th>Customer Address</th>";
            echo "</tr>"; 
            while($r = mysqli_fetch_array($q)){
                echo "<tr>";
                echo "<td>" . $r["custUsername"] . "</td>";
                echo "<td>" . $r["custPhoneNum"] . "</td>";
                echo "<td>" . $r["custAddress"] . "</td>";
            }
            echo "</table>";

            echo "<button onclick='closeCustomerData()'>Close</button>";
            echo "</div>";
        }
        ?>

<!DOCTYPE html>
        <html>
        <head>
            <!-- <link rel="stylesheet" href="admindash.css"> -->
            <script>
                function showStatistic() {
                    document.getElementById("statistic").style.display = "block";
                }

                function closeStatistic() {
                    document.getElementById("statistic").style.display = "none";
                }

                function showCustomerData() {
                    document.getElementById("customerdata").style.display = "block";
                }

                function closeCustomerData() {
                    document.getElementById("customerdata").style.display = "none";
                }

                function showCustomerOrder() {
                    document.getElementById("customerorder").style.display = "block";
                }

                function closeCustomerOrder() {
                    document.getElementById("customerorder").style.display = "none";
                }

                function showMenu() {
                    document.getElementById("menu").style.display = "block";
                }

                function closeMenu() {
                    document.getElementById("menu").style.display = "none";
                }

            </script>
            <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
            <style>
                
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
                .topbar {
                    width: 100%;
                    height: 80px;
                    background-color: #FFD700;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 0 20px;
                    
                }
                
                .name {
                    color: #7a2005;
                    text-decoration: none;
                    padding: 10px 20px;
                    transition: background-color 0.3s ease;
                    font-size: 40px;
                    font-family: Bedrock;
                    font-weight: bold;
                    text-transform: uppercase;
                }
                
                .topbar ul {
                    list-style-type: none;
                    margin: 0;
                    margin-right: 20px;
                    padding: 10px 20px;
                    display: flex;
                }
                
                .topbar li a {
                    display: flex;
                    color: #000000;
                    padding: 16px;
                    text-decoration: none;
                    font-family: 'Poppins', sans-serif;
                    font-weight: bold;
                    margin-top: 40px;
                    margin-right: 50px;
                }
                
                .topbar li a:hover {
                    background-color: #ffffff;
                    color: #181444;
                }

                #customerdata {
                    position: fixed;
                    top: 25%;
                    left: 25%;
                    transform: translate(-50%, -50%);
                    border-radius: 25px;
                    width: 1600px;
                    height: 800px;
                    margin-top: 260px;
                    margin-left: 500px;
                    background-color: #7a2005;
                    z-index: 100;
                }

                #customerdata h1 {
                    font-family: 'Poppins', sans-serif;
                    text-align: center;
                    color: white;
                    font-size: 50px;
                    margin-top: 20px;
                    animation: transitionIn 1s;
                }

                #customerdata p {
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                #customerdata button {
                    width: 100px;
                    height: 50px;
                    background-color: #7a2005;
                    border-radius: 25px;
                    font-weight: bold;
                    color: #FFD700;
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    margin-top: 30px;
                    margin-left: 750px;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                }

                #customerdata button:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .tableCustomerData {
                    height: 170;
                    width: 1500;
                    margin-left: 50px;
                    border-collapse: collapse;
                    animation: transitionIn 1s;
                }

                .tableCustomerData th td {
                    font-family: 'Poppins', sans-serif;
                    font-weight: bold;
                    color: #FFD700;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .tableCustomerData tr {
                    font-family: 'Poppins', sans-serif;
                    color: white;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .tableCustomerData a {
                    color: #FFD700;
                    text-align: center;
                    text-decoration: none;
                    font-weight: bold;
                    animation: transitionIn 1s;
                }

                #customerorder {
                    position: fixed;
                    top: 25%;
                    left: 25%;
                    transform: translate(-50%, -50%);
                    border-radius: 25px;
                    width: 1600px;
                    height: 800px;
                    margin-top: 260px;
                    margin-left: 500px;
                    background-color: #7a2005;
                    z-index: 100;
                }

                #customerorder h1 {
                    font-family: 'Poppins', sans-serif;
                    text-align: center;
                    color: white;
                    font-size: 50px;
                    margin-top: 20px;
                    animation: transitionIn 1s;
                }

                #customerorder p {
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                #customerorder button {
                    width: 100px;
                    height: 50px;
                    background-color: #7a2005;
                    border-radius: 25px;
                    font-weight: bold;
                    color: #FFD700;
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    margin-top: 30px;
                    margin-left: 750px;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                }

                #customerorder button:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .tableCustomerOrder {
                    height: 170;
                    width: 1500;
                    margin-left: 50px;
                    border-collapse: collapse;
                    animation: transitionIn 1s;
                }

                .tableCustomerOrder th {
                    font-family: 'Poppins', sans-serif;
                    font-weight: bold;
                    color: #181444;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .tableCustomerOrder td.pending {
                    font-family: 'Poppins', sans-serif;
                    font-size: 17px;
                    color: orange;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .tableCustomerOrder td.ready {
                    font-family: 'Poppins', sans-serif;
                    font-size: 17px;
                    color: green;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .tableCustomerOrder td.cancel {
                    font-family: 'Poppins', sans-serif;
                    font-size: 17px;
                    color: red;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .tableCustomerOrder tr {
                    font-family: 'Poppins', sans-serif;
                    color: #FFD700;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .tableCustomerOrder a {
                    color: #FFD700;
                    text-align: center;
                    text-decoration: none;
                    font-weight: bold;
                    animation: transitionIn 1s;
                }

                #statistic {
                    position: fixed;
                    top: 25%;
                    left: 25%;
                    transform: translate(-50%, -50%);
                    border-radius: 25px;
                    width: 1600px;
                    height: 800px;
                    margin-top: 260px;
                    margin-left: 500px;
                    background-color: #7a2005;
                    z-index: 100;
                }

                #statistic button {
                    width: 100px;
                    height: 50px;
                    background-color: #FFD700;
                    border-radius: 25px;
                    border-color: #7a2005;
                    font-weight: bold;
                    color: rgb(0, 0, 0);
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    margin-top: 50px;
                    margin-left: 750px;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                }

                #statistic button:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .hide {
                    color: white;
                }

                .box1 {
                    width: 1500px;
                    height: 250px;
                    background-color: white;
                    margin-top: 80px;
                    margin-left: 50px;
                    border-radius: 10px;
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .box2 {
                    width: 500px;
                    height: 250px;
                    background-color: white;
                    margin-top: 50px;
                    margin-left: 550px;
                    border-radius: 10px;
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .table1 {
                    margin-top: 25px;
                    margin-left: 80px;
                    width: 93%;
                }

                .table2 {
                    margin-top: 25px;
                    margin-left: 80px;
                    width: 80%;
                }

                .title1 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 25px;
                    font-weight: bold;
                    color: #181444;
                    margin-top: 20px;
                    animation: transitionIn 1s;
                    margin-left: 80px;
                }

                .text1 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 60px;
                    font-weight: bold;
                    color: #181444;
                    line-height: 10px;
                    animation: transitionIn 1s;
                    margin-left: 90px;
                }

                .img1 {
                    width: 130px;
                    height: 130px;
                    animation: transitionIn 1s;
                }

                #menu {
                    position: fixed;
                    top: 25%;
                    left: 25%;
                    transform: translate(-50%, -50%);
                    border-radius: 25px;
                    width: 1600px;
                    height: 800px;
                    margin-top: 260px;
                    margin-left: 500px;
                    background-color: #7a2005;
                    z-index: 100;
                }

                #menu h1 {
                    font-family: 'Poppins', sans-serif;
                    text-align: center;
                    color: white;
                    font-size: 50px;
                    margin-top: 20px;
                    animation: transitionIn 1s;
                }

                #menu p {
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                #menu button {
                    width: 100px;
                    height: 50px;
                    background-color: #7a2005;
                    border-radius: 25px;
                    font-weight: bold;
                    color: #FFD700;
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    margin-top: 30px;
                    margin-left: 750px;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                }

                #menu button:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .table-container {
                    max-height: 555px;
                    min-height: 555px;
                    padding: 10px;
                    overflow-y: scroll;
                }

                .menu {
                    width: 1500;
                    margin-left: 50px;
                    border-collapse: collapse;
                    animation: transitionIn 1s;
                    background-color: #FFD700;
                }

                .menu th {
                    font-family: 'Poppins', sans-serif;
                    font-weight: bold;
                    color: #181444;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .menu td.unavailable {
                    font-family: 'Poppins', sans-serif;
                    font-size: 17px;
                    color: red;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .menu td.available {
                    font-family: 'Poppins', sans-serif;
                    font-size: 17px;
                    color: green;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .menu tr {
                    font-family: 'Poppins', sans-serif;
                    color: #000000;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .menu a {
                    color: #000000;
                    text-align: center;
                    text-decoration: none;
                    font-weight: bold;
                    animation: transitionIn 1s;
                }

                .change {
                    width: 70px;
                    height: 30px;
                    background-color: #181444;
                    border-radius: 20px;
                    font-weight: bold;
                    color: white;
                    font-family: 'Poppins', sans-serif;
                    font-size: 10px;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                }

                a:visited {
                    color: #181444;
                    text-decoration: none;
                }
            </style>
        </head>

        <body>

            <div class="topbar">
                <ul>
                <p class="name">Hello,
                    <?php echo $adminName;?>
                </p>
                    
                    <li><a onclick="showStatistic()">Dashboard</a></li>
                    <li><a onclick="showCustomerData()">Customer Data</a></li>
                    <li><a onclick="showCustomerOrder()">Customer Order</a></li>
                    <li><a onclick="showMenu()">Menu</a></li>
                    <li><a href="addMenu.php">Add Menu</a></li>
                    <li><a href="searchCust.php">Search Customer</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>


            <div id="menu" hidden>
                <h1>Menu</h1>
                <div class="table-container">
                    <table border="1" class="menu">
                        <tr>
                            <th>Menu ID</th>
                            <th>Menu Type</th>
                            <th>Menu Name</th>
                            <th>Menu Price</th>
                            <th>Menu Status</th>
                            <th>Change Status</th>
                            <th>Edit</th>
                        </tr>

                        <?php
                        include("dbconn.php");
                        /* execute SQL statement */
                        $username = $_SESSION['username'];
                        $sql = "SELECT * FROM menu";
                        $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));

                        while ($r = mysqli_fetch_assoc($query)) {
                            $menuID = $r['menuID'];
                            $menuName = $r['menuName'];
                            $menuPrice = $r['menuPrice'];
                            $menuType = $r['menuType'];
                            $menuStatus = $r['menuStatus'];
                            $menuDesc = $r['menuDesc'];

                            ?>

                            <tr>
                                <td>
                                    <?php echo $menuID; ?>
                                </td>
                                <td>
                                    <?php echo $menuType; ?>
                                </td>
                                <td>
                                    <?php echo $menuName; ?>
                                </td>
                                <td>
                                    <?php echo $menuPrice; ?>
                                </td>
                                <td class="<?php echo strtolower($menuStatus); ?>">
                                    <?php echo $menuStatus; ?>
                                </td>
                                <td>
                                    <form method="post" action="menuStatus.php">
                                        <input type="hidden" name="menuID" value="<?php echo $menuID; ?>">
                                        <input type="hidden" name="menuStatus" value="<?php echo $menuStatus; ?>">
                                        <input type="submit" value="Change" class="change">
                                    </form>
                                </td>
                                <td>
                                    <form method="post" action="menuEdit.php">
                                        <input type="hidden" name="menuID" value="<?php echo $menuID; ?>">
                                        <input type="submit" value="Edit" class="change">
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <button onclick="closeMenu()">Close</button>
            </div>



            <div id="customerorder" hidden>
                <h1>Customer Order</h1>
                <table border="1" class="tableCustomerOrder">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Order Status</th>
                        <th>Staff ID</th>
                        <th>Services</th>
                        <th>Branch</th>
                    </tr>

                    <?php
                    include("dbconn.php");
                    /* execute SQL statement */
                    $username = $_SESSION['username'];
                    $sql = "SELECT * FROM orders";
                    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));

                    while ($r = mysqli_fetch_assoc($query)) {
                        $orderid = $r['orderID'];
                        $custUsername = $r['custUsername'];
                        $orderDateTime = $r['orderDateTime'];
                        $orderStatus = $r['orderStatus'];
                        $adminID = $r['adminID'];
                        $orderType = $r['orderType'];
                        $orderBranch = $r['orderBranch'];

                        ?>

                        <tr>
                            <td>
                                <?php echo $orderid; ?>
                            </td>
                            <td>
                                <?php echo $custUsername; ?>
                            </td>
                            <td>
                                <?php echo $orderDateTime; ?>
                            </td>
                            <td class="<?php echo strtolower($orderStatus); ?>">
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
                        </tr>

                        <?php
                    }
                    ?>
                </table>
                <button onclick="closeCustomerOrder()">Close</button>
            </div>

            <?php
            include("dbconn.php");
            $sql = "SELECT COUNT(*) AS total_rows FROM `orders`";
            // Execute the SQL statement
            $result = mysqli_query($dbconn, $sql);

            // Check if the query was successful
            if ($result) {
                // Fetch the result as an associative array
                $row = mysqli_fetch_assoc($result);

                // Access the count value
                $totalOrder = $row['total_rows'];
            }

            $sql2 = "SELECT SUM(TotalPrice) AS totalSum FROM payment";
            // Execute the SQL statement
            $result2 = mysqli_query($dbconn, $sql2);

            // Check if the query was successful
            if ($result2) {
                // Fetch the result as an associative array
                $row2 = mysqli_fetch_assoc($result2);

                // Access the count value
                $totalPrice = $row2['totalSum'];
            }

            $sql3 = "SELECT COUNT(*) AS total_rows FROM `customer`";
            // Execute the SQL statement
            $result3 = mysqli_query($dbconn, $sql3);

            // Check if the query was successful
            if ($result3) {
                // Fetch the result as an associative array
                $row3 = mysqli_fetch_assoc($result3);

                // Access the count value
                $totalCustomer = $row3['total_rows'];
            }

            $sql4 = "SELECT SUM(orderQty) AS totalSold FROM `order details`";
            // Execute the SQL statement
            $result4 = mysqli_query($dbconn, $sql4);

            // Check if the query was successful
            if ($result4) {
                // Fetch the result as an associative array
                $row4 = mysqli_fetch_assoc($result4);

                // Access the count value
                $totalSold = $row4['totalSold'];
            }

            ?>

            <div id="statistic">

                <div class="box1">
                    <p class="hide">1</p>
                    <table border="0" class="table1">
                        <!-- <td>
                            <img src="image/order.png" class="img1">
                        </td> -->
                        <td>
                            <p class="title1">Total Orders</p>
                            <p class="text1">
                                <?php echo $totalOrder; ?>
                            </p>
                        </td>
                        <!-- <td>
                            <img src="image/customer.png" class="img1">
                        </td> -->
                        <td>
                            <p class="title1">Total Customers</p>
                            <p class="text1">
                                <?php echo $totalCustomer; ?>
                            </p>
                        </td>
                        <!-- <td>
                            <img src="image/sales.png" class="img1">
                        </td> -->
                        <td>
                            <p class="title1">Total Sales</p>
                            <p class="text1">RM
                                <?php echo $totalPrice; ?>
                            </p>
                        </td>
                    </table>

                </div>

                <div class="box2">
                    <p class="hide">1</p>
                    <table border="0" class="table2">
                        <!-- <td>
                            <img src="image/item.png" class="img1">
                        </td> -->
                        <td>
                            <p class="title1">Product Sold</p>
                            <p class="text1">
                                <?php echo $totalSold; ?>
                            </p>
                        </td>
                    </table>

                </div>

                <button onclick="closeStatistic()">Close</button>

            </div>

        </body>

        </html>
        <?php 
    }
} else {
    header("Location: Login.html");
}
?>