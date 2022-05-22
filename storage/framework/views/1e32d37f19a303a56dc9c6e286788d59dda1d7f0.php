<!--jquery min js-->
<script src="<?php echo e(asset("js/jquery.min.js")); ?>"></script>
<!--bootstrap min js-->
<script src="<?php echo e(asset("js/bootstrap.min.js")); ?>"></script>
<!--jquery-ui.min js-->
<script src="<?php echo e(asset("admin/js/jquery-ui.min.js")); ?>"></script>
<!--bootstrap-tour-standalone.min js-->
<script src="<?php echo e(asset("admin/js/bootstrap-tour-standalone.min.js")); ?>"></script>
<!--select2 js-->
<script src="<?php echo e(asset("admin/js/select2.js")); ?>"></script>
<!--select2.script.js js-->
<!--toastr.min js-->
<script src="<?php echo e(asset("js/toastr.min.js")); ?>"></script>
<!--persiandatepicker min js-->
<script src="<?php echo e(asset("admin/js/persianDatepicker.min.js")); ?>"></script>
<script src="<?php echo e(asset("admin/js/all.min.js")); ?>"></script>
<!--ckeditor js-->
<script src="//cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
<!--dropzone js-->
<script src="<?php echo e(asset("admin/js/dropzone.js")); ?>"></script>
<!--galley js-->
<script src="<?php echo e(asset("admin/js/lightboxgallery-min.js")); ?>"></script>
<script src="<?php echo e(asset("admin/js/jquery.dataTables.js")); ?>"></script>
<!--carousel js-->
<script src="<?php echo e(asset("admin/js/owl.carousel.min.js")); ?>"></script>
<script src="<?php echo e(asset("admin/js/multiselect.min.js")); ?>"></script>
<script src="<?php echo e(asset("admin/js/jquery-clock-timepicker.js")); ?>"></script>

<script src="<?php echo e(asset("admin/js/jquery.switcher.js")); ?>"></script>


<script>
    $(document).ready(function (){

        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });

        ////dataTable
        $('.mytable').DataTable(
            {

            }
        );
        //Customize DataTable
        let a = $('.select-items').parent();
        // a.siblings().first().removeClass('col-md-6').addClass('col-md-4');
        // a.removeClass('col-md-6').addClass('col-md-2');
        $(".dataTables_wrapper").addClass('row');
        $('.select-items').addClass(['col-md-12'])
        $('.select-items').siblings().not('.dataTables_info').not('table').not('.dataTables_paginate').addClass(['col-md-6','order-2']);
        $('table').addClass('order-3');
        $('.dataTables_info').addClass('order-3');
        $('.dataTables_info').addClass('col-5');
        $('.dataTables_paginate').addClass('order-3');
        $('.dataTables_paginate').addClass('col-6');
        
        $('.dataTables_filter').after('<div class="col-sm-12 col-md-6 mt-2 order-1"><a href="" class="btn btn-success mb-2 hrefbtn" style="width:20%">افزودن</a></div>');
        $('.dataTables_filter').css('text-align','left');
        $('.dataTables_paginate a').addClass('btn');
        $('#DataTables_Table_0_length').hide();
        // $('.dataTables_paginate').addClass('w-100');
        // $('.dataTables_paginate').addClass('text-center');
        $(document).on('click','.paginate_button',function (ewe){

            $(this).addClass('text-center');
            $('.paginate_button').addClass('btn');

        });


        //Price 3 Digit Seperator
        $('.seprator').keyup(function (e){
            let value = $(this).val();
            separateNum(value,$(this)[0])

        });
        function separateNum(value, input) {
            /* seprate number input 3 number */
            var nStr = value + '';
            nStr = nStr.replace(/\,/g, "");
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            if (input !== undefined) {
                input.value = x1 + x2;
            } else {
                return x1 + x2;
            }
        }
        $('.select2').select2({
            placeholder: "انتخاب کنید.",
            "language": {
                "noResults": function(){
                    return "موردی وجود ندارد.";                }
            }
        });
        /////persiandate




        //jalali
        JalaliDate = {
            g_days_in_month: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
            j_days_in_month: [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29]
        };

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
        //providerSubmit
        $('.justnumber').on("keypress",function(e)
        {

            if (isNaN(e.key))
            {
                e.preventDefault()
            }

            if (e.key==" "){
                e.preventDefault()
            }

        });
        $('.phone').on("keypress",function(e)
        {
            if (isNaN(e.key))
            {
                e.preventDefault()
            }
            if ($(this).val().length>7){
                e.preventDefault();
            }

        });
        $('.ncode').on("keypress",function(e)
        {
            if (isNaN(e.key))
            {
                e.preventDefault()
            }
            if ($(this).val().length>9){
                e.preventDefault();
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
        $('.mobileInput').on("keypress",function(e){
            if ($(this).val().length>10){
                e.preventDefault();
            }
        });
        $('.cardnumber').on("keypress",function(e){

            if ($(this).val().length>18){
                e.preventDefault();
            }
        });

        $('.cardnumber').on("keyup",function(e){
            if ($(this).val().length==4){
                $(this).val( $(this).val()+"-");
            }
            if ($(this).val().length==9){
                $(this).val( $(this).val()+"-");
            }
            if ($(this).val().length==14){
                $(this).val( $(this).val()+"-");
            }

        });
        $('.birthday').on("keypress",function(e)
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
        ///cityForm
        $('#city-attach').change(function (e){
            let files=e.target.files;
            let file=files[0];
            let reader= new FileReader();
            reader.onload=(function (theFile){
                $('.single-show-img').remove();
                var imgSrc = theFile.target.result;
                $('.singleShow').append("<img class='single-show-img w-100 h-50' src='"+imgSrc+"'> ")
            })
// Read in the image file as a data URL.
            reader.readAsDataURL(this.files[0]);
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

    })

</script>
<?php /**PATH C:\xampp\htdocs\pansion3\resources\views/admin/master/masterjs.blade.php ENDPATH**/ ?>