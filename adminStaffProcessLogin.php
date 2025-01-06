<!DOCTYPE html>
<html>
    <head>
        <style>
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
        #error-message button {
            width: 200px;
            height: 50px;
            background-color: #7a2005;
            border-radius: 25px;
            font-weight: bold;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            margin-top: 30px;
            margin-left: 305px;
            border: none;
            outline: none;
            transition: box-shadow 0.2s ease-in-out;
            animation: transitionIn 1s;
        }

        #error-message button:hover {
            box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
        }
        </style>
    </head>
</html>
<?php 
session_start();
//include dbconn
include("dbconn.php");
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM admin where adminUsername = '$username' AND adminPassword = '$password'";
    $q = mysqli_query($dbconn,$sql) or die ("Error : " . mysqli_error($dbconn));
    $r = mysqli_num_rows($q);
    if($r == 0){
        echo "<div id = 'completed'>
        <h1> Invalid Username or Password</h1>
        <a href= 'adminStaffLogin.php'>
            <button> Try again </button>
        </a>
        </div>
        <div id='cover' style='display:block'></div>";
    }else{
        $f = mysqli_fetch_assoc($q);
        $adminType = $f['adminType'];
        if($adminType == "ADMIN"){
            $_SESSION['username'] = $f['adminUsername'];
            header("Location: adminDash.php");
        }else if ($adminType =="STAFF"){
            $_SESSION['username'] = $f['adminUsername'];
            header("Location: staffDash.php");
        }
    }
}
mysqli_close($dbconn);
?>