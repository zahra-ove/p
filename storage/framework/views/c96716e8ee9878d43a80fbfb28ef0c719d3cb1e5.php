
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
            <h2>ثبت نام مشتری</h2>

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

        <form method="POST" action="<?php echo e(route('post.register')); ?>" class="mt-5">
            <?php echo csrf_field(); ?>
            <div class="row text-center mt-5">
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-name">نام</label>
                <input class="form-control" name="name" type="text" id="signup-name"
                       placeholder="نام خود را وارد کنید" value="<?php echo e(old('name')); ?>" required>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-name">نام خانوادگی</label>
                <input class="form-control" name="family" type="text" id="signup-family"
                       placeholder="نام خانوادگی خود را وارد کنید" value="<?php echo e(old('family')); ?>" required>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-name">شماره موبایل</label>
                <input class="form-control justnumber mobileInput" name="mobilecode" type="text" id="signup-mobile"
                       placeholder="09121234567" value="<?php echo e(old('mobilecode')); ?>" required>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-name">کد ملی</label>
                <input class="form-control justnumber" name="ncode" type="text" id="signup-ncode"
                       placeholder="کد ملی خود را وارد کنید" value="<?php echo e(old('ncode')); ?>" required>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-name">شهر</label>
                <div>
                    <select id="selecetCityRegister" class="form-control select2" style="color:#908f95;;height: 50px" name="city_id">
                        <option style="color:black"> شهر خود را انتخاب کنید. </option>
                        <?php if($cities!='notfound'): ?>
                            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city->id); ?>" style="color:black" <?php echo e(old('city_id') == $city->id ? "selected" : ""); ?>><?php echo e($city->cityName); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-email">پست الکترونیکی</label>
                <input class="form-control" name="email" type="email" id="signup-email"
                       placeholder="ایمیل خود را وارد کنید"   required>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-email">تاریخ تولد</label>
                <input class="form-control" name="birthday" id="signup-birthday"
                       placeholder="__/__/____" value="<?php echo e(old('birthday')); ?>" required>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-password">رمز عبور <span
                        class='fs-sm text-muted'>حداقل 8 کاراکتر</span></label>
                <div class="password-toggle">
                    <input class="form-control" name="password" type="password" id="signup-password"
                           minlength="8" required>
                </div>
            </div>
            <div class="mb-4 col-12 col-lg-4 mt-5" style=" text-align: right;">
                <label class="form-label" for="signup-password-confirm">تایید رمز عبور</label>
                <div class="password-toggle">
                    <input class="form-control" type="password" name="password_confirmation" id="signup-password-confirm"
                           minlength="8" required>
                </div>
            </div>
            <div class="mb-4 col-12 col-lg-4 row mt-5" style=" text-align: right;">
                <label class="form-label col-12 mb-2" for="signup-password-confirm">جنسیت</label>
                <div class="col-md-6 row">
                    <div class="col-4">
                        <label for="gender">مرد</label>
                    </div>
                    <div class="col-6">
                        <input id="gender" type="radio"
                               class="<?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               name="gender" required
                               value="male" style="height: auto" checked>
                    </div>
                </div>
                <div class="col-md-6 row">
                    <div class="col-4">
                        <label for="gender">زن</label>
                    </div>
                    <div class="col-6">
                        <input id="gender" type="radio"
                               class="<?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> h-auto"
                               name="gender" style="height: auto" required
                               value="female">
                    </div>
                </div>

            </div>

            <div class="form-check mb-4 col-12 mt-5" style=" text-align: right;">
                <input class="form-check-input" style="height: auto" type="checkbox" id="agree-to-terms" required>
                <label class="form-check-label" for="agree-to-terms"> با ثبت نام در این سایت <a
                        href='#'> شرایط</a> و <a href='#'>قوانین </a> سایت را قبول دارم.</label>
            </div>
            </div>
            <input class="btn btn-primary w-25" type="submit" value="ثبت نام" >
        </form>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('store.master.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pansion3\resources\views/store/auth/register.blade.php ENDPATH**/ ?>