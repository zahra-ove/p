@extends('admin.master.ajax')

@section('js')
    <!--jquery min js-->

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
            $.ajax({
                    url: "{{asset('admin/getorderbyuser')}}/" + userId,
                    success: function (data) {
                        // $('tbody').empty()
                        if (data != 'notfound') {
                            data.forEach(function (item, index) {

                                if (item.status_order_id == 1 || item.status_order_id == 2) {
                                    $.ajax(
                                        {
                                            url: "{{asset('admin/reservetypes')}}",
                                            success: function (data) {
                                                if (data != 'notfound') {
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
                                    $('#shamsi').prepend(`<span id="mtimetablesh" month="1">??????????????</span>`)
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
                                    $('#shamsi').prepend(`<span id="mtimetablesh" month="2">????????????????</span>`)
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
                                    $('#shamsi').prepend(`<span id="mtimetablesh" month="3">??????????</span>`);
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
                                    $('#shamsi').prepend(`<span id="mtimetablesh" month="4">??????</span>`);
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
                                    $('#shamsi').prepend(`<span id="mtimetablesh" month="5">??????????</span>`);
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
                                    $('#shamsi').prepend(`<span id="mtimetablesh" month="6">????????????</span>`);
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
                                    $('#shamsi').prepend(`<span id="mtimetablesh" month="7">??????</span>`);
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
                                    $('#shamsi').prepend(`<span id="mtimetablesh" month="8">????????</span>`);
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
                                    $('#shamsi').prepend(`<span id="mtimetablesh" month="9">??????</span>`);
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
                                    $('#shamsi').prepend(`<span id="mtimetablesh" month="10">????</span>`);
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
                                    $('#shamsi').prepend(`<span id="mtimetablesh" month="11">????????</span>`)
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
                                    $('#shamsi').prepend(`<span id="mtimetablesh" month="12">??????????</span>`);
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
                                        $('#select2-reserve-container').attr('title', '?????? ???????? ???? ???????????? ????????.');
                                        $('#select2-reserve-container').html('?????? ???????? ???? ???????????? ????????.');
                                    } else if ($(this).hasClass('gozashte')) {
                                        toastr.error('?????? ?????? ?????????? ???? ?????? ???????? ???????????? ????????.');

                                    } else if ($(this).hasClass('reserved')) {
                                        toastr.error('?????? ?????? ?????????? ???????? ?????? ??????.')
                                    } else if ($(this).hasClass('gozashteh')) {
                                        toastr.error('?????? ?????? ?????????? ???? ?????????? ???????????? ????????.')
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
                                        $('#select2-reserve-container').attr('title', '?????? ???????? ???? ???????????? ????????.');
                                        $('#select2-reserve-container').html('?????? ???????? ???? ???????????? ????????.');
                                        $('#calculate').addClass('d-none');
                                    }
                                    if ($('.tdDay.bg-success').hasClass('gozashteh')) {

                                        $('.tdDay').removeClass('bg-success');
                                        $('#bargasht').val("");
                                        $('#to').empty();
                                        $('#reserve').prop("disabled", true);
                                        $('#reserve').children().first().attr('selected', 'selected');
                                        $('#select2-reserve-container').attr('title', '?????? ???????? ???? ???????????? ????????.');
                                        $('#select2-reserve-container').html('?????? ???????? ???? ???????????? ????????.');

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
                                        $(this).addClass('gozashte').css('color', 'red');
                                    }
                                    let weekDay = new Date(miladi).getDay();
                                    if (weekDay == 0) {
                                        $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                    }
                                    if (weekDay == 1) {
                                        $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                    }
                                    if (weekDay == 2) {
                                        $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                    }
                                    if (weekDay == 3) {
                                        $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                    }
                                    if (weekDay == 4) {
                                        $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                    }
                                    if (weekDay == 5) {
                                        $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                    }
                                    if (weekDay == 6) {
                                        $(this).append(`<br><i style="font-size: 9px">??</i>`)
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="1">??????????????</span>`)
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="2">????????????????</span>`)
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="3">??????????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="4">??????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="5">??????????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="6">????????????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="7">??????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="8">????????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="9">??????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="10">????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="11">????????</span>`)
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="12">??????????</span>`);
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
                                            $('#select2-reserve-container').attr('title', '?????? ???????? ???? ???????????? ????????.');
                                            $('#select2-reserve-container').html('?????? ???????? ???? ???????????? ????????.');
                                        } else if ($(this).hasClass('gozashte')) {
                                            toastr.error('?????? ?????? ?????????? ???? ?????? ???????? ???????????? ????????.')
                                        } else if ($(this).hasClass('reserved')) {
                                            toastr.error('?????? ?????? ?????????? ???????? ?????? ??????.')
                                        } else if ($(this).hasClass('gozashteh')) {
                                            toastr.error('?????? ?????? ?????????? ???? ?????????? ???????????? ????????.')
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
                                            $('#select2-reserve-container').attr('title', '?????? ???????? ???? ???????????? ????????.');
                                            $('#select2-reserve-container').html('?????? ???????? ???? ???????????? ????????.');
                                            $('#calculate').addClass('d-none');
                                        }
                                        if ($('.tdDay.bg-success').hasClass('gozashteh')) {

                                            $('.tdDay').removeClass('bg-success');
                                            $('#bargasht').val("");
                                            $('#to').empty();
                                            $('#reserve').prop("disabled", true);
                                            $('#reserve').children().first().attr('selected', 'selected');
                                            $('#select2-reserve-container').attr('title', '?????? ???????? ???? ???????????? ????????.');
                                            $('#select2-reserve-container').html('?????? ???????? ???? ???????????? ????????.');

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
                                            $(this).addClass('gozashte').css('color', 'red');
                                        }
                                        if (weekDay == 0) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                        }
                                        if (weekDay == 1) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                        }
                                        if (weekDay == 2) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                        }
                                        if (weekDay == 3) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                        }
                                        if (weekDay == 4) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                        }
                                        if (weekDay == 5) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                        }
                                        if (weekDay == 6) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="1">??????????????</span>`)
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="2">????????????????</span>`)
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="3">??????????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="4">??????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="5">??????????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="6">????????????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="7">??????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="8">????????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="9">??????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="10">????</span>`);
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="11">????????</span>`)
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
                                        $('#shamsi').prepend(`<span id="mtimetablesh" month="12">??????????</span>`);
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
                                            $('#select2-reserve-container').attr('title', '?????? ???????? ???? ???????????? ????????.');
                                            $('#select2-reserve-container').html('?????? ???????? ???? ???????????? ????????.');
                                        } else if ($(this).hasClass('gozashte')) {
                                            toastr.error('?????? ?????? ?????????? ???? ?????? ???????? ???????????? ????????.')
                                        } else if ($(this).hasClass('reserved')) {
                                            toastr.error('?????? ?????? ?????????? ???????? ?????? ??????.')
                                        } else if ($(this).hasClass('gozashteh')) {
                                            toastr.error('?????? ?????? ?????????? ???? ?????????? ???????????? ????????.')
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
                                            $('#select2-reserve-container').attr('title', '?????? ???????? ???? ???????????? ????????.');
                                            $('#select2-reserve-container').html('?????? ???????? ???? ???????????? ????????.');
                                            $('#calculate').addClass('d-none');
                                        }
                                        if ($('.tdDay.bg-success').hasClass('gozashteh')) {

                                            $('.tdDay').removeClass('bg-success');
                                            $('#bargasht').val("");
                                            $('#to').empty();
                                            $('#reserve').prop("disabled", true);
                                            $('#reserve').children().first().attr('selected', 'selected');
                                            $('#select2-reserve-container').attr('title', '?????? ???????? ???? ???????????? ????????.');
                                            $('#select2-reserve-container').html('?????? ???????? ???? ???????????? ????????.');

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
                                            $(this).addClass('gozashte').css('color', 'red');
                                        }

                                        let totalToday = JDate.toGregorian(jdateNow.date[0], jdateNow.date[1], jdateNow.date[2]).getTime();
                                        let weekDay = new Date(miladi).getDay();

                                        if (weekDay == 0) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                        }
                                        if (weekDay == 1) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                        }
                                        if (weekDay == 2) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                        }
                                        if (weekDay == 3) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                        }
                                        if (weekDay == 4) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                        }
                                        if (weekDay == 5) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
                                        }
                                        if (weekDay == 6) {
                                            $(this).append(`<br><i style="font-size: 9px">??</i>`)
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
                                        $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} ??????????`);
                                        $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} ??????????`);
                                        $("#totaldays").html(`${countDays} ??????`);
                                        $("#takPrice").html(`${numberWithCommas($('#price').val()).substr(0, numberWithCommas($('#price').val()).length - 3)} ??????????`);
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
                                            $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} ??????????`);
                                            $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} ??????????`);
                                            $("#totaldays").html(`${countDays} ??????`);
                                            $("#takPrice").html(`${numberWithCommas($('#price').val())} ??????????`);
                                            $("#totalPriceInput").val(totalPrice);
                                            $("#finallyPriceInput").val(numberWithCommas(totalPrice));
                                        } else {
                                            toastr.error('???? ???????? ?????????? ?????????? ?????? ???? ???? ???? ???? ???? ?????? ?????? ???? ?????? ???????????? ?????????????? ????????????.');
                                            $('#reserve').children().first().attr('selected', 'selected');
                                            $('#select2-reserve-container').attr('title', '?????? ???????? ???? ???????????? ????????.');
                                            $('#select2-reserve-container').html('?????? ???????? ???? ???????????? ????????.');
                                        }
                                    }
                                    $('#bedehkar').val("{!! $order->bedehkar !!}");
                                    let bedehkar = $('#bedehkar').val();

                                    if (parseInt(bedehkar) == 0) {
                                        let thisTotal = "{!! $order->statusmali[0]->bedehkar !!}";
                                        let totalKhales = parseInt(thisTotal) - parseInt($('#totalPriceInput').val());
                                        if (totalKhales < 0) {
                                            $('#finallyPriceInput').val(Math.abs(totalKhales));
                                            $('#bestankar').val(0);
                                        } else {
                                            $('#finallyPriceInput').val('0');
                                            $('#bestankar').val(parseInt(totalKhales));

                                        }

                                    } else if (parseInt(bedehkar) > 0) {
                                        let thisTotal = "{!! $order->statusmali[0]->bestankar !!}";
                                        let totalKhales = parseInt(thisTotal) - parseInt($('#totalPriceInput').val());

                                        if (totalKhales < 0) {
                                            $('#totaldovom').val(numberWithCommas(totalKhales * -1));
                                        } else {

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
                                    $('#finallyPrice').html(`${numberWithCommas(final)} ??????????`)
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
                                        $('#countMonthTitr').html(`<div class="col-10"> <input min="1" type="number" class="form-control" id="countMonth" value="1"></div> <div class="col-2"> <span class="btn btn-secondary" id="tayidCount" style="cursor: pointer">??????????</span></div>`)
                                    }
                                    $('#tayidCount').click(function (ese) {


                                        $('#tarikhMonth').empty();
                                        let countMonth = $('#countMonth').val();
                                        let perMounth = $('#finallyPriceInput').val() / countMonth;
                                        $('#perMonth').val(perMounth);
                                        $('#tarikhMonthTitr').append(`<h6 id="perMonth" class="mt-3">${numberWithCommas(perMounth)} ?????????? ???????? ?????????????? ???? ????????</h6>`)
                                        for (let i = 0; i < countMonth; i++) {
                                            $('#tarikhMonth').append(`    <div class="col-6 mt-3 pt-3" style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;" id="takhfifTitr">???????? ${i + 1}:</div>
                                <div class="col-6 mt-3 pt-3" style="border-top: 1px solid #bdc4c4;text-align: right;">   <input name="qesttarikh[]" autocomplete="off" class="form-control jalal"></div>`);
                                        }
                                        $(".jalal").persianDatepicker({

                                        });
                                    });
                                });
                            });

                            $('input[name="fish[]"]').change(function (echange) {
                                if (echange.target.files.length != 0) {
                                    $(this).siblings('span').remove();
                                    $(this).after(`<span><i class="fa fa-check text-success"></i></span>`);
                                }
                            });

                            $("#submit").submit(function (e) {
                                if ($('#priceTrans').val().length==0){
                                    $('#priceTrans').val('0')
                                }

                                //  ?????? ???????????? ?????????? ???????? ???????? ?? ???????? ?????????? ?????????? ?????? ????????
                                // if ($('#upload').val().length==0 && $('#pay_type').val() == 'naqd'){
                                //     console.log('???????????? ???????? ???????? ??????')
                                //     e.preventDefault();
                                //     toastr.warning('?????? ???????????? ???????????????? ???????? ??????.');
                                // }

                                if( $('#priceTrans').val() > 0 && $('#upload2').val().length==0 ) {
                                    console.log('???????? ?????????????? ?? ???????????? ???????? ?????? ?????????? ??????.')
                                    e.preventDefault();
                                    toastr.warning('?????? ???????????? ???????????????? ???????? ??????.');
                                }

                                if ( $('.naqdtypeMablagh').val()!=null){
                                    $('.naqdtypeMablagh').val($('.naqdtypeMablagh').val().replaceAll(',', ""));
                                }

                                $('.naqdtypeMablagh').each(function (index) {
                                    $('.naqdtypeMablagh').val($('.naqdtypeMablagh').val().replaceAll(',', ""));
                                    if ($(this).val() != '') {
                                        totalType = totalType + parseFloat($(this).val());
                                    }

                                    if ($(this).val() != "" && $(this).parents('.col-lg-6').siblings('.col-lg-6').children('.naqdtypeTitle').val() == "") {
                                        e.preventDefault();
                                        toastr.error('?????? ???????????? ?????? ???? ?????????? ???????? ????????.');
                                    }
                                });
                                $('#priceTrans').val($('#priceTrans').val().replaceAll(',', ''));
                                $('#jarimeh').val($('#jarimeh').val().replaceAll(',', ''));
                                if (  $('#takhfif').val()!=null) {
                                    $('#takhfif').val($('#takhfif').val().replaceAll(',', ""));
                                }
                                if (  $('#finallyPriceInput').val()!=null) {
                                    $('#finallyPriceInput').val($('#finallyPriceInput').val().replaceAll(',', ""));
                                }
                                if ($('#raft').val() == "") {
                                    e.preventDefault();
                                    toastr.error('?????????? ?????? ???????? ????????.');
                                }

                                if ($('#bargasht').val() == "") {
                                    e.preventDefault();
                                    toastr.error('?????????? ?????????? ???????? ????????.');
                                }

                                if ($('#reserve').val() == '') {
                                    e.preventDefault();
                                    toastr.error('???????????? ?????? ???????? ????????????????.');
                                }
                                if ($('#takht').val() == '') {
                                    e.preventDefault();
                                    toastr.error('???????????? ?????? ????????????????.');
                                }
                                if ($('#pansion').val() == '') {
                                    e.preventDefault();
                                    toastr.error('???????????? ?????????????? ????????????????.');
                                }
                                if ($('#room').val() == '') {
                                    e.preventDefault();
                                    toastr.error('???????????? ???????? ????????????????.');
                                }

                                if ($('#user').val() == '') {
                                    e.preventDefault();
                                    toastr.error('???????????? ?????????? ????????????????.');
                                }
                                if ($('.naqdtypeMablagh').length!=0) {
                                    let totalType = 0;
                                    $('.naqdtypeMablagh').each(function (index) {
                                        $(this).val($(this).val().replaceAll(',', ""));
                                        if ($(this).val() != '') {
                                            totalType = totalType + parseFloat($(this).val());
                                        }

                                        if ($(this).val() != "" && $(this).parents('.col-lg-6').siblings('.col-lg-6').children('.naqdtypeTitle').val() == "") {
                                            e.preventDefault();
                                            toastr.error('?????? ???????????? ?????? ???? ?????????? ???????? ????????.');
                                        }
                                    });
                                    if (totalType != $('#finallyPriceInput').val()) {
                                        e.preventDefault();
                                        toastr.error('?????????? ?????????????? ???? ???? ???????? ?????????? ?????????? ?????? ????????.');
                                    }
                                }
                            });
                        } else {
                            $('tbody').append(`<p style="padding: 20px">?????????? ???????? ?????????? ???????? ??????????.</p>`)
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
                if ( $('.naqdtypeMablagh').val()!=null) {
                    $('.naqdtypeMablagh').val($('.naqdtypeMablagh').val().replaceAll(',', ""));
                }
                $('#priceTrans').val($('#priceTrans').val().replaceAll(',', ''));
                $('#jarimeh').val($('#jarimeh').val().replaceAll(',', ''));
                let totalType = 0;
                $('.naqdtypeMablagh').each(function (index) {
                    $(this).val($(this).val().replaceAll(',', ""));
                    if ($(this).val() != '') {
                        totalType = totalType + parseFloat($(this).val());
                    }

                    if ($(this).val() != "" && $(this).parents('.col-lg-6').siblings('.col-lg-6').children('.naqdtypeTitle').val() == "") {
                        e.preventDefault();
                        toastr.error('?????? ???????????? ?????? ???? ?????????? ???????? ????????.');
                    }
                });
                if ($('#finallyPriceInput').val()!=null) {
                    if (totalType != $('#finallyPriceInput').val().replaceAll(",", "")) {
                        e.preventDefault();
                        toastr.error('?????????? ?????????????? ???? ???? ???????? ?????????? ?????????? ?????? ????????.');
                    }
                }
                if ($('#paytype').val() == 'q') {

                    if ($('.jalal').length == 0) {
                        e.preventDefault();
                        toastr.error('???????? ?????????? ???????? ?? ?????????? ?????? ???? ???????? ??????.');
                    } else {
                        $('.jalal').each(function (index) {

                            if ($(this).val() == "") {

                                e.preventDefault();
                                toastr.error('???????? ?????????? ???????? ?? ?????????? ?????? ???? ???????? ??????.');

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

            $('.fishUp').click(function () {

                $('.modal-content').css('height', '700px');
            });
            let ezaaf = 1;
            $('input[name="fish[]"]').change(function (echange) {
                if (echange.target.files.length != 0) {
                    $(this).siblings('span').remove();
                    $(this).after(`<span><i class="fa fa-check text-success"></i> </span>`)
                }
            });

            $('#upload').change(function (echange) {
                if (echange.target.files.length != 0) {
                    $(this).siblings('span').remove();
                    $(this).after(`<span><i class="fa fa-check text-success"></i> </span>`)
                }
            });

            $('#upload2').change(function (echange) {
                if (echange.target.files.length != 0) {
                    $(this).siblings('span').remove();
                    $(this).after(`<span><i class="fa fa-check text-success"></i> </span>`)
                }
            });

        });
    </script>
@endsection
@section('css')

    #timeTable{
        height: 448.719px;
    }

    .select2 {
        width: 100% !important;
    }
    table {
    table-layout: fixed;
    width: 100%;
    }

    th,td {
    border-style: solid;
    border-width: 5px;
    border-color: #BCBCBC;
    word-wrap: break-word;
    }

@endsection
@if(strtotime($order->raft)<time())
@section('content')
    <h2 class="alert-danger">?????????? ?????????? ???????? ???????? ?????? ????????.</h2>
@endsection
@else
@section('content')
    @if($order->status_order_id!='4')
        <div class="py-5 container-fluid mb-lg-3">
            <table class="table table-info" style="text-align:center;">
                <thead>
                    <th>?????? ???????? ??????????</th>
                    <th>??????</th>
                    <th>?????????? ????????</th>
                    <th>?????????? ??????????</th>
                    <th>????????????</th>
                    <th>???????? ????</th>
                    <th>??????????</th>
                    <th>?????????? ????????????</th>
                    <th>???????????? ????????????</th>
                </thead>
                <tbody>
                <td>{{$order->fullname}}</td>
                <td>{{$order->pansionname}} ???????? {{$order->roomnumber}} ?????? {{$order->takhtnumber}}</td>
                <td>{{$order->raftjalali}}</td>
                <td>{{$order->bargashtjalali}}</td>
                <td>{{number_format($order->bedehkar)}} ??????????</td>
                <td>{{number_format($order->totalprice)}} ??????????</td>
                <td>{{number_format($order->takhfif)}} ??????????</td>
                <td>{{$order->statusmalis}}</td>
                <td>
                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#detail-modal" style="font-size: 11px;padding: 8px 13px;">???????????? ????????????</a>
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
                                                <th>??????????</th>
                                                <th>???????? ??????</th>
                                                <th>???????? ??????????????</th>
                                                <th>????????</th>
                                                <th>??????????</th>
                                                <th>??????????</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($order->aqsat as $key=>$qest)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$qest->paytime}}</td>
                                                    <td>{{$qest->pardakhti!=null?$qest->pardakhti:'-'}}</td>
                                                    <td>{{number_format($qest->amount)}} ??????????</td>
                                                    <td>{{$qest->vaziat}}</td>
                                                    <td>
                                                        <button class="btn text-white btn-warning btn-fishup" style="padding: 10px 12px" title="??????" data-id="{{$qest->id}}" data-toggle="modal" data-target="#fish-modal-{{$key}}"><i class="fas fa-money-bill"></i> </button>
                                                        <!-- modal group -->
                                                        <div class="modal fade" id="fish-modal-{{$key}}" role="dialog">
                                                            <div class="modal-dialog modal-lg">

                                                                <!-- Modal content-->
                                                                <div class="modal-content fishi">
                                                                    <div class="modal-header d-block" style="text-align: right">
                                                                        <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                                                    </div>
                                                                    <div class="modal-body text-dark" >
                                                                        <!-- START: Breadcrumbs-->
                                                                        <div class="py-5 mt-5 mb-lg-3 row w-100">
                                                                            <div class="col-12  align-self-center">
                                                                                <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                                                                                    <div class="w-sm-100 mr-auto"><h4 class="mb-0">?????????? ?????? ????????????</h4></div>
                                                                                    <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                                                                    </ol>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="container-fluid">
                                                                            @if($qest->fish!=null)
                                                                            <img src="{{asset($qest->fish)}}">
                                                                            @else
                                                                            <h6>?????? ???????????? ??????????.</h6>
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
                                    @elseif($order->naqditype!=null)
                                        <table class="table">
                                            <thead class="bg-dark">
                                            <tr class="text-white">
                                                <th>??????????</th>
                                                <th> ?????? ????????????</th>
                                                <th>????????</th>
                                                <th>??????????</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($order->naqditype as $key=>$naqditype)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$naqditype->title}}</td>
                                                    <td>{{number_format($naqditype->mablagh)}} ??????????</td>
                                                    <td>
                                                        <button class="btn text-white btn-warning fishUp" style="padding: 10px 12px" title="??????" data-id="{{$naqditype->id}}" data-toggle="modal" data-target="#fish-modal-{{$key}}"><i class="fas fa-money-bill"></i> </button>
                                                        <!-- modal group -->
                                                        <div class="modal fade" id="fish-modal-{{$key}}" role="dialog">
                                                            <div class="modal-dialog">

                                                                <!-- Modal content-->
                                                                <div class="modal-content fishi">
                                                                    <div class="modal-header d-block" style="text-align: right">
                                                                        <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                                                    </div>
                                                                    <div class="modal-body text-dark" style="background: #b3be90">
                                                                        <div class="container-fluid">
                                                                            @if($naqditype->pivot->path!=null)
                                                                            <img style="width: 100%" src="{{asset($naqditype->pivot->path)}}">
                                                                            @else
                                                                                <h6>?????? ???????????? ??????????.</h6>
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
                </tbody>
            </table>
        </div>
        <!-- START: Form-->
        <form method="post" action="{{route('order.destroy',$order->id)}}" id="submit" enctype="multipart/form-data">
            @csrf
            @method('delete')
            <div class="container-fluid">
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
                                <h3>?????????? ?????????????? ?????? ??????????</h3>
                                <div class="row text-center" id="calculate">
                                    <div class="col-12">
                                    @if($order->aqsat!=null)
                                        <table class="table table-hover table-striped w-50 m-auto table-bordered">
                                            <thead class="">
                                            <tr class="text-white">
                                                <th>??????????</th>
                                                <th>???????? ??????</th>
                                                <th>???????? ??????????????</th>
                                                <th>????????</th>
                                                <th>??????????</th>
                                                <th>??????????</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($order->aqsat as $key=>$qest)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$qest->paytime}}</td>
                                                    <td>{{$qest->pardakhti!=null?$qest->pardakhti:'-'}}</td>
                                                    <td>{{number_format($qest->amount)}} ??????????</td>
                                                    <td>{{$qest->vaziat}}</td>
                                                    <td>{{$qest->vaziat}}</td>
                                                    <td>
                                                        <button class="btn text-white btn-warning fishUp" style="padding: 10px 12px" title="??????" data-id="{{$qest->id}}" data-toggle="modal" data-target="#qest-modal-{{$key}}"><i class="fas fa-money-bill"></i> </button>
                                                        <!-- modal group -->
                                                        <div class="modal fade" id="qest-modal-{{$key}}" role="dialog">
                                                            <div class="modal-dialog">

                                                                <!-- Modal content-->
                                                                <div class="modal-content fishi">
                                                                    <div class="modal-header d-block" style="text-align: right">
                                                                        <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                                                    </div>
                                                                    <div class="modal-body text-dark" style="background: #b3be90">
                                                                        <div class="container-fluid">
                                                                            @if($qest->fish!=null)
                                                                                <img style="width: 100%" src="{{asset($qest->fish)}}">
                                                                            @else
                                                                                <h6>?????? ???????????? ??????????.</h6>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                </td>
                                                <td></td>
                                                <td> ??????????: {{number_format($order->statusmali[0]->bestankar)}} ??????????</td>

                                            </tr>
                                            </tbody>
                                        </table>
                                    @elseif($order->naqditype!=null)
                                        <table class="table table-hover table-striped w-50 m-auto table-bordered">
                                            <thead class="">
                                            <tr class="text-white">
                                                <th>??????????</th>
                                                <th>?????? ????????????</th>
                                                <th>????????</th>
                                                <th>??????????</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($order->naqditype as $key=>$naqditype)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$naqditype->title}}</td>
                                                    <td>{{number_format($naqditype->mablagh)}} ??????????</td>
                                                    <td>
                                                        <span class="btn text-white btn-warning fishUp" style="padding: 10px 12px" title="??????" data-id="{{$naqditype->id}}" data-toggle="modal" data-target="#naqd-modal-{{$key}}"><i class="fas fa-money-bill"></i> </span>
                                                        <!-- modal group -->
                                                        <div class="modal fade" id="naqd-modal-{{$key}}" role="dialog">
                                                            <div class="modal-dialog">

                                                                <!-- Modal content-->
                                                                <div class="modal-content fishi">
                                                                    <div class="modal-header d-block" style="text-align: right">
                                                                        <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                                                    </div>
                                                                    <div class="modal-body text-dark" style="background: #b3be90">
                                                                        <div class="container-fluid">
                                                                            @if($naqditype->pivot->path!=null)
                                                                                <img style="width: 100%" src="{{asset($naqditype->pivot->path)}}">
                                                                            @else
                                                                                <h6>?????? ???????????? ??????????.</h6>
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

                                    <div class="col-12 mt-5" style="font-size:10px;">
                                        <table class="table-success table table-hover table-striped m-auto table-bordered">
                                            <thead style="
background: #166618;color: white;
">
                                            <th>???????? ????</th>
                                            <th>???????? ?????????? ??????????</th>
                                            <th>???????? ?????????????? ??????????</th>
                                            <th>?????? ???????????? ??????????</th>
                                            <th>?????????? ????????</th>
                                            <th>?????? ??????????</th>
                                            <th>?????? ???????????? ??????</th>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td> ??????????: {{number_format($order->statusmali[0]->bestankar)}} ??????????</td>
                                                <td><input class="justnumber seprator" name="jarimeh" id="jarimeh" value="" autocomplete="off" style="width: 98%;"></td>
                                                <td><input class="justnumber seprator"  name="priceTrans" id="priceTrans" value="{{number_format($order->statusmali[0]->bestankar)}}" autocomplete="off" style="width: 98%;"></td>
                                                <td>
                                                    {{--  specify type of pay: naqd or kasr as kife pool  --}}
                                                    <select name="pay_type" id="pay_type" style="width: 98%;" style="font-size:11px;">
                                                        <option value="">?????? ???????????? ?????????? ???????????? ??????</option>
                                                        <option value="naqd">??????</option>
                                                        <option value="wallet">?????? ???? ?????? ??????</option>
                                                    </select>
                                                </td>
                                                <td><textarea name="title" style="width: 98%;"></textarea></td>

                                                <td>
                                                    <label for="upload2" class="btn btn-info" style="white-space: normal;font-size:10px;">?????? ???????????? ??????</label>
                                                    <input type="file" name="fish_bazgasht_vajh" id="upload2" class="d-none fish_bazgasht_vajh" >
                                                </td>

                                                <td>
                                                    <label for="upload" class="btn btn-info" style="font-size:10px;">?????????? ?????? ??????????</label>
                                                    <input type="file" name="fish_jarime" id="upload" class="d-none fish_jarime" >
                                                </td>

                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    </div>

                        <div class="col-6 mb-3">
                        </div>
                        <div class="col-6 mt-5 mb-5 text-lg-right">
                            <button type="submit" class="w-25 btn btn-success pt-2 pb-2" style="background: orangered!important" id="freesubmit">?????? ??????????</button>
                        </div>
                </div>
            </div>
            </div>
        </form>
    @else
        <div class="container mt-5">
            <h4 class="alert-danger" style="margin-top: 200px">?????? ???????? ???????? ?????? ??????.</h4>
        </div>
    @endif
@endsection
@endif

