<!DOCTYPE html>
<html lang="en">

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['cart']); // Clear the cart after order submission
    echo "Thank you for your order!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Confirmed</h1>
    <p>Thank you for your purchase! Your order has been received.</p>
    <a href="Menu.php">Back to Menu</a>
</body>
</html>
