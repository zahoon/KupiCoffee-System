<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webleb</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="login.css">
</head>
<body style="display:flex; align-items:center; justify-content:center;">

    <div class="solid-box">
        <a href="Home.html" class="logo">Coffee For GO!!</a>
        <div class="nav-buttons">
            <a href="index.html" class="home-button">Home</a>
            <a href="Menu.php" class="menu-button">Menu</a>
        </div>
    </div>
<div class="login-page">
  <div class="form">
    <form class="login-form" action="adminStaffProcessLogin.php" method="post">
      <h2><i class="fas fa-lock"></i> Admin & Staff Login</h2>
      <input type="text" placeholder="Username" id="username" name="username" required />
      <input type="password" placeholder="Password" id="password" name ="password" required/>
      <button type="submit" name="login" id ="login" value="login">login</button>
    </form>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="login.js"></script>
</body>
</html>