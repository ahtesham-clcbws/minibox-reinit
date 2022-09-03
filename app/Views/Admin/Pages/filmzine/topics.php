<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
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
                                <span>Add New topic</span>
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
                    <th>Topic</th>
                    <th>Color</th>
                    <th>Articles</th>
                    <th class="text-end"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topics as $key => $topic) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $topic['name'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <div class="custom-control color-control">
                                <label class="custom-control-label dot dot-xl" style="background-color:<?= $topic['color'] ?>;"></label>
                            </div>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $topic['articles'] ?>
                        </td>
                        <td class="nk-tb-col nk-tb-col-tools pe-2 text-end" style="min-width:70px;padding:0;">
                            <button type="button" onclick="editData(<?= $topic['id'] ?>, '<?= $topic['name'] ?>', '<?= $topic['color'] ?>')" class="btn btn-round btn-icon btn-sm btn-info"><em class="icon ni ni-edit"></em></button>
                            <button type="button" onclick="deleteData(<?= $topic['id'] ?>)" class="btn btn-round btn-icon btn-sm btn-danger"><em class="icon ni ni-trash"></em></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade zoom" id="modalDefault">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="modalDefaultForm" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Add/Update Topic</h5>
            </div>
            <div class="modal-body">
                <input hidden type="hidden" class="form-control" id="topic_id" name="id" value="0">
                <div class="form-group">
                    <label class="form-label" for="name">Name</label>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" maxlength="200" id="topic_name" name="name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="color">Color</label>
                    <div class="form-control-wrap">
                        <input type="color" class="form-control" id="topic_color" name="color" required>
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
    var topic_id = $('#topic_id');
    var topic_name = $('#topic_name');
    var topic_color = $('#topic_color');
    var modalDefault = document.getElementById('modalDefault');
    modalDefault.addEventListener('hidden.bs.modal', function(event) {
        topic_id.val(0);
        topic_name.val('');
        topic_color.val('');
    });

    function editData(id, dataName, dataColor) {
        topic_id.val(id);
        topic_name.val(dataName);
        topic_color.val(dataColor);
        modalShow('modalDefault');
    }
    $('#modalDefaultForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('add_update', 'true');
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
                        alert('Add/Update topic successfull.').then(() => {
                            location.reload();
                        })
                    } else {
                        alert('Undefined error, please try after some time.', 'Error', 'error').then(() => {
                            modalClose('modalDefault');
                        })
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
    async function deleteData(id) {
        alert('This action will not revert back, as it will delete from all articles you are connected with this topic.', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
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