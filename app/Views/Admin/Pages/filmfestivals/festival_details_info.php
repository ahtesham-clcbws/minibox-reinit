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
                <a class="back-to" href="<?= route_to('admin_festival_details', $festival['id']) ?>">
                    <em class="icon ni ni-arrow-left"></em>
                    <span>Festivals</span>
                </a>
            </div>
        </div>
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub">
                <h3 class="nk-block-title page-title">
                    <?= '<span id="festivalTitlePrefixOld">' . $year_data['prefix'] . '</span>' . ' - ' . $pagename . ' - ' . '<span id="festivalTitleYearOld">' . $year_data['year'] . '</span>' ?>
                </h3>
            </div>
        </div>
    </div>
</div>

<input type="text" style="display: none;" value="<?= $year_data['venue_title'] ? $year_data['venue_title'] : '' ?>" id="venueTitleOld">
<input type="text" style="display: none;" value="<?= $year_data['venue_description'] ? $year_data['venue_description'] : '' ?>" id="venueDescriptionOld">

<div class="row pb-3 border-bottom">
    <div class="col-md-3">
        <h5>Festival Yearly Logo</h5>
        <form class="venue_image rounded" id="festivalLogoForm" enctype="multipart/form-data">
            <img src="<?= !empty($year_data['logo']) ? $year_data['logo'] : '/public/images/placeholder2.jpg' ?>" class="rounded w-100" id="festivalLogoImage">
            <div class="form-control-wrap pb-2">
                <div class="form-file">
                    <input type="file" class="form-file-input" id="logoFile" name="logo" required>
                    <label class="form-file-label" for="logoFile">Choose Logo</label>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-9">
        <div class="row ps-3 pb-3">
            <div class="col-12 mb-2">
                <h5>Venue Details</h5>
            </div>
            <div class="col-md-4">
                <form class="venue_image rounded" id="venueImageUploadForm">
                    <img src="<?= $year_data['venue_image'] ?>" class="rounded w-100" id="venueImageImg">
                    <em class="icon ni ni-camera-fill customIcon cameraIcon" title="Change Image" onclick="clickCameraImage()"></em>
                    <input type="file" name="venue_image" id="venueImageInput" style="display: none;" onchange="previewImage(event, 'venueImageImg'); saveImage()">
                </form>
            </div>
            <div class="col-md-8">
                <span id="venueTitleSpan">
                    <h4>
                        <span id="venueTitleText"><?= $year_data['venue_title'] ? $year_data['venue_title'] : '<span class="text-lead">Title Here</span>' ?></span>
                        <em class="icon ni ni-edit customIcon titleIcon" onclick="openediter('venueTitle')" title="edit title"></em>
                    </h4>
                </span>
                <div class="form-control-wrap" id="venueTitleDiv">
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= $year_data['venue_title'] ? $year_data['venue_title'] : 'Title Here' ?>" id="venueTitleInput" placeholder="Venue title" name="venue_title">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary btn-dim" onclick="saveData('venueTitle')">Save</button>
                            <button class="btn btn-outline-danger" onclick="closesEditer('venueTitle')">Cancel</button>
                        </div>
                    </div>
                </div>

                <br />
                <span id="venueDescriptionSpan">
                    <span id="venueDescriptionText"><?= $year_data['venue_description'] ? $year_data['venue_description'] : '' ?></span>
                    <em class="icon ni ni-edit customIcon descriptionIcon" onclick="openediter('venueDescription')" title="edit description"></em>
                </span>
                <div class="form-control-wrap" id="venueDescriptionDiv">
                    <div class="input-group">
                        <textarea class="form-control" name="venue_description" id="venueDescriptionInput"><?= $year_data['venue_description'] ? $year_data['venue_description'] : '' ?></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary btn-dim" onclick="saveData('venueDescription')">Save</button>
                            <button class="btn btn-outline-danger" onclick="closesEditer('venueDescription')">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row pt-3 pb-3 border-bottom">
    <div class="col-12 mb-2 text-center">
        <h5>PDF's</h5>
    </div>
    <div class="col-md-4 text-center">
        <b>Schedule PDF</b><br />
        <div class="btn-group">
            <?php if ($year_data['schedule_pdf']) : ?>
                <a type="button" class="btn btn-success" target="_blank" href="<?= $year_data['schedule_pdf'] ?>">
                    <em class="icon ni ni-link"></em><span>View</span>
                </a>
                <button type="button" class="btn btn-danger" onclick="deletePdf(<?= $year_data['id'] ?>, '<?= $year_data['schedule_pdf'] ?>', 'schedule_pdf')">
                    <em class="icon ni ni-trash"></em><span>Delete</span>
                </button>
            <?php else : ?>
                <span class="text-danger fw-bold pdfNotPresent">Please upload pdf here</span>
            <?php endif; ?>
        </div>
        <form class="form-group text-start mt-2" method="post" enctype="multipart/form-data" id="schedule_form">
            <div class="form-control-wrap">
                <div class="form-file">
                    <input type="file" class="form-file-input customFile" onchange="uploadPdf(event, 'schedule')" id="schedule_pdf" name="schedule_pdf" accept="application/pdf">
                    <label class="form-file-label" for="schedule_pdf"><?= $year_data['schedule_pdf'] ? 'Change ' : 'Upload ' ?>Schedule pdf</label>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4 text-center">
        <b>Winners PDF</b><br />
        <div class="btn-group">
            <?php if ($year_data['winners_pdf']) : ?>
                <a type="button" class="btn btn-success" target="_blank" href="<?= $year_data['winners_pdf'] ?>">
                    <em class="icon ni ni-link"></em><span>View</span>
                </a>
                <button type="button" class="btn btn-danger" onclick="deletePdf(<?= $year_data['id'] ?>, '<?= $year_data['winners_pdf'] ?>', 'winners_pdf')">
                    <em class="icon ni ni-trash"></em><span>Delete</span>
                </button>
            <?php else : ?>
                <span class="text-danger fw-bold pdfNotPresent">Please upload pdf here</span>
            <?php endif; ?>
        </div>
        <form class="form-group text-start mt-2" method="post" enctype="multipart/form-data" id="winners_form">
            <div class="form-control-wrap">
                <div class="form-file">
                    <input type="file" class="form-file-input customFile" onchange="uploadPdf(event, 'winners')" id="winners_pdf" name="winners_pdf" accept="application/pdf">
                    <label class="form-file-label" for="winners_pdf"><?= $year_data['winners_pdf'] ? 'Change ' : 'Upload ' ?> Winners pdf</label>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4 text-center">
        <b>Official Selection PDF</b><br />
        <div class="btn-group">
            <?php if ($year_data['official_selection_pdf']) : ?>
                <a type="button" class="btn btn-success" target="_blank" href="<?= $year_data['official_selection_pdf'] ?>">
                    <em class="icon ni ni-link"></em><span>View</span>
                </a>
                <button type="button" class="btn btn-danger" onclick="deletePdf(<?= $year_data['id'] ?>, '<?= $year_data['official_selection_pdf'] ?>', 'official_selection_pdf')">
                    <em class="icon ni ni-trash"></em><span>Delete</span>
                </button>
            <?php else : ?>
                <span class="text-danger fw-bold pdfNotPresent">Please upload pdf here</span>
            <?php endif; ?>
        </div>
        <form class="form-group text-start mt-2" method="post" enctype="multipart/form-data" id="official_selection_form">
            <div class="form-control-wrap">
                <div class="form-file">
                    <input type="file" class="form-file-input customFile" onchange="uploadPdf(event, 'official_selection')" id="official_selection_pdf" name="official_selection_pdf" accept="application/pdf">
                    <label class="form-file-label" for="official_selection_pdf"><?= $year_data['official_selection_pdf'] ? 'Change ' : 'Upload ' ?> Official Selection pdf</label>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row pt-3 pb-3 border-bottom">
    <div class="col-12 mb-4 text-center">
        <h5>Deadlines <small>(Year-Month-Day)</small></h5>
    </div>
    <div class="col-12 row">

        <div class="col-lg-3 col-md-3 col-sm-6 mb-2">
            <div class="form-control-wrap">
                <h5 class="form-label" for="early_deadline">Early deadline</h5>
                <div class="input-group">
                    <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?= $year_data['early_deadline'] ?>" placeholder="Early deadline" id="early_deadline" name="early_deadline" required>
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
                    <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?= $year_data['regular_deadline'] ?>" placeholder="Regular deadline" id="regular_deadline" name="regular_deadline" required>
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
                    <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?= $year_data['late_deadline'] ?>" placeholder="Late deadline" id="late_deadline" name="late_deadline" required>
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
                    <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?= $year_data['extended_deadline'] ?>" placeholder="Extended deadline" id="extended_deadline" name="extended_deadline" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary btn-dim" onclick="saveDeadline('extended')">Save</button>
                    </div>
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
        <?php if (count($year_data['film_types'])) : ?>
            <div class="row">
                <?php foreach ($year_data['filmtypes'] as $key => $filmType) : ?>
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
            <input type="text" style="display:none;" id="year_data_id" name="id" value="<?= $year_data['id'] ?>" required>
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
<?php if ($year_data['status'] == 0) : ?>
    <footerbar>
        <div class="text-center">
            <b><?= $festival['name'] ?></b> not activated. please go back to activate the festival from <a class="text-warning" href="<?= route_to('admin_festival_details', $festival['id']) ?>">Here</a>
        </div>
    </footerbar>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $('#addFestivalNewYear').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('addYear', 'true')
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
                    if (data.success == true) {
                        alert('', 'Festival added.', 'info').then(() => {
                            location.reload();
                        });
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
    });

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
        var text = $('#' + dataIdPart + 'Text');

        var oldData = $('#' + dataIdPart + 'Old');

        console.log(input.val());
        console.log(input.attr('name'));
        var festivalData = {
            dataId: "<?= $year_data['id'] ?>",
            columnName: input.attr('name'),
            columnValue: input.val(),
            updateData: 'true'
        };
        if (oldData.val() != input.val()) {
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
                                oldData.val(input.val());
                                text.html(input.val());
                                closesEditer(dataIdPart);
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
        } else {
            alert('', 'No new data found for saving', 'info');
        }

    }

    function saveImage() {
        var formData = new FormData($('#venueImageUploadForm')[0]);
        formData.append('venueImageUpload', 'true');
        formData.append('id', '<?= $year_data['id'] ?>');
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
                    if (data.success == true) {
                        alert('', 'Image uploaded.', 'info');
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

    function clickCameraImage() {
        $('#venueImageInput').click();
    }

    function uploadPdf(event, dataId) {
        $('#' + dataId + '_form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            formData.append('id', '<?= $year_data['id'] ?>');
            formData.append('columnName', dataId + '_pdf');
            formData.append('pdfUpload', 'true');
            formData.append('dataId', dataId);
            // return;
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
                        if (data.success == true) {
                            alert('', 'PDF uploaded successfully.', 'info').then(() => {
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
        $('#' + dataId + '_form').submit();
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
            dataId: "<?= $year_data['id'] ?>",
            columnName: realId,
            columnValue: inputElm.val(),
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
                            // oldData.val(input.val());
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

        <?php if (count($year_data['film_types'])) : ?>
            <?php $yearsDataFilmTypes =  json_encode($year_data['film_types']) ?>
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