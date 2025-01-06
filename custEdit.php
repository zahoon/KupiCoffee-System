<?php
/* include db connection file*/
include("dbconn.php");
session_start();
if (isset($_SESSION['username'])) {
    /* capture student number */
    $custUsername = $_SESSION['username'];
    /* execute SQL statement */
    $sql = "SELECT * FROM customer WHERE custUsername= '$custUsername'";
    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
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
        <html>
        <head>
            <title>Edit Customer</title>
            <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">

            <script>
                function goBack() {
                    window.history.back();
                }
            </script>

            <style>
                body {
                    background-color: #7a2005;
                    height: 100px;
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

                .title {
                    font-family: 'Poppins', sans-serif;
                    color: yellow;
                    font-weight: bold;
                    font-size: 50px;
                    margin-top: 100px;
                    animation: transitionIn 1s;
                    text-align: center;
                }

                .rounded-square {
                    width: 600px;
                    height: 660px;
                    border-radius: 20px;
                    background-color: yellow;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
                    margin-top: 60px;
                    margin-left: 650px;
                    animation: transitionIn 1s;
                }

                .rounded-square p {
                    color: #7a2005;
                    font-family: 'Poppins', sans-serif;
                    margin-left: 55px;
                    padding: 20px;
                    font-weight: bold;
                    animation: transitionIn 1s;
                }

                .rounded-textboxOne {
                    border-radius: 10px;
                    border-color: #00000053;
                    height: 45px;
                    width: 450px;
                    margin-top: 0px;
                    margin-left: 70px;
                    animation: transitionIn 1s;
                }

                .rounded-textboxTwo {
                    border-radius: 10px;
                    border-color: #00000053;
                    height: 45px;
                    width: 450px;
                    margin-top: 0px;
                    margin-left: 70px;
                    animation: transitionIn 1s;
                }

                input[type="text"],
                input[type="password"] {
                    font-family: "Poppins", sans-serif;
                    text-indent: 10px;
                }

                input[type="text"],
                input[type="password"]::placeholder {
                    text-indent: 10px;
                }

                .updateButton {
                    width: 100px;
                    height: 50px;
                    background-color:#7a2005;
                    border-radius: 25px;
                    font-weight: bold;
                    color: white;
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    margin-left: 185px;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                }

                .updateButton:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .deleteButton {
                    width: 100px;
                    height: 50px;
                    background-color: #7a2005;
                    border-radius: 25px;
                    font-weight: bold;
                    color: white;
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                }

                .deleteButton:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .backButton {
                    width: 100px;
                    height: 50px;
                    background-color: #7a2005;
                    border-radius: 25px;
                    font-weight: bold;
                    color: white;
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                    margin-left: 235px;
                }

                .backButton:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .req-text {
                    color: rgba(0, 0, 0, 0.425);
                    font-family: 'Poppins', sans-serif;
                    font-size: 13px;
                    font-weight: bold;
                    margin-left: 30px;
                    animation: transitionIn 1s;
                    max-width: 460px
                }
            </style>
        </head>
        </html>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
             <body>

            <p class="title">Edit Profile Information</p>
            <div class="rounded-square">
                <form name="form" method="POST" action="custProfileEdit.php">
                    <p>Phone Number</p>
                    <input class="rounded-textboxTwo" type="text" name="phonenumber"
                        value="<?php echo $custPhoneNum; ?>"><br>
                    <p>Address</p>
                    <input class="rounded-textboxOne" type="text" name="address" value="<?php echo $custAddress; ?>"><br>
                    <p>Password</p>
                    <input class="rounded-textboxOne" type="password" name="password" value=""><br>
                    <p class="req-text">Create a new password 8 to 25 characters long that includes at least 1 uppercase and 1
                        lowercase
                        letter, 1 number and 1 special character like an exclamation point or asterisk.</p>
                    <input class="updateButton" type="submit" name="Update" value="Update">
                    <input class="deleteButton" type="submit" name="Delete" value="Delete">
                </form>
                <a href="HomeCust.php">
                    <button class="backButton">Back</button>
                </a>
            </div>
        </body>

        </html>
        <?php
    }
} else {
    header("Location: Login.html");
}
mysqli_close($dbconn);
?>