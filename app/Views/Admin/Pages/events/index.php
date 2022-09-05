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
                            <a type="button" class="btn btn-primary" href="<?= route_to('admin_event_add') ?>">
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
                    <th>Title</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>State</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                    <th class="text-end"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $key => $event) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col">
                            <span><?= $key + 1 ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= $event['title'] ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <?php if ($event['type'] == 'festival') : ?>
                                <span><?= $event['festival_name'] ?></span>
                            <?php else : ?>
                                <span>Global</span>
                            <?php endif; ?>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= $event['categoryName'] ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= $event['stateName'] ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= date('d M, Y', strtotime($event['from_date'])) ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= date('d M, Y', strtotime($event['to_date'])) ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <?php if (strtotime($event['from_date']) > strtotime(date('Y-m-d'))) {
                                echo 'Future';
                            } ?>
                            <?php if (strtotime($event['from_date']) < strtotime(date('Y-m-d')) && strtotime($event['to_date']) > strtotime(date('Y-m-d'))) {
                                echo 'Ongoing';
                            } ?>
                            <?php if (strtotime($event['to_date']) < strtotime(date('Y-m-d'))) {
                                echo 'Expired';
                            } ?>
                        </td>
                        <td class="nk-tb-col text-end" style="min-width:70px;padding:0;">
                            <a type="button" href="<?= route_to('admin_event_update', $event['id']) ?>" class="btn btn-round btn-icon btn-sm btn-info"><em class="icon ni ni-edit"></em></a>
                            <button type="button" onclick="deleteEvent(<?= $event['id'] ?>)" class="btn btn-round btn-icon btn-sm btn-danger"><em class="icon ni ni-trash"></em></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    async function deleteEvent(id) {
        alert('', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    deleteEvent: id
                };
                $.ajax({
                    url: '',
                    type: 'post',
                    data: formData,
                    success: function(response, textStatus, jqXHR) {
                        console.log(response);
                        var data = {};
                        try {
                            data = JSON.parse(response);
                            if (data.success == true) {
                                alert('', 'Deleted!', 'info').then(() => {
                                    location.reload()
                                })
                            } else {
                                alert(data.message, 'Error', 'error');
                            }
                        } catch (e) {
                            console.log(e);
                            alert('Undefined error, please try after some time.', 'Error', 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Server error', 'Error', 'error');
                    },
                })
            } else {
                alert('You saved a day.', 'Good choice!', 'success')
            }
        })
    }
</script>
<?= $this->endSection() ?>