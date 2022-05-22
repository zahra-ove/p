<!--bootstrap min css-->
<link rel="stylesheet" href="{{ asset('css') }}/bootstrap.min.css">

<!--tiny slider css-->
<link rel="stylesheet" href="{{ asset('store') }}/css/bootstrap-datepicker.min.css">
<!--persian-date css-->
<link rel="stylesheet" href="{{ asset('admin') }}/css/persianDatepicker-default.css">
<!--flatpickr.min.css css-->
<link rel="stylesheet" href="{{ asset('store') }}/css/fancybox.min.css">
<!--toastr.min css-->
<link rel="stylesheet" href="{{ asset('css') }}/toastr.min.css">
{{--<link rel="stylesheet" href="{{ asset('store') }}/css/nice-select.css">--}}
<link rel="stylesheet" href="{{ asset('store') }}/css/swiper.min.css">
<link rel="stylesheet" href="{{ asset('store') }}/css/style.css">
<link rel="stylesheet" href="{{ asset('admin') }}/css/select2.min.css">



@yield('pagecss')
{{--style--}}
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
