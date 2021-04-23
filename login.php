<html>
<head>
<title>BDLSHOP</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/Js.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <script src="external/jquery/jquery.js"></script>
    <script src="javascript/jquery-ui.min.js"></script>
<script type="module" src="javascript/script.js"></script>
<script src="javascript/jquery-3.5.1.js"></script>
<script src="javascript/moment-with-locales.js"></script>
<script>
    let jq351 = $.noConflict(true);
window.addEventListener('load',function(){
    onLoad();
	Home();
	spmoi(1);
	menu.apply(<?php include 'php/xuly.php'; echo menu()?>);
	showPageSP(<?php echo sanPham(10);?>,<?php echo getPA()?>,<?php echo numPage(10);?>);
	Cart();
	vanceOption('#vance','Search(1);');
	showErrorLogin(<?php echo errorLogin();?>);
});
</script>
</head>
<body>

<div id="topmenu">
		<div style="width:3%;float:right;padding-top:2px;"><a href="?gh"><img src="image/shopping-cart-solid.png" class="shoppingicon"></a></div>
		<div style="float:right;width:10%;height:30px;padding:7px 0 0 2px;"><button class="DK" onClick="document.getElementById('id02').style.display='block';document.getElementById('mac').style.zIndex='-1';document.getElementById('shop').style.zIndex='-1'; ">Đăng ký</button></div>
<div id="id02" class="modal ">
  <form class="modal-content animate modaldk" method="post" action="php/xuly.php?action=register" name="register">
   	<div class="container" style="padding:0 20px 10px 20px;line-height:0.3;">
      <h1>Đăng Ký</h1>
      <hr>
      <label for="ht"><b>Họ và Tên</b></label><div class="Valid check1"></div>
      <input type="text" placeholder="Nhập họ tên" name="ht">
      
      <label for="username"><b>Tên đăng nhập</b></label><div class="Valid check1"></div>
      <input onKeyUp="checkUser();" type="text" placeholder="Nhập Username" name="user">

      <label for="psw"><b>Mật khẩu</b></label><div class="Valid check1"></div>
      <input type="password" placeholder="Nhập Password" name="pass">

      <label for="psw-repeat"><b>Nhập lại mật khẩu</b></label><div class="Valid check1"></div>
      <input type="password" placeholder="Nhập lại Password" name="repass">

	<label for="email"><b>Email</b></label><div class="Valid check1"></div>
      <input type="text" placeholder="Nhập Email" name="email">
	
	<label for="sdt"><b>Số điện thoại</b></label><div class="Valid check1"></div>
      <input type="text" placeholder="Nhập số điện thoại" name="sdt">

	<label for="address"><b>Địa chỉ</b></label><div class="Valid check1"></div>
      <input type="text" placeholder="Nhập địa chỉ" name="address">
	  </div>
      <div class="container" style="padding:15px;">
		  <button type="submit" class="signupbtn" onClick="return checkValid();">Đăng kí</button>
		  <button type="button" style="float: right" onClick="document.getElementById('id01').style.display='block';document.getElementById('id02').style.display='none';document.getElementById('mac').style.zIndex='-1';document.getElementById('shop').style.zIndex='-1';">Đã có tài khoản? nhấn vào đây</button>
    </div>
  </form>
</div>
		<div style="width:10%;float:right;height:30px;padding:7px 0 0 2px;"><button class="DN" onClick="document.getElementById('id01').style.display='block';document.getElementById('mac').style.zIndex='-1';document.getElementById('shop').style.zIndex='-1';">Đăng nhập</button> </div>
<div id="id01" class="modal">
  
  <form id="login" class="modal-content animate modaldn" action="php/xuly.php?action=login" name="login" method="post">

    <div class="container">
      <label for="uname"><strong>Tên đăng nhập</strong></label>
      <input type="text" placeholder="Username" name="user" value="<?php userError();?>" required>

    <label for="psw"><b>Mật Khẩu</b></label>
    <input type="password" placeholder="Password" name="pass" required>
    <label>
      <input id="remember" type="checkbox" checked="checked" name="remember">Lưu trình duyệt
    </label>
  </div>

  <div class="container" >
    <button type="submit" onClick="return check();">Đăng nhập</button>
    <button type="button" style="float: right" onClick="document.getElementById('id02').style.display='block';document.getElementById('id01').style.display='none';document.getElementById('mac').style.zIndex='-1';document.getElementById('shop').style.zIndex='-1';">Chưa có tài khoản?Đăng kí ở đây</button>
  </div>
  </form>
</div>
  	<div class="filter"><button style="width:100%;height:100%;"  onclick="$('#vance').toggle('fast');">Lọc</button></div>
  	<div style="width:50%;height:35px;float:right;"><input style="height:100%;border:1px solid white;border-radius:5px;	margin:2.5px;" id="dataSearch" onKeyUp="Search(1);" type="text" placeholder="Nhập tên điện thoại cần tìm" name="search"></div>
    <a href="index.php"><div style="font-size:100%;padding:10px 21px;color:#FFFFFF;font-family:'Times New Roman', Times, serif">BDLSHOP</div></a>
    <div id='vance' style='display:none;clear:left;'></div><div id="spSearch"></div><div id="tr"></div>

<script>
	/*search*/
	function openSearch() {
  document.getElementById("search").style.display = "block";
  document.getElementById("mac").style.zIndex="-1";
  document.getElementById("shop").style.zIndex="-1";
}

function closeSearch() {
  document.getElementById("search").style.display = "none";
document.getElementById("mac").style.zIndex="10";
  document.getElementById("shop").style.zIndex="10";
}
/*Dn,DK*/
	  var modal = document.getElementById('id01');
	var modal1=document.getElementById('id02');
window.addEventListener('click',function(event) {
	if(modal.style.display=="block") x=modal;
	if(modal1.style.display=="block") x=modal1;
    if (event.target == x) {
        x.style.display = "none";
	document.getElementById("mac").style.zIndex="10";
 	 document.getElementById("shop").style.zIndex="10";
    }});
	  </script>
</div>
<div>
<nav class="nav-wrapper">
  <div class="logo"> 
	  <a href="index.php"><img src="image/logo-dt.png" class="logoicon"></a>
  </div>
  <ul class="nav-items main-nav mobile-hide">
    <li class="list-item"><a href="?idBrand=IP&pageActive=1" >Trang chủ</a></li>
    <li class="list-item"><a href="#gt">Giới Thiệu</a></li>
    <li class="list-item" style="position:relative;"><a>Thể Loại</a><ul id="m" type="none"></ul></li>
    <li class="list-item"><a href="?maymoi">Máy mới</a></li>
    <li class="list-item"><a href="#lh">Liên Hệ</a></li>
  </ul>
</nav>
</div>	
<div class="main-wrapper" id="bodi">
  <div class="wrapper">
	<div class="featured">
    	<h3 style="color:black;">iPhone</h3>
    </div>
    <div class="sub-featured">
      <div class="sub1">
        <h3 >Samsung</h3>
      </div>
      <div class="sub2">
        <h3 >Oppo</h3>
      </div>
      <div class="sub3">
        <h3>Vivo</h3>
      </div>
    </div>
    <div class="main-content" id="mac">
     	<div id="menu"></div><div id="sp"></div><div id="trang"></div></div>
		
	  </div>
  </div>
</div>
<footer id="gt" class="footer">
  <div class="foot1">
    <h3 class="logo">BLDSHOP</h3>
  </div>
  <div class="foot2">
    <h4>Tạo ra bởi</h4>
    	<p>Trần Bảo Long</p>
	<p>Dương Ngọc Bảo</p>
	<p>Nguyễn Tuấn Đạt</p>
	<p>Vòng lương Khánh</p>
  </div>
  <div class="foot3">
    <h4>Địa chỉ</h4>
  	<p>273 An Dương Vương</p>
    	<p>Thành Phố Hồ Chí Minh,Việt Nam</p>
  </div>
  <div id="lh" class="foot4">
    <h4>Thông Tin Liên Hệ</h4>
	<h5>SDT:<span>0909096969</span></h5>
	<h5>EMAIL:<span>BLDSHOP@gmail.com</span></h5>
  </div>
  <div class="copyright">BLDSHOP</div>
</footer>

</body>
</html>
