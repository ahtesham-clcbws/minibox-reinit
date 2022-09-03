<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<style>
    /* .award_cat_details:not(:first-child) {
        padding-top: 15px;
        margin-top: 15px;
        border-top: 1px solid grey;
    } */

    .award_cat_details {
        position: relative;
        /* margin-bottom: 15px;
        margin-left: 15px; */
    }

    .award_cat_details .edit-icon {
        cursor: pointer;
    }

    .datatableInit .dataTables_wrapper .row.justify-between.g-2 {
        display: none;
    }

    .datatableInit .dataTables_wrapper .datatable-wrap {
        margin-top: 0 !important;
    }

    .customTable {
        width: 100%;
        color: #526484;
        vertical-align: top;
        border-color: #dbdfea;
    }

    .customTable th {
        border-radius: 0 !important;
    }

    .cardAwardCatImage {
        height: 40px;
        width: 40px;
        margin-right: 5px;
    }

    #award_cat_image_img {
        height: 150px;
    }

    .awardTypeBadge:not(:last-child) {
        margin-right: 10px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub"><a class="back-to" href="<?= route_to('admin_settings') ?>"><em class="icon ni ni-arrow-left"></em><span>Main Settings</span></a></div>
            <h3 class="nk-block-title page-title"><?= isset($pagename) && $pagename ? $pagename : 'Festival Awards' ?></h3>
        </div>
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt">
                            <button type="button" class="btn btn-secondary me-3" data-bs-toggle="modal" data-bs-target="#editAwardCat">
                                <em class="icon ni ni-plus"></em>
                                <span>Add Award Category</span>
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAward">
                                <em class="icon ni ni-plus"></em>
                                <span>Add Award</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row g-3">
    <?php foreach ($awardCategories as $key => $award) : ?>
        <div class="col-md-6 col-12">
            <div class="card shadow text-white bg-gray awardCatCard">
                <div class="card-header">
                    <span class="h3"><img src="<?= $award['image'] ? $award['image'] : '/public/images/placeholder.jpg' ?>" class="cardAwardCatImage"><?= $award['name'] ?> <small><small>(<?= $award['short_name'] ?>)</small></small></span>
                    <span class="float-end">
                        <a href="#" class="btn btn-trigger btn-icon text-warning" onclick="openEditAwardCat(<?= $award['id'] ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Award">
                            <em class="icon ni ni-edit"></em>
                        </a>
                        <a href="#" class="btn btn-trigger btn-icon text-danger" onclick="deleteAwardCat(<?= $award['id'] ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Award">
                            <em class="icon ni ni-trash"></em>
                        </a>
                    </span>
                </div>
                <div class="card-inner">
                    <table class="table table-light table-bordered customTable">
                        <thead>
                            <tr>
                                <th class="empty"></th>
                                <th colspan="2" class="headt">Short</th>
                                <th colspan="2" class="headt">Feature</th>
                            </tr>
                            <tr>
                                <th class="empty"></th>
                                <th class="headt">INR</th>
                                <th class="headt">EUR</th>
                                <th class="headt">INR</th>
                                <th class="headt">EUR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="headt">Student</th>
                                <td><?= $award['short_student_inr'] ?></td>
                                <td><?= $award['short_student_eur'] ?></td>
                                <td><?= $award['feature_student_inr'] ?></td>
                                <td><?= $award['feature_student_eur'] ?></td>
                            </tr>
                            <tr>
                                <th class="headt">Professional</th>
                                <td><?= $award['short_professional_inr'] ?></td>
                                <td><?= $award['short_professional_eur'] ?></td>
                                <td><?= $award['feature_professional_inr'] ?></td>
                                <td><?= $award['feature_professional_eur'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="col-12" id="awardsTableColum">
        <div class="card shadow">
            <div class="card-inner">
                <table id="awardsTable" class="nowrap table nk-tb-list nk-tb-ulist">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Award</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allAwards as $key => $award_2) : ?>
                            <tr class="nk-tb-item" id="tableRow<?= $award_2['id'] ?>">
                                <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                                <td class="nk-tb-col tb-col-md" id="dataName<?= $award_2['id'] ?>">
                                    <?= $award_2['name'] ?>
                                </td>
                                <td class="nk-tb-col tb-col-md" id="dataCategory<?= $award_2['id'] ?>">
                                    <?= $award_2['award_category'] ?>
                                </td>
                                <td class=" nk-tb-col tb-col-md">
                                    <span class="badge badge-dot awardTypeBadge bg-<?= $award_2['isShort'] ? 'success' : 'danger' ?>" id="dataIsShort<?= $award_2['id'] ?>">Short</span>
                                    <span class="badge badge-dot awardTypeBadge bg-<?= $award_2['isFeature'] ? 'success' : 'danger' ?>" id="dataIsFeature<?= $award_2['id'] ?>">Feature</span>
                                </td>
                                <td class="nk-tb-col text-end pe-0">
                                    <div class="d-inline">
                                        <a href="#" class="btn btn-trigger btn-icon" onclick="openEditAward(<?= $award_2['id'] ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Award">
                                            <em class="icon ni ni-edit"></em>
                                        </a>
                                        <a href="#" class="btn btn-trigger btn-icon text-danger" onclick="deleteAward(<?= $award_2['id'] ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Award">
                                            <em class="icon ni ni-trash"></em>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade zoom" tabindex="-1" id="addAward">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="addAwardForm" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Award Category</h5>
            </div>
            <input type="text" style="display:none;" id="award_id" name="id" value="0" required>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="award_category">Award Category</label>
                            <div class="form-control-wrap">
                                <select class="form-select js-select2" id="award_category" name="category_id" required>
                                    <?php foreach ($awardCategories as $key => $award) : ?>
                                        <option value="<?= $award['id'] ?>"><?= $award['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="award_isShort">Is Short?</label>
                            <div class="form-control-wrap">
                                <select class="form-select js-select2" id="award_isShort" name="isShort" required>
                                    <option value="" selected disabled></option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="award_isFeature">Is Feature?</label>
                            <div class="form-control-wrap">
                                <select class="form-select js-select2" id="award_isFeature" name="isFeature" required>
                                    <option value="" selected disabled></option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="award_name">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="award_name" name="name" required>
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

<div class="modal fade zoom" tabindex="-1" id="editAwardCat">
    <div class="modal-dialog modal-xl" role="document">
        <form class="modal-content" id="editAwardCatForm" action="" method="post" enctype="multipart/form-data">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Award Category</h5>
            </div>
            <input type="text" style="display:none;" id="award_cat_id" name="id" value="0" required>
            <div class="modal-body">
                <span id="allAwardsData"></span>
                <div class="row g-4">
                    <div class="col-md-3 col-12">
                        <img src="/public/images/placeholder.jpg" class="rounded" id="award_cat_image_img">
                        <div class="form-group">
                            <div class="form-control-wrap mt-2">
                                <div class="form-file">
                                    <input type="file" class="form-file-input" id="award_cat_image" name="image" required>
                                    <label class="form-file-label" for="award_cat_image">Choose file</label>
                                </div>
                            </div>
                            <label class="form-label text-warning" for="award_cat_image_label">
                                Only Square image<br />Must be 200px & above
                            </label>
                        </div>
                    </div>
                    <div class="col-md-9 col-12">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="award_cat_name">Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="award_cat_name" name="name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="award_cat_short_name">Short Name <small><small>(Internal purpose only)</small></small></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" maxlength="2" minlength="2" id="award_cat_short_name" name="short_name" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="short_student">Short Student</label>
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="award_cat_short_student_inr1">&#8377;</span>
                                                </div>
                                                <input type="number" class="form-control" min="1" id="award_cat_short_student_inr" name="short_student_inr" required>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="award_cat_short_student_eur1">&euro;</span>
                                                </div>
                                                <input type="number" class="form-control" min="1" id="award_cat_short_student_eur" name="short_student_eur" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="featured_student">Featured Student</label>
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="award_cat_feature_student_inr1">&#8377;</span>
                                                </div>
                                                <input type="number" class="form-control" min="1" id="award_cat_feature_student_inr" name="feature_student_inr" required>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="award_cat_feature_student_eur1">&euro;</span>
                                                </div>
                                                <input type="number" class="form-control" min="1" id="award_cat_feature_student_eur" name="feature_student_eur" required>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-6">
                                        <label class="form-label" for="short_professional">Short Professional</label>
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="award_cat_short_professional_inr1">&#8377;</span>
                                                </div>
                                                <input type="number" class="form-control" min="1" id="award_cat_short_professional_inr" name="short_professional_inr" required>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="award_cat_short_professional_eur1">&euro;</span>
                                                </div>
                                                <input type="number" class="form-control" min="1" id="award_cat_short_professional_eur" name="short_professional_eur" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="featured_professional">Featured Professional</label>
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="award_cat_feature_professional_inr1">&#8377;</span>
                                                </div>
                                                <input type="number" class="form-control" min="1" id="award_cat_feature_professional_inr" name="feature_professional_inr" required>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="award_cat_feature_professional_eur1">&euro;</span>
                                                </div>
                                                <input type="number" class="form-control" min="1" id="award_cat_feature_professional_eur" name="feature_professional_eur" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<link rel="stylesheet" href="/public/admin/css/editors/tinymce.css?ver=3.0.0">
<script src="/public/admin/js/libs/editors/tinymce.js?ver=3.0.0"></script>
<script src="/public/admin/js/editors.js?ver=3.0.0"></script>
<script src="/public/admin/js/libs/datatable-btns.js?ver=3.0.0"></script>
<script>
    var awardsTable = NioApp.DataTable('#awardsTable', {
        responsive: {
            details: true
        }
    });
    var editAwardCat = document.getElementById('editAwardCat')
    editAwardCat.addEventListener('hidden.bs.modal', function(event) {
        // /public/images/placeholder.jpg
        $('#award_cat_id').val(0);
        $('#award_cat_image_img').attr('src', '/public/images/placeholder.jpg');
        $('#award_cat_image').val('');
        $('#award_cat_image').attr('required', 'required');
        $('#award_cat_name').val('');
        $('#award_cat_short_name').val('');

        $('#award_cat_short_student_inr').val('');
        $('#award_cat_short_student_eur').val('');
        $('#award_cat_feature_student_inr').val('');
        $('#award_cat_feature_student_eur').val('');

        $('#award_cat_short_professional_inr').val('');
        $('#award_cat_short_professional_eur').val('');
        $('#award_cat_feature_professional_inr').val('');
        $('#award_cat_feature_professional_eur').val('');
    })

    function openEditAwardCat(id) {

        $.ajax({
            url: '',
            type: 'post',
            data: {
                id: id,
                getAwardCat: 'true'
            },
            success: function(response, textStatus, jqXHR) {
                console.log(response);
                var data = {};
                try {
                    data = JSON.parse(response);
                    if (data.success == true) {
                        var awardCatdata = data.data;
                        // $('#allAwardsData').html(JSON.stringify(awardCatdata));
                        $('#award_cat_id').val(awardCatdata.id);

                        if (awardCatdata.image) {
                            $('#award_cat_image_img').attr('src', awardCatdata.image);
                            $('#award_cat_image').removeAttr('required');
                        }

                        $('#award_cat_name').val(awardCatdata.name);
                        $('#award_cat_short_name').val(awardCatdata.short_name);

                        $('#award_cat_short_student_inr').val(awardCatdata.short_student_inr);
                        $('#award_cat_short_student_eur').val(awardCatdata.short_student_eur);
                        $('#award_cat_feature_student_inr').val(awardCatdata.feature_student_inr);
                        $('#award_cat_feature_student_eur').val(awardCatdata.feature_student_eur);

                        $('#award_cat_short_professional_inr').val(awardCatdata.short_professional_inr);
                        $('#award_cat_short_professional_eur').val(awardCatdata.short_professional_eur);
                        $('#award_cat_feature_professional_inr').val(awardCatdata.feature_professional_inr);
                        $('#award_cat_feature_professional_eur').val(awardCatdata.feature_professional_eur);

                        var myModal = new bootstrap.Modal(editAwardCat);
                        myModal.show();
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
    $('#award_cat_image').on('change', function(ev) {
        var output = document.getElementById('award_cat_image_img');
        output.src = URL.createObjectURL(ev.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    })
    $('#editAwardCatForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('update_award_cat', 'true');
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
                    console.log(data);
                    if (data.success == true) {
                        alert('Successfully added/updated Award').then(() => {
                            location.reload();
                        })
                    } else {
                        alert('', data.message, 'error');
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

    var addAward = document.getElementById('addAward')
    addAward.addEventListener('hidden.bs.modal', function(event) {
        $('#award_id').val(0);
        $('#award_category').val('').trigger('change');
        $('#award_isShort').val('').trigger('change');
        $('#award_isFeature').val('').trigger('change');
        $('#award_name').val('');
    })

    function openEditAward(id) {
        $.ajax({
            url: '',
            type: 'post',
            data: {
                id: id,
                getAward: 'true'
            },
            success: function(response, textStatus, jqXHR) {
                console.log(response);
                var data = {};
                try {
                    data = JSON.parse(response);
                    if (data.success == true) {
                        // console.log(data.data.name);
                        $('#award_id').val(data.data.id);
                        $('#award_category').val(data.data.category_id).trigger('change');
                        $('#award_isShort').val(data.data.isShort).trigger('change');
                        $('#award_isFeature').val(data.data.isFeature).trigger('change');
                        $('#award_name').val(data.data.name);
                        var myModal = new bootstrap.Modal(addAward);
                        myModal.show();
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
    $('#addAwardForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('add_update_award', 'true');
        // console.log(Array.from(formData));
        // return;
        var dataId = formData.get('id');
        var award_category = $('#award_category').find('option:selected').text();
        // console.log(award_category);
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
                    console.log(data);
                    if (data.success == true) {
                        var awardDataReturned = data.data;

                        var message = 'Successfully Update Award';
                        if (dataId == 0) {
                            message = 'Successfully Added Award';
                        }
                        alert(message).then(() => {
                            if (dataId == 0) {
                                location.reload();
                                return;
                            }
                            $('#dataName' + dataId).html(awardDataReturned.name);
                            $('#dataCategory' + dataId).html(award_category);
                            if (awardDataReturned.isShort == 0) {
                                $('#dataIsShort' + dataId).addClass('bg-danger');
                                $('#dataIsShort' + dataId).removeClass('bg-success');
                            } else {
                                $('#dataIsShort' + dataId).addClass('bg-success');
                                $('#dataIsShort' + dataId).removeClass('bg-danger');
                            }
                            if (awardDataReturned.isFeature == 0) {
                                $('#dataIsFeature' + dataId).addClass('bg-danger');
                                $('#dataIsFeature' + dataId).removeClass('bg-success');
                            } else {
                                $('#dataIsFeature' + dataId).addClass('bg-success');
                                $('#dataIsFeature' + dataId).removeClass('bg-danger');
                            }
                            modalClose('addAward');
                        })
                        // startLoader()
                        // alert('Successfully added/updated Award').then(() => {
                        // location.reload();
                        // })
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

    async function deleteAward(id) {
        alert('This action will not revert back, as it will delete the award and remove from all festivals also.', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    id: id,
                    deleteAward: true
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
                                alert('', 'Award Deleted!', 'info').then(() => {
                                    var tableRow = $('#tableRow' + id);
                                    var table = tableRow.closest('table').dataTable();
                                    table.api()
                                        .row(tableRow)
                                        .remove()
                                        .draw();
                                    window.location.hash = 'awardsTableColum';
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
</script>

<?= $this->endSection() ?>