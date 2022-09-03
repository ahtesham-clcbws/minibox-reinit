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
        <?php if (session()->get('user.is_dev') == 1) : ?>
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li class="nk-block-tools-opt">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDefault">
                                    <em class="icon ni ni-plus"></em>
                                    <span>Add New</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="card card-bordered card-preview">
    <div class="card-inner">
        <table class="datatable-init-export table nk-tb-list nk-tb-ulist" data-export-title="Export">
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

<?php if (session()->get('user.is_dev') == 1) : ?>
    <div class="modal fade zoom" tabindex="-1" id="modalDefault">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content" id="addFestival" action="" method="post">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Film Festival</h5>
                </div>
                <input type="text" style="display:none;" id="festival_id" name="id" value="0" required>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="festival_name">Festival Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="festival_name" name="name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="festival_status">Status</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2" id="festival_status" name="status" required>
                                        <option value="0">In-Active</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-primary">Save Festival</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<link rel="stylesheet" href="/public/admin/css/editors/tinymce.css?ver=3.0.0">
<script src="/public/admin/js/libs/editors/tinymce.js?ver=3.0.0"></script>
<script src="/public/admin/js/editors.js?ver=3.0.0"></script>
<script src="/public/admin/js/libs/datatable-btns.js?ver=3.0.0"></script>
<script>
    <?php if (session()->get('user.is_dev') == 0) : ?>
        var modalDefault = document.getElementById('modalDefault')
        modalDefault.addEventListener('hidden.bs.modal', function(event) {
            $('#festival_id').val(0);
            $('#festival_name').val('');
        })
        var modal = bootstrap.Modal.getInstance(modalDefault);

        function updateDetails(id = 5, name = 'something', status = '1') {
            modalDefault.show();
        }
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

    <?php endif; ?>
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