@extends('store.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
<style>
    .knsl-top-bar{
        top: 0px;
    }
    .select2-container .select2-selection--single{
        height: 50px!important;

    }
    .select2-container--default .select2-selection--single{
        border: 1px solid #ced4da!important;
    }
</style>
@section('content')
<div class="container text-center" style="margin-top: 90px">
    <div class="row mt-5 p-5" style="border: 1px solid #727576">
        <div class="col-12 text-center">
            <h2>ثبت نام مشتری</h2>

            @if($errors->any())
                <div class="alert alert-danger mt-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
{{--            <form class="mt-5" method="post" action="" >--}}
        <form method="POST" action="{{route('post.register')}}" class="mt-5">
            @csrf
            <div class="row text-center mt-5">
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-name">نام</label>
                <input class="form-control" name="name" type="text" id="signup-name"
                       placeholder="نام خود را وارد کنید" value="{{old('name')}}" required>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-name">نام خانوادگی</label>
                <input class="form-control" name="family" type="text" id="signup-family"
                       placeholder="نام خانوادگی خود را وارد کنید" value="{{old('family')}}" required>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-name">شماره موبایل</label>
                <input class="form-control justnumber mobileInput" name="mobilecode" type="text" id="signup-mobile"
                       placeholder="09121234567" value="{{old('mobilecode')}}" required>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-name">کد ملی</label>
                <input class="form-control justnumber" name="ncode" type="text" id="signup-ncode"
                       placeholder="کد ملی خود را وارد کنید" value="{{old('ncode')}}" required>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-name">شهر</label>
                <div>
                    <select id="selecetCityRegister" class="form-control select2" style="color:#908f95;;height: 50px" name="city_id">
                        <option style="color:black"> شهر خود را انتخاب کنید. </option>
                        @if($cities!='notfound')
                            @foreach($cities as $city)
                                <option value="{{$city->id}}" style="color:black" {{ old('city_id') == $city->id ? "selected" : "" }}>{{$city->cityName}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-email">پست الکترونیکی</label>
                <input class="form-control" name="email" type="email" id="signup-email"
                       placeholder="ایمیل خود را وارد کنید"   required>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-email">تاریخ تولد</label>
                <input class="form-control" name="birthday" id="signup-birthday"
                       placeholder="__/__/____" value="{{old('birthday')}}" required>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-password">رمز عبور <span
                        class='fs-sm text-muted'>حداقل 8 کاراکتر</span></label>
                <div class="password-toggle">
                    <input class="form-control" name="password" type="password" id="signup-password"
                           minlength="8" required>
                </div>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-password-confirm">تایید رمز عبور</label>
                <div class="password-toggle">
                    <input class="form-control" type="password" name="password_confirmation" id="signup-password-confirm"
                           minlength="8" required>
                </div>
            </div>
            <div class="mb-4 col-12 col-lg-4 row mt-5" style=" text-align: right;">
                <label class="form-label col-12 mb-2" for="signup-password-confirm">جنسیت</label>
                <div class="col-md-6 row">
                    <div class="col-4">
                        <label for="gender">مرد</label>
                    </div>
                    <div class="col-6">
                        <input id="gender" type="radio"
                               class="@error('gender') is-invalid @enderror"
                               name="gender" required
                               value="male" style="height: auto" checked>
                    </div>
                </div>
                <div class="col-md-6 row">
                    <div class="col-4">
                        <label for="gender">زن</label>
                    </div>
                    <div class="col-6">
                        <input id="gender" type="radio"
                               class="@error('gender') is-invalid @enderror h-auto"
                               name="gender" style="height: auto" required
                               value="female">
                    </div>
                </div>

            </div>

            <div class="form-check mb-4 col-12 mt-5" style=" text-align: right;">
                <input class="form-check-input" style="height: auto" type="checkbox" id="agree-to-terms" required>
                <label class="form-check-label" for="agree-to-terms"> با ثبت نام در این سایت <a
                        href='#'> شرایط</a> و <a href='#'>قوانین </a> سایت را قبول دارم.</label>
            </div>
            </div>
            <input class="btn btn-primary w-25" type="submit" value="ثبت نام" >
        </form>
    </div>

</div>
@endsection
