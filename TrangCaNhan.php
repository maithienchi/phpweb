<?php 
  require_once 'init.php';
  // Xử lý logic ở đây
  $posts=getNewFeedsCaNhan($currentUser['id'],10);
  // setcookie('PHPSESSID',$cookie_name['PHPSESSID'], time() + (0), "/");
  //var_dump($_COOKIE);
  //echo $currentUser['id'];
  // var_dump($GLOBALS);
  $privacy="";
  $privacy1="";
  $privacy2="";
  $image=null;
  if(isset($_POST['content']))
  {
    if ( isset( $_FILES["image"] ) && !empty( $_FILES["image"]["name"] ) ) {
      if ( is_uploaded_file( $_FILES["image"]["tmp_name"] ) && $_FILES["image"]["error"] == 0)
      {
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileTemp = $_FILES['image']['tmp_name'];
      // $filePath = './avatars/' . $currentUser['id'] . '.jpg';
      //  move_uploaded_file($fileTemp, $filePath);
        $newImage = resizeImage($fileTemp, 480, 480);
        // imagejpeg($newImage, $filePath);
        ob_start();
        imagejpeg($newImage);
        $image = ob_get_contents();
        ob_end_clean();
      }
    }
    if($image!=null){
      createPost($currentUser['id'],$_POST['content'],$image,$_POST['privacy']);
      }
      header('Location: TrangCaNhan.php');
  }
  // if(isset($_POST['deletePost']))
  // {
  //   deletePostWithId($_POST['deletePost']);
  //   header('Location:TrangCaNhan.php');
  // } 
  if(isset($_POST['privacy']) && $_POST['updatePost']!="")
  {
    UpdatePostById($_POST['updatePost'],$_POST['privacy']);
    header('Location:TrangCaNhan.php');
  }
?>
<?php include 'header.php'; ?>

<?php if ($currentUser): ?>
  
    <?php
        // global $db;
        // $stmt = $db->prepare("SELECT * from posts ORDER BY createdAt desc limit 10");
        // $stmt->execute(array());
        // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // for ($i = 0; $i < count($result); $i++) {
        //     echo "<p>";
        //     echo $result[$i]['userId'];
        //     echo $result[$i]['content'];
        //     echo $result[$i]['createdAt'];
        //     echo "</p>";
        // }
    ?>


<p>Chào mừng <?php echo $currentUser['displayName']; ?> đã trở lại </p>
<h3>Thông Tin Cá Nhân</h3>
<?php if($currentUser['avatar']): ?>
    <img src ="avatar.php?id=<?php echo $currentUser['id']; ?>"  alt="Cinque Terre" >
    <?php else: ?>
    <img src="no-avatar.jpg"  alt="Cinque Terre" >
    <?php endif;?>
<li>
    <b>Họ Tên: </b><?php echo $currentUser['displayName']; ?><br>
</li>
<li>
    <b>Email: </b><?php echo $currentUser['email']; ?>
</li>
<li>
    <b>Giới tính: </b><?php echo $currentUser['gender']; ?>
</li>
<li>
    <b>Ngày Sinh: </b><?php echo $currentUser['NamSinh']; ?>
</li>
<li>
    <b>Số điện thoại: </b><?php echo $currentUser['phone']; ?>
</li>
<form action="Update-Profile.php">
    <button type="submit" style="width:250px">Chỉnh sửa chi tiết</button>
</form>

<form  method = "POST" enctype="multipart/form-data">
    <div class = "form-group">
   <label for="content"><br>Tạo bài viết</label>
   <textarea class="form-control" name='content' id="content" rows="3" placeholder="<?php echo $currentUser['displayName']; ?> ơi, bạn đang nghĩ gì?"></textarea>
    </div>
    <select name="privacy"> 
    <option value="Công khai">Công khai</option> 
    <option value="Bạn bè">Bạn bè</option> 
    <option value="Chỉ mình tôi">Chỉ mình tôi</option> 
    </select>
    <input type="file" class="form-control-file" name="image" id="image" >
    <button type="submit" class="btn btn-primary btn-lg">Đăng</button>
    </form>


<div id="posts">
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


    <?php
      $countlike=DemLike($post['id']);
      $countcommemnt=getcountcomments($post['id']);
    ?>
    <div class="card-body">
    <hr>
        <div class="row">
            
            <div class="btn-group" style="position: relative;bottom:6px;left:23px">
            <?php if (KiemTraLike($post['id'],$currentUser['id'])): ?>
            <a class="btn"name="unlike"id="unlike"href="likeCaNhan.php?type=unlike&id=<?php echo $post['id'] ?>"style='color:blue'><i style='font-size:20px' class='far fa-thumbs-up'data-toggle="tooltip" title="Cảm xúc của bạn với status này!!"></i> Thích  <span class="badge badge-primary  rounded-circle" ><?php echo implode(" ",$countlike);?></span></a>
            <?php else:?>
            <a class="btn"name="like"id="like"href="likeCaNhan.php?type=like&id=<?php echo $post['id'] ?>"style='color:black'><i style='font-size:20px' class='far fa-thumbs-up'data-toggle="tooltip" title="Cảm xúc của bạn với status này!!"></i> Thích  <span class="badge badge-light  rounded-circle"><?php echo implode(" ",$countlike);?></span></a>
            <?php endif ?>
            </div>&emsp;&emsp;
            
            <div>
            <h9 aria-haspopup="true" aria-expanded="false"><i style='font-size:20px' class='far fa-comment-alt'data-toggle="tooltip" title="Cảm nghĩ của bạn về bài viết này!"></i> Bình luận<span class="badge badge-light  rounded-circle"><?php echo implode(" ",$countcommemnt);?></span></h9>
            </div>&emsp;&emsp;
            <div>
                <h9 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i style="font-size:20px" class="fa fa-share" data-toggle="tooltip" title="Chia sẻ với bạn bè" aria-hidden="true"></i><span class="sr-only">Chia sẻ với bạn bè</span> Chia sẻ </h9>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Chia sẻ ngay (Công khai)</a>
                    <a class="dropdown-item" href="#">Chia sẻ ...</a>
                    <a class="dropdown-item" href="#">Gửi dưới dạng tin nhắn</a>
                    <a class="dropdown-item" href="#">Chia sẻ trên dòng thời gian với bạn bè</a>
                    <a class="dropdown-item" href="#">Chia sẻ lên trang</a>
                </div>
            </div>
        </div>
    <hr>
    <?php $getcomment=getcomment($post['id']);
    ?>
    <?php if(usercommentd($post['id'],$currentUser['id'])): ?>
    <div class="target" style="height:200px;overflow:scroll;" >
        <?php foreach ($getcomment as $postss):?>
            
        <div class="card" >
        <div class="card-body">
                <h5 class="card-title">
                    <?php if($postss['avatar']):?> 
                      <img src ="avatar.php?id=<?php echo $postss['userId']; ?>" class="img-circle" alt="Cinque Terre" width="35" height="35">  
                    <?php else: ?>
                    <img src="no-avatar.jpg" class="img-circle" alt="Cinque Terre" width="35" height="35">
                    <?php endif ?> 
                    <a href="profile.php?id=<?php echo $postss['userId'] ?>"><div style="position: absolute; left:80px;top:20px " ><?php echo $postss['displayName']?> </div> </a>          
                  </h5> 

                  <small><p class="card-text"style="position: absolute; left:80px;top:50px" > Bình luận lúc: 
                    <?php echo $postss['createdAt'];?>
                </p></small>
                <p >
                    <?php echo $postss['content'];?>
                </p>
                <div class="col"style="text-align: right;position: absolute; left:8px;top:8px ">
                <form method="post">
                <button  type="submit" name="deletecomment" value = <?php echo $postss['id']; ?>  class="btn btn-danger" >Xóa</button>   
                </form>

                <?php 
                if(isset($_POST['deletecomment']))
                {
                    $value_commnet=$_POST['deletecomment'];
                    
                    deletecomment($value_commnet);
                    header("Location: index.php");
                    }
                ?>
                  
            </div>  
            </div>  
            </div>
        <?php endforeach ?>
                        </div>
    <?php else:?>
            <div></div>
    <?php endif?>
    <form action="upcomment1.php?type=upcommentindex&id=<?php echo $post['id'] ?>" method="POST" >
    <div class="form-group">
        <textarea style="height:50px" class="form-control" name="contents" id="contents" rows="3"placeholder="Thêm bình luận..."></textarea>                                
    </div>        
    <button type="submit" class="btn btn-primary" name="upcomment">comment</button>
    </form>	
</div>
   
  
  </p>
  </div>
</div>
<?php endforeach; ?>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<!-- <button id="btnLoadPost">Xem Thêm</button> -->
<div class="card" style="margin-bottom: 10px;">
    <button id="btnLoadPost">Tải thêm</button>
  </div>
<?php else: ?>
<h1>Chào mừng đến với trang mạng xã hội FaBo</h1>
<?php endif ?>
<?php include 'footer.php' ?>

<script>
        //jQuery code here!
        $(document).ready(function(){
        var PostCount = 10;
        $('#btnLoadPost').click(function(){
            PostCount=PostCount+10;
            $('#posts').load("LoadPostCaNhan.php",{
            PostNewCount: PostCount
            });
        });
        });
</script>

