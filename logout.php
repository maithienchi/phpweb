<?php 
  require_once 'init.php';

  // Xử lý logic ở đây

  
unset($_SESSION['userId']);
unset($_SESSION['userId1']);
unset($_SESSION['username']);
unset($_SESSION['password']);
header('Location: index.php');