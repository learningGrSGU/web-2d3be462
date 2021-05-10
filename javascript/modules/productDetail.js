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
                mod += '<div id="' + detail['maSP'] + '" class="modalsp"><div class="tendt">Điện thoại ' + escapeHtml(detail["tenSp"]) + '<hr></div>' +
                    '<div class="details">' +
                    '<div class="mota">Size: ' + escapeHtml(detail["Size"]) + '</div>' +
                    '<div class="mota">Weight: ' + escapeHtml(detail["Weight"]) + '</div>' +
                    '<div class="mota">Color: ' + escapeHtml(detail["Color"]) + '</div>' +
                    '<div class="mota">BoNhoTrong: ' + escapeHtml(detail["BoNhoTrong"]) + '</div>' +
                    '<div class="mota">Bộ nhớ đệm(Ram): ' + escapeHtml(detail["BoNho"]) + '</div>' +
                    '<div class="mota">HDH: ' + escapeHtml(detail["HDH"]) + '<hr></div>' +
                    '<div class="mota">CamTruoc: ' + escapeHtml(detail["CamTruoc"]) + '</div>' +
                    '<div class="mota">CamSau: ' + escapeHtml(detail["CamSau"]) + '</div>' +
                    '<div class="mota">Dung lượng Pin: ' + escapeHtml(detail["Pin"]) + '</div>' +
                    '<div class="mota">BaoHanh: ' + escapeHtml(detail["BaoHanh"]) + '</div>' +
                    '<div class="mota">TinhTrang: ' + escapeHtml(detail["TinhTrang"]) + '</div>' +
                    '</div>'+
                    '<div style="height:70%;width:40%;float:right;"><img style="height:100%;width:100%;" src="' + detail['HinhAnh'] + '"></div>' +
                    '<div style="height:15%;width:40%;float:right;"><div class="soLuong">SL: <input style="font-size:18px;width:30%;text-align:center;" type="number" onkeyup=\'checkValue.call(' + escapeHtml(JSON.stringify(detail)) + ',detail.value);\' min="1" value="1" max="' + detail["SL"] + '"/></div>' +
                    '<div class="addToCart"><button class="btnthem" onclick=\'addToCart.call(' + escapeHtml(JSON.stringify(detail)) + ');\'><img style="height:25px;float:left;" src="image/shopping-cart-solid - Copy.png"><span style="font-size:14px;color:black;">Thêm vào giỏ hàng</span></button></div></div>';
                // div chứa textbox bình luận và nút gửi bình luận
                mod += '<div><div style="width:90%;float:left;"><input style="padding:5px;width:100%;" type="text" id="chatBox" placeholder="Nhập bình luận tại đây..."/></div><div style="width:10%;float:left;"><button style="margin:5%;width:100%;" class="btnthem" id="submitBL" onclick="sendBL(' + detail['maSP'] + ');">Gửi</button></div></div>';

                // Phần hiển thị bình luận có trong database
                if (binhluan != null) for (let i = 0; i < binhluan.length; i++) {
                    let date = new moment(binhluan[i]['ThoiGianBL']).format('DD/MM/YYYY HH:mm:ss');
                    mod += '<div><div style="float:left;width:100%;">' + binhluan[i]['Hovaten'] + 'đã bình luận: <div style="float:left;padding:5px">' + binhluan[i]['ND'] + '</div></div><div style="float:right;">' + date + '</div></div>';
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
