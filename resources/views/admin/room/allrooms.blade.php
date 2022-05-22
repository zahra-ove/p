@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
<style>
    .owl-carousel .owl-item img {
        height: 96.828px;
    }
    .dataTables_wrapper{
        margin-top: 50px;
    }
    a.btn{
        padding-top: 10px;
        padding-bottom: 10px;
    }
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
@section('js')
    <script>
        $(document).ready(function (e) {
            $('.hrefbtn').attr('href',"{{route('room.create')}}");
            $('.item').click(function (e){
                let src = $(this).children('img').attr('src');
                let dataId=$(this).children('img').attr('data-id');
                $('.picked').prop('checked', false);
                $('.bigImg').attr('src',src);
                $('.bigImg').attr('data-id',dataId);
            });
            $('.item').mouseup(function (e) {
                $('.item').click(function (e) {
                    let src = $(this).children('img').attr('src');
                    let dataId=$(this).children('img').attr('data-id');
                    $('.picked').prop('checked', false);
                    $('.bigImg').attr('src',src);
                    $('.bigImg').attr('data-id',dataId);
                });
            });
        });

        $('.dataTables_filter').after('<div class="col-sm-12 col-md-6 mt-2 order-1"><a href="{{route('room.create')}}" class="btn btn-success mb-2" style="width:20%">افزودن</a></div>');
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
                    url: "{{asset('admin')}}/room/" + btnDel,
                    data: info,
                    type: "delete",
                    success: function (data) {
                        if (data == "ok") {
                            // location.reload();
                            toastr.success('محصول با موفقیت حذف شد.');

                        } else if (data == "notfound") {
                            // location.reload();
                            toastr.success('بروز خطا');
                        }

                    }
                }
            );
        });
    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">لیست تمامی اتاق ها </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- category table-->
    <div class="container card px-5" style="margin-top: 230px;background-color: gainsboro">
        @if($rooms!='notfound')
            <table class="align-right table table-hover table-dark table-striped mytable w-100 pt-2">
                <thead>
                <tr>
                    <th>شماره لیست</th>
                    <th>خوابگاه</th>
                    <th>طبقه</th>
                    <th>شماره اتاق</th>
                    <th>تعداد تخت</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>

                @foreach($rooms as $key=>$room)
                    <tr data-id="{{$room->id}}">
                        {{--             @if($tik->ferestande=\Illuminate\Support\Facades\Auth::id() or $tik->girande=\Illuminate\Support\Facades\Auth::id())--}}
                        <td>{{++$key}}</td>
                        <td>{{$room->pansionName!=null ? $room->pansionName : '-'}}</td>
                        <td>{{$room->floor!=null ? $room->floor : '-'}}</td>
                        <td>{{$room->roomnumber!=null ? $room->roomnumber : '-'}}</td>
                        <td>{{$room->counttakht!=null ? $room->counttakht : '-'}}</td>


                        <td>
                            <a href="{{route('takhtsofroom',$room->id)}}" class="btn text-white btn-info py-2" title="لیست تخت ها" data-id="{{$room->id}}"><i class="fas fa-bed"></i></a>
                            <button class="btn text-white btn-success py-2" style="padding: 10px 12px" title="گالری" data-id="{{$room->id}}" data-toggle="modal" data-target="#photo-modal-{{$key}}"><i class="fa fa-photo-film"></i> </button>
                            <a href="{{route('room.edit',$room->id)}}" class="btn text-white btn-warning py-2" title="ویرایش" data-id="{{$room->id}}"><i class="fas fa-edit"></i> </a>
                            <button  class="btn text-white btn-danger py-2" title="حذف" data-id="{{$room->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}"><i class="fas fa-trash"></i> </button>
                            <!-- modal photo -->
                            <div class="modal fade" id="photo-modal-{{$key}}" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >

                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 text-center position-relative home-slider mb-3" style="height: 450px;width: 450px">
                                                        @if(isset($room->photo[0]->path))
                                                            <img class="bigImg" style="width:450px!important;height: 450px!important;" src="{{asset($room->photo[0]->path)}}" data-id="{{$room->photo[0]->id}}">
                                                            <div class="delete-banner pb-3">
                                                                <button id="btn_gallery"
                                                                        class="btn btn-danger mr-2 text-white w-25 mt-2 del-pro"
                                                                        data-toggle="modal"
                                                                        data-target="#myModale-right"
                                                                        type="button">
                                                                    حذف
                                                                </button>
                                                            </div>
                                                        @else
                                                            <h2 class="alert-danger">عکسی برای این محصول ثبت نشده است.</h2>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="owl-carousel owl-theme">
                                                @foreach($room->photo as $photo)
                                                    <div class="item d-flex position-relative" data-bgimg="{{asset($photo->path)}}" data-id="{{$photo->id}}">
                                                        <img src="{{asset($photo->path)}}" data-id="{{$photo->id}}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
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
                                                        <div class="w-sm-100 mr-auto"><h4 class="mb-0">ویرایش محصول</h4></div>
                                                        <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                                        </ol>
                                                    </div>
                                                </div>
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
                                                <p>آیا می خواهید اتاق حذف شود؟</p>
                                            </div>
                                            <div style="text-align: left">
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$room->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert-danger p-1">اتاقی ثبت نشده است.</div>
        @endif

    </div>
@endsection
