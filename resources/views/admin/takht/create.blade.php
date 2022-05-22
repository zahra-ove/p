@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $('.time').clockTimePicker();
        $(document).ready(function () {
            let addpubcheck = [];
            let photosCount = 0;
            $.switcher('#showItem');
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

            $('#pansionPick').change(function (ev) {
                let pansionId = $(this).val();
                $.ajax(
                    {
                        url: "{{asset('admin/getroombypansion')}}/" + pansionId,
                        success: function (data) {
                            $('#roomId').empty()
                            $('#roomId').append(`<option value="">اتاق راانتخاب کنید.</option>`);
                            data.forEach(function (item, index) {
                                $('#roomId').append(`<option value="${item.id}"> طبقه ${item.floor} اتاق ${item.roomnumber}  </option> `)
                            })

                        }
                    }
                )


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
//
// // Read in the image file as a data URL.

//             });


            $("#submit").submit(function (e) {
                if ($('#roomId').val().length == 0) {
                    e.preventDefault();
                    $('#roomId').addClass('border-red');
                    toastr.error('قسمت اتاق خالی است.');
                } else {
                    $('#roomId').removeClass('border-red');
                }
                if ($('#reservetypeId').val().length == 0) {
                    e.preventDefault();
                    $('#reservetypeId').addClass('border-red');
                    toastr.error('قسمت نوع رزرو خالی است.');
                } else {
                    $('#reservetypeId').removeClass('border-red');
                }
                if ($('#takhtnumber').val().length == 0) {
                    e.preventDefault();
                    $('#takhtnumber').addClass('border-red');
                    toastr.error('قسمت شماره تخت خالی است.');
                } else {
                    $('#takhtnumber').removeClass('border-red');
                }
                if ($('#floor').val().length == 0) {
                    e.preventDefault();
                    $('#floor').addClass('border-red');
                    toastr.error('قسمت طبقه تخت خالی است.');
                } else {
                    $('#floor').removeClass('border-red');
                }
                if ($('#price').val().length == 0) {
                    e.preventDefault();
                    $('#price').addClass('border-red');
                    toastr.error('قسمت قیمت روزانه خالی است.');
                } else {
                    $('#price').removeClass('border-red');
                }
                if ($('#pricemonth').val().length == 0) {
                    e.preventDefault();
                    $('#pricemonth').addClass('border-red');
                    toastr.error('قسمت قیمت ماهانه خالی است.');
                } else {
                    $('#pricemonth').removeClass('border-red');
                }

                let show = 0;
                $('#price').val($('#price').val().replaceAll(',', ""));
                $('#pricemonth').val($('#pricemonth').val().replaceAll(',', ""));
                if ($('#showItem').is(':checked')) {
                    $('#show').val('2');


                } else {
                    $('#show').val('1');
                }
                if (photosCount == 0) {
                    e.preventDefault();
                    toastr.error('حداقل یک تصویر باید بارگزاری شود.');
                }
            });
            $('#plusPhoto').click(function () {

                let tedad = $('.file-attach').length;
                $('#album').append(`<div class="row row-photo" style="border-bottom: 1px solid #aaaa">
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

    .single-show-img {
        width: 225px;
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
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">افزودن تخت
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <form method="post" action="{{route('takht.store')}}" enctype="multipart/form-data" id="submit">
        @csrf
        <div class="container card" style="margin-top: 330px;background-color: gainsboro">
            <div class="row">
                <div class="col-12 mt-5">
                    <div class="row justify-content-between px-4">
                        <div class="col-lg-4 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">انتخاب خوابگاه</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <select name="cityId" class="form-control select2" id="pansionPick">
                                    <option value="">خوابگاه را انتخاب کنید.</option>
                                    @if($pansions!="notfound")
                                        @foreach($pansions as $pansion)
                                            <option value="{{$pansion->id}}">{{$pansion->name}}</option>
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
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">انتخاب اتاق</span>

                            </div>
                            <div class="col-9 p-0 ">
                                <select name="roomId" class="form-control select2" id="roomId">
                                    <option value="">اتاق را انتخاب کنید.</option>

                                </select>
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
                                <span class="form-label mb-2 position-relative" style="top: 24%">نوع رزرو</span>

                            </div>
                            <div class="col-9 p-0 ">
                                <select name="reservetypeId" class="form-control select2" id="reservetypeId">
                                    <option value="">نوع رزرو را انتخاب کنید.</option>
                                    @if($reservetypes!="notfound")
                                        @foreach($reservetypes as $reservetype)
                                            <option value="{{$reservetype->id}}">{{$reservetype->title}}</option>
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
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">شماره تخت</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input type="number" min="1" class="form-control" id="takhtnumber" name="takhtnumber">
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
                                <span class="form-label mb-2 position-relative" style="top: 24%">طبقه تخت</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input type="number" min="1" class="form-control" id="floor" name="floor">
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
                                <span class="form-label mb-2 position-relative" style="top: 24%">قیمت روزانه</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input class="justnumber form-control seprator" id="price" name="price">
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
                                <span class="form-label mb-2 position-relative" style="top: 24%">قیمت ماهانه</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input class="justnumber form-control seprator" id="pricemonth" name="pricemonth">
                            </div>
                        </div>


                    </div>
                    <div class="row px-4">
                        <div class="col-12 mb-5 mt-3 w-25 row">
                            <label class="form-label mb-2 col-1" for="submit-ostan">نمایش</label>
                            <input type="checkbox" class="form-control seprator justnumber col-1" id="showItem"
                                   autocomplete="off">
                            <input name="show" class="d-none" id="show" value="0">
                        </div>
                    </div>


                </div>

                <div class="col-12 mt-5 row m-auto">
                    <div class="col-12 row m-auto">

                        <div class="col-12  mb-3 text-center text-lg-left">

                        <span style="cursor:pointer;width: 157px!important;" class="btn btn-info w-25"
                              data-toggle="modal" data-target="#modalPhoto">
                            ثبت تصویر
                        </span>
                            <!-- PhotoModal -->
                            <div id="modalPhoto" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-lg">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header row" style="text-align: right" dir="ltr">
                                            <button type="button" class="close m-1" data-dismiss="modal">&times;
                                            </button>
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
                        <div class="col-12 mb-3 text-center text-lg-right">
                            <button type="submit" style="width: 157px!important;" class="w-25 btn btn-success pt-2 pb-2"
                                    id="productsubmit">ثبت
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>

@endsection
