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

    @media (min-width: 1500px) {
        .container {
            max-width: 1450px !important;
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
                url: '{{asset('admin/getallordersreturn')}}',
                async: false,
                success: function (data) {
                    countAllOrders = data;
                }
            });
            $.ajax({
                url: '{{asset('admin/getorderlimitoffset')}}/' + '10' + '/0',
                async: false,
                success: function (data) {

                    if (data != 'notfound') {
                        $('.pagination').empty();
                        let countpages = Math.ceil(countAllOrders.length / 10);
                        for (let i = 1; i <= countpages; i++) {
                            if (i == '1') {
                                $('.pagination').append(`<a page="${i}" href="#" class="active">${i}</a>`);
                            } else {
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
        <td>${item.mobilecode}</td>
                    <td>${item.ncode}</td>
                    <td>خوابگاه ${item.pansionname} اتاق ${item.roomnumber} شماره تخت ${item.takht.takhtnumber} </td>
                    <td>${item.raftjalali}</td>
                    <td>${item.bargashtjalali}</td>
                    <td>${item.order_number}</td>
                    <td>${item.karshenasName}</td>
                    <td>${item.vaziat}</td>
                    <td>   <a href="{{asset('admin/getstatusmalibyorder')}}/${item.id}" style="width: 40px" class="btn btn-secondary"><i class="fa fa-calculator"></i> </a></td>
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
            $(".datePick").persianDatepicker({
            });

            $(document).on('click', ".pagination a", function (ep) {
                let $this = $(this);

                if ($(this).hasClass('active') == false) {
                    if ($(this).hasClass('his') == false && $(this).hasClass('searched') == false) {

                        $('#orderList tbody').empty();
                        let pageNunmber = parseInt($(this).text());
                        let prePageNunmber = parseInt($(this).text()) - 1;
                        let preCounts = prePageNunmber * 10;
                        let counts = pageNunmber * 10;
                        $.ajax({
                            url: '{{asset('admin/getorderlimitoffset')}}/' + counts + '/' + preCounts,
                            async: false,
                            success: function (data) {
                                if (data != 'notfound') {
                                    $('.pagination').empty();
                                    let countpages = Math.ceil(countAllOrders.length / 10);
                                    for (let i = 1; i <= countpages; i++) {
                                        if (i == $this.text()) {
                                            $('.pagination').append(`<a page="${i}" href="#" class="active">${i}</a>`);
                                        } else {
                                            $('.pagination').append(`  <a page="${i}" href="#">${i}</a>`);


                                        }

                                    }
                                    // $('a.active').removeClass('active');

                                    $('.notfound').remove();
                                    $('#orderList').show();
                                    $('.pagination').show();
                                    $('#searchPart').show();
                                    data.forEach(function (item, index) {
                                        $('#orderList tbody').append(`<tr>
                    <td>${index + 1}</td>
   <td>${item.fullname}</td>
        <td>${item.mobilecode}</td>
                    <td>${item.ncode}</td>
                    <td>خوابگاه ${item.pansionname} اتاق ${item.roomnumber} شماره تخت ${item.takht.takhtnumber} </td>
                    <td>${item.raftjalali}</td>
                    <td>${item.bargashtjalali}</td>
                    <td>${item.order_number}</td>
                    <td>${item.karshenasName}</td>
                    <td>${item.vaziat}</td>
                    <td>   <a href="{{asset('admin/getstatusmalibyorder')}}/${item.id}" style="width: 40px" class="btn btn-secondary"><i class="fa fa-calculator"></i> </a></td>
                   </tr> `)
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
                    } else if ($(this).hasClass('his') == true) {

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
                            url: '{{asset('admin/getallordersbydate')}}/' + from + '/' + to,
                            async: false,
                            success: function (data) {
                                countDateOrders = data;
                            }
                        });
                        $.ajax(
                            {
                                url: "{{asset('admin/getallordersbydate')}}/" + from + '/' + to + '/' + counts + '/' + preCounts,
                                success: function (data) {
                                    if (data != 'notfound') {
                                        $('.pagination').empty();
                                        let countpages = Math.ceil(countDateOrders.length / 10);
                                        for (let i = 1; i <= countpages; i++) {
                                            if (i == $this.text()) {
                                                $('.pagination').append(`<a page="${i}" href="#" class="active his">${i}</a>`);
                                            } else {
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
                         <td>${item.mobilecode}</td>
                    <td>${item.ncode}</td>
                    <td>خوابگاه ${item.pansionname} اتاق ${item.roomnumber} شماره تخت ${item.takht.takhtnumber} </td>
                    <td>${item.raftjalali}</td>
                    <td>${item.bargashtjalali}</td>
                    <td>${item.order_number}</td>
                         <td>${item.karshenasName}</td>
                    <td>${item.vaziat}</td>
                    <td>   <a href="{{asset('admin/getstatusmalibyorder')}}/${item.id}" style="width: 40px" class="btn btn-secondary"><i class="fa fa-calculator"></i> </a></td>
                   </tr> `)
                                        })
                                    } else {
                                        $('.notfound').remove();
                                        $('#orderList').hide();
                                        $('.pagination').hide();
                                        $('#searchPart').hide();
                                        $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                                    }
                                }
                            }
                        )
                    } else if ($(this).hasClass('searched') == true) {

                        $('#orderList tbody').empty();
                        $('a.active').removeClass('active');
                        $(this).addClass('active');
                        let column = $('#column').val();
                        let output = $('#output').val();
                        let pageNunmber = parseInt($(this).text());
                        let prePageNunmber = parseInt($(this).text()) - 1;
                        let preCounts = prePageNunmber * 10;
                        let counts = pageNunmber * 10;
                        let countDateOrders = "";
                        $.ajax({
                            url: '{{asset('admin/getorderbysearch')}}/' + column + '/' + output,
                            async: false,
                            success: function (data) {
                                countDateOrders = data;
                            }
                        });
                        $.ajax(
                            {
                                url: "{{asset('admin/getorderbysearchlimitoffset')}}/" + column + '/' + column + '/' + counts + '/' + preCounts,
                                success: function (data) {
                                    if (data != 'notfound') {
                                        $('.pagination').empty();
                                        let countpages = Math.ceil(countDateOrders.length / 10);
                                        for (let i = 1; i <= countpages; i++) {
                                            if (i == $this.text()) {
                                                $('.pagination').append(`<a page="${i}" href="#" class="active searched">${i}</a>`);
                                            } else {
                                                $('.pagination').append(`  <a page="${i}" href="#" class="searched">${i}</a>`);


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
                         <td>${item.mobilecode}</td>
                    <td>${item.ncode}</td>
                    <td>خوابگاه ${item.pansionname} اتاق ${item.roomnumber} شماره تخت ${item.takht.takhtnumber} </td>
                    <td>${item.raftjalali}</td>
                    <td>${item.bargashtjalali}</td>
                    <td>${item.order_number}</td>
                         <td>${item.karshenasName}</td>
                    <td>${item.vaziat}</td>
                    <td>   <a href="{{asset('admin/getstatusmalibyorder')}}/${item.id}" style="width: 40px" class="btn btn-secondary"><i class="fa fa-calculator"></i> </a></td>
                   </tr> `)
                                        })
                                    } else {
                                        $('.notfound').remove();
                                        $('#orderList').hide();
                                        $('.pagination').hide();
                                        $('#searchPart').hide();
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
                if ($('#from').val().length != 0 && $('#to').val().length != 0) {
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
                        url: '{{asset('admin/getallordersbydate')}}/' + from + '/' + to,
                        async: false,
                        success: function (data) {
                            countDateOrders = data;
                        }
                    });

                    $.ajax(
                        {
                            url: "{{asset('admin/getallordersbydate')}}/" + from + '/' + to + '/' + '10' + '/' + '0',
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
                      <td>${item.mobilecode}</td>
                    <td>${item.ncode}</td>
                    <td>خوابگاه ${item.pansionname} اتاق ${item.roomnumber} شماره تخت ${item.takht.takhtnumber} </td>
                    <td>${item.raftjalali}</td>
                    <td>${item.bargashtjalali}</td>
                    <td>${item.order_number}</td>
                    <td>${item.karshenasName}</td>
                    <td>${item.vaziat}</td>
                    <td>   <a href="{{asset('admin/getstatusmalibyorder')}}/${item.id}" style="width: 40px" class="btn btn-secondary"><i class="fa fa-calculator"></i> </a></td>
                   </tr> `)
                                    })
                                } else {
                                    $('.notfound').remove();
                                    $('#orderList').hide();
                                    $('.pagination').hide();
                                    $('#searchPart').hide();
                                    $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                                }
                            }
                        }
                    );
                } else if ($('#from').val().length != 0) {
                    toastr.warning('تاریخ پایان مشخص نیست.');
                } else if ($('#to').val().length != 0) {
                    toastr.warning('تاریخ شروع مشخص نیست.');
                } else {
                    toastr.warning('تاریخ مشخص نشده است.');
                }
            });
            $('#searchColumn').click(function (es) {
                if ($('#column').val().length != 0 && $('#output').val().length != 0) {
                    $('#orderList tbody').empty();
                    $('a.active').removeClass('active');
                    $('.pagination a[page="1"]').addClass('active');
                    $(this).addClass('active');
                    let column = $('#column').val();
                    let output = $('#output').val();
                    let pageNunmber = parseInt($(this).text());
                    let prePageNunmber = parseInt($(this).text()) - 1;
                    let preCounts = prePageNunmber * 10;
                    let counts = pageNunmber * 10;
                    let countDateOrders = "";
                    $.ajax({
                        url: '{{asset('admin/getorderbysearch')}}/' + column + '/' + output,
                        async: false,
                        success: function (data) {
                            countDateOrders = data;
                        }
                    });

                    $.ajax(
                        {
                            url: "{{asset('admin/getorderbysearchlimitoffset')}}/" + column + '/' + output + '/' + '10' + '/' + '0',
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
                                    $('.pagination a').addClass('searched');
                                    $('.notfound').remove();
                                    $('#orderList').show();
                                    $('.pagination').show();
                                    $('#searchPart').show();
                                    data.forEach(function (item, index) {
                                        $('#orderList tbody').append(`<tr>
                    <td>${index + 1}</td>
                    <td>${item.fullname}</td>
                      <td>${item.mobilecode}</td>
                    <td>${item.ncode}</td>
                    <td>خوابگاه ${item.pansionname} اتاق ${item.roomnumber} شماره تخت ${item.takht.takhtnumber} </td>
                    <td>${item.raftjalali}</td>
                    <td>${item.bargashtjalali}</td>
                    <td>${item.order_number}</td>
                    <td>${item.karshenasName}</td>
                    <td>${item.vaziat}</td>
                    <td>   <a href="{{asset('admin/getstatusmalibyorder')}}/${item.id}" style="width: 40px" class="btn btn-secondary"><i class="fa fa-calculator"></i> </a></td>
                   </tr> `)
                                    })
                                } else {
                                    $('.notfound').remove();
                                    $('#orderList').hide();
                                    $('.pagination').hide();
                                    $('#searchPart').hide();
                                    $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                                }
                            }
                        }
                    );
                } else if ($('#column').val().length != 0) {
                    toastr.warning('ستون خالی است.');
                } else if ($('#output').val().length != 0) {
                    toastr.warning('کلمه نوشته نشده است.');
                } else {
                    toastr.warning('اطلاعاتی ثبت نشده است');
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
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">تاریخچه رزرو
                            ها بر اساس تاریخ

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
            <div class="col-lg-6 col-12 row justify-content-between ml-1">
                <div class="col-lg-5 col-12 mb-3 mt-5 row">
                    <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                        <span class="form-label mb-2 position-relative" style="top: 24%">شروع</span>
                    </div>
                    <div class="col-9 p-0 ">
                        <input name="from" id="from" class="form-control datePick">
                    </div>
                </div>
                <div class="col-lg-5 col-12 mb-3 mt-5 row">
                    <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                        <span class="form-label mb-2 position-relative" style="top: 24%">پایان</span>
                    </div>
                    <div class="col-9 p-0 ">
                        <input name="to" id="to" class="form-control datePick">

                    </div>
                </div>
                <div class="col-2 mb-3 mt-5">
                    <span class="btn btn-secondary" id="searchDate">جستجو</span>
                </div>
            </div>

            <div class="col-12 table-responsive">
                <table id="orderList" class="align-right table table-hover table-dark table-striped w-100 pt-2">
                    <thead>
                    <tr>

                        <th>لیست</th>
                        <th>نام</th>
                        <th>موبایل</th>
                        <th>کدملی</th>
                        <th>تخت</th>
                        <th>شروع</th>
                        <th>پایان</th>
                        <th>شماره سفارش</th>
                        <th>کارشناس</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>

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
