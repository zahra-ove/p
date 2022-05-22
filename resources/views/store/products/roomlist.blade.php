@extends('store.master.home')

@section('js')
    <script>
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        };
        $(document).ready(function (e) {
            $('.goTo').each(function (index) {
                $(this).attr('href',$(this).attr('href')+'/?'+`pansion=${getUrlParameter('pansion')}&raft=${getUrlParameter('raft')}&reserve=${getUrlParameter('reserve')}&month=${getUrlParameter('month')}&bargasht=${getUrlParameter('bargasht')}`);
            });
        });
    </script>
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
                            <h1 class="knsl-mb-20 knsl-h1-inner">اتاق های خوابگاه {{$rooms[0]->pansion->name}}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- banner end -->

        <!-- rooms -->
        <section class="knsl-p-100-100">
            <img src="img/palm.svg" class="knsl-deco-left" alt="palm">
            <div class="container">
                <div class="knsl-masonry-grid knsl-3-col">
                    <div class="knsl-grid-sizer"></div>
                    @if($rooms!='notfound')
                    @foreach($rooms as $room)
                        @if($room->showPhoto!=null)
                            <div class="knsl-masonry-grid-item knsl-masonry-grid-item-33 deluxe">
                                <!-- room card -->
                                <div class="knsl-room-card">
                                    <div class="knsl-cover-frame">
                                        <a class="goTo" href="{{route('gettakhtbyprice',$room->floor)}}"><img class="w-100" src="{{asset($room->showPhoto)}}" alt="cover"></a>
                                    </div>
                                    <div class="knsl-description-frame">
                                        <div class="knsl-room-features">
                                            <div class="knsl-feature">
                                                <div class="knsl-icon-frame"><i class="fa fa-bed"></i></div>
                                                <span>{{$room->counttakht}} تخت </span>
                                            </div>
                                            <div class="knsl-feature">
                                                <div class="knsl-icon-frame"><i class="fa fa-restroom"></i> </div>
                                                <span>ظرفیت  {{$room->capacity}} </span>
                                            </div>
                                        </div>
                                        <a href="{{route('detailroom',$room->id)}}">
                                            <h3 class="knsl-mb-20">  اتاق {{$room->roomnumber}} طبقه {{$room->floor}}</h3>
                                        </a>
                                    </div>
                                </div>
                                <!-- room card end -->
                            </div>
                        @endif
                    @endforeach
                    @endif
                </div>
                <ul class="knsl-pagination">
                    <li class="knsl-active"><a href="#.">1</a></li>
                </ul>
            </div>
        </section>
        <!-- rooms end -->

        <!-- testimonials -->
        <section class="knsl-p-100-80" style="background-color: #ECFAFB">
            <img src="img/palm.svg" class="knsl-deco-left" alt="palm">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                    </div>
                </div>
            </div>
        </section>
        <!-- testimonials end -->

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
