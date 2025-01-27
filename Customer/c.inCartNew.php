<?php
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Function to update quantity
function updateQuantity($index, $quantity) {
    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;
    }
}

// Function to remove an item from the cart
function removeItem($index) {
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        // Reindex the array to avoid gaps
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

// Check if the form is submitted to update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_quantity'])) {
        $index = $_POST['index'];
        $quantity = (int)$_POST['quantity'];
        if ($quantity > 0) {
            updateQuantity($index, $quantity);
        }
    }
    // Check if the form is submitted to remove an item
    elseif (isset($_POST['remove_item'])) {
        $index = $_POST['index'];
        removeItem($index);
    }
    // Redirect to prevent form resubmission on refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> 
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: rgb(255, 206, 223);
    background-size: cover;
    min-height: 100vh; /* Ensure the body takes up the full viewport height */
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    padding-top: 70px; /* Adjust for the header */
}

.container {
    background-color: rgb(255, 206, 223);
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 1200px; /* Adjust the max-width as needed */
    width: 90%; /* Ensure it doesn't overflow on smaller screens */
    margin: 20px auto;
    text-align: center;
}

        h1 {
            font-size: 30px;
            font-weight: bold;
            color: #7a2005;
            margin-top: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .order-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .order {
            flex: 1 1 calc(50% - 20px);
            max-width: 500px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: rgb(255, 253, 159);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 40px;
        }

        .order img {
            width: 150px;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
        }

        .order .details {
            text-align: left;
            flex-grow: 1;
        }

        .order strong {
            font-size: 20px;
            color: #7a2005;
            display: block;
            margin-bottom: 10px;
        }

        .order .details p {
            margin: 5px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .order .actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            justify-content: center;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-right: 40px;
        }

        .quantity-form {
            /* display: flex; */
            align-items: center;
            gap: 10px;
        }

        .quantity-form input[type="number"] {
            width: 60px;
            padding: 5px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .quantity-form button {
            padding: 5px 10px;
            font-size: 14px;
            background-color: #7a2005;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .quantity-form button:hover {
            background-color: #ffb300;
        }

        .remove-button {
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
        }

        .remove-button:hover {
            background-color: #cc0000;
        }

        .total {
            font-size: 24px;
            font-weight: bold;
            color: #7a2005;
            margin-top: 20px;
        }

        .floating-button {
            position: fixed;
            bottom: 35px;
            right: 45%;
            background-color: #7a2005;
            color: white;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        .floating-button:hover {
            background-color: #ffb300;
        }

        .center {
            display: flex;
            justify-content: center;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include '../Homepage/header.php'; ?>

<div class="container">
    <h1 style="font-size: 30px; font-weight: bold; color: #7a2005; margin-top: 20px; margin-bottom: 30px; text-align: center;">Your Orders List</h1>

    <?php if (!empty($_SESSION['cart'])): ?>
        <div class="order-container">
            <?php
            $total = 0; // Initialize total
            foreach ($_SESSION['cart'] as $index => $order):
                // Calculate subtotal for each item
                $price = $order['price']; // Dynamic price from the session
                $quantity = $order['quantity'] ?? 1; // Default quantity is 1
                $subtotal = $price * $quantity;
                $total += $subtotal; // Add to total
            ?>
                <div class="order">
                    <div class="details">
                        <strong>Order <?php echo $index + 1; ?></strong>
                        <p>Coffee Name: <?php echo htmlspecialchars($order['coffee_name']); ?></p>
                        <p>Milk: <?php echo htmlspecialchars($order['milk']); ?></p>
                        <p>Temperature: <?php echo htmlspecialchars($order['temperature']); ?></p>
                        <p>Size: <?php echo htmlspecialchars($order['size']); ?></p>
                        <p>Cream: <?php echo htmlspecialchars($order['cream']); ?></p>
                        <p>Bean: <?php echo htmlspecialchars($order['bean']); ?></p>
                        <p>Date: <?php echo htmlspecialchars($order['date']); ?></p>
                        <p>Price: RM <?php echo number_format($price, 2); ?></p>
                        <p>Subtotal: RM <?php echo number_format($subtotal, 2); ?></p>
                    </div>
                    <div class="actions">
                        <!-- Update Quantity Form -->
                        <form class="quantity-form" method="post">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <label for="quantity">Quantity:</label><br><br>
                            <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1"><br><br>
                            <button type="submit" name="update_quantity">Update</button>
                        </form>
                        <!-- Remove Button -->
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <button type="submit" name="remove_item" class="remove-button">Remove</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="total">
            Total: RM <?php echo number_format($total, 2); ?>
        </div>
    <?php else: ?>
        <p class="no-orders">No orders in cart.</p>
    <?php endif; ?>
</div>

<?php if (!empty($_SESSION['cart'])): ?>
        <button class="floating-button" onclick="window.location.href='../Customer/c_readyOrder.php';">Ready to Order</button>
<?php endif; ?>

</body>
</html>