@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">

@section('js')
{{--    <script src="https://rawgit.com/abdennour/hijri-date/master/cdn/hijri-date-latest.js"--}}
{{--            type="text/javascript"></script>--}}
    <script src="{{asset('admin/js/hijri-date-latest.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin')}}/js/jdate.min.js" type="text/javascript" charset="utf-8"></script>
    <script>

        $(document).ready(function () {
            let ezaaf = 1;

            let addpubcheck = [];
            $('.wallet').hide();


            $('#user').change(function (ev) {
                $('.wallet').hide();
                let userId = $(this).val();
                $(`input[name=user_id]`).val(userId);
                $('#walletType').val(null).trigger('change');

            });
            $('#walletType').change(function (ev) {
                $('#fish-bardasht').val(null);
                $('#fish-variz').val(null);
                $('#variz').val('0');
                $('#bardasht').val('0');
                $('.fa-check').remove();

                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                if ($('#user').val().length != 0) {
                    if ($(this).val() != "") {
                        $('.wallet').show();
                        if ($(this).val() == 'cash') {
                            $('#cashSubmit').show();
                            $('#depositeSubmit').hide();
                            let mablagh = $('#user').find(':selected').attr('wallet');
                            if (mablagh < 0) {
                                $('#bardasht').val(numberWithCommas(Math.abs(mablagh)));
                            } else {
                                $('#bardasht').val(0);
                            }
                        }
                        if ($(this).val() == 'deposite') {
                            $('#depositeSubmit').show();
                            $('#cashSubmit').hide();
                        }
                    }
                } else {
                    toastr.warning('مشترک را انتخاب کنید.');
                }


            });
            ///setProductsForm
            $('#fish-variz').change(function (e) {
                $(this).after('<i class="fa fa-check fa-2x text-success px-1"></i>');

            });

            $('#fish-bardasht').change(function (e) {
                $(this).after('<i class="fa fa-check fa-2x text-success px-1"></i>');

            });
//
// // Read in the image file as a data URL.

//             });


            $("#depositeSubmit").submit(function (e) {

                $('#userId').val()
                let depoVal = $('#variz').val().replaceAll(',', "");
                $('#variz').val($('#variz').val().replaceAll(',', ""));
                if ($('#fish-variz').val().length == 0) {
                    e.preventDefault();
                    toastr.error('تصویری فیش بارگذاری نشده است.');
                }
                if (depoVal < 50000) {
                    e.preventDefault();
                    toastr.warning('حداقل واریزی 50,000 تومان باید باشد.');
                }
                if (depoVal == null) {
                    e.preventDefault();
                    toastr.error('کادر خالی را پر کنید.');
                }


            });

            $("#cashSubmit").submit(function (e) {

                $('#userId').val()
                let cashVal = $('#bardasht').val().replaceAll(',', "");
                let mablagh = $('#user').find(':selected').attr('wallet');
                $('#bardasht').val($('#bardasht').val().replaceAll(',', ""));

                if (cashVal == "") {
                    e.preventDefault();
                    toastr.error('کادر خالی را پر کنید.');
                }
                if (cashVal == "0") {
                    e.preventDefault();
                    toastr.error('مبلغ وارد شده درست نیست.');
                }
                if ($('#fish-bardasht').val().length == 0) {
                    e.preventDefault();
                    toastr.error('تصویری فیش بارگذاری نشده است.');
                }
                if (Math.abs(mablagh)<cashVal) {
                    e.preventDefault();
                    toastr.error('مبلغ بیشتر از مقدار داخل کیف پول است.');
                }
            });
        });
    </script>

@endsection
<style>

    #timeTable {
        height: 448.719px;
    }

    .select2 {
        width: 100% !important;
    }

    @media (min-width: 992px) {
        .container {
            max-width: 992px !important;
        }

        .mr-140 {
            margin-right: 140px !important;
        }
    }

    @media (min-width: 1200px) {
        .container {
            max-width: 1200px !important;
        }
    }


    @media (min-width: 1500px) {
        .container {
            max-width: 1500px !important;
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
</style>
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
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">مدیریت کیف
                            پول
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <div class="container card mb-5" style="margin-top: 330px;background-color: gainsboro;">
        <div class="row">
            <div class="col-12 col-lg-3 ml-5 mb-5 mt-5 row">
                <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                      <span class="position-relative" style="top: 24%">
                            مشترک
                        </span>

                </div>
                <div class="col-9 p-0 ">
                    <select name="user_id" class="select2 form-control" id="user">
                        <option value="">مشترک را انتخاب کنبد.</option>
                        @if($users!='notfound')
                            @foreach($users as $user)
                                <option value="{{$user->id}}" data-id="{{$user->id}}"
                                        wallet="{{$user->wallet[0]->bedehkar}}">{{$user->name}} {{$user->family}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-3 ml-5 mb-5 mt-5 row">
                <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                      <span class="position-relative" style="top: 24%">
                            نوع تراکنش
                        </span>

                </div>
                <div class="col-9 p-0 ">
                    <select name="walletType" class="select2 form-control" id="walletType">
                        <option value="">یسیس</option>
                        <option value="deposite">واریز</option>
                        <option value="cash">برداشت</option>

                    </select>
                </div>
            </div>
        </div>

        <!-- reserves table-->
        <div class="container border-top row wallet">
            {{--BARDASHT--}}
            <form method="post" id="cashSubmit" action="{{route('cash')}}" class="w-100" enctype="multipart/form-data">

                @csrf
                <input name="user_id" class="d-none">
                <div class="container m-auto">
                    <h2 class="ml-5" id="bardashtTitr">برداشت</h2>
                    <div class="row ">
                        <div class="col-12 col-lg-3 ml-5 mb-5 mt-5 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                      <span class="position-relative" style="top: 24%">
                           مبلغ
                        </span>

                            </div>
                            <div class="col-9 p-0 ">
                                <input name="price" id="bardasht" class="seprator form-control justnumber"
                                       autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12 col-lg-3 ml-5 mb-5 mt-5 row">
                            <label for="fish-bardasht" class="btn btn-info h-75">فیش تراکنش</label>
                            <input class="d-none" name="fish" min="0" type="file" id="fish-bardasht">
                        </div>
                        <div class="col-12 ml-5 mb-5 mt-5 row">

                            <input type="submit" class="btn btn-success" value="برداشت">
                        </div>
                    </div>
                </div>
            </form>
            {{--VARIZ--}}
            <form method="post" action="{{route('deposite')}}" class="w-100" id="depositeSubmit" enctype="multipart/form-data">
                @csrf
                <input name="user_id" id="userId" class="d-none">
                <div class="container m-auto">
                    <h2 class="ml-5" id="variztTitr">واریز</h2>
                    <div class="row ">
                        <div class="col-12 col-lg-3 ml-5 mb-5 mt-5 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                      <span class="position-relative" style="top: 24%">
                           مبلغ
                        </span>

                            </div>
                            <div class="col-9 p-0 ">
                                <input name="price" id="variz" class="seprator form-control justnumber" value="0"
                                       autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12 col-lg-3 ml-5 mb-5 mt-5 row">
                            <label for="fish-variz" class="btn btn-info h-75">فیش تراکنش</label>
                            <input class="d-none" name="fish" min="0" type="file" id="fish-variz">
                        </div>
                        <div class="col-12 ml-5 mb-5 mt-5 row">

                            <input type="submit" class="btn btn-success" value="شارژ">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
