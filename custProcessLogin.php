<!DOCTYPE html>
<html>

<head>
    <script>
        function showCompleted() {
            document.getElementById("completed").style.display = "block";
            document.getElementById("cover").style.display = "block";
        }
    </script>
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

    </style>
</head>

<body>
</body>

</html>
<?php
session_start();
//include dbconn
include ("dbconn.php");
if(isset($_POST['login'])){
    //capture from HTML from
    $username = $_POST['username'];
    //$email = $_POST['email'];
    $password = $_POST['password'];
    if($username == "staff" && $password == "staff"){
        header("Location: adminStaffLogin.php");
    }else{
        //exec sql command
        $sql = "SELECT * FROM customer WHERE custUsername= '$username' AND custPassword= '$password'";
        $query = mysqli_query($dbconn , $sql) or die ("Error : ".mysqli_error($dbconn));
        $row = mysqli_num_rows($query);
        $r = mysqli_fetch_assoc($query);
        // $status = $r['custStatus'];
        if($row == 0){
            echo "<div id='completed'>
                <h1>Oh No!</h1>
                <p>Invalid Username or Password!</p>
                <a href='Login.html'>
                    <button>Try Again</button>
                </a>
            </div>
            <div id='cover' style='display:block'></div>";
            }else if($status == 'DEACTIVATED'){
                echo "<div id='completed'>
                <h1>Oh No!</h1>
                <p>Invalid Username or Password!</p>
                <a href='Login.html'>
                    <button>Try Again</button>
                </a>
            </div>
            <div id='cover' style='display:block'></div>";
            }else{
                $_SESSION['username'] = $r['custUsername'];
                header("Location:HomeCust.php");
            }
        
    }
}
mysqli_close($dbconn);
?>
