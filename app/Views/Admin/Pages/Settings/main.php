<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <?= view('Admin/Components/goToDashboard') ?>
            <h3 class="nk-block-title page-title"><?= isset($pagename) && $pagename ? $pagename : 'Settings' ?></h3>
        </div>
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card card-bordered card-preview">
    <div class="card-inner row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
            <div class="card text-white bg-primary">
                <a href="<?= route_to('admin_settings_homepage_banners') ?>" class="card-inner text-center">
                    <h4>Home Banners</h4>
                    <h1><em class="ni ni-img"></em></h1>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
            <div class="card text-white bg-primary">
                <a href="<?= route_to('admin_settings_homepage_filmzine') ?>" class="card-inner text-center">
                    <h4>Home FilmZine</h4>
                    <h1><em class="ni ni-property"></em></h1>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
            <div class="card text-white bg-primary">
                <a href="<?= route_to('admin_settings_testimonials') ?>" class="card-inner text-center">
                    <h4>Testimonials</h4>
                    <h1><em class="ni ni-comments"></em></h1>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
            <div class="card text-white bg-primary">
                <a href="<?= route_to('admin_settings_support_forms') ?>" class="card-inner text-center">
                    <h4>Support Form</h4>
                    <h1><em class="ni ni-headphone"></em></h1>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
            <div class="card text-white bg-primary">
                <a href="<?= route_to('admin_settings_festival_awards') ?>" class="card-inner text-center">
                    <h4>Awards</h4>
                    <h1><em class="ni ni-award"></em></h1>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
            <div class="card text-white bg-primary">
                <a href="<?= route_to('admin_settings_film_types') ?>" class="card-inner text-center">
                    <h4>Film Types</h4>
                    <h1><em class="ni ni-video"></em></h1>
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<?= $this->endSection() ?>