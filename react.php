<?php
ob_start();
include('post-esp.data.php');
ob_clean();
 
echo $meter;
?>
