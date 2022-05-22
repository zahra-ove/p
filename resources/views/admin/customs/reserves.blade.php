@extends('admin.master.home')

@section('js')

    <script>

        $(document).ready(function () {
            $('.hrefbtn').attr('href', "{{route('order.create')}}");
            let addpubcheck = [];
//////ckeditor
//             CKEDITOR.replace('editor', {
//                 language: "fa",
//
//             });



            $('#product-attach').change(function (e) {
                let files = e.target.files;
                // console.log(files)
                let file = files[0];
                let reader = new FileReader();
                reader.onload = (function (theFile) {
                    $('.single-show-img').remove();
                    $('#noneImg').remove();
                    var imgSrc = theFile.target.result;
                    $('.singleShow').append("<img class='single-show-img' style='width: 400px;height: 400px' src='" + imgSrc + "'> ")
                });
                reader.readAsDataURL(this.files[0]);
            });
//
// // Read in the image file as a data URL.

//             });




        })
    </script>

@endsection
<style>
.w-15{
    width: 15%!important;
}
    #timeTable {
        height: 448.719px;
    }

    .select2 {
        width: 100% !important;
    }
    @media (min-width: 1500px){
        .container {
            max-width: 1450px!important;
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
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">تاریخچه رزرو های مشترک {{$user->name.' '.$user->family}} </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->



    <!-- reserves table-->
    <div class="container card px-5" style="margin-top: 330px;background-color: gainsboro">

        @if($orders!='notfound')
        <table class="align-right table table-hover table-dark table-striped mytable w-100">
            <thead>
            <tr>

                <th>شماره لیست</th>
                <th>نام پانسیون</th>
                <th>شماره اتاق</th>
                <th>شماره تخت</th>
                <th>شماره رزرو</th>
                <th>ثبت کننده</th>
                <th>وضعیت</th>
                <th>جابجایی</th>
                <th>تاریخ شروع</th>
                <th>تاریخ پایان</th>
                <th>تنظیمات</th>
            </tr>
            </thead>
            <tbody>

            @foreach($orders as $key=>$order)
            <tr>

                <td>{{++$key}}</td>
                <td>{{$order->pansion}}</td>
                <td>{{$order->takhtnumber}}</td>
                <td>{{$order->roomnumber}}</td>
                <td>{{$order->order_number}}</td>
                <td class="w-15">{{$order->karshenasName}}</td>
                <td>{{$order->vaziat}}</td>
                <td>{{$order->jabjayi}}</td>
                <td>{{$order->jalaliRaft}}</td>
                <td>{{$order->jalaliBargasht}}</td>
                <td>

                    <a href="{{route('getstatusmalibyorder',$order->id)}}" style="width: 40px" class="btn btn-secondary"><i class="fa fa-calculator"></i> </a>
                    @if($order->status_order_id==5)
                        <span style="cursor: pointer;width: 40px" title="علت اخراج" class="btn btn-info" data-toggle="modal" data-target="#ellatModal-{{$key}}"><i class="fa fa-question"></i> </span>
                        <!-- EllatModal -->
                        <div class="modal fade" id="ellatModal-{{$key}}" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body text-dark">
                                        <h5 class="alert-info p-2">علت اخراج</h5>
                                        <div class="card p-2" style="border: 1px solid #aaaaaa;background-color: #e3e3e3">
                                            {!! $order->ellat !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


    @endif
                </td>
            </tr>
            @endforeach

            </tbody>

        </table>
        @else
            <div class="alert-danger p-1 my-1">رزروی برای این کاربر ثبت نشده است.</div>
        @endif
    </div>

@endsection
