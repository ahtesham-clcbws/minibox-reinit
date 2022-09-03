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

    #award_id,
    #titleDiv,
    #contentDiv {
        display: none;
    }

    #awardsListRow .btn-group>.btn {
        display: inline-block !important;
    }

    #awardsListRow .btn-group>.btn:first-child {
        border-top-left-radius: 0;
    }

    #awardsListRow .btn-group>.btn:last-child {
        border-top-right-radius: 0;
    }

    #awardsListRow .card-body {
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

<div class="row">
    <div class="col-12 pb-3 border-bottom mb-3">
        <span id="titleSpan">
            <h4>
                <em class="icon ni ni-edit customIcon titleIcon" onclick="openediter('title')" title="edit title"></em>
                <span id="titleText"><?= $pagedata['title'] ?></span>
            </h4>
        </span>
        <div class="form-control-wrap" id="titleDiv">
            <div class="input-group">
                <input type="text" class="form-control" value="<?= $pagedata['title'] ?>" id="titleInput" placeholder="Page title" name="title">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim" onclick="saveData('title')">Save</button>
                    <button class="btn btn-outline-danger" onclick="closesEditer('title')">Cancel</button>
                </div>
            </div>
        </div>

        <br />
        <span id="contentSpan">
            <em class="icon ni ni-edit customIcon" onclick="openediter('content')" title="edit description"></em>
            <span id="contentText"><?= $pagedata['content'] ?></span>
        </span>
        <div class="form-control-wrap" id="contentDiv">
            <div class="input-group">
                <textarea class="tinymce-basic form-control" name="content" id="contentInput"><?= $pagedata['content'] ?></textarea>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim" onclick="saveData('content')">Save</button>
                    <button class="btn btn-outline-danger" onclick="closesEditer('content')">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="awardsListRow">
    <?php if (count($festivalAwards)) : ?>
        <div class="col-12 text-end mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAward">Add Award</button>
        </div>
        <?php foreach ($festivalAwards as $key => $award) : ?>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="card card-bordered mb-2">
                    <img src="<?= $award['image'] ? $award['image'] : '/public/images/placeholder.jpg' ?>" class="card-img-top">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= $award['title'] ? $award['title'] : '' ?></h5>
                        <p class="card-text"><?= $award['content'] ? $award['content'] : '' ?></p>
                    </div>
                    <div class="card-footer border-top p-0 text-center">
                        <div class="btn-group w-100 text-center">
                            <button type="button" class="btn btn-dim btn-primary" onclick="editAward(<?= $award['id'] ?>,'<?= $award['image'] ?>','<?= $award['title'] ?>','<?= $award['content'] ?>')">Edit</button>
                            <button type="button" class="btn btn-dim btn-danger" onclick="deleteAward(<?= $award['id'] ?>,'<?= $award['image'] ?>')">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="col-12 text-center text-white bg-danger border-rounded" style="padding:50px 0">
            <h3>No awards found, please add some.</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAward">Add Award</button>
        </div>
    <?php endif; ?>


</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addAward">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <form class="row" method="post" enctype="multipart/form-data" id="addAwardForm">
                    <input id="award_id" value="0" name="id">
                    <div class="col-md-6">
                        <div style="position: relative;">
                            <img src="/public/images/placeholder.jpg" class="rounded w-100" id="imageImg">
                            <em class="icon ni ni-camera-fill customIcon cameraIcon" title="Change Image" onclick="$('#imageInput').click()"></em>
                            <input type="file" name="image" id="imageInput" style="display: none;" onchange="previewImage(event, 'imageImg')">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="award_title">Award Name/Title</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="award_title" name="title" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="award_description">Description</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="award_description" name="content" required></textarea>
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
    var addAward = document.getElementById('addAward')
    addAward.addEventListener('hidden.bs.modal', function(event) {
        $('#imageImg').attr('src', '/public/images/placeholder.jpg');
        $('#award_id').val(0);
        $('#award_title').val('');
        $('#award_description').val('');
    })

    function openediter(dataIdPart) {
        var span = $('#' + dataIdPart + 'Span');
        var div = $('#' + dataIdPart + 'Div');

        span.hide();
        div.show();
    }

    function closesEditer(dataIdPart) {
        var span = $('#' + dataIdPart + 'Span');
        var div = $('#' + dataIdPart + 'Div');

        span.show();
        div.hide();
    }

    function saveData(dataIdPart, reload = false) {
        var input = $('#' + dataIdPart + 'Input');
        var text = $('#' + dataIdPart + 'Text');

        console.log(input.val());
        console.log(input.attr('name'));
        var festivalData = {
            dataId: "<?= $pageId ?>",
            columnName: input.attr('name'),
            columnValue: input.val(),
            updateData: 'true'
        };
        // console.log(festivalData);
        $.ajax({
            url: '',
            type: 'post',
            data: festivalData,
            success: function(response, textStatus, jqXHR) {
                console.log(response);
                var data = {};
                try {
                    data = JSON.parse(response);
                    if (data.success == true) {
                        alert('', 'Data updated.', 'info').then(() => {
                            if (<?= intval($pageId) ?> == 0 || reload) {
                                location.reload();
                            } else {
                                text.html(input.val());
                                closesEditer(dataIdPart);
                            }
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
    }

    function editAward(id, image, title, content) {
        $('#award_id').val(id);
        $('#imageImg').attr('src', image);
        $('#award_title').val(title);
        $('#award_description').val(content);

        modalShow('addAward');
    }

    $('#addAwardForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('addUpdateAward', 'true');
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

    function deleteAward(id, image) {
        var formData = {
            id: id,
            image: image,
            deleteFestivalAward: 'true'
        };
        Swal.fire({
            title: 'Are you sure you want to delete this award?',
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