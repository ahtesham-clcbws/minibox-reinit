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

    #jury_id,
    #data_id {
        display: none;
    }

    #uploadedImages div {
        position: relative;
    }

    .deleteGalleryImage {
        cursor: pointer;
        padding: 3px;
        background: #b9b9b9;
        font-size: 20px;
        border-radius: 50%;
        position: absolute;
        top: 2px;
        left: 10px;
        color: #fff;
        background-color: red;
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
                        <span>Add Jury</span>
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
                    <th>Jury</th>
                    <th>Year</th>
                    <th>About</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($juryMembers as $key => $member) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                        <td class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                    <img src="<?= $member['image'] ?>" width="45" height="45">
                                </div>
                                <div class="user-info">
                                    <span class="tb-lead"><?= $member['first_name'] . ' ' . $member['last_name'] ?></span>
                                    <span><?= $member['profession'] ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $member['festival_year'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $member['about'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-icon btn-success" onclick="openGallery(<?= $member['id'] ?>)"><em class="icon ni ni-img"></em></button>
                                <button class="btn btn-sm btn-icon btn-primary" onclick="editData(<?= $member['id'] ?>)"><em class="icon ni ni-edit"></em></button>
                                <button class="btn btn-sm btn-icon btn-danger btnDelete" onclick="deleteMember(<?= $member['id'] ?>, '<?= $member['image'] ?>')"><em class="icon ni ni-trash"></em></button>
                            </div>
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

                        <div class="form-group mt-2">
                            <label class="form-label" for="about">About</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="about" name="about" required></textarea>
                            </div>
                        </div>
                        <!-- <div class="form-group mt-2">
                            <label class="form-label" for="social_details">
                                Social Media <small>(optional)</small>
                            </label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-primary btn-dim">
                                            <em class="ni ni-facebook-f"></em>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Facebook">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary btn-dim">
                                            <em class="ni ni-twitter"></em>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control" name="twitter" id="twitter" placeholder="Twitter">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-danger btn-dim">
                                            <em class="ni ni-instagram"></em>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control" name="instagram" id="instagram" placeholder="Instagram" required>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-success btn-dim">
                                            <em class="ni ni-whatsapp"></em>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control" name="whatsapp" id="whatsapp" placeholder="WhatsApp" required>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label" for="festival_year">Festival Year</label>
                            <div class="form-control-wrap">
                                <input type="number" maxlength="4" minlength="4" max="<?= $festival['current_year'] ?>" value="<?= $festival['current_year'] ?>" class="form-control" id="festival_year" name="festival_year" required>
                            </div>
                        </div>
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
                            <label class="form-label" for="video">Video <small>(Only vimeo & youtube links)</small></label>
                            <div class="form-control-wrap">
                                <input type="url" class="form-control" id="video" name="video">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-1 pt-1 border-top">
                        <label class="form-label" for="details_page">Details page content</label>
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title of the content" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="content" name="content" placeholder="Content here" required></textarea>
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
<div class="modal fade" tabindex="-1" role="dialog" id="galleryModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <form class="row" method="post" enctype="multipart/form-data" id="galeryForm">
                    <input id="jury_id" value="0" name="id">
                    <h4>Jury Gallery</h4>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="customMultipleFilesLabel">Select files to upload multiple</label>
                            <div class="form-control-wrap">
                                <div class="form-file">
                                    <input type="file" multiple class="form-file-input" name="galleryImages[]" id="galleryInput">
                                    <label class="form-file-label" for="galleryInput">Choose files</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 row" id="uploadedImages">

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
        $('#festival_year').val('');
        $('#first_name').val('');
        $('#last_name').val('');
        $('#profession').val('');
        $('#about').val('');

        $('#title').val('');
        $('#content').val('');
        $('#video').val('');

        // $('#facebook').val('');
        // $('#whatsapp').val('');
        // $('#twitter').val('');
        // $('#instagram').val('');
    });
    var galleryModal = document.getElementById('galleryModal')
    galleryModal.addEventListener('hidden.bs.modal', function(event) {
        $('#jury_id').val(0);
        $('#galleryInput').val('');
        // $('#uploadedImages').html('');
    });
    $('#addForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('appUpdateJury', 'true');
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

    function editData(id) {
        var formData = {
            id: id,
            getJury: 'true'
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
                        var jury = data.data;
                        $('#imageImg').attr('src', jury.image);
                        $('#data_id').val(id);
                        $('#festival_year').val(jury.festival_year);
                        $('#first_name').val(jury.first_name);
                        $('#last_name').val(jury.last_name);
                        $('#profession').val(jury.profession);
                        $('#about').val(jury.about);

                        $('#title').val(jury.title);
                        $('#content').val(jury.content);
                        $('#video').val(jury.video);

                        // $('#facebook').val(jury.facebook);
                        // $('#twitter').val(jury.twitter);
                        // $('#instagram').val(jury.instagram);
                        // $('#whatsapp').val(jury.whatsapp);

                        modalShow('modalDefault');
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

    function openGallery(id) {
        $('#jury_id').val(id);
        var formData = {
            jury_id: id,
            getJuryGallery: 'true'
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
                        // alert('', data.message, 'info').then(() => {
                        // location.reload();
                        var imagesUploaded = data.data;
                        imagesUploaded.forEach(gallery => {
                            createImageElementAjax(gallery.image, gallery.id);
                        });
                        // initFunctionsAgain()
                        // })
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
        modalShow('galleryModal');
    }

    var uploadingImages;
    var uploadedImages = document.getElementById('uploadedImages');

    $('#galleryInput').change(function(e) {
        uploadingImages = e.target.files;
        $('#galeryForm').submit();
    });
    $('#galeryForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('addJuryGallery', 'true');
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
                            // location.reload();
                            var imagesUploaded = data.data;
                            imagesUploaded.forEach(index => {
                                var imageFile = uploadingImages[index.key];
                                createImageElement(imageFile, index.id);
                            });
                            $('#galeryForm')[0].reset();
                            // initFunctionsAgain();
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

    function createImageElementAjax(imageFile, id) {
        var output = document.createElement('img');
        output.src = imageFile;
        var COL = document.createElement('div');
        COL.classList.add('col-md-3');
        COL.classList.add('pt-2');
        COL.appendChild(output);

        var iconFile = document.createElement('em');
        iconFile.classList.add('ni');
        iconFile.classList.add('ni-trash');
        iconFile.classList.add('deleteGalleryImage');
        iconFile.setAttribute('dataId', id);
        iconFile.setAttribute('onclick', 'deleteGalleryImage(' + id + ')');

        COL.appendChild(iconFile);
        uploadedImages.append(COL);
        // return COL;
    }

    function createImageElement(imageFile, id) {
        var output = document.createElement('img');
        output.src = URL.createObjectURL(imageFile);
        output.onload = function() {
            URL.revokeObjectURL(output.src)
        }
        var COL = document.createElement('div');
        COL.classList.add('col-md-3');
        COL.classList.add('pt-2');
        COL.appendChild(output);
        var iconFile = document.createElement('em');
        iconFile.classList.add('ni');
        iconFile.classList.add('ni-trash');
        iconFile.classList.add('deleteGalleryImage');
        iconFile.setAttribute('dataId', id);
        iconFile.setAttribute('onclick', 'deleteGalleryImage(' + id + ')');
        COL.appendChild(iconFile);
        uploadedImages.append(COL);
        // return COL;
    }

    function deleteGalleryImage(id) {
        var formData = {
            id: id,
            deleteGalleryImage: 'true'
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
                        alert('', data.message, 'info').then(() => {
                            // location.reload();
                            $("[dataId='" + id + "']").parent().remove();
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
</script>
<?= $this->endSection() ?>