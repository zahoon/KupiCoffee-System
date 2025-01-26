<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Pickup Orders</title>  
    <!-- Tailwind CSS CDN -->  
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">  
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
        .container-bg {  
            background-color: #6E260E;  
        }  
        /* New styles for table rows */  
        .table-row {  
            background-color: #B87333; /* Set the desired color */  
        }  
    </style>  
</head>  
<body class="bg-gray-100">  
    <?php include '../Homepage/header.php'; ?>  
    <div class="flex items-center justify-center h-screen">  
        <div class="container-bg p-8 rounded-lg shadow-lg w-full max-w-3xl">  
            <h2 class="text-2xl font-bold mb-6 text-center text-white">Pickup Orders</h2>  
            <div class="overflow-x-auto">  
                <table class="min-w-full bg-white border border-gray-300">  
                    <thead>  
                        <tr class="bg-gray-200">  
                            <th class="py-2 px-4 border-b text-left">ORDER</th>   
                            <th class="py-2 px-4 border-b text-left">CUSTOMER</th>  
                            <th class="py-2 px-4 border-b text-left">TIME</th>  
                            <th class="py-2 px-4 border-b text-left">STATUS</th>  
                            <th class="py-2 px-4 border-b text-left">ACTION</th>   
                        </tr>  
                    </thead>  
                    <tbody>  
                        <?php  
                        // Database connection  
                        $username = "kupidb";  
                        $password = "kupidb";  
                        $connection_string = "localhost:1521/xe";  

                        // Create connection  
                        $dbconn = oci_connect($username, $password, $connection_string);  

                        // Check connection  
                        if (!$dbconn) {  
                            $e = oci_error();  
                            die("Connection failed: " . $e['message']);  
                        }  

                        // Fetch orders  
                        $sql = "SELECT p.ORDERID, p.P_TIME, p.P_STATUS, c.C_USERNAME   
                                FROM PICKUP p   
                                JOIN ORDERTABLE o ON p.ORDERID = o.ORDERID   
                                JOIN CUSTOMER c ON o.CUSTID = c.CUSTID";  
                        $stmt = oci_parse($dbconn, $sql);  
                        oci_execute($stmt);  

                        // Fetch results  
                        while ($order = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {  
                            echo "  
                            <tr id='order-{$order['ORDERID']}' class='table-row hover:bg-gray-100'>    
                                <td class='py-2 px-4 border-b'>{$order['ORDERID']}</td>    
                                <td class='py-2 px-4 border-b'>{$order['C_USERNAME']}</td>  
                                <td class='py-2 px-4 border-b'>{$order['P_TIME']}</td>  
                                <td class='py-2 px-4 border-b' id='status-{$order['ORDERID']}'>{$order['P_STATUS']}</td>  
                                <td class='py-2 px-4 border-b'>  
                                    <button onclick='approveOrder({$order['ORDERID']})' class='bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600'>Approve</button>  
                                    <button onclick='openDeclinePopup({$order['ORDERID']})' class='bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600'>Reject</button>  
                                </td>  
                            </tr>";  
                        }  

                        if (oci_num_rows($stmt) == 0) {  
                            echo "<tr><td colspan='6' class='text-center py-4'>No orders found.</td></tr>";  
                        }  

                        oci_free_statement($stmt);  
                        oci_close($dbconn);  
                        ?>  
                    </tbody>  
                </table>  
            </div>  

            <!-- Back Button -->  
            <div class="mt-6 text-center">  
                <button onclick="window.history.back()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Back</button>  
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

            // Send AJAX request to update order status  
            fetch('update_order_status.php', {  
                method: 'POST',  
                headers: {  
                    'Content-Type': 'application/x-www-form-urlencoded'  
                },  
                body: new URLSearchParams({  
                    'orderId': currentOrderId,  
                    'status': 'rejected'  
                })  
            })  
            .then(response => response.json())  
            .then(data => {  
                if (data.success) {  
                    console.log(`Order #${currentOrderId} declined. Reason: ${fullReason}`);  
                    document.getElementById(`status-${currentOrderId}`).innerText = 'Rejected';  
                    closeDeclinePopup();  
                } else {  
                    console.error('Failed to decline order:', data.error);  
                }  
            })  
            .catch(error => console.error('Error:', error));  
        }  

        function approveOrder(orderId) {  
            fetch('update_order_status.php', {  
                method: 'POST',  
                headers: {  
                    'Content-Type': 'application/x-www-form-urlencoded'  
                },  
                body: new URLSearchParams({  
                    'orderId': orderId,  
                    'status': 'approved'  
                })  
            })  
            .then(response => response.json())  
            .then(data => {  
                if (data.success) {  
                    document.getElementById(`status-${orderId}`).innerText = 'Approved';  
                    document.getElementById('successPopup').style.display = 'flex';  
                    setTimeout(() => {  
                        closeSuccessPopup();  
                    }, 1500);  
                } else {  
                    console.error('Failed to approve order:', data.error);  
                }  
            })  
            .catch(error => console.error('Error:', error));  
        }  

        function closeSuccessPopup() {  
            document.getElementById('successPopup').style.display = 'none';  
        }  
    </script>  
</body>  
</html>