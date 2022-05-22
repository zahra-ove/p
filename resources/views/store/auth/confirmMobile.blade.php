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
            <h2>دریافت کد تایید شماره همراه</h2>

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
            {{--           دریافت کد تایید         --}}
            <div class="mb-4 col-12 col-lg-4 row mt-5" style=" text-align: center;margin:auto">
                <form method="POST"  action="{{ route('check.verifycode') }}" >
                    @csrf
                        <div class="input-group">
                            <input class="form-control justnumber  m-auto" name="active_code" id="signin_active_code"
                                   placeholder="کد تایید در این بخش وارد شود" required autocomplete="off" style="font-size:12px;">
                            <input type="hidden" value="{{$user_id}}" id="user_id" name="user_id">
                            <div class="input-group-prepend" id="getVerificationCode">
                                <div class="input-group-text btn" id="counter" style="font-size:12px;">دریافت کد تایید</div>
                            </div>
                        </div>
                    <button class="btn btn-primary mt-3" id="send_verify_code" type="submit">ثبت کد تایید</button>
                </form>
            </div>

        </div>
    </div>
</div>


@endsection
