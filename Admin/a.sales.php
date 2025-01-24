<?php
require_once '../Admin/a_sales.php';

// Fetch total sales and total purchases (this will be for the default date)
$totalData = fetchTotalSalesAndPurchases();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee System Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background-color: #fff5f7;
      padding-top: 70px;
    }

    .card {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body class="font-sans text-gray-700">
  <?php include '../Homepage/header.php'; ?>

  <!-- Statistics Section -->
  <div class="p-8">
    <h2 class="text-pink-700 mb-4" style="font-size: 35px; font-weight: bold;">Sales Statistics</h2>
    <div class="mb-6">
      <label for="dateFilter" class="text-gray-700 font-medium">Choose Time Period:</label>
      <input
        id="dateFilter"
        type="month"
        class="border border-gray-300 rounded-lg p-2 ml-2"
        value="2025-01" />
      <button id="updateChartBtn" class="bg-pink-700 text-white px-4 py-2 rounded-lg ml-4">Update Chart</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Total Sales -->
      <div class="bg-white rounded-lg p-6 shadow-md">
        <h3 class="text-pink-700 font-semibold mb-4">Total Sales</h3>
        <canvas id="salesChart" class="h-40"></canvas>
      </div>
      <!-- Total Purchases -->
      <div class="bg-white rounded-lg p-6 shadow-md">
        <h3 class="text-pink-700 font-semibold mb-4">Total Purchases</h3>
        <canvas id="purchasesChart" class="h-40"></canvas>
      </div>
    </div>
  </div>

  <script>
    // Default values for total sales and total purchases
    let totalSales = <?= json_encode($totalData['total_sales'] ?? 0) ?>;
    let totalPurchases = <?= json_encode($totalData['total_purchases'] ?? 0) ?>;

    console.log("Total Sales: ", totalSales); // Debugging output
    console.log("Total Purchases: ", totalPurchases); // Debugging output

    // Chart configuration
    const labels = ["Total"];
    let salesChart, purchasesChart;

    function initializeCharts() {
      // Ensure the canvas elements exist
      const salesCtx = document.getElementById("salesChart")?.getContext("2d");
      const purchasesCtx = document.getElementById("purchasesChart")?.getContext("2d");

      if (!salesCtx || !purchasesCtx) {
        console.error("Canvas elements not found.");
        return;
      }

      // Total Sales Chart
      salesChart = new Chart(salesCtx, {
        type: "bar",
        data: {
          labels: labels,
          datasets: [{
            label: "Total Sales",
            data: [totalSales],
            backgroundColor: "rgba(255, 102, 128, 0.6)",
            borderColor: "rgba(255, 102, 128, 1)",
            borderWidth: 2,
          }]
        },
        options: {
          responsive: true,
          scales: {
            x: {
              grid: {
                display: false
              }
            },
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 500
              }
            },
          },
        }
      });

      // Total Purchases Chart
      purchasesChart = new Chart(purchasesCtx, {
        type: "bar",
        data: {
          labels: labels,
          datasets: [{
            label: "Total Purchases",
            data: [totalPurchases],
            backgroundColor: "rgba(128, 255, 128, 0.6)",
            borderColor: "rgba(128, 255, 128, 1)",
            borderWidth: 2,
          }]
        },
        options: {
          responsive: true,
          scales: {
            x: {
              grid: {
                display: false
              }
            },
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 500
              }
            },
          },
        }
      });
    }

    // Function to fetch the total sales and total purchases for the selected month
    function updateChartData(selectedDate) {
      // Ensure the selectedDate is in the format YYYY-MM (Month-Year)
      const formData = new FormData();
      formData.append('selectedDate', selectedDate); // Send only the month (e.g., "2023-01")

      // Make an AJAX request to the backend
      fetch('a_sales.php', {
          method: 'POST',
          body: formData,
        })
        .then(response => response.json()) // Parse the response as JSON
        .then(data => {
          if (data.error) {
            // Handle error from the server
            console.error('Server Error:', data.error);
            return; // Stop further processing if there is an error
          }

          // Update the charts with the new data
          const totalSales = data.total_sales;
          const totalPurchases = data.total_purchases;

          console.log("Updated Total Sales: ", totalSales);
          console.log("Updated Total Purchases: ", totalPurchases);

          // Update the charts
          if (salesChart) salesChart.data.datasets[0].data = [totalSales];
          if (purchasesChart) purchasesChart.data.datasets[0].data = [totalPurchases];

          salesChart.update();
          purchasesChart.update();
        })
        .catch(error => console.error('Error updating data:', error));
    }


    // Event listener for the "Update Chart" button
    document.getElementById("updateChartBtn").addEventListener("click", function() {
      const selectedDate = document.getElementById("dateFilter").value;
      updateChartData(selectedDate);
    });

    document.addEventListener("DOMContentLoaded", function() {
      initializeCharts();
    });
  </script>
</body>

</html>