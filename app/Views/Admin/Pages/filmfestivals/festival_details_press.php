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
                        <span>Add Press</span>
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
                    <th>Year</th>
                    <th>Title</th>
                    <th>Url</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entities as $key => $entity) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $entity['festival_year'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $entity['title'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <span class="text-break" style="max-width: 6rem;">
                                <?= $entity['url'] ?>
                            </span>
                        </td>
                        <td class="nk-tb-col text-end pe-0">
                            <div class="btn-group">
                                <a href="#" class="btn btn-trigger btn-icon" onclick="openEdit(<?= $entity['id'] ?>, '<?= $entity['festival_year'] ?>', '<?= $entity['title'] ?>', '<?= $entity['url'] ?>')" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <em class="icon ni ni-edit"></em>
                                </a>
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
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="addUpdateForm" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Add/Update Press</h5>
            </div>
            <input type="text" style="display:none;" id="data_id" name="id" value="0">
            <div class="modal-body">
                <div class="row g-4">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="festival_year">Year</label>
                            <div class="form-control-wrap">
                                <input type="number" minlength="4" maxlength="4" max="<?= $festival['current_year'] ?>" value="<?= $festival['current_year'] ?>" class="form-control" id="festival_year" name="festival_year" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label" for="press_title">Title</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control mb-1" id="press_title" placeholder="Title" name="title" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="press_link">URL/Link</label>
                            <div class="form-control-wrap">
                                <input type="url" class="form-control mb-1" id="press_link" placeholder="Press link" name="url" required>
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
    var modalDefault = document.getElementById('modalDefault')
    modalDefault.addEventListener('hidden.bs.modal', function(event) {
        $('#festival_year').val('');
        $('#press_title').val('');
        $('#press_link').val('');
        $('#data_id').val(0);
    })


    function openEdit(id, year, title, url) {
        $('#festival_year').val(year);
        $('#press_title').val(title);
        $('#press_link').val(url);
        $('#data_id').val(id);

        // var myModal = new bootstrap.Modal(addBanner);
        // myModal.show();
        modalShow('modalDefault');
    }
    $('#addUpdateForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('addUpdateData', 'true');
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
                        alert(data.message).then(() => {
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

    async function deleteData(id) {
        alert('This action will not delete the this news.', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    id: id,
                    deleteData: true
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
                                alert('', data.message, 'info').then(() => {
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