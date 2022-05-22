<!--NavBar-->

<div id="nav-wrapper" class="nav-wrapper  bg-light">
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: rgba(242,253,236,0.76)">
        <a class="navbar-brand ms-3 ms-xl-4 logo mx-4" href="city-guide-home-v1.html"><img class="d-block" src="{{asset('img')}}/logo.png" height="50" alt="Finder"></a>
        <!--Start Plus Icon-->
        <div class="d-inline-block position-relative">
            <div class="dropdown-menu dropdown-menu-right left p-0">
                <a href="#" class="dropdown-item px-2">ایجاد صفحه</a>
                <a href="#" class="dropdown-item px-2">افزودن کاربر جدید</a>
                <a href="#" class="dropdown-item px-2">کمپین جدید</a>
                {{--                <div class="dropdown-divider"></div>--}}
                <a href="#" class="dropdown-item px-2 text-danger">گزارش تهیه کنید</a>
            </div>
        </div>
        <!--End Plus Icon-->

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu-nav-wrapper" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-menu-nav-wrapper">
            <ul class="navbar-nav">
                @if(\Illuminate\Support\Facades\Auth::user()->hasPermission('dashboard') || \Illuminate\Support\Facades\Auth::user()->hasPermissions('dashboard'))
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-support"></i>
                            <p>داشبورد</p>
                        </a>
                        <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('recentreserve')}}">رزرو فعال</a>
                            <a class="dropdown-item" href="{{route('changepassblade',\Illuminate\Support\Facades\Auth::id())}}">تغییر رمز</a>
                            <a class="dropdown-item" href="{{route('reserveuser',\Illuminate\Support\Facades\Auth::user()->id)}}">تاریخچه رزرو ها</a>
                            <a class="dropdown-item" href="{{asset('')}}">بازگشت به فروشگاه</a>
                            <div class="dropdown-divider"></div>
                            {{--                        <a class="dropdown-item" href="{{asset('')}}">بازگشت به فروشگاه</a>--}}
                            <a class="dropdown-item" href="#" id="logout">خروج</a>
                        </div>
                    </li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->hasPermission('payment') || \Illuminate\Support\Facades\Auth::user()->hasPermissions('payment'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-support"></i>
                            <p>مالی</p>
                        </a>
                        <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('payqestuser',\Illuminate\Support\Facades\Auth::id())}}">پرداخت قسط</a>
                            <a class="dropdown-item" href="{{route('gettransactionbyuser',\Illuminate\Support\Facades\Auth::id())}}">تراکنش مالی</a>
                        </div>
                    </li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->hasPermission('user_menu') || \Illuminate\Support\Facades\Auth::user()->hasPermissions('user_menu'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-support"></i>
                            <p>مشترکین</p>
                        </a>
                        <div class="dropdown-menu  bg-light" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('createcustomer')}}">ثبت مشترک</a>
                            <a class="dropdown-item" href="{{route('indexcustom')}}">لیست مشترکین</a>
                            <a class="dropdown-item" href="{{route('allcustomers')}}">لیست مشترکین ساکن</a>
                            <a class="dropdown-item" href="{{route('allcustomersgone')}}">لیست مشترکین خارج شده</a>
                            <a class="dropdown-item" href="{{route('wallet')}}">شارژ کیف پول</a>
                        </div>
                    </li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->hasPermission('report_menu') || \Illuminate\Support\Facades\Auth::user()->hasPermissions('report_menu'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-support"></i>
                            <p>گزارش ها</p>
                        </a>
                        <div class="dropdown-menu  bg-light" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('fulltakht')}}">تخت های پر</a>
                            <a class="dropdown-item" href="{{route('getAllorders')}}">تاریخچه رزرو ها</a>
                            <a class="dropdown-item" href="{{route('getAllordersByDate')}}">تاریخچه رزرو ها بر اساس تاریخ</a>
                            <a class="dropdown-item" href="{{route('getordersnotpay')}}">رزرو های بدهکار</a>
                        </div>
                    </li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->hasPermission('personal_menu') || \Illuminate\Support\Facades\Auth::user()->hasPermissions('personal_menu'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-support"></i>
                            <p>پرسنل</p>
                        </a>
                        <div class="dropdown-menu  bg-light" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('personal.create')}}">افزودن پرسنل</a>
                            <a class="dropdown-item" href="{{route('personal.index')}}">لیست پرسنل</a>
                        </div>
                    </li>
                @endif

                @if(\Illuminate\Support\Facades\Auth::user()->hasPermission('pansion_menu') || \Illuminate\Support\Facades\Auth::user()->hasPermissions('pansion_menu'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-support"></i>
                            <p>خوابگاه</p>
                        </a>
                        <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('pansion.index')}}">لیست خوابگاه ها</a>
                            <a class="dropdown-item" href="{{route('getallrooms')}}">لیست تمامی اتاق ها</a>
                            <a class="dropdown-item" href="{{route('pansion.create')}}">افزودن خوابگاه</a>
                            <a class="dropdown-item" href="{{route('room.create')}}">افزودن اتاق</a>
                            <a class="dropdown-item" href="{{route('takht.create')}}">افزودن تخت</a>
                        </div>
                    </li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->hasPermission('reserve_menu') || \Illuminate\Support\Facades\Auth::user()->hasPermissions('reserve_menu'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-support"></i>
                            <p>رزرو</p>
                        </a>
                        <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
                            @if(\Illuminate\Support\Facades\Auth::user()->hasPermission('personal_reserve'))
                                <a class="dropdown-item" href="{{route('order.create')}}">رزرو تخت</a>
                                <a class="dropdown-item" href="{{route('cancelreserve')}}">کنسلی رزرو</a>
                                <a class="dropdown-item" href="{{route('tamdidreserve')}}">تمدید رزرو</a>
                                <a class="dropdown-item" href="{{route('movereserve')}}">جابجایی تخت</a>
                                <a class="dropdown-item" href="{{route('taghirvaziat')}}">تغییر وضعیت زمانی</a>
                                <a class="dropdown-item" href="{{route('ekhrajiha')}}">اخراج افراد</a>
                                <a class="dropdown-item" href="{{route('khorujiha')}}">خروج زودهنگام</a>
                            @elseif(\Illuminate\Support\Facades\Auth::user()->hasPermission('customer_reserve'))
                                <a class="dropdown-item" href="{{route('customreserve',\Illuminate\Support\Facades\Auth::id())}}">رزرو تخت</a>
                                <a class="dropdown-item" href="{{route('tamdiduser',\Illuminate\Support\Facades\Auth::id())}}">تمدید رزرو</a>

                            @endif
                        </div>
                    </li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->hasPermission('city_menu') || \Illuminate\Support\Facades\Auth::user()->hasPermissions('city_menu'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-support"></i>
                            <p>شهر و استان</p>
                        </a>
                        <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('ostan.create')}}">افزودن استان</a>
                            <a class="dropdown-item" href="{{route('city.create')}}">افزودن شهر</a>
                        </div>
                    </li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::user()->hasPermission('firstpage_permission') ||  \Illuminate\Support\Facades\Auth::user()->hasPermissions('firstpage_permission'))
                    {{--                @permission('firstpage_permission')--}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-support"></i>
                            <p>تنظیمات</p>
                        </a>
                        <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('group.create')}}">افزودن سمت</a>
                            <a class="dropdown-item" href="{{route('permission.create')}}">افزودن دسترسی</a>
                            <a class="dropdown-item" href="{{route('naqdtype.create')}}">افزودن نوع پرداخت</a>
                            <a class="dropdown-item" href="{{route('massages')}}">تنظیمات پیامک ها</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-support"></i>
                            <p>صفحه اول</p>
                        </a>
                        <div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('slidercreate')}}">بنر اصلی</a>
                            <a class="dropdown-item" href="{{route('aboutcreate')}}">درباره</a>
                            <a class="dropdown-item" href="{{route('contactcreate')}}">تماس با ما</a>
                            <a class="dropdown-item" href="{{route('roompickcreate')}}">اتاق منتخب</a>
                        </div>
                    </li>
                    {{-- @endpermission--}}
                @endif

            </ul>
            <div class="navbar-right ml-auto" style="margin-left: 20px">

                @if(\Illuminate\Support\Facades\Auth::user()->ncodetype()->where('ncodetype_id',5)->exists())
                    <img  src="{{asset(\Illuminate\Support\Facades\Auth::user()->ncodetype()->where('ncodetype_id',5)->first()->pivot->path)}}" style="width: 50px;height: 50px;border-radius: 50%">
                @else
                    <img  src="{{asset('img')}}/unknown_user.png" style="width: 50px;height: 50px;border-radius: 50%">
                @endif

            </div>
        </div>

    </nav>
    <div class="row container-fluid mx-0 text-center py-3" style="border:1px solid #aaaaaa">
        <div class="col-lg-3 col-12">
            نام و نام خانوادگی: {{\Illuminate\Support\Facades\Auth::user()->name." ".\Illuminate\Support\Facades\Auth::user()->family}}
        </div>
        <div class="col-lg-3 col-12">
            کدملی: {{\Illuminate\Support\Facades\Auth::user()->ncode}}
        </div>
        <div class="col-lg-3 col-12">
            موبایل: {{\Illuminate\Support\Facades\Auth::user()->mobilecode}}
        </div>
    </div>
</div>
<!--  End NavBar-->


@auth
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endauth


<script>
    // let logout = function() {
    //     // document.getElementById('logout-form').submit();
    //
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         cache: false,
    //         type: "POST",
    //         timeout: 5000,
    //         url: "/logout",
    //         success: function(data)
    //         {
    //             console.log('logged out successfully');
    //
    //         },
    //         error: function(msg)
    //         {
    //             console.log('loggedout failed');
    //         }
    //     });
    // }
</script>
