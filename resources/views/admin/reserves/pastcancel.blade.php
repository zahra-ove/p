@extends('admin.master.home')

@section('js')
{{--    <script src="https://rawgit.com/abdennour/hijri-date/master/cdn/hijri-date-latest.js" type="text/javascript" ></script>--}}
    <script src="{{asset('admin/js/hijri-date-latest.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin')}}/js/jdate.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('admin')}}/js/taghvimSCOOB.js" type="text/javascript" charset="utf-8"></script>

    <script>

        $(document).ready(function () {
            let beShamsiKamels = new JDate(new Date('{!! $order->raft !!}')).format('dddd DD MMMM YYYY')
            $('#raft').val("{!! $order->raft !!}");
            $('#from').html(beShamsiKamels);

            $('#price').val('{!! $order->takht->price !!}');
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


                let userId = "{!! $order->user_id !!}";
                $.ajax(
                    {
                        url: "{{asset('admin/getorderbyuser')}}/" + userId,
                        success: function (data) {
                            // $('tbody').empty()
                            if (data != 'notfound') {
                                data.forEach(function (item, index) {


                                    if (item.status_order_id == 1 || item.status_order_id == 2) {










                                        $(`.orderStatus[data-id=${item.id}] option`).each(function (index) {
                                            if ($(this).val() == item.status_order_id) {
                                                $(this).attr('selected', 'selected');
                                            }
                                        });

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

                                    let mildate = JDate.toGregorian(jdate.date[0],jdate.date[1],jdate.date[2]);
                                        let tarikhs = [];

                                        $('#timeTable').prepend(`<div class="col-12 text-center" id="tarikhclicked"><h6>${jdate.format('dddd DD MMMM YYYY')}</h6></div>`);
                                        $('#timeTable').prepend(`<div class="col-12 text-center" id="miladiTitr"><h6 id="miladi" class="text-center mt-2 text-info"><span id="ytimetablemi"> ${mildate.getFullYear()}</span></h6></div>`);
                                        $('#timeTable').prepend(`<div class="col-4 mt-2" id="nextMonth" style="cursor: pointer"><i class="fas fa-arrow-right"></i></div> <div class="col-4 " id="titrTarikh"> <h4 id="shamsi" class="text-center mt-2 text-primary"><span id="ytimetablesh"> ${jdate.date['0']}</span></h4></div><div class="col-4 mt-2" id="preMonth" style="cursor: pointer;text-align: left;padding-left: 40px"><i class="fas fa-arrow-left"></i></div>`);


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
                                                $('#reserve').prop("disabled", false);
                                            } else if ($(this).hasClass('bg-success')) {
                                                $(this).removeClass('bg-success');
                                                $('#bargasht').val("");
                                                $('#to').empty();
                                                $('#reserve').prop("disabled", true);
                                                $('#reserve').children().first().attr('selected', 'selected');
                                                $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
                                                $('#calculate').addClass('d-none');
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
                                            if (new Date($(this).attr('miladi')).getTime() <= new Date('{!! $order->raft !!}').getTime()) {
                                                $(this).addClass('gozashte').css('color','red');
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
                                    $('.tdDay').each(function (e) {
                                        let thisraft = new Date("{!! $order->raft !!}").setHours(0, 0, 0, 0);

                                        let thisbargasht = new Date("{!! $order->bargasht !!}").setHours(0, 0, 0, 0);
                                        let clikeddate = new Date($(this).attr('miladi')).setHours(0, 0, 0, 0);
                                        console.log($(this).attr('miladi'))
                                        if (thisraft == clikeddate) {
                                            $(this).addClass('bg-info');
                                        }
                                        if (thisbargasht == clikeddate) {

                                            $(this).addClass('bg-secondary');
                                        }
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
                                                    $('#reserve').prop("disabled", false);
                                                } else if ($(this).hasClass('bg-success')) {
                                                    $(this).removeClass('bg-success');
                                                    $('#bargasht').val("");
                                                    $('#to').empty();
                                                    $('#reserve').prop("disabled", true);
                                                    $('#reserve').children().first().attr('selected', 'selected');
                                                    $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
                                                    $('#calculate').addClass('d-none');
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

                                                let $this = $(this);
                                                let clicktarikh = $(this).attr('tarikh').split('/');
                                                clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                                let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                                $(this).attr('miladi', miladi);
                                                let totalToday = JDate.toGregorian(jdateNow.date[0], jdateNow.date[1], jdateNow.date[2]).getTime();
                                                let weekDay = new Date(miladi).getDay();
                                                if (new Date($(this).attr('miladi')).getTime() == new Date('{!! $order->raft !!}').getTime()) {
                                                    $(this).addClass('bg-warning');
                                                    $('#raft').val(miladi);
                                                    $('#from').html(new JDate(new Date(miladi)).format('dddd DD MMMM YYYY'));
                                                }
                                                if (new Date($(this).attr('miladi')).getTime() <= new Date('{!! $order->raft !!}').getTime()) {
                                                    $(this).addClass('gozashte').css('color','red');
                                                }
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
                                            $('.tdDay').each(function (e) {
                                                let thisraft = new Date("{!! $order->raft !!}").setHours(0, 0, 0, 0);
                                                let thisbargasht = new Date("{!! $order->bargasht !!}").setHours(0, 0, 0, 0);
                                                let clikeddate = new Date($(this).attr('miladi')).setHours(0, 0, 0, 0);
                                                if (thisraft == clikeddate) {
                                                    $(this).addClass('bg-info');
                                                }
                                                if (thisbargasht == clikeddate) {
                                                    $(this).addClass('bg-secondary');
                                                }
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
                                                    $('#reserve').prop("disabled", false);
                                                } else if ($(this).hasClass('bg-success')) {
                                                    $(this).removeClass('bg-success');
                                                    $('#bargasht').val("");
                                                    $('#to').empty();
                                                    $('#reserve').prop("disabled", true);
                                                    $('#reserve').children().first().attr('selected', 'selected');
                                                    $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
                                                    $('#calculate').addClass('d-none');
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
                                                    $(this).addClass('gozashte').css('color','red');
                                                }

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
                                            $('.tdDay').each(function (e) {
                                                let thisraft = new Date("{!! $order->raft !!}").setHours(0, 0, 0, 0);
                                                let thisbargasht = new Date("{!! $order->bargasht !!}").setHours(0, 0, 0, 0);
                                                let clikeddate = new Date($(this).attr('miladi')).setHours(0, 0, 0, 0);
                                                if (thisraft == clikeddate) {
                                                    $(this).addClass('bg-info');
                                                }
                                                if (thisbargasht == clikeddate) {
                                                    $(this).addClass('bg-secondary');
                                                }
                                            });
                                        });


////////
                                        $('.time').clockTimePicker();




                                    $('#reserve').change(function (e) {
                                        $('#price').val('{!! $order->takht->price !!}');
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
                                            $("#finallyPriceInput").val(numberWithCommas(totalPrice));
                                        }
                                        if ($(this).val() == '2') {

                                            const oneDay = 1000 * 60 * 60 * 24 * 30;
                                            let countDays = Math.round(diff / oneDay);
                                            if (countDays != 0) {
                                                $('#mounth').val(countDays);
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
                                                $('#permounth').val(parseInt($('#price').val()));
                                                let totalPrice = parseInt($('#mounth').val()) * parseInt($('#permounth').val());
                                                $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                                                $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                                                $("#totaldays").html(`${countDays} ماه`);
                                                $("#takPrice").html(`${numberWithCommas($('#price').val())} تومان`);
                                                $("#totalPriceInput").val(totalPrice);
                                                $("#finallyPriceInput").val(numberWithCommas(totalPrice));
                                            } else {
                                                toastr.error('در صورت اینکه تعداد روز ها کم تر از یک ماه است از نوع روزانه استفاده نمایید.');
                                                $('#reserve').children().first().attr('selected', 'selected');
                                                $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                                                $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
                                            }
                                        }
                                        $('#bedehkar').val("{!! $order->bedehkar !!}");
                                        let bedehkar=$('#bedehkar').val();

                                        if (parseInt(bedehkar)==0){
                                            let thisTotal="{!! $order->statusmali[0]->bedehkar !!}";
                                            let totalKhales = parseInt(thisTotal) - parseInt($('#totalPriceInput').val());
                                            if(totalKhales<0){
                                                $('#finallyPriceInput').val(Math.abs(totalKhales));
                                                $('#bestankar').val(0);
                                            }
                                            else {
                                                    $('#finallyPriceInput').val('0');
                                                    $('#bestankar').val(parseInt(totalKhales));

                                            }

                                        }
                                        else if (parseInt(bedehkar)>0){
                                            let thisTotal="{!! $order->statusmali[0]->bestankar !!}";
                                            let totalKhales = parseInt(thisTotal) - parseInt($('#totalPriceInput').val());

                                            if(totalKhales<0){
                                                $('#totaldovom').val(numberWithCommas(totalKhales*-1));
                                            }
                                            else {

                                                    $('#finallyPriceInput').val('0');
                                                    $('#bestankar').val(parseInt(totalKhales));

                                            }


                                        }
                                    });

                                    $('#emaltakhfif').click(function (eee) {
                                        function numberWithCommas(x) {
                                            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                        }

                                        // let takhfif=$('#takhfif').val().replaceAll(',', "");
                                        let final = $('#totalPriceInput').val() - takhfif;
                                        $("#finallyPriceInput").val(numberWithCommas(final));
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
                                            let perMounth = $('#finallyPriceInput').val() / countMonth;
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
                                $('input[name="fish[]"]').change(function (echange) {
                                    if (echange.target.files.length!=0){
                                        $(this).siblings('span').remove();
                                        $(this).after(`<span><i class="fa fa-check text-success"></i> </span>`)
                                    }
                                });

                                $("#submit").submit(function (e) {
                                    $('.naqdtypeMablagh').val($('.naqdtypeMablagh').val().replaceAll(',', ""));
                                    $('.naqdtypeMablagh').each(function (index) {
                                        $('.naqdtypeMablagh').val($('.naqdtypeMablagh').val().replaceAll(',', ""));
                                        if ($(this).val() != '') {
                                            totalType = totalType + parseFloat($(this).val());
                                        }

                                        if ($(this).val() != "" && $(this).parents('.col-lg-6').siblings('.col-lg-6').children('.naqdtypeTitle').val() == "") {
                                            e.preventDefault();
                                            toastr.error('نوع پرداخت یکی از مبالغ درست نیست.');
                                        }
                                    });
                                    $('#priceTrans').val($('#priceTrans').val().replaceAll(',',''));
                                    $('#takhfif').val($('#takhfif').val().replaceAll(',', ""));
                                    $('#finallyPriceInput').val($('#finallyPriceInput').val().replaceAll(',', ""));
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
                $('.naqdtypeMablagh').val($('.naqdtypeMablagh').val().replaceAll(',', ""));
                $('#priceTrans').val($('#priceTrans').val().replaceAll(',',''));
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
                if (totalType != $('#finallyPriceInput').val().replaceAll(",", "")) {
                    e.preventDefault();
                    toastr.error('مجموع پرداختی ها با مبلغ نهایی برابر نمی باشد.');
                }

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


        let ezaaf=1;
        $('input[name="fish[]"]').change(function (echange) {
            if (echange.target.files.length!=0){
                $(this).siblings('span').remove();
                $(this).after(`<span><i class="fa fa-check text-success"></i> </span>`)
            }
        });
        $('.plusNaqd').click(function (ew) {

            $('.naghdi').last().after(`        <div class="naghdi row col-11 my-4 py-4" style="border-bottom: 1px solid #aaaaaa">
                                        <div class="col-1 text-center mt-3 adad">
                                           <i class="fa fa-credit-card"></i>
                                        </div>

                                    <div class="col-9 row">
                                        <div class="col-lg-12 mt-2">  <select class="form-control naqdtypeTitle" name="naqdtypeTitle[]"></select></div>
                                        <div class="col-lg-12 mt-2">   <input class="form-control seprator justnumber naqdtypeMablagh" name="naqdtypeMablagh[]" placeholder="مبلغ (به تومان)"></div>
   <div class="col-lg-12 mt-2">
                                                <label for="fish-${ezaaf+1}" class="btn btn-info">آپلود فیش</label>
                                                <input type="file" class="d-none" id="fish-${ezaaf+1}" name="fish[]">
                                            </div>

                                    </div>
                                    <div class="col-1 text-center mt-3">
                                        <span class="btn mt-1 p-0 removeNaqd" data-id="" style="cursor: pointer"><i class="fa fa-minus"></i> </span>
                                    </div>
                                    </div>`);
            ezaaf=ezaaf+1;
            $.ajax({
                url: "{{asset("admin/naqdtypes")}}",
                success: function (data) {

                    data.forEach(function (item, index) {

                        $('.naqdtypeTitle').append(`<option value="${item.id}">${item.title}</option>)`);
                    });
                }
            })

            $('.removeNaqd').click(function (ew) {
                $(this).parents('.naghdi').remove();
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
                if (echange.target.files.length!=0){
                    $(this).siblings('span').remove();
                    $(this).after(`<span><i class="fa fa-check text-success"></i> </span>`)
                }
            });
        });
        $('.removeNaqd').click(function (ew) {
            $(this).parents('.naghdi').remove();
        });
        })
    </script>
@endsection
@section('css')

    #timeTable{
        height: 448.719px;
    }

    .select2 {
        width: 100% !important;
    }

@endsection
@if(strtotime($order->raft)<time())
@section('content')
    @if($order->status_order_id!='4')
        <div class="container card mt-5">
            <h4 class="alert-danger p-2" style="margin-top: 200px">امکان کنسلی رزرو نیست.</h4>
        </div>
    @else
        <div class="container card mt-5">
            <h4 class="alert-danger" style="margin-top: 200px">این رزرو کنسل شده است.</h4>
        </div>
    @endif
@endsection
@else
@section('content')
    @if($order->status_order_id!='4')
        <!-- START: Breadcrumbs-->
        <div class="py-5 container-fluid mb-lg-3 px-0" style="margin-top: 130px">
            <div class="col-12  align-self-center px-0">
                <div class="sub-header mt-3 py-4 px-3 align-self-center d-sm-flex w-100 rounded">
                    <div class="w-sm-100 mr-auto"><h4 class="mb-0">کنسلی تخت</h4></div>

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
        <div class="py-5 container-fluid mb-lg-3" style="margin-top: 90px">
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
                <td>
                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#detail-modal">جزییات پرداخت</a>
                    <!-- Modal -->
                    <div class="modal fade" id="detail-modal" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    @if($order->aqsat!=null)
                                        <table class="table">
                                            <thead class="bg-dark">
                                            <tr class="text-white">
                                                <th>شماره</th>
                                                <th>زمان قسط</th>
                                                <th>زمان پرداختی</th>
                                                <th>مبلغ</th>
                                                <th>وضعیت</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($order->aqsat as $key=>$qest)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$qest->paytime}}</td>
                                                    <td>{{$qest->pardakhti!=null?$qest->pardakhti:'-'}}</td>
                                                    <td>{{number_format($qest->amount)}} تومان</td>
                                                    <td>{{$qest->vaziat}}</td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    @elseif($order->naqditype!=null)
                                        <table class="table">
                                            <thead class="bg-dark">
                                            <tr class="text-white">
                                                <th>شماره</th>
                                                <th>نوع پرداخت</th>
                                                <th>مبلغ</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($order->naqditype as $key=>$naqditype)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$naqditype->title}}</td>
                                                    <td>{{number_format($naqditype->mablagh)}} تومان</td>

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
                </tbody>
            </table>
        </div>
        <!-- START: Form-->
        <form method="post" action="{{route('order.destroy',$order->id)}}" id="submit" enctype="multipart/form-data">
            @csrf
            @method('delete')
            <div class="container-fluid card" style="height: 1750px;">
                <div class="row">
                    <div class="col-12 col-lg-6 row">


                        <div class="col-12 row">

                            <div class="col-12 row">




                            </div>

                        </div>

                    </div>
                    <div class=" col-12 mb-5 mt-5 row pl-5">
                        <div class="col-12 text-center mt-5">

                            <div class="col-12 text-center mt-5">
                                <h3>محاسبه پول بازگشتی به مشترک</h3>
                                <div class="row text-center" id="calculate">
                                    <div class="col-12">
                                    @if($order->aqsat!=null)
                                        <table class="table table-hover table-striped w-50 m-auto table-bordered">
                                            <thead class="">
                                            <tr class="text-white">
                                                <th>شماره</th>
                                                <th>زمان قسط</th>
                                                <th>زمان پرداختی</th>
                                                <th>مبلغ</th>
                                                <th>وضعیت</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($order->aqsat as $key=>$qest)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$qest->paytime}}</td>
                                                    <td>{{$qest->pardakhti!=null?$qest->pardakhti:'-'}}</td>
                                                    <td>{{number_format($qest->amount)}} تومان</td>
                                                    <td>{{$qest->vaziat}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                </td>
                                                <td></td>
                                                <td> مجموع: {{number_format($order->statusmali[0]->bestankar)}} تومان</td>

                                            </tr>
                                            </tbody>
                                        </table>
                                    @elseif($order->naqditype!=null)
                                        <table class="table table-hover table-striped w-50 m-auto table-bordered">
                                            <thead class="">
                                            <tr class="text-white">
                                                <th>شماره</th>
                                                <th>نوع پرداخت</th>
                                                <th>مبلغ</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($order->naqditype as $key=>$naqditype)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$naqditype->title}}</td>
                                                    <td>{{number_format($naqditype->mablagh)}} تومان</td>

                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td><label for="upload" class="btn btn-info">آپلود فیش واریز</label>
                                                    <input type="file" id="upload" class="d-none" name="fish">
                                                </td>
                                                <td><input name="priceTrans" id="priceTrans" value="{{number_format($order->statusmali[0]->bestankar)}}"></td>
                                                <td> مجموع: {{number_format($order->statusmali[0]->bestankar)}} تومان</td>

                                            </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                    </div>
                            </div>
                            <div class="col-12 mb-3 mt-5">
                                <button type="submit" class="w-25 btn btn-success pt-2 pb-2" style="background: orangered!important" id="freesubmit">ثبت کنسلی</button>
                            </div>
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
@endif
>
