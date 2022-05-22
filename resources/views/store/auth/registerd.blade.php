@extends('store.master.home')

@section('content')
    <!-- banner -->
    <section class="knsl-banner-simple knsl-transition-bottom">

        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="knsl-center knsl-title-frame">
                        <h1 class="knsl-h1-inner">اوه! ما کجا هستیم؟</h1>
                        <div class="knsl-404">خطا</div>
                        <p class="knsl-mb-30">قبلاٌ وارد شده اید.! این صفحه برای ثبت نام می باشد که شما قبلاٌ انجام داده اید.<br> ممکن است صفحه را اشتباه وارد شده باشید.</p>
                        <a href="{{asset('/')}}" class="knsl-btn">بازگشت به خانه</a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- banner end -->
@endsection
