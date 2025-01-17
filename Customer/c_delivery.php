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
            background-image: url(../image/bgDel.png);
            background-size: cover;
            color: #444;
            padding-top: 70px;
        }

        h1 {
            color: #7a2005;
            font-size: 28px;
            text-align: center;
            margin-bottom: 20px;
            text-decoration: underline;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 50px auto;
            display: flex;
            flex-direction: column; /* Allows proper layout for details and button */
            position: relative;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        .info {
            padding: 10px;
            font-size: 16px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: auto;
            margin-bottom: 10px;
        }

        .form-button {
            margin-top: 100; /* Pushes the button to the bottom */
            align-self: flex-end; /* Aligns the button to the right */
            padding: 10px 20px;
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

        @media (max-width: 480px) {
            h1 {
                font-size: 24px;
            }

            .form-button {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
<?php include '../Homepage/header.php'; ?>

<form action="addToCat.php" method="post">
    <h1 style="font-size: 28px; font-weight: bold; color: #7a2005; margin-: 0px; text-decoration: underline;">Delivery Details</h1>

    <label for="date">Date:</label>
    <div id="date" class="info">
        <?php echo date("Y-m-d"); // Auto-retrieved current date ?>
    </div>

    <label for="time">Time:</label>
    <div id="time" class="info">
        <?php echo date("H:i"); // Auto-retrieved current time ?>
    </div>

    <label for="address">Address:</label>
    <div id="address" class="info">
        <?php echo isset($_SESSION['address']) ? $_SESSION['address'] : 'No address available'; ?>
    </div>

    <label for="status">Status:</label>
    <div style= "margin-bottom: 30px"; id="status" class="info">
        <?php echo isset($_SESSION['status']) ? $_SESSION['status'] : 'Pending'; ?>
    </div>

    <!-- Button positioned at the bottom-right of the form -->
    <button onclick="window.location.href='../Homepage/menu.php';" type="button" class="form-button">OK</button>
</form>

</body>
</html>
