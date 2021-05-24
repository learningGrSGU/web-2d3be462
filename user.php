<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Phone Shop</title>
    <link rel="stylesheet" type="text/css" href="css/main-web.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous"/>
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
            showCTSP();
            user();
            Home();
            menu.apply(<?php echo menu()?>);
            showPageSP(<?php echo sanPham(10);?>,<?php echo getPA()?>,<?php echo numPage(10);?>);
            Cart();
            LsGd(<?php echo lsgd(5);?>,<?php echo getPA()?>,<?php echo numPagelsgd(5);?>);
            vanceOption('#vance', 'Search(1);');
            spmoi(1);
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
                    <li>
                        <div style="border:1px black solid;border-radius: 5rem;">
                            <input id="dataSearch" onkeyup="Search(1)" class="search-txt" type="text" name="search-bar"
                                   placeholder="Tìm Kiếm gì đó...">
                            <a style="margin-right: 5px;" href="#">
                                <i class="fas fa-search"></i>
                            </a>
                            <!--
                            Chỗ này để chứa kết quả search này :)))))

                            <div id='vance' style='display:none;clear:left;'></div><div id="spSearch"></div><div id="tr"></div>

                            -->
                        </div>
                    </li>
                    <li><a href="">Trang Chủ</a></li>
                    <li><a href="">Giới Thiệu</a></li>
                    <li><a href="">Liên Hệ</a></li>
                    <li id="name"><img src="image/user-solid.png" style="width: 15px;height: 15px;">
                        <ul id="user">
                            <li><a href="?LSGD=lsgd&pageActive=1">Lịch sử giao dịch</a></li>
                            <li onClick="logout();"><a href="#">Đăng Xuất</a></li>
                        </ul>
                    </li>
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

    <script>
        /*hover*/
        function user() {
            var user = document.createElement('span');
            user.id = 'ten';
            jq351.ajax({
                url: "php/xuly.php?action=getUName",
                success: function (result) {
                    user.innerHTML = result;
                }
            });
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
