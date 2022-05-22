<?php $__env->startSection('js'); ?>
    <script src="https://rawgit.com/abdennour/hijri-date/master/cdn/hijri-date-latest.js" type="text/javascript" ></script>
    <script src="<?php echo e(asset('admin/js/jdate.min.js')); ?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo e(asset('admin/js/taghvimSCOOB.js')); ?>" type="text/javascript" charset="utf-8"></script>

    <script>

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
                    console.log(JSON.parse(data));

                    $.each(JSON.parse(data), function(key, value) {

                        $('#tamdidTable tbody').append(`
                                                          <tr style="font-size:14px;">
                                                             <td scope="row">${parseInt(key)+1}</td>
                                                             <td>${value.takht_info}</td>
                                                             <td>${value.raft}</td>
                                                             <td>${value.bargasht}</td>
                                                             <td>${value.order_finally_price}</td>
                                                             <td>${value.paid_amount}</td>
                                                             <td>${value.maande_amount}</td>
                                                             <td>${value.total_mali_status}</td>
                                                             <td id="paymentlist" data-orderid="${value.id}"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#paymentlistmodal">اطلاعات پرداخت</button></td>
                                                             <td class="tamdidrequest" data-orderid="${value.id}"><button type="button" class="btn btn-primary btn-sm">درخواست تمدید</button></td>
                                                          </tr>
                                                     `);

                        $.each(data.allpaytypes, function(key, value) {
                            $('.paymentlistmodaltable tbody').append(`
                                                                        <tr style="font-size:14px;">
                                                                             <td scope="row">${parseInt(key)+1}</td>
                                                                             <td>${value[key]}</td>
                                                                            <td id="paymentTypes_${value[key]}"></td>
                                                                        </tr>
                                                                    `);
                        });

                        $.each(value, function(key, val) {
                            $(`.paymentlistmodaltable tbody #paymentTypes_${key}`).html(`
                                                                        ${key} : ${val}
                                                                    `);
                        });

                    });

                    $('#tamdidy').removeClass('d-none');
                },
                error: function (request, status, error)
                {
                    console.log(request.responseText);
                }
            });
        });
        //========================================= user selected from dropdown end ===============





































































































    </script>
<?php $__env->stopSection(); ?>
<style>

    #timeTable{
        height: 448.719px;
    }

    .select2 {
        width: 100% !important;
    }

    @media (min-width: 992px) {
        .taheHeight {
            height: 565px;
        }
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
    .select2-container{
        text-align: right;
    }
</style>



<?php if($ismoshtari && !$ispersonel): ?>  

    <?php if(\Illuminate\Support\Facades\Auth::id() == $userid): ?>

        <?php if($maande > 0): ?>
            
            
            <?php $__env->startSection('content'); ?>
                <div class="container card mt-5">
                    <h4 class="alert-danger p-2" style="margin-top: 200px">رزرو های قبلی هنوز تسویه نشده اند.</h4>
                </div>
            <?php $__env->stopSection(); ?>

        <?php else: ?>

            <?php if($allactiveordersforthisspecificuser): ?>

                
                <?php if($maande>0): ?>

                    <?php $__env->startSection('content'); ?>
                        <div class="container card mt-5">
                            <h4 class="alert-danger p-2" style="margin-top: 200px">رزرو های قبلی هنوز تسویه نشده اند.</h4>
                        </div>
                    <?php $__env->stopSection(); ?>

                <?php else: ?>

                    <?php $__env->startSection('content'); ?>

                            <!-- START: Breadcrumbs-->
                            <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
                                <div class="col-12  align-self-center">
                                    <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                                                <li class="breadcrumb-item" style="background: #d0e7ff"><a href="<?php echo e(route('admin')); ?>">داشبورد</a></li>
                                                <li class="breadcrumb-item" style="background: #d0e7ff"><a class="text-danger" href="<?php echo e(route('tamdidform')); ?>">تمدید رزرو</a></li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Breadcrumbs-->

                            <!-- tamdid table-->
                            <div class="container card border-top row  tamdidy mb-4 d-none" style="background-color: gainsboro;margin: 5em auto;">
                                <table class="table table-striped" id="tamdidTable">
                                    <thead>
                                        <tr style="font-size: 12px;font-weight: bold;">
                                            <th>تخت</th>
                                            <th>تاریخ شروع</th>
                                            <th>تاریخ پایان</th>
                                            <th>مبلغ کل</th>
                                            <th>بدهکار</th>
                                            <th>وضعیت پرداخت</th>
                                            <th>جزییات پرداخت</th>
                                            <th>درخواست تمدید</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <!-- START: Form-->
                            <form method="post" action="<?php echo e(route('customstore')); ?>" id="submit" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input id="raft" name="raft" class="d-none" value="<?php echo e($order->bargasht); ?>">
                                <input id="bargasht" name="bargasht" class="d-none" value="">
                                <input id="mounth" name="mounth" class="d-none" value="">
                                <input id="reservetype" name="reservetype" class="d-none" value="<?php echo e($order->reservetype_id); ?>">
                                <input id="takht_id" name="takht_id" class="d-none" value="<?php echo e($order->takht_id); ?>">
                                <input id="user_id" name="user_id" class="d-none" value="<?php echo e($order->user_id); ?>">
                                <input id="days" name="days" class="d-none" value="<?php echo e($order->days); ?>">
                                <input id="mounth" name="mounth" class="d-none" value="<?php echo e($order->month); ?>">
                                <input id="permounth" name="permounth" class="d-none" value="<?php echo e($order->permounth); ?>">
                            </form>


                            
                            <div class="modal fade" id="paymentlistmodal" tabindex="-1" role="dialog" aria-labelledby="paymentlistmodal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="paymentlistmodal">لیست پرداختی های این سفارش</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="paymentlistmodalbody">
                                            <table class="table table-striped paymentlistmodaltable">
                                                <thead>
                                                <tr style="font-size: 12px;font-weight: bold;">
                                                    <th scope="col">شماره</th>
                                                    <th scope="col">روش پرداخت</th>
                                                    <th scope="col">مبلغ پرداخت شده</th>
                                                    <th scope="col">تاریخ پرداخت</th>
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

                    <?php $__env->stopSection(); ?>
                <?php endif; ?>

            <?php else: ?>
                <?php $__env->startSection('content'); ?>
                    <!-- START: Breadcrumbs-->
                    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
                        <div class="col-12  align-self-center">
                            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="<?php echo e(route('admin')); ?>">داشبورد</a></li>
                                        <li class="breadcrumb-item" style="background: #d0e7ff"><a class="text-danger" href="<?php echo e(route('movereserve')); ?>">تمدید رزرو</a></li>
                                    </ol>
                                </nav>

                            </div>
                        </div>
                    </div>
                    <!-- END: Breadcrumbs-->
                    <div class="container card" style="margin-top: 330px;margin-bottom:100px;background-color: gainsboro">
                        <h4 class="alert-danger p-2">رزرو فعالی برای تمدید وجود ندارد</h4>
                    </div>
                <?php $__env->stopSection(); ?>
            <?php endif; ?>

        <?php endif; ?>

    <?php else: ?> 

        <?php $__env->startSection('content'); ?>
            <!-- START: Breadcrumbs-->
            <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
                <div class="col-12  align-self-center">
                    <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                                <li class="breadcrumb-item" style="background: #d0e7ff"><a href="<?php echo e(route('admin')); ?>">داشبورد</a></li>
                                <li class="breadcrumb-item" style="background: #d0e7ff"><a class="text-danger" href="<?php echo e(route('movereserve')); ?>">تمدید رزرو</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- END: Breadcrumbs-->
            <div class="container card" style="margin-top: 330px;margin-bottom:100px;background-color: gainsboro">
                <h4 class="alert-danger p-2">شما اجازه دسترسی به این آدرس را ندارید.</h4>
            </div>
        <?php $__env->stopSection(); ?>

    <?php endif; ?>
<?php elseif($ispersonel): ?>       

    <?php $__env->startSection('content'); ?>


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
                            <?php if($allusers!='notfound'): ?>
                                <?php $__currentLoopData = $allusers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?> <?php echo e($user->family); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <!-- tamdid table-->
        <div class="container card border-top row  mb-4 d-none" style="background-color: gainsboro;margin: 5em auto;" id="tamdidy">
            <table class="table table-striped" id="tamdidTable">
                <thead>
                    <tr style="font-size: 12px;font-weight: bold;">
                        <th>شماره</th>
                        <th>اطلاعات تخت</th>
                        <th>تاریخ شروع</th>
                        <th>تاریخ پایان</th>
                        <th>مبلغ کل</th>
                        <th>هزینه پرداخت شده</th>
                        <th>مبلغ مانده</th>
                        <th>وضعیت مالی سفارش</th>
                        <th>جزییات پرداخت</th>
                        <th>درخواست تمدید</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <!-- START: Form-->
        <form method="post" action="<?php echo e(route('customstore')); ?>" id="submit" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

        </form>


        
        <div class="modal fade" id="paymentlistmodal" tabindex="-1" role="dialog" aria-labelledby="paymentlistmodal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentlistmodal">لیست پرداختی های این سفارش</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="paymentlistmodalbody">
                        <table class="table table-striped paymentlistmodaltable">
                            <thead>
                                <tr style="font-size: 12px;font-weight: bold;">
                                    <th scope="col">شماره</th>
                                    <th scope="col">روش پرداخت</th>
                                    <th scope="col">مبلغ پرداخت شده</th>
                                    <th scope="col">تاریخ پرداخت</th>
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


    <?php $__env->stopSection(); ?>


<?php endif; ?>



<?php echo $__env->make('admin.master.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pansion3\resources\views/admin/customs/tamdid2.blade.php ENDPATH**/ ?>