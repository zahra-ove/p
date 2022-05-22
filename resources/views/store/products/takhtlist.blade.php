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

        let countAllOrders = "";
        let countDateOrders = "";
        let floors = {!! $floors !!};
        let from = getUrlParameter('raft');
        let to = getUrlParameter('bargasht');
        $.ajax(
            {
                url: "{{asset('gettakhtbypricelimitoffset')}}/"+ floors +'/' + from + '/' + to + '/' + '10' + '/' + '0',
                async:false,
                success: function (data) {
                    function numberWithCommas(x) {
                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                    if (data != 'notfound') {
                        $('.notfound').remove();
                        $('.knsl-pagination').show();

                        data.forEach(function (item, index) {
                            // console.log(numberWithCommas(item.roomnumber))
                            $('.knsl-masonry-grid').append(`
                        <div class="knsl-masonry-grid-item knsl-masonry-grid-item-33 deluxe">


                                                        <div class="knsl-room-card">
                                                            <div class="knsl-cover-frame">
                                                                <a class="goTo" href="{{asset('detailtakht')}}/${item.id}"><img class="w-100" src="{{asset('')}}/${item.showPhoto}" alt="cover"></a>
                                                            </div>
                                                            <div class="knsl-description-frame">
                                                                <div class="knsl-room-features">
                                                                    <div class="knsl-feature">
                                                                        <div class="knsl-icon-frame"><i class="fa fa-bed"></i></div>
                                                                        <span class="w-100">اتاق شماره ${item.roomnumber} </span>
                                                                    </div>
                                                                    <div class="knsl-feature">
                                                                        <div class="knsl-icon-frame"><i class="fa fa-restroom"></i> </div>
                                                                    </div>

                                                                </div>
                                                                <a href="{{asset('detailroom')}}/${item.id}">
                                                                    <h3 class="knsl-mb-20">تخت شماره ${item.takhtnumber}</h3>
                                                                </a>
                                                                <div class="knsl-card-bottom">
                                                                    <div class="knsl-price">${numberWithCommas(item.price.substr(0,item.price.length-3))}  <span>/روزانه </span></div>
                                                                    |
                                                                    <div class="knsl-price">${numberWithCommas(item.pricemonth.substr(0,item.pricemonth.length-3))}  <span>/ماهیانه </span></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                            `)
                        });
                    } else {

                        $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                    }
                }
            }
        )
        $(document).on('click', ".knsl-pagination li", function (ep) {
            let $this = $(this);

            if ($(this).hasClass('knsl-active') == false) {
                    $('#orderList tbody').empty();
                    $('li.knsl-active').removeClass('active');
                    $(this).addClass('knsl-active');
                    let pageNunmber = parseInt($(this).text());
                    let prePageNunmber = parseInt($(this).text()) - 1;
                    let preCounts = prePageNunmber * 10;
                    let counts = pageNunmber * 10;

                    let countDateOrders = "";

                    $.ajax({
                        url: '{{asset('admin/gettakhtbyprice')}}/' + from + '/' + to,
                        data:{'raft':from,'bargasht':to},
                        async: false,
                        success: function (data) {
                            countDateOrders = data;
                        }
                    });
                    $.ajax(
                        {
                            url: "{{asset('admin/gettakhtbypricelimitoffset')}}/"+ floors +'/' + from + '/' + to + '/' + counts + '/' + preCounts,
                            success: function (data) {
                                function numberWithCommas(x) {
                                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }
                                if (data != 'notfound') {
                                    $('.knsl-pagination').empty();
                                    let countpages = Math.ceil(countDateOrders.length / 10);
                                    for (let i = 1; i <= countpages; i++) {
                                        if (i == $this.text()) {
                                            $('.knsl-pagination').append(` <li class="knsl-active"><a href="#.">${i}</a></li>`);
                                        } else {
                                            $('.knsl-pagination').append(`   <li><a href="#.">${i}</a></li>`);


                                        }

                                    }
                                    $('.notfound').remove();
                                    $('.knsl-pagination').show();

                                    data.forEach(function (item, index) {
                                        // console.log(numberWithCommas(item.roomnumber))
                                        $('.knsl-masonry-grid').append(`
                        <div class="knsl-masonry-grid-item knsl-masonry-grid-item-33 deluxe">


                                                        <div class="knsl-room-card">
                                                            <div class="knsl-cover-frame">
                                                                <a class="goTo" href="{{asset('detailtakht')}}/${item.id}"><img class="w-100" src="{{asset('')}}/${item.showPhoto}" alt="cover"></a>
                                                            </div>
                                                            <div class="knsl-description-frame">
                                                                <div class="knsl-room-features">
                                                                    <div class="knsl-feature">
                                                                        <div class="knsl-icon-frame"><i class="fa fa-bed"></i></div>
                                                                        <span class="w-100">اتاق شماره ${item.roomnumber} </span>
                                                                    </div>
                                                                    <div class="knsl-feature">
                                                                        <div class="knsl-icon-frame"><i class="fa fa-restroom"></i> </div>
                                                                    </div>

                                                                </div>
                                                                <a href="{{asset('detailroom')}}/${item.id}">
                                                                    <h3 class="knsl-mb-20">تخت شماره ${item.takhtnumber}</h3>
                                                                </a>
                                                                <div class="knsl-card-bottom">
                                                                    <div class="knsl-price">${numberWithCommas(item.price.substr(0,item.price.length-3))}  <span>/روزانه </span></div>
                                                                    |
                                                                    <div class="knsl-price">${numberWithCommas(item.pricemonth.substr(0,item.pricemonth.length-3))}  <span>/ماهیانه </span></div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                            `)
                                    });
                                } else {

                                    $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                                }
                            }
                        }
                    );
                $('.goTo').each(function (index) {
                    $(this).attr('href',$(this).attr('href')+'/?'+`pansion=${getUrlParameter('pansion')}&raft=${getUrlParameter('raft')}&reserve=${getUrlParameter('reserve')}&month=${getUrlParameter('month')}&bargasht=${getUrlParameter('bargasht')}`);
                });
            }

        });
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
{{--                            <h1 class="knsl-mb-20 knsl-h1-inner">طبقات خوابگاه {{$rooms[0]->pansion->name}}</h1>--}}

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

                {{--                <div class="knsl-filter knsl-mb-60">--}}
                {{--                    <a href="#" data-filter="*" class="knsl-work-category knsl-current">همه اتاق ها</a>--}}
                {{--                    <a href="#" data-filter=".economy" class="knsl-work-category">اقتصاد</a>--}}
                {{--                    <a href="#" data-filter=".standart" class="knsl-work-category">استاندارد</a>--}}
                {{--                    <a href="#" data-filter=".deluxe" class="knsl-work-category">لوکس</a>--}}
                {{--                </div>--}}

                <div class="knsl-masonry-grid knsl-3-col">

                    <div class="knsl-grid-sizer"></div>
{{--                    @if($takhts!='notfound')--}}
{{--                    @if(count($takhts)!=0)--}}
{{--                    @foreach($takhts as $takht)--}}
{{--                        <div class="knsl-masonry-grid-item knsl-masonry-grid-item-33 deluxe">--}}

{{--                            <!-- takht card -->--}}
{{--                            <div class="knsl-room-card">--}}
{{--                                <div class="knsl-cover-frame">--}}
{{--                                    <a class="goTo" href="{{route('detailtakht',$takht->id)}}/"><img class="w-100" src="{{asset($takht->showPhoto)}}" alt="cover"></a>--}}
{{--                                </div>--}}
{{--                                <div class="knsl-description-frame">--}}
{{--                                    <div class="knsl-room-features">--}}
{{--                                        <div class="knsl-feature">--}}
{{--                                            <div class="knsl-icon-frame"><i class="fa fa-bed"></i></div>--}}
{{--                                            <span class="w-100">{{number_format($takht->price)}} تومان </span>--}}

{{--                                            <span class="w-100">اتاق شماره  {{number_format($takht->room->roomnumber)}} </span>--}}
{{--                                        </div>--}}
{{--                                        <div class="knsl-feature">--}}
{{--                                            <div class="knsl-icon-frame"><i class="fa fa-restroom"></i> </div>--}}
{{--                                            <span>ظرفیت  {{$takht->pricemonth}} </span>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}
{{--                                    <a href="{{route('detailroom',$takht->id)}}">--}}
{{--                                        <h3 class="knsl-mb-20"> طبقه {{$takht->floor}}</h3>--}}
{{--                                    </a>--}}
{{--                                    <div class="knsl-card-bottom">--}}
{{--                                        <div class="knsl-price">1800 <span>/ماهیانه </span></div>--}}
{{--                                        <a href="room.html" class="knsl-btn"><img src="img/icons/bookmark.svg" alt="icon">ثبت</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!-- takht card end -->--}}

{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                    @endif--}}
{{--                    @else--}}
{{--                    <h2 class="alert-info p-2">تخت خالی در این طبقه وجود ندارد.</h2>--}}
{{--                    @endif--}}
                </div>
                <ul class="knsl-pagination">
                    @for($i=1;$i<=$countTakht;$i++)
                        @if($i=='1')
                    <li class="knsl-active"><a href="#.">{{$i}}</a></li>
                        @else
                            <li><a href="#.">{{$i}}</a></li>
                            @endif
                    @endfor

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




    </div>
    <!-- page wrapper end -->


@endsection
