<?php
include("dbconn.php");
session_start();
if (isset($_SESSION['username'])) {
    /* execute SQL statement */
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM customer WHERE custUsername= '$username'";
    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error());
    $row = mysqli_num_rows($query);
    if ($row == 0) {
        echo "No record found";
    } else {
        $r = mysqli_fetch_assoc($query);
        $custUsername = $r['custUsername'];
        $custPhoneNum = $r['custPhoneNum'];
        $custAddress = $r['custAddress'];
        $custPassword = $r['custPassword'];
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <script>

            </script>
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

                .imgItem {
                    width: 200px;
                    height: 200px;
                    display: inline-block;
                    animation: transitionIn 1s;
                }

                .remove {
                    width: 60px;
                    height: 50px;
                    border-radius: 10px;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                }

                .remove:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .tableCart {
                    height: auto;
                    border-radius: 25px;
                    background-color: yellow;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
                    margin-top: 20px;
                }

                .price {
                    font-family: 'Poppins', sans-serif;
                    font-size: 25px;
                    color: #7a2005;
                    line-height: 25px;
                    font-weight: bolder;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .font {
                    font-family: 'Poppins', sans-serif;
                    font-size: 30px;
                    color: #181444;
                    line-height: 25px;
                    font-weight: bold;
                    animation: transitionIn 1s;
                }

                .greyFont {
                    font-family: 'Poppins', sans-serif;
                    font-size: 20px;
                    color: black;
                    line-height: 5px;
                    font-weight: none;
                    animation: transitionIn 1s;
                }

                .greyFont1 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 23px;
                    color: black;
                    line-height: 5px;
                    font-weight: none;
                    animation: transitionIn 1s;
                    text-align: center;
                }

                .td1 {
                    width: 100px;
                }

                .td2 {
                    width: 400px;
                }

                .rounded-square1 {
                    position: fixed;
                    width: 48%;
                    height: auto;
                    border-radius: 20px;
                    background-color: yellow;
                    animation: transitionIn 1s;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
                    margin-left: 1000px;
                }

                .rounded-square2 {
                    width: 96%;
                    height: auto;
                    border-style: solid;
                    border-width: 2px;
                    border-color: grey;
                    background-color: aliceblue;
                    border-radius: 10px;
                    margin-left: 20px;
                }

                .text1 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 25px;
                    color: #181444;
                    font-weight: bold;
                    animation: transitionIn 1s;
                    margin-left: 20px;
                    line-height: 2px;
                }

                .text2 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 20px;
                    color: grey;
                    font-weight: none;
                    animation: transitionIn 1s;
                    margin-left: 20px;
                    margin-top: 30px;
                    line-height: 2px;
                    margin-top: 50px;
                }

                .text22 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 20px;
                    color: #0077ff;
                    font-weight: bold;
                    animation: transitionIn 1s;
                    margin-left: 20px;
                    line-height: 2px;
                }

                .noline {
                    text-decoration: none;
                }

                .text3 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 20px;
                    color: grey;
                    font-weight: none;
                    animation: transitionIn 1s;
                    margin-left: 20px;
                    line-height: 2px;
                }

                .text33 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 20px;
                    color: #181444;
                    font-weight: bold;
                    animation: transitionIn 1s;
                    margin-left: 20px;
                }

                .submit {
                    margin-top: 5px;
                    margin-left: 20px;
                    background-color: #181444;
                    color: white;
                    border-radius: 5px;
                    font-family: 'Poppins', sans-serif;
                    font-size: 15px;
                    border: none;
                    outline: none;
                }

                .address {
                    font-family: 'Poppins', sans-serif;
                    font-size: 20px;
                    color: #181444;
                    font-weight: bold;
                    animation: transitionIn 1s;
                    margin-left: 20px;
                }

                .table1 {
                    height: auto;
                    width: 96%;
                    margin-left: 20px;
                }

                .text4 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 23px;
                    color: #181444;
                    font-weight: bold;
                    animation: transitionIn 1s;
                }

                .text5 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 23px;
                    color: #181444;
                    font-weight: bold;
                    animation: transitionIn 1s;
                    text-align: right;
                }

                .text6 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 33px;
                    color: #181444;
                    font-weight: bold;
                    animation: transitionIn 1s;
                }

                .text7 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 33px;
                    color: #181444;
                    font-weight: bold;
                    animation: transitionIn 1s;
                    text-align: right;
                }

                .button1 {
                    position: fixed;
                    width: 42%;
                    height: 80px;
                    border-radius: 10px;
                    background-color: #181444;
                    color: white;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                    margin-top: 715px;
                    margin-left: 1060px;
                    font-family: 'Poppins', sans-serif;
                    font-size: 25px;
                    font-weight: bold;
                    text-align: center;
                    border: none;
                    outline: none;
                }

                .button1:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .button2 {
                    position: fixed;
                    width: 42%;
                    height: 80px;
                    border-radius: 10px;
                    background-color: rgba(255, 255, 255, 0);
                    color: #181444;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                    margin-top: 800px;
                    margin-left: 1060px;
                    font-family: 'Poppins', sans-serif;
                    font-size: 25px;
                    font-weight: bold;
                    text-align: center;
                    border-style: solid;
                    border-color: #181444;
                    border-width: 5px;
                }

                .button2:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .button3 {
                    position: fixed;
                    width: 42%;
                    height: 80px;
                    border-radius: 10px;
                    background-color: #fd4343;
                    color: #ffffff;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                    margin-top: 885px;
                    margin-left: 1060px;
                    font-family: 'Poppins', sans-serif;
                    font-size: 25px;
                    font-weight: bold;
                    text-align: center;
                    border-style: solid;
                    border-color: #fd4343;
                    border-width: 5px;
                }

                .button3:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .listbox {
                    width: 96%;
                    height: auto;
                    margin-left: 20px;
                    margin-top: 1px;
                    font-family: 'Poppins', sans-serif;
                    font-size: 20px;
                    color: #181444;
                    font-weight: bold;
                    border-radius: 7px;
                    background-color: aliceblue;
                    border-width: 2px;
                }

                .listFont1 {
                    font-family: 'Poppins', sans-serif;
                    font-size: 20px;
                    color: #181444;
                    font-weight: bold;
                    animation: transitionIn 1s;
                    margin-left: 20px;
                }
            </style>
        </head>

        <body>

            <?php
            include("dbconn.php");

            // Fetch the item records from the database
            $query = "SELECT * FROM cart WHERE custUsername = '$custUsername'";
            $result = mysqli_query($dbconn, $query);

            $quantityItem = 0;
            $totalPrice = 5.00;
            $service = 'Delivery';

            // Iterate over the records and generate table columns dynamically
            while ($row = mysqli_fetch_assoc($result)) {
                $menuID = $row['menuID'];
                $quantity = $row['quantity'];

                $query2 = "SELECT * FROM menu WHERE menuID = '$menuID'";
                $result2 = mysqli_query($dbconn, $query2);

                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $menuPrice = $row2['menuPrice'];

                    $quantityItem += $quantity;

                    $total = $menuPrice * $quantity;
                    $totalPrice += $total;
                    $totalPriceFormat = number_format($totalPrice, 2);

                }
            }

            $nofees = $totalPrice - 5;
            $nofeesFormat = number_format($nofees, 2);

            // Check if items exist in the cart table
            $cartQuery = "SELECT * FROM cart WHERE custUsername = '$custUsername'";
            $cartResult = mysqli_query($dbconn, $cartQuery);
            $numItemsInCart = mysqli_num_rows($cartResult);

            if ($numItemsInCart == 0) {
                $totalPriceFormat = number_format($totalPrice, 2);
            }

            ?>

            <div class="rounded-square1">

                <p class="text1">My Cart:
                    <?php echo $quantityItem; ?> items
                </p>

                <p class="text2">Service</p>
                <p class="text1">Delivery</p>
                <a href="cartPickup.php" class="noline">
                    <p class="text22">Switch To Pickup</p>
                </a>

                <div class="rounded-square2">
                    <p class="text3">Address</p>
                    <p class="address">
                        <?php echo $custAddress; ?>
                    </p>
                </div>

                <p class="text3">Branch</p>

                <form id="myForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <select name="listboxValue" id="listboxId" class="listbox">
                        <option class="listFont1" value="option1">2, 2A, Jalan Bendahara 1, Taman Bendahara, 45000 Kuala Selangor, Selangor</option>
                        <option class="listFont1" value="option2">Block H (Ground Floor), Student Association Building, Jalan Broga, 43500 Semenyih, Selangor Darul Ehsan</option>
                        <option class="listFont1" value="option3">Lot CPD 3 A06, Gate A, Contact Pier Domestic KLIA, Kuala Lumpur International Airport, 64000 Sepang, Selangor Darul Ehsan</option>
                        <option class="listFont1" value="option4">ALot G.15 & G.16. KL Gateway Mall. 2, Jalan Kerinchi, Kampung Kerinchi, 59200 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur.</option>
                        <option class="listFont1" value="option5">Lot F37. Jalan R1, Seksyen 1, Bandar Baru Wangsa Maju 53300 Kuala Lumpur.
                        </option>
                        <option class="listFont1" value="option6">Lot CPD 3 A06, Gate A, Contact Pier Domestic KLIA, Kuala Lumpur International Airport, 64000 Sepang, Selangor Darul Ehsan.</option>
                        <option class="listFont1" value="option7">Lot KF2. Jalan Jejaka, Maluri, 55100 Cheras, Wilayah Persekutuan Kuala Lumpur</option>
                        <option class="listFont1" value="option8">A3 Library Cafe – GF, Xiamen University Malaysia, Jalan Sunsuria, Bandar Sunsuria, 43900 Sepang, Selangor.</option>
                    </select>
                    <input type="submit" value="Select" class="submit">
                </form>

                <?php
                $selectedValue = isset($_POST['listboxValue']) ? $_POST['listboxValue'] : 'option1';
                $branch = '';
                if ($selectedValue === 'option1') {
                    $branch = '2, 2A, Jalan Bendahara 1, Taman Bendahara, 45000 Kuala Selangor, Selangor';
                } else if ($selectedValue === 'option2') {
                    $branch = 'Block H (Ground Floor), Student Association Building, Jalan Broga, 43500 Semenyih, Selangor Darul Ehsan';
                } else if ($selectedValue === 'option3') {
                    $branch = 'Lot CPD 3 A06, Gate A, Contact Pier Domestic KLIA, Kuala Lumpur International Airport, 64000 Sepang, Selangor Darul Ehsan';
                } else if ($selectedValue === 'option4') {
                    $branch = 'ALot G.15 & G.16. KL Gateway Mall. 2, Jalan Kerinchi, Kampung Kerinchi, 59200 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur.';
                } else if ($selectedValue === 'option5') {
                    $branch = 'Lot F37. Jalan R1, Seksyen 1, Bandar Baru Wangsa Maju 53300 Kuala Lumpur.';
                } else if ($selectedValue === 'option6') {
                    $branch = 'Lot CPD 3 A06, Gate A, Contact Pier Domestic KLIA, Kuala Lumpur International Airport, 64000 Sepang, Selangor Darul Ehsan.';
                } else if ($selectedValue === 'option7') {
                    $branch = 'Lot KF2. Jalan Jejaka, Maluri, 55100 Cheras, Wilayah Persekutuan Kuala Lumpur';
                } else if ($selectedValue === 'option8') {
                    $branch = 'A3 Library Cafe – GF, Xiamen University Malaysia, Jalan Sunsuria, Bandar Sunsuria, 43900 Sepang, Selangor.';
                }
                ?>

                <p class="text3">Selected Branch</p>
                <p class="text33">
                    <?php echo $branch; ?>
                </p>

                <table border="0" class="table1">
                    <td>
                        <p class="text4">Items Total Price</p>
                    </td>

                    <td>
                        <p class="text5">RM
                            <?php echo $nofeesFormat; ?>
                        </p>
                    </td>
                </table>

                <table border="0" class="table1">
                    <td>
                        <p class="text4">Delivery Charges</p>
                    </td>

                    <td>
                        <p class="text5">RM 5.00</p>
                    </td>
                </table>

                <table border="0" class="table1">
                    <td>
                        <p class="text6">Total Price</p>
                    </td>

                    <td>
                        <p class="text7">RM
                            <?php echo $totalPriceFormat; ?>
                        </p>
                    </td>
                </table>
            </div>

            <?php

            $sql = "SELECT * FROM cart WHERE custUsername = '$custUsername'";
            $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error());
            $row = mysqli_num_rows($query);

            if ($row == 0) { ?>

            <?php } else { ?>
                <a
                    href="pay.php?price=<?php echo $totalPriceFormat; ?>&service=<?php echo $service; ?>&branch=<?php echo $branch; ?>">
                    <button class="button1">
                        Proceed To Checkout
                    </button>
                </a>
            <?php } ?>

            <a href="menuCust.php">
                <button class="button2">Continue Shopping</button>
            </a>
            <form action="cartDelete.php" method="post">
                <button class="button3" type="submit" name="DeleteAll">Remove All</button>
            </form>


            <?php
            include("dbconn.php");

            // Fetch the item records from the database
            $query = "SELECT * FROM cart WHERE custUsername = '$custUsername'";
            $result = mysqli_query($dbconn, $query);

            // Iterate over the records and generate table columns dynamically
            while ($row = mysqli_fetch_assoc($result)) {
                $menuID = $row['menuID'];
                $quantity = $row['quantity'];

                $query2 = "SELECT * FROM menu WHERE menuID = '$menuID'";
                $result2 = mysqli_query($dbconn, $query2);

                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $menuName = $row2['menuName'];
                    $menuType = $row2['menuType'];
                    $menuPrice = $row2['menuPrice'];
                    $menuImage = $row2['menuImage'];

                    $total = $menuPrice * $quantity;
                    $totalFormat = number_format($total, 2);

                    ?>

                    <table border="0" width="50%" class="tableCart">
                        <td class="td1">
                            <img src="image/<?php echo $menuImage; ?>" class="imgItem">
                        </td>

                        <td class="td2">
                            <p class="font">
                                <?php echo $menuName; ?>
                            </p>
                            <p class="greyFont">Type :
                                <?php echo $menuType; ?>
                            </p>
                            <p class="greyFont">Quantity :
                                <?php echo $quantity; ?>
                            </p>
                        </td>

                        <td>
                            <p class="greyFont1">Price</p>
                            <p class="price">RM
                                <?php echo $totalFormat; ?>
                            </p>
                        </td>

                        <td class="td1">
                            <form action="cartDelete.php" method="post">
                                <input type="hidden" name="menuID" value="<?php echo $menuID; ?>">
                                <button type="submit" name="Delete" class="remove" style="border: none; background: none; padding: 0;">
                                    <img src="image/delete.png" alt="Delete" class="remove" />
                                </button>
                            </form>

                        </td>
                    </table>

                    <?php
                }
                ?>

                <?php
            }
            ?>

        </body>

        </html>
        <?php
    }
} else {
    header("Location: Login.html");
}
?>