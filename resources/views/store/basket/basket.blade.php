@extends('store.master.home')

<style>
    .page-loading {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        -webkit-transition: all .4s .2s ease-in-out;
        transition: all .4s .2s ease-in-out;
        background-color: #fff;
        opacity: 0;
        visibility: hidden;
        z-index: 9999;
    }

    .page-loading.active {
        opacity: 1;
        visibility: visible;
    }

    .page-loading-inner {
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        text-align: center;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        -webkit-transition: opacity .2s ease-in-out;
        transition: opacity .2s ease-in-out;
        opacity: 0;
    }

    .page-loading.active > .page-loading-inner {
        opacity: 1;
    }

    .page-loading-inner > span {
        display: block;
        font-size: 1rem;
        font-weight: normal;
        color: #666276;;
    }

    .page-spinner {
        display: inline-block;
        width: 2.75rem;
        height: 2.75rem;
        margin-bottom: .75rem;
        vertical-align: text-bottom;
        border: .15em solid #bbb7c5;
        border-right-color: transparent;
        border-radius: 50%;
        -webkit-animation: spinner .75s linear infinite;
        animation: spinner .75s linear infinite;
    }

    @-webkit-keyframes spinner {
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes spinner {
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
</style>

@section('pagecss')
    <!--persian-date css-->
    <link rel="stylesheet" href="{{ asset('store') }}/css/leaflet.css">
    <!--flatpickr.min.css css-->
    <link rel="stylesheet" href="{{ asset('store') }}/css/flatpickr.min.css">
@endsection
@section('js')
    <script>
        $(document).ready(function (e) {

            if ($('.provider-list').children()[0].className=='empty'){
                $('#price').children('a').attr('href',"#");
                $('#price').hide();
                $('.kolli').removeClass('col-lg-8').removeClass('col-xl-9').addClass('col-lg-12').addClass('col-xl-12');
            }
            {{--let cityId="{{$ostan->id}}";--}}
            {{--let catid="";--}}
            {{--@if($subCat=='3000')--}}
            {{--    catid=3000;--}}
            {{--@else--}}
            {{--    catid=parseInt("{{$subCat->id}}");--}}
            {{--@endif--}}
            // console.log(catid);
            let offset = 0;
            let limit = offset + 6;
            $.ajax(
                {
                    url: "{{route('basket')}}",
                    // data:{'cityId':cityId,'catid':catid,'limit':limit,'offset':offset},
                    success: function (data) {
                        function numberWithCommas(x) {
                            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
let totalPrice=0;
let totalDiscount=0;
let totalfinally=0;
                        console.log(this.url)
                        if (data != 'notfound') {
                            $('.provider-list').empty();
                            $('#price').show();
                            $('.kolli').removeClass('col-lg-12').removeClass('col-xl-12').addClass('col-lg-8').addClass('col-xl-9');
                            data.forEach(function (item, index) {

                                        if (item.passengers[0].family!=null) {
                                            $('.provider-list').append(`      <div class="col-12">
                                                            <article class="position-relative row pb-4 pt-4" style="border-top: 1px solid #d3d3d3 !important;">
                                                                <div class="position-relative col-md-3">
                                                                    <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5 fav" data-id="${item.puId}" style="top:10px!important;left:10px!important" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="???????? ????????"><i class="fi-heart"></i></button>


                               <img class="rounded-3 mt-3" src="{{asset("")}}/${item.pathImage}" style="width:250px;height:250px;border: 1px solid #d3d3d3 !important" alt="Article img">


                                </div>
                                <div class="col-md-9 ">
                                <h3 class="mb-2 fs-lg"><a class="nav-link" href="{{asset("singleproduct")}}/${item.puId}">${item.business_title != null ? item.business_title : '-'}</a></h3>


                                                                <ul class="mb-0 fs-sm">
                                                                                                                                    <li class="ps-1 list-group-item" style="font-size: 1.1rem !important;"> ${item.productName != null ? item.productName : '-'}  ???? ${item.cityName != null ? item.cityName : '-'}
                                                                                                                                    <div class="d-inline" style="font-size: 0.9rem !important;">${item.jalali != null ? item.jalali : '-'} </div>
                                                                                                                                    <div class="d-inline" style="font-size: 0.9rem !important;">????  ${item.raft != null ? item.raft : '-'}  ???? ${item.bargasht != null ? item.bargasht : '-'}  </div>
                                                                                                                                    </li>


                                                                                                                                                                 <li class="ps-1 list-group-item" style="font-size: 0.9rem !important;text-align: left;"><div class="row"> <div class="col-6" style="text-align:right">??????????(${item.passengerCount} ??????):</div> <div class="seprate col-6" style="margin-right:-10px"><span
                                                                                                                                                                    data-toggle="modal" data-target="#passenger-modal-${item.id}" style="cursor: pointer;" class="link-info">???????? ??????????</span></div></div>  </li>

                                                                                                                                                                 <li class="ps-1 list-group-item" style="font-size: 0.9rem !important;text-align: left;"><div class="row"> <div class="col-6" style="text-align:right">???????? ????????:</div> <div class="seprate col-6" style="margin-right:-10px"> ${numberWithCommas(item.price.substring(0, item.price.length - 3))} ??????????</div></div></li>
                                                    <li class="ps-1 list-group-item text-danger" style="font-size: 0.9rem !important;text-align: left;"><div class="row"><div class="col-6" style="text-align:right">??????????:</div> <div class="seprate col-6" style="margin-right:-10px"> ${item.discount_price != null ? numberWithCommas(item.discount_price.substring(0, item.discount_price.length - 3)) : '-'} ??????????</div></div></li>
                                                    <li class="ps-1 list-group-item" style="font-size: 1.1rem !important;text-align: left;"><div class="row"><div class="col-6" style="text-align:right">???????? ??????????:</div> <div class="seprate col-6" style="margin-right:-10px">${numberWithCommas(item.finally_price)} ??????????</div></div></li>
                                                    <li class="ps-1 list-group-item" style="font-size: 1.1rem !important;text-align: left;"><div class="row"><div class="col-6" style="text-align:right"><span class="deletebasket" data-id="${index}"><i title="??????" class="fas fa-trash-alt" style="cursor: pointer;" data-id="${index}"></i></span></div> <div class="seprate col-6" style="margin-right:-10px"></div></div></li>
                                                                </ul>
                                                                </div>
                                                                 <div class="modal fade" id="passenger-modal-${item.id}" role="dialog">
                            <div class="modal-dialog modal-lg">


                                <div class="modal-content">
                                    <div class="modal-header d-block" style="text-align: right">
                                        <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                    </div>
                                    <div class="modal-body text-dark" >
                                        <!-- START: Breadcrumbs-->
                                        <div class="py-5 mt-5 mb-lg-3 row w-100">
                                            <div class="col-12  align-self-center">
                                                <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                                                    <div class="w-sm-100 mr-auto"><h4 class="mb-0">???????????? ????</h4></div>
                                                    <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid">
                                            <table class="table w-100" id="group-table">
                                                <thead>
                                                <tr>
                                                    <th><h5>??????????</h5> </th>
                                                    <th><h5>??????</h5></th>
                                                    <th><h5>
                                                          ?????? ????????????????
                                                        </h5>
                                                    </th>
                                                    <th><h5>
                                                            ??????????
                                                        </h5>
                                                    </th>
                                                     <th><h5>
                                                            ????
                                                        </h5>
                                                    </th>
                                                      <th><h5>
                                                            ??????????
                                                        </h5>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody id="tbody-${item.orderdetail_id}">

                                             </tbody>
                                </table>
                            </div>
                        </div>

                          <div class="modal-footer">
        <a href="{{asset('setpassengers')}}/${item.orderdetail_id}" type="button" class="btn btn-secondary">????????????</a>
      </div>
                    </div>

                </div>
            </div>
                                                </article>

                                            </div>`);
                                        }
                                        else {
                                            $('.provider-list').append(`      <div class="col-12">
                                                            <article class="position-relative row pb-4 pt-4" style="border-top: 1px solid #d3d3d3 !important;">
                                                                <div class="position-relative col-md-3">
                                                                    <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5 fav" data-id="${item.puId}" style="top:10px!important;left:10px!important" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="???????? ????????"><i class="fi-heart"></i></button>


                               <img class="rounded-3 mt-3" src="{{asset("")}}/${item.pathImage}" style="width:250px;height:250px;border: 1px solid #d3d3d3 !important" alt="Article img">


                                </div>
                                <div class="col-md-9 ">
                                <h3 class="mb-2 fs-lg"><a class="nav-link" href="{{asset("singleproduct")}}/${item.puId}">${item.business_title != null ? item.business_title : '-'}</a></h3>


                                                                <ul class="mb-0 fs-sm">
                                                                                                                                    <li class="ps-1 list-group-item" style="font-size: 1.1rem !important;"> ${item.productName != null ? item.productName : '-'}  ???? ${item.cityName != null ? item.cityName : '-'}
                                                                                                                                    <div class="d-inline" style="font-size: 0.9rem !important;">${item.jalali != null ? item.jalali : '-'} </div>
                                                                                                                                    <div class="d-inline" style="font-size: 0.9rem !important;">????  ${item.raft != null ? item.raft : '-'}  ???? ${item.bargasht != null ? item.bargasht : '-'}  </div>
                                                                                                                                    </li>


                                                                                                                                                                 <li class="ps-1 list-group-item" style="font-size: 0.9rem !important;text-align: left;"><div class="row"> <div class="col-6" style="text-align:right">??????????(${item.passengerCount} ??????):</div> <div class="seprate col-6 row" style="margin-right:-10px"><div class="col-8 alert-danger">???????? ?????????????? ?????????? ???? ???????? ????????.</div><div class="col-4"><span
                                                                                                                                                                    data-toggle="modal" data-target="#passenger-modal-${item.id}" style="cursor: pointer;" class="link-info">???????? ??????????</span></div></div> </div> </li>

                                                                                                                                                                 <li class="ps-1 list-group-item" style="font-size: 0.9rem !important;text-align: left;"><div class="row"> <div class="col-6" style="text-align:right">???????? ????????:</div> <div class="seprate col-6" style="margin-right:-10px"> ${numberWithCommas(item.price.substring(0, item.price.length - 3))} ??????????</div></div></li>
                                                    <li class="ps-1 list-group-item text-danger" style="font-size: 0.9rem !important;text-align: left;"><div class="row"><div class="col-6" style="text-align:right">??????????:</div> <div class="seprate col-6" style="margin-right:-10px"> ${item.discount_price != null ? numberWithCommas(item.discount_price.substring(0, item.discount_price.length - 3)) : '-'} ??????????</div></div></li>
                                                    <li class="ps-1 list-group-item" style="font-size: 1.1rem !important;text-align: left;"><div class="row"><div class="col-6" style="text-align:right">???????? ??????????:</div> <div class="seprate col-6" style="margin-right:-10px">${numberWithCommas(item.finally_price)} ??????????</div></div></li>
                                                    <li class="ps-1 list-group-item" style="font-size: 1.1rem !important;text-align: left;"><div class="row"><div class="col-6" style="text-align:right"><span class="deletebasket" data-id="${index}"><i title="??????" class="fas fa-trash-alt" style="cursor: pointer;" data-id="${index}"></i></span></div> <div class="seprate col-6" style="margin-right:-10px"></div></div></li>
                                                                </ul>
                                                                </div>
                                                                 <div class="modal fade" id="passenger-modal-${item.id}" role="dialog">
                            <div class="modal-dialog modal-lg">


                                <div class="modal-content">
                                    <div class="modal-header d-block" style="text-align: right">
                                        <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                    </div>
                                    <div class="modal-body text-dark" >
                                        <!-- START: Breadcrumbs-->
                                        <div class="py-5 mt-5 mb-lg-3 row w-100">
                                            <div class="col-12  align-self-center">
                                                <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                                                    <div class="w-sm-100 mr-auto"><h4 class="mb-0">???????????? ????</h4></div>
                                                    <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid">
                                            <table class="table w-100" id="group-table">
                                                <thead>
                                                <tr>
                                                    <th><h5>??????????</h5> </th>
                                                    <th><h5>??????</h5></th>
                                                    <th><h5>
                                                          ?????? ????????????????
                                                        </h5>
                                                    </th>
                                                    <th><h5>
                                                            ??????????
                                                        </h5>
                                                    </th>
                                                     <th><h5>
                                                            ????
                                                        </h5>
                                                    </th>
                                                      <th><h5>
                                                            ??????????
                                                        </h5>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody id="tbody-${item.orderdetail_id}">

                                             </tbody>
                                </table>
                            </div>
                        </div>
                            <div class="modal-footer">
        <a href="{{asset('setpassengers')}}/${item.orderdetail_id}" type="button" class="btn btn-secondary">????????????</a>
      </div>
                    </div>

                </div>
            </div>
                                                </article>

                                            </div>`);
                                        }
item.passengers.forEach(function (item,index) {
    if (item.gender=="male"){
         gender='??????';
    }
    else {
         gender='????????';
    }
    $(`#tbody-${item.orderdetail_id}`).append(
        ` <tr data-id="${item.id}-${item.orderdetail_id}">
                                                        <td>${++index}</td>
                                                        <td>${item.name!=null?item.name:'????????????'}</td>
                                                        <td>${item.family!=null?item.family:'????????????'}</td>
                                                        <td>${item.age!=null?item.age:'????????????'}</td>
                                                        <td>${item.ncode!=null?item.ncode:'????????????'}</td>
                                                        <td>${gender}</td>
                                                    </tr>`
    );
});

$('.deletebasket').click(function (eve){
  let item = $(this).attr('data-id');
   $.ajax({
       url:"{{route('deletebasket')}}",
       type:'post',
       data:{"_token": "{{ csrf_token() }}","item":item},
       success: function (data) {

               location.reload();


       }

   });
});
                                // item.passeger.forEach(function (item, index) {
                                //     $('.provider-list').append(``)
                                // });
totalPrice=parseInt(totalPrice)+parseInt(item.price);
totalDiscount=parseInt(totalDiscount)+parseInt(item.discount_price);

                                totalfinally=totalfinally+item.finally_price;
                                $('#payBtn').click(function (et) {
                                    if (item.passengers[0].family==null){
                                        $('#payBtn').attr('href','#');
                                        toastr.error('?????????????? ?????????? ?????? ???? ???????? ???? ?????? ???????? ??????.')

                                    }
                                });



                            });
                          $('#price').prepend(`
                          <ul>
<li class="ps-1 list-group-item" style="font-size: 1.1rem !important;"><div class="row"><div class="col-6">???????? ????:</div><div class="col-6">${numberWithCommas(totalPrice)} ??????????</div></div></li>
<li class="ps-1 list-group-item text-danger" style="font-size: 1.1rem !important;"><div class="row"><div class="col-6">?????????? ????:</div><div class="col-6">${numberWithCommas(totalDiscount)!='NaN'?numberWithCommas(totalDiscount):'-'} ??????????</div></div></li>
<li class="ps-1 list-group-item" style="font-size: 1.1rem !important;"><div class="row"><div style="font-size: 1.1rem" class="col-6">???????? ??????????:</div><div class="col-6">${numberWithCommas(totalfinally)} ??????????</div></div></li>
</ul>
                          `)
                            $()
                            $('.fav').click(function (eve) {

                                let proid = $(this).attr('data-id');
                                let id = "{{\Illuminate\Support\Facades\Auth::user()->id}}";
                                $.ajax(
                                    {
                                        url: "{{route('setfav')}}",
                                        data: {"_token": "{{ csrf_token() }}", 'id': id, 'proId': proid},
                                        type: "post",
                                        success: function (data) {

                                            console.log(this.url)
                                            if (data == 'notfound') {

                                                toastr.error('??????');

                                            }

                                        }
                                    }
                                );
                            });
                        }
                        // else {
                        //     $('.provider-list').append(`<div class="alert-danger">?????? ???????? ???????? ??????.</div>`)
                        // }

                    }
                }
            );

            if ($('.page-1').length != 0) {
                $('.page-1').addClass('active');
            }

            {{--$('.page-item').click(function (event) {--}}
            {{--    event.preventDefault();--}}
            {{--    if ($(this).hasClass('active')){--}}
            {{--        event.preventDefault();--}}
            {{--    }--}}
            {{--    else {--}}
            {{--        $('.provider-list').empty();--}}
            {{--        $('.page-item').removeClass('active');--}}
            {{--        $(this).addClass('active');--}}
            {{--        let dataId=$(this).attr('data-id');--}}
            {{--        let ostanId="{{$ostan}}";--}}
            {{--        let offset=(parseInt(dataId)-1) * 6;--}}
            {{--        let limit=offset + 6;--}}
            {{--        $.ajax(--}}
            {{--            {--}}
            {{--                url:"{{route('paginproductboom')}}",--}}
            {{--                data:{'cityId':cityId,'limit':limit,'offset':offset},--}}
            {{--                success: function (data) {--}}
            {{--                    function numberWithCommas(x) {--}}
            {{--                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");--}}
            {{--                    }--}}
            {{--                    if (data != 'notfound') {--}}
            {{--                        data.forEach(function (item, index) {--}}

            {{--                            $('.provider-list').append(`      <div class="col-12">--}}
            {{--                                                <article class="position-relative row pb-4 pt-4" style="border-top: 1px solid #d3d3d3 !important;">--}}
            {{--                                                    <div class="position-relative col-md-3">--}}
            {{--                                                        <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5 fav" data-id="${item.id}" style="top:10px!important;left:10px!important" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="???????? ????????"><i class="fi-heart"></i></button>--}}

            {{--                    <img class="rounded-3 mt-3" src="{{asset("")}}/${item.pathImage}" style="width:250px;height:250px;border: 1px solid #d3d3d3 !important" alt="Article img">--}}

            {{--                    </div>--}}
            {{--                    <div class="col-md-9 ">--}}
            {{--                    <h3 class="mb-2 fs-lg"><a class="nav-link stretched-link" href="{{asset("singleproduct")}}/${item.id}">${item.business_title}</a></h3>--}}
            {{--                                                    <ul class="mb-0 fs-sm">--}}
            {{--                                                                                                                        <li class="ps-1 list-group-item" style="font-size: 1.1rem !important;"> <div class="seprate d-inline">${numberWithCommas(item.price.substring(0,item.price.length-3))}</div> ?????????? </li>--}}
            {{--                                                                                                                        <li class="ps-1 list-group-item">${item.cityName}, ${item.ostanName}</li>--}}

            {{--                                                        <li class="ps-1 list-group-item"><i class="fi-star-filled mt-n1 ms-1 fs-base text-warning align-middle"></i><b>5.0</b><span class="text-muted">&nbsp;(48)</span></li>--}}
            {{--                                                    </ul>--}}
            {{--                                                    </div>--}}
            {{--                                                </article>--}}
            {{--                                            </div>`);--}}


            {{--                        });--}}
            {{--                    }--}}
            {{--                    $('.fav').click(function (eve) {--}}

            {{--                        let proid = $(this).attr('data-id');--}}
            {{--                        let id = "{{\Illuminate\Support\Facades\Auth::user()->id}}";--}}
            {{--                        $.ajax(--}}
            {{--                            {--}}
            {{--                                url:"{{route('setfav')}}",--}}
            {{--                                data:{"_token": "{{ csrf_token() }}",'id':id,'proId':proid},--}}
            {{--                                type:"post",--}}
            {{--                                success: function (data) {--}}

            {{--                                    console.log(this.url)--}}
            {{--                                    if (data == 'notfound') {--}}

            {{--                                        toastr.error('??????');--}}

            {{--                                    }--}}

            {{--                                }--}}
            {{--                            }--}}
            {{--                        );--}}
            {{--                    });--}}
            {{--                }--}}
            {{--            }--}}
            {{--        );--}}
            {{--    }--}}
            {{--});--}}

        });
    </script>
@endsection
@section('pagejs')
    <!--tiny leaflet min js-->
    <script src="{{asset("store")}}/js/leaflet.js"></script>
    <!--tiny nouislider min js-->
    <script src="{{asset("store")}}/js/nouislider.min.js"></script>
@endsection
@section('content')
    <!-- Page container-->
    <div class="container-fluid mt-5 pt-5 p-0">
        <div class="row g-0 mt-n3">
            <!-- Filters sidebar (Offcanvas on mobile)-->
        {{--            <aside class="col-lg-4 col-xl-3 border-top-lg border-end-lg shadow-sm px-3 px-xl-4 px-xxl-5 pt-lg-2">--}}
        {{--                <div class="offcanvas offcanvas-start offcanvas-collapse" id="filters-sidebar">--}}
        {{--                    <div class="offcanvas-header d-flex d-lg-none align-items-center">--}}
        {{--                        <h2 class="h5 mb-0">??????????</h2>--}}
        {{--                        <button class="btn-close" type="button" data-bs-dismiss="offcanvas"></button>--}}
        {{--                    </div>--}}
        {{--                    <!-- Search form-->--}}
        {{--                    <div class="offcanvas-header d-block border-bottom pt-0 pt-lg-4 px-lg-0 ">--}}
        {{--                        <form class="form-group mb-lg-2 rounded-pill">--}}
        {{--                            <div class="input-group"><span class="input-group-text text-muted"><i class="fi-search"></i></span>--}}
        {{--                                <input class="form-control" type="text" placeholder="??????????...">--}}
        {{--                            </div>--}}
        {{--                            <button class="btn btn-primary rounded-pill d-lg-inline-block d-none" type="button">??????????</button>--}}
        {{--                            <button class="btn btn-icon btn-primary rounded-circle flex-shrink-0 d-lg-none d-inline-flex" type="button"><i class="fi-search mt-n2"></i></button>--}}
        {{--                        </form>--}}
        {{--                    </div>--}}
        {{--                    <!-- Nav tabs-->--}}
        {{--                    <div class="offcanvas-header d-block border-bottom py-lg-4 py-3 px-lg-0">--}}
        {{--                        <ul class="nav nav-pills" role="tablist">--}}
        {{--                            <li class="nav-item"><a class="nav-link d-flex align-items-center active" href="#categories" data-bs-toggle="tab" role="tab"><i class="fi-list me-2"></i>???????? ????????</a></li>--}}
        {{--                            --}}{{--                            <li class="nav-item"><a class="nav-link d-flex align-items-center" href="#filters" data-bs-toggle="tab" role="tab"><i class="fi-filter-alt-horizontal me-2"></i>??????????</a></li>--}}
        {{--                        </ul>--}}
        {{--                    </div>--}}
        {{--                    <div class="offcanvas-body py-lg-4">--}}
        {{--                        <!-- Tabs content-->--}}
        {{--                        <div class="tab-content">--}}
        {{--                            <!-- Categories-->--}}
        {{--                            <div class="tab-pane fade show active" id="categories" role="tabpanel">--}}
        {{--                                <div class="row row-cols-lg-2 row-cols-1 g-3 categories-guid">--}}
        {{--                                    @if($categories!="notfound")--}}
        {{--                                        @foreach($categories as $c)--}}
        {{--                                            <div class="col dropdown">--}}
        {{--                                                <a class="icon-box card card-body h-100 border-0 shadow-sm card-hover text-center" href="#" data-bs-toggle="dropdown">--}}
        {{--                                                    <div class="icon-box-media bg-faded-accent rounded-circle mb-3 mx-auto">--}}
        {{--                                                        <i class="{{$c->classicon!=null?$c->classicon:''}} text-info pt-2"></i>--}}
        {{--                                                    </div>--}}
        {{--                                                    <h3 class="icon-box-title fs-base mb-0">{{$c->title}}</h3>--}}

        {{--                                                </a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-sm-end my-1 w-75">--}}
        {{--                                                    @if(count($c->subCategory)>0)--}}
        {{--                                                        @foreach($c->subCategory as $subcategory)--}}
        {{--                                                            <a class="dropdown-item fw-bold" href="{{route('getproductbycity',[$ostan->id,$subcategory->id])}}">{{$subcategory->title}}</a>--}}
        {{--                                                        @endforeach--}}
        {{--                                                    @endif--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        @endforeach--}}
        {{--                                    @endif--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <!-- Filters-->--}}
        {{--                            <div class="tab-pane fade" id="filters" role="tabpanel">--}}
        {{--                                <div class="pb-4 mb-2">--}}
        {{--                                    <h3 class="h6">???????????? ??????????</h3>--}}
        {{--                                    <select class="form-select mb-2">--}}
        {{--                                        <option value="Berlin" selected>??????????</option>--}}
        {{--                                        <option value="Hamburg">??????????????</option>--}}
        {{--                                        <option value="Munich">??????????</option>--}}
        {{--                                        <option value="Koln">????????????</option>--}}
        {{--                                        <option value="Frankfurt am Main">??????????????????</option>--}}
        {{--                                    </select>--}}
        {{--                                    <select class="form-select">--}}
        {{--                                        <option value="" selected disabled>???????????? ??????????</option>--}}
        {{--                                        <option value="Berlin-Mitte">??????????-??????</option>--}}
        {{--                                        <option value="Charlottenburg">??????????????????????</option>--}}
        {{--                                        <option value="Prenzlauer Berg">????????????</option>--}}
        {{--                                        <option value="Friedrichshain">????????????????????</option>--}}
        {{--                                        <option value="Kreuzberg">??????????</option>--}}
        {{--                                    </select>--}}
        {{--                                </div>--}}
        {{--                                <div class="pb-4 mb-2">--}}
        {{--                                    <h3 class="h6">???????? ????????</h3>--}}
        {{--                                    <div class="dropdown mb-sm-0 mb-3" data-bs-toggle="select">--}}
        {{--                                        <button class="btn btn-outline-secondary d-flex align-items-center w-100 px-4 fw-normal text-start dropdown-toggle" type="button" data-bs-toggle="dropdown"><i class="fi-list me-2 text-muted"></i><span class="dropdown-toggle-label d-block w-100 text-right">???????? ???????? ???????? ????</span></button>--}}
        {{--                                        <input type="hidden">--}}
        {{--                                        <ul class="dropdown-menu w-100">--}}
        {{--                                            <li><a class="dropdown-item" href="#"><i class="fi-bed fs-lg opacity-60"></i><span class="dropdown-item-label"> ????????????????</span></a></li>--}}
        {{--                                            <li><a class="dropdown-item" href="#"><i class="fi-cafe me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">?????????????? ?? ???????? ??????</span></a></li>--}}
        {{--                                            <li><a class="dropdown-item" href="#"><i class="fi-shopping-bag me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">???????? ????????</span></a></li>--}}
        {{--                                            <li><a class="dropdown-item" href="#"><i class="fi-museum me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">?????? ?? ??????????</span></a></li>--}}
        {{--                                            <li><a class="dropdown-item" href="#"><i class="fi-entertainment me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">???????????? ?? ????????????</span></a></li>--}}
        {{--                                            <li><a class="dropdown-item" href="#"><i class="fi-meds me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">?????????? ?? ????????????</span></a></li>--}}
        {{--                                            <li><a class="dropdown-item" href="#"><i class="fi-makeup me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">???????????? ?? ????????????</span></a></li>--}}
        {{--                                            <li><a class="dropdown-item" href="#"><i class="fi-car me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">?????????? ??????????</span></a></li>--}}
        {{--                                        </ul>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
        {{--                                <div class="pb-4 mb-2">--}}
        {{--                                    <h3 class="h6">?????? ????????</h3>--}}
        {{--                                    <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" data-simplebar-direction="rtl" style="height: 11rem;">--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="hotel">--}}
        {{--                                            <label class="form-check-label fs-sm" for="hotel">??????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="hostel">--}}
        {{--                                            <label class="form-check-label fs-sm" for="hostel">??????????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="motel">--}}
        {{--                                            <label class="form-check-label fs-sm" for="motel">??????????????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="apartment" checked>--}}
        {{--                                            <label class="form-check-label fs-sm" for="apartment">????????????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="cottage">--}}
        {{--                                            <label class="form-check-label fs-sm" for="cottage">????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="boutique-hotel">--}}
        {{--                                            <label class="form-check-label fs-sm" for="boutique-hotel">????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="room">--}}
        {{--                                            <label class="form-check-label fs-sm" for="room">??????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="land">--}}
        {{--                                            <label class="form-check-label fs-sm" for="land">????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="commercial">--}}
        {{--                                            <label class="form-check-label fs-sm" for="commercial">?????????? ?? ??????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="parking-lot">--}}
        {{--                                            <label class="form-check-label fs-sm" for="parking-lot">??????????????</label>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
        {{--                                <div class="pb-4 mb-2">--}}
        {{--                                    <h3 class="h6">????????</h3>--}}
        {{--                                    <div class="range-slider" data-start-min="300" data-start-max="700" data-min="50" data-max="1000" data-step="20">--}}
        {{--                                        <div class="range-slider-ui"></div>--}}
        {{--                                        <div class="d-flex align-items-center">--}}
        {{--                                            <div class="w-50 pe-2">--}}
        {{--                                                <div class="input-group flex-row-reverse"><span class="input-group-text fs-base">??</span>--}}
        {{--                                                    <input class="form-control range-slider-value-max" type="text">--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                            <div class="text-muted">???</div>--}}
        {{--                                            <div class="w-50 ps-2">--}}
        {{--                                                <div class="input-group flex-row-reverse"><span class="input-group-text fs-base">??</span>--}}
        {{--                                                    <input class="form-control range-slider-value-min" type="text">--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
        {{--                                <div class="pb-4 mb-2">--}}
        {{--                                    <h3 class="h6">?????????????? ????????????</h3>--}}
        {{--                                    <div class="form-check">--}}
        {{--                                        <input class="form-check-input" type="checkbox" id="5-star">--}}
        {{--                                        <label class="form-check-label fs-sm align-middle mt-n2" for="5-star"><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i></span>--}}
        {{--                                        </label>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="form-check">--}}
        {{--                                        <input class="form-check-input" type="checkbox" id="4-star">--}}
        {{--                                        <label class="form-check-label fs-sm align-middle mt-n2" for="4-star"><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star"></i></span>--}}
        {{--                                        </label>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="form-check">--}}
        {{--                                        <input class="form-check-input" type="checkbox" id="3-star">--}}
        {{--                                        <label class="form-check-label fs-sm align-middle mt-n2" for="3-star"><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star"></i><i class="star-rating-icon fi-star"></i></span>--}}
        {{--                                        </label>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="form-check">--}}
        {{--                                        <input class="form-check-input" type="checkbox" id="2-star">--}}
        {{--                                        <label class="form-check-label fs-sm align-middle mt-n2" for="2-star"><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star"></i><i class="star-rating-icon fi-star"></i><i class="star-rating-icon fi-star"></i></span>--}}
        {{--                                        </label>--}}
        {{--                                    </div>--}}
        {{--                                    <div class="form-check">--}}
        {{--                                        <input class="form-check-input" type="checkbox" id="1-star">--}}
        {{--                                        <label class="form-check-label fs-sm align-middle mt-n2" for="1-star"><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star"></i><i class="star-rating-icon fi-star"></i><i class="star-rating-icon fi-star"></i><i class="star-rating-icon fi-star"></i></span>--}}
        {{--                                        </label>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
        {{--                                <div class="pb-4 mb-2">--}}
        {{--                                    <h3 class="h6">?????????? ????????</h3>--}}
        {{--                                    <select class="form-select mb-2">--}}
        {{--                                        <option value="1-room" selected>1 ????????</option>--}}
        {{--                                        <option value="2-rooms">2 ????????</option>--}}
        {{--                                        <option value="3-rooms">3 ????????</option>--}}
        {{--                                        <option value="4-rooms">4 ????????</option>--}}
        {{--                                        <option value="5-rooms">5 ????????</option>--}}
        {{--                                    </select>--}}
        {{--                                </div>--}}
        {{--                                <div class="pb-4 mb-2">--}}
        {{--                                    <h3 class="h6">?????????????? ??????????</h3>--}}
        {{--                                    <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" style="height: 11rem;" data-simplebar-direction="rtl">--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="parking">--}}
        {{--                                            <label class="form-check-label fs-sm" for="parking">??????????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="restaurant">--}}
        {{--                                            <label class="form-check-label fs-sm" for="restaurant">??????????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="pet-friendly">--}}
        {{--                                            <label class="form-check-label fs-sm" for="pet-friendly">?????????????? ?????????????? ??????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="room-service" checked>--}}
        {{--                                            <label class="form-check-label fs-sm" for="room-service">?????????? ??????????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="fitness-center">--}}
        {{--                                            <label class="form-check-label fs-sm" for="fitness-center">???????? ??????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="free-wifi" checked>--}}
        {{--                                            <label class="form-check-label fs-sm" for="free-wifi">?????? ?????? ????????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="spa-lounge">--}}
        {{--                                            <label class="form-check-label fs-sm" for="spa-lounge">???????? ??????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="bar">--}}
        {{--                                            <label class="form-check-label fs-sm" for="bar">?????? ????????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="swimming-pool">--}}
        {{--                                            <label class="form-check-label fs-sm" for="swimming-pool">??????????</label>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
        {{--                                <div class="pb-4 mb-2">--}}
        {{--                                    <h3 class="h6">?????????????? ????????</h3>--}}
        {{--                                    <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" style="height: 11rem;" data-simplebar-direction="rtl">--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="kitchen">--}}
        {{--                                            <label class="form-check-label fs-sm" for="kitchen">????????????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="private-bathroom">--}}
        {{--                                            <label class="form-check-label fs-sm" for="private-bathroom">????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="air-conditioning" checked>--}}
        {{--                                            <label class="form-check-label fs-sm" for="air-conditioning">?????????? ??????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="desk">--}}
        {{--                                            <label class="form-check-label fs-sm" for="desk">??????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="terrace">--}}
        {{--                                            <label class="form-check-label fs-sm" for="terrace">??????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="washing-machine">--}}
        {{--                                            <label class="form-check-label fs-sm" for="washing-machine">?????????? ??????????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="heating">--}}
        {{--                                            <label class="form-check-label fs-sm" for="heating">?????????? ??????????????</label>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="form-check">--}}
        {{--                                            <input class="form-check-input" type="checkbox" id="laundry-service">--}}
        {{--                                            <label class="form-check-label fs-sm" for="laundry-service">?????????? ????????????????</label>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
        {{--                                <div class="border-top py-4">--}}
        {{--                                    <button class="btn btn-outline-primary rounded-pill" type="button"><i class="fi-rotate-right me-2"></i>?????? ??????????</button>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </aside>--}}
        <!-- Page content-->
            <div class="col-lg-8 col-xl-9 position-relative overflow-hidden pb-5 pt-4 px-3 px-xl-4 px-xxl-5 kolli" style="border: 1px solid #aaaa">
                <!-- Map popup-->
                <div class="map-popup invisible" id="map">
                    <button class="btn btn-icon btn-light btn-sm shadow-sm rounded-circle fav" type="button"
                            data-bs-toggle-class="invisible" data-bs-target="#map"><i class="fi-x fs-xs"></i></button>
                    <div class="interactive-map" data-map-options-json="json/map-options-city-guide.json"></div>
                </div>
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-2" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="city-guide-home-v1.html">????????</a></li>
                        <li class="breadcrumb-item active" aria-current="page">?????? ????????</li>
                    </ol>
                </nav>
                <!-- Title-->
            {{--                <div class="d-sm-flex align-items-center justify-content-between pb-3 pb-sm-4">--}}
            {{--                    <h1 class="h2 mb-sm-0">?????????? ?????????? ?????????? {{$ostan->name}}</h1><a class="d-inline-block fw-bold text-decoration-none py-1" href="#" data-bs-toggle-class="invisible" data-bs-target="#map"><i class="fi-map me-2"></i>???????????? ????????</a>--}}
            {{--                </div>--}}
            <!-- Sorting-->
            {{--                <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch my-2">--}}
            {{--                    <div class="d-flex align-items-center flex-shrink-0">--}}
            {{--                        <label class="fs-sm me-2 pe-1 text-nowrap" for="sortby"><i class="fi-arrows-sort text-muted mt-n1 me-2"></i>???????? ????????</label>--}}
            {{--                        <select class="form-select form-select-sm" id="sortby">--}}
            {{--                            <option>????????????????</option>--}}
            {{--                            <option>????????????????</option>--}}
            {{--                            <option>???????? ???????? - ??????????</option>--}}
            {{--                            <option>???????? ?????????? - ????????</option>--}}
            {{--                            <option>???????????? ????????</option>--}}
            {{--                            <option>???????????? ????????</option>--}}
            {{--                        </select>--}}
            {{--                    </div>--}}
            {{--                    <hr class="d-none d-sm-block w-100 mx-4">--}}
            {{--                    <div class="d-none d-sm-flex align-items-center flex-shrink-0 text-muted"><i class="fi-check-circle me-2"></i><span class="fs-sm mt-n1">{{$products!="notfound"?count($products):'0'}} ?????????? ???????? ????</span></div>--}}
            {{--                </div>--}}
            <!-- Catalog grid-->
                <div class="row provider-list">
                <div class="empty">
                    ?????? ???????? ???????? ??????.
                </div>
                    <!-- Item-->
                </div>
                <!-- Pagination-->
                {{--                @if($products!="notfound")--}}
                {{--                    <nav class="border-top pb-md-4 pt-4" aria-label="Pagination">--}}
                {{--                        <ul class="pagination mb-1">--}}
                {{--                            --}}{{--                        <li class="page-item d-sm-none"><span class="page-link page-link-static">1 / 5</span></li>--}}

                {{--                            @for($i=1;$i<=$count;$i++)--}}
                {{--                                <li data-id="{{$i}}" class="page-item d-none d-sm-block page-{{$i}}" aria-current="page"><button class="page-link">{{$i}}<span class="visually-hidden">(???????? ????????)</span></button></li>--}}
                {{--                            @endfor--}}
                {{--                        </ul>--}}
                {{--                    </nav>--}}
                {{--                @endif--}}
            </div>
        <div class="text-center col-lg-4 col-xl-3 position-relative overflow-hidden pb-5 pt-4 px-3 px-xl-4 px-xxl-5" id="price" style="border: 1px solid #aaaa">
<a href="#" class="btn btn-danger" id="payBtn">?????????? ???????????? ????????</a>
        </div>

        </div>
    </div>
@endsection
