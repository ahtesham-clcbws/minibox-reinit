<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('content') ?>
<!-- /* article>figure {
overflow: hidden;
max-height: 300px;
} */ -->
<style>
    .headlines-section article {
        position: relative;
    }

    article.smallArticle a.uk-link-reset {
        /* font-size: 18px !important; */
        /* line-height: 2px !important; */
        /* font-weight: 700 !important; */
        color: inherit !important;
        text-decoration: none !important;
    }

    .headlines-section article>figure {
        height: 300px;
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .headlines-section article>iframe {
        height: 300px;
        width: 100%;
    }

    .smallArticle>figure {
        height: 250px;
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .smallArticle>iframe {
        height: 250px;
        width: 100%;
    }

    .videoIcon {
        position: absolute;
        top: 35%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        color: #fff;
        -webkit-box-shadow: 0 3px 5px 0 rgb(0 1 1 / 10%);
        box-shadow: 0 3px 5px 0 rgb(0 1 1 / 10%);
        cursor: pointer;
    }

    .videoIcon.youtubeIcon {
        background-color: #FF0000;
    }

    .videoIcon.vimeoIcon {
        background-color: #86c9ef;
    }
</style>
<?php if (count($headlines) < 2) : ?>
    <style>
        .headlines-section article>iframe,
        .headlines-section article>figure {
            height: 400px;
        }

        .headlines-section article.smallArticle>figure,
        .headlines-section article.smallArticle>iframe {
            height: 200px;
        }
    </style>
<?php endif; ?>
<!-- HERO -->
<section class="uk-section-small clearfix uk-padding-remove">
    <div class="uk-slider-container">
        <div id="splide" class="splide" style="visibility: visible;">
            <div class="splide__track">
                <ul class="splide__list" style="transform: translateX(-2486.06px);">
                    <li class="splide__slide">
                        <div class="uk-height-min-large uk-cover-container uk-border-rounded">
                            <img src="/public/images/1619419610-film-festival-5.jpg" alt="Alt img" class="uk-animation-reverse uk-transform-origin-top-right">
                        </div>
                    </li>
                    <li class="splide__slide">
                        <div class="uk-height-min-large uk-cover-container uk-border-rounded">
                            <img src="/public/images/film-festival-4.jpg" alt="Alt img" class="uk-animation-reverse uk-transform-origin-top-right">
                        </div>
                    </li>
                    <li class="splide__slide">
                        <div class="uk-height-min-large uk-cover-container uk-border-rounded">
                            <img src="/public/images/film-festival-3.jpg" alt="Alt img" class="uk-animation-reverse uk-transform-origin-top-right">
                        </div>
                    </li>
                    <li class="splide__slide">
                        <div class="uk-height-min-large uk-cover-container uk-border-rounded">
                            <img src="/public/images/film-festival-2.jpg" alt="Alt img" class="uk-animation-reverse uk-transform-origin-top-right">
                        </div>
                    </li>
                    <li class="splide__slide is-visible" aria-hidden="false" tabindex="0">
                        <div class="uk-height-min-large uk-cover-container uk-border-rounded">
                            <img src="/public/images/film-festival-1.jpg" alt="Alt img" class="uk-animation-reverse uk-transform-origin-top-right">
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!--IN THE HEADLINES-->
<div class="uk-section-small uk-section-default headlines-section">
    <div class="uk-container">
        <h4 class="uk-heading-line uk-text-bold uk-text-center uk-animation-slide-bottom-medium">
            <span>IN THE HEADLINES</span>
        </h4>
        <div class="uk-grid" data-ukgrid="">
            <div class="<?= count($headlines) > 1 ? 'uk-width-2-3@m' : 'uk-width-1-1' ?>">
                <article class="uk-section uk-section-small uk-padding-remove-top uk-animation-slide-bottom-medium">
                    <?php if ($headlines[0]['media_type'] === 'image') : ?>
                        <figure style="background-image:url(<?= $headlines[0]['media_url'] ?>);"></figure>
                    <?php endif; ?>
                    <?php if ($headlines[0]['media_type'] === 'video') : ?>
                        <?php if ($headlines[0]['video_type'] === 'youtube') : ?>
                            <figure class="videoThumb" style="background-image:url(https://img.youtube.com/vi/<?= $headlines[0]['media_url'] ?>/hqdefault.jpg);"></figure>
                            <span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon youtubeIcon youtubeThumb" data-video="<?= $headlines[0]['media_url'] ?>"></span>
                        <?php endif; ?>
                        <?php if ($headlines[0]['video_type'] === 'vimeo') : ?>
                            <figure class="videoThumb" style="background-image:url(https://vumbnail.com/<?= $headlines[0]['media_url'] ?>.jpg);"></figure>
                            <span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon vimeoIcon vimeoThumb" data-video="<?= $headlines[0]['media_url'] ?>"></span>
                        <?php endif; ?>
                    <?php endif; ?>
                    <header>
                        <h2 class="uk-margin-remove-adjacent uk-text-bold uk-margin-small-bottom">
                            <a class="uk-link-reset" href="<?= route_to('film_zine_article', $headlines[0]['slug']) ?>">
                                <?= $headlines[0]['title'] ?>
                            </a>
                        </h2>
                        <p class="uk-article-meta uk-text-center text-color">
                            <?= date('F d, Y', strtotime($headlines[0]['created_at'])); ?>
                        </p>
                    </header>
                    <!-- <p>Description 2</p> -->
                </article>
            </div>
            <?php if (count($headlines) > 1) : ?>
                <div class="uk-width-1-3@m">
                    <article class="uk-section uk-section-small uk-padding-remove-top uk-animation-slide-bottom-medium smallArticle">
                        <?php if ($headlines[1]['media_type'] === 'image') : ?>
                            <figure style="background-image:url(<?= $headlines[1]['media_url'] ?>);"></figure>
                        <?php endif; ?>
                        <?php if ($headlines[1]['media_type'] === 'video') : ?>
                            <?php if ($headlines[1]['video_type'] === 'youtube') : ?>
                                <figure class="videoThumb" style="background-image:url(https://img.youtube.com/vi/<?= $headlines[1]['media_url'] ?>/hqdefault.jpg);"></figure>
                                <span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon youtubeIcon youtubeThumb" data-video="<?= $headlines[1]['media_url'] ?>"></span>
                            <?php endif; ?>
                            <?php if ($headlines[1]['video_type'] === 'vimeo') : ?>
                                <figure class="videoThumb" style="background-image:url(https://vumbnail.com/<?= $headlines[1]['media_url'] ?>.jpg);"></figure>
                                <span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon vimeoIcon vimeoThumb" data-video="<?= $headlines[1]['media_url'] ?>"></span>
                            <?php endif; ?>
                        <?php endif; ?>
                        <header>
                            <h3 class="uk-margin-remove-adjacent uk-margin-small-bottom">
                                <a class="uk-link-reset" href="<?= route_to('film_zine_article', $headlines[1]['slug']) ?>">
                                    <?= $headlines[1]['title'] ?>
                                </a>
                            </h3>
                            <p class="uk-article-meta uk-text-center text-color">
                                <?= date('F d, Y', strtotime($headlines[1]['created_at'])); ?>
                            </p>
                        </header>
                    </article>
                </div>
            <?php endif; ?>
        </div>
        <a href="<?= route_to('film_zine') ?>" title="Read More" class="uk-button uk-button-default uk-width uk-read-more uk-button-large">READ MORE</a>
    </div>
</div>

<!--EVENTS-->
<div class="uk-section-small uk-animation-slide-bottom-medium uk-padding-remove-top uk-padding-remove-bottom">
    <div class="uk-container">
        <!-- <a href="http://sky360.in/filmzine" target="_blank" title="Read More" class="uk-button uk-button-default uk-align-center uk-width-1-3@m uk-read-more ">FilmZine</a> -->
        <h4 class="uk-heading-line uk-text-bold uk-text-center  ">
            <span>EVENTS</span>
        </h4>
        <div class="uk-text-center uk-grid" uk-grid="">
            <div class="uk-width-1-3@m uk-first-column">
                <div class="uk-card uk-card-default">
                    <div class="ct-fancybox-layout4">
                        <div class="ct-fancybox-front">
                            <img src="/public/images/1618988349-events-2.jpg">
                            <h2>04 <span>Apr 2021</span></h2>
                            <h3>ICFF</h3>
                        </div>
                        <div class="ct-fancybox-back">
                            <h2>ICFF</h2>
                            <h3>some test heading for discussion</h3>
                            <a href="http://sky360.in/mini_box_office/film-festival/mumbai-film-festival/events-page/Nzc=" title="View Detail" class="uk-button uk-button-secondary">View Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-3@m">
                <div class="uk-card uk-card-default">
                    <div class="ct-fancybox-layout4">
                        <div class="ct-fancybox-front">
                            <img src="/public/images/events-1.jpg">
                            <h2>14 <span>Apr 2021</span></h2>
                            <h3>ICFF</h3>
                        </div>
                        <div class="ct-fancybox-back">
                            <h2>ICFF</h2>
                            <h3>6th Indian Cine Film</h3>
                            <a href="http://sky360.in/mini_box_office/film-festival/mumbai-film-festival/events-page/NzY=" title="View Detail" class="uk-button uk-button-secondary">View Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-3@m">
                <div class="uk-card uk-card-default">
                    <div class="ct-fancybox-layout4">
                        <div class="ct-fancybox-front">
                            <img src="/public/images/events-1.jpg">
                            <h2>14 <span>Apr 2021</span></h2>
                            <h3>ICFF</h3>
                        </div>
                        <div class="ct-fancybox-back">
                            <h2>ICFF</h2>
                            <h3>6th Indian Cine Film</h3>
                            <a href="http://sky360.in/mini_box_office/film-festival/mumbai-film-festival/events-page/NzU=" title="View Detail" class="uk-button uk-button-secondary">View Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (count($trailers)) : ?>
    <!-- Video Trailer -->
    <section class="uk-section-small uk-padding-remove-bottom">
        <div class="uk-container uk-position-z-index uk-section uk-animation-slide-bottom-medium uk-padding-remove-bottom">
            <h4 class="uk-heading-line uk-text-bold uk-text-center uk-text-uppercase   ">
                <span>Video Trailer</span>
            </h4>
            <div class="uk-container">
                <div class="uk-text-center uk-grid" uk-grid="">
                    <?php foreach ($trailers as $tKey => $trailer) : ?>
                        <div class="uk-width-1-3@m uk-grid-margin">
                            <article class="gridlove-post gridlove-post-a gridlove-box smallArticle">
                                <?php if ($trailer['media_type'] === 'image') : ?>
                                    <figure style="background-image:url(<?= $trailer['media_url'] ?>);"></figure>
                                <?php endif; ?>
                                <?php if ($trailer['media_type'] === 'video') : ?>
                                    <?php if ($trailer['video_type'] === 'youtube') : ?>
                                        <figure class="videoThumb" style="background-image:url(https://img.youtube.com/vi/<?= $trailer['media_url'] ?>/hqdefault.jpg);"></figure>
                                        <span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon youtubeIcon youtubeThumb" data-video="<?= $trailer['media_url'] ?>"></span>
                                    <?php endif; ?>
                                    <?php if ($trailer['video_type'] === 'vimeo') : ?>
                                        <figure class="videoThumb" style="background-image:url(https://vumbnail.com/<?= $trailer['media_url'] ?>.jpg);"></figure>
                                        <span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon vimeoIcon vimeoThumb" data-video="<?= $trailer['media_url'] ?>"></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="box-inner-p">
                                    <div class="box-inner-ellipsis">
                                        <div style="margin: 0px; padding: 0px; border: 0px;">
                                            <h2 class="entry-title h3">
                                                <a href="<?= route_to('film_zine_article', $trailer['slug']) ?>">
                                                    <?= $trailer['title'] ?>
                                                </a>
                                            </h2>
                                            <!-- <p class="uk-text-left">som e Description :... </p> -->
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!--testimonials-->
<div class="uk-container uk-position-z-index uk-section uk-animation-slide-bottom-medium uk-padding-remove-bottom">
    <h4 class="uk-heading-line uk-text-bold uk-text-center uk-text-uppercase   "><span>Testimonial</span></h4>
    <div data-uk-slider="velocity: 5" class="uk-slider">
        <div class="uk-position-relative">
            <div class="uk-slider-container">
                <ul class="uk-slider-items uk-child-width-1-1" style="transform: translate3d(0px, 0px, 0px);">
                    <li tabindex="-1" class="uk-active uk-text-center" style="">
                        <div class="testimonial-content">
                            <div class="text-testimonial">
                                <p class="">
                                    <span class="">Flash Filmis an award winning creative production company working
                                        for various clients and agencies in both New York &amp; LA</span>
                                </p>
                            </div>
                            <div class="testimonial-rating">
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <div class="testimonial-author-meta">
                                <h3 class="testimonial-title">Alan Spider</h3>
                                <p class="testimonial-position">/ Manager</p>
                            </div>
                        </div>
                    </li>
                    <li tabindex="-1" class="uk-text-center" style="">
                        <div class="testimonial-content">
                            <div class="text-testimonial">
                                <p class="">
                                    <span class="">Flash Filmis an award winning creative production company working
                                        for various clients and agencies in both New York &amp; LA</span>
                                </p>
                            </div>
                            <div class="testimonial-rating">
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star-o"></span>
                                <span class="fa fa-star-o"></span>
                                <span class="fa fa-star-o"></span>
                            </div>
                            <div class="testimonial-author-meta">
                                <h3 class="testimonial-title">Alan Spider</h3>
                                <p class="testimonial-position">/ Manager</p>
                            </div>
                        </div>
                    </li>
                    <li tabindex="-1" class="uk-text-center" style="">
                        <div class="testimonial-content">
                            <div class="text-testimonial">
                                <p class="">
                                    <span class="">Flash Filmis an award winning creative production company working
                                        for various clients and agencies in both New York &amp; LA</span>
                                </p>
                            </div>
                            <div class="testimonial-rating">
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star-o"></span>
                                <span class="fa fa-star-o"></span>
                                <span class="fa fa-star-o"></span>
                                <span class="fa fa-star-o"></span>
                            </div>
                            <div class="testimonial-author-meta">
                                <h3 class="testimonial-title">Alan Spider</h3>
                                <p class="testimonial-position">/ Manager</p>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="uk-hidden@l uk-light">
                <a class="uk-position-center-left uk-position-small uk-icon uk-slidenav-previous uk-slidenav" href="http://sky360.in/mini_box_office/film-festival/mumbai-film-festival#" data-uk-slidenav-previous="" data-uk-slider-item="previous"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                        <polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline>
                    </svg></a>
                <a class="uk-position-center-right uk-position-small uk-icon uk-slidenav-next uk-slidenav" href="http://sky360.in/mini_box_office/film-festival/mumbai-film-festival#" data-uk-slidenav-next="" data-uk-slider-item="next"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                        <polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 ">
                        </polyline>
                    </svg></a>
            </div>
            <div class="uk-visible@l">
                <a class="uk-position-center-left-out uk-position-small uk-icon uk-slidenav-previous uk-slidenav" href="http://sky360.in/mini_box_office/film-festival/mumbai-film-festival#" data-uk-slidenav-previous="" data-uk-slider-item="previous"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                        <polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline>
                    </svg></a>
                <a class="uk-position-center-right-out uk-position-small uk-icon uk-slidenav-next uk-slidenav" href="http://sky360.in/mini_box_office/film-festival/mumbai-film-festival#" data-uk-slidenav-next="" data-uk-slider-item="next"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                        <polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 ">
                        </polyline>
                    </svg></a>
            </div>
        </div>
        <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
            <li uk-slider-item="0" class="uk-active"><a href="http://sky360.in/mini_box_office/film-festival/mumbai-film-festival"></a></li>
            <li uk-slider-item="1"><a href="http://sky360.in/mini_box_office/film-festival/mumbai-film-festival"></a></li>
            <li uk-slider-item="2"><a href="http://sky360.in/mini_box_office/film-festival/mumbai-film-festival"></a></li>
        </ul>
    </div>
</div>

<?php if (count($interviews)) : ?>
    <!-- Interviews -->
    <section class="uk-section-small uk-padding-remove-bottom">
        <div class="uk-container uk-position-z-index uk-animation-slide-bottom-medium">
            <h4 class="uk-heading-line uk-text-bold uk-text-center uk-text-uppercase   ">
                <span>Interviews</span>
            </h4>
            <div class="uk-container">
                <div class="uk-text-center uk-grid" uk-grid="">
                    <?php foreach ($interviews as $tKey => $interview) : ?>
                        <div class="uk-width-1-3@m uk-grid-margin">
                            <article class="gridlove-post gridlove-post-a gridlove-box smallArticle">
                                <?php if ($interview['media_type'] === 'image') : ?>
                                    <figure style="background-image:url(<?= $interview['media_url'] ?>);"></figure>
                                <?php endif; ?>
                                <?php if ($interview['media_type'] === 'video') : ?>
                                    <?php if ($interview['video_type'] === 'youtube') : ?>
                                        <figure class="videoThumb" style="background-image:url(https://img.youtube.com/vi/<?= $interview['media_url'] ?>/hqdefault.jpg);"></figure>
                                        <span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon youtubeIcon youtubeThumb" data-video="<?= $interview['media_url'] ?>"></span>
                                    <?php endif; ?>
                                    <?php if ($interview['video_type'] === 'vimeo') : ?>
                                        <figure class="videoThumb" style="background-image:url(https://vumbnail.com/<?= $interview['media_url'] ?>.jpg);"></figure>
                                        <span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon vimeoIcon vimeoThumb" data-video="<?= $interview['media_url'] ?>"></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="box-inner-p">
                                    <div class="box-inner-ellipsis">
                                        <div style="margin: 0px; padding: 0px; border: 0px;">
                                            <h2 class="entry-title h3">
                                                <a href="<?= route_to('film_zine_article', $interview['slug']) ?>">
                                                    <?= $interview['title'] ?>
                                                </a>
                                            </h2>
                                            <!-- <p class="uk-text-left">som e Description :... </p> -->
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>


    </section>
<?php endif; ?>

<!--WE CAN'T WAIT TO SEE YOU-->
<section class="uk-container uk-section uk-animation-slide-bottom-medium uk-padding-remove-bottom">
    <h4 class="uk-heading-line uk-text-bold uk-text-center  uk-text-uppercase   "><span>WE CAN'T WAIT TO SEE
            YOU</span></h4>
    <div class="uk-container uk-container-xsmall uk-text-center">
        <p>We make films &amp; drama. Sometimes we win awards or cause controversies. After a long time, we love
            what we do since we started doing it and never looked back. Now flying the flag for the next crop of
            storytellers.</p>
        <div class="uk-container uk-text-center uk-margin-medium uk-grid" uk-grid="">
            <div class="uk-width-1-4@m uk-first-column">
                <div class="count">50</div>
                <div class="gr-text-default">COUNTRIES</div>
            </div>
            <div class="uk-width-1-4@m">
                <div class="count">20</div>
                <div class="gr-text-default">FILMMAKERS</div>
            </div>
            <div class="uk-width-1-4@m">
                <div class="count">200</div>
                <div class="gr-text-default">YEARS</div>
            </div>
            <div class="uk-width-1-4@m">
                <div class="count">246</div>
                <div class="gr-text-default">AWARDS</div>
            </div>
        </div>
    </div>


</section>

<!--NEWSLETTER-->
<section class="uk-container uk-section uk-animation-slide-bottom-medium ">
    <h4 class="uk-heading-line uk-text-bold uk-text-center  uk-text-uppercase   "><span>NEWSLETTER</span></h4>
    <div class="uk-container-xsmall uk-margin-auto uk-text-center">
        <h2 class="heading-subscrib uk-text-italic">Subscribe to our newsletter.</h2>
        <form class="uk-grid uk-grid-collapse" action="http://sky360.in/mini_box_office/film-festival/mumbai-film-festival" method="post">
            <div class="uk-width-expand uk-first-column subscribe-email">
                <input class="uk-input" type="email" required="" name="email" placeholder="Subscribe to our newsletter">
            </div>
            <div class="subscribe-submit">
                <input class="uk-button" type="submit" value="Subscribe">
            </div>
        </form>
    </div>
</section>

<div id="youtubeModal" class="uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
        <button class="uk-modal-close-outside" type="button" uk-close></button>
        <iframe id="youtubeModalIframe" src="" width="1280" height="720" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen uk-video uk-responsive></iframe>
    </div>
</div>

<div id="vimeoModal" class="uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
        <button class="uk-modal-close-outside" type="button" uk-close></button>
        <iframe id="vimeoModalIframe" src="" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen width="1280" height="720" uk-video uk-responsive></iframe>
    </div>
</div>
<?= $this->endSection() ?>
<!-- <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/neYXuKSz9k8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
<!-- <iframe src="https://player.vimeo.com/video/462692105?h=948f95b102&autoplay=1&title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe> -->
<!-- <script src="https://player.vimeo.com/api/player.js"></script> -->
<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        var line1 = $('#line1').text();
        var line2 = $('#line2').text();
        var line3 = $('#line3').text();
        var logo = $('#mylogo');
        if ((line2.trim() == '') && (line3.trim() == '')) {
            logo.css("font-size", "30px");
        }
        if ((line3.trim() != '')) {
            logo.css("font-size", "65px");
        }
        var counters = $(".count");
        var countersQuantity = counters.length;
        var counter = [];

        for (i = 0; i < countersQuantity; i++) {
            counter[i] = parseInt(counters[i].innerHTML);
        }
        // console.log(countersQuantity);

        var count = function(start, value, id) {
            var localStart = start;
            setInterval(function() {
                if (localStart < value) {
                    localStart++;
                    counters[id].innerHTML = localStart;
                }
            }, 40);
        };

        for (j = 0; j < countersQuantity; j++) {
            count(0, counter[j], j);
        }
    });
</script>
<script>
    new Splide("#splide", {
        type: "loop",
        focus: "center",
        perPage: 4,
        breakpoints: {
            640: {
                perPage: 2,
            },
        }
    }).mount();
    var youtubeModal = $('#youtubeModal');
    var vimeoModal = $('#vimeoModal');

    var youtubeModalIframe = $('#youtubeModalIframe');
    var vimeoModalIframe = $('#vimeoModalIframe');

    UIkit.util.on('#youtubeModal', 'hide', function(ev, index) {
        youtubeModalIframe.attr('src', '');
    });
    UIkit.util.on('#vimeoModal', 'hide', function(ev, index) {
        vimeoModalIframe.attr('src', '');
    });

    var youtubeThumb = $('.youtubeThumb');
    youtubeThumb.on('click', function(ev) {
        var videoId = $(this).data('video');
        console.log(videoId);
        var videoLink = 'https://www.youtube-nocookie.com/embed/' + videoId;
        youtubeModalIframe.attr('src', videoLink);
        UIkit.modal(youtubeModal).show();
    })
    var vimeoThumb = $('.vimeoThumb');
    vimeoThumb.on('click', function(ev) {
        var videoId = $(this).data('video');
        console.log(videoId);
        var videoLink = 'https://player.vimeo.com/video/' + videoId + '?h=948f95b102&autoplay=1&title=0&byline=0&portrait=0';
        vimeoModalIframe.attr('src', videoLink);
        UIkit.modal(vimeoModal).show();
    })
</script>
<?= $this->endSection() ?>