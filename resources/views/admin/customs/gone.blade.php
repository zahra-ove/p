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
    .select2-container--default{
        width: 100%!important;
    }
    #wichSearch,#search-ncode{
        background-color: #fff;
        border: 1px solid #aaa;
        border-radius: 4px;
        height: 36px;
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

        $(document).ready(function (e){

            $('.dataTables_length').after(`
<div class="col-lg-6 row">
<div class="col-lg-4">
<label>خوابگاه</label>
<select class="select2" id="pansion"> </select>
</div>
<div class="col-lg-4">
<label>اتاق</label>
<select class="select2" id="room"></select>
</div>
<div class="col-lg-4">
<label>تخت</label>
<select class="select2" id="takht"></select>
</div>
</div>
<div class="col-12 col-lg-3 mb-1" style="text-align: left">
<label for="serach-ncode h-100" style="margin-top: 35px;" class="h-100">جستجو کدملی</label>
<select id="wichSearch">
<option value="ncode">کدملی</option>
<option value="family">نام و نام خانوادگی</option>
<option value="mobilecode">شماره موبایل</option>
</select> </div>
<div class="col-12 col-lg-3 mb-1 " style="text-align: left;margin-right: -50px;">
<input class="justnumber" style="margin-top: 26px;" placeholder="جستجو" id="search-ncode">
<button class="btn btn-secondary" id="clickSearch">جستجو</button>
</div>
`)
            $('.select2').select2({
            });
            $.ajax({
                url:"{{asset('admin/getpansionajax')}}",
                success: function (data) {
                    $('#pansion').empty();
                    $('#pansion').append(`\`<option value="">خوابگاه خود را انتخاب کنبد.</option>\``);
                    $('#room').empty();
                    $('#takht').empty();
                    if (data!='notfound') {
                        data.forEach(function (item, index) {
                            $('#pansion').append(`<option value="${item.id}">${item.name}</option>`)
                        });
                    }

                }
            });
            $('#pansion').change(function (ev) {

                let pansionId=$(this).val();
                $.ajax(
                    {
                        url:"{{asset('admin/getroombypansion')}}/" + pansionId,
                        success:function (data) {
                            $('#room').empty()
                            $('#room').append(`<option value="">اتاق را انتخاب کنید.</option>`);
                            data.forEach(function (item,index) {
                                $('#room').append(`<option value="${item.id}"> طبقه ${item.floor} اتاق ${item.roomnumber}  </option> `)
                            })

                        }
                    }
                )


            });
            $('#room').change(function (ev) {

                let roomId=$(this).val();
                $.ajax(
                    {
                        url:"{{asset('admin/gettakhtbyroom')}}/" + roomId,
                        success:function (data) {
                            $('#takht').empty()
                            $('#takht').append(`<option value="">تخت را انتخاب کنید.</option>`);
                            data.forEach(function (item,index) {
                                $('#takht').append(`<option price="${item.price}" value="${item.id}"> تخت شماره ${item.takhtnumber} </option> `)
                            })

                        }
                    }
                )
            });
            $('#takht').change(function (ev) {
                $('#tbody-users').empty()
let id =$(this).val();
                $.ajax({
                    url:"{{asset('admin/getcustomsbytakht')}}/" + id,
                    success:function (data) {
                        if(data!='notfound') {

                            data.forEach(function(item,index){
                                $('#tbody-users').append(`<tr>
      <td>${index+1}</td>
                        <td>${item.name!=null ? item.name:'-'}</td>
                        <td>${item.family!=null ? item.family:'-'}</td>
                        <td>${item.ncode!=null ? item.ncode:'-'}</td>
                        <td>${item.mobilecode!=null ? item.mobilecode:'-'}</td>
                        <td>${item.saken!=null ? item.saken:'-'}</td>
                        <td>${item.bedehi!=null ? item.bedehi:'-'} تومان ${item.mali}</td>
                        <td>
                            <a href="{{asset('admin/reserveuser')}}/${item.id}" title="رزرو ها" class="btn btn-success"><i class="fa fa-book"></i> </a>
                            <a href="{{asset('admin/khorooji')}}/${item.orderId}" title="خروج" class="btn btn-warning m-1"><i class="fa fa-sign-out"></i> </a>
                            <a href="{{asset('admin/wheremove')}}/${item.orderId}" title="جابجایی" class="btn btn-warning m-1"><i class="fa fa-arrow-right-arrow-left"></i> </a>
                            <a href="{{asset('admin/vazait')}}/${item.orderId}" title="تغییر وضعیت" class="btn btn-warning m-1"><i class="fa fa-calendar-days"></i> </a>
                            <a href="{{asset('admin/ekhraaji')}}/${item.orderId}" title="اخراج" class="btn btn-warning m-1"><i class="fa fa-face-angry"></i> </a>
                             <a href="{{asset('admin/pastcancel')}}/${item.orderId}" title="کنسل" class="btn btn-warning m-1"><i class="fa fa-cancel"></i> </a>
                            <button href="#" class="btn text-white btn-info" style="padding: 10px 12px" title="نمایش"  data-toggle="modal" data-target="#other-modal-${index+1}"><i class="fas fa-eye"></i> </button>
                            <!-- modal otherdetail -->
                            <div class="modal fade" id="other-modal-${index+1}" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label>آدرس</label>
                                                        <div>
${item.addr}
                            </div>
                        </div>

                    </div>

                </div>


            </div>
        </div>

    </div>
</div>
{{--                            <a href="{{route('provider.edit',$user->id)}}" class="btn text-white btn-warning" style="padding: 10px 12px" title="ویرایش" target="_blank"><i class="fas fa-edit"></i> </a>--}}
                                <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="${item.id}" data-toggle="modal" data-target="#delete-modal-${index+1}"><i class="fas fa-trash"></i> </button>
                            <!-- modal delete -->
                            <div class="modal fade" id="delete-modal-${index+1}" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
                                            <div style="text-align: right">
                                                <p>آیا می خواهید  ${item.family} حذف شود؟</p>
                                            </div>
                                            <div style="text-align: left">
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="${item.id}" data-toggle="modal" data-target="#delete-modal-${index+1}">حذف </button>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </td>

</tr>`);
                            })

                        }

                    }
                })

            });
            $('#clickSearch').click(function(e){
                $("#tbody-users").empty();
             let column = $("#wichSearch").val();
             let data =  $("#search-ncode").val();
                $.ajax({
                    url:"{{asset('admin/getcustomsbyncode')}}/" + column + "/" + data,
                    success: function(data){
                        if (data!='notfound') {
                            data.forEach(function (item, index) {
                                $('#tbody-users').append(`<tr>
      <td>${index + 1}</td>
                        <td>${item.name != null ? item.name : '-'}</td>
                        <td>${item.family != null ? item.family : '-'}</td>
                        <td>${item.ncode != null ? item.ncode : '-'}</td>
                        <td>${item.mobilecode != null ? item.mobilecode : '-'}</td>
                        <td>${item.saken != null ? item.saken : '-'}</td>
                        <td>${item.bedehi != null ? item.bedehi : '-'} تومان ${item.mali}</td>
                        <td>
                            <a href="{{asset('admin/reserveuser')}}/${item.id}" title="رزرو ها" class="btn btn-success"><i class="fa fa-book"></i> </a>
                            <a href="{{asset('admin/khorooji')}}/${item.orderId}" title="خروج" class="btn btn-warning m-1"><i class="fa fa-sign-out"></i> </a>
                            <a href="{{asset('admin/wheremove')}}/${item.orderId}" title="جابجایی" class="btn btn-warning m-1"><i class="fa fa-arrow-right-arrow-left"></i> </a>
                            <a href="{{asset('admin/vazait')}}/${item.orderId}" title="تغییر وضعیت" class="btn btn-warning m-1"><i class="fa fa-calendar-days"></i> </a>
                            <a href="{{asset('admin/ekhraaji')}}/${item.orderId}" title="اخراج" class="btn btn-warning m-1"><i class="fa fa-face-angry"></i> </a>
                             <a href="{{asset('admin/pastcancel')}}/${item.orderId}" title="کنسل" class="btn btn-warning m-1"><i class="fa fa-cancel"></i> </a>
                            <button href="#" class="btn text-white btn-info" style="padding: 10px 12px" title="نمایش"  data-toggle="modal" data-target="#other-modal-${index + 1}"><i class="fas fa-eye"></i> </button>
                            <!-- modal otherdetail -->
                            <div class="modal fade" id="other-modal-${index + 1}" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label>آدرس</label>
                                                        <div>
${item.addr}
                            </div>
                        </div>

                    </div>

                </div>


            </div>
        </div>

    </div>
</div>
{{--                            <a href="{{route('provider.edit',$user->id)}}" class="btn text-white btn-warning" style="padding: 10px 12px" title="ویرایش" target="_blank"><i class="fas fa-edit"></i> </a>--}}
                                <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="${item.id}" data-toggle="modal" data-target="#delete-modal-${index + 1}"><i class="fas fa-trash"></i> </button>
                            <!-- modal delete -->
                            <div class="modal fade" id="delete-modal-${index + 1}" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
                                            <div style="text-align: right">
                                                <p>آیا می خواهید  ${item.family} حذف شود؟</p>
                                            </div>
                                            <div style="text-align: left">
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="${item.id}" data-toggle="modal" data-target="#delete-modal-${index + 1}">حذف </button>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </td>

</tr>`);
                            })
                        }
                    }
                });
            });
            $('.dataTables_filter').hide()
            $('.hrefbtn').hide();
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
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">جدول مشترکین خارج شده</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- category table-->
    <div class="container card px-5" style="margin-top: 230px;background-color: gainsboro">
        @if($users!='notfound')
        <table class="align-right table table-hover table-dark table-striped mytable w-100 pt-2">
            <thead>
            <tr>

                <th>شماره لیست</th>
                <th>نام</th>
                <th>نام خانوادگی</th>
                <th>کد ملی</th>
                <th>شماره موبایل</th>
                <th>وضعیت حال</th>
                <th>بدهکاری</th>
                <th>تنظیمات</th>
            </tr>
            </thead>
            <tbody id="tbody-users">

                @foreach($users as $key=>$user)
                    <tr data-id="{{$user->id}}">
                        {{--             @if($tik->ferestande=\Illuminate\Support\Facades\Auth::id() or $tik->girande=\Illuminate\Support\Facades\Auth::id())--}}
                        <td>{{++$key}}</td>
                        <td>{{$user->name!=null ? $user->name:'-'}}</td>
                        <td>{{$user->family!=null ? $user->family:'-'}}</td>
                        <td>{{$user->ncode!=null ? $user->ncode:'-'}}</td>
                        <td>{{$user->mobilecode!=null ? $user->mobilecode:'-'}}</td>
                        <td>{{$user->saken!=null ? $user->saken:'-'}}</td>
                        <td>{{number_format(abs($user->wallet[0]->bedehkar))}} تومان {{$user->mali}}</td>
                        <td>
                            <a href="{{route('reserveuser',$user->id)}}" title="رزرو ها" class="btn btn-success"><i class="fa fa-book"></i> </a>
                            <a href="{{route('khorooji',$user->orderId)}}" title="خروج" class="btn btn-warning m-1"><i class="fa fa-sign-out"></i> </a>
                            <a href="{{route('wheremove',$user->orderId)}}" title="جابجایی" class="btn btn-warning m-1"><i class="fa fa-arrow-right-arrow-left"></i> </a>
                            <a href="{{route('vaziat',$user->orderId)}}" title="تغییر وضعیت" class="btn btn-warning m-1"><i class="fa fa-calendar-days"></i> </a>
                            <a href="{{route('ekhraaji',$user->orderId)}}" title="اخراج" class="btn btn-warning m-1"><i class="fa fa-face-angry"></i> </a>
                            <a href="{{route('pastcancel',$user->orderId)}}" title="کنسل" class="btn btn-warning m-1"><i class="fa fa-cancel"></i> </a>
                            <a href="{{route('gettransactionbyuser',$user->id)}}" title="تراکنش مالی" class="btn btn-info m-1"><i class="fa fa-money-bill"></i> </a>
                            <button href="#" class="btn text-white btn-info" style="padding: 10px 12px" title="نمایش"  data-toggle="modal" data-target="#other-modal-{{$key}}"><i class="fas fa-eye"></i> </button>
                            <!-- modal otherdetail -->
                            <div class="modal fade" id="other-modal-{{$key}}" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label>آدرس</label>
                                                        <div>
                                                            {{count($user->address)!=0?$user->address[0]->addr:'-'}}
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>
{{--                            <a href="{{route('provider.edit',$user->id)}}" class="btn text-white btn-warning" style="padding: 10px 12px" title="ویرایش" target="_blank"><i class="fas fa-edit"></i> </a>--}}
                            <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="{{$user->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}"><i class="fas fa-trash"></i> </button>
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
                                                <p>آیا می خواهید  {{$user->family}} حذف شود؟</p>
                                            </div>
                                            <div style="text-align: left">
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$user->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>

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
            <div class="alert-danger p-1 my-1">مشترک خارج شده ای وجود ندارد.</div>
        @endif
    </div>
@endsection
