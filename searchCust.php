<?php
include("dbconn.php");
session_start();
if(isset($_SESSION['username'])){
    $custUsername = $_SESSION['username'];
    ?>
<!DOCTYPE html>
    <html>

    <head>
        <title>Customer Search </title>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>

<style>
            .rounded-square{
                background-color: yellow;
                text-align: center;
                width: 100%;
                animation: transitionIn 1s;

            }
            .form{
                position: center;
                width: fit-content;
                margin-left: 800px;
            }
            .text1{
                font-weight: bold;
                font-size: 40px;
            }
            #customerorder{
                background-color: #7a2005;
                height: 800px;
                width: 100%;
            }
            .header{
                text-align: center;
                color: white;
            }
            .tableCustomerOrder{
                margin-left: 150px;
                background-color: yellow;
                width: 1600px;
                border-radius: 25px;
                border: 1;
                border-color: black;
                z-index: 100;
            }
            .close{
                width: 100px;
                height: 50px;
                background-color: #7a2005;
                border-radius: 25px;
                font-weight: bold;
                color: #FFD700;
                font-family: 'Poppins', sans-serif;
                font-size: 16px;
                margin-top: 30px;
                margin-left: 870px;
                transition: box-shadow 0.2s ease-in-out;
                animation: transitionIn 1s;
            }
            .close:hover {
                box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
            }

            
        </style>
    </head>

    <body>
        
        <div class="rounded-square">
            <div class="form">
            <p class="text1">Customer Search</p>
            <form method="POST">
                    <input class="text" type="text" name="search">
                    <input class="submit" type="submit" name="submit" value="Search">
                    <input class="reset" type="reset" value="Reset" onclick="window.location.href='searchCust.php'">
                </form>
            </div>
            
        </div>
        <div id="customerorder">
                <h1 class="header">Customer Details</h1>
                <table border="1" class="tableCustomerOrder">
                    <tr>
                        <th>Customer Name</th>
                        <th>Customer Phone Number</th>
                        <th>Customer Email</th>
                        <th>Customer Address</th>
                    </tr>

                    <?php
                    /* execute SQL statement */
                    $q = "SELECT * FROM customer";
                    if(isset($_POST["submit"])){
                        $search = $_POST["search"];
                        $q = "SELECT * FROM customer where custUsername LIKE '%$search%'";
                    }
                    $result = mysqli_query($dbconn,$q);
                    while ($r = mysqli_fetch_assoc($result)) {
                        $custUsername = $r['custUsername'];
                        $custPhoneNum = $r['custPhoneNum'];
                        $custEmail = $r['custEmail'];
                        $custAddress = $r['custAddress'];
                        ?>

                        <tr>
                            <td>
                                <?php echo $custUsername; ?>
                            </td>
                            <td>
                                <?php echo $custPhoneNum; ?>
                            </td>
                            <td>
                                <?php echo $custEmail; ?>
                            </td>
                            <td>
                                <?php echo $custAddress; ?>
                            </td>
                        </tr>

                        <?php
                    }
                    ?>
                </table>
                <button class="close" onclick="window.location.href='adminDash.php'">Close</button>
            </div>

    </body>

    </html>
    <?php

} else {
    header("Location: Login.html");
}
mysqli_close($dbconn);
?>