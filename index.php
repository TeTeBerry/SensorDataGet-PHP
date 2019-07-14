<?php
require('vendor/autoload.php');

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require __DIR__ . '/views/get-esp-data.php';
        break;
    case '' :
        require __DIR__ . '/views/get-esp-data.php';
        break;
    case '/react' :
        require __DIR__ . '/views/react.php';
        break;
}