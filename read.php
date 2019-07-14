<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$servername = "127.0.0.1";

// REPLACE with your Database name
$dbname = "iot";
// REPLACE with Database user
$username = "root";
// REPLACE with Database user password
$password = "root";
$method = $_SERVER['REQUEST_METHOD'];

 
// database connection will be here
// include database and object files

 
// instantiate database and product object

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

       $sql = "SELECT id, sensorName,flowRate, flowMilliLitres, totalMilliLitres, reading_time FROM realTime";

 
$result = mysqli_query($conn,$sql);


if (!$result) {
  http_response_code(404);
  die(mysqli_error());
}




if ($method == 'GET') {
  if (!$key) echo '[';
  for ($i=0;$i<mysqli_num_rows($result);$i++) {
    echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
  }
  if (!$key) echo ']';
}

mysqli_close($conn);

?>