<!DOCTYPE html>
<html>
<head>
    <?php require_once '../Homepage/session.php'; ?>
    <?php include 'header.php';?>
    <link rel="stylesheet" href="../Home.css">
    <script src="../script.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- bootstrap links -->
    <!-- fonts links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <!-- fonts links -->
    <style>
    body {
    margin: 0;
    background-color: rgb(255, 255, 255);
    background-size: cover;
    background-position: center;
    padding-top: 70px;
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

  #home {
            width: 100%;
            height: 100vh;
            background-image:url(../image/index.png);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: auto;
            font-family: Garamond;
            font-weight: bolder;
        }

        .about {
            width: 100%;
            height: 950px;
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url(../image/about.jpg);
            background-size: cover;
            background-position: 80%;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .content {
            padding-top: 210px;
            margin-left: 56px;
            max-width: 50%;
        }

        .content h3 {
            font-size: 50px;
            color:rgb(60, 36, 13);
        }

        .content p {
            margin-top: 10px;
            color:rgb(60, 36, 13);
        }

        #btn {
            width: 150px;
            height: 36px;
            margin-top: 20px;
            background:rgb(255, 129, 188);
            border-radius: 5px;
            font-weight: bold;
            border: none;
            transition: 0.5s ease;
            cursor: pointer;
        }

        #btn:hover {
            background:rgb(60, 36, 13);
            color:rgb(255, 129, 188);
        }

        .image {
            position: absolute;
            right: 50px;
            top: 30%;
            width: 300px;
            height: 300px;
            border-radius: 50%;
        }

        .image img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }

        .featured {
            width: 100%;
            height: 100vh;
            background-image: url(../image/top.jpg);
            background-size: cover;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .featured h2 {
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

.coffee-box {
    width: 230px;
    height: 280px;
    background-color: #FFD700;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #7a2005;
    font-size: 20px;
}
.Kopidepan{
    width: 250px;
    height: 250px;
}

.details{
  background-image:linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)), url(../image/kopi6.jpg);
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
      background-color: white;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
      z-index: 100;
    }

    #profile h1 {
      font-family: 'Poppins', sans-serif;
      text-align: center;
      color: #181444;
      font-size: 25px;
      animation: transitionIn 1s;
    }

    .greyFont {
      font-family: 'Poppins', sans-serif;
      font-size: 15px;
      color: grey;
      text-align: center;
      line-height: 5px;
      font-weight: none;
      animation: transitionIn 1s;
    }

    #profile p:not(.greyFont) {
      font-family: 'Poppins', sans-serif;
      font-size: 20px;
      color: #181444;
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
      color: blue;
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
      background-color: #181444;
      border-radius: 25px;
      font-weight: bold;
      color: white;
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
      background: white;
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
      background-color: white;

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
</head>

<body>
    <section id="home">
        <div class="content">
            <h3 style= "font-size: 45px; font-weight: bold; color:rgb(60, 36, 1); margin-top: 20px;">Brew Joy. Sip Happiness.<br>Start Your Day With Us</h3>
            <p style="font-size: 18px; font-weight: bold; color:rgb(60, 36, 1); margin-top: 20px;">Welcome to Kupi Coffee, where every sip is a celebration of flavor
                <br>Let Kupi Coffee be your perfect start 
                <br> to every adventure.
            </p>
            <button onclick="window.location.href='../Homepage/menu.php';" type="button" id="btn">Shop Now</button>
        </div>
    </section>

    <section id="about">
    <div class="about" style="display: flex; justify-content: center; align-items: center; height: 60vh;">
        <div style="text-align: center; padding: 20px;">
            <!-- Title -->
            <h1 style="font-size: 40px; font-weight: bold; color:rgb(255, 129, 188); margin-top: 20px;">About Us</h1>
            <!-- Description -->
            <p style="margin: 20px auto; max-width: 600px; font-size: 18px; color:rgb(248, 175, 66);">
                At Kupi Coffee, we pour our passion and dedication into every cup, crafting not just exceptional coffee 
                but also moments of joy, connection, and inspiration. Whether you're seeking a cozy place to start your 
                day or a comforting brew to fuel your next adventure, we’re here to make every sip unforgettable.
            </p>
            <!-- Button -->
            <button onclick="window.location.href='../Homepage/meetOurTeam.php';" type="button" id="btn">Get to know us</button>
        </div>
    </div>
</section>

    <div class="featured">
        <h3 style="font-size: 40px; font-weight: bold; color:rgb(255, 169, 209);">Try Our Top 3<br>Picked Coffee !!</h3>
        <div class="coffee-box">
            <img src="../image/AMERICANO.png" class="Kopidepan">
            <div class="coffee-name">1. AMERICANO</div>
        </div>
        <div class="coffee-box">
            <img src="../image/MOCHA.png" class="Kopidepan">
            <div class="coffee-name">2. MOCHA</div>
        </div>
        <div class="coffee-box">
            <img src="../image/LATTE.png" class="Kopidepan">
            <div class="coffee-name">3. LATTE</div>
        </div>
    </div>

    <footer id="footer">
        <div class="socail-links text-center">
            <i class="fa-brands fa-twitter"></i>
            <i class="fa-brands fa-facebook-f"></i>
            <i class="fa-brands fa-instagram"></i>
            <i class="fa-brands fa-youtube"></i>
            <i class="fa-brands fa-pinterest-p"></i>
        </div>
        <div class="copyright text-center">
            &copy; Copyright <strong><span>Kupi Coffee 2025</span></strong>. Zahin Owner
        </div>
    </footer>
    <script src="../script.js"></script>
</body>

</html>