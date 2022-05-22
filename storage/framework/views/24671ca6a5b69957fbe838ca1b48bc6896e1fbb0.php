<!-- counters -->
<style>
    .knsl-features-card:after{
        content: none;
    }
</style>
<section class="" style="background-color: #ECFAFB">

    <div class="container">

        <!-- features card -->
        <div class="knsl-features-card knsl-counters-card knsl-scroll-animation">

            <div class="row">
                <div class="col-6 col-lg-3">

                    <!-- icon box -->
                    <div class="knsl-icon-box">
                        <div class="knsl-counter-number knsl-mb-10" data-count="<?php echo e($pansions!='notfound'?count($pansions):0); ?>"></div>
                        <h5>خوابگاه</h5>
                    </div>
                    <!-- icon box end -->

                </div>
                <div class="col-6 col-lg-3">

                    <!-- icon box -->
                    <div class="knsl-icon-box">
                        <div class="knsl-counter-number knsl-mb-10" data-count="<?php echo e($countRoom); ?>"></div>
                        <h5>اتاق</h5>
                    </div>
                    <!-- icon box end -->

                </div>
                <div class="col-6 col-lg-3">

                    <!-- icon box -->
                    <div class="knsl-icon-box">
                        <div class="knsl-counter-number knsl-mb-10" data-count="<?php echo e($countTakht); ?>"></div>
                        <h5>تخت</h5>
                    </div>
                    <!-- icon box end -->

                </div>
                <div class="col-6 col-lg-3">

                    <!-- icon box -->
                    <div class="knsl-icon-box">
                        <div class="knsl-counter-number knsl-mb-10" data-count="<?php echo e($countMoshtari); ?>"></div>
                        <h5>مهمان</h5>
                    </div>
                    <!-- icon box end -->

                </div>
            </div>

        </div>
        <!-- features card end -->

    </div>
</section>
<!-- counters end -->
<?php /**PATH C:\xampp\htdocs\pansion_fatemepc\resources\views/store/master/amar.blade.php ENDPATH**/ ?>