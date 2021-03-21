
function customDialog(msg, btnMsgs, icons, functionCalls){
	let dialog = document.createElement('div');
	dialog.id = "dialog";
	dialog.innerHTML = msg;
	let Default = "Tôi hiểu";
	let buttons = [];
	if(btnMsgs==null) {
		btnMsgs = Default;
		buttons =
			[{
				text: btnMsgs,
				icon: "ui-icon-check",
				click: function() {
					$( this ).dialog( "close" );
				}
			}]; }
	else {
		for(let i=0; i<btnMsgs.length; i++) {
			buttons.push({
				text: btnMsgs[i],
				icon: icons[i],
				click: function(){
					functionCalls[i]()
				}
			});
		}
	}
	$(dialog).dialog({
		position: {my: "center bottom", at: "center center", of: window},
		dialogClass: "no-close",
		buttons: buttons
	});
}
function exportExcel(title, Headers, Data, filename, sheetname){
	objectExporter({
		exportable: Data,
		headers: Headers,
		type: 'xls',
		fileName: filename,
		headerStyle: 'font-size:16px; font-weight:bold;',
  		cellStyle: 'font-size:14px; text-align:justify;',
		sheetName: sheetname,
		documentTitle: title,
		documentTitleStyle: 'color:#ff0000; font-size:20; font-style:italic;',
	});
}
function exportPDF(id){
	objectExporter({
          type: 'html',
          exportable: id
       });
}
function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return null;
}
function upload(file, masp, toDo){
	var form = new FormData();
	form.append('fileToUpload',file);
	jq351.ajax({
 	 	url: 'php/xuly.php?action=uploadImg&masp='+masp+'&do='+toDo,
  		type: 'POST',
		async: false,
  		cache: false,
  		contentType: false,
  		processData: false,
  		data: form,
  		success:function(result){
    	console.log(result);
		if(Number(result)==1) alert('Đổi hình thành công!');
		else if(Number(result)==-1) alert('Không hỗ trợ định dạng này!');
		else if(Number(result)==0) alert('Hình có Size quá lớn!');
		else if(Number(result)==-2) alert('Upload Hình thất bại');
		else alert('Vui lòng điền đầy đủ thông tin trước khi thêm hình!');
  			}
 		});
}
function update(sp, toDo){
	jq351.ajax({
		url: 'php/xuly.php?action=updateSP&do='+toDo,
		type: 'POST',
		async: false,
		data:{sp:sp},
		success: function(result){
		console.log(result);
		if(Number(result)==1) alert('Sửa thành công');
		else alert('Sản phẩm đã tồn tại! '+result);
		}
	});
}
function escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };

  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}
function check_num(number){
	var check=/^\d+$/g;
	return check.test(number);
}
function checkEmail(email){
	var check=/^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/i;
	return check.test(email);
}
function checkNumber(number){
	var check=/^(09|03|07|08|05)([0-9]{8})$/g;
	return check.test(number);
}
function vanceOption(id, func){
	jq351(function(){
		jq351.ajax({
		url: 'php/xuly.php?action=getTL',
		async: false,
		success: function(results){
			console.log(results);
			var result = JSON.parse(results);
			var s = "<select onchange='"+func+"'>";
			for(var i=0;i<result.length;i++){
				s+='<option value="'+escapeHtml(result[i]['maDM'])+'">'+escapeHtml(result[i]['tenDM'])+'</option>';
			}
			s+='<option value="ALL" selected>Tất cả</option></select>';
			var span = document.createElement('span');
			span.innerHTML = 'Chọn Thương Hiệu: '+s;
			span.style='color:white;background-color:black;';
			jq351(id).append(span);
		}
	});
	var s='<select onchange=\''+func+'\'><option value="none"></option><option value="0-2tr">0 - 2 triệu</option><option value="2-4tr">2 - 4 triệu</option><option value="4-6tr">4 - 6 triệu</option><option value="6-8tr">6 - 8 triệu</option><option value="8-12tr">8 - 12 triệu</option><option value="12-20tr">12 - 20 triệu</option><option value=">20tr">trên 20 triệu</option>';
	var span = document.createElement('span');
	span.style.marginLeft='5px';
	span.innerHTML = 'Chọn Mức Giá: '+s;
	span.style="color:white;background-color:black;";
	jq351(id).append(span);
	});
}
function showErrorLogin(error){
	if(Number(error)==0) alert('Sai thông tin đăng nhập!');
	if(Number(error)==-1) alert('Tài khoản đã bị khóa do nhập sai quá nhiều lần');
}
function sanphamDH(msp,sl,thanhtien){
	this.masp=msp;
	this.soluong=sl;
	this.thanhtien=thanhtien;
}
function onLoad() {
	var loadingConext = document.createElement("div");
	loadingConext.className = 'modal';
	loadingConext.id = 'ld';
	loadingConext.innerHTML = '<div id="loading"></div>';
	loadingConext.style.display = 'block';
	jq351("body").append(loadingConext);
	var $loading = jq351('#ld').hide();
	jq351(document)
		.ajaxStart(function () {
			$loading.show();
		})
		.ajaxStop(function () {
			$loading.fadeOut(1000);
		});
}
//-------------------------------------------------------------code function here-------------------------------------------------------------------//
function isLogin(errorCode){
	if(Number(errorCode)==0) alert('Mật khẩu không hợp lệ');
}
function Homead(){
	var url = location.href.split('/');
	if(url[url.length-1]=='admin.php'){
		var sDate = new moment(new Date()).subtract(1,'month').format('YYYY-MM-DD');
		var eDate = new moment(new Date()).format('YYYY-MM-DD');
			var opt ='<div id="DHVance"></div><input id="startDate" type="date" onchange="onchangeTkDH(1)" value="'+sDate+'"><input id="endDate" type="date" onchange="onchangeTkDH(1)" value="'+eDate+'">';
			document.getElementById("opt").innerHTML=opt;
			jq351(function(){xlDhVance(1);});
	}
}
function Home(){
	var url = location.href.split('/');
	if(url[url.length-1]=='index.php'||url[url.length-1]=='user.php'){
		jq351.ajax({
			url: 'php/xuly.php?action=home',
			success: function(results){
				console.log(results);
				if(Number(results)!=-1){
				if(Number(results)!=0){
					var result = JSON.parse(results);
					var sp="";
					for(var i=0;i<result.length;i++){
						var curr = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(result[i]['GiaCa']);
						sp+='<div class="sanPham" style="text-align:center;" onclick=\'showCTSP.apply('+escapeHtml(JSON.stringify(result[i]))+');\'><img src="'+result[i]["HinhAnh"]+'" class="img"><span style="font-size:10px;font-weight:bold;">'+escapeHtml(result[i]["tenSp"])+'</span><button style="text-align:center;width:100%;color:#ff0000;">'+curr+'</button></div>';
					}
					document.getElementById("sp").innerHTML=sp;
				} else {
					document.getElementById("sp").innerHTML='';
				}
			}
		}
		});
	}
}
function spmoi(pActive){
	var url = location.href.split('?');
 	if(url[1]=='maymoi'){
	var sDate = new moment(new Date()).subtract(20,'days').format('YYYY-MM-DD');
	var eDate = new moment(new Date()).format('YYYY-MM-DD');
		jq351.ajax({
			url: 'php/xuly.php?action=maymoi',
			data: {sDate:sDate,eDate:eDate},
			type: 'POST',
			success: function(results){
				console.log(results);
				if(Number(results)!=-1){
				if(Number(results)!=0){
					var result = JSON.parse(results);
					var sp="";
					for(var i=0;i<result.length;i++){
						var curr = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(result[i]['GiaCa']);
						sp+='<div class="sanPham" style="text-align:center;" onclick=\'showCTSP.apply('+escapeHtml(JSON.stringify(result[i]))+');\'><img src="'+result[i]["HinhAnh"]+'" class="img"><span style="font-size:10px;font-weight:bold;">'+escapeHtml(result[i]["tenSp"])+'</span><button style="text-align:center;width:100%;color:red;">'+curr+'</button></div>';		
					}
					document.getElementById("sp").innerHTML=sp;
				} else {
					document.getElementById("sp").innerHTML='';
				}
			}
		}
		});
	}
}
function Search(pActive){	
var url = 'php/xuly.php?action=searchVance';
var data = escapeHtml(jq351('#dataSearch').val());
if(data!=''){
var brandOption = document.getElementById('vance').getElementsByTagName('select')[0].value;
var priceOption = document.getElementById('vance').getElementsByTagName('select')[1].value;
	switch(brandOption){
		case "ALL":
			break;
		default:
			url += '&brandOption='+brandOption;
			break; 
	}
	switch(priceOption){
		case "0-2tr":
			url += '&startPrice=0&endPrice=2000000';
			break;
		case "2-4tr":
			url += '&startPrice=2000000&endPrice=4000000';
			break;
		case "4-6tr":
			url += '&startPrice=4000000&endPrice=6000000';
			break;
		case "6-8tr":
			url += '&startPrice=6000000&endPrice=8000000';
			break;
		case "8-12tr":
			url += '&startPrice=8000000&endPrice=12000000';
			break;
		case "12-20tr":
			url += '&startPrice=12000000&endPrice=20000000';
			break;
		case ">20tr":
			url += '&startPrice=20000000&endPrice=999999999';
			break;
		default: break;
	}
	jq351.ajax({
		url: url,
		async: false,
		data: {dataSearch:data,each:5,pActive:pActive},
		type: 'POST',
		success: function(results){
			console.log(results);
			if(results!=-1){				
				if(Number(results)!=0){
				var result = JSON.parse(results);
				var sp="";
				for(var i=0;i<result.length-1;i++){
				var curr = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(result[i]['GiaCa']);
				sp+='<div class="sanPham" style="text-align:center;" onclick=\'showCTSP.apply('+escapeHtml(JSON.stringify(result[i]))+');\'><img src="'+result[i]["HinhAnh"]+'" class="img"><span style="font-size:10px;font-weight:bold;">'+escapeHtml(result[i]["tenSp"])+'</span><button style="text-align:center;width:100%;color:red;">'+curr+'</button></div>';		
					}
				jq351('#spSearch').html(sp);
				page('tr',result[result.length-1],'Search',pActive);
				}
				else {
					jq351('#spSearch').html('');
					jq351('#tr').html('');
				}
			}
		}
	});
	}else {
		jq351('#spSearch').html('');
		jq351('#tr').html('');
	}
}
function del(x, pActive){
	jq351.ajax({
		url: 'php/xuly.php?action=del',
		data: {user: x},
		type: 'POST',
		success: function(result){
			if(Number(result)==1) alert('Xóa thành công');
			else alert('Đã tồn tại đơn hàng có tài khoản này!');
			console.log(result);
		}
	});
	qltk(pActive);
}
function Unlock_lock(x, l, pActive){
	jq351.ajax({
		url: 'php/xuly.php?action=unlock_lock',
		data: {user: x, do: l},
		type: 'POST',
		success: function(result){
			if(Number(result)==1) alert('Mở khóa thành công');
			else if(Number(result)==0) alert('Khóa thành công');
			else console.log(result);
		}
	});
	qltk(pActive);
}
function qltk(pActive){
	var url = location.href.split('?');
 	if(url[1]=='qltk'){
		jq351(function(){
		jq351('#opt').html('<button class="themtk" onclick="document.getElementById(\'id02\').style.display=\'block\';">Thêm tài khoản mới</button>');
		jq351.ajax({
			url: 'php/xuly.php?action=qltk',
			success: function(results){
				console.log(results);
				if(Number(results)!=0){
					var result = JSON.parse(results);
					var accs="";
					accs+='<div id="qltkcover"><div class="row"><div class="th qltk">STT</div><div class="th qltk">Tên Đăng Nhập</div><div class="th qltk">Họ và Tên</div><div class="th qltk">Địa chỉ</div><div class="th qltk">Email</div><div class="th qltk">Số điện thoại</div><div class="th qltks">chức năng</div></div>';
					for(var i=0;i<result.length-1;i++){
						if(result[i]['Mở/Khoá']==1){
	accs+='<div class="row" id="'+i+'"><div class="col qltk">'+i+'</div><div class="col qltk">'+escapeHtml(result[i]['Tên đăng nhập'])+'</div><div class="col">'+escapeHtml(result[i]['Tên'])+'</div><div class="col">'+result[i]['Địa chỉ']+'</div><div class="col qltk">'+escapeHtml(result[i]['Email'])+'</div><div class="col qltk">'+result[i]['số điện thoại']+'</div><div class="col qltks"><button class="delacc" onclick="del('+escapeHtml(JSON.stringify(result[i]['Tên đăng nhập']))+', '+pActive+');">Xóa tài khoản</button><button class="lockacc" onclick="Unlock_lock('+escapeHtml(JSON.stringify(result[i]['Tên đăng nhập']))+',0, '+pActive+');">Khóa tài khoản</button></div></div>';
					}
					else {	
					accs+='<div class="row" id="'+i+'"><div class="col qltk">'+i+'</div><div class="col qltk">'+escapeHtml(result[i]['Tên đăng nhập'])+'</div><div class="col qltk">'+escapeHtml(result[i]['Tên'])+'</div><div class="col qltk">'+result[i]['Địa chỉ']+'</div><div class="col qltk">'+escapeHtml(result[i]['Email'])+'</div><div class="col qltk">'+result[i]['số điện thoại']+'</div><div class="col qltks"><button class="delacc" onclick="del('+escapeHtml(JSON.stringify(result[i]['Tên đăng nhập']))+', '+pActive+');">Xóa tài khoản</button><button class="lockacc" onclick="Unlock_lock('+escapeHtml(JSON.stringify(result[i]['Tên đăng nhập']))+',1, '+pActive+');">Mở khóa tài khoản</button></div></div>';	
					}
					}
					accs+='</div>';
					jq351('#sp').html(accs);
					page('trang',result[result.length-1],'qltk',pActive);
				}
				else {
					jq351('#sp').html('Hiện chưa có tài khoản nào!');
					jq351('#trang').html('');
				}
			}
		});
		});
	}
}
function ok(x,pActive){
	var input=document.getElementById(x['maSP']).getElementsByTagName("input");
	var xacnhan=prompt("Nhập mật khẩu để xác nhận thay đổi!");
	if(xacnhan=="admin") {
		var check = false;
		if(x['tenSp']!=input[1].value){
		jq351.ajax({
			url: 'php/xuly.php?action=checkSP',
			type: 'POST',
			async: false,
			data:{tensp:input[1].value},
			success: function(result){
				console.log(result);
				if(result==1) {
					check = true;
					alert('Tên sản phẩm đã tồn tại');
				}
			}
		});}
		if(!check){
			if(input[2].value>=1000000000) alert('SL phải nhỏ hơn 1.000.000.000');
			if(input[3].value>=1000000000) alert('Giá phải nhỏ hơn 1.000.000.000');
			if(input[1].value!='') x['tenSp'] = input[1].value;
			if(input[2].value!=''&&check_num(input[2].value)&&input[2].value<1000000000) x['SL'] = input[2].value;
			if(input[3].value!=''&&check_num(input[3].value)&&input[3].value<1000000000) x['GiaCa'] = input[3].value;
			if(input[4].value!='') {
				var chitiet = input[4].value.split(';');
				if(chitiet.length==11){
					x['Size'] = chitiet[0];
					x['Weight'] = chitiet[1];
					x['Color'] = chitiet[2];
					x['BoNhoTrong'] = chitiet[3];
					x['BoNho'] = chitiet[4];
					x['HDH'] = chitiet[5];
					x['CamTruoc'] = chitiet[6];
					x['CamSau'] = chitiet[7];
					x['Pin'] = chitiet[8];
					x['BaoHanh'] = chitiet[9];
					x['TinhTrang'] = chitiet[10];					
				}
				else alert('Vui lòng nhập đủ 11 chi tiết cách nhau bởi ";" trong chi tiết!');				
			}
			if(input[5].value!='') x['maDM'] = input[5].value;
			if(input[6].value!='') x['tenDM'] = input[6].value;
			if(input[7].value!='') x['Mô tả'] = input[7].value;
			if(input[8].value!='') x['Ngày nhập hàng'] = new moment(input[8].value).format('YYYY-MM-DD HH:mm:ss');
			var sp = JSON.stringify(x);
				update(sp, 'update');
			if(input[0].files&&input[0].files[0]) {
				upload(input[0].files[0],x['maSP'],'update');
			}
			productList(pActive);
		}
	}
	else alert("mật khẩu sai vui lòng nhập lại!");	
}
function delSp(x,pActive){
	if(confirm("Bạn có chắc chắn muốn xóa?")) {
	jq351.ajax({
			url: 'php/xuly.php?action=delSp',
			type: 'POST',
			async: false,
			data:{masp:x},
			success: function(result){
			 	if(result==1) alert('Xóa thành công');
				else alert('Xóa thất bại! '+result);
			}
		});
		productList(pActive);
	}
}
function changeSp(x,pActive){
	var input=document.getElementById(x['maSP']).getElementsByTagName("div");
	input[0].innerHTML='<input type="file" accept="image/*">';
	input[2].innerHTML='<input type="text" value=\''+escapeHtml(x['tenSp'])+'\'>';
	input[3].innerHTML='<input type="number" value=\''+x['SL']+'\'>';
	input[4].innerHTML='<input type="number" value=\''+x['GiaCa']+'\'>';
	input[5].innerHTML='<input type="text" value=\''+escapeHtml(x['Size'])+';'+escapeHtml(x['Weight'])+';'+escapeHtml(x['Color'])+';'+escapeHtml(x['BoNhoTrong'])+';'+escapeHtml(x['BoNho'])+';'+escapeHtml(x['HDH'])+';'+escapeHtml(x['CamTruoc'])+';'+escapeHtml(x['CamSau'])+';'+escapeHtml(x['Pin'])+';'+escapeHtml(x['BaoHanh'])+';'+escapeHtml(x['TinhTrang'])+'\'>';
	input[6].innerHTML='<input type="text" value=\''+escapeHtml(x['maDM'])+'\'>';
	input[7].innerHTML='<input type="text" value=\''+escapeHtml(x['tenDM'])+'\'>';
	input[9].innerHTML='<input type="text" value=\''+escapeHtml(x['Mô tả'])+'\'>';
	input[10].innerHTML='<input type="date" value="'+x['Ngày nhập hàng']+'">';
	input[11].innerHTML='<button class="DP" onclick=\'ok('+escapeHtml(JSON.stringify(x))+', '+pActive+');\'>OK</button><button class="DP" onclick="productList('+pActive+');">Hủy</button>';
	var but=document.getElementById("sp").getElementsByTagName("button");
	for(var t=0;t<but.length;t++) but[t].style.width="100%";
}
function addSp(x){
	var input=document.getElementById(x).getElementsByTagName("input");
	var check=1;
	for(var i=1;i<input.length;i++){
		if(input[i].value=="") {
		alert("vui lòng nhập vào đầy đủ thông tin!");
		check=0;
		break;
		}
	}
	if(check==1) {
	var xacnhan=prompt("Nhập mật khẩu để xác nhận thay đổi!");
	if(xacnhan=="admin") {
		if(check_num(input[1].value)&&check_num(input[3].value)&&check_num(input[4].value)&&check_num(input[8].value)){
				if(input[5].value.split(';').length==11){
				if(input[1].value<1000000000&&input[3].value<1000000000&&input[4].value<1000000000&&input[8].value<1000000000){
					var data = {};
					var chitiet = input[5].value.split(';');
					data['Ngày nhập hàng'] = new moment(input[10].value).format('YYYY-MM-DD HH:mm:ss');
					data['maSP'] = input[1].value;
					data['tenSp'] = input[2].value;
					data['Mô tả'] = input[9].value;
					data['GiaCa'] = input[4].value;
					data['SL'] = input[3].value;
					data['maDM'] = input[6].value;
					data['tenDM'] = input[7].value;
					data['Mã chi tiết'] = input[8].value;
					data['Size'] = chitiet[0];
					data['Weight'] = chitiet[1];
					data['Color'] = chitiet[2];
					data['BoNhoTrong'] = chitiet[3];
					data['BoNho'] = chitiet[4];
					data['HDH'] = chitiet[5];
					data['CamTruoc'] = chitiet[6];
					data['CamSau'] = chitiet[7];
					data['Pin'] = chitiet[8];
					data['BaoHanh'] = chitiet[9];
					data['TinhTrang'] = chitiet[10];
					var sp = JSON.stringify(data);
					update(sp, 'insert');
					if(input[0].files&&input[0].files[0]){
						upload(input[0].files[0],input[1].value,'update');
					}
					productList(1);
				} else alert('maSP, SL, Đơn giá, Mã chi tiết phải nhỏ hơn 1.000.000.000');
			} else alert('Vui lòng nhập đủ 11 chi tiết cách nhau bởi ";" trong chi tiết!');
		} else alert('maSP, SL, Đơn giá, Mã chi tiết phải là số nguyên!');		
	}
	else alert("mật khẩu sai vui lòng nhập lại!");
	}
}
function showAddSp(){
	var modal = document.getElementById('addSp');
	if(modal!=null)
	modal.style.display='block';
	else {
		var mod='';
		var myModal=document.createElement('div');
		myModal.className='modal product';
		myModal.id='addSp';
		mod+='<div class="modal-content addProd" style="width:100%;height:90%;"><div id="newSp" class="container" style="padding:0 20px 10px 20px;line-height:0.3;">'+
      '<h1 style="color:red;">Nhập đầy đủ thông tin để thêm sản phẩm!!!!</h1>'+
      '<hr>'+
	  //1
      '<div style="clear:left;margin-bottom:3%;"><div style="float:left;font-size:13px;font-weight:bold;">Upload HinhAnh:</div>'+
      '<input style="float:left;margin:-8px auto auto 5px" type="file" accept="image/*"></div>'+
      //2
      '<div style="clear:left;margin-bottom:3%;"><div style="float:left;font-size:13px;font-weight:bold;">maSP:</div>'+
      '<input style="float:left;margin:-8px auto auto 5px;width:90%;padding: 3px 15px;display:inline-block;border: 1px solid black;border-radius: 5px;box-sizing: border-box;" type="text"></div>'+
	  //3
	  '<div style="clear:left;margin-bottom:3%;"><div style="float:left;font-size:13px;font-weight:bold;">Tên sản phẩm:</div>'+
      '<input style="float:left;margin:-8px auto auto 5px;width: 89%;padding: 3px 15px;display:inline-block;border: 1px solid black;border-radius: 5px;box-sizing: border-box;" type="text"></div>'+
	  //4
	  '<div style="clear:left;margin-bottom:3%;"><div style="float:left;font-size:13px;font-weight:bold;">SL:</div>'+
      '<input style="float:left;margin:-8px auto auto 5px;width: 90%;padding: 3px 15px;display:inline-block;border: 1px solid black;border-radius: 5px;box-sizing: border-box;" type="text"></div>'+
	  //5
	  '<div style="clear:left;margin-bottom:3%;"><div style="float:left;font-size:13px;font-weight:bold;">Đơn giá:</div>'+
      '<input style="float:left;margin:-8px auto auto 5px;width: 90%;padding: 3px 15px;display:inline-block;border: 1px solid black;border-radius: 5px;box-sizing: border-box;" type="text"></div>'+
	  //6
	  '<div style="clear:left;margin-bottom:3%;"><div style="float:left;font-size:13px;font-weight:bold;">Chi tiết:</div>'+
      '<input style="float:left;margin:-8px auto auto 5px;width: 90%;padding: 3px 15px;display:inline-block;border: 1px solid black;border-radius: 5px;box-sizing: border-box;" type="text"></div>'+
	  //7
	  '<div style="clear:left;margin-bottom:3%;"><div style="float:left;font-size:13px;font-weight:bold;">Mã thể loại:</div>'+
      '<input style="float:left;margin:-8px auto auto 5px;width: 90%;padding: 3px 15px;display:inline-block;border: 1px solid black;border-radius: 5px;box-sizing: border-box;" type="text"></div>'+
	  //8
	  '<div style="clear:left;margin-bottom:3%;"><div style="float:left;font-size:13px;font-weight:bold;">Tên thể loại:</div>'+
      '<input style="float:left;margin:-8px auto auto 5px;width: 90%;padding: 3px 15px;display:inline-block;border: 1px solid black;border-radius: 5px;box-sizing: border-box;" type="text"></div>'+
	  //9
	  '<div style="clear:left;margin-bottom:3%;"><div style="float:left;font-size:13px;font-weight:bold;">Mã chi tiết:</div>'+
      '<input style="float:left;margin:-8px auto auto 5px;width: 90%;padding: 3px 15px;display:inline-block;border: 1px solid black;border-radius: 5px;box-sizing: border-box;" type="text"></div>'+
	  //10
	  '<div style="clear:left;margin-bottom:3%;"><div style="float:left;font-size:13px;font-weight:bold;">Mô tả:</div>'+
      '<input style="float:left;margin:-8px auto auto 5px;width: 90%;padding: 3px 15px;display:inline-block;border: 1px solid black;border-radius: 5px;box-sizing: border-box;" type="text"></div>'+
	  //11
	  '<div style="clear:left;margin-bottom:3%;"><div style="float:left;font-size:13px;font-weight:bold;">Ngày nhập:</div>'+
      '<input style="float:left;margin:-8px auto auto 5px;width: 90%;padding: 3px 15px;display:inline-block;border: 1px solid black;border-radius: 5px;box-sizing: border-box;" type="date"></div>'+
	  '</div><div class="container"><button class="but" onclick="addSp(\'newSp\');">Thêm</button></div></div></div>';
		myModal.innerHTML=mod;
		document.getElementsByTagName('body')[0].appendChild(myModal);
	}
	if(modal==null) modal=myModal;
	window.addEventListener('click',function(event){
			if(event.target==modal){
				modal.style.display='none';
			}
	});
}
function productList(pActive){
	jq351(function(){
	document.addEventListener('keydown',function(ev){
		ev.preventDefault();
		if(ev.ctrlKey && ev.altKey && ev.key === 'n'){
			showAddSp();
		}
	});
	var sDate = document.getElementById('startDate').value;
	var eDate = document.getElementById('endDate').value;
	var url = 'php/xuly.php?action=productList';
	var data = escapeHtml(jq351('#productSearch').val());
	if(data!='') url+='&dataSearch='+data;
	var brandOption = document.getElementById('PDvance').getElementsByTagName('select')[0].value;
	var priceOption = document.getElementById('PDvance').getElementsByTagName('select')[1].value;
	switch(brandOption){
		case "ALL":
			break;
		default:
			url += '&brandOption='+brandOption;
			break; 
	}
	switch(priceOption){
		case "0-2tr":
			url += '&startPrice=0&endPrice=2000000';
			break;
		case "2-4tr":
			url += '&startPrice=2000000&endPrice=4000000';
			break;
		case "4-6tr":
			url += '&startPrice=4000000&endPrice=6000000';
			break;
		case "6-8tr":
			url += '&startPrice=6000000&endPrice=8000000';
			break;
		case "8-12tr":
			url += '&startPrice=8000000&endPrice=12000000';
			break;
		case "12-20tr":
			url += '&startPrice=12000000&endPrice=20000000';
			break;
		case ">20tr":
			url += '&startPrice=20000000&endPrice=999999999';
			break;
		default: break;
	}
	console.log(url);
		jq351.ajax({
			url: url,
			type: 'POST',
			async: false,
			data:{pageActive:pActive,each:10,sDate:sDate,eDate:eDate},
			success: function(results){
				console.log(results);
				if(Number(results)!=-1){
					if(Number(results)!=0){
					var result = JSON.parse(results);
			var curr = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' });
			var sp='<div class="row"><div class="th">HinhAnh</div><div class="th">maSP</div><div class="th">Tên sản phẩm</div><div class="th">SL</div><div class="th">Đơn giá</div><div class="th">Chi tiết</div><div class="th">Mã thể loại</div><div class="th">Tên thể loại</div><div class="th">Mã chi tiết</div><div class="th">Mô tả</div><div class="th">Ngày nhập hàng</div><div class="th" style="width:10%;">Chức năng</div></div>',s="";
			for(var i=0;i<result.length-1;i++){
			var ng=new moment(result[i]['Ngày nhập hàng']).format('DD/MM/YYYY HH:mm:ss');
			sp+='<div class="row" id="'+result[i]['maSP']+'"><div class="col" ><img alt="image" width="70%" height="65px" title="'+escapeHtml(result[i]['tenSp'])+'" src="'+result[i]['HinhAnh']+'"/></div><div class="col">'+result[i]['maSP']+'</div><div class="col">'+escapeHtml(result[i]['tenSp'])+'</div><div class="col">'+result[i]['SL']+'</div><div class="col">'+curr.format(result[i]['GiaCa'])+'</div><div class="col">'+escapeHtml(result[i]['Size'])+';'+escapeHtml(result[i]['Weight'])+';'+escapeHtml(result[i]['Color'])+';'+escapeHtml(result[i]['BoNhoTrong'])+';'+escapeHtml(result[i]['BoNho'])+';'+escapeHtml(result[i]['HDH'])+';'+escapeHtml(result[i]['CamTruoc'])+';'+escapeHtml(result[i]['CamSau'])+';'+escapeHtml(result[i]['Pin'])+';'+escapeHtml(result[i]['BaoHanh'])+';'+escapeHtml(result[i]['TinhTrang'])+'</div><div class="col">'+escapeHtml(result[i]['maDM'])+'</div><div class="col">'+escapeHtml(result[i]['tenDM'])+'</div><div class="col">'+result[i]['Mã chi tiết']+'</div><div class="col">'+escapeHtml(result[i]['Mô tả'])+'</div><div class="col">'+ng+'</div><div class="col" style="width:10%;"><button class="DP" onclick="delSp('+result[i]['maSP']+', '+pActive+');">Xóa</button><button class="CP" onclick=\'changeSp('+escapeHtml(JSON.stringify(result[i]))+','+pActive+');\'>Sửa</button></div></div>';
			}
			var sanP=document.getElementById("sp");
			sanP.innerHTML=sp;
			page("trang",result[result.length-1],"productList",pActive);
			var but=sanP.getElementsByTagName("button");
			for(var t=0;t<but.length;t++) but[t].style.width="100%";
					} else {
						jq351('#sp').html('Không tìm thấy sản phẩm!');
						jq351('#trang').html('');
					}
				}
			}
		});
	});
}
function product(){
	var url=location.href.split("?");
	if(url[1]=="dssp"){
		var sDate = new moment(new Date()).subtract(1,'month').format('YYYY-MM-DD');
		var eDate = new moment(new Date()).format('YYYY-MM-DD');
		document.getElementById('opt').innerHTML='<input  id="productSearch" onKeyUp="productList(1);" type="text" placeholder="Nhập maSP hoặc Tên sản phẩm để tìm" name="search"><div id="PDvance"></div><input id="startDate" type="date" onchange="productList(1);" value="'+sDate+'"><input id="endDate" type="date" onchange="productList(1)" value="'+eDate+'"><button class="AProd" onclick="showAddSp();">Thêm sản phẩm</button>';
		jq351(function(){productList(1);});
	}
}
function onchangeTkDH(pActive){
	jq351(function(){
	var dh = '';
	var tc = 0;
	var sDate = document.getElementById('startDate').value;
	var eDate = document.getElementById('endDate').value;
	var curr = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' });
	var url = 'php/xuly.php?action=TKDH';
	var brandOption = document.getElementById('DHvance').getElementsByTagName('select')[0].value;
	var priceOption = document.getElementById('DHvance').getElementsByTagName('select')[1].value;
	switch(brandOption){
		case "ALL":
			break;
		default:
			url += '&brandOption='+brandOption;
			break; 
	}
	switch(priceOption){
		case "0-2tr":
			url += '&startPrice=0&endPrice=2000000';
			break;
		case "2-4tr":
			url += '&startPrice=2000000&endPrice=4000000';
			break;
		case "4-6tr":
			url += '&startPrice=4000000&endPrice=6000000';
			break;
		case "6-8tr":
			url += '&startPrice=6000000&endPrice=8000000';
			break;
		case "8-12tr":
			url += '&startPrice=8000000&endPrice=12000000';
			break;
		case "12-20tr":
			url += '&startPrice=12000000&endPrice=20000000';
			break;
		case ">20tr":
			url += '&startPrice=20000000&endPrice=999999999';
			break;
		default: break;
	}
	jq351.ajax({
			url: url,
			type: 'POST',
			async: false,
			data:{pageActive:pActive,each:6,sDate:sDate,eDate:eDate},
			success: function(results){
				console.log(results);
				if(results!=-1){
					if(results!=0){
					var result = JSON.parse(results);
					var data = [];
					var columns = ['tenSp','SL','Tổng tiền'];
					var headers = [];
      				for (var k = 0; k < columns.length; k++) {
        			headers.push({
        			alias: columns[k],
          			name: columns[k],
          			flex: 1
        				});
      				}
					for(var i=0;i<result.length-1;i++){
				if(check){
					var ng=new moment(result[i]['Ngaykhoitao']).format('DD/MM/YYYY HH:mm:ss');
					dh+='<div id="'+i+'"><div class="acc" style="clear:both;"><span style="color:red;">Tên khách hàng: </span>'+escapeHtml(result[i]['Tên'])+'</div><div class="nggd" style="clear:both;"><span style="color:red;">Ngày giao dịch: </span>'+ng+'</div><div style="clear:both;"><span style="font-weight:bold;">Địa chỉ giao hàng: </span><span style="font-style:italic;">'+escapeHtml(result[i]['Địa chỉ'])+'</span></div><div style="clear:both;"><span style="font-weight:bold;">Số điện thoại: </span><span style="font-style:italic;">'+result[i]['số điện thoại']+'</span></div><div><span style="font-weight:bold;">TinhTrang: </span><span style="font-weight:bold;font-style:italic;color:#F60;">'+escapeHtml(result[i]['Tinhtrang'])+'</span></div><div id="tkcover">';
					check = false;
				}
				if(!check) {	
					dh+='<div class="donHang" style="clear:both;"><div class="col tk" style="width:20%;"><span style="font-size:15px;color:black;">'+escapeHtml(result[i]['tenSp'])+'</span></div><div class="col tk" style="width:20%;">SL: <span style="font-size:15px;color:black;">'+result[i]['SL']+' Cái</span></div><div class="col tk" style="width:20%;">Thành Tiền: <span style="font-size:15px;color:black;">'+curr.format(result[i]['Tổng tiền'])+'</span></div></div>';
/*	<div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 8px;">'+result[0]['tenSp']+'</span></div><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 7px;">SL: </span><div style="padding-top:7px;border:0;"><input style="width:70px;float:left;text-align:center" onchange="changeValue('+i+');" onkeyup="checkValueC('+i+');" type="number" min="0" max="'+soluong+'" value="'+sanPhamDH[i].soluong+'"></div></div><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 8px;">Thành Tiền: </span><div style="padding-top:7px;border:0;font-style:italic;font-size:18px;">'+curr.format(gia)+'</div></div>
*/					var rowData = {};
					for (var j = 0; j < columns.length; j++) {
						if(columns[j]=="Tổng tiền") rowData[columns[j]] = curr.format(result[i]['Tổng tiền']);
          				else rowData[columns[j]] = result[i][columns[j]];
        			}
        			data.push(rowData);
				}
				if(i!=result.length-2) if(result[i]['maDH']!=result[i+1]['maDH']) check=true;
				if(i==result.length-2) check=true;
				if(check){
					dh+='</div><div class="tongDH" style="clear:both;">Tổng tiền đơn hàng: '+curr.format(result[i]['tongtien'])+'</div>';
					if(result[i]['Tinhtrang']=='Đã xác nhận') tc += Number(result[i]['tongtien']);
					}
				}
				dh+='<div style="clear:both;font-size:20px;color:#8000ff;">Tổng doanh thu trên 1 trang: <span style="font-size:26px;color:black;">'+curr.format(tc)+'</span></div>';
				if(document.getElementById('export')==null){
				var div = document.createElement('div');
				div.id = 'export';
				div.innerHTML = '<button onclick=\'exportExcel("Thống kê điện thoại đã bán được", '+JSON.stringify(headers)+', '+escapeHtml(JSON.stringify(data))+', "Thống kê", "Thống kê theo khoảng thời gian")\'>Xuất Excel</button><button onclick="exportPDF(\'sp\')">Xuất PDF</button>';
				document.getElementById("menu").insertBefore(div,document.getElementById('opt'));
				}
					document.getElementById("sp").innerHTML=dh;
					page("trang",result[result.length-1],"onchangeTkDH",pActive);
					}
					else {
						document.getElementById("sp").innerHTML='<div class="check">Không có đơn hàng trong khoảng thời gian này!</div>';
						document.getElementById("trang").innerHTML="";
						var expo = document.getElementById('export');
						if(expo!=null)
						document.getElementById('menu').removeChild(expo);
					}
				}
			}
		});
	});
}
function tkDH(){
	var url=location.href.split("?");
	if(url[1]=="tksp"){
		var dh = '';
		var curr = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' });
		var sDate = new moment(new Date()).subtract(1,'month').format('YYYY-MM-DD');
		var eDate = new moment(new Date()).format('YYYY-MM-DD');
		var opt ='<div id="DHvance"></div><input id="startDate" type="date" onchange="onchangeTkDH(1)" value="'+sDate+'"><input id="endDate" type="date" onchange="onchangeTkDH(1)" value="'+eDate+'">';
		document.getElementById("opt").innerHTML=opt;
		jq351(function(){onchangeTkDH(1);});
	}
}
function LsGd(lsgdJSON,pActive,pNum){
	if(lsgdJSON!=-1){
		var dh="",s="";
		document.getElementsByClassName("featured")[0].style.display="none";
		document.getElementsByClassName("sub-featured")[0].style.display="none";
		if(lsgdJSON==0){
			document.getElementById("sp").innerHTML='<div class="check">Chưa có đơn đặt hàng!</div>';
			document.getElementById("trang").innerHTML=s;
		}
		else{
		var check = true;
		var curr = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' });
		for(var i=0;i<lsgdJSON.length;i++){
				if(check){
					var ng=new moment(lsgdJSON[i]['Ngaykhoitao']).format('DD/MM/YYYY HH:mm:ss');
					dh+='<div id="'+i+'"><div class="acc" style="clear:both;"><span style="color:red;">Tên khách hàng: </span>'+escapeHtml(lsgdJSON[i]['Hovaten'])+'</div><div class="nggd" style="clear:both;"><span style="color:red;">Ngày thanh toán: </span>'+ng+'</div><div style="clear:both;"><span style="font-weight:bold;">Địa chỉ giao hàng: </span><span style="font-style:italic;">'+escapeHtml(lsgdJSON[i]['Diachi'])+'</span></div><div style="clear:both;"><span style="font-weight:bold;">Số điện thoại: </span><span style="font-style:italic;">'+lsgdJSON[i]['Sdt']+'</span></div><div><span style="font-weight:bold;">Tình trạng đơn hàng: </span><span style="font-weight:bold;font-style:italic;color:#F60;">'+escapeHtml(lsgdJSON[i]['Tinhtrang'])+'</span></div><div id="lsgdcover">';
					check = false;
				}
				if(!check) {	
					dh+='<div class="donHang" style="clear:both;"><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding: 8px 0 0 4px;">'+escapeHtml(lsgdJSON[i]['tenSp'])+'</span></div><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 7px;">SL: <span style="font-size:18px;color:black;font-weight:normal;">'+lsgdJSON[i]['SL']+' Cái</span></div><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 8px;">Thành Tiền: <span style="padding-top:7px;border:0;font-style:italic;font-size:18px;color:red;">'+curr.format(lsgdJSON[i]['TongTien'])+'</span></div></div>';
		/*	<div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding:8px 0 0 4px;">'+result[0]['tenSp']+'</span></div><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 7px;">SL: </span><div style="padding-top:7px;border:0;"><input style="width:70px;float:left;text-align:center" onchange="changeValue('+i+');" onkeyup="checkValueC('+i+');" type="number" min="0" max="'+soluong+'" value="'+sanPhamDH[i].soluong+'"></div></div><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 8px;">Thành Tiền: </span><div style="padding-top:7px;border:0;font-style:italic;font-size:18px;">'+curr.format(gia)+'</div></div>
*/
				}
				if(i!=lsgdJSON.length-1) if(lsgdJSON[i]['maDH']!=lsgdJSON[i+1]['maDH']) check=true;
				if(i==lsgdJSON.length-1) check=true;
				if(check) dh+='</div>';
		}
		document.getElementById("sp").innerHTML=dh;
		page("trang",pNum,null,pActive);
		}
	}
}
function xnDh(x,input, pActive){
	var check;
	if(input.checked==true) check=1;
	else check=0; 
	jq351.ajax({
		url: 'php/xuly.php?action=xnDH',
		async: false,
		type: 'POST',
		data: {madh:JSON.stringify(x),check:check},
		success: function(result){
			if(result==1) {
				alert('Xác nhận thành công');
				xlDhVance(pActive);
			}
			else {
				alert('Hủy xác nhận thành công');
				xlDhVance(pActive);
			}
		}
	});
}
function huyDh(x, pActive){
	if(confirm("Bạn có chắc chắn muốn xóa?")) {
	jq351.ajax({
		url: 'php/xuly.php?action=xoaDH',
		async: false,
		type: 'POST',
		data: {madh:JSON.stringify(x)},
		success: function(result){
			if(result==1) {
				alert('Hủy đơn đặt hàng thành công');
				xlDhVance(pActive);
			}
			else alert('Xóa thất bại! '+result);
		}
	});
	}
}
function xlDhVance(pActive){
	jq351(function(){
	var sDate = document.getElementById('startDate').value;
	var eDate = document.getElementById('endDate').value;
	var dh="",s="";
	var url = 'php/xuly.php?action=xulyDHVance'
	var brandOption = document.getElementById('DHVance').getElementsByTagName('select')[0].value;
	var priceOption = document.getElementById('DHVance').getElementsByTagName('select')[1].value;
	switch(brandOption){
		case "ALL":
			break;
		default:
			url += '&brandOption='+brandOption;
			break; 
	}
	switch(priceOption){
		case "0-2tr":
			url += '&startPrice=0&endPrice=2000000';
			break;
		case "2-4tr":
			url += '&startPrice=2000000&endPrice=4000000';
			break;
		case "4-6tr":
			url += '&startPrice=4000000&endPrice=6000000';
			break;
		case "6-8tr":
			url += '&startPrice=6000000&endPrice=8000000';
			break;
		case "8-12tr":
			url += '&startPrice=8000000&endPrice=12000000';
			break;
		case "12-20tr":
			url += '&startPrice=12000000&endPrice=20000000';
			break;
		case ">20tr":
			url += '&startPrice=20000000&endPrice=999999999';
			break;
		default: break;
	}
		jq351.ajax({
			url: url,
			type: 'POST',
			async: false,
			data:{pageActive:pActive,each:6,sDate:sDate,eDate:eDate},
			success: function(results){
				if(results!=-1){
					if(results!=0){
					var result = JSON.parse(results);
					var curr = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' });
					for(var i=0;i<result.length-1;i++){
				if(check){
					var ng=new moment(result[i]['Ngaykhoitao']).format('DD/MM/YYYY HH:mm:ss');
					dh+='<div id="'+i+'"><div class="acc" style="clear:both;"><span style="color:red;">Tên khách hàng: </span>'+escapeHtml(result[i]['Tên'])+'</div><div class="nggd" style="clear:both;"><span style="color:red;">Ngày giao dịch: </span>'+ng+'</div><div style="clear:both;"><span style="font-weight:bold;">Địa chỉ giao hàng: </span><span style="font-style:italic;">'+escapeHtml(result[i]['Địa chỉ'])+'</span></div><div style="clear:both;"><span style="font-weight:bold;">Số điện thoại: </span><span style="font-style:italic;">'+result[i]['số điện thoại']+'</span></div><div><span style="font-weight:bold;">TinhTrang: </span><span style="font-weight:bold;font-style:italic;color:#F60;">'+escapeHtml(result[i]['Tinhtrang'])+'</span></div><div id="dhcover">';
					check = false;
				}
				if(!check) {	
					dh+='<div class="donHang" style="clear:both;"><div class="col dh" style="width:20%;"><span style="font-size:15px;color:black;">'+result[i]['tenSp']+'</span></div><div class="col dh" style="width:20%;">SL: <span style="font-size:15px;color:black;">'+result[i]['SL']+' Cái</span></div><div class="col dh" style="width:20%;">Thành Tiền: <span style="font-size:15px;color:black;">'+curr.format(result[i]['Tổng tiền'])+'</span></div></div>';
				}
				if(i!=result.length-2) if(result[i]['maDH']!=result[i+1]['maDH']) check=true;
				if(i==result.length-2) check=true;
				if(check){
				dh+='</div><div class="tongDH" style="clear:both;">Tổng tiền đơn hàng: '+curr.format(result[i]['tongtien'])+'</div><label class="switch" style="float:left;clear:left;"><input class="xacnhan" type="checkbox" onclick="xnDh('+result[i]['maDH']+',this, '+pActive+');"style="clear:right;float:left;" ';
				if(result[i]['Tinhtrang']=='Đã xác nhận') dh+='checked><span class="slider round"></span></label>';
				else dh+='><span class="slider round"></span></label><button onclick="huyDh('+result[i]['maDH']+','+pActive+');" style="float:left;">Hủy Đơn Hàng</button>';
				}
		}
					document.getElementById("sp").innerHTML=dh;
					page("trang",result[result.length-1],"xlDhVance",pActive);
					}
					else {
						document.getElementById("sp").innerHTML='<div class="check">Không có đơn hàng trong khoảng thời gian này!</div>';
						document.getElementById("trang").innerHTML=s;
					}
				}
			}
		});
	});
}
function xlDh(pNum){
	if(pNum!=-1){
		var dh="",s="";
		if(pNum==0){
			document.getElementById("sp").innerHTML='<div class="check">Chưa có đơn đặt hàng!</div>';
			document.getElementById("trang").innerHTML=s;
		}
		else{
			var sDate = new moment(new Date()).subtract(1,'month').format('YYYY-MM-DD');
			var eDate = new moment(new Date()).format('YYYY-MM-DD');
			var opt ='<div id="DHVance"></div><input id="startDate" type="date" onchange="onchangeTkDH(1)" value="'+sDate+'"><input id="endDate" type="date" onchange="onchangeTkDH(1)" value="'+eDate+'">';
			document.getElementById("opt").innerHTML=opt;
			jq351(function(){xlDhVance(1);});
		}
	}
}
function thanhToan(){
	var url = 'php/xuly.php?action=isLogin&checkuser=0';
	jq351.ajax({
		url: url,
		async: false,
		success: function(answer) {
			switch (Number(answer)) {
				case 1:
					var sanPhamDH = JSON.parse(localStorage.getItem("sanPhamDH"));
					jq351.ajax({
						url: 'php/xuly.php?action=donhang',
						type: 'POST',
						async: false,
						data: {
							DH: JSON.stringify(sanPhamDH),
							date: new moment(new Date()).format('YYYY-MM-DD HH:mm:ss')
						},
						success: function (result) {
							if (Number(result) == 1) {
								localStorage.removeItem("sanPhamDH");
								Cart();
								customDialog('Thanh toán thành công');
							} else customDialog('Giao dịch thất bại! ' + result);
						}
					});
				break;
				case -1:
					customDialog('Vui lòng đăng nhập để thanh toán!');
				break;
				default: break;
			}
		}
	});
}
function delAll(){
	localStorage.removeItem("sanPhamDH");
	Cart();	
}
function delSpDH(x){
	var	sanPhamDH=JSON.parse(localStorage.getItem("sanPhamDH"));
	var input=document.getElementById("gh"+sanPhamDH[x].masp).getElementsByTagName("input");
	var value=input[0].value;
	if(sanPhamDH.length==1) localStorage.removeItem("sanPhamDH");
	else {
	delete sanPhamDH[x];
	for(var i=x;i<sanPhamDH.length;i++){
			sanPhamDH[i]=sanPhamDH[i+1];
	}
	sanPhamDH.length--;
	localStorage.setItem("sanPhamDH",JSON.stringify(sanPhamDH));
	}
	Cart();
}
function checkValueC(i){
	var sanPhamDH=JSON.parse(localStorage.getItem("sanPhamDH"));
	var masp = sanPhamDH[i].masp;
	var input=document.getElementById("gh"+masp).getElementsByTagName("input");
	var value=input[0].value;
	if(value<0) {
		alert("vui lòng nhập vào đúng số");
		input[0].value=1;
	}
	jq351.ajax({
		url: 'php/xuly.php?action=search',
		async: false,
		data: {masp:JSON.stringify(sanPhamDH[i].masp)},
		type: 'POST',
		success: function(results){
		var result = JSON.parse(results);
			if(Number(result[0]['SL'])<value) {
				customDialog("xin lỗi, bạn chỉ có thể mua hàng với SL cho phép!");
				input[0].value=sanPhamDH[i].soluong;
			}
		}
	});
}
function changeValue(i){
	var sanPhamDH=JSON.parse(localStorage.getItem("sanPhamDH"));
	var masp = sanPhamDH[i].masp;
	var input=document.getElementById("gh"+masp).getElementsByTagName("input");
	var value=input[0].value;
			jq351.ajax({
					url: 'php/xuly.php?action=search',
					async: false,
					data: {masp:JSON.stringify(sanPhamDH[i].masp)},
					type: 'POST',
					success: function(results){
					var result = JSON.parse(results);
				if(sanPhamDH[i].soluong<value) {
					sanPhamDH[i].soluong=Number(value);
					sanPhamDH[i].thanhtien=Number(value)*parseInt(result[0]['GiaCa']);
				}
				if(sanPhamDH[i].soluong>value) {
					sanPhamDH[i].soluong=Number(value);
					sanPhamDH[i].thanhtien=Number(value)*parseInt(result[0]['GiaCa']);
				}
					}
			});
	localStorage.setItem("sanPhamDH",JSON.stringify(sanPhamDH));
	Cart();
}
function Cart(){
	var url=location.href.split("?");
	if(url[1]=="gh") {
		var acc=JSON.parse(localStorage.getItem("acc"));
		var sanPhamDH=JSON.parse(localStorage.getItem("sanPhamDH"));
		var sp="",tong=0;
		if(sanPhamDH==null) {
			sp+='<div class="check">Giỏ hàng trống!vui lòng tiếp tục mua hàng</div>';
			document.getElementById("sp").innerHTML=sp;
		}
		else{
		var curr = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' });
		sp+='<div class="ghcover">';
		for(var i=0;i<sanPhamDH.length;i++) {
				jq351.ajax({
					url: 'php/xuly.php?action=search',
					async: false,
					data: {masp:JSON.stringify(sanPhamDH[i].masp)},
					type: 'POST',
					success: function(results) {
						if (results != 0) {
							var result = JSON.parse(results);
							var gia = Number(sanPhamDH[i].soluong) * parseInt(result[0]['GiaCa']);
							var soluong = Number(result[0]['SL']);
							tong += gia;
							sp += '<div id="gh' + sanPhamDH[i].masp + '" class="donHang" style="clear:left;"><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 8px;">' + result[0]['tenSp'] + '</span></div><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 7px;">SL: </span><div style="padding-top:7px;border:0;"><input style="width:70px;float:left;text-align:center" onchange="changeValue(' + i + ');" onkeyup="checkValueC(' + i + ');" type="number" min="0" max="' + soluong + '" value="' + sanPhamDH[i].soluong + '"></div></div><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 8px;">Thành Tiền: </span><div style="padding-top:7px;border:0;font-style:italic;font-size:18px;">' + curr.format(gia) + '</div></div><button style="float:left;height:40px;width:5%;font-size: 30px;border: 1px solid black;" class="del" onclick="delSpDH(' + i + ');">&times;</button></div>';
						}
					}
				});
		}
		var thanhtoan='</div><div style="clear:left;color:red;font-weight:bold;font-size:20px;">Tổng tiền: <span style="color:black;font-style:italic;">'+curr.format(tong)+' </span></div><button style="float:left;clear:left;border:1px solid black;border-radius:5px;padding:5px;" onclick="thanhToan();">Thanh Toán</button>';
		var delAll='<div><button style="border:1px solid black;border-radius:5px;padding:5px;" onclick="delAll();">Xóa đơn hàng</button></div>';
		document.getElementById("sp").innerHTML=delAll+sp+thanhtoan;
	}
	}
}
function addToCart(){
	var input=document.getElementById(this['maSP']).getElementsByTagName("input");
	var value=Number(input[0].value);
	var checkSL=false,check=false;
	var j=0;
	var sanPhamDH=JSON.parse(localStorage.getItem("sanPhamDH"));			
	if(sanPhamDH==null) {if(value<=this['SL']) {
		sanPhamDH=[new sanphamDH(this['maSP'],value,(Number(value)*parseInt(this['GiaCa'])))];
		checkSL=true;
		}
	}
	else {for(j=0;j<sanPhamDH.length;j++){
		if(sanPhamDH[j].masp==this['maSP']) {
			if(sanPhamDH[j].soluong+value<=this['SL']){
			sanPhamDH[j].soluong+=value;
			sanPhamDH[j].thanhtien=Number(sanPhamDH[j].soluong)*parseInt(this['GiaCa']);
			checkSL = true;
			}
			else check=true;
			break;
		}
	}
	if(j==sanPhamDH.length&&!check) if(value<=this['SL']) {
		sanPhamDH.push(new sanphamDH(this['maSP'],value,(Number(value)*parseInt(this['GiaCa']))));
		checkSL=true;
		}
	}
	if(checkSL) {
	localStorage.setItem("sanPhamDH",JSON.stringify(sanPhamDH));
	alert("thêm thành công");
	}
	else alert('Bạn đã thêm quá SL cho phép');
}
function checkValue(input){
	if(Number(input)<0) {
		alert("vui lòng nhập vào đúng số");
		input=1;
	}
	if(this["SL"]<Number(input)) {
		alert("xin lỗi, bạn chỉ có thể mua hàng với SL cho phép!");
		input=this['SL'];
	}
}
function logout(){
	jq351.ajax({
		url: 'php/xuly.php?action=logout',
		async:false,
		type: 'POST',
		success: function(){
			location.assign('/pttk/index.php');
		}
	});	
}
function check(){
	if(document.login.user.value=="") {
		alert("Nhập vào Tên đăng nhập");
		return false;	
	}
	if(document.login.pass.value==""){
		alert("Nhập vào mật khẩu");
		return false;
	}
}
function checkValid(){
	var check = true;
	var checkUser = true;
	var form=document.register;
	var div=form.getElementsByClassName("Valid");
	if(div[1].innerHTML=="Tên đăng nhập đã tồn tại") {
		check = false;
		checkUser = false;	
	}
	if(form.ht.value.length<6){			
			div[0].innerHTML="*Vui lòng nhập tối thiểu 6 ký tự";
			form.ht.focus();
			check = false;
	}
	else div[0].innerHTML="";		
	if(checkUser==true){
	if(form.user.value.length<5){
			div[1].innerHTML="*Vui lòng nhập tối thiểu 5 ký tự";
			form.user.focus();
			check = false;
	}	 
		else div[1].innerHTML="";
	}
	if(form.pass.value.length<5){
			div[2].innerHTML="*Vui lòng nhập tối thiểu 5 ký tự";
			form.pass.focus();
			check = false;
	}
	else div[2].innerHTML="";
	if(form.repass.value!=form.pass.value){
			div[3].innerHTML="*Mật khẩu không trùng khớp";
			form.repass.focus();
			check = false;
	}
	else div[3].inerHTML="";
	if(!checkEmail(form.email.value)) {
			div[4].innerHTML="*Vui lòng nhập vào đúng định dạng email";
			form.email.focus();
			check = false;
	}
	else div[4].innerHTML="";
	if(!checkNumber(form.sdt.value)){
			div[5].innerHTML="*Số điện thoại không hợp lệ";
			form.sdt.focus();
			check = false;
	}
	else div[5].innerHTML="";
	if(form.address.value.length<10){
			div[6].innerHTML="*Vui lòng nhập tối thiểu 10 ký tự";
			form.address.focus();
			check = false;
	}
	else div[6].innerHTML="";
	if(check==false) return false;
}
function checkUser(){
	var form=document.register;
	jq351.ajax({
		url: "php/xuly.php?action=checkUser",
		type: "POST",
		data: {username: JSON.stringify(form.user.value)},
		success: function(result){
			if(Number(result)==1) jq351(".Valid")[1].innerHTML="Tên đăng nhập đã tồn tại";
			else {
				if(jq351(".Valid")[1].innerHTML=="Tên đăng nhập đã tồn tại") jq351(".Valid")[1].innerHTML="";
			}
		}
	});		
}
function menu(){
	var s="";
	for(var i=0;i<this.length;i++){
		s+='<li><a style="text-decoration:none;width:100%;" href="?idBrand='+this[i]['maDM']+'&pageActive=1"><div class="theloai">'+this[i]['tenDM']+"</div></a></li>";
	}
	document.getElementById("m").innerHTML=s;
}
function showPageSP(sanPhamJSON,pActiveJSON,pNumJSON){
	var sp="";
	for(var i=0;i<sanPhamJSON.length;i++){
		var curr = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(sanPhamJSON[i]['GiaCa']);
		sp+='<div class="sanPham" style="text-align:center;" onclick=\'showCTSP.apply('+escapeHtml(JSON.stringify(sanPhamJSON[i]))+');\'><img src="'+sanPhamJSON[i]["HinhAnh"]+'" class="img"><span style="font-size:10px;font-weight:bold;">'+escapeHtml(sanPhamJSON[i]["tenSp"])+'</span><button style="text-align:center;width:100%;color:red;">'+curr+'</button></div>';		
	}
	document.getElementById("sp").innerHTML=sp;
	page("trang",pNumJSON,null,pActiveJSON);
}
function showCTSP(){	
	var modal = document.getElementById(this["maSP"]);
	if(modal!=null)
	modal.style.display='block';
	else {
		var mod='';
		var myModal=document.createElement('div');
		myModal.className='modal product';
		myModal.id=this["maSP"];
		mod+='<div class="modal-content modalsp"><div class="close" onclick="document.getElementById('+this["maSP"]+').style.display='+"'none'"+';">&times;</div><div class="tendt">Điện thoại '+escapeHtml(this["tenSp"])+'<hr></div>'+
		'<div class="details">'+
		'<div class="mota">Size: '+escapeHtml(this["Size"])+'<hr></div>'+
		'<div class="mota">Weight: '+escapeHtml(this["Weight"])+'<hr></div>'+
		'<div class="mota">Color: '+escapeHtml(this["Color"])+'<hr></div>'+
		'<div class="mota">BoNhoTrong: '+escapeHtml(this["BoNhoTrong"])+'<hr></div>'+
		'<div class="mota">Bộ nhớ đệm(Ram): '+escapeHtml(this["BoNho"])+'<hr></div>'+
		'<div class="mota">HDH: '+escapeHtml(this["HDH"])+'<hr></div>'+
		'<div class="mota">CamTruoc: '+escapeHtml(this["CamTruoc"])+'<hr></div>'+
		'<div class="mota">CamSau: '+escapeHtml(this["CamSau"])+'<hr></div>'+
		'<div class="mota">Dung lượng Pin: '+escapeHtml(this["Pin"])+'<hr></div>'+
		'<div class="mota">BaoHanh: '+escapeHtml(this["BaoHanh"])+'<hr></div>'+
		'<div class="mota">TinhTrang: '+escapeHtml(this["TinhTrang"])+'<hr></div>'+
		'</div><div style="height:70%;width:40%;float:right;"><img style="height:100%;width:100%;" src="'+this['HinhAnh']+'"></div><div style="height:15%;width:40%;float:right;"><div class="soLuong">SL: <input style="font-size:18px;width:30%;text-align:center;" type="number" onkeyup=\'checkValue.call('+escapeHtml(JSON.stringify(this))+',this.value);\' min="1" value="1" max="'+this["SL"]+'"/></div><div class="addToCart"><button class="btnthem" onclick=\'addToCart.call('+escapeHtml(JSON.stringify(this))+');\'><img style="height:25px;float:left;" src="image/shopping-cart-solid - Copy.png"><span style="font-size:14px;color:black;">Thêm vào giỏ hàng</span></button></div></div></div>';
		myModal.innerHTML=mod;
		document.getElementsByTagName('body')[0].appendChild(myModal);
	}
	if(modal==null) modal=myModal;
	window.addEventListener('click',function(event){
			if(event.target==modal){
				modal.style.display='none';
			}
	});
	checkSP(this["maSP"],this["SL"]);
}
function page(idPage,pageNum,functionCall,pActive){
	if(Number(pageNum)>1){
	 var pages = 5;
	 var lef=50,pa='';
	 if(functionCall!=null){
		if(pActive!=1){ 
			pa+='<button class="page" onClick="'+functionCall+'('+(pActive - 1)+');"><div>\<</div></button>';
			lef--;
		}
		if(pageNum <= pages) {
		for(var i=1;i<=pageNum;i++,lef--){
			if(i==pActive) pa+='<button class="page active" onClick="'+functionCall+'('+i+');"><div>'+i+"</div></button>";
			else pa+='<button class="page" onClick="'+functionCall+'('+i+');"><div>'+i+"</div></button>";
			}
	} else {
		var i = 0;
		var d = pages - 2;
		var last = 1;
		do {
			i++;
			last = pages + (i - 1)*d;
		} while(pActive >= last);
		var first = 1 + (i - 1)*d;
		for(var i=first;i<=last && i<=pageNum;i++,lef--){
			if(i==pActive) pa+='<button class="page active" onClick="'+functionCall+'('+i+');"><div>'+i+"</div></button>";
			else pa+='<button class="page" onClick="'+functionCall+'('+i+');"><div>'+i+"</div></button>";
		}
		lef-=2
	}
	if(pActive!=pageNum){
			pa+='<button class="page" onClick="'+functionCall+'('+(pActive + 1)+');"><div>\></div></button>';
			lef--;
		}
	} else{		
		var url1 = document.location.href.split('?')[1];
	 	if(url1!=null)	var url=url1.substring(0,url1.length-1);
		if(pActive!=1){
			lef--;
			pa+='<button class="page" onClick="document.location.href=\'?'+url+(pActive-1)+'\';"><div>\<</div></button>';
		}
		if(pageNum <= pages) {		
		for(var i=1;i<=pageNum;i++,lef--){
			if(i==pActive) pa+='<a class="page active"  href="?'+url+i+'"><div >'+i+"</div></a>";
			else pa+='<a class="page" href="?'+url+i+'"><div >'+i+"</div></a>"; 
		}
		} else {
			var i = 0;
			var d = pages - 2;
			var last = 1;
			do {
				i++;
				last = pages + (i - 1)*d;
			} while(pActive >= last);
			var first = 1 + (i - 1)*d;
			for(var i=first;i<=last && i<=pageNum;i++,lef--){
				if(i==pActive) pa+='<a class="page active"  href="?'+url+i+'"><div >'+i+"</div></a>";
				else pa+='<a class="page" href="?'+url+i+'"><div >'+i+"</div></a>"; 
			}
			lef-=2
		}
		if(pActive!=pageNum){
			lef--;
			pa+='<button class="page" onClick="document.location.href=\'?'+url+(pActive+1)+'\';"><div>\></div></button>';
		}
	}
			document.getElementById(idPage).style.marginLeft= lef+'%';
			document.getElementById(idPage).innerHTML=pa;
	}
}
function checkSP(masp,soluong){
	var div=document.getElementById(masp);
				if(soluong==0){
					var content=div.getElementsByClassName('modal-content');
					var button=div.getElementsByTagName('button');
					var soluong=div.getElementsByClassName('soLuong');
					if(button[0]!=null){					
					button[0].remove();
					soluong[0].remove();
					var node=document.createElement("div");
					node.setAttribute("class","check");
					node.innerHTML="Hết Hàng";
					node.style.color='red';
					content[0].appendChild(node);
					}
				}
}