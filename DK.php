<!DOCTYPE html>
<html lang="en">
<head>
    <title>Đăng Ký</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter">
    <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
        <div class="wrap-login100">
            <form name="register" class="login100-form validate-form" method="post" action="php/xuly.php?action=register">
					<span class="login100-form-logo">
						<img src="images/logo-shop.png" style="width: 100%;border-radius: 50%;">
					</span>

                <div class="wrap-input100 validate-input" data-validate="Enter Name">
                    <div class="Valid check1" style="color:#e5f510;"></div>
                    <input class="input100" type="text" name="ht" placeholder="Họ và Tên">
                    <span class="focus-input100" data-placeholder="&#xf207;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Enter Username">
                    <div class="Valid check1" style="color:#e5f510;"></div>
                    <input onKeyUp="checkUser();" class="input100" type="text" name="user" placeholder="Tên Đăng Nhập">
                    <span class="focus-input100" data-placeholder="&#xf207;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Enter Password">
                    <div class="Valid check1" style="color:#e5f510;"></div>
                    <input class="input100" type="password" name="pass" placeholder="Mật Khẩu">
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Repeat  Password">
                    <div class="Valid check1" style="color:#e5f510;"></div>
                    <input class="input100" type="password" name="repass" placeholder="Nhập Lại Mật Khẩu">
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Enter Email">
                    <div class="Valid check1" style="color:#e5f510;"></div>
                    <input class="input100" type="text" name="email" placeholder="Email">
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Enter PhoneNumber">
                    <div class="Valid check1" style="color:#e5f510;" style="color:#e5f510;"></div>
                    <input class="input100" type="text" name="sdt" placeholder="Số Điện Thoại">
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Enter Address">
                    <div class="Valid check1" style="color:#e5f510;"></div>
                    <input class="input100" type="text" name="address" placeholder="Địa Chỉ">
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>

                <div class="container-login100-form-btn">
                    <button type="submit" onClick="return checkValid();" class="login100-form-btn" style="margin: 5px;">
                        Đăng ký
                    </button>
                </div>
                <div class="text-center p-t-90">
                    <a class="txt1" href="DN.php">
                        Đã Có Tài Khoản? Đăng Nhập Tại Đây
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>
<script type="module" src="javascript/script.js"></script>
<script src="javascript/jquery-3.5.1.js"></script>
<script src="javascript/moment-with-locales.js"></script>
<script>
    let jq351 = $.noConflict(true);
</script>

</body>
</html>