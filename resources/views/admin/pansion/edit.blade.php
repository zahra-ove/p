@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $('.time').clockTimePicker();
        $(document).ready(function () {
            let photosCount = $('.single-show-img').length;

            $.switcher('#showItem')
            let addpubcheck = [];
            $('#videoFile').change(function (e) {

                $('#isvideo').val('1');
                if (e.target.files[0].type == 'video/mp4' || e.target.files[0].type == 'video/x-matroska') {
                    $('#videoVideo').remove();
                    $('#detachVideo').remove();
                    $('#sourceVideo').removeClass('d-none');
                    let reader = new FileReader();
                    reader.onload = (function (theFile) {
                        var videoSrc = theFile.target.result;
                        $('#sourceVideo').html(`  <source id="sourceVideo" src="${videoSrc}" type="video/mp4">`);
                        $(`#video`).after(`<span class='btn btn-danger text-center' id="deleteVideo">حذف ویدیو</span>`);
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
            $('#detachVideo').click(function (e) {
                $('#isvideo').val(null);
                $('#video').addClass('d-none');
            });
            $('.detachPhoto').click(function (ee) {
                let id = $(this).attr('data-id');
                photosCount = photosCount - 1;
                let $this = $(this);
                $.ajax(
                    {
                        url: "{{asset('admin/deletephoto')}}/" + id,
                        type: 'post',
                        data: {'_token': "{{csrf_token()}}"},
                        success: function (data) {
                            if (data != 'notfound') {
                                if ($this.parents('.existPhotos').children('.pick').children('.col-2').children('input').prop('checked')){
                                    $('input[name=pick]').last().prop('checked',true);
                                }
                                $this.parents('.existPhotos').first().remove();
                            }
                        }
                    }
                )
            });


            $("#submit").submit(function (e) {

                if ($('#showItem').is(':checked')) {
                    $('#show').val('1');


                } else {
                    $('#show').val('0');
                }
                let show = 0;

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
                $('#album').append(` <div class="row  row-photo" style="border-bottom: 1px solid #aaaa">
                                                        <div class="col-md-5 my-2 row" style="text-align: right">
                                                        <div class="col-3">
                                                            <h3>${tedad + 1}.</h3>
                                                            </div>
<div class="col-9">
                                                            <label for="attach-${tedad + 1}" class="btn btn-info mt-2 file-attach-label w-50">انتخاب تصویر</label>

                                                            <input name="attach[]" class="d-none file-attach" id="attach-${tedad + 1}" type="file">
                                                        </div>
                                                        </div>
<div class="col-md-4 my-2 row pick" style="text-align: right;visibility: hidden">
                                                            <div class="col-lg-7 col-9">
                                                                عکس معرفی
                                                            </div>
                                                            <div class="col-2">
                                                                                                                                    <input name="pick" type="radio">
                                                                                                                            </div>
                                                        </div>
                                                        <div class="col-3 my-2 ncodePic" style="height: 150px">

                                                        </div>
                                                    </div>`);
                $('.file-attach').change(function (e) {

                    photosCount = photosCount + 1;
                    $(this).siblings('.deletePhoto').remove();
                    let files = e.target.files;
                    let $this = $(this);
                    let reader = new FileReader();
                    reader.onload = (function (theFile) {
                        var imgSrc = theFile.target.result;
                        $this.parents('.col-md-5').siblings('.ncodePic').html("<img class='single-show-img h-100' src='" + imgSrc + "'> ");
                    });
                    $this.after(`    <span style="cursor: pointer" class="btn btn-danger mt-2 w-50 deletePhoto">حذف</span>`)
                    $this.parents('.col-md-5').siblings('.pick').children(".col-2").children('input').attr('value',e.target.files[0].name);
                    $this.parents('.col-md-5').siblings('.pick').css('visibility','visible');
                    reader.readAsDataURL(this.files[0]);

                    $('.deletePhoto').click(function (esd) {
                        photosCount = photosCount - 1;
                        $(this).parents('.row-photo').first().remove();
                        if ($(this).parents('.row-photo').children('.pick').children('.col-2').children('input').prop('checked')) {

                            $('input[name=pick]').last().prop('checked', true);
                        }

                    });
                });
            });
            $('.file-attach').change(function (e) {
                photosCount = photosCount + 1;
                $(this).siblings('.deletePhoto').remove();
                let files = e.target.files;
                let $this = $(this);
                let reader = new FileReader();
                reader.onload = (function (theFile) {
                    var imgSrc = theFile.target.result;
                    $this.parents('.col-6').siblings('.ncodePic').html("<img class='single-show-img h-100' src='" + imgSrc + "'> ")
                });
                $this.after(`    <span style="cursor: pointer" class="btn btn-danger mt-2 w-50 deletePhoto">حذف</span>`)

                reader.readAsDataURL(this.files[0]);

                $('.deletePhoto').click(function (esd) {
                    photosCount = photosCount - 1;
                    $(this).parents('.row-photo').first().remove();
                    if ($(this).parents('.row-photo').children('.pick').children('.col-2').children('input').prop('checked')){
                        $('input[name=pick]').last().prop('checked',true);
                    }

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
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('pansion.index')}}">لیست
                                خوابگاه ها</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">ویرایش
                            خوابگاه {{$pansion->name}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <form method="post" action="{{route('pansion.update',$pansion->id)}}" enctype="multipart/form-data" id="submit">
        @csrf
        @method('patch')
        <div class="container card" style="margin-top: 330px;background-color: gainsboro">
            <div class="row">
                <div class="col-12 mt-5">
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
                                <input value="{{$pansion->name}}" class="form-control" id="name-pansion" name="name">
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
                                <input value="{{$pansion->countrooms}}" type="number" class="form-control"
                                       id="countrooms" name="countrooms">
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
                                <input value="{{$pansion->counttakhts}}" type="number" class="form-control"
                                       id="counttakhts" name="counttakhts">
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
                                            @if($city->id==$pansion->city_id)
                                                <option value="{{$city->id}}" selected>{{$city->cityName}}</option>
                                            @else
                                                <option value="{{$city->id}}">{{$city->cityName}}</option>
                                            @endif
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
                                <input value="{{$pansion->floors}}" type="number" class="form-control" id="vorud"
                                       name="floors">
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
                                @if($pansion->gender=='male')
                                    <input type="radio" class="mt-2" id="male" name="gender" value="male" checked>
                                    <label class="mt-2" for="male">پسرانه</label>
                                    <input class="mt-2" type="radio" id="female" name="gender"
                                           style="margin-right: 40px;" value="female">
                                    <label class="mt-2" for="female">دخترانه</label>
                                @elseif($pansion->gender=='female')
                                    <input type="radio" class="mt-2" id="male" name="gender" value="male">
                                    <label class="mt-2" for="male">پسرانه</label>
                                    <input class="mt-2" type="radio" id="female" name="gender"
                                           style="margin-right: 40px;" value="female" checked>
                                    <label class="mt-2" for="female">دخترانه</label>
                                @endif
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
                            @if($pansion->show=='0')
                                <input type="checkbox" class="form-control col-1" id="showItem"
                                       autocomplete="off">
                                <input name="show" class="d-none" id="show" value="0">
                            @elseif($pansion->show=='1')
                                <input type="checkbox" checked class="form-control col-1" name="show" id="showItem"
                                       autocomplete="off">
                                <input name="show" class="d-none" id="show" value="1">
                            @endif
                        </div>
                        <div class="col-12">
                            <h3>آدرس</h3>
                        </div>
                        <div class="col-12 col-md-6 mb-2 mt-5 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">عنوان آدرس</span></div>
                            <div class="col-9 p-0 ">
                                @if(count($pansion->address)!=0)
                                    <input value="{{$pansion->address[0]->title}}" class="form-control" name="title"
                                           id="addrtitle">
                                @else
                                    <input class="form-control" name="title" id="addrtitle">
                                @endif
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
                                <textarea class="form-control" name="addr"
                                          id="addr">@if(count($pansion->address)!=0){{$pansion->address[0]->addr}}@endif</textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-12 mt-5 row m-auto" style="margin-bottom: 100px">
                    <div class="col-12 row m-auto">
                        <div class="col-12 mb-3">

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
                                                                            style="cursor: pointer"></i>
                                                    </span>
                                                </div>
                                                @foreach($pansion->photo as $key=>$p)
                                                    <div class="row existPhotos" style="border-bottom: 1px solid #aaaa">
                                                        <div class="col-md-5 my-2 row" style="text-align: right">
                                                            <div class="col-3">
                                                                <h3>{{++$key}}.</h3>
                                                            </div>
                                                            <div class="col-9">
                                                                <span data-id="{{$p->id}}"
                                                                      style="cursor: pointer"
                                                                      class="btn btn-danger mt-2 w-50 detachPhoto">حذف</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 my-2 row pick" style="text-align: right">
                                                            <div class="col-lg-7 col-9">
                                                                عکس معرفی
                                                            </div>
                                                            <div class="col-2">
                                                                @if($p->pick=='1')
                                                                    <input name="pick" type="radio" value="{{$p->id}}"
                                                                           checked>
                                                                @else
                                                                    <input name="pick" type="radio" value="{{$p->id}}">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 my-2 ncodePic" style="height: 150px">
                                                            <img class='single-show-img h-100'
                                                                 src='{{asset($p->path)}}'>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">

                            <label for="videoFile" style="width: 157px!important;" class="btn btn-secondary pt-2 pb-2">آپلود
                                ویدیو</label>
                            <input id="videoFile" name="video" type="file" class="d-none">
                            <input id="isvideo" name="isvideo" type="text" class="d-none">
                        </div>
                        <div class="col-12 mb-3">
                        </div>
                        <div class="col-12 mb-3 text-lg-right">
                            <button type="submit" style="width: 157px!important;" class="btn btn-success pt-2 pb-2"
                                    id="productsubmit">ثبت
                            </button>
                        </div>
                        <div class="col-12 text-center">
                            <div class="w-100 bg-dark" id="video" style="margin-bottom: 100px">
                                @if(count($pansion->video)!=0)
                                    <video class="w-100" controls id="sourceVideo" style="margin-left: 10px">
                                        <source id="sourceVideo" src="{{asset($pansion->video[0]->path)}}"
                                                type="video/mp4">
                                    </video>
                                    <span class='btn btn-danger mt-2' id="detachVideo">حذف ویدیو</span>
                                @else
                                    <video class="w-100 d-none" controls id="sourceVideo" style="margin-left: 10px">
                                    </video>
                                @endif
                            </div>
                            <div class="w-100 text-center">

                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
        </div>
    </form>
    </div>

@endsection
