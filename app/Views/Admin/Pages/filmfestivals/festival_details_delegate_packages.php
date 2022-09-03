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

    #data_id {
        display: none;
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDefault">
                        <em class="icon ni ni-plus"></em>
                        <span>Add Package</span>
                    </button>
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
                    <th>Details</th>
                    <th>Fee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allPackages as $key => $package) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $package['details'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= number_to_currency($package['fee_inr'], 'INR', 'en_US', 2) ?><br />
                            <?= number_to_currency($package['fee_eur'], 'EUR', 'en_US', 2) ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <button class="btn btn-sm btn-icon btn-primary" onclick="editData(<?= $package['id'] ?>, '<?= $package['details'] ?>', '<?= $package['fee_inr'] ?>', '<?= $package['fee_eur'] ?>')"><em class="icon ni ni-edit"></em></button>
                            <button class="btn btn-sm btn-icon btn-danger btnDelete" onclick="deleteData(<?= $package['id'] ?>)"><em class="icon ni ni-trash"></em></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modalDefault">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <form class="row" method="post" enctype="multipart/form-data" id="addForm">
                    <input id="data_id" value="0" name="id">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label" for="package_details">Package Details</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <textarea class="form-control" name="details" id="package_details" placeholder="Proper package details" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="fee_inr">Fee (INR)</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="fee_inr" name="fee_inr" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="fee_eur">Fee (EUR)</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="fee_eur" name="fee_eur" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-end pt-3">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
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
<script>
    var modalDefault = document.getElementById('modalDefault');

    modalDefault.addEventListener('hidden.bs.modal', function(event) {
        $('#data_id').val(0);
        $('#package_details').val('');
        $('#fee_inr').val('');
        $('#fee_eur').val('');
    });

    function editData(id, details, fee_inr, fee_eur) {
        $('#data_id').val(id);
        $('#package_details').val(details);
        $('#fee_inr').val(fee_inr);
        $('#fee_eur').val(fee_eur);

        modalShow('modalDefault');
    }

    $('#addForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('addUpdate', 'true');
        console.log(Array.from(formData));
        // return;
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
                    if (data.success == true) {
                        alert('', data.message, 'info').then(() => {
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
                alert('Server error', 'Error', 'error');
            },
        })
    })

    function deleteData(id) {
        var formData = {
            id: id,
            deleteData: 'true'
        };
        Swal.fire({
            title: 'Are you sure you want to delete this package?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Save',
        }).then((result) => {
            if (result.isConfirmed) {
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
                                alert('', data.message, 'info').then(() => {
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
                        alert('Server error', 'Error', 'error');
                    },
                })
            } else {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }
</script>
<?= $this->endSection() ?>