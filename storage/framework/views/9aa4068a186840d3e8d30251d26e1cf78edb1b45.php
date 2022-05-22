<!-- top bar -->
<div class="knsl-top-bar">
    <div class="container">
        <div class="knsl-left-side">
            <!-- logo -->
            <a href="home-1.html" class="knsl-logo-frame">

            </a>
            <!-- logo end -->
        </div>
        <div class="knsl-right-side">
            <!-- menu -->
            <div class="knsl-menu">
                <nav>
                    <ul>
                        <li class="menu-item-has-children current-item">
                            <a href="<?php echo e(asset("")); ?>">خانه</a>

                        </li>
                        <li class="about-menu">
                            <a href="<?php echo e(route('about')); ?>">درباره</a>
                        </li>

                        <li class="contact-menu">
                            <a href="<?php echo e(route('contact')); ?>">تماس با ما</a>
                        </li>

                    </ul>
                </nav>
            </div>
            <!-- menu end -->
            <!-- action button -->
            <?php if(\Illuminate\Support\Facades\Auth::check()==false): ?>
                <a id="book-popup" href="<?php echo e(asset('login')); ?>" class="knsl-btn"> <i class="fa fa-bookmark p-1"></i>ورود  </a>
            <?php else: ?>
                <p><?php echo e(\Illuminate\Support\Facades\Auth::user()->name.' '.\Illuminate\Support\Facades\Auth::user()->family); ?></p>
                <a id="book-popup" href="<?php echo e(route('admin')); ?>" class="knsl-btn"> <i class="fa fa-bookmark p-1"></i>ورود به پنل  </a>
           <?php endif; ?>
            <!-- action button end -->
        </div>
        <!-- menu button -->
        <div class="knsl-menu-btn"><span></span></div>
        <!-- menu button end -->
    </div>
</div>
<!-- top bar end -->
<?php /**PATH C:\xampp\htdocs\pansion3\resources\views/store/master/header.blade.php ENDPATH**/ ?>