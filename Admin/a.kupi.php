<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee System Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    * {
      font-family: 'Lucida Sans', sans-serif;
    }

    body {
      background-color: rgb(255, 191, 230);
      padding-top: 70px;
    }

    .card {
      background-color: rgb(255, 238, 141);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
      border-radius: 5px;
      text-align: center;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }

    .card img {
      background-color: rgb(251, 233, 244); /* Set a white background for the image */
      padding: 10px; /* Add some padding inside the image background */
      border-radius: 100px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .card-content {
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 10px;
      border-radius: 8px;
      margin-top: 10px;
    }

    .card h3 {
      font-size: 20px;
      color: #78350F;
      margin: 5px 0;
      font-weight: bold;
    }

    .card p {
      font-size: 14px;
      color: #000;
      margin-bottom: 0.5rem;
      line-height: 1.4;
    }

    .card .price {
      font-size: 16px;
      font-weight: bold;
      color: #78350F;
      margin-top: 8px;
    }

    .search-bar {
      display: flex;
      justify-content: flex-end;
      margin: 20px 0;
    }

    .search-bar input {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 10px;
      width: 100%;
      transition: box-shadow 0.2s ease;
    }

    .search-bar input:focus {
      outline: none;
      box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
    }

    .toggle-button {
      transition: background-color 0.2s ease, color 0.2s ease;
    }

    .toggle-button:hover {
      background-color: #78350F;
      color: #fff;
    }

    .toggle-button.active {
      background-color: #78350F;
      color: #fff;
    }
  </style>
</head>
<body class="font-sans text-gray-700">
  <?php include '../Homepage/header.php';?>

  <!-- Content Section -->
  <div class="p-8">
    <!-- Header -->
    <h2 style="font-size: 35px; font-weight: bold; color: #7a2005">Admin Menu</h2>
    <div class="mb-7 flex justify-between items-center">
      <div class="flex space-x-4 mb-8">
        <button 
          id="coffeeButton" 
          class="toggle-button bg-white border border-amber-950 text-amber-950 px-4 py-2 rounded hover:bg-amber-950 hover:text-white focus:ring-1 focus:ring-amber-600 focus:outline-none active:bg-amber-950 active:text-white"
          onclick="toggleActive(this)">Coffee</button>
        <button 
          id="nonCoffeeButton" 
          class="toggle-button bg-white border border-amber-950 text-amber-950 px-4 py-2 rounded hover:bg-amber-950 hover:text-white focus:ring-1 focus:ring-amber-600 focus:outline-none active:bg-amber-950 active:text-white"
          onclick="toggleActive(this)">Non-Coffee</button>
      </div>
      <div class="search-bar">
        <input type="text" id="searchInput" class="form-control rounded" placeholder="Search events..." onkeyup="filterEvents()">
      </div>
    </div>

    <!-- Coffee Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
      <!-- Cards will be injected here dynamically using JavaScript -->
    </div>
  </div>
  <script>
    const coffeeItems = [
    { 
        name: "Americano", 
        description: "A timeless classic, freshly pulled shots of espresso to create a robust and flavorful black coffee that wakes you up with every sip.<br><br>", 
        price: "RM 6.00", 
        image: "../image/AMERICANO.png" 
    },
    { 
        name: "Cappuccino", 
        description: "A perfect balance of bold espresso, steamed milk, and creamy foam, topped with a light dusting of cocoa for a luxurious treat.<br><br>", 
        price: "RM 6.50", 
        image: "../image/CAPPUCINO.png" 
    },
    { 
        name: "Spanish Latte", 
        description: "A rich and smooth blend of espresso with steamed milk and a touch of condensed milk for a perfectly sweet and creamy finish.<br><br>", 
        price: "RM 7.00", 
        image: "../image/LATTE.png" 
    },
    { 
        name: "Salted Camy Frappe", 
        description: "A delightful blend of caramel syrup, coffee, milk, and ice, topped with whipped cream and a drizzle of caramel.<br><br>", 
        price: "RM 8.00", 
        image: "../image/SALTED_CARAMEL_FRAPPE.png" 
    },
    { 
        name: "Espresso Frappe", 
        description: "A bold and creamy drink made by blending freshly brewed espresso with milk and ice, ideal for those who love strong flavors.<br><br>", 
        price: "RM 7.50", 
        image: "../image/ESPRESSO_FRAPPE.png" 
    },
    { 
        name: "Salted Caramel Latte", 
        description: "A decadent treat made with rich caramel sauce, a hint of sea salt, and smooth espresso, topped with creamy steamed milk.<br><br>", 
        price: "RM 7.50", 
        image: "../image/SALTED_CARAMEL_LATTE.png" 
    },
    { 
        name: "Buttercreme Latte", 
        description: "An indulgent latte made with creamy butter and sweet cream, paired with bold espresso for a comforting and unique flavor.<br><br>", 
        price: "RM 8.00", 
        image: "../image/BUTTERCREME_LATTE.png" 
    },
    { 
        name: "Coconut Latte", 
        description: "A refreshing take on a latte with smooth coconut milk, bold espresso, and a hint of tropical sweetness to feel the day better than yesterday.<br><br>", 
        price: "RM 7.50", 
        image: "../image/COCONUT_LATTE.png" 
    },
    { 
        name: "Hazelnut Latte", 
        description: "A perfect balance of espresso and rich hazelnut syrup, blended with steamed milk for a creamy, nutty flavor.<br><br>", 
        price: "RM 7.00", 
        image: "../image/HAZELNUT_LATTE.png" 
    },
    { 
        name: "Matcha Latte", 
        description: "A smooth and creamy combination of matcha green tea and steamed milk, offering a refreshing and slightly earthy taste.<br><br>", 
        price: "RM 7.50", 
        image: "../image/MATCHA_LATTE.png" 
    },
    { 
        name: "Spanish Latte", 
        description: "A sweet, velvety espresso-based drink with a hint of condensed milk and steamed milk, offering a smooth finish.<br><br>", 
        price: "RM 7.00", 
        image: "../image/SPANISH_LATTE.png" 
    },
    { 
        name: "Nesloo", 
        description: "A delicious Malaysian blend of Nescafe and Milo, Neslo offers the perfect balance of bold coffee and sweet chocolate to energize your day.<br><br>", 
        price: "RM 7.00", 
        image: "../image/NESLOO.png" 
    }
];


    const nonCoffeeItems = [
    { 
        name: "Matcha Frappe", 
        description: "Premium Japanese Matcha blended with milk and ice, creating a creamy and refreshing drink with a hint of earthy sweetness.<br><br>", 
        price: "RM 8.50", 
        image: "../image/JAPANESE_MATCHA_FRAPPE.png" 
    },
    { 
        name: "Genmaicha Latte", 
        description: "A comforting latte featuring the unique nutty and toasty flavors of genmaicha tea, perfectly blended with milk.<br><br>", 
        price: "RM 7.50", 
        image: "../image/GREEN_TEA_LATTE.png" 
    },
    { 
        name: "Biscoff Frappe", 
        description: "A creamy and indulgent blend of crushed Biscoff cookies, milk, and ice, topped with whipped cream and drizzle of caramel biscoff.<br><br>", 
        price: "RM 9.00", 
        image: "../image/BISCOFF_FRAPPE.png" 
    },
    { 
        name: "Chocohazel Frappe", 
        description: "Rich chocolate combined with hazelnut syrup, milk, and ice, creating a dessert-like drink that’s perfect for any chocolate lover.<br><br>", 
        price: "RM 8.00", 
        image: "../image/CHOCOHAZEL_FRAPPE.png" 
    },
    { 
        name: "Chocookies", 
        description: "A nostalgic blend of milk, ice, and crushed cookies, topped with chocolate whipped cream and cookies for a sweet and crunchy treat.<br><br>", 
        price: "RM 7.00", 
        image: "../image/CHOCOOKIES.png" 
    },
    { 
        name: "Buttercreme Choco", 
        description: "A creamy and indulgent hot chocolate with hints of butter and cream, providing a velvety smooth experience.<br><br>", 
        price: "RM 8.00", 
        image: "../image/BUTTERCREME_CHOCO.png" 
    },
    { 
        name: "Lemonade", 
        description: "A bright and refreshing drink made with freshly squeezed lemons and sugar to start a fresh day with freshie moods. <br><br>", 
        price: "RM 5.00", 
        image: "../image/LEMONADE.png" 
    },
    { 
        name: "Cheesecream Matcha", 
        description: "A unique blend of matcha tea topped with a creamy cheese foam, offering a perfect balance of savory and sweet flavors.<br><br>", 
        price: "RM 9.50", 
        image: "../image/CHEESECREAM_MATCHA.png" 
    },
    { 
        name: "Ori Matcha", 
        description: "A drink made with premium Japanese green tea, offering a earthy flavor with a touch of natural sweetness. Perfect for matcha lovers.<br><br>", 
        price: "RM 8.00", 
        image: "../image/MATCHA.png" 
    },
    { 
        name: "Strawberry Frappe", 
        description: "A refreshing and fruity drink made with strawberries, milk, and ice, creating a smooth and indulgent flavor.<br><br>", 
        price: "RM 8.00", 
        image: "../image/STRAWBERRY_FRAPPE.png" 
    },
    { 
        name: "Yam Milk", 
        description: "A comforting drink made from yam, with full cream milk and a touch of sweetness, offering a unique and smooth taste.<br><br>", 
        price: "RM 7.50", 
        image: "../image/YAM_MILK.png" 
    },
    { 
        name: "Coconut Shake", 
        description: "A refreshing blend of creamy coconut milk and ice, topped with a scoop of vanilla ice cream for the ultimate tropical treat.<br><br>", 
        price: "RM 6.00", 
        image: "../image/COCONUTSHAKE.png" 
    }
    
];
    
function toggleActive(button) {
      const buttons = document.querySelectorAll('.toggle-button');
      buttons.forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');
    }

    const cardContainer = document.querySelector('.grid');
    const coffeeButton = document.getElementById('coffeeButton');
    const nonCoffeeButton = document.getElementById('nonCoffeeButton');

    const renderItems = (items) => {
      cardContainer.innerHTML = ''; 
      items.forEach(item => {
        const cardHTML = `
          <div class="card flex flex-col items-center rounded-lg p-3">
            <h3>${item.name}</h3>
            <img src="${item.image}" alt="${item.name}" class="w-40">
            <div class="card-content">
              <p>${item.description}</p>
              <p class="price">Price: ${item.price}</p>
            </div>
          </div>
        `;
        cardContainer.innerHTML += cardHTML;
      });
    };

    coffeeButton.addEventListener('click', () => renderItems(coffeeItems));
    nonCoffeeButton.addEventListener('click', () => renderItems(nonCoffeeItems));

    window.addEventListener('DOMContentLoaded', () => {
      toggleActive(coffeeButton); 
      renderItems(coffeeItems); 
    });

    function filterEvents() {
      const input = document.getElementById('searchInput').value.toLowerCase();
      const cards = document.querySelectorAll('.card');

      cards.forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();

        if (name.includes(input)) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    }
  </script>
  </body>
</html>
