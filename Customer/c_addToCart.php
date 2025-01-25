<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $coffeeName = $_POST['coffee_name'];
    $milk = $_POST['milk'];
    $temperature = $_POST['temperature'];
    $size = $_POST['size'];
    $cream = $_POST['cream'];
    $bean = $_POST['bean'];
    $date = $_POST['date'];

    // Define base prices for each coffee
    $coffeeBasePrices = [
        'Americano' => 6.00,
        'Cappuccino' => 6.50,
        'Spanish Latte' => 7.00,
        'Salted Camy Frappe' => 8.00,
        'Espresso Frappe' => 7.50,
        'Salted Caramel Latte' => 7.50,
        'Buttercreme Latte' => 8.00,
        'Coconut Latte' => 7.50,
        'Hazelnut Latte' => 7.00,
        'Matcha Latte' => 7.50,
        'Nesloo' => 7.00,
        'Matcha Frappe' => 8.50,
        'Genmaicha Latte' => 7.50,
        'Biscoff Frappe' => 9.00,
        'Chocohazel Frappe' => 8.00,
        'Chocookies' => 7.00,
        'Buttercreme Choco' => 8.00,
        'Lemonade' => 5.00,
        'Cheesecream Matcha' => 9.50,
        'Ori Matcha' => 8.00,
        'Strawberry Frappe' => 8.00,
        'Yam Milk' => 7.50,
        'Coconut Shake' => 6.00
    ];

    // Set the base price based on the coffee name
    $basePrice = $coffeeBasePrices[$coffeeName] ?? 5.00; // Default to $5.00 if coffee name is not found

    // Define pricing rules
    $milkPrices = [
        'Oat Milk' => 1.00,
        'Dairy Milk' => 0.00,
        'Full Cream Milk' => 0.75,
        'Low Fat Milk' => 0.50,
        'Coconut Milk' => 1.25
    ];

    $temperaturePrices = [
        'Hot' => 0.00,
        'Warm' => 0.00,
        'Cold' => 0.50
    ];

    $sizePrices = [
        'Regular' => 0.00,
        'Large' => 1.50
    ];

    $creamPrices = [
        'Yes' => 0.75,
        'No' => 0.00
    ];

    $beanPrices = [
        'Bourbon' => 0.00,
        'Geisha' => 2.00,
        'Arabica' => 0.50,
        'Typica' => 0.75,
        'Robusta' => 0.50,
        'Liberica' => 1.25,
        'Excelsa' => 1.00
    ];

    // Calculate total price
    $totalPrice = $basePrice +
        ($milkPrices[$milk] ?? 0) +
        ($temperaturePrices[$temperature] ?? 0) +
        ($sizePrices[$size] ?? 0) +
        ($creamPrices[$cream] ?? 0) +
        ($beanPrices[$bean] ?? 0);

    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the order to the cart
    $_SESSION['cart'][] = [
        'coffee_name' => $coffeeName,
        'milk' => $milk,
        'temperature' => $temperature,
        'size' => $size,
        'cream' => $cream,
        'bean' => $bean,
        'date' => $date,
        'price' => $totalPrice, // Store the calculated price
        'quantity' => 1, // Default quantity is 1
        'image' => 'https://via.placeholder.com/150' // Placeholder image
    ];

    // Redirect to the cart page
    header("Location: c.inCartNew.php");
    exit;
}
?>