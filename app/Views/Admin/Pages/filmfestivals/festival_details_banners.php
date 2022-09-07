<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<style>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBanner">
                        <em class="icon ni ni-plus"></em>
                        <span>Add Banner</span>
                    </button>
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="row gs-2">
    <?php foreach ($entities as $key => $banner) : ?>
        <div class="col-md-2 mb-2">
            <div class="card">
                <img src="<?= $banner['image'] ?>" class="card-img-top">
                <div class="card-footer text-muted p-0">
                    <div class="btn-group w-100 rounded-0 rounded-bottom" role="group">
                        <button type="button" class="btn btn-danger d-block rounded-0 rounded-bottom" onclick="deleteBanner(<?= $banner['id'] ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                            <em class="icon ni ni-trash"></em> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="modal fade zoom" tabindex="-1" id="addBanner" enctype="multipart/form-data">
    <div class="modal-dialog modal-sm" role="document">
        <form class="modal-content" id="addBannerForm" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Add Banner</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="bannerImageDiv">
                        <img src="/public/images/placeholder.jpg" id="bannerImageSrc" onclick="$('#image').click()">
                    </div>
                </div>
                <div class="form-group" style="display:none;">
                    <label class="form-label" for="banner_image_label">Image</label>
                    <div class="form-control-wrap">
                        <div class="form-file">
                            <input type="file" class="form-file-input" id="image" name="image" required onchange="previewBanner(event)">
                            <label class="form-file-label" for="image">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    var imageSizeValidated = false;
    var bannerImageSrc = $('#bannerImageSrc');
    var defaultBanner = '/public/images/placeholder.jpg';
    var addBanner = document.getElementById('addBanner');
    addBanner.addEventListener('hidden.bs.modal', function(event) {
        $('#bannerImageSrc').attr('src', defaultBanner);
        $('#data_id').val(0);
    })

    function previewBanner(event) {

        var fileUpload = event.target;
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
        if (regex.test(fileUpload.value.toLowerCase())) {
            //Check whether HTML5 is supported.
            if (typeof(fileUpload.files) != "undefined") {
                //Initiate the FileReader object.
                var reader = new FileReader();
                //Read the contents of Image File.
                reader.readAsDataURL(fileUpload.files[0]);
                reader.onload = function(e) {
                    //Initiate the JavaScript Image object.
                    var image = new Image();
                    //Set the Base64 string return from FileReader as source.
                    image.src = e.target.result;
                    image.onload = function await () {
                        //Determine the Height and Width.
                        var height = this.height;
                        var width = this.width;
                        if (height != 742 || width != 500) {
                            alert('', 'Height and Width must match 742x500 pixels', 'error');
                            imageSizeValidated = false;
                        } else {
                            console.log('image validated')
                            var output = document.getElementById('bannerImageSrc');
                            output.src = URL.createObjectURL(event.target.files[0]);
                            output.onload = function() {
                                URL.revokeObjectURL(output.src) // free memory
                            }
                            imageSizeValidated = true;
                        }
                    };
                }
            } else {
                alert('', "This browser does not support HTML5.", 'error');
                imageSizeValidated = false;
                return;
            }
        } else {
            alert('', "Please select a valid Image file.", 'error');
            imageSizeValidated = false;
            return;
        }

        // if (fileSizeValidation('image', 742, 500, true)) {
        //     console.log('image validated')
        //     var output = document.getElementById('bannerImageSrc');
        //     output.src = URL.createObjectURL(event.target.files[0]);
        //     output.onload = function() {
        //         URL.revokeObjectURL(output.src) // free memory
        //     }
        //     imageSizeValidated = true;
        // }
    }

    $('#addBannerForm').submit(function(e) {
        e.preventDefault();
        if (imageSizeValidated) {
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
                            alert('Successfully added/updated Image').then(() => {
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
            return;
        }
        alert('Please use proper image size before uploading', 'Error', 'error');
    });

    async function deleteBanner(id) {
        alert('This action will not delete the image permanently.', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
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