<!-- cities-->
<style>

    .tns-carousel-wrapper article::before {
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 2;
        display: block;
        content: '';
        width: 0;
        height: 0;
        background: rgba(255,255,255,.2);
        border-radius: 100%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        opacity: 0;
    }
    .tns-carousel-wrapper article:hover::before {
        -webkit-animation: circle .50s;
        animation: circle .50s;
        cursor: pointer;
    }
    @-webkit-keyframes circle {
        0% {
            opacity: 1;
        }
        40% {
            opacity: 1;
        }
        100% {
            width: 120%;
            height: 120%;
            opacity: 0;
        }
    }
    @keyframes circle {
        0% {
            opacity: 1;
        }
        40% {
            opacity: 1;
        }
        100% {
            width: 120%;
            height: 120%;
            opacity: 0;
        }
    }
    #openOstans:hover{
        color: #fd5631;
    }
</style>
<section class="container my-5 py-lg-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 pb-2">
        <h2 class="h4 mb-sm-0 font-vazir">شهر های پرطرفدار</h2>

    </div>
    <!-- Carousel-->
    <div class="tns-carousel-wrapper tns-nav-outside mb-md-2 row towns">
    {{--        <div class="tns-carousel-inner d-block" data-carousel-options="{&quot;controls&quot;: false, &quot;gutter&quot;: 24, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1,&quot;nav&quot;:true},&quot;500&quot;:{&quot;items&quot;:2},&quot;850&quot;:{&quot;items&quot;:3},&quot;1200&quot;:{&quot;items&quot;:3}}}">--}}
    <!-- Item-->
        <article class="col-md-6 col-lg-3 position-relative"><a class="d-block mb-3" href="{{route('getproductbycity',[1,3000])}}">
                <img src="img/tehran.jpg" alt="Post image">
                <div class="position-absolute top-0 text-white text-center pt-2 h-25"
                     style="background: rgba(0, 0, 0, 0.5);">تهران
                </div>
            </a>

        </article>
        <!-- Item-->
        <article class="col-md-6 col-lg-3 position-relative"><a class="d-block mb-3" href="{{route('getproductbycity',[2,3000])}}">
                <img src="img/shiraz.jpg" alt="Post image">
                <div class="position-absolute top-0 text-white text-center pt-2 h-25"
                     style="background: rgba(0, 0, 0, 0.5);">فارس
                </div>
            </a>
        </article>
        <!-- Item-->
        <article class="col-md-6 col-lg-3 position-relative"><a class="d-block mb-3" href="{{route('getproductbycity',[8,3000])}}">
                <img src="img/mashad.jpg" alt="Post image">
                <div class="position-absolute top-0 text-white text-center pt-2 h-25"
                     style="background: rgba(0, 0, 0, 0.5);">خراسان رضوی
                </div>
            </a>

        </article>
        <!-- Item-->
        <article class="col-md-6 col-lg-3 position-relative"><a class="d-block mb-3" href="{{route('getproductbycity',[3,3000])}}">
                <img src="img/esfahan.jpg" alt="Post image">
                <div class="position-absolute top-0 text-white text-center pt-2 h-25"
                     style="background: rgba(0, 0, 0, 0.5);">اصفهان
                </div>
            </a>

        </article>
        <!-- Item-->
        <article class="col-md-6 col-lg-3 position-relative"><a class="d-block mb-3" href="{{route('getproductbycity',[4,3000])}}">
                <img src="img/yazd.jpg" alt="Post image">
                <div class="position-absolute top-0 text-white text-center pt-2 h-25"
                     style="background: rgba(0, 0, 0, 0.5);">یزد
                </div>
            </a>

        </article>
        <!-- Item-->
        <article class="col-md-6 col-lg-3 position-relative"><a class="d-block mb-3" href="{{route('getproductbycity',[5,3000])}}">
                <img src="img/mazandaran.jpg" alt="Post image">
                <div class="position-absolute top-0 text-white text-center pt-2 h-25"
                     style="background: rgba(0, 0, 0, 0.5);">مازندران
                </div>
            </a>

        </article>
        <!-- Item-->
        <article class="col-md-6 col-lg-3 position-relative"><a class="d-block mb-3" href="{{route('getproductbycity',[6,3000])}}">
                <img src="img/gilan.jpg" alt="Post image">
                <div class="position-absolute top-0 text-white text-center pt-2 h-25"
                     style="background: rgba(0, 0, 0, 0.5);">گیلان
                </div>
            </a>

        </article>
        <!-- Item-->
        <article class="col-md-6 col-lg-3 position-relative"><a class="d-block mb-3" href="{{route('getproductbycity',[7,3000])}}">
                <img src="img/hormozgan.jpg" alt="Post image">
                <div class="position-absolute top-0 text-white text-center pt-2 h-25"
                     style="background: rgba(0, 0, 0, 0.5);">هرمزگان
                </div>
            </a>

        </article>

        <span class="btn btn-link fw-normal ms-sm-3 p-0"
           id="openOstans" style="text-align: right;cursor: pointer"> <i class="fi-arrow-long-left ms-2"></i>سایر استان ها
           </span>
<div class="col-12 row text-center" id="otherOstan" style="text-align: right" dir="rtl">
    <ul class="col-lg-4 col-12">
        @foreach($ostans as $key=>$ostan)
            @if($key<=(ceil(count($ostans)/3)-1))
            <li style="list-style-type: none"><a href="{{route('getproductbycity',[$ostan->id,3000])}}">{{$ostan->name}}</a></li>
            @endif
        @endforeach
    </ul>
    <ul class="col-lg-4 col-12">
        @foreach($ostans as $key=>$ostan)
            @if((ceil(count($ostans)/3)-1)<$key && $key<=(ceil(count($ostans)/3*2)-1))
                <li style="list-style-type: none"><a href="{{route('getproductbycity',[$ostan->id,3000])}}">{{$ostan->name}}</a></li>
            @endif
        @endforeach
    </ul>
    <ul class="col-lg-4 col-12">
        @foreach($ostans as $key=>$ostan)
            @if((ceil(count($ostans)/3*2)-1)<$key && $key<=(ceil(count($ostans))-1))
                <li style="list-style-type: none"><a href="{{route('getproductbycity',[$ostan->id,3000])}}">{{$ostan->name}}</a></li>
            @endif
        @endforeach
    </ul>

</div>
        {{--        </div>--}}
    </div>
</section>
