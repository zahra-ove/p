<section class="container py-5 mt-5 mb-lg-3">
    <div class="row align-items-center mt-md-2">
        <div class="col-lg-7 order-lg-2 mb-lg-0 mb-4 pb-2 pb-lg-0">
            @if($photoSearch!='notfound' )
                @if($photoSearch->path!=null)
            <img class="d-block mx-auto" src="{{asset($photoSearch->path)}}" width="746" alt="Hero image">
            @endif
            @endif
        </div>
        <div class="col-lg-5 order-lg-1 pe-lg-0">
            <h1 class="display-5 mb-4 ms-lg-n5 text-lg-start text-right mb-4">جستجوی خود را آغاز کنید <span class="dropdown d-inline-block">
                   @if($cities!="notfound")
                    <a class="dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$cities[0]->cityName}}</a>
                    <span class="dropdown-menu dropdown-menu-end my-1">
                        @foreach($cities as $city)
                        <a class="dropdown-item fs-base fw-bold" href="#">{{$city->cityName}}</a>
{{--                        <a class="dropdown-item fs-base fw-bold" href="#">مونیخ</a>--}}
{{--                        <a class="dropdown-item fs-base fw-bold" href="#">فرانکفورت</a>--}}
{{--                        <a class="dropdown-item fs-base fw-bold" href="#">اشتوتگارت</a>--}}
{{--                        <a class="dropdown-item fs-base fw-bold" href="#">پاریس</a>--}}
                        @endforeach

                    </span>
                </span>
                @endif
            </h1>
            <p class="text-lg-start text-right mb-4 mb-lg-5 fs-lg">مکانهای عالی برای اقامت ، غذا خوردن ، خرید یا بازدید از شرکا و متخصصان محلی خود بیابید.</p>
            <!-- Search form-->
            <div class="ms-lg-n5">
                <form class="form-group d-block d-md-flex position-relative rounded-md-pill me-lg-n5">
                    <div class="input-group input-group-lg border-end-md"><span class="input-group-text text-muted rounded-pill pe-3"><i class="fi-search"></i></span>
                        <input class="form-control" type="text" placeholder="دنبال چه چیزی میگردی؟">
                    </div>
                    <hr class="d-md-none my-2">
                    <div class="d-sm-flex">
                        <div class="dropdown w-100 mb-sm-0 mb-3" data-bs-toggle="select">
                            <button class="btn btn-link btn-lg dropdown-toggle ps-2 ps-sm-3" type="button" data-bs-toggle="dropdown"><i class="fi-list me-2"></i><span class="dropdown-toggle-label">دسته بندی ها</span></button>
                            <input type="hidden">
                            <ul class="dropdown-menu">
                                @if($categories!="notfound")
                                @foreach($categories as $c)
                                <li><a class="dropdown-item" href="#"><i class="fs-lg opacity-60 me-2"></i><span class="dropdown-item-label">{{$c->title}}</span></a></li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                        <button class="btn btn-primary btn-lg rounded-pill w-100 w-md-auto me-sm-3" type="button">جستجو</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
