<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Phone Shop</title>
    <link rel="stylesheet" type="text/css" href="css/main-web.css">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" type="text/css"
          href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/Js.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <script src="external/jquery/jquery.js"></script>
    <script src="javascript/jquery-ui.min.js"></script>
    <script type="module" src="javascript/script.js"></script>
    <script src="javascript/jquery-3.5.1.js"></script>
    <script src="javascript/moment-with-locales.js"></script>
    <script>
        let jq351 = $.noConflict(true);
        window.addEventListener('load', function () {
            onLoad();
            isLogin(<?php include 'php/xuly.php'; isLogin(); ?>)
            Home();
            spmoi(1);
            menu.apply(<?php echo menu()?>);
            showPageSP(<?php echo sanPham(10);?>,<?php echo getPA()?>,<?php echo numPage(10);?>);
            Cart();
            vanceOption('#vance', 'Search(1);');
            showErrorLogin(<?php echo errorLogin();?>);
            showCTSP();
        });
    </script>
</head>
<body>

<div class="header">

    <div class="container">
        <div class="navbar">
            <div class="logo">
                <img src="images/logo-shop.png" style="width:125px;border-radius:50%;">
            </div>
            <nav>
                <ul id="MenuItems">
                    <li><a href="">Trang Chủ</a></li>
                    <li><a href="">Giới Thiệu</a></li>
                    <li><a href="">Liên Hệ</a></li>
                    <li><a href="DN.php">Đăng Nhập</a></li>
                </ul>
            </nav>
            <a href="?gh"><img src="images/cart.png" width="30px" height="30px"></a>
        </div>
        <div id="none" class="row">
            <div class="col-1">
                <h1>Samsung Galaxy A50s</h1>
                <p>Galaxy A50s lựa chọn tốt nhất năm 2021</p>
                <a href="" class="btn">Khám phá ngay &#8594;</a>
            </div>
            <div class="col-1">
                <img src="images/samsung-galaxy-a50s.png">
            </div>
        </div>
    </div>

</div>

<!--nhà cung cấp,Danh mục-->
<div class="brands">
    <div class="small-container">
        <div id="m" class="row">
        </div>
    </div>

</div>
<div class="small-container">
    <h2 class="title">Sản Phẩm</h2>
    <div id="menu"></div>
    <div id="sp"></div>
    <div id="trang"></div>
</div>

</div>
</div>
<!--Đề xuất-->
<div class="offer">
    <div class="small-container">
        <div class="row">
            <div class="col-1">
                <img src="images/Xiaomi-x3.png" class="offer-img">
            </div>
            <div class="col-1">
                <p>Mặt hàng đang bán chạy</p>
                <h1>Xiaomi POCO X3 NFC</h1>
                <a href="" class="btn">Mua Ngay &#8594;</a>
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
        <p class="copyright">Copyright 2021</p>
    </div>
</div>
</body>
</html>