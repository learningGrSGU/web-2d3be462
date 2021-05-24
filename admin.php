<!doctype html>
<html>
<head>
    <title>Phone Shop(Admin)</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/Js.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/main-web.css">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" type="text/css"
          href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/Js.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <script src="external/jquery/jquery.js"></script>
    <script src="javascript/jquery-ui.min.js"></script>
    <script src='javascript/objectexporter.min.js'></script>
    <script type="module" src="javascript/script.js"></script>
    <script src="javascript/jquery-3.5.1.js"></script>
    <script src="javascript/canvasjs-stock-1.2.16/canvasjs.stock.min.js"></script>
    <script src="javascript/moment-with-locales.js"></script>
    <script>
        let jq351 = $.noConflict(true);
        window.addEventListener('load', function () {
            user();
            onLoad();
            isLogin(<?php include 'php/xuly.php'; isLogin(); ?>)
            Homead();
            xlDh(<?php echo numPageDH(6)?>);
            tkDH();
            product();
            vanceOption('#vance', 'Search(1);');
            vanceOption('#DHvance', 'onchangeTkDH(1);');
            vanceOption('#DHVance', 'xlDhVance(1);');
            vanceOption('#PDvance', 'productList(1);');
            qltk(1);
            ncc();
            permission(1);
            phieunhap(1);
        });
    </script>
</head>
<body>
<div class="header">
    <div style="padding: 30px;">
        <div style="font-size:24px;color:black;width:50%;float:left;text-align: end;">
            Xin Chào Nhân Viên:
        </div>
        <div style="width:50%;float:right;text-align: start;">
            <a href="" onClick="logout();" id="ad">
                <span onMouseOver="admover();" onMouseOut="admout();" id="admin"
                      style="color:black;font-size:24px;margin-left: 2%;"></span>
            </a>
        </div>
    </div>


    <script>
        function user() {
            jq351.ajax({
                url: "php/xuly.php?action=getUName",
                success: function (result) {
                    $('#admin').html(result);
                }
            });
        }

        /*hover*/
        function admover() {
            document.getElementById("ad").style = 'color:white;font-size:24px;';
            document.getElementById("admin").innerHTML = 'Đăng xuất';
        }

        function admout() {
            document.getElementById("ad").style = 'color:white;font-size:24px;';
            user();
            jq351('#ld').hide();
        }

        /*search*/
        function openSearch() {
            document.getElementById("search").style.display = "block";
            document.getElementById("mac").style.zIndex = "-1";
            document.getElementById("shop").style.zIndex = "-1";
        }

        function closeSearch() {
            document.getElementById("search").style.display = "none";
            document.getElementById("mac").style.zIndex = "10";
            document.getElementById("shop").style.zIndex = "10";
        }

        /*topmenu*/
        /*Dn,DK*/
        var modal = document.getElementById('id01');
        var modal1 = document.getElementById('id02');
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }

        }
    </script>
</div>
<div style="padding: 20px; background-color:black; ">
    <ul style="overflow: hidden;margin:0 7%;">
        <li class="admin-menu"><a href="?ncc">Nhập Hàng</a></li>
        <li class="admin-menu"><a href="?qltk">Quản Lý Tài Khoản</a></li>
        <li class="admin-menu"><a href="?dssp">Quản Lý Sản Phẩm</a></li>
        <li class="admin-menu"><a href="?tksp">Thống Kê Đơn Hàng</a></li>
        <li class="admin-menu"><a href="?DH=xldh">Xác Nhận Đơn Hàng</a></li>
        <li class="admin-menu"><a href="?quyen">Quản Lý Quyền</a></li>
        <li class="admin-menu"><a href="?phieunhap">Xem phiếu nhập</a></li>
    </ul>
</div>
<div id="id02" class="modal ">
    <form style="width:65%;height:75%;" class="modal-content animate modaldk" method="post"
          action="php/xuly.php?action=register&admin=1"
          name="register">
        <div class="container" style="padding:0 20px 0 20px;line-height:0.3;">
            <h1 style="color:red;">Vui lòng nhập đầy đủ thông tin để thêm tài khoản!!!!</h1>
            <hr>
            <div style="width:100%;">
                <label for="ht"><b>Họ và Tên</b></label>
                <div class="Valid check1"></div>
                <input style="width:100%;" type="text" placeholder="Nhập họ tên" name="ht">
            </div>


            <div style="width:100%;">
                <label for="username"><b>Tên đăng nhập</b></label>
                <div class="Valid check1"></div>
                <input style="width:100%;" onKeyUp="checkUser();" type="text" placeholder="Nhập Username" name="user">
            </div>

            <div style="width:100%;">
                <label for="psw"><b>Mật khẩu</b></label>
                <div class="Valid check1"></div>
                <input style="width:100%;" type="password" placeholder="Nhập Password" name="pass">
            </div>

            <div style="width:100%;">
                <label for="psw-repeat"><b>Nhập lại mật khẩu</b></label>
                <div class="Valid check1"></div>
                <input style="width:100%;" type="password" placeholder="Nhập lại Password" name="repass">
            </div>

            <div style="width:100%;">
                <label for="email"><b>Email</b></label>
                <div class="Valid check1"></div>
                <input style="width:100%;" type="text" placeholder="Nhập Email" name="email">
            </div>

            <div style="width:100%;">
                <label for="sdt"><b>Số điện thoại</b></label>
                <div class="Valid check1"></div>
                <input style="width:100%;" type="text" placeholder="Nhập số điện thoại" name="sdt">
            </div>

            <div style="width:100%;">
                <label for="address"><b>Địa chỉ</b></label>
                <div class="Valid check1"></div>
                <input style="width:100%;" type="text" placeholder="Nhập địa chỉ" name="address">
            </div>
        </div>
        <div class="container" style="text-align:center;padding:10px 20px;">
            <button type="button" onClick="document.getElementById('id02').style.display='none'" class="btn">Hủy
            </button>
            <button class="btn" type="submit" class="signupbtn" onClick="return checkValid();">Thêm tài khoản
            </button>
        </div>
    </form>
</div>
<script>
    var modal1 = document.getElementById('id02');
    window.addEventListener('click', function (event) {
        if (event.target == modal1) {
            modal1.style.display = "none";
        }
    });
</script>
<div class="main-content" id="mac">
    <div id="menu">
        <div id="opt"></div>
        <div id="sp"></div>
        <div id="trang"></div>
    </div>
</div>
</div>
</body>
</html>