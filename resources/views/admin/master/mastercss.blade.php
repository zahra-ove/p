<!--bootstrap min css-->
<link rel="stylesheet" href="{{ asset('css') }}/bootstrap.min.css">
<!--bootstrap min css-->
<link rel="stylesheet" href="{{ asset('css') }}/main.css">
<!--jquery ui css-->
<link rel="stylesheet" href="{{ asset('admin') }}/css/jquery-ui.min.css">
<!--jquery ui theme css-->
<link rel="stylesheet" href="{{ asset('admin') }}/css/jquery-ui.theme.min.css">
<!--bootstrap-tour-standalone.min css-->
<link rel="stylesheet" href="{{ asset('admin') }}/css/bootstrap-tour-standalone.min.css">
<!--select2 css-->
<link rel="stylesheet" href="{{ asset('admin') }}/css/select2.min.css">
<!--select2-bootstrap.min css-->
<link rel="stylesheet" href="{{ asset('admin') }}/css/select2-bootstrap.min.css">
<!--toastr.min css-->
<link rel="stylesheet" href="{{ asset('css') }}/toastr.min.css">
<!--persian-date css-->
<link rel="stylesheet" href="{{ asset('admin') }}/css/persianDatepicker-default.css">
<link rel="stylesheet" href="{{ asset('admin') }}/css/persianDatepicker-dark.css">
<link rel="stylesheet" href="{{ asset('admin') }}/css/persianDatepicker-latoja.css">
<link rel="stylesheet" href="{{ asset('admin') }}/css/persianDatepicker-melon.css">
<link rel="stylesheet" href="{{ asset('admin') }}/css/persianDatepicker-lightorang.css">
<!--dropzone css-->
<link rel="stylesheet" href="{{ asset('admin') }}/css/dropzone.css">
<!--gallery css-->
<link rel="stylesheet" href="{{ asset('admin') }}/css/owl.carousel.min.css">
<!--gallery css-->
<link rel="stylesheet" href="{{ asset('admin') }}/css/switcher.css">
<!--jquery-clock-timepicker css-->
{{--<link rel="stylesheet" href="{{ asset('admin') }}/css/jquery-clock-timepicker.min.css">--}}
<!--datatable css-->
{{--<link rel="stylesheet" href="{{ asset('admin') }}/css/dataTables.bootstrap4.css">--}}
{{--<link rel="stylesheet" href="{{ asset('admin') }}/css/datatables.min.css">--}}
<style>

    @font-face {
        font-family: IRANYekan;
        font-style: normal;
        font-weight: normal;
        src:url('{{asset("fonts")}}/IRANYekan.eot');
        src:url('{{asset("fonts")}}/IRANYekan.eot?#iefix') format('embedded-opentype'),  /* IE6-8 */

        url('{{asset("fonts")}}/IRANYekan.ttf') format('truetype');
    }

    @font-face {
        font-family: "BTitr";
        font-style: normal;
        font-weight: normal;
        src:url('{{asset("fonts")}}/B Titr Bold_0.ttf');

    }


    @font-face {
        font-family: IRANSansWeb_Light;
        font-style: normal;
        font-weight: normal;
        src:url('{{asset("fonts")}}/IRANSansWeb_Light.eot');
        src:url('{{asset("fonts")}}/IRANSansWeb_Light.eot?#iefix') format('embedded-opentype'),  /* IE6-8 */
        url('{{asset("fonts")}}/IRANSansWeb_Light.ttf') format('truetype');
    }

    body {
        /*min-height: 100%;*/

    }
    .form-control{
        background: white!important;
        border: 1px solid #aaa!important;
    }
    .border-red {
        border: 2px solid #e50000!important;
    }
    thead{
        font-family: IRANYekan;
        font-weight: bold;
        background-color: #385572;

    }
    .table{
        border-radius:5px ;
    }
    @media (min-width: 991px) {
        #main-menu-nav-wrapper ul li {
            padding: 1px;
            display: inline-block;
            border-right: none;
            border-bottom: none;
            border-left: 1px solid var(--sidebarbordercolor);
        }

        #nav-wrapper li {
            padding-left: 19px !important;
            padding-right: 19px !important;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .profile-dropdown {
            right: auto !important;
            left: 10px !important;
        }

        .nav-wrapper {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1030;
        }
    }


    #nav-wrapper .navbarDropdown {
        text-align: center;
        font-size: 15px
    }

    #nav-wrapper nav {
        padding: 0;
    }

    .dropdown-menu {
        right: 0;
        margin-top: 0;
    }

    @media (max-width: 991px) {
        #nav-wrapper .navbarDropdown {
            text-align: right !important;
            padding-right: 26px!important;
            padding-bottom: 0px !important;

        }

        #main-menu-nav-wrapper .navbar-nav {
            padding: 0;
        }

        #main-menu-nav-wrapper .nav-link p {
            display: inline-block
        }
        #main-menu-nav-wrapper .dropdown-menu{
            box-shadow:0 0 0 !important;
            padding-top:0!important;
            margin-bottom:20px;
        }


    }

    .btn-red {
        background-color: #e01b30;
    }

    .navbar-light .navbar-nav .active>.nav-link,
    .navbar-light .navbar-nav .nav-link.active,
    .navbar-light .navbar-nav .nav-link.show,
    .navbar-light .navbar-nav .show>.nav-link {
        color: #e01b30;
    }
</style>
