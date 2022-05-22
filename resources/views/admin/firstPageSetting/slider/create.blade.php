@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $('.time').clockTimePicker();
        $(document).ready(function () {
@if($slider!='notfound')
            $('#gallery').append("<img class='single-show-img w-100' style='height: 400px' src='{{asset($slider->photo[0]->path)}}'> ");
@endif
            let addpubcheck = [];
//////ckeditor
//             CKEDITOR.replace('editor', {
//                 language: "fa",
//
//             });
            $('#showItem').change(function (e) {
                if ($(this).is(':checked')) {
                    $(this).val('1');
                } else {
                    $(this).val('0');
                }
            });
            $('#file').change(function (e) {

                let files = e.target.files;
                let file = files[0];
                let reader = new FileReader();
                reader.onload = (function (theFile) {

                    $('.single-show-img').remove();
                    var imgSrc = theFile.target.result;
                    $('#gallery').append("<img class='single-show-img w-100' style='height: 400px' src='" + imgSrc + "'> ");
                });
                reader.readAsDataURL(this.files[0]);
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
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">تنظیم بنر اصلی
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <form method="post" action="{{route('sliderstore')}}" enctype="multipart/form-data" id="submit">
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
                                <span class="form-label mb-2 position-relative" style="top: 24%">تیتر</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input class="form-control" name="title" id="title" value="{{$slider!='notfound'?$slider->title:''}}">
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
                                <span class="form-label mb-2 position-relative" style="top: 24%">توضیح</span>
                            </div>
                            <div class="col-10 p-0 ">
                                <textarea name="passage" class="w-100" style="min-height: 100px">{{$slider!='notfound'?$slider->passage:''}}</textarea>
                            </div>
                        </div>
                        <div class="col-12 mb-5 mt-3 row">
                            <label for="file" class="btn btn-info">تصویر جدید</label>
                            <input type="file" name="file" id="file" class="d-none">
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
