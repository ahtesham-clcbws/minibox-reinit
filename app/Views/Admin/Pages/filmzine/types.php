<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
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
                    <th>Festival</th>
                    <th>Years</th>
                    <th>Current</th>
                    <th>Selections</th>
                    <th>Winners</th>
                    <th>Submitions</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($festivals as $key => $festival) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                        <td class="nk-tb-col tb-col-md">
                            <a href="<?= route_to('admin_festival_details', $festival['id']) ?>">
                                <?= $festival['name'] ?>
                            </a>
                        </td>
                        <td class="nk-tb-col tb-col-md"><?= $festival['edition'] ?></td>
                        <td class="nk-tb-col tb-col-md"><?= $festival['current_year'] ?></td>
                        <td class="nk-tb-col tb-col-md">0</td>
                        <td class="nk-tb-col tb-col-md">0</td>

                        <td class="nk-tb-col tb-col-md">0</td>

                        <td class="nk-tb-col tb-col-md">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" data_id="<?= $festival['id'] ?>" data_status="<?= $festival['status'] ?>" class="custom-control-input statusSwitch" <?= $festival['status'] == '1' ? 'checked' : '' ?> id="statusSwitch<?= $festival['id'] ?>">
                                <label class="custom-control-label" for="statusSwitch<?= $festival['id'] ?>"></label>
                            </div>
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
    $('#addFestival').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('festival_add', 'true');
        console.log(Array.from(formData));
        $.ajax({
            url: '',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response, textStatus, jqXHR) {
                console.log(response);
                var data = {};
                try {
                    data = JSON.parse(response);
                    console.log(data);
                    if (data.success == true) {
                        alert('Successfully added/updated festival').then(() => {
                            location.reload();
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
                // console.log(errorThrown);
                // console.log(textStatus);
                // console.log(jqXHR);
                alert('Server error', 'Error', 'error');
            },
        })
    });
    async function deleteFestival(id) {
        alert('This action will not revert back, as it will delete all festival files and content also.', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    id: id,
                    deleteFestival: true
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
                                alert('', 'Festival Deleted!', 'info').then(() => {
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

    // logo changing
</script>
<?= $this->endSection() ?>