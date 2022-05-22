<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>شرکت بوم گردی دریاگشت</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS
    ========================= -->
    @include("store.master.mastercss")
    <style>
    @include('store.master.css')
    </style>
</head>
<body>
@include('store.master.header')
<!-- The Modal -->
<div class="modal" id="baskets">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

            </div>


        </div>
    </div>
</div>
@include('store.master.content')
@include('store.master.footer')
{{--@include("store.mastermain.kharid")--}}

@include("store.master.masterjs")

@include('store.master.js')

@toastr_render
@yield('tabjs')
</body>
</html>
