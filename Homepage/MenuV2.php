<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../Homepage/session.php'; ?>
    <?php include '../Homepage/header.php'; ?>
    <?php include '../Homepage/dbkupi.php'; ?>
    <style>
        body {
            background-color: rgb(255, 191, 230);
            padding-top: 70px;
            font-family: 'Lucida Sans', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .menu-title {
            text-align: center;
            color: #7a2005;
            font-size: 35px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .menu-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .menu-item {
            flex: 0 0 300px;
            background-color: rgb(255, 238, 141);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .menu-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .menu-item h3 {
            color: #78350F;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .menu-item p {
            color: #333;
            margin-bottom: 10px;
            min-height: 60px;
        }

        .menu-item .price {
            color: #78350F;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .menu-item button {
            background: #78350F;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .menu-item button:hover {
            background: #92400e;
        }

        .cart-button {
            position: fixed;
            top: 80px;
            right: 20px;
            background: none;
            border: none;
            cursor: pointer;
            z-index: 1000;
        }

        .cart-icon {
            width: 100px;
            height: 100px;
            transition: transform 0.2s;
        }

        .cart-button:hover .cart-icon {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <?php
    $loggedin = getSession('username') ? true : false;

    if ($loggedin) {
        echo '<button class="cart-button" onclick="window.location.href=\'../Customer/c.inCartNew.php\'">
                <img src="../image/cart.png" alt="Cart" class="cart-icon">
            </button>';
    }

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // Debug database connection
    if ($condb) {
        echo "<!-- Database connected successfully -->";
        
        // List tables in the schema
        $tables_query = "SELECT table_name FROM user_tables";
        $tables_stmt = oci_parse($condb, $tables_query);
        oci_execute($tables_stmt);
        echo "<!-- Available tables: ";
        while ($table = oci_fetch_array($tables_stmt, OCI_ASSOC)) {
            print_r($table);
        }
        echo " -->";

        // Fetch menu items using uppercase table name
        $query = "SELECT * FROM KUPI ORDER BY KUPIID";
        $stmt = oci_parse($condb, $query);
        
        if ($stmt && oci_execute($stmt)) {
            $menuItems = array();
            while ($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                $menuItems[] = $row;
            }
            
            if (empty($menuItems)) {
                echo "<!-- No menu items found in KUPI table -->";
            } else {
                echo "<!-- Found " . count($menuItems) . " menu items. First item: ";
                print_r($menuItems[0]);
                echo " -->";
            }
        } else {
            $error = oci_error($stmt);
            echo "<!-- Query error: " . htmlentities($error['message']) . " -->";
        }
    } else {
        echo "<!-- Database connection failed -->";
        $error = oci_error();
        echo "<!-- Connection error: " . htmlentities($error['message']) . " -->";
    }
    ?>

    <div class="container">
        <h1 class="menu-title">Our Menu</h1>
        <div class="menu-grid">
            <?php foreach ($menuItems as $item) { ?>
                <div class="menu-item">
                    <img src="getKupiImage.php?id=<?php echo htmlspecialchars($item['KUPIID']); ?>" 
                         alt="<?php echo htmlspecialchars($item['K_NAME']); ?>">
                    <h3><?php echo htmlspecialchars($item['K_NAME']); ?></h3>
                    <p><?php echo htmlspecialchars($item['K_DESC']); ?></p>
                    <div class="price">RM <?php echo number_format($item['K_PRICE'], 2); ?></div>
                    <?php if ($loggedin): ?>
                        <form action="../Customer/c.addToCart.php" method="post">
                            <input type="hidden" name="item_id" value="<?php echo $item['KUPIID']; ?>">
                            <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($item['K_NAME']); ?>">
                            <button type="submit">Add to Cart</button>
                        </form>
                    <?php else: ?>
                        <button onclick="window.location.href='../Customer/c.login.php';">Add to Cart</button>
                    <?php endif; ?>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
