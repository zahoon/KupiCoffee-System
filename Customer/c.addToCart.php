<?php
require_once("../Homepage/session.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the coffee name and ID from the form
    $itemId = $_POST['item_id'];
    $itemName = $_POST['item_name'];

    // Store the coffee name in the session for later use
    $_SESSION['current_coffee'] = [
        'id' => $itemId,
        'name' => $itemName
    ];

    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Your Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-image: url(../image/KupiOrder.png);
            background-size: cover;
            color: #444;
            padding-top: 70px;
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
            padding: 15px;
            font-size: 18px;
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

        @media (max-width: 480px) {
            form {
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }

            select {
                font-size: 16px;
                padding: 12px;
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

<form action="c_addToCart.php" method="post">
    <h1 style="font-size: 28px; font-weight: bold; color: #7a2005; margin: 0px; text-decoration: underline;">
        <?php
        if (!empty($_SESSION['current_coffee'])) {
            echo htmlspecialchars($_SESSION['current_coffee']['name']);
        }
        ?>
    </h1>

    <!-- Pass the coffee name as a hidden input -->
    <input type="hidden" name="coffee_name" value="<?php echo htmlspecialchars($_SESSION['current_coffee']['name'] ?? ''); ?>">

    <label for="milk">Select Milk:</label>
    <select id="milk" name="milk">
        <option value="Oat Milk">Oat Milk + RM1.00</option>
        <option value="Dairy Milk">Dairy Milk</option>
        <option value="Full Cream Milk">Full Cream Milk + RM0.75</option>
        <option value="Low Fat Milk">Low Fat Milk + RM 0.50</option>
        <option value="Coconut Milk">Coconut Milk + RM 1.25</option>
    </select>

    <label for="temperature">Select Temperature:</label>
    <select id="temperature" name="temperature">
        <option value="Hot">Hot</option>
        <option value="Warm">Warm</option>
        <option value="Cold">Cold + RM 0.50</option>
    </select>

    <label for="size">Select Size:</label>
    <select id="size" name="size">
        <option value="Regular">Regular</option>
        <option value="Large">Large + RM 1.50</option>
    </select>

    <label for="cream">Whipped Cream Preference:</label>
    <select id="cream" name="cream">
        <option value="Yes">Yes + RM 1.00</option>
        <option value="No">No</option>
    </select>

    <label for="bean">Select Coffee Beans:</label>
    <select id="bean" name="bean">
        <option value="Bourbon">Bourbon</option>
        <option value="Geisha">Geisha + RM 2.00</option>
        <option value="Arabica">Arabica + RM 0.50</option>
        <option value="Typica">Typica + RM 0.75</option>
        <option value="Robusta">Robusta + RM 0.50</option>
        <option value="Liberica">Liberica + RM 1.25</option>
        <option value="Excelsa">Excelsa + RM 1.00</option>
    </select>

    <input type="hidden" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">

    <button type="submit" class="form-button">Add to Cart</button>
</form>

</body>
</html>