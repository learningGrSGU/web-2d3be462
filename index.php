<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <title>Phone Shop</title>
   <link rel="stylesheet" type="text/css" href="style.css">
   <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
   <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/Js.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <script src="external/jquery/jquery.js"></script>
    <script src="javascript/jquery-ui.min.js"></script>
    <script src="javascript/script.js"></script>
    <script src="javascript/jquery-3.5.1.js"></script>
    <script src="javascript/moment-with-locales.js"></script>
    <script>
        let jq351 = $.noConflict(true);
        window.addEventListener('load',function(){
            onLoad();
            isLogin(<?php include 'php/xuly.php'; isLogin(); ?>)
            Home();
            spmoi(1);
            menu.apply(<?php echo menu()?>);
            showPageSP(<?php echo sanPham(10);?>,<?php echo getPA()?>,<?php echo numPage(10);?>);
            Cart();
            vanceOption('#vance','Search(1);');
            showErrorLogin(<?php echo errorLogin();?>);
        });
    </script>
</head>
<body>

<div class="header">
      
      <div class="container">
         <div class="navbar">
            <div class="logo">
               <img src="images/logo.png" width="125px">         
            </div>
            <nav>
               <ul id="MenuItems">
                  <li><a href="">Home</a></li>
                  <li><a href="">Products</a></li>
                  <li><a href="">About</a></li>
                  <li><a href="">Contact</a></li>
                  <li><a href="">Account</a></li>
               </ul>
            </nav>
            <img src="images/cart.png" width="30px" height="30px">
            <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
         </div>
         <div class="row">
            <div class="col-1">
               <h1>main-title</h1>
               <p>sub-title</p>
               <a href="" class="btn">Khám phá ngay &#8594;</a>
            </div>
            <div class="col-1">
               <img src="images/image1.png">
            </div>
         </div>
      </div>

</div>
<!--Danh mục-->
<div class="categories">
   <div class="small-container">
      <div class="row">
         <div class="col-2">
            <img src="images/category-1.jpg">
         </div>
         <div class="col-2">
            <img src="images/category-2.jpg">
         </div>
         <div class="col-2">
            <img src="images/category-3.jpg">
         </div>
   </div>
   </div>
</div>   
<!--Sản phẩm
***1 sao: <i class="fa fa-star"></i>
   nửa sao: <i class="fa fa-star-half-o"></i>
   0 sao: <i class="fa fa-star-o"></i>
-->
   <div class="small-container">
      <h2 class="title">Sản Phẩm</h2>
       <div id="menu"></div><div id="sp"></div><div id="trang"></div></div>

</div>
<!--
      <div class="row">
         <div class="col-3">
            <img src="images/product-1.jpg">
            <h4>Iphone</h4>
            <div class="rating">
               <i class="fa fa-star"></i>
               <i class="fa fa-star"></i>
               <i class="fa fa-star"></i>
               <i class="fa fa-star"></i>
               <i class="fa fa-star-o"></i>
            </div>
            <p>$100</p>
         </div>
         <div class="col-3">
            <img src="images/product-2.jpg">
            <h4>Iphone</h4>
            <div class="rating">
               <i class="fa fa-star"></i>
               <i class="fa fa-star"></i>
               <i class="fa fa-star"></i>
               <i class="fa fa-star"></i>
               <i class="fa fa-star-o"></i>
            </div>
            <p>$101</p>
         </div>
         <div class="col-3">
            <img src="images/product-3.jpg">
            <h4>Iphone</h4>
            <div class="rating">
               <i class="fa fa-star"></i>
               <i class="fa fa-star"></i>
               <i class="fa fa-star"></i>
               <i class="fa fa-star"></i>
               <i class="fa fa-star-o"></i>
            </div>
            <p>$102</p>
         </div>
         <div class="col-3">
            <img src="images/product-4.jpg">
            <h4>Iphone</h4>
            <div class="rating">
               <i class="fa fa-star"></i>
               <i class="fa fa-star"></i>
               <i class="fa fa-star"></i>
               <i class="fa fa-star"></i>
               <i class="fa fa-star-o"></i>
            </div>
            <p>$103</p>
         </div>
      </div>
-->
      <!-- tạo vòng lặp từ <h2>...</h2>
         chia ra 3 hàng nha mỗi hàng 4 sp t để sẵn rồi đó(1 row - 4sp col-3 nha)-->
   </div>
<!--Đề xuất--> 
   <div class="offer">
      <div class="small-container">
         <div class="row">
            <div class="col-1">
               <img src="images/exclusive.png" class="offer-img">
            </div>
            <div class="col-1">
               <p>Mặt hàng đang bán chạy</p>
               <h1>Xiaomi...</h1>
               <small>
                  Một số mô tả 
               </small>
               <a href="" class="btn">Mua Ngay &#8594;</a>
            </div>
         </div>
      </div>
   </div>

<!--nhà cung cấp-->
   <div class="brands">
      <div class="small-container">
         <div class="row">
            <div class="col-4">
               <img src="images/logo-oppo.png">
            </div>
            <div class="col-4">
               <img src="images/logo-oppo.png">
            </div>
            <div class="col-4">
               <img src="images/logo-oppo.png">
            </div>
            <div class="col-4">
               <img src="images/logo-oppo.png">
            </div>
            <div class="col-4">
               <img src="images/logo-oppo.png">
            </div>
         </div>
      </div>
      
   </div>
<!-- footer-->
<div class="footer">
   <div class="container">
      <div class="row">
         <div class="footer-col-1">
            <h3>Phone Shop</h3>            
         </div>
         <div class="footer-col-2">
            <h3>Make By:</h3>            
            <p>Dương Ngọc Bảo</p>
            <p>Trần Bảo Long</p>
            <p>Thái Bảo Long</p>            
         </div>
         <div class="footer-col-3">
            <h3>Địa chỉ</h3>
            <p>273 An Dương Vương</p>
            <p>Thành Phố Hồ Chí Minh,Việt Nam</p>         
         </div>
         <div class="footer-col-4">
            <h3>Thông Tin Liên Hệ</h3> 
            <p>0969696966</p>
            <p>phoneshop@gmail.com</p>          
         </div>
      </div>
      <hr>
      <p class="copyright">Copyright 2021 Some Where</p>
   </div>
</div>
<!-- JS -->
   <script >
      var MenuItems = document.getElementById("MenuItems")
      MenuItems.style.maxHeight = "0px";
      function menutoggle(){
         if (MenuItems.style.maxHeight == "0px") {
            MenuItems.style.maxHeight = "200px";
         } 
         else {
            MenuItems.style.maxHeight = "0px";
         }
      }
   </script>
</body>
</html>