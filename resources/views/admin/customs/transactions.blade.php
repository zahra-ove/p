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
@section('js')
    <script>
        $(document).ready(function (e){

            $('.hrefbtn').hide();

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
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('reserveuser',$user->id)}}">تاریخچه رزرو های  {{$user->name.' '.$user->family}} </a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">تراکنش مالی های {{$user->name.' '.$user->family}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- category table-->
    <div class="container card px-5" style="margin-top: 330px;background-color: gainsboro;margin-bottom: 200px">
        @if($transactions!='notfound')
            <div class="table-responsive-md">
        <table class="align-right table table-hover table-dark table-striped mytable w-100 pt-2">
            <thead>
            <tr>

                <th>شماره لیست</th>
                <th>مبلغ</th>
                <th>نوع تراکنش</th>
                <th>شماره سفارش</th>
                <th>تاریخ</th>
                <th>مشاهده</th>
            </tr>
            </thead>
            <tbody>

                @foreach($transactions as $key=>$transaction)
                    <tr data-id="{{$transaction->id}}">
                        {{--             @if($tik->ferestande=\Illuminate\Support\Facades\Auth::id() or $tik->girande=\Illuminate\Support\Facades\Auth::id())--}}
                        <td>{{++$key}}</td>
                        <td>{{$transaction->price!=null ? number_format($transaction->price):'-'}} تومان {{($transaction->jarimeh!=0 || $transaction->jarimeh!=0)?"(مبلغ ".number_format($transaction->jarimeh).'تومان '.'جریمه)':''}}</td>
                        <td>{{$transaction->type!=null ? $transaction->type:'-'}}</td>
                        <td>{{$transaction->order!=null ? $transaction->order->order_number:'-'}}</td>
                        <td>{{$transaction->tarikh!=null ? $transaction->tarikh:'-'}}</td>

                        <td>
                            @if($transaction->fish!=null)
                            <button class="btn text-white btn-warning" style="padding: 10px 12px" title="فیش" data-id="{{$transaction->id}}" data-toggle="modal" data-target="#fish-modal-{{$key}}"><i class="fas fa-money-bill"></i> </button>
                            <!-- modal group -->
                            <div class="modal fade" id="fish-modal-{{$key}}" role="dialog">
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
                                                        <div class="w-sm-100 mr-auto"><h4 class="mb-0">تصویر فیش واریزی</h4></div>
                                                        <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
<div class="container-fluid">
    <img style="width: 400px" src="{{asset($transaction->fish)}}">
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
            </div>
        @else
            <div class="alert-danger p-1 my-1">تراکنشی تا الان انجام نشده است.</div>
        @endif
    </div>
@endsection
