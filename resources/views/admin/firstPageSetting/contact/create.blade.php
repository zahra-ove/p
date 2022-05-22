@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $('.time').clockTimePicker();
        $(document).ready(function () {

            let addpubcheck = [];
////ckeditor
//             CKEDITOR.replace('about_us', {
//                 language: "fa",
//
//             });
            CKEDITOR.replace('address', {
                language: "fa",

            });
            $('#showItem').change(function (e) {
                if ($(this).is(':checked')) {
                    $(this).val('1');
                } else {
                    $(this).val('0');
                }
            });



            $("#submit").submit(function (e) {


                // let description = CKEDITOR.instances.editor.getData();
                // let url = $("#urlVideo").val();
                let show = 0;
                $('#price').val($('#price').val().replaceAll(',', ""));
                if ($('#showItem').is(':checked')) {
                    $('#show').val('2');


                } else {
                    $('#show').val('1');
                }

            });

        });
    </script>
@endsection
<style>
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
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">تنظیم تماس با ما
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <form method="post" action="{{route('contactstore')}}" enctype="multipart/form-data" id="submit">
        @csrf
        <div class="container card" style="margin-top: 330px;background-color: gainsboro">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="row justify-content-between px-4">

                        <div class="col-lg-6 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">شماره تماس</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input class="form-control" name="phone" id="phone" value="{{$contact!='notfound'?$contact->phone:''}}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">ایمیل</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input class="form-control" name="email" id="email" value="{{$contact!='notfound'?$contact->email:''}}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-2 p-0 text-center position-relative h-100" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">آدرس</span>
                            </div>
                            <div class="col-10 p-0 ">
                                <textarea name="address" class="w-100" style="min-height: 100px">{{$contact!='notfound'?$contact->address:''}}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12 row mb-3 text-center m-auto" id="gallery">
                </div>
                <div class="col-12 mb-5 mt-5  pl-5 text-center text-lg-right">
                            <button style="width: 91px" class="btn btn-success pt-2 pb-2" id="ostansubmit">ثبت</button>

                </div>
            </div>
        </div>
    </form>
    </div>

@endsection
