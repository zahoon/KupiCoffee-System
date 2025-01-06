<!DOCTYPE html>
<html lang="en">
<head>
    <!-- 
        IZZUDDIN NANTI BETULKAN CSS NI AKU COPY IZZAT JE
-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        // function showCompleted() {
        //     document.getElementById("completed").style.display = "block";
        //     document.getElementById("cover").style.display = "block";
        // }
        function showAlert(message){
            var alert = new window.alert();

            // Set the message of the alert.
            alert.message = message;

            // Display the alert.
            alert.show();
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

        #error-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 25px;
            width: 800px;
            height: 680px;
            margin-top: 15px;
            background-color: #FFD700;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        #error-message h1 {
            text-align: center;
            color: red;
            font-size: 70px;
            margin-top: 200px;
            animation: transitionIn 1s;
        }

        #error-message p {
            font-family: 'Poppins', sans-serif;
            font-size: 40px;
            color: black;
            text-align: center;
            font-weight: bold;
            animation: transitionIn 1s;
        }
    </style>
</head>
<body>
    
</body>
</html>
<?php
include("dbconn.php");
if(isset($_POST['submit'])){      
    function generatecustID(){
        // Generate random number between 1 and 1000000;

        $custID = rand(1,1000000);

        return $custID;
    }
    //capture value from html form or registerPage.php
    $custID = generatecustID();
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNum'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $confirm_password = $_POST['confirm-password'];
    $custStatus = "ACTIVE";
    //encrpytion
    $hash = password_hash($password, PASSWORD_DEFAULT);
    if ($password !== $confirm_password) {
        // The passwords are not the same, so display an error message
         //ni pon boleh design untuk popup
        //echo "<script>alert('The passwords do not match. Please try again.');</script>";
        echo '<script>
                        window.location.href = "./Login.html";
                        alert("Username already exist")
                    </script>'; 
        exit();
    }
    // check if password contains uppercase and special letter
    if (preg_match('/[A-Z]/', $password) === 0 && preg_match('/[^a-zA-Z0-9]/', $password) === 0 && strlen($password) < 8) {
        echo '<script>
                        window.location.href = "./Login.html";
                        alert("The password must contain at least one uppercase letter and one special character.")
                    </script>'; 
        exit();
    }
    $sql = "SELECT custUsername FROM customer WHERE custUsername = '$username'";
    $query = mysqli_query($dbconn,$sql) or die ("Error : ".mysqli_error($dbconn));
    $row0 = mysqli_num_rows($query);
    if($row0 != 0){
        echo '<script>
                        window.location.href = "./Login.html";
                        alert("Username already exist")
                    </script>';
    }else {
        // execute SQL INSERT command 
        $sql1 = "INSERT INTO customer (custID , custUsername, custPassword,custPhoneNum,custEmail,custAddress,custStatus) 
    VALUES ('".$custID."', '".$username. " ','" . $password. "', '". $phoneNum. "','".$email."','".$address."','".$custStatus."')";
        mysqli_query($dbconn,$sql1) or die ("Error: " .mysqli_error($dbconn));
        //display message (@Udini please check)
        echo "<div id ='completed'>
        <h1> Congratulations ! </h1>
        <p> Account Created Successfully ! </p>
        <a href ='index.html'>
            <button>Back to home </button>
        </a>
    </div>
    <div id = 'cover' style = 'display:block'</div>";
    }
}
mysqli_close($dbconn);
?>