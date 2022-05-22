<!-- economic-->
<section class="container mb-sm-5 mb-4 pb-lg-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 pb-2">
        <h2 class="h4 mb-sm-0 font-vazir">پیشنهادات فصلی</h2>
{{--        <a class="btn btn-link fw-normal ms-sm-3 p-0" href="city-guide-catalog.html">مشاهده همه<i class="fi-arrow-long-left ms-2"></i></a>--}}
    </div>
    <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside">
        <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 3, &quot;gutter&quot;: 24, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1,&quot;nav&quot;:true},&quot;500&quot;:{&quot;items&quot;:2},&quot;850&quot;:{&quot;items&quot;:3},&quot;1400&quot;:{&quot;items&quot;:3,&quot;nav&quot;:false}}}">
           @if($seasons!='notfound')
            <!-- Item-->
            @foreach($seasons as $hotel)
                <div>
                    <div class="position-relative">
                        <div class="position-relative mb-3">
                            <button class="btn btn-icon btn-light-primary btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="نشان کردن"><i class="fi-heart"></i></button>
                            <img class="rounded-3" src="{{$hotel->path}}" alt="Image">
                        </div>
                        <h3 class="mb-2 fs-lg"><a class="nav-link stretched-link" href="{{route('singleproduct',$hotel->productuser->id)}}">{{$hotel->productuser->user->business_title}}</a></h3>
                        <ul class="list-inline mb-0 fs-sm">
                                                    <li class="list-inline-item ps-1"><i class="fi-star-filled mt-n1 ms-1 fs-base text-warning align-middle"></i><b>5.0</b><span class="text-muted">&nbsp;(48)</span></li>
                            {{$hotel->productuser->product->title}}
                            <li class="list-inline-item ps-1"><i class="fi-credit-card mt-n1 ms-1 fs-base text-muted align-middle"></i>{{number_format(substr($hotel->productuser->price,0,-3))}} تومان</li>
                                                    <li class="list-inline-item ps-1"><i class="fi-map-pin mt-n1 ms-1 fs-base text-muted align-middle"></i>1.4 کیلومتر از فرودگاه</li>
                        </ul>
                    </div>
                </div>
            @endforeach
               @endif
        </div>
    </div>
</section>

