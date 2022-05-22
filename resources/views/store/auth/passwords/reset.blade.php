@extends('store.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
<style>
    .knsl-top-bar{
        top: 0px;
    }
</style>
@section('content')

    {{--    Display any error    --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif


    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="container text-center" style="margin-top: 90px">
            <div class="row mt-5 p-5" style="border: 1px solid #727576">

                <div class="col-12 text-center">
                    <h2>ریست پسورد</h2>
                </div>


                <div class="col-12 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5 text-center">
                    <div class="mb-4 ">
                        <label class="form-label mb-2 w-50 m-auto py-3" for="email" style="text-align: right">آدرس ایمیل</label>
                        <input id="email" type="email" class="form-control w-50 m-auto @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required style="text-align: right" autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="mb-4 ">
                        <label class="form-label mb-2 w-50 m-auto py-3" for="password" style="text-align: right">رمز عبور جدید</label>
                        <input id="password" type="password" class="form-control w-50 m-auto @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="text-align: right">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4 ">
                        <label for="password-confirm" class="form-label mb-2 w-50 m-auto py-3" style="text-align: right">تکرار رمز عبور</label>
                        <input id="password-confirm" type="password" class="form-control w-50 m-auto" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <button class="btn btn-primary w-25" type="submit">تغییر پسورد</button>
                </div>
            </div>
        </div>
    </form>
@endsection










