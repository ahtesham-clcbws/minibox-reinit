<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <?= view('Admin/Components/goToDashboard') ?>
            <h3 class="nk-block-title page-title"><?= isset($pagename) && $pagename ? $pagename : 'Dashboard' ?></h3>
        </div>
    </div>
</div>
<div class="card card-bordered card-preview">
    <div class="card-inner">
        <table class="datatable-init table nk-tb-list nk-tb-ulist">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Events</th>
                    <th class="text-end"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
