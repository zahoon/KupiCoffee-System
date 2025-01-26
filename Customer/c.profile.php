<?php
include '../Homepage/dbkupi.php';
require_once '../Homepage/session.php';

// Check if the user is logged in
$custid = getSession('custid');
if (!$custid) {
    echo 'no custid available';
    exit();
}

// Fetch the profile information from the database
$sql = "SELECT c_username, c_pass, c_phonenum, c_email, c_address FROM customer WHERE custid = :custid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ':custid', $custid);
oci_execute($stmt);

$profile = oci_fetch_assoc($stmt);

// Function to fetch active orders (Pending status)
function fetchActiveOrders($condb) {
  $activeOrders = [];

  // Query to fetch active orders from DELIVERY and PICKUP tables with status = 'Pending'
  $query = "
      SELECT o.ORDERID, o.KUPIDATE, d.D_TIME AS delivery_time, p.P_TIME AS pickup_time, d.D_STATUS, p.P_STATUS
      FROM ORDERTABLE o
      LEFT JOIN DELIVERY d ON o.ORDERID = d.ORDERID
      LEFT JOIN PICKUP p ON o.ORDERID = p.ORDERID
      WHERE (d.D_STATUS = 'Pending' OR p.P_STATUS = 'Pending')
  ";

  $stmt = oci_parse($condb, $query);
  oci_execute($stmt);

  while ($row = oci_fetch_assoc($stmt)) {
      $orderID = $row['ORDERID'];
      $orderDate = $row['KUPIDATE'];
      $status = ($row['D_STATUS'] === 'Pending') ? 'Delivery Pending' : 'Pickup Pending';

      // Fetch order details (items) from ORDERDETAIL table
      $detailQuery = "
          SELECT od.QUANTITY, od.PRICEPERORDER, od.SUBTOTAL, od.KUPIID
          FROM ORDERDETAIL od
          WHERE od.ORDERID = :orderID
      ";

      $detailStmt = oci_parse($condb, $detailQuery);
      oci_bind_by_name($detailStmt, ':orderID', $orderID);
      oci_execute($detailStmt);

      $items = [];
      $total = 0;

      while ($detailRow = oci_fetch_assoc($detailStmt)) {
          $items[] = [
              'coffee' => 'Coffee Name', // Replace with actual coffee name if you have a mapping
              'quantity' => $detailRow['QUANTITY'],
              'price' => $detailRow['PRICEPERORDER'],
          ];
          $total += $detailRow['SUBTOTAL'];
      }

      $activeOrders[] = [
          'id' => $orderID,
          'date' => $orderDate,
          'status' => $status,
          'total' => $total,
          'items' => $items,
      ];
  }

  return $activeOrders;
}

// Function to fetch order history (completed orders)
function fetchOrderHistory($condb) {
  $orderHistory = [];

  // Query to fetch completed orders from ORDERTABLE
  $query = "
      SELECT ORDERID, KUPIDATE, (SELECT SUM(SUBTOTAL) FROM ORDERDETAIL WHERE ORDERID = o.ORDERID) AS total
      FROM ORDERTABLE o
      WHERE ORDERID NOT IN (
          SELECT ORDERID FROM DELIVERY WHERE D_STATUS = 'Pending'
          UNION
          SELECT ORDERID FROM PICKUP WHERE P_STATUS = 'Pending'
      )
  ";

  $stmt = oci_parse($condb, $query);
  oci_execute($stmt);

  while ($row = oci_fetch_assoc($stmt)) {
      $orderHistory[] = [
          'id' => $row['ORDERID'],
          'date' => $row['KUPIDATE'],
          'amount' => $row['TOTAL'],
      ];
  }

  return $orderHistory;
}

// Fetch active orders and order history
$activeOrders = fetchActiveOrders($condb);
$orderHistory = fetchOrderHistory($condb);


// Free the statement
oci_free_statement($stmt);

// Close the database connection
oci_close($condb);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
    .profile-image {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #f9a8d4;
    }
    .default-avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background-color: #f9a8d4;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      font-weight: bold;
      color: white;
      border: 4px solid #f9a8d4;
    }
    .scrollable-box {
      max-height: 180px; /* Adjust height as needed */
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
  </style>
</head>
<body>
  <?php include '../Homepage/header.php'; ?>
  <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
    <h1 class="text-3xl font-bold text-pink-600 mb-6">Customer Profile</h1>

    <!-- Personal Info and Edit Button -->
    <div class="bg-pink-50 p-4 rounded-lg mb-6">
      <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
          <?php
          $profileImage = '../image/profile.png'; 
          if ($profileImage) {
            echo "<img src='$profileImage' alt='profile' class='profile-image'>";
          } else {
            echo "<div class='default-avatar'>" . substr('Profile', 0, 1) . "</div>";
          }
          ?>
          <div>
            <p><span class="font-medium">Name:</span> <span id="profileName"><?php echo htmlspecialchars($profile['C_USERNAME']); ?></span></p>
            <p><span class="font-medium">Password:</span> <span id="profilePassword"><?php echo htmlspecialchars($profile['C_PASS']); ?></span></p>
            <p><span class="font-medium">Phone:</span> <span id="profilePhone"><?php echo htmlspecialchars($profile['C_PHONENUM']); ?></span></p>
            <p><span class="font-medium">Email:</span> <span id="profileEmail"><?php echo htmlspecialchars($profile['C_EMAIL']); ?></span></p>
            <p><span class="font-medium">Address:</span> <span id="profileAddress"><?php echo htmlspecialchars($profile['C_ADDRESS']); ?></span></p>
          </div>
        </div>
        <button onclick="openPopup()" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">Edit Profile</button>
      </div>
    </div>

    <!-- Active Orders and Order History -->
    <div class="grid grid-cols-2 gap-6">
    <!-- Active Orders -->
    <div class="bg-pink-50 p-4 rounded-lg">
        <h2 class="text-xl font-semibold text-pink-700 mb-4">Active Orders</h2>
        <div class="scrollable-box">
            <?php
            if (!empty($activeOrders)) {
                foreach ($activeOrders as $activeOrder) {
                    echo "
                    
                        
                        <div class='flex justify-between items-center p-4 bg-pink-100 rounded-lg'>
                            <div>
                                <p class='font-medium'>Order #{$activeOrder['id']}</p>
                                <p><span class='font-medium text-pink-700'>{$activeOrder['status']}</span></p>
                            </div>
                            <p class='text-pink-700'>RM{$activeOrder['total']}</p>
                        </div> </br>
                    ";

                    

                    
                }
            } else {
                echo "<p class='text-gray-600'>No active orders found.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Order History -->
    <div class="bg-pink-50 p-4 rounded-lg">
        <h2 class="text-xl font-semibold text-pink-700 mb-4">Order History</h2>
        <div class="scrollable-box">
            <div class="space-y-4">
                <?php
                if (!empty($orderHistory)) {
                    foreach ($orderHistory as $order) {
                        echo "
                        <div class='flex justify-between items-center p-4 bg-pink-100 rounded-lg'>
                            <div>
                                <p class='font-medium'>Order #{$order['id']}</p>
                                <p class='text-sm text-gray-600'>Date: {$order['date']}</p>
                            </div>
                            <p class='text-pink-700'>RM{$order['amount']}</p>
                        </div>
                        ";
                    }
                } else {
                    echo "<p class='text-gray-600'>No order history found.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
  </div>

  <!-- Popup Form -->
  <div id="popup" class="popup">
    <div class="popup-content">
      <h2 class="text-xl font-bold text-pink-700 mb-4">Edit Profile</h2>
      <form action="c_profile.php" method="post" onsubmit="saveProfile(event)">
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input name="username" type="text" id="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg" value="<?php echo htmlspecialchars($profile['C_USERNAME']); ?>" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input name="password" type="text" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg" value="<?php echo htmlspecialchars($profile['C_PASS']); ?>" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Phone</label>
            <input name="phonenum" type="tel" id="phonenum" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg" value="<?php echo htmlspecialchars($profile['C_PHONENUM']); ?>" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input name="email" type="email" id="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg" value="<?php echo htmlspecialchars($profile['C_EMAIL']); ?>" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Address</label>
            <input name="address" type="text" id="address" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg" value="<?php echo htmlspecialchars($profile['C_ADDRESS']); ?>" required>
          </div>
        </div>
        <div class="mt-6 flex justify-end space-x-4">
          <button type="button" onclick="closePopup()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Cancel</button>
          <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">Save</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Function to open the popup
    function openPopup() {
      document.getElementById('popup').style.display = 'flex';
    }

    // Function to close the popup
    function closePopup() {
      document.getElementById('popup').style.display = 'none';
    }

    // Function to save the profile
    function saveProfile(event) {
        event.preventDefault();
        // const username = document.getElementById('username').value;
        // const password = document.getElementById('password').value;
        // const phonenum = document.getElementById('phonenum').value;
        // const email = document.getElementById('email').value;
        // const address = document.getElementById('address').value;

        // // Update the profile info on the page
        // document.getElementById('profileName').textContent = name;
        // document.getElementById('profilePassword').textContent = password;
        // document.getElementById('profilePhone').textContent = phone;
        // document.getElementById('profileEmail').textContent = email;
        // document.getElementById('profileAddress').textContent = address;

        // Submit the form
        event.target.submit();

        // Close the popup
        closePopup();
    }
  </script>
</body>
</html>