<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once '../Homepage/session.php'; ?>
    <?php include '../Homepage/header.php'; ?>
    <style>
        * {
            font-family: 'Lucida Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: rgb(255, 191, 230) !important; 
            padding-top: 70px;
        }

        .menu-section {
            text-align: center;
            padding: 30px 20px;
        }

        .menu-header1 {
            color: #78350F;
            font-size: 30px;
            margin-bottom: 20px;
        }

        .menu-slider {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            max-width: 900px;
            margin: 0 auto;
        }

        .menu-container {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: fit-content;
            justify-content: center;
            gap:15px;
        }

        .coffee-item {
            flex: 0 0 300px;
            margin: 10px;
            background-color:rgb(255, 238, 141);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .coffee-item img {
            width: 100%;
            border-radius: 5px;
        }

        .coffee-item h3 {
            font-size: 24px;
            color: #78350F;
            margin: 10px 0;
            font-weight: bold;
        }

        .coffee-item p {
            font-size: 14px;
            color: #000;
        }

        .coffee-item .price {
            font-size: 18px; /* Bigger font size */
            font-weight: bold; /* Bold text */
            color: #78350F; /* You can adjust the color if you like */
        }


        .coffee-item button {
            margin-top: 10px;
            padding: 10px 15px;
            font-size: 16px;
            color: white;
            background: #78350F;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .nav-button {
            background: #78350F;
            color: white;
            border: none;
            font-size: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
        }

        .nav-button.left {
            left: -150px;
        }

        .nav-button.right {
            right: -150px;
        }

        .nav-button:disabled {
            background:rgb(255, 255, 255);
            color: #888;
            cursor: not-allowed;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .pagination-dot {
            width: 10px;
            height: 10px;
            background:rgb(255, 255, 255);
            border-radius: 50%;
            cursor: pointer;

        }

        .pagination-dot.active {
            background: #78350F;
        }

        .back-to-login {
            margin-top: 30px;
            font-size: 16px;
        }

        .back-to-login a {
            color: #78350F;
            text-decoration: none;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }


    .cart-button {
        position: fixed; /* Position the button relative to the viewport */
        top: 80px; /* Adjust the gap between the header and the button */
        right: 20px; /* Add some space from the right border */
        background: none; /* Remove button background */
        border: none; /* Remove button border */
        cursor: pointer; /* Show pointer cursor on hover */
        padding: 0; /* Remove padding around the button */
        z-index: 1000; /* Ensure it stays on top of other elements */
    }

    .cart-button:hover {
        transform: scale(1.1); /* Add zoom-in effect on hover */
    }

    .cart-icon {
        width: 100px; /* Adjust the cart icon size */
        height: 100px;
    }


    </style>
</head>

<body>
   <!-- Cart Button -->
    <?php
    $loggedin = getSession('username') ? true : false;

    if ($loggedin) {
        echo '<button class="cart-button" onclick="window.location.href=\'../Customer/c.inCartNew.php\'">
                <img src="../image/cart.png" alt="Cart" class="cart-icon">
            </button>';
    }
    ?>

    <script>
        const isLoggedIn = <?php echo json_encode($loggedin); ?>;
    </script>

    <!-- Coffee Menu Section -->
    <section class="menu-section">
        <h2 style="font-size: 35px; font-weight: bold; color: #7a2005">Coffee Menu</h2>
        <div class="menu-slider">
            <button class="nav-button left" id="prevButton" onclick="prevPage()">&#8249;</button>
            <div class="menu-container" id="coffeeContainer">
                <!-- Coffee items will be dynamically loaded here -->
            </div>
            <button class="nav-button right" id="nextButton" onclick="nextPage()">&#8250;</button>
        </div>
        <div class="pagination" id="paginationDots">
            <!-- Pagination dots for coffee menu -->
        </div>
    </section>

    <!-- Non-Coffee Menu Section -->
    <section class="menu-section">
        <h2 style="font-size: 35px; font-weight: bold; color: #7a2005">Non-Coffee Menu</h2>
        <div class="menu-slider">
            <button class="nav-button left" id="prevNonCoffeeButton" onclick="prevNonCoffeePage()">&#8249;</button>
            <div class="menu-container" id="nonCoffeeContainer">
                <!-- Non-coffee items will be dynamically loaded here -->
            </div>
            <button class="nav-button right" id="nextNonCoffeeButton" onclick="nextNonCoffeePage()">&#8250;</button>
        </div>
        <div class="pagination" id="nonCoffeePaginationDots">
            <!-- Pagination dots for non-coffee menu -->
        </div>
    </section>

    <script>
        const coffeeItems = [
    { 
        id: 1,
        name: "Americano", 
        description: "A timeless classic, freshly pulled shots of espresso to create a robust and flavorful black coffee that wakes you up with every sip.<br><br>", 
        price: "RM 6.00", 
        image: "../image/AMERICANO.png" 
    },
    { 
        id: 2,
        name: "Cappuccino", 
        description: "A perfect balance of bold espresso, steamed milk, and creamy foam, topped with a light dusting of cocoa for a luxurious treat.<br><br>", 
        price: "RM 6.50", 
        image: "../image/CAPPUCINO.png" 
    },
    { 
        id: 3,
        name: "Spanish Latte", 
        description: "A rich and smooth blend of espresso with steamed milk and a touch of condensed milk for a perfectly sweet and creamy finish.<br><br>", 
        price: "RM 7.00", 
        image: "../image/LATTE.png" 
    },
    { 
        id: 4,
        name: "Salted Camy Frappe", 
        description: "A delightful blend of caramel syrup, coffee, milk, and ice, topped with whipped cream and a drizzle of caramel.<br><br>", 
        price: "RM 8.00", 
        image: "../image/SALTED_CARAMEL_FRAPPE.png" 
    },
    { 
        id: 5,
        name: "Espresso Frappe", 
        description: "A bold and creamy drink made by blending freshly brewed espresso with milk and ice, ideal for those who love strong flavors.<br><br>", 
        price: "RM 7.50", 
        image: "../image/ESPRESSO_FRAPPE.png" 
    },
    { 
        id: 6,
        name: "Salted Caramel Latte", 
        description: "A decadent treat made with rich caramel sauce, a hint of sea salt, and smooth espresso, topped with creamy steamed milk.<br><br>", 
        price: "RM 7.50", 
        image: "../image/SALTED_CARAMEL_LATTE.png" 
    },
    { 
        id: 7,
        name: "Buttercreme Latte", 
        description: "An indulgent latte made with creamy butter and sweet cream, paired with bold espresso for a comforting and unique flavor.<br><br>", 
        price: "RM 8.00", 
        image: "../image/BUTTERCREME_LATTE.png" 
    },
    { 
        id: 8,
        name: "Coconut Latte", 
        description: "A refreshing take on a latte with smooth coconut milk, bold espresso, and a hint of tropical sweetness to feel the day better than yesterday.<br><br>", 
        price: "RM 7.50", 
        image: "../image/COCONUT_LATTE.png" 
    },
    { 
        id: 9,
        name: "Hazelnut Latte", 
        description: "A perfect balance of espresso and rich hazelnut syrup, blended with steamed milk for a creamy, nutty flavor.<br><br>", 
        price: "RM 7.00", 
        image: "../image/HAZELNUT_LATTE.png" 
    },
    { 
        id: 10,
        name: "Matcha Latte", 
        description: "A smooth and creamy combination of matcha green tea and steamed milk, offering a refreshing and slightly earthy taste.<br><br>", 
        price: "RM 7.50", 
        image: "../image/MATCHA_LATTE.png" 
    },
    { 
        id: 11,
        name: "Spanish Latte", 
        description: "A sweet, velvety espresso-based drink with a hint of condensed milk and steamed milk, offering a smooth finish.<br><br>", 
        price: "RM 7.00", 
        image: "../image/SPANISH_LATTE.png" 
    },
    { 
        id: 12,
        name: "Nesloo", 
        description: "A delicious Malaysian blend of Nescafe and Milo, Neslo offers the perfect balance of bold coffee and sweet chocolate to energize your day.<br><br>", 
        price: "RM 7.00", 
        image: "../image/NESLOO.png" 
    }
];


const nonCoffeeItems = [
    { 
        id: 13,
        name: "Matcha Frappe", 
        description: "Premium Japanese Matcha blended with milk and ice, creating a creamy and refreshing drink with a hint of earthy sweetness.<br><br>", 
        price: "RM 8.50", 
        image: "../image/JAPANESE_MATCHA_FRAPPE.png" 
    },
    { 
        id: 14,
        name: "Genmaicha Latte", 
        description: "A comforting latte featuring the unique nutty and toasty flavors of genmaicha tea, perfectly blended with milk.<br><br>", 
        price: "RM 7.50", 
        image: "../image/GREEN_TEA_LATTE.png" 
    },
    { 
        id: 15,
        name: "Biscoff Frappe", 
        description: "A creamy and indulgent blend of crushed Biscoff cookies, milk, and ice, topped with whipped cream and drizzle of caramel biscoff.<br><br>", 
        price: "RM 9.00", 
        image: "../image/BISCOFF_FRAPPE.png" 
    },
    { 
        id: 16,
        name: "Chocohazel Frappe", 
        description: "Rich chocolate combined with hazelnut syrup, milk, and ice, creating a dessert-like drink that’s perfect for any chocolate lover.<br><br>", 
        price: "RM 8.00", 
        image: "../image/CHOCOHAZEL_FRAPPE.png" 
    },
    { 
        id: 17,
        name: "Chocookies", 
        description: "A nostalgic blend of milk, ice, and crushed cookies, topped with chocolate whipped cream and cookies for a sweet and crunchy treat.<br><br>", 
        price: "RM 7.00", 
        image: "../image/CHOCOOKIES.png" 
    },
    { 
        id: 18,
        name: "Buttercreme Choco", 
        description: "A creamy and indulgent hot chocolate with hints of butter and cream, providing a velvety smooth experience.<br><br>", 
        price: "RM 8.00", 
        image: "../image/BUTTERCREME_CHOCO.png" 
    },
    { 
        id: 19,
        name: "Lemonade", 
        description: "A bright and refreshing drink made with freshly squeezed lemons and sugar to start a fresh day with freshie moods. <br><br>", 
        price: "RM 5.00", 
        image: "../image/LEMONADE.png" 
    },
    { 
        id: 20,
        name: "Cheesecream Matcha", 
        description: "A unique blend of matcha tea topped with a creamy cheese foam, offering a perfect balance of savory and sweet flavors.<br><br>", 
        price: "RM 9.50", 
        image: "../image/CHEESECREAM_MATCHA.png" 
    },
    { 
        id: 21,
        name: "Ori Matcha", 
        description: "A drink made with premium Japanese green tea, offering a earthy flavor with a touch of natural sweetness. Perfect for matcha lovers.<br><br>", 
        price: "RM 8.00", 
        image: "../image/MATCHA.png" 
    },
    { 
        id: 22,
        name: "Strawberry Frappe", 
        description: "A refreshing and fruity drink made with strawberries, milk, and ice, creating a smooth and indulgent flavor.<br><br>", 
        price: "RM 8.00", 
        image: "../image/STRAWBERRY_FRAPPE.png" 
    },
    { 
        id: 23,
        name: "Yam Milk", 
        description: "A comforting drink made from yam, with full cream milk and a touch of sweetness, offering a unique and smooth taste.<br><br>", 
        price: "RM 7.50", 
        image: "../image/YAM_MILK.png" 
    },
    { 
        id: 24,
        name: "Coconut Shake", 
        description: "A refreshing blend of creamy coconut milk and ice, topped with a scoop of vanilla ice cream for the ultimate tropical treat.<br><br>", 
        price: "RM 6.00", 
        image: "../image/COCONUTSHAKE.png" 
    }
    
];


        const itemsPerPage = 3;

        let currentCoffeePage = 0;
        let currentNonCoffeePage = 0;

        function loadMenuItems(containerId, paginationId, items, currentPage, prevButtonId, nextButtonId) {
            const menuContainer = document.getElementById(containerId);
            const paginationDots = document.getElementById(paginationId);
            const prevButton = document.getElementById(prevButtonId);
            const nextButton = document.getElementById(nextButtonId);

            menuContainer.innerHTML = '';

            const startIndex = currentPage * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageItems = items.slice(startIndex, endIndex);

            pageItems.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.classList.add('coffee-item');
                itemDiv.innerHTML = `
                    <img src="${item.image}" alt="${item.name}">
                    <h3>${item.name}</h3>
                    <p>${item.description}</p>
                    <p class="price">Price: ${item.price}</p>
                    
                    ${isLoggedIn ? `
                    <form action="../Customer/c.addToCart.php" method="post">
                        <input type="hidden" name="item_id" value="${item.id}">
                        <input type="hidden" name="item_name" value="${item.name}">
                        <button type="submit">Add to Cart</button>
                    </form>` : `
                    <button onclick="window.location.href='../Customer/c.login.php';">Add to Cart</button>`}
                `;
                menuContainer.appendChild(itemDiv);
            });


            paginationDots.innerHTML = '';
            for (let i = 0; i < Math.ceil(items.length / itemsPerPage); i++) {
                const dot = document.createElement('div');
                dot.classList.add('pagination-dot');
                if (i === currentPage) dot.classList.add('active');
                dot.addEventListener('click', () => {
                    if (containerId === 'coffeeContainer') {
                        currentCoffeePage = i;
                    } else {
                        currentNonCoffeePage = i;
                    }
                    loadMenuItems(containerId, paginationId, items, i, prevButtonId, nextButtonId);
                });
                paginationDots.appendChild(dot);
            }

            prevButton.disabled = currentPage === 0;
            nextButton.disabled = (currentPage + 1) * itemsPerPage >= items.length;
        }

        function nextPage() {
            if ((currentCoffeePage + 1) * itemsPerPage < coffeeItems.length) {
                currentCoffeePage++;
                loadMenuItems('coffeeContainer', 'paginationDots', coffeeItems, currentCoffeePage, 'prevButton', 'nextButton');
            }
        }

        function prevPage() {
            if (currentCoffeePage > 0) {
                currentCoffeePage--;
                loadMenuItems('coffeeContainer', 'paginationDots', coffeeItems, currentCoffeePage, 'prevButton', 'nextButton');
            }
        }

        function nextNonCoffeePage() {
            if ((currentNonCoffeePage + 1) * itemsPerPage < nonCoffeeItems.length) {
                currentNonCoffeePage++;
                loadMenuItems('nonCoffeeContainer', 'nonCoffeePaginationDots', nonCoffeeItems, currentNonCoffeePage, 'prevNonCoffeeButton', 'nextNonCoffeeButton');
            }
        }

        function prevNonCoffeePage() {
            if (currentNonCoffeePage > 0) {
                currentNonCoffeePage--;
                loadMenuItems('nonCoffeeContainer', 'nonCoffeePaginationDots', nonCoffeeItems, currentNonCoffeePage, 'prevNonCoffeeButton', 'nextNonCoffeeButton');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadMenuItems('coffeeContainer', 'paginationDots', coffeeItems, currentCoffeePage, 'prevButton', 'nextButton');
            loadMenuItems('nonCoffeeContainer', 'nonCoffeePaginationDots', nonCoffeeItems, currentNonCoffeePage, 'prevNonCoffeeButton', 'nextNonCoffeeButton');
        });
    </script>
</body>
