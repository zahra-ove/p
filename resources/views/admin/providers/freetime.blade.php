@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">

@section('js')
{{--    <script src="https://rawgit.com/abdennour/hijri-date/master/cdn/hijri-date-latest.js" type="text/javascript" ></script>--}}
    <script src="{{asset('admin/js/hijri-date-latest.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin')}}/js/jdate.min.js" type="text/javascript" charset="utf-8"></script>

    <script>
        $(document).ready(function () {

            let jdateNow = new JDate;
            let jdate = new JDate;
            let mildate = new Date();
            let tarikhs = [];

            $('#timeTable').prepend(`<div class="col-12 text-center"><h6>${jdate.format('dddd DD MMMM YYYY')}</h6></div>`);
            $('#timeTable').prepend(`<div class="col-12 text-center"><h6 id="miladi" class="text-center mt-2 text-info"><span id="ytimetablemi"> ${mildate.getFullYear()}</span></h6></div>`);
            $('#timeTable').prepend(`<div class="col-4 mt-2" id="nextMonth" style="cursor: pointer"><i class="fas fa-arrow-right"></i></div> <div class="col-4 "> <h4 id="shamsi" class="text-center mt-2 text-primary"><span id="ytimetablesh"> ${jdate.date['0']}</span></h4></div><div class="col-4 mt-2" id="preMonth" style="cursor: pointer;text-align: left"><i class="fas fa-arrow-left"></i></div>`);


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

                    if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                    if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                    if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                    if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                    if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                    if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                    if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                    if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                    if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                    if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                    if ($(this)[0].innerText == jdate.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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
            $('.tdDay').click(function(ee){
                let clicktarikh=$(this).attr('tarikh').split('/');
                clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];

                if ($(this).hasClass('bg-warning')){
                    $('#setting').addClass('d-none');
                    $('#showTarikh').empty();
                    $('#showStarttime').empty();
                    $('#showEndtime').empty();
                    $('#showStatus').empty();
                    $(this).removeClass('bg-warning');
                    let indexof=tarikhs.indexOf(miladi);
                    tarikhs.splice(indexof,1);

                }
                else if($(this).hasClass('kharide')){
                    toastr.error('قبلا خریداری شده')
                }
                else if($(this).hasClass('bg-danger'))
                {
                    toastr.error('قبلا ثبت شده');
                    $.ajax(
                        {
                            url:"{{asset('admin/getfreebytarikh')}}",
                            data:{'tarikh':miladi},
                            success:function (data) {
                                $('#setting').removeClass('d-none');
                                $('#showTarikh').html(`${data.jalali}`);
                                $('#showStarttime').html(`${data.starttime}`);
                                $('#showEndtime').html(`${data.endtime}`);
                                $('#showStatus').html(`${data.vaziat}`);
                                $('.delete-btn').attr('data-id',data.id);
                                $('#endtimeEdit').val(data.endtime);
                                $('#starttimeEdit').val(data.starttime);
                                $('#editSubmit').attr('action','{{asset('admin/freetime')}}/'+data.id+'/edit');
                                $('#statusEdit option').each(function (index) {
                                    if ($(this).val()==data.status){
                                        $(this).attr('selected','selected');
                                    }
                                })
                            }
                        }
                    )
                }
                else if($(this).hasClass('gozashte'))
                {
                    $('#setting').addClass('d-none');
                    $('#showTarikh').empty();
                    $('#showStarttime').empty();
                    $('#showEndtime').empty();
                    $('#showStatus').empty();
                    toastr.error('روز های گذشته را نمیشه انتخاب نمود.')
                }
                else {
                    let tarikhsplit="";
                    $('#setting').addClass('d-none');
                    $('#showTarikh').empty();
                    $('#showStarttime').empty();
                    $('#showEndtime').empty();
                    $('#showStatus').empty();
                    $(this).addClass('bg-warning');

                    tarikhs.push(miladi);

                }
                let tarikhPicked = $(this).attr('tarikh').split('/');

                jdate19 = new JDate(tarikhPicked[0], tarikhPicked[1], tarikhPicked[2]);

                $('#datePicked').html(`<h6>${jdate19.format('dddd DD MMMM YYYY')}</h6>`);


            });

            ///////disable pass day
            let thisDayTotal="";
            let thisDayTotalSplit="";
            $('.tdDay').each(function (index) {
                let $this = $(this);
                let clicktarikh=$(this).attr('tarikh').split('/');
                clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                let totalToday=JDate.toGregorian(jdateNow.date[0],jdateNow.date[1],jdateNow.date[2]).getTime();
                let weekDay=new Date(miladi).getDay();
                if (weekDay==0){
                    $(this).append(`<br><i style="font-size: 9px">یکشنبه</i>`)
                }
                if (weekDay==1){
                    $(this).append(`<br><i style="font-size: 9px">دوشنبه</i>`)
                }
                if (weekDay==2){
                    $(this).append(`<br><i style="font-size: 9px">سه شنبه</i>`)
                }
                if (weekDay==3){
                    $(this).append(`<br><i style="font-size: 9px">چهار شنبه</i>`)
                }
                if (weekDay==4){
                    $(this).append(`<br><i style="font-size: 9px">پبنجشنبه</i>`)
                }
                if (weekDay==5){
                    $(this).append(`<br><i style="font-size: 9px">جمعه</i>`)
                }
                if (weekDay==6){
                    $(this).append(`<br><i style="font-size: 9px">شنبه</i>`)
                }

                // if ()
                thisDayTotalSplit=$(this).attr('tarikh').split('/');
                thisDayTotal=JDate.toGregorian(parseInt(thisDayTotalSplit[0]),parseInt(thisDayTotalSplit[1]),parseInt(thisDayTotalSplit[2])).getTime();

                if(thisDayTotal<totalToday){
                    $(this).css('opacity','50%').addClass('gozashte');
                }
        tarikhs.forEach(function (item,index){
            if (item==miladi){
                $this.addClass('bg-warning');
            }
        });

            });
            //////nextmonth
            $('#nextMonth').click(function (ee) {
              $(this).attr('month',jdate.date[1])
              $(this).attr('day',jdate.date[2])

                let miladi3 = [];
                let unixNextMonth = Math.floor(mildate.setHours(0)) + 2592000000;

                if ($(this).attr('month')==11 && $(this).attr('day')==30)
                {

                    unixNextMonth = Math.floor(mildate.setHours(0)) + 2505600000;

                }
                if ($(this).attr('month')==1 || $(this).attr('month')==2 || $(this).attr('month')==3 ||
                    $(this).attr('month')==4 || $(this).attr('month')==5 || $(this).attr('month')==6)
                {

                    unixNextMonth = Math.floor(mildate.setHours(0)) + 2678400000;
                }

                if ($(this).attr('month')==6 && $(this).attr('day')==31)
                {

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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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
                $.ajax({
                    url:"{{asset('admin/getdisablefree')}}",
                    success:function (data) {
                        let splitTarikh="";
                        let jjddate="";
                        let disableJalali="";
                        let $this = "";
                        $('.tdDay').each(function (index) {
                            $this=$(this);
                            if (data!='notfound')
                            {

                                data.forEach(function (item,index) {

                                    // console.log(item.tarikh);
                                    splitTarikh=item.tarikh.split('-');
                                    jjddate=new JDate(new Date(item.tarikh));

                                    disableJalali=jjddate.date[0]+'/'+jjddate.date[1]+'/'+jjddate.date[2];

                                    if ($this.attr('tarikh')==disableJalali){


                                            $this.addClass('bg-danger');


                                    }
                                })


                            }

                        })

                    }
                });

                //////picker
                $('.tdDay').click(function(ee){
                    let clicktarikh=$(this).attr('tarikh').split('/');
                    clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                    let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                    if ($(this).hasClass('bg-warning')){
                        $('#setting').addClass('d-none');
                        $('#showTarikh').empty();
                        $('#showStarttime').empty();
                        $('#showEndtime').empty();
                        $('#showStatus').empty();
                        $(this).removeClass('bg-warning');
                        let indexof=tarikhs.indexOf(miladi);
                        tarikhs.splice(indexof,1);

                    }
                    else if($(this).hasClass('kharide')){
                        toastr.error('قبلا خریداری شده')
                    }
                    else if($(this).hasClass('gozashte'))
                    {
                        $('#setting').addClass('d-none');
                        $('#showTarikh').empty();
                        $('#showStarttime').empty();
                        $('#showEndtime').empty();
                        $('#showStatus').empty();
                        toastr.error('روز های گذشته را نمیشه انتخاب نمود.')
                    }
                    else if($(this).hasClass('bg-danger'))
                    {
                        toastr.error('قبلا ثبت شده');
                        $.ajax(
                            {
                                url:"{{asset('admin/getfreebytarikh')}}",
                                data:{'tarikh':miladi},
                                success:function (data) {
                                    $('#setting').removeClass('d-none');
                                    $('#showTarikh').html(`${data.jalali}`)
                                    $('#showStarttime').html(`${data.starttime}`)
                                    $('#showEndtime').html(`${data.endtime}`)
                                    $('#showStatus').html(`${data.vaziat}`)
                                    $('.delete-btn').attr('data-id',data.id);
                                    $('#endtimeEdit').val(data.endtime);
                                    $('#starttimeEdit').val(data.starttime);
                                }
                            }
                        );
                    }
                    else {
                        $('#setting').addClass('d-none');
                        $('#showTarikh').empty();
                        $('#showStarttime').empty();
                        $('#showEndtime').empty();
                        $('#showStatus').empty();
                        $(this).addClass('bg-warning');
                        tarikhs.push(miladi);
                        console.log(tarikhs);
                    }
                    let tarikhPicked = $(this).attr('tarikh').split('/');

                    jdate19 = new JDate(tarikhPicked[0], tarikhPicked[1], tarikhPicked[2]);

                    $('#datePicked').html(`<h6>${jdate19.format('dddd DD MMMM YYYY')}</h6>`);


                });
                ///////disable pass day

                $('.tdDay').each(function (index) {
                    let $this = $(this);
                    let clicktarikh=$(this).attr('tarikh').split('/');
                    clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                    let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                    let totalToday=JDate.toGregorian(jdateNow.date[0],jdateNow.date[1],jdateNow.date[2]).getTime();
                    thisDayTotalSplit=$(this).attr('tarikh').split('/');
                    thisDayTotal=JDate.toGregorian(parseInt(thisDayTotalSplit[0]),parseInt(thisDayTotalSplit[1]),parseInt(thisDayTotalSplit[2])).getTime();
                    let weekDay=new Date(miladi).getDay();
                    if (weekDay==0){
                        $(this).append(`<br><i style="font-size: 9px">یکشنبه</i>`)
                    }
                    if (weekDay==1){
                        $(this).append(`<br><i style="font-size: 9px">دوشنبه</i>`)
                    }
                    if (weekDay==2){
                        $(this).append(`<br><i style="font-size: 9px">سه شنبه</i>`)
                    }
                    if (weekDay==3){
                        $(this).append(`<br><i style="font-size: 9px">چهار شنبه</i>`)
                    }
                    if (weekDay==4){
                        $(this).append(`<br><i style="font-size: 9px">پبنجشنبه</i>`)
                    }
                    if (weekDay==5){
                        $(this).append(`<br><i style="font-size: 9px">جمعه</i>`)
                    }
                    if (weekDay==6){
                        $(this).append(`<br><i style="font-size: 9px">شنبه</i>`)
                    }
                    if(thisDayTotal<totalToday){
                        $(this).css('opacity','50%').addClass('gozashte');
                    }
                    tarikhs.forEach(function (item,index){
                        if (item==miladi){
                            $this.addClass('bg-warning');
                        }
                    });
                });

            });

            //////premonth
            $('#preMonth').click(function (ee) {
                $(this).attr('month',jdate.date[1])
                $(this).attr('day',jdate.date[2])
                let miladi3 = [];
                let unixNextMonth = Math.floor(mildate.setHours(0)) - 2592000000;

                if ($(this).attr('month')==1 &&$(this).attr('day')==1 ){
                    unixNextMonth = Math.floor(mildate.setHours(0)) - 2505600000;
                }

                if ($(this).attr('month')==1 || $(this).attr('month')==2 || $(this).attr('month')==3 ||
                    $(this).attr('month')==4 || $(this).attr('month')==5 || $(this).attr('month')==6)
                {

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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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

                        if ($(this)[0].innerText == jdateNow.date['2'] && $(this).attr('month')==jdateNow.date['1']) {
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
                })
                $.ajax({
                    url:"{{asset('admin/getdisablefree')}}",
                    success:function (data) {
                        let splitTarikh="";
                        let jjddate="";
                        let disableJalali="";
                        let $this = "";
                        $('.tdDay').each(function (index) {
                            $this=$(this);
                            if (data!='notfound')
                            {

                                data.forEach(function (item,index) {

                                    // console.log(item.tarikh);
                                    splitTarikh=item.tarikh.split('-');
                                    jjddate=new JDate(new Date(item.tarikh));

                                    disableJalali=jjddate.date[0]+'/'+jjddate.date[1]+'/'+jjddate.date[2];

                                    if ($this.attr('tarikh')==disableJalali){

                                            $this.addClass('bg-danger');

                                    }
                                })


                            }

                        })

                    }
                });

                //////picker
                $('.tdDay').click(function(ee){
                    let clicktarikh=$(this).attr('tarikh').split('/');
                    clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                    let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                    if ($(this).hasClass('bg-warning')){
                        $('#setting').addClass('d-none');
                        $('#showTarikh').empty();
                        $('#showStarttime').empty();
                        $('#showEndtime').empty();
                        $('#showStatus').empty();
                        $(this).removeClass('bg-warning');
                        let indexof=tarikhs.indexOf(miladi);
                        tarikhs.splice(indexof,1);

                    }
                    else if($(this).hasClass('kharide')){
                        toastr.error('قبلا خریداری شده')
                    }
                    else if($(this).hasClass('gozashte'))
                    {
                        $('#setting').addClass('d-none');
                        $('#showTarikh').empty();
                        $('#showStarttime').empty();
                        $('#showEndtime').empty();
                        $('#showStatus').empty();
                        toastr.error('روز های گذشته را نمیشه انتخاب نمود.')
                    }
                    else if($(this).hasClass('bg-danger'))
                    {
                        toastr.error('قبلا ثبت شده');
                        $.ajax(
                            {
                                url:"{{asset('admin/getfreebytarikh')}}",
                                data:{'tarikh':miladi},
                                success:function (data) {
                                    $('#setting').removeClass('d-none');
                                    $('#showTarikh').html(`${data.jalali}`)
                                    $('#showStarttime').html(`${data.starttime}`)
                                    $('#showEndtime').html(`${data.endtime}`)
                                    $('#showStatus').html(`${data.vaziat}`)
                                    $('.delete-btn').attr('data-id',data.id);
                                    $('#endtimeEdit').val(data.endtime);
                                    $('#starttimeEdit').val(data.starttime);
                                }
                            }
                        );
                    }
                    else {
                        $('#setting').addClass('d-none');
                        $('#showTarikh').empty();
                        $('#showStarttime').empty();
                        $('#showEndtime').empty();
                        $('#showStatus').empty();
                        $(this).addClass('bg-warning');
                        tarikhs.push(miladi);
                        console.log(tarikhs);
                    }
                    let tarikhPicked = $(this).attr('tarikh').split('/');

                    jdate19 = new JDate(tarikhPicked[0], tarikhPicked[1], tarikhPicked[2]);

                    $('#datePicked').html(`<h6>${jdate19.format('dddd DD MMMM YYYY')}</h6>`);


                });

                ///////disable pass day

                $('.tdDay').each(function (index) {
                    let $this = $(this);
                    let clicktarikh=$(this).attr('tarikh').split('/');
                    clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                    let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                    let totalToday=JDate.toGregorian(jdateNow.date[0],jdateNow.date[1],jdateNow.date[2]).getTime();
                    thisDayTotalSplit=$(this).attr('tarikh').split('/');
                    thisDayTotal=JDate.toGregorian(parseInt(thisDayTotalSplit[0]),parseInt(thisDayTotalSplit[1]),parseInt(thisDayTotalSplit[2])).getTime();
                    let weekDay=new Date(miladi).getDay();
                    if (weekDay==0){
                        $(this).append(`<br><i style="font-size: 9px">یکشنبه</i>`)
                    }
                    if (weekDay==1){
                        $(this).append(`<br><i style="font-size: 9px">دوشنبه</i>`)
                    }
                    if (weekDay==2){
                        $(this).append(`<br><i style="font-size: 9px">سه شنبه</i>`)
                    }
                    if (weekDay==3){
                        $(this).append(`<br><i style="font-size: 9px">چهار شنبه</i>`)
                    }
                    if (weekDay==4){
                        $(this).append(`<br><i style="font-size: 9px">پبنجشنبه</i>`)
                    }
                    if (weekDay==5){
                        $(this).append(`<br><i style="font-size: 9px">جمعه</i>`)
                    }
                    if (weekDay==6){
                        $(this).append(`<br><i style="font-size: 9px">شنبه</i>`)
                    }
                    if(thisDayTotal<totalToday){
                        $(this).css('opacity','50%').addClass('gozashte');
                    }
                    tarikhs.forEach(function (item,index){
                        if (item==miladi){
                            $this.addClass('bg-warning');
                        }
                    });
                });

            });


                $.ajax({
                    url:"{{asset('admin/getdisablefree')}}",
                    success:function (data) {
                        let splitTarikh="";
                        let jjddate="";
                        let disableJalali="";
                        let $this = "";
                        $('.tdDay').each(function (index) {
                                $this=$(this);
                            if (data!='notfound')
                            {

                                data.forEach(function (item,index) {

                                    // console.log(item.tarikh);
                                    splitTarikh=item.tarikh.split('-');
                                    jjddate=new JDate(new Date(item.tarikh));

                                    disableJalali=jjddate.date[0]+'/'+jjddate.date[1]+'/'+jjddate.date[2];

                                        if ($this.attr('tarikh')==disableJalali){

                                                $this.addClass('bg-danger');

                                        }
                                })


                            }

                        })

                    }
                });



////////
                $('.time').clockTimePicker();
                ////edit
                $('#month').change(function (ev) {
                    let valued = $(this).val();
                    if (valued == 'فروردین' || valued == 'ردیبهشت' || valued == 'خرداد' || valued == 'تیر' || valued == 'مرداد' || valued == 'شهریور') {
                        $('#day').empty();
                        $('#day').append(' <option value="">روز را انتخاب کنید.</option>');
                        for (let i = 1; i <= 31; i++) {
                            $('#day').append(` <option value="${i}">${i}</option>`);
                        }
                    } else if (valued == "") {
                        $('#day').empty();
                        $('#day').append(' <option value="">روز را انتخاب کنید.</option>');
                    } else {
                        $('#day').empty();
                        $('#day').append(' <option value="">روز را انتخاب کنید.</option>');
                        for (let i = 1; i <= 30; i++) {
                            $('#day').append(` <option value="${i}">${i}</option>`);
                        }
                    }
                })

                ///freetimaForm

                $("#submit").submit(function (e) {
                 $('#tarikh').val(tarikhs);
                    if ($('#starttime').val()==""){
                        e.preventDefault();
                        toastr.error('ساعت ورود ندارد');
                    }

                    if ($('#endtime').val()==""){
                        e.preventDefault();
                        toastr.error('ساعت خروج ندارد');
                    }

                        if (tarikhs.length==0){
                            e.preventDefault();
                            toastr.error('تاریخی انتخاب نشده است.');
                        }


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
                            url: "{{asset('admin')}}/freetime/" + btnDel,
                            data: info,
                            type: "delete",
                            success: function (data) {

                    location.reload();

                            }
                        }
                    );
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
            })

    </script>
@endsection
<style>

    #timeTable{
        height: 448.719px;
    }

    .select2 {
        width: 100% !important;
    }

</style>
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row w-100">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">افزودن زمان های آزاد {{$product->product->title}}
                        برای {{$product->user->business_title}}</h4></div>
                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <form method="post" action="{{route('freetime.store')}}" id="submit">
        @csrf
        <input name="id" class="d-none" value="{{$product->id}}">
        <input id="tarikh" name="tarikh" class="d-none" value="">
{{--        <input name="month[]" class="d-none" value="{{$product->id}}">--}}
        <div class="container-fluid card">
            <div class="row">
                <div class="col-lg-8 row">
                 <div class="col-12">
<h4 class="m-2">تنظیمات زمان آزاد</h4>
                             <table class="align-right table-hover table-dark table-striped w-100 " id="editTime">
                                 <thead class="m-3" >
                                 <tr class="m-3">


                                     <th>تاریخ دقیق</th>
                                     <th>ساعت ورود</th>
                                     <th>ساعت خروج</th>
                                     <th>وضعیت</th>
                                     <th class="text-center">تنظیمات</th>
                                 </tr>
                                 </thead>
                                 <tbody class="m-3">

                                         <tr data-id="" class="m-3">
                                             <td id="showTarikh" class="p-3"></td>
                                             <td id="showStarttime"></td>
                                             <td id="showEndtime"></td>
                                             <td id="showStatus"></td>

                                             <td class="text-center d-none" id="setting">
                                                 <a href="#" class="btn text-white btn-warning btn-edit" title="ویرایش" data-id=""
                                                         data-toggle="modal" data-target="#edit-modal"><i class="fas fa-edit"></i>
                                                 </a>

                                                 <a href="#" class="btn text-white btn-danger" title="حذف" data-id=""
                                                         data-toggle="modal" data-target="#delete-modal-"><i
                                                         class="fas fa-trash"></i></a>
                                                 <!-- modal delete -->
                                                 <div class="modal fade" id="delete-modal-" role="dialog">
                                                     <div class="modal-dialog">

                                                         <!-- Modal content-->
                                                         <div class="modal-content">
                                                             <div class="modal-header d-block" style="text-align: right">
                                                                 <button type="button" class="close" data-dismiss="modal"
                                                                         style="float: right">&times;
                                                                 </button>
                                                             </div>
                                                             <div class="modal-body text-dark">
                                                                 <div style="text-align: right">
                                                                     <p>آیا می خواهید زمان آزاد مربوطه حذف شود؟</p>
                                                                 </div>
                                                                 <div style="text-align: left">
                                                                     <button data-dismiss="modal"
                                                                             class="btn text-white btn-danger delete-btn" title="حذف"
                                                                             data-id="" data-toggle="modal"
                                                                             data-target="#delete-modal">حذف
                                                                     </button>

                                                                 </div>

                                                             </div>
                                                         </div>

                                                     </div>
                                                 </div>
                                             </td>


                                         </tr>

                                 </tbody>

                             </table>



                 </div>
                    <div class="col-12 col-lg-6 mt-5 row p-0 m-3" id="timeTable" style="border: 1px solid #dee2e6">
                        <div class="col-12 p-0">
                            <table id="mainTable" class="table mb-0">
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

                    <div class="col-12 col-lg-5 mt-5 row p-0 m-3" id="eventTable">
                        <h4>
                            رویداد های
                            شمسی
                        </h4>
                        <ul id="shamsiEvent" class="col-12">


                        </ul>

                        <h4>رویداد های قمری</h4>
                        <ul id="hijriEvent" class="col-12">

                        </ul>
                    </div>
                    <div class="col-12 mt-2" id="datePicked"></div>
                    <div class="col-12 col-lg-4 mb-5 mt-5" dir="ltr">
                        <label class="form-label mb-2" for="day">ساعت ورود</label>
                        <br>
                        <input name="starttime" id="starttime" class="form-control time">

                    </div>
                    <div class="col-12 col-lg-4 mb-5 mt-5" dir="ltr">

                        <label class="form-label mb-2" for="day">ساعت خروج</label>
                        <br>
                        <input name="endtime" id="endtime" class=" form-control time">

                    </div>

                </div>
                <div class="col-lg-4 mb-5 mt-5 row pl-5">
                    <div class="col-12 text-center">
                        <div class="col-12 mb-3">
                            <button type="submit" class="w-50 btn btn-success pt-2 pb-2" id="freesubmit">ثبت</button>
                        </div>
                        <div class="col-12 mb-3">
                            <a href="{{route('getproducts',$product->id)}}"
                               class="w-50 btn btn-danger pt-2 pb-2">بازگشت</a>

                            <div class="col-12 singleShow mt-5">

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </form>
    <!-- modal edit -->
    <div class="modal fade" id="edit-modal" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header d-block" style="text-align: right">
                    <button type="button" class="close" data-dismiss="modal"
                            style="float: right">&times;
                    </button>
                </div>
                <div class="modal-body text-dark">
                    <!-- START: Breadcrumbs-->
                    <div class="py-5 mt-5 mb-lg-3 row w-100">
                        <div class="col-12  align-self-center">
                            <div
                                class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                                <div class="w-sm-100 mr-auto"><h4 class="mb-0">ویرایش زمان</h4>
                                </div>
                                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- END: Breadcrumbs-->
                    <!-- START: Form-->
                    <form method="post" enctype="multipart/form-data" id="editSubmit">
                        @csrf
                        @method('patch')
                        <div class="container-fluid card">
                            <div class="row parent-file">
                                <div class="col-lg-8 row">
                                    <div class="col-12 col-lg-4 mb-5 mt-5" dir="ltr">
                                        <label class="form-label mb-2" for="day">ساعت ورود</label>
                                        <br>
                                        <input name="starttime" id="starttimeEdit" class="form-control time">

                                    </div>
                                    <div class="col-12 col-lg-4 mb-5 mt-5" dir="ltr">

                                        <label class="form-label mb-2" for="day">ساعت خروج</label>
                                        <br>
                                        <input name="endtime" id="endtimeEdit" class=" form-control time">

                                    </div>
                                    <div class="col-12 col-lg-4 mb-5 mt-5" dir="ltr">
                                        <label class="form-label mb-2" for="statusEdit">وضعیت</label>
                                        <br>
                                        <select class="form-control"  name="status" id="statusEdit">
                                            <option value="enable">فعال</option>
                                            <option value="disable">غیر فعال</option>
                                            <option value="reserv">رزرو شده</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-lg-4 mb-5 mt-5 row pl-5">
                                    <div class="col-12 text-center">
                                        <div class="col-12 mb-3 mt-3">
                                            <button type="submit"
                                                    class="w-100 btn btn-success mt-3 pt-2 pb-2 submit-edit"
                                                    id="citysubmit" data-id="">ثبت
                                            </button>
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
@endsection
