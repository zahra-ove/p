@extends('admin.master.ajax')

@section('js')
{{--    <script src="https://rawgit.com/abdennour/hijri-date/master/cdn/hijri-date-latest.js"--}}
{{--            type="text/javascript"></script>--}}
    <script src="{{asset('admin/js/hijri-date-latest.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin')}}/js/jdate.min.js" type="text/javascript" charset="utf-8"></script>
    {{--    <script src="{{asset('admin')}}/js/taghvimSCOOBCanscel.js" type="text/javascript" charset="utf-8"></script>--}}
    <script>

        ///freetimaForm

        let tarikhs = [];
        $(document).ready(function () {
            let contFile=0;

            $('#freesubmit').addClass('d-none');

            $('#price').val($(this).children('option:selected').attr('price'));
            $('#takhtId').val('{!! $order->takht_id !!}');
            $('#pricemonth').val($(this).children('option:selected').attr('pricemonth'));
            ////refresh
            $('#dayTable').empty();
            $('#titrTarikh').remove();
            $('#preMonth').remove();
            $('#nextMonth').remove();
            $('#miladiTitr').remove();
            $('#tarikhclicked').remove();
            $('#raft').val('');
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
            $('#today').html(`${jdateNow.date[0]}/${jdateNow.date[1]}/${jdateNow.date[2]}`);


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
                        $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}" style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                    if (days == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                        $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                    if (days == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                        $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                    if (days == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                        $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                    if (days == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                        $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                    if (days == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                        $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                    if (days == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                    if (days == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                    if (days == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                    if (days == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                    if (days == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                    if (days == jdate.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                    if (days == jdate.date['2']) {
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

            $('.tdDay').each(function () {
                let attr = $(this).attr('tarikh').split('/');
                pastDate = JalaliDate.jalaliToGregorian(attr[0], attr[1], attr[2]);

                let pastMiladi = pastDate[0] + "-" + pastDate[1] + "-" + pastDate[2];
                let newmiladi = new Date(miladi).getTime();
                let newpastMiladi = new Date(pastMiladi).getTime();
                if (newpastMiladi < newmiladi) {
                    $(this).css('opacity', '50%').addClass('gozashteh');
                }

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
                thisDayTotal = JDate.toGregorian(parseInt(thisDayTotalSplit[0]), parseInt(thisDayTotalSplit[1]), parseInt(thisDayTotalSplit[2])).getTime();
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
                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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



                ///////disable pass day

                $('.tdDay').each(function (index) {
                    let $this = $(this);
                    let clicktarikh = $(this).attr('tarikh').split('/');
                    clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                    let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                    $(this).attr('miladi', miladi);
                    let totalToday = JDate.toGregorian(jdateNow.date[0], jdateNow.date[1], jdateNow.date[2]).getTime();
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
                    thisDayTotalSplit = $(this).attr('tarikh').split('/');
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
                $.ajax({
                    url: "{{asset('admin/getorderbytakht')}}/" + {!! $order->takht_id !!},
                    success: function (data) {
                        if (data != 'notfound') {
                            data.forEach(function (item, index) {
                                // let roomId = $(this).val();
                                let thisraft = "{!! $order->raft !!}";
                                let thisbargasht = "{!! $order->bargasht !!}";
                                let v = new Date(`${item.raft}`).getTime();
                                let kh = new Date(`${item.bargasht}`).getTime();
                                let diff = kh - v;
                                let betDays = []
                                let unixDay = v;
                                let day = '';
                                const oneDay = 1000 * 60 * 60 * 24;
                                let countDays = Math.round(diff / oneDay);

                                for (let i = 1; i <= countDays; i++) {
                                    if (i == 1) {

                                        betDays.push(new Date(unixDay));
                                    } else {
                                        unixDay = unixDay + oneDay;
                                        betDays.push(new Date(unixDay));
                                    }
                                    $('.tdDay').each(function (index) {

                                        // console.log(new Date($(this).attr('miladi')).setHours()==new Date(unixDay).setHours())
                                        if (new Date($(this).attr('miladi')).setHours(0, 0, 0) == new Date(unixDay).setHours(0, 0, 0)) {

                                            $(this).addClass('reserved').css('color', 'red');
                                        }
                                        if (new Date(thisraft).setHours(0, 0, 0)<= new Date(unixDay).setHours(0, 0, 0) && new Date(thisbargasht).setHours(0, 0, 0)>new Date(unixDay).setHours(0, 0, 0))
                                        {
                                            $(this).removeClass('reserved').css('color', 'black');
                                        }
                                    });
                                }

                            });
                        }

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
                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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
                            $('.titr').last().append(`<td class="text-center tdDay" day="${days}" month="${jdate.date['1']}" tarikh="${jdate.date['0']}/${jdate.date['1']}/${days}"style="cursor: pointer;border:1px solid #dee2e6">${days}</td>`);
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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

                        if (days == jdateNow.date['2'] && $(this).attr('month') == jdateNow.date['1']) {
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


                ///////disable pass day

                $('.tdDay').each(function (index) {
                    let $this = $(this);
                    let clicktarikh = $(this).attr('tarikh').split('/');
                    clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                    let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                    $(this).attr('miladi', miladi);
                    let totalToday = JDate.toGregorian(jdateNow.date[0], jdateNow.date[1], jdateNow.date[2]).getTime();
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
                    thisDayTotalSplit = $(this).attr('tarikh').split('/');
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
                $.ajax({
                    url: "{{asset('admin/getorderbytakht')}}/" + {!! $order->takht_id !!},
                    success: function (data) {
                        if (data != 'notfound') {
                            data.forEach(function (item, index) {
                                // let roomId = $(this).val();
                                let thisraft = "{!! $order->raft !!}";
                                let thisbargasht = "{!! $order->bargasht !!}";
                                let v = new Date(`${item.raft}`).getTime();
                                let kh = new Date(`${item.bargasht}`).getTime();
                                let diff = kh - v;
                                let betDays = []
                                let unixDay = v;
                                let day = '';
                                const oneDay = 1000 * 60 * 60 * 24;
                                let countDays = Math.round(diff / oneDay);

                                for (let i = 1; i <= countDays; i++) {
                                    if (i == 1) {

                                        betDays.push(new Date(unixDay));
                                    } else {
                                        unixDay = unixDay + oneDay;
                                        betDays.push(new Date(unixDay));
                                    }
                                    $('.tdDay').each(function (index) {

                                        // console.log(new Date($(this).attr('miladi')).setHours()==new Date(unixDay).setHours())
                                        if (new Date($(this).attr('miladi')).setHours(0, 0, 0) == new Date(unixDay).setHours(0, 0, 0)) {

                                            $(this).addClass('reserved').css('color', 'red');
                                        }
                                        if (new Date(thisraft).setHours(0, 0, 0)<= new Date(unixDay).setHours(0, 0, 0) && new Date(thisbargasht).setHours(0, 0, 0)>new Date(unixDay).setHours(0, 0, 0))
                                        {
                                            $(this).removeClass('reserved').css('color', 'black');
                                        }
                                    });
                                }

                            });
                        }

                    }
                });
            });


////////
            $('.time').clockTimePicker();


            $('#emaltakhfif').click(function (eee) {
                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                let takhfif = $('#takhfif').val().replaceAll(',', "");
                let final = $('#totalPriceInput').val() - takhfif;
                $("#finallyPriceInput").val(final);
                $('#finallyPrice').html(`${numberWithCommas(final)} تومان`)
            });


            $('#paytype').change(function (ee) {
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
                    $('#countMonthTitr').html(`<div class="col-10"> <input min="1" type="number" class="form-control" id="countMonth" value="1"></div> <div class="col-2"> <span class="btn btn-secondary" id="tayidCount" style="cursor: pointer">تایید</span></div>`)
                }
                $('#tayidCount').click(function (ese) {


                    $('#tarikhMonth').empty();
                    let countMonth = $('#countMonth').val();
                    let perMounth = parseInt($('#finallyPriceInput').val().replaceAll(',', '')) / countMonth;
                    $('#perMonth').val(perMounth);
                    $('#tarikhMonthTitr').append(`<h6 id="perMonth" class="mt-3">${numberWithCommas(perMounth)} تومان مبلغ پرداختی هر نوبت</h6>`)
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

                                if ($(this).val()==""){

                                    e.preventDefault();
                                    toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');

                                }
                                else {

                                    let clicktarikh = $(this).val().split('/');
                                    clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                    let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                    $(this).val(miladi);

                                }


                            });


                        }

                    }


                });
            });

            let id ={!! $order->takht_id !!};


            {{--$('.tdDay').each(function (index) {--}}

            {{--    if (new Date($(this).attr('miladi')).getTime() == new Date("{!! $order->bargasht !!}").getTime()) {--}}
            {{--        $(this).addClass('bg-success');--}}

            {{--        $('#to').html(new JDate(new Date($(this).attr('miladi'))).format('dddd DD MMMM YYYY'));--}}

            {{--    }--}}
            {{--});--}}

            $('#price').val('{!! $order->takht->price !!}');
            $.ajax({
                url: "{{asset('admin/getorderbytakht')}}/" + {!! $order->takht_id !!},
                success: function (data) {
                    if (data != 'notfound') {
                        data.forEach(function (item, index) {
                            // let roomId = $(this).val();
                            let thisraft = "{!! $order->raft !!}";
                            let thisbargasht = "{!! $order->bargasht !!}";
                            let v = new Date(`${item.raft}`).getTime();
                            let kh = new Date(`${item.bargasht}`).getTime();
                            let diff = kh - v;
                            let betDays = []
                            let unixDay = v;
                            let day = '';
                            const oneDay = 1000 * 60 * 60 * 24;
                            let countDays = Math.round(diff / oneDay);

                            for (let i = 1; i <= countDays; i++) {
                                if (i == 1) {

                                    betDays.push(new Date(unixDay));
                                } else {
                                    unixDay = unixDay + oneDay;
                                    betDays.push(new Date(unixDay));
                                }
                                $('.tdDay').each(function (index) {

                                    // console.log(new Date($(this).attr('miladi')).setHours()==new Date(unixDay).setHours())
                                    if (new Date($(this).attr('miladi')).setHours(0, 0, 0) == new Date(unixDay).setHours(0, 0, 0)) {

                                        $(this).addClass('reserved').css('color', 'red');
                                    }
                                    if (new Date(thisraft).setHours(0, 0, 0)<= new Date(unixDay).setHours(0, 0, 0) && new Date(thisbargasht).setHours(0, 0, 0)>new Date(unixDay).setHours(0, 0, 0))
                                    {
                                        $(this).removeClass('reserved').css('color', 'black');
                                    }
                                });
                            }

                        });
                    }

                }
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


            //////picker
            $(document).on('click', '.tdDay', function (ee) {
                // $('#raft').val('');
                // $('#bargasht').val('');
                // $('#mounth').val('');
                // $('#from').empty();
                // $('#to').empty();

                if ($('#bargasht').val().length!=0 && $('.bg-warning').length!=1){
                    $('#room').prop('disabled',false);
                }
                let clicktarikh = $(this).attr('tarikh').split('/');
                clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                let beShamsiKamel = new JDate(new Date(miladi)).format('dddd DD MMMM YYYY')
                let bargashtUnix = new Date($('#bargasht').val()).getTime();
                let raftmiladi = new Date(miladi).getTime();

                if ($('#mounth').val() != 0 && $('#mounth').val() != null || $('#reserve').val() == 1) {
                    // $('#calculate').css('display','');
                    // $('#freesubmit').css('display','');
                    $('.tdDay').each(function (index) {
                        if ($(this).attr('tarikh')!=undefined) {
                            let attr = $(this).attr('tarikh').split('/');
                            pastDate = JalaliDate.jalaliToGregorian(attr[0], attr[1], attr[2]);

                            let pastMiladi = pastDate[0] + "-" + pastDate[1] + "-" + pastDate[2];
                            let newmiladi = new Date(miladi).getTime();
                            let newpastMiladi = new Date(pastMiladi).getTime();
                            if (newpastMiladi < newmiladi) {
                                $(this).css('opacity', '50%').addClass('gozashteh');
                            }
                        }
                    });
                    if ($(this).hasClass('bg-warning')) {

                        $('#calculate').addClass('d-none');
                        $('#freesubmit').addClass('d-none');
                        $(this).removeClass('bg-warning');
                        $('.gozashteh').not('.gozashte').css('opacity', '100%').removeClass('gozashteh');
                        let indexof = tarikhs.indexOf(miladi);
                        tarikhs.splice(indexof, 1);
                        if ($('#reserve').val()=='2'){
                            $('#bargasht').val('');
                            $('#to').empty();
                        }
                        $('#raft').val('');
                        $('#from').empty();
                        $('#takht').empty();
                        $('#reservehaa').hide();
                        $('#estelam').hide();
                        $('#takhtList').empty();
                        $('#takhtList').hide();
                        $('#room').val('');
                        $('#room').prop('disabled',true);
                        $('#select2-room-container').html('<span class="select2-selection__placeholder">انتخاب کنید.</span>');

                    } else if ($(this).hasClass('gozashte')) {
                        toastr.error('روز های گذشته را نمی توان انتخاب نمود.');

                    }
                    else if ($(this).hasClass('reserved')) {
                        toastr.error('این روز قبلاٌ رزرو شده است.')
                    }
                    else if ($(this).hasClass('gozashteh')) {
                        toastr.error('روز های گذشته را نمیشه انتخاب نمود.')
                    }

                    else if ($('.bg-warning').length == 0 && $('#raft').val().length == 0) {

                        $(this).addClass('bg-warning');
                        $('#raft').val(miladi);
                        $('#from').html(beShamsiKamel);
                    } else if (($('.bg-warning').length == 1 || $('#raft').val() != "") && $('.tdDay.bg-success').length == 0 && $('#bargasht').val() == "") {
                        $(this).addClass('bg-success');
                        $('#room').prop('disabled',false);
                        $('#bargasht').val(miladi);
                        $('#to').html(beShamsiKamel);
                    } else if ($(this).hasClass('bg-success')) {
                        $('.gozashteh').not('.gozashte').css('opacity', '100%').removeClass('gozashteh');
                        $('#calculate').addClass('d-none');
                        $('#freesubmit').addClass('d-none');
                        $('#takhtList').hide();
                        $(this).removeClass('bg-success');
                        $('#room').val("");
                        $('#takhtList').empty();
                        $('#room').prop('disabled',true);
                        $('#select2-room-container').html('<span class="select2-selection__placeholder">انتخاب کنید.</span>');
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
                }
                else if ($('#mounth').val() != 0){
                    toastr.warning('اول تعداد ماه را انتخاب کنید.');
                }

            });
            $(document).on('click', '.tdDay', function (ee) {

                if ($('#raft').val() != "") {

                    let oneday = 1000 * 60 * 60 * 24;

                    if ($(this).hasClass('bg-warning')) {
                        let thisraft = new Date("{!! $order->raft !!}").setHours(0, 0, 0, 0);
                        let thisbargasht=new Date("{!! $order->bargasht !!}").setHours(0, 0, 0, 0);
                        let clikeddate = new Date($(this).attr('miladi')).setHours(0, 0, 0, 0);
                        let atLast = 0;
                        if (thisbargasht>=clikeddate){
                            atLast=  Math.round((clikeddate - thisraft) / oneday);
                        }
                        else {
                            atLast = Math.round((thisbargasht - thisraft) / oneday);;
                        }
                        let cancelPrice = atLast * parseInt("{!! $order->takht->price !!}");
                        if (atLast < 0) {
                            $('#daysdovom').val(0);
                        } else {
                            $('#daysdovom').val(atLast);
                        }


                        $('#cancelPrice').val(cancelPrice);
                    }
                } else {

                }
            })
            $(document).on('change','#reserve',function (evv) {
                $('.gozashteh').not('.gozashte').css('opacity', '100%').removeClass('gozashteh');
                $('.bg-warning').removeClass('bg-warning');
                $('.bg-success').removeClass('bg-success');
                $('#to').empty();
                $('#raft').val("");
                $('#from').empty();
                $('#bargasht').val("");
                $('#calculate').addClass('d-none');
                $('#freesubmit').addClass('d-none');
                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
                $('#Prereserve option[value=1]').prop('selected',true);
                $('#select2-Prereserve-container').text('روزانه');
                $('#select2-Prereserve-container').attr('title','روزانه');
                $('#totaldaysDovomTitr').removeClass('d-none');
                $('#totalMonthDovomTitr').addClass('d-none');
                $('#roozaneTitrDovom').removeClass('d-none');
                $('#mahaneTitrDovom').addClass('d-none');


                let betDays = []
                let day = '';
                const oneDay = 1000 * 60 * 60 * 24;
                let raftDovom = new Date("{!! $order->raft !!}").getTime();
                let raft = new Date($('#raft').val()).getTime();
                let bargasht = new Date($('#bargasht').val()).getTime();
                let diff = bargasht - raft;
                let diffDovom = raft-raftDovom;
                let countDays = Math.round(diff / oneDay);
                let countDaysdovom = Math.ceil(diffDovom / oneDay);
                $('#daysdovom').val(countDaysdovom);
                $('#pricedovom').val('{!! $order->takht->price !!}');
                let totalDovom = parseInt($('#daysdovom').val(countDaysdovom)) * parseInt($('#pricedovom').val());
                let totalPrice=parseInt($('#daysdovom').val()) * parseInt($('#pricedovom').val());

                $("#totaldaysDovom").html(`${Math.ceil($('#daysdovom').val())} روز`);
                $("#takPriceDovom").html(`${numberWithCommas({!! $order->takht->price !!})} تومان`);
                $("#totalPriceDovom").html(`${numberWithCommas(totalPrice)} تومان`);
                $("#totalPriceInput").val(totalPrice);
                // $("#finallyPriceInput").val(totalPrice);
                $('#bedehkar').val("{!! $order->bedehkar !!}");
                let bedehkar = $('#bedehkar').val();


                if (parseInt(bedehkar) == 0) {
                    let thisTotal = "{!! $order->statusmali[0]->bedehkar !!}";
                    let totalGhabl = parseInt($('#daysdovom').val()) * parseInt(`{!! $order->takht->price !!}`);
                    let totalKhales = parseInt(thisTotal) - totalGhabl;
                    $('#totaldovom').val(numberWithCommas(totalGhabl));
                    if (totalKhales < 0) {
                        $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                    } else {
                        $('#totaldovom').val('0');
                        totalNew=$('#totalPrice').text().substr(0,$('#totalPrice').text().length-6);
                        let mabetafavot = parseInt(totalNew.replaceAll(",","")) - totalKhales;

                        if (mabetafavot < 0) {
                            $('#finallyPriceInput').val('0');
                            $('#bestankar').val(parseInt(mabetafavot * -1));
                            $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                        } else {
                            $('#finallyPriceInput').val(numberWithCommas(mabetafavot));
                            $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                        }

                    }

                } else if (parseInt(bedehkar) > 0) {
                    let thisTotal = "{!! $order->statusmali[0]->bestankar !!}";
                    let totalGhabl = parseInt($('#daysdovom').val().replaceAll(",","")) * parseInt(`{!! $order->takht->price !!}`);
                    let totalKhales = parseInt(thisTotal) - totalGhabl;

                    if (totalKhales < 0) {
                        $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                    } else {
                        $('#totaldovom').val('0');
                        let mabetafavot = parseInt($('#totalPriceInput').val()) - totalKhales;

                        if (mabetafavot < 0) {
                            $('#finallyPriceInput').val('0');
                            $('#bestankar').val(parseInt(mabetafavot * -1));
                            $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                        } else {
                            $('#finallyPriceInput').val(numberWithCommas(Math.abs(mabetafavot)));
                            $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                        }

                    }


                }
                if ($(this).val() == '1') {

                    $('#divMonth').addClass('d-none');
                    // $('#calculate').removeClass('d-none');
                    $('#roozaneTitr').removeClass('d-none');
                    $('#mahaneTitr').addClass('d-none');
                    $('#totaldays').empty();
                    $('#totaldaysDovom').empty();
                    $('#finallyPrice').empty();
                    $('#timeTable').removeClass('d-none');
                    $('#totalPrice').empty();
                    $('#takPrice').empty();
                    $('#totalPriceInput').empty();
                    $('#finallyPriceInput').empty();
                    $('#countMonthTitr').empty();
                    $('#tarikhMonth').empty();

                    $('#tarikhMonthTitr').empty();

                    $(document).on('click', '.tdDay', function (er) {
                        let betDays = []
                        let day = '';
                        const oneDay = 1000 * 60 * 60 * 24;

                        if ($(this).hasClass('bg-success') || ($(this).hasClass('bg-warning') && $('.bg-success').length != 0)) {

                            let raft = new Date($('#raft').val()).getTime();
                            let bargasht = new Date($('#bargasht').val()).getTime();
                            let diff = bargasht - raft;
                            let countDays = Math.round(diff / oneDay);
                            $('#days').val(countDays);
                            let totalPrice = parseInt($('#days').val()) * parseInt($('#price').val());
                            $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                            $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                            $("#totaldays").html(`${countDays} روز`);
                            $("#totaldaysDovom").html(`${$('#daysdovom').val()} روز`);

                            $("#takPrice").html(`${numberWithCommas($('#price').val()).substr(0, numberWithCommas($('#price').val()).length - 3)} تومان`);
                            $("#totalPriceInput").val(totalPrice);
                            $("#finallyPriceInput").val(numberWithCommas(totalPrice));
                            let bedehkar = $('#bedehkar').val();

                            if (parseInt(bedehkar) == 0) {
                                let thisTotal = "{!! $order->statusmali[0]->bedehkar !!}";
                                let totalGhabl = parseInt($('#daysdovom').val()) * parseInt(`{!! $order->takht->price !!}`);
                                let totalKhales = parseInt(thisTotal) - totalGhabl;
                                $('#totaldovom').val(numberWithCommas(totalGhabl));
                                if (totalKhales < 0) {
                                    $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                                } else {
                                    $('#totaldovom').val('0');
                                    let mabetafavot = parseInt($('#totalPriceInput').val()) - totalKhales;
                                    if (mabetafavot < 0) {
                                        $('#finallyPriceInput').val('0');
                                        $('#bestankar').val(parseInt(mabetafavot * -1));
                                        $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                                    } else {
                                        $('#finallyPriceInput').val(numberWithCommas(mabetafavot));
                                        $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                                    }

                                }

                            } else if (parseInt(bedehkar) > 0) {
                                let thisTotal = "{!! $order->statusmali[0]->bestankar !!}";
                                let totalGhabl = parseInt($('#daysdovom').val()) * parseInt(`{!! $order->takht->price !!}`);
                                let totalKhales = parseInt(thisTotal) - totalGhabl;

                                if (totalKhales < 0) {
                                    $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                                } else {
                                    $('#totaldovom').val('0');
                                    let mabetafavot = parseInt($('#totalPriceInput').val()) - totalKhales;
                                    if (mabetafavot < 0) {
                                        $('#finallyPriceInput').val('0');
                                        $('#bestankar').val(parseInt(mabetafavot * -1));
                                        $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                                    } else {
                                        $('#finallyPriceInput').val(numberWithCommas(Math.abs(mabetafavot)));
                                        $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                                    }

                                }


                            }
                            $('#calculate').removeClass('d-none');
                            $('#freesubmit').removeClass('d-none');
                        }
                    });

                }
                if ($(this).val() == '2') {

                    // $('#mounth').val(countDays);
                    $('#divMonth').removeClass('d-none');
                    $('#mahaneTitr').removeClass('d-none');
                    $('#roozaneTitr').addClass('d-none');
                    $('#timeTable').removeClass('d-none');
                    $('#totaldays').empty();
                    $('#finallyPrice').empty();
                    $('#totalPrice').empty();
                    $('#takPrice').empty();
                    $('#totalPriceInput').empty();
                    $('#finallyPriceInput').empty();
                    $('#countMonthTitr').empty();
                    $('#tarikhMonth').empty();
                    $('#tarikhMonthTitr').empty();
                    {{--                $(document).on('click', '.tdDay', function (er) {--}}
                    {{--                    let raft = new Date($('#raft').val()).getTime();--}}
                    {{--                    let bargasht = new Date($('#bargasht').val()).getTime();--}}
                    {{--                    let diff = bargasht - raft;--}}

                    {{--                    const oneDay = 1000 * 60 * 60 * 24 * 30;--}}
                    {{--                    let countDays = Math.round(diff / oneDay);--}}
                    {{--                    $('#pricemonth').val('{!! $order->takht->pricemonth !!}');--}}
                    {{--                    let totalPrice = parseInt($('#mounth').val()) * parseInt($('#pricemonth').val());--}}
                    {{--                    $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);--}}
                    {{--                    $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);--}}
                    {{--                    $("#totaldays").html(`${$('#mounth').val()} ماه`);--}}

                    {{--                    $("#takPrice").html(`${numberWithCommas($('#pricemonth').val()).substr(0, numberWithCommas($('#pricemonth').val()).length - 3)} تومان`);--}}
                    {{--                    $("#totalPriceInput").val(totalPrice);--}}
                    {{--                    $("#finallyPriceInput").val(numberWithCommas(totalPrice));--}}
                    {{--                    let tarikhMonth='';--}}
                    {{--                    if ($('.bg-warning').attr('month')=='11'){--}}
                    {{--                        tarikhMonth = $('#mounth').val() * 2505600000;--}}
                    {{--                    }--}}
                    {{--                    else if ($('.bg-warning').attr('month')=='1' || $('.bg-warning').attr('month')=='2' || $('.bg-warning').attr('month')=='3' || $('.bg-warning').attr('month')=='4' || $('.bg-warning').attr('month')=='5' || $('.bg-warning').attr('month')=='6' ){--}}
                    {{--                        tarikhMonth = $('#mounth').val() * 2678400000;--}}
                    {{--                        if ($('.bg-warning').attr('month')=='6' && $('.bg-warning').text()=='31'){--}}
                    {{--                            tarikhMonth = $('#mounth').val() * 2505600000;--}}
                    {{--                        }--}}
                    {{--                    }--}}
                    {{--                    else {--}}
                    {{--                        tarikhMonth = $('#mounth').val() * 2592000000;--}}
                    {{--                    }--}}
                    {{--                    let monthBargashtUnix = new Date($('#raft').val()).getTime() + tarikhMonth;--}}
                    {{--                    let monthBargasht = new Date(monthBargashtUnix);--}}
                    {{--                    let raftobiy = new JDate(new Date($('#raft').val()));--}}
                    {{--                    let jdate22 = new JDate(new Date(monthBargasht.getFullYear(), monthBargasht.getMonth(), monthBargasht.getDay()))--}}
                    {{--                    let bargashtAzMah="";--}}
                    {{--                    if ((raftobiy.date[1]=='6' && raftobiy.date[2]=="31") || (raftobiy.date[1]=='5' && raftobiy.date[2]=="31") || (raftobiy.date[1]=='4' && raftobiy.date[2]=="31") || (raftobiy.date[1]=='3' && raftobiy.date[2]=="31") || (raftobiy.date[1]=='2' && raftobiy.date[2]=="31")){--}}

                    {{--                        bargashtAzMah = new JDate(jdate22.date[0], jdate22.date[1], '30');--}}
                    {{--                    }--}}
                    {{--                    else {--}}
                    {{--                        bargashtAzMah = new JDate(jdate22.date[0], jdate22.date[1], raftobiy.date[2]);--}}
                    {{--                    }                    azmahmiladi = JalaliDate.jalaliToGregorian(bargashtAzMah.date[0], bargashtAzMah.date[1], bargashtAzMah.date[2]);--}}
                    {{--                    let bargashrazmiladi = azmahmiladi[0] + "-" + azmahmiladi[1] + "-" + azmahmiladi[2];--}}
                    {{--                    let beShamsiKamelBargasht = bargashtAzMah.format('dddd DD MMMM YYYY');--}}
                    {{--                    $('#bargasht').val(bargashrazmiladi);--}}
                    {{--                    $('#to').html(beShamsiKamelBargasht);--}}
                    {{--                    $.ajax({--}}
                    {{--                        url:"{{asset('admin/getoreders2date')}}/"+"{!! $order->takht_id !!}"+'/' +$('#raft').val() +'/'+ $('#bargasht').val() + '/' + $('#reserve').val() + '/' + "{!! $order->id !!}",--}}
                    {{--                        async:false,--}}
                    {{--                        success: function (data){--}}
                    {{--                            let raftJalali= new JDate(new Date($('#raft').val())).format('YYYY/MM/DD');--}}
                    {{--                            let bargashtJalali= new JDate(new Date($('#bargasht').val())).format('YYYY/MM/DD');--}}
                    {{--                            $(`#fullTable tbody`).empty();--}}
                    {{--                            if (data != 'notfound') {--}}

                    {{--                                $('#reservesModal').modal('show');--}}
                    {{--                                data.forEach(function (item,index) {--}}
                    {{--                                    $(`#fullTable tbody`).append(`--}}
                    {{--<tr>--}}
                    {{--<td>${index+1}</td>--}}
                    {{--<td>${item.fullname}</td>--}}
                    {{--<td>${item.raftjalali}</td>--}}
                    {{--<td>${item.bargashtjalali}</td>--}}
                    {{--<td>${item.statusmalis}</td>--}}
                    {{--</tr>--}}
                    {{--`);--}}
                    {{--                                });--}}
                    {{--                                $('#fullReserveHeader').text(`لیست رزرو ها از تاریخ ${raftJalali} تا تاریخ ${bargashtJalali}`);--}}
                    {{--                                $('.bg-success').removeClass('bg-success');--}}
                    {{--                                $('#bargasht').val('');--}}
                    {{--                                $('#to').empty();--}}
                    {{--                                $('.bg-warning').removeClass('bg-warning');--}}
                    {{--                                $('#raft').val('');--}}
                    {{--                                $('#from').empty();--}}
                    {{--                                toastr.error('بین تاریخ شروع و پایان رزرو وجود دارد.');--}}
                    {{--                            }--}}
                    {{--                        }--}}
                    {{--                    });--}}
                    {{--                    if ($(this).hasClass('bg-warning')) {--}}
                    {{--                        // console.log($('#daysdovom').val());--}}
                    {{--                        $("#totaldaysDovom").html(`${$('#daysdovom').val()} روز`);--}}
                    {{--                        $('#calculate').removeClass('d-none');--}}
                    {{--                        $('#freesubmit').removeClass('d-none');--}}
                    {{--                    }--}}
                    {{--                });--}}


                }
                if ($(this).val() == '') {
                    $('#timeTable').addClass('d-none');
                    $('#calculate').addClass('d-none');
                    $('#freesubmit').addClass('d-none');

                }
                $('#bedehkar').val("{!! $order->bedehkar !!}");


            });
            $(document).on('click','.tdDay',function (er) {
                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
                if ($('#reserve').val() == '1') {
                    $('#totaldaysTitr').removeClass('d-none');
                    $('#totaldaysDiv').removeClass('d-none');
                    $('#mahaneTitr').addClass('d-none');
                    $('#totalMonthDovomTitr').addClass('d-none');
                    $('#totaldaysTitr').show();
                    $('#totaldaysDiv').show();
                    $('#monthsTitr').addClass('d-none');
                    $('#totalmonthsTitr').addClass('d-none');
                    $('#divMonth').addClass('d-none');
                    // $('#calculate').removeClass('d-none');
                    $('#roozaneTitr').removeClass('d-none');
                    $('#roozaneTitrDovom').removeClass('d-none');
                    $('#mahaneTitr').addClass('d-none');
                    $('#totaldays').empty();
                    $('#totaldaysDovom').empty();
                    $('#finallyPrice').empty();
                    $('#timeTable').removeClass('d-none');
                    $('#totalPrice').empty();
                    $('#takPrice').empty();
                    $('#totalPriceInput').empty();
                    $('#finallyPriceInput').empty();
                    $('#countMonthTitr').empty();
                    $('#tarikhMonth').empty();
                    $('#tarikhMonthTitr').empty();
                    const oneDay = 1000 * 60 * 60 * 24;
                    $('#price').val('{!! $order->takht->price !!}');
                    $('#pricedovom').val('{!! $order->takht->price !!}');
                    $("#takPrice").html(`${numberWithCommas($('#price').val()).substr(0, numberWithCommas($('#price').val()).length - 3)} تومان`);
                    $('#permounth').val(parseInt($('#price').val()));
                    let raftDovom = new Date("{!! $order->raft !!}").getTime();
                    let raft = new Date($('#raft').val()).getTime();
                    let bargasht = new Date($('#bargasht').val()).getTime();
                    let diff = bargasht - raft;
                    let diffDovom = raft-raftDovom;
                    let countDays = Math.ceil(diff / oneDay);
                    let countDaysdovom = Math.ceil(diffDovom / oneDay);
                    $('#daysdovom').val(countDaysdovom);
                    $('#days').val(countDays);
                    let totalPricedovom = parseInt($('#daysdovom').val()) * parseInt($('#pricedovom').val());
                    $("#totalPriceDovom").html(`${numberWithCommas(totalPricedovom)} تومان`);
                    let totalPrice = parseInt($('#days').val()) * parseInt($('#price').val());
                    $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                    $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                    $("#totaldays").html(`${countDays} روز`);
                    $("#totaldaysDovom").html(`${Math.ceil($('#daysdovom').val())} روز`);
                    $("#takPrice").html(`${numberWithCommas($('#price').val()).substr(0, numberWithCommas($('#price').val()).length - 3)} تومان`);
                    $("#takPriceDovom").html(`${numberWithCommas($('#pricedovom').val()).substr(0, numberWithCommas($('#pricedovom').val()).length - 3)} تومان`);
                    $("#totalPriceInput").val(totalPrice);
                    $("#finallyPriceInput").val(numberWithCommas(totalPrice));
                    let bedehkar = $('#bedehkar').val();

                    if (parseInt(bedehkar) == 0) {
                        let thisTotal = "{!! $order->statusmali[0]->bedehkar !!}";
                        let totalGhabl = parseInt($('#daysdovom').val()) * parseInt(`{!! $order->takht->price !!}`);
                        let totalKhales = parseInt(thisTotal) - totalGhabl;
                        $('#totaldovom').val(numberWithCommas(totalGhabl));
                        if (totalKhales < 0) {
                            $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                        } else {
                            $('#totaldovom').val('0');
                            let mabetafavot = parseInt($('#totalPriceInput').val()) - totalKhales;

                            if (mabetafavot < 0) {
                                $('#finallyPriceInput').val('0');
                                $('#bestankar').val(parseInt(mabetafavot * -1));
                                $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                            } else {
                                $('#finallyPriceInput').val(numberWithCommas(mabetafavot));
                                $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                            }

                        }

                    } else if (parseInt(bedehkar) > 0) {
                        let thisTotal = "{!! $order->statusmali[0]->bestankar !!}";
                        let totalGhabl = parseInt($('#daysdovom').val()) * parseInt(`{!! $order->takht->price !!}`);
                        let totalKhales = parseInt(thisTotal) - totalGhabl;
                        if (totalKhales < 0) {
                            $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                        }
                        else {
                            $('#totaldovom').val('0');
                            let mabetafavot = parseInt($('#totalPriceInput').val()) - totalKhales;

                            if (mabetafavot < 0) {
                                $('#finallyPriceInput').val('0');
                                $('#bestankar').val(parseInt(mabetafavot * -1));
                                $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                            } else {
                                $('#finallyPriceInput').val(numberWithCommas(Math.abs(mabetafavot)));
                                $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                            }

                        }
                    }

                    let betDays = []
                    let day = '';


                    if ($(this).hasClass('bg-success') || ($(this).hasClass('bg-warning') && $('.bg-success').length != 0)) {


                        $('#calculate').css('display','');
                        $('#freesubmit').css('display','');
                    }
                    if ($(this).hasClass('bg-warning')) {
                        $('#calculate').css('display','none');
                        $('#freesubmit').css('display','none');
                    }
                    if ($(this).hasClass('bg-success')){
                        $('#Prereserve option[value=1]').prop('selected',true);
                        $('#select2-Prereserve-container').text('روزانه');
                        $('#select2-Prereserve-container').attr('title','روزانه');
                        $('#totaldaysDovomTitr').removeClass('d-none');
                        $('#totalMonthDovomTitr').addClass('d-none');
                        $('#roozaneTitrDovom').removeClass('d-none');
                        $('#mahaneTitrDovom').addClass('d-none');


                        let betDays = []
                        let day = '';
                        const oneDay = 1000 * 60 * 60 * 24;
                        let raftDovom = new Date("{!! $order->raft !!}").getTime();
                        let raft = new Date($('#raft').val()).getTime();
                        let bargasht = new Date($('#bargasht').val()).getTime();
                        let diff = bargasht - raft;
                        let diffDovom = raft-raftDovom;
                        let countDays = Math.round(diff / oneDay);
                        let countDaysdovom = Math.ceil(diffDovom / oneDay);
                        $('#daysdovom').val(countDaysdovom);
                        $('#pricedovom').val('{!! $order->takht->price !!}');
                        let totalDovom = parseInt($('#daysdovom').val(countDaysdovom)) * parseInt($('#pricedovom').val());
                        let totalPrice=parseInt($('#daysdovom').val()) * parseInt($('#pricedovom').val());

                        $("#totaldaysDovom").html(`${Math.ceil($('#daysdovom').val())} روز`);
                        $("#takPriceDovom").html(`${numberWithCommas({!! $order->takht->price !!})} تومان`);
                        $("#totalPriceDovom").html(`${numberWithCommas(totalPrice)} تومان`);
                        $("#totalPriceInput").val(totalPrice);
                        // $("#finallyPriceInput").val(totalPrice);
                        $('#calculate').removeClass('d-none');
                        $('#freesubmit').removeClass('d-none');
                        $('#bedehkar').val("{!! $order->bedehkar !!}");
                        let bedehkar = $('#bedehkar').val();


                        if (parseInt(bedehkar) == 0) {
                            let thisTotal = "{!! $order->statusmali[0]->bedehkar !!}";
                            let totalGhabl = parseInt($('#daysdovom').val()) * parseInt(`{!! $order->takht->price !!}`);
                            let totalKhales = parseInt(thisTotal) - totalGhabl;
                            $('#totaldovom').val(numberWithCommas(totalGhabl));
                            if (totalKhales < 0) {
                                $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                            } else {
                                $('#totaldovom').val('0');
                                totalNew=$('#totalPrice').text().substr(0,$('#totalPrice').text().length-6);
                                let mabetafavot = parseInt(totalNew.replaceAll(",","")) - totalKhales;

                                if (mabetafavot < 0) {
                                    $('#finallyPriceInput').val('0');
                                    $('#bestankar').val(parseInt(mabetafavot * -1));
                                    $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                                } else {
                                    $('#finallyPriceInput').val(numberWithCommas(mabetafavot));
                                    $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                                }

                            }

                        } else if (parseInt(bedehkar) > 0) {
                            let thisTotal = "{!! $order->statusmali[0]->bestankar !!}";
                            let totalGhabl = parseInt($('#daysdovom').val().replaceAll(",","")) * parseInt(`{!! $order->takht->price !!}`);
                            let totalKhales = parseInt(thisTotal) - totalGhabl;

                            if (totalKhales < 0) {
                                $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                            } else {
                                $('#totaldovom').val('0');
                                let mabetafavot = parseInt($('#totalPriceInput').val()) - totalKhales;

                                if (mabetafavot < 0) {
                                    $('#finallyPriceInput').val('0');
                                    $('#bestankar').val(parseInt(mabetafavot * -1));
                                    $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                                } else {
                                    $('#finallyPriceInput').val(numberWithCommas(Math.abs(mabetafavot)));
                                    $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                                }

                            }


                        }
                        $('#calculate').removeClass('d-none');
                        $('#freesubmit').removeClass('d-none');
                    }
                    if ($('#bargasht').val()!=''){
                        $.ajax({
                            url:"{{asset('admin/getoreders2date')}}/"+"{!! $order->takht_id !!}"+'/' +$('#raft').val() +'/'+ $('#bargasht').val() + '/' + $('#reserve').val() + '/' + "{!! $order->id !!}",
                            async:false,
                            success: function (data){

                                let raftJalali= new JDate(new Date($('#raft').val())).format('YYYY/MM/DD');
                                let bargashtJalali= new JDate(new Date($('#bargasht').val())).format('YYYY/MM/DD');
                                $(`#fullTable tbody`).empty();
                                if (data != 'notfound') {

                                    $('#reservesModal').modal('show');
                                    data.forEach(function (item,index) {
                                        $(`#fullTable tbody`).append(`
<tr>
<td>${index+1}</td>
<td>${item.fullname}</td>
<td>${item.raftjalali}</td>
<td>${item.bargashtjalali}</td>
<td>${item.statusmalis}</td>
</tr>
`);
                                    });
                                    $('#fullReserveHeader').text(`لیست رزرو ها از تاریخ ${raftJalali} تا تاریخ ${bargashtJalali}`);
                                    $('.bg-success').removeClass('bg-success');
                                    $('#bargasht').val('');
                                    $('#to').empty();
                                    $('.bg-warning').removeClass('bg-warning');
                                    $('.gozashteh').not('.gozashte').css('opacity', '100%').removeClass('gozashteh');
                                    $('#calculate').addClass('d-none');
                                    $('#freesubmit').addClass('d-none');
                                    toastr.error('بین تاریخ شروع و پایان رزرو وجود دارد.');
                                }
                            }
                        });
                    }

                }
                if ($('#reserve').val() == '2') {
                    $('#monthsTitr').removeClass('d-none');
                    $('#totalmonthsTitr').removeClass('d-none');
                    $('#divMonth').removeClass('d-none');
                    $('#mahaneTitr').removeClass('d-none');
                    $('#roozaneTitrDovom').removeClass('d-none');
                    $('#roozaneTitr').addClass('d-none');
                    $('#totalMonthDovomTitr').addClass('d-none');
                    $('#totaldaysTitr').addClass('d-none');
                    $('#totaldaysDiv').addClass('d-none');
                    $('#totaldays').empty();
                    $('#finallyPrice').empty();
                    $('#totalPrice').empty();
                    $('#takPrice').empty();
                    $('#totalPriceInput').empty();
                    $('#finallyPriceInput').empty();
                    $('#countMonthTitr').empty();
                    $('#tarikhMonth').empty();
                    $('#tarikhMonthTitr').empty();
                    $('#pricemonth').val({!! $order->takht->pricemonth !!});
                    $('#pricedovom').val({!! $order->takht->price !!});
                    $("#takPrice").html(`${numberWithCommas($('#pricemonth').val())} تومان`);
                    $("#takPriceDovom").html(`${numberWithCommas($('#pricedovom').val())} تومان`);
                    $('#permounth').val(parseInt($('#price').val()));
                    const oneMonth = 1000 * 60 * 60 * 24 * 30;
                    const oneDay = 1000 * 60 * 60 * 24;
                    let raftDovom = new Date("{!! $order->raft !!}").getTime();
                    let raft = new Date($('#raft').val()).getTime();
                    let bargasht = new Date($('#bargasht').val()).getTime();
                    let diff = bargasht - raft;
                    let diffDovom = raft-raftDovom;
                    let countDays = Math.ceil(diff / oneMonth);
                    let countDaysdovom = Math.ceil(diffDovom / oneDay);
                    $('#daysdovom').val(countDaysdovom);
                    $('#days').val(countDays);
                    $('#permounth').val(parseInt($('#price').val()) * 30);
                    $("#totalmonthsTitr").html(`${$('#mounth').val()} ماه`);
                    let totalPricedovom = parseInt($('#daysdovom').val()) * parseInt($('#pricedovom').val());
                    $("#totaldaysDovom").html(`${$('#daysdovom').val()} روز`);
                    $("#totalPriceDovom").html(`${numberWithCommas(totalPricedovom)} تومان`);
                    let totalPrice = parseInt($('#mounth').val()) * parseInt($('#permounth').val());
                    $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                    $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                    $("#totaldays").html(`${$('#mounth').val()} ماه`);

                    $("#takPrice").html(`${numberWithCommas($('#permounth').val())} تومان`);
                    $("#totalPriceInput").val(totalPrice);
                    $("#finallyPriceInput").val(numberWithCommas(totalPrice));
                    let bedehkar = $('#bedehkar').val();
                    if (parseInt(bedehkar) == 0) {
                        let thisTotal = "{!! $order->statusmali[0]->bedehkar !!}";
                        let totalGhabl = parseInt($('#daysdovom').val()) * parseInt(`{!! $order->takht->price !!}`);
                        let totalKhales = parseInt(thisTotal) - totalGhabl;
                        $('#totaldovom').val(numberWithCommas(totalGhabl));
                        if (totalKhales < 0) {
                            $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                        } else {
                            $('#totaldovom').val('0');
                            let mabetafavot = parseInt($('#totalPriceInput').val()) - totalKhales;

                            if (mabetafavot < 0) {
                                $('#finallyPriceInput').val('0');
                                $('#bestankar').val(parseInt(mabetafavot * -1));
                                $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                            } else {
                                $('#finallyPriceInput').val(numberWithCommas(mabetafavot));
                                $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                            }

                        }

                    } else if (parseInt(bedehkar) > 0) {
                        let thisTotal = "{!! $order->statusmali[0]->bestankar !!}";
                        let totalGhabl = parseInt($('#daysdovom').val()) * parseInt(`{!! $order->takht->price !!}`);
                        let totalKhales = parseInt(thisTotal) - totalGhabl;

                        if (totalKhales < 0) {
                            $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                        } else {
                            $('#totaldovom').val('0');
                            let mabetafavot = parseInt($('#totalPriceInput').val()) - totalKhales;

                            if (mabetafavot < 0) {
                                $('#finallyPriceInput').val('0');
                                $('#bestankar').val(parseInt(mabetafavot * -1));
                                $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                            } else {
                                $('#finallyPriceInput').val(numberWithCommas(Math.abs(mabetafavot)));
                                $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                            }

                        }


                    }

                    if ($('#mounth').val()!=0 && $('#raft').val()!='') {
                        let tarikhMonth='';
                        if ($('.bg-warning').attr('month')=='11'){
                            tarikhMonth = $('#mounth').val() * 2505600000;
                        }
                        else if ($('.bg-warning').attr('month')=='1' || $('.bg-warning').attr('month')=='2' || $('.bg-warning').attr('month')=='3' || $('.bg-warning').attr('month')=='4' || $('.bg-warning').attr('month')=='5' || $('.bg-warning').attr('month')=='6' ){
                            tarikhMonth = $('#mounth').val() * 2678400000;
                            if ($('.bg-warning').attr('month')=='6' && $('.bg-warning').text()=='31'){
                                tarikhMonth = $('#mounth').val() * 2505600000;
                            }
                        }
                        else {
                            tarikhMonth = $('#mounth').val() * 2592000000;
                        }

                        let monthBargashtUnix = new Date($('#raft').val()).getTime() + tarikhMonth;
                        let monthBargasht = new Date(monthBargashtUnix);
                        let raftobiy = new JDate(new Date($('#raft').val()));
                        let jdate22 = new JDate(new Date(monthBargasht.getTime()));
                        let bargashtAzMah="";
                        if ((raftobiy.date[1]=='6' && raftobiy.date[2]=="31") || (raftobiy.date[1]=='5' && raftobiy.date[2]=="31") || (raftobiy.date[1]=='4' && raftobiy.date[2]=="31") || (raftobiy.date[1]=='3' && raftobiy.date[2]=="31") || (raftobiy.date[1]=='2' && raftobiy.date[2]=="31")){

                            bargashtAzMah = new JDate(jdate22.date[0], jdate22.date[1], '30');
                        }
                        else {
                            bargashtAzMah = new JDate(jdate22.date[0], jdate22.date[1], raftobiy.date[2]);
                        }
                        let azmahmiladi = JalaliDate.jalaliToGregorian(bargashtAzMah.date[0], bargashtAzMah.date[1], bargashtAzMah.date[2]);
                        let bargashrazmiladi = azmahmiladi[0] + "-" + azmahmiladi[1] + "-" + azmahmiladi[2];
                        let beShamsiKamelBargasht = bargashtAzMah.format('dddd DD MMMM YYYY');
                        $('#bargasht').val(bargashrazmiladi);
                        $('#to').html(beShamsiKamelBargasht);
                        if ($('#bargasht').val()!='') {
                            $.ajax({
                                url: "{{asset('admin/getoreders2date')}}/" + "{!! $order->takht_id !!}" + '/' + $('#raft').val() + '/' + $('#bargasht').val() + '/' + $('#reserve').val() + '/' + "{!! $order->id !!}",
                                async: false,
                                success: function (data) {
                                    let raftJalali = new JDate(new Date($('#raft').val())).format('YYYY/MM/DD');
                                    let bargashtJalali = new JDate(new Date($('#bargasht').val())).format('YYYY/MM/DD');
                                    $(`#fullTable tbody`).empty();
                                    if (data != 'notfound') {

                                        $('#reservesModal').modal('show');
                                        data.forEach(function (item, index) {
                                            $(`#fullTable tbody`).append(`
<tr>
<td>${index + 1}</td>
<td>${item.fullname}</td>
<td>${item.raftjalali}</td>
<td>${item.bargashtjalali}</td>
<td>${item.statusmalis}</td>
</tr>
`);
                                        });
                                        $('#fullReserveHeader').text(`لیست رزرو ها از تاریخ ${raftJalali} تا تاریخ ${bargashtJalali}`);
                                        $('.bg-success').removeClass('bg-success');
                                        $('#bargasht').val('');
                                        $('#to').empty();
                                        $('#raft').val('');
                                        $('#from').empty();
                                        $('.bg-warning').removeClass('bg-warning');
                                        $('.gozashteh').not('.gozashte').css('opacity', '100%').removeClass('gozashteh');
                                        $('#calculate').addClass('d-none');
                                        $('#freesubmit').addClass('d-none');
                                        toastr.error('بین تاریخ شروع و پایان رزرو وجود دارد.');
                                    }
                                }
                            });
                        }
                        if ($('#bargasht').val().length != 0 && $('#raft').val().length != 0) {

                            $('#room').prop('disabled', false);
                        }
                        if ($(this).hasClass('bg-warning')) {
                            $("#totaldaysDovom").html(`${Math.ceil($('#daysdovom').val())} روز`);

                        }
                    }
                    else {
                        toastr.warning('اول تعداد ماه را انتخاب کنید.')
                    }
                    if ($(this).hasClass('bg-warning')) {
                        // console.log($('#daysdovom').val());
                        $("#totaldaysDovom").html(`${$('#daysdovom').val()} روز`);
                        $('#calculate').removeClass('d-none');
                        $('#freesubmit').removeClass('d-none');
                    }
                }
            });

            $('#mounth').change(function (ev) {
                $('.bg-warning').removeClass('bg-warning');
                $('#from').empty();
                $('#raft').val(null);
                $('#to').empty();
                $('#bargasht').val(null);
                $('#calculate').addClass('d-none');
                $('#freesubmit').addClass('d-none');
            });
            $('.search-box').keyup(function (e) {
                $('.delete-btn').click(function (e) {
                    let btnDel = $(this).attr('data-id');
                    $(this).parents('tr[data-id="' + btnDel + '"]').remove();
                    let info = {
                        "_token": "{{ csrf_token() }}"
                    }
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $.ajax(
                        {
                            url: "{{asset('admin')}}/freetime/" + btnDel,
                            data: info,
                            type: "delete",
                            success: function (data) {
                                if (data == "ok") {
                                    // location.reload();
                                    toastr.success('زمان با موفقیت حذف شد.');

                                } else if (data == "notfound") {
                                    // location.reload();
                                    toastr.success('بروز خطا');
                                }

                            }
                        }
                    );
                });
            });
            // Read in the image file as a data URL.
            $('.delete-btn').click(function (e) {
                let btnDel = $(this).attr('data-id');
                let info = {
                    "_token": "{{ csrf_token() }}",
                    'btn': btnDel,
                }

                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $.ajax(
                    {
                        url: "{{asset('admin')}}/tour/" + btnDel,
                        data: info,
                        type: "delete",
                        success: function (data) {

                            location.reload();

                        }
                    }
                );
            });
            $("#submit").submit(function (e) {

                if ($('#paytype').val() == 'n') {
                    $('.naghdi').each(function (index) {
                        let mablaghesh = $(this).children('.col-10').children('.col-lg-6').children('.naqdtypeMablagh').val();
                        if (index==0 && mablaghesh.length==0){
                            e.preventDefault();
                            toastr.warning('مبلغ پرداختی را تکمیل نمایید.');
                        }

                        if (mablaghesh.length==0 && index!=0){
                            $(this).remove();
                        }
                    });
                    if ($('.naqdtypeMablagh').length!=contFile){
                        e.preventDefault();
                        toastr.warning('تصویر فیش واریزی ثبت نشده است.')
                    }
                }
                $('#takhfif').val($('#takhfif').val().replaceAll(',', ""));
                $('#finallyPriceInput').val($('#finallyPriceInput').val().replaceAll(',', ""));
                $('#totaldovom').val($('#totaldovom').val().replaceAll(',', ""));
                if ($('#raft').val() == "") {
                    e.preventDefault();
                    toastr.error('تاریخ رفت مشخص نیست.');
                }

                if ($('#bargasht').val() == "") {
                    e.preventDefault();
                    toastr.error('تاریخ برگشت مشخص نیست.');
                }

                if ($('#reserve').val() == '') {
                    e.preventDefault();
                    toastr.error('انتخاب نوع رزرو الزامیست.');
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
                if ($('#paytype').val() == 'n') {
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
                }

            });
            let ezaaf=1;
            $(document).on('change','input[name="fish[]"]',function (echange) {
                contFile=contFile+1;
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
                ezaaf=ezaaf+1;
                $.ajax({
                    url: "{{asset("admin/naqdtypes")}}",
                    success: function (data) {
                        $('.naqdtypeTitle').empty();
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
            $('#Prereserve').change(function (ev){

                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
                if ($('#Prereserve').val()=='1') {
                    $('#totaldaysDovomTitr').removeClass('d-none');
                    $('#totalMonthDovomTitr').addClass('d-none');
                    $('#roozaneTitrDovom').removeClass('d-none');
                    $('#mahaneTitrDovom').addClass('d-none');


                    let betDays = []
                    let day = '';
                    const oneDay = 1000 * 60 * 60 * 24;
                    let raftDovom = new Date("{!! $order->raft !!}").getTime();
                    let raft = new Date($('#raft').val()).getTime();
                    let bargasht = new Date($('#bargasht').val()).getTime();
                    let diff = bargasht - raft;
                    let diffDovom = raft-raftDovom;
                    let countDays = Math.round(diff / oneDay);
                    let countDaysdovom = Math.ceil(diffDovom / oneDay);
                    $('#daysdovom').val(countDaysdovom);
                    $('#pricedovom').val('{!! $order->takht->price !!}');
                    let totalDovom = parseInt($('#daysdovom').val(countDaysdovom)) * parseInt($('#pricedovom').val());
                    let totalPrice=parseInt($('#daysdovom').val()) * parseInt($('#pricedovom').val());

                    $("#totaldaysDovom").html(`${Math.ceil($('#daysdovom').val())} روز`);
                    $("#takPriceDovom").html(`${numberWithCommas({!! $order->takht->price !!})} تومان`);
                    $("#totalPriceDovom").html(`${numberWithCommas(totalPrice)} تومان`);
                    $("#totalPriceInput").val(totalPrice);
                    // $("#finallyPriceInput").val(totalPrice);
                    $('#calculate').removeClass('d-none');
                    $('#freesubmit').removeClass('d-none');
                    $('#bedehkar').val("{!! $order->bedehkar !!}");
                    let bedehkar = $('#bedehkar').val();


                    if (parseInt(bedehkar) == 0) {
                        let thisTotal = "{!! $order->statusmali[0]->bedehkar !!}";
                        let totalGhabl = parseInt($('#daysdovom').val()) * parseInt(`{!! $order->takht->price !!}`);
                        let totalKhales = parseInt(thisTotal) - totalGhabl;
                        $('#totaldovom').val(numberWithCommas(totalGhabl));
                        if (totalKhales < 0) {
                            $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                        } else {
                            $('#totaldovom').val('0');
                            totalNew=$('#totalPrice').text().substr(0,$('#totalPrice').text().length-6);
                            let mabetafavot = parseInt(totalNew.replaceAll(",","")) - totalKhales;

                            if (mabetafavot < 0) {
                                $('#finallyPriceInput').val('0');
                                $('#bestankar').val(parseInt(mabetafavot * -1));
                                $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                            } else {
                                $('#finallyPriceInput').val(numberWithCommas(mabetafavot));
                                $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                            }

                        }

                    } else if (parseInt(bedehkar) > 0) {
                        let thisTotal = "{!! $order->statusmali[0]->bestankar !!}";
                        let totalGhabl = parseInt($('#daysdovom').val().replaceAll(",","")) * parseInt(`{!! $order->takht->price !!}`);
                        let totalKhales = parseInt(thisTotal) - totalGhabl;

                        if (totalKhales < 0) {
                            $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                        } else {
                            $('#totaldovom').val('0');
                            let mabetafavot = parseInt($('#totalPriceInput').val()) - totalKhales;

                            if (mabetafavot < 0) {
                                $('#finallyPriceInput').val('0');
                                $('#bestankar').val(parseInt(mabetafavot * -1));
                                $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                            } else {
                                $('#finallyPriceInput').val(numberWithCommas(Math.abs(mabetafavot)));
                                $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                            }

                        }


                    }

                }
                if ($('#Prereserve').val()=='2') {
                    $('#totaldaysDovomTitr').addClass('d-none');
                    $('#totalMonthDovomTitr').removeClass('d-none');
                    $('#mahaneTitrDovom').removeClass('d-none');
                    $('#roozaneTitrDovom').addClass('d-none');

                    const oneMonth = 1000 * 60 * 60 * 24 * 30;
                    const oneDay = 1000 * 60 * 60 * 24;
                    let raftDovom = new Date("{!! $order->raft !!}").getTime();
                    let raft = new Date($('#raft').val()).getTime();
                    let bargasht = new Date($('#bargasht').val()).getTime();
                    let diff = bargasht - raft;
                    let diffDovom = raft-raftDovom;
                    let countDays = Math.ceil(diff / oneMonth);
                    let countDaysdovom = Math.ceil(diffDovom / oneMonth);
                    // $('#daysdovom').val(countDaysdovom);


                    $('#pricemonthdovom').val('{!! $order->takht->pricemonth !!}');

                    $('#monthDovom').val(countDaysdovom);

                    let totalPrice = parseInt($('#monthDovom').val()) * parseInt($('#pricemonthdovom').val());
                    // $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                    // $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                    $("#totaldaysDovom").html(`${$('#monthDovom').val()} ماه`);
                    $("#takPriceDovom").html(`${numberWithCommas($('#pricemonthdovom').val().substr(0,$('#pricemonthdovom').val().length-3))} تومان`);
                    $("#totalPriceInput").val(totalPrice);
                    $("#totalPriceDovom").html(`${numberWithCommas(totalPrice)} تومان`);
                    $('#bedehkar').val("{!! $order->bedehkar !!}");
                    let bedehkar = $('#bedehkar').val();


                    if (parseInt(bedehkar) == 0) {
                        let thisTotal = "{!! $order->statusmali[0]->bedehkar !!}";
                        let totalGhabl = parseInt(countDaysdovom) * parseInt(`{!! $order->takht->pricemonth !!}`);
                        let totalKhales = parseInt(thisTotal) - totalGhabl;
                        $('#totaldovom').val(numberWithCommas(totalGhabl));
                        if (totalKhales < 0) {
                            $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                            $('#finallyPriceInput').val($('#totalPrice').text().substr(0,$('#totalPrice').text().length-6));
                        } else {
                            // if ( parseInt($('#totaldovom').val().replaceAll(",",""))>){
                            //
                            // }
                            $('#totaldovom').val('0');
                            let mabetafavot = parseInt($('#totalPriceInput').val().replaceAll(",","")) - totalKhales;


                            if (mabetafavot < 0) {
                                $('#finallyPriceInput').val('0');
                                $('#bestankar').val(parseInt(mabetafavot * -1));
                                $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                            } else {
                                // $('#finallyPriceInput').val(numberWithCommas(mabetafavot));
                                $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                            }

                        }

                    } else if (parseInt(bedehkar) > 0) {
                        let thisTotal = "{!! $order->statusmali[0]->bestankar !!}";
                        let totalGhabl = parseInt(countDays * parseInt(`{!! $order->takht->pricemonth !!}`));
                        let totalKhales = parseInt(thisTotal) - totalGhabl;

                        if (totalKhales < 0) {
                            $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                        } else {
                            $('#totaldovom').val('0');
                            let mabetafavot = parseInt($('#totalPriceInput').val()) - totalKhales;


                            if (mabetafavot < 0) {
                                $('#finallyPriceInput').val('0');
                                $('#bestankar').val(parseInt(mabetafavot * -1));
                                $(`#hesabketab`).html(`مبلغ ${numberWithCommas($('#bestankar').val())} بستانکاری موجود است`);
                            } else {
                                $('#finallyPriceInput').val(numberWithCommas(Math.abs(mabetafavot)));
                                $(`#hesabketab`).html(` از مبلغ کل ${numberWithCommas(totalKhales)} تومان که از قبل مانده بود کسر شده است.`);
                            }

                        }


                    }



                }

            });

        })
    </script>
@endsection
@section('css')

    #timeTable {
    height: 448.719px;
    margin-bottom: 150px!important;
    }

    .select2 {
    width: 100% !important;
    }

    section a div:hover {
    background-color: #0b5ed7 !important;
    color: white;

    }

    @media (min-width: 1500px){
    .container {
    max-width: 1450px!important;
    }
    }

    @media (min-width: 992px){
    .mr-140{
    margin-right: 140px!important;
    }
    }
    @media (max-width: 576px){
    .mr-140{
    margin-right:60px!important;
    }
    }

    #timeTable{
    margin-top: 100px;

    }
    .breadcrumb{
    background-color: white!important;
    }
    .tdDay{
    background: white;
    }
    .select2-container{
    text-align: right;
    }

@endsection

@section('content')
    @if($order->move!='1')

        <div class="container card px-5" style="background-color: gainsboro">
            <div class="table-responsive">
                <table class="table table-info mt-5">
                    <thead>
                    <th>نام رزرو کننده</th>
                    <th>تخت</th>
                    <th>تاریخ شروع</th>
                    <th>تاریخ پایان</th>
                    <th>نوع رزرو</th>
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
                    <td>{{$order->reservetype->title}}</td>
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
        </div>
        <!-- START: Form-->
        <div class="container card px-5" style="background-color: gainsboro">
            <form method="post" action="{{route('movetakht',$order->id)}}" id="submit" enctype="multipart/form-data">
                @csrf
                <input id="tarikh" name="tarikh" class="d-none" value="">
                <input id="raft" name="raft" class="d-none" value="">
                <input id="bargasht" name="bargasht" class="d-none" value="">
                <input id="days" name="days" class="d-none" value="">
                <input id="daysdovom" name="daysdovom" class="d-none" value="">
                <input id="cancelPrice" name="cancelPrice" class="d-none" value="">
                <input id="price" name="price" class="d-none" value="">
                <input id="pricedovom" name="pricedovom" class="d-none" value="">
                <input id="pricemonthdovom" name="pricemonthdovom" class="d-none" value="">
                <input id="pricemonth" name="pricemonth" class="d-none" value="">
                <input id="perMonth" name="perMonth" class="d-none" value="">
                <input id="bestankar" name="bestankar" class="d-none" value="">
                <input id="bedehkar" name="bedehkar" class="d-none" value="">
                <input id="takhtId" name="takht_id" class="d-none" value="">
                <input id="monthDovom" name="monthDovom" class="d-none" value="">

                {{--        <input name="month[]" class="d-none" value="{{$product->id}}">--}}

                <div class="row">
                    <div class="col-lg-8 col-12 row">


                        <div class="col-12 row " >

                            <div class="col-12 col-lg-6 mt-5 row" style="height: 400px">
                                <div class="col-12 row" style="height: 300px">
                                    <div class="col-12 text-white pt-3"
                                         style="font-size: 16px;height: 60px;background-color: #17a2b8;border-radius: 6px">شروع تاریخ قدیم: <span
                                            id="ghadimraft">{{$order->raftjalaliFull}}</span></div>
                                    <div class="col-12 text-white pt-3"
                                         style="font-size: 16px;height: 60px;background-color: #6c757d;border-radius: 6px">پایان تاریخ قدیم: <span
                                            id="ghadimto">{{$order->bargashtjalaliFull}}</span></div>
                                    <div class="col-12 pt-3"
                                         style="font-size: 16px;background: #ffc107!important;height: 60px;border-radius: 6px">
                                        شروع تاریخ جدید: <span id="from"></span></div>
                                    <div class="col-12 pt-3"
                                         style="font-size: 16px;background: #28a745!important;height: 60px;border-radius: 6px">
                                        پایان تاریخ جدید: <span id="to"></span></div>
                                </div>
                                <div class="col-12 mt-3 row" style="height: 100px">
                                    <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-radius: 5px;
    background-color: beige;">
                                        <span class="form-label mb-2 position-relative" style="top: 24%">نوع رزرو</span>
                                    </div>
                                    <div class="col-9 p-0 ">
                                        <select place name="reservetype" class="select2 form-control" id="reserve">
                                            <option value="">انتخاب کنید.</option>
                                            @foreach($reservetypes as $reservetype)
                                                @if($reservetype->id!=3)
                                                    <option value="{{$reservetype->id}}">{{$reservetype->title}}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                    </div>


                                </div>
                                <div class="col-12 row mb-5 d-none" id="divMonth">

                                    <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-radius: 5px;
    background-color: beige;">
                                        <span class="form-label mb-2 position-relative" style="top: 24%">تعداد ماه</span>
                                    </div>
                                    <div class="col-9 p-0 ">
                                        <select name="mounth" class="select2 form-control " id="mounth">
                                            <option value="0">تعداد ماه را انتخاب کنید.</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="col-12 col-lg-6 mb-5 mt-md-5 row p-0 d-none bg-white" id="timeTable"
                                 style="border: 1px solid #dee2e6;margin-right: 45px;border-radius: 10px">

                                <div class="col-12 p-0 h-100">
                                    <table id="mainTable" class="w-100 mb-0 h-100">
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

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5 mt-5 row pl-5">
                        <div class="col-12 text-center">

                            <div class="col-12 text-center mt-5">
                                <h3>محاسبه کرایه تخت</h3>
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
                                            <select place name="prereservetype" class="select2 form-control" id="Prereserve">
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
                                         id="roozaneTitrDovom">مبلغ روزانه قدیم:
                                    </div>
                                    <div class="col-6 mt-3 pt-3 d-none"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="mahaneTitrDovom">مبلغ ماهانه قدیم:
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;"><h5
                                            id="takPriceDovom"></h5></div>
                                    <div class="col-6 mt-3 pt-3 d-none"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="roozaneTitr">مبلغ روزانه جدید:
                                    </div>
                                    <div class="col-6 mt-3 pt-3 d-none"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="mahaneTitr">مبلغ ماهانه جدید:
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;"><h5
                                            id="takPrice"></h5></div>
                                    <div class="col-8 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="totaldaysDovomTitr">تعداد روزهای قبلی:
                                    </div>
                                    <div class="col-8 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="totalMonthDovomTitr">تعداد ماه های قبلی:
                                    </div>
                                    <div class="col-4 mt-3 pt-3"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;" id="totaldaysDovomParent">
                                        <h5
                                            id="totaldaysDovom"></h5></div>
                                    <div class="col-8 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="totaldaysTitr">تعداد روزهای جدید:
                                    </div>

                                    <div class="col-4 mt-3 pt-3"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;" id="totaldaysDiv">
                                        <h5 id="totaldays"></h5></div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="monthsTitr">تعداد ماه:
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="totalmonthsTitr">
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="totalpriceTitrDovom">مبلغ کل قدیم:
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;"><h5
                                            id="totalPriceDovom"></h5></div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="totalpriceTitr">مبلغ کل جدید:
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;"><h5
                                            id="totalPrice"></h5></div>
                                    <div class="col-2 mt-3 pt-3 px-0"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="takhfifTitr"> تخفیف:
                                    </div>
                                    <div class="col-7 mt-3 pt-3"   style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"><input class="form-control seprator justnumber" name="takhfif"
                                                                                                                                                   id="takhfif" autocomplete="off"></div>
                                    <div class="col-2 mt-3 pt-3"   style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"><span class="btn btn-secondary" id="emaltakhfif">اعمال</span>
                                    </div>

                                    <div class="col-7 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="totaldovomTitr">حساب قدیم:
                                    </div>
                                    <div class="col-5 mt-3 pt-3"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;"><input
                                            name="totaldovom" class="form-control seprator" id="totaldovom" autocomplete="off"></div>
                                    <div class="col-7 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="finallypriceTitr">حساب جدید:
                                    </div>
                                    <div class="col-5 mt-3 pt-3"
                                         style="border-top: 1px solid #bdc4c4;text-align: right;"><input
                                            name="finallyPrice" class="form-control seprator" id="finallyPriceInput" autocomplete="off">

                                    </div>
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
                                    {{--                      اقساطی          --}}
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
                                    {{--                      نقدی          --}}
                                    <div class="col-12 mt-3 pt-3 row"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="naqdtype">
                                        <div class="col-12">جزییات پرداخت:</div>

                                        <div class="col-1 text-center mt-3 p-0">
                                        <span class="btn  mt-1 p-0 plusNaqd" style="cursor: pointer"><i
                                                class="fa fa-plus fa-2x"></i> </span>
                                        </div>
                                        <div class="naghdi row col-11 py-4 my-4" style="border-bottom: 1px solid #aaaaaa">
                                            <div class="col-1 text-center mt-3 adad p-0">
                                                <i class="fa fa-credit-card"></i>
                                            </div>
                                            <div class="col-10 row">
                                                <div class="col-lg-6 mt-2 px-1">
                                                    <select class="form-control naqdtypeTitle" name="naqdtypeTitle[]"
                                                            placeholder="نوع پرداخت">
                                                        @foreach($naqdtypes as $key=>$naqdtype)

                                                            <option value="{{$naqdtype->id}}">{{$naqdtype->title}}</option>

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

                                    </div>
                                </div>


                                <input name="totalPrice" class="d-none" id="totalPriceInput">
                                {{--                            <input name="mounth" class="d-none" id="mounth">--}}
                                <input name="permounth" class="d-none" id="permounth">

                            </div>
                            <div class="col-12 mb-3">
                                <button type="submit" class="w-50 btn btn-success pt-2 pb-2" id="freesubmit">ثبت
                                </button>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- ReservesModal -->
                <div class="modal fade" id="reservesModal" role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <h6 class="alert-info p-2" id="fullReserveHeader"></h6>
                                <table class="table mt-5 " id="fullTable">
                                    <thead class="text-white">
                                    <th>شماره لیست</th>
                                    <th>نام رزرو کننده</th>
                                    <th>تاریخ شروع</th>
                                    <th>تاریخ پایان</th>
                                    <th>وضعیت پرداخت</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
                {{--endModal--}}
            </form>
        </div>
    @else
        <div class="container card mt-5">
            <h4 class="alert-danger" style="margin-top: 200px">این رزرو تغییر وضعیت زمانی داده است.</h4>
        </div>
    @endif
@endsection

