<?php
/* include db connection file*/
include("dbconn.php");
session_start();
if (isset($_SESSION['username'])) {

    $menuID= $_POST['menuID'];

    $sql = "SELECT * FROM menu WHERE menuID = $menuID";
    // Execute the SQL statement
    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error());

    $r = mysqli_fetch_assoc($query);
    $menuID = $r['menuID'];
    $menuPrice = $r['menuPrice'];
    $menuDesc = $r['menuDesc'];
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
                background-color: #FFD700;
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
                color: black;
                font-weight: bold;
                font-size: 50px;
                margin-top: 100px;
                margin-left: 100px;
                animation: transitionIn 1s;
                text-align: center;
            }

            .rounded-square {
                width: 600px;
                height: 500px;
                border-radius: 20px;
                background-color: rgb(255, 255, 255);
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
                margin-top: 60px;
                margin-left: 690px;
                animation: transitionIn 1s;
            }

            .rounded-square p:not(.white) {
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
                background-color: #7a2005;
                border-radius: 25px;
                font-weight: bold;
                color: white;
                font-family: 'Poppins', sans-serif;
                font-size: 16px;
                margin-top: 25px;
                margin-left: 250px;
                transition: box-shadow 0.2s ease-in-out;
                animation: transitionIn 1s;
            }

            .updateButton:hover {
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
                margin-left: 250px;
                transition: box-shadow 0.2s ease-in-out;
                animation: transitionIn 1s;
            }

            .backButton:hover {
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

            .bawah {
                margin-top: 50px;
            }

            .white {
                color: #7a2005;
            }
        </style>
    </head>

    <body>
        <p class="title">Edit Menu Information</p>
        <div class="rounded-square">
            <form name="form" method="post" action="menuEditProcess.php">
                <p class="white">t</p>
                <p class="bawah">Menu Price</p>
                <input class="rounded-textboxTwo" type="text" name="menuPrice" value="<?php echo $menuPrice; ?>"><br>

                <p>Menu Description</p>
                <input class="rounded-textboxOne" type="text" name="menuDesc" value="<?php echo $menuDesc; ?>"><br>
                <input type="hidden" name="menuID" value="<?php echo $menuID; ?>">
                <input class="updateButton" type="submit" name="Update" value="Update">
            </form>

            <button class="backButton" onclick="goBack()">Back</button>
        </div>
    </body>

    </html>
    <?php
}
mysqli_close($dbconn);
?>