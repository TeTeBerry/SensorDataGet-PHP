<?php
require('vendor/autoload.php');

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require __DIR__ . '/index.php';
        break;
    case '/realtime' :
        require __DIR__ . '/react.php';
        break;
    default:
        require __DIR__ . '/404.php';
        break;
}