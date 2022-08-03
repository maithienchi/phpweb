<?php 
  require_once 'init.php';
?>
<?php include 'header.php'; ?>
<h1>Reset mật khẩu</h1>
<?php if (isset($_POST['email'])): ?>
<?php
  $email = $_POST['email'];
  
  $success = false;
  $user = findUserByEmail($email);

  if ($user) {
    $newUserId = resetpassword($email);
    $success = true;
  }
?>
<?php if ($success): ?>
<div class="alert alert-success" role="alert">
  kiểm tra hộp thư <?php echo $email ?> để thay đổi mật khẩu
</div>
<?php else: ?>
<div class="alert alert-danger" role="alert">
  <?php echo $email ?> không tồn tại đề nghị nhập lại email
  <form action="forgot_password.php" method="POST">
  <button type="submit" class="btn btn-primary">Nhập lại</button>
</form>
</div>
<?php endif; ?>
<?php else: ?>
<form action="forgot_password.php" method="POST">
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
  </div>
  <button type="submit" class="btn btn-primary">Reset mật khẩu</button>
</form>
<?php endif; ?>
<?php include 'footer.php'; ?>
