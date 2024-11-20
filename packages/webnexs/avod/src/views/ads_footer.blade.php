<footer class="iq-footer">
    <div class="container-fluid p-5">
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="<?= URL::to('resources\views\admin\dashtheme\privacy-policy.html') ?>">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="<?= URL::to('resources\views\admin\dashtheme\terms-of-service.html') ?>">Terms of Use</a></li>
                </ul>
            </div>
            <div class="col-lg-6 text-right">
                 <?= GetWebsiteName()."&nbsp;". '<i class="ri-copyright-line"></i>' ."&nbsp;". Carbon\Carbon::now()->year ."&nbsp;&nbsp;". (__('All Rights Reserved')); ?> 
            </div>
        </div>
    </div>
 </footer>
 