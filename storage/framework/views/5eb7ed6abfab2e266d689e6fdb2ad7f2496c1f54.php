<!--jquery min js-->
<script src="<?php echo e(asset("js")); ?>/jquery.min.js"></script>

<!--bootstrap min js-->
<script src="<?php echo e(asset("js")); ?>/bootstrap.min.js"></script>
<!--bootstrap min js-->
<script src="<?php echo e(asset("store")); ?>/js/bootstrap.bundle.min.js"></script>
<!--bootstrap min js-->
<script src="<?php echo e(asset("store")); ?>/js/smooth-scroll.js"></script>
<!--tiny slider min js-->
<script src="<?php echo e(asset("store")); ?>/js/bootstrap-datepicker.fa.min.js"></script>
<script src="<?php echo e(asset("store")); ?>/js/bootstrap-datepicker.js"></script>
<script src="<?php echo e(asset("store/js/custom.js")); ?>"></script>
<!--persiandatepicker min js-->

<!--persian-date js-->

<!--flatpickr js-->
<script src="<?php echo e(asset("store")); ?>/js/fancybox.min.js"></script>
<!--rangePlugin.js js-->
<script src="<?php echo e(asset("store")); ?>/js/isotope.min.js"></script>

<script src="<?php echo e(asset("js")); ?>/toastr.min.js"></script>
<!--simplebar.js js-->
<script src="<?php echo e(asset("store")); ?>/js/jquery.nice-select.min.js"></script>
<!--lightgallery.js js-->
<script src="<?php echo e(asset("store")); ?>/js/mapbox.min.js"></script>
<script src="<?php echo e(asset("admin")); ?>/js/all.min.js"></script>
<!--lg-fullscreen.js js-->
<script src="<?php echo e(asset("store")); ?>/js/sticky.js"></script>
<!--lg-zoom.min.js.js js-->
<script src="<?php echo e(asset("store")); ?>/js/swiper.min.js"></script>
<!--lg-zoom.min.js.js js-->

<!--lg-zoom.min.js.js js-->
<script src="<?php echo e(asset("store")); ?>/js/persian-date.js"></script>
<!--select2 js-->
<script src="<?php echo e(asset("admin")); ?>/js/select2.js"></script>
<script src="<?php echo e(asset("js")); ?>/main.js"></script>
<script src="<?php echo e(asset("admin")); ?>/js/persianDatepicker.min.js"></script>

<?php echo $__env->yieldContent('pagejs'); ?>
<!-- Page loading scripts-->
<script>
    <?php if(\Illuminate\Support\Facades\Auth::check()): ?>
    $('.fav').click(function (eve) {

        let proid = $(this).attr('data-id');
        let id = "<?php echo e(\Illuminate\Support\Facades\Auth::user()->id); ?>";
        $.ajax(
            {
                url:"<?php echo e(route('setfav')); ?>",
                data:{"_token": "<?php echo e(csrf_token()); ?>",'id':id,'proId':proid},
                type:"post",
                success: function (data) {

                    console.log(this.url)
                    if (data == 'notfound') {

                        toastr.error('نشد');

                    }

                }
            }
        );
    });

    <?php endif; ?>
    // (function () {
    //     window.onload = function () {
    //         var preloader = document.querySelector('.page-loading');
    //         preloader.classList.remove('active');
    //         setTimeout(function () {
    //             preloader.remove();
    //         }, 2000);
    //     };
    // })();
    $(document).ready(function (e){
        $('.select2').select2({

        });
        ///seprate number
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
numberWithCommas($('.seprate').text());

        ///register
        $('.justnumber').on("keypress",function(e)
        {
            if (isNaN(e.key))
            {
                e.preventDefault()
            }
            if ($(this).val().length>10){
                e.preventDefault();
            }
            if (e.key==" "){
                e.preventDefault()
            }

        });
        $(".mobileInput").keyup(function (event){
            if ($(this).val()[0]!=0 && event.key!='Backspace' && isNaN(event.key)==false) {
                $(this).val($(this).val().slice(0, -1));
toastr.error('حتما باید با صفر شروع شود.')
            }
            if ($(this).val()[1] != 9 && event.key!="Backspace" && isNaN(event.key)==false) {
                if ($(this).val()[1] != undefined){
                    $(this).val($(this).val().slice(0, -1));
                    toastr.error('عدد دوم باید عدد 9 باشد.')
                }
            }
        })
        $('#signup-birthday').on("keypress",function(e)
        {
            if ($(this).val().length==4){
                $(this).val( $(this).val()+"/");
            }
            if ($(this).val().length==7){
                $(this).val( $(this).val()+"/");
            }
            if (isNaN(e.key))
            {
                e.preventDefault()
            }
            if ($(this).val().length>9){
                e.preventDefault();
            }


        });
        $("#registersubmit").submit(function (e) {
            let password=$("#signup-password").val();
            let passwordConfirm = $("#signup-password-confirm").val();
            if (password!==passwordConfirm){
                e.preventDefault();
                toastr.error('عدم تطابق تکرار پسورد.')

            }
        });
        $('#selecetCityRegister').change(function (e) {
            $(this).css('color','black');
        })
        ////login
        $("#submitLogin").click(function (e) {
            let mobliecode=$('#signin-mobilecode').val();
            let password=$('#signin-password').val();
            let info={
                "_token": "<?php echo e(csrf_token()); ?>",
                "mobilecode":mobliecode,
                "password":password
            }
            $.ajax(
                {
                    url:"<?php echo e(asset('logins')); ?>",
                    data:info,
                    type:"post",
                    success:function (data) {
                        if (data!="notfound"){
                            location.reload();
                            toastr.success("خوش آمدید")
                        }
                        else {
                            toastr.error("شماره تماس یا رمز عبور اشتباه است.")
                        }
                        console.log(data)
                    }
                }
            )
        });
        $("#logout").click(function (e) {
            let mobliecode=$('#signin-mobilecode').val();
            let password=$('#signin-password').val();
            let infos={
                "_token": "<?php echo e(csrf_token()); ?>",

            }
            $.ajax(
                {
                    url:"<?php echo e(asset('logout')); ?>",
                    data:infos,
                    type:"post",
                    success:function (data) {
                                 console.log(data)
                            location.href="<?php echo e(asset('')); ?>";

                    }
                }
            )
        })
        //////// towns
      let townpicwidth = $('.towns').children('article').children('a').children('img').css('width');
        $('.towns').children('article').children('a').children('div').css('width',townpicwidth);
        $('#otherOstan').hide()
        $('#openOstans').click(function (ee) {
            $(this).children('i').toggleClass('fi-arrow-long-left').toggleClass('fi-arrow-long-down');
            $('#otherOstan').toggle(500)
        });
    });
    // $('#date-event').persianDatepicker({
    //     initialValue: false,
    //     format: 'YYYY/MM/DD',
    //     selectedBefore:false,
    //
    // });
;
        //startDate is tomarrow
        var p = new persianDate();


        $('.moreCity').click(function (ev) {
            let heights =   $(this).siblings('.textAbout').children('p').css('height');
            console.log(heights)
           $(this).siblings('.textAbout').animate({height:heights,overflow:'visible'});

            if ($(this).siblings('.textAbout').css('height')==heights){
                $(this).siblings('.textAbout').animate({height:'25%',overflow:'hidden'});

            }
        });

    JalaliDate.jalaliToGregorian = function(j_y, j_m, j_d) {
        j_y = parseInt(j_y);
        j_m = parseInt(j_m);
        j_d = parseInt(j_d);
        var jy = j_y - 979;
        var jm = j_m - 1;
        var jd = j_d - 1;

        var j_day_no = 365 * jy + parseInt(jy / 33) * 8 + parseInt((jy % 33 + 3) / 4);
        for (var i = 0; i < jm; ++i) j_day_no += JalaliDate.j_days_in_month[i];

        j_day_no += jd;

        var g_day_no = j_day_no + 79;

        var gy = 1600 + 400 * parseInt(g_day_no / 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
        g_day_no = g_day_no % 146097;

        var leap = true;
        if (g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
        {
            g_day_no--;
            gy += 100 * parseInt(g_day_no / 36524); /* 36524 = 365*100 + 100/4 - 100/100 */
            g_day_no = g_day_no % 36524;

            if (g_day_no >= 365) g_day_no++;
            else leap = false;
        }

        gy += 4 * parseInt(g_day_no / 1461); /* 1461 = 365*4 + 4/4 */
        g_day_no %= 1461;

        if (g_day_no >= 366) {
            leap = false;

            g_day_no--;
            gy += parseInt(g_day_no / 365);
            g_day_no = g_day_no % 365;
        }

        for (var i = 0; g_day_no >= JalaliDate.g_days_in_month[i] + (i == 1 && leap); i++)
            g_day_no -= JalaliDate.g_days_in_month[i] + (i == 1 && leap);
        var gm = i + 1;
        var gd = g_day_no + 1;

        gm = gm < 10 ? "0" + gm : gm;
        gd = gd < 10 ? "0" + gd : gd;

        return [gy, gm, gd];
    }
</script>
<?php /**PATH C:\xampp\htdocs\pansion_fatemepc\resources\views/store/master/masterjs.blade.php ENDPATH**/ ?>