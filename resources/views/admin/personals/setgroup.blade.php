@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function (){
            $('#multiselect').multiselect();


            $("#setGroup").submit(function (e){
                if ($('#multiselect_to').children('option').length==0)
                {
                    e.preventDefault();
                }
            });

        });

    </script>
@endsection
<style>
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
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('personal.index')}}">لیست پرسنل</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">افزودن سمت برای پرسنل {{$personal->name.' '.$personal->family}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <form method="post" id="setGroup" action="{{route('setgroups')}}">
        @csrf
        <input name="uId" class="d-none" value="{{$personal->id}}">
        <div class="container card px-5" style="margin-top: 230px;background-color: gainsboro">

        <div class="row text-center mt-5 mb-5">
            <div class="col-md-8 row">
            <div class="col-xs-5 col-md-5">
                <select id="multiselect" class="w-100 h-100" size="8" multiple="multiple">
                    @if($groups!='notfound')
                    @foreach($groups as $g)
          <option value="{{$g->id}}">{{$g->name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-xs-2 col-md-2">
                <button type="button" id="multiselect_rightAll" class="btn btn-block btn-success">افزودن همه</button>
                <button type="button" id="multiselect_rightSelected" class="btn btn-block btn-success">افزودن تکی</button>
                <button type="button" id="multiselect_leftSelected" class="btn btn-block btn-danger">حذف تکی</button>
                <button type="button" id="multiselect_leftAll" class="btn btn-block btn-danger">حذف همه</button>
            </div>
            <div class="col-xs-5 col-md-5">
                <select name='gId[]' id="multiselect_to" class="form-control" size="8" multiple="multiple">
                </select>
            </div>
            </div>
            <div class="col-md-4 row">

                                <div class="col-12  text-center">
                                    <div class="col-12 mb-3">
                                        <button type="submit" class="w-50 btn btn-success pt-2 pb-2" id="groupsubmit">ثبت</button>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <button  class="w-50 btn btn-danger pt-2 pb-2">بازگشت</button>
                                    </div>
                            </div>
            </div>
        </div>

    </div>
    </form>
@endsection
