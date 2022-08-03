<?php
require_once 'init.php';
$conversations = getLatestConversations($currentUser['id']);

if(isset($_POST['deleteall']))
{
  deleteAllMessageWithId($currentUser['id'], $_POST['deleteall']);
  header('Location: message.php');
}

?>
<?php include 'header.php' ?>
<h1>Danh sách tin nhắn</h1>
<a href="new-message.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Thêm cuộc trò chuyện</a>
<?php foreach ($conversations as $conversation) : ?>
<div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
      <div class="row">
        <div class="col">
          <?php if($conversation['hasAvatar']): ?>
          <img src ="avatar.php?id=<?php echo $conversation['id']; ?>" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <?php else: ?>
          <img src="no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="35" height="35">
          <?php endif;?>
        
          <a href="conversation.php?id=<?php echo $conversation['id'] ?>"><?php echo $conversation['displayName'] ?></a>
          &emsp;
          <a href="wall.php?id=<?php echo $conversation['id']; ?>">XemTrangCáNhân</a>
        </div>
        <div class="col-0">
        <form method="POST">
          <button type="submit" class="btn btn-danger" name="deleteall" value="<?php echo $conversation['id'];?>">Xóa</button>
        </form>
      </div>
      </div>
    </h4>
    <p class="card-text">
    <small>Tin nhắn cuối: <?php echo $conversation['lastMessage']['createdAt'] ?></small>
    <p><?php echo $conversation['lastMessage']['content'] ?></p>
    </p>
  </div>
</div>
<?php endforeach; ?>
<br>
<?php include 'footer.php' ?>