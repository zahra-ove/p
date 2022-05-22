//freetimaForm
$(document).ready(function () {

    let tarikhs = [];
    let clickDate;
    $(document).on('change', '#reserve', function (evv){

        ////refresh
        $('#dayTable').empty();
        $('#titrTarikh').remove();
        $('#preMonth').remove();
        $('#nextMonth').remove();
        $('#miladiTitr').remove();
        $('#tarikhclicked').remove();
        $('#bargasht').val('');
        $('#to').empty();
        $('#raft').val('');
        $('#from').empty();
        $('#timeTable').css('border','none')
        // $('#mainTable').empty();

        $('.hrefbtn').hide()

        let jdateNow = new JDate;
        let jdate = new JDate;
        let mildate = new Date();


        $('#timeTable').prepend(`<div class="col-12 text-center" id="tarikhclicked"><h6>${jdate.format('dddd DD MMMM YYYY')}</h6></div>`);
        $('#timeTable').prepend(`<div class="col-12 text-center" id="miladiTitr"><h6 id="miladi" class="text-center mt-2 text-info"><span id="ytimetablemi"> ${mildate.getFullYear()}</span></h6></div>`);
        $('#timeTable').prepend(`<div class="col-3 mt-2" id="nextMonth" style="cursor: pointer"><i class="fas fa-arrow-right"></i></div> <div class="col-6 " id="titrTarikh"> <h4 id="shamsi" class="text-center mt-2 text-primary"><span id="ytimetablesh"> ${jdate.date['0']}</span></h4></div><div class="col-3 mt-2" id="preMonth" style="cursor: pointer;text-align: left"><i class="fas fa-arrow-left"></i></div>`);


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
        ///////disable pass day
        let thisDayTotal="";
        let thisDayTotalSplit="";
        $('.tdDay').each(function (index) {
        let $this = $(this);
        let clicktarikh=$(this).attr('tarikh').split('/');
        clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
        let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
        $(this).attr('miladi',miladi);
        let totalToday=JDate.toGregorian(jdateNow.date[0],jdateNow.date[1],jdateNow.date[2]).getTime();
        thisDayTotalSplit=$(this).attr('tarikh').split('/');
        thisDayTotal=JDate.toGregorian(parseInt(thisDayTotalSplit[0]),parseInt(thisDayTotalSplit[1]),parseInt(thisDayTotalSplit[2])).getTime();
        let weekDay=new Date(miladi).getDay();
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
        $(document).on('click','#nextMonth',function (ee) {
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



        ///////disable pass day

        $('.tdDay').each(function (index) {
        let $this = $(this);
        let clicktarikh=$(this).attr('tarikh').split('/');
        clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
        let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
        $(this).attr('miladi',miladi);
        let totalToday=JDate.toGregorian(jdateNow.date[0],jdateNow.date[1],jdateNow.date[2]).getTime();
        let weekDay=new Date(miladi).getDay();
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
        thisDayTotalSplit=$(this).attr('tarikh').split('/');
        thisDayTotal=JDate.toGregorian(parseInt(thisDayTotalSplit[0]),parseInt(thisDayTotalSplit[1]),parseInt(thisDayTotalSplit[2])).getTime();
        if ($('#raft').val()==miladi){
        $(this).addClass('bg-warning');
    }
        if ($('#bargasht').val()==miladi){
        $(this).addClass('bg-success');
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
        $(document).on('click','#preMonth',function (ee) {
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
    });



        ///////disable pass day

        $('.tdDay').each(function (index) {
            let $this = $(this);
            let clicktarikh=$(this).attr('tarikh').split('/');
            clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
            let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
            $(this).attr('miladi',miladi);
            let totalToday=JDate.toGregorian(jdateNow.date[0],jdateNow.date[1],jdateNow.date[2]).getTime();
            let weekDay=new Date(miladi).getDay();
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
            thisDayTotalSplit=$(this).attr('tarikh').split('/');
            thisDayTotal=JDate.toGregorian(parseInt(thisDayTotalSplit[0]),parseInt(thisDayTotalSplit[1]),parseInt(thisDayTotalSplit[2])).getTime();
            if ($('#raft').val()==miladi){
                $(this).addClass('bg-warning');
            }
            if ($('#bargasht').val()==miladi){
                $(this).addClass('bg-success');
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

////////
    $('.time').clockTimePicker();

});
//==========================================================================================================================
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    $('#finallyTakhfifInput').val(0);
    //////picker
    $(document).on('click', '.tdDay', function (ee) {

        let clicktarikh=$(this).attr('tarikh').split('/');
        clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
        let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
        let beShamsiKamel=new JDate(new Date(miladi)).format('dddd DD MMMM YYYY')
        let bargashtUnix=new Date($('#bargasht').val()).getTime();
        let raftmiladi= new Date(miladi).getTime();

        //================== start part1
        if ($('#mounth').val() != 0 && $('#mounth').val() != null || $('#reserve').val() == 1) {
            $('.tdDay').each(function () {

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
                if ($('#reserve').val()=='2'){
                    $('#bargasht').val('');
                    $('#to').empty();
                }
                $('#raft').val('');
                $('#from').empty();
                $('#calculate').addClass('d-none')
                $(this).removeClass('bg-warning');
                $('.gozashteh').removeClass('gozashteh').css('opacity', '100%');
                let indexof = tarikhs.indexOf(miladi);
                tarikhs.splice(indexof, 1);

                $('#raftTablo').html(``);
                $('#tablo').hide();

            } else if ($(this).hasClass('gozashte')) {
                toastr.error('روز های گذشته را نمی توان انتخاب نمود.');

            } else if ($(this).hasClass('reserved')) {
                toastr.error('این روز قبلاٌ رزرو شده است.')
            } else if ($(this).hasClass('gozashteh')) {
                toastr.error('روز های گذشته را نمیشه انتخاب نمود.')
            }
            else if ($('.bg-warning').length == 0 && $('#raft').val().length == 0) {
                // if (bargashtUnix < raftmiladi) {
                //     $('#bargasht').val('');
                // }

                $('#tablo').show();
                $(this).addClass('bg-warning');
                $('#raft').val(miladi);
                $('#from').html(beShamsiKamel);
            }
            else if (($('.bg-warning').length == 1 || $('#raft').val() != "") && $('.tdDay.bg-success').length == 0 && $('#bargasht').val() == "") {
                $(this).addClass('bg-success');
                $('#bargasht').val(miladi);
                $('#to').html(beShamsiKamel);
            } else if ($(this).hasClass('bg-success')) {
                $(this).removeClass('bg-success');
                $('#bargasht').val("");
                $('#to').empty();
                $('#bargashtTablo').html(``);
                $('#takht').empty();
                $('#select2-takht-container').empty();
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
        //================== end part1


        //================== start part2
        $('#takht').change(function (e) {

            if ($('#reserve').val()=='1')
            {
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
                $('#tarikhMonthTitr').hide();

                $('#price').val($('#takht option:selected').attr('price'));
                $('#tarikhMonthTitr').empty();

                $('#price').val($('#takht').children('option:selected').attr('price'));

                $('#permounth').val(parseInt($('#price').val()));
                let totalPrice = parseInt($('#days').val()) * parseInt($('#price').val());
                $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                $("#totaldays").html(`${$('#days').val()} روز`);
                $("#takPrice").html(`${numberWithCommas($('#price').val()).substr(0,numberWithCommas($('#price').val()).length-3)} تومان`);
                $("#totalPriceInput").val(totalPrice);
                $("#finallyPriceInput").val(totalPrice);
            }
            if ($('#reserve').val()=='2')
            {
                $('#divMonth').removeClass('d-none');
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
                $('#pricemonth').val($('#takht').children('option:selected').attr('pricemonth'));

                $('#permounth').val(parseInt($('#price').val()));
                let totalPrice = parseInt($('#mounth').val()) * parseInt($('#pricemonth').val());
                $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                $("#totalmonthsTitr").html(`${$('#mounth').val()} ماه`);
                $("#takPrice").html(`${numberWithCommas($('#pricemonth').val()).substr(0,numberWithCommas($('#pricemonth').val()).length-3)} تومان`);
                $("#totalPriceInput").val(totalPrice);
                $("#finallyPriceInput").val(totalPrice);
            }
        });
        //================== end part2

        //================== start part3
        $('#emaltakhfif').click(function (e) {

            e.stopPropagation();

            let finalprice = 0;
            let takhfif = 0;
            let newValue = 0;

            if($('#finallyTakhfifInput').val() != '') {
                finalprice = parseInt($('#finallyTakhfifInput').val()) + parseInt($('#finallyPriceInput').val());
                $("#finallyPriceInput").val(finalprice);  //reset to initial value before takhfif
            }

            takhfif = parseInt($('#takhfif').val().replaceAll(',', ""));  //get new takhfif
            $('#finallyTakhfifInput').val(takhfif);   //save current takhfif somewhere

            newValue = parseInt($('#finallyPriceInput').val()) - parseInt(takhfif);
            $("#finallyPriceInput").val(newValue);
            $('#finallyPrice').html(`${numberWithCommas(newValue)} تومان`);

        });
        //================== end part3

        //================== start part4
        $('#paytype').change(function (ee) {

            $('#tarikhMonthTitr').addClass('d-none')

            if ($(this).val()=='q') {

                $('#qestmonthTitr').removeClass('d-none');
                $('#countMonthTitr').removeClass('d-none');
                $('#tarikhMonth').removeClass('d-none');
                if ($('#naqdtype').hasClass('d-none')==false){
                    $('#naqdtype').addClass('d-none');
                }


                $('#countMonthTitr').html(` <div class="col-6" style="padding-left:0px;">
                                                <input min="1" type="number" class="form-control" id="countMonth" value="1" name="qestcount">
                                            </div>
                                            <div class="col-2">
                                                <span class="btn btn-secondary" id="tayidCount" style="cursor: pointer">تایید</span>
                                            </div>`);

                $('#tayidCount').click(function (ese) {
                    // $(document).on('click', '#tayidCount', function (ee) {
                    $('#tarikhMonthTitr').removeClass('d-none');
                    $('#tarikhMonth').empty();
                    let countMonth = $('#countMonth').val(); //تعداد نوبت اقساط
                    for (let i = 0;i<countMonth;i++){
                        $('#tarikhMonth').append(`
                                        <div class="col-3 mt-3 pt-3" style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: center;position: relative;" id="takhfifTitr">
                                            <span style="position: absolute;top: 50%;left: 0;right: 0;">نوبت ${i+1}:</span>
                                        </div>
                                        <div class="col-9 mt-3 pt-3 input-group" style="border-top: 1px solid #bdc4c4;text-align: right;">
                                            <input name="qestmablagh[]" autocomplete="off" class="form-control mr-3 seprator justnumber" id="qestmablagh_${i}"  placeholder="مبلغ" />
                                            <input type="text" name="qesttarikh[]" autocomplete="off" class="form-control jalal" id="qesttarikh_${i}"  placeholder="تاریخ" value="" />
                                        </div>`);
                    }

                    $(".jalal").persianDatepicker({
                    });

                });

            } else if ($(this).val()=='n'){
                $('#naqdtype').removeClass('d-none');

                if ($('#countMonthTitr').hasClass('d-none')==false){
                    $('#countMonthTitr').addClass('d-none');
                }

                if ($('#tarikhMonth').hasClass('d-none')==false){
                    $('#tarikhMonth').addClass('d-none');
                }

                if ($('#qestmonthTitr').hasClass('d-none')==false){
                    $('#qestmonthTitr').addClass('d-none');
                }
                $('#tarikhMonthTitr').empty();
                $('#tarikhMonth').empty();
            }

            // $('#countMonthTitr').empty();

            // $("#submit").submit(function (e) {
            //     // e.preventDefault();
            //     e.stopImmediatePropagation();
            //     if ($('#paytype').val()=='q'){
            //
            //         // تنظیمات تاریخ
            //         if ($('.jalal').length==0){
            //             e.preventDefault();
            //             toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');
            //         } else {
            //             $('.jalal').each(function (index) {
            //                 if ($(`#qesttarikh_${index}`)==""){
            //                     e.preventDefault();
            //                     toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');
            //                 } else {
            //                     let dateValue = $(`#qesttarikh_${index}`).val();
            //                     let clicktarikh = dateValue.split('/');
            //                     let z = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
            //                     let miladi = z[0] + "-" + z[1] + "-" + z[2];
            //                     console.log(miladi);
            //                     $(`#qesttarikh_${index}`).val(miladi);
            //                 }
            //             });
            //         }
            //
            //         // چک مجموع مبلغ قسط ها برابر مبلغ کل فاکتور باشد
            //         let sum = 0;
            //         let countMonth = $('#countMonth').val();   // تعداد نوبت قسط
            //         console.log(countMonth);
            //         for (let i = 0;i<countMonth;i++){
            //             console.log('qest number: ' + i);
            //             console.log($(`#qestmablagh_${i}`).val());
            //             sum = parseInt($(`#qestmablagh_${i}`).val()) + parseInt(sum);
            //         }
            //
            //         console.log('sum of all qests: ' + sum);
            //         console.log('total price: ' + totalPriceForReservation);
            //
            //         if(sum != totalPriceForReservation) {
            //             toastr.error('مجموع مبالغ نوبت ها باید برابر مبلغ نهایی اعلام شده باشد.');
            //         }
            //     }
            //
            // });
        });
        //================== end part4
    });
// end of document
});
