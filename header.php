<?php
  require_once 'init.php';

  if (isset($_POST['search']) && $_POST['search']!="")
  {
    header('Location: search.php?id='.$_POST['search']);
  }

  if(isset($_POST['notification']))
  {
    updateNotification($currentUser['id']);
    header('Location: index.php');
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- <link href="assets/css/bootstrap.css" rel="stylesheet">
        
    <link href="assets/css/facebook.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>FaBo</title>

    <!-- jquery ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <style>
    /* body {
    background-image: url('backgroud2.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: 100% 100%;
    } */
 
    </style>
  </head>
  <body>
  
  <div class="container">
    <h1>Mạng xã hội FaBo</h1>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
  <a class="navbar-brand" href="index.php"><strong>FaBo</strong></a>
  <!-- <a class="nav-item ml-sm-3 ">
  <ion-icon ios="ios-contacts" md="md-contacts" size="large" title="Danh sách bạn bè" ></ion-icon>
  </a>
  <a class="nav-item ml-sm-3 ">
  <ion-icon name="chatboxes" size="large"title="Tin nhắn"></ion-icon>
  </a>
  <a class="nav-item ml-sm-3 mr-sm-3 ">
  <ion-icon name="notifications" size="large" title="Thông báo"></ion-icon>
  </a> -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php if (!$currentUser): ?>
      <li class="nav-item <?php echo $page == 'register' ? 'active': ''; ?>">
        <a class="nav-link" href="register.php">Đăng Ký <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item <?php echo $page == 'login' ? 'active': ''; ?>">
        <a class="nav-link" href="login.php">Đăng Nhập <span class="sr-only">(current)</span></a>
      </li>
      <!-- <li class="nav-item <?php echo $page == 'forgot_password' ? 'active' : '' ?>">
              <a class="nav-link" href="forgot_password.php">Quên mật khẩu</a>
      </li> -->
      <?php else: ?>
      <form class="form-inline my-5 my-lg-0" method="POST">
      <input class="form-control mr-sm-1" type="search" name="search" placeholder="Nhập tên, email hoặc số điện thoại" aria-label="Search" style="width:350px">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
      <!-- <li class="nav-item <?php echo $page == 'friend' ? 'active': ''; ?>">
        <a class="nav-link" href="friend.php">Bạn bè<span class="sr-only">(current)</span></a>
      </li> -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Bạn Bè
      </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="friend.php">Danh sách bạn bè</a>
          <a class="dropdown-item" href="YeuCauKetBan.php">Lời mời kết bạn</a>
          <a class="dropdown-item" href="YeuCauDaGui.php">Yêu cầu kết bạn đã gửi</a>
        </div>
      </li>
      <li class="nav-item <?php echo $page == 'message' ? 'active': ''; ?>">
        <a class="nav-link" href="message.php">Tin Nhắn<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item <?php echo $page == 'notification' ? 'active': ''; ?>">
        <a class="nav-link" href="notification.php" >Thông Báo <span class="sr-only">(current)</span></a>
      </li>
      <li><div class="notification"><?php echo $currentUser['dem'];?></div></li>&ensp;
      
      <!-- </li><li class="nav-item <?php echo $page == 'change-password' ? 'active': ''; ?>">
        <a class="nav-link" href="change-password.php">Đổi mật khẩu<span class="sr-only">(current)</span></a>
      </li> -->
      <?php if($currentUser['avatar']): ?>
    <img src ="avatar.php?id=<?php echo $currentUser['id']; ?>" class="img-circle" alt="Cinque Terre" width="35" height="35">
    <?php else: ?>
    <img src="no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="35" height="35">
    <?php endif;?>
      <!-- <li class="nav-item <?php echo $page == 'logout' ? 'active': ''; ?>">
        <a class="nav-link" href="logout.php">Đăng Xuất <?php echo $currentUser ? ' ('. $currentUser['displayName'].')' :'' ?>  <span class="sr-only">(current)</span></a>
      </li> -->
     
     
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $currentUser ? ' ('. $currentUser['displayName'].')' :'' ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="TrangCaNhan.php">Trang cá nhân</a>
          <a class="dropdown-item" href="change-password.php">Đổi mật khẩu</a>
          <a class="dropdown-item" href="Update-Profile.php">Cài đặt</a>
          <a class="dropdown-item" href="Delete_Account.php">Xóa tài khoản</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Đăng Xuất <?php echo $currentUser ? ' ('. $currentUser['displayName'].')' :'' ?></a>
          <a class="dropdown-item" href="About.php">About</a>
        </div>
      </li>
      
      <?php endif; ?>
  </div>
</nav>
