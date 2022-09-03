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

    /* #titleDiv,
    #contentDiv {
        display: none;
    } */

    #venueListRow .btn-group>.btn {
        display: inline-block !important;
    }

    #venueListRow .btn-group>.btn:first-child {
        border-top-left-radius: 0;
    }

    #venueListRow .btn-group>.btn:last-child {
        border-top-right-radius: 0;
    }

    #venueListRow .card-body {
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


<div id="accordion" class="accordion">

    <?php foreach ($totalPages as $key => $page) : ?>
        <div class="accordion-item">
            <a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-<?= $key ?>">
                <h6 class="title"><?= $page['name'] ?></h6>
                <span class="accordion-icon"></span>
            </a>
            <div class="accordion-body collapse" id="accordion-<?= $key ?>" data-bs-parent="#accordion">
                <div class="accordion-inner">
                    <div class="form-control-wrap titleDiv mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?= $pagedata[$page['key'] . 'title'] ?>" id="title<?= $key ?>" placeholder="Page Title" pageKey="<?= $page['key'] ?>" name="title">
                            <div class="input-group-append">
                                <button class="btn btn-success" onclick="saveData('title<?= $key ?>', 'title')"><em class="ni ni-check"></em></button>
                                <button class="btn btn-danger" onclick="deleteData('title<?= $key ?>', 'title')"><em class="ni ni-trash"></em></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-control-wrap contentDiv">
                        <div class="form-group">
                            <textarea class="form-control" pageKey="<?= $page['key'] ?>" name="content" id="content<?= $key ?>" placeholder="Page Content"><?= $pagedata[$page['key'] . 'content'] ?></textarea>
                        <div class="btn-group">
                            <button class="btn btn-success" onclick="saveData('content<?= $key ?>', 'content')"><em class="ni ni-check"></em></button>
                            <button class="btn btn-danger" onclick="deleteData('content<?= $key ?>', 'content')"><em class="ni ni-trash"></em></button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
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
    function saveData(dataIdPart, type, reload = false) {
        var input = $('#' + dataIdPart);

        var value = input.val();
        var pageKey = input.attr('pageKey');
        var columName = pageKey + type;

        var festivalData = {
            dataId: "<?= $pageId ?>",
            columnName: columName,
            columnValue: value,
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
                            if (<?= intval($pageId) ?> == 0 || reload) {
                                location.reload();
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

    function deleteData(dataIdPart, type) {
        var input = $('#' + dataIdPart);
        var pageKey = input.attr('pageKey');
        var columName = pageKey + type;

        var festivalData = {
            dataId: "<?= $pageId ?>",
            columnName: columName,
            deleteData: 'true'
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
                            // delete from DOM
                            input.val('');
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