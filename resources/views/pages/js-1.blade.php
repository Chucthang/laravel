<script>
    let all_json = <?php echo json_encode($all); ?>;
    let limit_json = <?php echo json_encode($limit); ?>;
    let jsPaginate = " " + "<?php echo implode("-", $newPaginate); ?>" + " ";
    let toArr = [];
    let PreviousArr = [];
    let textSearch = '';
    let disableClick = 0;
    toArr = jsPaginate.split("-");
    let elindex = 1;
    let ClickPage = 0;
    let indexPage = 0;
    let indexSearch = "<?php echo $UrlSearch; ?>";

    $(document).ready(function() {
        PreviousArr.length = <?php echo $urljs ?> != 0 ? <?php echo $urljs ?> : PreviousArr.length;

        if (window.history && window.history.pushState) {
            $(window).on('popstate', function() {
                location.reload();
            });
        }
    });

    function Paginate(...params) {
        let allitem = document.querySelectorAll(".page-link");
        let idEnd = parseInt($('.ip_end').val());


        for (let index = 0; index < allitem.length; index++) {
            allitem[index].classList.remove('myactive');
        }
        let _this = params[3].firstChild.nodeName === '#text' ? params[3].lastChild : params[3].firstChild;
        _this = _this.nodeName === '#text' ? _this.previousElementSibling : _this;
        console.log(_this);

        _this.classList.add('myactive');

        switch (params[0]) {
            case 'Prev':
                let PrevArr = [];
                let PrevData = [];
                PrevArr = toArr;
                let gg = disableClick;

                disableClick = 0;

                //vị tri đầu: 101 - 1 ra vị trí => 100 , 100 - lengh(5)-1 => 96 ====== 1
                //vị tri đầu: 96 - 1 ra vị trí => (end)95 , 95 - lengh(8)-1 (7) => (start)88 ====== 2
                let current_Page_length = idEnd - 1 - PreviousArr.length + 1;
                let end2 = current_Page_length;
                let start2 = end2 - <?php echo $eachPaginate; ?>;
                // let end2 = idEnd  - <?php echo $eachPaginate; ?> ;
                // let start2 = idEnd ==  <?php echo $eachPaginate; ?> ? 0 : end2 - <?php echo $eachPaginate; ?> ;

                PrevArr = PrevArr.slice(start2, end2);

                // console.log(PrevData);
                AppendNumb(PrevArr, toArr);

                break;
            case 'numbpage':
                let txt = textSearch;
                indexPage = params[1];

                AjaxPagination(params[1], txt, params[4]);
                if (params[2] == "end") {
                    // alert('numbpage end' );
                } else if (params[2] == "notend") {
                    // alert('numbpage notend' );
                }
                break;
            case 'Next':
                ++ClickPage;
                // alert('Next');
                let NextArr = [];

                [...NextArr] = toArr;

                let start1 = idEnd;
                if (idEnd < toArr.length) {
                    let end1 = idEnd + <?php echo $eachPaginate; ?>;
                    [...NextArr] = NextArr.slice(start1, end1);

                    console.log("============param");
                    console.log(params);
                    AppendNumb(NextArr, toArr);

                }


                break;
            default:
                break;
        }



    }

    function AjaxPagination(numbPage, ...rest) {
        let txtValue = rest[0] == "" ? rest[1] : rest[0];
        let str_url = '';
        // let startPage = (numbPage-1)*20;
        let startPage = numbPage;

        // let objSearch = {"value" : txtValue, "page" : numbPage}
        if (txtValue != "" && txtValue != undefined) {
            str_url = "ajax/search=" + txtValue;
            elindex = 0;

        } else {
            str_url = "ajax/limit/" + numbPage;

        }

        $.ajax({
            type: "GET",
            url: str_url,
            data: {
                "value": txtValue,
                "page": startPage
            },
            beforeSend: function() {
                $(".wait_paginate").css({
                    "display": "block"
                });
                $(".wait-data").css({
                    "display": "none"
                });
            },
            success: function(response) {
                $(".mytable").html('');
                $(".mytable").append(` <tr class="prepend-data">
                                <th>ID</th>
                                <th>MÃ</th>
                                <th>HỌ TÊN</th>
                                <th>SỐ ĐIỆN THOẠI</th>
                                <th>ĐỊA CHỈ</th>
                                <th>EMAIL</th>
                                <th>XOÁ</th>
                                <th>SỬA</th>
                            </tr>`);
                AppendData(JSON.parse(response));
                if (numbPage != 0) {
                      history.pushState(null, null, `page=${numbPage}`);
                }
            }
        });
    }


    function Search(el) {
        let value = el.value;
        indexSearch = value;
        let strUrl = '';
        elindex = 0;

        if (value == "") {

            setTimeout(() => {
                strUrl = "searchempty";

                ForSearch(strUrl, value);


            }, 1500);


        } else {
            strUrl = "search";
            history.pushState(null, null, `tsearch=${value}`);
            ForSearch(strUrl, value)
        }

    }

    function ForSearch(url, value) {

        // let objValue = {"value": value, "type" : ""}
        $.ajax({
            url: url,
            type: "GET",
            data: {
                "value": value,
                "type": "",
                "page": ""
            },
            beforeSend: function() {
                $(".wait_paginate").css({
                    "display": "block"
                });
                $(".wait-data").css({
                    "display": "none"
                });
            },
            success: function(response) {
                let mainValue = JSON.parse(response);
                let limitValue = JSON.parse(mainValue['limit']);
                let allValue = mainValue['all'];

                if (allValue == 0) {
                    $(".wait_paginate").css({
                        "display": "none"
                    });
                    $(".pagination").hide();
                    $(".notdata").show();
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
                } else {
                    $(".wait_paginate").css({
                        "display": "block"
                    });
                    $(".pagination").show();
                    $(".notdata").hide();
                }
                $(".core_data").text(allValue);
                if (limitValue.length != 0) {
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
                    AppendData(limitValue);
                    let calcPage = Math.ceil(allValue / 20);
                    textSearch = value;

                    let SearchArr = [];
                    // if (SearchArr.length ==0) {
                    for (let index = 1; index <= calcPage; index++) {


                        SearchArr.push(index);

                        // 
                    }
                    // }

                    toArr = SearchArr;
                    let NextArr = [];
                    let start1 = 0;

                    let end1 = <?php echo $eachPaginate; ?>;
                    NextArr = SearchArr.slice(start1, end1);

                    console.log("=========SEARCH=============");
                    console.log(NextArr);
                    AppendNumb(NextArr, 'search');
                }

            }
        });
        //   console.log(value);
    }

    function AppendNumb(DataArr, ...restNumb) {


        let type = restNumb[0] == 'search' ? restNumb[0] : '';
        let chkRest = restNumb[0] != 'search' && restNumb[0] != '' && restNumb[0] !== undefined ? restNumb[0].length : 0;
        let ArLength = DataArr[DataArr.length - 1];


        if (ArLength !== undefined && parseInt(ArLength) > 0 && DataArr.length > 1) {

            disableClick++;
            PreviousArr = DataArr;

            $(".pagination").show();

            if (parseInt(DataArr[0]) >= 1 || (parseInt(DataArr[0]) >= 0 && restNumb[0] == 'search')) {
                $(".pagination").html('');
                $(".pagination").append(`<li class="page-item" 
                            onclick="Paginate('Prev','','',this,'${type}','${indexSearch}');"><a class="page-link aPrev" href="javascript:void(0)">Previous</a></li>`);
                $.each(DataArr, function(idx, el) {

                    let index_end = idx + 1;

                    if (index_end == <?php echo count($slice_Paginate) ?> || parseInt(el) == chkRest) {
                        elindex = 1;

                        $(".pagination").append(`
                                                <li class="page-item"  onclick="Paginate('numbpage',${el},'end',this,'${indexSearch}')" >
                                                <input type="hidden" class="ip_end" value="${el}">
                                                <a class="page-link" href="javascript:void(0)"> ${el}</a></li>`);
                    } else {
                        $(".pagination").append(`<li class="page-item"  onclick="Paginate('numbpage',${el},'notend',this,'${indexSearch}')" >
                                                <a class="page-link" href="javascript:void(0)">${el}</a></li>`);
                    }

                });
                $(".pagination").append(`<li class="page-item" 
                            onclick="Paginate('Next','','',this,'${type}','${indexSearch}');"><a class="page-link aNext" href="javascript:void(0)">Next</a></li>`);
            }


        }
        if (ArLength == 1) {
            $(".pagination").hide();
        }
    }

    function AppendData(arrLimit) {

        $.each(arrLimit, function(idx, item) {

            if (idx == arrLimit.length - 1) {
                $(".wait_paginate").css({
                    "display": "none"
                });
                $(".pagination").show();
            }

            $(".mytable").append(`<tr>
                                <td class="wait-data" >` + item.id + `</td>
                                <td class="wait-data">` + item.Ma + `</td>
                                <td class="wait-data">` + item.HoTen + `</td>
                                <td class="wait-data">` + item.Sdt + `</td>
                                <td class="wait-data">` + item.DiaChi + `</td>
                                <td class="wait-data">` + item.Email + `</td>
                                <td class="wait-data"><button  type="button"  onclick="return Query('delete','${item.id}')" class="btn-xoa btnAc">xoá</button></td>
                                <td class="wait-data"><button   type="button"  onclick="return Query('openupdate','${item.id}')"  class="btn-sua btnAc">sửa</button></td>
                            </tr>`);
        });
    }
</script>