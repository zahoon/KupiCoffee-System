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
        $customerphonenumber = $r['custPhoneNumber'];
        $customeraddress = $r['custAddress'];
        $customerpassword = $r['custPassword'];
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <link rel="stylesheet" href="/addtocart.css">
        </head>

        <body>

            <?php
            include("dbconn.php");

            // Fetch the item records from the database
            $query = "SELECT * FROM cart WHERE CUSTOMER_USERNAME = '$customerusername'";
            $result = mysqli_query($dbconn, $query);

            $quantityItem = 0;
            $totalPrice = 0.00;

            // Iterate over the records and generate table columns dynamically
            while ($row = mysqli_fetch_assoc($result)) {
                $productid = $row['PRODUCT_ID'];
                $quantity = $row['QUANTITY'];

                $query2 = "SELECT * FROM product WHERE PRODUCT_ID = '$productid'";
                $result2 = mysqli_query($dbconn, $query2);

                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $productprice = $row2['PRODUCT_PRICE'];

                    $quantityItem += $quantity;

                    $total = $productprice * $quantity;
                    $totalPrice += $total;
                    $totalPriceFormat = number_format($totalPrice, 2);

                }
            }

            $nofees = $totalPrice - 5;
            $nofeesFormat = number_format($nofees, 2);

            // Check if items exist in the cart table
            $cartQuery = "SELECT * FROM cart WHERE CUSTOMER_USERNAME = '$customerusername'";
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

            <a
                href="payment.php?price=<?php echo $totalPriceFormat; ?>&service=<?php echo $service; ?>&branch=<?php echo $branch; ?>">
                <button class="button1">
                    Proceed To Checkout
                </button>
            </a>
            <a href="menu.php">
                <button class="button2">Continue Shopping</button>
            </a>
            <form action="cartDelete.php" method="post">
                <button class="button3" type="submit" name="DeleteAll">Remove All</button>
            </form>


            <?php
            include("dbconn.php");

            // Fetch the item records from the database
            $query = "SELECT * FROM cart WHERE custUsername = '$customerusername'";
            $result = mysqli_query($dbconn, $query);

            // Iterate over the records and generate table columns dynamically
            while ($row = mysqli_fetch_assoc($result)) {
                $menuID = $row['menuID'];
                $quantity = $row['quantity'];

                $query2 = "SELECT * FROM menu WHERE menuID = '$menuID'";
                $result2 = mysqli_query($dbconn, $query2);

                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $menuName = $row2['PRODUCT_NAME'];
                    $menuType = $row2['PRODUCT_TYPE'];
                    $menuPrice = $row2['PRODUCT_PRICE'];
                    $menuImage = $row2['PRODUCT_IMAGE'];

                    $total = $menuPrice * $quantity;
                    $totalFormat = number_format($total, 2);

                    ?>

                    <table border="0" width="50%" class="tableCart">
                        <td class="td1">
                            <img src="menu/<?php echo $menuImage; ?>" class="imgItem">
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
                                <input type="hidden" name="product_id" value="<?php echo $productid; ?>">
                                <button type="submit" name="Delete" class="remove" style="border: none; background: none; padding: 0;">
                                    <img src="image/remove.png" alt="Delete" class="remove" />
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
    header("Location: login.html");
}
?>