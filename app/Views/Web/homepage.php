<?= $this->extend('Layouts/Web/home') ?>

<?= $this->section('content') ?>

<?php
$homeBanners = array(
    array(
        'title' => 'Film Festival',
        'sub_title' => 'Indian Cine Film Festival',
        'image' => '/public/images/1615811066-single-video-3.jpg',
        'url' => '/film-festival/indian-cine-film-festival'
    ),
    array(
        'title' => 'Film Market',
        'sub_title' => '',
        'image' => '/public/images/1641929350-single-video-2(1).jpg',
        'url' => '/film-market'
    ),
    array(
        'title' => 'Film Zine',
        'sub_title' => '',
        'image' => '/public/images/1615811145-single-video-10.jpg',
        'url' => '/film-zine'
    ),
    array(
        'title' => 'Prime Watch',
        'sub_title' => '',
        'image' => '/public/images/1615811104-single-video-8(1).jpg',
        'url' => '/prime-watch'
    ),
);
$banners = $homeBanners;
$banners = count(getHomepageBanners()) ? getHomepageBanners() : $homeBanners;
?>

<!-- HERO -->
<section class="uk-section-small clearfix uk-padding-remove-bottom uk-padding-remove-top">
    <div class="uk-slider-container">
        <div id="splide" class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php foreach ($banners as $key => $banner) : ?>
                        <li class="splide__slide">
                            <div class="video-image">
                                <div class="video-thumbnail-slideshow" data-speed="1000">
                                    <img src="<?= $banner['image'] ?>" alt="Facebook" style="display: block;">
                                </div>
                                <div class="video-icon">
                                    <a href="<?= $banner['url'] ?>" target="_blank" class="view-video-button" tabindex="0" uk-toggle>
                                    </a>
                                </div>
                                <div class="video-meta">
                                    <?php if (!empty($banner['sub_title'])) : ?>
                                        <div class="meta-wrap">
                                            <div class="video-meta-date"><?= $banner['sub_title'] ?></div>
                                        </div>
                                    <?php endif; ?>
                                    <h3 class="video-title"><a href="<?= $banner['url'] ?>" tabindex="0" target="_blank"><?= $banner['title'] ?></a></h3>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
    </div>
</section>
<!--IN THE HEADLINES-->
<div class="uk-section-small uk-section-default">
    <div class="uk-container">
        <h4 class="uk-heading-line uk-text-bold uk-text-center uk-animation-slide-bottom-medium"><span>IN THE
                HEADLINES</span></h4>
        <div class="uk-grid" data-ukgrid="">
            <div class="uk-width-2-3@m">
                <article class="uk-section uk-section-small uk-padding-remove-top uk-animation-slide-bottom-medium set-img">
                    <figure>
                        <div uk-slider="" class="uk-slider uk-slider-container">
                            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
                                <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-1@m" style="transform: translate3d(0px, 0px, 0px);">
                                    <li tabindex="-1" class="uk-active">
                                        <img src="/public/images/1615984438-b_730_d44d80bc-b199-4f03-9256-ba2c6c17b61b.jpg" alt="">

                                    </li>
                                </ul>
                                <a class="uk-position-center-left uk-position-small uk-hidden-hover uk-icon uk-slidenav-previous uk-slidenav uk-invisible" href="http://sky360.in/mini_box_office/#" uk-slidenav-previous="" uk-slider-item="previous" hidden=""><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                                        <polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline>
                                    </svg></a>
                                <a class="uk-position-center-right uk-position-small uk-hidden-hover uk-icon uk-slidenav-next uk-slidenav uk-invisible" href="http://sky360.in/mini_box_office/#" uk-slidenav-next="" uk-slider-item="next" hidden=""><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                                        <polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 "></polyline>
                                    </svg></a>
                            </div>
                        </div>
                    </figure>
                    <header>
                        <h2 class="uk-margin-remove-adjacent uk-text-bold uk-margin-small-bottom">
                            <a title="Fusce facilisis tempus magna ac dignissim." class="uk-link-reset" href="http://sky360.in/mini_box_office/stories-detail.php?id=8">Fusce facilisis
                                tempus magna ac dignissim.</a>
                        </h2>
                        <p class="uk-article-meta uk-text-center text-color">March 17, 2021</p>
                    </header>
                    <p>Description 5</p>
                    <a href="http://sky360.in/mini_box_office/stories-detail.php?id=8" title="Read More" class="uk-button uk-button-default uk-width uk-read-more uk-button-large">READ MORE</a>
                </article>
            </div>
            <div class="uk-width-1-3@m">
                <article class="uk-section uk-section-small uk-padding-remove-top uk-animation-slide-bottom-medium">
                    <figure>
                        <img src="/public/images/1615984392-slide26.jpg" width="840" height="440" alt="" class="lazy">
                    </figure>
                    <header>
                        <h2 class="uk-margin-remove-adjacent uk-margin-small-bottom uk-text-center"><a title="Story 4" class="uk-link-reset" href="http://sky360.in/mini_box_office/stories-detail.php?id=7">Story 4</a></h2>
                        <p class="uk-article-meta uk-text-center text-color">March 17, 2021 </p>
                    </header>
                    <hr>
                </article>
                <article class="uk-section uk-section-small uk-padding-remove-top uk-animation-slide-bottom-medium">
                    <figure>
                        <img src="/public/images/1618396918-article-1.jpg" width="840" height="440" alt="office Photo" class="lazy">
                    </figure>
                    <header>
                        <h2 class="uk-margin-remove-adjacent uk-margin-small-bottom uk-text-center"><a title="title" class="uk-link-reset" href="http://sky360.in/mini_box_office/stories-detail.php?id=27">title</a></h2>
                        <p class="uk-article-meta uk-text-center text-color">April 14, 2021 </p>
                    </header>
                </article>
            </div>
        </div>
    </div>
</div>
<!--EVENTS-->
<div class="uk-section-small uk-animation-slide-bottom-medium uk-padding-remove-top uk-padding-remove-bottom">
    <div class="uk-container">
        <a href="http://sky360.in/mini_box_office/filmzine/index.html" target="_blank" title="Read More" class="uk-button uk-button-default uk-align-center uk-width-1-3@m uk-read-more ">FilmZine</a>
        <h4 class="uk-heading-line uk-text-bold uk-text-center  "><span>EVENTS</span></h4>
        <div class="uk-text-center uk-grid" uk-grid="">
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
                            <a href="http://sky360.in/mini_box_office/events-page?id=MTQ=" title="View Detail" class="uk-button uk-button-secondary">View Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-3@m">
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
                            <a href="http://sky360.in/mini_box_office/events-page?id=MTU=" title="View Detail" class="uk-button uk-button-secondary">View Detail</a>
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
                            <a href="http://sky360.in/mini_box_office/events-page?id=MTQ=" title="View Detail" class="uk-button uk-button-secondary">View Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Video Trailer -->
<section class="uk-section-small uk-padding-remove-bottom">
    <div class="uk-container uk-position-z-index uk-section uk-animation-slide-bottom-medium uk-padding-remove-bottom">
        <h4 class="uk-heading-line uk-text-bold uk-text-center uk-text-uppercase   ">
            <span>Video Trailer</span>
        </h4>
        <div class="uk-container">
            <div class="uk-text-center uk-grid" uk-grid="">
                <div class="uk-width-1-3@m uk-first-column">
                    <article class="gridlove-post gridlove-post-a gridlove-box">
                        <div data-id="UWEjxkkB8Xs" data-target="magnificPopup" data-thumbnail="mqdefault" class="youtube"><a href="http://sky360.in/mini_box_office/#" class="preview"></a></div>

                        <div class="box-inner-p">
                            <div class="box-inner-ellipsis">
                                <div style="margin: 0px; padding: 0px; border: 0px;">
                                    <h2 class="entry-title h3">
                                        <a href="http://sky360.in/mini_box_office/video-trailer?id=MTM=">
                                            Why Buster Keaton’s visual comedy is still the best in a century-plus of
                                            cinema </a>
                                    </h2>
                                    <p class="uk-text-left">From the meticulous geometric framing of Wes Anderson to
                                        the droll deadpan of Bill Murray, the influ... </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="uk-width-1-3@m">
                    <article class="gridlove-post gridlove-post-a gridlove-box">
                        <div data-id="462692105" class="vimeo" data-target="magnificPopup" data-thumbnail="462692105_780x440"><a href="http://sky360.in/mini_box_office/#" class="preview"></a></div>

                        <div class="box-inner-p">
                            <div class="box-inner-ellipsis">
                                <div style="margin: 0px; padding: 0px; border: 0px;">
                                    <h2 class="entry-title h3">
                                        <a href="http://sky360.in/mini_box_office/video-trailer?id=MTI=">
                                            Are rock concerts really coming back into fashion? </a>
                                    </h2>
                                    <p class="uk-text-left">Monotonectally pursue backward-compatible ideas without
                                        empowered imperatives. Interactively predomi... </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="uk-width-1-3@m">
                    <article class="gridlove-post gridlove-post-a gridlove-box">
                        <div data-id="DsqFL6_Q_cI" data-target="magnificPopup" data-thumbnail="mqdefault" class="youtube"><a href="http://sky360.in/mini_box_office/#" class="preview"></a></div>

                        <div class="box-inner-p">
                            <div class="box-inner-ellipsis">
                                <div style="margin: 0px; padding: 0px; border: 0px;">
                                    <h2 class="entry-title h3">
                                        <a href="http://sky360.in/mini_box_office/video-trailer?id=MTE=">
                                            Are rock concerts really coming back into fashion? </a>
                                    </h2>
                                    <p class="uk-text-left">Monotonectally pursue backward-compatible ideas without
                                        empowered imperatives. Interactively predomi... </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="uk-width-1-3@m uk-grid-margin uk-first-column">
                    <article class="gridlove-post gridlove-post-a gridlove-box">
                        <div data-id="DsqFL6_Q_cI" data-target="magnificPopup" data-thumbnail="mqdefault" class="youtube"><a href="http://sky360.in/mini_box_office/#" class="preview"></a></div>

                        <div class="box-inner-p">
                            <div class="box-inner-ellipsis">
                                <div style="margin: 0px; padding: 0px; border: 0px;">
                                    <h2 class="entry-title h3">
                                        <a href="http://sky360.in/mini_box_office/video-trailer?id=MTA=">
                                            Are rock concerts really coming back into fashion? </a>
                                    </h2>
                                    <p class="uk-text-left">Monotonectally pursue backward-compatible ideas without
                                        empowered imperatives. Interactively predomi... </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="uk-width-1-3@m uk-grid-margin">
                    <article class="gridlove-post gridlove-post-a gridlove-box">
                        <div data-id="DsqFL6_Q_cI" data-target="magnificPopup" data-thumbnail="mqdefault" class="youtube"><a href="http://sky360.in/mini_box_office/#" class="preview"></a></div>

                        <div class="box-inner-p">
                            <div class="box-inner-ellipsis">
                                <div style="margin: 0px; padding: 0px; border: 0px;">
                                    <h2 class="entry-title h3">
                                        <a href="http://sky360.in/mini_box_office/video-trailer?id=OQ==">
                                            Are rock concerts really coming back into fashion? </a>
                                    </h2>
                                    <p class="uk-text-left">Monotonectally pursue backward-compatible ideas without
                                        empowered imperatives. Interactively predomi... </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="uk-width-1-3@m uk-grid-margin">
                    <article class="gridlove-post gridlove-post-a gridlove-box">
                        <div data-id="DsqFL6_Q_cI" data-target="magnificPopup" data-thumbnail="mqdefault" class="youtube"><a href="http://sky360.in/mini_box_office/#" class="preview"></a></div>

                        <div class="box-inner-p">
                            <div class="box-inner-ellipsis">
                                <div style="margin: 0px; padding: 0px; border: 0px;">
                                    <h2 class="entry-title h3">
                                        <a href="http://sky360.in/mini_box_office/video-trailer?id=OA==">
                                            Are rock concerts really coming back into fashion? </a>
                                    </h2>
                                    <p class="uk-text-left">Monotonectally pursue backward-compatible ideas without
                                        empowered imperatives. Interactively predomi... </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>

</section>

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
                    <li tabindex="-1" class="uk-text-center" style="">
                        <div class="testimonial-content">
                            <div class="text-testimonial">
                                <p class="">
                                    <span class="">Her face has the flawless sheen of Photoshop-adjusted models in
                                        cosmetics ads – an uncanny smoothness that leads us to make our own
                                        inferences about her character</span>
                                </p>
                            </div>
                            <div class="testimonial-rating">
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star-o"></span>
                            </div>
                            <div class="testimonial-author-meta">
                                <h3 class="testimonial-title">Jonathan Romney</h3>
                                <p class="testimonial-position">/ Author of Atom Egoyan (2003)</p>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="uk-hidden@l uk-light">
                <a class="uk-position-center-left uk-position-small uk-icon uk-slidenav-previous uk-slidenav" href="http://sky360.in/mini_box_office/#" data-uk-slidenav-previous="" data-uk-slider-item="previous"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                        <polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline>
                    </svg></a>
                <a class="uk-position-center-right uk-position-small uk-icon uk-slidenav-next uk-slidenav" href="http://sky360.in/mini_box_office/#" data-uk-slidenav-next="" data-uk-slider-item="next"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                        <polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 ">
                        </polyline>
                    </svg></a>
            </div>
            <div class="uk-visible@l">
                <a class="uk-position-center-left-out uk-position-small uk-icon uk-slidenav-previous uk-slidenav" href="http://sky360.in/mini_box_office/#" data-uk-slidenav-previous="" data-uk-slider-item="previous"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                        <polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline>
                    </svg></a>
                <a class="uk-position-center-right-out uk-position-small uk-icon uk-slidenav-next uk-slidenav" href="http://sky360.in/mini_box_office/#" data-uk-slidenav-next="" data-uk-slider-item="next"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                        <polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 ">
                        </polyline>
                    </svg></a>
            </div>
        </div>
        <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
            <li uk-slider-item="0" class="uk-active"><a href="http://sky360.in/mini_box_office/"></a></li>
            <li uk-slider-item="1" class=""><a href="http://sky360.in/mini_box_office/"></a></li>
            <li uk-slider-item="2" class=""><a href="http://sky360.in/mini_box_office/"></a></li>
            <li uk-slider-item="3" class=""><a href="http://sky360.in/mini_box_office/"></a></li>
        </ul>
    </div>
</div>

<!-- Interviews -->
<section class="uk-section-small uk-padding-remove-bottom">
    <div class="uk-container uk-position-z-index uk-animation-slide-bottom-medium">
        <h4 class="uk-heading-line uk-text-bold uk-text-center uk-text-uppercase   ">
            <span>Interviews</span>
        </h4>
        <div class="uk-container">
            <div class="uk-text-center uk-grid" uk-grid="">
                <div class="uk-width-1-3@m uk-first-column">
                    <article class="gridlove-post gridlove-post-a gridlove-box">
                        <div data-id="9y6Bkizc46o" data-target="magnificPopup" data-thumbnail="mqdefault" class="youtube"><a href="http://sky360.in/mini_box_office/#" class="preview"></a></div>

                        <div class="box-inner-p">
                            <div class="box-inner-ellipsis">
                                <div style="margin: 0px; padding: 0px; border: 0px;">
                                    <h2 class="entry-title h3">
                                        <a href="http://sky360.in/mini_box_office/interviews-detail?id=MTQ=">
                                            For millennia, we’d never seen anything like film cuts. How do we
                                            process them so easily? </a>
                                    </h2>
                                    <p class="uk-text-left">Before the emergence and rapid proliferation of film
                                        editing at the dawn of the 20th century, humans... </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="uk-width-1-3@m">
                    <article class="gridlove-post gridlove-post-a gridlove-box">
                        <div data-id="DsqFL6_Q_cI" data-target="magnificPopup" data-thumbnail="mqdefault" class="youtube"><a href="http://sky360.in/mini_box_office/#" class="preview"></a></div>

                        <div class="box-inner-p">
                            <div class="box-inner-ellipsis">
                                <div style="margin: 0px; padding: 0px; border: 0px;">
                                    <h2 class="entry-title h3">
                                        <a href="http://sky360.in/mini_box_office/interviews-detail?id=MTM=">
                                            test </a>
                                    </h2>
                                    <p class="uk-text-left">som e Description :... </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="uk-width-1-3@m">
                    <article class="gridlove-post gridlove-post-a gridlove-box">
                        <div data-id="DsqFL6_Q_cI" data-target="magnificPopup" data-thumbnail="mqdefault" class="youtube"><a href="http://sky360.in/mini_box_office/#" class="preview"></a></div>

                        <div class="box-inner-p">
                            <div class="box-inner-ellipsis">
                                <div style="margin: 0px; padding: 0px; border: 0px;">
                                    <h2 class="entry-title h3">
                                        <a href="http://sky360.in/mini_box_office/interviews-detail?id=Nw==">
                                            Are rock concerts really coming back into fashion? </a>
                                    </h2>
                                    <p class="uk-text-left">Monotonectally pursue backward-compatible ideas without
                                        empowered imperatives. Interactively predomi... </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="uk-width-1-3@m uk-grid-margin uk-first-column">
                    <article class="gridlove-post gridlove-post-a gridlove-box">
                        <div data-id="DsqFL6_Q_cI" data-target="magnificPopup" data-thumbnail="mqdefault" class="youtube"><a href="http://sky360.in/mini_box_office/#" class="preview"></a></div>

                        <div class="box-inner-p">
                            <div class="box-inner-ellipsis">
                                <div style="margin: 0px; padding: 0px; border: 0px;">
                                    <h2 class="entry-title h3">
                                        <a href="http://sky360.in/mini_box_office/interviews-detail?id=NQ==">
                                            Are rock concerts really coming back into fashion? </a>
                                    </h2>
                                    <p class="uk-text-left">Monotonectally pursue backward-compatible ideas without
                                        empowered imperatives. Interactively predomi... </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="uk-width-1-3@m uk-grid-margin">
                    <article class="gridlove-post gridlove-post-a gridlove-box">
                        <div data-id="DsqFL6_Q_cI" data-target="magnificPopup" data-thumbnail="mqdefault" class="youtube"><a href="http://sky360.in/mini_box_office/#" class="preview"></a></div>

                        <div class="box-inner-p">
                            <div class="box-inner-ellipsis">
                                <div style="margin: 0px; padding: 0px; border: 0px;">
                                    <h2 class="entry-title h3">
                                        <a href="http://sky360.in/mini_box_office/interviews-detail?id=NA==">
                                            Are rock concerts really coming back into fashion? </a>
                                    </h2>
                                    <p class="uk-text-left">Monotonectally pursue backward-compatible ideas without
                                        empowered imperatives. Interactively predomi... </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="uk-width-1-3@m uk-grid-margin">
                    <article class="gridlove-post gridlove-post-a gridlove-box">
                        <div data-id="DsqFL6_Q_cI" data-target="magnificPopup" data-thumbnail="mqdefault" class="youtube"><a href="http://sky360.in/mini_box_office/#" class="preview"></a></div>

                        <div class="box-inner-p">
                            <div class="box-inner-ellipsis">
                                <div style="margin: 0px; padding: 0px; border: 0px;">
                                    <h2 class="entry-title h3">
                                        <a href="http://sky360.in/mini_box_office/interviews-detail?id=Mw==">
                                            Are rock concerts really coming back into fashion? </a>
                                    </h2>
                                    <p class="uk-text-left">Monotonectally pursue backward-compatible ideas without
                                        empowered imperatives. Interactively predomi... </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>


</section>

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
                <div class="gr-text-default">Projects</div>
            </div>
            <div class="uk-width-1-4@m">
                <div class="count">100</div>
                <div class="gr-text-default">SATISFIED CLIENTS</div>
            </div>
            <div class="uk-width-1-4@m">
                <div class="count">20</div>
                <div class="gr-text-default">CUPS OF COFFEE</div>
            </div>
            <div class="uk-width-1-4@m">
                <div class="count">20</div>
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
        <form class="uk-grid uk-grid-collapse" action="http://sky360.in/mini_box_office/" method="post">
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

        var counters = $(".count");
        var countersQuantity = counters.length;
        var counter = [];

        for (i = 0; i < countersQuantity; i++) {
            counter[i] = parseInt(counters[i].innerHTML);
        }

        var count = function(start, value, id) {
            var localStart = start;
            setInterval(function() {
                if (localStart < value) {
                    localStart++;
                    counters[id].innerHTML = localStart;
                }
            }, 40);
        }

        for (j = 0; j < countersQuantity; j++) {
            count(0, counter[j], j);
        }
    });
</script>
<script>
    new Splide('#splide', {
        type: 'loop',
        autoWidth: true,
        focus: 'center',
        infinite: false,
        perPage: 3,
        padding: {
            right: '5rem',
            left: '5rem',
        },
    }).mount();
</script>
<?= $this->endSection() ?>