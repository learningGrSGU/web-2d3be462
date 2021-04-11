<!doctype html>
<!DOCTYPE html>
<html>
<head>
<title>BLDSHOP(user)</title>
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
    isLogin(<?php include 'php/xuly.php'; isLogin(); ?>)
	user();
	Home();
	menu.apply(<?php echo menu()?>);
	showPageSP(<?php echo sanPham(10);?>,<?php echo getPA()?>,<?php echo numPage(10);?>);
	Cart();
	LsGd(<?php echo lsgd(5);?>,<?php echo getPA()?>,<?php echo numPagelsgd(5);?>);
	vanceOption('#vance','Search(1);');
	spmoi(1);
});
</script>
</head>
<body>
<div id="topmenu">
	<div style="width:3%;float:right;padding-top:2px;"><a href="?gh"><img src="image/shopping-cart-solid.png" class="shoppingicon"></a></div>
    <div style="width:20%;float:right;padding-top:3px"><div id='name' style="text-align:center;"><img  src="image/user-solid.png" style="height:30px;width:30px;"><div id="user"><a href="?LSGD=lsgd&pageActive=1">Lịch sử giao dịch</a><button class="logout" onClick="logout();">Đăng xuất</button></div></div></div>
  	<div class="filter"><button style="width:100%;height:100%;"  onclick="$('#vance').toggle('fast');">Lọc</button></div>
  	<div style="width:50%;height:35px;float:right;"><input style="height:100%;border:1px solid white;border-radius:5px;	margin:2.5px;" id="dataSearch" onKeyUp="Search(1);" type="text" placeholder="Nhập tên điện thoại cần tìm" name="search"></div>
    <a href="index.php"><div style="font-size:100%;padding:10px 21px;color:#FFFFFF;font-family:'Times New Roman', Times, serif">BDLSHOP</div></a>
    <div id='vance' style='display:none;clear:left;'></div><div id="spSearch"></div><div id="tr"></div>
    
<script>
/*hover*/
function user(){
	var user=document.createElement('span');
	user.id='ten';
	user.innerHTML=getCookie('name');
	$('#user').before(user);
}
/**/

	/*search*/
	function openSearch() {
  document.getElementById("search").style.display = "block";
}

function closeSearch() {
  document.getElementById("search").style.display = "none";
}
	
</script>
	</div>
<div>
<nav class="nav-wrapper">
  <div class="logo"> 
	  <a href="user.php"><img src="image/logo-dt.png" class="logoicon"></a>
  </div>
   <ul class="nav-items main-nav mobile-hide">
   	<li class="list-item"><a href="?idBrand=IP&pageActive=1">Trang chủ</a></li>
    <li class="list-item"><a href="#gt">Giới Thiệu</a></li>
    <li class="list-item" style="position:relative;"><a>Thể Loại</a><ul id="m" type="none"></ul></li>
    <li class="list-item"><a href="?maymoi">Máy mới</a></li>
    <li class="list-item"><a href="#lh">Liên Hệ</a></li>
  </ul>
</nav>
</div>	
<div class="main-wrapper">
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
        <h3 >Vivo</h3>
      </div>
    </div>
    <div class="main-content">
     	<div id="menu"><div id="sp"></div><div id="trang"></div></div>
		
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
