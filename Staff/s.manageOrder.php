<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Manage Orders</title>  
    <script src="https://cdn.tailwindcss.com"></script>  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">  
    <style>  
        body {  
            font-family: 'Lucida Sans', sans-serif;  
            background-image: url(../image/bgDel.png);  
            background-size: cover;  
            color: #444;  
            padding-top: 100px;  
        }  
        .card {  
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);  
        }  
        .popup {  
            display: none;  
            position: fixed;  
            top: 0;  
            left: 0;  
            width: 100%;  
            height: 100%;  
            background-color: rgba(0, 0, 0, 0.5);  
            justify-content: center;  
            align-items: center;  
        }  
        .popup-content {  
            background-color: white;  
            padding: 20px;  
            border-radius: 8px;  
            width: 400px;  
            max-width: 90%;  
        }  
        .scrollable-box {  
            max-height: 480px;  
            overflow-y: auto;  
            scrollbar-width: thin;  
            scrollbar-color: #f9a8d4 #f9fafb;  
        }  
        .scrollable-box::-webkit-scrollbar {  
            width: 8px;  
        }  
        .scrollable-box::-webkit-scrollbar-thumb {  
            background-color: #f9a8d4;  
            border-radius: 4px;  
        }  
        .scrollable-box::-webkit-scrollbar-track {  
            background-color: #f9fafb;  
        }  
    </style>  
</head>  
<body class="flex items-center justify-center min-h-screen">  
    <?php include '../Homepage/header.php'; ?>  

    <div class="bg-red rounded-lg p-6 max-w-6xl w-full">  
        <h1 class="text-3xl font-bold text-pink-600 mb-6 text-center">Manage Orders</h1>  

        <h2 class="text-xl font-semibold mb-4 text-center">Choose to approve the order</h2>  
        <form id="orderTypeForm" method="POST" action="">  
            <input type="hidden" name="orderType" id="orderType" required>  
            <div class="flex space-x-4 mb-4 justify-center">  
                <!-- Self Pickup Card -->  
                <div class="card bg-blue-200 p-6 rounded-lg cursor-pointer hover:bg-blue-300 transition duration-300" onclick="window.location.href='s_orderPickup.php';">  
                    <div class="flex flex-col items-center">  
                        <img src="../image/pickup.png" alt="Pickup" class="w-32 h-32 mb-4">  <!-- Increased size here -->  
                        <h3 class="text-xl font-bold">PICKUP</h3>  
                    </div>  
                </div>  

                <!-- Delivery Card -->  
                <div class="card bg-gray-200 p-6 rounded-lg cursor-pointer hover:bg-gray-300 transition duration-300" onclick="window.location.href='s_orderDelivery.php';">  
                    <div class="flex flex-col items-center">  
                        <img src="../image/delivery.png" alt="Delivery" class="w-32 h-32 mb-4">  <!-- Increased size here -->  
                        <h3 class="text-xl font-bold">DELIVERY</h3>  
                    </div>  
                </div>  
            </div>  
        </form>  

        <!-- Order List -->  
        <div class="scrollable-box">  
            <div class="space-y-4">  
                <?php  
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
                    $orderType = $_POST['orderType'];  
                    $dbName = $orderType === 'DELIVERY' ? 'DELIVERY' : 'PICKUP';  

                    // Database connection  
                    $servername = "localhost"; // Your server name  
                    $username = "kupidb"; // Your database username  
                    $password = "kupidb"; // Your database password  
                    $dbname = $dbName;  

                    // Create connection  
                    $conn = new mysqli($servername, $username, $password, $dbname);  

                    // Check connection  
                    if ($conn->connect_error) {  
                        die("Connection failed: " . $conn->connect_error);  
                    }  

                    // Fetch orders from the selected database  
                    $sql = "SELECT id, customer, total, status FROM orders"; // Adjust the query as necessary  
                    $result = $conn->query($sql);  

                    if ($result->num_rows > 0) {  
                        while ($order = $result->fetch_assoc()) {  
                            echo "  
                            <div class='flex justify-between items-center p-4 bg-pink-50 rounded-lg'>  
                                <div>  
                                    <p class='font-medium'>Order #{$order['id']}</p>  
                                    <p class='text-sm text-gray-600'>Customer: {$order['customer']}</p>  
                                    <p class='text-sm text-gray-600'>Total: RM{$order['total']}</p>  
                                </div>  
                                <div class='flex space-x-4'>  
                                    <button onclick='approveOrder({$order['id']})' class='bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600'>  
                                        <i class='fas fa-check-circle'></i> <!-- Approve Icon -->  
                                    </button>  
                                    <button onclick='openDeclinePopup({$order['id']})' class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600'>  
                                        <i class='fas fa-times-circle'></i> <!-- Decline Icon -->  
                                    </button>  
                                </div>  
                            </div>  
                            ";  
                        }  
                    } else {  
                        echo "<p class='text-gray-600'>No orders found.</p>";  
                    }  

                    $conn->close();  
                }  
                ?>  
            </div>  
        </div>  
    </div>  

    <!-- Success Popup -->  
    <div id="successPopup" class="popup">  
        <div class="popup-content">  
            <h2 class="text-xl font-bold text-pink-700 mb-4">Success!</h2>  
            <p class="text-gray-700">The order has been approved successfully.</p>  
            <div class="mt-6 flex justify-center">  
                <button onclick="closeSuccessPopup()" class="bg-pink-700 text-white px-4 py-2 rounded-lg hover:bg-pink-200">OK</button>  
            </div>  
        </div>  
    </div>  

    <!-- Decline Popup -->  
    <div id="declinePopup" class="popup">  
        <div class="popup-content">  
            <h2 class="text-xl font-bold text-pink-700 mb-4">Decline Order</h2>  
            <p class="text-gray-700">Please select a reason for declining the order.</p>  
            <div>  
                <select id="declineReason" onchange="toggleOtherReason()">  
                    <option value="">Select reason</option>  
                    <option value="Out of stock">Out of stock</option>  
                    <option value="Customer request">Customer request</option>  
                    <option value="Other">Other</option>  
                </select>  
                <div id="otherReasonContainer" class="hidden mt-2">  
                    <input type="text" id="otherReason" placeholder="Please specify" class="border border-gray-300 p-2 w-full" />  
                </div>  
            </div>  
            <div class="mt-4 flex justify-between">  
                <button onclick="declineOrder(event)" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Submit</button>  
                <button onclick="closeDeclinePopup()" class="text-gray-500 hover:underline">Cancel</button>  
            </div>  
        </div>  
    </div>  

    <script>  
        let currentOrderId = null;  

        function openDeclinePopup(orderId) {  
            currentOrderId = orderId;  
            document.getElementById('declinePopup').style.display = 'flex';  
        }  

        function closeDeclinePopup() {  
            document.getElementById('declinePopup').style.display = 'none';  
            document.getElementById('otherReasonContainer').classList.add('hidden');  
            document.getElementById('declineReason').value = '';  
            document.getElementById('otherReason').value = '';  
        }  

        function toggleOtherReason() {  
            const reasonSelect = document.getElementById('declineReason');  
            const otherReasonContainer = document.getElementById('otherReasonContainer');  
            if (reasonSelect.value === 'Other') {  
                otherReasonContainer.classList.remove('hidden');  
            } else {  
                otherReasonContainer.classList.add('hidden');  
            }  
        }  

        function declineOrder(event) {  
            event.preventDefault();  
            const reason = document.getElementById('declineReason').value;  
            const otherReason = document.getElementById('otherReason').value;  

            const fullReason = reason === 'Other' ? otherReason : reason;  

            console.log(`Order #${currentOrderId} declined. Reason: ${fullReason}`);  
            closeDeclinePopup();  
        }  

        function approveOrder(orderId) {  
            document.getElementById('successPopup').style.display = 'flex';  

            setTimeout(() => {  
                const orderElement = document.getElementById(`order-${orderId}`);  
                if (orderElement) {  
                    orderElement.remove();  
                }  
                closeSuccessPopup();  
            }, 1500);  
        }  

        function closeSuccessPopup() {  
            document.getElementById('successPopup').style.display = 'none';  
        }  

        document.getElementById('declineReason').addEventListener('change', function () {  
            const otherReasonContainer = document.getElementById('otherReasonContainer');  
            if (this.value === 'Other') {  
                otherReasonContainer.classList.remove('hidden');  
            } else {  
                otherReasonContainer.classList.add('hidden');  
            }  
        });  
    </script>  
</body>  
</html>