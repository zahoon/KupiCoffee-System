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
<body class="bg-gray-100">  
    <?php include '../Homepage/header.php'; ?>  
    <div class="flex items-center justify-center h-screen">  
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">  
            <h2 class="text-2xl font-bold mb-6 text-center">Delivery Orders</h2>  
            <div class="overflow-x-auto">  
                <table class="min-w-full bg-white border border-gray-300">  
                    <thead>  
                        <tr class="bg-gray-200">  
                            <th class="py-2 px-4 border-b text-left">ORDER</th>
                            <th class="py-2 px-4 border-b text-left">ADDRESS</th>   
                            <th class="py-2 px-4 border-b text-left">TIME</th>  
                            <th class="py-2 px-4 border-b text-left">STATUS</th>  
                            <th class="py-2 px-4 border-b text-left">ACTION</th>  
                        </tr>  
                    </thead>  
                    <tbody>  
                        <?php  
                        // Database connection  
                        $username = "kupidb"; // Your Oracle database username  
                        $password = "kupidb"; // Your Oracle database password  
                        $connection_string = "localhost:1521/xe"; // Database connection string  

                        // Create connection  
                        $dbconn = oci_connect($username, $password, $connection_string);  

                        // Check connection  
                        if (!$dbconn) {  
                            $e = oci_error();  
                            die("Connection failed: " . $e['message']);  
                        }  

                        // Fetch orders from the PICKUP database  
                        $sql = "SELECT ORDERID, D_ADDRESS, D_TIME, D_STATUS FROM DELIVERY"; // Adjust the query as necessary  
                        $stmt = oci_parse($dbconn, $sql);  
                        oci_execute($stmt);  

                        // Fetch results and display in the table  
                        while ($order = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {  
                            echo "  
                            <tr class='hover:bg-gray-100'>  
                                <td class='py-2 px-4 border-b'>{$order['ORDERID']}</td>  
                                <td class='py-2 px-4 border-b'>{$order['D_ADDRESS']}</td>  
                                <td class='py-2 px-4 border-b'>{$order['D_TIME']}</td>
                                <td class='py-2 px-4 border-b'>{$order['D_STATUS']}</td>   
                                <td class='py-2 px-4 border-b'>  
                                    <button onclick='approveOrder({$order['ORDERID']})' class='bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600'>Approve</button>  
                                    <button onclick='openDeclinePopup({$order['ORDERID']})' class='bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600'>Reject</button>  
                                </td>  
                            </tr>  
                            ";  
                        }  

                        if (oci_num_rows($stmt) == 0) {  
                            echo "<tr><td colspan='4' class='text-center py-4'>No orders found.</td></tr>";  
                        }  

                        oci_free_statement($stmt);  
                        oci_close($dbconn);  
                        ?>  
                    </tbody>  
                </table>  
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
    </script>  
</body>  
</html>