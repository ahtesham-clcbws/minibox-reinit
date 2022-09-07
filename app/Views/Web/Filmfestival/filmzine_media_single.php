<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('css') ?>
<style>
    /* .sharingBlock .meks_ess {
        background: #FFF;
        padding: 16px;
        text-align: center;
        margin-bottom: 0;
    } */
    .summary {
        margin-top: 10px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="uk-section-small detail-page-bg">
    <div class="uk-container">
        <article class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-bottom">
            <div class="entry-media">
                <?php if ($entities['current']['media_type'] === 'image') : ?>
                    <img src="<?= $entities['current']['media_url'] ?>">
                <?php endif; ?>
                <?php if ($entities['current']['media_type'] === 'video') : ?>
                    <figure class="wp-block-embed-youtube">
                        <div class="wp-block-embed__wrapper">
                            <?php if ($entities['current']['video_type'] === 'youtube') : ?>
                                <iframe width="100%" height="500" src="https://www.youtube-nocookie.com/embed/<?= $entities['current']['media_url'] ?>" width="100%" height="720" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <?php endif; ?>
                            <?php if ($entities['current']['video_type'] === 'vimeo') : ?>
                                <iframe width="100%" height="500" src="https://player.vimeo.com/video/<?= $entities['current']['media_url'] ?>?h=948f95b102&autoplay=1&title=0&byline=0&portrait=0" width="100%" height="720" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            <?php endif; ?>
                        </div>
                    </figure>
                <?php endif; ?>
            </div>
            <div class="box-inner-p-bigger box-single">
                <div class="entry-header">
                    <div class="entry-category">
                        <div class="sharingBlock">
                            <div class="meks_ess square solid ">
                                <a href="javascript:void(0);" class="socicon-facebook" title="facebook" aria-hidden="true" data-title="MiniBoxOffice" data-sharer="facebook" data-url="http://sky360.in/mini_box_office/film-festival/indian-film-festival/video-trailer/OQ==">
                                    <span uk-icon="facebook"></span>
                                </a>
                                <a href="javascript:void(0);" class="socicon-twitter" title="twitter" aria-hidden="true" data-title="MiniBoxOffice" data-sharer="twitter" data-url="http://sky360.in/mini_box_office/film-festival/indian-film-festival/video-trailer/OQ==">
                                    <span uk-icon="twitter"></span>
                                </a>
                                <a href="javascript:void(0);" class="socicon-instagram" title="instagram" data-title="MiniBoxOffice" data-sharer="instagram" data-url="http://sky360.in/mini_box_office/film-festival/indian-film-festival/video-trailer/OQ==">
                                    <span uk-icon="instagram"></span>
                                </a>
                                <a href="javascript:void(0);" class="socicon-whatsapp" title="whatsapp" aria-hidden="true" data-title="MiniBoxOffice" data-sharer="whatsapp" data-url="http://sky360.in/mini_box_office/film-festival/indian-film-festival/video-trailer/OQ==">
                                    <span uk-icon="whatsapp"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <h1 class="entry-title">
                        <?= $entities['current']['title'] ?>
                    </h1>
                </div>
                <div class="entry-content">
                    <?= html_entity_decode($entities['current']['content']) ?>
                </div>
            </div>
        </article>
        <div class="uk-text-center uk-grid" uk-grid="masonry: true">

            <?php foreach ($entities['all'] as $tKey => $entity) : ?>
                <div class="uk-width-1-3@m">
                    <article class="uk-card uk-card-default uk-card-hover uk-card-body uk-padding-remove smallArticle">
                        <?php if ($entity['media_type'] === 'image') : ?>
                            <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, $entityType, base64_encode($entity['news_id'])) ?>">
                                <!-- <figure style="background-image:url();"></figure> -->
								<img src="<?= $entity['media_url'] ?>">
                            </a>
                        <?php endif; ?>
                        <?php if ($entity['media_type'] === 'video') : ?>
                            <?php if ($entity['video_type'] === 'youtube') : ?>
                                <figure class="videoThumb" style="background-image:url(https://img.youtube.com/vi/<?= $entity['media_url'] ?>/mqdefault.jpg);"></figure>
                                <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, $entityType, base64_encode($entity['news_id'])) ?>">
                                    <span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon youtubeIcon youtubeThumb"></span>
                                </a>
                            <?php endif; ?>
                            <?php if ($entity['video_type'] === 'vimeo') : ?>
                                <figure class="videoThumb" style="background-image:url(https://vumbnail.com/<?= $entity['media_url'] ?>.jpg);"></figure>
                                <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, $entityType, base64_encode($entity['news_id'])) ?>">
                                    <span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon vimeoIcon vimeoThumb"></span>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>

                        <!-- <div class="youtube"><a href="#" class="preview"><img src="//img.youtube.com/vi/DsqFL6_Q_cI/mqdefault.jpg" alt="" width="100%"></a></div> -->

                        <div class="box-inner-p">
                            <div class="box-inner-ellipsis">
                                <div style="margin: 0px; padding: 0px; border: 0px;">
                                    <h2 class="entry-title h3">
                                        <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, $entityType, base64_encode($entity['news_id'])) ?>">
                                            <?= $entity['title'] ?>
                                        </a>
                                    </h2>
                                    <?= !empty($entity['summary']) ? '<p class="uk-text-left summary">' . $entity['summary'] . '</p>' : '' ?>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>

            <!-- <div class="uk-width-1-3@m">
                <article class="uk-card uk-card-default uk-card-hover uk-card-body uk-padding-remove">
                    <div class="youtube"><a href="#" class="preview"><img src="//img.youtube.com/vi/DsqFL6_Q_cI/mqdefault.jpg" alt="" width="100%"></a></div>

                    <div class="box-inner-p">
                        <div class="box-inner-ellipsis">
                            <div style="margin: 0px; padding: 0px; border: 0px;">
                                <h2 class="entry-title h3">
                                    <a href="#">
                                        Are rock concerts really coming back into fashion?
                                    </a>
                                </h2>
                                <p class="uk-text-left">Monotonectally pursue backward-compatible ideas without empowered imperatives. Interactively predomi... </p>
                            </div>
                        </div>
                    </div>
                </article>
            </div> -->

        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<?= $this->endSection() ?>