<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<style>
    #module_id_block {
        display: none;
    }

    .editFieldButton .ni-edit {
        display: none;
    }

    .editFieldButton.editMode .ni-check {
        display: none;
    }

    .editFieldButton.editMode .ni-edit {
        display: block;
    }

    .clearImage {
        position: absolute;
        left: 10px;
        bottom: 10px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title"><span id="movie_name"><?= $movie['title'] ?></span> <span id="status_badge"><?= $movie['status_badge'] ?></span></h3>
        </div>
        <div class="nk-block-head-content">
            <div class="btn-group">
                <button type="button" class="btn btn-secondary" onclick="approveAllLive()">All Approve & Live</button>
                <button type="button" class="btn btn-danger" onclick="modalShow('rejectListingModal')">Reject</button>
                <!-- <button type="button" class="btn btn-primary btn-dim">4</button> -->
            </div>
        </div>
    </div>
</div>


<!-- major cast modal -->
<!-- onchange="fileSizeValidation('banner', 519, 1211, 'bannerPreview', '/public/images/entry-form-banner.png')" -->
<div class="modal fade" tabindex="-1" id="addCasteModal">
    <div class="modal-dialog" role="document">
        <form class="modal-content" enctype="multipart/form-data" id="addCasteForm">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Major Cast</h5>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">Image</label>
                            <div class="form-control-wrap">
                                <div class="form-file">
                                    <input type="file" class="form-file-input" name="image" id="cast_image" onchange="casteImageValidation()">
                                    <label class="form-file-label" for="poster">Change Image</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" maxlength="150" name="name" id="cast_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Character</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" maxlength="150" name="cast_character" id="cast_character" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Actor/Actress</label>
                            <div class="form-control-wrap">
                                <select class="form-select" name="gender" id="cast_gender">
                                    <option value="" selected>Select</option>
                                    <option value="Actor">Actor</option>
                                    <option value="Actress">Actress</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Attribute</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" maxlength="150" name="attribute" id="cast_attribute" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="/public/images/avatar.jpg" id="cast_image_preview" class="w-100">
                    </div>
                </div>
            </div>
            <input style="display:none;" type="hidden" name="id" value="0" id="cast_id" required>
            <div class="modal-footer bg-light">
                <button class="btn btn-primary submitButton" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
<!-- other information modal -->
<div class="modal fade" tabindex="-1" id="addOtherInfoModal">
    <div class="modal-dialog" role="document">
        <form class="modal-content" id="addOtherInfoForm">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title" id="addInfoTitle">Add</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <div class="form-control-wrap" id="nameInputBlock">
                        <!-- <input type="text" class="form-control" id="default-01" placeholder="Input placeholder"> -->
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Attribute <span id="attributeExtraText"></span></label>
                    <div class="form-control-wrap" id="attributeInputBlock">
                        <!-- <input type="text" class="form-control" id="default-01" placeholder="Input placeholder"> -->
                    </div>
                </div>
            </div>
            <input type="hidden" style="display:none;" value="0" name="id" id="infoIdInput">
            <input type="hidden" style="display:none;" value="" name="type" id="infoTypeInput">
            <div class="modal-footer bg-light">
                <button class="btn btn-primary submitButton" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
<!-- reject listing modal -->
<div class="modal fade" tabindex="-1" id="rejectListingModal">
    <div class="modal-dialog" role="document">
        <form class="modal-content" id="rejectListingForm">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Reject Reason</h5>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <textarea class="form-control no-resize" name="reject_reason" id="reject_reason"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-primary submitButton" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
<div id="accordion" class="accordion">
    <!-- Title & Details? -->
    <div class="accordion-item">
        <a href="#" class="accordion-head" data-bs-toggle="collapse" data-bs-target="#title-n-details">
            <h6 class="title">Title & Details?</h6>
            <span class="accordion-icon"></span>
        </a>
        <div class="accordion-body collapse show" id="title-n-details" data-bs-parent="#accordion">
            <div class="accordion-inner">
                <div class="row g-4">
                    <div class="col-md-6 col-12">

                        <div class="form-group">
                            <label class="form-label" for="default-01">Movie Name / Project Title</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control inputField editable" name="title" id="title" disabled value="<?= $movie['title'] ?>" oldValue="<?= $movie['title'] ?>">
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-12">

                        <div class="form-group">
                            <label class="form-label" for="default-01">Movie / Project Type</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <select name="project" class="form-select js-select2 inputField editable" disabled id="project" oldValue="<?= $movie['project'] ?>">
                                        <option value="" selected="" disabled=""></option>
                                        <?php foreach (getProjectTypes() as $kkey => $projectTypr) : ?>
                                            <option <?= $movie['project'] == $projectTypr['id'] ? 'selected' : '' ?> value="<?= $projectTypr['id'] ?>"><?= $projectTypr['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-12">

                        <div class="form-group">
                            <label class="form-label" for="default-01">Release Status</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <select name="film_status" class="form-select js-select2 inputField editable" id="film_status" disabled oldValue="<?= $movie['film_status'] ?>">
                                        <option value="" selected="" disabled=""></option>
                                        <?php foreach (getFilmStatus() as $filmstatus) : ?>
                                            <option <?= $movie['film_status'] == $filmstatus['name'] ? 'selected' : '' ?> value="<?= $filmstatus['name'] ?>"><?= $filmstatus['name'] ?> (<?= $filmstatus['info'] ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-12">

                        <div class="form-group">
                            <label class="form-label" for="default-01">Year</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <input type="number" maxlength="4" minlength="4" class="form-control inputField editable" name="year" id="year" disabled value="<?= $movie['year'] ?>" oldValue="<?= $movie['year'] ?>">
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-12">

                        <div class="form-group">
                            <label class="form-label" for="default-01">Country</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <select name="country" class="form-select js-select2 inputField editable" disabled id="country" oldValue="<?= $movie['country'] ?>">
                                        <option value="" selected="" disabled=""></option>
                                        <?php foreach (getAllCountries() as $kkey => $country) : ?>
                                            <option <?= $movie['country'] == $country['id'] ? 'selected' : '' ?> value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-12">

                        <div class="form-group">
                            <label class="form-label" for="default-01">Budget Currency</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <select name="budget_currency" class="form-select js-select2 inputField editable" id="budget_currency" disabled oldValue="<?= $movie['budget_currency'] ?>">
                                        <option value="" selected="" disabled=""></option>
                                        <?php foreach (getCurrencies() as $kkey => $budget_currency) : ?>
                                            <option <?= $movie['budget_currency'] == substr($budget_currency['value'], 0, 3) ? 'selected' : '' ?> value="<?= substr($budget_currency['value'], 0, 3) ?>"><?= $budget_currency['value'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-12">

                        <div class="form-group">
                            <label class="form-label" for="default-01">Budget Amount</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <input type="number" class="form-control inputField editable" name="budget_amount" id="budget_amount" disabled value="<?= $movie['budget_amount'] ?>" oldValue="<?= $movie['budget_amount'] ?>">
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Basic Info -->
    <div class="accordion-item">
        <a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#basic-info">
            <h6 class="title">Basic Info</h6>
            <span class="accordion-icon"></span>
        </a>
        <div class="accordion-body collapse" id="basic-info" data-bs-parent="#accordion">
            <div class="accordion-inner">
                <div class="row g-4">

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="default-01">Director</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control inputField editable" name="director" id="director" disabled value="<?= $movie['director'] ?>" oldValue="<?= $movie['director'] ?>">
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="default-01">Production Company</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control inputField editable" name="production_company" id="production_company" disabled value="<?= $movie['production_company'] ?>" oldValue="<?= $movie['production_company'] ?>">
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label class="form-label" for="default-01">Duration (In Minutes)</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <input type="number" class="form-control inputField editable" name="duration" id="duration" disabled value="<?= $movie['duration'] ?>" oldValue="<?= $movie['duration'] ?>">
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label class="form-label" for="default-01">Debut Film</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <select name="debut_film" class="form-select js-select2 inputField editable" id="debut_film" disabled oldValue="<?= $movie['debut_film'] ?>">
                                        <option value="" selected="" disabled=""></option>
                                        <option <?= $movie['debut_film'] == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                                        <option <?= $movie['debut_film'] == 'No' ? 'selected' : '' ?> value="No">No</option>
                                    </select>
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label class="form-label" for="default-01">Color</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <select name="color" class="form-select js-select2 inputField editable" id="color" disabled oldValue="<?= $movie['color'] ?>">
                                        <option value="" selected="" disabled=""></option>
                                        <option <?= $movie['color'] == '1' ? 'selected' : '' ?> value="1">Color</option>
                                        <option <?= $movie['color'] == '0' ? 'selected' : '' ?> value="0">Black & White</option>
                                    </select>
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="default-01">Genres</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <select name="genres" class="form-select js-select2 inputField editable" multiple id="genres" disabled>
                                        <?php foreach (getGenres() as $genres) : ?>
                                            <option <?= in_array($genres['value'], $movie['genres']) ? 'selected' : '' ?> value="<?= $genres['value'] ?>"><?= $genres['value'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="default-01">Certificates/Ratings</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <select name="certificates" class="form-select js-select2 inputField editable" multiple id="certificates" disabled>
                                        <?php foreach (getCertificates() as $certificates) : ?>
                                            <option <?= in_array($certificates['value'], $movie['certificates']) ? 'selected' : '' ?> value="<?= $certificates['value'] ?>"><?= $certificates['value'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <label class="form-label" for="synopsis">Synopsis</label>
                                <div class="button-group float-end">
                                    <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                        <em class="icon ni ni-edit"></em>
                                        <em class="icon ni ni-check"></em>
                                    </button>
                                    <!-- <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                    <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                    <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button> -->
                                </div>
                                <textarea class="form-control no-resize inputField editable mt-2" name="synopsis" id="synopsis" disabled oldValue="<?= $movie['synopsis'] ?>"><?= $movie['synopsis'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <label class="form-label" for="storyline">Storyline</label>
                                <div class="button-group float-end">
                                    <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                        <em class="icon ni ni-edit"></em>
                                        <em class="icon ni ni-check"></em>
                                    </button>
                                    <!-- <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                    <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                    <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button> -->
                                </div>
                                <textarea class="form-control no-resize inputField editable mt-2" name="storyline" id="storyline" disabled oldValue="<?= $movie['storyline'] ?>"><?= $movie['storyline'] ?></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Banner & Trailer -->
    <div class="accordion-item">
        <a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#banner-n-trailer">
            <h6 class="title">Banner & Trailer</h6>
            <span class="accordion-icon"></span>
        </a>
        <div class="accordion-body collapse" id="banner-n-trailer" data-bs-parent="#accordion">
            <div class="accordion-inner">
                <div class="row g-3">

                    <div class="col-md-4 col-12">
                        <div class="previewImage position-relative w-100">
                            <img src="<?= $movie['poster'] ? $movie['poster']  : '/public/images/movie-poster.png' ?>" id="posterImagePreview">
                            <button class="btn btn-icon btn-danger clearImage" title="Clear Image" onclick="clearImage(this, 'poster', '<?= $movie['poster'] ? $movie['poster']  : '/public/images/movie-poster.png' ?>')">
                                <em class="icon ni ni-cross"></em>
                            </button>
                        </div>
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <div class="form-file">
                                        <input type="file" disabled class="form-file-input editable" id="poster" previewImage="/public/images/movie-poster.png" onchange="imageRatioValidation('poster', 543, 362, 'posterPreview', '/public/images/movie-poster.png')">
                                        <label class="form-file-label" for="poster">Change poster</label>
                                    </div>
                                    <!-- <input type="file" class="form-control inputField editable" name="trailer" id="trailer" disabled value=""> -->
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="previewImage position-relative w-100">
                            <img src="<?= $movie['banner'] ? $movie['banner']  : '/public/images/entry-form-banner.png' ?>" id="bannerImagePreview">
                            <button class="btn btn-icon btn-danger clearImage" title="Clear Image" onclick="clearImage(this, 'banner', '<?= $movie['banner'] ? $movie['banner']  : '/public/images/entry-form-banner.png' ?>')">
                                <em class="icon ni ni-cross"></em>
                            </button>
                        </div>
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                            <em class="icon ni ni-edit"></em>
                                            <em class="icon ni ni-check"></em>
                                        </button>
                                    </div>
                                    <div class="form-file">
                                        <input type="file" disabled class="form-file-input editable" id="banner" onchange="imageRatioValidation('banner', 519, 1211, 'bannerPreview', '/public/images/entry-form-banner.png')">
                                        <label class="form-file-label" for="banner">Change banner</label>
                                    </div>
                                    <!-- <input type="file" class="form-control inputField editable" name="trailer" id="trailer" disabled value=""> -->
                                    <div class="input-group-append d-none">
                                        <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                        <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                        <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Distribution</label>
                                    <div class="form-control-wrap">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                                    <em class="icon ni ni-edit"></em>
                                                    <em class="icon ni ni-check"></em>
                                                </button>
                                            </div>
                                            <select name="distribution" class="form-select js-select2 inputField editable" id="distribution" disabled oldValue="<?= $movie['distribution'] ?>">
                                                <option <?= $movie['distribution'] == 'Available' ? 'selected' : '' ?> value="Available">Available</option>
                                                <option <?= $movie['distribution'] == 'Un-Available' ? 'selected' : '' ?> value="Un-Available">Un-Available</option>
                                            </select>
                                            <div class="input-group-append d-none">
                                                <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                                <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                                <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Trailer Cloud</label>
                                    <div class="form-control-wrap">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                                    <em class="icon ni ni-edit"></em>
                                                    <em class="icon ni ni-check"></em>
                                                </button>
                                            </div>
                                            <select name="trailer_type" class="form-select js-select2 inputField editable" id="trailer_type" disabled oldValue="<?= $movie['trailer_type'] ?>">
                                                <option value="" selected="" disabled=""></option>
                                                <option <?= $movie['trailer_type'] == 'youtube' ? 'selected' : '' ?> value="youtube">Youtube</option>
                                                <option <?= $movie['trailer_type'] == 'vimeo' ? 'selected' : '' ?> value="vimeo">Vimeo</option>
                                            </select>
                                            <div class="input-group-append d-none">
                                                <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                                <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                                <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-01">Trailer URL</label>
                                    <div class="form-control-wrap">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="editFieldButton editMode btn btn-icon btn-info" title="Field Editable">
                                                    <em class="icon ni ni-edit"></em>
                                                    <em class="icon ni ni-check"></em>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control inputField editable" name="trailer" id="trailer" disabled value="<?= $movie['trailer'] ?>" oldValue="<?= $movie['trailer'] ?>">
                                            <div class="input-group-append d-none">
                                                <button class="lockFieldButton btn btn-icon btn-primary" title="Field Lock"><em class="icon ni ni-lock"></em></button>
                                                <button class="unlockFieldButton btn btn-icon btn-danger" title="Field Unlock"><em class="icon ni ni-unlock"></em></button>
                                                <button class="approveFieldButton btn btn-icon btn-secondary" title="Field Approved"><em class="icon ni ni-check"></em></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Major Casts -->
    <div class="accordion-item">
        <a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#major-casts">
            <h6 class="title">Major Casts</h6>
            <span class="accordion-icon"></span>
        </a>
        <div class="accordion-body collapse" id="major-casts" data-bs-parent="#accordion">
            <div class="accordion-inner">
                <table class="nk-tb-list nk-tb-ulist nowrap dtr-inline table" id="majorCasteTable">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col"></th>
                            <th class="nk-tb-col">Image</th>
                            <th class="nk-tb-col">Name</th>
                            <th class="nk-tb-col">Type</th>
                            <th class="nk-tb-col">Character</th>
                            <th class="nk-tb-col">Attribute</th>
                            <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- All Other Crews -->
    <div class="accordion-item">
        <a href="#" class="accordion-head" data-bs-toggle="collapse" data-bs-target="#other-crews">
            <h6 class="title">All Other Crews</h6>
            <span class="accordion-icon"></span>
        </a>
        <div class="accordion-body collapse" id="other-crews" data-bs-parent="#accordion">
            <div class="accordion-inner">
                <div class="card card-bordered">
                    <div class="card-header border-bottom">Producers</div>
                    <div class="card-body">
                        <table class="movieInfoTable table-sm nk-tb-list nk-tb-ulist nowrap dtr-inline table" dataType="producers" id="producersTable">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col"></th>
                                    <th class="nk-tb-col">Producer</th>
                                    <th class="nk-tb-col">Occupation (Attribute)</th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card card-bordered">
                    <div class="card-header border-bottom">Writers</div>
                    <div class="card-body">
                        <table class="movieInfoTable table-sm nk-tb-list nk-tb-ulist nowrap dtr-inline table" dataType="writers" id="writersTable">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col"></th>
                                    <th class="nk-tb-col">Writer</th>
                                    <th class="nk-tb-col">Attribute</th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card card-bordered">
                    <div class="card-header border-bottom">Composers</div>
                    <div class="card-body">
                        <table class="movieInfoTable table-sm nk-tb-list nk-tb-ulist nowrap dtr-inline table" dataType="composers" id="composersTable">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col"></th>
                                    <th class="nk-tb-col">Composer</th>
                                    <th class="nk-tb-col">Attribute</th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card card-bordered">
                    <div class="card-header border-bottom">Cinematographers</div>
                    <div class="card-body">
                        <table class="movieInfoTable table-sm nk-tb-list nk-tb-ulist nowrap dtr-inline table" dataType="cinematographers" id="cinematographersTable">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col"></th>
                                    <th class="nk-tb-col">Cinematographer</th>
                                    <th class="nk-tb-col">Attribute</th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card card-bordered">
                    <div class="card-header border-bottom">Editors</div>
                    <div class="card-body">
                        <table class="movieInfoTable table-sm nk-tb-list nk-tb-ulist nowrap dtr-inline table" dataType="editors" id="editorsTable">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col"></th>
                                    <th class="nk-tb-col">Editor</th>
                                    <th class="nk-tb-col">Attribute</th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Other Specifications -->
    <div class="accordion-item">
        <a href="#" class="accordion-head" data-bs-toggle="collapse" data-bs-target="#other-specifications">
            <h6 class="title">Other Specifications</h6>
            <span class="accordion-icon"></span>
        </a>
        <div class="accordion-body collapse" id="other-specifications" data-bs-parent="#accordion">
            <div class="accordion-inner">

                <div class="card card-bordered">
                    <div class="card-header border-bottom">Sound Mix</div>
                    <div class="card-body">
                        <table class="movieInfoTable table-sm nk-tb-list nk-tb-ulist nowrap dtr-inline table" dataType="sound_mix" id="sound_mixTable">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col"></th>
                                    <th class="nk-tb-col">Sound</th>
                                    <th class="nk-tb-col">Attribute</th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card card-bordered">
                    <div class="card-header border-bottom">Aspect Ratio</div>
                    <div class="card-body">
                        <table class="movieInfoTable table-sm nk-tb-list nk-tb-ulist nowrap dtr-inline table" dataType="aspect_ratio" id="aspect_rationTable">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col"></th>
                                    <th class="nk-tb-col">Ratio</th>
                                    <th class="nk-tb-col">Attribute</th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card card-bordered">
                    <div class="card-header border-bottom">Languages <small>(All languages used in this film)</small></div>
                    <div class="card-body">
                        <table class="movieInfoTable table-sm nk-tb-list nk-tb-ulist nowrap dtr-inline table" dataType="languages" id="languagesTable">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col"></th>
                                    <th class="nk-tb-col">Language</th>
                                    <th class="nk-tb-col">Attribute</th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    function createDataTable(tableId, tableType, stepNumberValue = 0) {

        var myTable = NioApp.DataTable('#' + tableId, {
            paging: true,
            pagingType: 'first_last_numbers',
            ordering: false,
            // "bFilter": false,
            // dom: dom_normal,
            // lengthChange: false,

            lengthMenu: [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "Show All"]
            ],
            autoWidth: false,
            columnDefs: [{
                targets: ['_all'],
                className: 'mdc-data-table__cell',
            }],
            bProcessing: true,
            serverSide: true,
            ajax: {
                url: "", // json datasource
                type: "post",
                data: {
                    order: [{
                        dir: 'desc'
                    }],
                    other_info_data: tableType
                },
                deferRender: true,
            },
            columns: [{
                data: "key",
                className: "nk-tb-col",
            }, {
                data: "name",
                className: "nk-tb-col",
            }, {
                data: "attribute",
                className: "nk-tb-col",
            }, {
                data: "actions",
                className: "nk-tb-col text-end",
            }],
            fnInitComplete: function(oSettings, json) {
                // if (stepNumberValue != 'locked') {
                //     datatableCustomButtons(tableId, tableType);
                // }
            }
        });
    }

    // function datatableCustomButtons(tableId, tableType) {
    //     // console.log(tableId)
    //     var tableButtons = document.getElementById(tableId + '_filter');
    //     // console.log(tableButtons)
    //     var button = document.createElement('button');

    //     var icon = document.createElement('span');
    //     // icon.classList.add('text-danger');
    //     // icon.style.fontSize = '18px';
    //     // icon.classList.add('ni');
    //     // icon.classList.add('ni-trash-fill');
    //     icon.setAttribute('uk-icon', 'plus-circle');

    //     button.setAttribute('type', 'button');
    //     button.setAttribute('id', 'deleteButton');
    //     button.setAttribute('onclick', 'addInfoItem("' + tableType + '")');

    //     button.classList.add('btn');
    //     // button.classList.add('btn-sm');

    //     button.classList.add('mdc-button');
    //     button.classList.add('mdc-button--raised');
    //     button.classList.add('mdc-button--primary');
    //     button.classList.add('uk-margin-right');

    //     button.setAttribute('type', 'submit');
    //     button.setAttribute('title', 'Add ' + tableType);
    //     button.setAttribute('tabindex', '0');
    //     button.setAttribute('aria-controls', 'datatable');
    //     button.appendChild(icon);
    //     tableButtons.prepend(button);
    // }

    function tableReload(tableId) {
        // $('#' + tableId).DataTable().ajax.reload(null, false);
        $('#' + tableId).DataTable().ajax.reload();
    }
</script>
<script>
    var movieInfoTables = $('.movieInfoTable');
    movieInfoTables.each(function() {
        var tableId = $(this).attr('id');
        var tableType = $(this).attr('dataType');
        var stepNumberValue = '';
        if (tableType == 'producers' || tableType == 'writers' || tableType == 'composers' || tableType == 'cinematographers' || tableType == 'editors') {
            stepNumberValue = '<?= $movie['step5'] ?>';
        } else {
            stepNumberValue = '<?= $movie['step6'] ?>';
        }
        createDataTable(tableId, tableType, stepNumberValue);
    });
    var addCasteModal = document.getElementById('addCasteModal');
    addCasteModal.addEventListener('hidden.bs.modal', function(event) {
        $('#cast_id').val(0);
        resetImageInput('cast_image');
        $('#cast_image_preview').attr('src', '/public/images/avatar.jpg');
        $('#cast_name').val('');
        $('#cast_character').val('');
        $('#cast_gender').val('');
        $('#cast_attribute').val('');
    })
    var addOtherInfoModal = document.getElementById('addOtherInfoModal');
    addOtherInfoModal.addEventListener('hidden.bs.modal', function(event) {
        nameInputBlock.html('');
        attributeInputBlock.html('');
        $('#infoIdInput').val(0);
        $('#infoTypeInput').val('');
    })
    // inputField editable
    // editFieldButton
    $('.editFieldButton').on('click', function() {
        if ($(this).hasClass('editMode')) {
            $(this).closest('.form-control-wrap').find('.editable').removeAttr('disabled');
        } else {
            columnName = $(this).closest('.form-control-wrap').find('.editable').attr('name');
            columnValue = $(this).closest('.form-control-wrap').find('.editable').val();
            oldValue = $(this).closest('.form-control-wrap').find('.editable').attr('oldValue') ? $(this).closest('.form-control-wrap').find('.editable').attr('oldValue') : false;
            isSelect = $(this).closest('.form-control-wrap').find('.editable').hasClass('form-select') ? true : false;

            inputId = $(this).closest('.form-control-wrap').find('.editable').attr('id');
            console.log(inputId);

            if ($(this).closest('.form-control-wrap').find('.editable').attr('type') == 'file') {
                // console.log('this is file input');
                $("#" + inputId).wrap('<form enctype="multipart/form-data" id="' + inputId + 'Form">');
                const thisForm = $("#" + inputId + "Form");
                thisForm.submit(function(ev) {
                    ev.preventDefault();
                    var formData = new FormData($(this)[0]);
                    saveSingleField(formData, inputId, true, true);
                });
                thisForm.submit();
            } else {
                data = {
                    columnName,
                    columnValue
                };
                if (isSelect) {
                    saveSingleField(data, inputId);
                } else {
                    if (oldValue && oldValue !== columnValue) {
                        saveSingleField(data, inputId);
                    }
                }
            }
            $(this).closest('.form-control-wrap').find('.editable').attr('disabled', 'disabled');
        }
        $(this).toggleClass('editMode');
    })
    // lockFieldButton
    // unlockFieldButton
    // approveFieldButton
    function saveSingleField(form_data, fieldId, formData = false, ImagePreview = false) {
        if (formData) {
            ajaxOptions = {
                contentType: false,
                processData: false,
            }
            console.log(Array.from(form_data));
        } else {
            ajaxOptions = {}
            // console.log(form_data)
        }
        // if (ImagePreview) {
        //     ImagePreviewUrl = $('#' + inputId).attr('previewImage');
        // }

        // console.log('formData', formData);
        // console.log(form_data.columnName);

        $.ajax({
            ...ajaxOptions,
            url: '',
            type: 'POST',
            data: form_data,
            success: function(response) {
                console.log(response);
                try {
                    var data = JSON.parse(response);
                    console.log(data);
                    if (data.success) {
                        if (!formData) {
                            if (form_data.columnName == 'title') {
                                $('#movie_name').html(form_data.columnValue);
                            }
                            $('#' + fieldId).attr('oldValue', form_data.columnValue);
                        }
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Successfully'
                        })
                    } else {
                        var errorMessage = data.message ? data.message : 'Error happening, please try again later';
                        alert('Error', errorMessage, 'error').then((result) => {})
                    }
                } catch (error) {
                    console.log(error);
                    var errorMessage = 'Error happening, please try again later';
                    alert('Error', errorMessage, 'error').then((result) => {})
                }
            },
            error: function(error) {
                console.log(error);
                alert('Error', 'There is some error into the server. Please try again later.', 'error');
            },
            // complete: function(response) {
            //     setTimeout(() => {
            //         tableReload('majorCasteTable');
            //         setTimeout(() => {
            //             modalClose('addCasteModal');
            //             setTimeout(() => {
            //                 stopLoader();
            //             }, 250);
            //         }, 250);
            //     }, 250);
            // }
        });
    }

    // $("#" + inputId).wrap('<form>').closest('form').get(0).reset();
    // $("#" + inputId).unwrap();
    function clearImage(event, inputId, image) {
        $("#" + inputId).wrap('<form>').closest('form').get(0).reset();
        $("#" + inputId).unwrap();
        $('#' + inputId + 'ImagePreview').attr('src', image);
    }

    var majorCasteTable = NioApp.DataTable('#majorCasteTable', {
        // paging: true,
        // pagingType: 'first_last_numbers',
        ordering: false,

        lengthMenu: [
            [10, 15, 20, -1],
            [10, 15, 20, "Show All"]
        ],
        // autoWidth: false,
        // columnDefs: [{
        //     targets: ['_all'],
        //     className: 'mdc-data-table__cell',
        // }],
        bProcessing: true,
        serverSide: true,
        ajax: {
            url: "", // json datasource
            type: "post",
            data: {
                order: [{
                    dir: 'desc'
                }],
                casts_data: 'true'
            },
            deferRender: true,
        },
        createdRow: function(row, data, dataIndex) {
            // console.log(data)
            $(row).addClass('nk-tb-item');
        },
        columns: [{
            data: "key",
        }, {
            data: "previewImage",
            className: "nk-tb-col",
        }, {
            data: "name",
            className: "nk-tb-col",

        }, {
            data: "gender",
            className: "nk-tb-col",

        }, {
            data: "cast_character",
            className: "nk-tb-col",

        }, {
            data: "attribute",
            className: "nk-tb-col",

        }, {
            data: "actions",
            className: "nk-tb-col text-end",

        }],
        fnInitComplete: function(oSettings, json) {
            // castsTableButton('majorCasteTable');
        }
    });
    $.fn.DataTable.ext.pager.numbers_length = 7;

    // function castsTableButton(tableId) {
    //     var tableButtons = document.getElementById(tableId + '_filter');
    //     var button = document.createElement('button');

    //     var icon = document.createElement('span');
    //     icon.setAttribute('uk-icon', 'plus-circle');

    //     button.setAttribute('type', 'button');
    //     button.setAttribute('id', 'deleteButton');
    //     button.setAttribute('uk-toggle', 'target: #addCasteModal');

    //     button.classList.add('btn');
    //     // button.classList.add('btn-sm');

    //     button.classList.add('mdc-button');
    //     button.classList.add('mdc-button--raised');
    //     button.classList.add('mdc-button--primary');
    //     button.classList.add('uk-margin-right');

    //     button.setAttribute('type', 'submit');
    //     button.setAttribute('title', 'Add Caste');
    //     button.setAttribute('tabindex', '0');
    //     button.setAttribute('aria-controls', 'datatable');
    //     button.appendChild(icon);
    //     tableButtons.prepend(button);
    // }

    async function casteImageValidation() {
        var validated = true;
        var fileUpload = $("#cast_image")[0];
        // var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
        var regex = new RegExp(/\.(jpe?g|png|bmp)$/i);
        if (regex.test(fileUpload.value.toLowerCase())) {
            //Check whether HTML5 is supported.
            if (typeof(fileUpload.files) != "undefined") {
                //Initiate the FileReader object.
                var reader = new FileReader();
                //Read the contents of Image File.
                reader.readAsDataURL(fileUpload.files[0]);
                reader.onload = function(e) {
                    //Initiate the JavaScript Image object.
                    var image = new Image();
                    //Set the Base64 string return from FileReader as source.
                    image.src = e.target.result;
                    image.onload = function await () {
                        //Determine the Height and Width.
                        var height = this.height;
                        var width = this.width;

                        if (height > 200 || width > 200) {
                            alert('', "Height and Width must not exceed 200x200 pixels", 'error');
                            validated = false;
                            resetImageInput('cast_image');
                        }

                        if (height < 100 || width < 100) {
                            alert('', "Height and Width must minimum 100x100 pixels", 'error');
                            validated = false;
                            resetImageInput('cast_image');
                        }
                        if (validated) {
                            $('#cast_image_preview').attr('src', this.src);
                        } else {
                            $('#cast_image_preview').attr('src', '/public/images/avatar.jpg');
                        }
                    };
                }
            } else {
                alert('', "This browser does not support HTML5.", 'error');
                validated = false;
                resetImageInput('cast_image');
            }
        } else {
            alert('', "Please select a valid Image file.", 'error');
            validated = false;
            resetImageInput('cast_image');
        }
        return validated;
        // 'cast_image_preview', '/public/images/avatar.jpg'
    }
    async function imageRatioValidation(inputId, maxHeight, maxWidth, previewId = null, defaultImage) {
        let validated = true;
        var fileUpload = $("#" + inputId)[0];
        // var fileUpload = event.target;
        var regex = new RegExp(/\.(jpe?g|png|bmp)$/i);
        if (regex.test(fileUpload.value.toLowerCase())) {
            //Check whether HTML5 is supported.
            if (typeof(fileUpload.files) != "undefined") {
                //Initiate the FileReader object.
                var reader = new FileReader();
                //Read the contents of Image File.
                reader.readAsDataURL(fileUpload.files[0]);
                reader.onload = function(e) {
                    //Initiate the JavaScript Image object.
                    var image = new Image();
                    //Set the Base64 string return from FileReader as source.
                    image.src = e.target.result;
                    image.onload = function await () {
                        //Determine the Height and Width.
                        var height = this.height;
                        // console.log(height);
                        var width = this.width;
                        // console.log(width);

                        // console.log('this');
                        // console.log(this.src);

                        if (height < maxHeight || width < maxWidth) {
                            alert('', "Height and Width must be minimum " + maxHeight + 'x' + maxWidth + " pixels", 'error');
                            validated = false;

                            resetImageInput(inputId);
                        } else {
                            // ratio calculation
                            const ratio = parseFloat(maxHeight > maxWidth ? maxHeight / maxWidth : maxWidth / maxHeight).toFixed(2);
                            // console.log('ratio ', ratio);
                            const newRatio = parseFloat(height > width ? height / width : width / height).toFixed(2);
                            // console.log('newRatio ', newRatio);
                            // ratio calculation
                            if (numberToFloat(ratio) === numberToFloat(newRatio)) {
                                // previewImage(event, previewId);
                                $('#' + previewId).attr('src', this.src);
                            } else {
                                alert('', "Please maintain the aspect ratio of the image, it will be minimum size of " + maxHeight + 'x' + maxWidth + " pixels", 'error');
                                validated = false;
                                $('#' + previewId).attr('src', defaultImage);

                                resetImageInput(inputId);
                            }
                        }

                    };
                }
            } else {
                alert('', "This browser does not support HTML5.", 'error');
                validated = false;
                resetImageInput(inputId);
            }
        } else {
            alert('', "Please select a valid Image file.", 'error');
            validated = false;
            resetImageInput(inputId);
        }
        if (!validated) {
            resetImageInput(inputId);
        }
        return validated;
    }

    var nameInputBlock = $('#nameInputBlock'),
        attributeInputBlock = $('#attributeInputBlock'),
        attributeExtraText = $('#attributeExtraText'),
        infoIdInput = $('#infoIdInput'),
        infoTypeInput = $('#infoTypeInput'),
        defaultNameValue = null,
        defaultAttrValue = null;

    function addInfoItem(type, edit = false, itemId = 0, ItemName = null, itemAttr = null) {
        $('#addInfoTitle').html('Add');
        infoTypeInput.val(type);
        attributeExtraText.html('');

        if (edit) {
            infoIdInput.val(itemId);
            defaultNameValue = ItemName;
            defaultAttrValue = itemAttr;
        } else {
            infoIdInput.val(0);
            defaultNameValue = null;
            defaultAttrValue = null;
        }

        if (type === 'producers') {
            $('#addInfoTitle').html('Add Producer');

            $.ajax({
                url: '',
                data: {
                    get_producers_type_data: 'get_producers_type_data'
                },
                type: 'post',
                success: function(response) {
                    // console.log(response);
                    let selectListOption = [];
                    var parsedResponse = JSON.parse(response);
                    var responseData = parsedResponse.data

                    var input = getInput(['form-control'], [{
                        value: 'text',
                        name: 'type'
                    }, {
                        value: 'name',
                        name: 'name'
                    }, {
                        value: 'required',
                        name: 'required'
                    }], defaultNameValue);
                    nameInputBlock.html(input);
                    responseData.forEach(list => {
                        let optionData = {
                            value: list.value,
                            text: list.value
                        };
                        selectListOption.push(optionData);
                    });
                    var selectInput = getSelectInput(['form-select'], [{
                        value: 'attribute',
                        name: 'name'
                    }, {
                        value: 'required',
                        name: 'required'
                    }, {
                        value: 'producers_type',
                        name: 'id'
                    }], selectListOption, defaultAttrValue);
                    attributeInputBlock.html(selectInput);

                    modalShow('addOtherInfoModal');
                }
            })
        }
        if (type === 'writers' || type === 'composers' || type === 'cinematographers' || type === 'editors') {
            var title = type === 'writers' ? 'Writer' : (type === 'composers' ? 'Composer' : (type === 'cinematographers' ? 'Cinematographer' : (type === 'editors' ? 'Editor' : '')));
            $('#addInfoTitle').html('Add ' + title);
            attributeExtraText.html('(usually empty)');
            var nameInput = getInput(['form-control'], [{
                value: 'text',
                name: 'type'
            }, {
                value: 'name',
                name: 'name'
            }, {
                value: 'required',
                name: 'required'
            }], defaultNameValue);
            nameInputBlock.html(nameInput);
            var attrInput = getInput(['form-control'], [{
                value: 'text',
                name: 'type'
            }, {
                value: 'attribute',
                name: 'name'
            }], defaultAttrValue);
            attributeInputBlock.html(attrInput);

            modalShow('addOtherInfoModal');
        }
        if (type === 'sound_mix') {
            $('#addInfoTitle').html('Add Sound Mix');

            $.ajax({
                url: '',
                data: {
                    get_sound_mix_data: 'get_sound_mix_data'
                },
                type: 'post',
                success: function(response) {
                    // console.log(response);
                    var parsedResponse = JSON.parse(response);
                    var soundMixData = parsedResponse.data.sound_mixs
                    var soundMixAttrData = parsedResponse.data.sound_mix_attributes

                    let selectListOption = [];
                    soundMixData.forEach(list => {
                        let optionData = {
                            value: list.value,
                            text: list.value
                        };
                        selectListOption.push(optionData);
                    });
                    var selectInput1 = getSelectInput(['form-select'], [{
                        value: 'name',
                        name: 'name'
                    }, {
                        value: 'required',
                        name: 'required'
                    }, {
                        value: 'sounds_list',
                        name: 'id'
                    }], selectListOption, defaultNameValue);
                    nameInputBlock.html(selectInput1);

                    // $('#sounds_list').select2();

                    selectListOption = [];
                    soundMixAttrData.forEach(list => {
                        let optionData = {
                            value: list.value,
                            text: list.value
                        };
                        selectListOption.push(optionData);
                    });
                    var selectInput = getSelectInput(['form-select'], [{
                        value: 'attribute',
                        name: 'name'
                    }, {
                        value: 'sounds_list_attribute',
                        name: 'id'
                    }], selectListOption, defaultAttrValue);
                    attributeInputBlock.html(selectInput);

                    // $('#sounds_list_attribute').select2();

                    modalShow('addOtherInfoModal');
                }
            })
        }
        if (type === 'aspect_ratio') {
            $('#addInfoTitle').html('Add Aspect Ratio');

            $.ajax({
                url: '',
                data: {
                    get_aspect_ratio_data: 'get_aspect_ratio_data'
                },
                type: 'post',
                success: function(response) {
                    // console.log(response);
                    let selectListOption = [];
                    var parsedResponse = JSON.parse(response);
                    var responseData = parsedResponse.data
                    responseData.forEach(list => {
                        let optionData = {
                            value: list.value,
                            text: list.value
                        };
                        selectListOption.push(optionData);
                    });
                    var selectInput = getSelectInput(['form-select'], [{
                        value: 'name',
                        name: 'name'
                    }, {
                        value: 'required',
                        name: 'required'
                    }, {
                        value: 'aspect_ratio_list',
                        name: 'id'
                    }], selectListOption, defaultNameValue);
                    nameInputBlock.html(selectInput);

                    var input = getInput(['form-control'], [{
                        value: 'text',
                        name: 'type'
                    }, {
                        value: 'attribute',
                        name: 'name'
                    }], defaultAttrValue);
                    attributeInputBlock.html(input);
                    // $('#aspect_ratio_list').select2();

                    modalShow('addOtherInfoModal');
                }
            })
        }
        if (type === 'languages') {
            $('#addInfoTitle').html('Add Language');
            let selectListOption = [];

            const allLanguages = JSON.parse('<?= json_encode(getLanguages()) ?>');

            allLanguages.forEach(list => {
                let optionData = {
                    value: list.name,
                    text: list.name
                };
                selectListOption.push(optionData);
            });

            var selectInput = getSelectInput(['form-select'], [{
                value: 'name',
                name: 'name'
            }, {
                value: 'required',
                name: 'required'
            }, {
                value: 'languages_selection',
                name: 'id'
            }], selectListOption, defaultNameValue);
            nameInputBlock.html(selectInput);
            // $('#languages_selection').select2();

            var input = getInput(['form-control'], [{
                value: 'text',
                name: 'type'
            }, {
                value: 'attribute',
                name: 'name'
            }], defaultAttrValue);
            attributeInputBlock.html(input);

            modalShow('addOtherInfoModal');
        }
    }

    function deleteInfoItem(type, id) {
        var tableId = type + 'Table';

        var nameOfTheEntity = ''
        if (type === 'producers' || type === 'writers' || type === 'composers' || type === 'cinematographers' || type === 'editors' || type === 'languages') {
            nameOfTheEntity = type.toUpperCase();
        }
        if (type === 'sound_mix') {
            nameOfTheEntity = 'SOUND MIX';
        }
        if (type === 'aspect_ratio') {
            nameOfTheEntity = 'ASPECT RATIO';
        }

        alert('This action will not revert back, as it will delete the item from your (' + nameOfTheEntity + ') list.', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '',
                    type: 'post',
                    // contentType: false,
                    // processData: false,
                    data: {
                        deleteMovieData: id
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            // console.log(data);
                            Toast.fire({
                                icon: 'success',
                                title: 'Deleted Successfully'
                            });
                        } else {
                            var errorMessage = data.message ? data.message : 'Error happening, please try again later';
                            alert('Error', errorMessage, 'error').then((result) => {})
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        alert('Error', 'There is some error into the server. Please try again later.', 'error');
                    },
                    complete: function(response) {
                        setTimeout(() => {
                            tableReload(tableId);
                            setTimeout(() => {
                                stopLoader();
                            }, 250);
                        }, 250);
                    }
                });
            } else {
                Toast.fire({
                    icon: 'success',
                    title: 'Good choice! You saved a day'
                });
            }
        })

    }

    function getInput(classes, attributes, defaultValue = null) {
        var input = document.createElement('input');
        classes.forEach(elClass => {
            input.classList.add(elClass);
        });
        attributes.forEach(attr => {
            input.setAttribute(attr.name, attr.value);
        });
        if (defaultValue) {
            input.setAttribute('value', defaultValue);
        }
        return input;
    }

    function getSelectInput(classes, attributes, optionsList, defaultValue = null) {
        // console.log(attributes);
        var select = document.createElement('select');
        classes.forEach(elClass => {
            select.classList.add(elClass);
        });
        attributes.forEach(attribute => {
            select.setAttribute(attribute.name, attribute.value);
        });
        // select.setAttribute('autocomplete', 'new_');
        let option = document.createElement("option");
        option.value = '';
        option.text = '';
        select.add(option, null);
        optionsList.forEach(opt => {
            let option = document.createElement("option");
            option.value = opt.value;
            option.text = opt.text;
            if (defaultValue && defaultValue == opt.value) {
                option.setAttribute('selected', 'selected');
            }
            select.add(option);
        });
        return select;
    }

    $('#addOtherInfoForm').submit(function(ev) {
        startLoader();
        ev.preventDefault();
        var formData = new FormData($(this)[0]);
        // console.log(Array.from(formData));
        formData.append('addMovieData', 'other');
        var tableId = formData.get('type') + 'Table';
        // console.log(formData.get('type'));
        // return;
        $.ajax({
            url: '',
            type: 'post',
            contentType: false,
            processData: false,
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    // console.log(data);
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated Successfully'
                    });
                } else {
                    var errorMessage = data.message ? data.message : 'Error happening, please try again later';
                    alert('Error', errorMessage, 'error').then((result) => {})
                }
            },
            error: function(error) {
                console.log(error);
                alert('Error', 'There is some error into the server. Please try again later.', 'error');
            },
            complete: function(response) {
                setTimeout(() => {
                    tableReload(tableId);
                    setTimeout(() => {
                        modalClose('addOtherInfoModal');
                        setTimeout(() => {
                            stopLoader();
                        }, 250);
                    }, 250);
                }, 250);
            }
        });
    })
    $('#addCasteForm').submit(function(ev) {
        startLoader();
        ev.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('addMovieCast', 'true');

        console.log(Array.from(formData));

        // return;
        $.ajax({
            url: '',
            type: 'post',
            contentType: false,
            processData: false,
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    // console.log(data);
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated Successfully'
                    });
                } else {
                    var errorMessage = data.message ? data.message : 'Error happening, please try again later';
                    alert('Error', errorMessage, 'error').then((result) => {})
                }
            },
            error: function(error) {
                console.log(error);
                alert('Error', 'There is some error into the server. Please try again later.', 'error');
            },
            complete: function(response) {
                setTimeout(() => {
                    tableReload('majorCasteTable');
                    setTimeout(() => {
                        modalClose('addCasteModal');
                        setTimeout(() => {
                            stopLoader();
                        }, 250);
                    }, 250);
                }, 250);
            }
        });
    })

    function editCastetem(id, image, name, gender, character, attribute) {
        $('#cast_id').val(id);
        castImage = image ? image : '/public/images/avatar.jpg';
        $('#cast_image_preview').attr('src', castImage);
        $('#cast_name').val(name);
        $('#cast_character').val(character);
        $('#cast_gender').val(gender);
        $('#cast_attribute').val(attribute);
        modalShow('addCasteModal');
    }

    function deleteCasteItem() {
        alert('This action will not revert back, as it will delete the item from your major casts list.', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '',
                    type: 'post',
                    data: {
                        deleteMovieCast: id
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            // console.log(data);
                            Toast.fire({
                                icon: 'success',
                                title: 'Deleted Successfully'
                            });
                        } else {
                            var errorMessage = data.message ? data.message : 'Error happening, please try again later';
                            alert('Error', errorMessage, 'error').then((result) => {})
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        alert('Error', 'There is some error into the server. Please try again later.', 'error');
                    },
                    complete: function(response) {
                        setTimeout(() => {
                            tableReload('majorCasteTable');
                            setTimeout(() => {
                                stopLoader();
                            }, 250);
                        }, 250);
                    }
                });
            } else {
                Toast.fire({
                    icon: 'success',
                    title: 'Good choice! You saved a day'
                });
            }
        })

    }

    function resetImageInput(inputId) {
        $("#" + inputId).wrap('<form>').closest('form').get(0).reset();
        $("#" + inputId).unwrap();

        $("#" + inputId).closest('.form-file').find('.form-file-label').html('Change');

    }
</script>
<script>
    var status_badge = $('#status_badge');

    function approveAllLive() {
        $.ajax({
            url: '',
            type: 'post',
            data: {
                approveListing: 'true'
            },
            success: function(response) {
                console.log(response);
                try {
                    var data = JSON.parse(response);
                    console.log(data);
                    if (data.success) {
                        status_badge.html('<span class="badge badge-dot bg-success">Approved & Live</span>');
                        Toast.fire({
                            icon: 'success',
                            title: 'Approved Successfully'
                        })
                    } else {
                        var errorMessage = data.message ? data.message : 'Error happening, please try again later';
                        alert('Error', errorMessage, 'error').then((result) => {})
                    }
                } catch (error) {
                    console.log(error);
                    var errorMessage = 'Error happening, please try again later';
                    alert('Error', errorMessage, 'error').then((result) => {})
                }
            },
            error: function(error) {
                console.log(error);
                alert('Error', 'There is some error into the server. Please try again later.', 'error');
            }
        })
    }

    var rejectListingModal = document.getElementById('rejectListingModal');
    rejectListingModal.addEventListener('hidden.bs.modal', function(event) {
        $('#reject_reason').val('');
    })

    $('#rejectListingForm').submit(function(ev) {
        ev.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: '',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                try {
                    var data = JSON.parse(response);
                    console.log(data);
                    if (data.success) {
                        status_badge.html('<span class="badge badge-dot bg-danger">In User Review</span>');
                        Toast.fire({
                            icon: 'success',
                            title: 'Rejected Successfully'
                        })
                        modalClose('rejectListingModal');
                    } else {
                        var errorMessage = data.message ? data.message : 'Error happening, please try again later';
                        alert('Error', errorMessage, 'error').then((result) => {})
                    }
                } catch (error) {
                    console.log(error);
                    var errorMessage = 'Error happening, please try again later';
                    alert('Error', errorMessage, 'error').then((result) => {})
                }
            },
            error: function(error) {
                console.log(error);
                alert('Error', 'There is some error into the server. Please try again later.', 'error');
            }
        })
    })
</script>
<?= $this->endSection() ?>