<meta name="csrf_token" content="<?php echo e(csrf_token()); ?>">
<style>
    .knsl-top-bar{
        top: 0px;
    }
</style>
<?php $__env->startSection('content'); ?>

<form method="POST" action="<?php echo e(route('post.login')); ?>">
    <?php echo csrf_field(); ?>
    <div class="container text-center" style="margin-top: 90px">
        <div class="row mt-5 p-5" style="border: 1px solid #727576">
            <div class="col-12 text-center">
                <h2>ورود مشتری</h2>

                
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
                <div class="mb-4 ">
                    <label class="form-label mb-2 w-50 m-auto py-3" for="signin-email" style="text-align: right">شماره تماس</label>
                    <input class="form-control justnumber mobileInput w-50 m-auto" name="mobilecode" id="signin-mobilecode"
                           placeholder="شماره تماس خود را وارد کنید" required autocomplete="off">
                </div>

                <div class="mb-4 ">
                    <label class="form-label mb-0 w-50 m-auto py-3" for="signin-password" style="text-align: right">رمز عبور</label>
                    <input class="form-control w-50 m-auto" name="password" type="password" id="signin-password"
                           placeholder="پسوورد خود را وارد کنید" autocomplete="off" required>
                </div>

                <div class="mb-4">
                    <div class="form-label mb-0 w-50 m-auto py-3" style="text-align: right">
                        <a class="fs-sm mt-1" href="<?php echo e(route('password.request')); ?>">رمز عبور خود را فراموش کرده اید؟</a>
                    </div>
                    <div class="form-label mb-0 w-50 m-auto py-3" style="text-align: right">
                        <a href="<?php echo e(route('register')); ?>" class="link-accent">ثبت نام</a>
                    </div>
                </div>

                <button class="btn btn-primary w-25" type="submit">ورود به حساب کاربری</button>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>






<?php echo $__env->make('store.master.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pansion_fatemepc\resources\views/store/auth/login.blade.php ENDPATH**/ ?>