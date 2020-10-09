<div class="frame-insert">
    <div class="fr-input">
        <span> Họ tên:</span> <input type="text" class="ht qr_hoten" placeholder="Họ tên">
    </div>
    <div class="fr-input">
        <span> Sdt:</span> <input type="number" onkeyup="CutPhone(this)" class="sdt  qr_sdt" placeholder="Số điện thoại">
    </div>
    <div class="fr-input">
        <span> Email:</span> <input type="email" class="email  qr_email" placeholder="Email">
    </div>
    <div class="fr-input">
        <span> Địa chỉ:</span> <input type="text" class="diachi  qr_diachi" placeholder="Địa chỉ">
    </div>
    <button type="button" onclick="return Query('insert','')" class="them">Thêm</button>
</div>