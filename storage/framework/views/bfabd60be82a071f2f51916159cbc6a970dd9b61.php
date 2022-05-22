<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>شرکت بوم گردی دریاگشت</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="<?php echo e(csrf_token()); ?>">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="">

    <!-- CSS
    ========================= -->

    <?php echo $__env->make("admin.master.mastercss", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <style>
        * { margin: 0; padding: 0; outline: 0; }
        body{line-height: 1;}
        .select2-selection{

            min-height: 38px!important;

        }
        .breadcrumb-item.active{
            color: red!important;
        }
        @media  print {
            .position-fixed{
                display: none;
            }
        }
        <?php echo $__env->make('admin.master.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </style>
</head>

<body id="#main" dir="rtl">
<?php if(\Illuminate\Support\Facades\Auth::check()): ?>
<?php echo $__env->make('admin.master.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.master.maincontent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if(\Illuminate\Support\Facades\Auth::user()->group()->where('group_id',3)->exists()): ?>
    <?php if($user_mande_hesab): ?>
        <div class="position-fixed card w-100 py-2 px-4" style="text-align: left;bottom: 0">
            <div class="row mx-0 py-2" style="border-top: 1px solid #aaaaaa">
                <div class="col-lg-6"></div>
                <div class="col-lg-5 col-12 row">
                    <div class="col-6 order-2"> <a href="#" class="btn btn-lg btn-success w-50">تسویه</a> </div>
                    <div class="col-lg-6 col-12 row order-1" style="font-size: 18px">
                        <?php if($user_mande_hesab < 0): ?>
                            <div class="col-lg-4 col-6 pt-2">بستانکار: </div>
                            <div class="col-lg-8 col-6 pt-2"><?php echo e($user_mande_hesab); ?> تومان </div>
                        <?php elseif($user_mande_hesab > 0): ?>
                            <div class="col-lg-4 col-6 pt-2">بدهکار: </div>
                            <div class="col-lg-8 col-6 pt-2"><?php echo e($user_mande_hesab); ?> تومان </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php echo $__env->make("admin.master.masterjs", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make("admin.master.js", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php echo app('toastr')->render(); ?>
<?php echo $__env->yieldContent('tabjs'); ?>
<?php else: ?>
    <div class="container-fluid text-center position-relative h-100" style="margin-top: 300px">
        <div class="knsl-404 text-warning" style="top: 50%;left: 35%;font-size: 100px">خطای دسترسی</div>
        <p class="alert-danger" style="top: 50%;left: 35%">امکان دسترسی برای به این صفحه با این حساب مجاز نیست.</p>
        <a class="btn btn-success btn-lg" href="<?php echo e(asset('')); ?>" style="border-radius: 25px;">بازگشت به خانه</a>
    </div>
<?php endif; ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\pansion_fatemepc\resources\views/admin/master/home.blade.php ENDPATH**/ ?>