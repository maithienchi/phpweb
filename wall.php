<?php
require_once 'init.php';
$posts=getNewFeedsCaNhan($_GET['id']);
$profile = findUserById($_GET['id']);
$friends = getFriends($currentUser['id']);
$isFriend = false;
foreach ($friends AS $friend) {
  if ($friend['id'] == $profile['id']) {
    $isFriend = true;
  }
}
$isFollow = isFollow($currentUser['id'], $profile['id']);
$isRequest = isFollow($profile['id'], $currentUser['id']);
$KiemTraFollow=KiemTraFollow($currentUser['id'], $profile['id']);


$TheoDoi="";
$MauTheoDoi = "";

if (isset($_POST['NhanTin']))
{
  header('Location: conversation.php?id=' . $_GET['id']);
}
if(isset($_POST['TheoDoi']))
{
  if($KiemTraFollow){
    HuyFollow($currentUser['id'], $profile['id']);
  }
  else {
    Follow($currentUser['id'], $profile['id']);
  }
  header('Location: wall.php?id=' . $_GET['id']);
}
?>
<?php include 'header.php' ?>
<h1>Tường nhà <?php echo $profile['displayName'] ?></h1>
<?php if($profile['avatar']): ?>
    <img src ="avatar.php?id=<?php echo $profile['id']; ?>"  alt="Cinque Terre" >
    <?php else: ?>
    <img src="no-avatar.jpg"  alt="Cinque Terre" >
    <?php endif;?>
    <h3>Thông Tin Cá Nhân</h3>
<li>
    <b>Họ Tên: </b><?php echo $profile['displayName']; ?><br>
</li>
<?php if($isFriend):?>
  <?php if($profile['privacyEmail']==('Công khai' or 'Bạn bè')):?>
<li>
    <b>Email: </b><?php echo $profile['email']; ?>
</li>
  <?php endif;?>
<?php elseif($profile['privacyEmail']=='Công khai'): ?>
  <li><b>Email: </b><?php echo $profile['email']; ?></li>
<?php endif;?>

<?php if($isFriend):?>
  <?php if($profile['privacyGioiTinh']==('Công khai' or 'Bạn bè')):?>
<li>
    <b>Giới tính: </b><?php echo $profile['gender']; ?>
</li>
<?php endif;?>
<?php elseif($profile['privacyGioiTinh']=='Công khai'): ?>
  <li><b>Giới tính: </b><?php echo $profile['gender']; ?></li>
  <?php endif;?>

  <?php if($isFriend):?>
  <?php if($profile['privacyNamSinh']==('Công khai' or 'Bạn bè')):?>
<li>
    <b>Ngày Sinh: </b><?php echo $profile['NamSinh']; ?>
</li>
<?php endif;?>
<?php elseif($profile['privacyNamSinh']=='Công khai'): ?>
  <li><b>Ngày Sinh: </b><?php echo $profile['NamSinh']; ?></li>
<?php endif;?>


<?php if($isFriend):?>
  <?php if($profile['privacyPhone']==('Công khai' or 'Bạn bè')):?>
<li>
    <b>Số điện thoại: </b><?php echo $profile['phone']; ?>
</li>
<?php endif;?>
<?php elseif($profile['privacyPhone']=='Công khai'): ?>
  <li><b>Số điện thoại: </b><?php echo $profile['phone']; ?></li>
<?php endif;?>

<?php if($currentUser['id']!=$_GET['id']): ?>
<div class="row">
  <div class="col-sm-0">
<?php if ($isFriend) : ?>
<form action="friend-request.php" method="POST">
  <input type="hidden" name="action" value="unfriend">
  <input type="hidden" name="profileId" value="<?php echo $profile['id'] ?>">
  <button type="submit" class="btn btn-danger">Hủy kết bạn</button>
</form>
<?php else : ?>
  <?php if ($isFollow) : ?>
    <form action="friend-request.php" method="POST">
      <input type="hidden" name="action" value="cancel-friend-request">
      <input type="hidden" name="profileId" value="<?php echo $profile['id'] ?>">
      <button type="submit" class="btn btn-primary">Hủy yêu cầu kết bạn</button>
    </form>
  <?php elseif ($isRequest) : ?>
    <form action="friend-request.php" method="POST">
      <input type="hidden" name="action" value="accept-friend-request">
      <input type="hidden" name="profileId" value="<?php echo $profile['id'] ?>">
      <button type="submit" class="btn btn-primary">Chấp nhận yêu cầu kết bạn</button>
    </form>
    <form action="friend-request.php" method="POST">
      <input type="hidden" name="action" value="reject-friend-request">
      <input type="hidden" name="profileId" value="<?php echo $profile['id'] ?>">
      <button type="submit" class="btn btn-warning">Từ chối yêu cầu kết bạn</button>
    </form>
  <?php else : ?>
    <form action="friend-request.php" method="POST">
      <input type="hidden" name="action" value="send-friend-request">
      <input type="hidden" name="profileId" value="<?php echo $profile['id'] ?>">
      <button type="submit" class="btn btn-primary">Gửi yêu cầu kết bạn</button>
    </form>
  <?php endif; ?>
<?php endif; ?>
</div>

  <?php if($KiemTraFollow):?>
  <?php $TheoDoi="Đang theo dõi";$MauTheoDoi='class="btn btn-success"'?>
  <?php else: ?>
    <?php $TheoDoi="Theo dõi";$MauTheoDoi='class="btn btn-warning"'?>
  <?php endif;?>
&nbsp;
<form method="POST">
  <button type="submit" <?php echo $MauTheoDoi; ?> name="TheoDoi"><?php echo $TheoDoi; ?></button>
</form>
&nbsp;
<form method="POST">
  <button type="submit" class="btn btn-primary" name="NhanTin">Nhắn Tin</button>
</form>
</div>

  <?php endif; ?>
<!-- Xuất Bài viết -->
<?php foreach ($posts as $post) : ?>
<?php if ($isFriend): ?> 
  <?php if($post['privacy']=='Công khai'|| $post['privacy']=='Bạn bè' ): ?>  
<div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
          <?php if ($post['hasAvatar']): ?>
          <img src ="avatar.php?id=<?php echo $post['userId']; ?>" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <!-- <img style="width: 150px;" src ="avatar.php?id=<?php echo $post['userId']; ?>"> -->
          <!-- <img style="width: 150px;"src="./avatars/<?php echo $post['userId']; ?>.jpg"> -->
          <?php else : ?>
          <img src="no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <!-- <img style="width: 150px;"src="no-avatar.jpg"> -->
          <?php endif; ?>
        <!-- <div class="col-sm"> -->
        <?php echo $post['displayName']; ?>
        </h4>
        <!-- </div>
        </div>
        </div>
        </h4> -->
        <p class="card-text">
        <small>Đăng lúc: <?php echo $post['createdAt'] ?></small>
        <label style ='font-size:10px'>(<?php echo $post['privacy'].')'; ?></label>
        <p style ='font-size:18px'><?php echo $post['content'] ?></p>
        <?php if($post['image']): ?>
        <img src ="imagePost.php?id=<?php echo $post['id']; ?>"  alt="Cinque Terre" >
        <?php endif;?>
        </p>
        <i class ='fa fa-thumbs-o-up' data-toggle="tooltip" title="Cảm xúc với status này!" style ='font-size:20px; color:black;'>&ensp;Thích</i>&emsp;
        <i class ='far fa-comment-alt' data-toggle="tooltip" title="Viết bình luận" style ='font-size:20px; color:black;'>&ensp;Bình luận</i>&emsp;
        <i class ='fa fa-share' data-toggle="tooltip" title="Gửi nội dung này đến bạn bè hoặc đăng trên dòng thời gian của bạn" style ='font-size:20px; color:black;'>&ensp;Chia sẻ</i>&emsp; 
      </div>
    </div>
      <?php endif; ?>
<?php else: ?> 
  <?php if($post['privacy']=='Công khai'): ?>
    <div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
          <?php if ($post['hasAvatar']): ?>
          <img src ="avatar.php?id=<?php echo $post['userId']; ?>" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <!-- <img style="width: 150px;" src ="avatar.php?id=<?php echo $post['userId']; ?>"> -->
          <!-- <img style="width: 150px;"src="./avatars/<?php echo $post['userId']; ?>.jpg"> -->
          <?php else : ?>
          <img src="no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <!-- <img style="width: 150px;"src="no-avatar.jpg"> -->
          <?php endif; ?>
        <!-- <div class="col-sm"> -->
        <?php echo $post['displayName']; ?>
        </h4>
        <!-- </div>
        </div>
        </div>
        </h4> -->
        <p class="card-text">
        <small>Đăng lúc: <?php echo $post['createdAt'] ?></small>
        <label style ='font-size:10px'>(<?php echo $post['privacy'].')'; ?></label>
        <p style ='font-size:18px'><?php echo $post['content'] ?></p>
        <?php if($post['image']): ?>
        <img src ="imagePost.php?id=<?php echo $post['id']; ?>"  alt="Cinque Terre" >
        <?php endif;?>
        </p>
        <i class ='fa fa-thumbs-o-up' data-toggle="tooltip" title="Cảm xúc với status này!" style ='font-size:20px; color:black;'>&ensp;Thích</i>&emsp;
        <i class ='far fa-comment-alt' data-toggle="tooltip" title="Viết bình luận" style ='font-size:20px; color:black;'>&ensp;Bình luận</i>&emsp;
        <i class ='fa fa-share' data-toggle="tooltip" title="Gửi nội dung này đến bạn bè hoặc đăng trên dòng thời gian của bạn" style ='font-size:20px; color:black;'>&ensp;Chia sẻ</i>&emsp; 
      </div>
    </div>
  <?php endif; ?>
<?php endif; ?>
<?php endforeach; ?>
<?php include 'footer.php' ?>