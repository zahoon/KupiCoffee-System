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
    <?php include '../Homepage/header.php';?>
    <!-- Statistics Section -->
    <div class="p-8">
      <h2 class="text-pink-700 mb-4" style="font-size: 35px; font-weight: bold;">Sales Statistics</h2>
      <!-- Date Picker for Selecting Year/Month -->
      <div class="mb-6">
        <label for="dateFilter" class="text-gray-700 font-medium">Choose Time Period:</label>
        <input 
          id="dateFilter" 
          type="month" 
          class="border border-gray-300 rounded-lg p-2 ml-2"
          value="2023-01" 
        />
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
      // Initial dummy data
      const data = {
        "2023-01": { sales: [800], purchases: [600] },
        "2023-02": { sales: [900], purchases: [700] },
        "2023": { sales: [500, 700, 1200, 1000, 1500, 2000], purchases: [400, 600, 900, 800, 1400, 1800] },
        "2024": { sales: [600, 800, 1100, 1300, 1700, 2200], purchases: [500, 700, 1000, 900, 1500, 2000] },
      };

      // Chart configuration
      const labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun"];
      let salesChart, purchasesChart;

      function initializeCharts(salesData, purchasesData) {
        // Total Sales Chart
        const salesCtx = document.getElementById("salesChart").getContext("2d");
        salesChart = new Chart(salesCtx, {
          type: "line",
          data: {
            labels: labels,
            datasets: [
              {
                label: "Total Sales",
                data: salesData,
                fill: true,
                backgroundColor: "rgba(255, 102, 128, 0.2)",
                borderColor: "rgba(255, 102, 128, 1)",
                borderWidth: 2,
                tension: 0.3,
              },
            ],
          },
          options: {
            responsive: true,
            plugins: {
              legend: { display: false },
            },
            scales: {
              x: { grid: { display: false } },
              y: { beginAtZero: true, ticks: { stepSize: 500 } },
            },
          },
        });

        // Total Purchases Chart
        const purchasesCtx = document.getElementById("purchasesChart").getContext("2d");
        purchasesChart = new Chart(purchasesCtx, {
          type: "line",
          data: {
            labels: labels,
            datasets: [
              {
                label: "Total Purchases",
                data: purchasesData,
                fill: true,
                backgroundColor: "rgba(128, 255, 128, 0.2)",
                borderColor: "rgba(128, 255, 128, 1)",
                borderWidth: 2,
                tension: 0.3,
              },
            ],
          },
          options: {
            responsive: true,
            plugins: {
              legend: { display: false },
            },
            scales: {
              x: { grid: { display: false } },
              y: { beginAtZero: true, ticks: { stepSize: 500 } },
            },
          },
        });
      }

      // Initialize charts with default data (2023)
      initializeCharts(data["2023"].sales, data["2023"].purchases);

      // Update charts based on selected date
      document.getElementById("updateChartBtn").addEventListener("click", () => {
        const selectedDate = document.getElementById("dateFilter").value;

        // Determine if the user selected a full year or a specific month
        let selectedKey = selectedDate.length === 4 ? selectedDate : selectedDate;
        const salesData = data[selectedKey]?.sales;
        const purchasesData = data[selectedKey]?.purchases;

        // Update charts if data is available
        if (salesData && purchasesData) {
          salesChart.data.datasets[0].data = salesData;
          purchasesChart.data.datasets[0].data = purchasesData;
          salesChart.update();
          purchasesChart.update();
        } else {
          alert("No data available for the selected time period.");
        }
      });
    </script>
  </body>
</html>