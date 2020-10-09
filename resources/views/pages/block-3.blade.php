<div class="waitUpdate "  onclick="return Query('openupdate','')" >
<img src="{{asset('/public/images/load2.gif')}}" alt="">
</div>
<div class="overplay "  onclick="return Query('noneupdate','')" ></div>
<div class="wrap_update">
    <div class="frame-insert form-update">
        <div class="fr-input">
            <span> Họ tên:</span> <input type="text" class="ht qr_hoten_update" placeholder="Họ tên">
        </div>
        <div class="fr-input">
            <span> Sdt:</span> <input type="number" onkeyup="CutPhone(this)" class="sdt  qr_sdt_update" placeholder="Số điện thoại">
        </div>
        <div class="fr-input">
            <span> Email:</span> <input type="email" class="email  qr_email_update" placeholder="Email">
        </div>
        <div class="fr-input">
            <span> Địa chỉ:</span> <input type="text" class="diachi  qr_diachi_update" placeholder="Địa chỉ">
        </div>
        <button type="button" onclick="return Query('update','')" class="them">Cập nhật</button>
    </div>  
</div>
