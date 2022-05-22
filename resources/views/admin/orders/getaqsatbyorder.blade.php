@extends('admin.master.home')
@section('css')
    .owl-carousel .owl-item img {
        height: 96.828px;
    }

    .dataTables_wrapper {
        margin-top: 50px;
    }

    a.btn {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .select2 {
        width: 100% !important;
    }

    @media (min-width: 1400px) {
        .container {
            max-width: 1350px !important;
        }
    }

    @media (min-width: 992px) {
        .mr-140 {
            margin-right: 140px !important;
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

    .pagination {
        display: inline-block;
    }

    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
        border-radius: 5px;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
        border-radius: 5px;
    }
@endsection
@section('js')
    <script>
        $(document).ready(function (e) {
            $('.modal').on('hidden.bs.modal', function () {
                $('select').val('');
                $('input[type="text"]').val('');
                $('input[type="file"]').val('');
                $('.fa-check.text-success').remove();
                $('.select2-selection__rendered').html('انتخاب کنید.');
                $('.select2-selection__rendered').attr('title','انتخاب کنید.');
                console.log($('select').val())
            });
            $('.hrefbtn').hide();
            $('#orderList_length').hide();
            $(".datePick").persianDatepicker({
            });

$('.resid').change(function (ees) {
    if (ees.target.files.length){
        $(this).after('<i class="fa fa-check fa-2x text-success pl-2"></i>');
    }
});
$('form').submit(function (esub) {


    let $this=$(this);
    let dataId=$(this).attr('data-id');


    if ($(`.datePick[data-id=${dataId}]`).val().length==0){
        esub.preventDefault();
        toastr.error('تاریخ پرداخت را نتخاب کنید.');

    }

    if ($(`select[data-id=${dataId}]`).val().length==0){
        esub.preventDefault();
        toastr.error('نوع پرداخت را نتخاب کنید.');

    }
    if ($(`.resid[data-id=${dataId}]`).val().length==0){
        esub.preventDefault();
        toastr.error('تصویر سند واریزی وجود ندارد.');

    }
    $('input[name="paytarikh"]').each(function (index) {
        if ($(this).val()!=null){
            $(this).val($(this).attr('data-gdate').replaceAll('/','-'));
        }
    });
    $('.resid').each(function (index) {


        if ($(this).attr('data-id')==$this.attr('data-id')){
            if ($(this).val()==""){

                esub.preventDefault();
                toastr.warning('ثبت رسید پرداخت الزامی می باشد.');
            }
        }
    });
});

            $('.hrefbtn').attr('href', "{{route('pansion.create')}}");



        });

    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded"
                 style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a>
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('getordersnotpay')}}">لیست رزرو های بدهکار</a>
                        </li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">
                          لیست اقساط رزرو {{$order->user->name.' '.$order->user->family}}

                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- category table-->
    <div class="container card px-5" style="margin-top: 230px;background-color: gainsboro">
        <div class="row ">
            <div class="col-12">
                @if($aqsat!='notfound')
                <table id="orderList" class="align-right table table-hover table-dark table-striped w-100 pt-2 mytable">
                    <thead>
                    <tr>

                        <th>شماره لیست</th>
                        <th>نام و نام خانوادگی</th>
                        <th>تخت</th>
                        <th>مبلغ</th>
                        <th>تاریخ موعود</th>
                        <th>تاریخ پرداخت</th>
                        <th>وضعیت پرداخت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($aqsat as $key=>$qest)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$qest->fullname!=null?$qest->fullname:'-'}}</td>
                        <td>خوابگاه {{$qest->pansionname}} اتاق {{$qest->roomnumber}} شماره تخت {{$qest->takhtnumber}}</td>
                        <td>{{$qest->amount!=null?number_format($qest->amount).' '.'تومان':'-'}}</td>
                        <td>{{$qest->tarikh!=null?$qest->tarikhJalali:'-'}}</td>
                        <td>{{$qest->paytarikh!=null?$qest->payTarikhJalali:'-'}}</td>
                        <td>{{$qest->vaziat}}</td>
                        <td>
                            @if($qest->status=='0')
                            <span style="cursor: pointer" class="btn btn-success" data-target="#pay-{{$key}}" title="پرداخت" data-toggle="modal"><i class="fa fa-credit-card"></i> </span>
                                <!-- PayModal -->
                                <div class="modal fade" id="pay-{{$key}}" role="dialog">
                                    <div class="modal-dialog modal-lg">

                                        <!-- Modal content-->
                                        <div class="modal-content text-dark">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form data-id="{{$qest->id}}" class="form-submit" action="{{route('payQest',$qest->id)}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                              <div class="container-fluid px-5">
                                                  <div class="row justify-content-between">
                                                      <div class="col-lg-6 col-12 mb-3 mt-5 row">
                                                          <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                                              <span class="form-label mb-2 position-relative" style="top: 12%">نوع پرداخت</span>
                                                          </div>
                                                          <div class="col-9 p-0 ">
                                                              <select data-id="{{$qest->id}}" name="naqdtype" class="form-control select2">
                                                                  <option value="">نوع پرداخت را انتخاب کنید.</option>
                                                                  @if($naqdtypes!="notfound")
                                                                      @foreach($naqdtypes as $naqdtype)
                                                                          <option value="{{$naqdtype->id}}">{{$naqdtype->title}}</option>
                                                                      @endforeach
                                                                  @endif
                                                              </select>
                                                          </div>
                                                      </div>
                                                      <div class="col-lg-6 col-12 mb-3 mt-5 row">
                                                          <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                                              <span class="form-label mb-2 position-relative" style="top: 12%">تاریخ</span>
                                                          </div>
                                                          <div class="col-9 p-0 ">
                                                              <input data-id="{{$qest->id}}" name="paytarikh" autocomplete="off" class="form-control datePick">
                                                          </div>
                                                      </div>
                                                      <div class="col-6 mb-3 mt-5 row">
                                                          <label for="bill-{{$key}}" style="width: 157px" class="btn btn-info">رسید</label>
                                                          <input data-id="{{$qest->id}}" name="fish" type="file" class="d-none resid" id="bill-{{$key}}" data-id="{{$qest->id}}">
                                                      </div>
                                                      <div class="col-12 mb-3 mt-5 text-right">
                                                          <input data-id="{{$qest->id}}" type="submit" style="width: 157px" value="ثبت" class="btn btn-success">
                                                      </div>
                                                  </div>
                                              </div>
                                                </form>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @elseif($qest->status=='1')
                            <!-- BillModal -->
                                <span title="رسید پرداخت" style="cursor: pointer" class="btn btn-warning" data-target="#pay-{{$key}}" data-toggle="modal"><i class="fa fa-check"></i> </span>
                                <div class="modal fade" id="pay-{{$key}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                              <img style="width: 100%" src="{{asset($qest->fish)}}">
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
                    <p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>
                @endif
            </div>

        </div>


    </div>
@endsection
