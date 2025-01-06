<?php
include("dbconn.php");
session_start();
$services = $_GET['service'];
$totalPriceFormat = $_GET['price'];
$branch = $_GET['branch'];
if (isset($_SESSION['username'])) {
    /* execute SQL statement */
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM customer WHERE custUsername= '$username'";
    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error());
    $row = mysqli_num_rows($query);
    if ($row == 0) {
        echo "No record found";
    } else {
        $r = mysqli_fetch_assoc($query);
        $custUsername = $r['custUsername'];
        $custPhoneNum = $r['custPhoneNum'];
        $custAddress = $r['custAddress'];
        $custPassword = $r['custPassword'];

        // Check if all card information is provided correctly
        if (isset($_POST['cc']) && isset($_POST['cvv']) && isset($_POST['expiry_month']) && isset($_POST['expiry_year'])) {
            $cardNumber = $_POST['cc'];
            $cvv = $_POST['cvv'];
            $expiryMonth = $_POST['expiry_month'];
            $expiryYear = $_POST['expiry_year'];

            // Validate card information
            if (strlen($cardNumber) == 24 && strlen($cvv) >= 3 && strlen($expiryMonth) == 2 && strlen($expiryYear) == 2) {

                $url = "payProcess.php?services=" . urlencode($services) . "&totalprice=" . urlencode($totalPriceFormat) . "&branch=" . urlencode($branch);
                header("Location: $url");
                // exit();

            } else {

                echo "<div id='fail'>
                <h1>Oh No!</h1>
                <p>Invalid Card Information!</p>
                <p class='small'>Please make sure all fields<br> are filled correctly</p>
                <button onclick='closeFail()'>Close</button>
            </div>
            <div id='cover' style='display:block'></div>";

            }
        }
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Coffee For Go!</title>
            <style>
                body {
                    background-image: url(image/bg.png);
                }

                @keyframes transitionIn {
                    from {
                        opacity: 0;
                        transform: translateY(-10px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                #cover {
                    position: fixed;
                    top: 0;
                    right: 0;
                    bottom: 0;
                    left: 0;
                    background-color: black;
                    z-index: 99;
                }

                #fail {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    border-radius: 25px;
                    width: 800px;
                    height: 680px;
                    margin-top: 15px;
                    background-color: white;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
                    z-index: 100;
                }

                #fail h1 {
                    text-align: center;
                    color: #181444;
                    font-size: 70px;
                    margin-top: 140px;
                    animation: transitionIn 1s;
                }

                #fail p:not(.small) {
                    font-family: 'Poppins', sans-serif;
                    font-size: 40px;
                    color: #181444;
                    text-align: center;
                    font-weight: bold;
                    animation: transitionIn 1s;
                }

                .small {
                    font-family: 'Poppins', sans-serif;
                    font-size: 30px;
                    color: #181444;
                    text-align: center;
                    font-weight: bold;
                    animation: transitionIn 1s;
                }

                #fail button {
                    width: 200px;
                    height: 50px;
                    background-color: #181444;
                    border-radius: 25px;
                    font-weight: bold;
                    color: white;
                    font-family: 'Poppins', sans-serif;
                    font-size: 16px;
                    margin-top: 30px;
                    margin-left: 305px;
                    border: none;
                    outline: none;
                    transition: box-shadow 0.2s ease-in-out;
                    animation: transitionIn 1s;
                }

                #fail button:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                #fail img {
                    position: absolute;
                    width: 200px;
                    height: 200px;
                    border-radius: 50%;
                    margin-left: 300px;
                    animation: transitionIn 1s;
                }

                .rounded-textboxOne {
                    border-radius: 10px;
                    border-color: #00000053;
                    height: 45px;
                    width: 500px;
                    margin-left: 22px;
                    animation: transitionIn 1s;
                    text-align: center;
                }

                input.rounded-textboxOne:focus {
                    outline-color: #0077ff;
                    background-color: #0077ff32;
                    color: #0077ff;
                }


                .rounded-textboxTwo {
                    border-radius: 10px;
                    border-color: #00000053;
                    height: 45px;
                    width: 250px;
                    margin-left: 22px;
                    animation: transitionIn 1s;
                    text-align: center;
                }

                input.rounded-textboxTwo:focus {
                    outline-color: #0077ff;
                    background-color: #0077ff32;
                    color: #0077ff;
                }

                .rounded-textboxThree {
                    border-radius: 10px;
                    border-color: #00000053;
                    height: 45px;
                    width: 100px;
                    margin-left: 22px;
                    animation: transitionIn 1s;
                    text-align: center;
                }

                input.rounded-textboxThree:focus {
                    outline-color: #0077ff;
                    background-color: #0077ff32;
                    color: #0077ff;
                }

                input::placeholder {
                    font-family: "Poppins", sans-serif;
                    font-size: 17px;
                    color: #999;
                }

                input[type="text"] {
                    font-family: "Poppins", sans-serif;
                    font-size: 17px;
                    font-weight: bold;
                }

                .rounded-square {
                    width: 555px;
                    height: 850px;
                    border-radius: 20px;
                    background-color: yellow;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
                    margin-top: 80px;
                    margin-left: 725px;
                    animation: transitionIn 1s;
                }

                .cardnumber {
                    margin-top: 10px;
                    font-family: 'Poppins', sans-serif;
                    font-size: 20px;
                    color: #181444;
                    font-weight: bolder;
                    animation: transitionIn 1s;
                    margin-left: 22px;
                }

                .greyFont {
                    font-family: 'Poppins', sans-serif;
                    font-size: 15px;
                    color: grey;
                    font-weight: bold;
                    margin-left: 22px;
                    animation: transitionIn 1s;
                    line-height: 5px;
                }

                .pricebox {
                    border-radius: 10px;
                    background-color: #7a2005;
                    border: none;
                    outline: none;
                    height: 170px;
                    width: 500px;
                    margin-top: 30px;
                    margin-left: 22px;
                    animation: transitionIn 1s;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.7);
                }

                .price {
                    margin-top: 1px;
                    font-family: 'Poppins', sans-serif;
                    font-size: 35px;
                    color: white;
                    font-weight: bolder;
                    animation: transitionIn 1s;
                    margin-left: 22px;
                }

                .price2 {
                    margin-top: 1px;
                    font-family: 'Poppins', sans-serif;
                    font-size: 30px;
                    color: white;
                    font-weight: bolder;
                    animation: transitionIn 1s;
                    margin-left: 22px;
                }

                .pay {
                    border-radius: 10px;
                    background-color: #7a2005;
                    border: none;
                    outline: none;
                    height: 70px;
                    width: 500px;
                    margin-top: 20px;
                    margin-left: 22px;
                    animation: transitionIn 1s;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.7);
                    font-family: 'Poppins', sans-serif;
                    font-size: 20px;
                    color: white;
                    font-weight: bolder;
                    transition: box-shadow 0.2s ease-in-out;
                }

                .cancel {
                    border-radius: 10px;
                    background-color: #ff4b4b;
                    border: none;
                    outline: none;
                    height: 70px;
                    width: 500px;
                    margin-top: 20px;
                    margin-left: 22px;
                    animation: transitionIn 1s;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.7);
                    font-family: 'Poppins', sans-serif;
                    font-size: 20px;
                    color: white;
                    font-weight: bolder;
                    transition: box-shadow 0.2s ease-in-out;
                }

                .pay:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }

                .cancel:hover {
                    box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
                }
            </style>
            <script>

                function goBack() {
                    window.history.back();
                }

                function showFail() {
                    document.getElementById("fail").style.display = "block";
                    document.getElementById("cover").style.display = "block";
                }

                function closeFail() {
                    document.getElementById("fail").style.display = "none";
                    document.getElementById("cover").style.display = "none";
                }

                function formatCreditCardNumber(input) {
                    // Remove any non-digit characters from the input
                    let cardNumber = input.value.replace(/\D/g, '');

                    // Restrict the maximum length to 16 digits
                    cardNumber = cardNumber.slice(0, 16);

                    // Add spaces after every four digits with adjustable spacing
                    const groupSize = 4; // Number of digits in each group
                    const spacing = '  '; // Desired spacing between groups
                    const regex = new RegExp(`(.{${groupSize}})`, 'g');
                    cardNumber = cardNumber.replace(regex, `$1${spacing}`);

                    // Update the input value
                    input.value = cardNumber;
                }

                function formatCvvNumber(input) {
                    // Remove any non-digit characters from the input
                    let cardNumber = input.value.replace(/\D/g, '');

                    // Restrict the maximum length to 16 digits
                    cardNumber = cardNumber.slice(0, 4);

                    // Update the input value
                    input.value = cardNumber;
                }

                function formatExpiryDate(input) {
                    // Remove any non-digit characters from the input
                    let cardNumber = input.value.replace(/\D/g, '');

                    // Restrict the maximum length to 16 digits
                    cardNumber = cardNumber.slice(0, 2);

                    // Update the input value
                    input.value = cardNumber;
                }


            </script>
            <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
        </head>

        <body>

            <div class="rounded-square">

                <br>
                <form action="" method="post">
                    <p class="cardnumber">Card Number</p>
                    <p class="greyFont">Enter the 16-digit code number on the card</p>
                    <input type="text" placeholder="XXXX  XXXX  XXXX  XXXX" name="cc" class="rounded-textboxOne"
                        oninput="formatCreditCardNumber(this)">

                    <p class="cardnumber">CVV Number</p>
                    <p class="greyFont">Enter the 3 or 4 digit number on the card</p>
                    <input type="text" placeholder="XXX" name="cvv" class="rounded-textboxTwo" oninput="formatCvvNumber(this)">

                    <p class="cardnumber">Expiry Date</p>
                    <p class="greyFont">Enter the expiration date of the card</p>
                    <input type="text" placeholder="MM" name="expiry_month" class="rounded-textboxThree"
                        oninput="formatExpiryDate(this)">
                    <input type="text" placeholder="YY" name="expiry_year" class="rounded-textboxThree"
                        oninput="formatExpiryDate(this)">

                    <div class="pricebox">
                        <br>
                        <p class="price">Total Payment</p>
                        <p class="price2">RM
                            <?php echo $totalPriceFormat; ?>
                        </p>
                    </div>

                    <br>
                    <button class="pay" type="submit">Pay</button>
                    <br>
                </form>
                <button class="cancel" onclick="goBack()">Cancel Payment</button>

            </div>

        </body>

        </html>

        <?php
    }
} else {
    header("Location: Login.html");
}
?>