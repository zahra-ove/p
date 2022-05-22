@extends('store.master.home')

@section('js')
    <script>
        $(document).ready(function (e) {

            $('li').removeClass('current-item');
            $('.contact-menu').addClass('current-item');
        });

    </script>
@endsection

@section('content')
    <!-- preloader -->
    <div class="knsl-preloader-frame">
        <div class="knsl-preloader">
            <img src="img/logo.svg" alt="Kinsley">
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
{{--    <section class="knsl-banner-simple knsl-transition-bottom">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-12">--}}

{{--                    <div class="knsl-center knsl-title-frame">--}}
{{--                        <h1 class="knsl-mb-20 knsl-h1-inner">در تماس باشید</h1>--}}
{{--                        <p class="knsl-mb-30">تخفیف مینیاپولیس. به هیچ وجه نتیجه ای حاصل نمی شود که از آنچه برای لذت شدید انتخاب شده است ، اما لذت را کنار بگذارد. تنقلات رایگان که به راحتی ادارات را نکوهش می کنند تا نیاز به جلوگیری از بدتر این نفرت را پیدا کنند.</p>--}}
{{--                        <ul class="knsl-breadcrumbs">--}}
{{--                            <li><a href="home-1.html">خانه</a></li>--}}
{{--                            <li><span>تماس با ما</span></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <!-- banner end -->

    <!-- contact -->
    <section class="knsl-p-100-100">

        <div id="knsl-triger-1"></div>

        <div class="container">

            <!-- features card -->
            <div class="">

                <div class="row">
                    <div class="col-12 col-lg-4">

                        <!-- icon box -->
                        <div class="knsl-icon-box">
                            <img src="img/features/9.svg" alt="icon" class="knsl-mb-10">
                            <h5 class="knsl-mb-10">آدرس</h5>
                           {!! $contact!='notfound'?$contact->address:'' !!}
                        </div>
                        <!-- icon box end -->

                    </div>
                    <div class="col-12 col-lg-4">

                        <!-- icon box -->
                        <div class="knsl-icon-box">
                            <img src="img/features/10.svg" alt="icon" class="knsl-mb-10">
                            <h5 class="knsl-mb-10">تماس</h5>
                            <p>   {!! $contact!='notfound'?$contact->phone:'' !!}</p>
                        </div>
                        <!-- icon box end -->

                    </div>
                    <div class="col-12 col-lg-4">

                        <!-- icon box -->
                        <div class="knsl-icon-box">
                            <img src="img/features/11.svg" alt="icon" class="knsl-mb-10">
                            <h5 class="knsl-mb-10">ایمیل</h5>
                            <p> {!! $contact!='notfound'?$contact->email:'' !!}</p>
                        </div>
                        <!-- icon box end -->

                    </div>
                </div>

            </div>
            <!-- contact end -->

        </div>
    </section>


{{--    <section class="knsl-transition-top knsl-p-0-100">--}}

{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-12">--}}

{{--                    <div class="knsl-center knsl-title-frame knsl-scroll-animation knsl-mb-100">--}}
{{--                        <h2 class="knsl-mb-20">کینزلی منتظر شماست !</h2>--}}
{{--                        <p class="knsl-mb-30">تخفیف مینیاپولیس. به هیچ وجه نتیجه ای حاصل نمی شود که از آنچه برای لذت شدید انتخاب شده است ، اما لذت را کنار بگذارد. تنقلات رایگان که به راحتی ادارات را نکوهش می کنند تا نیاز به جلوگیری از بدتر این نفرت را پیدا کنند.</p>--}}
{{--                        <a href="about.html" class="knsl-btn knsl-btn-md">اطلاعات بیشتر</a>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--                <div class="col-lg-12">--}}
{{--                    <form class="knsl-scroll-animation">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-lg-6">--}}
{{--                                <input type="text" placeholder="نام">--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-6">--}}
{{--                                <input type="email" placeholder="ایمیل">--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-12">--}}
{{--                                <textarea name="name" rows="8" placeholder="متن"></textarea>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-12">--}}
{{--                                <div class="knsl-form-submit-frame">--}}
{{--                                    <!-- temporary button to show the popup -->--}}
{{--                                    <a class="knsl-btn" data-fancybox href="#knsl-success">ارسال</a>--}}
{{--                                    <!-- <button class="knsl-btn">ارسال</button> -->--}}
{{--                                    <div class="knsl-text-sm">ما قول می دهیم اطلاعات شخصی شما را برای اشخاص ثالث اعلام نکنیم</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    @endsection
