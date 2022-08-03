<?php 
    require_once 'init.php';
    $PostNewCount = $_POST['PostNewCount'];
    $posts=getNewFeedsCaNhan($currentUser['id'],$PostNewCount);
?>
<?php foreach ($posts as $post) : ?>
<div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
      <div class="row">
        <div class="col">
          <?php if ($post['hasAvatar']) : ?>
          <img src ="avatar.php?id=<?php echo $post['userId']; ?>" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <!-- <img style="width: 150px;" src ="avatar.php?id=<?php echo $post['userId']; ?>"> -->
          <!-- <img style="width: 150px;"src="./avatars/<?php echo $post['userId'] ?>.jpg"> -->
          <?php else : ?>
          <img src="no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <!-- <img style="width: 150px;"src="no-avatar.jpg"> -->
          <?php endif; ?>
          <?php echo $post['displayName'] ?>
        </div>
        <div class="col-0">
        </div>
        <form method="POST">
        <button class="img-circle" style ='font-size:10px' align="right" id="deletePost" name="deletePost" value="<?php echo $post['id']; ?>">xóa</button>
        </form>
      </div>
    </h4>
    <p class="card-text">
    <div class="row">
    <div class="col-0">
    <small>Đăng lúc: <?php echo $post['createdAt'] ?></small>&nbsp;
    </div>
  <!-- <ion-icon name="lock" size="normal" title="Thông báo"></ion-icon> -->
  <!-- value="17" selected="1" -->
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
        <button style ='font-size:10px'class="img-circle"  name="updatePost" value="<?php echo $post['id']; ?>">cập nhật</button>
      </form>
      </div>
  <?php 
  $privacy="";
  $privacy1="";
  $privacy2="";
  ?>
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
<?php endforeach; ?>