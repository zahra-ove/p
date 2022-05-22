@extends('store.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
<style>
    .knsl-top-bar{
        top: 0px;
    }
</style>
@section('content')

   <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="container text-center" style="margin-top: 90px">
            <div class="row mt-5 p-5" style="border: 1px solid #727576">
                <div class="col-12 text-center">
                    <h2>ریست پسورد</h2>

                    @if (session('status'))
                        <div class="alert alert-success mt-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


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
                        <label class="form-label mb-2 w-50 m-auto py-3" for="email" style="text-align: right">آدرس ایمیل</label>
                        <input id="email" type="email" class="form-control w-50 m-auto @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" style="text-align: right" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <button class="btn btn-primary w-25" type="submit">ارسال لینک تغییر پسورد</button>
                </div>
            </div>
        </div>
    </form>
@endsection
