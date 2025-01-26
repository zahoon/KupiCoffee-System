<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store the address and delivery time in the session
    $_SESSION['order_method'] = 'pickup';
    $_SESSION['delivery_time'] = $_POST['pickup_time'];

    // Redirect to the receipt page
    header("Location: c_receipt.php");
    exit;
}
?>

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
            flex-direction: column;
            position: relative;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input[type="text"],
        input[type="time"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
        }

        .form-button {
            margin-top: 20px;
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
    <!-- Include Flatpickr CSS and JS for time picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
<?php include '../Homepage/header.php'; ?>

<form action="" method="post">
    <h1 style="font-size: 28px; font-weight: bold; color: #7a2005; text-decoration: underline;">Delivery Details</h1>

   

    <label for="delivery_time">Pickup Time:</label>
    <input type="time" id="pickup_time" name="pickup_time" required>

    <!-- Submit button -->
    <button type="submit" class="form-button">Submit</button>
</form>

<script>
    // Initialize Flatpickr for the time picker
    flatpickr("#pickup_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: false,
        minTime: "10:00",
        maxTime: "20:00",
        defaultDate: "11:00", // Default time
    });
</script>

</body>
</html>