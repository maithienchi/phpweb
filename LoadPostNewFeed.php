<?php 
    require_once 'init.php';
    $PostNewCount = $_POST['PostNewCount'];
    $posts=getNewFeeds($PostNewCount);
    $friends = getFriends($currentUser['id']);
?>

<?php foreach ($posts as $post) : ?>
<?php 
  $KiemTraFollow=KiemTraFollow($currentUser['id'],$post['userId']);
  $isFriend = false;
  foreach ($friends AS $friend) {
  if ($friend['id'] == $post['userId']) {
    $isFriend = true;
  }
}
?>
<?php if($post['userId']!=$currentUser['id']):?>
  <?php if($KiemTraFollow):?>
    <?php if($isFriend):?>
      <?php if($post['privacy']==('Công khai' or 'Bạn bè')):?>
<div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
      <div class="row">
        <div class="col">
          <?php if ($post['hasAvatar']) : ?>
          <img src ="avatar.php?id=<?php echo $post['userId']; ?>" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <!-- <img style="width: 150px;" src ="avatar.php?id=<?php echo $post['userId']; ?>"> -->
          <!-- <img style="width: 150px;"src="./avatars/<?php echo $post['userId']; ?>.jpg"> -->
          <?php else : ?>
          <img src="no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <!-- <img style="width: 150px;"src="no-avatar.jpg"> -->
          <?php endif; ?>
          <?php echo $post['displayName'] ?>
        </div>
        <?php if($post['userId']==$currentUser['id']):?>
        <div class="col-0">
        <form method="POST">
        <button class="img-circle" style ='font-size:10px' id="deletePost" name="deletePost" value="<?php echo $post['id']; ?>">xóa</button>
        </form>
      </div>
      <?php endif; ?>

    </h4>
    <p class="card-text">
    <div class="row">
    <div class="col-0">
    <small>Đăng lúc: <?php echo $post['createdAt']; ?></small>
    </div>
    <?php if($post['userId']==$currentUser['id']):?>
      <!-- <ion-icon name="lock" size="normal" title="Thông báo"></ion-icon> -->
      <?php if($post['privacy'] =='Công khai'){
        $privacy='selected="1"';
      }
      else if($post['privacy'] =='Bạn bè'){
        $privacy1='selected="1"';
      }
      else{
        $privacy2='selected="1"';
      }
      ?>
      <div class="col">
      <form method="POST">
      <select style ='font-size:10px' name="privacy" >
        <option style ='font-size:10px' value="Công khai" <?php echo $privacy; ?>>Công khai</option> 
        <option style ='font-size:10px' value="Bạn bè" <?php echo $privacy1; ?>>Bạn bè</option> 
        <option style ='font-size:10px' value="Chỉ mình tôi"<?php echo $privacy2; ?>>Chỉ mình tôi</option> 
        </select>
        <button style ='font-size:10px'class="img-circle" id="updatePost" name="updatePost" value="<?php echo $post['id']; ?>">cập nhật</button>
      </form>
      </div>
      <?php 
      $privacy="";
      $privacy1="";
      $privacy2="";
      ?>
    <!-- <div class="dropdown">
        <p class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          </p>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="TrangCaNhan.php">Công Khai</a>
          <a class="dropdown-item" href="change-password.php">Bạn bè</a>
          <a class="dropdown-item" href="#">Chỉ mình tôi</a>
        </div>
    </div> -->
    <?php else:?>
    <div class="col">
    <label style ='font-size:10px'>(<?php echo $post['privacy'].')'; ?></label>
    </div>
    <?php endif; ?>
    </div>
    </p>
    
    <p class="card-text" style ='font-size:18px'><?php echo $post['content'] ?></p>
    <?php if($post['image']): ?>
    <img class="card-text" src ="imagePost.php?id=<?php echo $post['id']; ?>"  alt="Cinque Terre" >
    <?php endif;?>
    <p class="card-text">
    <br>
    <i class ='fa fa-thumbs-o-up' data-toggle="tooltip" title="Cảm xúc với status này!" style ='font-size:20px; color:black;'>&ensp;Thích</i>&emsp;
    <i class ='far fa-comment-alt' data-toggle="tooltip" title="Viết bình luận" style ='font-size:20px; color:black;'>&ensp;Bình luận</i>&emsp;
    <i class ='fa fa-share' data-toggle="tooltip" title="Gửi nội dung này đến bạn bè hoặc đăng trên dòng thời gian của bạn" style ='font-size:20px; color:black;'>&ensp;Chia sẻ</i>&emsp;
  </p>
  <form action="" method="post" enctype="multipart/form-data">

    <table width="200" border="0" style="margin-bottom:40px;">
        <tr>
            <td colspan="2" style="font-size:16px; font-weight:bold">Bình luận sản phẫm</div></td>

        </tr>
        <tr>
            <td width="68">Tên</td>
            <td width="122"><label for="ten"></label>
                <input type="text" name="ten" id="ten" size="30" placeholder="Tên bạn..."/></td>
        </tr>
        <tr>
            <td>Nội dung</td>
            <td><label for="noidung"></label>
                <textarea name="noidung" id="noidung" cols="45" rows="5" placeholder="Nội dung bình luận..."></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="binhluan" id="binhluan" value="Bình luận"/></td>

        </tr>
    </table>
</form>

  </div>
</div>
    <?php endif; ?>
    <?php elseif($post['privacy']=='Công khai'):?>
      <div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
      <div class="row">
        <div class="col">
          <?php if ($post['hasAvatar']) : ?>
          <img src ="avatar.php?id=<?php echo $post['userId']; ?>" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <!-- <img style="width: 150px;" src ="avatar.php?id=<?php echo $post['userId']; ?>"> -->
          <!-- <img style="width: 150px;"src="./avatars/<?php echo $post['userId']; ?>.jpg"> -->
          <?php else : ?>
          <img src="no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <!-- <img style="width: 150px;"src="no-avatar.jpg"> -->
          <?php endif; ?>
          <?php echo $post['displayName'] ?>
        </div>
        <?php if($post['userId']==$currentUser['id']):?>
        <div class="col-0">
        <form method="POST">
        <button class="img-circle" style ='font-size:10px' id="deletePost" name="deletePost" value="<?php echo $post['id']; ?>">xóa</button>
        </form>
      </div>
      <?php endif; ?>

    </h4>
    <p class="card-text">
    <div class="row">
    <div class="col-0">
    <small>Đăng lúc: <?php echo $post['createdAt']; ?></small>
    </div>
    <?php if($post['userId']==$currentUser['id']):?>
      <!-- <ion-icon name="lock" size="normal" title="Thông báo"></ion-icon> -->
      <?php if($post['privacy'] =='Công khai'){
        $privacy='selected="1"';
      }
      else if($post['privacy'] =='Bạn bè'){
        $privacy1='selected="1"';
      }
      else{
        $privacy2='selected="1"';
      }
      ?>
      <div class="col">
      <form method="POST">
      <select style ='font-size:10px' name="privacy" >
        <option style ='font-size:10px' value="Công khai" <?php echo $privacy; ?>>Công khai</option> 
        <option style ='font-size:10px' value="Bạn bè" <?php echo $privacy1; ?>>Bạn bè</option> 
        <option style ='font-size:10px' value="Chỉ mình tôi"<?php echo $privacy2; ?>>Chỉ mình tôi</option> 
        </select>
        <button style ='font-size:10px'class="img-circle" id="updatePost" name="updatePost" value="<?php echo $post['id']; ?>">cập nhật</button>
      </form>
      </div>
      <?php 
      $privacy="";
      $privacy1="";
      $privacy2="";
      ?>
    <!-- <div class="dropdown">
        <p class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          </p>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="TrangCaNhan.php">Công Khai</a>
          <a class="dropdown-item" href="change-password.php">Bạn bè</a>
          <a class="dropdown-item" href="#">Chỉ mình tôi</a>
        </div>
    </div> -->
    <?php else:?>
    <div class="col">
    <label style ='font-size:10px'>(<?php echo $post['privacy'].')'; ?></label>
    </div>
    <?php endif; ?>
    </div>
    </p>
    
    <p class="card-text" style ='font-size:18px'><?php echo $post['content'] ?></p>
    <?php if($post['image']): ?>
    <img class="card-text" src ="imagePost.php?id=<?php echo $post['id']; ?>"  alt="Cinque Terre" >
    <?php endif;?>
    <p class="card-text">
    <br>
    <i class ='fa fa-thumbs-o-up' data-toggle="tooltip" title="Cảm xúc với status này!" style ='font-size:20px; color:black;'>&ensp;Thích</i>&emsp;
    <i class ='far fa-comment-alt' data-toggle="tooltip" title="Viết bình luận" style ='font-size:20px; color:black;'>&ensp;Bình luận</i>&emsp;
    <i class ='fa fa-share' data-toggle="tooltip" title="Gửi nội dung này đến bạn bè hoặc đăng trên dòng thời gian của bạn" style ='font-size:20px; color:black;'>&ensp;Chia sẻ</i>&emsp;
  </p>
  </div>
</div>
      <?php endif;?>
    <?php endif;?>


<?php else:?>
  <div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
      <div class="row">
        <div class="col">
          <?php if ($post['hasAvatar']) : ?>
          <img src ="avatar.php?id=<?php echo $post['userId']; ?>" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <!-- <img style="width: 150px;" src ="avatar.php?id=<?php echo $post['userId']; ?>"> -->
          <!-- <img style="width: 150px;"src="./avatars/<?php echo $post['userId']; ?>.jpg"> -->
          <?php else : ?>
          <img src="no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <!-- <img style="width: 150px;"src="no-avatar.jpg"> -->
          <?php endif; ?>
          <?php echo $post['displayName'] ?>
        </div>
        <?php if($post['userId']==$currentUser['id']):?>
        <div class="col-0">
        <form method="POST">
        <button class="img-circle" style ='font-size:10px' id="deletePost" name="deletePost" value="<?php echo $post['id']; ?>">xóa</button>
        </form>
      </div>
      <?php endif; ?>

    </h4>
    <p class="card-text">
    <div class="row">
    <div class="col-0">
    <small>Đăng lúc: <?php echo $post['createdAt']; ?></small>
    </div>
    <?php if($post['userId']==$currentUser['id']):?>
      <!-- <ion-icon name="lock" size="normal" title="Thông báo"></ion-icon> -->
      <?php if($post['privacy'] =='Công khai'){
        $privacy='selected="1"';
      }
      else if($post['privacy'] =='Bạn bè'){
        $privacy1='selected="1"';
      }
      else{
        $privacy2='selected="1"';
      }
      ?>
      <div class="col">
      <form method="POST">
      <select style ='font-size:10px' name="privacy" >
        <option style ='font-size:10px' value="Công khai" <?php echo $privacy; ?>>Công khai</option> 
        <option style ='font-size:10px' value="Bạn bè" <?php echo $privacy1; ?>>Bạn bè</option> 
        <option style ='font-size:10px' value="Chỉ mình tôi"<?php echo $privacy2; ?>>Chỉ mình tôi</option> 
        </select>
        <button style ='font-size:10px'class="img-circle" id="updatePost" name="updatePost" value="<?php echo $post['id']; ?>">cập nhật</button>
      </form>
      </div>
      <?php 
      $privacy="";
      $privacy1="";
      $privacy2="";
      ?>
    <!-- <div class="dropdown">
        <p class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          </p>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="TrangCaNhan.php">Công Khai</a>
          <a class="dropdown-item" href="change-password.php">Bạn bè</a>
          <a class="dropdown-item" href="#">Chỉ mình tôi</a>
        </div>
    </div> -->
    <?php else:?>
    <div class="col">
    <label style ='font-size:10px'>(<?php echo $post['privacy'].')'; ?></label>
    </div>
    <?php endif; ?>
    </div>
    </p>
    
    <p class="card-text" style ='font-size:18px'><?php echo $post['content'] ?></p>
    <?php if($post['image']): ?>
    <img class="card-text" src ="imagePost.php?id=<?php echo $post['id']; ?>"  alt="Cinque Terre" >
    <?php endif;?>
    <p class="card-text">
    <br>
    <i class ='fa fa-thumbs-o-up' data-toggle="tooltip" title="Cảm xúc với status này!" style ='font-size:20px; color:black;'>&ensp;Thích</i>&emsp;
    <i class ='far fa-comment-alt' data-toggle="tooltip" title="Viết bình luận" style ='font-size:20px; color:black;'>&ensp;Bình luận</i>&emsp;
    <i class ='fa fa-share' data-toggle="tooltip" title="Gửi nội dung này đến bạn bè hoặc đăng trên dòng thời gian của bạn" style ='font-size:20px; color:black;'>&ensp;Chia sẻ</i>&emsp;
  </p>
  </div>
</div>
<?php endif;?>
<?php endforeach; ?>