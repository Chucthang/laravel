<script>
    let q_hoten, q_sdt, q_email, q_diachi;
    $(document).ready(function() {
        q_hoten = document.querySelector('.qr_hoten');
        q_sdt = document.querySelector('.qr_sdt');
        q_email = document.querySelector('.qr_email');
        q_diachi = document.querySelector('.qr_diachi');

        q_hoten_update = document.querySelector('.qr_hoten_update');
        q_sdt_update = document.querySelector('.qr_sdt_update');
        q_email_update = document.querySelector('.qr_email_update');
        q_diachi_update = document.querySelector('.qr_diachi_update');
        let rd = Math.random().toString(36).substring(0);
        let rdName = rd.replace(/[.0-9]/g, "");
        let rdSdt = '';
        let old_hoten = '';
        let old_sdt = '';
        let old_diachi = '';
        let old_email = '';
        for (let index = 0; index < 11; index++) {

            rdSdt += Math.floor(Math.random() * 10);
        }
        let rdEmail = rd.replace(/[.]/g, "") + "@gmail.com";
        let rdDiachi = rd.replace(/[.]/g, "");

        q_hoten.value = rdName;
        q_email.value = rdEmail;
        q_sdt.value = rdSdt;
        q_diachi.value = rdDiachi;



    });

    function guid() {
        function _p8(s) {
            var p = (Math.random().toString(16) + "000000000").substr(2, 8);
            return s ? "-" + p.substr(0, 4) + "-" + p.substr(4, 4) : p;
        }
        return _p8() + _p8(true) + _p8(true) + _p8();
    }


    function CutPhone(el) {
        let length_phone = el.value.length;
        el.value = el.value.substring(0, 11);

    }

    function Query(type, ...rest) {

        switch (type) {
            case 'back':

                indexSearch = '';
                $(".notdata").hide();
                ForSearch("searchempty", indexSearch);
                AjaxPagination(indexPage, '');
                document.querySelector('#search_ip').value = '';
                break;
            case 'insert':

                if (q_hoten.value == "" ||
                    q_sdt.value == "" ||
                    q_email.value == "" || q_diachi.value == "") {
                    alert('nhập đầy đủ');

                } else if (q_sdt.value.length < 8 || q_sdt.value.length > 11) {

                    alert('Số điện thoại tối thiểu 8 số, tối đa 11 số');
                } else if (ExistValue(Email, q_email.value) == true) {

                    alert('Email đã tồn tại');
                } else if (ExistValue(Sdt, q_sdt.value) == true) {

                    alert('Sdt đã tồn tại');
                } else {

                    $.ajax({
                        type: "POST",
                        url: "ajax/insert",
                        data: {
                            "hoten": q_hoten.value,
                            "sdt": q_sdt.value,
                            "email": q_email.value,
                            "diachi": q_diachi.value
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $(".wait_paginate").css({
                                "display": "block"
                            });
                            $(".wait-data").css({
                                "display": "none"
                            });
                            $(".pagination").hide();
                        },
                        success: function(response) {


                            if (response.data == true) {
                                ForSearch("searchempty", '');
                                MaSo.push({
                                    Ma: response.Maso
                                });
                                Email.push({
                                    Email: q_email.value
                                });
                                Sdt.push({
                                    Sdt: q_sdt.value
                                });


                                $(".pagination").show();
                            }
                            debugger
                        }
                    });
                }
                break;
            case 'delete':
                indexPage = indexPage == 0 ? 1 : indexPage;
                if (indexPage == 1) {
                    document.querySelectorAll('.page-item:nth-child(2)')[0].firstChild.classList.add('myactive');

                }

                $.ajax({
                    type: "DELETE",
                    url: "ajax/delete=" + parseInt(rest[0]),
                    dataType: "json",
                    beforeSend: function() {
                        $(".wait_paginate").css({
                            "display": "block"
                        });
                        $(".mytable").html(`<tr class="prepend-data">
                                    <th>ID</th>
                                    <th>MÃ</th>
                                    <th>HỌ TÊN</th>
                                    <th>SỐ ĐIỆN THOẠI</th>
                                    <th>ĐỊA CHỈ</th>
                                    <th>EMAIL</th>
                                    <th>XOÁ</th>
                                    <th>SỬA</th>
                                </tr>`);
                        $(".pagination").hide();
                    },
                    success: function(response) {

                        AjaxPagination(indexPage, '');
                        if (response != '' || response != null) {
                            let getcoredata = parseInt(document.querySelector('.core_data').textContent);
                            $(".core_data").text(getcoredata - 1);
                            // setTimeout(() => {
                            //          $(".wait_paginate").css({"display":"none"});
                            // }, 1000);

                            if (ExistValue(MaSo, response.data.Ma) == true) {
                                MaSo = MaSo.filter(function(value) {

                                    return value.Ma != response.data.Ma;

                                });
                            }
                            if (ExistValue(Email, response.data.Email) == true) {

                                Email = Email.filter(function(value) {

                                    return value.Email != response.data.Email;

                                });
                            }
                            if (ExistValue(Sdt, response.data.Sdt) == true) {

                                Sdt = Sdt.filter(function(value) {

                                    return value.Sdt != response.data.Sdt;

                                });

                            }
                        }

                    }
                });

                break;
            case 'openupdate':

                $.ajax({
                    type: "GET",
                    url: "ajax/update/user=" + rest[0],
                    dataType: "json",
                    beforeSend: function() {
                        $(".waitUpdate").css({
                            "display": "block"
                        });
                    },
                    success: function(response) {
                        old_hoten = response.data.HoTen;
                        old_sdt = response.data.Sdt;
                        old_diachi = response.data.DiaChi;
                        old_email = response.data.Email;

                        $(".overplay , .wrap_update").css({
                            "display": "block"
                        });
                        $(".waitUpdate").css({
                            "display": "none"
                        });
                        $(".form-update").html(`
                          <div class="fr-input">
                            <span> Họ tên:</span> <input type="text" class="ht qr_hoten_update"  value="${response.data.HoTen}"   placeholder="Họ tên">
                        </div>
                        <div class="fr-input">
                            <span> Sdt:</span> <input type="number" onkeyup="CutPhone(this)" class="sdt  qr_sdt_update"  value="${response.data.Sdt}"  placeholder="Số điện thoại">
                        </div>
                        <div class="fr-input">
                            <span> Email:</span> <input type="email" class="email  qr_email_update" value="${response.data.Email}"  placeholder="Email">
                        </div>
                        <div class="fr-input">
                            <span> Địa chỉ:</span> <input type="text" class="diachi  qr_diachi_update" value="${response.data.DiaChi}" placeholder="Địa chỉ">
                        </div>
                        <button type="button" onclick="return Query('update',${response.data.id})" class="them">Cập nhật</button>
                          `);
                    }
                });

                break;
            case 'update':
                let q_email_update = $(".qr_email_update").val();
                let q_sdt_update = $(".qr_sdt_update").val();
                let q_diachi_update = $(".qr_diachi_update").val();
                let q_hoten_update = $(".qr_hoten_update").val();
                //   AjaxPagination(indexPage,'');
                let checc = indexPage;

                if (q_hoten_update == "" ||
                    q_sdt_update == "" ||
                    q_email_update == "" || q_diachi_update == "") {
                    // alert('nhập đầy đủ');

                } else if (q_sdt_update != old_sdt && ExistValue(Sdt, q_sdt_update) == true) {
                    alert('sdt đã tồn tại');
                } else if (q_email_update != old_email && ExistValue(Email, q_email_update) == true) {
                    alert('Email đã tồn tại');
                } else if (q_email_update == old_email &&
                    q_sdt_update == old_sdt && q_diachi_update == old_diachi &&
                    q_hoten_update == old_hoten
                ) {
                    alert('Không có sự thay đổi');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "ajax/update/edit",
                        data: {
                            "id": rest[0],
                            "hoten": q_hoten_update,
                            "sdt": q_sdt_update,
                            "diachi": q_diachi_update,
                            "email": q_email_update,
                        },
                        beforeSend: function() {
                            $(".overplay , .wrap_update").css({
                                "display": "none"
                            });
                            $(".waitUpdate").css({
                                "display": "block"
                            });
                        },
                        dataType: "json",
                        success: function(response) {
                            AjaxPagination(indexPage, '');
                            $(".waitUpdate").css({
                                "display": "none"
                            });
                        }
                    });
                }
                break;
            case 'noneupdate':
                $(".overplay , .wrap_update").css({
                    "display": "none"
                });
                break;
            default:

                break;
        }
        return false;
    }
</script>