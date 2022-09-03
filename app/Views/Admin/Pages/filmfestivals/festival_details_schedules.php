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

    .cardIcon {
        position: absolute;
        top: 5px;
        right: 5px;
    }

    .cardIcon.deleteIcon {
        left: 5px;
        color: red;
    }

    .cameraIcon {
        position: absolute;
        top: 2px;
        left: 2px;
    }

    #schedulesListRow .btn-group>.btn {
        display: inline-block !important;
    }

    #schedulesListRow .btn-group>.btn:first-child {
        border-top-left-radius: 0;
    }

    #schedulesListRow .btn-group>.btn:last-child {
        border-top-right-radius: 0;
    }

    #schedulesListRow .card-body {
        padding: 0.75rem 0.5rem;
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

<div class="row" id="schedulesListRow">
    <?php if (count($festivalSchedules)) : ?>
        <div class="col-12 text-end mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSchedule">Add Schedule</button>
        </div>
        <?php foreach ($festivalSchedules as $key => $schedule) : ?>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="card card-bordered mb-2">
                    <img src="<?= $schedule['image'] ? $schedule['image'] : '/public/images/placeholder.jpg' ?>" class="card-img-top">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= $schedule['festival_year'] ?></h5>
                        <h6 class="card-title"><?= $schedule['title'] ? $schedule['title'] : '' ?></h6>
                        <?= $schedule['content'] ? '<p class="card-text">' . $schedule['content'] . '</p>' : '' ?>
                    </div>
                    <div class="card-footer border-top p-0 text-center">
                        <div class="btn-group w-100 text-center">
                            <a target="_blank" href="<?= $schedule['pdf'] ?>" type="button" class="btn btn-primary">PDF</a>
                            <button type="button" class="btn btn-warning" onclick="editSchedule(<?= $schedule['id'] ?>,<?= $schedule['festival_year'] ?>,'<?= $schedule['pdf'] ?>','<?= $schedule['image'] ?>','<?= $schedule['title'] ?>','<?= $schedule['content'] ?>')">Edit</button>
                            <button type="button" class="btn btn-danger" onclick="deleteSchedule(<?= $schedule['id'] ?>,'<?= $schedule['pdf'] ?>','<?= $schedule['image'] ?>')">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="col-12 text-center text-white bg-danger border-rounded" style="padding:50px 0">
            <h3>No Schedules found, please add some.</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSchedule">Add Schedule</button>
        </div>
    <?php endif; ?>


</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addSchedule">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <form class="row" method="post" enctype="multipart/form-data" id="addScheduleForm">
                    <input id="schedule_id" value="0" name="id" style="display: none;">
                    <div class="col-md-6">
                        <div style="position: relative;">
                            <img src="/public/images/placeholder.jpg" class="rounded w-100" id="imageImg">
                            <em class="icon ni ni-camera-fill customIcon cameraIcon" title="Change Image" onclick="$('#imageInput').click()"></em>
                            <input type="file" name="image" id="imageInput" style="display: none;" onchange="previewImage(event, 'imageImg')">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="festival_year">Schedule Year</label>
                            <div class="form-control-wrap">
                                <input type="number" minlength="4" maxlength="4" max="<?= $festival['current_year'] ?>" value="<?= $festival['current_year'] ?>" class="form-control" id="festival_year" name="festival_year" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="schedule_title">Schedule Name/Title</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="schedule_title" name="title" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="schedulePdf">Schedule PDF</label>
                            <div class="form-control-wrap" id="schedulePdf">
                                <div class="form-file">
                                    <input type="file" class="form-file-input" id="schedule_pdf" name="pdf" accept="application/pdf" required>
                                    <label class="form-file-label" for="schedule_pdf">Choose PDF</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-none">
                            <label class="form-label" for="schedule_description">Description</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="schedule_description" name="content"></textarea>
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
<link rel="stylesheet" href="/public/admin/css/editors/tinymce.css?ver=3.0.0">
<script src="/public/admin/js/libs/editors/tinymce.js?ver=3.0.0"></script>
<script src="/public/admin/js/editors.js?ver=3.0.0"></script>
<script>
    var addSchedule = document.getElementById('addSchedule')
    addSchedule.addEventListener('hidden.bs.modal', function(event) {
        $('#imageImg').attr('src', '/public/images/placeholder.jpg');
        $('#schedule_id').val(0);
        $('#schedule_pdf').val('');
        $('#schedule_pdf').attr('required', 'required');
        $('#schedule_title').val('');
        $('#festival_year').val('');
        $('#schedule_description').val('');
    })

    function editSchedule(id, year, pdf, image, title, content) {
        $('#schedule_id').val(id);
        $('#imageImg').attr('src', image);
        $('#schedule_pdf').removeAttr('required');
        $('#schedule_title').val(title);
        $('#festival_year').val(year);
        $('#schedule_description').val(content);

        modalShow('addSchedule');
    }

    $('#addScheduleForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('addUpdateSchedule', 'true');
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

    function deleteSchedule(id, pdf, image) {
        var formData = {
            id: id,
            image: image,
            pdf: pdf,
            deleteFestivalSchedule: 'true'
        };
        Swal.fire({
            title: 'Are you sure you want to delete this schedule?',
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