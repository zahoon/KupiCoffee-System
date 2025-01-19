<?php
require_once '../Homepage/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemId = $_POST['item_id'];
    $itemName = $_POST['item_name'];

    // Add the item to the cart
    addToCart($itemId, $itemName);

    // Redirect back to the menu or cart page
    header("Location: ../Customer/c.addToCart.php");
    exit();
}

function addToCart($itemId, $itemName) {
    // Implement your add to cart logic here
    // For example, you can store the cart items in the session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = ['id' => $itemId, 'name' => $itemName];
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
        if (!empty($_SESSION['cart'])) {
            $lastAddedItem = end($_SESSION['cart']);
            echo htmlspecialchars($lastAddedItem['name']);
        }
        ?>
    </h1>

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
        <option value="Hot">Hot</option>
        <option value="Cold">Cold</option>
    </select>

    <label for="size">Select Size:</label>
    <select id="size" name="size">
        <option value="Regular">Regular</option>
        <option value="Large">Large</option>
    </select>

    <label for="cream">WhimpedCream Preference:</label>
    <select id="cream" name="cream">
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>

    <label for="bean">Select Coffee Beans:</label>
    <select id="bean" name="bean">
        <option value="Bourbon">Bourbon</option>
        <option value="Geisha">Geisha</option>
        <option value="Arabica">Arabica</option>
        <option value="Typica">Typica</option>
        <option value="Robusta">Robusta</option>
        <option value="Liberica">Liberica</option>
        <option value="Excelsa">Excelsa</option>
    </select>

    <input type="hidden" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">

    <button type="submit" class="form-button">Add to Cart</button>
</form>

</body>
</html>