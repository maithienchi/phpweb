<?php
require_once 'init.php';
$notifications = getnotifications($currentUser['id']);
updateNotification($currentUser['id']);
if(isset($_POST['delete']))
{
  deleteNotificationsWithId($_POST['delete']);
  header('Location: notification.php');
}
if(isset($_POST['deleteall']))
{
  deleteAllNotifications($currentUser['id']);
  header('Location: notification.php');
}
?>
<?php include 'header.php' ?>
<h1>Danh sách thông báo</h1>
<form method="POST">
  <button type="submit" class="btn btn-danger" name="deleteall">Xóa tất cả</button>
  <?php updateNotification($currentUser['id']); ?>
</form>
<!-- <a href="new-message.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Thêm cuộc trò chuyện</a> -->
<?php foreach ($notifications as $notification) : ?>
<?php  if($notification['privacy']=='m'): ?>
<div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
      <div class="row">
        <div class="col">
          <?php if($notification['avatar']!=null): ?>
          <img src ="avatar.php?id=<?php echo $notification['id1']; ?>" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <?php else: ?>
          <img src="no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <?php endif;?>
         
          <a href="conversation.php?id=<?php echo $notification['id1'] ?>"><?php echo $notification['displayName'] ?></a>
          &emsp;
          <a><?php echo $notification['content']; ?></a>
          <!-- <br>
          <a href="wall.php?id=<?php echo $notification['id1']; ?>">XemTrangCáNhân</a> -->
        </div>
        <div class="col-0">
        <form method="POST">
          <button type="submit" class="btn btn-primary" name="delete" value="<?php echo $notification['id'];?>">Xóa</button>
        </form>
      </div>
      </div>
    </h4>
    <p class="card-text">
    <small>ngày tạo: <?php echo $notification['createdAt']; ?></small>
    
    </p>
  </div>
</div>
<?php else:?>
  <div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
      <div class="row">
        <div class="col">
          <?php if($notification['avatar']!=null): ?>
          <img src ="avatar.php?id=<?php echo $notification['id1']; ?>" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <?php else: ?>
          <img src="no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <?php endif;?>
         
          <a href="wall.php?id=<?php echo $notification['id1']; ?>"><?php echo $notification['displayName'] ?></a>
          &emsp;
          <a><?php echo $notification['content']; ?></a>
         
           
        </div>
        <div class="col-0">
        <form method="POST">
          <button type="submit" class="btn btn-primary" name="deleteall" value="<?php echo $notification['id1'];?>">Xóa</button>
        </form>
      </div>
      </div>
    </h4>
    <p class="card-text">
    <small>ngày tạo: <?php echo $notification['createdAt']; ?></small>
    
    </p>
  </div>
</div>
<?php endif; ?>

<?php endforeach; ?>
<br>
<?php include 'footer.php' ?>