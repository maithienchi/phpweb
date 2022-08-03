<?php
require_once 'init.php';

if (!$currentUser) {
  header('Location: index.php');
  exit();
}
$privacy="";
$privacy1="";
$privacy2="";
$displayName=$currentUser['displayName'];
$avatar=$currentUser['avatar'];
$phone=$currentUser['phone'];
$success = true;

// Kiểm tra người dùng có nhập tên
// if (isset($_POST['displayName'])) {
//   if (strlen($_POST['displayName']) > 0) 
//   {
//     $displayName=$_POST['displayName'];
//     updateUserProfile($currentUser);
//   } else {
//     $success = false;
//   }

  if(isset($_FILES['avatar']) && isset($_POST['phone']) && isset($_POST['displayName']) && isset($_POST['gender']))
  {
    if ( isset( $_FILES["avatar"] ) && !empty( $_FILES["avatar"]["name"] ) ) {
      if ( is_uploaded_file( $_FILES["avatar"]["tmp_name"] ) && $_FILES["avatar"]["error"] == 0 ){
      $fileName = $_FILES['avatar']['name'];
      $fileSize = $_FILES['avatar']['size'];
      $fileTemp = $_FILES['avatar']['tmp_name'];
      // $filePath = './avatars/' . $currentUser['id'] . '.jpg';
      //  move_uploaded_file($fileTemp, $filePath);
      $newImage = resizeImage($fileTemp, 480, 480);
      // imagejpeg($newImage, $filePath);
      ob_start();
      imagejpeg($newImage);
      $avatar = ob_get_contents();
      ob_end_clean();
      }
    }
    else{
      $avatar=$currentUser['avatar'];
    }
    if($_POST['birthday_day']==0 || $_POST['birthday_month']==0 || $_POST['birthday_year']==0){
      $NamSinh=$currentUser['NamSinh'];
    }
    else{
      $NamSinh=$_POST['birthday_day'].'-'.$_POST['birthday_month'].'-'.$_POST['birthday_year'];
    }
      // $currentUser['avatar']=$avatar;
      // $currentUser['hasAvatar'] = 1;
      $displayName=$_POST['displayName'];
      $phone=$_POST['phone'];
      $gender = $_POST['gender'];
      $privacyGioiTinh=$_POST['privacyGioiTinh'];
      $privacyPhone=$_POST['privacyPhone'];
      $privacyEmail=$_POST['privacyEmail'];
      $privacyNamSinh=$_POST['privacyNamSinh'];


      updateUserProfile($currentUser['id'],$displayName,$phone,1,$avatar,$gender,$NamSinh,$privacyNamSinh,$privacyPhone,$privacyEmail,$privacyGioiTinh);
      header('Location: Update-Profile.php');
  }
?>

<?php include 'header.php' ?>
<h1>Quản lý thông tin cá nhân</h1>
<?php if (!$success) : ?>
<div class="alert alert-danger" role="alert">
  Vui lòng nhập đầy đủ thông tin!
</div>
<?php endif; ?>
<form action="Update-Profile.php" method = "POST" enctype="multipart/form-data">
    <div class = "form-group">
    <label for="displayName">Họ Tên</label>
    <input type="text" name="displayName" class="form-control" placeholder="Họ Tên" value= "<?php echo $currentUser['displayName']; ?>">
    </div>
    <div class = "form-group">
    <br>
    <label for="email">Email: </label>
    <lable><strong><?php echo $currentUser['email'];?></strong></label>
    <br>
    <?php if($currentUser['privacyEmail'] =='Công khai'){
    $privacy='selected="1"';
    }
    else if($currentUser['privacyEmail'] =='Bạn bè'){
      $privacy1='selected="1"';
    }
    else{
      $privacy2='selected="1"';
    }
    ?>
    <select style ='font-size:10px' name="privacyEmail" >
    <option style ='font-size:10px' value="Công khai"<?php echo $privacy; ?>>Công khai</option> 
    <option style ='font-size:10px' value="Bạn bè" <?php echo $privacy1; ?>>Bạn bè</option> 
    <option style ='font-size:10px' value="Chỉ mình tôi"<?php echo $privacy2; ?>>Chỉ mình tôi</option> 
    </select>
    <?php 
    $privacy="";
    $privacy1="";
    $privacy2="";
    ?>
    </div>
    <div class ="form-group">
    <br>
    <label for="gioitinh">Giới tính</label>
    <div>
        <label for="male" class="radio-inline"><input type="radio" name="gender"
        value="Nam" id="male">Nam</label>
        <label for="female" class="radio-inline"><input type="radio" name="gender"
        value="Nữ" id="female">Nữ</label>
        <!-- <label for="others" class="radio-inline"><input type="radio" name="gender"
        value="o" id="others">Tùy chỉnh</label> -->
    <?php if($currentUser['privacyGioiTinh'] =='Công khai'){
    $privacy='selected="1"';
    }
    else if($currentUser['privacyGioiTinh'] =='Bạn bè'){
      $privacy1='selected="1"';
    }
    else{
      $privacy2='selected="1"';
    }
    ?>
    <select style ='font-size:10px' name="privacyGioiTinh" >
    <option style ='font-size:10px' value="Công khai" <?php echo $privacy; ?>>Công khai</option> 
    <option style ='font-size:10px' value="Bạn bè" <?php echo $privacy1; ?>>Bạn bè</option> 
    <option style ='font-size:10px' value="Chỉ mình tôi"<?php echo $privacy2; ?>>Chỉ mình tôi</option> 
    </select>
    <?php 
    $privacy="";
    $privacy1="";
    $privacy2="";
    ?>
    </div>
    </div>
    <div class="form-group">
    <br>
    <label for="ngaysinh">Ngày Sinh</label>
    <span>
    <select aria-label="Ngày" 
    name="birthday_day" id="day" 
    title="Ngày" class="_5dba _8esg">
    <option value="0">Ngày</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
    <option value="18">18</option>
    <option value="19">19</option>
    <option value="20">20</option>
    <option value="21">21</option>
    <option value="22">22</option>
    <option value="23">23</option>
    <option value="24">24</option>
    <option value="25">25</option>
    <option value="26">26</option>
    <option value="27">27</option>
    <option value="28">28</option>
    <option value="29">29</option>
    <option value="30">30</option>
    <option value="31">31</option>
    </select>
    <select 
    aria-label="Tháng" 
    name="birthday_month" id="month" 
    title="Tháng" class="_5dba _8esg">
    <option value="0">Tháng</option>
    <option value="1">Tháng 1</option>
    <option value="2">Tháng 2</option>
    <option value="3">Tháng 3</option>
    <option value="4">Tháng 4</option>
    <option value="5">Tháng 5</option>
    <option value="6">Tháng 6</option>
    <option value="7">Tháng 7</option>
    <option value="8">Tháng 8</option>
    <option value="9">Tháng 9</option>
    <option value="10">Tháng 10</option>
    <option value="11">tháng 11</option>
    <option value="12">Tháng 12</option>
    </select>
    <select 
    aria-label="Năm" 
    name="birthday_year" id="year" 
    title="Năm" class="_5dba _8esg">
    <option value="0">Năm</option>
    <option value="2019">2019</option>
    <option value="2018">2018</option>
    <option value="2017">2017</option>
    <option value="2016">2016</option>
    <option value="2015">2015</option>
    <option value="2014">2014</option>
    <option value="2013">2013</option>
    <option value="2012">2012</option>
    <option value="2011">2011</option>
    <option value="2010">2010</option>
    <option value="2009">2009</option>
    <option value="2008">2008</option>
    <option value="2007">2007</option>
    <option value="2006">2006</option>
    <option value="2005">2005</option>
    <option value="2004">2004</option>
    <option value="2003">2003</option>
    <option value="2002">2002</option>
    <option value="2001">2001</option>
    <option value="2000">2000</option>
    <option value="1999">1999</option>
    <option value="1998">1998</option>
    <option value="1997">1997</option>
    <option value="1996">1996</option>
    <option value="1995">1995</option>
    <option value="1994">1994</option>
    <option value="1993">1993</option>
    <option value="1992">1992</option>
    <option value="1991">1991</option>
    <option value="1990">1990</option>
    <option value="1989">1989</option>
    <option value="1988">1988</option>
    <option value="1987">1987</option>
    <option value="1986">1986</option>
    <option value="1985">1985</option>
    <option value="1984">1984</option>
    <option value="1983">1983</option>
    <option value="1982">1982</option>
    <option value="1981">1981</option>
    <option value="1980">1980</option>
    <option value="1979">1979</option>
    <option value="1978">1978</option>
    <option value="1977">1977</option>
    <option value="1976">1976</option>
    <option value="1975">1975</option>
    <option value="1974">1974</option>
    <option value="1973">1973</option>
    <option value="1972">1972</option>
    <option value="1971">1971</option>
    <option value="1970">1970</option>
    <option value="1969">1969</option>
    <option value="1968">1968</option>
    <option value="1967">1967</option>
    <option value="1966">1966</option>
    <option value="1965">1965</option>
    <option value="1964">1964</option>
    <option value="1963">1963</option>
    <option value="1962">1962</option>
    <option value="1961">1961</option>
    <option value="1960">1960</option>
    <option value="1959">1959</option>
    <option value="1958">1958</option>
    <option value="1957">1957</option>
    <option value="1956">1956</option>
    <option value="1955">1955</option>
    <option value="1954">1954</option>
    <option value="1953">1953</option>
    <option value="1952">1952</option>
    <option value="1951">1951</option>
    <option value="1950">1950</option>
    <option value="1949">1949</option>
    <option value="1948">1948</option>
    <option value="1947">1947</option>
    <option value="1946">1946</option>
    <option value="1945">1945</option>
    <option value="1944">1944</option>
    <option value="1943">1943</option>
    <option value="1942">1942</option>
    <option value="1941">1941</option>
    <option value="1940">1940</option>
    <option value="1939">1939</option>
    <option value="1938">1938</option>
    <option value="1937">1937</option>
    <option value="1936">1936</option>
    <option value="1935">1935</option>
    <option value="1934">1934</option>
    <option value="1933">1933</option>
    <option value="1932">1932</option>
    <option value="1931">1931</option>
    <option value="1930">1930</option>
    <option value="1929">1929</option>
    <option value="1928">1928</option>
    <option value="1927">1927</option>
    <option value="1926">1926</option>
    <option value="1925">1925</option>
    <option value="1924">1924</option>
    <option value="1923">1923</option>
    <option value="1922">1922</option>
    <option value="1921">1921</option>
    <option value="1920">1920</option>
    <option value="1919">1919</option>
    <option value="1918">1918</option>
    <option value="1917">1917</option>
    <option value="1916">1916</option>
    <option value="1915">1915</option>
    <option value="1914">1914</option>
    <option value="1913">1913</option>
    <option value="1912">1912</option>
    <option value="1911">1911</option>
    <option value="1910">1910</option>
    <option value="1909">1909</option>
    <option value="1908">1908</option>
    <option value="1907">1907</option>
    <option value="1906">1906</option>
    <option value="1905">1905</option>
     </select>
     </span>
    <?php if($currentUser['privacyNamSinh'] =='Công khai'){
    $privacy='selected="1"';
    }
    else if($currentUser['privacyNamSinh'] =='Bạn bè'){
      $privacy1='selected="1"';
    }
    else{
      $privacy2='selected="1"';
    }
    ?>
      <select style ='font-size:10px' name="privacyNamSinh" >
        <option style ='font-size:10px' value="Công khai" <?php echo $privacy; ?>>Công khai</option> 
        <option style ='font-size:10px' value="Bạn bè" <?php echo $privacy1; ?> >Bạn bè</option> 
        <option style ='font-size:10px' value="Chỉ mình tôi"<?php echo $privacy2; ?>>Chỉ mình tôi</option> 
        </select>
    <?php 
    $privacy="";
    $privacy1="";
    $privacy2="";
    ?>
    </div>
    <div class="form-group">
    <br>
    <label for="phone">Số điện thoại</label>
    <input type="phone" class="form-control" id="phone" name="phone" placeholder="số điện thoại" value= "<?php echo $currentUser['phone']; ?>">
    <?php if($currentUser['privacyPhone'] =='Công khai'){
    $privacy='selected="1"';
    }
    else if($currentUser['privacyPhone'] =='Bạn bè'){
      $privacy1='selected="1"';
    }
    else{
      $privacy2='selected="1"';
    }
    ?>
      <select style ='font-size:10px' name="privacyPhone" >
        <option style ='font-size:10px' value="Công khai"<?php echo $privacy; ?> >Công khai</option> 
        <option style ='font-size:10px' value="Bạn bè" <?php echo $privacy1; ?>>Bạn bè</option> 
        <option style ='font-size:10px' value="Chỉ mình tôi"<?php echo $privacy2; ?>>Chỉ mình tôi</option> 
        </select>
    <?php 
    $privacy="";
    $privacy1="";
    $privacy2="";
    ?>
    </div>
    <div class="form-group">
    <label for="avatar">Ảnh đại diện</label>
    <input type="file" class="form-control-file" name="avatar" id="avatar" >
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Cập nhật thông tin cá nhân</button>
    </form>
<?php include 'footer.php'; ?>


