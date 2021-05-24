<?php

ob_start();

session_start();



defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);


defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__ . DS . "Templates/Front");
defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS . "Templates/Back");


defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY", __DIR__ . DS . "uploads");
defined("IMAGE_DIRECTORY") ? null : define("IMAGE_DIRECTORY", __DIR__ . DS . "images");

defined("CONTROL") ? null : define("CONTROL", __DIR__ . DS . "Control");

defined("DB_HOST") ? null : define("DB_HOST", "localhost");
defined("DB_USER") ? null : define("DB_USER", "root");
defined("DB_PASS") ? null : define("DB_PASS", "");
defined("DB_NAME") ? null : define("DB_NAME", "gcs190283");

$ConnectingDB = new PDO('mysql:host = localhost; dbname=gcs190283', 'root', '');
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);


require_once("functions.php");
require_once("cart.php");