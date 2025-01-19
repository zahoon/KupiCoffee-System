<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: rgb(255, 206, 223);
            background-size: cover;
            padding-top: 70px;
        }

        .container {
            display: inline-block; /* Shrink-wrap to fit content */
            margin: 20px auto; 
            padding: 20px;
            background-color: rgb(255, 206, 223);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

        .order {
            max-width: 600px; 
            margin: 15px auto; 
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: rgb(255, 253, 159);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex; /* Use flexbox for layout */
            align-items: center; /* Center image and text vertically */
            gap: 15px; /* Add spacing between image and text */
        }

        .order img {
            width: 150px; /* Set a fixed width for the image */
            height: auto; 
            object-fit: cover; /* Ensure image fits nicely within bounds */
            border-radius: 8px;
        }

        .order .details {
            text-align: left;
            flex-grow: 1; /* Allow text to take up remaining space */
        }

        .order strong {
            font-size: 20px;
            color: #7a2005;
            display: block; /* Ensure it starts a new line */
            margin-bottom: 10px;
        }

        .order .details p {
            margin: 5px 0;
            font-size: 16px;
            font-weight: bold;
        }

        /* Floating Button */
        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
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
    </style>
</head>
<body>

<?php include '../Homepage/header.php'; ?>

<div class="container">
    <h1  style = "font-size: 30px;
            font-weight: bold;
            color: #7a2005;
            margin-top: 20px;
            margin-bottom: 30px; 
            text-align: center;">Your Orders List</h1>

    <?php
    // Example orders
    $orders = [
        [
            'milk' => 'Almond Milk',
            'type' => 'Latte',
            'size' => 'Large',
            'cream' => 'Whipped Cream',
            'temperature' => 'Hot',
            'image' => '../image/SALTED_CARAMEL_FRAPPE.png'
        ],
        [
            'milk' => 'Whole Milk',
            'type' => 'Cappuccino',
            'size' => 'Medium',
            'cream' => 'No Cream',
            'temperature' => 'Warm',
            'image' => '../image/CHOCOOKIES.png'
        ],
        [
            'milk' => 'Soy Milk',
            'type' => 'Mocha',
            'size' => 'Small',
            'cream' => 'Extra Cream',
            'temperature' => 'Cold',
            'image' => '../image/YAM_MILK.png'
        ],
    ];
    ?>

    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $index => $order): ?>
            <div class="order">
                <img src="<?php echo htmlspecialchars($order['image']); ?>" alt="Order Image">
                <div class="details">
                    <strong>Order <?php echo $index + 1; ?></strong>
                    <p>Milk: <?php echo htmlspecialchars($order['milk']); ?></p>
                    <p>Type: <?php echo htmlspecialchars($order['type']); ?></p>
                    <p>Size: <?php echo htmlspecialchars($order['size']); ?></p>
                    <p>Cream: <?php echo htmlspecialchars($order['cream']); ?></p>
                    <p>Temperature: <?php echo htmlspecialchars($order['temperature']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-orders">No orders in cart.</p>
    <?php endif; ?>
</div>

<!-- Button -->
<button class="floating-button" onclick="window.location.href='../Customer/c_readyOrder.php';">Ready to Order</button>

</body>
</html>
