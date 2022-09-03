<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <?= view('Admin/Components/goToDashboard') ?>
            <h3 class="nk-block-title page-title"><?= isset($pagename) && $pagename ? $pagename : 'Dashboard' ?></h3>
        </div>
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDefault">
                                <em class="icon ni ni-plus"></em>
                                <span>Add New</span>
                                </a>
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
                    <th>Name</th>
                    <th>Total Events</th>
                    <th class="text-end"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entities as $key => $entity) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col">
                            <span><?= $key + 1 ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= $entity['name'] ?></span>
                        </td>
                        <td class="nk-tb-col">
                            <span><?= $entity['events'] ?></span>
                        </td>
                        <td class="nk-tb-col text-end" style="min-width:70px;padding:0;">
                            <button type="button" onclick="editData(<?= $entity['id'] ?>, '<?= $entity['name'] ?>')" class="btn btn-round btn-icon btn-sm btn-info"><em class="icon ni ni-edit"></em></button>
                            <button type="button" onclick="deleteData(<?= $entity['id'] ?>, <?= $entity['events'] ?>)" class="btn btn-round btn-icon btn-sm btn-danger"><em class="icon ni ni-trash"></em></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade zoom" id="modalDefault">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="addUpdate" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Add/Update</h5>
            </div>
            <div class="modal-body">
                <input hidden type="hidden" id="data_id" name="id" value="0">
                <input hidden type="hidden" name="addUpdate" value="true">
                <div class="form-group">
                    <label class="form-label" for="data_name">Name</label>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" maxlength="200" id="data_name" name="name" required>
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
    var data_id = $('#data_id');
    var data_name = $('#data_name');
    
    var modalDefault = document.getElementById('modalDefault');
    modalDefault.addEventListener('hidden.bs.modal', function(event) {
        data_id.val(0);
        data_name.val('');
    });

    function editData(id, name) {
        data_id.val(id);
        data_name.val(name);
        modalShow('modalDefault');
    }
    $('#addUpdate').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        console.log(Array.from(formData));
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
                        alert('', data.message).then(() => {
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
    async function deleteData(id, events) {
        if (events > 0) {
            alert('Unable to delete this category, as it will have ' + events + ' Events in it, please remove events from this category to delete that.', 'Error', 'error');
            return;
        }
        alert('', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    id: id,
                    deleteFestival: true
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