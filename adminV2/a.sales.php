<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

// Get available years from orders
$yearsQuery = "SELECT DISTINCT EXTRACT(YEAR FROM KUPIDATE) as year 
               FROM ORDERTABLE 
               ORDER BY year DESC";
$yearsStmt = oci_parse($condb, $yearsQuery);
oci_execute($yearsStmt);
$years = array();
while ($row = oci_fetch_assoc($yearsStmt)) {
    $years[] = $row['YEAR'];
}
oci_free_statement($yearsStmt);

// Default to current year and month if not selected
$selectedYear = $_GET['year'] ?? date('Y');
$selectedMonth = $_GET['month'] ?? date('m');

// Get daily sales for selected month
$dailySalesQuery = "SELECT 
                      EXTRACT(DAY FROM o.KUPIDATE) as day,
                      SUM(od.SUBTOTAL) as daily_total
                    FROM ORDERTABLE o
                    JOIN ORDERDETAIL od ON o.ORDERID = od.ORDERID 
                    WHERE EXTRACT(YEAR FROM o.KUPIDATE) = :year
                    AND EXTRACT(MONTH FROM o.KUPIDATE) = :month
                    GROUP BY EXTRACT(DAY FROM o.KUPIDATE)
                    ORDER BY day";
$dailyStmt = oci_parse($condb, $dailySalesQuery);
oci_bind_by_name($dailyStmt, ":year", $selectedYear);
oci_bind_by_name($dailyStmt, ":month", $selectedMonth);
oci_execute($dailyStmt);

$dailyLabels = [];
$dailyData = [];
while ($row = oci_fetch_assoc($dailyStmt)) {
    $dailyLabels[] = $row['DAY'];
    $dailyData[] = $row['DAILY_TOTAL'];
}
oci_free_statement($dailyStmt);

// Get monthly sales for selected year
$monthlySalesQuery = "SELECT 
                        EXTRACT(MONTH FROM o.KUPIDATE) as month,
                        SUM(od.SUBTOTAL) as monthly_total
                      FROM ORDERTABLE o
                      JOIN ORDERDETAIL od ON o.ORDERID = od.ORDERID
                      WHERE EXTRACT(YEAR FROM o.KUPIDATE) = :year
                      GROUP BY EXTRACT(MONTH FROM o.KUPIDATE)
                      ORDER BY month";
$monthlyStmt = oci_parse($condb, $monthlySalesQuery);
oci_bind_by_name($monthlyStmt, ":year", $selectedYear);
oci_execute($monthlyStmt);

$monthlyLabels = [];
$monthlyData = [];
while ($row = oci_fetch_assoc($monthlyStmt)) {
    $monthlyLabels[] = date('F', mktime(0, 0, 0, $row['MONTH'], 1));
    $monthlyData[] = $row['MONTHLY_TOTAL'];
}
oci_free_statement($monthlyStmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f0f4f8;
            padding-top: 70px;
        }
        .chart-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
    </style>
</head>
<body class="font-sans text-gray-700">
    <?php include '../Homepage/header.php'; ?>

    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-pink-700 mb-6">Sales Analytics</h1>
            
            <!-- Date Filters -->
            <form class="mb-8 flex gap-4 items-end">
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                    <select name="year" id="year" onchange="this.form.submit()"
                            class="mt-1 block w-40 rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        <?php foreach ($years as $year): ?>
                            <option value="<?php echo $year; ?>" 
                                    <?php echo $year == $selectedYear ? 'selected' : ''; ?>>
                                <?php echo $year; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                    <select name="month" id="month" onchange="this.form.submit()"
                            class="mt-1 block w-40 rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?php echo $m; ?>" 
                                    <?php echo $m == $selectedMonth ? 'selected' : ''; ?>>
                                <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </form>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Daily Sales Chart -->
            <div class="chart-container">
                <h2 class="text-xl font-semibold mb-4">Daily Sales for <?php echo date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)); ?></h2>
                <canvas id="dailySalesChart"></canvas>
            </div>

            <!-- Monthly Sales Chart -->
            <div class="chart-container">
                <h2 class="text-xl font-semibold mb-4">Monthly Sales for <?php echo $selectedYear; ?></h2>
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Daily Sales Chart
        new Chart(document.getElementById('dailySalesChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($dailyLabels); ?>,
                datasets: [{
                    label: 'Daily Sales (RM)',
                    data: <?php echo json_encode($dailyData); ?>,
                    backgroundColor: 'rgba(219, 39, 119, 0.5)',
                    borderColor: 'rgb(219, 39, 119)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'RM ' + value;
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Sales: RM ' + context.raw;
                            }
                        }
                    }
                }
            }
        });

        // Monthly Sales Chart
        new Chart(document.getElementById('monthlySalesChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($monthlyLabels); ?>,
                datasets: [{
                    label: 'Monthly Sales (RM)',
                    data: <?php echo json_encode($monthlyData); ?>,
                    borderColor: 'rgb(219, 39, 119)',
                    backgroundColor: 'rgba(219, 39, 119, 0.1)',
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'RM ' + value;
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Sales: RM ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
