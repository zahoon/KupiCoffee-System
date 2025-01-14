<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'Homepage/header.html'; ?>
    <style>
        * {
            font-family: 'Lucida Sans', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: ##f9dfef;
        }

        .menu-section {
            text-align: center;
            padding: 30px 20px;
        }

        .menu-header1 {
            color: #7a2005;
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
            background-color: #FFD700;
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
            color: #7a2005;
            margin: 10px 0;
            font-weight: bold;
        }

        .coffee-item p {
            font-size: 14px;
            color: #000;
        }

        .coffee-item button {
            margin-top: 10px;
            padding: 10px 15px;
            font-size: 16px;
            color: white;
            background: #7a2005;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .nav-button {
            background: #7a2005;
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
            background: #ccc;
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
            background: #ccc;
            border-radius: 50%;
            cursor: pointer;
        }

        .pagination-dot.active {
            background: #7a2005;
        }

        .back-to-login {
            margin-top: 30px;
            font-size: 16px;
        }

        .back-to-login a {
            color: #7a2005;
            text-decoration: none;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
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
            { name: "Americano", description: "Freshly pulled shots of espresso with hot water.", price: "RM 4.00", image: "image/AMERICANO.png" },
            { name: "Cappuccino", description: "Espresso layered with steamed milk and foam.", price: "RM 4.50", image: "image/CAPPUCINO.png" },
            { name: "Spanish Latte", description: "Espresso with steamed non-fat milk and foam.", price: "RM 4.75", image: "image/LATTE.png" },
            { name: "Salted Caramel Frappe", description: "Caramel syrup blended with coffee, milk, and ice.", price: "$5.00", image: "image/SALTED_CARAMEL_FRAPPE.png" },
            { name: "Espresso Frappe", description: "Espresso blended with milk and ice.", price: "RM 5.00", image: "image/ESPRESSO_FRAPPE.png" },
            { name: "Salted Caramel Latte", description: "Salted caramel latte made with caramel sauce and sea salt.", price: "RM 5.25", image: "image/SALTED_CARAMEL_LATTE.png" },
            { name: "Buttercreme Latte", description: "Butter + creme.", price: "RM 5.50", image: "image/BUTTERCREME_LATTE.png" },
            { name: "Coconut Latte", description: "coconut.", price: "RM 5.25", image: "image/COCONUT_LATTE.png" },
            { name: "Hazelnut Latte", description: "hazel kopi.", price: "RM 5.25", image: "image/HAZELNUT_LATTE.png" },
            { name: "Matcha Latte", description: "coconut.", price: "RM 5.25", image: "image/MATCHA_LATTE.png" },
            { name: "Spanish Latte", description: "coconut.", price: "RM 5.25", image: "image/SPANISH_LATTE.png" },
            { name: "Nesloo", description: "coconut.", price: "RM 5.25", image: "image/NESLOO.png" }
        ];

        const nonCoffeeItems = [
            { name: "Matcha Frappe", description: "Japanese-style Matcha blended with milk and ice.", price: "RM 5.50", image: "image/JAPANESE_MATCHA_FRAPPE.png" },
            { name: "Genmaicha Latte", description: "A latte made with green tea instead of espresso.", price: "RM 5.25", image: "image/GREEN_TEA_LATTE.png" },
            { name: "Biscoff Frappe", description: "A blend of black tea and spices with milk.", price: "RM 4.00", image: "image/BISCOFF_FRAPPE.png" },
            { name: "Chocohazel Frappe", description: "Rich and creamy chocolate drink.", price: "RM 3.50", image: "image/CHOCOHAZEL_FRAPPE.png" },
            { name: "Chocookies", description: "Premium matcha green tea blended with milk.", price: "RM 4.75", image: "image/CHOCOOKIES.png" },
            { name: "Buttercreme Choco", description: "Premium matcha green tea blended with milk.", price: "RM 4.75", image: "image/BUTTERCREME_CHOCO.png" },
            { name: "Lemonade", description: "Freshly squeezed lemons with a hint of sweetness.", price: "RM 3.00", image: "image/LEMONADE.png" },
            { name: "Chesecream Matcha", description: "Refreshing black tea served cold.", price: "$2.50", image: "image/CHEESECREAM_MATCHA.png" },
            { name: "Matcha", description: "Premium matcha green tea blended with milk.", price: "RM 4.75", image: "image/MATCHA.png" },
            { name: "Strawberry Frappe", description: "Premium matcha green tea blended with milk.", price: "RM 4.75", image: "image/STRAWBERRY_FRAPPE.png" },
            { name: "Yam Milk", description: "Premium matcha green tea blended with milk.", price: "RM 4.75", image: "image/YAM_MILK.png" },
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
                    <p>Price: ${item.price}</p>
                    <button onclick="window.location.href='Login.html';">Add to Cart</button>
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
