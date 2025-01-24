<?php
// a_kupi.php
include '../Homepage/header.php'; // Assuming your header is included here
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee System Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for AJAX -->
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

    .button-group {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    .button-group button {
      margin: 0 10px;
      padding: 10px 20px;
      background-color: #F29F05;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .button-group button:hover {
      background-color: #D6892F;
    }

    .button-group button.active {
      background-color: #78350F;
      font-weight: bold;
    }
  </style>
</head>
<body class="font-sans text-gray-700">
  <?php include '../Homepage/header.php';?>

  <!-- Content Section -->
  <div class="p-8">
    <!-- Header -->
    <h2 style="font-size: 35px; font-weight: bold; color: #7a2005">Admin Menu</h2>

    <!-- Button Group for Coffee & Non-Coffee -->
    <div class="button-group">
      <button id="coffeeBtn" class="active" onclick="fetchKupi(1, 'coffee')">Coffee</button>
      <button id="nonCoffeeBtn" onclick="fetchKupi(1, 'non-coffee')">Non-Coffee</button>
    </div>

    <!-- Pagination Links -->
    <div class="pagination" id="pagination"></div>

    <!-- Coffee Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mt-8" id="coffee-cards"></div>
  </div>

  <script>
    // Function to fetch and render coffee items
    function fetchKupi(page, category = 'coffee') {
      $.ajax({
        url: 'a_kupi.php',
        method: 'GET',
        data: { page: page, category: category },
        dataType: 'json',
        success: function(response) {
          if (response.error) {
            alert(response.error);
            return;
          }
          
          // Render Coffee Cards
          const coffeeCardsContainer = $('#coffee-cards');
          coffeeCardsContainer.empty();
          response.kupi.forEach(function(item) {
            coffeeCardsContainer.append(`
              <div class="card flex flex-col items-center rounded-lg p-3">
                <h3>${item.K_NAME}</h3>
                <img src="../image/${item.K_NAME}.png" alt="${item.K_NAME}" class="w-40">
                <div class="card-content">
                  <p>${item.K_DESC}</p>
                  <p class="price">Price: RM ${item.K_PRICE}</p>
                </div>
              </div>
            `);
          });

          // Render Pagination
          const paginationContainer = $('#pagination');
          paginationContainer.empty();
          for (let i = 1; i <= response.totalPages; i++) {
            paginationContainer.append(`
              <a href="javascript:void(0);" class="px-4 py-2 border border-gray-300 rounded ${i === page ? 'bg-gray-200' : ''}" onclick="fetchKupi(${i}, '${category}')">${i}</a>
            `);
          }

          // Highlight active category button
          if (category === 'coffee') {
            $('#coffeeBtn').addClass('active');
            $('#nonCoffeeBtn').removeClass('active');
          } else {
            $('#nonCoffeeBtn').addClass('active');
            $('#coffeeBtn').removeClass('active');
          }
        }
      });
    }

    // Initial call to fetch coffee data for the first page
    $(document).ready(function() {
      fetchKupi(1, 'coffee');
    });
  </script>
</body>
</html>
