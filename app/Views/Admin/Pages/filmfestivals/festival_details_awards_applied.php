<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<style>
    .about-team {
        max-width: 250px;
    }

    .edit-icon {
        cursor: pointer;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub"><a class="back-to" href="<?= route_to('admin_film_festivals') ?>"><em class="icon ni ni-arrow-left"></em><span>Festivals</span></a></div>
            <h3 class="nk-block-title page-title"><?= isset($pagename) && $pagename ? $pagename : 'Film festival' ?> Awards</h3>
        </div>
        <!-- <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUpdateAwards">
                                <em class="icon ni ni-award"></em>
                                <span>Apply/Update Awards</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div> -->
    </div>
</div>
<div class="section row">
    <div class="col-12">
        <?php foreach ($awards as $key => $adminAward) : ?>
            <div class="card card-bordered">
                <div class="card-inner">
                    <h5 class="card-title">
                        <em data_id="<?= $adminAward['id'] ?>" class="ni ni-edit edit-icon" onclick="openEditAwardCat(this)"></em>
                        <span class="award_cat_name"><?= $adminAward['name'] ?></span>
                        (<small class="award_price award_usd"><?= number_to_currency($adminAward['usd'], 'USD', 'en_US', 2) ?></small>)
                        (<small class="award_price award_inr"><?= number_to_currency($adminAward['inr'], 'INR', 'en_US', 2) ?></small>)
                    </h5>
                    <p class="card-text">
                        <?php foreach ($adminAward['awards'] as $key2 => $award_2) : ?>
                    <div class="form-check form-check-inline me-3">
                        <input class="form-check-input" onchange="changeAward(<?= $adminAward['id'] ?>, '<?= $award_2['name'] ?>', <?= $award_2['applied'] ?>)" type="checkbox" <?= $award_2['applied'] ? 'checked' : '' ?> id="inlineCheckbox<?= $key . $key2 ?>" value="<?= $award_2['name'] ?>">
                        <label class="form-check-label" for="inlineCheckbox<?= $key . $key2 ?>"><?= $award_2['name'] ?></label>
                    </div>
                <?php endforeach; ?>
                </p>
                </div>
            </div>
        <?php endforeach; ?>
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
                                <input type="text" class="form-control" id="award_cat_usd" name="usd" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label" for="award_cat_inr">INR</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="award_cat_inr" name="inr" required>
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
            <b><?= $festival['name'] ?></b> not activated. please go back to activate the festival from <a class="text-warning" href="<?= route_to('admin_film_festivals') ?>">Here</a>
        </div>
    </footerbar>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    function changeAward(id, awardName, status) {
        var formData = {
            id: id,
            awardName: awardName,
            status: status == 1 ? 0 : 1,
            changeFestivalAward: true
        };
        $.ajax({
            url: '',
            type: 'post',
            data: formData,
            success: function(response) {
                console.log(JSON.parse(response))
            },
            error: function(error) {
                console.log(error)
            }
        })
    }
    var editAwardCat = document.getElementById('editAwardCat')
    editAwardCat.addEventListener('hidden.bs.modal', function(event) {
        $('#award_cat_id').val(0);
        $('#award_cat_name').val('');
        $('#award_cat_usd').val(0);
        $('#award_cat_inr').val(0);
    })

    function openEditAwardCat(event) {
        console.log($(event).attr('data_id'))
        var dataId = $(event).attr('data_id');
        $.ajax({
            url: '',
            type: 'post',
            data: {
                id: dataId,
                getAwardCat: 'true'
            },
            success: function(response, textStatus, jqXHR) {
                console.log(response);
                var data = {};
                try {
                    data = JSON.parse(response);
                    if (data.success == true) {
                        // console.log(data.data.name);
                        $('#award_cat_id').val(data.data.id);
                        $('#award_cat_name').val(data.data.name);
                        $('#award_cat_usd').val(data.data.usd);
                        $('#award_cat_inr').val(data.data.inr);
                        var myModal = new bootstrap.Modal(editAwardCat);
                        myModal.show();
                        // modalShow(editAwardCat);
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
</script>
<?= $this->endSection() ?>