<?php
require_once 'init.php';
$searchs = GetUser($_GET['id'],$currentUser['id']);
// var_dump($searchs);
?>
<?php include 'header.php' ?>
<?php if(!$searchs):?>
<h1>Không tìm thấy kết quả nào</h1>
<?php else:?>
<h1>Kết quả tìm kiếm</h1>
<ul>
  <?php foreach ($searchs as $search) : ?>
  <li>
    <?php if($search['avatar']): ?>
    <img src ="avatar.php?id=<?php echo $search['id']; ?>" class="img-circle" alt="Cinque Terre" width="35" height="35">
    <?php else: ?>
    <img src="no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="35" height="35">
    <?php endif;?>
    <a href="wall.php?id=<?php echo $search['id']; ?>"><?php echo $search['displayName'] ?></a>
  </li>
  <?php endforeach; ?>
</ul>
    <?php endif; ?>
<?php include 'footer.php' ?>