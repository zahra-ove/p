@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">

<style>
    .dataTables_wrapper {
        margin-top: 50px;
    }

    a.btn {
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>
@section('js')
    <script>
        $(document).ready(function (e){
            $('.hrefbtn').attr('href',"{{route('personal.create')}}");
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
                        url: "{{asset('admin')}}/provider/" + btnDel,
                        data: info,
                        type: "delete",
                        success: function (data) {
                            if (data == "ok") {
                                // location.reload();
                                toastr.success('خدمات دهنده با موفقیت حذف شد.');

                            } else if (data == "notfound") {
                                // location.reload();
                                toastr.success('بروز خطا');
                            }

                        }
                    }
                );
            });
            $('.dettach-btn').click(function (e) {
                let uDel=$(this).attr('data-id');
                let gDel=$(this).attr('data_id');
                // let keycol=$(this).parents('td').siblings('.key-col');
                // $('td.key-col').each(function (index) {
                //     if (parseInt($(this).html())>parseInt(keycol)){
                //         $(this).text(parseInt($(this).html())-1)
                //     }
                // });

                $(this).parents('tr[data-id="'+gDel+'-'+uDel+'"]').remove();
                let info = {
                    "_token": "{{ csrf_token() }}",
                    "uId": uDel,
                    "gId": gDel,
                }
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $.ajax(
                    {
                        url: "{{route('dettachgroup')}}",
                        data: info,
                        type: "post",
                        success: function (data) {
                            if (data == "ok") {
                                // location.reload();
                                toastr.success('سمت با موفقیت حذف شد.');

                            } else if (data == "notfound") {
                                // location.reload();
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
    <div class="py-5 row w-100" style="margin-top: 130px">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">جدول خدمات دهنده</h4></div>

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
    <!-- category table-->
    <div class="container-fluid card border-top row m-auto">
        <table class="align-right table table-hover table-dark table-striped mytable w-100 pt-2">
            <thead>
            <tr>

                <th>شماره لیست</th>
                <th>نام پرسنل</th>
                <th>کد ملی</th>
                <th>شماره تماس</th>
                <th>تنظیمات</th>
            </tr>
            </thead>
            <tbody>
            @if($personals!='notfound')
                @foreach($personals as $key=>$personal)
                    <tr data-id="{{$personal->id}}">
                        {{--             @if($tik->ferestande=\Illuminate\Support\Facades\Auth::id() or $tik->girande=\Illuminate\Support\Facades\Auth::id())--}}
                        <td>{{++$key}}</td>
                        <td>{{$personal->name!=null ? $personal->name:'-'}} {{$personal->family!=null ? $personal->family:'-'}}</td>
                        <td>{{$personal->ncode!=null ? $personal->ncode:'-'}}</td>
                        <td>{{$personal->mobilecode!=null ? $personal->mobilecode:'-'}}</td>

                        <td>

                            <a href="{{route('personal.edit',$personal->id)}}" class="btn text-white btn-warning" style="padding: 10px 12px" title="ویرایش" target="_blank"><i class="fas fa-edit"></i> </a>
                            <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="{{$personal->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}"><i class="fas fa-trash"></i> </button>
                            <!-- modal group -->
                            <div class="modal fade" id="group-modal-{{$key}}" role="dialog">
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
                                                        <div class="w-sm-100 mr-auto"><h4 class="mb-0">دسترسی ها</h4></div>
                                                        <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container-fluid">
                                                <table class="table w-100" id="group-table">
                                                    <thead>
                                                    <tr>
                                                        <th><h5>شماره</h5> </th>
                                                        <th><h5>نام دسترسی</h5></th>
                                                        <th><h5>
                                                                نام انگلیسی دسترسی
                                                            </h5>
                                                        </th>
                                                        <th><h5>
                                                                تنظیمات
                                                            </h5>
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($personal->group as $keys=>$g)
                                                        <tr data-id="{{$g->id}}-{{$personal->id}}">
                                                            <td>{{++$keys}}</td>
                                                            <td>{{$g->name}}</td>
                                                            <td>{{$g->name_en}}</td>
                                                            <td class="text-center">
                                                                <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="{{$personal->id}}" data-toggle="modal" data-target="#delete-group-{{$key}}-{{$g->id}}"><i class="fas fa-trash"></i> </button>
                                                                <!-- group delete -->
                                                                <div class="modal fade" id="delete-group-{{$key}}-{{$g->id}}" role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <!-- Modal content-->
                                                                        <div class="modal-content">
                                                                            <div class="modal-header d-block" style="text-align: right">
                                                                                <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body text-dark" >
                                                                                <div style="text-align: right">
                                                                                    <p>آیا می خواهید حذف شود؟</p>
                                                                                </div>
                                                                                <div style="text-align: left">
                                                                                    <button data-dismiss="modal" class="btn text-white btn-danger dettach-btn" title="حذف" data_id="{{$g->id}}" data-id="{{$personal->id}}">حذف </button>

                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </table>
                                            </div>
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
                                                <p>آیا می خواهید  {{$personal->name}} {{$personal->family}} حذف شود؟</p>
                                            </div>
                                            <div style="text-align: left">
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$personal->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>

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
