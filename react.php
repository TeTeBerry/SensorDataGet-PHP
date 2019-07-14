<?php

require('vendor/autoload.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// (1) INIT
set_time_limit(60); // Set the appropriate time limit
ignore_user_abort(false); // Stop when polling breaks

define('DB_HOST', 'us-cdbr-iron-east-02.cleardb.net');
define('DB_NAME', 'heroku_0abf4b67ee6747a');
define('DB_USER', 'b5b7819d9b19a5');
define('DB_PASSWORD', '47532b88');
 
// (2) DATABASE
class DB {
  protected $pdo = null;
  protected $stmt = null;
  function __construct() {
    try {
      $this->pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, 
        DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]
      );
      return true;
    } catch (Exception $ex) {
      print_r($ex);
      die();
    }
  }
  function __destruct() {
    if ($this->stmt !== null) { $this->stmt = null; }
    if ($this->pdo !== null) { $this->pdo = null; }
  }
  function getData() {
    $this->stmt = $this->pdo->prepare("SELECT * FROM `realTime` ORDER BY `reading_time` DESC LIMIT 1");
    $this->stmt->execute();
    $result = $this->stmt->fetchAll();
    return count($result)==0 ? ["sensorName"=>0, "flowRate"=>0, "flowMilliLitres"=>0, "totalMilliLitres"=>0,"reading_time"=>0] : ["reading_time"=>strtotime($result[0]['reading_time']), "sensorName"=>$result[0]['sensorName'], "flowRate"=>$result[0]['flowRate'],"flowMilliLitres"=>$result[0]['flowMilliLitres'],"totalMilliLitres"=>$result[0]['totalMilliLitres']];
  }
}
$pdoDB = new DB();

// (3) LOOP - CHECK FOR UPDATES
// Will keep looping until a score update or AJAX timeout
while (true) {
  $data = $pdoDB->getData();
  if ($data['reading_time']>$_GET['last']) {
    echo json_encode($data);
    break;
  }
  sleep(1);
}
?>