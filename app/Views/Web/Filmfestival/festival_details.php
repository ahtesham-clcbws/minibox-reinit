<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('content') ?>
<style>
    .post-meta-date {
        text-transform: uppercase;
        color: #D8B069;
        letter-spacing: 2px;
        padding-right: 13px;
        border-right: 1px solid #ababab;
    }
</style>
<?php if (count($headlines) < 2) : ?>
    <style>
        .headlines-section article>iframe,
        .headlines-section article>figure {
            height: 345px;
        }

        .headlines-section article.smallArticle>figure,
        .headlines-section article.smallArticle>iframe {
            height: 190px !important;
        }
    </style>
<?php endif; ?>
<!-- HERO -->
<?php if (count($banners)) : ?>
    <section class="uk-section-small clearfix uk-padding-remove">
        <div class="uk-slider-container">
            <div id="splide" class="splide" style="visibility: visible;">
                <div class="splide__track">
                    <ul class="splide__list" style="transform: translateX(-2486.06px);">
                        <?php foreach ($banners as $key => $banner) : ?>
                            <li class="splide__slide">
                                <div class="uk-height-min-large uk-cover-container uk-border-rounded">
                                    <img src="<?= $banner['image'] ?>" alt="Alt img" class="uk-animation-reverse uk-transform-origin-top-right">
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!--IN THE HEADLINES-->
<?php if (count($headlines)) : ?>
    <div class="uk-section-small uk-section-default headlines-section">
        <div class="uk-container">
            <h4 class="uk-heading-line uk-text-bold uk-text-center uk-animation-slide-bottom-medium">
                <span>IN THE HEADLINES</span>
            </h4>
            <div class="uk-grid uk-grid-column-large uk-grid-divider" data-ukgrid="">
                <div class="<?= count($headlines) > 1 ? 'uk-width-2-3@m' : 'uk-width-1-1' ?>">
                    <article class="uk-section uk-section-small uk-text-center uk-padding-remove-top uk-animation-slide-bottom-medium">
                        <?php if ($headlines[0]['media_type'] === 'image') : ?>
                            <figure style="background-image:url(<?= $headlines[0]['media_url'] ?>);"></figure>
                        <?php endif; ?>
                        <?php if ($headlines[0]['media_type'] === 'video') : ?>
                            <?php if ($headlines[0]['video_type'] === 'youtube') : ?>
                                <figure class="videoThumb" style="background-image:url(https://img.youtube.com/vi/<?= $headlines[0]['media_url'] ?>/hqdefault.jpg);"></figure>
                                <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'headlines', base64_encode($headlines[0]['news_id'])) ?>" uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon youtubeIcon" data-video="<?= $headlines[0]['media_url'] ?>"></a>
                            <?php endif; ?>
                            <?php if ($headlines[0]['video_type'] === 'vimeo') : ?>
                                <figure class="videoThumb" style="background-image:url(https://vumbnail.com/<?= $headlines[0]['media_url'] ?>.jpg);"></figure>
                                <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'headlines', base64_encode($headlines[0]['news_id'])) ?>" uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon vimeoIcon" data-video="<?= $headlines[0]['media_url'] ?>"></a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <header>
                            <h3 class="uk-margin-remove-adjacent uk-text-bold uk-margin-small-bottom">
                                <a class="uk-link-reset" href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'headlines', base64_encode($headlines[0]['news_id'])) ?>">
                                    <?= $headlines[0]['title'] ?>
                                </a>
                            </h3>
                            <div class="uk-article-meta uk-text-center text-color">
                                <?= date('F d, Y', strtotime($headlines[0]['created_at'])); ?>
                            </div>
                            <p class="post-excerpt">
                                <?= $headlines[0]['summary'] ?>
                            </p>
                        </header>
                        <!-- <p>Description 2</p> -->
                    </article>
                    <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'headlines', base64_encode($headlines[0]['news_id'])) ?>" title="Read More" class="uk-button uk-button-default uk-width uk-read-more uk-button-large">READ MORE</a>
                </div>
                <?php if (count($headlines) > 1) : ?>
                    <div class="uk-width-1-3@m">
                        <article class="uk-section uk-section-small uk-text-center uk-padding-remove-top uk-animation-slide-bottom-medium smallArticle">
                            <?php if ($headlines[1]['media_type'] === 'image') : ?>
                                <figure style="background-image:url(<?= $headlines[1]['media_url'] ?>);"></figure>
                            <?php endif; ?>
                            <?php if ($headlines[1]['media_type'] === 'video') : ?>
                                <?php if ($headlines[1]['video_type'] === 'youtube') : ?>
                                    <figure class="videoThumb" style="background-image:url(https://img.youtube.com/vi/<?= $headlines[1]['media_url'] ?>/hqdefault.jpg);"></figure>
                                    <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'headlines', base64_encode($headlines[1]['news_id'])) ?>" uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon youtubeIcon" data-video="<?= $headlines[1]['media_url'] ?>"></a>
                                <?php endif; ?>
                                <?php if ($headlines[1]['video_type'] === 'vimeo') : ?>
                                    <figure class="videoThumb" style="background-image:url(https://vumbnail.com/<?= $headlines[1]['media_url'] ?>.jpg);"></figure>
                                    <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'headlines', base64_encode($headlines[1]['news_id'])) ?>" uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon vimeoIcon" data-video="<?= $headlines[1]['media_url'] ?>"></a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <header>
                                <h4 class="uk-margin-remove-adjacent uk-margin-small-bottom">
                                    <a class="uk-link-reset onlyTwoTitleLines" href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'headlines', base64_encode($headlines[1]['news_id'])) ?>">
                                        <?= $headlines[1]['title'] ?>
                                    </a>
                                </h4>
                                <div class="uk-article-meta uk-text-center text-color">
                                    <?= date('F d, Y', strtotime($headlines[1]['created_at'])); ?>
                                </div>
                            </header>
                        </article>
                        <article class="uk-section uk-section-small uk-text-center uk-padding-remove-top uk-animation-slide-bottom-medium smallArticle">
                            <?php if ($headlines[2]['media_type'] === 'image') : ?>
                                <figure style="background-image:url(<?= $headlines[2]['media_url'] ?>);"></figure>
                            <?php endif; ?>
                            <?php if ($headlines[2]['media_type'] === 'video') : ?>
                                <?php if ($headlines[2]['video_type'] === 'youtube') : ?>
                                    <figure class="videoThumb" style="background-image:url(https://img.youtube.com/vi/<?= $headlines[2]['media_url'] ?>/hqdefault.jpg);"></figure>
                                    <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'headlines', base64_encode($headlines[2]['news_id'])) ?>" uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon youtubeIcon" data-video="<?= $headlines[2]['media_url'] ?>"></a>
                                <?php endif; ?>
                                <?php if ($headlines[2]['video_type'] === 'vimeo') : ?>
                                    <figure class="videoThumb" style="background-image:url(https://vumbnail.com/<?= $headlines[2]['media_url'] ?>.jpg);"></figure>
                                    <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'headlines', base64_encode($headlines[2]['news_id'])) ?>" uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon vimeoIcon" data-video="<?= $headlines[2]['media_url'] ?>"></a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <header>
                                <h4 class="uk-margin-remove-adjacent uk-margin-small-bottom">
                                    <a class="uk-link-reset onlyTwoTitleLines" href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'headlines', base64_encode($headlines[2]['news_id'])) ?>">
                                        <?= $headlines[2]['title'] ?>
                                    </a>
                                </h4>
                                <div class="uk-article-meta uk-text-center text-color">
                                    <?= date('F d, Y', strtotime($headlines[2]['created_at'])); ?>
                                </div>
                            </header>
                        </article>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!--EVENTS-->
<?php if (count($events)) : ?>
    <div class="uk-section-small uk-animation-slide-bottom-medium uk-padding-remove-top uk-padding-remove-bottom">
        <div class="uk-container">
            <h4 class="uk-heading-line uk-text-bold uk-text-center">
                <span>EVENTS</span>
            </h4>
            <div class="uk-text-center uk-grid" uk-grid="">
                <?php foreach ($events as $key => $event) : ?>
                    <div class="uk-width-1-3@m">
                        <div class="uk-card uk-card-default">
                            <div class="ct-fancybox-layout4">
                                <div class="ct-fancybox-front">
                                    <figure class="eventShowcaseImage" style="background-image:url(<?= $event['image'] ?>);">
                                    </figure>
                                    <h2><?= date('d', strtotime($event['from_date'])) ?> <span><?= date('M Y', strtotime($event['from_date'])) ?></span></h2>
                                    <h3><?= $event['categoryName'] ?></h3>
                                </div>
                                <div class="ct-fancybox-back">
                                    <h2 class="text"><?= $event['categoryName'] ?></h2>
                                    <h4 class="text"><?= $event['title'] ?></h4>
                                    <a href="<?= route_to('festival_event_details', $festivalSlug, base64_encode($event['id'])) ?>" title="View Detail" class="uk-button uk-button-secondary">View Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- <div class="uk-width-1-3@m">
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
            </div> -->
                <!-- <div class="uk-width-1-3@m">
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
            </div> -->
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Video Trailer -->
<?php if (count($trailers)) : ?>
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
                                        <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'trailers', base64_encode($trailer['news_id'])) ?>" uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon youtubeIcon" data-video="<?= $trailer['media_url'] ?>"></span>
                                        <?php endif; ?>
                                        <?php if ($trailer['video_type'] === 'vimeo') : ?>
                                            <figure class="videoThumb" style="background-image:url(https://vumbnail.com/<?= $trailer['media_url'] ?>.jpg);"></figure>
                                            <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'trailers', base64_encode($trailer['news_id'])) ?>" uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon vimeoIcon" data-video="<?= $trailer['media_url'] ?>"></a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="box-inner-p">
                                        <div class="box-inner-ellipsis">
                                            <div style="margin: 0px; padding: 0px; border: 0px;">
                                                <h2 class="entry-title h3">
                                                    <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'trailers', base64_encode($trailer['news_id'])) ?>">
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
<?php if (count($testimonials)) : ?>
    <div class="uk-container uk-position-z-index uk-section uk-animation-slide-bottom-medium uk-padding-remove-bottom">
        <h4 class="uk-heading-line uk-text-bold uk-text-center uk-text-uppercase"><span>Testimonial</span></h4>
        <div data-uk-slider="velocity: 5" class="uk-slider">
            <div class="uk-position-relative">
                <div class="uk-slider-container">
                    <ul class="uk-slider-items uk-child-width-1-1" style="transform: translate3d(0px, 0px, 0px);">
                        <?php foreach ($testimonials as $key => $testimonial) : ?>
                            <li class="<?= $key == 0 ? 'uk-active' : '' ?> uk-text-center">
                                <div class="testimonial-content">
                                    <div class="text-testimonial">
                                        <p class=""><?= html_entity_decode($testimonial['content']) ?></p>
                                    </div>
                                    <div class="testimonial-rating">
                                        <?php foreach (getStars('2.5') as $star) {
                                            echo $star;
                                        } ?>
                                    </div>
                                    <div class="testimonial-author-meta">
                                        <h3 class="testimonial-title"><?= $testimonial['name'] ?></h3>
                                        <?php if ($testimonial['designation'] && !empty($testimonial['designation'])) : ?>
                                            <p class="testimonial-position">/ <?= $testimonial['designation'] ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="uk-hidden@l uk-light">
                    <a class="uk-position-center-left uk-position-small uk-icon uk-slidenav-previous uk-slidenav" href="#" data-uk-slidenav-previous="" data-uk-slider-item="previous">
                        <svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                            <polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline>
                        </svg>
                    </a>
                    <a class="uk-position-center-right uk-position-small uk-icon uk-slidenav-next uk-slidenav" href="#" data-uk-slidenav-next="" data-uk-slider-item="next">
                        <svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                            <polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 ">
                            </polyline>
                        </svg>
                    </a>
                </div>
                <div class="uk-visible@l">
                    <a class="uk-position-center-left-out uk-position-small uk-icon uk-slidenav-previous uk-slidenav" href="#" data-uk-slidenav-previous="" data-uk-slider-item="previous">
                        <svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                            <polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline>
                        </svg>
                    </a>
                    <a class="uk-position-center-right-out uk-position-small uk-icon uk-slidenav-next uk-slidenav" href="#" data-uk-slidenav-next="" data-uk-slider-item="next">
                        <svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                            <polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 ">
                            </polyline>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Interviews -->
<?php if (count($interviews)) : ?>
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
                                        <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'interviews', base64_encode($interview['news_id'])) ?>" uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon youtubeIcon" data-video="<?= $interview['media_url'] ?>"></a>
                                    <?php endif; ?>
                                    <?php if ($interview['video_type'] === 'vimeo') : ?>
                                        <figure class="videoThumb" style="background-image:url(https://vumbnail.com/<?= $interview['media_url'] ?>.jpg);"></figure>
                                        <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'interviews', base64_encode($interview['news_id'])) ?>" uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon vimeoIcon" data-video="<?= $interview['media_url'] ?>"></a>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="box-inner-p">
                                    <div class="box-inner-ellipsis">
                                        <div style="margin: 0px; padding: 0px; border: 0px;">
                                            <h2 class="entry-title h3">
                                                <a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, 'interviews', base64_encode($interview['news_id'])) ?>">
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
    <h4 class="uk-heading-line uk-text-bold uk-text-center  uk-text-uppercase"><span>NEWSLETTER</span></h4>
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

<?= $this->endSection() ?>

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
</script>
<?= $this->endSection() ?>