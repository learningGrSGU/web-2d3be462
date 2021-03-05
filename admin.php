<!doctype html>
<html>
<head>
<title>BLDSHOP(Admin)</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/Js.css" type="text/css">
<script src='javascript/objectexporter.min.js'></script>
<script src="javascript/script.js"></script>
<script src="javascript/jquery-3.5.1.js"></script>
<script src="javascript/moment-with-locales.js"></script>
<script>
window.addEventListener('load',function(){
    onLoad();
    isLogin(<?php include 'php/xuly.php'; isLogin(); ?>)
	Homead();
	xlDh(<?php echo numPageDH(6)?>);
	tkDH();
	product();
	vanceOption('#vance','Search(1);');
	vanceOption('#DHvance','onchangeTkDH(1);');
	vanceOption('#DHVance','xlDhVance(1);');
	vanceOption('#PDvance','productList(1);');
	qltk(1);
});
</script>
</head>
<body>
<div id="topmenu" style="height:30px;">
    
    <div style="width:100%;heigth:30px;"><div style="width:50%;float:left;padding:12px;font-size:24px;font-family:Georgia, 'Times New Roman', Times, serif;text-align:right;color:white">Xin Chào Admin</div><div style="padding:8px;width:50%;float:right;"><a href="" onClick="logout();" id="ad" onMouseOver="admover();" onMouseOut="admout();"><span style="color:white;font-size:24px;">Dương Ngọc Bảo</span></a></div></div>
    
<script>
	/*hover*/
	function admover(){
		document.getElementById("ad").style='color:white;font-size:24px;';
		document.getElementById("ad").innerHTML='Đăng xuất';
	}
	function admout(){
		document.getElementById("ad").style='color:white;font-size:24px;';
		document.getElementById("ad").innerHTML='Dương Ngọc Bảo';
	}
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
	/*topmenu*/
/*Dn,DK*/
	  var modal = document.getElementById('id01');
	var modal1=document.getElementById('id02');
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
	
}
	  </script>
</div>
<div>
<nav class="nav-wrapper">
  <div class="logo"> 
	  
  </div>
  <ul class="nav-items main-nav mobile-hide">
    <li class="list-item"><a href="?qltk">Quản lý tài khoản</a></li>
    <li class="list-item"><a href="?dssp">Quản lý sản phẩm</a></li>
    <li class="list-item"><a href="?tksp">Thống kê đơn hàng</a></li>
    <li class="list-item"><a href="?DH=xldh">Xác nhận đơn hàng</a></li>
  </ul>
</nav>
</div>	
<div class="main-wrapper" id="bodi">
  <!--<div class="wrapper">
	<div class="featured">
    </div>
    <div class="sub-featured">
      <div class="sub1">
        <h3>Hot</h3>
      </div>
      <div class="sub2">
        <h3>New</h3>
      </div>
      <div class="sub3">
        <h3>About BlackFriday Sale</h3>
      </div>
    </div>
    </div>
-->
<div id="id02" class="modal ">
  <form class="modal-content animate modaldk" method="post" action="php/xuly.php?action=register&admin=1" name="register">
    <div class="container" style="padding:0 20px 0 20px;line-height:0.3;">
      <h1 style="color:red;">Vui lòng nhập đầy đủ thông tin để thêm tài khoản!!!!</h1>
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
      <div class="container" style="text-align:center;padding:10px 20px;">
        <button style="border:2px solid black;border-radius:5px;padding:5px;" type="button" onClick="document.getElementById('id02').style.display='none'" class="cancelbtn">Hủy</button>
		  <button style="border:2px solid black;border-radius:5px;padding:5px;" type="submit" class="signupbtn" onClick="return checkValid();">Thêm tài khoản</button>
    </div>
  </form>
</div>
<script>
var modal1=document.getElementById('id02');
window.addEventListener('click',function(event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    }});
</script> 
    <div class="main-content" id="mac">
     	<div id="menu"><div style="width:100%;padding:10px;background-color:white;">
        </div><div id="opt"></div><div id="sp"></div><div id="trang"></div></div>	
	  </div>
  </div>
</body>
<footer id="gt" class="footer">
  <div class="foot1">
    <h3 class="logo">BLDSHOP</h3>
  </div>
  <div class="foot2">
    <h4>Tạo ra bởi</h4>
    	<p>Trần Bảo Long</p>
	<p>Dương Ngọc Bảo</p>
	<p>Nguyễn Tuấn Đạt</p>
	<p>Vòng Lương Khánh</p>
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