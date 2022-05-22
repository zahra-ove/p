<!-- top bar -->
<div class="knsl-top-bar">
    <div class="container">
        <div class="knsl-left-side">
            <!-- logo -->
            <a href="home-1.html" class="knsl-logo-frame">
{{--                <img src="{{asset('img/logo.svg')}}" alt="Kinsley">--}}
            </a>
            <!-- logo end -->
        </div>
        <div class="knsl-right-side">
            <!-- menu -->
            <div class="knsl-menu">
                <nav>
                    <ul>
                        <li class="menu-item-has-children current-item">
                            <a href="{{asset("")}}">خانه</a>

                        </li>
                        <li class="about-menu">
                            <a href="{{route('about')}}">درباره</a>
                        </li>

                        <li class="contact-menu">
                            <a href="{{route('contact')}}">تماس با ما</a>
                        </li>

                    </ul>
                </nav>
            </div>
            <!-- menu end -->
            <!-- action button -->
            @if(\Illuminate\Support\Facades\Auth::check()==false)
                <a id="book-popup" href="{{asset('login')}}" class="knsl-btn"> <i class="fa fa-bookmark p-1"></i>ورود  </a>
            @else
                <p>{{\Illuminate\Support\Facades\Auth::user()->name.' '.\Illuminate\Support\Facades\Auth::user()->family}}</p>
                <a id="book-popup" href="{{route('admin')}}" class="knsl-btn"> <i class="fa fa-bookmark p-1"></i>ورود به پنل  </a>
           @endif
            <!-- action button end -->
        </div>
        <!-- menu button -->
        <div class="knsl-menu-btn"><span></span></div>
        <!-- menu button end -->
    </div>
</div>
<!-- top bar end -->
