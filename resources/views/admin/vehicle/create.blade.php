@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function () {
            $('.hrefbtn').remove();
            ///vehicleForm
            $("#vehiclesubmit").click(function (e) {
                let vehicleName = $('#vehicleName').val();
                if (vehicleName == "") {
                    toastr.error('فیلد استان حتما پر شود.')
                    $('#vehicleName').addClass('border-red');
                } else {
                    $('#vehicleName').removeClass('border-red');

                    let info={
                        "_token": "{{ csrf_token() }}",
                        "vehicle":vehicleName
                    }

                    $.ajax(
                        {
                            url: "{{route('vehicle.store')}}",
                            type: "post",
                            data:info,
                            success: function (data) {
                                if (data == "ok") {
                                    location.reload();
                                    toastr.success('وسیله نقیله با موفقیت ثبت شد.');
                                } else if (data == "notfound") {
                                    toastr.success('بروز خطا');
                                }

                            }
                        }
                    );
                }


            });


            $('.delete-btn').click(function (e) {
                let btnDel=$(this).attr('data-id');
                console.log(btnDel)
                // let keycol=$(this).parents('td').siblings('.key-col');
                // $('td.key-col').each(function (index) {
                //     if (parseInt($(this).html())>parseInt(keycol)){
                //         $(this).text(parseInt($(this).html())-1)
                //     }
                // });

                $(this).parents('tr[data-id="'+btnDel+'"]').remove();
                let info = {
                    "_token": "{{ csrf_token() }}"
                }
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $.ajax(
                    {
                        url: "{{asset('admin')}}/vehicle/" + btnDel,
                        data: info,
                        type: "delete",
                        success: function (data) {
                            if (data == "ok") {
                                // location.reload();
                                toastr.success('وسیله نقلیه با موفقیت حذف شد.');

                            } else if (data == "notfound") {
                                // location.reload();
                                toastr.success('بروز خطا');
                            }

                        }
                    }
                );
            });
        });

    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row w-100">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">ثبت وسیله نقلیه</h4></div>

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
                    <label class="form-label mb-2" for="vehicleName">نام وسیله نقلیه</label>
                    <input class="form-control" name="vehicle" autocomplete="off" id="vehicleName">
                </div>
            </div>
            <div class="col-lg-4 mb-5 mt-5 row pl-5">
                <div class="col-12 text-center">
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-success pt-2 pb-2" id="vehiclesubmit">ثبت</button>
                    </div>
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-danger pt-2 pb-2">بازگشت</button>
                    </div>
                </div>
                <div class="col-12 singleShow mt-5">
                </div>

            </div>
        </div>
    </div>
    <!-- cities table-->
    <div class="container-fluid card border-top row m-auto">
        <h2 class="mb-3 pt-2">جدول وسیله نقلیه</h2>
        <table class="align-right table table-hover table-dark table-striped mytable w-100">
            <thead>
            <tr>

                <th>شماره لیست</th>
                <th>نام وسیله نقلیه</th>
                <th class="text-center">تنظیمات</th>
            </tr>
            </thead>
            <tbody>
            @if($vehicles!='notfound')
                @foreach($vehicles as $key=>$vehicle)
                    <tr data-id="{{$vehicle->id}}">
                        {{--             @if($tik->ferestande=\Illuminate\Support\Facades\Auth::id() or $tik->girande=\Illuminate\Support\Facades\Auth::id())--}}
                        <td>{{++$key}}</td>

                        <td>{{$vehicle->vehicle!=null ? $vehicle->vehicle:'-'}}</td>

                        <td class="text-center">
                            <button class="btn text-white btn-warning" style="padding: 10px 12px" title="ویرایش" data-id="{{$vehicle->id}}" data-toggle="modal" data-target="#edit-modal-{{$key}}"><i class="fas fa-edit"></i> </button>
                            <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="{{$vehicle->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}"><i class="fas fa-trash"></i> </button>
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
                                                        <div class="w-sm-100 mr-auto"><h4 class="mb-0">ویرایش وسیله نقلیه</h4></div>
                                                        <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END: Breadcrumbs-->
                                            <!-- START: Form-->
                                            <form action="{{route('vehicle.update',$vehicle->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('patch')
                                                <div class="container-fluid card">
                                                    <div class="row parent-file">
                                                        <div class="col-lg-8 row">
                                                            <div class="col-md-12 mb-5 mt-5" style="text-align: right;">
                                                                <label class="form-label mb-2" for="submit-vehiclename">نام وسیله نقلیه</label>
                                                                <input class="form-control edit-name" name="vehicle" value="{{$vehicle->vehicle}}" autocomplete="off" id="vehicleName">
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-4 mb-5 mt-5 row pl-5">
                                                            <div class="col-12 text-center">
                                                                <div class="col-12 mb-3 mt-3">
                                                                    <button type="submit" class="w-100 btn btn-success mt-3 pt-2 pb-2 submit-edit" id="vehiclesubmit" data-id="{{$vehicle->id}}">ثبت</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 singleShow mt-5">
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
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
                                                <p>آیا می خواهید زیردسته {{$vehicle->vehicle}} حذف شود؟</p>
                                            </div>
                                            <div style="text-align: left">
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$vehicle->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>

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
@endsection
