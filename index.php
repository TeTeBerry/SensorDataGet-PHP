<?php
require('vendor/autoload.php');

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require __FILE__ . '/index.php';
        break;
    case '/realtime' :
        require __FILE__ . '/react.php';
        break;
    default:
        require __FILE__ . '/404.php';
        break;
}