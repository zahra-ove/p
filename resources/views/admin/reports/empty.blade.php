@extends('admin.master.home')
@section('js')
{{--    <script src="https://rawgit.com/abdennour/hijri-date/master/cdn/hijri-date-latest.js"--}}
{{--            type="text/javascript"></script>--}}
    <script src="{{asset('admin/js/hijri-date-latest.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin')}}/js/jdate.min.js" type="text/javascript" charset="utf-8"></script>
    <script>

        $(document).ready(function () {
            $('.hrefbtn').attr('href', "{{route('order.create')}}");
            let addpubcheck = [];
//////ckeditor
//             CKEDITOR.replace('editor', {
//                 language: "fa",
//
//             });
            $('#showItem').change(function (e) {
                if ($(this).is(':checked')) {
                    $(this).val('1');
                } else {
                    $(this).val('0');
                }
            });

            $('#user').change(function (ev) {
                let userId = $(this).val();
                $.ajax(
                    {
                        url: "{{asset('admin/getorderbyuser')}}/" + userId,
                        success: function (data) {
                            $('tbody').empty()
                            if (data != 'notfound') {
                                data.forEach(function (item, index) {
                                    $('tbody').append(`<tr data-id="${item.id}">
<td>${index + 1}</td>
<td>${item.pansion}</td>
<td>${item.roomnumber}</td>
<td>${item.takhtnumber}</td>
<td>${item.order_number}</td>
<td>${item.karshenasName}</td>
<td>${item.vaziat}</td>
<td>${item.jabjayi}</td>
<td>${item.jalaliRaft}</td>
<td>${item.jalaliBargasht}</td>
<td class="btns">


</td>

</tr>


`);

                                    if (item.status_order_id == 1 || item.status_order_id == 2) {


                                        $('.btns').last().html(`

<a href="{{asset('admin/pastcancel')}}/${item.id}" class="btn text-white btn-danger w-100 canceling" style="padding: 10px 12px" title="کنسل" data-id="${item.id}" data-target="#delete-modal-${index}">کنسل</a>

                            <div class="modal fade" id="delete-modal-${index}" role="dialog">
                                <div class="modal-dialog modal-lg">


                                    <div class="modal-content" style="height: 3000px">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
<form method="post" action="" id="submit">

                                            <input id="tarikh" name="tarikh" class="d-none" value="">
                                            <input id="raft" name="raft" class="d-none"  value="">
                                            <input id="bargasht" name="bargasht" class="d-none"  value="">
                                            <input id="days" name="days" class="d-none"  value="">
                                            <input id="price" name="price" class="d-none"  value="">
                                            <input id="perMonth" name="perMonth" class="d-none"  value="">
                                            <input id="orderId" name="orderId" class="d-none"  value="${item.id}">
                                            <input id="orderId" name="takht_id" class="d-none"  value="${item.takht_id}">
                                            <input id="orderId" name="user_id" class="d-none"  value="${item.user_id}">

                                            <div class="container-fluid card" style="height: 1750px;">
                                                <div class="row">
                                                    <div class="col-12 row">


                                                        <div class="col-12 row">

                                                            <div class="col-12 row">


                                            <div class="col-12 col-lg-6 mb-5 mt-5" >

                                                <label class="form-label mb-2" for="day">نوع رزرو</label>
                                                <br>
                                                <select disabled name="reservetype" class="select2 form-control" id="reserve">
                                                    <option value="">نوع رزرو را انتخاب کنید.</option>

                                            </select>

                                        </div>

                                </div>
    <div class="col-lg-3 col-12 mt-5">از تاریخ: <span id="from"></span></div>
                                                            <div class="col-lg-3 col-12 mt-5">تا تاریخ: <span id="to"></span></div>
                                <div class="col-12 mt-5 row p-0" id="timeTable" style="border: 1px solid #dee2e6;margin-right: 45px;">

                                    <div class="col-12 p-0">
                                        <table id="mainTable" class="table mb-0 h-100">
                                            <thead class="bg-dark">
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody id="dayTable">
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                                </div>

                            </div>
                            <div class="col-12 mb-5 mt-5 row pl-5">
                                <div class="col-12 text-center mt-5">

                                    <div class="col-12 text-center mt-5">
                                        <h3>محاسبه کرایه تخت</h3>
                                        <div class="row d-none" id="calculate">
                                <div class="col-6 mt-3 pt-3 d-none" style="font-size: 20px;border-top: 1px solid #bdc4c4;text-align: right;" id="roozaneTitr">مبلغ روزانه:</div>
                                <div class="col-6 mt-3 pt-3 d-none" style="font-size: 20px;border-top: 1px solid #bdc4c4;text-align: right;" id="mahaneTitr">مبلغ ماهانه:</div>
                                <div class="col-6 mt-3 pt-3" style="border-top: 1px solid #bdc4c4;text-align: right;">   <h5 id="takPrice"></h5></div>
                                <div class="col-6 mt-3 pt-3" style="font-size: 20px;border-top: 1px solid #bdc4c4;text-align: right;" id="totaldaysTitr">تعداد روزها:</div>
                                <div class="col-6 mt-3 pt-3" style="border-top: 1px solid #bdc4c4;text-align: right;">   <h5 id="totaldays"></h5></div>
                                <div class="col-6 mt-3 pt-3" style="font-size: 20px;border-top: 1px solid #bdc4c4;text-align: right;" id="totalpriceTitr">مبلغ کل:</div>
                                <div class="col-6 mt-3 pt-3" style="border-top: 1px solid #bdc4c4;text-align: right;"> <h5 id="totalPrice"></h5></div>
                                <div class="col-6 mt-3 pt-3" style="font-size: 20px;border-top: 1px solid #bdc4c4;text-align: right;" id="takhfifTitr">مبلغ تخفیف(به تومان):</div>
                                <div class="col-6 mt-3 pt-3 row" style="border-top: 1px solid #bdc4c4;text-align: right;">  <div class="col-10"><input class="form-control seprator justnumber" name="takhfif" id="takhfif"></div><div class="col-2"><span class="btn btn-secondary" id="emaltakhfif">اعمال</span></div> </div>
                                <div class="col-6 mt-3 pt-3" style="font-size: 20px;border-top: 1px solid #bdc4c4;text-align: right;" id="finallypriceTitr">مبلغ نهایی:</div>
                                <div class="col-6 mt-3 pt-3" style="border-top: 1px solid #bdc4c4;text-align: right;"> <h5 id="finallyPrice"></h5></div>
                                <div class="col-6 mt-3 pt-3" style="font-size: 20px;border-top: 1px solid #bdc4c4;text-align: right;" id="paytypeTitr">نوع پرداخت:</div>
                                <div class="col-6 mt-3 pt-3" style="border-top: 1px solid #bdc4c4;text-align: right;"> <select name="paytype" id="paytype" class="select2 form-control">
                                        <option value="n">نقدی</option>
                                        <option value="q">اقساطی</option>
                                    </select>
                                </div>

                                            <div class="col-6 mt-3 pt-3 d-none" style="font-size: 20px;border-top: 1px solid #bdc4c4;text-align: right;" id="qestmonthTitr">تعداد نوبت:</div>
                                            <div class="col-6 mt-3 pt-3 row d-none" style="border-top: 1px solid #bdc4c4;text-align: right;" id="countMonthTitr">

                                            </div>
                                            <div class="col-12 mt-3 pt-3 d-none" style="font-size: 20px;border-top: 1px solid #bdc4c4;text-align: right;" id="tarikhMonthTitr">تعیین تاریخ نوبت:</div>
                                            <div class="col-12 mt-3 pt-3 row" style="text-align: right;" id="tarikhMonth"> </div>

                                            <div class="col-12 mt-3 pt-3 row" style="font-size: 20px;border-top: 1px solid #bdc4c4;text-align: right;" id="naqdtype">
                                                <div class="col-12" id="payDetail">جزییات پرداخت:</div>

                                            <div class="col-1 text-center mt-3">
                                                <span class="btn  mt-1 p-0 plusNaqd" style="cursor: pointer"><i class="fa fa-plus"></i> </span>
                                            </div>
                                            </div>
                                    </div>


                                                <input name="totalPrice" class="d-none" id="totalPriceInput">
                                                <input name="finallyPrice" class="d-none" id="finallyPriceInput">
                                            </div>
          <div class="col-12 mb-3 mt-5">
                                                <button type="submit" class="w-50 btn btn-success pt-2 pb-2" id="freesubmit">ثبت</button>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </form>

                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>`);
                                        {{--$('#submit').attr('action',"{{route('deletepassday')}}");--}}
                                        $('#submit').prepend(`<input class="d-none" name="_token" value="{{csrf_token()}}">`);

                                        $.ajax(
                                            {
                                                url:"{{asset('admin/naqdtypes')}}",
                                                success:function (data) {
                                                    if (data!='notfound') {
                                                        data.forEach(function (item, index) {
                                                            $('#payDetail').after(`             <div class="naghdi row col-11">
                                        <div class="col-1 text-center mt-3 adad">
                                           <i class="fa fa-credit-card"></i>
                                        </div>

                                    <div class="col-9 row">
                                        <div class="col-lg-6 mt-2 ">  <input class="form-control naqdtypeTitle" name="naqdtypeTitle[]" placeholder="نوع پرداخت" value="${item.title}"></div>
                                        <div class="col-lg-6 mt-2">   <input class="form-control seprator justnumber naqdtypeMablagh" name="naqdtypeMablagh[]" placeholder="مبلغ (به تومان)"></div>


                                    </div>
                                    <div class="col-1 text-center mt-3">
                                        <span class="btn mt-1 p-0 removeNaqd" data-id="${item.id}" style="cursor: pointer"><i class="fa fa-minus"></i> </span>
                                    </div>
                                    </div>`);
                                                        });
                                                    }
                                                }
                                            }
                                        );



                                        $.ajax(
                                            {
                                                url:"{{asset('admin/reservetypes')}}",
                                                success:function (data) {
                                                    if (data!='notfound') {
                                                        data.forEach(function (item, index) {
                                                            $('#reserve').append(`   <option value="${item.id}">${item.title}</option>`);
                                                        });
                                                    }
                                                }
                                            }
                                        );


                                        $(`.orderStatus[data-id=${item.id}] option`).each(function (index) {
                                            if ($(this).val() == item.status_order_id) {
                                                $(this).attr('selected', 'selected');
                                            }
                                        });
                                        let action = "{{asset('admin/order')}}/" + item.id;
                                        $(`form[data-id=${item.id}]`).attr('action', action);
                                        $(`form[data-id=${item.id}]`).prepend('@csrf');
                                        $(`form[data-id=${item.id}]`).prepend('@method('patch')');
                                    }
                                    $('.delete-btn').click(function (e) {

                                        let id = $(this).attr('data-id');
                                        $(this).parents('tr[data-id="' + id + '"]').remove();
                                        $('.modal-backdrop').remove();
                                        $('body').removeClass('modal-open');

                                        let info = {
                                            "_token": "{{ csrf_token() }}"
                                        }
                                        $.ajax(
                                            {
                                                url: '{{asset('admin/order/')}}/' + id,
                                                type: 'delete',
                                                data: info,
                                                success: function (data) {
                                                    if (data == "ok") {
                                                        // location.reload();
                                                        toastr.success('دسترسی با موفقیت حذف شد.');
                                                        if ($('tbody').children().length == 0) {
                                                            $('tbody').append(`<p style="padding: 20px">رزروی برای مشترک وجود ندارد.</p>`)
                                                        }

                                                    } else if (data == "notfound") {
                                                        // location.reload();

                                                        toastr.error('بروز خطا');
                                                    }

                                                }
                                            }
                                        );
                                    });
                                    $('.canceling').click(function (evv) {
                                        $('#price').val(`${item.price}`);

                                        ////refresh
                                        $('#dayTable').empty();
                                        $('#titrTarikh').remove();
                                        $('#preMonth').remove();
                                        $('#nextMonth').remove();
                                        $('#miladiTitr').remove();
                                        $('#tarikhclicked').remove();
                                        $('#raft').val('');
                                        $('#bargasht').val('');
                                        $('#timeTable').css('border', 'none')
                                        // $('#mainTable').empty();

                                        $('.hrefbtn').hide()

                                        let jdateNow = new JDate;
                                        let jdate = new JDate;
                                        let mildate = new Date();
                                        let tarikhs = [];

                                        $('#timeTable').prepend(`<div class="col-12 text-center" id="tarikhclicked"><h6>${jdate.format('dddd DD MMMM YYYY')}</h6></div>`);
                                        $('#timeTable').prepend(`<div class="col-12 text-center" id="miladiTitr"><h6 id="miladi" class="text-center mt-2 text-info"><span id="ytimetablemi"> ${mildate.getFullYear()}</span></h6></div>`);
                                        $('#timeTable').prepend(`<div class="col-4 mt-2" id="nextMonth" style="cursor: pointer"><i class="fas fa-arrow-right"></i></div> <div class="col-4 " id="titrTarikh"> <h4 id="shamsi" class="text-center mt-2 text-primary"><span id="ytimetablesh"> ${jdate.date['0']}</span></h4></div><div class="col-4 mt-2" id="preMonth" style="cursor: pointer;text-align: left"><i class="fas fa-arrow-left"></i></div>`);


                                        ///miladi month
                                        if (mildate.getMonth() == '0') {
                                            $('#miladi').prepend(`<span id="mtimetablesh" month="1">January</span>`)
                                        }
                                        if (mildate.getMonth() == '1') {
                                            $('#miladi').prepend(`<span id="mtimetablesh" month="2">February</span>`)
                                        }
                                        if (mildate.getMonth() == '2') {
                                            $('#miladi').prepend(`<span id="mtimetablesh" month="3">March</span>`)
                                        }
                                        if (mildate.getMonth() == '3') {
                                            $('#miladi').prepend(`<span id="mtimetablesh" month="4">April</span>`)
                                        }
                                        if (mildate.getMonth() == '4') {
                                            $('#miladi').prepend(`<span id="mtimetablesh" month="5">May</span>`)
                                        }
                                        if (mildate.getMonth() == '5') {
                                            $('#miladi').prepend(`<span id="mtimetablesh" month="6">June</span>`)
                                        }
                                        if (mildate.getMonth() == '6') {
                                            $('#miladi').prepend(`<span id="mtimetablesh" month="7">July</span>`)
                                        }
                                        if (mildate.getMonth() == '7') {
                                            $('#miladi').prepend(`<span id="mtimetablesh" month="8">August</span>`)
                                        }
                                        if (mildate.getMonth() == '8') {
                                            $('#miladi').prepend(`<span id="mtimetablesh" month="9">September</span>`)
                                        }
                                        if (mildate.getMonth() == '9') {
                                            $('#miladi').prepend(`<span id="mtimetablesh" month="10">October</span>`)
                                        }
                                        if (mildate.getMonth() == '10') {
                                            $('#miladi').prepend(`<span id="mtimetablesh" month="11">November</span>`)
                                        }
                                        if (mildate.getMonth() == '11') {
                                            $('#miladi').prepend(`<span id="mtimetablesh" month="12">December</span>`)
                                        }
                                        ///jalali month
                                        if (jdate.date['1'] == '1') {
                                            $('#shamsi').prepend(`<span id="mtimetablesh" month="1">فروردین</span>`)
                                            let days = 0;
                                            for (let i = 1; i <= 5; i++) {
                                                $('#dayTable').append(`<tr class="titr"></tr>`);
                                                for (let j = 1; j <= 7; j++) {
                                                    days = days + 1;
                                                    $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}" style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                    if (days == 31) {
                                                        break;
                                                    }
                                                }
                                            }
                                            $('.tdDay').hover(function () {
                                                $(this).css("background-color", "#dee2e6");
                                            }, function () {
                                                $(this).css("background-color", "white");
                                            });
                                            $('.tdDay').each(function (index) {

                                                if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                    $(this).css('background', 'blue').css('color', 'white');
                                                    $(this).hover(function () {
                                                        $(this).css("background-color", "#dee2e6");
                                                    }, function () {
                                                        $(this).css("background-color", "blue").css('color', 'white');
                                                    });
                                                }
                                            });
                                        }
                                        if (jdate.date['1'] == '2') {
                                            $('#shamsi').prepend(`<span id="mtimetablesh" month="2">اردیبهشت</span>`)
                                            let days = 0;
                                            for (let i = 1; i <= 5; i++) {
                                                $('#dayTable').append(`<tr class="titr"></tr>`);
                                                for (let j = 1; j <= 7; j++) {
                                                    days = days + 1;
                                                    $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                    if (days == 31) {
                                                        break;
                                                    }
                                                }
                                            }
                                            $('.tdDay').hover(function () {
                                                $(this).css("background-color", "#dee2e6");
                                            }, function () {
                                                $(this).css("background-color", "white");
                                            });
                                            $('.tdDay').each(function (index) {

                                                if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                    $(this).css('background', 'blue').css('color', 'white');
                                                    $(this).hover(function () {
                                                        $(this).css("background-color", "#dee2e6");
                                                    }, function () {
                                                        $(this).css("background-color", "blue").css('color', 'white');
                                                    });
                                                }
                                            });
                                        }
                                        if (jdate.date['1'] == '3') {
                                            $('#shamsi').prepend(`<span id="mtimetablesh" month="3">خرداد</span>`);
                                            let days = 0;
                                            for (let i = 1; i <= 5; i++) {
                                                $('#dayTable').append(`<tr class="titr"></tr>`);
                                                for (let j = 1; j <= 7; j++) {
                                                    days = days + 1;
                                                    $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                    if (days == 31) {
                                                        break;
                                                    }
                                                }
                                            }
                                            $('.tdDay').hover(function () {
                                                $(this).css("background-color", "#dee2e6");
                                            }, function () {
                                                $(this).css("background-color", "white");
                                            });
                                            $('.tdDay').each(function (index) {

                                                if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                    $(this).css('background', 'blue').css('color', 'white');
                                                    $(this).hover(function () {
                                                        $(this).css("background-color", "#dee2e6");
                                                    }, function () {
                                                        $(this).css("background-color", "blue").css('color', 'white');
                                                    });
                                                }
                                            });
                                        }
                                        if (jdate.date['1'] == '4') {
                                            $('#shamsi').prepend(`<span id="mtimetablesh" month="4">تیر</span>`);
                                            let days = 0;
                                            for (let i = 1; i <= 5; i++) {
                                                $('#dayTable').append(`<tr class="titr"></tr>`);
                                                for (let j = 1; j <= 7; j++) {
                                                    days = days + 1;
                                                    $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                    if (days == 31) {
                                                        break;
                                                    }
                                                }
                                            }
                                            $('.tdDay').hover(function () {
                                                $(this).css("background-color", "#dee2e6");
                                            }, function () {
                                                $(this).css("background-color", "white");
                                            });
                                            $('.tdDay').each(function (index) {

                                                if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                    $(this).css('background', 'blue').css('color', 'white');
                                                    $(this).hover(function () {
                                                        $(this).css("background-color", "#dee2e6");
                                                    }, function () {
                                                        $(this).css("background-color", "blue").css('color', 'white');
                                                    });
                                                }
                                            });

                                        }
                                        if (jdate.date['1'] == '5') {
                                            $('#shamsi').prepend(`<span id="mtimetablesh" month="5">مرداد</span>`);
                                            let days = 0;
                                            for (let i = 1; i <= 5; i++) {
                                                $('#dayTable').append(`<tr class="titr"></tr>`);
                                                for (let j = 1; j <= 7; j++) {
                                                    days = days + 1;
                                                    $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                    if (days == 31) {
                                                        break;
                                                    }
                                                }
                                            }
                                            $('.tdDay').hover(function () {
                                                $(this).css("background-color", "#dee2e6");
                                            }, function () {
                                                $(this).css("background-color", "white");
                                            });
                                            $('.tdDay').each(function (index) {

                                                if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                    $(this).css('background', 'blue').css('color', 'white');
                                                    $(this).hover(function () {
                                                        $(this).css("background-color", "#dee2e6");
                                                    }, function () {
                                                        $(this).css("background-color", "blue").css('color', 'white');
                                                    });
                                                }
                                            });
                                        }
                                        if (jdate.date['1'] == '6') {
                                            $('#shamsi').prepend(`<span id="mtimetablesh" month="6">شهریور</span>`);
                                            let days = 0;
                                            for (let i = 1; i <= 5; i++) {
                                                $('#dayTable').append(`<tr class="titr"></tr>`);
                                                for (let j = 1; j <= 7; j++) {
                                                    days = days + 1;
                                                    $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                    if (days == 31) {
                                                        break;
                                                    }
                                                }
                                            }
                                            $('.tdDay').hover(function () {
                                                $(this).css("background-color", "#dee2e6");
                                            }, function () {
                                                $(this).css("background-color", "white");
                                            });
                                            $('.tdDay').each(function (index) {

                                                if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                    $(this).css('background', 'blue').css('color', 'white');
                                                    $(this).hover(function () {
                                                        $(this).css("background-color", "#dee2e6");
                                                    }, function () {
                                                        $(this).css("background-color", "blue").css('color', 'white');
                                                    });
                                                }
                                            });
                                        }
                                        if (jdate.date['1'] == '7') {
                                            $('#shamsi').prepend(`<span id="mtimetablesh" month="7">مهر</span>`);
                                            let days = 0;
                                            for (let i = 1; i <= 5; i++) {
                                                $('#dayTable').append(`<tr class="titr"></tr>`);
                                                for (let j = 1; j <= 7; j++) {
                                                    days = days + 1;
                                                    $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                    if (days == 30) {
                                                        break;
                                                    }
                                                }
                                            }
                                            $('.tdDay').hover(function () {
                                                $(this).css("background-color", "#dee2e6");
                                            }, function () {
                                                $(this).css("background-color", "white");
                                            });
                                            $('.tdDay').each(function (index) {

                                                if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                    $(this).css('background', 'blue').css('color', 'white');
                                                    $(this).hover(function () {
                                                        $(this).css("background-color", "#dee2e6");
                                                    }, function () {
                                                        $(this).css("background-color", "blue").css('color', 'white');
                                                    });
                                                }
                                            });
                                        }
                                        if (jdate.date['1'] == '8') {
                                            $('#shamsi').prepend(`<span id="mtimetablesh" month="8">آبان</span>`);
                                            let days = 0;
                                            for (let i = 1; i <= 5; i++) {
                                                $('#dayTable').append(`<tr class="titr"></tr>`);
                                                for (let j = 1; j <= 7; j++) {
                                                    days = days + 1;
                                                    $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                    if (days == 30) {
                                                        break;
                                                    }
                                                }
                                            }
                                            $('.tdDay').hover(function () {
                                                $(this).css("background-color", "#dee2e6");
                                            }, function () {
                                                $(this).css("background-color", "white");
                                            });
                                            $('.tdDay').each(function (index) {

                                                if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                    $(this).css('background', 'blue').css('color', 'white');
                                                    $(this).hover(function () {
                                                        $(this).css("background-color", "#dee2e6");
                                                    }, function () {
                                                        $(this).css("background-color", "blue").css('color', 'white');
                                                    });
                                                }
                                            });
                                        }
                                        if (jdate.date['1'] == '9') {
                                            $('#shamsi').prepend(`<span id="mtimetablesh" month="9">آذر</span>`);
                                            let days = 0;
                                            for (let i = 1; i <= 5; i++) {
                                                $('#dayTable').append(`<tr class="titr"></tr>`);
                                                for (let j = 1; j <= 7; j++) {
                                                    days = days + 1;
                                                    $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                    if (days == 30) {
                                                        break;
                                                    }
                                                }
                                            }
                                            $('.tdDay').hover(function () {
                                                $(this).css("background-color", "#dee2e6");
                                            }, function () {
                                                $(this).css("background-color", "white");
                                            });
                                            $('.tdDay').each(function (index) {

                                                if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                    $(this).css('background', 'blue').css('color', 'white');
                                                    $(this).hover(function () {
                                                        $(this).css("background-color", "#dee2e6");
                                                    }, function () {
                                                        $(this).css("background-color", "blue").css('color', 'white');
                                                    });
                                                }
                                            });
                                        }
                                        if (jdate.date['1'] == '10') {
                                            $('#shamsi').prepend(`<span id="mtimetablesh" month="10">دی</span>`);
                                            let days = 0;
                                            for (let i = 1; i <= 5; i++) {
                                                $('#dayTable').append(`<tr class="titr"></tr>`);
                                                for (let j = 1; j <= 7; j++) {
                                                    days = days + 1;
                                                    $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                    if (days == 30) {
                                                        break;
                                                    }
                                                }
                                            }
                                            $('.tdDay').hover(function () {
                                                $(this).css("background-color", "#dee2e6");
                                            }, function () {
                                                $(this).css("background-color", "white");
                                            });
                                            $('.tdDay').each(function (index) {

                                                if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                    $(this).css('background', 'blue').css('color', 'white');
                                                    $(this).hover(function () {
                                                        $(this).css("background-color", "#dee2e6");
                                                    }, function () {
                                                        $(this).css("background-color", "blue").css('color', 'white');
                                                    });
                                                }
                                            });
                                        }
                                        if (jdate.date['1'] == '11') {
                                            $('#shamsi').prepend(`<span id="mtimetablesh" month="11">بهمن</span>`)
                                            let days = 0;
                                            for (let i = 1; i <= 5; i++) {
                                                $('#dayTable').append(`<tr class="titr"></tr>`);
                                                for (let j = 1; j <= 7; j++) {
                                                    days = days + 1;
                                                    $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                    if (days == 30) {
                                                        break;
                                                    }
                                                }
                                            }
                                            $('.tdDay').hover(function () {
                                                $(this).css("background-color", "#dee2e6");
                                            }, function () {
                                                $(this).css("background-color", "white");
                                            });
                                            $('.tdDay').each(function (index) {

                                                if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                    $(this).css('background', 'blue').css('color', 'white');
                                                    $(this).hover(function () {
                                                        $(this).css("background-color", "#dee2e6");
                                                    }, function () {
                                                        $(this).css("background-color", "blue").css('color', 'white');
                                                    });
                                                }
                                            });
                                        }
                                        if (jdate.date['1'] == '12') {
                                            $('#shamsi').prepend(`<span id="mtimetablesh" month="12">اسفند</span>`);
                                            let days = 0;
                                            for (let i = 1; i <= 5; i++) {
                                                $('#dayTable').append(`<tr class="titr"></tr>`);
                                                for (let j = 1; j <= 7; j++) {
                                                    days = days + 1;
                                                    $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                    if (days == 29) {
                                                        break;
                                                    }
                                                }
                                            }
                                            $('.tdDay').hover(function () {
                                                $(this).css("background-color", "#dee2e6");
                                            }, function () {
                                                $(this).css("background-color", "white");
                                            });
                                            $('.tdDay').each(function (index) {

                                                if ($(this)[0].innerText == jdate.date['2']) {
                                                    $(this).css('background', 'blue').css('color', 'white');
                                                    $(this).hover(function () {
                                                        $(this).css("background-color", "#dee2e6");
                                                    }, function () {
                                                        $(this).css("background-color", "blue").css('color', 'white');
                                                    });
                                                }
                                            });
                                        }

                                        ////events
                                        let miladi3 = [];
                                        var hijri2 = 0;
                                        for (let i = 1; i <= 31; i++) {
                                            let jdate2 = new JDate(jdate.date[0], jdate.date[1], i)
                                            let mildate2 = JDate.toGregorian(jdate.date[0], jdate.date[1], i);
                                            miladi3.push(mildate2);
                                            // console.log(mildate2.toHijri().date)
                                            // hijri.push([mildate2.toHijri.date,hijriDay.toHijri.month]);
                                            hijri2 = mildate.toHijri();
                                            // console.log(hijri2);
                                            let hijriMonth = hijri2.month
                                            let hijriDay = hijri2.date
                                            let solarMonth = jdate.date[1];
                                            let solarDay = jdate.date[2];


                                            $.ajax({
                                                url: "https://farsicalendar.com/api/sh/" + i + "/" + solarMonth,
                                                dataType: 'json',
                                                success: function (data) {
                                                    if (data.values.length != 0) {
                                                        // console.log(data.values[0].occasion)


                                                        $('#shamsiEvent').append(`<li>${i}: ${data.values[0].occasion}</li>`)
                                                    }


                                                }
                                            });
                                        }
                                        miladi3.forEach(function (item, index) {
                                            // console.log(item.toHijri().date)
                                            // console.log(item.toHijri().month)


                                            $.ajax({
                                                url: "https://farsicalendar.com/api/ic/" + item.toHijri().date + "/" + item.toHijri().month,
                                                dataType: 'json',
                                                success: function (data) {

                                                    if (data.values.length != 0) {
                                                        // console.log(data.values[0].occasion)


                                                        $('#hijriEvent').append(`<li>${new JDate(item).date[2]}: ${data.values[0].occasion}</li>`)
                                                    }

                                                },
                                                error: function (error) {
                                                    console.log(error);
                                                }

                                            });
                                        })
                                        //////picker
                                        $('.tdDay').click(function (ee) {
                                            let clicktarikh = $(this).attr('tarikh').split('/');
                                            clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                            let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                            let beShamsiKamel = new JDate(new Date(miladi)).format('dddd DD MMMM YYYY')
                                            let bargashtUnix = new Date($('#bargasht').val()).getTime();
                                            let raftmiladi = new Date(miladi).getTime();


                                            if ($('.tdDay.bg-warning').length == 0 && $('.tdDay.bg-success').length == 1) {
                                                $('#reserve').prop("disabled", false);
                                            }
                                            if ($(this).hasClass('bg-warning')) {
                                                // $('.tdDay').removeClass('gozashteh').css('opacity', '100%');
                                                let indexof = tarikhs.indexOf(miladi);
                                                tarikhs.splice(indexof, 1);
                                                // $('#raft').val('');
                                                // $('#from').empty();
                                                $('#reserve').prop("disabled", true);
                                                $('#reserve').children().first().attr('selected', 'selected');
                                                $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
                                            } else if ($(this).hasClass('gozashte')) {
                                                toastr.error('روز های گذشته را نمی توان انتخاب نمود.');

                                            } else if ($(this).hasClass('reserved')) {
                                                toastr.error('این روز قبلاٌ رزرو شده است.')
                                            } else if ($(this).hasClass('gozashteh')) {
                                                toastr.error('روز های گذشته را نمیشه انتخاب نمود.')
                                            } else if ($('.bg-warning').length == 0 && $('#raft').val() == "") {
                                                if (bargashtUnix < raftmiladi) {
                                                    $('#bargasht').val('');
                                                }
                                                $('.tdDay').each(function () {
                                                    let attr = $(this).attr('tarikh').split('/');
                                                    pastDate = JalaliDate.jalaliToGregorian(attr[0], attr[1], attr[2]);

                                                    let pastMiladi = pastDate[0] + "-" + pastDate[1] + "-" + pastDate[2];
                                                    let newmiladi = new Date(miladi).getTime();
                                                    let newpastMiladi = new Date(pastMiladi).getTime();
                                                    if (newpastMiladi < newmiladi) {
                                                        $(this).css('opacity', '50%').addClass('gozashteh');
                                                    }

                                                })
                                                $(this).addClass('bg-warning');
                                                $('#raft').val(miladi);
                                                $('#from').html(beShamsiKamel);


                                            } else if (($('.bg-warning').length == 1 || $('#raft').val() != "") && $('.tdDay.bg-success').length == 0 && $('#bargasht').val() == "") {
                                                $(this).addClass('bg-success');
                                                $('#bargasht').val(miladi);
                                                $('#to').html(beShamsiKamel);
                                                $('#reserve').prop("disabled", false);
                                            } else if ($(this).hasClass('bg-success')) {
                                                $(this).removeClass('bg-success');
                                                $('#bargasht').val("");
                                                $('#to').empty();
                                                $('#reserve').prop("disabled", true);
                                                $('#reserve').children().first().attr('selected', 'selected');
                                                $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
                                            }
                                            if ($('.tdDay.bg-success').hasClass('gozashteh')) {

                                                $('.tdDay').removeClass('bg-success');
                                                $('#bargasht').val("");
                                                $('#to').empty();
                                                $('#reserve').prop("disabled", true);
                                                $('#reserve').children().first().attr('selected', 'selected');
                                                $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');

                                            }


                                            let tarikhPicked = $(this).attr('tarikh').split('/');

                                            jdate19 = new JDate(tarikhPicked[0], tarikhPicked[1], tarikhPicked[2]);

                                            $('#datePicked').html(`<h6>${jdate19.format('dddd DD MMMM YYYY')}</h6>`);


                                        });

                                        ///////disable pass day
                                        let thisDayTotal = "";
                                        let thisDayTotalSplit = "";
                                        $('.tdDay').each(function (index) {

                                            let $this = $(this);
                                            let clicktarikh = $(this).attr('tarikh').split('/');
                                            clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                            let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                            $(this).attr('miladi', miladi);
                                            let totalToday = JDate.toGregorian(jdateNow.date[0], jdateNow.date[1], jdateNow.date[2]).getTime();
                                            thisDayTotalSplit = $(this).attr('tarikh').split('/');
                                            let beShamsiKamel = new JDate(new Date(miladi)).format('dddd DD MMMM YYYY');
                                            thisDayTotal = JDate.toGregorian(parseInt(thisDayTotalSplit[0]), parseInt(thisDayTotalSplit[1]), parseInt(thisDayTotalSplit[2])).getTime();
                                            if (new Date($(this).attr('miladi')).getTime() == new Date(item.raft).getTime()) {
                                                $(this).addClass('bg-warning');
                                                $('#raft').val(miladi);
                                                $('#from').html(beShamsiKamel);
                                            }
                                            let weekDay = new Date(miladi).getDay();
                                            if (weekDay == 0) {
                                                $(this).append(`<br><i style="font-size: 9px">ی</i>`)
                                            }
                                            if (weekDay == 1) {
                                                $(this).append(`<br><i style="font-size: 9px">د</i>`)
                                            }
                                            if (weekDay == 2) {
                                                $(this).append(`<br><i style="font-size: 9px">س</i>`)
                                            }
                                            if (weekDay == 3) {
                                                $(this).append(`<br><i style="font-size: 9px">چ</i>`)
                                            }
                                            if (weekDay == 4) {
                                                $(this).append(`<br><i style="font-size: 9px">پ</i>`)
                                            }
                                            if (weekDay == 5) {
                                                $(this).append(`<br><i style="font-size: 9px">ج</i>`)
                                            }
                                            if (weekDay == 6) {
                                                $(this).append(`<br><i style="font-size: 9px">ش</i>`)
                                            }
                                            if (thisDayTotal < totalToday) {
                                                $(this).css('opacity', '50%').addClass('gozashte');
                                            }
                                            tarikhs.forEach(function (item, index) {
                                                if (item == miladi) {
                                                    $this.addClass('bg-warning');
                                                }
                                            });

                                        });
                                        //////nextmonth
                                        $('#nextMonth').click(function (ee) {
                                            $(this).attr('month', jdate.date[1])
                                            $(this).attr('day', jdate.date[2])

                                            let miladi3 = [];
                                            let unixNextMonth = Math.floor(mildate.setHours(0)) + 2592000000;

                                            if ($(this).attr('month') == 11 && $(this).attr('day') == 30) {

                                                unixNextMonth = Math.floor(mildate.setHours(0)) + 2505600000;

                                            }
                                            if ($(this).attr('month') == 1 || $(this).attr('month') == 2 || $(this).attr('month') == 3 ||
                                                $(this).attr('month') == 4 || $(this).attr('month') == 5 || $(this).attr('month') == 6) {

                                                unixNextMonth = Math.floor(mildate.setHours(0)) + 2678400000;
                                            }

                                            if ($(this).attr('month') == 6 && $(this).attr('day') == 31) {

                                                unixNextMonth = Math.floor(mildate.setHours(0)) + 2592000000;

                                            }


                                            jdate = new JDate(new Date(unixNextMonth));
                                            mildate = new Date(unixNextMonth);
                                            $('#miladi').empty();
                                            $('#shamsi').empty();
                                            $('#dayTable').empty();
                                            $('#shamsiEvent').empty();
                                            $('#hijriEvent').empty();


                                            $('#miladi').prepend(`<div class="col-12 text-center"><span id="ytimetablemi"> ${mildate.getFullYear()}</span></div>`);
                                            $('#shamsi').prepend(`<span id="ytimetablesh"> ${jdate.date['0']}</span>`);

                                            ///miladi month
                                            if (mildate.getMonth() == '0') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="1">January</span>`)
                                            }
                                            if (mildate.getMonth() == '1') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="2">February</span>`)
                                            }
                                            if (mildate.getMonth() == '2') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="3">March</span>`)
                                            }
                                            if (mildate.getMonth() == '3') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="4">April</span>`)
                                            }
                                            if (mildate.getMonth() == '4') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="5">May</span>`)
                                            }
                                            if (mildate.getMonth() == '5') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="6">June</span>`)
                                            }
                                            if (mildate.getMonth() == '6') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="7">July</span>`)
                                            }
                                            if (mildate.getMonth() == '7') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="8">August</span>`)
                                            }
                                            if (mildate.getMonth() == '8') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="9">September</span>`)
                                            }
                                            if (mildate.getMonth() == '9') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="10">October</span>`)
                                            }
                                            if (mildate.getMonth() == '10') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="11">November</span>`)
                                            }
                                            if (mildate.getMonth() == '11') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="12">December</span>`)
                                            }
                                            ///jalali month
                                            if (jdate.date['1'] == '1') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="1">فروردین</span>`)
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 31) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '2') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="2">اردیبهشت</span>`)
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 31) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '3') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="3">خرداد</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 31) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '4') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="4">تیر</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 31) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });

                                            }
                                            if (jdate.date['1'] == '5') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="5">مرداد</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 31) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '6') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="6">شهریور</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 31) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '7') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="7">مهر</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 30) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '8') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="8">آبان</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 30) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '9') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="9">آذر</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 30) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '10') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="10">دی</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 30) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '11') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="11">بهمن</span>`)
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 30) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '12') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="12">اسفند</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 29) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }

                                            for (let i = 1; i <= 31; i++) {
                                                let jdate2 = new JDate(jdate.date[0], jdate.date[1], i)
                                                let mildate2 = JDate.toGregorian(jdate.date[0], jdate.date[1], i);
                                                miladi3.push(mildate2);
                                                // console.log(mildate2.toHijri().date)
                                                // hijri.push([mildate2.toHijri.date,hijriDay.toHijri.month]);
                                                hijri2 = mildate.toHijri();
                                                // console.log(hijri2);
                                                let hijriMonth = hijri2.month
                                                let hijriDay = hijri2.date
                                                let solarMonth = jdate.date[1];
                                                let solarDay = jdate.date[2];


                                                $.ajax({
                                                    url: "https://farsicalendar.com/api/sh/" + i + "/" + solarMonth,
                                                    dataType: 'json',
                                                    success: function (data) {
                                                        if (data.values.length != 0) {
                                                            // console.log(data.values[0].occasion)


                                                            $('#shamsiEvent').append(`<li>${i}: ${data.values[0].occasion}</li>`)
                                                        }


                                                    }
                                                });
                                            }
                                            miladi3.forEach(function (item, index) {
                                                // console.log(item.toHijri().date)
                                                // console.log(item.toHijri().month)


                                                $.ajax({
                                                    url: "https://farsicalendar.com/api/ic/" + item.toHijri().date + "/" + item.toHijri().month,
                                                    dataType: 'json',
                                                    success: function (data) {

                                                        if (data.values.length != 0) {
                                                            // console.log(data.values[0].occasion)


                                                            $('#hijriEvent').append(`<li>${new JDate(item).date[2]}: ${data.values[0].occasion}</li>`)
                                                        }

                                                    },
                                                    error: function (error) {
                                                        console.log(error);
                                                    }

                                                });


                                            })


                                            //////picker
                                            $('.tdDay').click(function (ee) {
                                                let clicktarikh = $(this).attr('tarikh').split('/');
                                                clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                                let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                                let beShamsiKamel = new JDate(new Date(miladi)).format('dddd DD MMMM YYYY');
                                                let bargashtUnix = new Date($('#bargasht').val()).getTime();
                                                let raftmiladi = new Date(miladi).getTime();

                                                if ($('.tdDay.bg-warning').length == 0 && $('.tdDay.bg-success').length == 1) {
                                                    $('#reserve').prop("disabled", false);
                                                }
                                                if ($(this).hasClass('bg-warning')) {
                                                    // $('.tdDay').removeClass('gozashteh').css('opacity', '100%');
                                                    let indexof = tarikhs.indexOf(miladi);
                                                    tarikhs.splice(indexof, 1);
                                                    $('#raft').val('');
                                                    $('#from').empty();
                                                    $('#reserve').prop("disabled", true);
                                                    $('#reserve').children().first().attr('selected', 'selected');
                                                    $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
                                                } else if ($(this).hasClass('gozashte')) {
                                                    toastr.error('روز های گذشته را نمی توان انتخاب نمود.')
                                                } else if ($(this).hasClass('reserved')) {
                                                    toastr.error('این روز قبلاٌ رزرو شده است.')
                                                } else if ($(this).hasClass('gozashteh')) {
                                                    toastr.error('روز های گذشته را نمیشه انتخاب نمود.')
                                                } else if ($('.bg-warning').length == 0 && $('#raft').val() == "") {
                                                    if (bargashtUnix < raftmiladi) {
                                                        $('#bargasht').val('');
                                                    }
                                                    $('.tdDay').each(function () {
                                                        let attr = $(this).attr('tarikh').split('/');
                                                        pastDate = JalaliDate.jalaliToGregorian(attr[0], attr[1], attr[2]);

                                                        let pastMiladi = pastDate[0] + "-" + pastDate[1] + "-" + pastDate[2];
                                                        let newmiladi = new Date(miladi).getTime();
                                                        let newpastMiladi = new Date(pastMiladi).getTime();
                                                        if (newpastMiladi < newmiladi) {
                                                            $(this).css('opacity', '50%').addClass('gozashteh');
                                                        }

                                                    })
                                                    $(this).addClass('bg-warning');
                                                    $('#raft').val(miladi);
                                                    $('#from').html(beShamsiKamel);


                                                } else if (($('.bg-warning').length == 1 || $('#raft').val() != "") && $('.tdDay.bg-success').length == 0 && $('#bargasht').val() == "") {
                                                    $(this).addClass('bg-success');
                                                    $('#bargasht').val(miladi);
                                                    $('#to').html(beShamsiKamel);
                                                    $('#reserve').prop("disabled", false);
                                                } else if ($(this).hasClass('bg-success')) {
                                                    $(this).removeClass('bg-success');
                                                    $('#bargasht').val("");
                                                    $('#to').empty();
                                                    $('#reserve').prop("disabled", true);
                                                    $('#reserve').children().first().attr('selected', 'selected');
                                                    $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
                                                }
                                                if ($('.tdDay.bg-success').hasClass('gozashteh')) {

                                                    $('.tdDay').removeClass('bg-success');
                                                    $('#bargasht').val("");
                                                    $('#to').empty();
                                                    $('#reserve').prop("disabled", true);
                                                    $('#reserve').children().first().attr('selected', 'selected');
                                                    $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');

                                                }

                                                let tarikhPicked = $(this).attr('tarikh').split('/');

                                                jdate19 = new JDate(tarikhPicked[0], tarikhPicked[1], tarikhPicked[2]);

                                                $('#datePicked').html(`<h6>${jdate19.format('dddd DD MMMM YYYY')}</h6>`);


                                            });
                                            ///////disable pass day

                                            $('.tdDay').each(function (index) {
                                                if (new Date($(this).attr('miladi')).getTime() == new Date(item.raft).getTime()) {
                                                    $(this).addClass('bg-warning');
                                                    $('#raft').val(miladi);
                                                    $('#from').html(beShamsiKamel);
                                                }
                                                let $this = $(this);
                                                let clicktarikh = $(this).attr('tarikh').split('/');
                                                clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                                let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                                $(this).attr('miladi', miladi);
                                                let totalToday = JDate.toGregorian(jdateNow.date[0], jdateNow.date[1], jdateNow.date[2]).getTime();
                                                let weekDay = new Date(miladi).getDay();
                                                if (weekDay == 0) {
                                                    $(this).append(`<br><i style="font-size: 9px">ی</i>`)
                                                }
                                                if (weekDay == 1) {
                                                    $(this).append(`<br><i style="font-size: 9px">د</i>`)
                                                }
                                                if (weekDay == 2) {
                                                    $(this).append(`<br><i style="font-size: 9px">س</i>`)
                                                }
                                                if (weekDay == 3) {
                                                    $(this).append(`<br><i style="font-size: 9px">چ</i>`)
                                                }
                                                if (weekDay == 4) {
                                                    $(this).append(`<br><i style="font-size: 9px">پ</i>`)
                                                }
                                                if (weekDay == 5) {
                                                    $(this).append(`<br><i style="font-size: 9px">ج</i>`)
                                                }
                                                if (weekDay == 6) {
                                                    $(this).append(`<br><i style="font-size: 9px">ش</i>`)
                                                }
                                                thisDayTotalSplit = $(this).attr('tarikh').split('/');
                                                let beShamsiKamel = new JDate(new Date(miladi)).format('dddd DD MMMM YYYY');
                                                thisDayTotal = JDate.toGregorian(parseInt(thisDayTotalSplit[0]), parseInt(thisDayTotalSplit[1]), parseInt(thisDayTotalSplit[2])).getTime();
                                                if ($('#raft').val() == miladi) {
                                                    $(this).addClass('bg-warning');
                                                }
                                                if ($('#bargasht').val() == miladi) {
                                                    $(this).addClass('bg-success');
                                                }
                                                if (thisDayTotal < totalToday) {
                                                    $(this).css('opacity', '50%').addClass('gozashte');
                                                }
                                                tarikhs.forEach(function (item, index) {
                                                    if (item == miladi) {
                                                        $this.addClass('bg-warning');
                                                    }
                                                });
                                            });

                                        });

                                        //////premonth
                                        $('#preMonth').click(function (ee) {
                                            $(this).attr('month', jdate.date[1])
                                            $(this).attr('day', jdate.date[2])
                                            let miladi3 = [];
                                            let unixNextMonth = Math.floor(mildate.setHours(0)) - 2592000000;

                                            if ($(this).attr('month') == 1 && $(this).attr('day') == 1) {
                                                unixNextMonth = Math.floor(mildate.setHours(0)) - 2505600000;
                                            }

                                            if ($(this).attr('month') == 1 || $(this).attr('month') == 2 || $(this).attr('month') == 3 ||
                                                $(this).attr('month') == 4 || $(this).attr('month') == 5 || $(this).attr('month') == 6) {

                                                unixNextMonth = Math.floor(mildate.setHours(0)) - 2678400000;
                                            }
                                            // let unixNextMonth = strtotime('+1 month',mildate);


                                            jdate = new JDate(new Date(unixNextMonth));
                                            mildate = new Date(unixNextMonth);
                                            $('#miladi').empty();
                                            $('#shamsi').empty();
                                            $('#dayTable').empty();
                                            $('#shamsiEvent').empty();
                                            $('#hijriEvent').empty();


                                            $('#miladi').prepend(`<div class="col-12 text-center"><span id="ytimetablemi"> ${mildate.getFullYear()}</span></div>`);
                                            $('#shamsi').prepend(`<span id="ytimetablesh"> ${jdate.date['0']}</span>`);

                                            ///miladi month
                                            if (mildate.getMonth() == '0') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="1">January</span>`)
                                            }
                                            if (mildate.getMonth() == '1') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="2">February</span>`)
                                            }
                                            if (mildate.getMonth() == '2') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="3">March</span>`)
                                            }
                                            if (mildate.getMonth() == '3') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="4">April</span>`)
                                            }
                                            if (mildate.getMonth() == '4') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="5">May</span>`)
                                            }
                                            if (mildate.getMonth() == '5') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="6">June</span>`)
                                            }
                                            if (mildate.getMonth() == '6') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="7">July</span>`)
                                            }
                                            if (mildate.getMonth() == '7') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="8">August</span>`)
                                            }
                                            if (mildate.getMonth() == '8') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="9">September</span>`)
                                            }
                                            if (mildate.getMonth() == '9') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="10">October</span>`)
                                            }
                                            if (mildate.getMonth() == '10') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="11">November</span>`)
                                            }
                                            if (mildate.getMonth() == '11') {
                                                $('#miladi').prepend(`<span id="mtimetablesh" month="12">December</span>`)
                                            }
                                            ///jalali month
                                            if (jdate.date['1'] == '1') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="1">فروردین</span>`)
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 31) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '2') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="2">اردیبهشت</span>`)
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 31) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '3') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="3">خرداد</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 31) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '4') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="4">تیر</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 31) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });

                                            }
                                            if (jdate.date['1'] == '5') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="5">مرداد</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 31) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '6') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="6">شهریور</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 31) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '7') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="7">مهر</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 30) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '8') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="8">آبان</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 30) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '9') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="9">آذر</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 30) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '10') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="10">دی</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 30) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '11') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="11">بهمن</span>`)
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 30) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }
                                            if (jdate.date['1'] == '12') {
                                                $('#shamsi').prepend(`<span id="mtimetablesh" month="12">اسفند</span>`);
                                                let days = 0;
                                                for (let i = 1; i <= 5; i++) {
                                                    $('#dayTable').append(`<tr class="titr"></tr>`);
                                                    for (let j = 1; j <= 7; j++) {
                                                        days = days + 1;
                                                        $('.titr').last().append(`<td class="text-center tdDay" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                        if (days == 29) {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $('.tdDay').hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "white");
                                                });
                                                $('.tdDay').each(function (index) {

                                                    if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                        $(this).css('background', 'blue').css('color', 'white');
                                                        $(this).hover(function () {
                                                            $(this).css("background-color", "#dee2e6");
                                                        }, function () {
                                                            $(this).css("background-color", "blue").css('color', 'white');
                                                        });
                                                    }
                                                });
                                            }

                                            for (let i = 1; i <= 31; i++) {
                                                let jdate2 = new JDate(jdate.date[0], jdate.date[1], i)
                                                let mildate2 = JDate.toGregorian(jdate.date[0], jdate.date[1], i);
                                                miladi3.push(mildate2);
                                                // console.log(mildate2.toHijri().date)
                                                // hijri.push([mildate2.toHijri.date,hijriDay.toHijri.month]);
                                                hijri2 = mildate.toHijri();
                                                // console.log(hijri2);
                                                let hijriMonth = hijri2.month
                                                let hijriDay = hijri2.date
                                                let solarMonth = jdate.date[1];
                                                let solarDay = jdate.date[2];


                                                $.ajax({
                                                    url: "https://farsicalendar.com/api/sh/" + i + "/" + solarMonth,
                                                    dataType: 'json',
                                                    success: function (data) {
                                                        if (data.values.length != 0) {
                                                            // console.log(data.values[0].occasion)


                                                            $('#shamsiEvent').append(`<li>${i}: ${data.values[0].occasion}</li>`)
                                                        }


                                                    }
                                                });
                                            }
                                            miladi3.forEach(function (item, index) {


                                                $.ajax({
                                                    url: "https://farsicalendar.com/api/ic/" + item.toHijri().date + "/" + item.toHijri().month,
                                                    dataType: 'json',
                                                    success: function (data) {

                                                        if (data.values.length != 0) {
                                                            // console.log(data.values[0].occasion)


                                                            $('#hijriEvent').append(`<li>${new JDate(item).date[2]}: ${data.values[0].occasion}</li>`)
                                                        }

                                                    },
                                                    error: function (error) {
                                                        console.log(error);
                                                    }

                                                });
                                            });

                                            //////picker
                                            $('.tdDay').click(function (ee) {
                                                let clicktarikh = $(this).attr('tarikh').split('/');
                                                clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                                let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                                let beShamsiKamel = new JDate(new Date(miladi)).format('dddd DD MMMM YYYY');
                                                let bargashtUnix = new Date($('#bargasht').val()).getTime();
                                                let raftmiladi = new Date(miladi).getTime();

                                                if ($('.tdDay.bg-warning').length == 0 && $('.tdDay.bg-success').length == 1) {
                                                    $('#reserve').prop("disabled", false);
                                                }
                                                if ($(this).hasClass('bg-warning')) {
                                                    // $('.tdDay').removeClass('gozashteh').css('opacity', '100%');
                                                    let indexof = tarikhs.indexOf(miladi);
                                                    tarikhs.splice(indexof, 1);
                                                    $('#raft').val('');
                                                    $('#from').empty();
                                                    $('#reserve').prop("disabled", true);
                                                    $('#reserve').children().first().attr('selected', 'selected');
                                                    $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
                                                } else if ($(this).hasClass('gozashte')) {
                                                    toastr.error('روز های گذشته را نمی توان انتخاب نمود.')
                                                } else if ($(this).hasClass('reserved')) {
                                                    toastr.error('این روز قبلاٌ رزرو شده است.')
                                                } else if ($(this).hasClass('gozashteh')) {
                                                    toastr.error('روز های گذشته را نمیشه انتخاب نمود.')
                                                } else if ($('.bg-warning').length == 0 && $('#raft').val() == "") {
                                                    if (bargashtUnix < raftmiladi) {
                                                        $('#bargasht').val('');
                                                    }
                                                    $('.tdDay').each(function () {
                                                        let attr = $(this).attr('tarikh').split('/');
                                                        pastDate = JalaliDate.jalaliToGregorian(attr[0], attr[1], attr[2]);

                                                        let pastMiladi = pastDate[0] + "-" + pastDate[1] + "-" + pastDate[2];
                                                        let newmiladi = new Date(miladi).getTime();
                                                        let newpastMiladi = new Date(pastMiladi).getTime();
                                                        if (newpastMiladi < newmiladi) {
                                                            $(this).css('opacity', '50%').addClass('gozashteh');
                                                        }

                                                    })
                                                    $(this).addClass('bg-warning');
                                                    $('#raft').val(miladi);
                                                    $('#from').html(beShamsiKamel);


                                                } else if (($('.bg-warning').length == 1 || $('#raft').val() != "") && $('.tdDay.bg-success').length == 0 && $('#bargasht').val() == "") {
                                                    $(this).addClass('bg-success');
                                                    $('#bargasht').val(miladi);
                                                    $('#to').html(beShamsiKamel);
                                                    $('#reserve').prop("disabled", false);
                                                } else if ($(this).hasClass('bg-success')) {
                                                    $(this).removeClass('bg-success');
                                                    $('#bargasht').val("");
                                                    $('#to').empty();
                                                    $('#reserve').prop("disabled", true);
                                                    $('#reserve').children().first().attr('selected', 'selected');
                                                    $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
                                                }
                                                if ($('.tdDay.bg-success').hasClass('gozashteh')) {

                                                    $('.tdDay').removeClass('bg-success');
                                                    $('#bargasht').val("");
                                                    $('#to').empty();
                                                    $('#reserve').prop("disabled", true);
                                                    $('#reserve').children().first().attr('selected', 'selected');
                                                    $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');

                                                }

                                                let tarikhPicked = $(this).attr('tarikh').split('/');

                                                jdate19 = new JDate(tarikhPicked[0], tarikhPicked[1], tarikhPicked[2]);

                                                $('#datePicked').html(`<h6>${jdate19.format('dddd DD MMMM YYYY')}</h6>`);


                                            });

                                            ///////disable pass day

                                            $('.tdDay').each(function (index) {
                                                if (new Date($(this).attr('miladi')).getTime() == new Date(item.raft).getTime()) {
                                                    $(this).addClass('bg-warning');
                                                    $('#raft').val(miladi);
                                                    $('#from').html(beShamsiKamel);
                                                }
                                                let $this = $(this);
                                                let clicktarikh = $(this).attr('tarikh').split('/');
                                                clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                                let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                                $(this).attr('miladi', miladi);
                                                let totalToday = JDate.toGregorian(jdateNow.date[0], jdateNow.date[1], jdateNow.date[2]).getTime();
                                                let weekDay = new Date(miladi).getDay();

                                                if (weekDay == 0) {
                                                    $(this).append(`<br><i style="font-size: 9px">ی</i>`)
                                                }
                                                if (weekDay == 1) {
                                                    $(this).append(`<br><i style="font-size: 9px">د</i>`)
                                                }
                                                if (weekDay == 2) {
                                                    $(this).append(`<br><i style="font-size: 9px">س</i>`)
                                                }
                                                if (weekDay == 3) {
                                                    $(this).append(`<br><i style="font-size: 9px">چ</i>`)
                                                }
                                                if (weekDay == 4) {
                                                    $(this).append(`<br><i style="font-size: 9px">پ</i>`)
                                                }
                                                if (weekDay == 5) {
                                                    $(this).append(`<br><i style="font-size: 9px">ج</i>`)
                                                }
                                                if (weekDay == 6) {
                                                    $(this).append(`<br><i style="font-size: 9px">ش</i>`)
                                                }
                                                thisDayTotalSplit = $(this).attr('tarikh').split('/');
                                                let beShamsiKamel = new JDate(new Date(miladi)).format('dddd DD MMMM YYYY');
                                                thisDayTotal = JDate.toGregorian(parseInt(thisDayTotalSplit[0]), parseInt(thisDayTotalSplit[1]), parseInt(thisDayTotalSplit[2])).getTime();
                                                if ($('#raft').val() == miladi) {
                                                    $(this).addClass('bg-warning');
                                                }
                                                if ($('#bargasht').val() == miladi) {
                                                    $(this).addClass('bg-success');
                                                }
                                                if (thisDayTotal < totalToday) {
                                                    $(this).css('opacity', '50%').addClass('gozashte');
                                                }
                                                tarikhs.forEach(function (item, index) {
                                                    if (item == miladi) {
                                                        $this.addClass('bg-warning');

                                                    }
                                                });
                                            });

                                        });


////////
                                        $('.time').clockTimePicker();


                                    });

                                    $('#reserve').change(function (e) {
                                        function numberWithCommas(x) {
                                            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                        }

                                        let raft = new Date($('#raft').val()).getTime();
                                        let bargasht = new Date($('#bargasht').val()).getTime();
                                        let diff = bargasht - raft;
                                        if ($(this).val() == '1') {

                                            let betDays = []
                                            let day = '';
                                            const oneDay = 1000 * 60 * 60 * 24;
                                            let countDays = Math.round(diff / oneDay);
                                            $('#days').val(countDays);
                                            $('#calculate').removeClass('d-none');
                                            $('#roozaneTitr').removeClass('d-none');
                                            $('#mahaneTitr').addClass('d-none');
                                            $('#totaldays').empty();
                                            $('#finallyPrice').empty();
                                            $('#totalPrice').empty();
                                            $('#takPrice').empty();
                                            $('#totalPriceInput').empty();
                                            $('#finallyPriceInput').empty();
                                            $('#countMonthTitr').empty();
                                            $('#tarikhMonth').empty();
                                            $('#tarikhMonthTitr').empty();
                                            let totalPrice = parseInt($('#days').val()) * parseInt($('#price').val());
                                            $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                                            $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                                            $("#totaldays").html(`${countDays} روز`);
                                            $("#takPrice").html(`${numberWithCommas($('#price').val()).substr(0, numberWithCommas($('#price').val()).length - 3)} تومان`);
                                            $("#totalPriceInput").val(totalPrice);
                                            $("#finallyPriceInput").val(totalPrice);
                                        }
                                        if ($(this).val() == '2') {

                                            const oneDay = 1000 * 60 * 60 * 24 * 30;
                                            let countDays = Math.round(diff / oneDay);
                                            console.log(countDays);
                                            if (countDays != 0) {
                                                $('#days').val(countDays);
                                                $('#calculate').removeClass('d-none');
                                                $('#mahaneTitr').removeClass('d-none');
                                                $('#roozaneTitr').addClass('d-none');
                                                $('#totaldays').empty();
                                                $('#finallyPrice').empty();
                                                $('#totalPrice').empty();
                                                $('#takPrice').empty();
                                                $('#totalPriceInput').empty();
                                                $('#finallyPriceInput').empty();
                                                $('#countMonthTitr').empty();
                                                $('#tarikhMonth').empty();
                                                $('#tarikhMonthTitr').empty();
                                                // $('#price').val($('#takht').children('option:selected').attr('price'));
                                                $('#price').val(parseInt($('#price').val()) * 30);
                                                console.log($('#price').val());
                                                let totalPrice = parseInt($('#days').val()) * parseInt($('#price').val());
                                                $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                                                $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                                                $("#totaldays").html(`${countDays} ماه`);
                                                $("#takPrice").html(`${numberWithCommas($('#price').val())} تومان`);
                                                $("#totalPriceInput").val(totalPrice);
                                                $("#finallyPriceInput").val(totalPrice);
                                            } else {
                                                toastr.error('در صورت اینکه تعداد روز ها کم تر از یک ماه است از نوع روزانه استفاده نمایید.');
                                                $('#reserve').children().first().attr('selected', 'selected');
                                                $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
                                            }
                                        }
                                    });

                                    $('#emaltakhfif').click(function (eee) {
                                        function numberWithCommas(x) {
                                            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                        }

                                        // let takhfif=$('#takhfif').val().replaceAll(',', "");
                                        let final = $('#totalPriceInput').val() - takhfif;
                                        $("#finallyPriceInput").val(final);
                                        $('#finallyPrice').html(`${numberWithCommas(final)} تومان`)
                                    });


                                    $('#paytype').change(function (ee) {
                                        if ($(this).val() == 'q') {
                                            $('#qestmonthTitr').removeClass('d-none');
                                            $('#countMonthTitr').removeClass('d-none');
                                        } else if ($(this).val() == 'n') {
                                            if ($('#countMonthTitr').hasClass('d-none') == false) {
                                                $('#countMonthTitr').addClass('d-none');
                                            }
                                            if ($('#qestmonthTitr').hasClass('d-none') == false) {
                                                $('#qestmonthTitr').addClass('d-none');
                                            }
                                            $('#tarikhMonthTitr').empty();
                                            $('#tarikhMonth').empty();
                                        }

                                        function numberWithCommas(x) {
                                            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                        }

                                        $('#countMonthTitr').empty();
                                        if ($(this).val() == 'q') {
                                            $('#countMonthTitr').html(`<div class="col-10"> <input min="1" type="number" class="form-control" id="countMonth" value="1"></div> <div class="col-2"> <span class="btn btn-secondary" id="tayidCount" style="cursor: pointer">تایید</span></div>`)
                                        }
                                        $('#tayidCount').click(function (ese) {


                                            $('#tarikhMonth').empty();
                                            let countMonth = $('#countMonth').val();
                                            let perMounth = parseInt($('#finallyPriceInput').val().replaceAll(',',''))/countMonth;
                                            $('#perMonth').val(perMounth);
                                            $('#tarikhMonthTitr').append(`<h6 id="perMonth" class="mt-3">${numberWithCommas(perMounth)} تومان مبلغ پرداختی هر نوبت</h6>`)
                                            for (let i = 0; i < countMonth; i++) {
                                                $('#tarikhMonth').append(`    <div class="col-6 mt-3 pt-3" style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;" id="takhfifTitr">نوبت ${i + 1}:</div>
                                <div class="col-6 mt-3 pt-3" style="border-top: 1px solid #bdc4c4;text-align: right;">   <input name="qesttarikh[]" autocomplete="off" class="form-control jalal"></div>`);
                                            }
                                            $(".jalal").persianDatepicker({

                                            });

                                        });


                                    });
                                });
                                $('.plusNaqd').click(function (ew) {

                                    $('.naghdi').last().after(`        <div class="naghdi row col-11">
                                        <div class="col-1 text-center mt-3 adad">
                                           <i class="fa fa-credit-card"></i>
                                        </div>

                                    <div class="col-9 row">
                                        <div class="col-lg-6 mt-2">  <input class="form-control naqdtypeTitle" name="naqdtypeTitle[]" placeholder="نوع پرداخت" value=""></div>
                                        <div class="col-lg-6 mt-2">   <input class="form-control seprator justnumber naqdtypeMablagh" name="naqdtypeMablagh[]" placeholder="مبلغ (به تومان)"></div>


                                    </div>
                                    <div class="col-1 text-center mt-3">
                                        <span class="btn mt-1 p-0 removeNaqd" data-id="" style="cursor: pointer"><i class="fa fa-minus"></i> </span>
                                    </div>
                                    </div>`);
                                    $('.removeNaqd').click(function (ew) {
                                        $(this).parents('.naghdi').remove();
                                    });
                                    $('.justnumber').on("keypress",function(e)
                                    {

                                        if (isNaN(e.key))
                                        {
                                            e.preventDefault()
                                        }

                                        if (e.key==" "){
                                            e.preventDefault()
                                        }

                                    });
                                    function separateNum(value, input) {
                                        /* seprate number input 3 number */
                                        var nStr = value + '';
                                        nStr = nStr.replace(/\,/g, "");
                                        x = nStr.split('.');
                                        x1 = x[0];
                                        x2 = x.length > 1 ? '.' + x[1] : '';
                                        var rgx = /(\d+)(\d{3})/;
                                        while (rgx.test(x1)) {
                                            x1 = x1.replace(rgx, '$1' + ',' + '$2');
                                        }
                                        if (input !== undefined) {
                                            input.value = x1 + x2;
                                        } else {
                                            return x1 + x2;
                                        }
                                    }
                                    $('.seprator').keyup(function (e){
                                        let value = $(this).val();
                                        separateNum(value,$(this)[0])

                                    });

                                });
                                $("#submit").submit(function (e) {
                                    $('#takhfif').val($('#takhfif').val().replaceAll(',', ""));
                                    if ($('#raft').val()==""){
                                        e.preventDefault();
                                        toastr.error('تاریخ رفت مشخص نیست.');
                                    }

                                    if ($('#bargasht').val()==""){
                                        e.preventDefault();
                                        toastr.error('تاریخ برگشت مشخص نیست.');
                                    }

                                    if ($('#reserve').val()==''){
                                        e.preventDefault();
                                        toastr.error('انتخاب نوع رزرو الزامیست.');
                                    }
                                    if ($('#takht').val()==''){
                                        e.preventDefault();
                                        toastr.error('انتخاب تخت الزامیست.');
                                    }
                                    if ($('#pansion').val()==''){
                                        e.preventDefault();
                                        toastr.error('انتخاب خوابگاه الزامیست.');
                                    }
                                    if ($('#room').val()==''){
                                        e.preventDefault();
                                        toastr.error('انتخاب اتاق الزامیست.');
                                    }

                                    if ($('#user').val()==''){
                                        e.preventDefault();
                                        toastr.error('انتخاب مشترک الزامیست.');
                                    }
                                    let totalType=0;
                                    $('.naqdtypeMablagh').each(function (index) {
                                        $(this).val($(this).val().replaceAll(',',""));
                                        if ($(this).val()!=''){
                                            totalType=totalType+parseFloat($(this).val());
                                        }

                                        if ($(this).val()!="" && $(this).parents('.col-lg-6').siblings('.col-lg-6').children('.naqdtypeTitle').val()==""){
                                            e.preventDefault();
                                            toastr.error('نوع پرداخت یکی از مبالغ درست نیست.');
                                        }
                                    });
                                    if (totalType!=$('#finallyPriceInput').val()){
                                        e.preventDefault();
                                        toastr.error('مجموع پرداختی ها با مبلغ نهایی برابر نمی باشد.');
                                    }

                                });
                            } else {
                                $('tbody').append(`<p style="padding: 20px">رزروی برای مشترک وجود ندارد.</p>`)
                            }


                        }
                    }
                );


            });
            // $('#urlVideo').change(function (e) {
            //     let video = $('#video');
            //     let urlVal = $(this).val();
            //     video.empty();
            //     video.append(`<source src="${urlVal}" type="video/mp4">`)
            //     // video.onload = function() {
            //     // show video element
            //     video.removeClass('d-none');
            //     // }
            //
            //     // video.onerror = function() {
            //     //     alert('error, couldn\'t load');
            //     //     // don't show video element
            //     // }
            // });
            ///setProductsForm
            $('#product-attach').change(function (e) {
                let files = e.target.files;
                // console.log(files)
                let file = files[0];
                let reader = new FileReader();
                reader.onload = (function (theFile) {
                    $('.single-show-img').remove();
                    $('#noneImg').remove();
                    var imgSrc = theFile.target.result;
                    $('.singleShow').append("<img class='single-show-img' style='width: 400px;height: 400px' src='" + imgSrc + "'> ")
                });
                reader.readAsDataURL(this.files[0]);
            });
//
// // Read in the image file as a data URL.

//             });


            $("#submit").submit(function (e) {

                if ($('#paytype').val()=='q'){

                    if ($('.jalal').length==0){
                        e.preventDefault();
                        toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');
                    }
                    else {
                        $('.jalal').each(function (index) {

                            if ($(this).val()==""){

                                e.preventDefault();
                                toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');

                            }
                            else {

                                // let clicktarikh = $(this).val().split('/');
                                // clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                // let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                // $(this).val(miladi);

                            }


                        });


                    }
                    let clicktarikh=$(this).attr('tarikh').split('/');
                    clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                    let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                }


            });

        })
    </script>

@endsection
@section('css')

    #timeTable {
        height: 448.719px;
    }

    .select2 {
        width: 100% !important;
    }

@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row w-100">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">کنسلی رزرو</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    {{--                    <li class="breadcrumb-item">خانه</li>--}}
                    {{--                    <li class="breadcrumb-item">فرم</li>--}}
                    {{--                    <li class="breadcrumb-item">عناصر</li>--}}
                    {{--                    <li class="breadcrumb-item active"><a href="#">کادرهای انتخاب</a></li>--}}
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <div class="container-fluid card">
        <div class="row">
            <div class="col-12 col-lg-3 mb-5 mt-5">
                <label class="form-label mb-2" for="day">مشترک</label>
                <br>
                <select name="user_id" class="select2 form-control" id="user">
                    <option value="">مشترک را انتخاب کنبد.</option>
                    @if($users!='notfound')
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}} {{$user->family}}</option>
                        @endforeach
                    @endif
                </select>

            </div>
        </div>
    </div>


    <!-- reserves table-->
    <div class="container-fluid card border-top row m-auto">
        <h2 class="mb-3 pt-2">جدول رزرو ها</h2>
        <table class="align-right table table-hover table-dark table-striped mytable w-100">
            <thead>
            <tr>

                <th>شماره لیست</th>
                <th>نام پانسیون</th>
                <th>شماره اتاق</th>
                <th>شماره تخت</th>
                <th>شماره رزرو</th>
                <th>ثبت کننده</th>
                <th>وضعیت</th>
                <th>جابجایی</th>
                <th>تاریخ شروع</th>
                <th>تاریخ پایان</th>
                <th>تنظیمات</th>
            </tr>
            </thead>
            <tbody>

            </tbody>

        </table>
    </div>

@endsection
