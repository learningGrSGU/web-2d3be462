export function showCTSP() {
    jq351(function () {
        let check = /\?(productID=(\w+))(?!.)/g;
        let url = location.href.match(check);
        try {
            if (url) {
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
                mod += '<div id="' + detail['maSP'] + '" class="product-content modalsp"><div class="tendt">Điện thoại ' + escapeHtml(detail["tenSp"]) + '<hr></div>' +
                    '<div class="details">' +
                    '<div class="mota">Size: ' + escapeHtml(detail["Size"]) + '<hr></div>' +
                    '<div class="mota">Weight: ' + escapeHtml(detail["Weight"]) + '<hr></div>' +
                    '<div class="mota">Color: ' + escapeHtml(detail["Color"]) + '<hr></div>' +
                    '<div class="mota">BoNhoTrong: ' + escapeHtml(detail["BoNhoTrong"]) + '<hr></div>' +
                    '<div class="mota">Bộ nhớ đệm(Ram): ' + escapeHtml(detail["BoNho"]) + '<hr></div>' +
                    '<div class="mota">HDH: ' + escapeHtml(detail["HDH"]) + '<hr></div>' +
                    '<div class="mota">CamTruoc: ' + escapeHtml(detail["CamTruoc"]) + '<hr></div>' +
                    '<div class="mota">CamSau: ' + escapeHtml(detail["CamSau"]) + '<hr></div>' +
                    '<div class="mota">Dung lượng Pin: ' + escapeHtml(detail["Pin"]) + '<hr></div>' +
                    '<div class="mota">BaoHanh: ' + escapeHtml(detail["BaoHanh"]) + '<hr></div>' +
                    '<div class="mota">TinhTrang: ' + escapeHtml(detail["TinhTrang"]) + '<hr></div>' +
                    '</div><div style="height:70%;width:40%;float:right;"><img style="height:100%;width:100%;" src="' + detail['HinhAnh'] + '"></div>' +
                    '<div style="height:15%;width:40%;float:right;"><div class="soLuong">SL: <input style="font-size:18px;width:30%;text-align:center;" type="number" onkeyup=\'checkValue.call(' + escapeHtml(JSON.stringify(detail)) + ',detail.value);\' min="1" value="1" max="' + detail["SL"] + '"/></div>' +
                    '<div class="addToCart"><button class="btnthem" onclick=\'addToCart.call(' + escapeHtml(JSON.stringify(detail)) + ');\'><img style="height:25px;float:left;" src="image/shopping-cart-solid - Copy.png"><span style="font-size:14px;color:black;">Thêm vào giỏ hàng</span></button></div></div>';
                // div chứa textbox bình luận và nút gửi bình luận :)))
                mod += '<div><div><input type="text" id="chatBox" placeholder="Nhập bình luận tại đây!"/></div><div><button id="submitBL" onclick="sendBL(' + detail['maSP'] + ');">Gửi bình luận</button></div></div>';

                // Phần hiển thị bình luận có trong database :)))
                if (binhluan != null) for (let i = 0; i < binhluan.length; i++) {
                    let date = new moment(binhluan[i]['ThoiGianBL']).format('DD/MM/YYYY HH:mm:ss');
                    mod += '<div><div>' + binhluan[i]['Hovaten'] + '</div><div>' + binhluan[i]['ND'] + '</div><div>' + date + '</div></div>';
                }
                mod += '</div>';
                jq351('#sp').html(mod);
                checkSP(detail["maSP"], detail["SL"]);
                localStorage.removeItem("productDetail");
            }
        } catch (exception) {
            customDialog("Sản phẩm không tồn tại! " + exception);
        }
    });
}
