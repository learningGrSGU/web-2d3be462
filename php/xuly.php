<?php
session_start();
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "delPermission":
            delPermission();
            break;
        case "qlquyen":
            qlquyen();
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

}

function encrypt()
{
    $str = "123456";
    echo password_hash($str, PASSWORD_BCRYPT, array('cost' => 10));
}

function uploadImg()
{
    if (isset($_FILES['fileToUpload']) && isset($_GET['do'])) {
        $dir = "../image/files_upload/";
        $target_file = $dir . basename($_FILES['fileToUpload']['name']);
        $extension = pathinfo($target_file, PATHINFO_EXTENSION);
        if (getimagesize($_FILES["fileToUpload"]["tmp_name"]) !== false) {
            if ($_FILES["fileToUpload"]["size"] > 500000) echo 0;
            else {
                if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
                    $upload_file = ltrim($target_file, "./");
                    if (isset($_GET['masp'])) $masp = $_GET['masp'];
                    include_once 'DBConnect.php';
                    if ($_GET['do'] == 'update') $sql = "update `chitietsp` set `Hình ảnh`='$upload_file' where `maSP`='$masp'";
                    $update = DBconnect::getInstance()->execUpdate($sql);
                    if ($update === true) echo 1;
                    else echo $update;
                } else echo -2;
            }
        } else echo -1;
    } else echo -1;
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
    echo $_SESSION['name'];
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

function ncc()
{

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
        if ($_GET['do'] == 'update') $sql1 = "update `sanpham` set `tenSp`='" . replace_regex($sp['tenSp']) . "', `MoTa`='" . replace_regex($sp['MoTa']) . "', `GiaCa`=" . $sp['GiaCa'] . ", `SL`=" . $sp['SL'] . " where `maSP`='" . $sp['maSP'] . "'";
        if ($_GET['do'] == 'insert') $sql1 = "insert into `sanpham` values ('" . $sp['maSP'] . "','" . replace_regex($sp['tenSp']) . "','" . replace_regex($sp['MoTa']) . "'," . $sp['GiaCa'] . "," . $sp['SL'] . ")";
        if ($_GET['do'] == 'update') $sql2 = "update `chitietsp` set `maDM`='" . replace_regex($sp['maDM']) . "', `Size`='" . replace_regex($sp['Size']) . "', `Weight`='" . replace_regex($sp['Weight']) . "', `Color`='" . replace_regex($sp['Color']) . "', `BoNhoTrong`='" . replace_regex($sp['BoNhoTrong']) . "', `BoNho`='" . replace_regex($sp['BoNho']) . "', `HDH`='" . replace_regex($sp['HDH']) . "', `CamTruoc`='" . replace_regex($sp['CamTruoc']) . "', `CamSau`='" . replace_regex($sp['CamSau']) . "', `Pin`='" . replace_regex($sp['Pin']) . "', `BaoHanh`='" . replace_regex($sp['BaoHanh']) . "', `TinhTrang`='" . replace_regex($sp['TinhTrang']) . "', `Ngày nhập hàng`='" . $sp['Ngày nhập hàng'] . "' where `maSP`='" . $sp['maSP'] . "'";
        if ($_GET['do'] == 'insert') $sql2 = "insert into `chitietsp`(`maSP`,`maDM`,`Size`,`Weight`,`Color`,`BoNhoTrong`,`BoNho`,`HDH`,`CamTruoc`,`CamSau`,`Pin`,`BaoHanh`,`TinhTrang`,`Ngày nhập hàng`) values ('" . $sp['maSP'] . "','" . replace_regex($sp['maDM']) . "','" . replace_regex($sp['Size']) . "','" . replace_regex($sp['Weight']) . "','" . replace_regex($sp['Color']) . "','" . replace_regex($sp['BoNhoTrong']) . "','" . replace_regex($sp['BoNho']) . "','" . replace_regex($sp['HDH']) . "','" . replace_regex($sp['CamTruoc']) . "','" . replace_regex($sp['CamSau']) . "','" . replace_regex($sp['Pin']) . "','" . replace_regex($sp['BaoHanh']) . "','" . replace_regex($sp['TinhTrang']) . "','" . $sp['Ngày nhập hàng'] . "')";
        $update1 = DBconnect::getInstance()->execUpdate($sql1);
        if ($update1 === true) $update2 = DBconnect::getInstance()->execUpdate($sql2);
        if (isset($update2) && $update2 === true) echo 1;
        else {
            if (isset($update2)) echo $update1 . $update2;
            else echo $update1;
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
}

function isLogin()
{
    include_once 'DBConnect.php';
    if (isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['pass'])) {
        $sql = "select `MK` from nguoidung where `TK`='" . replace_regex($_SESSION['user']) . "'";
        $pass = DBconnect::getInstance()->execSQL($sql);
        if ($pass[0]['MK'] === $_SESSION['pass']) {
            if (isset($_GET['checkuser'])) echo 1;
            else if (isset($_SESSION['role']) && $_SERVER['PHP_SELF'] != '/pttk/admin.php') header('location:/pttk/admin.php');
            else if (!isset($_SESSION['role']) && $_SERVER['PHP_SELF'] != '/pttk/user.php') header('location:/pttk/user.php');
        } else {
            if ($_SERVER['PHP_SELF'] != '/pttk/index.php') {
                echo 0;
                header('location:/pttk/index.php');
            }
        }
    }
    if (!(isset($_SESSION['name']) && isset($_SESSION['user']) && isset($_SESSION['pass'])) && $_SERVER['PHP_SELF'] != '/pttk/index.php') {
        if (isset($_GET['checkuser'])) echo -1;
        else header('location:/pttk/index.php');
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
                    header('location:/pttk/user.php');
                } else header('location:/pttk/admin.php?qltk');
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
                    header('location:/pttk/index.php');
                } else header('location:/pttk/index.php?errorLock=true');
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
                    header('location:/pttk/DN.php?error=true&user=' . $_POST['user'] . '&num=' . $_SESSION['error']);
                } else header('location:/pttk/DN.php?error=true&user=' . $_POST['user']);
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