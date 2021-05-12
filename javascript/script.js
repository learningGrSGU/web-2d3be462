import * as prodDetailModule from './modules/productDetail.js';
import * as sortTableModule from './modules/SortedTable.js';

window.sortedTable = function (tag) {
    sortTableModule.sortedTable.call(this, tag);
}

window.checkPermission = function (permission) {
    let bool;
    jq351.ajax({
        url: 'php/xuly.php?action=checkPermission',
        type: 'POST',
        async: false,
        data: {permission: permission},
        success: function (result) {
            bool = (Number(result) == 1);
        }
    });
    return bool;
}

window.isCheckedPermission = function (permission) {
    let permissions = this.split(', ');
    let bool = false;
    permissions.forEach(function (item, index) {
        if (item == permission) {
            bool = true;
            return;
        }
    });
    return bool;
}

window.getPosition = function (e) {
    var posx = 0;
    var posy = 0;

    if (!e) var e = window.event;

    if (e.pageX || e.pageY) {
        posx = e.pageX;
        posy = e.pageY;
    } else if (e.clientX || e.clientY) {
        posx = e.clientX + document.body.scrollLeft +
            document.documentElement.scrollLeft;
        posy = e.clientY + document.body.scrollTop +
            document.documentElement.scrollTop;
    }

    return {
        x: posx,
        y: posy
    }
}

window.escapeContext = function (event) {
    const menu = document.getElementById("menu_" + this.id);
    const call = document.getElementById(this.functionCalls + '_' + this.id);
    const position = getPosition(event);
    const x = position.x;
    const y = position.y;
    menu.style.top = `${y}px`;
    menu.style.left = `${x}px`;
    menu.style.display = 'block';
    const documentClickHandler = function (e) {
        const isClickedOutside = !menu.contains(e.target);
        if (isClickedOutside && !call.contains(e.target)) {
            menu.style.display = 'none';
            document.removeEventListener('click', documentClickHandler);
        }
    };
    document.addEventListener('click', documentClickHandler);
}

window.showCTSP = function () {
    if (this != null) {
        localStorage.setItem("productDetail", JSON.stringify(this));
        location.assign("?productID=" + this["maSP"]);
    } else {
        let check = /\?(productID=(\w+))(?!.)/g;
        let url = location.href;
        if (url.includes("productID=")) {
            if (url.match(check)) {
                if (localStorage.getItem("productDetail") != null) prodDetailModule.showCTSP();
                else {
                    let productID = url.substring(url.search(check), url.length).split("=")[1];
                    jq351.ajax({
                        url: "php/xuly.php?action=getDetail&productID=" + productID,
                        success: function (result) {
                            console.log(result);
                            if (Number(result) != -1) {
                                if (result == 0)
                                    customDialog("Sản phẩm không tồn tại!");
                                else {
                                    localStorage.setItem("productDetail", JSON.stringify(JSON.parse(result)[0]));
                                    prodDetailModule.showCTSP();
                                }
                            } else customDialog("Sản phẩm không tồn tại!");
                        }
                    });
                }
            } else customDialog("Sản phẩm không tồn tại!");
        }
    }
}

window.customDialog = function (msg, btnMsgs, icons, functionCalls, Arguments) {
    let dialog = document.createElement('div');
    dialog.id = "dialog";
    dialog.innerHTML = msg;
    let Default = "Tôi hiểu";
    let buttons = [];
    if (btnMsgs == null) {
        btnMsgs = Default;
        buttons =
            [{
                text: btnMsgs,
                icon: "ui-icon-check",
                click: function () {
                    $(this).dialog("close");
                }
            }];
    } else {
        for (let i = 0; i < btnMsgs.length; i++) {
            buttons.push({
                text: btnMsgs[i],
                icon: icons[i],
                click: function () {
                    functionCalls[i]().apply(Arguments[i]);
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

window.exportExcel = function (title, Headers, Data, filename, sheetname) {
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

window.exportPDF = function (id) {
    objectExporter({
        type: 'html',
        exportable: id
    });
}

window.format = function (data) {
    let formated = '#DDH' + window.btoa(data) + '$' + data;
    return formated;
}

window.decode = function (data) {
    let decode = data.replace(/(.+)(?=\$)\$/g, '');
    let code = data.replace("#DDH", "").replace(decode, "").replace("$", "");
    return (window.atob(code) == decode) ? Number(decode) : "";
}

window.upload = function (file, masp, toDo) {
    var form = new FormData();
    form.append('fileToUpload', file);
    jq351.ajax({
        url: 'php/xuly.php?action=uploadImg&masp=' + masp + '&do=' + toDo,
        type: 'POST',
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        data: form,
        success: function (result) {
            console.log(result);
            if (Number(result) == 1) alert('Đổi hình thành công!');
            else if (Number(result) == -1) alert('Không hỗ trợ định dạng này!');
            else if (Number(result) == 0) alert('Hình có Size quá lớn!');
            else if (Number(result) == -2) alert('Upload Hình thất bại');
            else alert('Vui lòng điền đầy đủ thông tin trước khi thêm hình!');
        }
    });
}

window.update = function (sp, toDo) {
    jq351.ajax({
        url: 'php/xuly.php?action=updateSP&do=' + toDo,
        type: 'POST',
        async: false,
        data: {sp: sp},
        success: function (result) {
            console.log(result);
            if (Number(result) == 1) alert('Sửa thành công');
            else alert('Sản phẩm đã tồn tại! ' + result);
        }
    });
}

window.isCurrency = function (str) {
    if (typeof str != "string") return false;
    let check = /(^(\d\.*)*\d(?: ₫)$)/gi;
    return str.match(check);
}

window.isNumeric = function (str) {
    if (typeof str != 'string') return false;
    return (!isNaN(parseFloat(str)) && !isNaN(str));
}

let isNumber = function (value) {
    return typeof value === 'number' && isFinite(value);
}

let isNumberObject = function (n) {
    return (Object.prototype.toString.apply(n) === '[object Number]');
}

let isCustomNumber = function (n) {
    return isNumber(n) || isNumberObject(n);
}

window.escapeHtml = function (text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };

    return text.replace(/[&<>"']/g, function (m) {
        return map[m];
    });
}

window.check_num = function (number) {
    var check = /^\d+$/g;
    return check.test(number);
}

window.checkEmail = function (email) {
    var check = /^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/i;
    return check.test(email);
}

window.checkNumber = function (number) {
    var check = /^(09|03|07|08|05)([0-9]{8})$/g;
    return check.test(number);
}

window.vanceOption = function (id, func) {
    jq351(function () {
        jq351.ajax({
            url: 'php/xuly.php?action=getTL',
            async: false,
            success: function (results) {
                console.log(results);
                var result = JSON.parse(results);
                var s = "<select onchange='" + func + "'>";
                for (var i = 0; i < result.length; i++) {
                    s += '<option value="' + escapeHtml(result[i]['maDM']) + '">' + escapeHtml(result[i]['tenDM']) + '</option>';
                }
                s += '<option value="ALL" selected>Tất cả</option></select>';
                var span = document.createElement('span');
                span.innerHTML = 'Chọn Thương Hiệu: ' + s;
                span.style = 'color:white;background-color:#333;';
                jq351(id).append(span);
            }
        });
        var s = '<select onchange=\'' + func + '\'><option value="none"></option><option value="0-2tr">0 - 2 triệu</option><option value="2-4tr">2 - 4 triệu</option><option value="4-6tr">4 - 6 triệu</option><option value="6-8tr">6 - 8 triệu</option><option value="8-12tr">8 - 12 triệu</option><option value="12-20tr">12 - 20 triệu</option><option value=">20tr">trên 20 triệu</option>';
        var span = document.createElement('span');
        span.style.marginLeft = '5px';
        span.innerHTML = 'Chọn Mức Giá: ' + s;
        span.style = "color:white;background-color:#333;";
        jq351(id).append(span);
    });
}

window.showErrorLogin = function (error) {
    if (Number(error) == 0) alert('Sai thông tin đăng nhập!');
    if (Number(error) == -1) alert('Tài khoản đã bị khóa do nhập sai quá nhiều lần');
}

window.sanphamDH = function (msp, sl, thanhtien) {
    this.masp = msp;
    this.soluong = sl;
    this.thanhtien = thanhtien;
}

window.onLoad = function () {
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

window.sendBL = function (masp) {
    let comment = jq351('#chatBox').val();
    if (comment != "") {
        jq351.ajax({
            url: "php/xuly.php?action=sendBL",
            data: {
                cmt: JSON.stringify(comment),
                masp: JSON.stringify(masp),
                datetime: new moment(new Date()).format('YYYY-MM-DD')
            },
            type: "POST",
            success: function (result) {
                if (Number(result) == 1) {
                    showCTSP();
                    customDialog("Gửi bình luận thành công");
                } else customDialog("Vui lòng đăng nhập để bình luận ");
            }
        });
    }
}

//-------------------------------------------------------------code function here-------------------------------------------------------------------//
window.isLogin = function (errorCode) {
    if (Number(errorCode) == 0) alert('Mật khẩu không hợp lệ');
}

window.Homead = function () {
    var url = location.href.split('/');
    if (url[url.length - 1] == 'admin.php') {
        if (checkPermission('thongke')) {
            var sDate = new moment(new Date()).subtract(5, 'year').format('YYYY-MM-DD');
            var eDate = new moment(new Date()).format('YYYY-MM-DD');
            var opt = '<input id="startDate" type="date" onchange="onchangeTkDH(1)" value="' + sDate + '"><input id="endDate" type="date" onchange="onchangeTkDH(1)" value="' + eDate + '">';
            document.getElementById("opt").innerHTML = opt;
            jq351(function () {
                onchangeTkDH(1);
            });
        } else jq351('#sp').html('<div class="check">Bạn không có quyền truy cập chức năng này</div>');
    }
}

window.Home = function () {
    var url = location.href.split('/');
    if (url[url.length - 1] == 'index.php' || url[url.length - 1] == 'user.php') {
        jq351.ajax({
            url: 'php/xuly.php?action=home',
            success: function (results) {
                console.log(results);
                if (Number(results) != -1) {
                    if (Number(results) != 0) {
                        var result = JSON.parse(results);
                        var sp = "";
                        for (var i = 0; i < result.length; i++) {
                            if (i % 4 == 0) sp += '<div class=\"row\">';
                            var curr = new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(result[i]['GiaCa']);
                            let rate = "";
                            let total = Number(result[i]['rate']);
                            for (let j = 1; j <= 5; j++) {
                                if (total >= 1) {
                                    rate += "<i class=\"fa fa-star\"></i>";
                                    total--;
                                } else if (total == 0.5) {
                                    rate += "<i class=\"fa fa-star-half-o\"></i>";
                                    total -= 0.5;
                                } else if (total == 0) rate += "<i class=\"fa fa-star-o\"></i>";
                                else rate += "<i class=\"fa fa-star-o\"></i>";
                            }
                            sp += '<div class="col-3 sanPham" onclick=\'showCTSP.apply(' + escapeHtml(JSON.stringify(result[i])) + ');\'><img src="' + result[i]["HinhAnh"] + '" class="img"><h4>' + escapeHtml(result[i]["tenSp"]) + '</h4><div class="rating">' + rate + '</div><p style="text-align:center;width:100%;color:#ff0000;">' + curr + '</p></div>';
                            if (i % 4 == 3) sp += '</div>';
                        }
                        document.getElementById("sp").innerHTML = sp;
                    } else {
                        document.getElementById("sp").innerHTML = '';
                    }
                }
            }
        });
    }
}

window.spmoi = function (pActive) {
    var url = location.href.split('?');
    if (url[1] == 'maymoi') {
        var sDate = new moment(new Date()).subtract(20, 'days').format('YYYY-MM-DD');
        var eDate = new moment(new Date()).format('YYYY-MM-DD');
        jq351.ajax({
            url: 'php/xuly.php?action=maymoi',
            data: {sDate: sDate, eDate: eDate},
            type: 'POST',
            success: function (results) {
                console.log(results);
                if (Number(results) != -1) {
                    if (Number(results) != 0) {
                        var result = JSON.parse(results);
                        var sp = "";
                        for (var i = 0; i < result.length; i++) {
                            if (i % 4 == 0) sp += '<div class=\"row\">';
                            var curr = new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(result[i]['GiaCa']);
                            let rate = "";
                            let total = Number(result[i]['rate']);
                            for (let j = 1; j <= 5; j++) {
                                if (total >= 1) {
                                    rate += "<i class=\"fa fa-star\"></i>";
                                    total--;
                                } else if (total == 0.5) {
                                    rate += "<i class=\"fa fa-star-half-o\"></i>";
                                    total -= 0.5;
                                } else if (total == 0) rate += "<i class=\"fa fa-star-o\"></i>";
                                else rate += "<i class=\"fa fa-star-o\"></i>";
                            }
                            sp += '<div class="col-3 sanPham" onclick=\'showCTSP.apply(' + escapeHtml(JSON.stringify(result[i])) + ');\'><img src="' + result[i]["HinhAnh"] + '" class="img"><h4>' + escapeHtml(result[i]["tenSp"]) + '</h4><div class="rating">' + rate + '</div><p style="text-align:center;width:100%;color:#ff0000;">' + curr + '</p></div>';
                            if (i % 4 == 3) sp += '</div>';
                        }
                        document.getElementById("sp").innerHTML = sp;
                    } else {
                        document.getElementById("sp").innerHTML = '';
                    }
                }
            }
        });
    }
}

window.Search = function (pActive) {
    var url = 'php/xuly.php?action=searchVance';
    var data = escapeHtml(jq351('#dataSearch').val());
    if (data != '') {
        var brandOption = document.getElementById('vance').getElementsByTagName('select')[0].value;
        var priceOption = document.getElementById('vance').getElementsByTagName('select')[1].value;
        switch (brandOption) {
            case "ALL":
                break;
            default:
                url += '&brandOption=' + brandOption;
                break;
        }
        switch (priceOption) {
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
            default:
                break;
        }
        jq351.ajax({
            url: url,
            async: false,
            data: {dataSearch: data, each: 5, pActive: pActive},
            type: 'POST',
            success: function (results) {
                console.log(results);
                if (results != -1) {
                    if (Number(results) != 0) {
                        var result = JSON.parse(results);
                        var sp = "";
                        for (var i = 0; i < result.length - 1; i++) {
                            if (i % 4 == 0) sp += '<div class=\"row\">';
                            var curr = new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(result[i]['GiaCa']);
                            let rate = "";
                            let total = Number(result[i]['rate']);
                            for (let j = 1; j <= 5; j++) {
                                if (total >= 1) {
                                    rate += "<i class=\"fa fa-star\"></i>";
                                    total--;
                                } else if (total == 0.5) {
                                    rate += "<i class=\"fa fa-star-half-o\"></i>";
                                    total -= 0.5;
                                } else if (total == 0) rate += "<i class=\"fa fa-star-o\"></i>";
                                else rate += "<i class=\"fa fa-star-o\"></i>";
                            }
                            sp += '<div class="col-3 sanPham" onclick=\'showCTSP.apply(' + escapeHtml(JSON.stringify(result[i])) + ');\'><img src="' + result[i]["HinhAnh"] + '" class="img"><h4>' + escapeHtml(result[i]["tenSp"]) + '</h4><div class="rating">' + rate + '</div><p style="text-align:center;width:100%;color:#ff0000;">' + curr + '</p></div>';
                            if (i % 4 == 3) sp += '</div>';
                        }
                        jq351('#spSearch').html(sp);
                        page('tr', result[result.length - 1], 'Search', pActive);
                    } else {
                        jq351('#spSearch').html('');
                        jq351('#tr').html('');
                    }
                }
            }
        });
    } else {
        jq351('#spSearch').html('');
        jq351('#tr').html('');
    }
}

window.onchangeNCC = function (pActive) {

}

window.ncc = function () {
    var url = location.href.split('?');
    if (url[1] == 'ncc') {
        if (checkPermission('qlncc')) {

        } else jq351('#sp').html('<div class="check">Bạn không có quyền truy cập chức năng này</div>');
    }
}

window.delPermission = function (id, pActive) {
    if (confirm('Bạn có muốn xóa quyền này không?'))
        jq351.ajax({
            url: 'php/xuly.php?action=delPermission',
            data: {id: id},
            type: 'POST',
            success: function (result) {
                if (Number(result) == 1) customDialog('Xóa thành công');
                else customDialog('Đã tồn tại tài khoản sử dụng quyền này!');
            }
        });
    permission(pActive);
}

window.addNewPermission = function (pActive) {
    let permissions = [];
    let checkbox = document.getElementById('add-permission').getElementsByTagName('input');
    for (let i = 1; i < checkbox.length; i++) {
        if (checkbox[i].checked) {
            permissions.push(checkbox[i].value);
        }
    }
    let Chitiet = permissions.join(', ');
    if (checkbox[0].value != '') {
        jq351.ajax({
            url: 'php/xuly.php?action=addPermission',
            data: {permissions: Chitiet, name: checkbox[0].value},
            type: 'POST',
            async: false,
            success: function (result) {
                if (Number(result) == 1) {
                    customDialog('Cập nhật thành công');
                    document.getElementById('add-permission').style.display = 'none';
                    permission(pActive);
                } else {
                    console.log(result);
                    customDialog('Phát sinh lỗi trong quá trình cập nhật!');
                }
            }
        });
    } else customDialog('Vui lòng nhập tên quyền!');
}

window.addPermission = function () {
    var modal = document.getElementById('add-permission');
    if (modal == null) {
        var mod = '';
        var myModal = document.createElement('div');
        myModal.className = 'modal';
        myModal.id = 'add-permission';
        mod += '<div class="modal-content" style="width:100%;height:90%;"><div class="container" style="padding:0 20px 10px 20px;line-height:0.3;">' +
            '<div>Tên quyền: <input type="text" placeholder="Nhập tên quyền"></div>'
        mod += '<div class="input-checkbox"><input value="qlsanpham" type="checkbox" ';
        mod += '/> Quản lý sản phẩm</div>';
        mod += '<div class="input-checkbox"><input value="thongke" type="checkbox" ';
        mod += '/> Thống kê</div>';
        mod += '<div class="input-checkbox"><input value="qldonhang" type="checkbox" ';
        mod += '/> Quản lý đơn hàng</div>';
        mod += '<div class="input-checkbox"><input value="qlncc" type="checkbox" ';
        mod += '/> Quản lý nhà cung cấp</div>';
        mod += '<div class="input-checkbox"><input value="qltaikhoan" type="checkbox" ';
        mod += '/> Quản lý tài khoản</div>';
        mod += '<div class="input-checkbox"><input value="nhaphang" type="checkbox" ';
        mod += '/> Nhập hàng</div>';
        mod += '<div class="input-checkbox"><input value="qlquyen" type="checkbox" ';
        mod += '/> Quản lý quyền</div>';
        mod += '<div><button onclick="addNewPermission(' + this + ')">Thêm quyền</button></div></div>'
        myModal.innerHTML = mod;
        document.getElementsByTagName('body')[0].appendChild(myModal);
        modal = myModal;
    }
    modal.style.display = 'block';
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}

window.updatePermission = function (id, pActive) {
    let permissions = [];
    let checkbox = document.getElementById('detail-permission-' + id).getElementsByTagName('input');
    for (let i = 0; i < checkbox.length; i++) {
        if (checkbox[i].checked) {
            permissions.push(checkbox[i].value);
        }
    }
    let Chitiet = permissions.join(', ');
    jq351.ajax({
        url: 'php/xuly.php?action=updatePermission',
        data: {permissions: Chitiet, id: id},
        type: 'POST',
        async: false,
        success: function (result) {
            if (Number(result) == 1) {
                customDialog('Cập nhật thành công');
                permission(pActive);
            } else {
                console.log(result);
                customDialog('Phát sinh lỗi trong quá trình cập nhật!');
            }
        }
    });
}

window.showPermission = function () {
    var modal = document.getElementById('detail-permission-' + this.result['RoleID']);
    if (modal == null) {
        var mod = '';
        var myModal = document.createElement('div');
        myModal.className = 'modal';
        myModal.id = 'detail-permission-' + this.result['RoleID'];
        mod += '<div class="modal-content" style="width:100%;height:90%;"><div class="container" style="padding:0 20px 10px 20px;line-height:0.3;">'
        mod += '<div class="input-checkbox"><input value="qlsanpham" type="checkbox" ';
        if (isCheckedPermission.call(this.result['ChiTiet'], 'qlsanpham')) mod += 'checked="true"';
        mod += '/> Quản lý sản phẩm</div>';
        mod += '<div class="input-checkbox"><input value="thongke" type="checkbox" ';
        if (isCheckedPermission.call(this.result['ChiTiet'], 'thongke')) mod += 'checked="true"';
        mod += '/> Thống kê</div>';
        mod += '<div class="input-checkbox"><input value="qldonhang" type="checkbox" ';
        if (isCheckedPermission.call(this.result['ChiTiet'], 'qldonhang')) mod += 'checked="true"';
        mod += '/> Quản lý đơn hàng</div>';
        mod += '<div class="input-checkbox"><input value="qlncc" type="checkbox" ';
        if (isCheckedPermission.call(this.result['ChiTiet'], 'qlncc')) mod += 'checked="true"';
        mod += '/> Quản lý nhà cung cấp</div>';
        mod += '<div class="input-checkbox"><input value="qltaikhoan" type="checkbox" ';
        if (isCheckedPermission.call(this.result['ChiTiet'], 'qltaikhoan')) mod += 'checked="true"';
        mod += '/> Quản lý tài khoản</div>';
        mod += '<div class="input-checkbox"><input value="nhaphang" type="checkbox" ';
        if (isCheckedPermission.call(this.result['ChiTiet'], 'nhaphang')) mod += 'checked="true"';
        mod += '/> Nhập hàng</div>';
        mod += '<div class="input-checkbox"><input value="qlquyen" type="checkbox" ';
        if (isCheckedPermission.call(this.result['ChiTiet'], 'qlquyen')) mod += 'checked="true"';
        mod += '/> Quản lý quyền</div>';
        mod += '<div><button onclick="updatePermission(\'' + this.result['RoleID'] + '\', ' + this.pActive + ')">Cập nhật quyền</button></div></div>'
        myModal.innerHTML = mod;
        document.getElementsByTagName('body')[0].appendChild(myModal);
        modal = myModal;
    }
    modal.style.display = 'block';
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}

window.permissionManage = function (event, visible) {
    if (!visible) {
        let context_menu = '<ul id="menu_' + this.id + '" class="menu">' +
            '<li class="menu-item" onclick="delPermission(' + escapeHtml(JSON.stringify(this.result['RoleID'])) + ', ' + this.pActive + ')">Xóa Quyền</li>' +
            '<li class="menu-item" onclick="showPermission.call(' + escapeHtml(JSON.stringify(this)) + ')">Xem chi tiết</li>' +
            '<li class="menu-item" onclick="addPermission.call(' + this.pActive + ')">Thêm quyền mới</li>';
        context_menu += '</ul>';
        jq351('#sp').append(context_menu);
    } else {
        escapeContext.call(this, event);
    }
}

window.permission = function (pActive) {
    var url = location.href.split('?');
    if (url[1] == 'quyen') {
        if (checkPermission('qlquyen')) {
            jq351.ajax({
                url: 'php/xuly.php?action=qlquyen&pActive=' + pActive,
                success: function (results) {
                    if (Number(results) != 0) {
                        let result = JSON.parse(results);
                        let pages = result[result.length - 1];
                        result.length -= 1;
                        let toSortObject = {
                            id: "#sp",
                            headers: ["Mã quyền", "Tên quyền"],
                            result: result,
                            colToSort: "RoleID",
                            alias: ["RoleID", "tenQuyen"],
                            type: ["number", "string"],
                            functions: [permissionManage],
                            functionCalls: ['permissionManage'],
                            buttonName: ['...'],
                            pages: pages,
                            toPage: "permission",
                            pActive: pActive
                        };
                        sortedTable.apply(toSortObject, [null]);
                    } else {
                        jq351('#sp').html('<div class="check">Không tìm thấy quyền nào!</div>');
                        jq351('#trang').html('');
                    }
                }
            });
        } else jq351('#sp').html('<div class="check">Bạn không có quyền truy cập chức năng này</div>');
    }
}

window.grantPermission = function (user, pActive) {
    let select = document.getElementById('choose-permission-' + user).getElementsByTagName('select');
    jq351.ajax({
        url: 'php/xuly.php?action=grantPermission',
        data: {maUser: user, role: select[0].value},
        type: 'POST',
        async: false,
        success: function (result) {
            if (Number(result) == 1) {
                customDialog('Cấp quyền thành công');
                document.getElementById('choose-permission-' + user).style.display = 'none';
                qltk(pActive);
            } else {
                console.log(result);
                customDialog('Phát sinh lỗi trong quá trình cập nhật!');
            }
        }
    });
}

window.phanquyen = function (id, pActive, user) {
    var modal = document.getElementById('choose-permission-' + user);
    if (modal == null) {
        var mod = '';
        var myModal = document.createElement('div');
        myModal.className = 'modal';
        myModal.id = 'choose-permission-' + user;
        mod += '<div class="modal-content" style="width:100%;height:90%;"><div class="container" style="padding:0 20px 10px 20px;line-height:0.3;">'
        jq351.ajax({
            url: 'php/xuly.php?action=getPermission',
            async: false,
            success: function (result) {
                let results = JSON.parse(result);
                mod += '<select>';
                for (let i = 0; i < results.length; i++) {
                    if (results[i]['RoleID'] == id) mod += '<option value="' + results[i]['RoleID'] + '" selected>' + results[i]['tenQuyen'] + '</option>';
                    else mod += '<option value="' + results[i]['RoleID'] + '">' + results[i]['tenQuyen'] + '</option>';
                }
                mod += '</select>';
            }
        });
        mod += '<div><button onclick="grantPermission(\'' + user + '\', ' + pActive + ')">Cấp quyền</button></div></div>'
        myModal.innerHTML = mod;
        document.getElementsByTagName('body')[0].appendChild(myModal);
        modal = myModal;
    }
    modal.style.display = 'block';
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}

window.del = function (x, pActive) {
    if (confirm('Bạn có muốn xóa tài khoản này không?'))
        jq351.ajax({
            url: 'php/xuly.php?action=del',
            data: {user: x},
            type: 'POST',
            success: function (result) {
                if (Number(result) == 1) customDialog('Xóa thành công');
                else customDialog('Đã tồn tại đơn hàng có tài khoản này!');
            }
        });
    qltk(pActive);
}

window.Unlock_lock = function (x, l, pActive) {
    jq351.ajax({
        url: 'php/xuly.php?action=unlock_lock',
        data: {user: x, do: l},
        type: 'POST',
        success: function (result) {
            if (Number(result) == 1) alert('Mở khóa thành công');
            else if (Number(result) == 0) alert('Khóa thành công');
            else console.log(result);
        }
    });
    qltk(pActive);
}

window.accountManage = function (event, visible) {
    if (!visible) {
        let context_menu = '<ul id="menu_' + this.id + '" class="menu">' +
            '<li class="menu-item" onclick="del(' + escapeHtml(JSON.stringify(this.result['maUser'])) + ', ' + this.pActive + ')">Xóa tài khoản</li>';
        if (this.result['lock/unlock'] == 1) context_menu += '<li class="menu-item" onclick="Unlock_lock(' + escapeHtml(JSON.stringify(this.result['TK'])) + ', 0, ' + this.pActive + ')">Khóa tài khoản</li>';
        else context_menu += '<li class="menu-item" onclick="Unlock_lock(' + escapeHtml(JSON.stringify(this.result['TK'])) + ', 1, ' + this.pActive + ')">Mở khóa tài khoản</li>';
        if (this.result['RoleID'] != null) context_menu += '<li class="menu-item" onclick="phanquyen(\'' + this.result['RoleID'] + '\', ' + this.pActive + ', \'' + this.result['maUser'] + '\')">Phân quyền</li>';
        context_menu += '</ul>';
        jq351('#sp').append(context_menu);
    } else {
        escapeContext.call(this, event);
    }
}

window.qltk = function (pActive) {
    var url = location.href.split('?');
    if (url[1] == 'qltk') {
        if (checkPermission('qltaikhoan')) {
            jq351(function () {
                jq351('#opt').html('<button class="btn" onclick="document.getElementById(\'id02\').style.display=\'block\';">Thêm tài khoản mới</button>');
                jq351.ajax({
                    url: 'php/xuly.php?action=qltk&pActive=' + pActive,
                    success: function (results) {
                        if (Number(results) != 0) {
                            let result = JSON.parse(results);
                            let pages = result[result.length - 1];
                            result.length -= 1;
                            let toSortObject = {
                                id: "#sp",
                                headers: ["Tên Đăng Nhập", "Họ và Tên", "Địa chỉ", "Email", "Số điện thoại"],
                                result: result,
                                colToSort: "TK",
                                alias: ["TK", "TenUser", "Diachi", "Email", "Sdt"],
                                type: ["string", "string", "string", "string", "number"],
                                functions: [accountManage],
                                functionCalls: ['accountManage'],
                                buttonName: ['...'],
                                pages: pages,
                                toPage: "qltk",
                                pActive: pActive
                            };
                            sortedTable.apply(toSortObject, [null]);
                            //sortedAccount(results, "TK", pActive, null);
                        } else {
                            jq351('#sp').html('<div class="check">Hiện chưa có tài khoản nào!</div>');
                            jq351('#trang').html('');
                        }
                    }
                });
            });
        } else jq351('#sp').html('<div class="check">Bạn không có quyền truy cập chức năng này</div>');
    }
}
/*
window.sortedAccount = function (results, colToSort, pActive, tag) {
    let result = JSON.parse(results);
    result.sort(function (a, b) {
        if (a[colToSort] > b[colToSort]) return 1;
        else if (a[colToSort] < b[colToSort]) return -1;
        else return 0;
    });
    if (tag == null) {
        page('trang', result[result.length - 1], 'qltk', pActive);
        result.length = result.length - 1;
        var accs = "";
        accs += '<div id="qltkcover"><div class="row"><div class="th qltk">STT</div><div class="th qltk" onclick=\'sortedAccount(' + JSON.stringify(JSON.stringify(result)) + ', "TK", ' + pActive + ' , this)\'>Tên Đăng Nhập</div><div class="th qltk" onclick=\'sortedAccount(' + JSON.stringify(JSON.stringify(result)) + ', "TenUser", ' + pActive + ' , this)\'>Họ và Tên</div><div class="th qltk" onclick=\'sortedAccount(' + JSON.stringify(JSON.stringify(result)) + ', "Diachi", ' + pActive + ' , this)\'>Địa chỉ</div><div class="th qltk" onclick=\'sortedAccount(' + JSON.stringify(JSON.stringify(result)) + ', "Email", ' + pActive + ' , this)\'>Email</div><div class="th qltk" onclick=\'sortedAccount(' + JSON.stringify(JSON.stringify(result)) + ', "Sdt", ' + pActive + ', this)\'>Số điện thoại</div><div class="th qltks">chức năng</div></div>';
        for (var i = 0; i < result.length; i++) {
            if (result[i]['lock/unlock'] == 1) {
                accs += '<div class="row" id="' + i + '"><div class="col qltk">' + i + '</div><div class="col qltk">' + escapeHtml(result[i]['TK']) + '</div><div class="col">' + escapeHtml(result[i]['TenUser']) + '</div><div class="col">' + result[i]['Diachi'] + '</div><div class="col qltk">' + escapeHtml(result[i]['Email']) + '</div><div class="col qltk">' + result[i]['Sdt'] + '</div><div class="col qltks"><button class="delacc" onclick="del(' + escapeHtml(JSON.stringify(result[i]['maUser'])) + ', ' + pActive + ');">Xóa tài khoản</button><button class="lockacc" onclick="Unlock_lock(' + escapeHtml(JSON.stringify(result[i]['TK'])) + ',0, ' + pActive + ');">Khóa tài khoản</button></div></div>';
            } else {
                accs += '<div class="row" id="' + i + '"><div class="col qltk">' + i + '</div><div class="col qltk">' + escapeHtml(result[i]['TK']) + '</div><div class="col qltk">' + escapeHtml(result[i]['TenUser']) + '</div><div class="col qltk">' + result[i]['Diachi'] + '</div><div class="col qltk">' + escapeHtml(result[i]['Email']) + '</div><div class="col qltk">' + result[i]['Sdt'] + '</div><div class="col qltks"><button class="delacc" onclick="del(' + escapeHtml(JSON.stringify(result[i]['maUser'])) + ', ' + pActive + ');">Xóa tài khoản</button><button class="lockacc" onclick="Unlock_lock(' + escapeHtml(JSON.stringify(result[i]['TK'])) + ',1, ' + pActive + ');">Mở khóa tài khoản</button></div></div>';
            }
        }
        accs += '</div>';
        jq351('#sp').html(accs);
    }
    if (tag != null) {
        switch (tag.className) {
            case "th qltk asc":
                result.reverse();
                tag.className = "th qltk dsc";
                break;
            case "th qltk dsc":
                tag.className = "th qltk asc";
                break;
            default:
                tag.className = "th qltk asc";
                break;
        }
        var removalElement = $(".row");
        for (let i = 1; i < removalElement.length; i++)
            removalElement[i].remove();
        var accs = "";
        for (var i = 0; i < result.length; i++) {
            if (result[i]['lock/unlock'] == 1) {
                accs += '<div class="row" id="' + i + '"><div class="col qltk">' + i + '</div><div class="col qltk">' + escapeHtml(result[i]['TK']) + '</div><div class="col">' + escapeHtml(result[i]['TenUser']) + '</div><div class="col">' + result[i]['Diachi'] + '</div><div class="col qltk">' + escapeHtml(result[i]['Email']) + '</div><div class="col qltk">' + result[i]['Sdt'] + '</div><div class="col qltks"><button class="delacc" onclick="del(' + escapeHtml(JSON.stringify(result[i]['maUser'])) + ', ' + pActive + ');">Xóa tài khoản</button><button class="lockacc" onclick="Unlock_lock(' + escapeHtml(JSON.stringify(result[i]['TK'])) + ',0, ' + pActive + ');">Khóa tài khoản</button></div></div>';
            } else {
                accs += '<div class="row" id="' + i + '"><div class="col qltk">' + i + '</div><div class="col qltk">' + escapeHtml(result[i]['TK']) + '</div><div class="col qltk">' + escapeHtml(result[i]['TenUser']) + '</div><div class="col qltk">' + result[i]['Diachi'] + '</div><div class="col qltk">' + escapeHtml(result[i]['Email']) + '</div><div class="col qltk">' + result[i]['Sdt'] + '</div><div class="col qltks"><button class="delacc" onclick="del(' + escapeHtml(JSON.stringify(result[i]['maUser'])) + ', ' + pActive + ');">Xóa tài khoản</button><button class="lockacc" onclick="Unlock_lock(' + escapeHtml(JSON.stringify(result[i]['TK'])) + ',1, ' + pActive + ');">Mở khóa tài khoản</button></div></div>';
            }
        }
        jq351('#qltkcover').append(accs);
    }
}
*/
window.ok = function (x, pActive) {
    var input = document.getElementById(x['maSP']).getElementsByTagName("input");
    var xacnhan = prompt("Nhập mật khẩu để xác nhận thay đổi!");
    if (xacnhan == "admin") {
        var check = false;
        if (x['tenSp'] != input[1].value) {
            jq351.ajax({
                url: 'php/xuly.php?action=checkSP',
                type: 'POST',
                async: false,
                data: {tensp: input[1].value},
                success: function (result) {
                    console.log(result);
                    if (result == 1) {
                        check = true;
                        alert('Tên sản phẩm đã tồn tại');
                    }
                }
            });
        }
        if (!check) {
            if (input[2].value >= 1000000000) alert('SL phải nhỏ hơn 1.000.000.000');
            if (input[3].value >= 1000000000) alert('Giá phải nhỏ hơn 1.000.000.000');
            if (input[1].value != '') x['tenSp'] = input[1].value;
            if (input[2].value != '' && check_num(input[2].value) && input[2].value < 1000000000) x['SL'] = input[2].value;
            if (input[3].value != '' && check_num(input[3].value) && input[3].value < 1000000000) x['GiaCa'] = input[3].value;
            if (input[4].value != '') {
                var chitiet = input[4].value.split(';');
                if (chitiet.length == 11) {
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
                } else alert('Vui lòng nhập đủ 11 chi tiết cách nhau bởi ";" trong chi tiết!');
            }
            if (input[5].value != '') x['maDM'] = input[5].value;
            if (input[6].value != '') x['tenDM'] = input[6].value;
            if (input[7].value != '') x['Mô tả'] = input[7].value;
            if (input[8].value != '') x['Ngày nhập hàng'] = new moment(input[8].value).format('YYYY-MM-DD HH:mm:ss');
            var sp = JSON.stringify(x);
            update(sp, 'update');
            if (input[0].files && input[0].files[0]) {
                upload(input[0].files[0], x['maSP'], 'update');
            }
            productList(pActive);
        }
    } else alert("mật khẩu sai vui lòng nhập lại!");
}

window.delSp = function (x, pActive) {
    if (confirm("Bạn có chắc chắn muốn xóa?")) {
        jq351.ajax({
            url: 'php/xuly.php?action=delSp',
            type: 'POST',
            async: false,
            data: {masp: x},
            success: function (result) {
                if (result == 1) alert('Xóa thành công');
                else alert('Xóa thất bại! ' + result);
            }
        });
        productList(pActive);
    }
}

window.changeSp = function (x, pActive) {
    var input = document.getElementById(x['maSP']).getElementsByTagName("div");
    input[0].innerHTML = '<input type="file" accept="image/*">';
    input[2].innerHTML = '<input type="text" value=\'' + escapeHtml(x['tenSp']) + '\'>';
    input[3].innerHTML = '<input type="number" value=\'' + x['SL'] + '\'>';
    input[4].innerHTML = '<input type="number" value=\'' + x['GiaCa'] + '\'>';
    input[5].innerHTML = '<input type="text" value=\'' + escapeHtml(x['Size']) + ';' + escapeHtml(x['Weight']) + ';' + escapeHtml(x['Color']) + ';' + escapeHtml(x['BoNhoTrong']) + ';' + escapeHtml(x['BoNho']) + ';' + escapeHtml(x['HDH']) + ';' + escapeHtml(x['CamTruoc']) + ';' + escapeHtml(x['CamSau']) + ';' + escapeHtml(x['Pin']) + ';' + escapeHtml(x['BaoHanh']) + ';' + escapeHtml(x['TinhTrang']) + '\'>';
    input[6].innerHTML = '<input type="text" value=\'' + escapeHtml(x['maDM']) + '\'>';
    input[7].innerHTML = '<input type="text" value=\'' + escapeHtml(x['tenDM']) + '\'>';
    input[9].innerHTML = '<input type="text" value=\'' + escapeHtml(x['Mô tả']) + '\'>';
    input[10].innerHTML = '<input type="date" value="' + x['Ngày nhập hàng'] + '">';
    input[11].innerHTML = '<button class="DP" onclick=\'ok(' + escapeHtml(JSON.stringify(x)) + ', ' + pActive + ');\'>OK</button><button class="DP" onclick="productList(' + pActive + ');">Hủy</button>';
    var but = document.getElementById("sp").getElementsByTagName("button");
    for (var t = 0; t < but.length; t++) but[t].style.width = "100%";
}

window.addSp = function (x) {
    var input = document.getElementById(x).getElementsByTagName("input");
    var check = 1;
    for (var i = 1; i < input.length; i++) {
        if (input[i].value == "") {
            alert("vui lòng nhập vào đầy đủ thông tin!");
            check = 0;
            break;
        }
    }
    if (check == 1) {
        var xacnhan = prompt("Nhập mật khẩu để xác nhận thay đổi!");
        if (xacnhan == "admin") {
            if (check_num(input[1].value) && check_num(input[3].value) && check_num(input[4].value) && check_num(input[8].value)) {
                if (input[5].value.split(';').length == 11) {
                    if (input[1].value < 1000000000 && input[3].value < 1000000000 && input[4].value < 1000000000 && input[8].value < 1000000000) {
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
                        if (input[0].files && input[0].files[0]) {
                            upload(input[0].files[0], input[1].value, 'update');
                        }
                        productList(1);
                    } else alert('maSP, SL, Đơn giá, Mã chi tiết phải nhỏ hơn 1.000.000.000');
                } else alert('Vui lòng nhập đủ 11 chi tiết cách nhau bởi ";" trong chi tiết!');
            } else alert('maSP, SL, Đơn giá, Mã chi tiết phải là số nguyên!');
        } else alert("mật khẩu sai vui lòng nhập lại!");
    }
}

window.showAddSp = function () {
    
}
window.productDetail = function (x, pActive) {
var modal = document.getElementById('detail-product-' + x['maSP']);
    if (modal == null) {
        var mod = '';
        var myModal = document.createElement('div');
        myModal.className = 'modal product';
        myModal.id = 'detail-product-' + x['maSP'];
        mod += '<div class="modal-content" style="width:90%;height:95%;margin:1% 5%;"><div class="container" style="padding:0 20px 10px 20px;line-height:0.3;">' +
                '<h1>Thông Tin Chi Tiết Của Sản Phẩm</h1>' +
                '<hr>' +
                '<div class="ctleft">'+
                '<div class="update-sp"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Mã sản phẩm:</div> <input style="width:60%;text-align:center;" class="ipt-ctsp" disabled type="text" value="'+ x['maSP'] +'"></div>' +
                '<div class="update-sp1"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Tên điện thoại:</div> <input style="width:60%;text-align:center;" type="text" value="'+x['tenSp']+'"></div>'+
                '<div class="update-sp"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Thể Loại</div> <input style="width:60%;text-align:center;" type="text" disabled value="'+x['maDM']+'"></div>'+
                '<div class="update-sp1"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Kích Thước</div> <input style="width:60%;text-align:center;" type="text" value="'+x['Size']+'"></div>'+
                '<div class="update-sp"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Trọng Lượng:</div> <input style="width:60%;text-align:center;" type="text" value="'+x['Weight']+'"></div>'+
                '<div class="update-sp1"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Màu sắc:</div> <input style="width:60%;text-align:center;" type="text" value="'+x['Color']+'"></div>'+
                '<div class="update-sp"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Bộ Nhớ Trong:</div> <input style="width:60%;text-align:center;" type="text" value="'+x['BoNhoTrong']+'"></div>'+
                '<div class="update-sp1"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Bộ Nhớ Đệm:</div> <input style="width:60%;text-align:center;" type="text" value="'+x['BoNho']+'"></div>'+
                '<div class="update-sp"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Hệ điều hành:</div> <input style="width:60%;text-align:center;" type="text" value="'+x['HDH']+'"></div>'+
                '<div class="update-sp1"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Cam Trước:</div> <input style="width:60%;text-align:center;" type="text" value="'+x['CamTruoc']+'"></div>'+
                '<div class="update-sp"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Cam Sau:</div> <input style="width:60%;text-align:center;" type="text" value="'+x['CamSau']+'"></div>'+                
                '</div>'+
                '<div class="ctright" style="text-align:center;">'+
                '<div class="update-sp1"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Dung Lượng Pin:</div> <input style="width:60%;text-align:center;" type="text" value="'+x['Pin']+'"></div>'+
                '<div class="update-sp"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Bảo Hành:</div> <input style="width:60%;text-align:center;" type="text" value="'+x['BaoHanh']+'"></div>'+
                '<div class="update-sp1"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Tình Trạng Máy:</div> <input style="width:60%;text-align:center;" type="text" value="'+x['TinhTrang']+'"></div>'+
                '<div class="update-sp"><div style="width:30%;float:left;padding:8px 15px;margin:17px;">Số Lượng:</div> <input style="width:60%;text-align:center;" disabled type="text" value="'+x['SL']+'"></div>'+
                '<div class="update-sp1"><img src="' + x['HinhAnh'] + '"><input type="file"></div>'+
                '</div>'+
                '<div style="clear:left;text-align:center;">'+
                '<button style="background-color:#333;" class="btn">Cập Nhập Thông tin</button>'+
                '</div>'+
                '</div>';
                mod += '</div></div>';
                /*'<div id="' + detail['maSP'] + '" class="modalsp"><div class="tendt">' + detail["tenSp"] + '</div>' +
                    '<div>' +
                    '<div class="details"><span style="font-size:20px;font-weight:bold;color:#404040;padding:15px">Cấu Hình</span>' +
                    '<div class="mota">Kích Cỡ: ' + detail["Size"] + '</div>' +
                    '<div class="mota1">Trọng Lượng: ' + detail["Weight"] + '</div>' +
                    '<div class="mota">Màu Sắc: ' + detail["Color"] + '</div>' +
                    '<div class="mota1">Bộ Nhớ Trong: ' + detail["BoNhoTrong"] + '</div>' +
                    '<div class="mota">Bộ nhớ đệm(Ram): ' + detail["BoNho"] + '</div>' +
                    '<div class="mota1">Hệ Điều Hành: ' + detail["HDH"] + '</div>' +
                    '<div class="mota">Cam Trước: ' + detail["CamTruoc"] + '</div>' +
                    '<div class="mota1">Cam Sau: ' + detail["CamSau"] + '</div>' +
                    '<div class="mota">Dung Lượng Pin: ' + detail["Pin"] + '</div>' +
                    '<div class="mota1">Bảo Hành: ' + detail["BaoHanh"] + '</div>' +
                    '<div class="mota">Tình Trạng Máy: ' + detail["TinhTrang"] + '</div>' +
                    '<div class="mota1 soLuong">Số Lượng: '+ detail["SL"]+'</div>' +
                    '</div>' +
                    '<div class="details1">' +
                    '<div style="height:100%;width:100%;"><img style="height:100%;width:100%;" src="' + detail['HinhAnh'] + '"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>'*/
        
        myModal.innerHTML = mod;
        document.getElementsByTagName('body')[0].appendChild(myModal);
        modal = myModal;
    }
    modal.style.display = 'block';
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}
window.productManage = function (event, visible) {
    if (!visible) {
        let context_menu = '<ul id="menu_' + this.id + '" class="menu">' +
            '<li class="menu-item" onclick="delSp(' + escapeHtml(JSON.stringify(this.result['maSP'])) + ', ' + this.pActive + ')">Xóa sản phẩm</li>';
        context_menu += '<li class="menu-item" onclick="productDetail(' + escapeHtml(JSON.stringify(this.result)) + ', ' + this.pActive + ')">Sửa Sản Phẩm</li>';
        context_menu += '</ul>';
        jq351('#sp').append(context_menu);
    } else {
        escapeContext.call(this, event);
    }
}

window.productList = function (pActive) {
    jq351(function () {
        document.addEventListener('keydown', function (ev) {
            if (ev.ctrlKey && ev.altKey && ev.key == 'n') {
                showAddSp();
            }
        });
        var sDate = document.getElementById('startDate').value;
        var eDate = document.getElementById('endDate').value;
        var url = 'php/xuly.php?action=productList';
        var data = escapeHtml(jq351('#productSearch').val());
        if (data != '') url += '&dataSearch=' + data;
        var brandOption = document.getElementById('PDvance').getElementsByTagName('select')[0].value;
        var priceOption = document.getElementById('PDvance').getElementsByTagName('select')[1].value;
        switch (brandOption) {
            case "ALL":
                break;
            default:
                url += '&brandOption=' + brandOption;
                break;
        }
        switch (priceOption) {
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
            default:
                break;
        }
        console.log(url);
        jq351.ajax({
            url: url,
            type: 'POST',
            async: false,
            data: {pageActive: pActive, each: 10, sDate: sDate, eDate: eDate},
            success: function (results) {
                console.log(results);
                if (Number(results) != -1) {
                    if (Number(results) != 0) {
                        let result = JSON.parse(results);
                        let pages = result[result.length - 1];
                        result.length -= 1;
                        let toSortObject = {
                            id: "#sp",
                            headers: ["Hình Ảnh", "Mã sản phẩm", "Tên sản phẩm", "Số lượng", "Đơn giá", "Tên thể loại", "Mô tả", "Ngày nhập hàng"],
                            result: result,
                            colToSort: "maSP",
                            alias: ["HinhAnh", "maSP", "tenSp", "SL", "GiaCa", "tenDM", "MoTa", "Ngày nhập hàng"],
                            type: ["img", "string", "string", "number", "currency", "string", "string", "date"],
                            functions: [productManage],
                            functionCalls: ['productManage'],
                            buttonName: ['...'],
                            pages: pages,
                            toPage: "productList",
                            pActive: pActive
                        };
                        sortedTable.call(toSortObject, null);
                        //sortedProduct(results, false, "maSP", pActive, null);
                    } else {
                        jq351('#sp').html('Không tìm thấy sản phẩm!');
                        jq351('#trang').html('');
                    }
                }
            }
        });
    });
}
/*
window.sortedProduct = function (results, isDate, colToSort, pActive, tag) {
    var result = JSON.parse(results);
    result.sort(function (a, b) {
        if (isNumeric(a[colToSort]) || isCurrency(a[colToSort])) return Number(a[colToSort]) - Number(b[colToSort]);
        if (a[colToSort] > b[colToSort]) return 1;
        if (a[colToSort] < b[colToSort]) return -1;
        else return 0;
    });
    if (tag == null) {
        page("trang", result[result.length - 1], "productList", pActive);
        result.length = result.length - 1;
        var curr = new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'});
        var sp = '<div class="row"><div class="th">Hình Ảnh</div><div class="th" onclick=\'sortedProduct(' + JSON.stringify(JSON.stringify(result)) + ', false, "maSP", ' + pActive + ', this);\'>Mã sản phẩm</div><div class="th" onclick=\'sortedProduct(' + JSON.stringify(JSON.stringify(result)) + ', false, "tenSp", ' + pActive + ', this);\'>Tên sản phẩm</div><div class="th" onclick=\'sortedProduct(' + JSON.stringify(JSON.stringify(result)) + ', false, "SL", ' + pActive + ', this);\'>SL</div><div class="th" onclick=\'sortedProduct(' + JSON.stringify(JSON.stringify(result)) + ', false, "GiaCa", ' + pActive + ', this);\'>Đơn giá</div><div class="th" onclick=\'sortedProduct(' + JSON.stringify(JSON.stringify(result)) + ', false, "maDM", ' + pActive + ', this);\'>Mã thể loại</div><div class="th" onclick=\'sortedProduct(' + JSON.stringify(JSON.stringify(result)) + ', false, "tenDM", ' + pActive + ', this);\'>Tên thể loại</div><div class="th" onclick=\'sortedProduct(' + JSON.stringify(JSON.stringify(result)) + ', false, "maCT", ' + pActive + ', this);\'>Mã chi tiết</div><div class="th" onclick=\'sortedProduct(' + JSON.stringify(JSON.stringify(result)) + ', false, "MoTa", ' + pActive + ', this);\'>Mô tả</div><div class="th" onclick=\'sortedProduct(' + JSON.stringify(JSON.stringify(result)) + ', true, "Ngày nhập hàng", ' + pActive + ', this);\'>Ngày nhập hàng</div><div class="th" style="width:10%;">Chức năng</div></div>',
            s = "";
        for (var i = 0; i < result.length; i++) {
            var ng = new moment(result[i]['Ngày nhập hàng']).format('DD/MM/YYYY HH:mm:ss');
            sp += '<div class="row" id="' + result[i]['maSP'] + '"><div class="col" ><img alt="image" width="70%" height="65px" title="' + escapeHtml(result[i]['tenSp']) + '" src="' + result[i]['HinhAnh'] + '"/></div><div class="col">' + result[i]['maSP'] + '</div><div class="col">' + escapeHtml(result[i]['tenSp']) + '</div><div class="col">' + result[i]['SL'] + '</div><div class="col">' + curr.format(result[i]['GiaCa']) + '</div><div class="col">' + escapeHtml(result[i]['maDM']) + '</div><div class="col">' + escapeHtml(result[i]['tenDM']) + '</div><div class="col">' + result[i]['maCT'] + '</div><div class="col">' + escapeHtml(result[i]['MoTa']) + '</div><div class="col">' + ng + '</div><div class="col" style="width:10%;"><button class="DP" onclick="delSp(' + result[i]['maSP'] + ', ' + pActive + ');">Xóa</button><button class="CP" onclick=\'changeSp(' + escapeHtml(JSON.stringify(result[i])) + ',' + pActive + ');\'>Sửa</button></div></div>';
        }
        var sanP = document.getElementById("sp");
        sanP.innerHTML = sp;
    }
    if (tag != null) {
        switch (tag.className) {
            case "th asc":
                result.reverse();
                tag.className = "th dsc";
                break;
            case "th dsc":
                tag.className = "th asc";
                break;
            default:
                tag.className = "th asc";
                break;
        }
        var removalElement = jq351(".row");
        for (let i = 1; i < removalElement.length; i++)
            removalElement[i].remove();
        var sp = "";
        for (let i = 0; i < result.length; i++) {
            var curr = new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'});
            var ng = new moment(result[i]['Ngày nhập hàng']).format('DD/MM/YYYY HH:mm:ss');
            sp += '<div class="row" id="' + result[i]['maSP'] + '"><div class="col" ><img alt="image" width="70%" height="65px" title="' + escapeHtml(result[i]['tenSp']) + '" src="' + result[i]['HinhAnh'] + '"/></div><div class="col">' + result[i]['maSP'] + '</div><div class="col">' + escapeHtml(result[i]['tenSp']) + '</div><div class="col">' + result[i]['SL'] + '</div><div class="col">' + curr.format(result[i]['GiaCa']) + '</div><div class="col">' + escapeHtml(result[i]['maDM']) + '</div><div class="col">' + escapeHtml(result[i]['tenDM']) + '</div><div class="col">' + result[i]['maCT'] + '</div><div class="col">' + escapeHtml(result[i]['MoTa']) + '</div><div class="col">' + ng + '</div><div class="col" style="width:10%;"><button class="DP" onclick="delSp(' + result[i]['maSP'] + ', ' + pActive + ');">Xóa</button><button class="CP" onclick=\'changeSp(' + escapeHtml(JSON.stringify(result[i])) + ',' + pActive + ');\'>Sửa</button></div></div>';
        }
        jq351('#sp').append(sp);
    }
    let but = document.getElementById("sp").getElementsByTagName("button");
    for (var t = 0; t < but.length; t++) but[t].style.width = "100%";
}
*/
window.product = function () {
    var url = location.href.split("?");
    if (url[1] == "dssp") {
        if (checkPermission('qlsanpham')) {
            var sDate = new moment(new Date()).subtract(1, 'month').format('YYYY-MM-DD');
            var eDate = new moment(new Date()).format('YYYY-MM-DD');
            document.getElementById('opt').innerHTML = '<input  id="productSearch" onKeyUp="productList(1);" type="text" placeholder="Nhập Mã sản phẩm hoặc Tên sản phẩm để tìm" name="search"><div id="PDvance"></div><input id="startDate" type="date" onchange="productList(1);" value="' + sDate + '"><input id="endDate" type="date" onchange="productList(1)" value="' + eDate + '">';
            jq351(function () {
                productList(1);
            });
        } else jq351('#sp').html('<div class="check">Bạn không có quyền truy cập chức năng này</div>');
    }
}
/*
window.onchangeTkDH = function (pActive) {
    jq351(function () {
        var dh = '';
        var tc = 0;
        var sDate = document.getElementById('startDate').value;
        var eDate = document.getElementById('endDate').value;
        var curr = new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'});
        var url = 'php/xuly.php?action=TKDH';
        var brandOption = document.getElementById('DHvance').getElementsByTagName('select')[0].value;
        var priceOption = document.getElementById('DHvance').getElementsByTagName('select')[1].value;
        switch (brandOption) {
            case "ALL":
                break;
            default:
                url += '&brandOption=' + brandOption;
                break;
        }
        switch (priceOption) {
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
            default:
                break;
        }
        jq351.ajax({
            url: url,
            type: 'POST',
            async: false,
            data: {pageActive: pActive, each: 6, sDate: sDate, eDate: eDate},
            success: function (results) {
                console.log(results);
                if (results != -1) {
                    if (results != 0) {
                        var result = JSON.parse(results);
                        var data = [];
                        var columns = ['tenSp', 'SL', 'Tổng tiền'];
                        var headers = [];
                        for (var k = 0; k < columns.length; k++) {
                            headers.push({
                                alias: columns[k],
                                name: columns[k],
                                flex: 1
                            });
                        }
                        for (var i = 0; i < result.length - 1; i++) {
                            if (check) {
                                var ng = new moment(result[i]['Ngaykhoitao']).format('DD/MM/YYYY HH:mm:ss');
                                dh += '<div id="' + i + '"><div class="acc" style="clear:both;"><span style="color:red;">Tên khách hàng: </span>' + escapeHtml(result[i]['Tên']) + '</div><div class="nggd" style="clear:both;"><span style="color:red;">Ngày giao dịch: </span>' + ng + '</div><div style="clear:both;"><span style="font-weight:bold;">Địa chỉ giao hàng: </span><span style="font-style:italic;">' + escapeHtml(result[i]['Địa chỉ']) + '</span></div><div style="clear:both;"><span style="font-weight:bold;">Số điện thoại: </span><span style="font-style:italic;">' + result[i]['Sdt'] + '</span></div><div><span style="font-weight:bold;">TinhTrang: </span><span style="font-weight:bold;font-style:italic;color:#F60;">' + escapeHtml(result[i]['Tinhtrang']) + '</span></div><div id="tkcover">';
                                check = false;
                            }
                            if (!check) {
                                dh += '<div class="donHang" style="clear:both;"><div class="col tk" style="width:20%;"><span style="font-size:15px;color:black;">' + escapeHtml(result[i]['tenSp']) + '</span></div><div class="col tk" style="width:20%;">SL: <span style="font-size:15px;color:black;">' + result[i]['SL'] + ' Cái</span></div><div class="col tk" style="width:20%;">Thành Tiền: <span style="font-size:15px;color:black;">' + curr.format(result[i]['Tổng tiền']) + '</span></div></div>';

                                var rowData = {};
                                for (var j = 0; j < columns.length; j++) {
                                    if (columns[j] == "Tổng tiền") rowData[columns[j]] = curr.format(result[i]['Tổng tiền']);
                                    else rowData[columns[j]] = result[i][columns[j]];
                                }
                                data.push(rowData);
                            }
                            if (i != result.length - 2) if (result[i]['maDH'] != result[i + 1]['maDH']) check = true;
                            if (i == result.length - 2) check = true;
                            if (check) {
                                dh += '</div><div class="tongDH" style="clear:both;">Tổng tiền đơn hàng: ' + curr.format(result[i]['tongtien']) + '</div>';
                                if (result[i]['Tinhtrang'] == 'Đã xác nhận') tc += Number(result[i]['tongtien']);
                            }
                        }
                        dh += '<div style="clear:both;font-size:20px;color:#8000ff;">Tổng doanh thu trên 1 trang: <span style="font-size:26px;color:black;">' + curr.format(tc) + '</span></div>';
                        if (document.getElementById('export') == null) {
                            var div = document.createElement('div');
                            div.id = 'export';
                            div.innerHTML = '<button onclick=\'exportExcel("Thống kê điện thoại đã bán được", ' + JSON.stringify(headers) + ', ' + escapeHtml(JSON.stringify(data)) + ', "Thống kê", "Thống kê theo khoảng thời gian")\'>Xuất Excel</button><button onclick="exportPDF(\'sp\')">Xuất PDF</button>';
                            document.getElementById("menu").insertBefore(div, document.getElementById('opt'));
                        }
                        document.getElementById("sp").innerHTML = dh;
                        page("trang", result[result.length - 1], "onchangeTkDH", pActive);
                    } else {
                        document.getElementById("sp").innerHTML = '<div class="check">Không có đơn hàng trong khoảng thời gian này!</div>';
                        document.getElementById("trang").innerHTML = "";
                        var expo = document.getElementById('export');
                        if (expo != null)
                            document.getElementById('menu').removeChild(expo);
                    }
                }
            }
        });
    });
}
*/
window.onchangeTkDH = function (pActive) {
    let sDate = document.getElementById('startDate').value;
    let eDate = document.getElementById('endDate').value;
    let url = 'php/xuly.php?action=TKDH';
    jq351.ajax({
        url: url,
        type: "POST",
        async: false,
        data: {sDate: sDate, eDate: eDate},
        success: function (result) {
            if (Number(result) != 0) {
                let results = JSON.parse(result);
                jq351('#sp').html('<div id="stockChartContainer" style="height: 400px; width: 100%;"></div>');
                var dataPoints = [];
                let dataPoints1 = [];
                let dataPoints2 = [];
                var stockChart = new CanvasJS.StockChart("stockChartContainer", {
                    exportEnabled: true,
                    title: {
                        text: "Sơ đồ thống kê doanh thu đơn hàng đã xét duyệt theo từng tháng",
                        fontFamily: "Itim",
                    },
                    subtitles: [{
                        text: "Tổng doanh thu các sản phẩm đã bán được",
                        fontFamily: "Segoe Script",
                        fontSize: 20
                    }],
                    charts: [{
                        axisX: {
                            crosshair: {
                                enabled: true,
                                snapToDataPoint: true,
                                valueFormatString: "MMM YYYY"
                            }
                        },
                        axisY: {
                            title: "Triệu đồng",
                            prefix: "",
                            suffix: "",
                            crosshair: {
                                enabled: true,
                                snapToDataPoint: true,
                                valueFormatString: "#,###.## triệu đồng",
                            }
                        },
                        data: [{
                            type: "line",
                            xValueFormatString: "MMM YYYY",
                            yValueFormatString: "#,###.## triệu đồng",
                            dataPoints: dataPoints
                        }]
                    }],
                    navigator: {
                        slider: {
                            minimum: new Date(sDate),
                            maximum: new Date(eDate)
                        }
                    }
                });
                let sale = 0;
                let checked = 0;
                let waiting = 0;
                for (let i = 0, startDate = new moment(results[0]['date']).set('date', 1); i < results.length; i++) {
                    let date = new moment(results[i]['date']);
                    if (Number(date.diff(startDate, 'months', true)) >= 1 || i == results.length - 1) {
                        let xDate = new moment(startDate);
                        xDate.add(1, 'month').subtract(1, 'day');
                        if (i == results.length - 1) {
                            if (results[i]['Tinhtrang'] == 'Đã xác nhận') {
                                sale += Number(results[i]['sale']);
                                checked++;
                            } else waiting++;
                        }
                        dataPoints.push({x: new Date(xDate.format('YYYY-MM-DD')), y: sale / 1000000})
                        dataPoints1.push({x: new Date(xDate.format('YYYY-MM-DD')), y: checked})
                        dataPoints2.push({x: new Date(xDate.format('YYYY-MM-DD')), y: waiting})
                        if (results[i]['Tinhtrang'] == 'Đã xác nhận') {
                            sale = Number(results[i]['sale']);
                            checked = 1;
                            waiting = 0;
                        } else if (results[i]['Tinhtrang'] == 'Đang chờ xử lý') {
                            sale = 0;
                            waiting = 1;
                            checked = 0;
                        }
                        startDate = new moment(results[i]['date']).set('date', 1);
                    } else {
                        if (results[i]['Tinhtrang'] == 'Đã xác nhận') {
                            sale += Number(results[i]['sale']);
                            checked++;
                        } else if (results[i]['Tinhtrang'] == 'Đang chờ xử lý') {
                            waiting++;
                        }
                    }
                }
                stockChart.render();
                jq351('#sp').append('<div id="stockChartColumn" style="height: 400px; width: 100%;"></div>');
                var chart = new CanvasJS.StockChart("stockChartColumn", {
                    exportEnabled: true,
                    animationEnabled: true,
                    title: {
                        text: "Thống kê số lượng đơn hàng theo từng tháng",
                        fontFamily: "Itim"
                    },
                    subtitles: [{
                        text: ""
                    }],
                    axisX: {
                        crosshair: {
                            enabled: true,
                            snapToDataPoint: true,
                            valueFormatString: "MMM YYYY"
                        }
                    },
                    charts: [{
                        axisX: {
                            crosshair: {
                                enabled: true,
                                snapToDataPoint: true,
                                valueFormatString: "MMM YYYY"
                            }
                        },
                        axisY: {
                            title: "Đơn hàng đã xác nhận - Đơn",
                            titleFontColor: "#4F81BC",
                            lineColor: "#4F81BC",
                            labelFontColor: "#4F81BC",
                            tickColor: "#4F81BC",
                            includeZero: true
                        },
                        axisY2: {
                            title: "Đơn hàng chờ xử lý - Đơn",
                            titleFontColor: "#C0504E",
                            lineColor: "#C0504E",
                            labelFontColor: "#C0504E",
                            tickColor: "#C0504E",
                            includeZero: true
                        },
                        toolTip: {
                            shared: true
                        },
                        legend: {
                            cursor: "pointer",
                            itemclick: toggleDataSeries
                        },
                        data: [{
                            type: "column",
                            name: "Đơn hàng đã xác nhận",
                            showInLegend: true,
                            xValueFormatString: "MMM YYYY",
                            yValueFormatString: "#,##0.# Đơn",
                            dataPoints: dataPoints1
                        },
                            {
                                type: "column",
                                name: "Đơn hàng chờ xử lý",
                                axisYType: "secondary",
                                showInLegend: true,
                                xValueFormatString: "MMM YYYY",
                                yValueFormatString: "#,##0.# Đơn",
                                dataPoints: dataPoints2
                            }]
                    }], navigator: {
                        slider: {
                            minimum: new Date(sDate),
                            maximum: new Date(eDate)
                        }
                    }
                });
                chart.render();

                function toggleDataSeries(e) {
                    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    } else {
                        e.dataSeries.visible = true;
                    }
                    e.chart.render();
                }
            } else {
                document.getElementById("sp").innerHTML = '<div class="check">Không có đơn hàng trong khoảng thời gian này!</div>';
            }
        }
    });
}
window.tkDH = function () {
    var url = location.href.split("?");
    if (url[1] == "tksp") {
        if (checkPermission('thongke')) {
            var sDate = new moment(new Date()).subtract(5, 'year').format('YYYY-MM-DD');
            var eDate = new moment(new Date()).format('YYYY-MM-DD');
            var opt = '<input id="startDate" type="date" onchange="onchangeTkDH(1)" value="' + sDate + '"><input id="endDate" type="date" onchange="onchangeTkDH(1)" value="' + eDate + '">';
            document.getElementById("opt").innerHTML = opt;
            jq351(function () {
                onchangeTkDH(1);
            });
        } else jq351('#sp').html('<div class="check">Bạn không có quyền truy cập chức năng này</div>');
    }
}

window.LsGd = function (lsgdJSON, pActive, pNum) {
    if (lsgdJSON != -1) {
        var dh = "", s = "";
        if (lsgdJSON == 0) {
            document.getElementById("sp").innerHTML = '<div class="check">Chưa có đơn đặt hàng!</div>';
            document.getElementById("trang").innerHTML = s;
        } else {
            var check = true;
            var curr = new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'});
            for (var i = 0, count = 1; i < lsgdJSON.length; i++) {
                if (check) {
                    var ng = new moment(lsgdJSON[i]['Ngaykhoitao']).format('DD/MM/YYYY HH:mm:ss');
                    dh += '<h3> Đơn hàng ' + format(lsgdJSON[i]['maDH']) + '</h3><div id="' + count + '"><div class="acc" style="clear:both;"><span style="color:red;">Tên khách hàng: </span>' + escapeHtml(lsgdJSON[i]['Hovaten']) + '</div><div class="nggd" style="clear:both;"><span style="color:red;">Ngày thanh toán: </span>' + ng + '</div><div style="clear:both;"><span style="font-weight:bold;">Địa chỉ giao hàng: </span><span style="font-style:italic;">' + escapeHtml(lsgdJSON[i]['Diachi']) + '</span></div><div style="clear:both;"><span style="font-weight:bold;">Số điện thoại: </span><span style="font-style:italic;">' + lsgdJSON[i]['Sdt'] + '</span></div><div><span style="font-weight:bold;">Tình trạng đơn hàng: </span><span style="font-weight:bold;font-style:italic;color:#F60;">' + escapeHtml(lsgdJSON[i]['Tinhtrang']) + '</span></div><div class="lsgdcover">';
                    check = false;
                    count++;
                }
                if (!check) {
                    dh += '<div class="donHang" style="clear:both;"><div class="col gh"><span onclick="location.assign(\'?productID=' + lsgdJSON[i]["maSP"] + '\');" style="cursor: pointer; font-size:20px;color:black;font-weight:bold;float: left;padding: 8px 0 0 4px;">' + escapeHtml(lsgdJSON[i]['tenSp']) + '</span></div><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 7px;">SL: <span style="font-size:18px;color:black;font-weight:normal;">' + lsgdJSON[i]['SL'] + ' Cái</span></div><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 8px;">Thành Tiền: <span style="padding-top:7px;border:0;font-style:italic;font-size:18px;color:red;">' + curr.format(lsgdJSON[i]['TongTien']) + '</span></div></div>';
                    /*	<div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding:8px 0 0 4px;">'+result[0]['tenSp']+'</span></div><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 7px;">SL: </span><div style="padding-top:7px;border:0;"><input style="width:70px;float:left;text-align:center" onchange="changeValue('+i+');" onkeyup="checkValueC('+i+');" type="number" min="0" max="'+soluong+'" value="'+sanPhamDH[i].soluong+'"></div></div><div class="col gh"><span style="font-size:20px;color:black;font-weight:bold;float: left;padding-top: 8px;">Thành Tiền: </span><div style="padding-top:7px;border:0;font-style:italic;font-size:18px;">'+curr.format(gia)+'</div></div>
*/
                }
                if (i != lsgdJSON.length - 1) if (lsgdJSON[i]['maDH'] != lsgdJSON[i + 1]['maDH']) check = true;
                if (i == lsgdJSON.length - 1) check = true;
                if (check) dh += '</div></div>';
            }
            document.getElementById("sp").innerHTML = dh;
            jq351(function () {
                $("#sp").accordion({
                    collapsible: true
                });
                $("#sp").accordion("refresh");
            });
            page("trang", pNum, null, pActive);
        }
    }
}

window.xnDh = function (x, input, pActive, id) {
    var check;
    if (input.checked == true) check = 1;
    else check = 0;
    jq351.ajax({
        url: 'php/xuly.php?action=xnDH',
        async: false,
        type: 'POST',
        data: {madh: JSON.stringify(x), check: check},
        success: function (result) {
            if (result == 1) {
                alert('Xác nhận thành công');
                xlDhVance(pActive, id);
            } else {
                alert('Hủy xác nhận thành công');
                xlDhVance(pActive, id);
            }
        }
    });
}

window.huyDh = function (x, pActive) {
    if (confirm("Bạn có chắc chắn muốn xóa?")) {
        jq351.ajax({
            url: 'php/xuly.php?action=xoaDH',
            async: false,
            type: 'POST',
            data: {madh: JSON.stringify(x)},
            success: function (result) {
                if (result == 1) {
                    alert('Hủy đơn đặt hàng thành công');
                    xlDhVance(pActive);
                } else alert('Xóa thất bại! ' + result);
            }
        });
    }
}

window.xlDhVance = function (pActive, id) {
    jq351(function () {
        var sDate = document.getElementById('startDate').value;
        var eDate = document.getElementById('endDate').value;
        var dh = "", s = "";
        var url = 'php/xuly.php?action=xulyDHVance'
        var data = decode(escapeHtml(jq351('#BillSearch').val()));
        if (jq351('#BillSearch').val() != '') url += '&dataSearch=' + data;
        var brandOption = document.getElementById('DHVance').getElementsByTagName('select')[0].value;
        var priceOption = document.getElementById('DHVance').getElementsByTagName('select')[1].value;
        switch (brandOption) {
            case "ALL":
                break;
            default:
                url += '&brandOption=' + brandOption;
                break;
        }
        switch (priceOption) {
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
            default:
                break;
        }
        jq351.ajax({
            url: url,
            type: 'POST',
            async: false,
            data: {pageActive: pActive, each: 6, sDate: sDate, eDate: eDate},
            success: function (results) {
                if (results != -1) {
                    if (results != 0) {
                        var result = JSON.parse(results);
                        var curr = new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'});
                        for (var i = 0, count = 1; i < result.length - 1; i++) {
                            if (check) {
                                var ng = new moment(result[i]['Ngaykhoitao']).format('DD/MM/YYYY HH:mm:ss');
                                dh += '<h3>Đơn hàng ' + format(result[i]['maDH']) + ' <button onclick="huyDh(' + result[i]['maDH'] + ',' + pActive + ');" style="float:left;">Hủy Đơn Hàng</button></h3><div id="' + count + '"><div class="acc" style="clear:both;"><span style="color:red;">Tên khách hàng: </span>' + escapeHtml(result[i]['Hovaten']) + '</div><div class="nggd" style="clear:both;"><span style="color:red;">Ngày giao dịch: </span>' + ng + '</div><div style="clear:both;"><span style="font-weight:bold;">Địa chỉ giao hàng: </span><span style="font-style:italic;">' + escapeHtml(result[i]['Diachi']) + '</span></div><div style="clear:both;"><span style="font-weight:bold;">Số điện thoại: </span><span style="font-style:italic;">' + result[i]['Sdt'] + '</span></div><div><span style="font-weight:bold;">Tình trạng: </span><span style="font-weight:bold;font-style:italic;color:#F60;">' + escapeHtml(result[i]['Tinhtrang']) + '</span></div><div class="dhcover">';
                                check = false;
                                count++;
                            }
                            if (!check) {
                                dh += '<div class="donHang" style="clear:both;"><div class="col dh" style="width:20%;"><span style="font-size:15px;color:black;">' + result[i]['tenSp'] + '</span></div><div class="col dh" style="width:20%;">SL: <span style="font-size:15px;color:black;">' + result[i]['SL'] + ' Cái</span></div><div class="col dh" style="width:20%;">Thành Tiền: <span style="font-size:15px;color:black;">' + curr.format(result[i]['TongTien']) + '</span></div></div>';
                            }
                            if (i != result.length - 2) if (result[i]['maDH'] != result[i + 1]['maDH']) check = true;
                            if (i == result.length - 2) check = true;
                            if (check) {
                                dh += '</div><div class="tongDH" style="clear:both;">Tổng tiền đơn hàng: ' + curr.format(result[i]['tongtien']) + '</div><label class="switch" style="float:left;clear:left;"><input class="xacnhan" type="checkbox" onclick="xnDh(' + result[i]['maDH'] + ',this, ' + pActive + ', ' + (count - 2) + ');"style="clear:right;float:left;" ';
                                if (result[i]['Tinhtrang'] == 'Đã xác nhận') dh += 'checked><span class="slider round"></span></label></div>';
                                else dh += '><span class="slider round"></span></label></div>';
                            }
                        }
                        document.getElementById("sp").innerHTML = dh;
                        jq351(function () {
                            $("#sp").accordion({
                                collapsible: true
                            });
                            $("#sp").accordion("refresh");
                            if (id != null) $("#sp").accordion("option", "active", id);
                        });
                        page("trang", result[result.length - 1], "xlDhVance", pActive);
                    } else {
                        document.getElementById("sp").innerHTML = '<div class="check">Không có đơn hàng trong khoảng thời gian này!</div>';
                        document.getElementById("trang").innerHTML = s;
                    }
                }
            }
        });
    });
}

window.xlDh = function (pNum) {
    if (pNum != -1) {
        if (checkPermission('qldonhang')) {
            var dh = "", s = "";
            if (pNum == 0) {
                document.getElementById("sp").innerHTML = '<div class="check">Chưa có đơn đặt hàng!</div>';
                document.getElementById("trang").innerHTML = s;
            } else {
                var sDate = new moment(new Date()).subtract(1, 'month').format('YYYY-MM-DD');
                var eDate = new moment(new Date()).format('YYYY-MM-DD');
                var opt = '<input  id="BillSearch" onKeyUp="xlDhVance(1);" type="text" placeholder="Nhập Mã đơn hàng để tìm" name="search"><div id="DHVance"></div><input id="startDate" type="date" onchange="onchangeTkDH(1)" value="' + sDate + '"><input id="endDate" type="date" onchange="onchangeTkDH(1)" value="' + eDate + '">';
                document.getElementById("opt").innerHTML = opt;
                jq351(function () {
                    xlDhVance(1);
                });
            }
        } else jq351('#sp').html('<div class="check">Bạn không có quyền truy cập chức năng này</div>');
    }
}

window.thanhToan = function () {
    var url = 'php/xuly.php?action=isLogin&checkuser=0';
    jq351.ajax({
        url: url,
        async: false,
        success: function (answer) {
            console.log(answer);
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
                default:
                    break;
            }
        }
    });
}

window.delAll = function () {
    localStorage.removeItem("sanPhamDH");
    Cart();
}

window.delSpDH = function (x) {
    var sanPhamDH = JSON.parse(localStorage.getItem("sanPhamDH"));
    var input = document.getElementById("gh" + sanPhamDH[x].masp).getElementsByTagName("input");
    var value = input[0].value;
    if (sanPhamDH.length == 1) localStorage.removeItem("sanPhamDH");
    else {
        delete sanPhamDH[x];
        for (var i = x; i < sanPhamDH.length; i++) {
            sanPhamDH[i] = sanPhamDH[i + 1];
        }
        sanPhamDH.length--;
        localStorage.setItem("sanPhamDH", JSON.stringify(sanPhamDH));
    }
    Cart();
}

window.checkValueC = function (i) {
    var sanPhamDH = JSON.parse(localStorage.getItem("sanPhamDH"));
    var masp = sanPhamDH[i].masp;
    var input = document.getElementById("gh" + masp).getElementsByTagName("input");
    var value = input[0].value;
    if (value < 0) {
        alert("vui lòng nhập vào đúng số");
        input[0].value = 1;
    }
    jq351.ajax({
        url: 'php/xuly.php?action=search',
        async: false,
        data: {masp: JSON.stringify(sanPhamDH[i].masp)},
        type: 'POST',
        success: function (results) {
            var result = JSON.parse(results);
            if (Number(result[0]['SL']) < value) {
                customDialog("xin lỗi, bạn chỉ có thể mua hàng với SL cho phép!");
                input[0].value = sanPhamDH[i].soluong;
            }
        }
    });
}

window.changeValue = function (i) {
    var sanPhamDH = JSON.parse(localStorage.getItem("sanPhamDH"));
    var masp = sanPhamDH[i].masp;
    var input = document.getElementById("gh" + masp).getElementsByTagName("input");
    var value = input[0].value;
    jq351.ajax({
        url: 'php/xuly.php?action=search',
        async: false,
        data: {masp: JSON.stringify(sanPhamDH[i].masp)},
        type: 'POST',
        success: function (results) {
            var result = JSON.parse(results);
            if (sanPhamDH[i].soluong < value) {
                sanPhamDH[i].soluong = Number(value);
                sanPhamDH[i].thanhtien = Number(value) * parseInt(result[0]['GiaCa']);
            }
            if (sanPhamDH[i].soluong > value) {
                sanPhamDH[i].soluong = Number(value);
                sanPhamDH[i].thanhtien = Number(value) * parseInt(result[0]['GiaCa']);
            }
        }
    });
    localStorage.setItem("sanPhamDH", JSON.stringify(sanPhamDH));
    Cart();
}

window.Cart = function () {
    var url = location.href.split("?");
    if (url[1] == "gh") {
        jq351('#none').hide();
        jq351('.categories').hide();
        var acc = JSON.parse(localStorage.getItem("acc"));
        var sanPhamDH = JSON.parse(localStorage.getItem("sanPhamDH"));
        var sp = "", tong = 0;
        if (sanPhamDH == null) {
            sp += '<div class="check">Giỏ hàng trống!vui lòng tiếp tục mua hàng</div>';
            document.getElementById("sp").innerHTML = sp;
        } else {
            var curr = new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'});
            sp += '<div class="ghcover">';
            for (var i = 0; i < sanPhamDH.length; i++) {
                jq351.ajax({
                    url: 'php/xuly.php?action=search',
                    async: false,
                    data: {masp: JSON.stringify(sanPhamDH[i].masp)},
                    type: 'POST',
                    success: function (results) {
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
            var thanhtoan = '</div><div style="clear:left;color:red;font-weight:bold;font-size:20px;">Tổng tiền: <span style="color:black;font-style:italic;">' + curr.format(tong) + ' </span></div><button style="float:left;clear:left;border:1px solid black;border-radius:5px;padding:5px;" onclick="thanhToan();">Thanh Toán</button>';
            var delAll = '<div><button style="border:1px solid black;border-radius:5px;padding:5px;" onclick="delAll();">Xóa đơn hàng</button></div>';
            document.getElementById("sp").innerHTML = delAll + sp + thanhtoan;
        }
    }
}

window.addToCart = function () {
    var input = document.getElementById(this['maSP']).getElementsByTagName("input");
    var value = Number(input[0].value);
    var checkSL = false, check = false;
    var j = 0;
    var sanPhamDH = JSON.parse(localStorage.getItem("sanPhamDH"));
    if (sanPhamDH == null) {
        if (value <= this['SL']) {
            sanPhamDH = [new sanphamDH(this['maSP'], value, (Number(value) * parseInt(this['GiaCa'])))];
            checkSL = true;
        }
    } else {
        for (j = 0; j < sanPhamDH.length; j++) {
            if (sanPhamDH[j].masp == this['maSP']) {
                if (sanPhamDH[j].soluong + value <= this['SL']) {
                    sanPhamDH[j].soluong += value;
                    sanPhamDH[j].thanhtien = Number(sanPhamDH[j].soluong) * parseInt(this['GiaCa']);
                    checkSL = true;
                } else check = true;
                break;
            }
        }
        if (j == sanPhamDH.length && !check) if (value <= this['SL']) {
            sanPhamDH.push(new sanphamDH(this['maSP'], value, (Number(value) * parseInt(this['GiaCa']))));
            checkSL = true;
        }
    }
    if (checkSL) {
        localStorage.setItem("sanPhamDH", JSON.stringify(sanPhamDH));
        alert("thêm thành công");
    } else alert('Bạn đã thêm quá SL cho phép');
}

window.checkValue = function (input) {
    if (Number(input) < 0) {
        alert("vui lòng nhập vào đúng số");
        input = 1;
    }
    if (this["SL"] < Number(input)) {
        alert("xin lỗi, bạn chỉ có thể mua hàng với SL cho phép!");
        input = this['SL'];
    }
}

window.logout = function () {
    jq351.ajax({
        url: 'php/xuly.php?action=logout',
        async: false,
        type: 'POST',
        success: function () {
            location.assign('/pttk/index.php');
        }
    });
}

window.check = function () {
    if (document.login.user.value == "") {
        alert("Nhập vào Tên đăng nhập");
        return false;
    }
    if (document.login.pass.value == "") {
        alert("Nhập vào mật khẩu");
        return false;
    }
}

window.checkValid = function () {
    var check = true;
    var checkUser = true;
    var form = document.register;
    var div = form.getElementsByClassName("Valid");
    if (div[1].innerHTML == "Tên đăng nhập đã tồn tại") {
        check = false;
        checkUser = false;
    }
    if (form.ht.value.length < 6) {
        div[0].innerHTML = "*Vui lòng nhập tối thiểu 6 ký tự";
        form.ht.focus();
        check = false;
    } else div[0].innerHTML = "";
    if (checkUser == true) {
        if (form.user.value.length < 5) {
            div[1].innerHTML = "*Vui lòng nhập tối thiểu 5 ký tự";
            form.user.focus();
            check = false;
        } else div[1].innerHTML = "";
    }
    if (form.pass.value.length < 5) {
        div[2].innerHTML = "*Vui lòng nhập tối thiểu 5 ký tự";
        form.pass.focus();
        check = false;
    } else div[2].innerHTML = "";
    if (form.repass.value != form.pass.value) {
        div[3].innerHTML = "*Mật khẩu không trùng khớp";
        form.repass.focus();
        check = false;
    } else div[3].inerHTML = "";
    if (!checkEmail(form.email.value)) {
        div[4].innerHTML = "*Vui lòng nhập vào đúng định dạng email";
        form.email.focus();
        check = false;
    } else div[4].innerHTML = "";
    if (!checkNumber(form.sdt.value)) {
        div[5].innerHTML = "*Số điện thoại không hợp lệ";
        form.sdt.focus();
        check = false;
    } else div[5].innerHTML = "";
    if (form.address.value.length < 10) {
        div[6].innerHTML = "*Vui lòng nhập tối thiểu 10 ký tự";
        form.address.focus();
        check = false;
    } else div[6].innerHTML = "";
    if (check == false) return false;
}

window.checkUser = function () {
    var form = document.register;
    jq351.ajax({
        url: "php/xuly.php?action=checkUser",
        type: "POST",
        data: {username: JSON.stringify(form.user.value)},
        success: function (result) {
            if (Number(result) == 1) jq351(".Valid")[1].innerHTML = "Tên đăng nhập đã tồn tại";
            else {
                if (jq351(".Valid")[1].innerHTML == "Tên đăng nhập đã tồn tại") jq351(".Valid")[1].innerHTML = "";
            }
        }
    });
}

window.menu = function () {
    var s = "";
    for (var i = 0; i < this.length; i++) {
        s += '<div class="col-4"><a href="?idBrand=' + this[i]['maDM'] + '&pageActive=1"><img src="' + this[i]['logo'] + '"></a></div>'
    }
    document.getElementById("m").innerHTML = s;
}

window.showPageSP = function (sanPhamJSON, pActiveJSON, pNumJSON) {
    var sp = "";
    for (var i = 0; i < sanPhamJSON.length; i++) {
        if (i % 4 == 0) sp += '<div class=\"row\">';
        var curr = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(sanPhamJSON[i]['GiaCa']);
        let rate = "";
        let total = Number(sanPhamJSON[i]['rate']);
        for (let j = 1; j <= 5; j++) {
            if (total >= 1) {
                rate += "<i class=\"fa fa-star\"></i>";
                total--;
            } else if (total == 0.5) {
                rate += "<i class=\"fa fa-star-half-o\"></i>";
                total -= 0.5;
            } else if (total == 0) rate += "<i class=\"fa fa-star-o\"></i>";
            else rate += "<i class=\"fa fa-star-o\"></i>";
        }
        sp += '<div class="col-3 sanPham" onclick=\'showCTSP.apply(' + escapeHtml(JSON.stringify(sanPhamJSON[i])) + ');\'><img src="' + sanPhamJSON[i]["HinhAnh"] + '" class="img"><h4>' + escapeHtml(sanPhamJSON[i]["tenSp"]) + '</h4><div class="rating">' + rate + '</div><p style="text-align:center;width:100%;color:#ff0000;">' + curr + '</p></div>';
        if (i % 4 == 3) sp += '</div>';
    }
    document.getElementById("sp").innerHTML = sp;
    page("trang", pNumJSON, null, pActiveJSON);
}


window.page = function (idPage, pageNum, functionCall, pActive) {
    if (Number(pageNum) > 1) {
        var pages = 5;
        var lef = 50, pa = '';
        if (functionCall != null) {
            if (pActive != 1) {
                pa += '<button class="page" onClick="' + functionCall + '(' + (pActive - 1) + ');"><div>\<</div></button>';
                lef--;
            }
            if (pageNum <= pages) {
                for (var i = 1; i <= pageNum; i++, lef--) {
                    if (i == pActive) pa += '<button class="page active" onClick="' + functionCall + '(' + i + ');"><div>' + i + "</div></button>";
                    else pa += '<button class="page" onClick="' + functionCall + '(' + i + ');"><div>' + i + "</div></button>";
                }
            } else {
                var i = 0;
                var d = pages - 2;
                var last = 1;
                do {
                    i++;
                    last = pages + (i - 1) * d;
                } while (pActive >= last);
                var first = 1 + (i - 1) * d;
                for (var i = first; i <= last && i <= pageNum; i++, lef--) {
                    if (i == pActive) pa += '<button class="page active" onClick="' + functionCall + '(' + i + ');"><div>' + i + "</div></button>";
                    else pa += '<button class="page" onClick="' + functionCall + '(' + i + ');"><div>' + i + "</div></button>";
                }
                lef -= 2
            }
            if (pActive != pageNum) {
                pa += '<button class="page" onClick="' + functionCall + '(' + (pActive + 1) + ');"><div>\></div></button>';
                lef--;
            }
        } else {
            var url1 = document.location.href.split('?')[1];
            if (url1 != null) var url = url1.substring(0, url1.length - 1);
            if (pActive != 1) {
                lef--;
                pa += '<button class="page" onClick="document.location.href=\'?' + url + (pActive - 1) + '\';"><div>\<</div></button>';
            }
            if (pageNum <= pages) {
                for (var i = 1; i <= pageNum; i++, lef--) {
                    if (i == pActive) pa += '<a class="page active"  href="?' + url + i + '"><div >' + i + "</div></a>";
                    else pa += '<a class="page" href="?' + url + i + '"><div >' + i + "</div></a>";
                }
            } else {
                var i = 0;
                var d = pages - 2;
                var last = 1;
                do {
                    i++;
                    last = pages + (i - 1) * d;
                } while (pActive >= last);
                var first = 1 + (i - 1) * d;
                for (var i = first; i <= last && i <= pageNum; i++, lef--) {
                    if (i == pActive) pa += '<a class="page active"  href="?' + url + i + '"><div >' + i + "</div></a>";
                    else pa += '<a class="page" href="?' + url + i + '"><div >' + i + "</div></a>";
                }
                lef -= 2
            }
            if (pActive != pageNum) {
                lef--;
                pa += '<button class="page" onClick="document.location.href=\'?' + url + (pActive + 1) + '\';"><div>\></div></button>';
            }
        }
        document.getElementById(idPage).style.marginLeft = lef + '%';
        document.getElementById(idPage).innerHTML = pa;
    }
}

window.checkSP = function (masp, soluong) {
    var div = document.getElementById(masp);
    if (soluong == 0) {
        var button = div.getElementsByTagName('button');
        var soluong = div.getElementsByClassName('soLuong');
        if (button[0] != null) {
            button[0].remove();
            soluong[0].remove();
            var node = document.createElement("div");
            node.setAttribute("class", "check");
            node.innerHTML = "Hết Hàng";
            node.style.color = 'red';
            div.appendChild(node);
        }
    }
}