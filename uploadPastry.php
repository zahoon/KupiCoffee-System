<?php 
include("dbconn.php");
if(isset($_POST['submit'])){

    function generatePastryID(){
        // Generate random number between 1 and 1000000;

        $pastryID = rand(1,1000000);

        return $pastryID;
    }
    $pastryID = generatePastryID();
    $pastryName = $_POST['pastryName'];
    $pastryPrice = $_POST['pastryPrice'];
    $pastryDesc = $_POST['pastryDesc'];
    $pastryStatus = $_POST['pastryStatus'];

    $targetDir = "coffeepastry/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

  //check file is PNG
  if($fileType == "png"){
    if(move_uploaded_file($_FILES["file"]["tmp_name"],$targetFilePath)){    

        $sql1 = "SELECT pastryID FROM pastry where pastryID ='$pastryID'";
        $query = mysqli_query($dbconn,$sql1) or die ("Error : " .mysqli_error($dbconn));
        $row = mysqli_num_rows($query);
        if($row != 0){
            echo "Record exists";
        }else {
            //exec sql insert command
            $sql2 = "INSERT INTO pastry (pastryID, pastryName,pastryPrice,pastryDesc,pastryStatus,pastryImage)
         VALUES('".$pastryID."','".$pastryName."','".$pastryPrice."','".$pastryDesc."','".$pastryStatus."','".$fileName."')";
            mysqli_query($dbconn,$sql2) or die ("Error : ".mysqli_error($dbconn));
            //display msg
            echo "<div id ='completed'>
            <p> Pastry Inserted Scuessfully ! </p>
            <a href='adminDash.php'>
            <button>Close </button>
            </a>
            </div>
            <div id='cover' style='display:block'></div>";
        }
        }else{
            echo "<div id='error'>
            <h1>Pastry Failed to insert</h1>
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