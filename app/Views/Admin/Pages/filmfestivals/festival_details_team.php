<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<style>
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
                        <span>Add Team Member</span>
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
                    <th>Member</th>
                    <th>Profession</th>
                    <th>About</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($festivalTeamMembers as $key => $member) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                        <td class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                    <img src="<?= $member['image'] ?>" width="45">
                                </div>
                                <div class="user-info">
                                    <span class="tb-lead"><?= $member['first_name'] . ' ' . $member['last_name'] ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $member['profession'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $member['about'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <button class="btn btn-sm btn-icon btn-primary" onclick="editData(<?= $member['id'] ?>, '<?= $member['first_name'] ?>', '<?= $member['last_name'] ?>', '<?= $member['profession'] ?>', '<?= $member['about'] ?>','<?= $member['image'] ?>')"><em class="icon ni ni-edit"></em></button>
                            <button class="btn btn-sm btn-icon btn-danger btnDelete" onclick="deleteMember(<?= $member['id'] ?>, '<?= $member['image'] ?>')"><em class="icon ni ni-trash"></em></button>
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
                    <div class="col-md-4">
                        <div style="position: relative;">
                            <img src="/public/images/placeholder.jpg" class="rounded w-100" id="imageImg">
                            <em class="icon ni ni-camera-fill customIcon cameraIcon" title="Change Image" onclick="$('#imageInput').click()"></em>
                            <input type="file" name="image" id="imageInput" style="display: none;" onchange="previewImage(event, 'imageImg')">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label" for="full_name">Full Name</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" required>
                                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="profession">Profession</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="profession" name="profession" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="about">About</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="about" name="about" required></textarea>
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
            <b><?= $festival['name']
                ?></b> not activated. please go back to activate the festival from <a class="text-warning" href="<?= route_to('admin_festival_details', $festival['id']) ?>">Here</a>
        </div>
    </footerbar>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    var modalDefault = document.getElementById('modalDefault')
    modalDefault.addEventListener('hidden.bs.modal', function(event) {
        $('#imageImg').attr('src', '/public/images/placeholder.jpg');
        $('#data_id').val(0);
        $('#imageInput').val('');
        $('#first_name').val('');
        $('#last_name').val('');
        $('#profession').val('');
        $('#about').val('');
    });

    $('#addForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('addUpdateTeam', 'true');
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

    function editData(id, firstName, lastName, profession, about, image) {
        $('#imageImg').attr('src', image);
        $('#data_id').val(id);
        $('#first_name').val(firstName);
        $('#last_name').val(lastName);
        $('#profession').val(profession);
        $('#about').val(about);

        modalShow('modalDefault');
    }

    function deleteMember(id, image) {
        var formData = {
            id: id,
            image: image,
            deleteMember: 'true'
        };
        Swal.fire({
            title: 'Are you sure you want to delete this member?',
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