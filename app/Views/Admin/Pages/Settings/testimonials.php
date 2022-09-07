<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<style>
    /* #movieRatingBlock, */
    /* #topic_name, */
    /* #type_name, */
    /* #imageInputBlock, */
    /* #imagePlaceholder, */
    /* #video_type_block, */
    #module_id_block {
        display: none;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <div class="nk-block-head-sub"><a class="back-to" href="<?= route_to('admin_settings') ?>"><em class="icon ni ni-arrow-left"></em><span>Main Settings</span></a></div>
            <h3 class="nk-block-title page-title"><?= isset($pagename) && $pagename ? $pagename : 'Settings' ?></h3>
        </div>
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUpdate">
                                <em class="icon ni ni-plus"></em>
                                <span>Add Testimonial</span>
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
                    <th>Person</th>
                    <th>Type</th>
                    <th>Content</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($testimonials as $key => $testimonial) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $testimonial['name'] ?>
                            <br />(<?= $testimonial['rating'] ?>) Stars / <?= $testimonial['designation'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= ucfirst($testimonial['type']) ?>
                            <?php if ($testimonial['type'] == 'festival') {
                                echo '<br/><b>' . $testimonial['festival_name'] . '</b>';
                            } ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= html_entity_decode($testimonial['content']) ?>
                        </td>
                        <td class="nk-tb-col text-end pe-0">
                            <div class="d-inline">
                                <div style="display:none;" id="decodedData<?= $testimonial['id'] ?>"><?= json_encode($testimonial) ?></div>
                                <a href="#" class="btn btn-trigger btn-icon" onclick="editData(<?= $testimonial['id'] ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <em class="icon ni ni-edit"></em>
                                </a>
                                <a href="#" class="btn btn-trigger btn-icon text-danger" onclick="deleteData(<?= $testimonial['id'] ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
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
<div class="modal fade zoom" tabindex="-1" id="addUpdate" enctype="multipart/form-data">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" enctype="multipart/form-data" id="addUpdateForm">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Add/Update</h5>
            </div>

            <div class="modal-body">
                <input type="hidden" hidden value="addTestimonial" name="addTestimonial">
                <input type="hidden" hidden value="0" name="id" id="entity_id">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="type">Type</label>
                            <div class="form-control-wrap">
                                <select class="form-select" id="type" name="type" required>
                                    <option value="global" selected>Global</option>
                                    <option value="festival">Festival</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" id="module_id_block">
                        <div class="form-group">
                            <label class="form-label" for="module_id">Select <span id="module_name">Module</span></label>
                            <div class="form-control-wrap">
                                <select class="form-select" id="module_id" name="module_id">
                                    <option value="0" selected disabled></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="rating">Rating</label>
                            <div class="form-control-wrap">
                                <select class="form-select" id="rating" name="rating" required>
                                    <option value="" selected disabled></option>
                                    <option value="0.5">0.5</option>
                                    <option value="1.0">1.0</option>
                                    <option value="1.5">1.5</option>
                                    <option value="2.0">2.0</option>
                                    <option value="2.5">2.5</option>
                                    <option value="3.0">3.0</option>
                                    <option value="3.5">3.5</option>
                                    <option value="4.0">4.0</option>
                                    <option value="4.5">4.5</option>
                                    <option value="5.0">5.0</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="name">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" maxlength="200" id="name" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="designation">Designation</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" maxlength="200" id="designation" name="designation">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="content">Content</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="content" name="content"></textarea>
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
    var newsId = 0;

    const entity_id = $('#entity_id');
    const type = $('#type');
    const module_name = $('#module_name');
    const module_id = $('#module_id');
    const module_id_block = $('#module_id_block');

    const rating = $('#rating');
    const name = $('#name');
    const designation = $('#designation');
    const content = $('#content');

    var oldModuleId = 0;


    var addUpdate = document.getElementById('addUpdate');
    addUpdate.addEventListener('hidden.bs.modal', function(event) {
        entity_id.val(0);
        type.val('');
        module_id.val('');
        rating.val('');
        name.val('');
        designation.val('');
        content.val('');
        oldModuleId = 0;

        module_id.html('<option value="" selected disabled></option>');
        module_id.removeAttr('required');
        module_id_block.hide();
    });

    function editData(id) {
        var data = JSON.parse($('#decodedData' + id).html());
        entity_id.val(id);
        if (data.type != 'global') {
            oldModuleId = data.module_id;
        }
        type.val(data.type).change();
        // module_id.val(data.module_id);
        rating.val(data.rating);
        name.val(data.name);
        designation.val(data.designation);
        content.val(data.content);

        modalShow('addUpdate');
    }


    type.change(function(ev) {
        const value = $(this).val();
        const moduleName = value.charAt(0).toUpperCase() + value.slice(1);
        module_name.html(moduleName);
        var formData = {
            getmoduleData: value
        };
        if (value == 'festival') {
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
                            var moduleData = data.data;
                            // ajax request to get all festival names & ids
                            // <option value="0" selected disabled></option>
                            if (oldModuleId > 0) {
                                var options = '<option value=""></option>';
                            } else {
                                var options = '<option value="" selected disabled></option>';
                            }
                            if (moduleData.length > 0) {
                                moduleData.forEach(module => {
                                    var selected = oldModuleId == module.id ? 'selected' : '';
                                    options += '<option ' + selected + ' value="' + module.id + '">' + module.name + '</option>';
                                });
                                module_id.html(options);
                                module_id.attr('required', 'required');
                                module_id_block.show();
                            } else {
                                module_id.html('<option value="" selected disabled></option>');
                                module_id.removeAttr('required');
                                module_id_block.hide();
                                alert(data.message, 'Error', 'error');
                            }
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
        } else {
            module_id.html('<option value="" selected disabled></option>');
            module_id.removeAttr('required');
            module_id_block.hide();
        }
    });

    $('#addUpdateForm').submit(function(ev) {
        ev.preventDefault();
        const formData = new FormData($(this)[0]);
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
    })
</script>
<?= $this->endSection() ?>