@extends('store.master.home')

@section('js')
    <script src="{{asset('admin')}}/js/jdate.min.js" type="text/javascript" charset="utf-8"></script>
    <script>
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
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
            let jdateRaft=new JDate(new Date(getUrlParameter('raft')));
            let jdateBargasht=new JDate(new Date(getUrlParameter('bargasht')));
           let jalaliRaft=`${jdateRaft.date[0]}/${jdateRaft.date[1]}/${jdateRaft.date[2]}`;
           let jalaliBargasht=`${jdateBargasht.date[0]}/${jdateBargasht.date[1]}/${jdateBargasht.date[2]}`;
           $('.from').append(jalaliRaft);
           $('.to').append(jalaliBargasht);
let raftUnix=new Date(getUrlParameter('raft')).getTime();
let bargashtUnix=new Date(getUrlParameter('bargasht')).getTime();
let oneDay=24*60*60*1000;
let oneMonth=30*24*60*60*1000;
let diffUnix =bargashtUnix-raftUnix;
            let diffTime="";
            let totalPrice='';
if (getUrlParameter('reserve')=='days'){
    diffTime=Math.round(diffUnix/oneDay);
    $('.long').append(`${diffTime} روز`);
    $('.each').html(`کرایه برای هر روز:`);
    $('.eachPrice').html(`{{number_format($takht->price)}} تومان`);
    totalPrice=parseInt({{$takht->price}}) * parseInt(diffTime);
    $('.totalPrice').html(numberWithCommas(totalPrice)+" "+ 'تومان');
}
            if (getUrlParameter('reserve')=='months'){
                diffTime=Math.round(diffUnix/oneMonth);
                $('.long').append(`${diffTime} ماه`);
$('.each').html(`کرایه برای هر ماه:`);
$('.eachPrice').html(`{{number_format($takht->pricemonth)}} تومان`);
totalPrice=parseInt({{$takht->pricemonth}}) * parseInt(diffTime);
$('.totalPrice').html(numberWithCommas(totalPrice)+" "+ 'تومان');
            }


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
                            <h1 class="knsl-mb-20 knsl-h1-inner">اتاق {{$takht->room->roomnumber}} در طبقه {{$takht->room->floor}} خوابگاه {{$takht->room->pansion->name}}</h1>
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
                                    @foreach($takht->photo as $photo)
                                    <div class="swiper-slide">
                                        <a data-fancybox="gallery" href="{{asset($photo->path)}}" class="knsl-room-detail-photo-lg" data-swiper-parallax="-80" data-swiper-parallax-scale="1.2" data-swiper-parallax-duration="400">
                                            <img src="{{asset($photo->path)}}" alt="اتاق">
                                            <span class="knsl-zoom"><i class="fas fa-search-plus"></i></span>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="swiper-container knsl-rd-slider-1">
                                <div class="swiper-wrapper">
                                    @foreach($takht->photo as $photo)
                                    <div class="swiper-slide">
                                        <div class="knsl-room-detail-photo-sm">
                                            <img src="{{asset($photo->path)}}" alt="اتاق">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <!-- sidebar -->
                        <div class="knsl-sticky knsl-stycky-right" data-margin-top="100">

                         <div class="row" style="list-style-type: none">
                             <div class="col-6 my-2">از تاریخ:</div>
                             <div class="col-6 my-2 from"></div>
                             <div class="col-6 my-2">تا تاریخ:</div>
                             <div class="col-6 my-2 to"></div>
                             <div class="col-6 my-2">به مدت:</div>
                             <div class="col-6 my-2 long"></div>
                             <div class="col-6 my-2 each"></div>
                             <div class="col-6 my-2 eachPrice"></div>
                             <div class="col-6 my-2">مبلغ کل:</div>
                             <div class="col-6 my-2 totalPrice"></div>
                             @if(\Illuminate\Support\Facades\Auth::check())
                             <div class="col-12 text-center mt-5"><a href="#" class="btn btn-success w-50">پرداخت</a> </div>
                             @else
                                 <div class="col-12 text-center mt-5"><a href="{{route('login')}}" class="btn btn-success w-50">پرداخت</a> </div>
                             @endif
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
