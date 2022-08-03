<?php
require_once('./vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function detectPage()
{
    $uri=$_SERVER['REQUEST_URI'];
    $parts=explode('/',$uri);
    $filename=$parts[2];
    $parts=explode('.',$filename);
    $page=$parts[0];
    return $page;
}
function findUserByEmail($email)
{
    global $db;
    $stmt=$db->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute(array($email));

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function findUserById($id)
{
    global $db;
    $stmt=$db->prepare("SELECT * FROM users WHERE id=?");
    $stmt->execute(array($id));

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findPostById($id)
{
    global $db;
    $stmt=$db->prepare("SELECT * FROM posts WHERE id=?");
    $stmt->execute(array($id));

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function UpdatePostById($id,$privacy)
{
    global $db;
    $stmt=$db->prepare("UPDATE posts SET privacy=? WHERE id=?");
    $stmt->execute(array($privacy,$id));

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function UpdateUserPassword($id,$password){
    global $db;
    $hashPassword=password_hash($password,PASSWORD_DEFAULT);
    $stmt=$db->prepare("UPDATE  users SET password=? where id=?");
    return $stmt->execute(array($hashPassword,$id));
}

// function updateUserProfile($id,$displayName,$hasAvatar){
//     global $db;
//     $stmt=$db->prepare("UPDATE  users SET displayName =? hasAvatar = ?where id=?");
//     return $stmt->execute(array($displayName,$hasAvatar,$id));
// }
// function updateUserProfile($user) {
//     global $db;
//     $stmt = $db->prepare("UPDATE  users SET displayName =?, hasAvatar = ?where id=?");
//     return  $stmt->execute(array($user['displayName'],$user['hasAvatar'], $user['id']));
    
//   }
// function updateUserProfile($user) {
//   global $db;
//   $stmt = $db->prepare("UPDATE  users SET displayName =?, hasAvatar = ?, avatar = ?where id=?");
//   return  $stmt->execute(array($user['displayName'],$user['hasAvatar'],$user['avatar'], $user['id']));
  
// }
function updateUserProfile($id,$displayName,$phone,$hasAvatar,$avatar,$GioiTinh,$NamSinh,$privacyNamSinh,$privacyPhone,$privacyEmail,$privacyGioiTinh) {
  global $db;
  $stmt = $db->prepare("UPDATE  users SET displayName =?,phone=?, hasAvatar = ?, avatar = ?,gender=?,NamSinh=?,privacyNamSinh=?,privacyPhone=?,privacyEmail=?,privacyGioiTinh=? where id=?");
  return  $stmt->execute(array($displayName,$phone,$hasAvatar,$avatar,$GioiTinh,$NamSinh,$privacyNamSinh,$privacyPhone,$privacyEmail,$privacyGioiTinh,$id));
}
function getFriends($userId) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId1 = ? OR userId2 = ?");
  $stmt->execute(array($userId, $userId));
  $followings = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $friends = array();
  for ($i = 0; $i < count($followings); $i++) {
    $row1 = $followings[$i];
    if ($userId == $row1['userId1']) {
      $userId2 = $row1['userId2'];
      for ($j = 0; $j < count($followings); $j++) {
        $row2 = $followings[$j];
        if ($userId == $row2['userId2'] && $userId2 == $row2['userId1']) {
          $friends[] = findUserById($userId2);
        }
      }
    }
  }
  return $friends;
}
function GetUser($search,$currentId)
{
  global $db;
  $stmt = $db->prepare("SELECT * FROM users WHERE (email=? or displayName=? or phone=?) and id!=?");
  $stmt->execute(array($search, $search,$search,$currentId));
  $followings = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $friends = array();
  for ($i = 0; $i < count($followings); $i++)
  {
    $friends[] = $followings[$i];
  }
  return $friends;

}
function YeuCauKetBan($userId) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId2 = ?");
  $stmt->execute(array($userId));
  $followings = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $friends = array();
  for ($i = 0; $i < count($followings); $i++) {
    $row1 = $followings[$i];
    if ($userId == $row1['userId2']) {
      $stmt1 = $db->prepare("SELECT * FROM friends WHERE userId1 = ? and userId2 = ?");
      $stmt1->execute(array($userId,$row1['userId1']));
      $followings1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
      $dem=count($followings1);
      if($dem==0)
      {
        $friends[] = findUserById($row1['userId1']);
      }
    }
  }
  return $friends;
}
function YeuCauDaGui($userId) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId1 = ?");
  $stmt->execute(array($userId));
  $followings = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $friends = array();
  for ($i = 0; $i < count($followings); $i++) {
    $row1 = $followings[$i];
    if ($userId == $row1['userId1']) {
      $stmt1 = $db->prepare("SELECT * FROM friends WHERE userId1 = ? and userId2 = ?");
      $stmt1->execute(array($row1['userId2'],$userId));
      $followings1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
      $dem=count($followings1);
      if($dem==0)
      {
        $friends[] = findUserById($row1['userId2']);
      }
    }
  }
  return $friends;
}
function isFollow($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId1, $userId2));
  $user1ToUser2 = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$user1ToUser2) {
    return false;
  }
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId2, $userId1));
  $user2ToUser1 = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($user2ToUser1) {
    return false;
  }
  return true;
}
function KiemTraFollow($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId3 = ? AND userId4 = ?");
  $stmt->execute(array($userId1, $userId2));
  $user1ToUser2 = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$user1ToUser2) {
    return false;
  }
  return true;
}
function HuyFollow($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId1 = ? AND userId2 = ? AND userId3 = ? AND userId4 = ?");
  $stmt->execute(array(0,0,$userId1, $userId2));
  $user1ToUser2 = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$user1ToUser2) {
    $stmt = $db->prepare("UPDATE friends SET userId3 = ?,userId4 = ? WHERE userId3 = ? AND userId4 = ?");
    $stmt->execute(array(0,0,$userId1, $userId2));
  }
  else{
    $stmt = $db->prepare("DELETE FROM friends WHERE userId3 = ? AND userId4 = ?");
    $stmt->execute(array($userId1, $userId2));
  }
}
function Follow($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId1, $userId2));
  $user1ToUser2 = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$user1ToUser2) {
    $stmt = $db->prepare("INSERT INTO friends(userId3, userId4) VALUES(?, ?)");
    $stmt->execute(array($userId1, $userId2));
  }
  else{
    $stmt = $db->prepare("UPDATE friends SET userId3 = ?,userId4 = ?  WHERE userId1 = ? AND userId2 = ?");
    $stmt->execute(array($userId1, $userId2,$userId1, $userId2));
  }

  $stmt = $db->prepare("UPDATE users set dem=dem+? where id= ?");
  $stmt->execute(array(1,$userId2));

  $stmt = $db->prepare("INSERT INTO notification (id1, id2, content,privacy) VALUE (?, ?, ?, ?)");
  $stmt->execute(array($userId1,$userId2,'đã theo dõi bạn',f));
}
function DeleteAccount($id)
{
  global $db;
  $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
  $stmt->execute(array($id));
}

function unfriend($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("DELETE FROM friends WHERE userId1 = ? AND userId2 = ? AND ((userId3 = ? AND userId4 = ?) or (userId3 = ? AND userId4 = ?))");
  $stmt->execute(array($userId1, $userId2,$userId1, $userId2,0,0));
  $stmt = $db->prepare("DELETE FROM friends WHERE userId1 = ? AND userId2 = ? AND ((userId3 = ? AND userId4 = ?) or (userId3 = ? AND userId4 = ?))");
  $stmt->execute(array($userId2, $userId1,$userId2, $userId1,0,0));
}

function sendFriendRequest($userId1, $userId2) {
  global $db,$BASE_URL;
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId3 = ? AND userId4 = ?");
  $stmt->execute(array($userId1, $userId2));
  $user1ToUser2 = $stmt->fetch(PDO::FETCH_ASSOC);
  $User2=findUserById($userId2);
  $User1=findUserById($userId1);
  if (!$user1ToUser2) {
    $stmt = $db->prepare("INSERT INTO friends(userId1, userId2,userId3, userId4) VALUES(?, ?, ?, ?)");
    $stmt->execute(array($userId1, $userId2,$userId1, $userId2));
    sendEmail($User2['email'], $User2['displayName'], 'Lời mời kết bạn Mạng xã hội FaBo',$User1['displayName']. " vừa gửi cho bạn một lời mời kết bạn <br> Xem thông tin người này <a href=\"$BASE_URL/wall.php?id=$userId1\">Xem</a>");
  }
  else{
    $stmt = $db->prepare("UPDATE friends SET userId1 = ?,userId2 = ?  WHERE userId3 = ? AND userId4 = ?");
    $stmt->execute(array($userId1, $userId2,$userId1, $userId2));
    sendEmail($User2['email'], $User2['displayName'], 'Lời mời kết bạn Mạng xã hội FaBo',$User1['displayName']. " vừa gửi cho bạn một lời mời kết bạn <br> Xem thông tin người này <a href=\"$BASE_URL/wall.php?id=$userId1\">Xem</a>");
  } 

  $stmt = $db->prepare("UPDATE users set dem=dem+? where id= ?");
  $stmt->execute(array(1,$userId2));

  $stmt = $db->prepare("INSERT INTO notification (id1, id2, content,privacy) VALUE (?, ?, ?, ?)");
  $stmt->execute(array($userId1,$userId2,'đã gửi cho bạn lời mời kết bạn',f));
}

function acceptFriendRequest($userId1, $userId2) {
  global $db,$BASE_URL;
  $stmt = $db->prepare("INSERT INTO friends(userId1, userId2,userId3, userId4) VALUES(?, ?, ?, ?)");
  $stmt->execute(array($userId1, $userId2,$userId1, $userId2));
  $User2=findUserById($userId2);
  $User1=findUserById($userId1);
  sendEmail($User2['email'], $User2['displayName'], 'Lời mời kết bạn Mạng xã hội FaBo',$User1['displayName']. " vừa chấp nhận lời kết bạn của bạn <br> Xem thông tin người này <a href=\"$BASE_URL/wall.php?id=$userId1\">Xem</a>");

  $stmt = $db->prepare("UPDATE users set dem=dem+? where id= ?");
  $stmt->execute(array(1,$userId2));

  $stmt = $db->prepare("INSERT INTO notification (id1, id2, content,privacy) VALUE (?, ?, ?, ?)");
  $stmt->execute(array($userId1,$userId2,'đã chấp nhận lời kết bạn của bạn',f));
}

function rejectFriendRequest($userId1, $userId2){
  global $db;
  $stmt = $db->prepare("UPDATE friends SET userId1 = ?,userId2 = ?  WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array(0,0,$userId2, $userId1));
}

function cancelFriendRequest($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("DELETE FROM friends WHERE userId1 = ? AND userId2 = ? AND ((userId3 = ? AND userId4 = ?) or (userId3 = ? AND userId4 = ?))");
  $stmt->execute(array($userId1, $userId2,$userId1, $userId2,0,0));
}

function resizeImage($filename, $max_width, $max_height)
{
  list($orig_width, $orig_height) = getimagesize($filename);

  $width = $orig_width;
  $height = $orig_height;

  # taller
  if ($height > $max_height) {
      $width = ($max_height / $height) * $width;
      $height = $max_height;
  }

  # wider
  if ($width > $max_width) {
      $height = ($max_width / $width) * $height;
      $width = $max_width;
  }

  $image_p = imagecreatetruecolor($width, $height);

  $image = imagecreatefromjpeg($filename);

  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

  return $image_p;
}
function KiemTraLike($post_id,$userid)
{
  global $db1;

  $sql = "SELECT * FROM likes WHERE userId=$userid
        AND postId=$post_id ";
  $result = mysqli_query($db1, $sql);
  if (mysqli_num_rows($result) > 0) {
    return true;
  }else{
    return false;
  }
}
function DemLike($id)
{
  global $db;
  $stmt = $db->prepare("SELECT COUNT(*) FROM likes WHERE postId = ?");
  $stmt->execute(array($id));
  return $stmt->fetch(PDO::FETCH_ASSOC);
}
function Like($id1,$id2)
{
    global $db;
    $stmt=$db->query("INSERT INTO likes (postId, userId) VALUE (?, ?)");
    $stmt->execute(array($id1, $id2));
}
function UnLike($id1,$id2)
{   
    global $db;
    $stmt = $db->prepare("DELETE FROM likes WHERE postId = ? AND userId = ?");
    $stmt->execute(array($id1, $id2));
}
function upcomment($userId,$postId,$content){
  global $db;
  $stmt=$db->prepare("INSERT INTO comments (postId,userId,content) VALUES (? , ?,?)");
  $stmt->execute(array($postId,$userId,$content));
 return $db->lastInsertId();
}
function getcomment($id){
  global $db;
  $stmt=$db->prepare("SELECT p.id,pc.userId,u.avatar,u.displayName,pc.content,pc.createdAt ,p.image,pc.id FROM comments AS pc JOIN users as u on  u.id= pc.userId JOIN posts as p where p.id= pc.postId and pc.postId=? ORDER BY pc.createdAt DESC");
  $stmt->execute(array($id));
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $posts;
}
function usercommentd($post_id,$userid)
{
  global $db1;

  $sql = "SELECT * FROM comments WHERE userId=$userid
        AND postId=$post_id ";
  $result = mysqli_query($db1, $sql);
  if (mysqli_num_rows($result) > 0) {
    return true;
  }else{
    return false;
  }
}
function getcountcomments($id)
{
  global $db;
  $stmt = $db->prepare("SELECT COUNT(*) FROM comments WHERE postId = ?");
  $stmt->execute(array($id));
  return $stmt->fetch(PDO::FETCH_ASSOC);
}
function deletecomment($idcomment) {
  global $db;
  $stmt = $db->prepare("DELETE FROM comments WHERE id = ? ");
  $stmt->execute(array($idcomment));
}
function deleteallcomment($idpost) {
  global $db;
  $stmt = $db->prepare("DELETE FROM comments WHERE postId = ? ");
  $stmt->execute(array($idpost));
}
function getNewFeeds($limit)
{
    global $db;
    $stmt=$db->query("SELECT p.*,u.displayName,u.hasAvatar FROM posts p join users u on p.userId=u.id where privacy=N'Bạn bè' or privacy=N'Công khai'order by p.createdAt desc limit $limit");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getNewFeedsCaNhan($id,$limit)
{
    global $db;
    $stmt=$db->query("SELECT p.*,u.displayName,u.hasAvatar FROM posts p join users u on p.userId=u.id where p.userId=$id order by p.createdAt desc limit $limit");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function createPost($userId, $content,$image,$privacy) {
    global $db;
    $stmt = $db->prepare("INSERT INTO posts (userId, content,image,privacy,createdAt) VALUE (?, ?, ?, ?, CURRENT_TIMESTAMP())");
    $stmt->execute(array($userId, $content,$image,$privacy));
    return $db->lastInsertId();
  }
  function createUser($displayName, $email, $NamSinh,$gender,$phone, $password) {
    global $db, $BASE_URL;
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $code = generateRandomString(16);
    $stmt = $db->prepare("INSERT INTO users (displayName, email, NamSinh, gender, phone, password, status, code) VALUES (?, ?, ?, ?, ?,?,?,?)");
    $stmt->execute(array($displayName, $email,$NamSinh,$gender,$phone,$hashPassword, 0, $code));
    $id = $db->lastInsertId();
    sendEmail($email, $displayName, 'Kích hoạt tài khoản', "Mã kích hoạt tài khoản của bạn là <a href=\"$BASE_URL/activate.php?code=$code\">$BASE_URL/activate.php?code=$code</a>");
    return $id;
  }
  function resetpassword($email) {
    global $BASE_URL;
    $user = findUserByEmail($email);
    $_SESSION['userId1'] = $user['id'];
    sendEmail($email,'', 'Reset password', "Đổi mật khẩu mới: <a href=\"$BASE_URL/new_password.php\">$BASE_URL/new_password.php</a>");
  }
  
  function generateRandomString($length = 10) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
  
  function sendEmail($to, $name, $subject, $content) {
    global $EMAIL_FROM, $EMAIL_NAME, $EMAIL_PASSWORD;
  
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
  
    //Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->CharSet    = 'UTF-8';
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $EMAIL_FROM;                     // SMTP username
    $mail->Password   = $EMAIL_PASSWORD;                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to
  
    //Recipients
    $mail->setFrom($EMAIL_FROM, $EMAIL_NAME);
    $mail->addAddress($to, $name);     // Add a recipient
  
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $content;
    // $mail->AltBody = $content;
  
    $mail->send();
  }
  
  function activateUser($code) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE code = ? AND status = ?");
    $stmt->execute(array($code, 0));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && $user['code'] == $code) {
      $stmt = $db->prepare("UPDATE users SET code = ?, status = ? WHERE id = ?");
      $stmt->execute(array('', 1, $user['id']));
      return true;
    }
    return false;
  }

  function getLatestConversations($userId) {
    global $db;
    $stmt = $db->prepare("SELECT userId2 AS id, u.displayName, u.hasAvatar FROM messages AS m LEFT JOIN users AS u ON u.id = m.userId2 WHERE userId1 = ? GROUP BY m.userId2 desc");
    $stmt->execute(array($userId));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    for ($i = 0; $i < count($result); $i++) {
      $stmt = $db->prepare("SELECT * FROM messages WHERE userId1 = ? AND userId2 = ? ORDER BY createdAt DESC LIMIT 1");
      $stmt->execute(array($userId, $result[$i]['id']));
      $lastMessage = $stmt->fetch(PDO::FETCH_ASSOC);
      $result[$i]['lastMessage'] = $lastMessage;
    }
    return $result;
  }
  
  function getnotifications($userId)
  {
    global $db;
    $stmt = $db->prepare("SELECT u.*,n.* FROM notification n, users u WHERE n.id1=u.id and id2 = ? ORDER BY createdAt desc");
    $stmt->execute(array($userId));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  function updateNotification($id)
  {
    global $db;
    $stmt = $db->prepare("UPDATE users set dem=? WHERE id = ?");
    $stmt->execute(array(0,$id));
  }
  function getMessagesWithUserId($userId1, $userId2) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM messages WHERE userId1 = ? AND userId2 = ? ORDER BY createdAt asc");
    $stmt->execute(array($userId1, $userId2));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  function sendMessage($userId1, $userId2, $content) {
    global $db,$BASE_URL;
    $stmt = $db->prepare("INSERT INTO messages (userId1, userId2, content, type) VALUE (?, ?, ?, ?)");
    $stmt->execute(array($userId1, $userId2, $content, 0));
    $id = $db->lastInsertId();
    $stmt = $db->prepare("SELECT * FROM messages WHERE id = ?");
    $stmt->execute(array($id));
    $newMessage = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $db->prepare("INSERT INTO messages (userId2, userId1, content, type, createdAt) VALUE (?, ?, ?, ?, ?)");
    $stmt->execute(array($userId1, $userId2, $content, 1, $newMessage['createdAt']));
    $User2=findUserById($userId2);
    $User1=findUserById($userId1);
    sendEmail($User2['email'], $User2['displayName'], 'Tin nhắn mới Mạng xã hội FaBo',$User1['displayName']. " vừa gửi cho bạn: $content <br> Đi đến cuộc trò chuyện <a href=\"$BASE_URL/conversation.php?id=$userId1\">Đi đến cuộc trò chuyện</a>");

    $stmt = $db->prepare("UPDATE users set dem=dem+? where id= ?");
    $stmt->execute(array(1,$userId2));

    $stmt = $db->prepare("INSERT INTO notification (id1, id2, content,privacy) VALUE (?, ?, ?, ?)");
    $stmt->execute(array($userId1,$userId2,'đã gửi cho bạn một tin nhắn mới',m));
  }
  function deleteMessageWithId($id)
  {
    global $db;
    $stmt = $db->prepare("DELETE FROM messages WHERE id=?");
    $stmt->execute(array($id));
  }
  function deleteNotificationsWithId($id)
  {
    global $db;
    $stmt = $db->prepare("DELETE FROM notification WHERE id=?");
    $stmt->execute(array($id));
  }
  function deleteAllNotifications($id)
  {
    global $db;
    $stmt = $db->prepare("DELETE FROM notification WHERE id2=?");
    $stmt->execute(array($id));
  }
  function deleteAllMessageWithId($userId1, $userId2)
  {
    global $db;
    $stmt = $db->prepare("DELETE FROM messages WHERE userId1 = ? AND userId2 = ?");
    $stmt->execute(array($userId1, $userId2));
  }
  function deletePostWithId($id)
  {
    global $db;
    $stmt = $db->prepare("DELETE FROM posts WHERE id=?");
    $stmt->execute(array($id));
  }
