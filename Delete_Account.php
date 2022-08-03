<?php 
  require_once 'init.php';

  if(isset($_POST['action']))
  {
      if($_POST['action']=='no'){
        header('Location: index.php');
      }
      else{
          DeleteAccount($currentUser['id']);
          header('Location: index.php');
      }
  }

?>
<?php include 'header.php' ?>
<h1>Bạn có chắc muốn xóa tài khoản??</h1>

<form  method="POST">
      <input type="hidden" name="action" value="no">
      <button type="submit" class="btn btn-primary">Không</button>
    </form>
    <br>
    <form method="POST">
      <input type="hidden" name="action" value="yes">
      <button type="submit" class="btn btn-danger">Có</button>
    </form>