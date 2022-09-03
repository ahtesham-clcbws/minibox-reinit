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

    #venueTitleDiv,
    #venueDescriptionDiv {
        display: none;
    }

    .pdfNotPresent {
        line-height: 36px;
    }

    .film_type_awards:not(:last-child)::after {
        content: " | ";
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub">
                <a class="back-to" href="<?= route_to('admin_film_festivals', $festival['id']) ?>">
                    <em class="icon ni ni-arrow-left"></em>
                    <span>All Festivals</span>
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

<div class="row pb-3 border-bottom align-bottom">
    <div class="col-md-3 align-bottom h-100">
        <!-- <h5>Festival Yearly Logo</h5> -->
        <form class="venue_image rounded" id="festivalLogoForm" enctype="multipart/form-data">
            <img src="<?= !empty($festival['logo']) ? $festival['logo'] : '/public/images/placeholder2.jpg' ?>" class="rounded w-100" id="festivalLogoImage">
            <div class="form-control-wrap pt-2 pb-2">
                <div class="form-file">
                    <input type="file" class="form-file-input" id="logoFile" name="logo" required>
                    <label class="form-file-label" for="logoFile">Choose Logo</label>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-3 align-bottom h-100">
        <div class="form-control-wrap">
            <h5 class="mb-4" for="titleInput">Festival Title</h5>
            <div class="input-group mt-2 pt-2">
                <input type="text" maxlength="200" class="form-control" value="<?= $festival['title'] ?>" placeholder="Festival Year" id="titleInput" name="title" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim" onclick="saveData('title')">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 align-bottom h-100">
        <div class="form-control-wrap">
            <h5 class="mb-4" for="editionInput">Edition</h5>
            <div class="input-group mt-2 pt-2">
                <input type="number" class="form-control" value="<?= $festival['edition'] ?>" placeholder="Festival Edition" id="editionInput" name="edition" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim" onclick="saveData('edition')">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 align-bottom h-100">
        <div class="form-control-wrap">
            <h5 class="mb-4" for="current_yearInput">Current Year</h5>
            <div class="input-group mt-2 pt-2">
                <input type="number" class="form-control" value="<?= $festival['current_year'] ?>" placeholder="Festival Year" id="current_yearInput" name="current_year" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim" onclick="saveData('current_year')">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row pt-3 pb-3 border-bottom">
    <div class="col-12 mb-4 text-center">
        <h5>Deadlines <small>(Year-Month-Day)</small></h5>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 mb-2">
        <div class="form-control-wrap">
            <h5 class="form-label" for="early_deadline">Early deadline</h5>
            <div class="input-group">
                <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?= $festival['early_deadline'] ?>" placeholder="Early deadline" id="early_deadline" name="early_deadline" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim" onclick="saveDeadline('early')">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 mb-2">
        <div class="form-control-wrap">
            <h5 class="form-label" for="regular_deadline">Regular deadline</h5>
            <div class="input-group">
                <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?= $festival['regular_deadline'] ?>" placeholder="Regular deadline" id="regular_deadline" name="regular_deadline" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim" onclick="saveDeadline('regular')">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 mb-2">
        <div class="form-control-wrap">
            <h5 class="form-label" for="late_deadline">Late deadline</h5>
            <div class="input-group">
                <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?= $festival['late_deadline'] ?>" placeholder="Late deadline" id="late_deadline" name="late_deadline" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim" onclick="saveDeadline('late')">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 mb-2">
        <div class="form-control-wrap">
            <h5 class="form-label" for="extended_deadline">Extended deadline</h5>
            <div class="input-group">
                <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?= $festival['extended_deadline'] ?>" placeholder="Extended deadline" id="extended_deadline" name="extended_deadline" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim" onclick="saveDeadline('extended')">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row pt-3 pb-3 border-bottom mb-5">
    <div class="col-12 mb-2 text-center">
        <h5>
            Film Types
            <em class="icon ni ni-edit customIcon" title="Edit Film Types" onclick="openChangeFilmType()"></em>
        </h5>
    </div>
    <div class="col-12">
        <?php if (count($festival['film_types'])) : ?>
            <div class="row">
                <?php foreach ($festival['filmtypes'] as $key => $filmType) : ?>
                    <div class="col-12 mb-3">
                        <h6><?= $filmType['name'] ?></h6>
                        <?php foreach ($filmType['awards'] as $key => $award) {
                            echo '<span class="film_type_awards">' . $award['name'] . ' <b>(' . $award['sn'] . ')</b>' . '</span>';
                        } ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="w-100 text-center">
                <h5 class="text-danger">You dont have film type, please add here</h5>
                <button class="btn btn-primary" onclick="openChangeFilmType()">Add Film Type</button>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade zoom" id="addEditFilmType">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="addEditFilmTypeForm" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Film Types</h5>
            </div>
            <input type="text" style="display:none;" id="festival_id" name="id" value="<?= $festival['id'] ?>" required>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="form-control-wrap" id="award_ids_category">
                                <?php foreach ($allFilmTypes as $key => $filmType) : ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input award_id_checkbox" type="checkbox" name="film_types[]" id="inlineCheckbox<?= $filmType['id'] ?>" value="<?= $filmType['id'] ?>">
                                        <label class="form-check-label" for="inlineCheckbox<?= $filmType['id'] ?>"><?= $filmType['name'] ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
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

    function saveData(dataIdPart) {
        var input = $('#' + dataIdPart + 'Input');
        // var text = $('#' + dataIdPart + 'Text');

        var festivalData = {
            columnName: input.attr('name'),
            columnValue: input.val(),
            updateData: 'true'
        };
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
                            // text.html(input.val());
                            // closesEditer(dataIdPart);
                            // location.reload()
                            // if (data_status == 0) {
                            //     $(this).attr('checked', 'checked');
                            // } else {
                            //     $(this).removeAttr('checked');
                            // }
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

    function deletePdf(dataId, filePath, columnId) {
        alert('This action will not revert back, as it will delete the PDF file.', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    id: dataId,
                    filePath: filePath,
                    columnId: columnId,
                    deletePdf: true
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
                                alert('', 'PDF Deleted!', 'info').then(() => {
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

    function saveDeadline(id) {
        var realId = id + '_deadline';
        var inputElm = $('#' + realId);
        var festivalData = {
            columnName: realId,
            columnValue: inputElm.val(),
            updateData: 'true'
        };
        console.log(festivalData);
        // return;
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
                            // text.html(input.val());
                            // closesEditer(dataIdPart);
                            // location.reload()
                            // if (data_status == 0) {
                            //     $(this).attr('checked', 'checked');
                            // } else {
                            //     $(this).removeAttr('checked');
                            // }
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

    var addEditFilmType = document.getElementById('addEditFilmType')
    addEditFilmType.addEventListener('hidden.bs.modal', function(event) {});

    function openChangeFilmType() {

        <?php if (count($festival['film_types'])) : ?>
            <?php $yearsDataFilmTypes =  json_encode($festival['film_types']) ?>
            filmTypesIds = JSON.parse('<?= $yearsDataFilmTypes ?>');
            // console.log(filmTypesIds);
            filmTypesIds.forEach(id => {
                $('#inlineCheckbox' + id).attr('checked', 'checked')
            });
        <?php endif; ?>
        modalShow('addEditFilmType');
    }

    $('#addEditFilmTypeForm').submit(function(e) {
        e.preventDefault();

        var formData = new FormData($(this)[0]);

        var formArray = Array.from(formData);

        // console.log(formArray);
        formData.append('addEditFilmTypes', 'true');

        if (!formData.has('film_types[]')) {
            formData.append('film_types', '[]');
        }
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
                        alert('', 'Film Types Updated successfully.', 'info').then(() => {
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
    //logo
    $('#logoFile').change(function(event) {
        var output = document.getElementById('festivalLogoImage');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
        $('#festivalLogoForm').submit();
    })
    $('#festivalLogoForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('saveLogo', 'true');
        // console.log(Array.from(formData));

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
                        alert('', 'Logo Changed.', 'info').then(() => {
                            // location.reload()
                        })
                    } else {
                        alert(data.message, 'Warning', 'warning').then(() => {
                            // location.reload();
                            $('#festivalLogoImage').attr('src', placeholder2);
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
    })
</script>
<?= $this->endSection() ?>