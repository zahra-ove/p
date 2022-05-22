@extends('admin.master.home')
@section('css')
    .owl-carousel .owl-item img {
        height: 96.828px;
    }

    .dataTables_wrapper {
        margin-top: 50px;
    }

    a.btn {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .select2 {
        width: 100% !important;
    }

    @media (min-width: 1400px) {
        .container {
            max-width: 1350px !important;
        }
    }

    @media (min-width: 992px) {
        .mr-140 {
            margin-right: 140px !important;
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

    .pagination {
        display: inline-block;
    }

    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
        border-radius: 5px;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
        border-radius: 5px;
    }
@endsection
@section('js')
    <script>
        $(document).ready(function (e) {
            let countAllOrders = "";
            $.ajax({
                url:'{{asset('admin/getallordersnotpay')}}',
                async:false,
                success:function (data) {
                    countAllOrders=data;

                }
            });

            $(".datePick").persianDatepicker({

            });

            $.ajax({
                url: '{{asset('admin/getordersnotpaylimitoffset')}}/' + '10' + '/0',
                success: function (data) {
                    if (data != 'notfound') {
                        $('.pagination').empty();
                        let countpages=Math.ceil(countAllOrders.length/10);
                        for(let i=1;i<=countpages;i++) {
                            if (i == '1') {
                                $('.pagination').append(`<a page="${i}" href="#" class="active">${i}</a>`);
                            }
                            else
                            {
                                $('.pagination').append(`  <a page="${i}" href="#">${i}</a>`);


                            }

                        }
                        $('.notfound').remove();
                        $('#orderList').show();
                        $('.pagination').show();
                        $('#searchPart').show();
                        data.forEach(function (item, index) {
                            $('#orderList tbody').append(`<tr>
                    <td>${index + 1}</td>
   <td>${item.fullname}</td>
                    <td>خوابگاه ${item.pansionname} اتاق ${item.roomnumber} شماره تخت ${item.takht.takhtnumber} </td>
                    <td>${item.raftjalali}</td>
                    <td>${item.bargashtjalali}</td>
                    <td>${item.vaziat}</td>
                    <td>${item.statusmalis}</td>
                    <td><a href="{{asset('admin/getaqsatbyorder')}}/${item.id}" class="btn btn-success"><i class="fa fa-money-bill"></i> </a> </td>
                    </tr>`)
                        })
                    } else {
                        $('.notfound').remove();
                        $('#orderList').hide();
                        $('.pagination').hide();
                        $('#searchPart').hide();
                        $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                    }
                }
            });
            $(document).on('click',".pagination a",function (ep) {
                let $this=$(this);
                if ($(this).hasClass('active') == false) {
                    if ($(this).hasClass('his') == false) {
                        $('#orderList tbody').empty();
                        $('a.active').removeClass('active');
                        $(this).addClass('active');
                        let pageNunmber = parseInt($(this).text());
                        let prePageNunmber = parseInt($(this).text()) - 1;
                        let preCounts = prePageNunmber * 10;
                        let counts = pageNunmber * 10;
                        $.ajax({
                            url: '{{asset('admin/getordersnotpaylimitoffset')}}/' + counts + '/' + preCounts,
                            success: function (data) {
                                if (data != 'notfound') {
                                    $('.notfound').remove();
                                    $('#orderList').show();
                                    $('.pagination').show();
                                    $('#searchPart').show();
                                    data.forEach(function (item, index) {
                                        $('#orderList tbody').append(`<tr>
                    <td>${index + 1}</td>
   <td>${item.fullname}</td>
                    <td>خوابگاه ${item.pansionname} اتاق ${item.roomnumber} شماره تخت ${item.takht.takhtnumber} </td>
                    <td>${item.raftjalali}</td>
                    <td>${item.bargashtjalali}</td>
                    <td>${item.vaziat}</td>
                    <td>${item.statusmalis}</td>
                    <td><a href="{{asset('admin/getaqsatbyorder')}}/${item.id}" class="btn btn-success"><i class="fa fa-money-bill"></i> </a></td>

                    </tr>`)
                                    })
                                } else {
                                    $('.notfound').remove();
                                    $('#orderList').hide();
                                    $('.pagination').hide();
                                    $('#searchPart').hide();
                                    $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                                }
                            }
                        });
                    }
                    else {

                        $('#orderList tbody').empty();
                        $('a.active').removeClass('active');
                        $(this).addClass('active');
                        let pageNunmber = parseInt($(this).text());
                        let prePageNunmber = parseInt($(this).text()) - 1;
                        let preCounts = prePageNunmber * 10;
                        let counts = pageNunmber * 10;
                        let from = $('#from').attr('data-gdate').replaceAll('/', '-');
                        let to = $('#to').attr('data-gdate').replaceAll('/', '-');
                        let countDateOrders = "";
                        $.ajax({
                            url:'{{asset('admin/getordersnotpaydate')}}/'+ from + '/' + to ,
                            async:false,
                            success:function (data) {
                                countDateOrders=data;
                            }
                        });
                        $.ajax(
                            {
                                url: "{{asset('admin/getordersnotpaydatelimitoffset')}}/" + from + '/' + to + '/' + counts + '/' + preCounts,
                                success: function (data) {
                                    if (data != 'notfound') {
                                        $('.pagination').empty();
                                        let countpages=Math.ceil(countDateOrders.length/10);
                                        for(let i=1;i<=countpages;i++) {
                                            if (i == $this.text()) {
                                                $('.pagination').append(`<a page="${i}" href="#" class="active his">${i}</a>`);
                                            }
                                            else
                                            {
                                                $('.pagination').append(`  <a page="${i}" href="#" class="his">${i}</a>`);


                                            }

                                        }
                                        $('.notfound').remove();
                                        $('#orderList').show();
                                        $('.pagination').show();
                                        $('#searchPart').show();
                                        data.forEach(function (item, index) {
                                            $('#orderList tbody').append(`<tr>
                    <td>${index + 1}</td>
   <td>${item.fullname}</td>
                    <td>خوابگاه ${item.pansionname} اتاق ${item.roomnumber} شماره تخت ${item.takht.takhtnumber} </td>
                    <td>${item.raftjalali}</td>
                    <td>${item.bargashtjalali}</td>
                    <td>${item.vaziat}</td>
                    <td>${item.statusmalis}</td>
                    <td><a href="{{asset('admin/getaqsatbyorder')}}/${item.id}" class="btn btn-success"><i class="fa fa-money-bill"></i> </a> </td>
                    </tr>`)
                                        })
                                    } else {
                                        $('.notfound').remove();
                                        $('#orderList').hide();
                                        $('.pagination').hide();
                                        // $('#searchPart').hide();
                                        $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                                    }
                                }
                            }
                        )
                    }
                }
            });
            $('.hrefbtn').attr('href', "{{route('pansion.create')}}");
            $('#searchDate').click(function (es) {
                if ($('#from').val().length!=0 && $('#to').val().length!=0) {

                    $('#orderList tbody').empty();
                    $('a.active').removeClass('active');
                    $('.pagination a[page="1"]').addClass('active');
                    $(this).addClass('active');
                    let pageNunmber = parseInt($(this).text());
                    let prePageNunmber = parseInt($(this).text()) - 1;
                    let preCounts = prePageNunmber * 10;
                    let counts = pageNunmber * 10;
                    let from = $('#from').attr('data-gdate').replaceAll('/', '-');
                    let to = $('#to').attr('data-gdate').replaceAll('/', '-');
                    let countDateOrders = "";
                    $.ajax({
                        url: '{{asset('admin/getordersnotpaydate')}}/' + from + '/' + to,
                        async: false,
                        success: function (data) {
                            countDateOrders = data;
                        }
                    });
                    $.ajax(
                        {
                            url: "{{asset('admin/getordersnotpaydatelimitoffset')}}/" + from + '/' + to + '/' + '10' + '/' + '0',
                            success: function (data) {
                                if (data != 'notfound') {
                                    $('.pagination').empty();
                                    let countpages = Math.ceil(countDateOrders.length / 10);
                                    for (let i = 1; i <= countpages; i++) {
                                        if (i == '1') {
                                            $('.pagination').append(`<a page="${i}" href="#" class="active">${i}</a>`);
                                        } else {
                                            $('.pagination').append(`  <a page="${i}" href="#">${i}</a>`);


                                        }

                                    }
                                    $('.pagination a').addClass('his');
                                    $('.notfound').remove();
                                    $('#orderList').show();
                                    $('.pagination').show();
                                    $('#searchPart').show();
                                    data.forEach(function (item, index) {
                                        $('#orderList tbody').append(`<tr>
                    <td>${index + 1}</td>
   <td>${item.fullname}</td>
                    <td>خوابگاه ${item.pansionname} اتاق ${item.roomnumber} شماره تخت ${item.takht.takhtnumber} </td>
                    <td>${item.raftjalali}</td>
                    <td>${item.bargashtjalali}</td>
                    <td>${item.vaziat}</td>
                    <td>${item.statusmalis}</td>
                    <td><a href="{{asset('admin/getaqsatbyorder')}}/${item.id}" class="btn btn-success"><i class="fa fa-money-bill"></i> </a> </td>
                    </tr>`)
                                    });
                                } else {
                                    $('.notfound').remove();
                                    $('#orderList').hide();
                                    $('.pagination').hide();
                                    // $('#searchPart').hide();
                                    $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                                }
                            }
                        }
                    );
                }
                else if ($('#from').val().length!=0){
                    toastr.warning('تاریخ پایان مشخص نیست.');
                }
                else if ($('#to').val().length!=0){
                    toastr.warning('تاریخ شروع مشخص نیست.');
                }
                else {
                    toastr.warning('تاریخ مشخص نشده است.');
                }
            });

        });

    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded"
                 style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a>
                        </li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">لیست رزرو های
                            بدهکار

                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- category table-->
    <div class="container card px-5" style="margin-top: 230px;background-color: gainsboro">
        <div class="row ">
            <div class="col-12 row my-2" id="searchPart">
                <div class="col-lg-6 col-10 row justify-content-between">
                    <div class="col-lg-6 col-12 mb-3 mt-5 row">
                        <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative" style="top: 24%">تاریخ شروع</span>
                        </div>
                        <div class="col-9 p-0 ">
                            <input name="from" id="from" class="form-control datePick">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 mb-3 mt-5 row">
                        <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative" style="top: 24%">تاریخ پایان</span>
                        </div>
                        <div class="col-9 p-0 ">
                            <input name="to" id="to" class="form-control datePick">

                        </div>
                    </div>
                </div>
                <div class="col-2 mb-3 mt-5">
                    <span class="btn btn-secondary" id="searchDate">جستجو</span>
                </div>
            </div>
            <div class="col-12">
                <table id="orderList" class="align-right table table-hover table-dark table-striped w-100 pt-2">
                    <thead>
                    <tr>

                        <th>شماره لیست</th>
                        <th>نام و نام خانوادگی</th>
                        <th>تخت</th>
                        <th>تاریخ شروع</th>
                        <th>تاریخ پایان</th>
                        <th>وضعیت رزرو</th>
                        <th>وضعیت پرداخت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                    </tr>
                    </tbody>

                </table>
            </div>
            @if($pages!=0)
                <div class="col-12 m-auto justify-content-center row">
                    <div class="pagination mb-2">

                        @for($i=1;$i<=$pages;$i++)
                            @if($i=='1')
                                <a page="{{$i}}" href="#" class="active">{{$i}}</a>
                            @else

                                <a page="{{$i}}" href="#">{{$i}}</a>

                            @endif
                        @endfor

                    </div>
                </div>
            @endif
        </div>


    </div>
@endsection
