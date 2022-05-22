<!-- gallery -->
<section class="knsl-transition-top knsl-p-0-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">

                <!-- slider -->
                <div class="swiper-container knsl-about-slider knsl-scroll-animation" >
                    <div class="swiper-wrapper" dir="ltr">
                        @if($pansions!='notfound')
                        @foreach($pansions as $pansion)
                        <div class="swiper-slide">

                        <!-- gallery item -->
                            <div class="knsl-image-frame">
                                <a data-fancybox="gallery" href="{{asset($pansion->showPhoto)}}">
                                    <img src="{{asset($pansion->showPhoto)}}" alt="about">
                                    <div class="knsl-badge">خوابگاه {{$pansion->name}}</div>
                                    <span class="knsl-zoom"><i class="fas fa-search-plus"></i></span>
                                </a>
                            </div>  </div>
                            <!-- gallery item end -->
                        @endforeach
                        @endif
                    </div>

                    <!-- slider navigation -->
                    <div class="knsl-slider-nav-panel">
                        <!-- pagination -->
                        <div class="knsl-about-slider-1-pagination"></div>
                        <!-- navigation -->
                        <div class="knsl-about-slider-nav">
                            <div class="knsl-about-slider-1-prev"><i class="fas fa-arrow-right"></i></div>
                            <div class="knsl-about-slider-1-next"><i class="fas fa-arrow-left"></i></div>
                        </div>
                        <!-- navigation end -->
                    </div>
                    <!-- slider navigation end -->

                </div>
                <!-- slider end -->

            </div>

        </div>
    </div>

</section>
<!-- gallery end -->
