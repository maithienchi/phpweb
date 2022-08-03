<?php
// Load core functions
ob_start();
require_once('./vendor/autoload.php');
require_once('config.php');
require_once('functions.php');

// Always display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();
// Detect page
$page = detectPage();

// Connect database
$db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8", $DB_USER, $DB_PASSWORD);
$db1= new mysqli($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
// Detect login 
$currentUser = null;

if (isset($_SESSION['userId'])) {
  $currentUser = findUserById($_SESSION['userId']);
}

$resetemail = null;

if (isset($_SESSION['userId1'])) {
  $resetemail=findUserById($_SESSION['userId1']);
}

