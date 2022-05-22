<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>شرکت بوم گردی دریاگشت</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS
    ========================= -->
    @include("store.master.mastercss")
    <style>
        @include('store.master.css')
    </style>
</head>
<body dir="rtl">

@include('store.master.header')
@include('store.master.maincontent')
@include('store.master.footer')
{{--@include("store.mastermain.kharid")--}}

@include("store.master.masterjs")
@include("store.master.js")

@toastr_render
@yield('tabjs')
</body>
</html>
