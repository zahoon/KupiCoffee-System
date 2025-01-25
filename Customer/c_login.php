<?php
// Include required files for session management and database connection
require_once '../Homepage/session.php';
include("../Homepage/dbkupi.php");

// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to validate the username and password
    $sql = "SELECT * FROM customer WHERE c_username = :c_username AND c_pass = :c_pass";
    $stmt = oci_parse($condb, $sql);

    oci_bind_by_name($stmt, ':c_username', $username);
    oci_bind_by_name($stmt, ':c_pass', $password);

    oci_execute($stmt);

    // If a matching user is found
    if ($row = oci_fetch_assoc($stmt)) {
        // Set session variables
        setSession('custid', $row['CUSTID']);
        setSession('username', $row['C_USERNAME']);
        setSession('password', $row['C_PASS']);
        setSession('phonenum', $row['C_PHONENUM']);
        setSession('email', $row['C_EMAIL']);
        setSession('address', $row['C_ADDRESS']);

        // Redirect to the homepage or dashboard
        header("Location: ../Homepage/index.php");
        exit();
    } else {
        // Login failed, set error message
        $_SESSION['error'] = "Incorrect username or password.";
        header("Location: c_login.php");
        exit();
    }

    oci_free_statement($stmt);
}
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webleb</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url(https://fonts.googleapis.com/css?family=Poppins:300);

        body {
            height: 100vh;
            overflow: hidden;
            font-family: "Poppins";
            background: #ffffff;
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
            font-family: fantasy;
        }

        .nav-buttons {
            display: flex;
            gap: 20px;
        }

        .home-button, .menu-button {
            color: #7a2005;
            text-decoration: none;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
            font-size: larger;
            font-weight: bold;
            margin-right: 50px;
            text-transform: uppercase;
        }

        .home-button:hover, .menu-button:hover {
            background-color: #ffffff;
        }

        .login-page {
            width: 400px;
            padding: 8% 0 0;
            margin: auto;
        }

        .form {
            position: relative;
            z-index: 1;
            background: #FFFFFF;
            max-width: 400px;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }

        .form input {
            font-family: "Poppins", sans-serif;
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            border-radius: 7px;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .form button {
            font-family: "Poppins", sans-serif;
            text-transform: uppercase;
            outline: 0;
            background: #FFD700;
            width: 100%;
            border: 0;
            padding: 15px;
            color: #000000;
            border-radius: 7px;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .form button:hover, .form button:active, .form button:focus {
            background: #FFD700;
        }

        .form .message {
            margin: 15px 0 0;
            color: #b3b3b3;
            font-size: 12px;
        }

        .form .message a {
            color: #FFD700;
            text-decoration: none;
        }

        .form .register-form {
            display: none;
        }
    </style>
    <script>
        function validatePhoneNumberMalaysia(phoneNumber) {
            const phoneNumberRegex = /^\+60 1[0-9]{9}$/;
            if (!phoneNumberRegex.test(phoneNumber)) {
                document.getElementById("phone_number_error").innerHTML = "Please enter a valid Malaysian phone number.";
            } else {
                document.getElementById("phone_number_error").innerHTML = "";
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const messageLinks = document.querySelectorAll('.message a');
            messageLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const forms = document.querySelectorAll('form');
                    forms.forEach(form => {
                        form.style.display = form.style.display === 'none' ? 'block' : 'none';
                    });
                });
            });
        });
    </script>
</head>

    <div class="login-page">
        <div class="form">
        <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='error'>{$_SESSION['error']}</div>";
                unset($_SESSION['error']); // Clear the error message after displaying
            }
            ?>
            <form class="register-form" action="" method="POST">
                <h2><i class="fas fa-lock"></i> Register</h2>
                <input type="text" id="username" name="username" placeholder="Username*" required/>
                <input type="email" placeholder="Email*" id="email" name="email" required/>
                <input type="text" onkeyup="validatePhoneNumberMalaysia(this.value)" placeholder="Phone Number*" id="phoneNum" name="phoneNum" required/>
                <span id="phone_number_error" style="color: red;"></span>
                <input type="password" placeholder="Password*" id="password" name="password" required/>
                <input type="password" placeholder="Confirm Password*" id="confirm-password" name="confirm-password" required/>
                <input type="text" id="address" name="address" placeholder="Full Address*" required/>
                <button type="submit" name="submit" value="submit">Create</button>
                <p class="message">Already registered? <a href="#">Sign In</a></p>
            </form>
            <form class="login-form" action="" method="post">
                <h2><i class="fas fa-lock"></i> Login</h2>
                <input type="text" placeholder="Username" id="username" name="username" required />
                <input type="password" placeholder="Password" id="password" name="password" required/>
                <button type="submit" name="login" value="login">Login</button>
                <p class="message">Not registered? <a href="#">Create an account</a></p>
            </form>
        </div>
    </div>


    
</body>
</html> -->
