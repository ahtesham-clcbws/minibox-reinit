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
            <h3 class="nk-block-title page-title"><?= isset($pagename) && $pagename ? $pagename : 'Dashboard' ?></h3>
        </div>
    </div>
</div>
<div class="card card-bordered card-preview">
    <div class="card-inner">

        <form enctype="multipart/form-data" id="addUpdateForm">
            <input type="hidden" hidden value="addEvent" name="addEvent">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="event_type">Type of Event</label>
                        <div class="form-control-wrap">
                            <select class="form-select" id="event_type" name="type" required>
                                <option value="global" selected>Global</option>
                                <option value="festival">Festival</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-4 pb-4">
                        <div class="col" id="module_id_block">
                            <div class="form-group">
                                <label class="form-label" for="module_id">Select <span id="module_name">Module</span></label>
                                <div class="form-control-wrap">
                                    <select class="form-select" id="module_id" name="module_id">
                                        <option value="0" selected disabled></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="category">Category</label>
                                <div class="form-control-wrap">
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="" selected disabled></option>
                                        <?php foreach ($categories as $key => $value) : ?>
                                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Dates</label>
                        <div class="form-control-wrap">
                            <div class="input-daterange date-picker-range input-group" data-date-format="yyyy-mm-dd">
                                <input type="text" class="form-control" id="from_date" name="from_date" required />
                                <div class="input-group-addon">TO</div>
                                <input type="text" class="form-control" id="to_date" name="to_date" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Timing</label>
                        <div class="form-control-wrap">
                            <div class="input-group">
                                <input type="text" class="form-control time-picker" id="from_time" name="from_time" required />
                                <div class="input-group-addon">TO</div>
                                <input type="text" class="form-control time-picker" id="to_time" name="to_time" required />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="address">Address</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" maxlength="200" id="address" name="address" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="google_map">Google Map URL</label>
                        <div class="form-control-wrap">
                            <input type="url" class="form-control" id="google_map" name="google_map" required>
                            <input type="hidden" hidden id="latitude" name="latitude">
                            <input type="hidden" hidden id="longitude" name="longitude">
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="selectCountry">Country</label>
                                <div class="form-control-wrap">
                                    <select name="country" class="form-select" autocomplete="off" id="selectCountry" required>
                                        <option value="" selected="" disabled="">Select Country</option>
                                        <?php foreach (getAllCountries() as $kkey => $country) : ?>
                                            <option value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="selectState">State</label>
                                <div class="form-control-wrap">
                                    <select name="state" class="form-select" autocomplete="off" id="selectState" required>
                                        <option value="" selected="" disabled="">Select State</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="selectCity">City</label>
                                <div class="form-control-wrap">
                                    <select name="city" class="form-select" autocomplete="off" id="selectCity" required>
                                        <option value="" selected="" disabled="">Select City</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="pincode">Pin code</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" minlength="5" maxlength="7" id="pincode" name="pincode" required>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="latitude">Latitude <small>(optional)</small></label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="latitude" name="latitude">
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="longitude">Longitude <small>(optional)</small></label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="longitude" name="longitude">
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>

                <hr />

                <div class="col-lg-6">
                    <img src="/public/images/placeholder2.jpg" id="imagePlaceholder">
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="image_file">Image File</label>
                        <div class="form-control-wrap">
                            <div class="form-file">
                                <input type="file" class="form-file-input" id="image_input" name="image" required>
                                <label class="form-file-label" for="image_input">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="video_type">Video Type</label>
                        <div class="form-control-wrap">
                            <select class="form-select" id="video_type" name="video_type">
                                <option value="" selected>None</option>
                                <option value="youtube">Youtube</option>
                                <option value="vimeo">Vimeo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="video_url">Video ID (you have to submit the URL)</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" onchange="parseVideoUrl()" maxlength="200" id="video_url" name="video">
                        </div>
                    </div>
                </div>
                <hr />
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="title">Title</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" maxlength="200" id="title" name="title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="content">Content</label>
                        <div class="form-control-wrap">
                            <textarea class="tinymce-basic form-control" id="content" name="content"><?= isset($news['content']) && !empty($news['content']) ? html_entity_decode($news['content']) : '' ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<link rel="stylesheet" href="/public/admin/css/editors/tinymce.css?ver=3.0.0">
<script src="/public/admin/js/libs/editors/tinymce.js?ver=3.0.0"></script>
<script src="/public/admin/js/editors.js?ver=3.0.0"></script>

<script>
    var newsId = 0;

    const event_type = $('#event_type');
    const module_name = $('#module_name');
    const module_id = $('#module_id');
    const module_id_block = $('#module_id_block');

    const video_url = $('#video_url');
    const video_type = $('#video_type');

    const image_input = $('#image_input');
    const imagePlaceholder = $('#imagePlaceholder');

    const google_map = $('#google_map');
    const latitude = $('#latitude');
    const longitude = $('#longitude');

    event_type.change(function(ev) {
        const value = $(this).val();
        const moduleName = value.charAt(0).toUpperCase() + value.slice(1);
        module_name.html(moduleName);
        var formData = {
            getmoduleData: 'festival'
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
                            var options = '<option value="" selected disabled></option>';
                            if (moduleData.length > 0) {
                                moduleData.forEach(module => {
                                    options += '<option value="' + module.id + '">' + module.name + '</option>';
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
    video_type.change(function(ev) {
        var value = $(this).val();
        console.log(value)
        if (value) {
            video_url.attr('urltype', value);
            video_url.attr('required', 'required');
        } else {
            video_url.removeAttr('urltype');
            video_url.removeAttr('required');
        }
    });
    image_input.change(function(ev) {
        var output = document.getElementById('imagePlaceholder');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    });
    google_map.change(function(ev) {
        const value = $(this).val();
        if (value) {
            var longlat = /\/\@(.*),(.*),/.exec(value);
            latitude.val(longlat[1]);
            longitude.val(longlat[2]);
        } else {
            latitude.val('');
            longitude.val('');
        }
    });

    //     var url="https://www.google.com/maps/place/Arctic+Pixel+Digital+Solutions/@63.6741553,-164.9587713,4z/data=!3m1!4b1!4m5!3m4!1s0x5133b2ed09c706b9:0x66deacb5f48c5d57!8m2!3d64.751111!4d-147.3494442";

    // var longlat = /\/\@(.*),(.*),/.exec(url);

    // var lng = longlat[1]; //63.6741553
    // var lat = longlat[2]; //-164.9587713

    function parseVideoUrl() {
        var urltype = video_url.attr('urltype');
        var videoId = videoUrlGetID(urltype);
        video_url.val(videoId);
    }

    function videoUrlGetID(type) {
        var getId = null;
        var url = video_url.val();
        if (type == 'youtube') {
            getId = youtube_parser(url);
        } else {
            getId = vimeo_parser(url);
        }
        console.log(getId);
        return getId;
    }
    $('#addUpdateForm').submit(function(ev) {
        ev.preventDefault();
        const formData = new FormData($(this)[0]);
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
                            window.location.href = data.data;
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