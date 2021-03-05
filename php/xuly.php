<?php
session_start();
if(isset($_GET['action'])){ 
	switch($_GET['action']){
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
		default: break;
	}
}
function test(){
		echo $_SESSION['user'];	
}
function encrypt(){
	$str="123456";
	echo password_hash($str,PASSWORD_BCRYPT,array('cost'=>10));
}
function uploadImg(){
	if(isset($_FILES['fileToUpload'])&&isset($_GET['do'])){
		$dir = "../image/files_upload/";
		$target_file = $dir.basename($_FILES['fileToUpload']['name']);
		$extension = pathinfo($target_file,PATHINFO_EXTENSION);
		if(getimagesize($_FILES["fileToUpload"]["tmp_name"])!==false){
			if($_FILES["fileToUpload"]["size"] > 500000) echo 0;
			else {
			if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$target_file)){
				$upload_file = ltrim($target_file,"./");
				if(isset($_GET['masp'])) $masp = $_GET['masp'];
				include_once 'DBConnect.php';
				if($_GET['do']=='update') $sql = "update `chi tiết sản phẩm` set `Hình ảnh`='$upload_file' where `Mã sản phẩm`='$masp'";
				$update = DBconnect::getInstance()->execUpdate($sql);
				if($update===true) echo 1;
				else echo $update;
				}
			else echo -2;
			}
		}
		else echo -1;
	}
	else echo -1;
}
function errorLogin(){
	if(isset($_GET['error'])&&$_GET['error']==true) echo 0;
	else if(isset($_GET['errorLock'])&&$_GET['errorLock']==true) echo -1;
	else echo 1;
}
function userError(){
	if(isset($_GET['user'])) echo $_GET['user'];
}
?>
<?php
function replace_regex($string){
	return preg_replace('/\'/','\'\'',$string);
}
function removeMWSpace($String){
	return preg_replace('/\s{2,}/',' ',trim($String));
}
function home(){
	include_once 'DBConnect.php';
	$sql = "SELECT * FROM `sản phẩm` sp JOIN `chi tiết sản phẩm` ctsp ON sp.`Mã sản phẩm`=ctsp.`Mã sản phẩm` limit 0,10";
	$sp = DBconnect::getInstance()->execSQL($sql);
	if($sp) echo json_encode($sp);
	else echo $sql;
}
function del(){
	if(isset($_POST['user'])){
		include_once 'DBConnect.php';
	$sql = "delete from user where `Tên đăng nhập`='".replace_regex($_POST['user'])."' and `Tên đăng nhập`<>'admin'";
	$update = DBconnect::getInstance()->execUpdate($sql);
	if($update===true) echo 1;
	else echo $update;
	} else echo -1;
}
function unlock_lock(){
	if(isset($_POST['user'])&&isset($_POST['do'])){
		include_once 'DBConnect.php';
	if($_POST['do']==1) $sql1 = "update user set `Mở/Khoá`=1 where `Tên đăng nhập`='".replace_regex($_POST['user'])."' and `Tên đăng nhập`<>'admin'";
	else $sql2 = "update user set `Mở/Khoá`=0 where `Tên đăng nhập`='".replace_regex($_POST['user'])."' and `Tên đăng nhập`<>'admin'";
	if(isset($sql1)) $update1 = DBconnect::getInstance()->execUpdate($sql1);
	if(isset($sql2)) $update2 = DBconnect::getInstance()->execUpdate($sql2);
		if(isset($update1)){
			 if($update1===true) echo 1;
			 else echo $update1;
		}
		if(isset($update2)){
			 if($update2===true) echo 0;
			 else echo $update2;
		}
	}else echo -1;
}
function qltk(){
	include_once 'DBConnect.php';
	$sql = "select * from user where `Tên đăng nhập`<>'admin'";
	$user = DBconnect::getInstance()->execSQL($sql);
	if($user) {
		$numpage = ceil(count($user)/10);
		$user[count($user)] = $numpage;
		echo json_encode($user);
	}
	else echo 0;
}
function spmoi(){
	if(isset($_POST['sDate'])&&isset($_POST['eDate'])){
	$sDate = $_POST['sDate'];
	$eDate = $_POST['eDate'];
	include_once 'DBConnect.php';
	$sql = "SELECT * FROM `sản phẩm` sp JOIN `chi tiết sản phẩm` ctsp ON sp.`Mã sản phẩm`=ctsp.`Mã sản phẩm` where ctsp.`Ngày nhập hàng` between '$sDate' and '$eDate 23:59:59.9999'";
	$sp = DBconnect::getInstance()->execSQL($sql);
	if($sp) echo json_encode($sp);
	else echo $sql;
	} else echo -1;
}
function searchVance(){
	if(isset($_POST['dataSearch'])&&isset($_POST['each'])&&isset($_POST['pActive'])){
		include_once 'DBConnect.php';
		$toSearch = removeMWSpace($_POST['dataSearch']);
		$each = $_POST['each'];
		$sql = "SELECT * FROM `sản phẩm` sp JOIN `chi tiết sản phẩm` ctsp ON sp.`Mã sản phẩm`=ctsp.`Mã sản phẩm` JOIN `danh mục` th ON th.`Mã danh mục`=ctsp.`Mã danh mục` WHERE (sp.`Mã sản phẩm` = '$toSearch' or sp.`Tên điện thoại` like '%$toSearch%')";
		if(isset($_GET['brandOption'])) $sql.="and (th.`Mã danh mục`='".$_GET['brandOption']."')";
		if(isset($_GET['startPrice'])&&isset($_GET['endPrice'])) $sql.="and (sp.`Giá cả` between ".$_GET['startPrice']." and ".$_GET['endPrice'].")";
		$num = DBconnect::getInstance()->execSQL($sql);
		if($num!=0){
			$numPage = ceil(count($num)/$each);
		$sql.=" limit ".($_POST['pActive']-1)*$each.",$each";
		$search = DBconnect::getInstance()->execSQL($sql);
		$search[count($search)] = $numPage;
		echo json_encode($search);
		} else echo 0;
	}
	else echo -1;
}
function updateSP(){
	if(isset($_POST['sp'])&&isset($_GET['do'])){
		$sp = json_decode($_POST['sp'],true);
		include_once 'DBConnect.php';
		if($_GET['do']=='update') $sql1 = "update `sản phẩm` set `Tên điện thoại`='".replace_regex($sp['Tên điện thoại'])."', `Mô tả`='".replace_regex($sp['Mô tả'])."', `Giá cả`=".$sp['Giá cả'].", `Số lượng`=".$sp['Số lượng']." where `Mã sản phẩm`='".$sp['Mã sản phẩm']."'";
		if($_GET['do']=='insert') $sql1 = "insert into `sản phẩm` values ('".$sp['Mã sản phẩm']."','".replace_regex($sp['Tên điện thoại'])."','".replace_regex($sp['Mô tả'])."',".$sp['Giá cả'].",".$sp['Số lượng'].")";
		$sql = "select count(`Mã danh mục`) from `danh mục` where `Mã danh mục`='".replace_regex($sp['Mã danh mục'])."'";
		$check = DBconnect::getInstance()->execSQL($sql);
		if($check!=0&&$check[0][0]==0) {
			$sqlTL = "insert into `danh mục` values ('".replace_regex($sp['Mã danh mục'])."','".replace_regex($sp['Tên Danh mục'])."')";
			$insert = DBconnect::getInstance()->execUpdate($sqlTL);
		}			
			if($_GET['do']=='update') $sql2 = "update `chi tiết sản phẩm` set `Mã danh mục`='".replace_regex($sp['Mã danh mục'])."', `Kích thước`='".replace_regex($sp['Kích thước'])."', `Trọng lượng`='".replace_regex($sp['Trọng lượng'])."', `Màu sắc`='".replace_regex($sp['Màu sắc'])."', `Bộ nhớ trong`='".replace_regex($sp['Bộ nhớ trong'])."', `Bộ nhớ đệm/Ram`='".replace_regex($sp['Bộ nhớ đệm/Ram'])."', `Hệ điều hành`='".replace_regex($sp['Hệ điều hành'])."', `Camera trước`='".replace_regex($sp['Camera trước'])."', `Camera sau`='".replace_regex($sp['Camera sau'])."', `Pin`='".replace_regex($sp['Pin'])."', `Bảo hành`='".replace_regex($sp['Bảo hành'])."', `Tình trạng`='".replace_regex($sp['Tình trạng'])."', `Ngày nhập hàng`='".$sp['Ngày nhập hàng']."' where `Mã sản phẩm`='".$sp['Mã sản phẩm']."'";
			if($_GET['do']=='insert') $sql2 = "insert into `chi tiết sản phẩm`(`Mã chi tiết`,`Mã sản phẩm`,`Mã danh mục`,`Kích thước`,`Trọng lượng`,`Màu sắc`,`Bộ nhớ trong`,`Bộ nhớ đệm/Ram`,`Hệ điều hành`,`Camera trước`,`Camera sau`,`Pin`,`Bảo hành`,`Tình trạng`,`Ngày nhập hàng`) values ('".$sp['Mã chi tiết']."','".$sp['Mã sản phẩm']."','".replace_regex($sp['Mã danh mục'])."','".replace_regex($sp['Kích thước'])."','".replace_regex($sp['Trọng lượng'])."','".replace_regex($sp['Màu sắc'])."','".replace_regex($sp['Bộ nhớ trong'])."','".replace_regex($sp['Bộ nhớ đệm/Ram'])."','".replace_regex($sp['Hệ điều hành'])."','".replace_regex($sp['Camera trước'])."','".replace_regex($sp['Camera sau'])."','".replace_regex($sp['Pin'])."','".replace_regex($sp['Bảo hành'])."','".replace_regex($sp['Tình trạng'])."','".$sp['Ngày nhập hàng']."')";			
		$update1 = DBconnect::getInstance()->execUpdate($sql1);
		if($update1===true) $update2 = DBconnect::getInstance()->execUpdate($sql2);
		if(isset($update2)&&$update2===true) echo 1;
		else {
			if(isset($update2)) echo $update1.$update2;
			else echo $update1;
		}
	}
	else echo -1;
}
function checkSP(){
	if(isset($_POST['tensp'])){
		include_once 'DBConnect.php';
		$tensp = $_POST['tensp'];
		$sql = "select count(`Tên điện thoại`) from `sản phẩm` where `Tên điện thoại`='".replace_regex($tensp)."'";
		$check = DBconnect::getInstance()->execSQL($sql);
		if($check!=0&&$check[0][0]==0) echo 0;
		else echo 1;
	}
	else echo -1;
}
function delSp(){
	if(isset($_POST['masp'])){
		include_once 'DBConnect.php';
		$masp = $_POST['masp'];
		$sql = "DELETE FROM `sản phẩm` where `Mã sản phẩm`='$masp'";
		$del = DBconnect::getInstance()->execUpdate($sql);
		if($del===true) echo 1;
		else echo $del;
	}
	else echo -1;
}
function productList(){
	if(isset($_POST['pageActive'])&&isset($_POST['each'])&&isset($_POST['sDate'])&&isset($_POST['eDate'])){
		include_once 'DBConnect.php';
		$sDate = $_POST['sDate'];
		$eDate = $_POST['eDate'];
		$sqlNum="SELECT COUNT(sp.`Mã sản phẩm`) as SL FROM `sản phẩm` sp JOIN `chi tiết sản phẩm` ctsp ON sp.`Mã sản phẩm`=ctsp.`Mã sản phẩm` where (ctsp.`Ngày nhập hàng` between '$sDate' and '$eDate 23:59:59.9999') ";
		if(isset($_GET['dataSearch'])) $sqlNum.="and (ctsp.`Mã sản phẩm` like '%".removeMWSpace($_GET['dataSearch'])."%' or sp.`Tên điện thoại` like '%".removeMWSpace($_GET['dataSearch'])."%')";
		if(isset($_GET['brandOption'])) $sqlNum.="and (ctsp.`Mã danh mục`='".$_GET['brandOption']."')";
		if(isset($_GET['startPrice'])&&isset($_GET['endPrice'])) $sqlNum.="and (sp.`Giá cả` between ".$_GET['startPrice']." and ".$_GET['endPrice'].")";
		$num = DBconnect::getInstance()->execSQL($sqlNum);
		if($num!=0||$num[0][0]!=0) {
		$each = $_POST['each'];
		$numPage = ceil($num[0][0]/$each);
		$sqlSP="SELECT * FROM `sản phẩm` sp JOIN `chi tiết sản phẩm` ctsp ON sp.`Mã sản phẩm`=ctsp.`Mã sản phẩm` JOIN `danh mục` ON `danh mục`.`Mã danh mục`=ctsp.`Mã danh mục` where (ctsp.`Ngày nhập hàng` between '$sDate' and '$eDate 23:59:59.9999') ";
		if(isset($_GET['dataSearch'])) $sqlSP.="and (ctsp.`Mã sản phẩm` like '%".removeMWSpace($_GET['dataSearch'])."%' or sp.`Tên điện thoại` like '%".removeMWSpace($_GET['dataSearch'])."%')";
		if(isset($_GET['brandOption'])) $sqlSP.="and (ctsp.`Mã danh mục`='".$_GET['brandOption']."')";
		if(isset($_GET['startPrice'])&&isset($_GET['endPrice'])) $sqlSP.="and (sp.`Giá cả` between ".$_GET['startPrice']." and ".$_GET['endPrice'].")";
		$sqlSP.= "limit ".($_POST['pageActive']-1)*$each.",$each";
		$sanPham = DBconnect::getInstance()->execSQL($sqlSP);
		if($sanPham!=0){ 
		$sanPham[count($sanPham)] = $numPage;
		echo json_encode($sanPham);
			}else echo 0;
		}
		else echo 0;
	}
	else echo -1;
}
function TKDH(){
	if(isset($_POST['pageActive'])&&isset($_POST['each'])&&isset($_POST['sDate'])&&isset($_POST['eDate'])){
		include_once 'DBConnect.php';
		$sDate = $_POST['sDate'];
		$eDate = $_POST['eDate'];
		$each = $_POST['each'];
		$sqlNum="SELECT COUNT(dh.`Mã đơn hàng`) as SL FROM `đơn hàng` dh join `chi tiết đơn hàng` ctdh on dh.`Mã đơn hàng` = ctdh.`Mã đơn hàng` where (dh.`Ngày khởi tạo` between '$sDate' and '$eDate 23:59:59.9999')";
		$sqlPage="SELECT COUNT(DISTINCT dh.`Mã đơn hàng`) as SL FROM `đơn hàng` dh join `chi tiết đơn hàng` ctdh on dh.`Mã đơn hàng` = ctdh.`Mã đơn hàng` where (dh.`Ngày khởi tạo` between '$sDate' and '$eDate 23:59:59.9999')";
		if(isset($_GET['brandOption'])) {
			$sqlPage.=" and (ctdh.`Mã đơn hàng` = any (select ctdh1.`Mã đơn hàng` from `chi tiết đơn hàng` ctdh1 join `chi tiết sản phẩm` ctsp on ctdh1.`mã sản phẩm`=ctsp.`mã sản phẩm` where ctsp.`Mã danh mục`='".$_GET['brandOption']."'))";
			$sqlNum.=" and (ctdh.`Mã đơn hàng` = any (select ctdh1.`Mã đơn hàng` from `chi tiết đơn hàng` ctdh1 join `chi tiết sản phẩm` ctsp on ctdh1.`mã sản phẩm`=ctsp.`mã sản phẩm` where ctsp.`Mã danh mục`='".$_GET['brandOption']."'))";
		}
		if(isset($_GET['startPrice'])&&isset($_GET['endPrice'])){
			$sqlPage.=" and (dh.`Tổng tiền` between ".$_GET['startPrice']." and ".$_GET['endPrice'].")";
			$sqlNum.=" and (dh.`Tổng tiền` between ".$_GET['startPrice']." and ".$_GET['endPrice'].")";
		}
		$num = DBconnect::getInstance()->execSQL($sqlNum);
		$page = DBconnect::getInstance()->execSQL($sqlPage);
		if($num!=0||$num[0][0]!=0) {
		$numPage = ceil($page[0][0]/$each);
		$sqlLimit = "SELECT COUNT(ctdh.`Mã đơn hàng`) as count FROM `đơn hàng` dh join `chi tiết đơn hàng` ctdh on dh.`Mã đơn hàng` = ctdh.`Mã đơn hàng` where (dh.`Ngày khởi tạo` between '$sDate' and '$eDate 23:59:59.9999')";
		$sqlLast = "SELECT COUNT(ctdh.`Mã đơn hàng`) as count FROM `đơn hàng` dh join `chi tiết đơn hàng` ctdh on dh.`Mã đơn hàng` = ctdh.`Mã đơn hàng` where (dh.`Ngày khởi tạo` between '$sDate' and '$eDate 23:59:59.9999')";
		if(isset($_GET['brandOption'])) {
			$sqlLimit.=" and (ctdh.`Mã đơn hàng` = any (select ctdh1.`Mã đơn hàng` from `chi tiết đơn hàng` ctdh1 join `chi tiết sản phẩm` ctsp on ctdh1.`mã sản phẩm`=ctsp.`mã sản phẩm` where ctsp.`Mã danh mục`='".$_GET['brandOption']."'))";
			$sqlLast.=" and (ctdh.`Mã đơn hàng` = any (select ctdh1.`Mã đơn hàng` from `chi tiết đơn hàng` ctdh1 join `chi tiết sản phẩm` ctsp on ctdh1.`mã sản phẩm`=ctsp.`mã sản phẩm` where ctsp.`Mã danh mục`='".$_GET['brandOption']."'))";
		}
		if(isset($_GET['startPrice'])&&isset($_GET['endPrice'])){
			$sqlLimit.=" and (dh.`Tổng tiền` between ".$_GET['startPrice']." and ".$_GET['endPrice'].")";
			$sqlLast.=" and (dh.`Tổng tiền` between ".$_GET['startPrice']." and ".$_GET['endPrice'].")";
		}
		$sqlLimit.=" group by ctdh.`Mã đơn hàng` limit ".($_POST['pageActive']-1)*$each.",$each";
		$limits = DBconnect::getInstance()->execSQL($sqlLimit);
		$limit=0;
		if($limits!=0) for($i=0;$i<count($limits);$i++) $limit+=$limits[$i]['count'];				
		$sqlLast.=" group by ctdh.`Mã đơn hàng` limit ".($_POST['pageActive']-1)*$each.",".$num[0][0];
		$lasts = DBconnect::getInstance()->execSQL($sqlLast);
		$start = $num[0][0];
		if($lasts!=0) {
			for($i=0;$i<count($lasts);$i++) $start-=$lasts[$i]['count'];
		$sql="select dh.`Tổng tiền` as tongtien ,dh.`Mã đơn hàng`,dh.`Ngày khởi tạo`,user.`Tên`,user.`Địa chỉ`,user.`số điện thoại`,sp.`Tên điện thoại`,ctdh.`Số lượng`,ctdh.`Tổng tiền`,ctdh.`tình trạng đơn hàng` from `đơn hàng` dh join `chi tiết đơn hàng` ctdh on dh.`Mã đơn hàng` = ctdh.`Mã đơn hàng` join user on user.`Mã người dùng` = dh.`Mã người dùng` join `sản phẩm` sp on sp.`Mã sản phẩm` = ctdh.`Mã sản phẩm` where (dh.`Ngày khởi tạo` between '$sDate' and '$eDate 23:59:59.9999')";
		if(isset($_GET['brandOption'])) {
			$sql.=" and (ctdh.`Mã đơn hàng` = any (select ctdh1.`Mã đơn hàng` from `chi tiết đơn hàng` ctdh1 join `chi tiết sản phẩm` ctsp on ctdh1.`mã sản phẩm`=ctsp.`mã sản phẩm` where ctsp.`Mã danh mục`='".$_GET['brandOption']."'))";
		}
		if(isset($_GET['startPrice'])&&isset($_GET['endPrice'])){
			$sql.=" and (dh.`Tổng tiền` between ".$_GET['startPrice']." and ".$_GET['endPrice'].")";
		}
		$sql.=" order by dh.`Mã đơn hàng` limit $start,$limit";
		$DH = DBconnect::getInstance()->execSQL($sql);
		$DH[count($DH)] = $numPage;
		echo json_encode($DH);
		}
			}
			else echo 0;
	}
	else echo -1;
}
function numPagelsgd($lsgd1Page){
	if(isset($_GET['LSGD'])&&isset($_GET['pageActive'])&&isset($_SESSION['id'])){
		include_once 'DBConnect.php';
		$makh = replace_regex($_SESSION['id']);
		$sqlNum="SELECT COUNT(`Mã đơn hàng`) FROM `đơn hàng` where `Mã người dùng`='$makh'";
		$num = DBconnect::getInstance()->execSQL($sqlNum);
		$numPage = ceil($num[0][0]/$lsgd1Page);	
		return $numPage;
	}
	else return -1;
}
function lsgd($lsgd1Page){
	if(isset($_GET['LSGD'])&&isset($_GET['pageActive'])&&isset($_SESSION['id'])) {
		include_once 'DBConnect.php';
		$makh = replace_regex($_SESSION['id']);
		$limits = DBconnect::getInstance()->execSQL("select count(ctdh.`Mã đơn hàng`) count from `chi tiết đơn hàng` ctdh join `đơn hàng` dh on dh.`Mã đơn hàng`=ctdh.`Mã đơn hàng` where dh.`Mã người dùng`='$makh' group by ctdh.`Mã đơn hàng` limit ".($_GET['pageActive']-1)*$lsgd1Page.",$lsgd1Page");
		$limit=0;
		if($limits!=0) for($i=0;$i<count($limits);$i++) $limit+=$limits[$i]['count'];
		$all = DBconnect::getInstance()->execSQL("select count(ctdh.`Mã đơn hàng`) from `chi tiết đơn hàng` ctdh join `đơn hàng` dh on dh.`Mã đơn hàng`=ctdh.`Mã đơn hàng` where dh.`Mã người dùng`='$makh'");
		if($all!=0){
		$lasts = DBconnect::getInstance()->execSQL("select count(ctdh.`Mã đơn hàng`) count from `chi tiết đơn hàng` ctdh join `đơn hàng` dh on dh.`Mã đơn hàng`=ctdh.`Mã đơn hàng` where dh.`Mã người dùng`='$makh' group by ctdh.`Mã đơn hàng` limit ".($_GET['pageActive']-1)*$lsgd1Page.",".$all[0][0]);
		$start = $all[0][0];
		if($lasts!=0) for($i=0;$i<count($lasts);$i++) $start-=$lasts[$i]['count'];
		$sql="select dh.`Mã đơn hàng`,dh.`Ngày khởi tạo`,user.`Tên`,user.`Địa chỉ`,user.`số điện thoại`,sp.`Tên điện thoại`,ctdh.`Số lượng`,ctdh.`Tổng tiền`,ctdh.`tình trạng đơn hàng` from `đơn hàng` dh join `chi tiết đơn hàng` ctdh on dh.`Mã đơn hàng` = ctdh.`Mã đơn hàng` join user on user.`Mã người dùng` = dh.`Mã người dùng` join `sản phẩm` sp on sp.`Mã sản phẩm` = ctdh.`Mã sản phẩm` where dh.`Mã người dùng`='$makh' order by dh.`Mã đơn hàng` limit $start,$limit";
		$lsgd = DBconnect::getInstance()->execSQL($sql);
		return json_encode($lsgd);
		}
		return 0;
	}
	else return -1;
}
function xnDH(){
	if(isset($_POST['madh'])&&isset($_POST['check'])){
		$madh = json_decode($_POST['madh']);
		include_once 'DBConnect.php';
		if($_POST['check']==1) {
			$sql = "update `chi tiết đơn hàng` set `tình trạng đơn hàng`='Đã xác nhận' where `mã đơn hàng`='$madh'";
			$update = DBconnect::getInstance()->execUpdate($sql);
			if($update===true) echo 1;
			else echo $update;
		}
		else {
			$sql = "update `chi tiết đơn hàng` set `tình trạng đơn hàng`='Đang chờ xử lý' where `mã đơn hàng`='$madh'";
			$update = DBconnect::getInstance()->execUpdate($sql);
			if($update===true) echo 0;
			else echo $update;
		}
	}
	else echo -1;
}
function xoaDH(){
	if(isset($_POST['madh'])){
		include_once 'DBConnect.php';
		$update;
		$madh = json_decode($_POST['madh']);
		$sqlSLDH = "select `Số lượng`,`Mã sản phẩm` from `chi tiết đơn hàng` where `Mã đơn hàng`='$madh'";
		$SLDH = DBconnect::getInstance()->execSQL($sqlSLDH);
		for($i=0;$i<count($SLDH);$i++) {
			$masp = $SLDH[$i]['Mã sản phẩm'];
			$sqlSLSP = "select `Số lượng` from `sản phẩm` where `Mã sản phẩm`='$masp'";
			$SLSP = DBconnect::getInstance()->execSQL($sqlSLSP);
			$soluong = $SLSP[0][0] + $SLDH[$i]['Số lượng'];
			$sqlUpdate = "update `sản phẩm` set `Số lượng`=$soluong where `Mã sản phẩm`='$masp'";
			DBconnect::getInstance()->execUpdate($sqlUpdate);
			$sql = "update `chi tiết đơn hàng` set `tình trạng đơn hàng`='Đã hủy' where `Mã đơn hàng`='$madh'";
			$update = Dbconnect::getInstance()->execUpdate($sql);
		}
		if($update===true) echo 1;
		else echo $update;
	}
	else echo -1;
}
function xulyDHVance(){
	if(isset($_POST['pageActive'])&&isset($_POST['each'])&&isset($_POST['sDate'])&&isset($_POST['eDate'])){
		include_once 'DBConnect.php';
		$sDate = $_POST['sDate'];
		$eDate = $_POST['eDate'];
		$each = $_POST['each'];
		$sqlNum="SELECT COUNT(dh.`Mã đơn hàng`) as SL FROM `đơn hàng` dh join `chi tiết đơn hàng` ctdh on dh.`Mã đơn hàng` = ctdh.`Mã đơn hàng` where (ctdh.`tình trạng đơn hàng` NOT IN('Đã hủy')) and (dh.`Ngày khởi tạo` between '$sDate' and '$eDate 23:59:59.9999')";
		$sqlPage="SELECT COUNT(DISTINCT dh.`Mã đơn hàng`) as SL FROM `đơn hàng` dh join `chi tiết đơn hàng` ctdh on dh.`Mã đơn hàng` = ctdh.`Mã đơn hàng` where (ctdh.`tình trạng đơn hàng` NOT IN('Đã hủy')) and (dh.`Ngày khởi tạo` between '$sDate' and '$eDate 23:59:59.9999')";
		if(isset($_GET['brandOption'])) {
			$sqlPage.=" and (ctdh.`Mã đơn hàng` = any (select ctdh1.`Mã đơn hàng` from `chi tiết đơn hàng` ctdh1 join `chi tiết sản phẩm` ctsp on ctdh1.`mã sản phẩm`=ctsp.`mã sản phẩm` where ctsp.`Mã danh mục`='".$_GET['brandOption']."'))";
			$sqlNum.=" and (ctdh.`Mã đơn hàng` = any (select ctdh1.`Mã đơn hàng` from `chi tiết đơn hàng` ctdh1 join `chi tiết sản phẩm` ctsp on ctdh1.`mã sản phẩm`=ctsp.`mã sản phẩm` where ctsp.`Mã danh mục`='".$_GET['brandOption']."'))";
		}
		if(isset($_GET['startPrice'])&&isset($_GET['endPrice'])){
			$sqlPage.=" and (dh.`Tổng tiền` between ".$_GET['startPrice']." and ".$_GET['endPrice'].")";
			$sqlNum.=" and (dh.`Tổng tiền` between ".$_GET['startPrice']." and ".$_GET['endPrice'].")";
		}
		$num = DBconnect::getInstance()->execSQL($sqlNum);
		$page = DBconnect::getInstance()->execSQL($sqlPage);
		if($num!=0) {
			if($num[0][0]!=0){
		$numPage = ceil($page[0][0]/$each);
		$sqlLimit = "SELECT COUNT(ctdh.`Mã đơn hàng`) as count FROM `đơn hàng` dh join `chi tiết đơn hàng` ctdh on dh.`Mã đơn hàng` = ctdh.`Mã đơn hàng`  where (ctdh.`tình trạng đơn hàng` NOT IN('Đã hủy')) and (dh.`Ngày khởi tạo` between '$sDate' and '$eDate 23:59:59.9999')";
		$sqlLast = "SELECT COUNT(ctdh.`Mã đơn hàng`) as count FROM `đơn hàng` dh join `chi tiết đơn hàng` ctdh on dh.`Mã đơn hàng` = ctdh.`Mã đơn hàng`  where (ctdh.`tình trạng đơn hàng` NOT IN('Đã hủy')) and (dh.`Ngày khởi tạo` between '$sDate' and '$eDate 23:59:59.9999')";
		if(isset($_GET['brandOption'])) {
			$sqlLimit.=" and (ctdh.`Mã đơn hàng` = any (select ctdh1.`Mã đơn hàng` from `chi tiết đơn hàng` ctdh1 join `chi tiết sản phẩm` ctsp on ctdh1.`mã sản phẩm`=ctsp.`mã sản phẩm` where ctsp.`Mã danh mục`='".$_GET['brandOption']."'))";
			$sqlLast.=" and (ctdh.`Mã đơn hàng` = any (select ctdh1.`Mã đơn hàng` from `chi tiết đơn hàng` ctdh1 join `chi tiết sản phẩm` ctsp on ctdh1.`mã sản phẩm`=ctsp.`mã sản phẩm` where ctsp.`Mã danh mục`='".$_GET['brandOption']."'))";
		}
		if(isset($_GET['startPrice'])&&isset($_GET['endPrice'])){
			$sqlLimit.=" and (dh.`Tổng tiền` between ".$_GET['startPrice']." and ".$_GET['endPrice'].")";
			$sqlLast.=" and (dh.`Tổng tiền` between ".$_GET['startPrice']." and ".$_GET['endPrice'].")";
		}
		$sqlLast.=" group by ctdh.`Mã đơn hàng` limit ".($_POST['pageActive']-1)*$each.",".$num[0][0];
		$sqlLimit.=" group by ctdh.`Mã đơn hàng` limit ".($_POST['pageActive']-1)*$each.",$each";
		$limits = DBconnect::getInstance()->execSQL($sqlLimit);
		$limit=0;
		if($limits!=0) for($i=0;$i<count($limits);$i++) $limit+=$limits[$i]['count'];
		$lasts = DBconnect::getInstance()->execSQL($sqlLast);
		$start = $num[0][0];
		if($lasts!=0) {
			for($i=0;$i<count($lasts);$i++) $start-=$lasts[$i]['count'];
		$sql="select dh.`Tổng tiền` as tongtien ,dh.`Mã đơn hàng`,dh.`Ngày khởi tạo`,user.`Tên`,user.`Địa chỉ`,user.`số điện thoại`,sp.`Tên điện thoại`,ctdh.`Số lượng`,ctdh.`Tổng tiền`,ctdh.`tình trạng đơn hàng` from `đơn hàng` dh join `chi tiết đơn hàng` ctdh on dh.`Mã đơn hàng` = ctdh.`Mã đơn hàng` join user on user.`Mã người dùng` = dh.`Mã người dùng` join `sản phẩm` sp on sp.`Mã sản phẩm` = ctdh.`Mã sản phẩm` where (ctdh.`tình trạng đơn hàng` NOT IN('Đã hủy')) and (dh.`Ngày khởi tạo` between '$sDate' and '$eDate 23:59:59.9999')";
		if(isset($_GET['brandOption'])) {
			$sql.=" and (ctdh.`Mã đơn hàng` = any (select ctdh1.`Mã đơn hàng` from `chi tiết đơn hàng` ctdh1 join `chi tiết sản phẩm` ctsp on ctdh1.`mã sản phẩm`=ctsp.`mã sản phẩm` where ctsp.`Mã danh mục`='".$_GET['brandOption']."'))";
		}
		if(isset($_GET['startPrice'])&&isset($_GET['endPrice'])){
			$sql.=" and (dh.`Tổng tiền` between ".$_GET['startPrice']." and ".$_GET['endPrice'].")";
		}
		$sql.=" order by dh.`Mã đơn hàng` limit $start,$limit";
		$DH = DBconnect::getInstance()->execSQL($sql);
		$DH[count($DH)] = $numPage;
		echo json_encode($DH);
		}
			}
			else echo 0;
		}
	}
	else echo -1;
}
function numPageDH($DH1Page){
	if(isset($_GET['DH'])){
		include_once 'DBConnect.php';
		$sqlNum="SELECT COUNT(dh.`Mã đơn hàng`) as SL FROM `đơn hàng` dh join `chi tiết đơn hàng` ctdh on dh.`Mã đơn hàng` = ctdh.`Mã đơn hàng` where ctdh.`tình trạng đơn hàng` NOT IN('Đã hủy')";
		$num = DBconnect::getInstance()->execSQL($sqlNum);
		$numPage = ceil($num[0][0]/$DH1Page);	
		return $numPage;
	}
	else return -1;
}
function donhang(){
	if(isset($_POST['DH'])&&isset($_POST['date'])&&isset($_SESSION['id'])){
		include_once 'DBConnect.php';
		$DH = json_decode($_POST['DH'],true);
		$maKH = replace_regex($_SESSION['id']);
		$date = $_POST['date'];
		$tongtien = 0;
		$sql2='insert into `chi tiết đơn hàng`(`Mã đơn hàng`, `Mã sản phẩm`, `Số lượng`, `Tổng tiền`, `tình trạng đơn hàng`) values';
		$maDH=DBconnect::getInstance()->execSQL("select max(`Mã đơn hàng`) from `đơn hàng`");
		$insMaDH=(int)$maDH[0][0] + 1;
		for($i=0;$i<count($DH);$i++){
			$tongtien+=$DH[$i]['thanhtien'];
			$masp=$DH[$i]['masp'];
			$soluong=$DH[$i]['soluong'];
			$thanhtien=$DH[$i]['thanhtien'];
			$sql = "select `Số lượng` from `sản phẩm` where `Mã sản phẩm`='$masp'";			
			$sql2.=" ('$insMaDH', '$masp', $soluong, $thanhtien, 'Đang chờ xử lý'),";
			$SLSP = DBconnect::getInstance()->execSQL($sql);
			$soluong = $SLSP[0][0] - $soluong;
			$sqlUpdate = "update `sản phẩm` set `Số lượng`=$soluong where `Mã sản phẩm`='$masp'";
			DBconnect::getInstance()->execUpdate($sqlUpdate);
		}
		$sql1="insert into `đơn hàng`(`Mã đơn hàng`, `Mã người dùng`, `Tổng tiền`, `Ngày khởi tạo`) values ('$insMaDH', '$maKH', $tongtien, '$date')";
		$exec1 = DBconnect::getInstance()->execUpdate($sql1);
		$exec2 = DBconnect::getInstance()->execUpdate(rtrim($sql2,','));
		if($exec1===true&&$exec2===true) echo 1;
		else echo $exec1.$exec2;
	}
}
function searchSP(){
	if(isset($_POST['masp'])){
		$masp = json_decode($_POST['masp']);
		include_once 'DBConnect.php';
		$sql="SELECT * FROM `sản phẩm` where `Mã sản phẩm`='$masp'";
		$sp = DBconnect::getInstance()->execSQL($sql);
		echo json_encode($sp);
	}	
}
function logout(){
	session_destroy();
}
function isLogin(){
	include_once 'DBConnect.php';
	if(isset($_SESSION['name'])&&isset($_SESSION['user'])&&isset($_SESSION['pass'])){
		$sql = "select `Mật khẩu` from user where `Tên đăng nhập`='".replace_regex($_SESSION['user'])."'";
		$pass = DBconnect::getInstance()->execSQL($sql);
		if($pass[0]['Mật khẩu']===$_SESSION['pass']) {
			if(isset($_GET['checkuser'])) echo 1;
			else if ($_SESSION['user'] === "admin" && $_SERVER['PHP_SELF'] != '/nhom3/admin.php') header('location:/nhom3/admin.php');
			else if ($_SESSION['user'] !== "admin" && $_SERVER['PHP_SELF'] != '/nhom3/user.php') header('location:/nhom3/user.php');
		} else {
			if($_SERVER['PHP_SELF']!='/nhom3/index.php') {
				echo 0;
				header('location:/nhom3/index.php');
			}
		}
	}
	if(!(isset($_SESSION['name'])&&isset($_SESSION['user'])&&isset($_SESSION['pass']))&&$_SERVER['PHP_SELF']!='/nhom3/index.php') {
		if(isset($_GET['checkuser'])) echo -1;
		else header('location:/nhom3/index.php');
	}
}
function checkUser(){
	if(isset($_POST['username'])){
		$user = replace_regex(json_decode($_POST['username']));
		include_once 'DBConnect.php';
		$sql="select `Tên đăng nhập` from user where `Tên đăng nhập`='".$user."'";
		if(DBconnect::getInstance()->execSQL($sql)) echo 1;
		else echo 0;
	}
}
function xulyDK(){
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if(isset($_POST['ht']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['email']) && isset($_POST['sdt']) && isset($_POST['address'])){
			include_once 'DBConnect.php';
			$maKH=DBconnect::getInstance()->execSQL("select max(`Mã người dùng`) from user");
			$insMaKH="KH".(trim($maKH[0][0],"KH") + 1);
			$cryptedPass = password_hash($_POST['pass'],PASSWORD_BCRYPT,array('cost'=>10));
			$sql="insert into user values ('$insMaKH','".replace_regex($_POST['user'])."','$cryptedPass','".replace_regex($_POST['ht'])."','".replace_regex($_POST['address'])."','".$_POST['sdt']."','".replace_regex($_POST['email'])."',2,1)";
			if(DBconnect::getInstance()->execUpdate($sql)) {
				if(!isset($_GET['admin'])){
					$_SESSION['id']=$insMaKH;
					$_SESSION['name']=$_POST['ht'];
					$_SESSION['user']=$_POST['user'];
					$_SESSION['pass']=$cryptedPass;
					setcookie(session_name(),session_id(),time()+172800,'/');
				header('location:/nhom3/user.php');
				} else header('location:/nhom3/admin.php?qltk');
			}	
		}
	}
}
function xuLyDN(){
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if(isset($_POST['user'])&&isset($_POST['pass'])){
			include_once 'DBConnect.php';
			$sql="select `Tên`, `RoleID`, `Mở/Khoá`, `Mật khẩu`, `Mã người dùng` from user where `Tên đăng nhập`='".replace_regex($_POST['user'])."'";
			$user = DBconnect::getInstance()->execSQL($sql);
			if(password_verify($_POST['pass'],$user[0]['Mật khẩu'])){
				if($user[0]['Mở/Khoá']==1) {
					$_SESSION['id']=$user[0]['Mã người dùng'];
					$_SESSION['name']=$user[0]['Tên'];
					$_SESSION['user']=$_POST['user'];
					$_SESSION['pass']=$user[0]['Mật khẩu'];
					if($_POST['remember']==true){
						setcookie(session_name(),session_id(),time()+172800,'/');
					}
					header('location:/nhom3/index.php');
				}
				else header('location:/nhom3/index.php?errorLock=true');
			}
			else {
				if(!isset($_SESSION['error'])) $_SESSION['error'] = 0;
				else $_SESSION['error']++;
				if(isset($_SESSION['error'])&&$_SESSION['error']==3&&$_POST['user']!='admin') {
					DBconnect::getInstance()->execUpdate("update user set `Mở/Khoá`=0 where `Tên đăng nhập`='".replace_regex($_POST['user'])."'");
					session_unset();
				}
				header('location:/nhom3/index.php?error=true&user='.$_POST['user']);
			}
		}
	}
}
function menu(){
	include_once 'DBConnect.php';
	$sqlTL="SELECT * from `danh mục`";
	$TL = DBconnect::getInstance()->execSQL($sqlTL);
	echo json_encode($TL);
}
function sanPham($SP1Page){
	if(isset($_GET['idBrand'])&&isset($_GET['pageActive'])){
		include_once 'DBConnect.php';
		$sqlSP="SELECT * FROM `sản phẩm` JOIN `chi tiết sản phẩm` ON `sản phẩm`.`Mã sản phẩm`=`chi tiết sản phẩm`.`Mã sản phẩm` JOIN `danh mục`ON `danh mục`.`Mã danh mục`=`chi tiết sản phẩm`.`Mã danh mục` WHERE `danh mục`.`Mã danh mục`='".replace_regex($_GET['idBrand'])."' limit ".($_GET['pageActive']-1)*$SP1Page.",$SP1Page";
		$sanPham = DBconnect::getInstance()->execSQL($sqlSP);
		return json_encode($sanPham);
	}
	else return -1;
}
function getPA(){
	if(isset($_GET['pageActive'])) echo $_GET['pageActive'];
	else return -1;
}
function numPage($SP1Page){
	if(isset($_GET['idBrand'])&&isset($_GET['pageActive'])){
		include_once 'DBConnect.php';
		$sqlNum="SELECT COUNT(`chi tiết sản phẩm`.`Mã sản phẩm`) as SL FROM `chi tiết sản phẩm` WHERE `chi tiết sản phẩm`.`Mã danh mục`='".replace_regex($_GET['idBrand'])."'";
		$num = DBconnect::getInstance()->execSQL($sqlNum);
		$numPage = ceil($num[0][0]/$SP1Page);	
		return $numPage;
	}
	else return -1;
}
?>