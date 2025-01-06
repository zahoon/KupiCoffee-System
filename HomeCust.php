<?php
include("dbconn.php");
session_start();
if (isset($_SESSION['username'])) {
  //execute sql statement
  $username = $_SESSION['username'];
  $sql = "SELECT * FROM customer WHERE custUsername ='$username'";
  $query = mysqli_query($dbconn, $sql) or die("Error:  " . mysqli_error($dbconn));
  $row = mysqli_num_rows($query);
  if ($row == 0) {
    echo "No record is found";
  } else {
    $fetch = mysqli_fetch_assoc($query);
    $custName = $fetch['custUsername'];
    $custphoneNum = $fetch['custPhoneNum'];
    $custPassword = $fetch['custPassword'];
    $custAddress = $fetch['custAddress'];
  
?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Homepage</title>
  <style>
          *{
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif
}

body {
    margin: 0;
    background-color: rgb(255, 255, 255);
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
    color:#7a2005;
    text-decoration: none;
    transition: background-color 0.3s ease;
    padding: 10px 20px;
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

* {
    box-sizing: border-box;
  }
  
  img {
    vertical-align: middle;
  }

  #home{
    width: 100%;
    height: 100vh;
    background-image:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)), url(image/kopi2.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: 80%;
    font-family: Garamond;
    font-weight: bolder;
}
.image{
  width: 200px;
  height: 200px;
  border-radius: 500px;
}
.content{
  padding-top: 210px;
  margin-left: 56px;
}
.content h3{
  font-size: 50px;
  color: #FFD700;
}
.content p{
  margin-top: 10px;
  color: #FFD700;
}
#btn{
  width: 150px;
  height: 36px;
  margin-top: 20px;
  background: #FFD700;
  border-radius: 5px;
  font-weight: bold;
  border: none;
  transition: 0.5s ease;
  cursor: pointer;
}
#btn:hover{
  background: #ffffff;
  color: #7a2005;
}

.featured {
    width: 100%;
    height: 950px;
    background-image:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)),  url(image/kopi3.jpg);
    background-size: cover;
    display: flex;
    justify-content: space-around;
    align-items: center;
}

.featured h2{
  color: #ffffff;
}

.featured .coffee-box {
  position: relative;
}

.featured .coffee-name {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 10px;
  background-color: rgba(0, 0, 0, 0.7);
  color: #fff;
  font-weight: bold;
  text-align: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.featured .coffee-box:hover .coffee-name {
  opacity: 1;
}

.featured .coffee-box img {
  transition: transform 0.3s ease;
}

.featured .coffee-box img:hover {
  transform: scale(1.1);
}
.info p{
    color: #7a2005;
    font-size: medium;
  }
.coffee-box {
    width: 200px;
    height: 200px;
    background-color: #FFD700;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #7a2005;
    font-size: 20px;
}
.Kopidepan{
    width: 190px;
    height: 190px;
}

.details{
  background-image:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)), url(image/kopi6.jpg);
  background-size: cover;
}
.staf{
  margin-left: 660px;
}
  .staf p{
    margin-left: 10px;
    color: #fff;
  }
  .staff {
    width: 200px;
    height: 200px;
    background-color: #FFD700;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #7a2005;
    font-size: 20px;
    margin-top: 10px;
    
}
.admin{
    width: 190px;
    height: 190px;
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
      font-weight: bold;
      font-size: 25px;
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

    #cover {
      position: fixed;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      background-color: rgba(0, 0, 0, 0.8);
      z-index: 99;
    }

    .footer {
      background: var(--black);
      text-align: center;
    }

    .footer .share {
      padding: 1rem 0;
    }

    .footer .share a {
      height: 5rem;
      width: 5rem;
      line-height: 5rem;
      font-size: 2rem;
      color: #fff;
      border: var(--border);
      margin: .3rem;
      border-radius: 50%;
    }

    .footer .share a:hover {
      background-color: var(--main-color);

    }

    .footer .links {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      padding: 2rem 0;
      gap: 1rem;
    }

    .footer .links a {
      padding: 7rem 2rem;
      color: #fff;
      border: var(--border);
      font-size: 2rem;
    }

    .footer .links a :hover {
      background: var(--main-color);
    }

    html {
      scroll-behavior: smooth;
    }
  </style>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- bootstrap links -->
  <!-- fonts links -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
  <!-- fonts links -->
</head>
<script>
  function showProfile() {
    document.getElementById("profile").style.display = "block";
    document.getElementById("cover").style.display = "block";
  }
  function closeProfile() {
    document.getElementById("profile").style.display = "none";
    document.getElementById("cover").style.display = "none";
  }
</script>

<body>
  <div id='profile' style='display:none'>
    <img onclick="closeProfile()" src="image/blackArrow.png">
    <h1>My Profile</h1>
    <img src="image/profile.png" class="imgThree">
    <br><br>
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
  <div id='cover' style='display:none'></div>
  <div class="solid-box">
    <a href="HomeCust.php" class="logo">COFFEE FOR GO!!</a>
    <div class="nav-buttons">
      <a href="HomeCust.php" class="home-button">Home</a>
      <a href="MenuCust.php" class="menu-button">Menu</a>
      <a class="login-button" onclick="showProfile()">PROFILE (
        <?php echo $_SESSION['username']; ?>)
      </a>
      <button onclick="showCompleted()" id="cart-button">Cart</button>
    </div>
  </div>

  <section id="home">
    <div class="content">
      <div class="image">
        <img src="image/logo.png" class="image">
      </div>
      <h3>Start Your Day With a <br> Fresh Coffee</h3>
      <p>Everyone should believe in something. I believe I will have another coffee.
        <br>Humanity runs on coffee.
      </p>
      <button id="btn">Shop Now</button>
    </div>
  </section>

  <div class="featured">
      <h2>Top Picked Coffee</h2>
      <div class="coffee-box">
        <img src="image/AMERICANO.png" class="Kopidepan">
        <div class="coffee-name">AMERICANO</div>
      </div>
      <div class="coffee-box">
        <img src="image/MOCHA.png" class="Kopidepan">
        <div class="coffee-name">MOCHA</div>
      </div>
      <div class="coffee-box">
        <img src="image/LATTE.png" class="Kopidepan">
        <div class="coffee-name">LATTE</div>
      </div>
      <div class="coffee-box">
        <img src="image/SALTED_CARAMEL_LATTE.png" class="Kopidepan">
        <div class="coffee-name">SALTED CARAMEL LATTE</div>
      </div>
    </div>
    <!-- <div class="details">
    <table border="0" class="staf">
        <tr>
          <td>
            <div class="staff">
              <img src="image/Eiman.png" class="admin">
          </div>
          </td>
          <td>
            <p>Nama : Eiman Damien Bin Rohmat</p>
            <p>Student ID : 2021466508</p>
            <p>IC Number : 030916-10-0261</p>
          </td>
        </tr>
        <tr>
          <td>
            <div class="staff">
              <img src="image/Izzuddin.png" class="admin">
          </div>
          </td>
          <td>
            <p>Nama : Muhammad Izzuddin Bin Mohd Fathi</p>
            <p>Student ID : 2021893118</p>
            <p>IC Number : 030609-10-0077</p>
          </td>
        </tr>
        <tr>
          <td>
            <div class="staff">
              <img src="image/Zahin.png" class="admin">
          </div>
          </td>
          <td>
            <p>Nama : Muhammad Zahin Eifwwat Bin Mohd Rosli</p>
            <p>Student ID : 2021650086</p>
            <p>IC Number : 030929-06-0203</p>
          </td>
        </tr>
        <tr>
          <td>
            <div class="staff">
              <img src="image/Naqib.png" class="admin">
          </div>
          </td>
          <td>
            <p>Nama : Wan Muhammad Naqib Bin Wan Mohd Nazri</p>
            <p>Student ID : 2021453086</p>
            <p>IC Number : 030711-06-0307</p>
          </td>
        </tr>
    </div>
      </table>
    </div> -->

  <!-- footer -->
  <footer id="footer">
    <div class="socail-links text-center">
      <i class="fa-brands fa-twitter"></i>
      <i class="fa-brands fa-facebook-f"></i>
      <i class="fa-brands fa-instagram"></i>
      <i class="fa-brands fa-youtube"></i>
      <i class="fa-brands fa-pinterest-p"></i>
    </div>
    <div class="copyright text-center">
      &copy; Copyright <strong><span>Coffee Shop</span></strong>. All Rights Reserved
    </div>


  </footer>
  <script src="script.js"></script>
</body>

</html>
<?php 
    }
}else{
    header("Location: Login.html");
}
?>