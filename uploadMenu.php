<?php
include("dbconn.php");
if (isset($_POST['submit'])) {

    function generateMenuID(){
        // Generate random number between 1 and 1000000;

        $menuID = rand(1,1000000);

        return $menuID;
    }

    $menuID = generateMenuID();
    $menuName = $_POST['menuName'];
    $menuPrice = $_POST['menuPrice'];
    $menuType = $_POST['menuType'];
    $menuStatus = $_POST['menuStatus'];
    $menuDesc = $_POST['menuDesc'];

    $targetDir = "coffeepastry/"; // Specify the desired location
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if the uploaded file is a PNG
    if ($fileType == "png") {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {

            $sql0 = "SELECT menuID FROM menu WHERE menuID= '$menuID'";
            $query0 = mysqli_query($dbconn, $sql0) or die("Error: " . mysqli_error($dbconn));
            $row0 = mysqli_num_rows($query0);
            if ($row0 != 0) {
                echo "Record is existed";
            } else {
                /* execute SQL INSERT command */
                $sql2 = "INSERT INTO menu (menuID,menuType, menuName , menuPrice, menuStatus, menuImage, menuDesc)
	VALUES ('" . $menuID . "', '" . $menuType . "', '" . $menuName . "', '" . $menuPrice . "', '" . $menuStatus . "', '" . $fileName . "', '" . $menuDesc . "')";
                mysqli_query($dbconn, $sql2) or die("Error: " . mysqli_error($dbconn));
                /* display a message */
                echo "<div id='completed'>
        <h1>Congratulation!</h1>
        <p>Product Inserted Succesfully!</p>
        <a href='adminDash.php'>
            <button>Close</button>
        </a>
    </div>
    <div id='cover' style='display:block'></div>";
            }
        } else {
            echo "<div id='error'>
        <h1>Oh No!</h1>
        <p>Error Inserting File!</p>
        <a href='addMenu.php'>
            <button>Close</button>
        </a>
    </div>
    <div id='cover' style='display:block'></div>";
        }
    } else {
        echo "<div id='png'>
        <h1>Oh No!</h1>
        <p>File must be PNG!</p>
        <a href='addMenu.php'>
            <button>Close</button>
        </a>
    </div>
    <div id='cover' style='display:block'></div>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <script>
        function showCompleted() {
            document.getElementById("completed").style.display = "block";
            document.getElementById("cover").style.display = "block";
        }

        function showError() {
            document.getElementById("error").style.display = "block";
            document.getElementById("cover").style.display = "block";
        }

        function showPng() {
            document.getElementById("png").style.display = "block";
            document.getElementById("cover").style.display = "block";
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

        #error {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 25px;
            width: 800px;
            height: 680px;
            margin-top: 15px;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        #error h1 {
            text-align: center;
            color: black;
            font-size: 70px;
            margin-top: 200px;
            animation: transitionIn 1s;
        }

        #error p {
            font-family: 'Poppins', sans-serif;
            font-size: 40px;
            color: #181444;
            text-align: center;
            font-weight: bold;
            animation: transitionIn 1s;
        }

        #error button {
            width: 200px;
            height: 50px;
            background-color: #181444;
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

        #error button:hover {
            box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
        }

        #error img {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin-left: 300px;
            animation: transitionIn 1s;
        }

        #png {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 25px;
            width: 800px;
            height: 680px;
            margin-top: 15px;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        #png h1 {
            text-align: center;
            color: #181444;
            font-size: 70px;
            margin-top: 200px;
            animation: transitionIn 1s;
        }

        #png p {
            font-family: 'Poppins', sans-serif;
            font-size: 40px;
            color: #181444;
            text-align: center;
            font-weight: bold;
            animation: transitionIn 1s;
        }

        #png button {
            width: 200px;
            height: 50px;
            background-color: #181444;
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

        #png button:hover {
            box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
        }

        #png img {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin-left: 300px;
            animation: transitionIn 1s;
        }
    </style>
</head>

<body>
</body>

</html>