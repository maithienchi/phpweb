<?php 
  require_once 'init.php';

  // Xử lý logic ở đây
  if(!$resetemail)
  {
    header('Location: index.php');
    exit();
  }

 

?>
<?php include 'header.php'; ?>
<div clast="container" class="col-sm-4" >
<h1>Đổi mật khẩu</h1>
<?php if (isset($_POST['Password']) && isset($_POST['newPassword'])): ?>
<?php
    
    $Password=$_POST['Password'];
    $newPassword=$_POST['newPassword'];
    

    $succcess=false;
    if ($Password==$newPassword){
        UpdateUserPassword($resetemail['id'],$Password);
        $_SESSION['userId'] = $resetemail['id'];
      
        $succcess=true;
    }
    
?>
<?php if ($succcess): ?>
<div class="alert alert-primary" role="alert">
<?php header('Location: index.php'); ?>
</div>
<?php else: ?>
<div class="alert alert-danger" role="alert">
    Nhập lại mật khẩu sai!!!
<form action="new_password.php">
<button type="submit" class="btn btn-primary btn-lg">Đổi lại mật khẩu</button>
</form>
</div>
<?php endif; ?>
<?php else: ?>
    <form action="new_password.php" method = "POST" >
  

    <div class = "form-group">
    <label for="Password">Mật khẩu mới</label>
    <input type="text" name="Password" class="form-control" placeholder="Mật khẩu mới">
    </div>

    <div class = "form-group">
    <label for="newPassword">Nhập lại khẩu Mới</label>
    <input type="text" name="newPassword" class="form-control" placeholder="Nhập lại mật khẩu mới">
    </div>

    
    <button type="submit" class="btn btn-primary btn-lg">Đổi mật khẩu</button>

    </form>
    </div>
    
<?php endif; ?>
<?php include 'footer.php'; ?>