@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $('.time').clockTimePicker();
        $(document).ready(function () {
            let addpubcheck = [];
            let photosCount=0;
$.switcher('#showItem');
            $('#videoFile').change(function (e) {

                if (e.target.files[0].type == 'video/mp4' || e.target.files[0].type == 'video/x-matroska') {
                    $('#videoVideo').remove();
                    let reader = new FileReader();
                    reader.onload = (function (theFile) {
                        var videoSrc = theFile.target.result;
                        $('#sourceVideo').html(`  <source id="sourceVideo" src="${videoSrc}" type="video/mp4">`);
                        $(`#sourceVideo`).after(`<span class='btn btn-danger' id="deleteVideo">حذف ویدیو</span>`);
                        $('#deleteVideo').click(function (ed) {
                            $('#sourceVideo').empty();
                            $('#video').addClass('d-none');
                            $('#videoFile').val(null);
                            $(this).remove();
                        });
                    });
                    reader.readAsDataURL(this.files[0]);
                    $('#video').removeClass('d-none');
                } else {
                    toastr.error('نوع فایل باید حتما از فرمت های ویدیو باشد.');
                }

            });

            ///setProductsForm
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



            $("#submit").submit(function (e) {




                // let description = CKEDITOR.instances.editor.getData();
                // let url = $("#urlVideo").val();
                let show = 0;

                if ($('#showItem').is(':checked')) {
                    $('#show').val('1');


                } else {
                    $('#show').val('0');
                }


                if ($('#name-pansion').val().length == 0) {
                    e.preventDefault();
                    $('#name-pansion').addClass('border-red');
                    toastr.error('قسمت نام خوابگاه خالی است.');
                } else {
                    $('#name-pansion').removeClass('border-red');
                }
                if ($('#countrooms').val().length == 0) {
                    e.preventDefault();
                    $('#countrooms').addClass('border-red');
                    toastr.error('قسمت تعداد اتاق خالی است.');
                } else {
                    $('#countrooms').removeClass('border-red');
                }
                if ($('#counttakhts').val().length == 0) {
                    e.preventDefault();
                    $('#counttakhts').addClass('border-red');
                    toastr.error('قسمت تعداد تخت خالی است.');
                } else {
                    $('#counttakhts').removeClass('border-red');
                }
                if ($('#cityId').val().length == 0) {
                    e.preventDefault();
                    $('#cityId').addClass('border-red');
                    toastr.error('قسمت شهر خالی است.');
                } else {
                    $('#cityId').removeClass('border-red');
                }
                if ($('#floors').val().length == 0) {
                    e.preventDefault();
                    $('#floors').addClass('border-red');
                    toastr.error('قسمت تعداد طبقات خالی است.');
                } else {
                    $('#floors').removeClass('border-red');
                }
                if ($('#addrtitle').val().length == 0) {
                    e.preventDefault();
                    $('#addrtitle').addClass('border-red');
                    toastr.error('قسمت عنوان آدرس خالی است.');
                } else {
                    $('#addrtitle').removeClass('border-red');
                }
                if ($('#addr').val().length == 0) {
                    e.preventDefault();
                    $('#addr').addClass('border-red');
                    toastr.error('قسمت آدرس خالی است.');
                } else {
                    $('#addr').removeClass('border-red');
                }
                if (photosCount == 0) {
                    e.preventDefault();
                    toastr.error('حداقل یک تصویر باید بارگزاری شود.');
                }

            });
            $('#plusPhoto').click(function () {

                let tedad = $('.file-attach').length;
                $('#album').append(` <div class="row row-photo" style="border-bottom: 1px solid #aaaa">
                                                        <div class="col-6 my-2 row" style="text-align: right">
                                                        <div class="col-2">
                                                            <h3>${tedad + 1}.</h3>
                                                            </div>
<div class="col-10">
                                                            <label for="attach-${tedad + 1}" class="btn btn-info mt-2 file-attach-label">انتخاب تصویر</label>

                                                            <input name="attach[]" class="d-none file-attach" id="attach-${tedad + 1}" type="file">
                                                        </div>
                                                        </div>
                                                        <div class="col-6 my-2 ncodePic" style="height: 150px">

                                                        </div>
                                                    </div>`);
                $('.file-attach').change(function (e) {
                    photosCount=photosCount+1;
                    $(this).siblings('.deletePhoto').remove();
                    let files = e.target.files;
                    let $this = $(this);
                    let reader = new FileReader();
                    reader.onload = (function (theFile) {
                        var imgSrc = theFile.target.result;
                        $this.parents('.col-6').siblings('.ncodePic').html("<img class='single-show-img h-100' src='" + imgSrc + "'> ")
                    });
                    $this.after(`    <span style="cursor: pointer;margin-right: 10px;" class="btn btn-danger mt-2 w-25 deletePhoto">حذف</span>`)

                    reader.readAsDataURL(this.files[0]);
                    $('.deletePhoto').click(function (esd) {
                        photosCount=photosCount-1;
                        $(this).parents('.row-photo').first().remove();
                    });
                });
            });
            $('.file-attach').change(function (e) {
                photosCount=photosCount+1;
                $(this).siblings('.deletePhoto').remove();
                let files = e.target.files;
                let $this = $(this);
                let reader = new FileReader();
                reader.onload = (function (theFile) {
                    var imgSrc = theFile.target.result;
                    $this.parents('.col-6').siblings('.ncodePic').html("<img class='single-show-img h-100' src='" + imgSrc + "'> ")
                });
                $this.after(`    <span style="cursor: pointer;margin-right: 10px;" class="btn btn-danger mt-2 w-25 deletePhoto">حذف</span>`)

                reader.readAsDataURL(this.files[0]);

                $('.deletePhoto').click(function (esd) {
                    photosCount=photosCount-1;
                    $(this).parents('.row-photo').first().remove();
                });
            });

        })
    </script>
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

        @media (max-width: 992px) {
            .mr-140 {
                margin-right: 140px !important;
            }
            .mb-sm-100{
                margin-bottom: 100px!important;
            }
        }

        @media (max-width: 576px) {
            .mr-140 {
                margin-right: 60px !important;
            }
            .mb-sm-100{
                margin-bottom: 100px!important;
            }
        }

        .breadcrumb {
            background-color: white !important;
        }
        .single-show-img{
            width: 225px;
        }
    </style>
@endsection
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
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">افزودن
                            خوابگاه
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <form method="post" action="{{route('pansion.store')}}" enctype="multipart/form-data" id="submit">
        @csrf
        <div class="container card " style="margin-top: 330px;background-color: gainsboro">
            <div class="row mt-5">
                <div class="col-12  m-auto">
                    <div class="row justify-content-between px-4">
                        <div class="col-lg-4 of col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">نام</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input class="form-control" id="name-pansion" name="name">
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">تعداد اتاق ها</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input type="number" class="form-control" id="countrooms" name="countrooms">
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">تعداد تخت ها</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input type="number" class="form-control" id="counttakhts" name="counttakhts">
                            </div>
                        </div>

                    </div>
                    <div class="row justify-content-between px-4">

                        <div class="col-lg-4 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">شهر</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <select name="cityId" class="form-control select2" id="cityId">
                                    <option value="">شهر را انتخاب کنید.</option>
                                    @if($cities!="notfound")
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{$city->cityName}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">تعداد طبقات</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input type="number" class="form-control" id="floors" name="floors">
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">نوع خوابگاه</span>
                            </div>
                            <div class="col-9 ">
                                <input type="radio" class="mt-2" id="male" name="gender" value="male" checked>
                                <label class="mt-2" for="male">پسرانه</label>
                                <input class="mt-2" type="radio" id="female" name="gender" style="margin-right: 40px;"
                                       value="female">
                                <label class="mt-2" for="female">دخترانه</label>
                            </div>
                        </div>
                        {{--                    <div class="col-lg-4 col-12 mb-5 mt-3"  dir="ltr">--}}
                        {{--                        <label class="form-label mb-2" for="vorud">ساعت ورود</label>--}}
                        {{--                        <br>--}}
                        {{--                        <input class="form-control time" id="vorud" name="vorud">--}}
                        {{--                    </div>--}}
                        {{--                    <div class="col-lg-4 col-12 mb-5 mt-3"  dir="ltr">--}}
                        {{--                        <label class="form-label mb-2" for="khoruj" >ساعت خروج</label>--}}
                        {{--                            <br>--}}
                        {{--                        <input  class="form-control time" id="khoruj" name="khoruj">--}}
                        {{--                    </div>--}}
                        <div class="col-4 mb-5 mt-3 w-25 row">
                            <label class="form-label mb-2 col-2" for="submit-ostan">نمایش</label>
                            <input type="checkbox" class="form-control seprator justnumber col-1" id="showItem"
                                   autocomplete="off">
                            <input name="show" class="d-none" id="show">
                        </div>
                        <div class="col-12">
                            <h3>آدرس</h3>
                        </div>
                        <div class="col-12 col-md-4 mb-2 mt-5 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">عنوان آدرس</span></div>
                            <div class="col-9 p-0 ">
                                <input class="form-control" name="title" id="addrtitle">
                            </div>
                        </div>
                        <div class="col-12 mb-5 mt-2 row">
                            <div class="form-label mb-2 col-1 p-0 text-center position-relative h-100" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative h-100" style="top: 24%">آدرس</span>

                            </div>
                            <div class="col-11 p-0 ">
                                <textarea class="form-control" name="addr" id="addr"></textarea>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-12 mt-5 mb-sm-100 row">
                    <div class="col-12 mt-5 row m-auto">
                    <div class="col-lg-6 col-12 text-center text-lg-left mt-lg-5 mb-3">

                        <span style="cursor:pointer;" class="btn btn-info w-25" data-toggle="modal"
                              data-target="#modalPhoto">
                            ثبت تصویر
                        </span>
                        <!-- PhotoModal -->
                        <div id="modalPhoto" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header row" style="text-align: right" dir="ltr">
                                        <button type="button" class="close m-1" data-dismiss="modal">&times;</button>
                                        <div class="col-12">
                                            <h3 class="w-100">آپلود تصویر</h3>
                                        </div>


                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid" id="album">
                                            <div class="row mb-4" style="border-bottom: 1px solid #aaaaaa">
                                                <h4 class="d-inline px-4">بیشتر</h4>
                                                <span id="plusPhoto"><i class="fa fa-plus fa-2x"
                                                                        style="cursor: pointer"></i> </span>
                                            </div>



                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 text-center text-lg-left mt-lg-5 mb-3"></div>
                    <div class="col-lg-6 col-12 text-center text-lg-left mt-lg-2 mb-3">
                        <label for="videoFile" class="w-25 btn btn-secondary pt-2 pb-2">آپلود ویدیو</label>
                        <input id="videoFile" name="video" type="file" class="d-none">
                    </div>
                        <div class="col-lg-6 col-12"></div>
                        <div class="col-lg-6 col-12"></div>
                    <div class=" col-lg-6 mt-lg-2 mb-3 text-center text-lg-right">
                        <button type="submit" class="w-25 btn btn-success pt-2 pb-2" id="productsubmit">ثبت</button>
                    </div>
                    <div class="col-12">
                        <div class="w-100 bg-dark d-none" id="video">
                            <video class="w-100" controls id="sourceVideo" style="margin-left: 10px">

                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div></div>
    </form>
    </div>

@endsection
