@extends('admin.master.home')
@section('js')
    <script src="{{asset('admin/js/hijri-date-latest.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin/js/jdate.min.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('admin/js/taghvimSCOOB.js')}}" type="text/javascript" charset="utf-8"></script>

    <script>

        $(document).ready(function (e) {

            let walletAmount = 0;     // final price after accounting takhfif and wallet
            let walletDecreased = 0;   // این فلگ مشخص میکند که در مرحله قبل، کسر مبلغ از کیف پول انجام شده بوده یا خیر.
            let contFile=0;



            window.onload = function (e) {
                $('#pansion').val("empty");
            };
            $.switcher('#useCharge');
            $('#wallet_activation').addClass('d-none');   // hide wallet preview



            $('#tablo').hide();
            $('#reservehaa').hide();
            $('#estelam').hide();
            $('#freesubmit').addClass('d-none');

//=============================================== USER CHANGED START ===================================================
            // if user selector changed and new user selected, then get wallet amount for new selected user
            $(document).on('change','#user',function (e){
                let wallet =  $( "#user option:selected" ).attr("data-wallet");
                let userId =  $( "#user option:selected" ).val();
                walletAmount = parseInt(wallet);    //save wallet amount in global variable named `walletAmount`

                $('#userId').val(userId);

                if(wallet > 0) {
                    $('#wallet_activation').removeClass('d-none');
                    $('#wallet_mojoodi').html(`${wallet}تومان `);
                }else {
                    $('#wallet_activation').addClass('d-none');
                }
            });
//=============================================== USER CHANGED END =====================================================


//=============================================== WALLET CHANGE START ==================================================
            $(document).on('change','#useCharge',function (fifi) {
                let finalPriceAmount;

                if ($(this).prop('checked')) {
                    $(this).val(1);

                    // موجودی کیف پول کمتر از مبلغ سفارش باشد
                    if(walletAmount <= parseInt($('#finallyPriceInput').val())) {
                        finalPriceAmount = parseInt(parseInt($('#finallyPriceInput').val()) - walletAmount);
                        $('#finallyPriceInput').val(finalPriceAmount);
                        $('#finallyPrice').text(`${numberWithCommas( finalPriceAmount )} تومان `);
                        $('#walletAmountUsedInput').val(walletAmount);

                        console.log( $('#walletAmountUsedInput').val());
                    } else {  // موجودی کیف پول بیشتر از مبلغ سفارش باشد

                        // کل مبلغ سفارش از کیف پول پرداخت شده
                        $('#walletAmountUsedInput').val(parseInt($('#finallyPriceInput').val()));
                        $('#finallyPriceInput').val(0);
                        $('#finallyPrice').text(`${numberWithCommas( 0 )} تومان `);

                        console.log($('#finallyPriceInput').val());
                        console.log( $('#walletAmountUsedInput').val());

                    }
                    walletDecreased = 1;      // کسر مبلغ از کیف پول انجام شده


                }else if(walletDecreased) {
                    $(this).val(0);
                    finalPriceAmount = parseInt(parseInt($('#finallyPriceInput').val()) + parseInt($('#walletAmountUsedInput').val()) );
                    $('#finallyPriceInput').val(finalPriceAmount);
                    $('#finallyPrice').text(`${numberWithCommas( finalPriceAmount )} تومان `);
                } else if(!walletDecreased) {
                    $(this).val(0);
                    finalPriceAmount = parseInt(parseInt($('#finallyPriceInput').val()));
                    $('#finallyPriceInput').val(finalPriceAmount);
                    $('#finallyPrice').text(`${numberWithCommas( finalPriceAmount )} تومان `);
                }
            });
//=============================================== WALLET CHANGE END ==================================================

//=============================================== PANSION CHANGE START ==================================================
            $('#pansion').on('click change', function (ev) {

                if($(this).val().length != 0) {
                    $('#reservehaa').hide();
                    $('#estelam').hide();
                    $('#calculate').addClass('d-none');
                    $('#freesubmit').addClass('d-none');
                    emptyCalculationInputs();


                    $('#reserve').empty();
                    $('#select2-reserve-container').attr('title', 'نوع رزرو را انتخاب کنید.');
                    $('#select2-reserve-container').html('نوع رزرو را انتخاب کنید.');
                    ////refresh
                    $('#dayTable').empty();
                    $('#titrTarikh').remove();
                    $('#preMonth').remove();
                    $('#nextMonth').remove();
                    $('#miladiTitr').remove();
                    $('#tarikhclicked').remove();
                    $('#raft').val('');
                    $('#bargasht').val('');

                    $.ajax(
                        {
                            url:"{{asset('admin/reservetypes')}}",
                            success: function (data) {
                                $('#reserve').append(`<option value=""></option>`);
                                data.forEach(function (item, index) {
                                    if (item.id!=3){
                                        $('#reserve').append(`<option value="${item.id}">${item.title}</option>`);
                                    }

                                })
                            }
                        }
                    )
                }
            });
//=============================================== PANSION CHANGE END ==================================================

//=============================================== DATE CHANGE START ===================================================
            $("body").on('DOMSubtreeModified', "#to", function() {
                console.log('date changed');
                findTakht();
            });

            $("body").on('DOMSubtreeModified', "#from", function() {
                console.log('date changed');
                findTakht();
            });

            const findTakht = function() {
                if($('#from').html() !== "" &&  $('#to').html() !== "") {
                    //====
                    let pansionId = $('#pansion').find(":selected").val();
                    let reservId = $('#reserve').find(":selected").val();
                    let rafts = $('#raft').val();
                    let bargashts = $('#bargasht').val();

                    console.log(rafts);
                    console.log(bargashts);

                    const [raftYear, raftMonth, raftDay] = rafts.split("-");
                    const [bargashtYear, bargashtMonth, bargashtDay] = bargashts.split("-");

                    let date = {
                        raft: {
                            year: raftYear,
                            month: raftMonth,
                            day: raftDay
                        },
                        bargasht: {
                            year: bargashtYear,
                            month: bargashtMonth,
                            day: bargashtDay
                        }
                    }
                    console.log(date);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        }
                    });
                    $.ajax({
                        url:"{{asset('admin/getemptytakhtpansion')}}" +'/'+pansionId + '/' + reservId,
                        type: "POST",
                        data: JSON.stringify({data:date}),
                        success:function (data) {
                            console.log('data recieved');

                            console.log(data);
                            $('#takht').empty();
                            $('#takht').append(`<option value=""></option>`);

                            if(data != 'notfound') {
                                data.forEach(function (item, index) {
                                    $('#takht').append(`<option price="${item.price}" pricemonth="${item.pricemonth}" value="${item.id}">اتاق ${item.roomnumber} تخت ${item.takhtnumber} </option>`);
                                })
                            } else {
                                $('#takht').append(`<option value="">برای تاریخ انتخاب شده، اتاق خالی یافت نشد!</option>`);
                                toastr.error('برای بازه زمانی مشخص شده، اتاق خالی یافت نشد!');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('error');
                            console.log(xhr);
                        }
                    });
                }
            };
//=============================================== DATE CHANGE END ===================================================
            $(document).on('change','#takht',function (e){
                $('#reservehaa').show();
                $('#estelam').show();
                $('#calculate').removeClass('d-none');
                $('#freesubmit').removeClass('d-none');
                emptyCalculationInputs();   //@todo: should fix bug. when changing pansion or takht or time, useCharge switch should turn off automatically

                /////////////////////////////////order reserved
                let id = $(this).val();
                let $this = $(this);


                /////modalReserve
                $.ajax({
                    url:"{{asset('admin/getorderbytakht')}}/" +id,
                    success:function (data) {
                        $('#reserves4Takht tbody').empty();
                        if ($.trim(data)!='notfound'){
                            console.log(data);
                            data.forEach(function (item,index){
                                $('#reserves4Takht tbody').append(`<tr><td>${index+1}</td>
                                <td>${item.fullName}</td>
                                <td>از تاریخ ${item.jalaliRaft} تا تاریخ ${item.jalaliBargasht}</td>
                                </tr>`)
                            });
                        }
                    }
                });
            });


            $('#mounth').change(function (ev) {
                $('.bg-warning').removeClass('bg-warning');
                $('#from').empty();
                $('#raft').val(null);
                $('#to').empty();
                $('#bargasht').val(null);
                $('#calculate').addClass('d-none');
                $('#freesubmit').addClass('d-none');
                emptyCalculationInputs();
            });
            $(document).on('change','#reserve',function (ev)
            {
                $('#raftTablo').empty();
                $('#bargashtTablo').empty();
                $('#calculate').addClass('d-none');
                $('#freesubmit').addClass('d-none');
                $('#raft').val('');
                $('#bargasht').val('');
                $('#to').empty();
                $('#from').empty();
                $('#takhfif').val('');
                emptyCalculationInputs();

                if ($('#reserve').val()=='1') {
                    $('#totaldaysTitr').show();
                    $('#totaldaysDiv').show();
                    $('#monthsTitr').hide();
                    $('#totalmonthsTitr').hide();
                    $('#divMonth').addClass('d-none');
                }
                if ($('#reserve').val()=='2') {
                    $('#totaldaysTitr').hide();
                    $('#totaldaysDiv').hide();
                    $('#monthsTitr').show();
                    $('#totalmonthsTitr').show();

                    $('#divMonth').removeClass('d-none');
                }

                $(document).on('click', '.tdDay', function (ee) {
                    $('#calculate').addClass('d-none');
                    $('#freesubmit').addClass('d-none');
                    let pansionId=$('#pansion').val();
                    let reservId=$('#reserve').val();
                    let rafts=$('#raft').val();
                    let bargashts=$('#bargasht').val();

                    {{--if (bargashts!=""){--}}
                        {{--    $.ajax({--}}
                        {{--            url:"{{asset('admin/getemptytakhtpansion')}}" +'/'+pansionId +'/'+rafts+'/'+bargashts+'/'+reservId,--}}
                        {{--            success:function (data) {--}}

                        {{--                $('#takht').empty();--}}
                        {{--                $('#takht').append(`<option value=""></option>`);--}}
                        {{--                if (data!='notfound'){--}}
                        {{--                    data.forEach(function (item, index) {--}}
                        {{--                       $('#takht').append(`<option price="${item.price}" pricemonth="${item.pricemonth}" value="${item.id}">اتاق ${item.roomnumber} تخت ${item.takhtnumber} </option>`);--}}
                        {{--                    })--}}
                        {{--                }--}}
                        {{--            }--}}
                        {{--    });--}}

                        {{--}--}}

                    if (rafts!="" && $(this).hasClass('bg-warning')) {
                        $('#raftTablo').html(`<div class="col-6 p-2">تاریخ شروع:</div>
                                           <div class="col-6 p-2">${$(this).attr('tarikh')}</div>`);

                        if ($('#reserve').val() == '2') {
                            $('#bargashtTablo').html(`<div class="col-6 p-2">تاریخ پایان:</div>
                                                    <div class="col-6 p-2">${new JDate(new Date($('#bargasht').val())).format('YYYY/M/D')}</div>`);
                        }
                    }

                    if (bargashts!="" && $(this).hasClass('bg-success')) {
                        $('#bargashtTablo').html(`<div class="col-6 p-2">تاریخ پایان:</div>
                                                <div class="col-6 p-2">${new JDate(new Date($('#bargasht').val())).format('YYYY/M/D')}</div>`);
                    }

                });
            })

            $(document).on('click', '.tdDay', function (er) {
                console.log('tdDay clicked')
                if ($('#reserve').val()=='1') {
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
                        // totalPriceAmount = totalPrice;
                        $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                        $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                        $("#totaldays").html(`${countDays} روز`);
                        $("#takPrice").html(`${numberWithCommas($('#price').val()).substr(0, numberWithCommas($('#price').val()).length - 3)} تومان`);
                        $("#totalPriceInput").val(totalPrice);
                        $("#finallyPriceInput").val(totalPrice);
                        $('#calculate').removeClass('d-none');
                        $('#freesubmit').removeClass('d-none');
                    }
                    if ($(this).hasClass('bg-warning')) {
                        $('#calculate').addClass('d-none');
                        $('#freesubmit').addClass('d-none');
                    }
                    if ($(this).hasClass('bg-success')) {
                        $('#calculate').addClass('d-none');
                        $('#freesubmit').addClass('d-none');
                    }
                }
                if ($('#reserve').val()=='2') {

                    if ($('#mounth').val()!=0 && $('#raft').val()!='') {
                        let raft = new Date($('#raft').val()).getTime();
                        let bargasht = new Date($('#bargasht').val()).getTime();
                        let diff = bargasht - raft;
                        const oneDay = 1000 * 60 * 60 * 24 * 30;
                        let countDays = Math.round(diff / oneDay);
                        // $('#mounth').val(countDays);
                        let totalPrice = parseInt($('#mounth').val()) * parseInt($('#pricemonth').val());
                        // totalPriceAmount = totalPrice;
                        // console.log(totalPriceAmount)

                        $("#totalPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                        $("#finallyPrice").html(`${numberWithCommas(parseFloat(totalPrice))} تومان`);
                        $("#totaldays").html(`${$('#mounth').val()} ماه`);
                        $("#takPrice").html(`${numberWithCommas($('#pricemonth').val().substr(0,$('#pricemonth').val().length-3))} تومان`);
                        $("#totalPriceInput").val(totalPrice);
                        $("#finallyPriceInput").val(numberWithCommas(totalPrice));

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


                        if ($(this).hasClass('bg-warning')) {
                            $('#calculate').removeClass('d-none');
                            $('#freesubmit').removeClass('d-none');
                        }
                    }
                    else {

                        toastr.warning('اول تعداد ماه را انتخاب کنید.')
                    }
                }

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
                                    toastr.error('بروز خطا');
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
                e.stopImmediatePropagation();

                if ($('#paytype').val()=='n'){

                    $('#countMonth').val('');    //qestcount be null

                    $('.naghdi').each(function (index) {
                        let mablaghesh = $(this).children('.col-10').children('.col-lg-6').children('.naqdtypeMablagh').val();
                        if (index==0 && mablaghesh.length==0  &&  $('#finallyPriceInput').val()!= 0 ){
                            e.preventDefault();
                            toastr.warning('مبلغ پرداختی را تکمیل نمایید.');
                        }

                        if (mablaghesh.length==0 && index!=0){
                            $(this).remove();
                        }
                    });

                    if ($('.naqdtypeMablagh').length!=contFile &&  $('#finallyPriceInput').val() != 0){
                        e.preventDefault();
                        toastr.warning('تصویر فیش واریزی ثبت نشده است.')
                    }

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
                    if (totalType != $('#finallyPriceInput').val()) {
                        e.preventDefault();
                        toastr.error('مجموع پرداختی ها با مبلغ نهایی برابر نمی باشد.');
                    }

                }else if ($('#paytype').val()=='q'){

                    $('.jalal').each(function (index) {
                        if ($(`#qesttarikh_${index}`)==""){
                            e.preventDefault();
                            toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');
                        } else {
                            let dateValue = $(`#qesttarikh_${index}`).val();
                            let clicktarikh = dateValue.split('/');
                            let z = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                            let miladi = z[0] + "-" + z[1] + "-" + z[2];
                            console.log(miladi);
                            $(`#qesttarikh_${index}`).val(miladi);
                        }
                    });

                    // چک مجموع مبلغ قسط ها برابر مبلغ کل فاکتور باشد
                    let sum = 0;
                    let countMonth = $('#countMonth').val();   // تعداد نوبت قسط
                    console.log(countMonth);
                    for (let i = 0;i<countMonth;i++){
                        console.log('qest number: ' + i);
                        console.log($(`#qestmablagh_${i}`).val());
                        sum = parseInt($(`#qestmablagh_${i}`).val()) + parseInt(sum);
                    }

                    console.log('sum of all qests: ' + sum);
                    console.log('total price: ' + totalPriceForReservation);
                    let totalPriceForReservation = $('#finallyPriceInput').val();    // مبلغ نهایی قابل پرداخت

                    if(sum != totalPriceForReservation) {
                        toastr.error('مجموع مبالغ نوبت ها باید برابر مبلغ نهایی اعلام شده باشد.');
                    }
                }

                //=======
                $('#takhfif').val($('#takhfif').val().replaceAll(',', ""));


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
                if ($('#user').val() == '') {
                    e.preventDefault();
                    toastr.error('انتخاب مشترک الزامیست.');
                }

            });

            $(document).on('change','input[name="fish[]"]',function (echange) {
                contFile=contFile+1;
                if (echange.target.files.length != 0) {

                    $(this).siblings('span').remove();
                    $(this).after(`<span><i class="fa fa-check text-success"></i> </span>`)
                }
            });
            let ezaaf = 1;

            $(document).on('click','.plusNaqd',function (echange) {

                $('.naghdi').last().after(`<div class="naghdi row col-11 py-4 my-4" style="border-bottom: 1px solid #aaaaaa">
                                            <div class="col-1 text-center mt-3 adad p-0">
                                                <i class="fa fa-credit-card"></i>
                                            </div>
                                            <div class="col-10 row">
                                                <div class="col-lg-6 mt-2 px-1">
                                                    <select class="form-control naqdtypeTitle" name="naqdtypeTitle[]" placeholder="نوع پرداخت">

                                                    </select>
                                                </div>
                                            <div class="col-lg-6 mt-2 px-1">
                                                    <input
                                                    class="form-control seprator justnumber naqdtypeMablagh"
                                                    name="naqdtypeMablagh[]" placeholder="مبلغ (به تومان)">
                                            </div>
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

                $('.seprator').keyup(function (e) {
                    let value = $(this).val();
                    separateNum(value, $(this)[0])
                });
            });

            $('.removeNaqd').click(function (ew) {
                $(this).parents('.naghdi').remove();
            });
        });
//=============================================== CUSTOM FUNCTIONS START =================================================
        const emptyCalculationInputs = function() {
           document.getElementById("useCharge").checked = false;
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

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
//=============================================== CUSTOM FUNCTIONS END ===================================================


    </script>
@endsection
@section('css')


    #timeTable {
    height: 448.719px;
    background-color: white;
    }
    #mainTable{
    height: 340px;
    background-color: white;
    }
    .select2 {
    width: 100% !important;
    }
    @media (min-width: 992px) {
    .container {
    max-width: 992px !important;
    }
    .mr-140 {
    margin-right: 140px !important;
    }
    }
    @media (min-width: 1200px) {
    .container {
    max-width: 1200px !important;
    }
    }


    @media (min-width: 1600px) {
    .container {
    max-width: 1600px !important;
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
@section('content')
{{--    --}}
{{--    <section class="bg-white position-fixed container" style="top: 190px;z-index:1000;left: 5px;width: 250px;  box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;--}}
{{--    border-radius: 6px;" id="tablo">--}}
{{--        <div class="row " id="raftTablo" style="border-bottom: 1px solid #aaaaaa">--}}
{{--        </div>--}}
{{--        <div class="row " id="bargashtTablo" style="border-bottom: 1px solid #aaaaaa">--}}
{{--        </div>--}}
{{--    </section>--}}


    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">رزرو تخت</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Form-->
    <form class="h-100 mb-5" method="post" action="{{route('order.store')}}" id="submit" enctype="multipart/form-data">
        @csrf

        <input id="tarikh" name="tarikh" class="d-none" value="">
        <input id="raft" name="raft" class="d-none" value="">
        <input id="bargasht" name="bargasht" class="d-none" value="">
        <input id="days" name="days" class="d-none" value="">
        <input id="price" name="price" class="d-none" value="">
        <input id="pricemonth" name="pricemonth" class="d-none" value="">
        <input id="perMonth" name="perMonth" class="d-none" value="">
        <input id="userId" name="user_id" class="d-none" value="">
        <div class="container card mx-auto h-100" style="margin-top: 330px;margin-bottom:100px;background-color: gainsboro;min-height: 1200px">
            <div class="row mx-auto">
                <div class="col-lg-8 col-12 row mx-auto h-100">


                    <div class="col-12 row mx-auto" style="
    height: 573.219px;
">

                        <div class="col-12 col-lg-6 row justify-content-between px-5">
                            <div class="col-12 mt-5 row">
                                <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-radius: 5px;
    background-color: beige;">
                                    <span class="form-label mb-2 position-relative" style="top: 24%">مشترک</span>
                                </div>
                                <div class="col-9 p-0 ">
                                    <select name="user_id" class="select2 form-control" id="user">
                                        <option value="">مشترک را انتخاب کنبد.</option>
                                        @if($users!='notfound')
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}" data-wallet="{{ $user['wallet_mojoodi'] }}">{{$user->name}} {{$user->family}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <span>
                                  <a href="{{route('createnewuser')}}" class="btn btn-secondary">افزودن کاربر</a>
                                </span>

                            </div>
                            <div class="col-12 mt-3 row">

                                <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="border: 1px solid;height: 38px;border: 1px solid #aaa!important;background-color: beige;">
                                    <span class="form-label mb-2 position-relative" style="top: 24%">خوابگاه</span>
                                </div>
                                <div class="col-9 p-0 ">
                                    <select class="select2 form-control" id="pansion">
                                        <option value="">خوابگاه را انتخاب کنید.</option>
                                        @if($pansions!='notfound')
                                            @foreach($pansions as $pansion)
                                                <option value="{{$pansion->id}}">{{$pansion->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-3 row">
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

                                    </select>

                                </div>
                                <div class="col-12 mb-1 pt-2" style="background: 	rgb(255, 193, 7,0.6)!important;border-radius: 5px" id="fromDate">از تاریخ: <span id="from"></span></div>
                                <div class="col-12 pt-2" style="background:rgb(92, 184, 92,0.6);border-radius: 5px" id="toDate">تا تاریخ: <span id="to"></span></div>
                            </div>
                            <div class="col-12 mt-5 d-none row" id="divMonth">
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
                            <div class="col-12 mt-3 row">
                                <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-radius: 5px;
    background-color: beige;">
                                    <span class="form-label mb-2 position-relative" style="top: 24%">تخت</span>
                                </div>
                                <div class="col-9 p-0 ">
                                    <select name="takht_id" class="select2 form-control" id="takht">
                                        <option value="">تخت را انتخاب کنید.</option>
                                    </select>
                                    <span style="cursor: pointer" id="reservehaa" class="btn btn-info mt-3"  data-toggle="modal" data-target="#reservesModal">
                                                                    تاریخچه تخت
                                                                </span>
                                    <span style="cursor: pointer" id="estelam" class="btn btn-secondary mt-3">
                                                                    استعلام
                                                                </span>
                                </div>
                            </div>


                        </div>

                        <div class="col-12 col-lg-6 mt-5 row p-0  mx-auto" id="timeTable"
                             style="border: none;border-radius: 10px;">

                            <div class="col-12 p-0">
                                <table id="mainTable" class="w-100 mb-0">
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
                <div class="col-lg-4 mb-5 mt-5 row pl-5 col-12">
                    <div class="col-12 text-center">

                        <div class="col-12 text-center mt-5">
                            <h3>محاسبه کرایه تخت</h3>
                            <div class="row d-none" id="calculate" style="font-size: 15px;">
                                <div class="col-6 mt-3 pt-3 d-none"
                                     style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;"
                                     id="roozaneTitr">مبلغ روزانه:
                                </div>
                                <div class="col-6 mt-3 pt-3 d-none"
                                     style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;"
                                     id="mahaneTitr">مبلغ ماهانه:
                                </div>
                                <div class="col-6 mt-3 pt-3" style="border-top: 1px solid #bdc4c4;text-align: right;font-size: 15px;">
                                    <h5 id="takPrice"></h5></div>
                                <div class="col-6 mt-3 pt-3"
                                     style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;"
                                     id="totaldaysTitr">تعداد روز:
                                </div>
                                <div class="col-6 mt-3 pt-3"
                                     style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;"
                                     id="monthsTitr">تعداد ماه:
                                </div>
                                <div class="col-6 mt-3 pt-3"
                                     style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;"
                                     id="totalmonthsTitr">
                                </div>
                                <div class="col-6 mt-3 pt-3" id="totaldaysDiv" style="border-top: 1px solid #bdc4c4;text-align: right;">
                                    <h5 id="totaldays"></h5></div>
                                <div class="col-6 mt-3 pt-3"
                                     style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;"
                                     id="totalpriceTitr">مبلغ کل:
                                </div>
                                <div class="col-6 mt-3 pt-3" style="border-top: 1px solid #bdc4c4;text-align: right;">
                                    <h5 id="totalPrice"></h5></div>
                                <div class="col-4 mt-3 pt-3"
                                     style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;line-height: 33px;"
                                     id="takhfifTitr"> تخفیف:
                                </div>

                                <div class="col-6 mt-3 pt-3"   style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: left;padding-left:1em;"><input class="form-control seprator justnumber" name="takhfif" id="takhfif" style="width:80%;display: inline;padding:.27rem 0.75rem;"></div>

                                <div class="col-2 mt-3 pt-3"   style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;padding-right:2px;"><span class="btn btn-secondary" id="emaltakhfif">اعمال</span>
                                </div>

                                {{-- wallet --}}
                                {{-- موجودی مثبت کیف پول یعنی بستانکار بودن کاربر--}}
                                <div class="input-group" id="wallet_activation">
                                    <div class="col-6 mt-3 pt-3"
                                         style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="walletTitr">
                                        استفاده از کیف پول
                                    </div>
                                    <div class="col-6 mt-3 pt-3"
                                         style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                         id="sd">
                                        <input type="checkbox" id="useCharge" value="0" name="charge">
                                        <br>
                                        <div style="font-size:12px;color: #aaaaaa" id="wallet_mojoodi"></div>
                                    </div>
                                </div>
                                {{--  --}}

                                <div class="col-6 mt-3 pt-3"
                                     style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;"
                                     id="finallypriceTitr">مبلغ نهایی:
                                </div>
                                <div class="col-6 mt-3 pt-3" style="border-top: 1px solid #bdc4c4;text-align: right;">
                                    <h5 id="finallyPrice"></h5>
                                </div>
                                <div class="col-6 mt-3 pt-3"
                                     style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;line-height: 33px;"
                                     id="paytypeTitr">نوع پرداخت:
                                </div>
                                <div class="col-6 mt-3 pt-3" style="border-top: 1px solid #bdc4c4;text-align: right;">
                                    <select name="paytype" id="paytype" class="select2 form-control">
                                        <option value="n">نقدی</option>
                                        <option value="q">اقساطی</option>
                                    </select>
                                </div>



                                <div class="col-8 mt-3 pt-3 row d-none"
                                     style="border-top: 1px solid #bdc4c4;text-align: right;" id="countMonthTitr">
                                </div>
                                <div class="col-12 mt-3 pt-3 d-none"
                                     style="font-size: 15px;border-top: 1px solid #bdc4c4;text-align: right;"
                                     id="tarikhMonthTitr">تعیین تاریخ نوبت:
                                </div>
                                <div class="col-12 mt-3 pt-3 row mb-3" style="text-align: right;" id="tarikhMonth"></div>

                                {{--   پرداخت نقد  --}}
                                <div class="col-12 mt-3 pt-3 row"
                                     style="font-size: 18px;border-top: 1px solid #bdc4c4;text-align: right;"
                                     id="naqdtype">
                                    <div class="col-12">جزییات پرداخت:</div>
                                    <div class="col-1 text-center mt-3">
                                        <span class="btn  mt-1 p-0 plusNaqd" style="cursor: pointer"><i
                                                class="fa fa-plus"></i> </span>
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
                                            <div class="col-lg-6 mt-2 px-1">
                                                <input
                                                    class="form-control seprator justnumber naqdtypeMablagh"
                                                    name="naqdtypeMablagh[]" placeholder="مبلغ (به تومان)">
                                            </div>
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

                            <input name="totalprice" class="d-none" id="totalPriceInput">
                            <input name="finallyprice" class="d-none" id="finallyPriceInput">
                            <input name="finallytakhfif" class="d-none" id="finallyTakhfifInput">
                            <input name="walletamountused" class="d-none" id="walletAmountUsedInput">
                        </div>
                        <div class="col-12 mb-5">
                            <button type="submit" class="w-50 btn btn-success pt-2 pb-2" id="freesubmit">ثبت</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Reserve Modal -->
    <div class="modal fade" id="reservesModal" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <table class="table" id="reserves4Takht">
                            <thead>
                            <tr>
                                <th>لیست</th>
                                <th>فرد رزرو کننده</th>
                                <th>تاریخ های رزرو شده</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyReserves">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
