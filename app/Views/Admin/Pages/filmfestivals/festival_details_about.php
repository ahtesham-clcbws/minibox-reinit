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

    #allIconInput,
    #titleDiv,
    #contentDiv,
    /* #icon1, */
    #icon_title1Div,
    #icon_content1Div,
    /* #icon2, */
    #icon_title2Div,
    #icon_content2Div,
    /* #icon3, */
    #icon_title3Div,
    #icon_content3Div,
    /* #icon4, */
    #icon_title4Div,
    #icon_content4Div {
        display: none;
    }

    .service-box {
        position: relative;
        padding: 40px 0;
        /* border-left: solid 1px rgba(0, 0, 0, 0.12); */
        border: solid 1px rgba(0, 0, 0, 0.12);
        background: #FFFFFF;
        text-align: center;
        /* color: #000; */
        margin-bottom: 30px;
        line-height: 1;
        font-size: 60px;
        width: 100%;
    }

    .service-box h3 {
        font-size: 20px;
        font-weight: 500;
        margin-bottom: 12px;
    }

    .service-box p {
        font-size: 14px;
        opacity: .6;
        margin: 0;
    }

    .iconEditButton {
        font-size: 17px;
        color: red;
        position: absolute;
        left: 60%;
    }

    .singleIcon {
        display: inline-block;
        font-size: 20px;
        border: 0.5px solid #8080805e;
        margin-bottom: 2px;
        border-radius: 5px;
        height: 35px;
        width: 35px;
        line-height: 34px;
        text-align: center;
        cursor: pointer;
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

<div class="row">
    <div class="col-12 pb-3 border-bottom mb-3">
        <span id="titleSpan">
            <h4>
                <em class="icon ni ni-edit customIcon titleIcon" onclick="openediter('title')" title="edit title"></em>
                <span id="titleText"><?= $pagedata['title'] ?></span>
            </h4>
        </span>
        <div class="form-control-wrap" id="titleDiv">
            <div class="input-group">
                <input type="text" class="form-control" value="<?= $pagedata['title'] ?>" id="titleInput" placeholder="Page title" name="title">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim" onclick="saveData('title')">Save</button>
                    <button class="btn btn-outline-danger" onclick="closesEditer('title')">Cancel</button>
                </div>
            </div>
        </div>

        <br />
        <span id="contentSpan">
            <em class="icon ni ni-edit customIcon" onclick="openediter('content')" title="edit description"></em>
            <span id="contentText"><?= $pagedata['content'] ?></span>
        </span>
        <div class="form-control-wrap" id="contentDiv">
            <div class="input-group">
                <textarea class="tinymce-basic form-control" name="content" id="contentInput"><?= $pagedata['content'] ?></textarea>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-dim" onclick="saveData('content')">Save</button>
                    <button class="btn btn-outline-danger" onclick="closesEditer('content')">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-3">
            <div class="service-box">
                <em class="icon ni ni-edit customIcon iconEditButton" onclick="openEditIcon(1, 'icon1')" title="edit icon"></em>
                <div class="service-icon" id="icon1Div">
                    <i class="<?= $pagedata['icon1'] ?>"></i>
                </div>
                <span id="icon_title1Span">
                    <h3>
                        <em class="icon ni ni-edit customIcon titleIcon" onclick="openediter('icon_title1')" title="edit title"></em>
                        <span id="icon_title1Text"><?= $pagedata['icon_title1'] ?></span>
                    </h3>
                </span>
                <div class="form-control-wrap" id="icon_title1Div">
                    <input type="text" class="form-control" value="<?= $pagedata['icon_title1'] ?>" id="icon_title1Input" placeholder="Icon title" name="icon_title1">
                    <div class="buttton-group">
                        <button class="btn btn-outline-primary btn-dim" onclick="saveData('icon_title1')"><i class="fa-solid fa-check"></i></button>
                        <button class="btn btn-outline-danger" onclick="closesEditer('icon_title1')"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
                <span id="icon_content1Span">
                    <p>
                        <em class="icon ni ni-edit customIcon titleIcon" onclick="openediter('icon_content1')" title="edit title"></em>
                        <span id="icon_content1Text"><?= $pagedata['icon_content1'] ?></span>
                    </p>
                </span>
                <div class="form-control-wrap" id="icon_content1Div">
                    <input type="text" class="form-control" value="<?= $pagedata['icon_content1'] ?>" id="icon_content1Input" placeholder="Icon title" name="icon_content1">
                    <div class="buttton-group">
                        <button class="btn btn-outline-primary btn-dim" onclick="saveData('icon_content1')"><i class="fa-solid fa-check"></i></button>
                        <button class="btn btn-outline-danger" onclick="closesEditer('icon_content1')"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="service-box">
                <em class="icon ni ni-edit customIcon iconEditButton" onclick="openEditIcon(2, 'icon2')" title="edit icon"></em>
                <div class="service-icon" id="icon2Div">
                    <i class="<?= $pagedata['icon2'] ?>"></i>
                </div>
                <span id="icon_title2Span">
                    <h3>
                        <em class="icon ni ni-edit customIcon titleIcon" onclick="openediter('icon_title2')" title="edit title"></em>
                        <span id="icon_title2Text"><?= $pagedata['icon_title2'] ?></span>
                    </h3>
                </span>
                <div class="form-control-wrap" id="icon_title2Div">
                    <input type="text" class="form-control" value="<?= $pagedata['icon_title2'] ?>" id="icon_title2Input" placeholder="Icon title" name="icon_title2">
                    <div class="buttton-group">
                        <button class="btn btn-outline-primary btn-dim" onclick="saveData('icon_title2')"><i class="fa-solid fa-check"></i></button>
                        <button class="btn btn-outline-danger" onclick="closesEditer('icon_title2')"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
                <span id="icon_content2Span">
                    <p>
                        <em class="icon ni ni-edit customIcon titleIcon" onclick="openediter('icon_content2')" title="edit title"></em>
                        <span id="icon_content2Text"><?= $pagedata['icon_content2'] ?></span>
                    </p>
                </span>
                <div class="form-control-wrap" id="icon_content2Div">
                    <input type="text" class="form-control" value="<?= $pagedata['icon_content2'] ?>" id="icon_content2Input" placeholder="Icon title" name="icon_content2">
                    <div class="buttton-group">
                        <button class="btn btn-outline-primary btn-dim" onclick="saveData('icon_content2')"><i class="fa-solid fa-check"></i></button>
                        <button class="btn btn-outline-danger" onclick="closesEditer('icon_content2')"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="service-box">
                <em class="icon ni ni-edit customIcon iconEditButton" onclick="openEditIcon(3, 'icon3')" title="edit icon"></em>
                <div class="service-icon" id="icon3Div">
                    <i class="<?= $pagedata['icon3'] ?>"></i>
                </div>
                <span id="icon_title3Span">
                    <h3>
                        <em class="icon ni ni-edit customIcon titleIcon" onclick="openediter('icon_title3')" title="edit title"></em>
                        <span id="icon_title3Text"><?= $pagedata['icon_title3'] ?></span>
                    </h3>
                </span>
                <div class="form-control-wrap" id="icon_title3Div">
                    <input type="text" class="form-control" value="<?= $pagedata['icon_title3'] ?>" id="icon_title3Input" placeholder="Icon title" name="icon_title3">
                    <div class="buttton-group">
                        <button class="btn btn-outline-primary btn-dim" onclick="saveData('icon_title3')"><i class="fa-solid fa-check"></i></button>
                        <button class="btn btn-outline-danger" onclick="closesEditer('icon_title3')"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
                <span id="icon_content3Span">
                    <p>
                        <em class="icon ni ni-edit customIcon titleIcon" onclick="openediter('icon_content3')" title="edit title"></em>
                        <span id="icon_content3Text"><?= $pagedata['icon_content3'] ?></span>
                    </p>
                </span>
                <div class="form-control-wrap" id="icon_content3Div">
                    <input type="text" class="form-control" value="<?= $pagedata['icon_content3'] ?>" id="icon_content3Input" placeholder="Icon title" name="icon_content3">
                    <div class="buttton-group">
                        <button class="btn btn-outline-primary btn-dim" onclick="saveData('icon_content3')"><i class="fa-solid fa-check"></i></button>
                        <button class="btn btn-outline-danger" onclick="closesEditer('icon_content3')"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="service-box">
                <em class="icon ni ni-edit customIcon iconEditButton" onclick="openEditIcon(4, 'icon4')" title="edit icon"></em>
                <div class="service-icon" id="icon4Div">
                    <i class="<?= $pagedata['icon4'] ?>"></i>
                </div>
                <span id="icon_title4Span">
                    <h3>
                        <em class="icon ni ni-edit customIcon titleIcon" onclick="openediter('icon_title4')" title="edit title"></em>
                        <span id="icon_title4Text"><?= $pagedata['icon_title4'] ?></span>
                    </h3>
                </span>
                <div class="form-control-wrap" id="icon_title4Div">
                    <input type="text" class="form-control" value="<?= $pagedata['icon_title4'] ?>" id="icon_title4Input" placeholder="Icon title" name="icon_title4">
                    <div class="buttton-group">
                        <button class="btn btn-outline-primary btn-dim" onclick="saveData('icon_title4')"><i class="fa-solid fa-check"></i></button>
                        <button class="btn btn-outline-danger" onclick="closesEditer('icon_title4')"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
                <span id="icon_content4Span">
                    <p>
                        <em class="icon ni ni-edit customIcon titleIcon" onclick="openediter('icon_content4')" title="edit title"></em>
                        <span id="icon_content4Text"><?= $pagedata['icon_content4'] ?></span>
                    </p>
                </span>
                <div class="form-control-wrap" id="icon_content4Div">
                    <input type="text" class="form-control" value="<?= $pagedata['icon_content4'] ?>" id="icon_content4Input" placeholder="Icon title" name="icon_content4">
                    <div class="buttton-group">
                        <button class="btn btn-outline-primary btn-dim" onclick="saveData('icon_content4')"><i class="fa-solid fa-check"></i></button>
                        <button class="btn btn-outline-danger" onclick="closesEditer('icon_content4')"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<input id="allIconInput" value="0">
<div class="modal fade" tabindex="-1" role="dialog" id="iconsPopup">
    <div class="modal-dialog modal-xl modal-dialog-bottom" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h4 class="title">Choose icon</h4>
                <div class="row">
                    <div class="col iconsList">
                        <?php foreach ($icons as $key => $icon) : ?>
                            <span class="singleIcon" onclick="getSetIcon('<?= $icon ?>')">
                                <i class="<?= $icon ?>"></i>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
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
    var iconsPopup = document.getElementById('iconsPopup')
    iconsPopup.addEventListener('hidden.bs.modal', function(event) {
        $('#allIconInput').val(0);
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

    function saveData(dataIdPart, reload = false) {
        var input = $('#' + dataIdPart + 'Input');
        var text = $('#' + dataIdPart + 'Text');

        // var oldData = $('#' + dataIdPart + 'Old');

        console.log(input.val());
        console.log(input.attr('name'));
        var festivalData = {
            dataId: "<?= $pageId ?>",
            columnName: input.attr('name'),
            columnValue: input.val(),
            updateData: 'true'
        };
        console.log(festivalData);
        // return;
        // if (oldData.val() != input.val()) {
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
                            if (<?= intval($pageId) ?> == 0 || reload) {
                                location.reload();
                            } else {
                                text.html(input.val());
                                closesEditer(dataIdPart);
                            }
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
        // } else {
        //     alert('', 'No new data found for saving', 'info');
        // }

    }

    function openEditIcon(id, iconId) {
        $('#allIconInput').val(id);
        modalShow('iconsPopup');
    }

    function getSetIcon(icon) {
        var defaultIcon = '<i class="fa-solid fa-heart"></i>';
        var newIconElement = '<i class="' + icon + '"></i>';
        Swal.fire({
            title: '<strong>Are you sure to use this ' + newIconElement + ' Icon!</strong>',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Save',
        }).then((result) => {
            if (result.isConfirmed) {
                if ($('#allIconInput').val() != 0) {
                    var iconNumber = 'icon' + $('#allIconInput').val();
                    var festivalData = {
                        dataId: "<?= $pageId ?>",
                        columnName: iconNumber,
                        columnValue: icon,
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
                                        $('#' + iconNumber + 'Div').html(newIconElement);
                                        // var modal = document.getElementById('iconsPopup')
                                        // var myModal = new bootstrap.Modal(modal);
                                        // myModal.hide();
                                        modalClose('iconsPopup');
                                        if (<?= intval($pageId) ?> == 0) {
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
                } else {
                    Swal.fire('Some error happened', '', 'info')
                }
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }
</script>
<?= $this->endSection() ?>