<?php 
include("dbconn.php");
session_start();
if (isset($_SESSION['username'])){
    //execute sql statement
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM customer WHERE custUsername ='$username'";
    $query = mysqli_query($dbconn,$sql) or die ("Error:  ".mysqli_error($dbconn));
    $row = mysqli_num_rows($query);
    if($row == 0){
        echo "No record is found";
    }else {
        $fetch = mysqli_fetch_assoc($query);
        $custName = $fetch['custUsername'];
        $custphoneNum = $fetch['custPhoneNum'];
        $custPassword = $fetch['custPassword'];
        $custAddress = $fetch['custAddress'];
        ?>

<!DOCTYPE html>
<html>

<head>
    <title>Coffee Menu</title>
    <style>
        body {
    margin: 0;
    background-color: #fff;
    background-size: cover;
    background-position: center;
}

.solid-box {
    background-color: #FFD700;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 100;
    transition: background-color 0.3s ease;
  }

.solid-box.scrolled {
    background-color: #7a2005;
  }

.logo {
    color: #7a2005;
    text-decoration: none;
    padding: 10px 20px;
    transition: background-color 0.3s ease;
    font-size: 60px;
    font-family: Bedrock;
    font-weight: bold;
}

.nav-buttons {
    display: flex;
    gap: 20px;
}

.home-button,
.menu-button,
.login-button,
#cart-button {
    color:  #7a2005;
    text-decoration: none;
    padding: 10px 20px;
    transition: background-color 0.3s ease;
    font-size: larger;
    font-weight: bold;
    margin-right: 50px;
    text-transform: uppercase;
}

.home-button:hover,
.menu-button:hover,
.login-button:hover {
    background-color: #ffffff;
}

.menu-header1 {
    color: #7a2005;
    font-size: 30px;
    margin-top: 120px;
    margin-bottom: -20px;
    text-align: center;
}

.menu-header2 {
    color: #7a2005;
    font-size: 30px;
    text-align: center;
}
.menu-header3{
    color: #7a2005;
    font-size: 30px;
    text-align: center;
}
.menu-header4{
    color: #7a2005;
    font-size: 30px;
    text-align: center;
}
.menu-container {
            display: grid;
            width: 1800px;
            margin-top: 80px;
            margin-left: 60px;
        }

        .coffee-item {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: #FFD700;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .coffee-item img {
            width: 250px;
            height: auto;
            margin-right: 20px;
        }

        .coffee-item .info {
            flex: 1;
        }

        .coffee-item h3 {
            margin: 0;
            color: #7a2005;
            font-weight: 900;
            font-size: 33px;
        }

        .coffee-item p {
            margin-top: 10px;
            color: #000000;
        }
        
.table{
   border: 1;
   max-width: 100px;
}

#cart-button {
    color:  #7a2005;
    text-decoration: none;
    padding: 10px 20px;
    transition: background-color 0.3s ease;
    font-size: larger;
    font-weight: bold;
    margin-right: 50px;
    text-transform: uppercase;
}
  .info p{
    color: #7a2005;
    font-size: medium;
  }

  #profile {
      position: fixed;
      top: 55%;
      left: 50%;
      transform: translate(-50%, -50%);
      border-radius: 45px;
      width: 600px;
      height: 800px;
      background-color: #7a2005;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
      z-index: 100;
    }

    #profile h1 {
      font-family: 'Poppins', sans-serif;
      text-align: center;
      color: white;
      font-size: 25px;
      font-weight: bold;
      animation: transitionIn 1s;
    }

    .greyFont {
      font-family: 'Poppins', sans-serif;
      font-size: 15px;
      color: #FFD700;
      text-align: center;
      line-height: 7px;
      font-weight: none;
      animation: transitionIn 1s;
    }

    #profile p:not(.greyFont) {
      font-family: 'Poppins', sans-serif;
      font-size: 20px;
      color: white;
      margin-left: 50px;
      max-width: 500px;
      line-height: 25px;
      text-align: center;
      font-weight: bold;
      animation: transitionIn 1s;
    }

  .edit {
    width: 100px;
    height: 40px;
    background-color: white;
    border-radius: 20px;
    font-weight: bold;
    color: #FFD700;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    margin-top: 80px;
    margin-left: 250px;
    border: none;
    outline: none;
    transition: box-shadow 0.2s ease-in-out;
    animation: transitionIn 1s;
  }

  .history {
    width: 500px;
    height: 50px;
    background-color: #FFD700;
    border-radius: 25px;
    font-weight: bold;
    color: black;
    text-align: center;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    margin-top: 5px;
    margin-left: 50px;
    border: none;
    outline: none;
    transition: box-shadow 0.2s ease-in-out;
    animation: transitionIn 1s;
  }

  #profile button:not(.edit):not(.history) {
      width: 100px;
      height: 40px;
      background-color: white;
      border-radius: 20px;
      font-weight: bold;
      color: red;
      font-family: 'Poppins', sans-serif;
      font-size: 16px;
      margin-top: 10px;
      margin-left: 250px;
      border: none;
      outline: none;
      transition: box-shadow 0.2s ease-in-out;
      animation: transitionIn 1s;
    }

    #profile button:hover {
      box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
    }

    .imgThree {
      width: 150px;
      height: 150px;
      margin-top: 10px;
      margin-left: 225px;
      animation: transitionIn 1s;
    }

    #profile img:not(.imgThree) {
      position: absolute;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-top: 15px;
      margin-left: 10px;
      rotate: 180deg;
      transition: box-shadow 0.2s ease-in-out;
    }

    #profile img:hover:not(.imgThree) {
      box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
    }

  .add-to-cart-button{
        width: 150px;
        height: 36px;
        margin-top: 20px;
        background: #7a2005;
        border-radius: 5px;
        font-weight: bold;
        border: none;
        transition: 0.5s ease;
        cursor: pointer;
        color: white;
        margin-left: 500px;
    }
    .add-to-cart-button:hover{
        background: #ffffff;
        color: #7a2005;
    }
    </style>
</head>
<script>
        <?php
        include("dbconn.php");
        // Assuming you have a database connection established
        // and the item data is stored in a table called "items"
        // with columns: id, name, price, image_path
        
        // Fetch the item records from the database
        $query = "SELECT * FROM menu";
        $result = mysqli_query($dbconn, $query);

        // Iterate over the IDs and generate CSS for each Popup
        while ($row = mysqli_fetch_assoc($result)) {
            $menuID = $row['menuID'];
            ?>

            function showItem(menuID) {
                document.getElementById("popup_" + menuID).style.display = "block";
                document.getElementById("cover").style.display = "block";
            }

            function closeItem(menuID) {
                document.getElementById("popup_" + menuID).style.display = "none";
                document.getElementById("cover").style.display = "none";
            }

            <?php
        }
        ?>
            function showProfile() {
                document.getElementById("profile").style.display = "block";
                document.getElementById("cover").style.display = "block";
            }
            function closeProfile() {
                document.getElementById("profile").style.display = "none";
                document.getElementById("cover").style.display = "none";
            }
            function showCompleted() {
            document.getElementById("completed").style.display = "block";
            document.getElementById("cover").style.display = "block";
            setTimeout(closeCompleted, 2000);
            }
            function closeCompleted() {
                document.getElementById("completed").style.display = "none";
                document.getElementById("cover").style.display = "none";
            }
            function showCart() {
			document.getElementById("cart").style.display = "block";
			document.getElementById("cover").style.display = "block";
			}

			function closeCart() {
			document.getElementById("cart").style.display = "none";
			document.getElementById("cover").style.display = "none";
			}

            function searchMenu() {
  // Get the search input value
  var searchInput = document.getElementById("searchBar").value.toLowerCase();

  // Get all the menu item elements
  var menuItems = document.getElementsByClassName("searchCont");

  // Loop through each menu item and check if it matches the search input
  for (var i = 0; i < menuItems.length; i++) {
    var menuItem = menuItems[i];
    var menuItemText = menuItem.textContent || menuItem.innerText;

    // Hide or show the menu item based on the search input
    if (menuItemText.toLowerCase().indexOf(searchInput) > -1) {
      menuItem.style.display = "";
    } else {
      menuItem.style.display = "none";
    }
  }
}
</script>
<body>
    <div class="solid-box">
        <a href="index.html" class="logo">COFFEE FOR GO!!</a>
        <div class="nav-buttons">
            <a href="HomeCust.php" class="home-button">Home</a>
            <a href="MenuCust.php" class="menu-button">Menu</a>
            <a class="login-button" onclick="showProfile()">PROFILE (
                <?php echo $_SESSION['username']; ?>)
            </a>
            <button onclick="showCart()" id="cart-button">Cart</button>
        </div>
        <div id='completed' hidden>
                <p>Product Added To Cart!</p>
                </div>
                <div id='cover' style='display:none'></div>

                <div id='cart' hidden>
                <p>Choose Type Of Services</p>
                <a href="cartDeliver.php">
                <button>Delivery</button>
                </a>
                <a href="cartPickup.php">
                <button>Pickup</button>
                </a>
                <button onclick="closeCart()">Back</button>
                </div>
                <div id='cover' style='display:none'></div>

                <input type="text" id="searchBar" placeholder="Search menu items..." onkeyup="searchMenu()">
    <div id='profile' style='display:none'>
    <img onclick="closeProfile()" src="image/blackArrow.png">
    <h1>My Profile</h1>
    <img src="image/profile.png" class="imgThree">
    <p class="greyFont">Username</p>
    <p>
      <?php echo $custName; ?>
    </p>
    <p class="greyFont">Phone Number</p>
    <p>
      <?php echo $custphoneNum; ?>
    </p>
    <p class="greyFont">Address</p>
    <p>
      <?php echo $custAddress; ?>
    </p><br>
    <p class="greyFont">Dashboard</p>
    <a href="custOrder.php">
      <button class="history">Order History</button>
    </a>
    <a href="custEdit.php">
      <button class="edit">Edit Profile</button>
    </a>
    <a href="logout.php">
      <button>Logout</button>
    </a>
  </div>
        
    </div>
    <div id='completed' style='display:none'>
                <p>Product Added To Cart!</p>
    </div>
    <section class="menu-section">
        <h2 class="menu-header1">Coffee Menu</h2>
        <table height="50%" class="table">
        <?php 
                include("dbconn.php");
                $q = "SELECT * FROM menu WHERE menuType ='COFFEE' ";
                $result = mysqli_query($dbconn,$q);

                while($row = mysqli_fetch_assoc($result)){
                    $coffeeID = $row['menuID'];
                    $coffeeName = $row['menuName'];
                    $coffeePrice = $row['menuPrice'];
                    $coffeeDesc = $row['menuDesc'];
                    $coffeeStatus = $row['menuStatus'];
                    $coffeeImage = $row['menuImage'];
                
                ?>
            <tr class="searchCont">
                <td>
                    <div class="menu-container searchCont">
                        <div class="coffee-item">
                        <img src="coffeepastry/<?php echo $coffeeImage; ?>" alt="Coffee 1">
                            <div class="info">
                                <h3><?php echo $coffeeName; ?></h3>
                                <p><?php echo $coffeeDesc;?></p>
                                <p>RM<?php echo $coffeePrice; ?> </p>
                                <?php if ($coffeeStatus == 'UNAVAILABLE'){ ?>
                                    <button class="add-to-cart-button">Unavailable</button>
                                <?php } else {?>
                                <a href="addtocartProcess.php?menuID=<?php echo $coffeeID; ?>">
                                <button onclick = "showCompleted()" class="add-to-cart-button">Add To Cart</button>
                                </a>
                
                                <?php } ?>
                            </div> 
                        </div>
                    </div>
                </td>
            </tr>
            <?php 
                }
                ?>
        </table>
    </section>
    <section class="menu-section2">
        <h2 class="menu-header2">Pastry Menu</h2>
        <table height="50%" class="table">
        <?php 
                $q = "SELECT * FROM menu where menuType ='PASTRY' ";
                $result = mysqli_query($dbconn,$q);

                while($row = mysqli_fetch_assoc($result)){
                    $pastryID = $row['menuID'];
                    $pastryName = $row['menuName'];
                    $pastryPrice = $row['menuPrice'];
                    $pastryDesc = $row['menuDesc'];
                    $pastryStatus = $row['menuStatus'];
                    $pastryImage = $row['menuImage'];
                
                ?>
            <tr class="searchCont">
            <td>
            <div class="menu-container searchCont">
                    <div class="coffee-item">
                    <img src="coffeepastry/<?php echo $pastryImage; ?>">
                    <div class="info">
                        <h3><?php echo $pastryName ?></h3>
                        <p><?php echo $pastryDesc;?></p>
                        <p>RM<?php echo $pastryPrice; ?> </p>
                        <?php if ($pastryStatus == 'UNAVAILABLE'){ ?>
                            <button class="add-to-cart-button">Unavailable</button>
                    <?php } else {?>
                    <a href="addtocartProcess.php?menuID=<?php echo $pastryID; ?>">
                            <button onclick = "showCompleted()" class="add-to-cart-button">Add To Cart</button>
                </a>
                <?php } ?>
                    </div> 
                </div>
            </div>
                </td>
            </tr>
            <?php 
                }
                ?>
        </table>
    </section>
    <section class="menu-section3">
        <h2 class="menu-header3">Frappe Menu</h2>
        <table height="50%" class="table">
        <?php 
                $q = "SELECT * FROM menu where menuType ='FRAPPE' ";
                $result = mysqli_query($dbconn,$q);

                while($row = mysqli_fetch_assoc($result)){
                    $frappeID = $row['menuID'];
                    $frappeName = $row['menuName'];
                    $frappePrice = $row['menuPrice'];
                    $frappeDesc = $row['menuDesc'];
                    $frappeStatus = $row['menuStatus'];
                    $frappeImage = $row['menuImage'];
                
                ?>    
            <tr class="searchCont">
            <div class="menu-container searchCont">
                    <div class="coffee-item">
                    <img src="coffeepastry/<?php echo $frappeImage; ?>">
                    <div class="info">
                        <h3><?php echo $frappeName ?></h3>
                        <p><?php echo $frappeDesc;?></p>
                        <p>RM<?php echo $frappePrice; ?> </p>
                        <?php if ($frappeStatus == 'UNAVAILABLE'){ ?>
                            <button class="add-to-cart-button">Unavailable</button>
                    <?php } else {?>
                    <a href="addtocartProcess.php?menuID=<?php echo $frappeID; ?>">
                            <button onclick = "showCompleted()" class="add-to-cart-button">Add To Cart</button>
                </a>
                <?php } ?>
                    </div> 
                </div>
            </div>
                </td>
                
            </tr>
            <?php 
                }
                ?> 
        </table>
    </section>
    <section class="menu-section4">
        <h2 class="menu-header4">Hot Meals Menu</h2>
        <table height="50%" class="table">
            <?php 
                $q = "SELECT * FROM menu where menuType ='HOT MEALS' ";
                $result = mysqli_query($dbconn,$q);

                while($row = mysqli_fetch_assoc($result)){
                    $hotMealsID = $row['menuID'];
                    $hotMealsName = $row['menuName'];
                    $hotMealsPrice = $row['menuPrice'];
                    $hotMealsDesc = $row['menuDesc'];
                    $hotMealsStatus = $row['menuStatus'];
                    $hotMealsImage = $row['menuImage'];
                
                ?>
            <tr class="searchCont">
            <div class="menu-container searchCont">
                    <div class="coffee-item">
                    <img src="coffeepastry/<?php echo $hotMealsImage; ?>">
                    <div class="info">
                        <h3><?php echo $hotMealsName ?></h3>
                        <p><?php echo $hotMealsDesc;?></p>
                        <p>RM<?php echo $hotMealsPrice; ?> </p> 
                        <?php if ($hotMealsStatus == 'UNAVAILABLE'){ ?>
                            <button class="add-to-cart-button">Unavailable</button>
                    <?php } else {?>
                    <a href="addtocartProcess.php?menuID=<?php echo $hotMealsID; ?>">
                            <button onclick = "showCompleted()" class="add-to-cart-button">Add To Cart</button>
                </a>
                <?php } ?>
                    </div> 
                </div>
            </div> 
            </tr>
            </td>
                <?php 
                }
                ?>
        </table>
    </section>
    <script src="script.js"></script>
</body>

</html>
<?php 
    }
}else{
    header("Location: Login.html");
}
?>