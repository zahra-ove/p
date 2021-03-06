{{--@extends('admin.master.home')--}}
{{--<meta name="csrf_token" content="{{csrf_token()}}">--}}
@if(\Illuminate\Support\Facades\Auth::id()==$user->id)
    @if($order!='notfound')
        @section('js')
            <script src="https://rawgit.com/abdennour/hijri-date/master/cdn/hijri-date-latest.js" type="text/javascript" ></script>
            <script src="{{asset('admin/js/jdate.min.js')}}" type="text/javascript" charset="utf-8"></script>
            <script src="{{asset('admin/js/taghvimSCOOB.js')}}" type="text/javascript" charset="utf-8"></script>
            <script>

                $(document).ready(function () {

                    let jdateRaft =new JDate(new Date('{!! $order->bargasht !!}'));
                    let beShamsiKamels = new JDate(new Date('{!! $order->bargasht !!}')).format('dddd DD MMMM YYYY');

                    $('#raft').val("{!! $order->bargasht !!}");


                    $('#price').val('{!! $order->takht->price !!}');
                    $('.hrefbtn').attr('href', "{{route('order.create')}}");

                    @if($order->reservetype_id=='2')
                        let addpubcheck = [];
                        let tarikhMonth='';
                        if (jdateRaft.date[1]=='11'){
                            tarikhMonth = $('#mounth').val() * 2505600000;
                        }
                        else if (jdateRaft.date[1]=='1' || jdateRaft.date[1]=='2' || jdateRaft.date[1]=='3' || jdateRaft.date[1]=='4' || jdateRaft.date[1]=='5' || jdateRaft.date[1]=='6' ){
                            tarikhMonth = {!! $order->month !!} * 2678400000;
                            if ($('.bg-warning').attr('month')=='6' && $('.bg-warning').text()=='31'){
                                tarikhMonth = ${!! $order->month !!} * 2505600000;
                            }
                        }
                        else {
                            tarikhMonth = {!! $order->month !!} * 2592000000;
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
                        let beShamsiKamelBargasht = bargashtAzMah.format('YYYY/MM/DD');
                        $('#newKhoruj').text(beShamsiKamelBargasht);


                        $("#submit").submit(function (e) {
                            if (totalType != $('#finallyPriceInput').val().replaceAll(",", "")) {
                                e.preventDefault();
                                toastr.error('?????????? ?????????????? ???? ???? ???????? ?????????? ?????????? ?????? ????????.');
                            }

                            if ($('#paytype').val()=='q'){

                                if ($('.jalal').length==0){
                                    e.preventDefault();
                                    toastr.error('???????? ?????????? ???????? ?? ?????????? ?????? ???? ???????? ??????.');
                                }
                                else {
                                    $('.jalal').each(function (index) {

                                        if ($(this).val()==""){
                                            e.preventDefault();
                                            toastr.error('???????? ?????????? ???????? ?? ?????????? ?????? ???? ???????? ??????.');
                                        }
                                        else {


                                        }
                                    });
                                }
                                let clicktarikh=$(this).attr('tarikh').split('/');
                                clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                            }

                        });
                        $('#bargasht').val(bargashrazmiladi);


                    @else
                        let longDays=60*60*24*1000*{{$order->days}};
                        let dayBargashtUnix =new Date($('#raft').val()).getTime()+longDays;
                        let bargashtDays = new JDate(new Date(dayBargashtUnix));
                        let bargashtDaysMiladi = JalaliDate.jalaliToGregorian(bargashtDays.date[0], bargashtDays.date[1], bargashtDays.date[2]);
                        let azMiladi = bargashtDaysMiladi[0] + "-" + bargashtDaysMiladi[1] + "-" + bargashtDaysMiladi[2];
                        $('#newKhoruj').text(bargashtDays.format('YYYY/MM/DD'));
                        $('#bargasht').val(azMiladi);
                    @endif

                    $.ajax({
                        url:"{{asset('admin/fullfortamdid')}}" +'/'+ $('#raft').val()+'/'+ $('#bargasht').val() + '/' + "{{$order->takht_id}}",
                        success:function (data){
                            if (data=='found'){
                                $('#payment').empty();

                                $('#payment').append('<h4 class="alert-danger p-2">???? ?????? ?????????? ?????????? ???? ?????????? ?????????? ?????????? ?????????? ?????????? ?????? ????????.</h4>');
                            }
                        }
                    })

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

{{--        @if($user->wallet->bedehkar>0)--}}
        @if($maande>0)
            @section('content')
                <div class="container card mt-5">
                    <h4 class="alert-danger p-2" style="margin-top: 200px">???????? ?????? ???????? ???????? ?????????? ???????? ??????.</h4>
                </div>
            @endsection
        @else
            @section('content')
                @if($order->status_order_id!='4')
                    <!-- START: Breadcrumbs-->
                    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
                        <div class="col-12  align-self-center">
                            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">??????????????</a></li>
                                        <li class="breadcrumb-item" style="background: #d0e7ff"><a class="text-danger" href="{{route('movereserve')}}">?????????? ????????</a></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <!-- END: Breadcrumbs-->

                    <div class="container" style="margin-top: 330px;background-color: gainsboro;">
                        <div class="table-responsive">
                            <table class="table table-info mt-3">
                                <thead>
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
                                <td> ?????????????? {{$order->pansionname}} ???????? {{$order->roomnumber}} ?????? {{$order->takhtnumber}}</td>
                                <td>{{$order->raftjalali}}</td>
                                <td>{{$order->bargashtjalali}}</td>
                                <td>{{number_format($order->bedehkar)}} ??????????</td>
                                <td>{{number_format($order->totalprice)}} ??????????</td>
                                <td>{{number_format($order->takhfif)}} ??????????</td>
                                <td>{{$order->statusmalis}}</td>
                                <td>
                                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#detail-modal">???????????? ????????????</a>
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
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    @elseif($order->naqditype!=null)
                                                        <table class="table">
                                                            <thead class="bg-dark">
                                                            <tr class="text-white">
                                                                <th>??????????</th>
                                                                <th>?????? ????????????</th>
                                                                <th>????????</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            @foreach($order->naqditype as $key=>$naqditype)
                                                                <tr>
                                                                    <td>{{++$key}}</td>
                                                                    <td>{{$naqditype->title}}</td>
                                                                    <td>{{number_format($naqditype->mablagh)}} ??????????</td>
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
                        <form method="post" action="{{route('customstore')}}" id="submit" enctype="multipart/form-data">
                            <input id="raft" name="raft" class="d-none" value="{{$order->bargasht}}">
                            <input id="bargasht" name="bargasht" class="d-none" value="">
                            <input id="mounth" name="mounth" class="d-none" value="">
                            <input id="reservetype" name="reservetype" class="d-none" value="{{$order->reservetype_id}}">
                            <input id="takht_id" name="takht_id" class="d-none" value="{{$order->takht_id}}">
                            <input id="user_id" name="user_id" class="d-none" value="{{$order->user_id}}">
                            <input id="days" name="days" class="d-none" value="{{$order->days}}">
                            <input id="mounth" name="mounth" class="d-none" value="{{$order->month}}">
                            <input id="permounth" name="permounth" class="d-none" value="{{$order->permounth}}">
                            @csrf
                            <div class="container-fluid text-center" style="font-size: 16px">
                                <div class="row" style="margin-bottom: 200px">
                                    <div class="col-12 col-lg-4 row">

                                        <div class="col-12 row justify-content-between px-5 mb-4">
                                            <div class="col-12 mt-3">
                                                <h5>???????? ????????:</h5>
                                            </div>
                                            <div class="col-12 row">
                                                <div class="col-6 mt-2 pr-0">
                                                    ?????? ???????? ????????:
                                                </div>
                                                <div class="col-6 mt-2 pl-0">
                                                    {{$order->reservetype->title}}
                                                </div>
                                            </div>
                                            <div class="col-12 row">
                                                <div class="col-6 mt-2 pr-0">
                                                    ?????????? ???????? ????????:
                                                </div>
                                                <div class="col-6 mt-2 pl-0">
                                                    {{$order->raftjalali}}
                                                </div>
                                            </div>
                                            <div class="col-12 row">
                                                <div class="col-6 mt-2 pr-0">
                                                    ?????????? ???????? ????????:
                                                </div>
                                                <div class="col-6 mt-2 pl-0">
                                                    {{$order->bargashtjalali}}
                                                </div>
                                            </div>
                                            @if($order->reservetype_id==1)
                                                <div class="col-12 row">
                                                    <div class="col-6 mt-2 pr-0">
                                                        ?????????? ??????:
                                                    </div>
                                                    <div class="col-6 mt-2 pl-0">
                                                        {{$order->days}} ??????
                                                    </div>
                                                </div>
                                            @endif
                                            @if($order->reservetype_id==2)
                                                <div class="col-12 row">
                                                    <div class="col-6 mt-2 pr-0">
                                                        ?????????? ??????:
                                                    </div>
                                                    <div class="col-6 mt-2 pl-0">
                                                        {{$order->month}} ??????
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 row">
                                        <div class="col-12 row justify-content-between px-5 mb-4">
                                            <div class="col-12 mt-3">
                                                <h5>?????? ????????:</h5>
                                            </div>
                                            <div class="col-12 row">
                                                <div class="col-6 mt-2 pr-0">
                                                    ?????????? ???????? ????????:
                                                </div>
                                                <div class="col-6 mt-2 pl-0" id="newShoru">
                                                    {{$order->bargashtjalali}}
                                                </div>
                                            </div>
                                            <div class="col-12 row">
                                                <div class="col-6 mt-2 pr-0">
                                                    ?????????? ???????? ????????:
                                                </div>
                                                <div class="col-6 mt-2 pl-0" id="newKhoruj">
                                                </div>
                                            </div>
                                            @if($order->reservetype_id==1)
                                                <div class="col-12 row">
                                                    <div class="col-6 mt-2 pr-0">
                                                        ?????????? ??????:
                                                    </div>
                                                    <div class="col-6 mt-2 pl-0">
                                                        {{$order->days}} ??????
                                                    </div>
                                                </div>
                                            @endif
                                            @if($order->reservetype_id==2)
                                                <div class="col-12 row">
                                                    <div class="col-6 mt-2 pr-0">
                                                        ?????????? ??????:
                                                    </div>
                                                    <div class="col-6 mt-2 pl-0">
                                                        {{$order->month}} ??????
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 mt-5 row mb-5" id="payment">
                                        <div class="col-12 row" id="calculator">
                                            @if($order->reservetype_id==1)
                                                <div class="col-4 offset-2">???????? ????????????: </div>
                                                <div class="col-4">{{number_format($order->takht->price).' '.'??????????'}}</div>
                                                <div class="col-4 offset-2 mt-2 pr-0">
                                                    ?????????? ??????:
                                                </div>
                                                <div class="col-4 mt-2 pl-0">
                                                    {{$order->days}} ??????
                                                </div>
                                                <div class="col-4 offset-2 mt-2 pr-0">
                                                    ???????? ????:
                                                </div>
                                                <div class="col-4 mt-2 pl-0">
                                                    {{number_format($order->takht->price*$order->days).' '.'??????????'}}
                                                </div>
                                                <input id="finallyPrice" name="finallyPrice" class="d-none" value="{{$order->takht->price*$order->days}}">

                                            @endif
                                            @if($order->reservetype_id==2)
                                                <div class="col-4 offset-2">???????? ????????????: </div>
                                                <div class="col-4">{{number_format($order->takht->pricemonth).' '.'??????????'}}</div>
                                                <div class="col-4 offset-2 mt-2 pr-0">
                                                    ?????????? ??????:
                                                </div>
                                                <div class="col-4 mt-2 pl-0">
                                                    {{$order->month}} ??????
                                                </div>
                                                <div class="col-4 offset-2 mt-2 pr-0">
                                                    ???????? ????:
                                                </div>
                                                <div class="col-4 mt-2 pl-0">
                                                    {{number_format($order->takht->pricemonth*$order->month).' '.'??????????'}}
                                                </div>
                                                <input id="finallyPrice" name="finallyPrice" class="d-none" value="{{$order->takht->pricemonth*$order->month}}">

                                            @endif
                                        </div>
                                        <div class="col-12 mt-5">
                                            <input type="submit" value="?????????? ???? ??????????" class="btn btn-success w-50" style="height: 40px;font-size: 18px">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="container card mt-5">
                        <h4 class="alert-danger" style="margin-top: 200px">?????? ???????? ???????? ?????? ??????.</h4>
                    </div>
                @endif
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
                                <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">??????????????</a></li>
                                <li class="breadcrumb-item" style="background: #d0e7ff"><a class="text-danger" href="{{route('movereserve')}}">?????????? ????????</a></li>
                            </ol>
                        </nav>

                    </div>
                </div>
            </div>
            <!-- END: Breadcrumbs-->
            <div class="container card" style="margin-top: 330px;margin-bottom:100px;background-color: gainsboro">
                <h4 class="alert-danger p-2">???????? ?????????? ???????? ?????????? ???????? ??????????</h4>
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
                            <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">??????????????</a></li>
                            <li class="breadcrumb-item" style="background: #d0e7ff"><a class="text-danger" href="{{route('movereserve')}}">?????????? ????????</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END: Breadcrumbs-->
        <div class="container card" style="margin-top: 330px;margin-bottom:100px;background-color: gainsboro">
            <h4 class="alert-danger p-2">?????? ?????????? ???????????? ???? ?????? ???????? ???? ????????????.</h4>
        </div>
    @endsection
@endif
