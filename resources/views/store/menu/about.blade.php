@extends('store.master.home')
@section('js')
    <script>
        $(document).ready(function (e) {

            $('li').removeClass('current-item');
            $('.about-menu').addClass('current-item');
        });

    </script>
@endsection

@section('content')
<!-- page wrapper -->
<div class="knsl-app">

    <!-- preloader -->
    <div class="knsl-preloader-frame">
        <div class="knsl-preloader">
            <img src="{{asset('img/logo.svg')}}" alt="Kinsley">
            <div class="knsl-preloader-progress">
                <div class="knsl-preloader-bar"></div>
            </div>
            <div><span class="knsl-preloader-number" data-count="101">0</span>%</div>
        </div>
    </div>
    <!-- preloader end -->

    <!-- datepicker frame -->
    <div class="knsl-datepicker-place"></div>



    <!-- banner -->
    <section class="knsl-banner-simple knsl-transition-bottom">
        <img src="img/palm.svg" class="knsl-deco-left" alt="palm">
        <img src="img/palm.svg" class="knsl-deco-right" alt="palm">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="knsl-center knsl-title-frame">
                        <h1 class="knsl-mb-20 knsl-h1-inner">درباره هتل ما</h1>
                        <p class="knsl-mb-30">{!!$about!='notfound'? $about->about_us:'' !!}</p>
                        <ul class="knsl-breadcrumbs">
                            <li><a href="home-1.html">خانه</a></li>
                            <li><span>درباره</span></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- banner end -->

    <!-- quote -->
    <section class="knsl-p-100-100">

        <div class="container">
            <div class="row">

                <div class="col-lg-12">

                    <div class="knsl-quote-with-author">

                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <div class="knsl-photo-frame">
                                    <img src="{!! $about->photo!=null?$about->photo[0]->path:'' !!}" alt="Author">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <blockquote class="">
                                    {!! $about!='notfound'?$about->about_boss:'' !!}
                                </blockquote>
                                <div class="knsl-quote-bottom">
                                    <div>
                                        <h4 class="">{!! $about!='notfound'?$about->boss_name:'' !!}</h4>
                                        <p>مدیر ارشد</p>
                                    </div>
{{--                                    <img src="img/signature.png" alt="signature" class="knsl-signature">--}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </section>
    <!-- quote end -->



</div>
<!-- page wrapper end -->
@endsection
