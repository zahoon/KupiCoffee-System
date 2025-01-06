<?php
include("dbconn.php");
session_start();
if (isset($_SESSION['username'])) {
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Coffee File Upload</title>

        <style>
            body {
                background-color: #FFD700;
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

            .rounded-square {
                width: 500px;
                height: 750px;
                border-radius: 20px;
                background-color: rgb(255, 255, 255);
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
                margin-top: 150px;
                margin-left: 750px;
                animation: transitionIn 1s;
            }

            .rounded-textboxOne {
                border-radius: 10px;
                border-color: #00000053;
                height: 25px;
                width: 450px;
                margin-top: 10px;
                margin-left: 22px;
                animation: transitionIn 1s;
            }

            .req-text {
                color: rgba(0, 0, 0, 0.425);
                font-family: 'Poppins', sans-serif;
                font-size: 13px;
                font-weight: bold;
                margin-left: 30px;
                animation: transitionIn 1s;
            }

            .uploadButton {
                width: 90px;
                height: 40px;
                border-radius: 50px;
                background-color: #181444;
                margin-top: 10px;
                margin-left: 200px;
                justify-content: center;
                color: rgb(255, 255, 255);
                font-family: 'Poppins', sans-serif;
                font-size: 13px;
                font-weight: bold;
                animation: transitionIn 1s;
            }

            .text1 {
                color: #181444;
                font-family: 'Poppins', sans-serif;
                font-size: 30px;
                font-weight: bold;
                text-align: center;
                line-height: 50px;
                animation: transitionIn 1s;
            }

            .text2 {
                color: #181444;
                font-family: 'Poppins', sans-serif;
                font-size: 20px;
                font-weight: bold;
                animation: transitionIn 1s;
                margin-left: 50px;
                animation: transitionIn 1s;
            }

            .text3 {
                color: #181444;
                font-family: 'Poppins', sans-serif;
                font-size: 15px;
                font-weight: bold;
                animation: transitionIn 1s;
                margin-left: 10px;
            }

            input::placeholder {
                font-family: "Poppins", sans-serif;
                font-size: 14px;
                color: #999;
            }

            input[type="text"] {
                font-family: "Poppins", sans-serif;
                text-indent: 10px;
            }

            input[type="text"]:placeholder {
                text-indent: 10px;
            }
        </style>
    </head>

    <body>

        <div class="rounded-square">
            <p class="text1">Coffee File Upload</p>
            <form action="uploadCoffee.php" method="POST" enctype="multipart/form-data">
                <label for="file" class="text2">Select PNG file:</label>
                <input type="file" name="file" id="file" accept=".png" class="text3">

                <input type="text" placeholder="Product Name" class="rounded-textboxOne" name="coffeeName">
                <p class="req-text">Please insert the appropriate name for this coffee</p>

                <input type="text" placeholder="Product Price" class="rounded-textboxOne" name="coffeePrice">
                <p class="req-text">Please insert the appropriate price for this coffee</p>

                <select class="rounded-textboxOne" name="coffeeType">
                    <option value="COLD">COLD</option>
                    <option value="HOT">HOT</option>
                </select>
                <p class="req-text">Please select the coffee type</p>


                <select class="rounded-textboxOne" name="coffeeStatus">
                    <option value="AVAILABLE">AVAILABLE</option>
                    <option value="UNAVAILABLE">UNAVAILABLE</option>
                </select>
                <p class="req-text">Please select the product status</p>


                <input type="text" placeholder="Product Description" class="rounded-textboxOne" name="coffeeDesc">
                <p class="req-text">Please insert the appropriate description for this product</p>

                <input type="submit" name="submit" value="Upload" class="uploadButton">
            </form>
        </div>

    </body>

    </html>
    <?php

} else {
    header("Location: signinPage.php");
}
mysqli_close($dbconn);
?>