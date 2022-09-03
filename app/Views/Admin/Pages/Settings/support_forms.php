<?= $this->extend('Admin/Layout') ?>

<?= $this->section('content') ?>
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub"><a class="back-to" href="<?= route_to('admin_settings') ?>"><em class="icon ni ni-arrow-left"></em><span>Main Settings</span></a></div>
            <h3 class="nk-block-title page-title"><?= isset($pagename) && $pagename ? $pagename : 'Settings' ?></h3>
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
                    <th>Message</th>
                    <th>Entity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($forms as $key => $form) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                        <td class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-info">
                                    <span class="tb-lead"><?= $form['name'] ?></span>
                                    <span><?= $form['email'] ?></span>
                                    <span><?= $form['mobile'] ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $form['subject'] ?><br />
                            <?= $form['message'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $form['entity_data'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
