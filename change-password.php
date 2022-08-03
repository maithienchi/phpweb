<?php 
  require_once 'init.php';

  // Xử lý logic ở đây
  if(!$currentUser)
  {
    header('Location: index.php');
    exit();
  }

 

?>
<?php include 'header.php'; ?>
<div clast="container" class="col-sm-4" >
<h1>Đổi mật khẩu</h1>
<?php if (isset($_POST['currentPassword']) && isset($_POST['password'])): ?>
<?php
    
    $password=$_POST['password'];
    $currentPassword=$_POST['currentPassword'];
    

    $succcess=false;
    

    if (password_verify($currentPassword,$currentUser['password']) ){
        UpdateUserPassword($currentUser['id'],$password);
      
      $succcess=true;
    }
    
?>
<?php if ($succcess): ?>
<div class="alert alert-primary" role="alert">
<?php header('Location: index.php'); ?>
</div>
<?php else: ?>
<div class="alert alert-danger" role="alert">
    Đổi mật khẩu thất bại
<form action="change-password.php">
<button type="submit" class="btn btn-primary btn-lg">Đổi lại mật khẩu</button>
</form>
</div>
<?php endif; ?>
<?php else: ?>
    <form action="change-password.php" method = "POST" >
  

    <div class = "form-group">
    <label for="currentPassword">Mật khẩu hiện tại</label>
    <input type="text" name="currentPassword" class="form-control" placeholder="Mật khẩu hiện tại">
    </div>

    <div class = "form-group">
    <label for="password">Mật khẩu Mới</label>
    <input type="text" name="password" class="form-control" placeholder="Mật khẩu mới">
    </div>

    
    <button type="submit" class="btn btn-primary btn-lg">Đổi mật khẩu</button>

    </form>
    </div>
    
<?php endif; ?>
<?php include 'footer.php'; ?>