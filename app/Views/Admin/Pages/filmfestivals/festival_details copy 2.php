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

    .card+.card:not(.card .card + .card) {
        margin-top: 15px;
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
    <div class="col-12 mb-4">
        <h5>Dates <small>(Year-Month-Day)</small></h5>
    </div>
    <div class="col-md-6 col-12 mb-2">
        <div class="form-control-wrap">
            <h5 class="form-label" for="opening_date">Opening Date</h5>
            <div class="input-group">
                <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?= $festival['opening_date'] ?>" placeholder="Opening Date" id="opening_date" name="opening_date" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim" onclick="saveDate('opening_date')">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 mb-2">
        <div class="form-control-wrap">
            <h5 class="form-label" for="event_date">Event Date</h5>
            <div class="input-group">
                <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?= $festival['event_date'] ?>" placeholder="Event Date" id="event_date" name="event_date" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim" onclick="saveDate('event_date')">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deadlines -->
<div class="row pt-3 pb-3 border-bottom">
    <div class="col-12 mb-4">
        <h5>Deadlines <em class="ni ni-plus-circle customIcon" data-bs-toggle="modal" data-bs-target="#addUpdateDeadline"></em></h5>
    </div>
    <div class="dol-12 mb-4" id="blocksOfDeadlines">
        <?php foreach ($festival['deadlines'] as $deadline) : ?>
            <div class="card shadow" id="deadlineBlock<?= $deadline['id'] ?>">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-5 col-12">
                            <label>Deadline Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="deadlineName<?= $deadline['id'] ?>" value="<?= $deadline['name'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <label>Deadline Date</label>
                            <div class="form-control-wrap">
                                <div class="form-icon form-icon-right">
                                    <em class="icon ni ni-calendar-alt"></em>
                                </div>
                                <input type="text" class="form-control" id="deadlineDate<?= $deadline['id'] ?>" value="<?= date('M d, Y', strtotime($deadline['deadline'])) ?>" disabled>
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="btn-group w-100 mt-3">
                                <button class="btn btn-primary d-block" onclick="editDeadline(<?= $deadline['id'] ?>)">
                                    <em class="ni ni-edit"></em>
                                </button>
                                <button class="btn btn-danger d-block" onclick="deleteDeadline(<?= $deadline['id'] ?>)">
                                    <em class="ni ni-trash"></em>
                                </button>
                            </div>
                        </div>
                        <hr class="mt-2">

                        <div class="col-md-3 col-sm-6 col-12">
                            <label>Student EUR</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">€</span>
                                    </div>
                                    <input type="text" class="form-control" id="deadlineStudentEur<?= $deadline['id'] ?>" value="<?= date('M d, Y', strtotime($deadline['student_eur'])) ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <label>Student INR</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₹</span>
                                    </div>
                                    <input type="text" class="form-control" id="deadlineStudentInr<?= $deadline['id'] ?>" value="<?= date('M d, Y', strtotime($deadline['student_inr'])) ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <label>Professional EUR</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">€</span>
                                    </div>
                                    <input type="text" class="form-control" id="deadlineProfessionalEur<?= $deadline['id'] ?>" value="<?= date('M d, Y', strtotime($deadline['professional_eur'])) ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <label>Professional INR</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₹</span>
                                    </div>
                                    <input type="text" class="form-control" id="deadlineProfessionalInr<?= $deadline['id'] ?>" value="<?= date('M d, Y', strtotime($deadline['professional_inr'])) ?>" disabled>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5 col-12">
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-5 col-12">
                        <div class="form-control-wrap">
                            <div class="form-icon form-icon-right">
                                <em class="icon ni ni-calendar-alt"></em>
                            </div>
                            <input type="text" class="form-control" data-date-format="yyyy-mm-dd" disabled>
                        </div>
                    </div>
                    <div class="col-md-2 col-12">
                        <div class="btn-group w-100">
                            <button class="btn btn-primary d-block">
                                <em class="ni ni-edit"></em>
                            </button>
                            <button class="btn btn-danger d-block">
                                <em class="ni ni-trash"></em>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>

<!-- Film Types -->
<div class="row pt-3 pb-3 border-bottom mb-5">
    <div class="col-12 mb-2 text-center">
        <h5>
            Film Types
            <em class="icon ni ni-edit customIcon" title="Edit Film Types" onclick="openChangeFilmType()"></em>
        </h5>
    </div>
    <?php if (count($festival['film_types'])) : ?>
        <div class="row" id="filmTypesRow">
            <div class="col-md-6">
                <?php foreach ($festival['filmtypes'] as $key => $filmType) : ?>
                    <?php if ($key < $festival['filmTypesCountPart']) : ?>
                        <div class="card shadow">
                            <div class="card-body">
                                <h6><?= $filmType['name'] ?></h6>
                                <?php foreach ($filmType['awards'] as $key => $award) {
                                    echo '<span class="film_type_awards">' . $award['name'] . ' <b>(' . $award['sn'] . ')</b>' . '</span>';
                                } ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="col-md-6">
                <?php foreach ($festival['filmtypes'] as $key => $filmType) : ?>
                    <?php if ($key >= $festival['filmTypesCountPart']) : ?>
                        <div class="card shadow">
                            <div class="card-body">
                                <h6><?= $filmType['name'] ?></h6>
                                <?php foreach ($filmType['awards'] as $key => $award) {
                                    echo '<span class="film_type_awards">' . $award['name'] . ' <b>(' . $award['sn'] . ')</b>' . '</span>';
                                } ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else : ?>
        <div class="col-12">
            <div class="w-100 text-center">
                <h5 class="text-danger">You dont have film type, please add here</h5>
                <button class="btn btn-primary" onclick="openChangeFilmType()">Add Film Type</button>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Festival Awards Pricing -->
<div class="row pt-3 pb-3 mb-5">
    <div class="col-12 mb-2 text-center">
        <h5>Festival Awards Pricing <button class="btn btn-primary" onclick="$('#awardsFormSubmit').click()">Save</button></h5>
    </div>
    <?php if (count($festival['awards'])) : ?>
        <form class="col-12" id="awardsForm">

            <table class="table nk-tb-list nk-tb-ulist table-bordered">
                <thead>
                    <tr>
                        <th>Category & Awards</th>
                        <th class="text-center">Student / Professional</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($festival['awards'] as $key => $award) : ?>
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col tb-col-md" style="max-width:600px;">
                                <b><?= $award['name'] ?> (<?= $award['short_name'] ?>)</b><br />
                                <?php foreach ($award['trophies'] as $trophy) : ?>
                                    <span class="film_type_awards"><?= $trophy['name'] ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <div class="form-control-wrap">
                                    <input type="hidden" name="awardsFormData" value="true">

                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₹</span>
                                        </div>
                                        <input type="number" class="form-control awardsPriceField awardsPriceFieldStudent awardsPriceFieldINR" value="<?= isset($award['prices']) && isset($award['prices']['inr']['student']) ? $award['prices']['inr']['student'] : '' ?>" name="price[<?= $award['short_name'] ?>][inr][student]" placeholder="Student INR" required>

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">/</span>
                                        </div>
                                        <input type="number" class="form-control awardsPriceField awardsPriceFieldProfessinal awardsPriceFieldINR" value="<?= isset($award['prices']) && isset($award['prices']['inr']['professional']) ? $award['prices']['inr']['professional'] : '' ?>" name="price[<?= $award['short_name'] ?>][inr][professional]" placeholder="Professional INR" required>
                                    </div>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">€</span>
                                        </div>
                                        <input type="number" class="form-control awardsPriceField awardsPriceFieldStudent awardsPriceFieldEUR" value="<?= isset($award['prices']) && isset($award['prices']['eur']['student']) ? $award['prices']['eur']['student'] : '' ?>" name="price[<?= $award['short_name'] ?>][eur][student]" placeholder="Student EUR" required>

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">/</span>
                                        </div>
                                        <input type="number" class="form-control awardsPriceField awardsPriceFieldProfessinal awardsPriceFieldEUR" value="<?= isset($award['prices']) && isset($award['prices']['eur']['professional']) ? $award['prices']['eur']['professional'] : '' ?>" name="price[<?= $award['short_name'] ?>][eur][professional]" placeholder="Professional EUR" required>
                                    </div>

                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="text-end">
                <button class="btn btn-primary" type="submit" id="awardsFormSubmit">Save</button>
            </div>
        </form>
    <?php else : ?>
        <div class="col-12">
            <div class="w-100 text-center">
                <h5 class="text-danger">You dont have film type, please add here</h5>
                <button class="btn btn-primary" onclick="openChangeFilmType()">Add Film Type</button>
            </div>
        </div>
    <?php endif; ?>
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

<div class="modal fade zoom" id="addUpdateDeadline">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="deadlineForm" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Deadline</h5>
            </div>
            <input type="text" style="display:none;" id="deadline_id" name="id" value="0">
            <div class="modal-body">

                <div class="form-group">
                    <label class="form-label" for="form_deadline_name">Title/Name</label>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" id="form_deadline_name" name="name" placeholder="Deadline Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="form_deadline">Deadline</label>
                    <div class="form-control-wrap">
                        <div class="form-icon form-icon-right">
                            <em class="icon ni ni-calendar-alt"></em>
                        </div>
                        <input type="text" class="form-control date-picker" id="form_deadline" name="deadline" data-date-start-date="<?= $festival['opening_date'] ?>" data-date-end-date="<?= $festival['event_date'] ?>" data-date-format="yyyy-mm-dd" required>
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
    var addUpdateDeadline = document.getElementById('addUpdateDeadline');
    addUpdateDeadline.addEventListener('hidden.bs.modal', function(event) {
        $('#form_deadline_name').val('');
        $('#form_deadline').val('');
        $('#deadline_id').val(0);
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

    function saveDate(id) {
        var realId = id;
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

    // $('#addDeadline').click(function() {
    //     // createBlock();
    // })

    function createBlock(id, name, date) {
        console.log(id, name, date);
        var dateOptions = {
            day: 'numeric',
            month: 'short',
            year: 'numeric',
        };
        var formatedDate = new Date(date).toLocaleDateString("en-US", dateOptions);
        var oldElement = document.getElementById('deadlineBlock' + id);
        console.log('deadlineBlock' + id);
        if (oldElement) {
            var nameInput = $('#deadlineName' + id).val(name);
            var dateInput = $('#deadlineDate' + id).val(formatedDate);
        } else {
            var blocksOfDeadlines = $('#blocksOfDeadlines');

            var input = createHtmlElement('INPUT', ["form-control"], [{
                name: "type",
                value: "text"
            }, {
                name: "disabled",
                value: "disabled"
            }, {
                name: "id",
                value: "deadlineName" + id
            }]);
            input.value = name;
            var div = createHtmlElement('div', ["form-control-wrap"], [], [input]);
            var column1 = createHtmlElement('div', ["col-md-5", "col-12"], [], [div]);

            var input = createHtmlElement('INPUT', ["form-control"], [{
                name: "type",
                value: "text"
            }, {
                name: "data-date-format",
                value: "yyyy-mm-dd"
            }, {
                name: "disabled",
                value: "disabled"
            }, {
                name: "id",
                value: "deadlineDate" + id
            }]);
            input.value = formatedDate;
            var icon = createHtmlElement('em', ["icon", "ni", "ni-calendar-alt"], []);
            var div = createHtmlElement('div', ["form-icon", "form-icon-right"], [], [icon]);
            var div = createHtmlElement('div', ["form-control-wrap"], [], [div, input]);
            var column2 = createHtmlElement('div', ["col-md-5", "col-12"], [], [div]);

            var icon1 = createHtmlElement('em', ["ni", "ni-edit"], []);
            var button = createHtmlElement('button', ["btn", "btn-primary", "d-block"], [{
                name: 'onclick',
                value: 'editDeadline(' + id + ')'
            }], [icon1]);

            var icon2 = createHtmlElement('em', ["ni", "ni-trash"], []);
            var button2 = createHtmlElement('button', ["btn", "btn-danger", "d-block"], [{
                name: 'onclick',
                value: 'deleteDeadline(' + id + ')'
            }], [icon2]);

            var div = createHtmlElement('div', ["btn-group", "w-100"], [], [button, button2]);
            var column3 = createHtmlElement('div', ["col-md-2", "col-12"], [], [div]);

            var row = createHtmlElement('div', ["row"], [], [column1, column2, column3]);
            var cardBody = createHtmlElement('div', ["card-body"], [], [row]);
            var card = createHtmlElement('div', ["card", "shadow"], [{
                name: "id",
                value: "deadlineBlock" + id
            }], [cardBody]);

            document.getElementById('blocksOfDeadlines').appendChild(card);
        }
    }

    function editDeadline(id) {
        var formData = {
            id: id,
            getDeadline: 'true'
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
                        var deadline = data.data;
                        $('#form_deadline_name').val(deadline.name);
                        $('#form_deadline').val(deadline.deadline);
                        $('#deadline_id').val(deadline.id);
                        modalShow('addUpdateDeadline');
                        // alert('', 'Deadline Saved', 'info').then(() => {
                        //     // location.reload()
                        // })
                    } else {
                        alert(data.message, 'Warning', 'warning').then(() => {
                            // location.reload();
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
    }

    function deleteDeadline(id) {
        var formData = {
            id: id,
            deleteDeadline: 'true'
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
                        alert('', 'Deadline deleted succesfully.', 'info').then(() => {
                            $('#deadlineBlock' + id).remove();
                        })
                    } else {
                        alert(data.message, 'Warning', 'warning').then(() => {})
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

    $('#deadlineForm').submit(function(e) {
        e.preventDefault();
        if ($('#opening_date').val().length === 0) {
            alert('', 'Please add Festival Opening date before adding any deadlines.', 'info');
            return;
        }

        if ($('#event_date').val().length === 0) {
            alert('', 'Please add Festival Event date before adding any deadlines.', 'info');
            return;
        }
        var formData = new FormData($(this)[0]);
        formData.append('saveDeadline', 'true');
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
                        alert('', 'Deadline Saved', 'info').then(() => {
                            var deadline = data.data;
                            console.log(deadline.id, deadline.name, deadline.deadline);
                            createBlock(deadline.id, deadline.name, deadline.deadline);
                            modalClose('addUpdateDeadline');
                        })
                    } else {
                        alert(data.message, 'Warning', 'warning').then(() => {})
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

    $('#awardsForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        console.log(Array.from(formData));

        // var dataOfForms = Array.from(formData);
        // var formData = {
        //     awardsFormData: 'true',
        //     data: dataOfForms
        // };

        // console.log(formData);

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
                        alert('', data.message, 'info').then(() => {
                            // var deadline = data.data;
                            // console.log(deadline.id, deadline.name, deadline.deadline);
                            // createBlock(deadline.id, deadline.name, deadline.deadline);
                            // modalClose('addUpdateDeadline');
                        })
                    } else {
                        alert(data.message, 'Warning', 'warning').then(() => {})
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
    // $('.awardsPriceField').keyup(function(e) {
    //     setTimeout(() => {
    //         $('#awardsForm').submit();
    //     }, 1500);
    // })
</script>

<div class="card shadow d-none">
    <div class="card-body">
        <div class="row">
            <div class="col-md-5 col-12">
                <div class="form-control-wrap">
                    <input type="text" class="form-control" disabled>
                </div>
            </div>
            <div class="col-md-5 col-12">
                <div class="form-control-wrap">
                    <div class="form-icon form-icon-right">
                        <em class="icon ni ni-calendar-alt"></em>
                    </div>
                    <input type="text" class="form-control" data-date-format="yyyy-mm-dd" disabled>
                </div>
            </div>

            <div class="col-md-2 col-12">
                <div class="btn-group w-100">
                    <button class="btn btn-primary d-block">
                        <em class="ni ni-edit"></em>
                    </button>
                    <button class="btn btn-danger d-block">
                        <em class="ni ni-trash"></em>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>