
    ///freetimaForm


    $(document).ready(function () {

});

    $('#takht').change(function (evv){
    $('#price').val($(this).children('option:selected').attr('price'));

    ////refresh
    $('#dayTable').empty();
    $('#titrTarikh').remove();
    $('#preMonth').remove();
    $('#nextMonth').remove();
    $('#miladiTitr').remove();
    $('#tarikhclicked').remove();
    $('#raft').val('');
    $('#timeTable').css('border','none')
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
    let beShamsiKamel=new JDate(new Date(miladi)).format('dddd DD MMMM YYYY')
    let bargashtUnix=new Date($('#bargasht').val()).getTime();
    let raftmiladi= new Date(miladi).getTime();


    if ($('.tdDay.bg-warning').length==0 && $('.tdDay.bg-success').length==1){
    $('#reserve').prop("disabled", false);
}
    if ($(this).hasClass('bg-warning')){
    $(this).removeClass('bg-warning');
    $('.tdDay').removeClass('gozashteh').css('opacity','100%');
    let indexof=tarikhs.indexOf(miladi);
    tarikhs.splice(indexof,1);
    $('#raft').val('');
    $('#from').empty();
    $('#reserve').prop("disabled", true);
    $('#reserve').children().first().attr('selected','selected');
    $('#select2-reserve-container').attr('title','نوع رزرو را انتخاب کنید.');
    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
}
    else if($(this).hasClass('gozashte'))
{
    toastr.error('روز های گذشته را نمی توان انتخاب نمود.');

}
    else if($(this).hasClass('reserved'))
{
    toastr.error('این روز قبلاٌ رزرو شده است.')
}
    else if($(this).hasClass('gozashteh'))
{
    toastr.error('روز های گذشته را نمیشه انتخاب نمود.')
}
    else if ($('.bg-warning').length==0 && $('#raft').val()=="") {
    if (bargashtUnix<raftmiladi){

}
    $('.tdDay').each(function () {
    let attr=$(this).attr('tarikh').split('/');
    pastDate = JalaliDate.jalaliToGregorian(attr[0], attr[1], attr[2]);

    let pastMiladi=pastDate[0] + "-" + pastDate[1] + "-" + pastDate[2];
    let newmiladi= new Date(miladi).getTime();
    let newpastMiladi= new Date(pastMiladi).getTime();
    if(newpastMiladi<newmiladi){
    $(this).css('opacity','50%').addClass('gozashteh');
}

})
    $(this).addClass('bg-warning');
    $('#raft').val(miladi);
    $('#from').html(beShamsiKamel);


}
    else if(($('.bg-warning').length==1 || $('#raft').val()!="") && $('.tdDay.bg-success').length==0 && $('#bargasht').val()==""){
    $(this).addClass('bg-success');
    $('#bargasht').val(miladi);
    $('#to').html(beShamsiKamel);
    $('#reserve').prop("disabled", false);
}
    else if($(this).hasClass('bg-success')){
    $(this).removeClass('bg-success');
        $('#bargasht').val("");
    $('#to').empty();
    $('#reserve').prop("disabled", true);
    $('#reserve').children().first().attr('selected','selected');
    $('#select2-reserve-container').attr('title','نوع رزرو را انتخاب کنید.');
    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
}
    if ($('.tdDay.bg-success').hasClass('gozashteh')){

    $('.tdDay').removeClass('bg-success');

    $('#to').empty();
    $('#reserve').prop("disabled", true);
    $('#reserve').children().first().attr('selected','selected');
    $('#select2-reserve-container').attr('title','نوع رزرو را انتخاب کنید.');
    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');

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
    $(this).attr('miladi',miladi);
    let totalToday=JDate.toGregorian(jdateNow.date[0],jdateNow.date[1],jdateNow.date[2]).getTime();
    thisDayTotalSplit=$(this).attr('tarikh').split('/');
    thisDayTotal=JDate.toGregorian(parseInt(thisDayTotalSplit[0]),parseInt(thisDayTotalSplit[1]),parseInt(thisDayTotalSplit[2])).getTime();
    let weekDay=new Date(miladi).getDay();
    if (weekDay==0){
    $(this).append(`<br><i style="font-size: 9px">ی</i>`)
}
    if (weekDay==1){
    $(this).append(`<br><i style="font-size: 9px">د</i>`)
}
    if (weekDay==2){
    $(this).append(`<br><i style="font-size: 9px">س</i>`)
}
    if (weekDay==3){
    $(this).append(`<br><i style="font-size: 9px">چ</i>`)
}
    if (weekDay==4){
    $(this).append(`<br><i style="font-size: 9px">پ</i>`)
}
    if (weekDay==5){
    $(this).append(`<br><i style="font-size: 9px">ج</i>`)
}
    if (weekDay==6){
    $(this).append(`<br><i style="font-size: 9px">ش</i>`)
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


    //////picker
    $('.tdDay').click(function(ee){
    let clicktarikh=$(this).attr('tarikh').split('/');
    clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
    let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
    let beShamsiKamel=new JDate(new Date(miladi)).format('dddd DD MMMM YYYY');
    let bargashtUnix=new Date($('#bargasht').val()).getTime();
    let raftmiladi= new Date(miladi).getTime();

    if ($('.tdDay.bg-warning').length==0 && $('.tdDay.bg-success').length==1){
    $('#reserve').prop("disabled", false);
}
    if ($(this).hasClass('bg-warning')){
    $(this).removeClass('bg-warning');
    $('.tdDay').removeClass('gozashteh').css('opacity','100%');
    let indexof=tarikhs.indexOf(miladi);
    tarikhs.splice(indexof,1);
    $('#raft').val('');
    $('#from').empty();
    $('#reserve').prop("disabled", true);
    $('#reserve').children().first().attr('selected','selected');
    $('#select2-reserve-container').attr('title','نوع رزرو را انتخاب کنید.');
    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
}
    else if($(this).hasClass('gozashte'))
{
    toastr.error('روز های گذشته را نمی توان انتخاب نمود.')
}
    else if($(this).hasClass('reserved'))
{
    toastr.error('این روز قبلاٌ رزرو شده است.')
}
    else if($(this).hasClass('gozashteh'))
{
    toastr.error('روز های گذشته را نمیشه انتخاب نمود.')
}
    else if ($('.bg-warning').length==0 && $('#raft').val()=="") {
    if (bargashtUnix<raftmiladi){
    // $('#bargasht').val('');
}
    $('.tdDay').each(function () {
    let attr=$(this).attr('tarikh').split('/');
    pastDate = JalaliDate.jalaliToGregorian(attr[0], attr[1], attr[2]);

    let pastMiladi=pastDate[0] + "-" + pastDate[1] + "-" + pastDate[2];
    let newmiladi= new Date(miladi).getTime();
    let newpastMiladi= new Date(pastMiladi).getTime();
    if(newpastMiladi<newmiladi){
    $(this).css('opacity','50%').addClass('gozashteh');
}

})
    $(this).addClass('bg-warning');
    $('#raft').val(miladi);
    $('#from').html(beShamsiKamel);


}
    else if(($('.bg-warning').length==1 || $('#raft').val()!="") && $('.tdDay.bg-success').length==0 && $('#bargasht').val()==""){
    $(this).addClass('bg-success');
    $('#bargasht').val(miladi);
    $('#to').html(beShamsiKamel);
    $('#reserve').prop("disabled", false);
}
    else if($(this).hasClass('bg-success')){
    $(this).removeClass('bg-success');
        $('#bargasht').val("");
    $('#to').empty();
    $('#reserve').prop("disabled", true);
    $('#reserve').children().first().attr('selected','selected');
    $('#select2-reserve-container').attr('title','نوع رزرو را انتخاب کنید.');
    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
}
    if ($('.tdDay.bg-success').hasClass('gozashteh')){

    $('.tdDay').removeClass('bg-success');
    //
    $('#to').empty();
    $('#reserve').prop("disabled", true);
    $('#reserve').children().first().attr('selected','selected');
    $('#select2-reserve-container').attr('title','نوع رزرو را انتخاب کنید.');
    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');

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
    $(this).attr('miladi',miladi);
    let totalToday=JDate.toGregorian(jdateNow.date[0],jdateNow.date[1],jdateNow.date[2]).getTime();
    let weekDay=new Date(miladi).getDay();
    if (weekDay==0){
    $(this).append(`<br><i style="font-size: 9px">ی</i>`)
}
    if (weekDay==1){
    $(this).append(`<br><i style="font-size: 9px">د</i>`)
}
    if (weekDay==2){
    $(this).append(`<br><i style="font-size: 9px">س</i>`)
}
    if (weekDay==3){
    $(this).append(`<br><i style="font-size: 9px">چ</i>`)
}
    if (weekDay==4){
    $(this).append(`<br><i style="font-size: 9px">پ</i>`)
}
    if (weekDay==5){
    $(this).append(`<br><i style="font-size: 9px">ج</i>`)
}
    if (weekDay==6){
    $(this).append(`<br><i style="font-size: 9px">ش</i>`)
}
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
});

    //////picker
    $('.tdDay').click(function(ee){
    let clicktarikh=$(this).attr('tarikh').split('/');
    clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
    let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
    let beShamsiKamel=new JDate(new Date(miladi)).format('dddd DD MMMM YYYY');
    let bargashtUnix=new Date($('#bargasht').val()).getTime();
    let raftmiladi= new Date(miladi).getTime();

    if ($('.tdDay.bg-warning').length==0 && $('.tdDay.bg-success').length==1){
    $('#reserve').prop("disabled", false);
}
    if ($(this).hasClass('bg-warning')){
    $(this).removeClass('bg-warning');
    $('.tdDay').removeClass('gozashteh').css('opacity','100%');
    let indexof=tarikhs.indexOf(miladi);
    tarikhs.splice(indexof,1);
    $('#raft').val('');
    $('#from').empty();
    $('#reserve').prop("disabled", true);
    $('#reserve').children().first().attr('selected','selected');
    $('#select2-reserve-container').attr('title','نوع رزرو را انتخاب کنید.');
    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
}
    else if($(this).hasClass('gozashte'))
{
    toastr.error('روز های گذشته را نمی توان انتخاب نمود.')
}
    else if($(this).hasClass('reserved'))
{
    toastr.error('این روز قبلاٌ رزرو شده است.')
}
    else if($(this).hasClass('gozashteh'))
{
    toastr.error('روز های گذشته را نمیشه انتخاب نمود.')
}
    else if ($('.bg-warning').length==0 && $('#raft').val()=="") {
    if (bargashtUnix<raftmiladi){

}
    $('.tdDay').each(function () {
    let attr=$(this).attr('tarikh').split('/');
    pastDate = JalaliDate.jalaliToGregorian(attr[0], attr[1], attr[2]);

    let pastMiladi=pastDate[0] + "-" + pastDate[1] + "-" + pastDate[2];
    let newmiladi= new Date(miladi).getTime();
    let newpastMiladi= new Date(pastMiladi).getTime();
    if(newpastMiladi<newmiladi){
    $(this).css('opacity','50%').addClass('gozashteh');
}

})
    $(this).addClass('bg-warning');
    $('#raft').val(miladi);
    $('#from').html(beShamsiKamel);


}
    else if(($('.bg-warning').length==1 || $('#raft').val()!="") && $('.tdDay.bg-success').length==0 && $('#bargasht').val()==""){
    $(this).addClass('bg-success');
    $('#bargasht').val(miladi);
    $('#to').html(beShamsiKamel);
    $('#reserve').prop("disabled", false);
}
    else if($(this).hasClass('bg-success')){
    $(this).removeClass('bg-success');
    $('#bargasht').val("");
    console.log($('#bargasht').val())
    $('#to').empty();
    $('#reserve').prop("disabled", true);
    $('#reserve').children().first().attr('selected','selected');
    $('#select2-reserve-container').attr('title','نوع رزرو را انتخاب کنید.');
    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
}
    if ($('.tdDay.bg-success').hasClass('gozashteh')){

    $('.tdDay').removeClass('bg-success');

    $('#to').empty();
    $('#reserve').prop("disabled", true);
    $('#reserve').children().first().attr('selected','selected');
    $('#select2-reserve-container').attr('title','نوع رزرو را انتخاب کنید.');
    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');

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
    $(this).attr('miladi',miladi);
    let totalToday=JDate.toGregorian(jdateNow.date[0],jdateNow.date[1],jdateNow.date[2]).getTime();
    let weekDay=new Date(miladi).getDay();
    if (weekDay==0){
    $(this).append(`<br><i style="font-size: 9px">ی</i>`)
}
    if (weekDay==1){
    $(this).append(`<br><i style="font-size: 9px">د</i>`)
}
    if (weekDay==2){
    $(this).append(`<br><i style="font-size: 9px">س</i>`)
}
    if (weekDay==3){
    $(this).append(`<br><i style="font-size: 9px">چ</i>`)
}
    if (weekDay==4){
    $(this).append(`<br><i style="font-size: 9px">پ</i>`)
}
    if (weekDay==5){
    $(this).append(`<br><i style="font-size: 9px">ج</i>`)
}
    if (weekDay==6){
    $(this).append(`<br><i style="font-size: 9px">ش</i>`)
}
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



    $('#emaltakhfif').click(function (eee) {
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    let takhfif=$('#takhfif').val().replaceAll(',', "");
    let final = $('#totalPriceInput').val()-takhfif;
    $("#finallyPriceInput").val(final);
    $('#finallyPrice').html(`${numberWithCommas(final)} تومان`)
});


    $('#paytype').change(function (ee) {
    if ($(this).val()=='q'){
    $('#qestmonthTitr').removeClass('d-none');
    $('#countMonthTitr').removeClass('d-none');
    $('#tarikhMonth').removeClass('d-none');
        if ($('#naqdtype').hasClass('d-none')==false){
            $('#naqdtype').addClass('d-none');
        }
}
    else if ($(this).val()=='n'){

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
    function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
    $('#countMonthTitr').empty();
    if ($(this).val()=='q'){
    $('#countMonthTitr').html(`<div class="col-10"> <input min="1" type="number" class="form-control" id="countMonth" value="1"></div> <div class="col-2"> <span class="btn btn-secondary" id="tayidCount" style="cursor: pointer">تایید</span></div>`)
}
    $('#tayidCount').click(function (ese) {


    $('#tarikhMonth').empty();
    let countMonth = $('#countMonth').val();
    let perMounth = parseInt($('#finallyPriceInput').val().replaceAll(',',''))/countMonth;
    $('#perMonth').val(perMounth);
    $('#tarikhMonthTitr').append(`<h6 id="perMonth" class="mt-3">${numberWithCommas(perMounth)} تومان مبلغ پرداختی هر نوبت</h6>`)
    for (let i = 0;i<countMonth;i++){
    $('#tarikhMonth').append(`    <div class="col-6 mt-3 pt-3" style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;" id="takhfifTitr">نوبت ${i+1}:</div>
                                <div class="col-6 mt-3 pt-3" style="border-top: 1px solid #bdc4c4;text-align: right;">   <input name="qesttarikh[]" autocomplete="off" class="form-control jalal"></div>`);
}
    $(".jalal").persianDatepicker({alwaysShow: true,closeOnBlur:true,
});
    $('.pdp-default').hide();
    $('.jalal').click(function (eve) {
    let $this=$(this);

    $('.pdp-default').each(function (index) {
    if ($this.attr('pdp-id')==$(this).attr('id')){
    $(this).show();
}
});
});

    $('.pdp-default').click(function (eve) {

    let $this=$(this);

    $('.jalal').each(function (index) {

    if ($(this).attr('pdp-id')==$this.attr('id')){
    $this.hide();
}
});


});

});
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
});


