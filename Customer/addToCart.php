<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kupi Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-image: url(../image/KupiOrder.png);
            background-size: cover;
            color: #444;
        }

        h1 {
            color: #7a2005;
            font-size: 28px;
            text-align: center;
            margin-bottom: 10px;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        select {
            width: 100%;
            padding: 15px; /* Increased size */
            font-size: 18px; /* Increased size */
            border: 5px solid rgb(255, 179, 214);
            border-radius: 5px;
        }

        .form-button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 30px;
            font-size: 16px;
            font-weight: bold;
            background-color: #7a2005;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-button:hover {
            background-color: rgb(255, 225, 0);
        }

        /* Media Query for Responsive Design */
        @media (max-width: 480px) {
            form {
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }

            select {
                font-size: 16px; /* Adjusted size for smaller screens */
                padding: 12px; /* Adjusted size for smaller screens */
            }

            .form-button {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
<?php include '../Homepage/header.php'; ?>
<h1 style="font-size: 35px; font-weight: bold; color: #7a2005; margin-top: 20px;">Customize Your Order</h1>

<form action="addToCat.php" method="post">
<h1 style="font-size: 28px; font-weight: bold; color: #7a2005; margin-: 0px; text-decoration: underline;">Nesloo</h1>

    <label for="milk">Select Milk:</label>
    <select id="milk" name="milk">
        <option value="Oat Milk">Oat Milk</option>
        <option value="Dairy Milk">Dairy Milk</option>
        <option value="Full Cream Milk">Full Cream Milk</option>
        <option value="Low Fat Milk">Low Fat Milk</option>
        <option value="Coconut Milk">Coconut Milk</option>
    </select>

    <label for="type">Select Type:</label>
    <select id="type" name="type">
        <option value="Boss">Boss</option>
        <option value="Lydia">Lydia</option>
    </select>

    <label for="size">Select Size:</label>
    <select id="size" name="size">
        <option value="Small">Small</option>
        <option value="Medium">Medium</option>
        <option value="Large">Large</option>
    </select>

    <label for="cream">Cream Preference:</label>
    <select id="cream" name="cream">
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>

    <label for="temperature">Select Temperature:</label>
    <select id="temperature" name="temperature">
        <option value="Hot">Hot</option>
        <option value="Cold">Cold</option>
    </select>

    <button onclick="window.location.href='../Customer/Menu.php';" type="button" class="form-button">Add to Cart</button>
</form>

</body>
</html>
