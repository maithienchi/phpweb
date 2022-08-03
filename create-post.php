<?php 
require_once 'init.php';
if (!$currentUser){
    header ('Location: index.php');
    exit();
}

$content=$_GET['content'];
createPost($currentUser['id'],$content,$_GET['image']);





header('Location: index.php');