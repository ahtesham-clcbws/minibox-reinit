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
                            <a type="button" class="btn btn-primary" href="<?= route_to('admin_film_zine_add') ?>">
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
                    <th>Topic</th>
                    <th>Media</th>
                    <th>Featured</th>
                    <th class="text-end"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($AllNews as $key => $news) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col">
                            <span><?= $key + 1 ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= $news['title'] ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= $news['type_name'] ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= $news['topic_name'] ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= ucfirst($news['media_type']) ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span class="badge badge-dot bg-<?= $news['featured'] ? 'success' : 'danger' ?>"><?= $news['featured'] ? 'Featured' : 'No' ?></span>
                        </td>
                        <td class="nk-tb-col nk-tb-col-tools" style="min-width:70px;padding:0;">
                            <a href="<?= route_to('admin_film_zine_update', $news['id']) ?>" class="btn btn-round btn-icon btn-sm btn-info"><em class="icon ni ni-edit"></em></a>
                            <button type="button" onclick="deleteData(<?= $news['id'] ?>)" class="btn btn-round btn-icon btn-sm btn-danger"><em class="icon ni ni-trash"></em></button>
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
    async function deleteData(id) {
        alert('', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    deleteData: id
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
    // statusSwitch
    $('.statusSwitch').on('click', function() {
        var dataId = $(this).attr('data_id');
        var data_status = $(this).attr('data_status');
        var formData = {
            id: dataId,
            status: data_status == '0' ? '1' : '0',
            changeStatus: true
        };
        console.log(formData)
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
                        alert('', 'Status updated.', 'info').then(() => {
                            // location.reload()
                            if (data_status == 0) {
                                $(this).attr('checked', 'checked');
                            } else {
                                $(this).removeAttr('checked');
                            }
                        })
                    } else {
                        alert(data.message, 'Warning', 'warning').then(() => {
                            location.reload();
                        })
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
    });
</script>
<?= $this->endSection() ?>