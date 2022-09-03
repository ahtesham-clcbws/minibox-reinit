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

    .awardCatCard .btn-trigger.btn-icon {}

    .customTable {
        width: 100%;
        color: #526484;
        vertical-align: top;
        border-color: #dbdfea;
    }

    .customTable th {
        border-radius: 0 !important;
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
    <?php foreach ($awards as $key => $award) : ?>
        <div class="col-md-6 col-12">
            <div class="card shadow text-white bg-gray awardCatCard">
                <div class="card-header">
                    <span class="h3"><?= $award['name'] ?></span>
                    <span class="float-end">
                        <a href="#" class="btn btn-trigger btn-icon text-warning" onclick="openEditAwardCat(<?= $award['id'] ?>, '<?= $award['name'] ?>','<?= $award['short_name'] ?>',<?= $award['short_student_inr'] ?>,<?= $award['short_student_eur'] ?>,<?= $award['short_professional_inr'] ?>,<?= $award['short_professional_eur'] ?>,<?= $award['feature_student_inr'] ?>,<?= $award['feature_student_eur'] ?>,<?= $award['feature_professional_inr'] ?>,<?= $award['feature_professional_eur'] ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Award">
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
    <div class="col-12">
        <div class="card shadow">
            <div class="card-inner">
                <table class="datatable-init nowrap table nk-tb-list nk-tb-ulist">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Award</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($awards as $key => $award_2) : ?>
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                                <td class="nk-tb-col tb-col-md">
                                    <?= $award_2['name'] ?>
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
                                    <?php foreach ($awards as $key => $award) : ?>
                                        <option value="<?= $award['id'] ?>"><?= $award['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
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
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="editAwardCatForm" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Award Category</h5>
            </div>
            <input type="text" style="display:none;" id="award_cat_id" name="id" value="0" required>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="award_cat_name">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="award_cat_name" name="name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="award_cat_usd">USD</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="award_cat_usd" name="usd" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="award_cat_inr">INR</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="award_cat_inr" name="inr" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="award_cat_student_usd">Student USD</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="award_cat_student_usd" name="student_usd" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="award_cat_student_inr">Student INR</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="award_cat_student_inr" name="student_inr" required>
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
    var editAwardCat = document.getElementById('editAwardCat')
    editAwardCat.addEventListener('hidden.bs.modal', function(event) {
        $('#award_cat_id').val(0);
        $('#award_cat_name').val('');
        $('#award_cat_usd').val(0);
        $('#award_cat_inr').val(0);
        $('#award_cat_student_usd').val(0);
        $('#award_cat_studentinr').val(0);
    })

    function openEditAwardCat(data) {
        var awardCatdata = JSON.parse(data);
        $('#award_cat_id').val(awardCatdata.id);
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
    }
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

    var addAward = document.getElementById('addAward')
    addAward.addEventListener('hidden.bs.modal', function(event) {
        $('#award_id').val(0);
        $('#award_category').val('').trigger('change');
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
</script>

<?= $this->endSection() ?>