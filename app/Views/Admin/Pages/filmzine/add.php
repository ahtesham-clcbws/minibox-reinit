<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<style>
    #movieRatingBlock,
    #topic_name,
    #type_name,
    #imageInputBlock,
    #imagePlaceholder,
    #video_type_block,
    #video_url_block {
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

        <form enctype="multipart/form-data" id="article_form">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label" for="type_id">Type of Article</label>
                        <div class="form-control-wrap">
                            <select class="form-select js-select2" id="type_id" name="type_id" required>
                                <option value="" selected disabled></option>
                                <?php foreach ($types as $key => $value) : ?>
                                    <option value="<?= $value['id'] ?>" ratingType="<?= $value['rating'] ?>"><?= $value['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input hidden type="hidden" class="form-control" id="type_name" name="type_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="topic_id">Article Topic/Category</label>
                        <div class="form-control-wrap">
                            <select class="form-select js-select2" id="topic_id" name="topic_id" required>
                                <option value="" selected disabled></option>
                                <?php foreach ($topics as $key => $value) : ?>
                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input hidden type="hidden" class="form-control" id="topic_name" name="topic_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="title">Title</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" maxlength="200" id="title" name="title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="media_type">Media Type</label>
                        <div class="form-control-wrap">
                            <select class="form-select js-select2" id="media_type" name="media_type" required>
                                <option value="" selected disabled></option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="is_featured">Is Featured ?</label>
                                <div class="form-control-wrap">
                                    <ul class="custom-control-group g-3 align-center flex-wrap">
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="1" name="featured" id="featured-enable" required>
                                                <label class="custom-control-label" for="featured-enable">Yes</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="0" name="featured" id="featured-disable" checked required>
                                                <label class="custom-control-label" for="featured-disable">No</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="movieRatingBlock">
                                <label class="form-label" for="movie_rating">Rating</label>
                                <div class="form-control-wrap">
                                    <select class="form-select js-select2" id="movie_rating" name="movie_rating">
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
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="/public/images/placeholder2.jpg" id="imagePlaceholder">
                    <div class="form-group" id="imageInputBlock">
                        <label class="form-label" for="image_file">Image File</label>
                        <div class="form-control-wrap">
                            <div class="form-file">
                                <input type="file" class="form-file-input" id="image_input" name="image_input">
                                <label class="form-file-label" for="image_input">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="video_type_block">
                        <label class="form-label" for="video_type">Video Type</label>
                        <div class="form-control-wrap">
                            <select class="form-select js-select2" id="video_type" name="video_type">
                                <option value="" selected disabled></option>
                                <option value="youtube">Youtube</option>
                                <option value="vimeo">Vimeo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="video_url_block">
                        <label class="form-label" for="video_url">Video ID (you have to submit the URL)</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" onchange="parseVideoUrl()" maxlength="200" id="video_url" name="video_url">
                        </div>
                    </div>
                </div>
                <hr />
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="content">Article Content</label>
                        <div class="form-control-wrap">
                            <textarea class="tinymce-basic form-control" id="content" name="content"><?= isset($news['content']) && !empty($news['content']) ? html_entity_decode($news['content']) : '' ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-primary">Save Article</button>
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
    <?php if ($news != null && isset($news['id']) && !empty($news['id'])) : ?>
        newsId = <?= $news['id'] ?>;

    <?php endif; ?>
    const type_id = $('#type_id');
    const type_name = $('#type_name');
    const movie_rating = $('#movie_rating');
    const movieRatingBlock = $('#movieRatingBlock');

    const topic_id = $('#topic_id');
    const topic_name = $('#topic_name');

    const media_type = $('#media_type');
    const video_type = $('#video_type');

    const image_input = $('#image_input');
    const imagePlaceholder = $('#imagePlaceholder');
    const imageInputBlock = $('#imageInputBlock');
    const video_type_block = $('#video_type_block');
    const video_url = $('#video_url');
    const video_url_block = $('#video_url_block');

    type_id.change(function(ev) {
        var dataName = $('option:selected', this).text();
        console.log(dataName);
        type_name.val(dataName);
        var getRating = $('option:selected', this).attr('ratingType');
        console.log(getRating);
        if (getRating == '1') {
            if (newsId == 0) {
                movie_rating.attr('required', 'required');
            }
            movieRatingBlock.show();
        } else {
            movie_rating.removeAttr('required');
            movie_rating.val('').trigger('change');
            movieRatingBlock.hide();
        }
    })
    topic_id.change(function(ev) {
        var dataName = $('option:selected', this).text();
        topic_name.val(dataName);
    })
    media_type.change(function(ev) {
        var value = $(this).val();
        if (value == 'image') {
            if (newsId == 0) {
                image_input.attr('required', 'required');
            }
            imagePlaceholder.show();
            imageInputBlock.show();

            video_type.removeAttr('required');
            video_type_block.hide();
            video_url.removeAttr('required');
            // video_url.removeAttr('urltype');
        } else {
            image_input.removeAttr('required');
            imagePlaceholder.attr('src', placeholder2);
            imagePlaceholder.hide();
            imageInputBlock.hide();
            // show & required video type input
            if (newsId == 0) {
                video_type.attr('required', 'required');
            }
            video_type_block.show();
        }
    })
    video_type.change(function(ev) {
        var value = $(this).val();
        // show video input
        video_url.attr('urltype', value);
        video_url.attr('required', 'required');
        video_url_block.show();
    });
    image_input.change(function(ev) {
        var output = document.getElementById('imagePlaceholder');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    });

    function parseVideoUrl() {
        var urltype = video_url.attr('urltype');
        var width = '100%';
        var height = '250';
        var src = '';
        var extras = '';
        if (urltype == 'youtube') {
            src = 'https://www.youtube.com/embed/';
            extras = 'allow="accelerometer; autoplay; clipboard-write; encrypted-media;"'
        } else {
            src = 'https://player.vimeo.com/video/';
        }
        var videoId = videoUrlGetID(urltype);
        // console.log(videoId)
        video_url.val(videoId);
        // var iFrame = '<iframe width="' + width + '" height="' + height + '" src="' + src + videoId + '" ' + extras + ' frameborder="0"></iframe>';
        // videoPreviewFrame.html(iFrame);
        // <iframe width="100%" height="250" src="https://www.youtube.com/embed/{video_id}" frameborder="0"></iframe>
        // <iframe width="100%" height="250" src="https://player.vimeo.com/video/{video_id}" frameborder="0"></iframe>
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

</script>

<?php if ($news != null) : ?>
    <script>
        // 'type_id',
        <?php if (isset($news['type_id']) && !empty($news['type_id'])) : ?>
            $('#type_id').val('<?= $news['type_id'] ?>').trigger('change');
        <?php endif; ?>
        <?php if (isset($news['type_name']) && !empty($news['type_name'])) : ?>
            $('#type_name').val('<?= $news['type_name'] ?>');
        <?php endif; ?>
        <?php if (isset($news['movie_rating']) && !empty($news['movie_rating'])) : ?>
            $('#movie_rating').val('<?= $news['movie_rating'] ?>').trigger('change');
        <?php endif; ?>
        // 'featured',
        <?php if (isset($news['featured']) && !empty($news['featured'])) : ?>
            if (<?= $news['featured'] ?> == 1) {
                $('#featured-disable').removeAttr('checked');
                $('#featured-enable').attr('checked', 'checked');
            } else {
                $('#featured-enable').removeAttr('checked');
                $('#featured-disable').attr('checked', 'checked');
            }
        <?php endif; ?>
        // 'title',
        <?php if (isset($news['title']) && !empty($news['title'])) : ?>
            $('#title').val('<?= $news['title'] ?>');
        <?php endif; ?>
        // 'topic_id',
        <?php if (isset($news['topic_id']) && !empty($news['topic_id'])) : ?>
            $('#topic_id').val('<?= $news['topic_id'] ?>').trigger('change');
        <?php endif; ?>
        <?php if (isset($news['topic_name']) && !empty($news['topic_name'])) : ?>
            $('#topic_name').val('<?= $news['topic_name'] ?>');
        <?php endif; ?>
        // 'movie_rating',
        <?php if (isset($news['movie_rating']) && !empty($news['movie_rating'])) : ?>
            $('#movie_rating').val('<?= $news['movie_rating'] ?>');
        <?php endif; ?>

        <?php if (isset($news['media_type']) && !empty($news['media_type'])) : ?>
            $('#media_type').val('<?= $news['media_type'] ?>').trigger('change');
            if ('<?= $news['media_type'] ?>' == 'image') {
                imagePlaceholder.attr('src', '<?= $news['media_url'] ?>');
                video_url.val('');
            } else {
                imagePlaceholder.attr('src', placeholder2);
                <?php if (isset($news['video_type']) && !empty($news['video_type'])) : ?>
                    $('#video_type').val('<?= $news['video_type'] ?>').trigger('change');
                <?php endif; ?>
                video_url.val('<?= $news['media_url'] ?>');
            }
        <?php endif; ?>
    </script>
<?php endif; ?>
<script>
    $('#article_form').submit(function(ev) {
        ev.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('add_update', 'true');

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
                            window.location.href = '<?= route_to('admin_film_zine') ?>';
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
    })
</script>
<?= $this->endSection() ?>