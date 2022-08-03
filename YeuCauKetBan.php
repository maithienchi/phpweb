<?php
require_once 'init.php';
$friends1 = YeuCauKetBan($currentUser['id']);
// var_dump($friends);
?>
<?php include 'header.php' ?>
<h1>Lời mời kết bạn</h1>
<ul>
  <?php foreach ($friends1 as $friend) : ?>
  <li>
    <?php if($friend['avatar']): ?>
    <img src ="avatar.php?id=<?php echo $friend['id']; ?>" class="img-circle" alt="Cinque Terre" width="35" height="35">
    <?php else: ?>
    <img src="no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="35" height="35">
    <?php endif;?>
    <a href="wall.php?id=<?php echo $friend['id']; ?>"><?php echo $friend['displayName'] ?></a>
  </li>
  <?php endforeach; ?>
</ul>
<?php include 'footer.php' ?>