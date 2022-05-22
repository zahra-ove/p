@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function () {
            ///cityForm
                $("#citysubmit").click(function (e) {
                    let cityName = $('#cityName').val();
                    let ostan = $('#ostanIdInsert').val();
                    let info={
                        "_token": "{{ csrf_token() }}",
                        "name":cityname,
                        "ostan_id":ostan
                    }

                    $.ajax(
                        {
                            url: "{{route('city.store')}}",
                            type: "post",
                            success: function (data) {
                                if (data == "ok") {
                                    location.href = "{{asset('admin/s')}}";
                                    toastr.success('شهر با موفقیت ثبت شد.');
                                } else if (data == "notfound") {
                                    location.href = "{{asset('admin/s')}}";
                                    toastr.success('بروز خطا');
                                }

                            }
                        }
                    );
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

        })
    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row w-100">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">ثبت شهر</h4></div>

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
    <!-- START: Form-->
    <div class="container-fluid card">
        <div class="row">
            <div class="col-lg-8 row">
                <div class="col-lg-6 mb-5 mt-5">
                    <label class="form-label mb-2" for="submit-cityname">نام شهر</label>
                    <input class="form-control" name="name" autocomplete="off" id="cityName">
                </div>
                <div class="col-lg-6 mb-5 mt-5">
                    <label class="form-label mb-2" for="ostanIdInsert">استان</label>
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
            <div class="col-lg-4 mb-5 mt-5 row pl-5">
                <div class="col-12 text-center">
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-success pt-2 pb-2" id="citysubmit">ثبت</button>
                    </div>
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-danger pt-2 pb-2">بازگشت</button>
                    </div>
                    <div class="col-12 mb-3">
                        <input id="city-attach" name="attach" type="file" class="d-none">
                        <label class="btn btn-info w-50" for="city-attach">
                            ثبت تصویر
                        </label>
                    </div>
                    <div class="col-12 mb-3">

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
                </div>
                <div class="col-12 singleShow mt-5">
                </div>

            </div>
        </div>
    </div>
    <!-- cities table-->
    <div class="container-fluid card border-top row m-auto">
        <h2 class="mb-3 pt-2">جدول شهر</h2>
        <table class="align-right table table-hover table-dark table-striped mytable w-100">
            <thead>
            <tr>

                <th>شماره لیست</th>
                <th>نام شهر</th>
                <th>نام استان</th>
            </tr>
            </thead>
            <tbody>
            <tr> @foreach($cities as $key=>$city)
                    {{--             @if($tik->ferestande=\Illuminate\Support\Facades\Auth::id() or $tik->girande=\Illuminate\Support\Facades\Auth::id())--}}
                    <td>{{++$key}}</td>

                    <td>{{$city ? $city->cityName:'-'}}</td>

                    <td>{{$city ? $city->ostanName : '-'}}</td>


            </tr>
            @endforeach
            </tbody>

        </table>
    </div>
@endsection
