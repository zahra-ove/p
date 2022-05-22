<!doctype html>
<html class="no-js" lang="en">
<head>
    <style>
        @include('admin.master.css')
    </style>
</head>
<body id="#main" dir="rtl">
@if(\Illuminate\Support\Facades\Auth::check())
{{--@if(\Illuminate\Support\Facades\Auth::check())--}}

@include('admin.master.maincontent')
{{--@else--}}
{{--    <div class="container-fluid text-center m-5">--}}
{{--        <h1 class="alert-danger m-auto w-100 p-5">امکان دسترسی برای شما وجود ندارد.</h1>--}}
{{--    </div>--}}

{{--@endif--}}
<div class="position-fixed card w-100 py-2 px-4" style="text-align: left;bottom: 0">


</div>
{{--@include('admin.master.footer')--}}
{{--@include("admin.mastermain.kharid")--}}

{{--@include("admin.master.masterjs")--}}

    @include("admin.master.js")
<script>
    $('.select2').select2({
        placeholder: "انتخاب کنید.",
        "language": {
            "noResults": function(){
                return "موردی وجود ندارد.";                }
        }
    });
</script>

@toastr_render
@yield('tabjs')
@else
    <div class="container-fluid text-center position-relative h-100" style="margin-top: 300px">
        <div class="knsl-404 text-warning" style="top: 50%;left: 35%;font-size: 100px">خطای دسترسی</div>
        <p class="alert-danger" style="top: 50%;left: 35%">امکان دسترسی برای به این صفحه با این حساب مجاز نیست.</p>
    </div>

@endif
</body>
</html>
