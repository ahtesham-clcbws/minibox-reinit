<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<style>
    #banner_image_file {
        display: none;
    }

    .bannerImageDiv {
        position: relative;
    }

    .bannerImageIcon {
        position: absolute;
        top: 5px;
        left: 5px;
        padding: 5px;
        font-size: 20px;
        background-color: #fff;
        border-radius: 50%;
        cursor: pointer;
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBanner">
                                <em class="icon ni ni-plus"></em>
                                <span>Add Banner</span>
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
                    <th>Image</th>
                    <th>Title</th>
                    <th>Subtitle</th>
                    <th>Url</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($banners as $key => $banner) : ?>
                    <tr class="nk-tb-item">
                        <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>
                        <td class="nk-tb-col tb-col-md">
                            <img src="<?= $banner['image'] ?>" style="max-width: 50px;">
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $banner['title'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $banner['sub_title'] ?>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <?= $banner['url'] ?>
                        </td>
                        <td class="nk-tb-col text-end pe-0">
                            <div class="d-inline">
                                <a href="#" class="btn btn-trigger btn-icon" onclick="openEditBanner(<?= $banner['id'] ?>, '<?= $banner['image'] ?>', '<?= $banner['title'] ?>', '<?= $banner['sub_title'] ?>', '<?= $banner['url'] ?>')" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Banner">
                                    <em class="icon ni ni-edit"></em>
                                </a>
                                <a href="#" class="btn btn-trigger btn-icon text-danger" onclick="deleteBanner(<?= $banner['id'] ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Banner">
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
<div class="modal fade zoom" tabindex="-1" id="addBanner" enctype="multipart/form-data">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="addBannerForm" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Add/Update Banner</h5>
            </div>
            <input type="text" style="display:none;" id="banner_id" name="id" value="0" required>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="banner_image">Image</label>
                            <div class="bannerImageDiv">
                                <img src="/public/images/default-banner.jpg" id="bannerImageSrc">
                                <input type="file" id="banner_image_file" name="image" onchange="previewBanner(event)">
                                <em class="ni ni-camera bannerImageIcon" onclick="$('#banner_image_file').click()"></em>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label" for="banner_details">Details</label>
                            <div class="form-control-wrap" id="banner_details">
                                <input type="text" class="form-control mb-1" id="banner_title" placeholder="Banner Title" name="title" required>
                                <input type="text" class="form-control mb-1" id="banner_subtitle" placeholder="Banner Subtitle" name="sub_title" required>
                                <input type="url" class="form-control mb-1" id="banner_url" placeholder="Banner URL" name="url" required>
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
    var bannerImageSrc = $('#bannerImageSrc');
    var defaultBanner = '/public/images/default-banner.jpg';
    var addBanner = document.getElementById('addBanner')
    addBanner.addEventListener('hidden.bs.modal', function(event) {
        $('#bannerImageSrc').attr('src', defaultBanner);
        $('#banner_subtitle').val('');
        $('#banner_title').val('');
        $('#banner_url').val('');
        $('#banner_id').val(0);
    })

    function previewBanner(event) {
        var output = document.getElementById('bannerImageSrc');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    }

    function openEditBanner(id, image, title, subtitle, url) {
        $('#bannerImageSrc').attr('src', image);
        $('#banner_subtitle').val(subtitle);
        $('#banner_title').val(title);
        $('#banner_url').val(url);
        $('#banner_id').val(id);

        var myModal = new bootstrap.Modal(addBanner);
        myModal.show();
    }
    $('#addBannerForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('add_banner', 'true');
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
                        alert('Successfully added/updated Banner').then(() => {
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

    async function deleteBanner(id) {
        alert('This action will not delete the banner permanently.', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    id: id,
                    deleteBanner: true
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
                                alert('', 'Banner Deleted!', 'info').then(() => {
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