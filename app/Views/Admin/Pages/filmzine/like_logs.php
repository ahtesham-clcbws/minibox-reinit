<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
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
                    <th>Title</th>
                    <th>Like/Dislike</th>
                    <th>User IP</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allLikeLogs as $key => $like) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $like['title'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?php if ($like['like']) : ?>
                                <span class="badge badge-dot bg-success">Liked</span>
                            <?php else : ?>
                                <span class="badge badge-dot bg-danger">Dislike</span>
                            <?php endif; ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $like['user_ip'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= date('d F, Y', strtotime($like['created_at'])) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>