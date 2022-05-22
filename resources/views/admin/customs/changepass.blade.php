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
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">تغییر رمز</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- category table-->
    <div class="container card" style="margin-top: 330px;background-color: gainsboro">
        <form method="post" action="{{route('changePassword',$user->id)}}">
            @csrf
        <div class="row mt-5 p-5 justify-content-center">

            <div class="col-12 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5 justify-content-center">

                <div class="mb-4 col-12 row justify-content-center">
                    <div class="form-label mb-2 col-2 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                        <span class="form-label mb-2 position-relative" style="top: 24%">رمز قدیم</span>
                    </div>
                    <div class="col-10 p-0 ">
                    <input type="password" class="form-control w-50" name="oldPass" id="signin-mobilecode"
                            required autocomplete="off">
                </div>
                </div>
                <div class="mb-4 col-12 row justify-content-center">
                    <div class="form-label mb-2 col-2 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                        <span class="form-label mb-2 position-relative" style="top: 24%">رمز جدید</span>
                    </div>
                    <div class="col-10 p-0 ">

                    <input class="form-control w-50" name="newPass" type="password" id="signin-password"
                           placeholder="پسوورد خود را وارد کنید" autocomplete="off" required>

                    </div>
                </div>
                <button class="btn btn-primary w-25" id="submitLogin">تغییر رمز
                </button>
            </div>

        </div>
        </form>
@endsection
