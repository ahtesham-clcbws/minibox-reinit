<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<style>
    /* .award_cat_details:not(:first-child) {
        padding-top: 15px;
        margin-top: 15px;
        border-top: 1px solid grey;
    } */
    .film_type_awards>span:not(:last-child)::after,
    .awards_cat_short_names:not(:last-child)::after {
        content: " | ";
    }

    .award_cat_details {
        position: relative;
        /* margin-bottom: 15px;
        margin-left: 15px; */
    }

    .award_cat_details .edit-icon {
        cursor: pointer;
    }

    .film_type_awards {
        max-width: 300px;
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddType">
                                <em class="icon ni ni-plus"></em>
                                <span>Add Type</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card card-bordered card-preview">
    <div class="card-inner">
        <table class="datatable-init table nk-tb-list nk-tb-ulist">
            <thead>
                <tr>
                    <th></th>
                    <th>Film Type</th>
                    <th>Awards</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($film_types as $key => $filmType) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $filmType['name'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $filmType['type'] ?>
                        </td>
                        <td class="nk-tb-col text-end pe-0">
                            <div class="d-inline">
                                <a href="#" class="btn btn-trigger btn-icon" onclick="openEditType(<?= $filmType['id'] ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Award">
                                    <em class="icon ni ni-edit"></em>
                                </a>
                                <a href="#" class="btn btn-trigger btn-icon text-danger" onclick="deleteType(<?= $filmType['id'] ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Award">
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
<div class="modal fade zoom" id="AddType">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="AddTypeForm" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Film / Project Type</h5>
            </div>
            <input type="text" style="display:none;" id="film_type_id" name="id" value="0" required>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="film_type_name">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="film_type_name" name="name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="film_type_type">Type</label>
                            <div class="form-control-wrap">
                                <div class="form-control-select">
                                    <select class="form-control" id="film_type_type" name="type" required>
                                        <option value="" selected disabled></option>
                                        <option value="Short">Short</option>
                                        <option value="Feature">Feature</option>
                                    </select>
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
    // $('.js-select2').select2({
    //     dropdownParent: $('.modal')
    // });
    var AddType = document.getElementById('AddType')
    AddType.addEventListener('hidden.bs.modal', function(event) {
        $('#film_type_id').val(0);
        $('#film_type_name').val('');
        $('.award_id_checkbox').each(function(index, element) {
            $(element).removeAttr('checked');
        })
    })

    function openEditType(id) {
        $.ajax({
            url: '',
            type: 'post',
            data: {
                id: id,
                getFilmType: 'true'
            },
            success: function(response, textStatus, jqXHR) {
                // console.log(response);
                var data = {};
                try {
                    data = JSON.parse(response);
                    if (data.success == true) {
                        $('#film_type_id').val(data.data.id);
                        $('#film_type_name').val(data.data.name);
                        $('#film_type_type').val(data.data.type);

                        var myModal = new bootstrap.Modal(AddType);
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
    $('#AddTypeForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('update_film_type', 'true');
        // console.log(Array.from(formData));
        // startLoader();
        // $('.award_id_checkbox').each(function(index, element) {
        //     console.log($(element).attr('checked'));
        //     if ($(element).attr('checked')) {
        //         // return alert('please select some awards before continue.', 'Error', 'error');
        //         // stopLoader()
        //     }
        // })
        // return;
        // stopLoader()
        $.ajax({
            url: '',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response, textStatus, jqXHR) {
                // console.log(response);
                var data = {};
                try {
                    data = JSON.parse(response);
                    // console.log(data);
                    if (data.success == true) {
                        alert('Successfully added/updated Type').then(() => {
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
    });

    async function deleteType(id) {
        alert('This action will not revert back.', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    id: id,
                    deleteType: true
                };
                $.ajax({
                    url: '',
                    type: 'post',
                    data: formData,
                    success: function(response, textStatus, jqXHR) {
                        // console.log(response);
                        var data = {};
                        try {
                            data = JSON.parse(response);
                            if (data.success == true) {
                                alert('', 'Deleted!', 'info').then(() => {
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