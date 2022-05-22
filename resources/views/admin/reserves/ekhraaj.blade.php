@extends('admin.master.home')


@section('js')
{{--    <script src="https://rawgit.com/abdennour/hijri-date/master/cdn/hijri-date-latest.js"--}}
{{--            type="text/javascript"></script>--}}
    <script src="{{asset('admin/js/hijri-date-latest.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin')}}/js/jdate.min.js" type="text/javascript" charset="utf-8"></script>

    <script>

        $(document).ready(function () {
            let contFile = 0;
            $('#monthsTitr').hide();
            let beShamsiKamels = new JDate(new Date('{!! $order->raft !!}')).format('dddd DD MMMM YYYY')
            $('#raft').val("{!! $order->raft !!}");
            $('#from').html(beShamsiKamels);

            $('#price').val('{!! $order->takht->price !!}');
            $('.hrefbtn').attr('href', "{{route('order.create')}}");
            let addpubcheck = [];
//////ckeditor
            CKEDITOR.replace('editor', {
                language: "fa",

            });
            $('#showItem').change(function (e) {
                if ($(this).is(':checked')) {
                    $(this).val('1');
                } else {
                    $(this).val('0');
                }
            });


            let userId = "{!! $order->user_id !!}";
            $.ajax(
                {
                    url: "{{asset('admin/getorderbyuser')}}/" + userId,
                    success: function (data) {
                        // $('tbody').empty()
                        if (data != 'notfound') {
                            data.forEach(function (item, index) {


                                if (item.status_order_id == 1 || item.status_order_id == 2) {


                                    $('#submit').attr('action', "{{route('ekhraaj',$order->id)}}");
                                    $('#submit').prepend(`<input class="d-none" name="_token" value="{{csrf_token()}}">`);


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


                                ////refresh
                                $('#dayTable').empty();
                                $('#titrTarikh').remove();
                                $('#preMonth').remove();
                                $('#nextMonth').remove();
                                $('#miladiTitr').remove();
                                $('#tarikhclicked').remove();
                                // $('#raft').val('');
                                $('#bargasht').val('');
                                $('#timeTable').css('border', 'none')
                                // $('#mainTable').empty();

                                $('.hrefbtn').hide()

                                let jdateNow = new JDate;

                                let jdate = "";
                                if (new URL(location.href).searchParams.get('taghvim') == 'begin') {

                                    jdate = new JDate(new Date('{!! $order->raft !!}'));

                                } else if (new URL(location.href).searchParams.get('taghvim') == 'recent') {
                                    jdate = new JDate;
                                } else if (new URL(location.href).searchParams.get('taghvim') == 'end') {
                                    jdate = new JDate(new Date('{!! $order->bargasht !!}'));
                                } else {
                                    jdate = new JDate(new Date('{!! $order->raft !!}'));
                                }

                                let mildate = JDate.toGregorian(jdate.date[0], jdate.date[1], jdate.date[2]);
                                let tarikhs = [];

                                $('#timeTable').prepend(`<div class="col-12 text-center" id="tarikhclicked"><h6> تاریخ امروز: ${jdateNow.format('dddd DD MMMM YYYY')}</h6></div>`);
                                $('#timeTable').prepend(`<div class="col-12 text-center" id="miladiTitr"><h6 id="miladi" class="text-center mt-2 text-info"><span id="ytimetablemi"> ${mildate.getFullYear()}</span></h6></div>`);
                                $('#timeTable').prepend(`<div class="col-4 mt-2" id="nextMonth" style="cursor: pointer"><i class="fas fa-arrow-right"></i></div> <div class="col-4 " id="titrTarikh"> <h4 id="shamsi" class="text-center mt-2 text-primary"><span id="ytimetablesh"> ${jdate.date['0']}</span></h4></div><div class="col-4 mt-2 px-4" id="preMonth" style="cursor: pointer;text-align: left"><i class="fas fa-arrow-left"></i></div>`);


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
                                        $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                        for (let j = 1; j <= 7; j++) {
                                            days = days + 1;
                                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}" style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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
                                        $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                        for (let j = 1; j <= 7; j++) {
                                            days = days + 1;
                                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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
                                        $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                        for (let j = 1; j <= 7; j++) {
                                            days = days + 1;
                                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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
                                        $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                        for (let j = 1; j <= 7; j++) {
                                            days = days + 1;
                                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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
                                        $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                        for (let j = 1; j <= 7; j++) {
                                            days = days + 1;
                                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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
                                        $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                        for (let j = 1; j <= 7; j++) {
                                            days = days + 1;
                                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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
                                        $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                        for (let j = 1; j <= 7; j++) {
                                            days = days + 1;
                                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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
                                        $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                        for (let j = 1; j <= 7; j++) {
                                            days = days + 1;
                                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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
                                        $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                        for (let j = 1; j <= 7; j++) {
                                            days = days + 1;
                                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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
                                        $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                        for (let j = 1; j <= 7; j++) {
                                            days = days + 1;
                                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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
                                        $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                        for (let j = 1; j <= 7; j++) {
                                            days = days + 1;
                                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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
                                        $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                        for (let j = 1; j <= 7; j++) {
                                            days = days + 1;
                                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                            if ((parseInt(jdate.date['0'])-1399)%4!=0 && days == 29){
                                                break;
                                            }
                                           else if (days == 30) {
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
                                    let thisraft = new Date("{!! $order->raft !!}").setHours(0, 0, 0, 0);
                                    let thisbargasht = new Date("{!! $order->bargasht !!}").setHours(0, 0, 0, 0);
                                    let clikeddate = new Date($(this).attr('miladi')).setHours(0, 0, 0, 0);

                                    if (thisraft == clikeddate) {
                                        $(this).addClass('bg-info');
                                    }
                                    if (thisbargasht == clikeddate) {
                                        $(this).addClass('bg-secondary');
                                    }
                                    if (new Date($(this).attr('miladi')).getTime() == new Date(item.raft).getTime()) {
                                        $(this).addClass('bg-warning');
                                        $('#raft').val(miladi);
                                        $('#from').html(beShamsiKamel);
                                    }
                                    if (new Date($(this).attr('miladi')).getTime() <= new Date('{!! $order->raft !!}').getTime()) {
                                        $(this).addClass('gozashte').css('color', 'red');
                                    }
                                    let weekDay = new Date(miladi).getDay();
                                    if (weekDay == 0) {
                                        if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                            $('#timeTable tbody tr').each(function (index) {

                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }
                                            });

                                        } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {


                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                        } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                            $('#timeTable tbody tr').each(function (index) {

                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }
                                            });
                                        }

                                        for (let i =1;i<=7;i++){
                                            if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                            }
                                            else{
                                                break;
                                            }
                                        }
                                    }
                                    if (weekDay == 1) {
                                        if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                            $('#timeTable tbody tr').each(function (index) {

                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }
                                            });

                                        } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {

                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                        } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                            $('#timeTable tbody tr').each(function (index) {

                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }
                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                            $('#timeTable tbody tr').each(function (index) {

                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }
                                            });
                                        }
                                        for (let i =1;i<=7;i++){
                                            if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                            }
                                            else{
                                                break;
                                            }
                                        }
                                    }
                                    if (weekDay == 2) {
                                        if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });

                                        } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                        } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                        }
                                        for (let i =1;i<=7;i++){
                                            if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                            }
                                            else{
                                                break;
                                            }
                                        }
                                    }
                                    if (weekDay == 3) {
                                        if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });

                                        } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {

                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                        } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                             $('#timeTable tbody tr').each(function (index) {
   if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
													}

                                            });
                                        }
                                        for (let i =1;i<=7;i++){
                                            if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                            }
                                            else{
                                                break;
                                            }
                                        }
                                    }
                                    if (weekDay == 4) {
                                        if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                            $('#timeTable tbody tr').each(function (index) {

                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }
                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });

                                        } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {

                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                } else {
                                                    let lastTrTd = $(this).children().last();

                                                    $(this).children().last().remove();

                                                    $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                }

                                            });
                                        } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">25</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                        }
                                        for (let i =1;i<=7;i++){
                                            if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                            }
                                            else{
                                                break;
                                            }
                                        }
                                    }
                                    if (weekDay == 5) {
                                        if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">25</td>`);
                                            $('#timeTable tbody tr').each(function (index) {

                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }
                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                            $('#timeTable tbody tr').each(function (index) {

                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }
                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });

                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            if ($(this).attr('month') == '12'){
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);

                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            }
                                            else {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    } else {
                                                        let lastTrTd = $(this).children().last();

                                                        $(this).children().last().remove();

                                                        $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                    }

                                                });
                                            }


                                        } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {

                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                            $('#timeTable tbody tr').each(function (index) {

                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }
                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            if ($(this).attr('month') == '7') {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    } else {
                                                        let lastTrTd = $(this).children().last();

                                                        $(this).children().last().remove();

                                                        $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                    }

                                                });
                                            }
                                            else {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    } else {
                                                        let lastTrTd = $(this).children().last();

                                                        $(this).children().last().remove();

                                                        $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    } else {
                                                        let lastTrTd = $(this).children().last();

                                                        $(this).children().last().remove();

                                                        $('#mainTable tbody').children('tr').last().append(lastTrTd[0].outerHTML );
                                                    }

                                                });
                                            }
                                        } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">25</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index!=$('#timeTable tbody tr').length-1) {
                                                    let lastTd=$(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                }

                                            });
                                            $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                            $('#timeTable tbody tr').each(function (index) {
                                                if (index != $('#timeTable tbody tr').length - 1) {
                                                    let lastTd = $(this).children().last();
                                                    $(this).children().last().remove();
                                                    $(this).next().prepend(lastTd[0]);
                                                } else {
                                                    let lastTrTd = $(this).children().last();

                                                    $(this).children().last().remove();

                                                    $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                }

                                            });
                                        }
                                        for (let i =1;i<=7;i++){
                                            if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                            }
                                            else{
                                                break;
                                            }
                                        }
                                    }
                                    if (weekDay == 6) {

                                    }

                                    $('.tdDay').hover(function () {
                                        $(this).css("background-color", "#dee2e6");
                                    }, function () {
                                        $(this).css("background-color", "white");
                                    });
                                    $('.tdDay').each(function (index) {

                                        if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                            $(this).css('background', 'blue').css('color', 'white');
                                            $(this).hover(function () {
                                                $(this).css("background-color", "#dee2e6");
                                            }, function () {
                                                $(this).css("background-color", "blue").css('color', 'white');
                                            });
                                        }
                                    });
                                    if (thisDayTotal < totalToday) {
                                        $(this).css('opacity', '50%').addClass('gozashte');
                                    }
                                    tarikhs.forEach(function (item, index) {
                                        if (item == miladi) {
                                            $this.addClass('bg-warning');
                                        }
                                    });

                                });
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
                                $(document).on('click', '.tdDay', function (ee) {
                                    console.log('his')
                                    let clicktarikh = $(this).attr('tarikh').split('/');
                                    clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                    let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                    let beShamsiKamel = new JDate(new Date(miladi)).format('dddd DD MMMM YYYY')
                                    let bargashtUnix = new Date($('#bargasht').val()).getTime();
                                    let raftmiladi = new Date(miladi).getTime();


                                    if ($(this).hasClass('bg-warning')) {
                                        // $('.tdDay').removeClass('gozashteh').css('opacity', '100%');
                                        let indexof = tarikhs.indexOf(miladi);
                                        tarikhs.splice(indexof, 1);
                                        // $('#raft').val('');
                                        // $('#from').empty();

                                    } else if ($(this).hasClass('gozashte')) {
                                        toastr.error('روز های گذشته را نمی توان انتخاب نمود.');

                                    } else if ($(this).hasClass('reserved')) {
                                        toastr.error('این روز قبلاٌ رزرو شده است.')
                                    } else if ($(this).hasClass('gozashteh')) {
                                        toastr.error('روز های گذشته را نمیشه انتخاب نمود.')
                                    } else if ($('#raft').val() == null) {

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


                                    } else if ($('#raft').val() != null && $('.tdDay.bg-success').length == 0 && $('#bargasht').val() == "") {
                                        $(this).addClass('bg-success');
                                        $('#bargasht').val(miladi);
                                        $('#to').html(beShamsiKamel);
                                    } else if ($(this).hasClass('bg-success')) {
                                        $(this).removeClass('bg-success');
                                        $('#bargasht').val("");
                                        $('#to').empty();

                                    }
                                    if ($('.tdDay.bg-success').hasClass('gozashteh')) {

                                        $('.tdDay').removeClass('bg-success');
                                        $('#bargasht').val("");
                                        $('#to').empty();


                                    }


                                    let tarikhPicked = $(this).attr('tarikh').split('/');

                                    jdate19 = new JDate(tarikhPicked[0], tarikhPicked[1], tarikhPicked[2]);

                                    $('#datePicked').html(`<h6>${jdate19.format('dddd DD MMMM YYYY')}</h6>`);


                                });

                                ///////disable pass day

                                //////nextmonth
                                $(document).on('click', '#nextMonth', function (ee) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                if ((parseInt(jdate.date['0'])-1399)%4!=0 && days == 29){
                                                    break;
                                                }
                                                else if (days == 30) {
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                $(this).css('background', 'blue').css('color', 'white');
                                                $(this).hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "blue").css('color', 'white');
                                                });
                                            }
                                        });
                                    }
                                    $('.tdDay').each(function (index) {

                                        let $this = $(this);
                                        let clicktarikh = $(this).attr('tarikh').split('/');
                                        clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                        let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                        $(this).attr('miladi', miladi);
                                        let totalToday = JDate.toGregorian(jdateNow.date[0], jdateNow.date[1], jdateNow.date[2]).getTime();
                                        let weekDay = new Date(miladi).getDay();
                                        let thisraft = new Date("{!! $order->raft !!}").setHours(0, 0, 0, 0);
                                        let thisbargasht = new Date("{!! $order->bargasht !!}").setHours(0, 0, 0, 0);
                                        let clikeddate = new Date($(this).attr('miladi')).setHours(0, 0, 0, 0);

                                        if (thisraft == clikeddate) {
                                            $(this).addClass('bg-info');
                                        }
                                        if (thisbargasht == clikeddate) {
                                            $(this).addClass('bg-secondary');
                                        }
                                        if (new Date($(this).attr('miladi')).getTime() == new Date('{!! $order->raft !!}').getTime()) {
                                            $(this).addClass('bg-warning');
                                            $('#raft').val(miladi);
                                            $('#from').html(new JDate(new Date(miladi)).format('dddd DD MMMM YYYY'));
                                        }
                                        if (new Date($(this).attr('miladi')).getTime() <= new Date('{!! $order->raft !!}').getTime()) {
                                            $(this).addClass('gozashte').css('color', 'red');
                                        }
                                        if (weekDay == 0) {
                                            if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });

                                            } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {


                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                            }

                                            for (let i =1;i<=7;i++){
                                                if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                    $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                                }
                                                else{
                                                    break;
                                                }
                                            }
                                        }
                                        if (weekDay == 1) {
                                            if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });

                                            } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {

                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                            }
                                            for (let i =1;i<=7;i++){
                                                if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                    $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                                }
                                                else{
                                                    break;
                                                }
                                            }
                                        }
                                        if (weekDay == 2) {
                                            if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });

                                            } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            }
                                            for (let i =1;i<=7;i++){
                                                if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                    $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                                }
                                                else{
                                                    break;
                                                }
                                            }
                                        }
                                        if (weekDay == 3) {
                                            if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });

                                            } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {

                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            }
                                            for (let i =1;i<=7;i++){
                                                if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                    $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                                }
                                                else{
                                                    break;
                                                }
                                            }
                                        }
                                        if (weekDay == 4) {
                                            if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });

                                            } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {

                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    } else {
                                                        let lastTrTd = $(this).children().last();

                                                        $(this).children().last().remove();

                                                        $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                    }

                                                });
                                            } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">25</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            }
                                            for (let i =1;i<=7;i++){
                                                if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                    $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                                }
                                                else{
                                                    break;
                                                }
                                            }
                                        }
                                        if (weekDay == 5) {
                                            if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">25</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });

                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                if ($(this).attr('month') == '12'){
                                                    $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);

                                                    $('#timeTable tbody tr').each(function (index) {
                                                        if (index != $('#timeTable tbody tr').length - 1) {
                                                            let lastTd = $(this).children().last();
                                                            $(this).children().last().remove();
                                                            $(this).next().prepend(lastTd[0]);
                                                        }

                                                    });
                                                }
                                                else {
                                                    $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                    $('#timeTable tbody tr').each(function (index) {
                                                        if (index != $('#timeTable tbody tr').length - 1) {
                                                            let lastTd = $(this).children().last();
                                                            $(this).children().last().remove();
                                                            $(this).next().prepend(lastTd[0]);
                                                        } else {
                                                            let lastTrTd = $(this).children().last();

                                                            $(this).children().last().remove();

                                                            $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                        }

                                                    });
                                                }


                                            } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {

                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                if ($(this).attr('month') == '7') {
                                                    $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                    $('#timeTable tbody tr').each(function (index) {
                                                        if (index != $('#timeTable tbody tr').length - 1) {
                                                            let lastTd = $(this).children().last();
                                                            $(this).children().last().remove();
                                                            $(this).next().prepend(lastTd[0]);
                                                        }

                                                    });
                                                    $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                    $('#timeTable tbody tr').each(function (index) {
                                                        if (index != $('#timeTable tbody tr').length - 1) {
                                                            let lastTd = $(this).children().last();
                                                            $(this).children().last().remove();
                                                            $(this).next().prepend(lastTd[0]);
                                                        } else {
                                                            let lastTrTd = $(this).children().last();

                                                            $(this).children().last().remove();

                                                            $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                        }

                                                    });
                                                }
                                                else {
                                                    $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                    $('#timeTable tbody tr').each(function (index) {
                                                        if (index != $('#timeTable tbody tr').length - 1) {
                                                            let lastTd = $(this).children().last();
                                                            $(this).children().last().remove();
                                                            $(this).next().prepend(lastTd[0]);
                                                        } else {
                                                            let lastTrTd = $(this).children().last();

                                                            $(this).children().last().remove();

                                                            $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                        }

                                                    });
                                                    $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                    $('#timeTable tbody tr').each(function (index) {
                                                        if (index != $('#timeTable tbody tr').length - 1) {
                                                            let lastTd = $(this).children().last();
                                                            $(this).children().last().remove();
                                                            $(this).next().prepend(lastTd[0]);
                                                        } else {
                                                            let lastTrTd = $(this).children().last();

                                                            $(this).children().last().remove();

                                                            $('#mainTable tbody').children('tr').last().append(lastTrTd[0].outerHTML );
                                                        }

                                                    });
                                                }
                                            } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">25</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    } else {
                                                        let lastTrTd = $(this).children().last();

                                                        $(this).children().last().remove();

                                                        $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                    }

                                                });
                                            }
                                            for (let i =1;i<=7;i++){
                                                if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                    $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                                }
                                                else{
                                                    break;
                                                }
                                            }
                                        }
                                        if (weekDay == 6) {

                                        }
                                        $('.tdDay').hover(function () {
                                            $(this).css("background-color", "#dee2e6");
                                        }, function () {
                                            $(this).css("background-color", "white");
                                        });
                                        $('.tdDay').each(function (index) {

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                $(this).css('background', 'blue').css('color', 'white');
                                                $(this).hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "blue").css('color', 'white');
                                                });
                                            }
                                        });

                                        if (thisDayTotal < totalToday) {
                                            $(this).css('opacity', '50%').addClass('gozashte');
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


                                    ///////disable pass day


                                    $(document).on('click', '.tdDay', function (e) {
                                        console.log('hi')

                                        if ($(this).hasClass('bg-success') == false) {
                                            $('#calculate').addClass('d-none');
                                            $('#freesubmit').addClass('d-none');
                                            $('#reserve').val('1');
                                            $('#totaldaysTitr').show();
                                            $('#totaldaysDiv').show();
                                            $('#monthsTitr').hide();
                                            $('#totalmonthsTitr').hide();
                                            $('#divMonth').addClass('d-none');
                                            $('#roozaneTitr').show();
                                            $('#mahaneTitr').addClass('d-none');

                                        } else {
                                            $('#price').val('{!! $order->takht->price !!}');

                                            function numberWithCommas(x) {
                                                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                            }

                                            let raft = new Date($('#raft').val()).getTime();
                                            let bargasht = new Date($('#bargasht').val()).getTime();
                                            let diff = bargasht - raft;


                                            let betDays = []
                                            let day = '';
                                            const oneDay = 1000 * 60 * 60 * 24;
                                            let countDays = Math.round(diff / oneDay);
                                            $('#days').val(countDays);
                                            $('#reserve').val('1');
                                            $('#calculate').removeClass('d-none');
                                            $('#freesubmit').removeClass('d-none');
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
                                            $("#finallyPriceInput").val(numberWithCommas(totalPrice));
                                            $('#bedehkar').val("{!! $order->bedehkar !!}");
                                            let bedehkar = $('#bedehkar').val();
                                            if (parseInt(bedehkar) == 0) {
                                                let thisTotal = "{!! $order->statusmali[0]->bedehkar !!}";
                                                let totalKhales = parseInt(thisTotal) - parseInt($("#finallyPriceInput").val().replaceAll(',', ""));

                                                if (totalKhales < 0) {
                                                    $('#finallyPriceInput').val(numberWithCommas(Math.abs(totalKhales)));
                                                    $('#bestankar').val(0);
                                                } else {
                                                    $('#finallyPriceInput').val('0');
                                                    $('#bestankar').val(parseInt(totalKhales));

                                                }

                                            } else if (parseInt(bedehkar) > 0) {
                                                let thisTotal = "{!! $order->statusmali[0]->bestankar !!}";
                                                if (thisTotal == "") {
                                                    thisTotal = 0;
                                                }

                                                let totalKhales = parseInt(thisTotal) - parseInt($("#finallyPriceInput").val().replaceAll(',', ""));

                                                if (totalKhales < 0) {

                                                    $('#finallyPriceInput').val(numberWithCommas(totalKhales * -1));
                                                } else {

                                                    $('#finallyPriceInput').val('0');
                                                    $('#bestankar').val(parseInt(totalKhales));

                                                }


                                            }
                                        }
                                    });
                                });

                                //////premonth
                                $(document).on('click', '#preMonth', function (ee) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" day="${jdate.date['2']}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                                            $('#dayTable').append(`<tr class="titr bg-white"></tr>`);
                                            for (let j = 1; j <= 7; j++) {
                                                days = days + 1;
                                                $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
                                                if ((parseInt(jdate.date['0'])-1399)%4!=0 && days == 29){
                                                    break;
                                                }
                                                else if (days == 30) {
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

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                $(this).css('background', 'blue').css('color', 'white');
                                                $(this).hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "blue").css('color', 'white');
                                                });
                                            }
                                        });
                                    }
                                    $('.tdDay').each(function (index) {


                                        let $this = $(this);
                                        let clicktarikh = $(this).attr('tarikh').split('/');
                                        clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                        let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                        $(this).attr('miladi', miladi);
                                        if (new Date($(this).attr('miladi')).getTime() == new Date('{!! $order->raft !!}').getTime()) {
                                            $(this).addClass('bg-warning');
                                            $('#raft').val(miladi);
                                            $('#from').html(new JDate(new Date(miladi)).format('dddd DD MMMM YYYY'));
                                        }
                                        if (new Date($(this).attr('miladi')).getTime() <= new Date('{!! $order->raft !!}').getTime()) {
                                            $(this).addClass('gozashte').css('color', 'red');
                                        }
                                        let totalToday = JDate.toGregorian(jdateNow.date[0], jdateNow.date[1], jdateNow.date[2]).getTime();
                                        let weekDay = new Date(miladi).getDay();
                                        let thisraft = new Date("{!! $order->raft !!}").setHours(0, 0, 0, 0);
                                        let thisbargasht = new Date("{!! $order->bargasht !!}").setHours(0, 0, 0, 0);
                                        let clikeddate = new Date($(this).attr('miladi')).setHours(0, 0, 0, 0);

                                        if (thisraft == clikeddate) {
                                            $(this).addClass('bg-info');
                                        }
                                        if (thisbargasht == clikeddate) {
                                            $(this).addClass('bg-secondary');
                                        }
                                        if (weekDay == 0) {
                                            if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });

                                            } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {


                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                            }

                                            for (let i =1;i<=7;i++){
                                                if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                    $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                                }
                                                else{
                                                    break;
                                                }
                                            }
                                        }
                                        if (weekDay == 1) {
                                            if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });

                                            } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {

                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                            }
                                            for (let i =1;i<=7;i++){
                                                if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                    $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                                }
                                                else{
                                                    break;
                                                }
                                            }
                                        }
                                        if (weekDay == 2) {
                                            if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });

                                            } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            }
                                            for (let i =1;i<=7;i++){
                                                if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                    $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                                }
                                                else{
                                                    break;
                                                }
                                            }
                                        }
                                        if (weekDay == 3) {
                                            if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });

                                            } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {

                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            }
                                            for (let i =1;i<=7;i++){
                                                if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                    $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                                }
                                                else{
                                                    break;
                                                }
                                            }
                                        }
                                        if (weekDay == 4) {
                                            if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });

                                            } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {

                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    } else {
                                                        let lastTrTd = $(this).children().last();

                                                        $(this).children().last().remove();

                                                        $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                    }

                                                });
                                            } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">25</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                            }
                                            for (let i =1;i<=7;i++){
                                                if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                    $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                                }
                                                else{
                                                    break;
                                                }
                                            }
                                        }
                                        if (weekDay == 5) {
                                            if (($(this).text() == '1' && $(this).attr('month') == '8') || ($(this).text() == '1' && $(this).attr('month') == '9') || ($(this).text() == '1' && $(this).attr('month') == '10') || ($(this).text() == '1' && $(this).attr('month') == '11') || ($(this).text() == '1' && $(this).attr('month') == '12')) {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">25</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });

                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                if ($(this).attr('month') == '12'){
                                                    $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);

                                                    $('#timeTable tbody tr').each(function (index) {
                                                        if (index != $('#timeTable tbody tr').length - 1) {
                                                            let lastTd = $(this).children().last();
                                                            $(this).children().last().remove();
                                                            $(this).next().prepend(lastTd[0]);
                                                        }

                                                    });
                                                }
                                                else {
                                                    $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                    $('#timeTable tbody tr').each(function (index) {
                                                        if (index != $('#timeTable tbody tr').length - 1) {
                                                            let lastTd = $(this).children().last();
                                                            $(this).children().last().remove();
                                                            $(this).next().prepend(lastTd[0]);
                                                        } else {
                                                            let lastTrTd = $(this).children().last();

                                                            $(this).children().last().remove();

                                                            $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                        }

                                                    });
                                                }


                                            } else if (($(this).text() == '1' && $(this).attr('month') == '2') || ($(this).text() == '1' && $(this).attr('month') == '3') || ($(this).text() == '1' && $(this).attr('month') == '4') || ($(this).text() == '1' && $(this).attr('month') == '5') || ($(this).text() == '1' && $(this).attr('month') == '6') || ($(this).text() == '1' && $(this).attr('month') == '7')) {

                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                                $('#timeTable tbody tr').each(function (index) {

                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }
                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                if ($(this).attr('month') == '7') {
                                                    $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                    $('#timeTable tbody tr').each(function (index) {
                                                        if (index != $('#timeTable tbody tr').length - 1) {
                                                            let lastTd = $(this).children().last();
                                                            $(this).children().last().remove();
                                                            $(this).next().prepend(lastTd[0]);
                                                        }

                                                    });
                                                    $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                    $('#timeTable tbody tr').each(function (index) {
                                                        if (index != $('#timeTable tbody tr').length - 1) {
                                                            let lastTd = $(this).children().last();
                                                            $(this).children().last().remove();
                                                            $(this).next().prepend(lastTd[0]);
                                                        } else {
                                                            let lastTrTd = $(this).children().last();

                                                            $(this).children().last().remove();

                                                            $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                        }

                                                    });
                                                }
                                                else {
                                                    $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">30</td>`);
                                                    $('#timeTable tbody tr').each(function (index) {
                                                        if (index != $('#timeTable tbody tr').length - 1) {
                                                            let lastTd = $(this).children().last();
                                                            $(this).children().last().remove();
                                                            $(this).next().prepend(lastTd[0]);
                                                        } else {
                                                            let lastTrTd = $(this).children().last();

                                                            $(this).children().last().remove();

                                                            $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                        }

                                                    });
                                                    $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">31</td>`);
                                                    $('#timeTable tbody tr').each(function (index) {
                                                        if (index != $('#timeTable tbody tr').length - 1) {
                                                            let lastTd = $(this).children().last();
                                                            $(this).children().last().remove();
                                                            $(this).next().prepend(lastTd[0]);
                                                        } else {
                                                            let lastTrTd = $(this).children().last();

                                                            $(this).children().last().remove();

                                                            $('#mainTable tbody').children('tr').last().append(lastTrTd[0].outerHTML );
                                                        }

                                                    });
                                                }
                                            } else if ($(this).text() == '1' && $(this).attr('month') == '1') {
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">25</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">26</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">27</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">28</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index!=$('#timeTable tbody tr').length-1) {
                                                        let lastTd=$(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    }

                                                });
                                                $(this).before(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">29</td>`);
                                                $('#timeTable tbody tr').each(function (index) {
                                                    if (index != $('#timeTable tbody tr').length - 1) {
                                                        let lastTd = $(this).children().last();
                                                        $(this).children().last().remove();
                                                        $(this).next().prepend(lastTd[0]);
                                                    } else {
                                                        let lastTrTd = $(this).children().last();

                                                        $(this).children().last().remove();

                                                        $('#mainTable tbody').append('<tr class="titr bg-white">' + lastTrTd[0].outerHTML + '</tr>');
                                                    }

                                                });
                                            }
                                            for (let i =1;i<=7;i++){
                                                if ($('#timeTable tbody').children('tr').last().children().length!=7){
                                                    $('#timeTable tbody').children('tr').last().append(`<td class="text-center tdDay gozashte" style="cursor: pointer; border: 1px solid rgb(222, 226, 230); color: rgb(255, 0, 0); opacity: 0.5; background-color: rgb(255, 255, 255);">${i}</td>`)
                                                }
                                                else{
                                                    break;
                                                }
                                            }
                                        }
                                        if (weekDay == 6) {

                                        }
                                        $('.tdDay').hover(function () {
                                            $(this).css("background-color", "#dee2e6");
                                        }, function () {
                                            $(this).css("background-color", "white");
                                        });
                                        $('.tdDay').each(function (index) {

                                            if ($(this).attr('day') == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
                                                $(this).css('background', 'blue').css('color', 'white');
                                                $(this).hover(function () {
                                                    $(this).css("background-color", "#dee2e6");
                                                }, function () {
                                                    $(this).css("background-color", "blue").css('color', 'white');
                                                });
                                            }
                                        });
                                        if (thisDayTotal < totalToday) {
                                            $(this).css('opacity', '50%').addClass('gozashte');
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


                                    ///////disable pass day


                                    $(document).on('click', '.tdDay', function (e) {
                                        if ($(this).hasClass('bg-success') == false) {
                                            $('#calculate').addClass('d-none');
                                            $('#freesubmit').addClass('d-none');
                                            $('#reserve').val('1');
                                            $('#totaldaysTitr').show();
                                            $('#totaldaysDiv').show();
                                            $('#monthsTitr').hide();
                                            $('#totalmonthsTitr').hide();
                                            $('#divMonth').addClass('d-none');
                                            $('#roozaneTitr').show();
                                            $('#mahaneTitr').addClass('d-none');

                                        } else {
                                            $('#price').val('{!! $order->takht->price !!}');

                                            function numberWithCommas(x) {
                                                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                            }

                                            let raft = new Date($('#raft').val()).getTime();
                                            let bargasht = new Date($('#bargasht').val()).getTime();
                                            let diff = bargasht - raft;


                                            let betDays = []
                                            let day = '';
                                            const oneDay = 1000 * 60 * 60 * 24;
                                            let countDays = Math.round(diff / oneDay);
                                            $('#days').val(countDays);
                                            $('#reserve').val('1');

                                            $('#calculate').removeClass('d-none');
                                            $('#freesubmit').removeClass('d-none');
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
                                            $("#finallyPriceInput").val(numberWithCommas(totalPrice));
                                            $('#bedehkar').val("{!! $order->bedehkar !!}");
                                            let bedehkar = $('#bedehkar').val();
                                            if (parseInt(bedehkar) == 0) {
                                                let thisTotal = "{!! $order->statusmali[0]->bedehkar !!}";
                                                let totalKhales = parseInt(thisTotal) - parseInt($("#finallyPriceInput").val().replaceAll(',', ""));

                                                if (totalKhales < 0) {
                                                    $('#finallyPriceInput').val(numberWithCommas(Math.abs(totalKhales)));
                                                    $('#bestankar').val(0);
                                                } else {
                                                    $('#finallyPriceInput').val('0');
                                                    $('#bestankar').val(parseInt(totalKhales));

                                                }

                                            } else if (parseInt(bedehkar) > 0) {
                                                let thisTotal = "{!! $order->statusmali[0]->bestankar !!}";
                                                if (thisTotal == "") {
                                                    thisTotal = 0;
                                                }

                                                let totalKhales = parseInt(thisTotal) - parseInt($("#finallyPriceInput").val().replaceAll(',', ""));

                                                if (totalKhales < 0) {

                                                    $('#finallyPriceInput').val(numberWithCommas(totalKhales * -1));
                                                } else {

                                                    $('#finallyPriceInput').val('0');
                                                    $('#bestankar').val(parseInt(totalKhales));

                                                }


                                            }
                                        }
                                    });
                                });


////////
                                $('.time').clockTimePicker();


                                $(document).on('click', '.tdDay', function (e) {
                                    console.log('hi')
                                    if ($(this).hasClass('bg-success') == false) {
                                        $('#calculate').addClass('d-none');
                                        $('#freesubmit').addClass('d-none');
                                        $('#reserve').val('1');
                                        $('#totaldaysTitr').show();
                                        $('#totaldaysDiv').show();
                                        $('#monthsTitr').hide();
                                        $('#totalmonthsTitr').hide();
                                        $('#divMonth').addClass('d-none');
                                        $('#roozaneTitr').show();
                                        $('#mahaneTitr').addClass('d-none');

                                    } else {
                                        $('#price').val('{!! $order->takht->price !!}');

                                        function numberWithCommas(x) {
                                            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                        }

                                        let raft = new Date($('#raft').val()).getTime();
                                        let bargasht = new Date($('#bargasht').val()).getTime();
                                        let diff = bargasht - raft;


                                        let betDays = []
                                        let day = '';
                                        const oneDay = 1000 * 60 * 60 * 24;
                                        let countDays = Math.round(diff / oneDay);
                                        $('#days').val(countDays);
                                        $('#reserve').val('1');
                                        $('#calculate').removeClass('d-none');
                                        $('#freesubmit').removeClass('d-none');
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
                                        $("#finallyPriceInput").val(numberWithCommas(totalPrice));
                                        $('#bedehkar').val("{!! $order->bedehkar !!}");
                                        let bedehkar = $('#bedehkar').val();
                                        if (parseInt(bedehkar) == 0) {
                                            let thisTotal = "{!! $order->statusmali[0]->bedehkar !!}";
                                            let totalKhales = parseInt(thisTotal) - parseInt($("#finallyPriceInput").val().replaceAll(',', ""));

                                            if (totalKhales < 0) {
                                                $('#finallyPriceInput').val(numberWithCommas(Math.abs(totalKhales)));
                                                $('#bestankar').val(0);
                                            } else {
                                                $('#finallyPriceInput').val('0');
                                                $('#bestankar').val(parseInt(totalKhales));

                                            }

                                        } else if (parseInt(bedehkar) > 0) {
                                            let thisTotal = "{!! $order->statusmali[0]->bestankar !!}";
                                            if (thisTotal == "") {
                                                thisTotal = 0;
                                            }

                                            let totalKhales = parseInt(thisTotal) - parseInt($("#finallyPriceInput").val().replaceAll(',', ""));

                                            if (totalKhales < 0) {

                                                $('#finallyPriceInput').val(numberWithCommas(totalKhales * -1));
                                            } else {

                                                $('#finallyPriceInput').val('0');
                                                $('#bestankar').val(parseInt(totalKhales));

                                            }


                                        }
                                    }
                                });

                                $('#emaltakhfif').on('click', function (eee) {
                                    function numberWithCommas(x) {
                                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                    }

                                    let takhfif = $('#takhfif').val().replaceAll(',', "");
                                    let final = $('#totalPriceInput').val().replaceAll(',', "") - takhfif;
                                    $("#finallyPriceInput").val(numberWithCommas(final));
                                    $('#finallyPrice').html(`${numberWithCommas(final)} تومان`)
                                });


                            });
                            $('#paytype').change(function (ee) {
                                $('#tarikhMonthTitr').addClass('d-none')
                                if ($(this).val() == 'q') {
                                    $('#qestmonthTitr').removeClass('d-none');
                                    $('#countMonthTitr').removeClass('d-none');
                                    $('#tarikhMonth').removeClass('d-none');
                                    if ($('#naqdtype').hasClass('d-none') == false) {
                                        $('#naqdtype').addClass('d-none');
                                    }
                                } else if ($(this).val() == 'n') {

                                    $('#naqdtype').removeClass('d-none');

                                    if ($('#countMonthTitr').hasClass('d-none') == false) {
                                        $('#countMonthTitr').addClass('d-none');
                                    }
                                    if ($('#tarikhMonth').hasClass('d-none') == false) {
                                        $('#tarikhMonth').addClass('d-none');
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
                                    $('#countMonthTitr').html(`<div class="col-8"> <input min="1" type="number" class="form-control" id="countMonth" value="1"></div> <div class="col-2"> <span class="btn btn-secondary" id="tayidCount" style="cursor: pointer">تایید</span></div>`)
                                }
                                $('#tayidCount').click(function (ese) {

                                    $('#tarikhMonthTitr').removeClass('d-none');
                                    $('#tarikhMonth').empty();
                                    let countMonth = $('#countMonth').val();
                                    let perMounth = Math.floor($('#finallyPriceInput').val().replaceAll(',',"") / countMonth);

                                    $('#perMonth').val(perMounth);
                                    $('#tarikhMonthTitr').html(`<h6 id="perMonth" class="mt-3">${numberWithCommas(perMounth)} تومان مبلغ پرداختی هر نوبت</h6>`)
                                    for (let i = 0; i < countMonth; i++) {
                                        $('#tarikhMonth').append(`    <div class="col-6 mt-3 pt-3" style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;" id="takhfifTitr">نوبت ${i + 1}:</div>
                                <div class="col-6 mt-3 pt-3" style="border-top: 1px solid #bdc4c4;text-align: right;">   <input name="qesttarikh[]" autocomplete="off" class="form-control jalal"></div>`);
                                    }
                                    $(".jalal").persianDatepicker({

                                    });


                                });
                                $("#submit").submit(function (e) {


                                    if ($('#paytype').val() == 'q') {

                                        if ($('.jalal').length == 0) {
                                            e.preventDefault();
                                            toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');
                                        } else {
                                            $('.jalal').each(function (index) {

                                                if ($(this).val() == "") {

                                                    e.preventDefault();
                                                    toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');

                                                } else {

                                                    // let clicktarikh = $(this).val().split('/');
                                                    // clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                                    // let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                                    // $(this).val(miladi);

                                                }


                                            });


                                        }
                                        let clicktarikh = $(this).attr('tarikh').split('/');
                                        clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                        let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                    }


                                });
                            });
                            $('.fishUp').click(function () {

                                $('.modal-content').css('height', '700px');
                            });
                            let ezaaf = 1;
                            $(document).on('change', 'input[name="fish[]"]', function (echange) {
                                contFile = contFile + 1;

                                if (echange.target.files.length != 0) {
                                    $(this).siblings('span').remove();
                                    $(this).after(`<span><i class="fa fa-check text-success"></i> </span>`)
                                }
                            });
                            $('.plusNaqd').click(function (ew) {

                                $('.naghdi').last().after(`      <div class="naghdi row col-11 py-4 my-4" style="border-bottom: 1px solid #aaaaaa">
                                        <div class="col-1 text-center mt-3 adad p-0">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <div class="col-10 row">
                                            <div class="col-lg-6 mt-2 px-1">
                                                <select class="form-control naqdtypeTitle" name="naqdtypeTitle[]"
                                                        placeholder="نوع پرداخت">

            </select>
        </div>
        <div class="col-lg-6 mt-2 px-1"><input
                class="form-control seprator justnumber naqdtypeMablagh"
                name="naqdtypeMablagh[]" placeholder="مبلغ (به تومان)"></div>
        <div class="col-lg-12 mt-2">
            <label for="fish-${ezaaf + 1}" class="btn btn-info">آپلود فیش</label>
            <input type="file" class="d-none" id="fish-${ezaaf + 1}" name="fish[]">
        </div>

    </div>
    <div class="col-1 text-center mt-3">
  <span class="btn mt-1 p-0 removeNaqd" data-id="" style="cursor: pointer"><i class="fa fa-minus"></i> </span>
    </div>
</div>`);
                                ezaaf = ezaaf + 1;
                                $.ajax({
                                    url: "{{asset("admin/naqdtypes")}}",
                                    success: function (data) {

                                        data.forEach(function (item, index) {

                                            $('.naqdtypeTitle').last().append(`<option value="${item.id}">${item.title}</option>)`);


                                        });
                                    }
                                })

                                $('.removeNaqd').click(function (ew) {
                                    let fileFish = $(this).parents('.naghdi').children('.col-10').children('.col-lg-12').children('input');
                                    $(this).parents('.naghdi').remove();
                                    if (fileFish.val().length != 0) {
                                        contFile = contFile - 1;
                                    }


                                });
                                $('.justnumber').on("keypress", function (e) {

                                    if (isNaN(e.key)) {
                                        e.preventDefault()
                                    }

                                    if (e.key == " ") {
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

                                $('.seprator').keyup(function (e) {
                                    let value = $(this).val();
                                    separateNum(value, $(this)[0])

                                });
                                $('input[name="fish[]"]').change(function (echange) {
                                    if (echange.target.files.length != 0) {
                                        $(this).siblings('span').remove();
                                        $(this).after(`<span><i class="fa fa-check text-success"></i> </span>`)
                                    }
                                });
                            });
                            $('.removeNaqd').click(function (ew) {
                                $(this).parents('.naghdi').remove();
                            });
                            $(document).on('submit', '#submit', function (e) {
                                let totalType = 0;
                                $('.naqdtypeMablagh').each(function (index) {
                                    $(this).val($(this).val().replaceAll(',', ""));
                                    if ($(this).val() != '') {
                                        totalType = totalType + parseFloat($(this).val());
                                    }

                                    if ($(this).val() != "" && $(this).parents('.col-lg-6').siblings('.col-lg-6').children('.naqdtypeTitle').val() == "") {
                                        e.preventDefault();
                                        toastr.error('نوع پرداخت یکی از مبالغ درست نیست.');
                                    }
                                });

                                if ($('#finallyPriceInput').val() == 0 || $('#finallyPriceInput').val().length == 0) {
                                    if (totalType!=0){
                                        e.preventDefault();
                                        toastr.error('مبلغ نهایی باید صفر باشد.');
                                    }

                                }
                                else {
                                    if (totalType != $('#finallyPriceInput').val()) {
                                        e.preventDefault();
                                        toastr.error('مجموع پرداختی ها با مبلغ نهایی برابر نمی باشد.');
                                    }
                                    $('.naghdi').each(function (index) {
                                        let mablaghesh = $(this).children('.col-10').children('.col-lg-6').children('.naqdtypeMablagh').val();
                                        if (index == 0 && mablaghesh.length == 0) {
                                            e.preventDefault();
                                            toastr.warning('مبلغ پرداختی را تکمیل نمایید.');
                                        }

                                        if (mablaghesh.length == 0 && index != 0) {
                                            $(this).remove();
                                        }
                                    });
                                    if ($('.naqdtypeMablagh').length != contFile) {
                                        e.preventDefault();
                                        toastr.warning('تصویر فیش واریزی ثبت نشده است.')
                                    }
                                }

                                $('.naqdtypeMablagh').val($('.naqdtypeMablagh').val().replaceAll(',', ""));
                                $('#takhfif').val($('#takhfif').val().replaceAll(',', ""));
                                $('#finallyPriceInput').val($('#finallyPriceInput').val().replaceAll(',', ""));
                                if ($('#raft').val() == "") {
                                    e.preventDefault();
                                    toastr.error('تاریخ رفت مشخص نیست.');
                                }

                                if ($('#bargasht').val() == "") {
                                    e.preventDefault();
                                    toastr.error('تاریخ برگشت مشخص نیست.');
                                }


                                if ($('#takht').val() == '') {
                                    e.preventDefault();
                                    toastr.error('انتخاب تخت الزامیست.');
                                }
                                if ($('#pansion').val() == '') {
                                    e.preventDefault();
                                    toastr.error('انتخاب خوابگاه الزامیست.');
                                }
                                if ($('#room').val() == '') {
                                    e.preventDefault();
                                    toastr.error('انتخاب اتاق الزامیست.');
                                }

                                if ($('#user').val() == '') {
                                    e.preventDefault();
                                    toastr.error('انتخاب مشترک الزامیست.');
                                }

                                if (CKEDITOR.instances.editor.getData().length == 0) {
                                    e.preventDefault();
                                    toastr.warning('علت اخراج نوشته نشده است.');
                                }

                            });
                        } else {
                            $('tbody').append(`<p style="padding: 20px">رزروی برای مشترک وجود ندارد.</p>`)
                        }


                    }
                }
            );


            $('#reserve').change(function (ev) {

                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                if ($('#reserve').val() == '1') {
                    $('#totaldaysTitr').show();
                    $('#totaldaysDiv').show();
                    $('#monthsTitr').hide();
                    $('#totalmonthsTitr').hide();
                    $('#divMonth').addClass('d-none');
                    $('#roozaneTitr').show();
                    $('#mahaneTitr').addClass('d-none');

                    let betDays = []
                    let day = '';
                    const oneDay = 1000 * 60 * 60 * 24;
                    let raft = new Date($('#raft').val()).getTime();
                    let bargasht = new Date($('#bargasht').val()).getTime();
                    let diff = bargasht - raft;
                    let countDays = Math.round(diff / oneDay);
                    $('#days').val(countDays);
                    let totalPrice = parseInt($('#days').val()) * parseInt($('#price').val());
                    $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                    $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                    $("#totaldays").html(`${countDays} روز`);
                    $("#takPrice").html(`${numberWithCommas($('#price').val()).substr(0, numberWithCommas($('#price').val()).length - 3)} تومان`);
                    $("#totalPriceInput").val(totalPrice);
                    $("#finallyPriceInput").val(totalPrice);
                    $('#calculate').removeClass('d-none');
                    $('#freesubmit').removeClass('d-none');
                    $('#bedehkar').val("{!! $order->bedehkar !!}");
                    let bedehkar = $('#bedehkar').val();
                    if (parseInt(bedehkar) == 0) {
                        let thisTotal = "{!! $order->statusmali[0]->bedehkar !!}";
                        let totalKhales = parseInt(thisTotal) - parseInt($("#finallyPriceInput").val().replaceAll(',', ""));

                        if (totalKhales < 0) {
                            $('#finallyPriceInput').val(numberWithCommas(Math.abs(totalKhales)));
                            $('#bestankar').val(0);
                        } else {
                            $('#finallyPriceInput').val('0');
                            $('#bestankar').val(parseInt(totalKhales));

                        }

                    } else if (parseInt(bedehkar) > 0) {
                        let thisTotal = "{!! $order->statusmali[0]->bestankar !!}";
                        if (thisTotal == "") {
                            thisTotal = 0;
                        }

                        let totalKhales = parseInt(thisTotal) - parseInt($("#finallyPriceInput").val().replaceAll(',', ""));

                        if (totalKhales < 0) {

                            $('#finallyPriceInput').val(numberWithCommas(totalKhales * -1));
                        } else {

                            $('#finallyPriceInput').val('0');
                            $('#bestankar').val(parseInt(totalKhales));

                        }


                    }

                }
                if ($('#reserve').val() == '2') {
                    $('#totaldaysTitr').hide();
                    $('#totaldaysDiv').hide();
                    $('#roozaneTitr').hide();
                    $('#monthsTitr').show();
                    $('#totalmonthsTitr').show();

                    $('#divMonth').removeClass('d-none');
                    $('#mahaneTitr').removeClass('d-none');

                    let raft = new Date($('#raft').val()).getTime();
                    let bargasht = new Date($('#bargasht').val()).getTime();
                    let diff = bargasht - raft;
                    const oneDay = 1000 * 60 * 60 * 24 * 30;
                    let countDays = Math.ceil(diff / oneDay);


                    $('#pricemonth').val('{!! $order->takht->pricemonth !!}');

                    $('#mounth').val(countDays);
                    let totalPrice = parseInt($('#mounth').val()) * parseInt($('#pricemonth').val());
                    $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                    $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                    $("#totaldays").html(`${$('#mounth').val()} ماه`);
                    $("#takPrice").html(`${numberWithCommas($('#pricemonth').val().substr(0, $('#pricemonth').val().length - 3))} تومان`);
                    $("#totalPriceInput").val(totalPrice);
                    $("#finallyPriceInput").val(numberWithCommas(totalPrice));
                    $('#bedehkar').val("{!! $order->bedehkar !!}");
                    let bedehkar = $('#bedehkar').val();
                    if (parseInt(bedehkar) == 0) {
                        let thisTotal = "{!! $order->statusmali[0]->bedehkar !!}";
                        let totalKhales = parseInt(thisTotal) - parseInt($("#finallyPriceInput").val().replaceAll(',', ""));

                        if (totalKhales < 0) {
                            $('#finallyPriceInput').val(numberWithCommas(Math.abs(totalKhales)));
                            $('#bestankar').val(0);
                        } else {
                            $('#finallyPriceInput').val('0');
                            $('#bestankar').val(parseInt(totalKhales));

                        }

                    } else if (parseInt(bedehkar) > 0) {
                        let thisTotal = "{!! $order->statusmali[0]->bestankar !!}";
                        if (thisTotal == "") {
                            thisTotal = 0;
                        }

                        let totalKhales = parseInt(thisTotal) - parseInt($("#finallyPriceInput").val().replaceAll(',', ""));

                        if (totalKhales < 0) {

                            $('#finallyPriceInput').val(numberWithCommas(totalKhales * -1));
                        } else {

                            $('#finallyPriceInput').val('0');
                            $('#bestankar').val(parseInt(totalKhales));

                        }


                    }


                }

            });
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

                if ($('#paytype').val() == 'q') {

                    if ($('.jalal').length == 0) {
                        e.preventDefault();
                        toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');
                    } else {
                        $('.jalal').each(function (index) {

                            if ($(this).val() == "") {

                                e.preventDefault();
                                toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');

                            } else {

                                let clicktarikh = $(this).val().split('/');
                                clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                $(this).val(miladi);

                            }


                        });


                    }
                    // let clicktarikh = $(this).attr('tarikh').split('/');
                    // clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                    // let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                }


            });

        })
    </script>
@endsection
@section('css')
    .table-secondary thead {
        color: white;
        background: #a5a248;
    }

    #timeTable {
        height: 448.719px;
    }

    .select2 {
        width: 100% !important;
    }

    #mainTable {
    height: 345px;
    }
    @media (min-width: 1400px) {
        .container {
            max-width: 1350px !important;
        }
    }

    @media (min-width: 992px) {
        .mr-140 {
            margin-right: 140px !important;
        }
    }

    @media (max-width: 576px) {
        .mr-140 {
            margin-right: 60px !important;
        }
    }

    .breadcrumb {
        background-color: white !important;
    }
@endsection
@if(strtotime($order->raft)<time())
@section('content')
    @if($order->status_order_id!='5')
        <section class="bg-white position-fixed container" style="top: 190px;z-index:1000;left: 5px;width: 250px;  box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    border-radius: 6px;">
            <a href="{{asset('admin/ekhraaji/'.$order->id.'?taghvim=begin')}}" id="link-begin">
                <div class="row " style="border-bottom: 1px solid #aaaaaa">

                    <div class="col-6 p-2">تاریخ شروع:</div>
                    <div class="col-6 p-2">{{$order->raftjalali}}</div>

                </div>
            </a>
            <a href="{{asset('admin/ekhraaji/'.$order->id.'?taghvim=end')}}">
                <div class="row" style="border-bottom: 1px solid #aaaaaa">
                    <div class="col-6 p-2">تاریخ پایان:</div>
                    <div class="col-6 p-2">{{$order->bargashtjalali}}</div>

                </div>
            </a>
            <a href="{{asset('admin/ekhraaji/'.$order->id.'?taghvim=recent')}}">
                <div class="row" style="border-bottom: 1px solid #aaaaaa">
                    <div class="col-6 p-2">تاریخ امروز:</div>
                    <div class="col-6 p-2" id="today">{{$order->raftjalali}}</div>
                </div>
            </a>
        </section>
        <!-- START: Breadcrumbs-->
        <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
            <div class="col-12  align-self-center">
                <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded"
                     style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                            <li class="breadcrumb-item" style="background: #d0e7ff"><a
                                    href="{{route('admin')}}">داشبورد</a></li>
                            <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('ekhrajiha')}}">اخراج
                                    افراد</a></li>
                            <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">
                                اخراج {{$order->user->name.' '.$order->user->family}}                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END: Breadcrumbs-->
        <div class="container card mb-5" style="margin-top: 230px;background-color: gainsboro;">
            <div class="mb-4" style="color: #a5a248">
                <b> <span class="p-2"
                          style="background: white;border: #d7d7d7 1px solid;border-radius: 6px;font-size: 20px;box-shadow: rgba(0, 0, 0, 0.15) 0px 5px 15px 0px;">تاریخچه رزروهای مشترک {{$order->user->name.' '.$order->user->family}}</span></b>
            </div>
            <div class="table-responsive">
            <table class="table table-striped table-secondary">
                <thead>
                <tr>
                    <th>لیست</th>
                    <th>نام رزرو کننده</th>
                    <th>تخت</th>
                    <th>تاریخ شروع</th>
                    <th>تاریخ پایان</th>
                    <th>وضعیت رزرو</th>
                    <th>مبلغ قابل پرداخت</th>
                    <th>مبلغ پرداخت شده</th>
                    <th>تخفیف</th>
                    <th>بدهکار</th>
                    <th>وضعیت پرداخت</th>
                    <th>جزییات پرداخت</th>
                </tr>
                </thead>
                <tbody>
                @foreach($statusmalis as $key=>$statusmali)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$statusmali->fullname}}</td>
                        <td>{{$statusmali->pansionname}} اتاق {{$statusmali->roomnumber}}
                            تخت {{$statusmali->takhtnumber}}</td>
                        <td>{{$statusmali->jalaliRaft}}</td>
                        <td>{{$statusmali->jalaliBargasht}}</td>
                        <td>{{$statusmali->status_order}}</td>
                        <td>{{number_format($statusmali->bedehkar)}} تومان</td>
                        <td>{{number_format($statusmali->bestankar)}} تومان</td>
                        <td>{{number_format($statusmali->takhfif)}} تومان</td>
                        <td>{{number_format($statusmali->bedehi)}} تومان</td>
                        <td>{{$statusmali->statusmalis}}</td>
                        <td>
                            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#details-modal-{{$key}}">جزییات
                                پرداخت</a>
                            <!--detailPay Modal -->
                            <div class="modal fade" id="details-modal-{{$key}}" role="dialog">
                                <div class="modal-dialog modal-lg">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            @if($statusmali->aqsat!=null)
                                                <table class="table">
                                                    <thead class="bg-dark">
                                                    <tr class="text-white">
                                                        <th>شماره</th>
                                                        <th>زمان قسط</th>
                                                        <th>زمان پرداختی</th>
                                                        <th>مبلغ</th>
                                                        <th>وضعیت</th>
                                                        <th>نمایش</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($statusmali->aqsat as $keys=>$qest)
                                                        <tr>
                                                            <td>{{++$keys}}</td>
                                                            <td>{{$qest->paytime}}</td>
                                                            <td>{{$qest->pardakhti!=null?$qest->pardakhti:'-'}}</td>
                                                            <td>{{number_format($qest->amount)}} تومان</td>
                                                            <td>{{$qest->vaziat}}</td>
                                                            <td>
                                                                <button class="btn text-white btn-warning btn-fishup"
                                                                        style="padding: 10px 12px" title="فیش"
                                                                        data-id="{{$qest->id}}" data-toggle="modal"
                                                                        data-target="#fish-modal-{{$keys}}"><i
                                                                        class="fas fa-money-bill"></i></button>
                                                                <!-- modal group -->
                                                                <div class="modal fade" id="fish-modal-{{$keys}}"
                                                                     role="dialog">
                                                                    <div class="modal-dialog modal-lg">

                                                                        <!-- Modal content-->
                                                                        <div class="modal-content fishi">
                                                                            <div class="modal-header d-block"
                                                                                 style="text-align: right">
                                                                                <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        style="float: right">&times;
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body text-dark">
                                                                                <!-- START: Breadcrumbs-->
                                                                                <div
                                                                                    class="py-5 mt-5 mb-lg-3 row w-100">
                                                                                    <div
                                                                                        class="col-12  align-self-center">
                                                                                        <div
                                                                                            class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                                                                                            <div
                                                                                                class="w-sm-100 mr-auto">
                                                                                                <h4 class="mb-0">تصویر
                                                                                                    فیش واریزی</h4>
                                                                                            </div>
                                                                                            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                                                                            </ol>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="container-fluid">
                                                                                    @if($qest->fish!=null)
                                                                                        <img
                                                                                            src="{{asset($qest->fish)}}">
                                                                                    @else
                                                                                        <h6>فیش واریزی ندارد.</h6>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            @elseif($statusmali->naqditype!=null)
                                                <table class="table">
                                                    <thead class="bg-dark">
                                                    <tr class="text-white">
                                                        <th>شماره</th>
                                                        <th>نوع پرداخت</th>
                                                        <th>مبلغ</th>
                                                        <th>نمایش</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($statusmali->naqditype as $keys=>$naqditype)
                                                        <tr>
                                                            <td>{{++$keys}}</td>
                                                            <td>{{$naqditype->title}}</td>
                                                            <td>{{number_format($naqditype->mablagh)}} تومان</td>
                                                            <td>
                                                                <button class="btn text-white btn-warning fishUp"
                                                                        style="padding: 10px 12px" title="فیش"
                                                                        data-id="{{$naqditype->id}}" data-toggle="modal"
                                                                        data-target="#fish-modal-{{$keys}}"><i
                                                                        class="fas fa-money-bill"></i></button>
                                                                <!-- modal group -->
                                                                <div class="modal fade" id="fish-modal-{{$keys}}"
                                                                     role="dialog">
                                                                    <div class="modal-dialog">

                                                                        <!-- Modal content-->
                                                                        <div class="modal-content fishi">
                                                                            <div class="modal-header d-block"
                                                                                 style="text-align: right">
                                                                                <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        style="float: right">&times;
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body text-dark"
                                                                                 style="background: #b3be90">
                                                                                <div class="container-fluid">
                                                                                    @if($naqditype->pivot->path!=null)
                                                                                        <img style="width: 100%"
                                                                                             src="{{asset($naqditype->pivot->path)}}">
                                                                                    @else
                                                                                        <h6>فیش واریزی ندارد.</h6>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <div class="container card mb-5" style="margin-top: 50px;background-color: gainsboro;">
            <div class="mb-4" style="color: #385572">
                <b> <span class="p-2"
                          style="background: white;border: #d7d7d7 1px solid;border-radius: 6px;font-size: 20px;box-shadow: rgba(0, 0, 0, 0.15) 0px 5px 15px 0px;"> رزرو فعال مشترک {{$order->user->name.' '.$order->user->family}}</span></b>
            </div>
            <div class="table-responsive">
            <table class="table table-info">
                <thead>
                <th>نام رزرو کننده</th>
                <th>تخت</th>
                <th>تاریخ شروع</th>
                <th>تاریخ پایان</th>
                <th>بدهکار</th>
                <th>مبلغ کل</th>
                <th>تخفیف</th>
                <th>وضعیت پرداخت</th>
                <th>جزییات پرداخت</th>
                </thead>
                <tbody>
                <td>{{$order->fullname}}</td>
                <td>{{$order->pansionname}} اتاق {{$order->roomnumber}} تخت {{$order->takhtnumber}}</td>
                <td>{{$order->raftjalali}}</td>
                <td>{{$order->bargashtjalali}}</td>
                <td>{{number_format($order->bedehkar)}} تومان</td>
                <td>{{number_format($order->totalprice)}} تومان</td>
                <td>{{number_format($order->takhfif)}} تومان</td>
                <td>{{$order->statusmalis}}</td>
                <td><a href="#" class="btn btn-info">جزییات پرداخت</a></td>
                </tbody>
            </table>
        </div>
        </div>
        <!-- START: Form-->
        <form method="post" class="h-100" action="" id="submit">

            <input id="tarikh" name="tarikh" class="d-none" value="">
            <input id="raft" name="raft" class="d-none" value="">
            <input id="bargasht" name="bargasht" class="d-none" value="">
            <input id="days" name="days" class="d-none" value="">
            <input id="price" name="price" class="d-none" value="">
            <input id="perMonth" name="perMonth" class="d-none" value="">
            <input id="orderId" name="orderId" class="d-none" value="{{$order->id}}">
            <input id="takht_id" name="takht_id" class="d-none" value="{{$order->takht_id}}">
            <input id="user_id" name="user_id" class="d-none" value="{{$order->user_id}}">
            <input id="bestankar" name="bestankar" class="d-none" value="">
            <input id="bedehkar" name="bedehkar" class="d-none" value="">
            <input id="pricemonth" name="pricemonth" class="d-none" value="">

            <div class="container card mb-5" style="margin-top: 50px;background-color: gainsboro;">
                <div class="row h-100 mb-5">
                    <div class="col-12 col-lg-8 row" style="height: 1100px">
                        <div class="col-12 row" style="height: 600px">
                            <div class="col-6 offset-6 mt-3 mx-5 py-2"
                                 style="background: #ffc107!important;border-radius: 6px;height: 35px">از تاریخ: <span
                                    id="from"></span></div>
                            <div class="col-6 offset-6 mt-1 mx-5 py-2"
                                 style="background: #28a745!important;border-radius: 6px;height: 35px">تا تاریخ:
                                <span id="to"></span></div>
                            <div class="mt-5 row p-0" id="timeTable"
                                 style="border: none;margin-right: 45px;width: 700px;border: 1px solid #aaa;background: white;border-radius: 10px;">

                                <div class="col-12 p-0">
                                    <table id="mainTable" class="table mb-0">
                                        <thead class="bg-dark text-white">
                                        <tr class="justify-content-between">
                                            <th class="text-center py-1" style="width: 80px">ش</th>
                                            <th class="text-center py-1" style="width: 80px">ی</th>
                                            <th class="text-center py-1" style="width: 80px">د</th>
                                            <th class="text-center py-1" style="width: 80px">س</th>
                                            <th class="text-center py-1" style="width: 80px">چ</th>
                                            <th class="text-center py-1" style="width: 80px">پ</th>
                                            <th class="text-center py-1" style="width: 80px">ج</th>
                                        </tr>
                                        </thead>
                                        <tbody id="dayTable">
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-12 pt-3 my-5">
                                    <div class="mb-2"><span class="p-2 "
                                                            style="background: #eefbce;border-radius: 5px;border: 1px solid #a8a77b">علت اخراج</span>
                                    </div>
                                    <textarea name="editor" id="editor" class="w-100"></textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-4 col-12 mb-5 mt-5 row pl-5">
                        <div class="col-12 mt-5">

                            <div class="col-12 mt-5">
                                <h3 class="text-center">محاسبه کرایه تخت</h3>
                                <div class="row d-none" id="calculate">
                                    <div class="col-12 mt-3 row">
                                        <div class="form-label mb-2 col-3 p-0 position-relative text-center" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-radius: 5px;
    background-color: beige;">
                                            <span class="form-label mb-2 position-relative"
                                                  style="top: 24%">نوع رزرو</span>
                                        </div>
                                        <div class="col-9 p-0 ">
                                            <select place name="reservetype" class="select2 form-control" id="reserve">
                                                @foreach($reservetypes as $key=>$reservetype)
                                                    @if($reservetype->id!=3)
                                                        <option
                                                            value="{{$reservetype->id}}">{{$reservetype->title}}</option>
                                                    @endif
                                                @endforeach
                                            </select>

                                        </div>

                                    </div>
                                    <div class="col-6 mt-3 pt-3 d-none"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="roozaneTitr">مبلغ روزانه:
                                    </div>
                                    <div class="col-6 mt-3 pt-3 d-none"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="mahaneTitr">مبلغ ماهانه:
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;"><h5
                                            id="takPrice"></h5></div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="totaldaysTitr">تعداد روزها:
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="monthsTitr">تعداد ماه:
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;"><h5
                                            id="totaldays"></h5></div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="totalpriceTitr">مبلغ کل :
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;"><h5
                                            id="totalPrice"></h5></div>
                                    <div class="col-2 mt-3 pt-3 px-0"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="takhfifTitr"> تخفیف:
                                    </div>
                                    <div class="col-7 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"><input
                                            class="form-control seprator justnumber" name="takhfif"
                                            id="takhfif" autocomplete="off"></div>
                                    <div class="col-2 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"><span
                                            class="btn btn-secondary" id="emaltakhfif">اعمال</span>
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="finallypriceTitr">مبلغ نهایی:
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;"><input
                                            name="finallyPrice" class="form-control seprator" id="finallyPriceInput"></div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="paytypeTitr">نوع پرداخت:
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;"><select name="paytype"
                                                                                                          id="paytype"
                                                                                                          class="select2 form-control">
                                            <option value="n">نقدی</option>
                                            <option value="q">اقساطی</option>
                                        </select>
                                    </div>

                                    <div class="col-6 mt-3 pt-3 d-none"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="qestmonthTitr">تعداد نوبت:
                                    </div>
                                    <div class="col-6 mt-3 pt-3 row d-none"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;" id="countMonthTitr">

                                    </div>
                                    <div class="col-12 mt-3 pt-3 d-none"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="tarikhMonthTitr">تعیین تاریخ نوبت:
                                    </div>
                                    <div class="col-12 mt-3 pt-3 row" style="text-align: right;" id="tarikhMonth"></div>

                                    <div class="col-12 mt-3 pt-3 row"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="naqdtype">
                                        <div class="col-12" id="payDetail">جزییات پرداخت:</div>

                                        <div class="naghdi row col-11 py-4 my-4"
                                             style="border-bottom: 1px solid #aaaaaa">
                                            <div class="col-1 text-center mt-3 adad p-0">
                                                <i class="fa fa-credit-card"></i>
                                            </div>
                                            <div class="col-10 row">
                                                <div class="col-lg-6 mt-2 px-1">
                                                    <select class="form-control naqdtypeTitle" name="naqdtypeTitle[]"
                                                            placeholder="نوع پرداخت">
                                                        @foreach($naqdtypes as $key=>$naqdtype)

                                                            <option
                                                                value="{{$naqdtype->id}}">{{$naqdtype->title}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 mt-2 px-1"><input
                                                        class="form-control seprator justnumber naqdtypeMablagh"
                                                        name="naqdtypeMablagh[]" placeholder="مبلغ (به تومان)"></div>
                                                <div class="col-lg-12 mt-2">
                                                    <label for="fish-1" class="btn btn-info">آپلود فیش</label>
                                                    <input type="file" class="d-none" id="fish-1" name="fish[]">
                                                </div>

                                            </div>
                                            <div class="col-1 text-center mt-3">

                                            </div>
                                        </div>
                                        <div class="col-1 text-center mt-3">
                                            <span class="btn  mt-1 p-0 plusNaqd" style="cursor: pointer"><i
                                                    class="fa fa-plus"></i> </span>
                                        </div>
                                    </div>
                                </div>


                                <input name="totalPrice" class="d-none" id="totalPriceInput">
                                <input name="mounth" class="d-none" id="mounth">
                                <input name="permounth" class="d-none" id="permounth">

                            </div>
                            <div class="col-12 mb-3 mt-5 text-center">
                                <button type="submit" class="w-50 btn btn-success pt-2 pb-2 d-none" id="freesubmit">ثبت
                                </button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="container card mt-5">
            <h4 class="alert-danger" style="margin-top: 200px">این رزرو کنسل شده است.</h4>
        </div>
    @endif
@endsection
@else
@section('content')
    <div class="py-5 container-fluid">
        <div class="table-responsive">
        <table class="table table-info">
            <thead>
            <th>نام رزرو کننده</th>
            <th>تخت</th>
            <th>تاریخ شروع</th>
            <th>تاریخ پایان</th>
            <th>بدهکار</th>
            <th>مبلغ کل</th>
            <th>تخفیف</th>
            <th>وضعیت پرداخت</th>
            <th>جزییات پرداخت</th>
            </thead>
            <tbody>
            <td>{{$order->fullname}}</td>
            <td>{{$order->pansionname}} اتاق {{$order->roomnumber}} تخت {{$order->takhtnumber}}</td>
            <td>{{$order->raftjalali}}</td>
            <td>{{$order->bargashtjalali}}</td>
            <td>{{number_format($order->bedehkar)}} تومان</td>
            <td>{{number_format($order->totalprice)}} تومان</td>
            <td>{{number_format($order->takhfif)}} تومان</td>
            <td>{{$order->statusmalis}}</td>
            <td><a href="#" class="btn btn-info">جزییات پرداخت</a></td>
            </tbody>
        </table>
    </div>
    </div>
    <h2 class="alert-success">زمان شروع رزرو هنوز فرا نرسیده است.</h2>
@endsection
@endif
