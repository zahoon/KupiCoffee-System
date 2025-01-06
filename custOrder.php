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
        $customerusername = $r['custUsername'];
        $customerphonenumber = $r['custPhoneNum'];
        $customeraddress = $r['custAddress'];
        $customerpassword = $r['custPassword'];
        ?>
        <<!DOCTYPE html>
        <html>

        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Customer Order</title>
            <style>
                body {
                    background-image: white;
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

                #cover {
                    position: fixed;
                    top: 0;
                    right: 0;
                    bottom: 0;
                    left: 0;
                    background-color: rgba(0, 0, 0, 0.8);
                    z-index: 99;
                }

                #profile {
                position: fixed;
                            top: 55%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                            border-radius: 45px;
                            width: 600px;
                            height: 800px;
                            background-color: #7a2005;
                            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
                            z-index: 100;
                }

                #profile h1 {
                    font-family: 'Poppins', sans-serif;
                    text-align: center;
                    color: #7a2005;
                    font-size: 25px;
                    animation: transitionIn 1s;
                }

                .greyFont {
                    font-family: 'Poppins', sans-serif;
                    font-size: 15px;
                    color: grey;
                    text-align: center;
                    line-height: 5px;
                    font-weight: none;
                    animation: transitionIn 1s;
                }

                #profile p:not(.greyFont) {
                    font-family: 'Poppins', sans-serif;
                    font-size: 20px;
                    color: white;
                    margin-left: 50px;
                    max-width: 500px;
                    line-height: 25px;
                    text-align: center;
                    font-weight: bold;
                    animation: transitionIn 1s;
                }

                .edit {
                    width: 100px;
                    height: 40px;
                    background-color: white;
                    border-radius: 20px;
                    font-weight: bold;
                    color: darkgoldenrod;
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    margin-top: 80px;
                    margin-left: 250px;
                    border: none;
                    outline: none;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                }

                .history {
                    width: 500px;
                    height: 50px;
                    background-color: #181444;
                    border-radius: 25px;
                    font-weight: bold;
                    color: white;
                    text-align: center;
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    margin-top: 5px;
                    margin-left: 50px;
                    border: none;
                    outline: none;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                }

                #profile button:not(.edit):not(.history) {
                    width: 100px;
                    height: 40px;
                    background-color: white;
                    border-radius: 20px;
                    font-weight: bold;
                    color: red;
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    margin-top: 10px;
                    margin-left: 250px;
                    border: none;
                    outline: none;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                }

                #profile button:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .imgThree {
                    width: 150px;
                    height: 150px;
                    margin-top: 10px;
                    margin-left: 225px;
                    animation: transitionIn 1s;
                }

                #profile img:not(.imgThree) {
                    position: absolute;
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    margin-top: 15px;
                    margin-left: 10px;
                    rotate: 180deg;
                    transition: box-shadow 0.2s ease-in-out;
                }

                #profile img:hover:not(.imgThree) {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .solid-box {
                    background-color: #FFD700;
                    height: 100px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 0 20px;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    z-index: 100;
                    transition: background-color 0.3s ease;
                }

                .solid-box.scrolled {
                    background-color: #7a2005;
                }

                .logo {
                    color:#7a2005;
                    text-decoration: none;
                    transition: background-color 0.3s ease;
                    padding: 10px 20px;
                    font-size: 60px;
                    font-family: Bedrock;
                    font-weight: bold;
                }

                .nav-buttons {
                    display: flex;
                    gap: 20px;
                }

                .home-button,
                .menu-button,
                .login-button,
                #cart-button {
                    color:  #7a2005;
                    text-decoration: none;
                    padding: 10px 20px;
                    transition: background-color 0.3s ease;
                    font-size: larger;
                    font-weight: bold;
                    margin-right: 50px;
                    text-transform: uppercase;
                }

                .home-button:hover,
                .menu-button:hover,
                .login-button:hover {
                    background-color: #ffffff;
                }

                #customerdata {
                    position: fixed;
                    top: 25%;
                    left: 25%;
                    transform: translate(-50%, -50%);
                    border-radius: 25px;
                    width: 1600px;
                    height: 800px;
                    margin-top: 300px;
                    margin-left: 500px;
                    background-color: #7a2005;
                    z-index: 99;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
                }

                #customerdata h1 {
                    font-family: 'Poppins', sans-serif;
                    text-align: center;
                    color: yellow;
                    font-size: 50px;
                    margin-top: 20px;
                    animation: transitionIn 1s;
                    background-color: #7a2005;
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
                    background-color: yellow;
                    border-radius: 25px;
                    font-weight: bold;
                    color: white;
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

                .ordertable {
                    height: 70px;
                    width: 1500px;
                    margin-left: 50px;
                    border-collapse: collapse;
                    animation: transitionIn 1s;
                }

                .ordertable th {
                    font-family: 'Poppins', sans-serif;
                    font-weight: bold;
                    color: white;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .ordertable td.pending {
                    font-family: 'Poppins', sans-serif;
                    font-size: 17px;
                    color: red;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .ordertable td.ready {
                    font-family: 'Poppins', sans-serif;
                    font-size: 17px;
                    color: green;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .ordertable td.pending {
                    font-family: 'Poppins', sans-serif;
                    font-size: 17px;
                    color: orange;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .ordertable td.ready {
                    font-family: 'Poppins', sans-serif;
                    font-size: 17px;
                    color: green;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .ordertable td.cancel {
                    font-family: 'Poppins', sans-serif;
                    font-size: 17px;
                    color: red;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .ordertable tr {
                    font-family: 'Poppins', sans-serif;
                    color: #181444;
                    text-align: center;
                    animation: transitionIn 1s;
                }

                .ordertable a {
                    color: #181444;
                    text-align: center;
                    text-decoration: none;
                    font-weight: bold;
                    animation: transitionIn 1s;
                }

                a:visited {
                    color: #181444;
                    text-decoration: none;
                }
            </style>
            <script>
                function showProfile() {
                    document.getElementById("profile").style.display = "block";
                    document.getElementById("cover").style.display = "block";
                }
                function closeProfile() {
                    document.getElementById("profile").style.display = "none";
                    document.getElementById("cover").style.display = "none";
                }
            </script>
            <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
        </head>

        <body>

        <div class="solid-box">
        <a href="HomeCust.php" class="logo">COFFEE FOR GO!!</a>
        <div class="nav-buttons">
        <a href="HomeCust.php" class="home-button">Home</a>
        <a href="MenuCust.php" class="menu-button">Menu</a>
        <a class="login-button" onclick="showProfile()">PROFILE (
        <?php echo $_SESSION['username']; ?>)
        </a>
        </div>
        </div>

            <div id='customerdata'>
                <h1>My Order</h1>
                <table class="ordertable">
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Order Status</th>
                        <th>Staff ID</th>
                        <th>Services</th>
                        <th>Receipt</th>
                    </tr>

                    <?php
                    include("dbconn.php");
                    /* execute SQL statement */
                    $username = $_SESSION['username'];
                    $sql = "SELECT * FROM orders WHERE custUsername= '$username'";
                    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error());

                    while ($r = mysqli_fetch_assoc($query)) {
                        $orderID = $r['orderID'];
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
                                <a href="receipt.php?orderID=<?php echo $orderID; ?>&orderType=<?php echo $orderType; ?>">
                                    View
                                </a>
                            </td>
                        </tr>

                        <?php
                    }
                    ?>

                </table>
            </div>

            <div id='profile' hidden>
                <img onclick="closeProfile()" src="image/blackArrow.png">
                <h1>My Profile</h1>
                <img src="image/profile.png" class="imgThree">
                <p class="greyFont">Username</p>
                <p>
                    <?php echo $customerusername; ?>
                </p>
                <p class="greyFont">Phone Number</p>
                <p>
                    <?php echo $customerphonenumber; ?>
                </p>
                <p class="greyFont">Address</p>
                <p>
                    <?php echo $customeraddress; ?>
                </p><br>
                <p class="greyFont">Dashboard</p>
                <a href="custOrder.php">
                    <button class="history">Order History</button>
                </a>
                <a href="custEdit.php">
                    <button class="edit">Edit Profile</button>
                </a>
                <a href="logout.php">
                    <button>Logout</button>
                </a>
            </div>
            <div id='cover' style='display:none'></div>
        </body>

        </html>

        <?php
    }

    } else {
    header("Location: signinPage.php");
    }
    ?>