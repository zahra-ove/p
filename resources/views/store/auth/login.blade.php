@extends('store.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
<style>
    .knsl-top-bar{
        top: 0px;
    }
</style>
@section('content')

<form method="POST" action="{{route('post.login')}}">
    @csrf
    <div class="container text-center" style="margin-top: 90px">
        <div class="row mt-5 p-5" style="border: 1px solid #727576">
            <div class="col-12 text-center">
                <h2>ورود مشتری</h2>

                {{--    Display any error    --}}
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
            <div class="col-12 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5 text-center">
                <div class="mb-4 ">
                    <label class="form-label mb-2 w-50 m-auto py-3" for="signin-email" style="text-align: right">شماره تماس</label>
                    <input class="form-control justnumber mobileInput w-50 m-auto" name="mobilecode" id="signin-mobilecode"
                           placeholder="شماره تماس خود را وارد کنید" required autocomplete="off">
                </div>

                <div class="mb-4 ">
                    <label class="form-label mb-0 w-50 m-auto py-3" for="signin-password" style="text-align: right">رمز عبور</label>
                    <input class="form-control w-50 m-auto" name="password" type="password" id="signin-password"
                           placeholder="پسوورد خود را وارد کنید" autocomplete="off" required>
                </div>

                <div class="mb-4">
                    <div class="form-label mb-0 w-50 m-auto py-3" style="text-align: right">
                        <a class="fs-sm mt-1" href="{{ route('password.request') }}">رمز عبور خود را فراموش کرده اید؟</a>
                    </div>
                    <div class="form-label mb-0 w-50 m-auto py-3" style="text-align: right">
                        <a href="{{route('register')}}" class="link-accent">ثبت نام</a>
                    </div>
                </div>

                <button class="btn btn-primary w-25" type="submit">ورود به حساب کاربری</button>
            </div>
        </div>
    </div>
</form>
@endsection





