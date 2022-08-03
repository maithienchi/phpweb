<?php
require_once 'init.php';
if(isset($_GET['type'],$_GET['id'])){
    $type=$_GET['type'];
    $id=(int)$_GET['id'];
    switch($type){
        case'like':
            $db1->query("INSERT INTO likes (postId,userId)
            VALUE ($id,{$currentUser['id']})
            ");
            break;
        case'unlike':
                $db1->query("DELETE FROM likes WHERE userId={$currentUser['id']} AND postId={$id}
                ");
         break;
    }
}
header('Location: TrangCaNhan.php');