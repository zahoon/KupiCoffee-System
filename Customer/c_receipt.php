<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['custid'])) {
    header("Location: ../Customer/c.login.php");
    exit;
}

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: c.inCart.php");
    exit;
}

// Retrieve order method and address from the session
$orderMethod = $_SESSION['order_method'] ?? 'pickup';
$address = isset($_SESSION['address']) ? $_SESSION['address'] : 'No address available';

// Calculate the total amount
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * ($item['quantity'] ?? 1);
}

// Add delivery fee if applicable
$deliveryFee = ($orderMethod === 'delivery') ? 5.00 : 0.00;
$total += $deliveryFee;

// Calculate VAT (10%) and discount (10%)
$vat = $total * 0.10;
$discount = $total * 0.10;
$finalTotal = $total + $vat - $discount;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(255, 206, 223);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding-top: 70px;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px; /* Increased width to accommodate more columns */
            width: 90%;
            text-align: center;
        }

        h1 {
            color: #7a2005;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .invoice-details {
            text-align: left;
            margin-bottom: 20px;
        }

        .invoice-details p {
            margin: 5px 0;
            font-size: 16px;
        }

        .invoice-details strong {
            font-size: 18px;
            color: #7a2005;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #7a2005;
            color: white;
        }

        .total-details {
            text-align: right;
            margin-bottom: 20px;
        }

        .total-details p {
            margin: 5px 0;
            font-size: 16px;
        }

        .total-details strong {
            font-size: 18px;
            color: #7a2005;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #7a2005;
        }

        .form-button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
            background-color: #7a2005;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-button:hover {
            background-color: #ffb300;
        }
    </style>
</head>
<body>

<?php include '../Homepage/header.php'; ?>

<div class="container">
    <h1>Order Receipt</h1>

    <div class="invoice-details">
        <strong>Receipt To:</strong>
        <p><?php echo htmlspecialchars($_SESSION['username'] ?? 'John Doe'); ?></p>
        <?php if ($orderMethod === 'delivery'): ?>
            <p><?php echo htmlspecialchars($address); ?></p>
        <?php endif; ?>
    </div>

    <div class="invoice-details">
        <strong>Date:</strong> <?php echo date('d/m/Y'); ?><br>
        <strong>Delivery Method:</strong> <?php echo ucfirst($orderMethod); ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>ITEM DESCRIPTION</th>
                <th>QTY</th>
                <th>PRICE</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td>
                        <?php
                        // Combine all customization options into one sentence
                        $description = htmlspecialchars($item['coffee_name']);
                        $description .= " " . htmlspecialchars($item['bean'] ?? 'N/A');
                        $description .= " " . htmlspecialchars($item['milk'] ?? 'N/A');
                        $description .= " " . htmlspecialchars($item['size'] ?? 'N/A');
                        $description .= " " . htmlspecialchars($item['temperature'] ?? 'N/A');

                        // Add whipped cream if selected
                        if (isset($item['cream']) && $item['cream'] === 'Yes') {
                            $description .= " (Whipped Cream)";
                        }
                        echo $description;
                        ?>
                    </td>
                    <td><?php echo $item['quantity'] ?? 1; ?></td>
                    <td>RM <?php echo number_format($item['price'] * ($item['quantity'] ?? 1), 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total-details">
        <p><strong>Sub Total:</strong> RM <?php echo number_format($total - $deliveryFee, 2); ?></p>
        <?php if ($orderMethod === 'delivery'): ?>
            <p><strong>Delivery Charges:</strong> RM <?php echo number_format($deliveryFee, 2); ?></p>
        <?php endif; ?>
        <p><strong>Total:</strong> RM <?php echo number_format($finalTotal, 2); ?></p>
    </div>

    <div class="footer">
        <p>1 000-0000-000</p>
        <p>www.kupicoffee.com</p>
        <p>cs@kupicoffee.com</p>
        <p>123, Raub Avenue, Negeri Tujuh</p>
    </div>

    <button class="form-button" onclick="window.location.href='../Customer/c_finalizeOrder.php';">Confirm Order</button>
</div>

</body>
</html>