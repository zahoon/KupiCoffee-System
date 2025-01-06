<?php 
include("dbconn.php");
if(isset($_POST['submit'])){
    
    function generateCoffeeId() {

        // Generate a random number between 1 and 1000000.
        $coffeeId = rand(1, 1000000);
    
        // Convert the random number to a string.
        $coffeeIdStr = strval($coffeeId);
    
        // Return the coffee ID string.
        return $coffeeIdStr;
    }
    

    $coffeeID = generatecoffeeId();
    $coffeeName = $_POST['coffeeName'];
    $coffeePrice = $_POST['coffeePrice'];
    $coffeeDesc = $_POST['coffeeDesc'];
    $coffeeType = $_POST['coffeeType'];
    $coffeeStatus = $_POST['coffeeStatus'];

    $targetDir = "coffeepastry/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    //check file is PNG
    if($fileType == "png"){
        if(move_uploaded_file($_FILES["file"]["tmp_name"],$targetFilePath)){    

            $sql1 = "SELECT coffeeID FROM coffee where coffeeID ='$coffeeID'";
            $query = mysqli_query($dbconn,$sql1) or die ("Error : " .mysqli_error($dbconn));
            $row = mysqli_num_rows($query);
            if($row != 0){
                echo "Record exists";
            }else {
                //exec sql insert command
                $sql2 = "INSERT INTO coffee (coffeeID, coffeeName,coffeePrice,coffeeDesc,coffeeType,coffeeStatus,coffeeImage)
             VALUES('".$coffeeID."','".$coffeeName."','".$coffeePrice."','".$coffeeDesc."','".$coffeeType."','".$coffeeStatus."','".$fileName."')";
                mysqli_query($dbconn,$sql2) or die ("Error : ".mysqli_error($dbconn));
                //display msg
                echo "<div id ='completed'>
                <p> Coffee Inserted Scuessfully ! </p>
                <a href='adminDash.php'>
                <button>Close </button>
                </a>
                </div>
                <div id='cover' style='display:block'></div>";
            }
            }else{
                echo "<div id='error'>
                <h1>Coffee Failed to insert</h1>
                <p> Error </p>
                <a href='addMenu.php'>
                <button>Close</button>
                </a>
                </div>
                <div = id='cover' style='display:block'></div>";
            }
        }else{
            echo "div id='filenotpng'>
            <h1> File must be in PNG!</p>
            <a href='addMenu.php'>
            <button>Close</button>
            </a>
            </div>
            <div id ='cover' style = 'display:block'></div>";
        }
    }
?>