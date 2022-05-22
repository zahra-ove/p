@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">

@section('js')

    <script>

        $(document).ready(function () {
$('.dataTables_filter').hide();
$('.hrefbtn').hide();
$('.col-sm-12').hide();
$('#DataTables_Table_0_length').hide();
$('#DataTables_Table_0_info').hide();
$('#DataTables_Table_0_paginate').hide();
            let addpubcheck = [];
//////ckeditor
//             CKEDITOR.replace('editor', {
//                 language: "fa",
//
//             });



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




        })
    </script>

@endsection
<style>

    #timeTable {
        height: 448.719px;
    }

    .select2 {
        width: 100% !important;
    }
    @media (min-width: 1500px){
        .container {
            max-width: 1450px!important;
        }
    }

    @media (min-width: 992px){
        .mr-140{
            margin-right: 140px!important;
        }
    }
    @media (max-width: 576px){
        .mr-140{
            margin-right:60px!important;
        }
    }
    .breadcrumb{
        background-color: white!important;
    }
thead{
    color: white;
}
</style>
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">رزرو فعال</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->



    <!-- reserves table-->
    @if($order!='notfound')
        <div class="container card px-5" style="margin-top: 330px;background-color: gainsboro">

        <table class="align-right table-hover table-secondary table-striped mytable w-100 my-3">
            <thead>
            <tr>


                <th style="padding-right: 15px">نام پانسیون</th>
                <th>شماره اتاق</th>
                <th>شماره تخت</th>
                <th>شماره رزرو</th>
                <th>ثبت کننده</th>
                <th>وضعیت</th>
                <th>جابجایی</th>
                <th>تاریخ شروع</th>
                <th>تاریخ پایان</th>

            </tr>
            </thead>

            <tbody>

                <tr>


                    <td style="padding-right: 15px">{{$order->pansionname}}</td>
                    <td>{{$order->roomnumber}}</td>
                    <td>{{$order->takhtnumber}}</td>
                    <td>{{$order->order_number}}</td>
                    <td>{{$order->karshenasName}}</td>
                    <td>{{$order->vaziat}}</td>
                    <td>{{$order->jabjayi}}</td>
                    <td>{{$order->jalaliRaft}}</td>
                    <td>{{$order->jalaliBargasht}}</td>

                </tr>

            </tbody>

        </table>

            </div>

        @if(count($order->statusmali[0]->qest)!=0)
            <div class="container card p-0 my-4">
                @if($order->recentQest!=null)
            <div class="row">
                <div class="col-12">     <h5 class="p-2" style="background: #cad0d0">نزدیک ترین قسط شما</h5></div>
                <div class="col-12">
                    <p class="p-2">{{$order->recentQest->jalaliTarikh}} به مبلغ {{number_format($order->recentQest->amount)}} تومان</p>

                </div>
            </div>
                @endif
    </div>
        @endif

            @if($order->pastTarikh!=null)
                <div class="container card my-4">
                <div class="row">
                    <div class="col-12 p-0">     <h5 class="p-2" style="background: #cad0d0">تاریخ های گذشته قسط شما</h5></div>
                    @foreach($order->pastTarikh as $past)
                    <div class="col-12" style="border-bottom:1px solid #92928e">
                        <p class="p-2">{{$past->jalaliTarikh}} به مبلغ {{number_format($past->amount)}} تومان</p>

                    </div>

                    @endforeach
                </div>


            @endif
    </div>
        @else
                <div class="container card px-5" style="margin-top: 330px;background-color: gainsboro">
        <h3 class="alert-info p-2" style="background-color: gainsboro">رزرو فعالی موجود نیست.</h3>

    </div>
    @endif

@endsection
