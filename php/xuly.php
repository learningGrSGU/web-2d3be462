<?php
if (!headers_sent()) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "saveURL":
            saveURL();
            break;
        case "getPN":
            getPN();
            break;
        case "grantPermission":
            grantPermission();
            break;
        case "getPermission":
            getPermission();
            break;
        case "addPermission":
            addPermission();
            break;
        case "delPermission":
            delPermission();
            break;
        case "updatePermission":
            updatePermission();
            break;
        case "qlquyen":
            qlquyen();
            break;
        case "getMaSP":
            getMaSP();
            break;
        case "getSP":
            getSP();
            break;
        case "updateSLSP":
            updateSLSP();
            break;
        case "updateNCC":
            updateNCC();
            break;
        case "addNCC":
            addNCC();
            break;
        case "delNCC":
            delNCC();
            break;
        case "ncc":
            ncc();
            break;
        case "checkPermission":
            checkPermission();
            break;
        case "getUName":
            getUName();
            break;
        case "sendBL":
            sendBL();
            break;
        case "getBL":
            Bl_KH();
            break;
        case "getDetail":
            productDetail();
            break;
        case "home":
            home();
            break;
        case "maymoi":
            spmoi();
            break;
        case "del":
            del();
            break;
        case "unlock_lock":
            unlock_lock();
            break;
        case "qltk":
            qltk();
            break;
        case "searchVance":
            searchVance();
            break;
        case "getTL":
            menu();
            break;
        case "uploadImg":
            uploadImg();
            break;
        case "updateSP":
            updateSP();
            break;
        case "checkSP":
            checkSP();
            break;
        case "delSp":
            delSp();
            break;
        case "productList":
            productList();
            break;
        case "TKDH":
            TKDH();
            break;
        case "xulyDHVance":
            xulyDHVance();
            break;
        case "xnDH":
            xnDH();
            break;
        case "xoaDH":
            xoaDH();
            break;
        case "search":
            searchSP();
            break;
        case "donhang":
            donhang();
            break;
        case "register":
            xulyDK();
            break;
        case "login":
            xuLyDN();
            break;
        case "checkUser":
            checkUser();
            break;
        case "isLogin":
            isLogin();
            break;
        case "logout":
            logout();
            break;
        case "encrypt":
            encrypt();
            break;
        case "test":
            test();
            break;
        default:
            break;
    }
}
function test()
{
    echo $_POST['rating'];
}

function encrypt()
{
    $str = "123456";
    echo password_hash($str, PASSWORD_BCRYPT, array('cost' => 10));
}

function uploadImg()
{
    if (isset($_FILES['fileToUpload']) && isset($_GET['do'])) {
        $dir = "../image/" . $_GET['folder'] . "/";
        $target_file = $dir . basename($_FILES['fileToUpload']['name']);
        $extension = pathinfo($target_file, PATHINFO_EXTENSION);
        if (getimagesize($_FILES["fileToUpload"]["tmp_name"]) !== false) {
            if ($_FILES["fileToUpload"]["size"] > 500000) echo 0;
            else {
                if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
                    $upload_file = ltrim($target_file, "./");
                    if (isset($_GET['masp'])) $masp = $_GET['masp'];
                    include_once 'DBConnect.php';
                    if ($_GET['do'] == 'update') $sql = "update `chitietsp` set `HinhAnh`='$upload_file' where `maSP`='$masp'";
                    $update = DBconnect::getInstance()->execUpdate($sql);
                    if ($update === true) echo 1;
                    else echo $update;
                } else echo -2;
            }
        } else echo -1;
    } else echo -3;
}

function saveURL()
{
    if (isset($_POST['URL'])) {
        $_SESSION['URL'] = $_POST['URL'];
    }
}

function errorLogin()
{
    if (isset($_GET['error']) && $_GET['error'] == true) echo 0;
    else if (isset($_GET['errorLock']) && $_GET['errorLock'] == true) echo -1;
    else echo 1;
}

function userError()
{
    if (isset($_GET['user'])) echo $_GET['user'];
}

function checkPermission()
{
    if (isset($_POST['permission'])) {
        include_once 'DBConnect.php';
        $permission = DBconnect::getInstance()->execSQL('select ChiTiet from phanquyen where RoleID = "' . $_SESSION['role'] . '"');
        if ($permission[0][0] == 'Có đầy đủ tất cả các quyền') echo 1;
        else {
            $permissions = explode(', ', $permission[0][0]);
            foreach ($permissions as $each) {
                if ($each == $_POST['permission']) {
                    echo 1;
                    return;
                }
            }
            echo 0;
        }
    }
}

?>
<?php
function replace_regex($string)
{
    return preg_replace('/\'/', '\'\'', $string);
}

function removeMWSpace($String)
{
    return preg_replace('/\s{2,}/', ' ', trim($String));
}

function getUName()
{
    if (isset($_SESSION['name'])) echo $_SESSION['name'];
}

function sendBL()
{
    if (isset($_POST['cmt'])) {
        if (isset($_SESSION['id'])) {
            include_once 'DBConnect.php';
            $maKH = DBconnect::getInstance()->execSQL("select maKH from khachhang where maUser='" . $_SESSION['id'] . "'")[0][0];
            $sql = "insert into binhluan(maKH, maSP, ND, ThoiGianBL) values('$maKH', '" . json_decode($_POST['masp']) . "', '" . json_decode($_POST['cmt']) . "', '" . $_POST['datetime'] . "')";
            $sp = DBconnect::getInstance()->execUpdate($sql);
            echo 1;
        } else echo 0;
    }
}

function Bl_KH()
{
    if (isset($_POST['masp'])) {
        include_once 'DBConnect.php';
        $sql = "SELECT * FROM binhluan bl JOIN khachhang kh ON bl.maKH = kh.maKH where bl.maSP = " . $_POST['masp'];
        $sp = DBconnect::getInstance()->execSQL($sql);
        echo json_encode($sp);
    } else echo -1;
}

function home()
{
    include_once 'DBConnect.php';
    $sql = "SELECT * FROM `sanpham` sp JOIN `chitietsp` ctsp ON sp.`maSP`=ctsp.`maSP` limit 0,12";
    $sp = DBconnect::getInstance()->execSQL($sql);
    echo json_encode($sp);
}

function getPN()
{
    include_once 'DBConnect.php';
    $sqlNum = "SELECT COUNT(`maPN`) FROM `phieunhap`";
    $num = DBconnect::getInstance()->execSQL($sqlNum);
    $numPage = ceil($num[0][0] / 5);
    $limits = DBconnect::getInstance()->execSQL("select count(ctpn.`maPN`) count from `chitietpn` ctpn join `phieunhap` pn on pn.`maPN`=ctpn.`maPN` group by ctpn.`maPN` limit " . ($_GET['pActive'] - 1) * 5 . ",5");
    $limit = 0;
    if ($limits != 0) for ($i = 0; $i < count($limits); $i++) $limit += $limits[$i]['count'];
    $all = DBconnect::getInstance()->execSQL("select count(ctpn.`maPN`) from `chitietpn` ctpn join `phieunhap` pn on pn.`maPN`=ctpn.`maPN`");
    if ($all != 0) {
        $lasts = DBconnect::getInstance()->execSQL("select count(ctpn.`maPN`) count from `chitietpn` ctpn join `phieunhap` pn on pn.`maPN`=ctpn.`maPN` group by ctpn.`maPN` limit " . ($_GET['pActive'] - 1) * 5 . "," . $all[0][0]);
        $start = $all[0][0];
        if ($lasts != 0) for ($i = 0; $i < count($lasts); $i++) $start -= $lasts[$i]['count'];
        $sql = "select sp.`maSP`, pn.`maPN`,pn.`NgayNhap`,ncc.`tenNCC`,ncc.`DiaChi`,ncc.`SDT`,sp.`tenSp`,ctpn.`SL`,ctpn.`DonGia`, pn.Tong from `phieunhap` pn join `chitietpn` ctpn on pn.`maPN` = ctpn.`maPN` join nhacungcap ncc on ncc.`maNCC` = pn.`maNCC` join `sanpham` sp on sp.`maSP` = ctpn.`maSP` order by pn.`maPN` limit $start, $limit";
        if ($all[0][0] != 0) {
            $lsgd = DBconnect::getInstance()->execSQL($sql);
            $lsgd[count($lsgd)] = $numPage;
            echo json_encode($lsgd);
        } else echo 0;
    } else echo 0;
}

function grantPermission()
{
    if (isset($_POST['maUser'])) {
        include_once 'DBConnect.php';
        $sql = "update nguoidung set RoleID = '" . $_POST['role'] . "' where maUser = '" . $_POST['maUser'] . "'";
        $sp = DBconnect::getInstance()->execUpdate($sql);
        if ($sp === true) echo 1;
        else echo json_encode($sp);
    } else echo -1;
}

function getPermission()
{
    include_once 'DBConnect.php';
    $sql = "SELECT * FROM phanquyen where RoleID <> 0";
    $sp = DBconnect::getInstance()->execSQL($sql);
    echo json_encode($sp);
}

function delPermission()
{
    if (isset($_POST['id'])) {
        include_once 'DBConnect.php';
        $sql = "delete from phanquyen where `RoleID`='" . $_POST['id'] . "';";
        $update = DBconnect::getInstance()->execUpdate($sql);
        if ($update == 1) echo 1;
        else echo $update;
    } else echo -1;
}

function addPermission()
{
    if (isset($_POST['permissions'])) {
        include_once 'DBConnect.php';
        $sql = "insert into phanquyen(tenQuyen, ChiTiet) values ('" . replace_regex($_POST['name']) . "', '" . $_POST['permissions'] . "')";
        $update = DBconnect::getInstance()->execUpdate($sql);
        if ($update == 1) echo 1;
        else echo $update;
    } else echo -1;
}

function updatePermission()
{
    if (isset($_POST['permissions'])) {
        include_once 'DBConnect.php';
        $sql = "update phanquyen set ChiTiet='" . $_POST['permissions'] . "' where `RoleID`='" . $_POST['id'] . "';";
        $update = DBconnect::getInstance()->execUpdate($sql);
        if ($update == 1) echo 1;
        else echo $update;
    } else echo -1;
}

function qlquyen()
{
    include_once 'DBConnect.php';
    $sql = "SELECT * from phanquyen where RoleID <> 0 limit " . ($_GET['pActive'] - 1) * 10 . ", 10";
    $permission = DBconnect::getInstance()->execSQL($sql);
    if ($permission) {
        $numpage = ceil(DBconnect::getInstance()->execSQL('select count(RoleID) from phanquyen where RoleID <> 0')[0][0] / 10);
        $permission[count($permission)] = $numpage;
        echo json_encode($permission);
    } else echo 0;
}

function phieunhap($data)
{
    include_once 'DBConnect.php';
    $maPN = DBconnect::getInstance()->execSQL('select count(maPN) from phieunhap')[0][0] + 1;
    $maNV = DBconnect::getInstance()->execSQL('select maNV from nhanvien where maUser = "' . $_SESSION['id'] . '"')[0][0];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date('Y-m-d');
    $tong = $data[1] * $data[3];
    $sql = "insert into phieunhap values ('$maPN', '$data[4]', '$maNV', '$date', '$tong');";
    $sql .= "insert into chitietpn values ('$maPN', '$data[0]', '$data[3]', '$data[1]');";
    $insert = DBconnect::getInstance()->execMultiQuery($sql);
    if ($insert == 1) {
        DBconnect::getInstance()->nextResult();
        return true;
    } else {
        echo $insert;
        return false;
    }
}

function getMaSP()
{
    include_once 'DBConnect.php';
    $sql = "select Max(cast(maSP as unsigned)) from sanpham";
    $sp = DBconnect::getInstance()->execSQL($sql)[0][0];
    echo $sp + 1;
}

function getSP()
{
    include_once 'DBConnect.php';
    $sql = "select maSP, tenSp, GiaCa, SL from sanpham";
    $sp = DBconnect::getInstance()->execSQL($sql);
    echo json_encode($sp);
}

function updateSLSP()
{
    if (isset($_POST['data'])) {
        include_once 'DBConnect.php';
        $data = json_decode($_POST['data'], true);
        $sl = ($data[2] + $data[3]);
        $sql = "update sanpham set SL = '$sl' where maSP = '$data[0]'";
        if (phieunhap($data) == true) {
            $update = DBconnect::getInstance()->execUpdate($sql);
            if ($update == 1) echo 1;
            else echo $update;
        }
    } else echo -1;
}

function updateNCC()
{
    if (isset($_POST['ncc'])) {
        include_once 'DBConnect.php';
        $ncc = json_decode($_POST['ncc'], true);
        $sql = "update nhacungcap set tenNCC ='$ncc[1]', DiaChi = '$ncc[2]', SDT = '$ncc[3]', Email = '$ncc[4]' where maNCC = '$ncc[0]'";
        $insert = DBconnect::getInstance()->execUpdate($sql);
        if ($insert == 1) echo 1;
        else echo $insert;
    } else echo -1;
}

function addNCC()
{
    if (isset($_POST['ncc'])) {
        include_once 'DBConnect.php';
        $ncc = json_decode($_POST['ncc'], true);
        $sql = "insert into nhacungcap(tenNCC, DiaChi, SDT, Email) values ('$ncc[0]', '$ncc[1]', '$ncc[2]', '$ncc[3]')";
        $insert = DBconnect::getInstance()->execUpdate($sql);
        if ($insert == 1) echo 1;
        else echo $insert;
    } else echo -1;
}

function delNCC()
{
    if (isset($_POST['id'])) {
        include_once 'DBConnect.php';
        $sql = "delete from nhacungcap where `maNCC`='" . $_POST['id'] . "';";
        $update = DBconnect::getInstance()->execUpdate($sql);
        if ($update == 1) echo 1;
        else echo $update;
    } else echo -1;
}

function ncc()
{
    include_once 'DBConnect.php';
    $sql = "SELECT * FROM nhacungcap ";
    if (isset($_GET['dataSearch'])) $sql .= "where maNCC like '%" . $_GET['dataSearch'] . "%' or tenNCC like '%" . $_GET['dataSearch'] . "%'";
    $sql .= "limit " . ($_GET['pActive'] - 1) * 10 . ", 10";
    $sqlPages = "SELECT count(maNCC) FROM nhacungcap ";
    if (isset($_GET['dataSearch'])) $sqlPages .= "where maNCC like '%" . $_GET['dataSearch'] . "%' or tenNCC like '%" . $_GET['dataSearch'] . "%'";
    $ncc = DBconnect::getInstance()->execSQL($sql);
    if ($ncc) {
        $numpage = ceil(DBconnect::getInstance()->execSQL($sqlPages)[0][0] / 10);
        $ncc[count($ncc)] = $numpage;
        echo json_encode($ncc);
    } else echo 0;
}

function del()
{
    if (isset($_POST['user'])) {
        include_once 'DBConnect.php';
        $sql = "update khachhang set maUser = null where maUser = '" . $_POST['user'] . "';";
        $sql .= "delete from nguoidung where `maUser`='" . replace_regex($_POST['user']) . "';";
        $update = DBconnect::getInstance()->execMultiQuery($sql);
        if ($update == 1) echo 1;
        else echo $update;
    } else echo -1;
}

function unlock_lock()
{
    if (isset($_POST['user']) && isset($_POST['do'])) {
        include_once 'DBConnect.php';
        if ($_POST['do'] == 1) $sql1 = "update nguoidung set `lock/unlock`=1 where `TK`='" . replace_regex($_POST['user']) . "' and `TK`<>'admin'";
        else $sql2 = "update nguoidung set `lock/unlock`=0 where `TK`='" . replace_regex($_POST['user']) . "' and `TK`<>'admin'";
        if (isset($sql1)) $update1 = DBconnect::getInstance()->execUpdate($sql1);
        if (isset($sql2)) $update2 = DBconnect::getInstance()->execUpdate($sql2);
        if (isset($update1)) {
            if ($update1 === true) echo 1;
            else echo $update1;
        }
        if (isset($update2)) {
            if ($update2 === true) echo 0;
            else echo $update2;
        }
    } else echo -1;
}

function qltk()
{
    include_once 'DBConnect.php';
    $sql = "SELECT nd.maUser, nd.RoleID, nd.TenUser, nd.TK, nd.`lock/unlock`, kh.maKH, kh.Hovaten, kh.Diachi, kh.Sdt, kh.Email, kh.CMND FROM nguoidung nd, khachhang kh where nd.maUser = kh.maUser limit " . ($_GET['pActive'] - 1) * 5 . ", 5";
    $sql1 = "SELECT nd.maUser, nd.RoleID, nd.TenUser, nd.TK, nd.`lock/unlock`, nv.maNV, nv.TenNV as Hovaten, nv.Diachi, nv.SDT as Sdt, nv.Email, nv.CMND FROM nguoidung nd, nhanvien nv where nd.maUser = nv.maUser limit " . ($_GET['pActive'] - 1) * 5 . ", 5";
    $user = DBconnect::getInstance()->execSQL($sql);
    $nv = DBconnect::getInstance()->execSQL($sql1);
    if ($user) {
        $result = array_merge($user, $nv);
        $numpage = ceil(DBconnect::getInstance()->execSQL('select count(maUser) from nguoidung where maUser <> 0')[0][0] / 10);
        $result[count($result)] = $numpage;
        echo json_encode($result);
    } else echo 0;
}

function spmoi()
{
    if (isset($_POST['sDate']) && isset($_POST['eDate'])) {
        $sDate = $_POST['sDate'];
        $eDate = $_POST['eDate'];
        include_once 'DBConnect.php';
        $sql = "SELECT * FROM `sanpham` sp JOIN `chitietsp` ctsp ON sp.`maSP`=ctsp.`maSP` where ctsp.`Ngày nhập hàng` between '$sDate' and '$eDate 23:59:59.9999'";
        $sp = DBconnect::getInstance()->execSQL($sql);
        if ($sp) echo json_encode($sp);
        else echo $sp;
    } else echo -1;
}

function searchVance()
{
    if (isset($_POST['dataSearch']) && isset($_POST['each']) && isset($_POST['pActive'])) {
        include_once 'DBConnect.php';
        $toSearch = removeMWSpace($_POST['dataSearch']);
        $each = $_POST['each'];
        $sql = "SELECT * FROM `sanpham` sp JOIN `chitietsp` ctsp ON sp.`maSP`=ctsp.`maSP` JOIN `danhmuc` th ON th.`maDM`=ctsp.`maDM` WHERE (sp.`maSP` = '$toSearch' or sp.`tenSp` like '%$toSearch%')";
        if (isset($_GET['brandOption'])) $sql .= "and (th.`maDM`='" . $_GET['brandOption'] . "')";
        if (isset($_GET['startPrice']) && isset($_GET['endPrice'])) $sql .= "and (sp.`GiaCa` between " . $_GET['startPrice'] . " and " . $_GET['endPrice'] . ")";
        $num = DBconnect::getInstance()->execSQL($sql);
        if ($num != 0) {
            $numPage = ceil(count($num) / $each);
            $sql .= " limit " . ($_POST['pActive'] - 1) * $each . ",$each";
            $search = DBconnect::getInstance()->execSQL($sql);
            $search[count($search)] = $numPage;
            echo json_encode($search);
        } else echo 0;
    } else echo -1;
}

function updateSP()
{
    if (isset($_POST['sp']) && isset($_GET['do'])) {
        $sp = json_decode($_POST['sp'], true);
        include_once 'DBConnect.php';
        if ($_GET['do'] == 'update') {
            $sql = "update `sanpham` set `tenSp`='" . replace_regex($sp[1]) . "', `MoTa`='" . replace_regex($sp[5]) . " - " . replace_regex($sp[6]) . "', `SL`=" . $sp[13] . " where `maSP`='" . $sp[0] . "';";
            $sql .= "update `chitietsp` set `maDM`='" . replace_regex($sp[14]) . "', `Size`='" . replace_regex($sp[2]) . "', `Weight`='" . replace_regex($sp[3]) . "', `Color`='" . replace_regex($sp[4]) . "', `BoNhoTrong`='" . replace_regex($sp[5]) . "', `BoNho`='" . replace_regex($sp[6]) . "', `HDH`='" . replace_regex($sp[7]) . "', `CamTruoc`='" . replace_regex($sp[8]) . "', `CamSau`='" . replace_regex($sp[9]) . "', `Pin`='" . replace_regex($sp[10]) . "', `BaoHanh`='" . replace_regex($sp[11]) . "', `TinhTrang`='" . replace_regex($sp[12]) . "' where `maSP`='" . $sp[0] . "';";
        }
        if ($_GET['do'] == 'insert') {
            $sql = "insert into `sanpham` values ('" . $sp[0] . "','" . replace_regex($sp[1]) . "','" . replace_regex($sp[5]) . " - " . replace_regex($sp[6]) . "'," . $sp[13] . "," . $sp[14] . ");";
            $sql .= "insert into `chitietsp`(`maSP`,`maDM`,`Size`,`Weight`,`Color`,`BoNhoTrong`,`BoNho`,`HDH`,`CamTruoc`,`CamSau`,`Pin`,`BaoHanh`,`TinhTrang`,`Ngày nhập hàng`) values ('" . $sp[0] . "','" . replace_regex($sp[16]) . "','" . replace_regex($sp[2]) . "','" . replace_regex($sp[3]) . "','" . replace_regex($sp[4]) . "','" . replace_regex($sp[5]) . "','" . replace_regex($sp[6]) . "','" . replace_regex($sp[7]) . "','" . replace_regex($sp[8]) . "','" . replace_regex($sp[9]) . "','" . replace_regex($sp[10]) . "','" . replace_regex($sp[11]) . "','" . replace_regex($sp[12]) . "','" . $sp[17] . "');";
        }
        $update = DBconnect::getInstance()->execMultiQuery($sql);
        if ($update == 1) {
            DBconnect::getInstance()->nextResult();
            if ($_GET['do'] == 'insert') {
                $data = [];
                $data[0] = $sp[0];
                $data[1] = $sp[13];
                $data[2] = 0;
                $data[3] = $sp[14];
                $data[4] = $sp[15];
                phieunhap($data);
            }
            echo 1;
        }
    } else echo -1;
}

function checkSP()
{
    if (isset($_POST['tensp'])) {
        include_once 'DBConnect.php';
        $tensp = $_POST['tensp'];
        $sql = "select count(`tenSp`) from `sanpham` where `tenSp`='" . replace_regex($tensp) . "'";
        $check = DBconnect::getInstance()->execSQL($sql);
        if ($check != 0 && $check[0][0] == 0) echo 0;
        else echo 1;
    } else echo -1;
}

function delSp()
{
    if (isset($_POST['masp'])) {
        include_once 'DBConnect.php';
        $masp = $_POST['masp'];
        $sql = "DELETE FROM `chitietsp` where `maSP`='$masp';";
        $sql .= "DELETE FROM `sanpham` where `maSP`='$masp';";
        $del = DBconnect::getInstance()->execMultiQuery($sql);
        if ($del === true) echo 1;
        else echo $del;
    } else echo -1;
}

function productList()
{
    if (isset($_POST['pageActive']) && isset($_POST['each']) && isset($_POST['sDate']) && isset($_POST['eDate'])) {
        include_once 'DBConnect.php';
        $sDate = $_POST['sDate'];
        $eDate = $_POST['eDate'];
        $sqlNum = "SELECT COUNT(sp.`maSP`) as SL FROM `sanpham` sp JOIN `chitietsp` ctsp ON sp.`maSP`=ctsp.`maSP` where (ctsp.`Ngày nhập hàng` between '$sDate' and '$eDate 23:59:59.9999') ";
        if (isset($_GET['dataSearch'])) $sqlNum .= "and (ctsp.`maSP` like '%" . removeMWSpace($_GET['dataSearch']) . "%' or sp.`tenSp` like '%" . removeMWSpace($_GET['dataSearch']) . "%')";
        if (isset($_GET['brandOption'])) $sqlNum .= "and (ctsp.`maDM`='" . $_GET['brandOption'] . "')";
        if (isset($_GET['startPrice']) && isset($_GET['endPrice'])) $sqlNum .= "and (sp.`GiaCa` between " . $_GET['startPrice'] . " and " . $_GET['endPrice'] . ")";
        $num = DBconnect::getInstance()->execSQL($sqlNum);
        if ($num != 0 || $num[0][0] != 0) {
            $each = $_POST['each'];
            $numPage = ceil($num[0][0] / $each);
            $sqlSP = "SELECT * FROM `sanpham` sp JOIN `chitietsp` ctsp ON sp.`maSP`=ctsp.`maSP` JOIN `danhmuc` ON `danhmuc`.`maDM`=ctsp.`maDM` where (ctsp.`Ngày nhập hàng` between '$sDate' and '$eDate 23:59:59.9999') ";
            if (isset($_GET['dataSearch'])) $sqlSP .= "and (ctsp.`maSP` like '%" . removeMWSpace($_GET['dataSearch']) . "%' or sp.`tenSp` like '%" . removeMWSpace($_GET['dataSearch']) . "%')";
            if (isset($_GET['brandOption'])) $sqlSP .= "and (ctsp.`maDM`='" . $_GET['brandOption'] . "')";
            if (isset($_GET['startPrice']) && isset($_GET['endPrice'])) $sqlSP .= "and (sp.`GiaCa` between " . $_GET['startPrice'] . " and " . $_GET['endPrice'] . ")";
            $sqlSP .= "limit " . ($_POST['pageActive'] - 1) * $each . ",$each";
            $sanPham = DBconnect::getInstance()->execSQL($sqlSP);
            if ($sanPham != 0) {
                $sanPham[count($sanPham)] = $numPage;
                echo json_encode($sanPham);
            } else echo 0;
        } else echo 0;
    } else echo -1;
}

function TKDH()
{
    if (isset($_POST['sDate']) && isset($_POST['eDate'])) {
        include_once 'DBConnect.php';
        $sDate = $_POST['sDate'];
        $eDate = $_POST['eDate'];
        $sql = "SELECT DISTINCT dh.TongTien as sale, dh.Ngaykhoitao as date, ctdh.Tinhtrang  FROM `donhang` dh join `chitietdonhang` ctdh on dh.`maDH` = ctdh.`maDH` where (dh.`Ngaykhoitao` between '$sDate' and '$eDate 23:59:59.9999')";
        echo json_encode(DBconnect::getInstance()->execSQL($sql));
    }
}

/*
function TKDH()
{
    if (isset($_POST['pageActive']) && isset($_POST['each']) && isset($_POST['sDate']) && isset($_POST['eDate'])) {
        include_once 'DBConnect.php';
        $sDate = $_POST['sDate'];
        $eDate = $_POST['eDate'];
        $each = $_POST['each'];
        $sqlNum = "SELECT COUNT(dh.`maDH`) as SL FROM `donhang` dh join `chitietdonhang` ctdh on dh.`maDH` = ctdh.`maDH` where (dh.`Ngaykhoitao` between '$sDate' and '$eDate 23:59:59.9999')";
        $sqlPage = "SELECT COUNT(DISTINCT dh.`maDH`) as SL FROM `donhang` dh join `chitietdonhang` ctdh on dh.`maDH` = ctdh.`maDH` where (dh.`Ngaykhoitao` between '$sDate' and '$eDate 23:59:59.9999')";
        if (isset($_GET['brandOption'])) {
            $sqlPage .= " and (ctdh.`maDH` = any (select ctdh1.`maDH` from `chitietdonhang` ctdh1 join `chitietsp` ctsp on ctdh1.`maSP`=ctsp.`maSP` where ctsp.`maDM`='" . $_GET['brandOption'] . "'))";
            $sqlNum .= " and (ctdh.`maDH` = any (select ctdh1.`maDH` from `chitietdonhang` ctdh1 join `chitietsp` ctsp on ctdh1.`maSP`=ctsp.`maSP` where ctsp.`maDM`='" . $_GET['brandOption'] . "'))";
        }
        if (isset($_GET['startPrice']) && isset($_GET['endPrice'])) {
            $sqlPage .= " and (dh.`TongTien` between " . $_GET['startPrice'] . " and " . $_GET['endPrice'] . ")";
            $sqlNum .= " and (dh.`TongTien` between " . $_GET['startPrice'] . " and " . $_GET['endPrice'] . ")";
        }
        $num = DBconnect::getInstance()->execSQL($sqlNum);
        $page = DBconnect::getInstance()->execSQL($sqlPage);
        if ($num != 0 || $num[0][0] != 0) {
            $numPage = ceil($page[0][0] / $each);
            $sqlLimit = "SELECT COUNT(ctdh.`maDH`) as count FROM `donhang` dh join `chitietdonhang` ctdh on dh.`maDH` = ctdh.`maDH` where (dh.`Ngaykhoitao` between '$sDate' and '$eDate 23:59:59.9999')";
            $sqlLast = "SELECT COUNT(ctdh.`maDH`) as count FROM `donhang` dh join `chitietdonhang` ctdh on dh.`maDH` = ctdh.`maDH` where (dh.`Ngaykhoitao` between '$sDate' and '$eDate 23:59:59.9999')";
            if (isset($_GET['brandOption'])) {
                $sqlLimit .= " and (ctdh.`maDH` = any (select ctdh1.`maDH` from `chitietdonhang` ctdh1 join `chitietsp` ctsp on ctdh1.`maSP`=ctsp.`maSP` where ctsp.`maDM`='" . $_GET['brandOption'] . "'))";
                $sqlLast .= " and (ctdh.`maDH` = any (select ctdh1.`maDH` from `chitietdonhang` ctdh1 join `chitietsp` ctsp on ctdh1.`maSP`=ctsp.`maSP` where ctsp.`maDM`='" . $_GET['brandOption'] . "'))";
            }
            if (isset($_GET['startPrice']) && isset($_GET['endPrice'])) {
                $sqlLimit .= " and (dh.`TongTien` between " . $_GET['startPrice'] . " and " . $_GET['endPrice'] . ")";
                $sqlLast .= " and (dh.`TongTien` between " . $_GET['startPrice'] . " and " . $_GET['endPrice'] . ")";
            }
            $sqlLimit .= " group by ctdh.`maDH` limit " . ($_POST['pageActive'] - 1) * $each . ",$each";
            $limits = DBconnect::getInstance()->execSQL($sqlLimit);
            $limit = 0;
            if ($limits != 0) for ($i = 0; $i < count($limits); $i++) $limit += $limits[$i]['count'];
            $sqlLast .= " group by ctdh.`maDH` limit " . ($_POST['pageActive'] - 1) * $each . "," . $num[0][0];
            $lasts = DBconnect::getInstance()->execSQL($sqlLast);
            $start = $num[0][0];
            if ($lasts != 0) {
                for ($i = 0; $i < count($lasts); $i++) $start -= $lasts[$i]['count'];
                $sql = "select dh.`TongTien` as tongtien ,dh.`maDH`,dh.`Ngaykhoitao`,user.`Hovaten`,user.`Diachi`,user.`Sdt`,sp.`tenSp`,ctdh.`SL`,ctdh.`TongTien`,ctdh.`Tinhtrang` from `donhang` dh join `chitietdonhang` ctdh on dh.`maDH` = ctdh.`maDH` join user on user.`maUser` = dh.`maUser` join `sanpham` sp on sp.`maSP` = ctdh.`maSP` where (dh.`Ngaykhoitao` between '$sDate' and '$eDate 23:59:59.9999')";
                if (isset($_GET['brandOption'])) {
                    $sql .= " and (ctdh.`maDH` = any (select ctdh1.`maDH` from `chitietdonhang` ctdh1 join `chitietsp` ctsp on ctdh1.`maSP`=ctsp.`maSP` where ctsp.`maDM`='" . $_GET['brandOption'] . "'))";
                }
                if (isset($_GET['startPrice']) && isset($_GET['endPrice'])) {
                    $sql .= " and (dh.`TongTien` between " . $_GET['startPrice'] . " and " . $_GET['endPrice'] . ")";
                }
                $sql .= " order by dh.`maDH` limit $start,$limit";
                $DH = DBconnect::getInstance()->execSQL($sql);
                $DH[count($DH)] = $numPage;
                echo json_encode($DH);
            }
        } else echo 0;
    } else echo -1;
}
*/
function numPagelsgd($lsgd1Page)
{
    if (isset($_GET['LSGD']) && isset($_GET['pageActive']) && isset($_SESSION['id'])) {
        include_once 'DBConnect.php';
        $maUser = replace_regex($_SESSION['id']);
        $maKH = DBconnect::getInstance()->execSQL("select maKH from khachhang where maUser = '$maUser'");
        $sqlNum = "SELECT COUNT(`maDH`) FROM `donhang` where `maKH`='" . $maKH[0][0] . "'";
        $num = DBconnect::getInstance()->execSQL($sqlNum);
        $numPage = ceil($num[0][0] / $lsgd1Page);
        return $numPage;
    } else return -1;
}

function lsgd($lsgd1Page)
{
    if (isset($_GET['LSGD']) && isset($_GET['pageActive']) && isset($_SESSION['id'])) {
        include_once 'DBConnect.php';
        $maUser = replace_regex($_SESSION['id']);
        $maKH = DBconnect::getInstance()->execSQL("select maKH from khachhang where maUser = '$maUser'");
        $limits = DBconnect::getInstance()->execSQL("select count(ctdh.`maDH`) count from `chitietdonhang` ctdh join `donhang` dh on dh.`maDH`=ctdh.`maDH` where dh.`maKH`='" . $maKH[0][0] . "' group by ctdh.`maDH` limit " . ($_GET['pageActive'] - 1) * $lsgd1Page . ",$lsgd1Page");
        $limit = 0;
        if ($limits != 0) for ($i = 0; $i < count($limits); $i++) $limit += $limits[$i]['count'];
        $all = DBconnect::getInstance()->execSQL("select count(ctdh.`maDH`) from `chitietdonhang` ctdh join `donhang` dh on dh.`maDH`=ctdh.`maDH` where dh.`maKH`='" . $maKH[0][0] . "'");
        if ($all != 0) {
            $lasts = DBconnect::getInstance()->execSQL("select count(ctdh.`maDH`) count from `chitietdonhang` ctdh join `donhang` dh on dh.`maDH`=ctdh.`maDH` where dh.`maKH`='" . $maKH[0][0] . "' group by ctdh.`maDH` limit " . ($_GET['pageActive'] - 1) * $lsgd1Page . "," . $all[0][0]);
            $start = $all[0][0];
            if ($lasts != 0) for ($i = 0; $i < count($lasts); $i++) $start -= $lasts[$i]['count'];
            $sql = "select sp.`maSP`, dh.`maDH`,dh.`Ngaykhoitao`,user.`Hovaten`,user.`Diachi`,user.`Sdt`,sp.`tenSp`,ctdh.`SL`,ctdh.`TongTien`,ctdh.`Tinhtrang` from `donhang` dh join `chitietdonhang` ctdh on dh.`maDH` = ctdh.`maDH` join khachhang user on user.`maKH` = dh.`maKH` join `sanpham` sp on sp.`maSP` = ctdh.`maSP` where dh.`maKH`='" . $maKH[0][0] . "' order by dh.`maDH` limit $start,$limit";
            $lsgd = DBconnect::getInstance()->execSQL($sql);
            return json_encode($lsgd);
        }
        return 0;
    } else return -1;
}

function xnDH()
{
    if (isset($_POST['madh']) && isset($_POST['check'])) {
        $madh = json_decode($_POST['madh']);
        include_once 'DBConnect.php';
        if ($_POST['check'] == 1) {
            $sql = "update `chitietdonhang` set `Tinhtrang`='Đã xác nhận' where `maDH`='$madh'";
            $update = DBconnect::getInstance()->execUpdate($sql);
            if ($update === true) echo 1;
            else echo $update;
        } else {
            $sql = "update `chitietdonhang` set `Tinhtrang`='Đang chờ xử lý' where `maDH`='$madh'";
            $update = DBconnect::getInstance()->execUpdate($sql);
            if ($update === true) echo 0;
            else echo $update;
        }
    } else echo -1;
}

function xoaDH()
{
    if (isset($_POST['madh'])) {
        include_once 'DBConnect.php';
        $update;
        $madh = json_decode($_POST['madh']);
        $sqlSLDH = "select `SL`,`maSP` from `chitietdonhang` where `maDH`='$madh'";
        $SLDH = DBconnect::getInstance()->execSQL($sqlSLDH);
        for ($i = 0; $i < count($SLDH); $i++) {
            $masp = $SLDH[$i]['maSP'];
            $sqlSLSP = "select `SL` from `sanpham` where `maSP`='$masp'";
            $SLSP = DBconnect::getInstance()->execSQL($sqlSLSP);
            $soluong = $SLSP[0][0] + $SLDH[$i]['SL'];
            $sqlUpdate = "update `sanpham` set `SL`=$soluong where `maSP`='$masp'";
            DBconnect::getInstance()->execUpdate($sqlUpdate);
            $sql = "update `chitietdonhang` set `Tinhtrang`='Đã hủy' where `maDH`='$madh'";
            $update = Dbconnect::getInstance()->execUpdate($sql);
        }
        if ($update === true) echo 1;
        else echo $update;
    } else echo -1;
}

function xulyDHVance()
{
    if (isset($_POST['pageActive']) && isset($_POST['each']) && isset($_POST['sDate']) && isset($_POST['eDate'])) {
        include_once 'DBConnect.php';
        $sDate = $_POST['sDate'];
        $eDate = $_POST['eDate'];
        $each = $_POST['each'];
        $sqlNum = "SELECT COUNT(dh.`maDH`) as SL FROM `donhang` dh join `chitietdonhang` ctdh on dh.`maDH` = ctdh.`maDH` where (ctdh.`Tinhtrang` NOT IN('Đã hủy')) and (dh.`Ngaykhoitao` between '$sDate' and '$eDate 23:59:59.9999')";
        $sqlPage = "SELECT COUNT(DISTINCT dh.`maDH`) as SL FROM `donhang` dh join `chitietdonhang` ctdh on dh.`maDH` = ctdh.`maDH` where (ctdh.`Tinhtrang` NOT IN('Đã hủy')) and (dh.`Ngaykhoitao` between '$sDate' and '$eDate 23:59:59.9999')";
        if (isset($_GET['dataSearch'])) {
            $sqlNum .= ' and dh.maDH = \'' . $_GET['dataSearch'] . '\'';
            $sqlPage .= ' and dh.maDH = \'' . $_GET['dataSearch'] . '\'';
        }
        if (isset($_GET['brandOption'])) {
            $sqlPage .= " and (ctdh.`maDH` = any (select ctdh1.`maDH` from `chitietdonhang` ctdh1 join `chitietsp` ctsp on ctdh1.`maSP`=ctsp.`maSP` where ctsp.`maDM`='" . $_GET['brandOption'] . "'))";
            $sqlNum .= " and (ctdh.`maDH` = any (select ctdh1.`maDH` from `chitietdonhang` ctdh1 join `chitietsp` ctsp on ctdh1.`maSP`=ctsp.`maSP` where ctsp.`maDM`='" . $_GET['brandOption'] . "'))";
        }
        if (isset($_GET['startPrice']) && isset($_GET['endPrice'])) {
            $sqlPage .= " and (dh.`TongTien` between " . $_GET['startPrice'] . " and " . $_GET['endPrice'] . ")";
            $sqlNum .= " and (dh.`TongTien` between " . $_GET['startPrice'] . " and " . $_GET['endPrice'] . ")";
        }
        $num = DBconnect::getInstance()->execSQL($sqlNum);
        $page = DBconnect::getInstance()->execSQL($sqlPage);
        if ($num != 0) {
            if ($num[0][0] != 0) {
                $numPage = ceil($page[0][0] / $each);
                $sqlLimit = "SELECT COUNT(ctdh.`maDH`) as count FROM `donhang` dh join `chitietdonhang` ctdh on dh.`maDH` = ctdh.`maDH`  where (ctdh.`Tinhtrang` NOT IN('Đã hủy')) and (dh.`Ngaykhoitao` between '$sDate' and '$eDate 23:59:59.9999')";
                $sqlLast = "SELECT COUNT(ctdh.`maDH`) as count FROM `donhang` dh join `chitietdonhang` ctdh on dh.`maDH` = ctdh.`maDH`  where (ctdh.`Tinhtrang` NOT IN('Đã hủy')) and (dh.`Ngaykhoitao` between '$sDate' and '$eDate 23:59:59.9999')";
                if (isset($_GET['dataSearch'])) {
                    $sqlLimit .= ' and dh.maDH = \'' . $_GET['dataSearch'] . '\'';
                    $sqlLast .= ' and dh.maDH = \'' . $_GET['dataSearch'] . '\'';
                }
                if (isset($_GET['brandOption'])) {
                    $sqlLimit .= " and (ctdh.`maDH` = any (select ctdh1.`maDH` from `chitietdonhang` ctdh1 join `chitietsp` ctsp on ctdh1.`maSP`=ctsp.`maSP` where ctsp.`maDM`='" . $_GET['brandOption'] . "'))";
                    $sqlLast .= " and (ctdh.`maDH` = any (select ctdh1.`maDH` from `chitietdonhang` ctdh1 join `chitietsp` ctsp on ctdh1.`maSP`=ctsp.`maSP` where ctsp.`maDM`='" . $_GET['brandOption'] . "'))";
                }
                if (isset($_GET['startPrice']) && isset($_GET['endPrice'])) {
                    $sqlLimit .= " and (dh.`TongTien` between " . $_GET['startPrice'] . " and " . $_GET['endPrice'] . ")";
                    $sqlLast .= " and (dh.`TongTien` between " . $_GET['startPrice'] . " and " . $_GET['endPrice'] . ")";
                }
                $sqlLast .= " group by ctdh.`maDH` limit " . ($_POST['pageActive'] - 1) * $each . "," . $num[0][0];
                $sqlLimit .= " group by ctdh.`maDH` limit " . ($_POST['pageActive'] - 1) * $each . ",$each";
                $limits = DBconnect::getInstance()->execSQL($sqlLimit);
                $limit = 0;
                if ($limits != 0) for ($i = 0; $i < count($limits); $i++) $limit += $limits[$i]['count'];
                $lasts = DBconnect::getInstance()->execSQL($sqlLast);
                $start = $num[0][0];
                if ($lasts != 0) {
                    for ($i = 0; $i < count($lasts); $i++) $start -= $lasts[$i]['count'];
                    $sql = "select dh.`TongTien` as tongtien ,dh.`maDH`,dh.`Ngaykhoitao`,user.`Hovaten`,user.`Diachi`,user.`Sdt`,sp.`tenSp`,ctdh.`SL`,ctdh.`TongTien`,ctdh.`Tinhtrang` from `donhang` dh join `chitietdonhang` ctdh on dh.`maDH` = ctdh.`maDH` join khachhang user on user.`maKH` = dh.`maKH` join `sanpham` sp on sp.`maSP` = ctdh.`maSP` where (ctdh.`Tinhtrang` NOT IN('Đã hủy')) and (dh.`Ngaykhoitao` between '$sDate' and '$eDate 23:59:59.9999')";
                    if (isset($_GET['dataSearch'])) {
                        $sql .= ' and dh.maDH = \'' . $_GET['dataSearch'] . '\'';
                    }
                    if (isset($_GET['brandOption'])) {
                        $sql .= " and (ctdh.`maDH` = any (select ctdh1.`maDH` from `chitietdonhang` ctdh1 join `chitietsp` ctsp on ctdh1.`maSP`=ctsp.`maSP` where ctsp.`maDM`='" . $_GET['brandOption'] . "'))";
                    }
                    if (isset($_GET['startPrice']) && isset($_GET['endPrice'])) {
                        $sql .= " and (dh.`TongTien` between " . $_GET['startPrice'] . " and " . $_GET['endPrice'] . ")";
                    }
                    $sql .= " order by dh.`maDH` limit $start,$limit";
                    $DH = DBconnect::getInstance()->execSQL($sql);
                    $DH[count($DH)] = $numPage;
                    echo json_encode($DH);
                }
            } else echo 0;
        }
    } else echo -1;
}

function numPageDH($DH1Page)
{
    if (isset($_GET['DH'])) {
        include_once 'DBConnect.php';
        $sqlNum = "SELECT COUNT(dh.`maDH`) as SL FROM `donhang` dh join `chitietdonhang` ctdh on dh.`maDH` = ctdh.`maDH` where ctdh.`Tinhtrang` NOT IN('Đã hủy')";
        $num = DBconnect::getInstance()->execSQL($sqlNum);
        $numPage = ceil($num[0][0] / $DH1Page);
        return $numPage;
    } else return -1;
}

function donhang()
{
    if (isset($_POST['DH']) && isset($_POST['date']) && isset($_SESSION['id'])) {
        include_once 'DBConnect.php';
        $DH = json_decode($_POST['DH'], true);
        $maUser = replace_regex($_SESSION['id']);
        $date = $_POST['date'];
        $tongtien = 0;
        $sql2 = 'insert into `chitietdonhang`(`maDH`, `maSP`, `SL`, `TongTien`, `Tinhtrang`) values';
        $maDH = DBconnect::getInstance()->execSQL("select max(`maDH`) from `donhang`");
        $insMaDH = (int)$maDH[0][0] + 1;
        for ($i = 0; $i < count($DH); $i++) {
            $tongtien += $DH[$i]['thanhtien'];
            $masp = $DH[$i]['masp'];
            $soluong = $DH[$i]['soluong'];
            $thanhtien = $DH[$i]['thanhtien'];
            $sql = "select `SL` from `sanpham` where `maSP`='$masp'";
            $sql2 .= " ('$insMaDH', '$masp', $soluong, $thanhtien, 'Đang chờ xử lý'),";
            $SLSP = DBconnect::getInstance()->execSQL($sql);
            $soluong = $SLSP[0][0] - $soluong;
            $sqlUpdate = "update `sanpham` set `SL`=$soluong where `maSP`='$masp'";
            DBconnect::getInstance()->execUpdate($sqlUpdate);
        }
        $maKH = DBconnect::getInstance()->execSQL("select maKH from khachhang where maUser = '$maUser'");
        $sql1 = "insert into `donhang`(`maDH`, `maKH`,`maNV`, `TongTien`, `Ngaykhoitao`) values ('$insMaDH', '" . $maKH[0][0] . "',null, $tongtien, '$date');";
        $exec = DBconnect::getInstance()->execMultiQuery($sql1 . rtrim($sql2, ',') . ";");
        if ($exec === true) echo 1;
        else echo $exec;
    }
}

function searchSP()
{
    if (isset($_POST['masp'])) {
        $masp = json_decode($_POST['masp']);
        include_once 'DBConnect.php';
        $sql = "SELECT * FROM `sanpham` where `maSP`='$masp'";
        $sp = DBconnect::getInstance()->execSQL($sql);
        echo json_encode($sp);
    }
}

function logout()
{
    session_destroy();
    setcookie(session_name(), session_id(), time() - 1, '/');
    echo getenv('TARGET');
}

function isLogin()
{
    include_once 'DBConnect.php';
    if (isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['pass'])) {
        $sql = "select `MK` from nguoidung where `TK`='" . replace_regex($_SESSION['user']) . "'";
        $pass = DBconnect::getInstance()->execSQL($sql);
        $URL = '';
        if ($pass[0]['MK'] === $_SESSION['pass']) {
            if (isset($_SESSION['URL'])) {
                $URL = '?' . $_SESSION['URL'];
                $_SESSION['URL'] = null;
            }
            if (getenv('TARGET') === 'production') {
                if (isset($_GET['checkuser'])) echo 1;
                else if (isset($_SESSION['role']) && $_SERVER['PHP_SELF'] != '/admin.php') header('location:admin.php');
                else if (!isset($_SESSION['role']) && $_SERVER['PHP_SELF'] != '/user.php') header('location:user.php' . $URL);
            } else {
                if (isset($_GET['checkuser'])) echo 1;
                else if (isset($_SESSION['role']) && $_SERVER['PHP_SELF'] != '/pttk/admin.php') header('location:/pttk/admin.php');
                else if (!isset($_SESSION['role']) && $_SERVER['PHP_SELF'] != '/pttk/user.php') header('location:/pttk/user.php' . $URL);
            }
        } else {
            if (getenv('TARGET') === 'production') {
                if ($_SERVER['PHP_SELF'] != '/index.php') {
                    echo 0;
                    header('location:index.php' . $URL);
                }
            } else {
                if ($_SERVER['PHP_SELF'] != '/pttk/index.php') {
                    echo 0;
                    header('location:/pttk/index.php' . $URL);
                }
            }
        }
    }
    if (!(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['pass']))) {
        if ($_SERVER['PHP_SELF'] != '/pttk/index.php' && getenv('TARGET') !== 'production') {
            if (isset($_GET['checkuser'])) echo -1;
            else {
                header('location:/pttk/index.php');
            }
        } else if ($_SERVER['PHP_SELF'] != '/index.php' && getenv('TARGET') === 'production') {
            if (isset($_GET['checkuser'])) echo -1;
            else {
                header('location:index.php');
            }
        }
    }
}

function checkUser()
{
    if (isset($_POST['username'])) {
        $user = replace_regex(json_decode($_POST['username']));
        include_once 'DBConnect.php';
        $sql = "select `TK` from nguoidung where `TK`='" . $user . "'";
        if (DBconnect::getInstance()->execSQL($sql)) echo 1;
        else echo 0;
    }
}

function xulyDK()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['ht']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['email']) && isset($_POST['sdt']) && isset($_POST['address'])) {
            include_once 'DBConnect.php';
            $maKH = DBconnect::getInstance()->execSQL("SELECT MAX(CAST(SUBSTRING(maUser,3,length(maUser)-2) AS unsigned)) FROM nguoidung WHERE maUser LIKE 'KH%'");
            $numMaKH = (int)trim($maKH[0][0], "KH") + 1;
            $insMaKH = "KH" . ($numMaKH);
            $idKH = (int)DBconnect::getInstance()->execSQL("SELECT MAX(maKH) from khachhang")[0][0] + 1;
            $cryptedPass = password_hash($_POST['pass'], PASSWORD_BCRYPT, array('cost' => 10));
            $sql = "insert into nguoidung values ('$insMaKH',null,'" . replace_regex($_POST['ht']) . "','" . replace_regex($_POST['user']) . "','$cryptedPass',1);";
            $sql .= "insert into `khachhang` values ($idKH, '$insMaKH','" . replace_regex($_POST['ht']) . "','" . replace_regex($_POST['address']) . "','" . $_POST['sdt'] . "','" . replace_regex($_POST['email']) . "',null);";
            if (DBconnect::getInstance()->execMultiQuery($sql)) {
                if (!isset($_GET['admin'])) {
                    $_SESSION['id'] = $insMaKH;
                    $_SESSION['name'] = $_POST['ht'];
                    $_SESSION['user'] = $_POST['user'];
                    $_SESSION['pass'] = $cryptedPass;
                    $_SESSION['sql'] = $sql;
                    setcookie(session_name(), session_id(), time() + 172800, '/');
                    if (getenv('TARGET') === 'production') header('location:/user.php');
                    else header('location:/pttk/user.php');
                }
            }
        }
    }
}

function xuLyDN()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['user']) && isset($_POST['pass'])) {
            include_once 'DBConnect.php';
            $sql = "select `TenUser`, `RoleID`, `lock/unlock`, `MK`, `maUser` from nguoidung where `TK`='" . replace_regex($_POST['user']) . "'";
            $user = DBconnect::getInstance()->execSQL($sql);
            if (password_verify($_POST['pass'], $user[0]['MK'])) {
                if ($user[0]['lock/unlock'] == 1) {
                    $_SESSION['id'] = $user[0]['maUser'];
                    $_SESSION['name'] = $user[0]['TenUser'];
                    $_SESSION['user'] = $_POST['user'];
                    $_SESSION['pass'] = $user[0]['MK'];
                    $_SESSION['role'] = $user[0]['RoleID'];
                    if ($_POST['remember'] == true) {
                        setcookie(session_name(), session_id(), time() + 172800, '/');
                    }
                    if (getenv('TARGET') === 'production') header('location:/index.php');
                    else header('location:/pttk/index.php');
                } else {
                    if (getenv('TARGET') === 'production') header('location:/index.php?errorLock=true');
                    else header('location:/pttk/index.php?errorLock=true');
                }
            } else {
                if (!isset($_SESSION['error'])) $_SESSION['error'] = 0;
                if (!isset($_SESSION['lastUser'])) $_SESSION['lastUser'] = $_POST['user'];
                if ($_SESSION['lastUser'] != $_POST['user']) {
                    $_SESSION['lastUser'] = $_POST['user'];
                    $_SESSION['error'] = 0;
                } else $_SESSION['error']++;
                if (isset($user[0]['maUser'])) {
                    if (isset($_SESSION['error']) && $_SESSION['error'] == 3 && ($user[0]['RoleID'] != 0 || !isset($user[0]['RoleID']))) {
                        DBconnect::getInstance()->execUpdate("update nguoidung set `lock/unlock`=0 where `TK`='" . replace_regex($_POST['user']) . "'");
                        session_unset();
                    }
                    if (getenv('TARGET') === 'production') header('location:/DN.php?error=true&user=' . $_POST['user'] . '&num=' . $_SESSION['error']);
                    else header('location:/pttk/DN.php?error=true&user=' . $_POST['user'] . '&num=' . $_SESSION['error']);
                } else {
                    if (getenv('TARGET') === 'production') header('location:/DN.php?error=true&user=' . $_POST['user']);
                    else header('location:/pttk/DN.php?error=true&user=' . $_POST['user']);
                }
            }
        }
    }
}

function menu()
{
    include_once 'DBConnect.php';
    $sqlTL = "SELECT * from `danhmuc`";
    $TL = DBconnect::getInstance()->execSQL($sqlTL);
    echo json_encode($TL);
}

function productDetail()
{
    if (isset($_GET["productID"])) {
        include_once 'DBConnect.php';
        $sql = "SELECT * FROM `sanpham` JOIN `chitietsp` ON `sanpham`.`maSP`=`chitietsp`.`maSP` WHERE `sanpham`.`maSP` = " . $_GET['productID'];
        $detail = DBconnect::getInstance()->execSQL($sql);
        echo json_encode($detail);
    } else echo -1;
}

function sanPham($SP1Page)
{
    if (isset($_GET['idBrand']) && isset($_GET['pageActive'])) {
        include_once 'DBConnect.php';
        $sqlSP = "SELECT * FROM `sanpham` JOIN `chitietsp` ON `sanpham`.`maSP`=`chitietsp`.`maSP` JOIN `danhmuc`ON `danhmuc`.`maDM`=`chitietsp`.`maDM` WHERE `danhmuc`.`maDM`='" . replace_regex($_GET['idBrand']) . "' limit " . ($_GET['pageActive'] - 1) * $SP1Page . ",$SP1Page";
        $sanPham = DBconnect::getInstance()->execSQL($sqlSP);
        return json_encode($sanPham);
    } else return -1;
}

function getPA()
{
    if (isset($_GET['pageActive'])) echo $_GET['pageActive'];
    else return -1;
}

function numPage($SP1Page)
{
    if (isset($_GET['idBrand']) && isset($_GET['pageActive'])) {
        include_once 'DBConnect.php';
        $sqlNum = "SELECT COUNT(`chitietsp`.`maSP`) as SL FROM `chitietsp` WHERE `chitietsp`.`maDM`='" . replace_regex($_GET['idBrand']) . "'";
        $num = DBconnect::getInstance()->execSQL($sqlNum);
        $numPage = ceil($num[0][0] / $SP1Page);
        return $numPage;
    } else return -1;
}

?>