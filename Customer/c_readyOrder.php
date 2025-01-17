<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ready Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url(../image/KupiOrder.png);
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        header {
            width: 100%;
            background-color: #7a2005;
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        h1 {
            font-size: 35px;
            font-weight: bold;
            color: #7a2005;
            margin: 50px 20px 30px; /* Added top margin for spacing */
            text-align: center;
            text-transform: capitalize; /* Text is properly capitalized */
            line-height: 1.5;
        }

        .container {
            display: flex;
            gap: 30px;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
            margin-top: 20px;
        }

        .box {
            width: 350px;
            height: auto;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.3s;
        }

        .box:hover {
            transform: scale(1.05);
            background-color: #ffe8f3;
        }

        .box img {
            width: 200%;
            height: auto;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .box p {
            margin: 20px 0;
            font-size: 22px;
            font-weight: bold;
            color: #7a2005;
        }

        .box a {
            display: block;
            width: 100%;
            height: 100%;
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php include '../Homepage/header.php'; ?>

<!-- Page Title -->
<h1 style = "font-size: 30px;
            font-weight: bold;
            color: #7a2005;
            margin-top: 60px;
            margin-bottom: 10px; 
            text-align: center;">Choose your preferred order method</h1>

<!-- Buttons Container -->
<div class="container">
    <!-- Delivery Button -->
    <div class="box">
        <a href="../Customer/c_delivery.php">
            <img src="../image/delivery.png" alt="Delivery">
            <p>Delivery</p>
        </a>
    </div>

    <!-- Pickup Button -->
    <div class="box">
        <a href="../Customer/c_pickup.php">
            <img src="../image/pickup.png" alt="Pickup">
            <p>Pickup</p>
        </a>
    </div>
</div>

</body>
</html>
