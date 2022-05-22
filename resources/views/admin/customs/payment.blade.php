@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">

@section('js')




@endsection
<style>

    #timeTable{
        height: 448.719px;
    }

    .select2 {
        width: 100% !important;
    }

    @media (min-width: 992px) {
        .taheHeight {
            height: 565px;
        }
    }

    @media (min-width: 992px) {
        .container {
            max-width: 992px !important;
        }

        .mr-140 {
            margin-right: 140px !important;
        }
    }

    @media (min-width: 1200px) {
        .container {
            max-width: 1200px !important;
        }
    }


    @media (min-width: 1500px) {
        .container {
            max-width: 1500px !important;
        }
    }


    @media (max-width: 576px) {
        .mr-140 {
            margin-right: 60px !important;
        }
    }

    .breadcrumb {
        background-color: white !important;
    }
    .select2-container{
        text-align: right;
    }
</style>



        <!-- START: Breadcrumbs-->
        <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
            <div class="col-12  align-self-center">
                <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
{{--                            <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>--}}
                            <li class="breadcrumb-item" style="background: #d0e7ff"><a class="text-danger" href="{{route('movereserve')}}">پرداخت</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END: Breadcrumbs-->
@section('content')
    @if(\Illuminate\Support\Facades\Auth::id()==$order->user->id)
        @if($order!='notfound')
        @if($order->status_order_id=='7')
        <div class="container" style="margin-top: 330px;background-color: gainsboro;">

        <!-- START: Form-->
        <form method="post" action="{{route('customstore')}}" id="submit" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid text-center" style="font-size: 16px">
           <div class="row">
               <div class="col-12 p-3">
                   <h4 id="price">مبلغ: {{number_format($totalPrice).' '.'تومان'}}</h4>
               </div>
               <div class="col-12 p-3">
                  <button type="submit" class="btn btn-success btn-lg">اتصال به درگاه</button>
               </div>
           </div>
            </div>
        </form>
        </div>
        @else
            <div class="container" style="margin-top: 330px;background-color: gainsboro;">
                <h4 class="p-3 alert-danger">امکان اتصال به درگاه برای این رزرو میسر نمی باشد.</h4>
            </div>
        @endif
        @endif
    @else
        <div class="container" style="margin-top: 330px;background-color: gainsboro;">
            <h4 class="p-3 alert-danger">امکان دسترسی برای شما میسر نمی باشد.</h4>
        </div>
        @endif
@endsection

