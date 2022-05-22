
<meta name="csrf_token" content="<?php echo e(csrf_token()); ?>">
<style>
    .knsl-top-bar{
        top: 0px;
    }
    .select2-container .select2-selection--single{
        height: 50px!important;

    }
    .select2-container--default .select2-selection--single{
        border: 1px solid #ced4da!important;
    }
</style>
<?php $__env->startSection('content'); ?>

<div class="container text-center" style="margin-top: 90px">
    <div class="row mt-5 p-5" style="border: 1px solid #727576">
        <div class="col-12 text-center">
            <h2>دریافت کد تایید شماره همراه</h2>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger mt-4">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-12 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5 text-center">
            
            <div class="mb-4 col-12 col-lg-4 row mt-5" style=" text-align: center;margin:auto">
                <form method="POST"  action="<?php echo e(route('check.verifycode')); ?>" >
                    <?php echo csrf_field(); ?>
                        <div class="input-group">
                            <input class="form-control justnumber  m-auto" name="active_code" id="signin_active_code"
                                   placeholder="کد تایید در این بخش وارد شود" required autocomplete="off" style="font-size:12px;">
                            <input type="hidden" value="<?php echo e($user_id); ?>" id="user_id" name="user_id">
                            <div class="input-group-prepend" id="getVerificationCode">
                                <div class="input-group-text btn" id="counter" style="font-size:12px;">دریافت کد تایید</div>
                            </div>
                        </div>
                    <button class="btn btn-primary mt-3" id="send_verify_code" type="submit">ثبت کد تایید</button>
                </form>
            </div>

        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('store.master.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pansion_fatemepc\resources\views/store/auth/confirmMobile.blade.php ENDPATH**/ ?>