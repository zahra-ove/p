@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function (){


            $("#leadersubmit").click(function (e){
                let leadername=$('#leader-name').val();
                let leadername_en=$('#city_id').val();
                info={
                    "_token": "{{ csrf_token() }}",
                    "user_id":leadername,
                    "city_id":leadername_en,
                }
                $.ajax(
                    {
                        url:"{{route('leader.store')}}",
                        data:info,
                        type:"post",
                        success: function (data){
                            if (data=="ok"){
                                location.reload();
                                toastr.success('لیدر با موفقیت ثبت شد.');
                            }
                            else if (data=="notfound"){

                                toastr.success('بروز خطا');
                            }

                        }
                    }
                );
            });

            $('.delete-btn').click(function (e) {
                let btnDel=$(this).attr('data-id');
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
                        url: "{{asset('admin')}}/leader/" + btnDel,
                        data: info,
                        type: "delete",
                        success: function (data) {
                            if (data == "ok") {
                                // location.reload();
                                toastr.success('لیدر با موفقیت حذف شد.');

                            } else if (data == "notfound") {
                                // location.reload();
                                toastr.success('بروز خطا');
                            }

                        }
                    }
                );
            });

            $('.dettach-btn').click(function (e) {
                let gDel=$(this).attr('data-id');
                let pDel=$(this).attr('data_id');
                // let keycol=$(this).parents('td').siblings('.key-col');
                // $('td.key-col').each(function (index) {
                //     if (parseInt($(this).html())>parseInt(keycol)){
                //         $(this).text(parseInt($(this).html())-1)
                //     }
                // });

                $(this).parents('tr[data-id="'+pDel+'-'+gDel+'"]').remove();
                let info = {
                    "_token": "{{ csrf_token() }}",
                    "gId": gDel,
                    "pId": pDel,
                }
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $.ajax(
                    {
                        url: "{{route('dettachpermission')}}",
                        data: info,
                        type: "post",
                        success: function (data) {
                            if (data == "ok") {
                                // location.reload();
                                toastr.success('دسترسی با موفقیت حذف شد.');

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
<style>
    #permission-table,#permission-table th,#permission-table td{
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">ثبت لیدر</h4></div>

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
                    <label class="form-label mb-2" for="leader-name">انتخاب لیدر</label>
                    <select class="select2 form-control" id="leader-name" name="user_id">
                        <option value="">لیدر را انتخاب کنید</option>
                        @if($users!='notfound')
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}} {{$user->family}}</option>
                        @endforeach
                            @endif
                    </select>
                </div>
                <div class="col-lg-6 mb-5 mt-5">
                    <label class="form-label mb-2" for="leader-name">شهر</label>
                    <select class="select2 form-control" id="city_id" name="city_id" >
                        <option value="">شهر را انتخاب کنید</option>
                        @if($cities!='notfound')
                        @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->cityName}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-lg-4 mb-5 mt-5 row pl-5">
                <div class="col-12 text-center">
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-success pt-2 pb-2" id="leadersubmit">ثبت</button>
                    </div>
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-danger pt-2 pb-2">بازگشت</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- leaders table-->
        <div class="container-fluid card border-top row m-auto">
            <h2 class="mb-3 pt-2">جدول لیدر ها</h2>
            <table class="align-right table table-hover table-dark table-striped mytable w-100">
                <thead>
                <tr>

                    <th>شماره لیست</th>
                    <th>نام لیدر</th>
                    <th>شهر</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @if($leaders!="notfound")
                    @foreach($leaders as $key=>$leader)
                        <tr data-id="{{$leader->id}}">
                            <td class="key-col">{{++$key}}</td>
                            <td>{{$leader->user->name!=null ? $leader->user->name:'-'}} {{$leader->user->family!=null ? $leader->user->family:'-'}}</td>
                            <td>{{$leader->city->name!=null ? $leader->city->name:'-'}}</td>

                            <td class="text-center">
                                <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="{{$leader->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}"><i class="fas fa-trash"></i> </button>
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
                                                    <p>آیا می خواهید لیدر {{$leader->name}} حذف شود؟</p>
                                                </div>
                                                <div style="text-align: left">
                                                    <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$leader->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>

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
