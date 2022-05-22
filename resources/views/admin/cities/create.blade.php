@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function () {
            $('.hrefbtn').hide();
            ////edit
            $('.city-attach-edit').change(function (e) {
                let files = e.target.files;
                console.log(files)
                let file = files[0];
                let reader = new FileReader();
                let $this = $(this);
                reader.onload = (function (theFile) {
                    $this.parents('.parent-file').siblings('.edit-pic').children('.show-edit-photo').empty();
                    var imgSrc = theFile.target.result;
                    $this.parents('.parent-file').siblings('.edit-pic').children('.show-edit-photo').append("<img class='single-show-img' style='width: 600px;height: 300px' src='" + imgSrc + "'> ")
                });
                reader.readAsDataURL(this.files[0]);
            });
            let files="";
            ///cityForm
            $('#city-attach').change(function (e) {
                files = e.target.files;
                let file = files[0];
                let reader = new FileReader();
                reader.onload = (function (theFile) {
                    $('.single-show-img').remove();
                    var imgSrc = theFile.target.result;
                    $('.singleShow').append("<img class='single-show-img' style='width: 400px;height: 200px' src='" + imgSrc + "'> ")
                });


// Read in the image file as a data URL.
                reader.readAsDataURL(this.files[0]);
            });
            $("#citysubmit").click(function (e) {
                let cityName = $('#cityName').val();
                let ostan = $('#ostanIdInsert').val();
                if (ostan == "") {
                    $('#ostanIdInsert').addClass('border-red');
                }
                else {
                    $('#ostanIdInsert').removeClass('border-red');
                }

                if (cityName == "") {
                    $('#cityName').addClass('border-red');
                }
                else {
                    $('#cityName').removeClass('border-red');
                }
                if (cityName != "" && ostan!='') {
                    var postData = new FormData();
                    if (files.length!=0){
                        postData.append('attach', files[0]);
                    }

                    postData.append('name', cityName);
                    postData.append('ostan_id', ostan);
                    $.ajax(
                        {
                            url: "{{route('city.store')}}",
                            headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                            async: true,
                            contentType: false,
                            processData: false,
                            data: postData,
                            type: "post",
                            success: function (data) {
                                if (data == "ok") {
                                    location.reload();
                                    toastr.success('شهر با موفقیت ثبت شد.');
                                } else if (data == "notfound") {
                                    location.reload();
                                    toastr.success('بروز خطا');
                                }

                            }
                        }
                    );

                }

                else {

                    toastr.error('تمامی قسمت ها باید پر شوند.')

                }



            });
            $("#ostansubmit").click(function (e) {
                let ostanName = $("#ostanName").val();
                let info = {
                    "_token": "{{ csrf_token() }}",
                    "name": ostanName,
                }


                $.ajax(
                    {
                        url: "{{route('ostan.store')}}",
                        data: info,
                        type: "post",
                        success: function (data) {
                            if (data == "ok") {
                                location.reload();
                                toastr.success('استان با موفقیت ثبت شد.');
                            } else if (data == "notfound") {
                                location.reload();
                                toastr.success('بروز خطا');
                            }

                        }
                    }
                );



            });
            $('.delete-btn').click(function (e) {
                let btnDel=$(this).attr('data-id');
                $(this).parents('tr[data-id="'+btnDel+'"]').remove();
                let info = {
                    "_token": "{{ csrf_token() }}"
                }
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $.ajax(
                    {
                        url: "{{asset('admin')}}/city/" + btnDel,
                        data: info,
                        type: "delete",
                        success: function (data) {
                            if (data == "ok") {
                                // location.reload();
                                toastr.success('شهر با موفقیت حذف شد.');

                            } else if (data == "notfound") {
                                // location.reload();
                                toastr.success('بروز خطا');
                            }

                        }
                    }
                );
            });
            $('.search-box').keyup(function (e) {
                $('.delete-btn').click(function (e) {
                    let btnDel=$(this).attr('data-id');
                    $(this).parents('tr[data-id="'+btnDel+'"]').remove();
                    let info = {
                        "_token": "{{ csrf_token() }}"
                    }
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $.ajax(
                        {
                            url: "{{asset('admin')}}/city/" + btnDel,
                            data: info,
                            type: "delete",
                            success: function (data) {
                                if (data == "ok") {
                                    // location.reload();
                                    toastr.success('شهر با موفقیت حذف شد.');

                                } else if (data == "notfound") {
                                    // location.reload();
                                    toastr.success('بروز خطا');
                                }

                            }
                        }
                    );
                });
            });
        })
    </script>
@endsection
<style>
    .select2{
        width: 100%!important;
    }
    @media (min-width: 1400px){
        .container {
            max-width: 1350px!important;
        }
    }

    @media (min-width: 992px){
        .mr-140{
            margin-right: 140px!important;
        }
    }
    @media (max-width: 576px){
        .mr-140{
            margin-right:60px!important;
        }
    }
    .breadcrumb{
        background-color: white!important;
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
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">افزودن
                            شهر
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <div class="container card" style="margin-top: 330px;background-color: gainsboro">
        <div class="row ">
            <div class="col-lg-8 row p-0" style="height: 200px">
                <div class="col-9 mt-5 row mr-140">
                    <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                      <span class="position-relative" style="top: 24%">
                            استان
                        </span>

                    </div>
                    <div class="col-9 p-0 ">
                        <select name="ostan_id" class="form-control select2" id="ostanIdInsert">
                            <option value="">استان را انتخاب کنید.</option>
                            @if($ostans!="notfound")
                                @foreach($ostans as $ostan)
                                    <option value="{{$ostan->id}}">{{$ostan->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-9 row mr-140">
                    <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;
" for="submit-cityname">
                        <span class="position-relative" style="top: 24%">
                             نام شهر
                        </span>


                    </div>
                    <div class="col-9 p-0">
                    <input class="form-control" name="name" autocomplete="off" id="cityName">
                </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5 mt-5 p-0 row">
                <div class="col-12 p-0">
                    <div class="col-12 mb-3 p-0">
                        <button class="w-50 btn btn-success pt-2 pb-2" id="citysubmit">ثبت</button>
                    </div>
                    <div class="col-12 mb-3 p-0">

                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-secondary w-50 pt-2 pb-2" data-toggle="modal"
                                data-target="#myModal">ثبت استان
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- START: Breadcrumbs-->
                                        <div class="py-5 mt-5 mb-lg-3 row container-fluid">
                                            <div class="col-12  align-self-center">
                                                <div
                                                    class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                                                    <div class="w-sm-100 mr-auto"><h4 class="mb-0">ثبت استان</h4></div>

                                                    <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                                        {{--                    <li class="breadcrumb-item">خانه</li>--}}
                                                        {{--                    <li class="breadcrumb-item">فرم</li>--}}
                                                        {{--                    <li class="breadcrumb-item">عناصر</li>--}}
                                                        {{--                    <li class="breadcrumb-item active"><a href="#">کادرهای انتخاب</a></li>--}}
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END: Breadcrumbs-->
                                        <div class="container row">
                                            <div class="col-lg-6 mb-5 text-left">
                                                <label class="form-label mb-2" for="submit-cityname">
                                                    نام استان</label>
                                                <input class="form-control" id="ostanName" name="name"
                                                       autocomplete="off">
                                            </div>
                                            <div class="col-lg-6 mb-5 pt-4">
                                                <button class="w-50 btn btn-success pt-2 pb-2" id="ostansubmit">ثبت
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-12 mb-3 p-0" >
                        <input id="city-attach" name="attach" type="file" class="d-none">
                        <label class="btn btn-info w-50" for="city-attach">
                            ثبت تصویر
                        </label>
                    </div>
                </div>
                <div class="col-12 singleShow mt-5 p-0">
                </div>
                    <ul class="col-12 p-0">
                        <li style="list-style-type: none">تصویر انتخاب شده باید در ابعاد 800 در 600 باشد.</li>
                    </ul>
            </div>
        </div>

    <!-- cities table-->
    <div class="container-fluid border-top px-5">
        <h2 class="mb-3 pt-2">جدول شهر
        </h2>
        <table class="align-right table table-hover table-dark table-striped mytable w-100" style="margin-bottom: 100px">
            <thead>
            <tr>

                <th>شماره لیست</th>
                <th>نام شهر</th>
                <th>نام استان</th>
                <th class="text-center">تنظیمات</th>
            </tr>
            </thead>
            <tbody>
            @if($cities!="notfound")
             @foreach($cities as $key=>$city)
                 <tr data-id="{{$city->id}}">
                    {{--             @if($tik->ferestande=\Illuminate\Support\Facades\Auth::id() or $tik->girande=\Illuminate\Support\Facades\Auth::id())--}}
                    <td>{{++$key}}</td>

                    <td>{{$city ? $city->cityName:'-'}}</td>

                    <td>{{$city ? $city->ostanName : '-'}}</td>

                    <td class="text-center">
                        <button class="btn text-white btn-warning btn-edit" title="ویرایش" data-id="{{$city->id}}" data-toggle="modal" data-target="#edit-modal-{{$key}}"><i class="fas fa-edit"></i> </button>
                        <!-- modal edit -->
                        <div class="modal fade" id="edit-modal-{{$key}}" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header d-block" style="text-align: right">
                                        <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                    </div>
                                    <div class="modal-body text-dark" >
                                        <!-- START: Breadcrumbs-->
                                        <div class="py-5 mt-5 mb-lg-3 row w-100">
                                            <div class="col-12  align-self-center">
                                                <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                                                    <div class="w-sm-100 mr-auto"><h4 class="mb-0">ویرایش شهر</h4></div>
                                                    <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END: Breadcrumbs-->
                                        <!-- START: Form-->
                                        <form action="{{route('city.update',$city->id)}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('patch')
                                        <div class="container-fluid card">
                                            <div class="row parent-file">
                                                <div class="col-lg-8 row">
                                                    <div class="col-md-6 mb-5 mt-5" style="text-align: right;">
                                                        <label class="form-label mb-2" for="submit-cityname">نام شهر</label>
                                                        <input class="form-control edit-name" name="name" value="{{$city->cityName}}" autocomplete="off" id="cityName">
                                                    </div>
                                                    <div class="col-md-6 mb-5 mt-5" style="text-align: right;">
                                                        <label class="form-label mb-2 w-100" for="ostanIdInsert-{{$key}}">استان</label>
                                                        <select name="ostan_id"  class="form-control w-100 select2" id="ostanIdInsert-{{$key}}">
                                                            <option value="">استان را انتخاب کنید.</option>
                                                            @if($ostans!="notfound")
                                                                @foreach($ostans as $ostan)
                                                                    @if($ostan->id==$city->ostan_id)
                                                                    <option value="{{$ostan->id}}" selected>{{$ostan->name}}</option>
                                                                    @else
                                                                        <option value="{{$ostan->id}}">{{$ostan->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 mb-5 mt-5 row pl-5">
                                                    <div class="col-12 text-center">
                                                        <div class="col-12 mb-3">
                                                            <input id="city-attach-edit-{{$key}}" name="attach" type="file" class="d-none city-attach-edit">
                                                            <label class="btn btn-info w-100" for="city-attach-edit-{{$key}}">
                                                                ثبت تصویر
                                                            </label>
                                                        </div>
                                                        <div class="col-12 mb-3 mt-3">
                                                            <button type="submit" class="w-100 btn btn-success mt-3 pt-2 pb-2 submit-edit" id="citysubmit" data-id="{{$city->id}}">ثبت</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 singleShow mt-5">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row edit-pic text-center">
                                                <div class="col-12 mb3 show-edit-photo">
                                                    @if($city->pathImage!=null)
                                                    <img src="{{asset($city->pathImage)}}" style="width: 600px;height: 300px">
                                                    @else
                                                    <div class="bg-secondary instead-edit-photo" style="width: 600px;height: 300px"></div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                            @if(count($errors)!=0)
                                                <ul class="text-danger">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{$error}}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <button class="btn text-white btn-danger" title="حذف" data-id="{{$city->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}"><i class="fas fa-trash"></i> </button>
                        <!-- modal delete -->
                        <div class="modal fade" id="delete-modal-{{$key}}" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header d-block" style="text-align: right">
                                        <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                    </div>
                                    <div class="modal-body text-dark" >
                                        <div style="text-align: right">
                                            <p>آیا می خواهید شهر {{$city->cityName}} حذف شود؟</p>
                                        </div>
                                        <div style="text-align: left">
                                            <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$city->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </td>


            </tr>
            @endforeach
            @endif
            </tbody>

        </table>
    </div>
    </div>
@endsection
