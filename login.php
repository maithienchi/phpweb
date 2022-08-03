<?php 
  require_once 'init.php';

  // Xử lý logic ở đây

 

?>
<?php include 'header.php'; ?>
<div clast="container" class="col-sm-4" >
<h1>Đăng Nhập</h1>
<?php if (  isset($_POST['email']) && isset($_POST['password'])): ?>
<?php
    $email=$_POST['email'];
    $password=$_POST['password'];
    $succcess=false;

    $user=findUserByEmail($email);
    if ($user && password_verify($password,$user['password'])){
      $succcess=true;
      $_SESSION['userId'] = $user['id'];
    }
    
?>
<?php if ($succcess): ?>
<div class="alert alert-primary" role="alert">
<?php header('Location: index.php'); ?>
</div>
<?php else: ?>
<div class="alert alert-danger" role="alert">
    Đăng nhập thất bại
</div>
<?php endif; ?>
<?php else: ?>
    <form action="login.php" method = "POST" >
    <div class = "form-group">
   <label for="email">Email</label>
    <input type="text" name="email" class="form-control" placeholder="Email" >
    </div>

    <div class = "form-group">
    <label for="password">Mật Khẩu</label>
    <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
    </div>
    <button type="submit" class="btn btn-primary btn-lg">Đăng Nhập</button>
    </form>
    <a href="forgot_password.php">Quên tài khoản?</a>
    </div>
    
<?php endif; ?>
<?php include 'footer.php'; ?>