@extends('store.master.home')

    <style>
    .page-loading {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    -webkit-transition: all .4s .2s ease-in-out;
    transition: all .4s .2s ease-in-out;
    background-color: #fff;
    opacity: 0;
    visibility: hidden;
    z-index: 9999;
    }
    .page-loading.active {
    opacity: 1;
    visibility: visible;
    }
    .page-loading-inner {
    position: absolute;
    top: 50%;
    left: 0;
    width: 100%;
    text-align: center;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    -webkit-transition: opacity .2s ease-in-out;
    transition: opacity .2s ease-in-out;
    opacity: 0;
    }
    .page-loading.active > .page-loading-inner {
    opacity: 1;
    }
    .page-loading-inner > span {
    display: block;
    font-size: 1rem;
    font-weight: normal;
    color: #666276;;
    }
    .page-spinner {
    display: inline-block;
    width: 2.75rem;
    height: 2.75rem;
    margin-bottom: .75rem;
    vertical-align: text-bottom;
    border: .15em solid #bbb7c5;
    border-right-color: transparent;
    border-radius: 50%;
    -webkit-animation: spinner .75s linear infinite;
    animation: spinner .75s linear infinite;
    }
    @-webkit-keyframes spinner {
    100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
    }
    }
    @keyframes spinner {
    100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
    }
    }
    </style>

@section('pagecss')
    <!--persian-date css-->
    <link rel="stylesheet" href="{{ asset('store') }}/css/leaflet.css">
    <!--flatpickr.min.css css-->
    <link rel="stylesheet" href="{{ asset('store') }}/css/flatpickr.min.css">
@endsection
@section('js')
    <script>
        $(document).ready(function (e) {
            let catId="{{$category->id}}";
            let cityId="{{$city}}";
            let offset=0;
            let limit=offset + 6;
            $.ajax(
                {
                    url:"{{route('paginprovider')}}",
                    data:{'catId':catId,'cityId':cityId,'limit':limit,'offset':offset},
                    success: function (data) {
                        if (data != 'notfound') {
                            data.forEach(function (item, index) {

                                $('.provider-list').append(`      <div class="col pb-sm-2">
                                                            <article class="position-relative">
                                                                <div class="position-relative mb-3">
                                                                    <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="نشان کردن"><i class="fi-heart"></i></button>

                                <img class="rounded-3" src="{{asset("")}}/${item.pathImage}" alt="Article img">

                                </div>
                                <h3 class="mb-2 fs-lg"><a class="nav-link stretched-link" href="{{asset('providerproducts')}}/${item.uId}">${item.business_title}</a></h3>
                                                                <ul class="list-inline mb-0 fs-sm">
                                                                    <li class="list-inline-item ps-1"><i class="fi-star-filled mt-n1 ms-1 fs-base text-warning align-middle"></i><b>5.0</b><span class="text-muted">&nbsp;(48)</span></li>

                                                                    <li class="list-inline-item ps-1"><i class="fi-map-pin mt-n1 ms-1 fs-base text-muted align-middle"></i>1.4 کیلومتر از فرودگاه</li>
                                                                </ul>
                                                            </article>
                                                        </div>`);


                            });
                        }
                    }
                }
            );

                if ($('.page-1').length!=0){
                    $('.page-1').addClass('active');
                }

                $('.page-item').click(function (event) {
                    event.preventDefault();
                    if ($(this).hasClass('active')){
                        event.preventDefault();
                    }
                    else {
                    $('.provider-list').empty();
                    $('.page-item').removeClass('active');
                    $(this).addClass('active');
                    let dataId=$(this).attr('data-id');
                    let catId="{{$category->id}}";
                    let cityId="{{$city}}";
                    let offset=(parseInt(dataId)-1) * 6;
                    let limit=offset + 6;
                    $.ajax(
                        {
                            url:"{{route('paginprovider')}}",
                            data:{'catId':catId,'cityId':cityId,'limit':limit,'offset':offset},
                            success: function (data) {
                                if (data != 'notfound') {
                                    data.forEach(function (item, index) {

                                        $('.provider-list').append(`      <div class="col pb-sm-2">
                                                            <article class="position-relative">
                                                                <div class="position-relative mb-3">
                                                                    <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="نشان کردن"><i class="fi-heart"></i></button>

                                <img class="rounded-3" src="{{asset("")}}/${item.pathImage}" alt="Article img">

                                </div>
                                <h3 class="mb-2 fs-lg"><a class="nav-link stretched-link" href="city-guide-single.html">${item.business_title}</a></h3>
                                                                <ul class="list-inline mb-0 fs-sm">
                                                                    <li class="list-inline-item ps-1"><i class="fi-star-filled mt-n1 ms-1 fs-base text-warning align-middle"></i><b>5.0</b><span class="text-muted">&nbsp;(48)</span></li>

                                                                    <li class="list-inline-item ps-1"><i class="fi-map-pin mt-n1 ms-1 fs-base text-muted align-middle"></i>1.4 کیلومتر از فرودگاه</li>
                                                                </ul>
                                                            </article>
                                                        </div>`);


                                    });
                                }
                            }
                        }
                    );
                    }
                });

        });
    </script>
@endsection
@section('pagejs')
    <!--tiny leaflet min js-->
    <script src="{{asset("store")}}/js/leaflet.js"></script>
    <!--tiny nouislider min js-->
    <script src="{{asset("store")}}/js/nouislider.min.js"></script>
@endsection
@section('content')
    <!-- Page container-->
    <div class="container-fluid mt-5 pt-5 p-0">
        <div class="row g-0 mt-n3">
            <!-- Filters sidebar (Offcanvas on mobile)-->
            <aside class="col-lg-4 col-xl-3 border-top-lg border-end-lg shadow-sm px-3 px-xl-4 px-xxl-5 pt-lg-2">
                <div class="offcanvas offcanvas-start offcanvas-collapse" id="filters-sidebar">
                    <div class="offcanvas-header d-flex d-lg-none align-items-center">
                        <h2 class="h5 mb-0">جستجو</h2>
                        <button class="btn-close" type="button" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <!-- Search form-->
                    <div class="offcanvas-header d-block border-bottom pt-0 pt-lg-4 px-lg-0">
                        <form class="form-group mb-lg-2 rounded-pill">
                            <div class="input-group"><span class="input-group-text text-muted"><i class="fi-search"></i></span>
                                <input class="form-control" type="text" placeholder="جستجو...">
                            </div>
                            <button class="btn btn-primary rounded-pill d-lg-inline-block d-none" type="button">جستجو</button>
                            <button class="btn btn-icon btn-primary rounded-circle flex-shrink-0 d-lg-none d-inline-flex" type="button"><i class="fi-search mt-n2"></i></button>
                        </form>
                    </div>
                    <!-- Nav tabs-->
                    <div class="offcanvas-header d-block border-bottom py-lg-4 py-3 px-lg-0">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item"><a class="nav-link d-flex align-items-center active" href="#categories" data-bs-toggle="tab" role="tab"><i class="fi-list me-2"></i>دسته بندی</a></li>
{{--                            <li class="nav-item"><a class="nav-link d-flex align-items-center" href="#filters" data-bs-toggle="tab" role="tab"><i class="fi-filter-alt-horizontal me-2"></i>فیلتر</a></li>--}}
                        </ul>
                    </div>
                    <div class="offcanvas-body py-lg-4">
                        <!-- Tabs content-->
                        <div class="tab-content">
                            <!-- Categories-->
                            <div class="tab-pane fade show active" id="categories" role="tabpanel">
                                <div class="row row-cols-lg-2 row-cols-1 g-3 categories-guid">
                                    @if($categories!="notfound")
                                    @foreach($categories as $c)
                                    <div class="col dropdown">
                                        <a class="icon-box card card-body h-100 border-0 shadow-sm card-hover text-center" href="#" data-bs-toggle="dropdown">
                                            <div class="icon-box-media bg-faded-accent rounded-circle mb-3 mx-auto">
                                                <i class="{{$c->classicon!=null?$c->classicon:''}} text-info pt-2"></i>
                                            </div>
                                            <h3 class="icon-box-title fs-base mb-0">{{$c->title}}</h3>

                                        </a>
                                        <div class="dropdown-menu dropdown-menu-sm-end my-1 w-75">
                                            @if(count($c->subCategory)>0)
                                                @foreach($c->subCategory as $subcategory)
                                                    <a class="dropdown-item fw-bold" href="{{route('showproviders',[$subcategory->id,1])}}">{{$subcategory->title}}</a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
{{--                                    <div class="col"><a class="icon-box card card-body h-100 border-0 shadow-sm card-hover text-center" href="#">--}}
{{--                                            <div class="icon-box-media bg-faded-primary text-primary rounded-circle mb-3 mx-auto"><i class="fi-dumbell"></i></div>--}}
{{--                                            <h3 class="icon-box-title fs-base mb-0">ورزشی</h3></a></div>--}}
{{--                                    <div class="col"><a class="icon-box card card-body h-100 border-0 shadow-sm card-hover text-center" href="#">--}}
{{--                                            <div class="icon-box-media bg-faded-warning text-warning rounded-circle mb-3 mx-auto"><i class="fi-cafe"></i></div>--}}
{{--                                            <h3 class="icon-box-title fs-base mb-0">رستوران و کافی شاپ</h3></a></div>--}}
{{--                                    <div class="col"><a class="icon-box card card-body h-100 border-0 shadow-sm card-hover text-center" href="#">--}}
{{--                                            <div class="icon-box-media bg-faded-success text-success rounded-circle mb-3 mx-auto"><i class="fi-disco-ball"></i></div>--}}
{{--                                            <h3 class="icon-box-title fs-base mb-0">تور و سفر</h3></a></div>--}}
{{--                                    <div class="col"><a class="icon-box card card-body h-100 border-0 shadow-sm card-hover text-center" href="#">--}}
{{--                                            <div class="icon-box-media bg-faded-primary text-primary rounded-circle mb-3 mx-auto"><i class="fi-shopping-bag"></i></div>--}}
{{--                                            <h3 class="icon-box-title fs-base mb-0">مراکز خرید</h3></a></div>--}}
{{--                                    <div class="col"><a class="icon-box card card-body h-100 border-0 shadow-sm card-hover text-center" href="#">--}}
{{--                                            <div class="icon-box-media bg-faded-info text-info rounded-circle mb-3 mx-auto"><i class="fi-meds"></i></div>--}}
{{--                                            <h3 class="icon-box-title fs-base mb-0">پزشکی و سلامتی</h3></a></div>--}}
{{--                                    <div class="col"><a class="icon-box card card-body h-100 border-0 shadow-sm card-hover text-center" href="#">--}}
{{--                                            <div class="icon-box-media bg-faded-success text-success rounded-circle mb-3 mx-auto"><i class="fi-museum"></i></div>--}}
{{--                                            <h3 class="icon-box-title fs-base mb-0">هنر و تئاتر</h3></a></div>--}}
{{--                                    <div class="col"><a class="icon-box card card-body h-100 border-0 shadow-sm card-hover text-center" href="#">--}}
{{--                                            <div class="icon-box-media bg-faded-warning text-warning rounded-circle mb-3 mx-auto"><i class="fi-makeup"></i></div>--}}
{{--                                            <h3 class="icon-box-title fs-base mb-0">آرایشی و زیبایی</h3></a></div>--}}
{{--                                    <div class="col"><a class="icon-box card card-body h-100 border-0 shadow-sm card-hover text-center" href="#">--}}
{{--                                            <div class="icon-box-media bg-faded-primary text-primary rounded-circle mb-3 mx-auto"><i class="fi-entertainment"></i></div>--}}
{{--                                            <h3 class="icon-box-title fs-base mb-0">تفریحی و سرگرمی</h3></a></div>--}}
{{--                                    <div class="col"><a class="icon-box card card-body h-100 border-0 shadow-sm card-hover text-center" href="#">--}}
{{--                                            <div class="icon-box-media bg-faded-info text-info rounded-circle mb-3 mx-auto"><i class="fi-car"></i></div>--}}
{{--                                            <h3 class="icon-box-title fs-base mb-0">خدمات خودرو</h3></a></div>--}}
                                </div>
                            </div>
{{--                            <!-- Filters-->--}}
{{--                            <div class="tab-pane fade" id="filters" role="tabpanel">--}}
{{--                                <div class="pb-4 mb-2">--}}
{{--                                    <h3 class="h6">موقعیت مکانی</h3>--}}
{{--                                    <select class="form-select mb-2">--}}
{{--                                        <option value="Berlin" selected>برلین</option>--}}
{{--                                        <option value="Hamburg">هامبورگ</option>--}}
{{--                                        <option value="Munich">مونیخ</option>--}}
{{--                                        <option value="Koln">منچستر</option>--}}
{{--                                        <option value="Frankfurt am Main">فرانکفورت</option>--}}
{{--                                    </select>--}}
{{--                                    <select class="form-select">--}}
{{--                                        <option value="" selected disabled>انتخاب منطقه</option>--}}
{{--                                        <option value="Berlin-Mitte">برلین-میت</option>--}}
{{--                                        <option value="Charlottenburg">شارلوتنبورگ</option>--}}
{{--                                        <option value="Prenzlauer Berg">منچستر</option>--}}
{{--                                        <option value="Friedrichshain">فردریششاین</option>--}}
{{--                                        <option value="Kreuzberg">پاریس</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="pb-4 mb-2">--}}
{{--                                    <h3 class="h6">دسته بندی</h3>--}}
{{--                                    <div class="dropdown mb-sm-0 mb-3" data-bs-toggle="select">--}}
{{--                                        <button class="btn btn-outline-secondary d-flex align-items-center w-100 px-4 fw-normal text-start dropdown-toggle" type="button" data-bs-toggle="dropdown"><i class="fi-list me-2 text-muted"></i><span class="dropdown-toggle-label d-block w-100 text-right">تمام دسته بندی ها</span></button>--}}
{{--                                        <input type="hidden">--}}
{{--                                        <ul class="dropdown-menu w-100">--}}
{{--                                            <li><a class="dropdown-item" href="#"><i class="fi-bed fs-lg opacity-60"></i><span class="dropdown-item-label"> اقامتگاه</span></a></li>--}}
{{--                                            <li><a class="dropdown-item" href="#"><i class="fi-cafe me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">رستوران و کافی شاپ</span></a></li>--}}
{{--                                            <li><a class="dropdown-item" href="#"><i class="fi-shopping-bag me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">مرکز خرید</span></a></li>--}}
{{--                                            <li><a class="dropdown-item" href="#"><i class="fi-museum me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">هنر و تئاتر</span></a></li>--}}
{{--                                            <li><a class="dropdown-item" href="#"><i class="fi-entertainment me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">تفریحی و سرگرمی</span></a></li>--}}
{{--                                            <li><a class="dropdown-item" href="#"><i class="fi-meds me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">پزشکی و سلامتی</span></a></li>--}}
{{--                                            <li><a class="dropdown-item" href="#"><i class="fi-makeup me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">آرایشی و زیبایی</span></a></li>--}}
{{--                                            <li><a class="dropdown-item" href="#"><i class="fi-car me-2 fs-lg opacity-60"></i><span class="dropdown-item-label">خدمات خودرو</span></a></li>--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="pb-4 mb-2">--}}
{{--                                    <h3 class="h6">زیر دسته</h3>--}}
{{--                                    <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" data-simplebar-direction="rtl" style="height: 11rem;">--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="hotel">--}}
{{--                                            <label class="form-check-label fs-sm" for="hotel">هتل</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="hostel">--}}
{{--                                            <label class="form-check-label fs-sm" for="hostel">خوابگاه</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="motel">--}}
{{--                                            <label class="form-check-label fs-sm" for="motel">مسافرخانه</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="apartment" checked>--}}
{{--                                            <label class="form-check-label fs-sm" for="apartment">آپارتمان</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="cottage">--}}
{{--                                            <label class="form-check-label fs-sm" for="cottage">کلبه</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="boutique-hotel">--}}
{{--                                            <label class="form-check-label fs-sm" for="boutique-hotel">ویلا</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="room">--}}
{{--                                            <label class="form-check-label fs-sm" for="room">سوییت</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="land">--}}
{{--                                            <label class="form-check-label fs-sm" for="land">زمین</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="commercial">--}}
{{--                                            <label class="form-check-label fs-sm" for="commercial">تجاری و اداری</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="parking-lot">--}}
{{--                                            <label class="form-check-label fs-sm" for="parking-lot">پارکینگ</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="pb-4 mb-2">--}}
{{--                                    <h3 class="h6">قیمت</h3>--}}
{{--                                    <div class="range-slider" data-start-min="300" data-start-max="700" data-min="50" data-max="1000" data-step="20">--}}
{{--                                        <div class="range-slider-ui"></div>--}}
{{--                                        <div class="d-flex align-items-center">--}}
{{--                                            <div class="w-50 pe-2">--}}
{{--                                                <div class="input-group flex-row-reverse"><span class="input-group-text fs-base">ت</span>--}}
{{--                                                    <input class="form-control range-slider-value-max" type="text">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="text-muted">—</div>--}}
{{--                                            <div class="w-50 ps-2">--}}
{{--                                                <div class="input-group flex-row-reverse"><span class="input-group-text fs-base">ت</span>--}}
{{--                                                    <input class="form-control range-slider-value-min" type="text">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="pb-4 mb-2">--}}
{{--                                    <h3 class="h6">میانگین امتیاز</h3>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="5-star">--}}
{{--                                        <label class="form-check-label fs-sm align-middle mt-n2" for="5-star"><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i></span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="4-star">--}}
{{--                                        <label class="form-check-label fs-sm align-middle mt-n2" for="4-star"><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star"></i></span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="3-star">--}}
{{--                                        <label class="form-check-label fs-sm align-middle mt-n2" for="3-star"><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star"></i><i class="star-rating-icon fi-star"></i></span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="2-star">--}}
{{--                                        <label class="form-check-label fs-sm align-middle mt-n2" for="2-star"><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star"></i><i class="star-rating-icon fi-star"></i><i class="star-rating-icon fi-star"></i></span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="1-star">--}}
{{--                                        <label class="form-check-label fs-sm align-middle mt-n2" for="1-star"><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star"></i><i class="star-rating-icon fi-star"></i><i class="star-rating-icon fi-star"></i><i class="star-rating-icon fi-star"></i></span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="pb-4 mb-2">--}}
{{--                                    <h3 class="h6">تعداد اتاق</h3>--}}
{{--                                    <select class="form-select mb-2">--}}
{{--                                        <option value="1-room" selected>1 اتاق</option>--}}
{{--                                        <option value="2-rooms">2 اتاق</option>--}}
{{--                                        <option value="3-rooms">3 اتاق</option>--}}
{{--                                        <option value="4-rooms">4 اتاق</option>--}}
{{--                                        <option value="5-rooms">5 اتاق</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="pb-4 mb-2">--}}
{{--                                    <h3 class="h6">امکانات رفاهی</h3>--}}
{{--                                    <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" style="height: 11rem;" data-simplebar-direction="rtl">--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="parking">--}}
{{--                                            <label class="form-check-label fs-sm" for="parking">پارکینگ</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="restaurant">--}}
{{--                                            <label class="form-check-label fs-sm" for="restaurant">رستوران</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="pet-friendly">--}}
{{--                                            <label class="form-check-label fs-sm" for="pet-friendly">نگهداری حیوانات خانگی</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="room-service" checked>--}}
{{--                                            <label class="form-check-label fs-sm" for="room-service">سرویس بهداشتی</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="fitness-center">--}}
{{--                                            <label class="form-check-label fs-sm" for="fitness-center">مرکز ورزشی</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="free-wifi" checked>--}}
{{--                                            <label class="form-check-label fs-sm" for="free-wifi">وای فای رایگان</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="spa-lounge">--}}
{{--                                            <label class="form-check-label fs-sm" for="spa-lounge">سالن آبگرم</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="bar">--}}
{{--                                            <label class="form-check-label fs-sm" for="bar">گاز رومیزی</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="swimming-pool">--}}
{{--                                            <label class="form-check-label fs-sm" for="swimming-pool">استخر</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="pb-4 mb-2">--}}
{{--                                    <h3 class="h6">امکانات اتاق</h3>--}}
{{--                                    <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" style="height: 11rem;" data-simplebar-direction="rtl">--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="kitchen">--}}
{{--                                            <label class="form-check-label fs-sm" for="kitchen">آشپزخانه</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="private-bathroom">--}}
{{--                                            <label class="form-check-label fs-sm" for="private-bathroom">حمام</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="air-conditioning" checked>--}}
{{--                                            <label class="form-check-label fs-sm" for="air-conditioning">تهویه هوا</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="desk">--}}
{{--                                            <label class="form-check-label fs-sm" for="desk">میز</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="terrace">--}}
{{--                                            <label class="form-check-label fs-sm" for="terrace">بالکن</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="washing-machine">--}}
{{--                                            <label class="form-check-label fs-sm" for="washing-machine">ماشین ظرفشویی</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="heating">--}}
{{--                                            <label class="form-check-label fs-sm" for="heating">سرویس گرمایشی</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input class="form-check-input" type="checkbox" id="laundry-service">--}}
{{--                                            <label class="form-check-label fs-sm" for="laundry-service">ماشین لباسشویی</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="border-top py-4">--}}
{{--                                    <button class="btn btn-outline-primary rounded-pill" type="button"><i class="fi-rotate-right me-2"></i>حذف فیلتر</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </aside>
            <!-- Page content-->
            <div class="col-lg-8 col-xl-9 position-relative overflow-hidden pb-5 pt-4 px-3 px-xl-4 px-xxl-5">
                <!-- Map popup-->
                <div class="map-popup invisible" id="map">
                    <button class="btn btn-icon btn-light btn-sm shadow-sm rounded-circle" type="button" data-bs-toggle-class="invisible" data-bs-target="#map"><i class="fi-x fs-xs"></i></button>
                    <div class="interactive-map" data-map-options-json="json/map-options-city-guide.json"></div>
                </div>
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-2" aria-label="Breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="city-guide-home-v1.html">خانه</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$category->title}}</li>
                    </ol>
                </nav>
                <!-- Title-->
                <div class="d-sm-flex align-items-center justify-content-between pb-3 pb-sm-4">
                    <h1 class="h2 mb-sm-0">جستجو محل اقامت</h1><a class="d-inline-block fw-bold text-decoration-none py-1" href="#" data-bs-toggle-class="invisible" data-bs-target="#map"><i class="fi-map me-2"></i>مشاهده نقشه</a>
                </div>
                <!-- Sorting-->
                <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch my-2">
{{--                    <div class="d-flex align-items-center flex-shrink-0">--}}
{{--                        <label class="fs-sm me-2 pe-1 text-nowrap" for="sortby"><i class="fi-arrows-sort text-muted mt-n1 me-2"></i>مرتب سازی</label>--}}
{{--                        <select class="form-select form-select-sm" id="sortby">--}}
{{--                            <option>جدیدترین</option>--}}
{{--                            <option>پربازدید</option>--}}
{{--                            <option>قیمت بالا - پایین</option>--}}
{{--                            <option>قیمت پایین - بالا</option>--}}
{{--                            <option>امتیاز بالا</option>--}}
{{--                            <option>امتیاز بالا</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
                    <hr class="d-none d-sm-block w-100 mx-4">
                    <div class="d-none d-sm-flex align-items-center flex-shrink-0 text-muted"><i class="fi-check-circle me-2"></i><span class="fs-sm mt-n1">{{$providers!="notfound"?count($providers):'0'}} نتیجه یافت شد</span></div>
                </div>
                <!-- Catalog grid-->
                <div class="row row-cols-xl-3 row-cols-sm-2 row-cols-1 gy-4 gx-3 gx-xxl-4 py-4 provider-list">
                    <!-- Item-->
{{--                    @if($providers!="notfound")--}}
{{--@foreach($providers as $provider)--}}
{{--                    <div class="col pb-sm-2">--}}
{{--                        <article class="position-relative">--}}
{{--                            <div class="position-relative mb-3">--}}
{{--                                <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="نشان کردن"><i class="fi-heart"></i></button>--}}
{{--                                @if(isset($provider->user->photo[0]))--}}
{{--                                    <img class="rounded-3" src="{{asset($provider->user->photo[0]->pic_path)}}" alt="Article img">--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <h3 class="mb-2 fs-lg"><a class="nav-link stretched-link" href="city-guide-single.html">{{$provider->user->business_title}}</a></h3>--}}
{{--                            <ul class="list-inline mb-0 fs-sm">--}}
{{--                                <li class="list-inline-item ps-1"><i class="fi-star-filled mt-n1 ms-1 fs-base text-warning align-middle"></i><b>5.0</b><span class="text-muted">&nbsp;(48)</span></li>--}}
{{--                                <li class="list-inline-item ps-1"><i class="fi-credit-card mt-n1 ms-1 fs-base text-muted align-middle"></i>{{number_format(substr($provider->price,0,-3))}} تومان</li>--}}
{{--                                <li class="list-inline-item ps-1"><i class="fi-map-pin mt-n1 ms-1 fs-base text-muted align-middle"></i>1.4 کیلومتر از فرودگاه</li>--}}
{{--                            </ul>--}}
{{--                        </article>--}}
{{--                    </div>--}}
{{--                    @endforeach--}}
{{--                    @endif--}}
                </div>
                <!-- Pagination-->
                @if($providers!="notfound")
                <nav class="border-top pb-md-4 pt-4" aria-label="Pagination">
                    <ul class="pagination mb-1">
                        @for($i=1;$i<=$count;$i++)
{{--                        <li class="page-item d-sm-none"><span class="page-link page-link-static">1 / 5</span></li>--}}
                        <li data-id="{{$i}}" class="page-item d-none d-sm-block page-{{$i}}" aria-current="page"><button class="page-link">{{$i}}<span class="visually-hidden">(صفحه جاری)</span></button></li>
{{--                        <li class="page-item d-none d-sm-block"><a class="page-link" href="#">2</a></li>--}}
{{--                        <li class="page-item d-none d-sm-block"><a class="page-link" href="#">3</a></li>--}}
{{--                        <li class="page-item d-none d-sm-block">...</li>--}}
{{--                        <li class="page-item d-none d-sm-block"><a class="page-link" href="#">8</a></li>--}}
{{--                        <li class="page-item"><a class="page-link" href="#" aria-label="Next"><i class="fi-chevron-right"></i></a></li>--}}
                        @endfor
                    </ul>
                </nav>
                @endif
            </div>
        </div>
    </div>
@endsection
