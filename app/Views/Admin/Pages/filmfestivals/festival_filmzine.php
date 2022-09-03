<?= $this->extend('Admin/Layout') ?>

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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDefault">
                        <em class="icon ni ni-plus"></em>
                        <span>Add Filmzine Data</span>
                    </button>
                </h3>
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
                    <th>Title</th>
                    <th>Type</th>
                    <th class="text-end"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entities as $key => $entity) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $entity['title'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?php if ($entity['type_id'] == '4') {
                                echo '<span class="badge bg-primary">Trailers</span>';
                            } elseif ($entity['type_id'] == '3') {
                                echo '<span class="badge bg-secondary">Interviews</span>';
                            } else {
                                echo '<span class="badge bg-gray">Headlines</span>';
                            } ?>
                        </td>
                        <td class="nk-tb-col text-end pe-0">
                            <div class="btn-group">
                                <a href="#" class="btn btn-trigger btn-icon text-danger" onclick="deleteData(<?= $entity['id'] ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
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

<div class="modal fade zoom" tabindex="-1" id="modalDefault">
    <div class="modal-dialog" role="document">
        <form class="modal-content" id="addUpdateForm" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Add Filmzine</h5>
            </div>
            <div class="modal-body">
                <div class="row g-4">

                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="filmzine_type">Type</label>
                            <div class="form-control-wrap">
                                <select class="form-select" id="filmzine_type" required>
                                    <option value="" selected disabled>Select Type</option>
                                    <option value="headlines">Headlines</option>
                                    <option value="trailers">Trailers</option>
                                    <option value="interviews">Interviews</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="articles_data_block" style="display:none;">
                        <div class="form-group">
                            <label class="form-label" for="articles_data">Filmzine Articles</label>
                            <div class="form-control-wrap">
                                <select class="form-select" id="articles_data" name="news_id" placeholder="Select an article" data-allow-clear="true" required>
                                    <option value="" selected disabled>Select an article</option>
                                </select>
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
<script>
    // getFilmzines('headlines')
    var filmzine_type = $('#filmzine_type');
    var articles_data = $('#articles_data');
    var articles_data_block = $('#articles_data_block');
    var modalDefault = document.getElementById('modalDefault');
    modalDefault.addEventListener('hidden.bs.modal', function(event) {
        var selectOptions = '<option value="" selected>Select an article</option>';
        articles_data.val('');
        articles_data.html(selectOptions);
        filmzine_type.val('');
        articles_data_block.hide();
    })

    filmzine_type.change(function(ev) {
        if ($(this).val()) {
            getFilmzines($(this).val());
        }
    })

    async function getFilmzines(type) {
        articles_data_block.hide();
        $.ajax({
            url: '',
            type: 'post',
            data: {
                getFilmzines: type
            },
            success: await
            function(response, textStatus, jqXHR) {
                var data = {};
                try {
                    data = JSON.parse(response);
                    console.log(data);
                    if (data.success == true) {
                        var filmZines = data.data;
                        var selectOptions = '<option value="" selected>Select an article</option>';
                        articles_data.val('');
                        if (filmZines.length > 0) {
                            filmZines.forEach(filmZine => {
                                selectOptions += '<option value="' + filmZine.id + '">' + filmZine.text + '</option>';
                            });
                            articles_data.html(selectOptions);
                            articles_data_block.show();
                        } else {
                            alert('', 'No Articles Found in this type, please try after add some articles in this type.', 'error');
                        }
                        // articles_data.empty().trigger("change");
                        // articles_data.select2('destroy');
                        // articles_data.select2({
                        //     placeholder: {
                        //         id: '-1', // the value of the option
                        //         text: 'Select an article'
                        //     },
                        //     data: data.data
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
    }

    $('#addUpdateForm').submit(function(ev) {
        ev.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('addFilmzines', 'addFilmzines');
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
                        alert('', 'Added').then(() => {
                            location.reload();
                        })
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
    });

    function deleteData(id) {
        $.ajax({
            url: '',
            type: 'post',
            data: {
                deleteData: id
            },
            success: function(response, textStatus, jqXHR) {
                var data = {};
                try {
                    data = JSON.parse(response);
                    console.log(data);
                    if (data.success == true) {
                        alert('', 'Deleted', 'info').then(() => {
                            location.reload();
                        })
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
    }
</script>
<?= $this->endSection() ?>