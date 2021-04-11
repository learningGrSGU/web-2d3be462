export function showCTSP() {
    var modal = document.getElementById(this["maSP"]);
    if (modal != null)
        modal.style.display = 'block';
    else {
        var mod = '';
        var myModal = document.createElement('div');
        myModal.className = 'modal product';
        myModal.id = this["maSP"];
        mod += '<div class="modal-content modalsp"><div class="close" onclick="document.getElementById(' + this["maSP"] + ').style.display=' + "'none'" + ';">&times;</div><div class="tendt">Điện thoại ' + escapeHtml(this["tenSp"]) + '<hr></div>' +
            '<div class="details">' +
            '<div class="mota">Size: ' + escapeHtml(this["Size"]) + '<hr></div>' +
            '<div class="mota">Weight: ' + escapeHtml(this["Weight"]) + '<hr></div>' +
            '<div class="mota">Color: ' + escapeHtml(this["Color"]) + '<hr></div>' +
            '<div class="mota">BoNhoTrong: ' + escapeHtml(this["BoNhoTrong"]) + '<hr></div>' +
            '<div class="mota">Bộ nhớ đệm(Ram): ' + escapeHtml(this["BoNho"]) + '<hr></div>' +
            '<div class="mota">HDH: ' + escapeHtml(this["HDH"]) + '<hr></div>' +
            '<div class="mota">CamTruoc: ' + escapeHtml(this["CamTruoc"]) + '<hr></div>' +
            '<div class="mota">CamSau: ' + escapeHtml(this["CamSau"]) + '<hr></div>' +
            '<div class="mota">Dung lượng Pin: ' + escapeHtml(this["Pin"]) + '<hr></div>' +
            '<div class="mota">BaoHanh: ' + escapeHtml(this["BaoHanh"]) + '<hr></div>' +
            '<div class="mota">TinhTrang: ' + escapeHtml(this["TinhTrang"]) + '<hr></div>' +
            '</div><div style="height:70%;width:40%;float:right;"><img style="height:100%;width:100%;" src="' + this['HinhAnh'] + '"></div><div style="height:15%;width:40%;float:right;"><div class="soLuong">SL: <input style="font-size:18px;width:30%;text-align:center;" type="number" onkeyup=\'checkValue.call(' + escapeHtml(JSON.stringify(this)) + ',this.value);\' min="1" value="1" max="' + this["SL"] + '"/></div><div class="addToCart"><button class="btnthem" onclick=\'addToCart.call(' + escapeHtml(JSON.stringify(this)) + ');\'><img style="height:25px;float:left;" src="image/shopping-cart-solid - Copy.png"><span style="font-size:14px;color:black;">Thêm vào giỏ hàng</span></button></div></div></div>';
        myModal.innerHTML = mod;
        document.getElementsByTagName('body')[0].appendChild(myModal);
    }
    if (modal == null) modal = myModal;
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
    checkSP(this["maSP"], this["SL"]);
}