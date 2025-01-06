<!DOCTYPE html>
<html>

<head>
    <script>
        function showCompleted() {
            document.getElementById("completed").style.display = "block";
            document.getElementById("cover").style.display = "block";
        }

        function goBack() {
            window.history.back();
        }
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

        #completed {
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

        #completed {
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

        #completed h1 {
            text-align: center;
            color: black;
            font-size: 70px;
            margin-top: 200px;
            animation: transitionIn 1s;
        }

        #completed p {
            font-family: 'Poppins', sans-serif;
            font-size: 40px;
            color: white;
            text-align: center;
            font-weight: bold;
            animation: transitionIn 1s;
        }

        #completed button {
            width: 200px;
            height: 50px;
            background-color: #181444;
            border-radius: 25px;
            font-weight: bold;
            color: black;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            margin-top: 30px;
            margin-left: 305px;
            border: none;
            outline: none;
            transition: box-shadow 0.2s ease-in-out;
            animation: transitionIn 1s;
        }

        #completed button:hover {
            box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
        }

    </style>
</head>

<body>
</body>

</html>

<?php
/* include db connection file */
include("dbconn.php");
session_start();
$username = $_SESSION['username'];
if (isset($_POST['Update'])) {
    /* capture values from HTML form */
    $custPhonenNum = $_POST['phonenumber'];
    $custAddress = $_POST['address'];
    $custPassword = $_POST['password'];

    // Check if any of the textboxes are empty
    if (empty($custPhonenNum) || empty($custAddress) || empty($custPassword)) {
        echo "<div id='completed'>
        <h1>Oh No!</h1>
        <p>Please fill in all the fields!</p>
            <button onclick='goBack()'>Try Again</button>
    </div>
    <div id='cover' style='display:block'></div>";
        exit;
    }

    // Validate password
    if (
        strlen($custPassword) < 8 || strlen($custPassword) > 25 ||
        !preg_match("/[a-z]/", $custPassword) || // Check for lowercase letter
        !preg_match("/[A-Z]/", $custPassword) || // Check for uppercase letter
        !preg_match("/[0-9]/", $custPassword) || // Check for digit
        !preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $custPassword) // Check for special character
    ) {
        echo "<div id='completed'>
        <h1>Oh No!</h1>
        <p>Your password does not meet the requirements!</p>
            <button onclick='goBack()'>Try Again</button>
    </div>
    <div id='cover' style='display:block'></div>";
        exit;
    }

    $hashedPassword = password_hash($custPassword, PASSWORD_DEFAULT);

    $sql0 = "SELECT custUsername FROM customer WHERE custUsername= '$username'";
    $query0 = mysqli_query($dbconn, $sql0) or die("Error: " . mysqli_error($dbconn));
    $row0 = mysqli_num_rows($query0);
    if ($row0 == 0) {
        echo "<div id='completed'>
        <h1>Oh No!</h1>
        <p>The Username is already taken!</p>
        <a href='registerCust.php'>
            <button>Back</button>
        </a>
    </div>
    <div id='cover' style='display:block'></div>";
    } else {
        /* execute SQL UPDATE command */
        $sql2 = "UPDATE customer SET custPhoneNum = '" . $custPhonenNum . "',
	custAddress= '" . $custAddress . "',
	custPassword = '" . $hashedPassword . "' where custUsername = '" . $username . "'";

        mysqli_query($dbconn, $sql2) or die("Error: " . mysqli_error($dbconn));

        /* display a message */
        echo "<div id='completed'>
        <h1>Congratulations!</h1>
        <p>Account Updated Succesfully!</p>
        <a href='HomeCust.php'>
            <button>Back</button>
        </a>
    </div>
    <div id='cover' style='display:block'></div>";
    }
} elseif (isset($_POST['Delete'])) {

    $sql0 = "SELECT *  FROM customer WHERE custUsername= '$username'";

    $query0 = mysqli_query($dbconn, $sql0) or die("Error: " . mysqli_error($dbconn));
    $row0 = mysqli_num_rows($query0);
    if ($row0 == 0) {
        echo "Record is not existed";
    } else {
        /* execute SQL DELETE command */
        $sql2 = "UPDATE customer SET custStatus = 'DEACTIVATED' WHERE custUsername= '$username'";

        mysqli_query($dbconn, $sql2) or die("Error: " . mysqli_error($dbconn));

        /* display a message */
        echo "<div id='completed'>
        <h1>Congratulation!</h1>
        <p>Account Deleted Succesfully!</p>
        <a href='index.html'>
            <button>Back</button>
        </a>
    </div>
    <div id='cover' style='display:block'></div>";
    }
}

// close if isset()
/* close db connection */
mysqli_close($dbconn);

?>