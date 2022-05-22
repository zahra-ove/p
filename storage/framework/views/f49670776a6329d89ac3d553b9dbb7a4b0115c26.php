<meta name="csrf_token" content="<?php echo e(csrf_token()); ?>">

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('admin/js/hijri-date-latest.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('admin/js/jdate.min.js')); ?>" type="text/javascript" charset="utf-8"></script>
    <script>
        $(document).ready(function () {

            $('#jarimeTable').addClass('d-none');
            let userId;       // selected userId
            let orderId;      // selected orderId for selected user

//========================================= custom functions start ============================
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
//========================================= custom functions end ============================

//========================================= user selected from dropdown start ===============
            $('#user').change(function (ev) {
                // $('.table').show();
                userId = $(this).val();    //user id
                console.log(userId);

                // دریافت لیست سفارش های مشتری انتخاب شده
                $.ajax({
                        // get all orders related to selected user
                        cache: false,
                        type: "GET",
                        url: "/admin/getallactiveorder/" +  userId,
                        success: function(data)
                        {
                            // console.log(data);

                            $.each(JSON.parse(data), function(key, value) {
                                console.log(key + ':' + JSON.stringify(value));

                                $('#cancelyTable tbody').append(`
                                                                      <tr>
                                                                         <td scope="row">${parseInt(key)+1}</td>
                                                                         <td>${value.raft}</td>
                                                                         <td>${value.bargasht}</td>
                                                                         <td>${value.total_price_before_takhfif_wallet}</td>
                                                                         <td>${value.takhfif}</td>
                                                                         <td>${value.wallet_used_amount}</td>
                                                                         <td>${value.paid_amount}</td>
                                                                         <td>${value.maande_amount}</td>
                                                                         <td>${value.paid_way}</td>
                                                                         <td>${value.total_mali_status}</td>
                                                                         <td id="qestlist" data-orderid="${value.id}"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#qestlistmodal">مشاهده</button></td>
                                                                         <td id="transactionlist" data-orderid="${value.id}"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#transactionlistmodal">مشاهده</button></td>
                                                                         <td class="cancelrequest" data-orderid="${value.id}"><button type="button" class="btn btn-primary btn-sm">لغو</button></td>
                                                                       </tr>
                                                                 `);
                            });
                        },
                        error: function (request, status, error)
                        {
                            console.log(request.responseText);
                        }
                    });
                });
//========================================= user selected from dropdown end ===============


//========================================= get qests list for selected order start =======
            // دریافت لیست اقساط سفارش بر اساس id
            $(document).on('click','#qestlist',function() {
               let orderId =  $(this).attr("data-orderid");
               $('.loader').removeClass('d-none');

                $.ajax({
                        // get all qest lists for this order
                        cache: false,
                        type: "GET",
                        url: "/admin/getallqestlistfororder/" +  orderId,
                        success: function(data)
                        {
                            $('.loader').addClass('d-none');
                            console.log('qest list is: ');
                            console.log(data);
                            $('#qestlistmodaltable tbody').empty();
                            // if there is no data, then table content be empty
                            if(!data){
                                $('#qestlistmodalbody').hide();
                            }

                            $.each(JSON.parse(data), function(key, value) {
                                $('#qestlistmodaltable tbody').append(`
                                                                      <tr>
                                                                         <td>${value.nobate_qest}</td>
                                                                         <td>${value.amount}</td>
                                                                         <td>${value.tarikh_mogharar}</td>
                                                                         <td>${value.tarikh_pardakht}</td>
                                                                         <td>${value.status}</td>
                                                                       </tr>
                                                                 `);
                            });
                        },
                        error: function (request, status, error)
                        {
                            console.log(request.responseText);
                        }

                    });
            });
//========================================= get qests list for selected order end =======

//==================== get transactions list for selected order start ===================
            // دریافت لیست تراکنشهای سفارش بر اساس id
            $(document).on('click','#transactionlist',function() {
                let orderId =  $(this).attr("data-orderid");

                $.ajax({
                    // get all qest lists for this order
                    cache: false,
                    type: "GET",
                    url: "/admin/getalltransactionlistfororder/" +  orderId,
                    success: function(data)
                    {
                        console.log('transactions list is: ');
                        console.log(data);
                        $('#transactionlistmodaltable tbody').empty();
                        // if there is no data, then table content be empty
                        if(!data){
                            $('#transactionlistmodalbody').hide();
                        }

                        $.each(JSON.parse(data), function(key, value) {
                            $('#transactionlistmodaltable tbody').append(`
                                                                      <tr>
                                                                         <td>${value.id}</td>
                                                                         <td>${value.price}</td>
                                                                         <td>${value.transactiontype_id}</td>
                                                                         <td>${value.naqdtype_id}</td>
                                                                       </tr>
                                                                 `);
                        });
                    },
                    error: function (request, status, error)
                    {
                        console.log(request.responseText);
                    }

                });
            });
//==================== get transactions list for selected order end ===================

//==================== show cancelation form when laghv button pressed start ==========

            //  نمایش فرم لغو سفارش برای سفارش انتخاب شده
            $(document).on('click','.cancelrequest',function() {
                orderId = $(this).attr("data-orderid");        // save selected orderId that must be deleted
                $('#jarimeTable').removeClass('d-none');      // display table


                // دریافت اطلاعات سفارش انتخاب شده
                //  دریافت موجودی کیف پول برای کاربر انتخاب شده
                $.ajax({
                    cache: false,
                    type: "GET",
                    url: "/admin/getwalletmojoodiandordertotalprice/" +  userId + '/' + orderId,
                    success: function(data){
                        // console.log('getwalletmojoodiandordertotalprice:');
                        // console.log(data);

                        $('#totalorderprice').html(`${data.totalprice} تومان `);    // مبلغ کل سفارش
                        $('#paid_amount').val(`${data.paid_amount} تومان `);       // مبلغ پرداخت شده توسط مشتری
                        $('#wallet_amount').val(`${data.wallet_mojoodi} تومان `);   // موجودی فعلی کیف پول مشتری

                    },
                    error: function (request, status, error)
                    {
                        console.log(request.responseText);
                    }
                });

            });
//==================== show cancelation form when laghv button pressed end ==========

//===========================start ارسال درخواست لغو رزرو ====================================
            $(document).on('click','#reserve_cancelation',function(e) {

                let jarime = $('#jarimeh').val() == null ? 0 :  $('#jarimeh').val().replace(',', '');      // میزان جریمه دریافت شده از مشتری
                let returnVajhToCustomer = $('#priceTrans').val() == null ? 0 :  $('#priceTrans').val().replace(',', '');        // میزان مبلغ بازگشت داده شده به مشتری
                let paid_amount = $('#paid_amount').val().split('.')[0];                                  // میزان مبلغ پرداخت شده توسط مشتری
                let jarime_pay_way = $('#jarime_pay_way option:selected').val();                         // میزان مبلغ پرداخت شده توسط مشتری
                let returningfish = $('#returningfish')[0].files[0];
                let jarimefish = $('#jarimefish')[0].files[0];

                console.log(jarime);
                console.log(returnVajhToCustomer);
                console.log(paid_amount);
                console.log(jarime_pay_way);

                let formData = new FormData();
                formData.append("orderId", orderId);
                formData.append("jarime", jarime);
                formData.append("returnVajhToCustomer", returnVajhToCustomer);
                formData.append("paid_amount", paid_amount);
                formData.append("jarime_pay_way", jarime_pay_way);
                formData.append("returningfish", returningfish);
                formData.append("jarimefish", jarimefish);
                formData.append("_token", '<?php echo e(csrf_token()); ?>');


                // اگر جریمه از از مبلغ بستانکاری کسر شده باشد و برآیند مبالغ اوکی نباشد ارور بده
                // check for error
                if( jarime_pay_way == parseInt(paid_amount) - parseInt(jarime) != parseInt(returnVajhToCustomer) ) {
                    e.preventDefault();
                    toastr.error('مبلغ بازگشتی به مشتری با مبلغ پرداختی و مبلغ جریمه تطابق ندارد.');
                } else {

                    // if every thing is ok, then send cancel request to controller
                    $.ajax({
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: "POST",
                        url: "/admin/cancelorder",
                        data: formData,
                        success: function(data){
                            console.log(data);
                        },
                        error: function (request, status, error)
                        {
                            console.log(request.responseText);
                        }
                    });

                }

            });
//===========================end ارسال درخواست لغو رزرو ====================================


        })
    </script>

<?php $__env->stopSection(); ?>
<style>
    #timeTable {
        height: 448.719px;
    }

    .select2 {
        width: 100% !important;
    }

    @media (min-width: 992px) {
        .container {
            max-width: 992px !important;
        }

        .mr-140 {
            margin-right: 140px !important;
        }
    }

    @media (min-width: 1200px) {
        .container {
            max-width: 1200px !important;
        }
    }


    @media (min-width: 1500px) {
        .container {
            max-width: 1500px !important;
        }
    }


    @media (max-width: 576px) {
        .mr-140 {
            margin-right: 60px !important;
        }
    }

    .breadcrumb {
        background-color: white !important;
    }

    /* ---- Loader ---- */
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 60px;
        height: 60px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
        margin: auto auto;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes  spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

</style>
<?php $__env->startSection('content'); ?>
    <!-- START: Breadcrumbs-->
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded"
                 style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="<?php echo e(route('admin')); ?>">داشبورد</a>
                        </li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">کنسلی رزرو
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <div class="container card mb-5" style="margin-top: 330px;background-color: gainsboro;">
        <div class="row justify-content-between mx-3">
            <div class="col-12 col-lg-3 mb-5 mt-5 row">
                <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
                                                                                        border: 1px solid;
                                                                                        height: 38px;
                                                                                        border: 1px solid #aaa!important;
                                                                                        border-radius: 5px;
                                                                                        background-color: beige;">
                    <span class="form-label mb-2 position-relative" style="top: 24%">مشترک</span>
                </div>
                <div class="col-9 p-0 ">
                    <select name="user_id" class="select2 form-control" id="user">
                        <option value="">مشترک را انتخاب کنید.</option>
                        <?php if($users!='notfound'): ?>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?> <?php echo e($user->family); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>

                </div>
            </div>
        </div>
    </div>

    <!-- reserves table-->
    <div class="container card border-top row  cancely mb-4" style="background-color: gainsboro;margin: 5em auto;">
        <table class="table table-striped" id="cancelyTable">
            <thead>
                <tr style="font-size: 12px;font-weight: bold;">
                    <th scope="col">شماره سفارش</th>
                    <th scope="col">زمان رفت</th>
                    <th scope="col">زمان برگشت</th>
                    <th scope="col">مبلغ نهایی سفارش</th>
                    <th scope="col">تخفیف</th>
                    <th scope="col">مبلغ پرداخت شده از کیف پول</th>
                    <th scope="col">کل مبلغ پرداخت شده</th>
                    <th scope="col">مبلغ باقی مانده</th>
                    <th scope="col">روش پرداخت</th>
                    <th scope="col">وضعیت کلی</th>
                    <th scope="col">لیست اقساط</th>
                    <th scope="col">لیست تراکنش ها</th>
                    <th scope="col">درخواست لغو رزرو</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>


    <!-- Qest list Modal -->
    <div class="modal fade" id="qestlistmodal" tabindex="-1" role="dialog" aria-labelledby="qestlistmodal" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">لیست قسط های مرتبط با این سفارش</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="qestlistmodalbody">
                    <table class="table table-striped" id="qestlistmodaltable">
                        <thead>
                        <tr style="font-size: 12px;font-weight: bold;">
                            <th scope="col">نوبت قسط</th>
                            <th scope="col">مبلغ</th>
                            <th scope="col">موعد مقرر پرداخت</th>
                            <th scope="col">تاریخ پرداخت</th>
                            <th scope="col">وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <div class="loader d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Transactions list Modal -->
    <div class="modal fade" id="transactionlistmodal" tabindex="-1" role="dialog" aria-labelledby="transactionlistmodal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">لیست تراکنش های مرتبط با این سفارش</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="transactionlistmodalbody">
                    <table class="table table-striped" id="transactionlistmodaltable">
                        <thead>
                        <tr style="font-size: 12px;font-weight: bold;">
                            <th scope="col">شماره</th>
                            <th scope="col">مبلغ</th>
                            <th scope="col">نوع تراکنش</th>
                            <th scope="col">نحوه پرداخت</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    <div class="loader d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>



    
    <div class="container card border-top row" style="margin: 4em auto;font-size:12px;" id="jarimeTable">
        <div>
            <table class="table-success table table-hover table-striped m-auto table-bordered" style="font-size:12px;">
                <thead style="background: #166618;color: white;">
                    <tr>
                        <th>کل سفارش</th>
                        <th>موجودی کیف پول</th>
                        <th>جریمه کنسلی</th>
                        <th>پرداخت شده توسط مشتری</th>
                        <th>بازگشتی به مشتری</th>
                        <th>نوع پرداخت جریمه</th>
                        <th>عملیات</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td id="totalorderprice"></td>
                        <td><input class="justnumber seprator" name="wallet_amount" id="wallet_amount" value="" autocomplete="off" disabled></td>
                        <td><input class="justnumber seprator" name="jarimeh" id="jarimeh" value="" autocomplete="off"></td>
                        <td><input class="justnumber seprator" name="paid_amount" id="paid_amount" value="" autocomplete="off" disabled></td>
                        <td><input class="justnumber seprator" name="priceTrans" id="priceTrans" value="0" autocomplete="off"></td>
                        <td>
                            <select name="jarime_pay_way" id="jarime_pay_way">
                                <option value="1">پرداخت از کیف پول</option>
                                <option value="2">پرداخت نقدی</option>
                                <option value="3">کسر از مبلغ بستانکاری سفارش</option>
                                <option value="4">جریمه پرداخت نشده است</option>
                            </select>
                        </td>
                        <td>
                            <label for="returningfish" class="btn btn-info" style="font-size:12px;">آپلود فیش واریز</label>
                            <input type="file" id="returningfish" class="d-none" name="returningfish">


                            <label for="jarimefish" class="btn btn-info" style="font-size:12px;">آپلود فیش جریمه</label>
                            <input type="file" id="jarimefish" class="d-none" name="jarimefish">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="text-align:center;"><button type="button" class="btn btn-primary mt-3"  id="reserve_cancelation">ثبت درخواست لغو رزرو</button></div>

    </div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.master.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pansion3\resources\views/admin/reserves/cancel.blade.php ENDPATH**/ ?>