@extends('store.master.home')

@section('js')

@endsection
@section('content')
    <!-- page wrapper -->
    <div class="knsl-app">

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
        <section class="knsl-banner-simple knsl-transition-bottom">
            <img src="img/palm.svg" class="knsl-deco-left" alt="palm">
            <img src="img/palm.svg" class="knsl-deco-right" alt="palm">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="knsl-center knsl-title-frame">
                            <h1 class="knsl-mb-20 knsl-h1-inner">اتاق {{$room->roomnumber}} در طبقه {{$room->floor}} خوابگاه {{$room->pansion->name}}</h1>
                            <ul class="knsl-breadcrumbs">
                                <li><a href="home-1.html">خانه</a></li>
                                <li><a href="#">اتاق ها</a></li>
                                <li><span>اتاق لوکس</span></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- banner end -->

        <!-- room -->
        <div class="knsl-p-100-100">
            <div class="container">
                <div class="row" data-sticky-container>
                    <div class="col-lg-8">

                        <div class="knsl-room-detail-slider-frame knsl-mb-60">
                            <div class="swiper-container knsl-rd-slider-2 knsl-mb-10">
                                <div class="swiper-wrapper">
                                    @if($room->photo!=null)
                                    @foreach($room->photo as $photo)
                                    <div class="swiper-slide">
                                        <a data-fancybox="gallery" href="img/rooms/2.jpg" class="knsl-room-detail-photo-lg" data-swiper-parallax="-80" data-swiper-parallax-scale="1.2" data-swiper-parallax-duration="400">
                                            <img src="{{asset($photo->path)}}" alt="اتاق">
                                            <span class="knsl-zoom"><i class="fas fa-search-plus"></i></span>
                                        </a>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="swiper-container knsl-rd-slider-1">
                                <div class="swiper-wrapper">
                                    @if($room->photo!=null)
                                    @foreach($room->photo as $photo)
                                    <div class="swiper-slide">
                                        <div class="knsl-room-detail-photo-sm">
                                            <img src="{{asset($photo->path)}}" alt="اتاق">
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <!-- sidebar -->
                        <div class="knsl-sticky knsl-stycky-right" data-margin-top="100">

                            <div class="knsl-book-form">
                                <form>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="knsl-input-frame">
                                                <label for="check-in">ورود</label>
                                                <input id="check-in" type="text" class="datepicker-here" data-position="bottom left" placeholder="انتخاب تاریخ" autocomplete="off" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="knsl-input-frame">
                                                <label for="check-out" class="knsl-add-icon">خروج</label>
                                                <input id="check-out" type="text" class="datepicker-here" data-position="bottom left" placeholder="انتخاب تاریخ" autocomplete="off" readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 knsl-center">
                                            <button type="submit" class="knsl-btn"><i class="fa fa-search"></i> جستجو</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- sidebar end -->

                    </div>
                </div>
            </div>
        </div>
        <!-- room end -->


        <!-- popup -->
        <div id="knsl-success" class="knsl-popup">
            <img src="img/features/12.svg" alt="success" class="knsl-succes-icon">
            <h2 class="knsl-mb-20">موفقیت</h2>
            <p>پیام شما با موفقیت ارسال شد <br>این پنجره بازشو برای نمایش وجود دارد.</p>
        </div>
        <!-- popup end -->

        <!-- popup -->
        <div class="knsl-popup-frame">
            <div class="knsl-book-form knsl-book-popup">
                <span class="knsl-close-popup">+</span>
                <h2 class="knsl-mb-40">جستجو اتاق</h2>
                <form>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="knsl-input-frame">
                                <label>ورود</label>
                                <input type="text" class="datepicker-here" data-position="bottom left" placeholder="انتخاب تاریخ" autocomplete="off" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="knsl-input-frame">
                                <label class="knsl-add-icon">خروج</label>
                                <input type="text" class="datepicker-here" data-position="bottom left" placeholder="انتخاب تاریخ" autocomplete="off" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="knsl-select-frame">
                                <label>شخص</label>
                                <select>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4" disabled>4</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="knsl-select-frame">
                                <label>کودک</label>
                                <select>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4" disabled>4</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 knsl-center">
                            <button type="submit" class="knsl-btn"><img src="img/icons/search.svg" class="knsl-zoom" alt="icon">جستجو</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <!-- popup end -->

    </div>
    <!-- page wrapper end -->
@endsection
