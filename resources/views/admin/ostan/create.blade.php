@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function () {
            $('.hrefbtn').remove();
            ///ostanForm
            $("#ostansubmit").click(function (e) {
                let ostanName = $('#ostanName').val();
                if (ostanName == "") {
                    toastr.error('فیلد استان حتما پر شود.')
                    $('#ostanName').addClass('border-red');
                } else {
                    $('#ostanName').removeClass('border-red');

                    let info={
                        "_token": "{{ csrf_token() }}",
                        "name":ostanName
                    }

                    $.ajax(
                        {
                            url: "{{route('ostan.store')}}",
                            type: "post",
                            data:info,
                            success: function (data) {
                                if (data == "ok") {
                                    location.reload();
                                    toastr.success('استان با موفقیت ثبت شد.');
                                } else if (data == "notfound") {
                                    toastr.error('بروز خطا');
                                }
                            },
                            error: function(e) {
                                console.log('خطایی رخ داده، لطفا مجدد تلاش فرمایید');
                                toastr.error('بروز خطا');
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
                $.ajax({

                        url: "{{asset('admin')}}/ostan/" + btnDel,
                        data: info,
                        type: "delete",
                        success: function (data) {
                            if (data == "ok") {
                                // location.reload();
                                toastr.success('استان با موفقیت حذف شد.');
                            } else if (data == "notfound") {
                                // location.reload();
                                toastr.error('بروز خطا');
                            }
                        }
                    });
            });
        });

    </script>
@endsection
<style>
    .select2{
        width: 100%!important;
    }
    /*@media (min-width: 1400px){*/
    /*    .container {*/
    /*        max-width: 1350px!important;*/
    /*    }*/
    /*}*/

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
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded"
                 style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a>
                        </li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">افزودن
                            استان
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- START: Form-->
    <div class="container card" style="margin-top: 230px;background-color: gainsboro">
        <div class="row px-5">
            <div class="col-lg-8 row pr-0">
                <div class="col-12 mb-5 mt-5 row pr-0">
                    <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                        <span class="position-relative" style="top: 24%">
                            نام استان
                        </span>
                    </div>
                    <div class="col-9 p-0 ">
                    <input class="form-control" name="name" autocomplete="off" id="ostanName">
                </div>
                </div>
            </div>
            <div class="col-lg-4 mt-5 row">
                <div class="col-12">
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-success pt-2 pb-2" id="ostansubmit">ثبت</button>
                    </div>
                </div>
                <div class="col-12 singleShow mt-5">
                </div>

            </div>
        </div>

    <!-- cities table-->
    <div class="container-fluid border-top px-5">
        <h2 class="mb-3 pt-2">جدول استان</h2>
        <table class="align-right table table-hover table-dark table-striped mytable w-100">
            <thead>
            <tr>

                <th>شماره لیست</th>
                <th>نام استان</th>
                <th class="text-center">تنظیمات</th>
            </tr>
            </thead>
            <tbody>
            @if($ostans!='notfound')
            @foreach($ostans as $key=>$ostan)
                <tr data-id="{{$ostan->id}}">
                {{--             @if($tik->ferestande=\Illuminate\Support\Facades\Auth::id() or $tik->girande=\Illuminate\Support\Facades\Auth::id())--}}
                    <td>{{++$key}}</td>

                    <td>{{$ostan->name!=null ? $ostan->name:'-'}}</td>

                    <td class="text-center">
                        <button class="btn text-white btn-warning" style="padding: 10px 12px" title="ویرایش" data-id="{{$ostan->id}}" data-toggle="modal" data-target="#edit-modal-{{$key}}"><i class="fas fa-edit"></i> </button>
                        <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="{{$ostan->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}"><i class="fas fa-trash"></i> </button>
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
                                                    <div class="w-sm-100 mr-auto"><h4 class="mb-0">ویرایش استان</h4></div>
                                                    <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END: Breadcrumbs-->
                                        <!-- START: Form-->
                                        <form action="{{route('ostan.update',$ostan->id)}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('patch')
                                            <div class="container-fluid card">
                                                <div class="row parent-file">
                                                    <div class="col-lg-8 row">
                                                        <div class="col-md-12 mb-5 mt-5" style="text-align: right;">
                                                            <label class="form-label mb-2" for="submit-ostanname">نام استان</label>
                                                            <input class="form-control edit-name" name="name" value="{{$ostan->name}}" autocomplete="off" id="ostanName">
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-4 mb-5 mt-5 row pl-5">
                                                        <div class="col-12 text-center">
                                                            <div class="col-12 mb-3 mt-3">
                                                                <button type="submit" class="w-100 btn btn-success mt-3 pt-2 pb-2 submit-edit" id="ostansubmit" data-id="{{$ostan->id}}">ثبت</button>
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
                                            <p>آیا می خواهید زیردسته {{$ostan->name}} حذف شود؟</p>
                                        </div>
                                        <div style="text-align: left">
                                            <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$ostan->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>

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
