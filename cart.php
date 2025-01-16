<!DOCTYPE html>
<html lang="en">

<?php
session_start();

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
</head>
<body>
    <h1>Your Cart</h1>
    <?php if (empty($cart)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($cart as $item): ?>
                <li>
                    <?php echo htmlspecialchars($item['name']); ?> - <?php echo htmlspecialchars($item['price']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <form action="KupiOrder.php" method="POST">
            <button type="submit">Proceed to Order</button>
        </form>
    <?php endif; ?>
</body>
</html>
