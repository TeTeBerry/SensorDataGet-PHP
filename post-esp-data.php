<?php


$servername = "127.0.0.1";

// REPLACE with your Database name
$dbname = "iot";
// REPLACE with Database user
$username = "root";
// REPLACE with Database user password
$password = "root";

$data_value = "sensorData";
$client_value = "react";


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $data = test_input($_GET["data"]);
    if($data == $data_value) {
        $sensorName = test_input($_GET["sensorName"]);
        $flowRate = test_input($_GET["flowRate"]);
        $flowMilliLitres = test_input($_GET["flowMilliLitres"]);
        $totalMilliLitres = test_input($_GET["totalMilliLitres"]);

        $meter= array("sensorName"=>$_GET["sensorName"], "flowRate"=>$_GET["flowRate"],"flowMilliLitres"=>$_GET["flowMilliLitres"], "totalMilliLitres"=>$_GET["totalMilliLitres"]);

 
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 


        $filterSql = "SELECT * FROM SensorData WHERE totalMilliLitres = '".$_GET["totalMilliLitres"]."'";
        $filerQuery = mysqli_query($conn,$filterSql);
        $filterResult = mysqli_fetch_array($filerQuery);
        if($filterResult) {
            echo "totalMilliLitres already exist";
        }
        else{
        
        $sql = "INSERT INTO SensorData (sensorName, flowRate, flowMilliLitres, totalMilliLitres)
        VALUES ('" . $sensorName . "', '" . $flowRate . "', '" . $flowMilliLitres . "', '" . $totalMilliLitres . "')";
        
        $result = $conn->query($sql);




        if ($result === TRUE) {
              echo json_encode($meter);

}
        
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
        $conn->close();

}
    

} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $client = $_GET["client"];
    if($client == $client_value) {

        echo "string";

    }
}

else {
    echo "No data posted with HTTP GET.";
}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}