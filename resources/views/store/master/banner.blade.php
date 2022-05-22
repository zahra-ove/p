<!-- banner -->
<style>
    .list {
        width: 100%;
    }

    .nice-select .list .option {
        width: 100% !important;
    }
</style>
@section('js')
    <script src="{{asset('admin')}}/js/jdate.min.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $(document).ready(function () {

            $('#reservetypeDiv').hide();
            $('#monthDiv').hide();
            $('#exitDiv').hide();

            $(document).on('change','#check-in',function (e) {
                $('.khorooj').remove();
                $('#reservetypeDiv').show();
                $('#exitDiv').show();
                $('#check-out').val('');
                $('#month').val('');
                $('#monthDiv').hide();
                $('#reservetypeDiv .knsl-input-frame .nice-select .current').text('روزانه');
                $('#reservetype option[value=days]').prop('selected',true);
                $('li').removeClass('selected');
                $('.list li[data-value=days]').addClass('selected');

            });
            $('#month').change(function (e) {
                $('.khorooj').remove();
                let begin = $('#check-in').val();
                let splitMiladi = begin.split('/');
                let jdate = new JDate(splitMiladi[0], splitMiladi[1], splitMiladi[2]);
                let beginMiladi = jdate.toGregorian();

                let beginMiladiUnix = beginMiladi.getTime();
                let tarikhMonth = '';
                let bargashtAzMah = "";

                if (splitMiladi[1] == '11' && splitMiladi[2] == '30') {
                    tarikhMonth = $('#month').val() * 2505600000;
                } else if (splitMiladi[1] == '01' || splitMiladi[1] == '02' || splitMiladi[1] == '03' || splitMiladi[1] == '04' || splitMiladi[1] == '05' || splitMiladi[1] == '06') {
                    tarikhMonth = $('#month').val() * 2678400000;
                    if (splitMiladi[1] == '06' && splitMiladi[2] == '31') {
                        tarikhMonth = $('#month').val() * 2505600000;
                    }
                } else {
                    tarikhMonth = $('#month').val() * 2592000000;
                }
                let newJdateUnix = beginMiladiUnix + tarikhMonth;
                let newJdateMiladi = new Date(newJdateUnix);
                let newJdate = new JDate(newJdateMiladi);
                if ((jdate.date[1] == '6' && jdate.date[2] == "31") || (jdate.date[1] == '5' && jdate.date[2] == "31") || (jdate.date[1] == '4' && jdate.date[2] == "31") || (jdate.date[1] == '3' && jdate.date[2] == "31") || (jdate.date[1] == '2' && jdate.date[2] == "31")) {

                    bargashtAzMah = new JDate(newJdate.date[0], newJdate.date[1], '30');
                } else {
                    bargashtAzMah = new JDate(newJdate.date[0], newJdate.date[1], newJdate.date[2]);
                }

                $('#searchBtn').before(`<div class="knsl-input-frame col-lg-12 khorooj">
                                        <label for="check-in">خروج</label>
                                            <p>${bargashtAzMah.date[0]+'/'+bargashtAzMah.date[1]+'/'+bargashtAzMah.date[2]}</p>
                                    </div>`);
$('#check-out').val(`${bargashtAzMah.date[0]+'/'+bargashtAzMah.date[1]+'/'+bargashtAzMah.date[2]}`);
            });
            $('#pansions').change(function (es){
                $('#form').attr('action', '{{asset('roomlist')}}/' + $('#pansions').val());
            });
            $('#reservetype').change(function (e) {
                $('.khorooj').remove();
                if ($(this).val() == 'days') {
                    $('#monthDiv').hide();
                    $('#exitDiv').show();
                    $('#month').val(null);
                } else if ($(this).val() == 'months') {
                    $('.khorooj').remove();
                    $('#month').val('1');
                    $('#exitDiv').hide();
                    $('#check-out').val(null);
                    $('#monthDiv').show();
                    $('#form').attr('action', '{{asset('roomlist')}}/' + $('#pansions').val());
                    let begin = $('#check-in').val();
                    let splitMiladi = begin.split('/');
                    let jdate = new JDate(splitMiladi[0], splitMiladi[1], splitMiladi[2]);
                    let beginMiladi = jdate.toGregorian();

                    let beginMiladiUnix = beginMiladi.getTime();

                    let tarikhMonth = '';
                    let bargashtAzMah = "";

                    if (splitMiladi[1] == '11') {
                        tarikhMonth = $('#month').val() * 2505600000;
                    } else if (splitMiladi[1] == '01' || splitMiladi[1] == '02' || splitMiladi[1] == '03' || splitMiladi[1] == '04' || splitMiladi[1] == '05' || splitMiladi[1] == '06') {
                        tarikhMonth = $('#month').val() * 2678400000;
                        if (splitMiladi[1] == '6' && splitMiladi[2] == '31') {
                            tarikhMonth = $('#month').val() * 2505600000;
                        }
                    } else {
                        tarikhMonth = $('#month').val() * 2592000000;
                    }
                    let newJdateUnix = beginMiladiUnix + tarikhMonth;
                    let newJdateMiladi = new Date(newJdateUnix);
                    let newJdate = new JDate(newJdateMiladi);

                    if ((jdate.date[1] == '6' && jdate.date[2] == "31") || (jdate.date[1] == '5' && jdate.date[2] == "31") || (jdate.date[1] == '4' && jdate.date[2] == "31") || (jdate.date[1] == '3' && jdate.date[2] == "31") || (jdate.date[1] == '2' && jdate.date[2] == "31")) {

                        bargashtAzMah = new JDate(newJdate.date[0], newJdate.date[1], '30');
                    } else {
                        bargashtAzMah = new JDate(newJdate.date[0], newJdate.date[1], newJdate.date[2]);
                    }

                    $('#searchBtn').before(`<div class="knsl-input-frame col-lg-12 khorooj">
                                        <label for="check-in">خروج</label>
                                            <p>${bargashtAzMah.date[0]+'/'+bargashtAzMah.date[1]+'/'+bargashtAzMah.date[2]}</p>
                                    </div>`);
                    $('#check-out').val(`${bargashtAzMah.date[0]+'/'+bargashtAzMah.date[1]+'/'+bargashtAzMah.date[2]}`);
                }
            });
            $('#month').change(function () {

                $('#form').attr('action', '{{asset('roomlist')}}/' + $('#pansions').val());
            });
            $('#check-out').change(function () {
                $('#form').attr('action', '{{asset('roomlist')}}/' + $('#pansions').val());
            });

        });

        $('#form').submit(function (ee) {

            let raft = $('#check-in').val();
            let bargasht = $('#check-out').val();
            let splitMiladiRaft = raft.split('/');
            let splitMiladiBargasht = bargasht.split('/');
            let jdateRaft = new JDate(splitMiladiRaft[0], splitMiladiRaft[1], splitMiladiRaft[2]);
            let jdateBargasht = new JDate(splitMiladiBargasht[0], splitMiladiBargasht[1], splitMiladiBargasht[2]);
            let MiladiRaft = JDate.toGregorian(jdateRaft.date[0], jdateRaft.date[1], jdateRaft.date[2]);
            let MiladiBargasht = jdateBargasht.toGregorian(jdateRaft.date[0], jdateRaft.date[1], jdateRaft.date[2]);
            if ($('#pansions').val().length==0){
                ee.preventDefault();
                return toastr.warning('خوابگاه را باید مشخص کنید.');
            }
            if ($('#check-in').val().length==0){
                ee.preventDefault();
                return toastr.warning('تاریخ شروع را باید مشخص کنید.');
            }
            if ($('#check-out').val().length==0){
                ee.preventDefault();
                return toastr.warning('تاریخ خروج را باید مشخص کنید.');
            }
if (MiladiRaft.getTime()>=MiladiBargasht.getTime()){
    ee.preventDefault();
    return toastr.warning('تاریخ خروج باید قبل از شروع باشد.');
}

            $('#check-in').val(`${MiladiRaft.getFullYear()+'-'+(MiladiRaft.getMonth()+1)+'-'+MiladiRaft.getDate()}`);
            $('#check-out').val(`${MiladiBargasht.getFullYear()+'-'+(MiladiBargasht.getMonth()+1)+'-'+MiladiBargasht.getDate()}`);

        });
    </script>
@endsection
<section class="knsl-banner">
    <div class="knsl-cover-frame">
        <img src="{{$slider->photo!=null?asset($slider->photo[0]->path):''}}" alt="banner" class="knsl-parallax">
    </div>
    <div class="knsl-overlay"></div>

    <div class="knsl-banner-content knsl-p-40-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 align-self-center">
                    <div class="knsl-main-title knsl-mb-40">
                        <div class="knsl-white">
                            <ul class="knsl-stars knsl-stars-left">
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                            </ul>
                            <!-- main-title -->
                            <h1 class="knsl-mb-20">{{$slider!='notfound'?$slider->title:''}}</h1>
                            <div class="knsl-mb-30">
                                {{$slider!='notfound'?$slider->passage:''}}
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">

                    <div class="knsl-book-form knsl-mb-40">
                        <form id="form">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="knsl-input-frame">
                                        <label for="check-in">خوابگاه</label>
                                        <select name="pansion" class="" id="pansions">
                                            <option value="">انتخاب</option>
                                            @if($pansions!='notfound')
                                                @foreach($pansions as $pansion)
                                                    <option value="{{$pansion->id}}">{{$pansion->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="knsl-input-frame">
                                        <label for="check-in">ورود</label>
                                        <input name="raft" id="check-in" type="text" class="datepicker-here"
                                               data-position="bottom left" placeholder="انتخاب تاریخ" autocomplete="off"
                                               readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-lg-12" id="reservetypeDiv">
                                    <div class="knsl-input-frame">
                                        <label for="check-in">نوع رزرو</label>
                                        <select name="reserve" id="reservetype">
                                            <option value="days">روزانه</option>
                                            <option value="months">ماهانه</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12" id="monthDiv">
                                    <div class="knsl-input-frame">
                                        <label for="check-in">تعداد ماه</label>
                                        <select name="month" id="month" class="">
                                            <option value="1"> 1 ماه</option>
                                            <option value="2"> 2 ماه</option>
                                            <option value="3"> 3 ماه</option>
                                            <option value="4"> 4 ماه</option>
                                            <option value="5"> 5 ماه</option>
                                            <option value="6"> 6 ماه</option>
                                            <option value="7"> 7 ماه</option>
                                            <option value="8"> 8 ماه</option>
                                            <option value="9"> 9 ماه</option>
                                            <option value="10"> 10 ماه</option>
                                            <option value="11"> 11 ماه</option>
                                            <option value="12"> 12 ماه</option>


                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12" id="exitDiv">
                                    <div class="knsl-input-frame">
                                        <label for="check-out" class="knsl-add-icon">خروج</label>
                                        <input name="bargasht" id="check-out" type="text" class="datepicker-here"
                                               data-position="bottom left" placeholder="انتخاب تاریخ" autocomplete="off"
                                               readonly="readonly">
                                    </div>
                                </div>

                                <div class="col-lg-12 knsl-center" id="searchBtn">
                                    <button type="submit" class="knsl-btn"><img src="img/icons/search.svg"
                                                                                class="knsl-zoom" alt="icon">جستجو
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- banner end -->
