export function showCTSP() {
    jq351(function () {
        let check = /\?(productID=(\w+))(?!.)/g;
        let url = location.href.match(check);
        try {
            if (url) {
                jq351('#none').hide();
                jq351('.categories').hide();
                let detail = JSON.parse(localStorage.getItem("productDetail"));
                let binhluan;
                jq351.ajax({
                    url: "php/xuly.php?action=getBL",
                    async: false,
                    data: {masp: detail['maSP']},
                    type: "POST",
                    success: function (result) {
                        if (Number(result) != -1) {
                            if (Number(result) != 0) {
                                binhluan = JSON.parse(result);
                            }
                        }
                    }
                });
                var mod = '';
                mod += '<div id="' + detail['maSP'] + '" class="modalsp"><div class="tendt">' + escapeHtml(detail["tenSp"]) + '</div>' +
                    '<div>' +
                    '<div class="details"><span style="font-size:20px;font-weight:bold;color:#404040;padding:15px">Cấu Hình</span>' +
                    '<div class="mota1">Vote</div>' +
                    '<div class="mota">Kích Cỡ: ' + escapeHtml(detail["Size"]) + '</div>' +
                    '<div class="mota1">Trọng Lượng: ' + escapeHtml(detail["Weight"]) + '</div>' +
                    '<div class="mota">Màu Sắc: ' + escapeHtml(detail["Color"]) + '</div>' +
                    '<div class="mota1">Bộ Nhớ Trong: ' + escapeHtml(detail["BoNhoTrong"]) + '</div>' +
                    '<div class="mota">Bộ nhớ đệm(Ram): ' + escapeHtml(detail["BoNho"]) + '</div>' +
                    '<div class="mota1">Hệ Điều Hành: ' + escapeHtml(detail["HDH"]) + '</div>' +
                    '<div class="mota">Cam Trước: ' + escapeHtml(detail["CamTruoc"]) + '</div>' +
                    '<div class="mota1">Cam Sau: ' + escapeHtml(detail["CamSau"]) + '</div>' +
                    '<div class="mota">Dung Lượng Pin: ' + escapeHtml(detail["Pin"]) + '</div>' +
                    '<div class="mota1">Bảo Hành: ' + escapeHtml(detail["BaoHanh"]) + '</div>' +
                    '<div class="mota">Tình Trạng Máy: ' + escapeHtml(detail["TinhTrang"]) + '</div>' +
                    '<div class="mota1 soLuong">Số Lượng:<input style="font-size:16px;width:40%;text-align:center;margin-left:50px;" type="number" onkeyup=\'checkValue.call(' + escapeHtml(JSON.stringify(detail)) + ',detail.value);\' min="1" value="1" max="' + detail["SL"] + '"/></div>' +
                    '<div class="addToCart" style="margin-left:30%;"><button class="btnthem" onclick=\'addToCart.call(' + escapeHtml(JSON.stringify(detail)) + ');\'><img style="height:25px;float:left;" src="image/shopping-cart-solid - Copy.png"><span style="font-size:16px;color:white;">Thêm vào giỏ hàng</span></button></div>' +
                    '</div>' +
                    '<div class="details1">' +
                    '<div style="height:100%;width:100%;"><img style="height:100%;width:100%;" src="' + detail['HinhAnh'] + '"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                // div chứa textbox bình luận và nút gửi bình luận
                mod += '<div><div style="width:90%;float:left;"><input style="padding:5px;width:100%;" type="text" id="chatBox" placeholder="Nhập bình luận tại đây..."/></div><div style="width:10%;float:left;"><button style="margin:5%;width:100%;" class="btnthem" id="submitBL" onclick="sendBL(' + detail['maSP'] + ');">Gửi</button></div></div>';

                // Phần hiển thị bình luận có trong database
                if (binhluan != null) for (let i = 0; i < binhluan.length; i++) {
                    let date = new moment(binhluan[i]['ThoiGianBL']).format('DD/MM/YYYY HH:mm:ss');
                    mod += '<div><div class="cmt"><span style="padding:5px;color:#3333ff;">' + binhluan[i]['Hovaten'] + '</span><div style="padding:5px;margin-left:10px;">' + binhluan[i]['ND'] + '<div style="float:right;">' + date + '</div></div></div></div>';
                }
                mod += '</div>';
                jq351('#sp').html(mod);
                jq351('#chatBox').on('keyup', function (ev) {
                    if (ev.key == "Enter") sendBL(detail['maSP']);
                });
                checkSP(detail["maSP"], detail["SL"]);
                localStorage.removeItem("productDetail");
            } else customDialog("Sản phẩm không tồn tại!");
        } catch (exception) {
            customDialog("Sản phẩm đã hết hàng! ");
        }
    });
}
