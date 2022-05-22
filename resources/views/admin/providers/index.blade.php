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
            $('.hrefbtn').attr('href',"");
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
        })

    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row w-100">
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
                <th>خدمات دهنده</th>
                <th>نام شرکت</th>
                <th>تاریخ پایان قرارداد</th>
                <th>تاریخ شروع قرارداد</th>
                <th>شماره قرارداد</th>
                <th>تنظیمات</th>
            </tr>
            </thead>
            <tbody>
            @if($providers!='notfound')
             @foreach($providers as $key=>$provider)
                 <tr data-id="{{$provider->id}}">
                    {{--             @if($tik->ferestande=\Illuminate\Support\Facades\Auth::id() or $tik->girande=\Illuminate\Support\Facades\Auth::id())--}}
                    <td>{{++$key}}</td>
                    <td>{{$provider ? $provider->name:'-'}} {{$provider ? $provider->family:'-'}}</td>
                    <td>{{$provider ? $provider->business_title : '-'}}</td>
                    <td>{{$provider ? str_replace('-','/',Verta($provider->startdate)->formatDate()) : '-'}}</td>
                    <td>{{$provider ?  str_replace('-','/',Verta($provider->enddate)->formatDate()) : '-'}}</td>
                    <td>{{$provider ? $provider->contractNumber : '-'}}</td>
                    <td>
{{--                        <button href="#" class="btn text-white btn-info" style="padding: 10px 12px" title="نمایش"><i class="fas fa-eye"></i> </button>--}}
                        <a href="{{route('getproducts',$provider->id)}}"  class="btn text-white btn-secondary" title="محصولات"><i class="fas fa-tags"></i> </a>
                        <a href="{{route('provider.edit',$provider->id)}}" class="btn text-white btn-warning" style="padding: 10px 12px" title="ویرایش" target="_blank"><i class="fas fa-edit"></i> </a>
                        <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="{{$provider->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}"><i class="fas fa-trash"></i> </button>
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
                                            <p>آیا می خواهید {{$provider->business_title}} حذف شود؟</p>
                                        </div>
                                        <div style="text-align: left">
                                            <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$provider->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>

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
