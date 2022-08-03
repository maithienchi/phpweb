<?php
require_once 'init.php';

if (isset($_POST['content']) && $_POST['content']!="") {
  sendMessage($currentUser['id'], $_GET['id'], $_POST['content']); 
  header('Location: conversation.php?id=' . $_GET['id']);
}
$messages = getMessagesWithUserId($currentUser['id'], $_GET['id']);
$user = findUserById($_GET['id']);
if(isset($_POST['currentMessage']))
{
  deleteMessageWithId($_POST['currentMessage']);
  header('Location: conversation.php?id=' . $_GET['id']);
}
if(isset($_POST['deleteall']))
{
  deleteAllMessageWithId($currentUser['id'], $_GET['id']);
  header('Location: conversation.php?id=' . $_GET['id']);
}
?>
<?php include 'header.php' ?>
<h1>Cuộc trò chuyện với: <?php echo $user['displayName'] ?></h1>
<?php foreach ($messages as $message) : ?>
<form method="POST">
<div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <?php if ($message['type'] == 1) : ?>
    <p class="card-text">
      <strong><?php echo $user['displayName'] ?></strong>:
      <?php echo $message['content'] ?>
      <br>
      <a style="font-size: x-small;"><?php echo 'lúc: '. $message['createdAt']; ?></a>
      <br>
      <button type="submit" id="currentMessage" name="currentMessage" class="btn btn-primary" value="<?php echo $message['id']; ?>">Xóa</button>
    </p>
    <?php else: ?>
    <p class="card-text text-right">
      <?php echo $message['content'] ?>
      <br>
      <a style="font-size: x-small;"><?php echo 'lúc: '. $message['createdAt']; ?></a>
      <br>
      <button type="submit" id="currentMessage" name="currentMessage" class="btn btn-primary" value="<?php echo $message['id']; ?>">Xóa</button>
    </p>
  </form>
    <?php endif; ?>
  </div>
</div>
<?php endforeach; ?>
<br>
<form method="POST">
  <div class="form-group">
    <label for="content">Tin nhắn:</label>
    <textarea class="form-control" id="content" name="content" rows="3"></textarea>
  </div>
  <div class="row">
  <div class="col-sm-0">
  <button type="submit" class="btn btn-primary">Gửi tin nhắn</button>
  </div>
  &nbsp;
</form>
<?php if($messages): ?>
<form method="POST">
  <button type="submit" class="btn btn-danger" name="deleteall">Xóa tất cả tin nhắn</button>
</form>
</div>
<?php endif; ?>


<?php include 'footer.php' ?>