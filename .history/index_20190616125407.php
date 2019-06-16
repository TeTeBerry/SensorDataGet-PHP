<?php

$servername = "127.0.0.1";

// REPLACE with your Database name
$dbname = "iot";
// REPLACE with Database user
$username = "root";
// REPLACE with Database user password
$password = "root";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "chentete";

$api_key= $sensor  = $flowRate = $flowMilliLitres = $totalMilliLitres = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $sensor = test_input($_POST["sensor"]);
        $value1 = test_input($_POST["flowRate"]);
        $value2 = test_input($_POST["flowMilliLitres"]);
        $value3 = test_input($_POST["totalMilliLitres"]);
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO SensorData (sensor, flowRate, flowMilliLitres, value3)
        VALUES ('" . $sensor . "', '" . $flowRate . "', '" . $flowMilliLitres . "', '" . $totalMilliLitres . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}