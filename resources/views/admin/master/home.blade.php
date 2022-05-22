<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>شرکت بوم گردی دریاگشت</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="{{csrf_token()}}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="">

    <!-- CSS
    ========================= -->

    @include("admin.master.mastercss")

    <style>
        * { margin: 0; padding: 0; outline: 0; }
        body{line-height: 1;}
        .select2-selection{

            min-height: 38px!important;

        }
        .breadcrumb-item.active{
            color: red!important;
        }
        @media print {
            .position-fixed{
                display: none;
            }
        }
        @include('admin.master.css')
    </style>
</head>

<body id="#main" dir="rtl">
@if(\Illuminate\Support\Facades\Auth::check())
@include('admin.master.header')
@include('admin.master.maincontent')

@if(\Illuminate\Support\Facades\Auth::user()->group()->where('group_id',3)->exists())
{{--    @if($user_mali)--}}
        <div class="position-fixed card w-100 py-2 px-4" style="text-align: left;bottom: 0">
            <div class="row mx-0 py-2" style="border-top: 1px solid #aaaaaa">

                <div class="col-lg-12 col-12 row">

{{--                    <div class="col-3 order-3"> <a href="#" class="btn btn-lg btn-success w-50">تسویه</a> </div>--}}

                    <div class="col-lg-9 col-12 row order-2 justify-content-center" style="font-size: 18px;align-items: center;">
                        <div class="d-flex flex-row justify-content-center">
                            @if($maande > 0)
                                <div class="col ml-1" style="font-size:14px;font-weight:bold;">بستانکار:</div>
                                <div class="col m-0 p-0" style="font-size:12px;font-weight:bold;text-align: right;">{{ abs($maande) }}تومان </div>
                            @else
                                <div class="col ml-1" style="font-size:14px;font-weight:bold;">بدهکار:</div>
                                <div class="col m-0 p-0" style="font-size:12px;font-weight:bold;text-align: right;">{{ $maande }}تومان </div>
                            @endif

                            <div class="col-7 ml-1" style="font-size:14px;font-weight:bold;">موجودی کیف پول:</div>
                            <div class="col m-0 p-0" style="font-size:12px;font-weight:bold;text-align: right;">{{ $wallet_mojoodi }}تومان </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
{{--    @endif--}}
@endif
@include("admin.master.masterjs")
@include("admin.master.js")


@toastr_render
@yield('tabjs')
@else
    <div class="container-fluid text-center position-relative h-100" style="margin-top: 300px">
        <div class="knsl-404 text-warning" style="top: 50%;left: 35%;font-size: 100px">خطای دسترسی</div>
        <p class="alert-danger" style="top: 50%;left: 35%">امکان دسترسی برای به این صفحه با این حساب مجاز نیست.</p>
        <a class="btn btn-success btn-lg" href="{{asset('')}}" style="border-radius: 25px;">بازگشت به خانه</a>
    </div>
@endif

</body>
</html>
