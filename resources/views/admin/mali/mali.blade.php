@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
<style>
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
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('reserveuser',$statusmali->order->user_id)}}">تاریخچه رزرو های مشترک {{$statusmali->fullname}} </a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">گزارش مالی رزرو</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <div class="container card px-3 " style="margin-top: 230px;background-color: gainsboro">
        <div class="table-responsive">
            <table class="table table-info mt-4">
                <thead class="text-white">
                <th>تخت</th>
                <th>مبلغ قابل پرداخت</th>
                <th>مبلغ پرداخت شده</th>
                <th>تخفیف</th>
                <th>بدهکار</th>
                <th>وضعیت پرداخت</th>
                </thead>
                <tbody>
                <td>{{$statusmali->pansionname}} اتاق {{$statusmali->roomnumber}} تخت {{$statusmali->takhtnumber}}</td>
                <td>{{number_format($statusmali->bedehkar)}} تومان</td>
                <td>{{number_format($statusmali->bestankar)}} تومان</td>
                <td>{{number_format($statusmali->takhfif)}} تومان</td>
                <td>{{number_format($statusmali->bedehi)}} تومان</td>
                <td>{{$statusmali->statusmalis}}</td>

                </tbody>
            </table>
        </div>

    @if($statusmali->aqsat!=null)
        <h3 class="mt-5">جزییات پرداخت</h3>
            <div class="table-responsive">
        <table class="table">
            <thead class="bg-dark">
            <tr class="text-white">
                <th>شماره</th>
                <th>زمان قسط</th>
                <th>زمان پرداختی</th>
                <th>مبلغ</th>
                <th>وضعیت</th>
            </tr>
            </thead>
            <tbody>
            @foreach($statusmali->aqsat as $key=>$qest)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$qest->paytime}}</td>
                    <td>{{$qest->pardakhti!=null?$qest->pardakhti:'-'}}</td>
                    <td>{{number_format($qest->amount)}} تومان</td>
                    <td>{{$qest->vaziat}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
            </div>
    @elseif($statusmali->naqditype!=null)
            <h3 class="mt-5">جزییات پرداخت</h3>
            <table class="table">
                <thead class="bg-dark">
                <tr class="text-white">
                    <th>شماره</th>
                    <th>نوع پرداخت</th>
                    <th>مبلغ</th>
                </tr>
                </thead>
                <tbody>
                @foreach($statusmali->naqditype as $key=>$naqditype)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$naqditype->title}}</td>
                        <td>{{number_format($naqditype->mablagh)}} تومان</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    @endif
</div>
@endsection
