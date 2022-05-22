@extends('admin.master.home')


@section('js')
    <script src="https://rawgit.com/abdennour/hijri-date/master/cdn/hijri-date-latest.js" type="text/javascript" ></script>
    <script src="{{asset('admin/js/jdate.min.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('admin/js/taghvimSCOOB.js')}}" type="text/javascript" charset="utf-8"></script>
{{--    <script src="{{asset('admin/js/font-awesome.min.css')}}" type="text/javascript" charset="utf-8"></script>--}}
    <script>

        //========================================= user selected from dropdown start ===============
        $('#user').change(function (ev) {
            // $('.table').show();
            userId = $(this).val();    //user id
            console.log(userId);

            // دریافت لیست سفارش های مشتری انتخاب شده
            $.ajax({
                // get all orders related to selected user
                cache: false,
                type: "GET",
                url: "/admin/getallactiveorder/" +  userId,
                success: function(data)
                {
                    console.log(JSON.parse(data));

                    $.each(JSON.parse(data), function(key, value) {

                        $('#tamdidTable tbody').append(`
                                                          <tr style="font-size:14px;">
                                                             <td scope="row">${parseInt(key)+1}</td>
                                                             <td>${value.takht_info}</td>
                                                             <td>${value.raft}</td>
                                                             <td>${value.bargasht}</td>
                                                             <td>${value.order_finally_price}</td>
                                                             <td>${value.paid_amount}</td>
                                                             <td>${value.maande_amount}</td>
                                                             <td>${value.total_mali_status}</td>
                                                             <td id="paymentlist" data-orderid="${value.id}"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#paymentlistmodal">اطلاعات پرداخت</button></td>
                                                             <td class="tamdidrequest" data-orderid="${value.id}"><button type="button" class="btn btn-primary btn-sm">درخواست تمدید</button></td>
                                                          </tr>
                                                     `);

                        $.each(data.allpaytypes, function(key, value) {
                            $('.paymentlistmodaltable tbody').append(`
                                                                        <tr style="font-size:14px;">
                                                                             <td scope="row">${parseInt(key)+1}</td>
                                                                             <td>${value[key]}</td>
                                                                            <td id="paymentTypes_${value[key]}"></td>
                                                                        </tr>
                                                                    `);
                        });

                        $.each(value, function(key, val) {
                            $(`.paymentlistmodaltable tbody #paymentTypes_${key}`).html(`
                                                                        ${key} : ${val}
                                                                    `);
                        });

                    });

                    $('#tamdidy').removeClass('d-none');
                },
                error: function (request, status, error)
                {
                    console.log(request.responseText);
                }
            });
        });
        //========================================= user selected from dropdown end ===============


{{--        $(document).ready(function () {--}}

{{--            let jdateRaft =new JDate(new Date('{!! $order->bargasht !!}'));--}}
{{--            let beShamsiKamels = new JDate(new Date('{!! $order->bargasht !!}')).format('dddd DD MMMM YYYY');--}}

{{--            $('#raft').val("{!! $order->bargasht !!}");--}}


{{--            $('#price').val('{!! $order->takht->price !!}');--}}
{{--            $('.hrefbtn').attr('href', "{{route('order.create')}}");--}}

{{--            @if($order->reservetype_id=='2')--}}
{{--            let addpubcheck = [];--}}
{{--            let tarikhMonth='';--}}
{{--            if (jdateRaft.date[1]=='11'){--}}
{{--                tarikhMonth = $('#mounth').val() * 2505600000;--}}
{{--            }--}}
{{--            else if (jdateRaft.date[1]=='1' || jdateRaft.date[1]=='2' || jdateRaft.date[1]=='3' || jdateRaft.date[1]=='4' || jdateRaft.date[1]=='5' || jdateRaft.date[1]=='6' ){--}}
{{--                tarikhMonth = {!! $order->month !!} * 2678400000;--}}
{{--                if ($('.bg-warning').attr('month')=='6' && $('.bg-warning').text()=='31'){--}}
{{--                    tarikhMonth = ${!! $order->month !!} * 2505600000;--}}
{{--                }--}}
{{--            }--}}
{{--            else {--}}
{{--                tarikhMonth = {!! $order->month !!} * 2592000000;--}}
{{--            }--}}
{{--            let monthBargashtUnix = new Date($('#raft').val()).getTime() + tarikhMonth;--}}
{{--            let monthBargasht = new Date(monthBargashtUnix);--}}
{{--            let raftobiy = new JDate(new Date($('#raft').val()));--}}
{{--            let jdate22 = new JDate(new Date(monthBargasht.getTime()));--}}
{{--            let bargashtAzMah="";--}}
{{--            if ((raftobiy.date[1]=='6' && raftobiy.date[2]=="31") || (raftobiy.date[1]=='5' && raftobiy.date[2]=="31") || (raftobiy.date[1]=='4' && raftobiy.date[2]=="31") || (raftobiy.date[1]=='3' && raftobiy.date[2]=="31") || (raftobiy.date[1]=='2' && raftobiy.date[2]=="31")){--}}
{{--                bargashtAzMah = new JDate(jdate22.date[0], jdate22.date[1], '30');--}}
{{--            }--}}
{{--            else {--}}
{{--                bargashtAzMah = new JDate(jdate22.date[0], jdate22.date[1], raftobiy.date[2]);--}}
{{--            }--}}
{{--            let azmahmiladi = JalaliDate.jalaliToGregorian(bargashtAzMah.date[0], bargashtAzMah.date[1], bargashtAzMah.date[2]);--}}
{{--            let bargashrazmiladi = azmahmiladi[0] + "-" + azmahmiladi[1] + "-" + azmahmiladi[2];--}}
{{--            let beShamsiKamelBargasht = bargashtAzMah.format('YYYY/MM/DD');--}}
{{--            $('#newKhoruj').text(beShamsiKamelBargasht);--}}


{{--            $("#submit").submit(function (e) {--}}
{{--                if (totalType != $('#finallyPriceInput').val().replaceAll(",", "")) {--}}
{{--                    e.preventDefault();--}}
{{--                    toastr.error('مجموع پرداختی ها با مبلغ نهایی برابر نمی باشد.');--}}
{{--                }--}}

{{--                if ($('#paytype').val()=='q'){--}}

{{--                    if ($('.jalal').length==0){--}}
{{--                        e.preventDefault();--}}
{{--                        toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');--}}
{{--                    }--}}
{{--                    else {--}}
{{--                        $('.jalal').each(function (index) {--}}

{{--                            if ($(this).val()==""){--}}
{{--                                e.preventDefault();--}}
{{--                                toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');--}}
{{--                            }--}}
{{--                            else {--}}


{{--                            }--}}
{{--                        });--}}
{{--                    }--}}
{{--                    let clicktarikh=$(this).attr('tarikh').split('/');--}}
{{--                    clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);--}}
{{--                    let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];--}}
{{--                }--}}

{{--            });--}}
{{--            $('#bargasht').val(bargashrazmiladi);--}}


{{--            @else--}}
{{--            let longDays=60*60*24*1000*{{$order->days}};--}}
{{--            let dayBargashtUnix =new Date($('#raft').val()).getTime()+longDays;--}}
{{--            let bargashtDays = new JDate(new Date(dayBargashtUnix));--}}
{{--            let bargashtDaysMiladi = JalaliDate.jalaliToGregorian(bargashtDays.date[0], bargashtDays.date[1], bargashtDays.date[2]);--}}
{{--            let azMiladi = bargashtDaysMiladi[0] + "-" + bargashtDaysMiladi[1] + "-" + bargashtDaysMiladi[2];--}}
{{--            $('#newKhoruj').text(bargashtDays.format('YYYY/MM/DD'));--}}
{{--            $('#bargasht').val(azMiladi);--}}
{{--            @endif--}}

{{--            $.ajax({--}}
{{--                url:"{{asset('admin/fullfortamdid')}}" +'/'+ $('#raft').val()+'/'+ $('#bargasht').val() + '/' + "{{$order->takht_id}}",--}}
{{--                success:function (data){--}}
{{--                    if (data=='found'){--}}
{{--                        $('#payment').empty();--}}

{{--                        $('#payment').append('<h4 class="alert-danger p-2">به علت تکمیل ظرفیت در تاریخ تمدید مجدد، امکان تمدید نمی باشد.</h4>');--}}
{{--                    }--}}
{{--                }--}}
{{--            })--}}

{{--        })--}}
    </script>
@endsection
<style>

    #timeTable{
        height: 448.719px;
    }

    .select2 {
        width: 100% !important;
    }

    @media (min-width: 992px) {
        .taheHeight {
            height: 565px;
        }
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


    @media (min-width: 1500px) {
        .container {
            max-width: 1500px !important;
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
    .select2-container{
        text-align: right;
    }
</style>


{{--   check if user is in personel group or in moshtari group   --}}
@if($ismoshtari && !$ispersonel)  {{-- user is moshtari and is not personel --}}

    @if(\Illuminate\Support\Facades\Auth::id() == $userid)

        @if($maande > 0)
            {{-- check user statusmali is bedehkar or bestankar  --}}
            {{-- if is bedehkar, then  do not allow reservation tamdid     --}}
            @section('content')
                <div class="container card mt-5">
                    <h4 class="alert-danger p-2" style="margin-top: 200px">رزرو های قبلی هنوز تسویه نشده اند.</h4>
                </div>
            @endsection

        @else

            @if($allactiveordersforthisspecificuser)

                {{--        @if($user->wallet->bedehkar>0)--}}
                @if($maande>0)

                    @section('content')
                        <div class="container card mt-5">
                            <h4 class="alert-danger p-2" style="margin-top: 200px">رزرو های قبلی هنوز تسویه نشده اند.</h4>
                        </div>
                    @endsection

                @else

                    @section('content')

                            <!-- START: Breadcrumbs-->
                            <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
                                <div class="col-12  align-self-center">
                                    <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                                                <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                                                <li class="breadcrumb-item" style="background: #d0e7ff"><a class="text-danger" href="{{route('tamdidform')}}">تمدید رزرو</a></li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Breadcrumbs-->

                            <!-- tamdid table-->
                            <div class="container card border-top row  tamdidy mb-4 d-none" style="background-color: gainsboro;margin: 5em auto;">
                                <table class="table table-striped" id="tamdidTable">
                                    <thead>
                                        <tr style="font-size: 12px;font-weight: bold;">
                                            <th>تخت</th>
                                            <th>تاریخ شروع</th>
                                            <th>تاریخ پایان</th>
                                            <th>مبلغ کل</th>
                                            <th>بدهکار</th>
                                            <th>وضعیت پرداخت</th>
                                            <th>جزییات پرداخت</th>
                                            <th>درخواست تمدید</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <!-- START: Form-->
                            <form method="post" action="{{route('customstore')}}" id="submit" enctype="multipart/form-data">
                                @csrf
                                <input id="raft" name="raft" class="d-none" value="{{$order->bargasht}}">
                                <input id="bargasht" name="bargasht" class="d-none" value="">
                                <input id="mounth" name="mounth" class="d-none" value="">
                                <input id="reservetype" name="reservetype" class="d-none" value="{{$order->reservetype_id}}">
                                <input id="takht_id" name="takht_id" class="d-none" value="{{$order->takht_id}}">
                                <input id="user_id" name="user_id" class="d-none" value="{{$order->user_id}}">
                                <input id="days" name="days" class="d-none" value="{{$order->days}}">
                                <input id="mounth" name="mounth" class="d-none" value="{{$order->month}}">
                                <input id="permounth" name="permounth" class="d-none" value="{{$order->permounth}}">
                            </form>


                            {{-- مدال مربوط به اطلاعات پرداخت --}}
                            <div class="modal fade" id="paymentlistmodal" tabindex="-1" role="dialog" aria-labelledby="paymentlistmodal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="paymentlistmodal">لیست پرداختی های این سفارش</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="paymentlistmodalbody">
                                            <table class="table table-striped paymentlistmodaltable">
                                                <thead>
                                                <tr style="font-size: 12px;font-weight: bold;">
                                                    <th scope="col">شماره</th>
                                                    <th scope="col">روش پرداخت</th>
                                                    <th scope="col">مبلغ پرداخت شده</th>
                                                    <th scope="col">تاریخ پرداخت</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>

                                            <div class="loader d-none"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    @endsection
                @endif

            @else
                @section('content')
                    <!-- START: Breadcrumbs-->
                    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
                        <div class="col-12  align-self-center">
                            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                                        <li class="breadcrumb-item" style="background: #d0e7ff"><a class="text-danger" href="{{route('movereserve')}}">تمدید رزرو</a></li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </div>
                    <!-- END: Breadcrumbs-->
                    <div class="container card" style="margin-top: 330px;margin-bottom:100px;background-color: gainsboro">
                        <h4 class="alert-danger p-2">رزرو فعالی برای تمدید وجود ندارد</h4>
                    </div>
                @endsection
            @endif

        @endif

    @else {{-- if requested user is not who is authenticated, then do not allow to see the content --}}

        @section('content')
            <!-- START: Breadcrumbs-->
            <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
                <div class="col-12  align-self-center">
                    <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                                <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                                <li class="breadcrumb-item" style="background: #d0e7ff"><a class="text-danger" href="{{route('movereserve')}}">تمدید رزرو</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- END: Breadcrumbs-->
            <div class="container card" style="margin-top: 330px;margin-bottom:100px;background-color: gainsboro">
                <h4 class="alert-danger p-2">شما اجازه دسترسی به این آدرس را ندارید.</h4>
            </div>
        @endsection

    @endif
@elseif($ispersonel)       {{-- personel user --}}

    @section('content')


        <div class="container card mb-5" style="margin-top: 330px;background-color: gainsboro;">
            <div class="row justify-content-between mx-3">
                <div class="col-12 col-lg-3 mb-5 mt-5 row">
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
                            <option value="">مشترک را انتخاب کنید.</option>
                            @if($allusers!='notfound')
                                @foreach($allusers as $user)
                                    <option value="{{$user->id}}">{{$user->name}} {{$user->family}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <!-- tamdid table-->
        <div class="container card border-top row  mb-4 d-none" style="background-color: gainsboro;margin: 5em auto;" id="tamdidy">
            <table class="table table-striped" id="tamdidTable">
                <thead>
                    <tr style="font-size: 12px;font-weight: bold;">
                        <th>شماره</th>
                        <th>اطلاعات تخت</th>
                        <th>تاریخ شروع</th>
                        <th>تاریخ پایان</th>
                        <th>مبلغ کل</th>
                        <th>هزینه پرداخت شده</th>
                        <th>مبلغ مانده</th>
                        <th>وضعیت مالی سفارش</th>
                        <th>جزییات پرداخت</th>
                        <th>درخواست تمدید</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <!-- START: Form-->
        <form method="post" action="{{route('customstore')}}" id="submit" enctype="multipart/form-data">
            @csrf

        </form>


        {{-- مدال مربوط به اطلاعات پرداخت --}}
        <div class="modal fade" id="paymentlistmodal" tabindex="-1" role="dialog" aria-labelledby="paymentlistmodal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentlistmodal">لیست پرداختی های این سفارش</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="paymentlistmodalbody">
                        <table class="table table-striped paymentlistmodaltable">
                            <thead>
                                <tr style="font-size: 12px;font-weight: bold;">
                                    <th scope="col">شماره</th>
                                    <th scope="col">روش پرداخت</th>
                                    <th scope="col">مبلغ پرداخت شده</th>
                                    <th scope="col">تاریخ پرداخت</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                        <div class="loader d-none"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>


    @endsection


@endif


