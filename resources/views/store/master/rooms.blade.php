<!-- rooms -->
@if($roompicks!='notfound')
<section class="knsl-transition-bottom" style="background-color: #ECFAFB">
    <img src="img/palm.svg" class="knsl-deco-left" alt="palm">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 mt-5">
                <div class="swiper-container knsl-uni-slider">
                    <div class="swiper-wrapper" dir="ltr">
                        @foreach($roompicks as $roompick)
                            <div class="swiper-slide">
                                <!-- room card -->
                                <div class="knsl-room-card knsl-scroll-animation">
                                    <div class="knsl-cover-frame">
                                        <a href="{{route('detailroom',$roompick->room->id)}}"><img src="{{$roompick->path}}" alt="cover"></a>
                                    </div>
                                    <div class="knsl-description-frame">
                                        <div class="knsl-room-features">
                                            <div class="knsl-feature">
                                                <div class="knsl-icon-frame"><i class="fa fa-bed"></i></div>
                                                <span>{{$roompick->room->counttakht}} تخت </span>
                                            </div>
                                            <div class="knsl-feature">
                                                <div class="knsl-icon-frame"><i class="fa fa-restroom"></i> </div>
                                                <span>ظرفیت  {{$roompick->room->capacity}} </span>
                                            </div>
                                        </div>
                                        <a href="{{route('detailroom',$roompick->room->id)}}">
                                            <h3 class="knsl-mb-20">اتاق شماره {{$roompick->room->roomnumber}} در طبقه {{$roompick->room->floor}} در خوابگاه {{$roompick->room->pansion->name}}</h3>
                                        </a>
                                    </div>
                                </div>
                                <!-- room card end -->
                            </div>
                        @endforeach
                    </div>
                    <!-- slider navigation -->
                    <div class="knsl-uni-slider-nav-panel">
                        <div class="knsl-uni-slider-pagination"></div>
                        <div class="knsl-uni-nav">
                            <div class="knsl-uni-slider-prev"><i class="fas fa-arrow-right"></i></div>
                            <div class="knsl-uni-slider-next"><i class="fas fa-arrow-left"></i></div>
                        </div>
                    </div>
                    <!-- slider navigation end -->

                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- rooms end -->
