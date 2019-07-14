<?php


header("Access-Control-Allow-Origin: *");
$servername = "us-cdbr-iron-east-02.cleardb.net";

// REPLACE with your Database name
$dbname = "heroku_0abf4b67ee6747a";
// REPLACE with Database user
$username = "b5b7819d9b19a5";
// REPLACE with Database user password
$password = "47532b88";

if (!empty($_GET["sensorName"])) {
        // Calls from sensor to save data
        $sensorName = $_GET["sensorName"];
        $flowRate = $_GET["flowRate"];
        $flowMilliLitres = $_GET["flowMilliLitres"];
        $totalMilliLitres = $_GET["totalMilliLitres"];
        $meter = array("sensorName"=>$_GET["sensorName"], "flowRate"=>$_GET["flowRate"],"flowMilliLitres"=>$_GET["flowMilliLitres"], "totalMilliLitres"=>$_GET["totalMilliLitres"]);
      
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        //Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
         $sql2 = "INSERT INTO realTime (sensorName, flowRate, flowMilliLitres, totalMilliLitres)
            VALUES ('" . $sensorName . "', '" . $flowRate . "', '" . $flowMilliLitres . "', '" . $totalMilliLitres . "')";
             $result2 = $conn->query($sql2);
        $filterSql = "SELECT * FROM sensorData WHERE totalMilliLitres = '".$_GET["totalMilliLitres"]."'";
        $filerQuery = mysqli_query($conn,$filterSql);
        $filterResult = mysqli_fetch_array($filerQuery);
        if($filterResult) {
            echo "totalMilliLitres already exist";
        }
        else{
        
            $sql = "INSERT INTO sensorData (sensorName, flowRate, flowMilliLitres, totalMilliLitres)
            VALUES ('" . $sensorName . "', '" . $flowRate . "', '" . $flowMilliLitres . "', '" . $totalMilliLitres . "')";
            
            $result = $conn->query($sql);
           
            if ($result&&$result2 === TRUE) {
                echo "New records created successfully";
            }
        
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    
        $conn->close();
    
}else{
    echo "NO DATA SAVE INTO DATABASE";
}
// function test_input($caller) {
//     $caller = trim($caller);
//     $caller = stripslashes($caller);
//     $caller = htmlspecialchars($caller);
//     return $caller;
// }
?>