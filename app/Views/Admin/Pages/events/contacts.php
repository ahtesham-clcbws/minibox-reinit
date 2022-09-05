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
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalContact">
                                <em class="icon ni ni-plus"></em>
                                <span>Add New</span>
                            </a>
                        </li>
                    </ul>
                </div>
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>WhatsApp</th>
                    <th class="text-end"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $key => $contact) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col">
                            <span><?= $key + 1 ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= $contact['name'] ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= $contact['email'] ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= $contact['phone'] ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= $contact['whatsapp'] ?></span>
                        </td>
                        <td class="nk-tb-col text-end" style="min-width:70px;padding:0;">
                            <button type="button" onclick="editContact(<?= $contact['id'] ?>, '<?= $contact['name'] ?>', '<?= $contact['email'] ?>', '<?= $contact['phone'] ?>', '<?= $contact['whatsapp'] ?>')" class="btn btn-round btn-icon btn-sm btn-info"><em class="icon ni ni-edit"></em></button>
                            <button type="button" onclick="deleteContact(<?= $contact['id'] ?>)" class="btn btn-round btn-icon btn-sm btn-danger"><em class="icon ni ni-trash"></em></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<?= view('Admin/Pages/events/contacts_component'); ?>
<?= $this->endSection() ?>