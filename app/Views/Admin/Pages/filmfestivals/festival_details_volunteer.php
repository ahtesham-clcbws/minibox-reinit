<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<style>
    .venue_image {
        position: relative;
    }

    .customIcon {
        cursor: pointer;
        background-color: #fff;
        border-radius: 50%;
        padding: 7px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
    }

    .customIcon:hover {
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    }

    .cameraIcon {
        position: absolute;
        top: 2px;
        left: 2px;
    }

    #venueTitleDiv,
    #venueDescriptionDiv {
        display: none;
    }

    .pdfNotPresent {
        line-height: 36px;
    }

    .film_type_awards:not(:last-child)::after {
        content: " | ";
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub">
                <a class="back-to" href="<?= route_to('admin_festival_details', $festival['id']) ?>">
                    <em class="icon ni ni-arrow-left"></em>
                    <span>Festivals</span>
                </a>
            </div>
        </div>
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub">
                <h3 class="nk-block-title page-title">
                    <?= $pagename ?>
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="card card-bordered card-preview">
    <div class="card-inner">
        <table class="datatable-init table nk-tb-list nk-tb-ulist">
            <thead>
                <tr>
                    <th></th>
                    <th>Volunteer</th>
                    <th>Contacts</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($volunteers as $key => $member) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                        <td class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-info">
                                    <span class="tb-lead"><?= $member['name'] ?></span>
                                    <span><?= $member['email'] ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $member['whatsapp'] ?><br />
                            <?= $member['mobile'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $member['address'] ?>,<br/>
                            <?= $member['pin'] ?>, <?= $member['city'] ?>, <?= $member['state'] ?>, <?= $member['country'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if ($festival['status'] == 0) : ?>
    <footerbar>
        <div class="text-center">
            <b><?= $festival['name'] ?></b> not activated. please go back to activate the festival from <a class="text-warning" href="<?= route_to('admin_festival_details', $festival['id']) ?>">Here</a>
        </div>
    </footerbar>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<?= $this->endSection() ?>