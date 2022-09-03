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

    .deadlineBlock {
        position: relative;
    }

    .film_type_awards:not(:last-child)::after {
        content: " | ";
    }

    .card+.card:not(.card .card + .card) {
        margin-top: 15px;
    }

    .deadlineButton {
        padding: 4px;
        position: absolute;
        right: 2px;
        top: 2px;
        width: 22px;
    }

    .ni-edit.deadlineButton {
        color: #4192da;
        /* right: 30px; */
        top: 30px;
    }

    .ni-trash.deadlineButton {
        color: red;
    }

    .deadlineBlock .card-body {
        max-width: 98%;
    }

    .deadlineBlock .form-control {
        padding-left: 5px !important;
        padding-right: 1px !important;
        min-width: 28% !important;
    }

    .awards_prices_control .custom-control-label {
        font-size: initial;
        line-height: inherit;
    }

    .awardsPricingTable thead tr th:not(:last-child),
    .awardsPricingTable tbody tr td:not(:last-child),
    .awardsPricingTable tfoot tr td:not(:last-child) {
        border-right: 1px solid #dbdfea !important;
    }

    .awardsPricingTable tbody tr td {
        border-bottom: 1px solid #dbdfea;
    }

    .awardsPricingTable tbody tr td:not(:first-child),
    .awardsPricingTable tfoot tr td:not(:first-child) {
        text-align: center;
    }

    .awardsPricingTable .form-control {
        max-width: fit-content;
    }

    .singleAward:not(:last-child)::after {
        content: " | ";
    }
</style>
<?php if ($festival['awards_prices'] == 'global') : ?>
    <style>
        #awardsPricingLoginContainer {
            display: none;
        }
    </style>
<?php endif; ?>
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
                <h5 class="nk-block-title">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#rulesModal">Edit Festival Rules</a>
                </h5>
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
    <div class="col-md-6 col-12">
        <div class="row">
            <div class="col-12 mb-4">
                <h5>Dates <small>(Year-Month-Day)</small></h5>
            </div>
            <div class="col-md-6 col-12 mb-2">
                <div class="form-control-wrap">
                    <h5 class="form-label" for="opening_date">Opening Date</h5>
                    <div class="input-group">
                        <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" onchange="saveDate('opening_date')" value="<?= $festival['opening_date'] ?>" placeholder="Opening Date" id="opening_date" name="opening_date" required>
                        <!-- <div class="input-group-append">
                            <button class="btn btn-outline-primary btn-dim" onclick="saveDate('opening_date')">Save</button>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12 mb-2">
                <div class="form-control-wrap">
                    <h5 class="form-label" for="event_date">Event Date</h5>
                    <div class="input-group">
                        <input type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" onchange="saveDate('event_date')" value="<?= $festival['event_date'] ?>" placeholder="Event Date" id="event_date" name="event_date" required>
                        <!-- <div class="input-group-append">
                            <button class="btn btn-outline-primary btn-dim" onclick="saveDate('event_date')">Save</button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="row">
            <div class="col-12 mb-4">
                <h5>Type</h5>
            </div>
            <div class="col-md-6 col-12 mb-2">
                <div class="form-group">
                    <h5 class="form-label" for="short_awards">Short Awards ?</h5>
                    <div class="form-control-wrap ">
                        <div class="form-control-select">
                            <select class="form-control" id="short_awards">
                                <option value="" disabled></option>
                                <option <?= $festival['short_awards'] == '1' ? 'selected' : '' ?> value="1">Yes</option>
                                <option <?= $festival['short_awards'] == '0' ? 'selected' : '' ?> value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12 mb-2">
                <div class="form-group">
                    <h5 class="form-label" for="feature_awards">Feature Awards ?</h5>
                    <div class="form-control-wrap ">
                        <div class="form-control-select">
                            <select class="form-control" id="feature_awards">
                                <option value="" disabled></option>
                                <option <?= $festival['feature_awards'] == '1' ? 'selected' : '' ?> value="1">Yes</option>
                                <option <?= $festival['feature_awards'] == '0' ? 'selected' : '' ?> value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row pt-3 pb-3 border-bottom">
    <h5> Project Types to Show </h5>
    <form class="col-12" id="projectTypesForm" method="post">
        <?php foreach ($allProjectTypes as $key => $projectType) : ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input project_types" <?= in_array($projectType['id'], $festival['project_types']) ? 'checked' : '' ?> name="project_types[]" type="checkbox" id="<?= $key ?>" value="<?= $projectType['id'] ?>">
                <label class="form-check-label" for="<?= $key ?>"><?= $projectType['name'] ?></label>
            </div>
        <?php endforeach; ?>
    </form>
</div>
<div class="row pt-3 pb-3 border-bottom">
    <h5> Award Categories to Show </h5>
    <form class="col-12" id="awardCatForm" method="post">
        <?php foreach ($awardCats as $key => $awardCat) : ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input award_category_to_show" <?= in_array($awardCat['id'], $festival['award_category_to_show']) ? 'checked' : '' ?> name="award_category_to_show[]" type="checkbox" id="<?= $key ?>" value="<?= $awardCat['id'] ?>">
                <label class="form-check-label" for="<?= $key ?>"><?= $awardCat['name'] ?></label>
            </div>
        <?php endforeach; ?>
    </form>
</div>
<?php if (count($festival['award_category_to_show'])) : ?>
    <form class="row pt-3 pb-3 border-bottom" id="awardsForm" method="post">
        <h5> Awards to Show </h5>
        <?php foreach ($awardCats as $key => $awardCat) : ?>
            <?php if (isset($awardCat['awards'])) : ?>
                <div class="col-12">
                    <b class="w-100 d-block"><?= $awardCat['name'] ?></b>
                    <?php foreach ($awardCat['awards'] as $key => $award) : ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input awards_to_show" <?= in_array($award['id'], $festival['awards_to_show']) ? 'checked' : '' ?> name="awards_to_show[]" type="checkbox" id="<?= $award['id'] . $key ?>" value="<?= $award['id'] ?>">
                            <label class="form-check-label" for="<?= $award['id'] . $key ?>"><?= $award['name'] ?></label>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </form>
<?php endif; ?>

<!-- Deadlines -->
<div class="row pt-3 pb-3 border-bottom">
    <div class="col-12 mb-4">
        <h5>Deadlines <em class="ni ni-plus-circle customIcon" data-bs-toggle="modal" data-bs-target="#addUpdateDeadline"></em></h5>
    </div>
    <div class="dol-12 mb-4" id="blocksOfDeadlines">
        <?php foreach ($festival['deadlines'] as $deadline) : ?>
            <div class="card shadow deadlineBlock" id="deadlineBlock<?= $deadline['id'] ?>">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-3 col-12">
                            <label>Deadline Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="deadlineName<?= $deadline['id'] ?>" value="<?= $deadline['name'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <label>Deadline Date</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="deadlineDate<?= $deadline['id'] ?>" value="<?= date('M d, Y', strtotime($deadline['deadline'])) ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <label>Student (% decrease)</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₹</span>
                                    </div>
                                    <input type="text" class="form-control" id="deadlineStudentInr<?= $deadline['id'] ?>" value="<?= $deadline['student_inr'] ?>" disabled>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">€</span>
                                    </div>
                                    <input type="text" class="form-control" id="deadlineStudentEur<?= $deadline['id'] ?>" value="<?= $deadline['student_eur'] ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <label>Professional (% decrease)</label>
                            <div class="form-control-wrap">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₹</span>
                                    </div>
                                    <input type="text" class="form-control" id="deadlineProfessionalInr<?= $deadline['id'] ?>" value="<?= $deadline['professional_inr'] ?>" disabled>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">€</span>
                                    </div>
                                    <input type="text" class="form-control" id="deadlineProfessionalEur<?= $deadline['id'] ?>" value="<?= $deadline['professional_eur'] ?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <em class="ni ni-edit customIcon deadlineButton" onclick="editDeadline(<?= $deadline['id'] ?>)"></em>
                <em class="ni ni-trash customIcon deadlineButton" onclick="deleteDeadline(<?= $deadline['id'] ?>)"></em>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php if (count($festival['award_category_to_show']) && count($festival['awards_to_show'])) : ?>
    <div class="awardsPricingDiv pb-3 border-bottom">
        <div class="awardsPricingSelectionHeading text-center">
            <h4 class="pt-3 pb-2 text-center d-inline-block"> Awards Prices Type
                <div class="ms-3 d-inline-block" style="min-width: 130px;">
                    <div class="form-control-wrap">
                        <select class="form-select js-select2" name="awards_prices" id="awards_prices" required>
                            <option value="global" <?= $festival['awards_prices'] == 'global' ? 'selected' : '' ?>>Global</option>
                            <option value="custom" <?= $festival['awards_prices'] == 'custom' ? 'selected' : '' ?>>Custom</option>
                        </select>
                    </div>
                </div>
            </h4>
        </div>
        <div class="row pb-3" id="awardsPricingLoginContainer">
            <?php if ($festival['short_awards']) : ?>
                <form id="short_awards_form" onsubmit="return false;">
                    <table class="nk-tb-list nk-tb-ulist shadow mt-2 awardsPricingTable">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col border-bottom-0"><span class="sub-text"></span></th>
                                <th class="nk-tb-col text-center" colspan="2"><span class="sub-text">INR</span></th>
                                <th class="nk-tb-col text-center" colspan="2"><span class="sub-text">EUR</span></th>
                            </tr>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col"><span class="sub-text">Short Type Awards</span></th>
                                <th class="nk-tb-col text-center"><span class="sub-text">Student</span></th>
                                <th class="nk-tb-col text-center"><span class="sub-text">Professional</span></th>
                                <th class="nk-tb-col text-center"><span class="sub-text">Student</span></th>
                                <th class="nk-tb-col text-center"><span class="sub-text">Professional</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($festival['short_awards_prices'] as $key => $awardType) : ?>
                                <?php if ($awardType['award_count'] > 0) : ?>
                                    <tr class="nk-tb-item">
                                        <td class="nk-tb-col" style="max-width:300px;">
                                            <b><?= $awardType['award_name'] ?> Awards</b><br />
                                            <?php foreach ($awardType['awards'] as $aKey => $award) : ?>
                                                <span class="singleAward"><?= $award['name'] ?></span>
                                            <?php endforeach; ?>
                                            <input type="hidden" hidden name="short_awards_prices[<?= $key ?>][award_id]" value="<?= $awardType['award_id'] ?>">
                                            <input type="hidden" hidden name="short_awards_prices[<?= $key ?>][award_name]" value="<?= $awardType['award_name'] ?>">
                                            <input type="hidden" hidden name="short_awards_prices[<?= $key ?>][award_image]" value="<?= $awardType['award_image'] ?>">
                                        </td>
                                        <td class="nk-tb-col">
                                            <input type="number" class="form-control" name="short_awards_prices[<?= $key ?>][prices][inr][student]" value="<?= $awardType['prices']['inr']['student'] ?>" oninput="$('#short_awards_form').submit()">
                                        </td>
                                        <td class="nk-tb-col">
                                            <input type="number" class="form-control" name="short_awards_prices[<?= $key ?>][prices][inr][professional]" value="<?= $awardType['prices']['inr']['professional'] ?>" oninput="$('#short_awards_form').submit()">
                                        </td>
                                        <td class="nk-tb-col">
                                            <input type="number" class="form-control" name="short_awards_prices[<?= $key ?>][prices][eur][student]" value="<?= $awardType['prices']['eur']['student'] ?>" oninput="$('#short_awards_form').submit()">
                                        </td>
                                        <td class="nk-tb-col">
                                            <input type="number" class="form-control" name="short_awards_prices[<?= $key ?>][prices][eur][professional]" value="<?= $awardType['prices']['eur']['professional'] ?>" oninput="$('#short_awards_form').submit()">
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col text-end" colspan="5">
                                    <strong>INFO: </strong>These are the base maximum price for SHORT AWARDS in the festival.
                                </td>
                                <!-- <td class="nk-tb-col p-1">
                                    <button type="submit" class="btn btn-primary d-block w-100">Save</button>
                                </td> -->
                            </tr><!-- .nk-tb-item  -->
                        </tfoot>
                    </table>
                </form>
            <?php endif; ?>
            <?php if ($festival['feature_awards']) : ?>
                <form id="feature_awards_form" onsubmit="return false;">
                    <table class="nk-tb-list nk-tb-ulist shadow mt-2 awardsPricingTable">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col border-bottom-0"><span class="sub-text"></span></th>
                                <th class="nk-tb-col text-center" colspan="2"><span class="sub-text">INR</span></th>
                                <th class="nk-tb-col text-center" colspan="2"><span class="sub-text">EUR</span></th>
                            </tr>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col"><span class="sub-text">Feature Type Awards</span></th>
                                <th class="nk-tb-col text-center"><span class="sub-text">Student</span></th>
                                <th class="nk-tb-col text-center"><span class="sub-text">Professional</span></th>
                                <th class="nk-tb-col text-center"><span class="sub-text">Student</span></th>
                                <th class="nk-tb-col text-center"><span class="sub-text">Professional</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($festival['feature_awards_prices'] as $key => $awardType) : ?>
                                <?php if ($awardType['award_count'] > 0) : ?>
                                    <tr class="nk-tb-item">
                                        <td class="nk-tb-col" style="max-width:300px;">
                                            <b><?= $awardType['award_name'] ?> Awards</b><br />
                                            <?php foreach ($awardType['awards'] as $aKey => $award) : ?>
                                                <span class="singleAward"><?= $award['name'] ?></span>
                                            <?php endforeach; ?>
                                            <input type="hidden" hidden name="feature_awards_prices[<?= $key ?>][award_id]" value="<?= $awardType['award_id'] ?>">
                                            <input type="hidden" hidden name="feature_awards_prices[<?= $key ?>][award_name]" value="<?= $awardType['award_name'] ?>">
                                            <input type="hidden" hidden name="feature_awards_prices[<?= $key ?>][award_image]" value="<?= $awardType['award_image'] ?>">
                                        </td>
                                        <td class="nk-tb-col">
                                            <input type="number" class="form-control" name="feature_awards_prices[<?= $key ?>][prices][inr][student]" value="<?= $awardType['prices']['inr']['student'] ?>" oninput="$('#feature_awards_form').submit()">
                                        </td>
                                        <td class="nk-tb-col">
                                            <input type="number" class="form-control" name="feature_awards_prices[<?= $key ?>][prices][inr][professional]" value="<?= $awardType['prices']['inr']['professional'] ?>" oninput="$('#feature_awards_form').submit()">
                                        </td>
                                        <td class="nk-tb-col">
                                            <input type="number" class="form-control" name="feature_awards_prices[<?= $key ?>][prices][eur][student]" value="<?= $awardType['prices']['eur']['student'] ?>" oninput="$('#feature_awards_form').submit()">
                                        </td>
                                        <td class="nk-tb-col">
                                            <input type="number" class="form-control" name="feature_awards_prices[<?= $key ?>][prices][eur][professional]" value="<?= $awardType['prices']['eur']['professional'] ?>" oninput="$('#feature_awards_form').submit()">
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col text-end" colspan="5">
                                    <strong>INFO: </strong>These are the base maximum price for FEATURE AWARDS in the festival.
                                </td>
                                <!-- <td class="nk-tb-col p-1">
                                    <button type="submit" class="btn btn-primary d-block w-100">Save</button>
                                </td> -->
                            </tr><!-- .nk-tb-item  -->
                        </tfoot>
                    </table>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<div class="mb-5"></div>
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
                <div class="row g-4">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="form_deadline_name">Title/Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="form_deadline_name" name="name" placeholder="Deadline Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="form_deadline">Deadline</label>
                            <div class="form-control-wrap">
                                <div class="form-icon form-icon-right">
                                    <em class="icon ni ni-calendar-alt"></em>
                                </div>
                                <input type="text" class="form-control date-picker" autocomplete="new-deadline" id="form_deadline" name="deadline" data-date-start-date="<?= $festival['opening_date'] ?>" data-date-end-date="<?= $festival['event_date'] ?>" data-date-format="yyyy-mm-dd" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="student_price">Student</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₹</span>
                                </div>
                                <input type="text" class="form-control" id="form_student_inr" value="0" name="student_inr" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">€</span>
                                </div>
                                <input type="text" class="form-control" id="form_student_eur" value="0" name="student_eur" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label class="form-label" for="professional_price">Professional</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₹</span>
                                </div>
                                <input type="text" class="form-control" id="form_professional_inr" value="0" name="professional_inr" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">€</span>
                                </div>
                                <input type="text" class="form-control" id="form_professional_eur" value="0" name="professional_eur" required>
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
<div class="modal fade zoom" id="rulesModal">
    <div class="modal-dialog modal-xl" role="document">
        <form class="modal-content" id="rulesForm" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Festival Rules</h5>
            </div>
            <div class="modal-body">
                <textarea class="tinymce-basic form-control" id="festival_rules" name="rules"><?= isset($festival['rules']) && !empty($festival['rules']) ? html_entity_decode($festival['rules']) : '' ?></textarea>
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
<link rel="stylesheet" href="/public/admin/css/editors/tinymce.css?ver=3.0.0">
<script src="/public/admin/js/libs/editors/tinymce.js?ver=3.0.0"></script>
<script src="/public/admin/js/editors.js?ver=3.0.0"></script>
<script>
    var addUpdateDeadline = document.getElementById('addUpdateDeadline');
    addUpdateDeadline.addEventListener('hidden.bs.modal', function(event) {
        $('#deadline_id').val(0);
        $('#form_deadline_name').val('');
        $('#form_deadline').val('');

        $('#form_student_inr').val(0);
        $('#form_student_eur').val(0);
        $('#form_professional_inr').val(0);
        $('#form_professional_eur').val(0);
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
                        alert('', 'Data updated.', 'info').then(() => {})
                        location.reload()
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

    // festival logo
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

    // deadlines
    function createBlock(id, name, date, student_inr, student_eur, professional_inr, professional_eur) {
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
            var studentInr = $('#deadlineStudentInr' + id).val(student_inr);
            var studentEur = $('#deadlineStudentEur' + id).val(student_eur);
            var proInr = $('#deadlineProfessionalInr' + id).val(professional_inr);
            var proEur = $('#deadlineProfessionalEur' + id).val(professional_eur);
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
            var label = createHtmlElement('label', [], [], [], 'Deadline Name');
            var formControlWrap = createHtmlElement('div', ["form-control-wrap"], [], [input]);
            var column1 = createHtmlElement('div', ["col-md-3", "col-12"], [], [label, formControlWrap]);

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

            var label = createHtmlElement('label', [], [], [], 'Deadline Date');
            var formControlWrap = createHtmlElement('div', ["form-control-wrap"], [], [input]);
            var column2 = createHtmlElement('div', ["col-md-3", "col-12"], [], [label, formControlWrap]);

            var rupeeSpan = createHtmlElement('span', ["input-group-text"], [], [], '₹');
            var rupeeDiv = createHtmlElement('span', ["input-group-prepend"], [], [rupeeSpan]);

            var euroSpan = createHtmlElement('span', ["input-group-text"], [], [], '€');
            var euroDiv = createHtmlElement('span', ["input-group-prepend"], [], [euroSpan]);

            var inrInput = createHtmlElement('INPUT', ["form-control"], [{
                name: "type",
                value: "text"
            }, {
                name: "disabled",
                value: "disabled"
            }, {
                name: "id",
                value: "deadlineStudentInr" + id
            }]);
            inrInput.value = student_inr;

            var eurInput = createHtmlElement('INPUT', ["form-control"], [{
                name: "type",
                value: "text"
            }, {
                name: "disabled",
                value: "disabled"
            }, {
                name: "id",
                value: "deadlineStudentEur" + id
            }]);
            eurInput.value = student_eur;

            var inputGroup = createHtmlElement('span', ["input-group"], [], [rupeeDiv, inrInput, euroDiv, eurInput]);
            var formControlWrap = createHtmlElement('div', ["form-control-wrap"], [], [inputGroup]);
            var label = createHtmlElement('label', [], [], [], 'Student (% decrease)');
            var column3 = createHtmlElement('div', ["col-md-3", "col-sm-6", "col-12"], [], [label, formControlWrap]);

            var rupeeSpan = createHtmlElement('span', ["input-group-text"], [], [], '₹');
            var rupeeDiv = createHtmlElement('span', ["input-group-prepend"], [], [rupeeSpan]);

            var euroSpan = createHtmlElement('span', ["input-group-text"], [], [], '€');
            var euroDiv = createHtmlElement('span', ["input-group-prepend"], [], [euroSpan]);

            var inrInput = createHtmlElement('INPUT', ["form-control"], [{
                name: "type",
                value: "text"
            }, {
                name: "disabled",
                value: "disabled"
            }, {
                name: "id",
                value: "deadlineProfessionalInr" + id
            }]);
            inrInput.value = professional_inr;

            var eurInput = createHtmlElement('INPUT', ["form-control"], [{
                name: "type",
                value: "text"
            }, {
                name: "disabled",
                value: "disabled"
            }, {
                name: "id",
                value: "deadlineProfessionalEur" + id
            }]);
            eurInput.value = professional_eur;

            var inputGroup = createHtmlElement('span', ["input-group"], [], [rupeeDiv, inrInput, euroDiv, eurInput]);
            var formControlWrap = createHtmlElement('div', ["form-control-wrap"], [], [inputGroup]);
            var label = createHtmlElement('label', [], [], [], 'Professional (% decrease)');
            var column4 = createHtmlElement('div', ["col-md-3", "col-sm-6", "col-12"], [], [label, formControlWrap]);

            var columns = [column1, column2, column3, column4];

            var row = createHtmlElement('div', ["row"], [], columns);

            var icon1 = createHtmlElement('em', ["ni", "ni-edit", "customIcon", "deadlineButton"], [{
                name: 'onclick',
                value: 'editDeadline(' + id + ')'
            }]);
            var icon2 = createHtmlElement('em', ["ni", "ni-trash", "customIcon", "deadlineButton"], [{
                name: 'onclick',
                value: 'deleteDeadline(' + id + ')'
            }]);
            var cardBody = createHtmlElement('div', ["card-body"], [], [row, icon1, icon2]);
            var card = createHtmlElement('div', ["card", "shadow", "deadlineBlock"], [{
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

                        $('#form_student_inr').val(deadline.student_inr);
                        $('#form_student_eur').val(deadline.student_eur);
                        $('#form_professional_inr').val(deadline.professional_inr);
                        $('#form_professional_eur').val(deadline.professional_eur);
                        modalShow('addUpdateDeadline');
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
                        let timerInterval
                        Swal.fire({
                            title: 'Deadline Saved',
                            icon: 'info',
                            timer: 700,
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            var deadline = data.data;
                            console.log(deadline.id, deadline.name, deadline.deadline);

                            createBlock(deadline.id, deadline.name, deadline.deadline, deadline.student_inr, deadline.student_eur, deadline.professional_inr, deadline.professional_eur);
                            modalClose('addUpdateDeadline');
                        })
                        // alert('', 'Deadline Saved', 'info').then(() => {})
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

    $('#short_awards').on('change', function(e) {
        var value = $(this).val();
        awardTypeChange(value, 'short_awards');
    })

    $('#feature_awards').on('change', function(e) {
        var value = $(this).val();
        awardTypeChange(value, 'feature_awards');
    })

    function awardTypeChange(value, type) {
        var formData = {
            value: value,
            type: type,
            awardTypeChange: true
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
                        alert('', 'Type updated.', 'info').then(() => {})
                        location.reload()
                    } else {
                        alert(data.message, 'Warning', 'warning').then(() => {
                            location.reload();
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

    $('.project_types').on('change', function(e) {
        $('#projectTypesForm').submit();
    })
    $('#projectTypesForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('saveProjectTypes', 'true');
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
                        // alert('', 'Categories Saved', 'info');
                        // location.reload();
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
    });
    $('.award_category_to_show').on('change', function(e) {
        $('#awardCatForm').submit();
    })
    $('#awardCatForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('saveAwardCategories', 'true');
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
                        alert('', 'Categories Saved', 'info');
                        location.reload();
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
    });
    $('.awards_to_show').on('change', function(e) {
        $('#awardsForm').submit();
    })
    $('#awardsForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('saveAwards', 'true');
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
                        // alert('', 'Categories Saved', 'info');
                        // location.reload();
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
    });
    const awardsPricingLoginContainer = $('#awardsPricingLoginContainer');
    $('#awards_prices').on('change', function(event) {
        var pricesValue = $(this).val();
        var formData = {
            changeAwardPriceType: 'true',
            value: pricesValue
        };
        console.log(formData);

        if (pricesValue == 'global') {
            alert('This action will not revert back, as it will delete the already saved awards prices data in this festival.', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
                if (result.isConfirmed) {
                    awards_prices_submit(formData);
                } else {
                    alert('You saved a day.', 'Good choice!', 'success')
                }
            })
        } else {
            awards_prices_submit(formData);
        }
    })

    function awards_prices_submit(formData) {
        $.ajax({
            url: '',
            type: 'post',
            data: formData,
            success: function(response, textStatus, jqXHR) {
                console.log(response);
                var data = {};
                try {
                    data = JSON.parse(response);
                    console.log(data);
                    if (data.success == true) {
                        // change toggles
                        location.reload();
                        // if (pricesValue == 'global') {
                        //     // hide all awards panel with pricesLogic
                        //     awardsPricingLoginContainer.hide();
                        // } else {
                        //     // show all awards panel with pricesLogic
                        //     awardsPricingLoginContainer.show();
                        // }
                    } else {
                        if (pricesValue == 'global') {
                            // $(this).val('custom').trigger;
                        } else {}
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

    $('#short_awards_form').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('saveShortAwardsPrices', 'true');
        console.log(Array.from(formData));

        $.ajax({
            url: '',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response, textStatus, jqXHR) {
                var data = {};
                try {
                    data = JSON.parse(response);
                    console.log(data);
                    if (data.success == true) {
                        // alert('', 'Data updated.', 'info').then(() => {
                        //     stopLoader();
                        //     location.reload();
                        // })
                    } else {
                        console.log(response);
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
    $('#feature_awards_form').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('saveFeatureAwardsPrices', 'true');
        console.log(Array.from(formData));

        $.ajax({
            url: '',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response, textStatus, jqXHR) {
                var data = {};
                try {
                    data = JSON.parse(response);
                    console.log(data);
                    if (data.success == true) {
                        // alert('', 'Data updated.', 'info').then(() => {
                        //     stopLoader();
                        //     location.reload();
                        // })
                    } else {
                        console.log(response);
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

    $('#rulesForm').submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('rulesForm', 'true');
        console.log(Array.from(formData));

        $.ajax({
            url: '',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response, textStatus, jqXHR) {
                var data = {};
                try {
                    data = JSON.parse(response);
                    console.log(data);
                    if (data.success == true) {
                        // alert('', 'Data updated.', 'info').then(() => {
                        //     stopLoader();
                        //     location.reload();
                        modalClose('rulesModal');
                        // })
                    } else {
                        console.log(response);
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
</script>

<?= $this->endSection() ?>