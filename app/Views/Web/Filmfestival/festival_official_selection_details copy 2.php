<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('content') ?>
<style>
    .bannerSection {
        min-height: 525px;
        /* background-attachment: fixed; */
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>

<section class="about-section-shadow uk-hidden">
    <img src="http://sky360.in/mini_box_office/mini@1357admin/img/filmfestival/userform/1625651134-title-bar-background.jpg" alt="" class="img-height" uk-img="">
    <div class="cover-shadow"></div>
    <div class="uk-section-small  uk-padding-remove-bottom  uk-padding-remove-top">
        <div class="team-details-top" style="width: 100%;">
            <div class="uk-container">
                <div class="uk-grid" uk-grid="">
                    <div class="uk-width-1-3@m uk-first-column">
                        <img src="http://sky360.in/mini_box_office/mini@1357admin/img/filmfestival/userform/1626162337-list-box-3.jpg" alt="" class="team-photo-img">
                    </div>
                    <div class="uk-width-2-3@m">
                        <div class="team-details">
                            <h3 class="winner-year">5<sup>th</sup> IFF-15 | Best Actor</h3>
                            <h2>movie name</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim blandit volutpat maecenas volutpat blandit aliquam etiam erat. Nibh cras pulvinar mattis nunc sed blandit libero. Vitae congue mauris rhoncus aenean vel elit scelerisque mauris pellentesque. </p>
                            <div class="winner-items">
                                <div class="winner-circular-items">
                                    <a href="https://vimeo.com/180293809" target="_blank">
                                        <div class="winner-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play">
                                                <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                            </svg>
                                        </div>
                                        <span>Watch the Trailer</span>
                                    </a>
                                </div>
                                <div class="winner-dotted-items">
                                    <div class="winner-item winner-time">2020</div>
                                    <div class="winner-item winner-time">2h 55min</div>
                                    <div class="winner-item winner-genres">
                                        Crime, Drama, Horror </div>
                                    <div class="gt-item gt-release-date">June 27 ,2021</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="about-section-shadow bannerSection" style="background-image:url(<?= $movie['banner'] ?>);">
    <div class="cover-shadow"></div>
    <div class="uk-section-small  uk-padding-remove-bottom  uk-padding-remove-top">
        <div class="team-details-top" style="width: 100%;">
            <div class="uk-container">
                <div class="uk-grid" uk-grid="">
                    <div class="uk-width-1-3@m uk-first-column">
                        <img src="<?= $movie['poster'] ?>" alt="<?= $movie['title'] ?>" class="team-photo-img">
                    </div>
                    <div class="uk-width-2-3@m">
                        <div class="team-details">
                            <!-- <h3 class="winner-year">5<sup>th</sup> IFF-15 | Best Actor</h3> -->
                            <h3 class="winner-year"></h3>
                            <h2><?= $movie['title'] ?></h2>
                            <p><?= $movie['synopsis'] ?></p>
                            <div class="winner-items">
                                <div class="winner-circular-items <?= $movie['trailer_type'] === 'youtube' ? 'youtubeThumb' : 'vimeoThumb' ?>" data-video="<?= $movie['trailer'] ?>">
                                    <div class="winner-icon" style="color:#fff;cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play">
                                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                        </svg>
                                    </div>
                                    <span style="color:#fff;cursor: pointer;">Watch the Trailer</span>
                                </div>
                                <div class="winner-dotted-items">
                                    <div class="winner-item winner-time"><?= $movie['year'] ?></div>
                                    <div class="winner-item winner-time"><?= getHoursFromMinutes($movie['duration']) ?></div>
                                    <div class="winner-item winner-genres">
                                        <?php foreach (json_decode($movie['genres'], true) as $key => $genre) : if ($key < 3) { ?>
                                                <span class="commaSeparated"><?= $genre ?></span>
                                        <?php }
                                        endforeach; ?>
                                    </div>
                                    <!-- <div class="gt-item gt-release-date">June 27 ,2021</div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-section-shadow uk-hidden">
    <img src="<?= $movie['banner'] ?>" alt="" class="img-height" uk-img="">
    <div class="cover-shadow"></div>
    <div class="uk-section-small  uk-padding-remove-bottom  uk-padding-remove-top">
        <div class="team-details-top">
            <div class="uk-container">
                <div class="uk-grid" uk-grid="">
                    <div class="uk-width-1-3@m uk-first-column">
                        <img src="<?= $movie['poster'] ?>" alt="" class="team-photo-img">
                    </div>
                    <div class="uk-width-2-3@m">
                        <div class="team-details">
                            <!-- <h3 class="winner-year">5<sup>th</sup> IFF-15 | Best Actor2</h3> -->
                            <h2><?= $movie['title'] ?></h2>
                            <p><?= $movie['synopsis'] ?></p>
                            <div class="winner-items">
                                <div class="winner-circular-items <?= $movie['trailer_type'] === 'youtube' ? 'youtubeThumb' : 'vimeoThumb' ?>" data-video="<?= $movie['trailer'] ?>">
                                    <div class="winner-icon" style="color:#fff;cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play">
                                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                        </svg>
                                    </div>
                                    <span style="color:#fff;cursor: pointer;">Watch the Trailer</span>
                                </div>
                                <div class="winner-dotted-items">
                                    <div class="winner-item winner-time"><?= $movie['year'] ?></div>
                                    <div class="winner-item winner-time"><?= getHoursFromMinutes($movie['duration']) ?></div>
                                    <div class="winner-item winner-genres">
                                        <?php foreach (json_decode($movie['genres'], true) as $key => $genre) : if ($key < 3) { ?>
                                                <span class="commaSeparated"><?= $genre ?></span>
                                        <?php }
                                        endforeach; ?>
                                    </div>
                                    <!-- <div class="gt-item gt-release-date">June 27 ,2021</div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<div class="clearfix"></div>
<section class="uk-section-small uk-section-default">
    <div class="uk-container">
        <div class="uk-grid" data-uk-grid="">
            <div class="uk-width-1-3@m uk-first-column"></div>
            <div class="uk-width-2-3@m">
                <div class="winner-style winner-item-part-2">
                    <div class="winner-item-rating">
                        <!-- <div class="user-reating winner-style">
                            <div class="winner-star">
                                <i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o check" aria-hidden="true"></i><i class="fa fa-star-o check" aria-hidden="true"></i><i class="fa fa-star-o check" aria-hidden="true"></i>
                            </div>
                            <div class="user-results">
                                <span>7</span>
                                <span>10</span>
                            </div>
                        </div> -->
                        <div class="uerr-network user-reating winner-style">
                            <div class="user-item-title">Director</div>
                            <div class="user-item-content">
                                <a href="#"><?= $movie['director'] ?></a>
                            </div>
                        </div>
                        <div class="uerr-network user-reating winner-style">
                            <div class="user-item-title">Country</div>
                            <div class="user-item-content">
                                <a href="#"><?= getWorldName($movie['country']) ?></a>
                            </div>
                        </div>
                        <div class="uerr-network user-reating winner-style">
                            <div class="user-item-title">Distribution </div>
                            <div class="user-item-content">
                                <?= $movie['distribution'] ?>
                            </div>
                        </div>
                        <div class="uerr-network user-reating winner-style">
                            <div class="user-item-title">Status </div>
                            <div class="user-item-content">
                                <?= $movie['film_status'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="clearfix"></div>
<section class="uk-section-small uk-section-default">
    <div class="uk-container">
        <div class="about-text-title winner-item-title">Cast &amp; Crew</div>
        <div class="winner-cast-list uk-grid-small uk-child-width-1-4@s" uk-grid="">
            <?php foreach ($movie['casts'] as $cast) : ?>
                <div>
                    <div class="winner-item">
                        <div class="winner-profile">
                            <div class="winner-photo">
                                <img width="100" height="100" src="<?= $cast['image'] && file_exists('./' . $cast['image']) ? $cast['image'] : '/public/images/avatar.jpg' ?>" class="attachment-noxe-thumbnail-2 size-noxe-thumbnail-2 winner-lazy-load loaded" alt="<?= $cast['name'] ?>" loading="lazy" data-ll-status="loaded">
                            </div>
                            <div class="winner-title">
                                <span class="winner-subtitle"><?= $cast['name'] ?></span>
                                <span class="winner-name"><?= $cast['cast_character'] ?></span>
                            </div>
                        </div>
                        <!-- <div class="winner-details"></div> -->
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
    </div>
</section>


<!-- <div class="clearfix"></div> -->

<div class="uk-container">
    <hr>
</div>

<div class="clearfix"></div>
<section class="uk-section-small">
    <div class="uk-container">
        <div class="uk-grid" data-ukgrid="">
            <div class="uk-width-1-4@m ">
                <ul class="uk-tab-left left-tab uk-tab" uk-tab="connect: #component-tab-left; animation: uk-animation-fade" aria-expanded="true">
                    <li class="uk-active"><a href="#" aria-expanded="false">Storyline</a></li>
                    <li class=""><a href="#" aria-expanded="false">Details</a></li>
                    <li class=""><a href="#" aria-expanded="false">Producers</a></li>
                    <li class=""><a href="#" aria-expanded="false">Writers</a></li>
                    <li class=""><a href="#" aria-expanded="false">Composers</a></li>
                    <li class=""><a href="#" aria-expanded="false">Cinematographers</a></li>
                    <li class=""><a href="#" aria-expanded="false">Editors</a></li>
                    <li class=""><a href="#" aria-expanded="false">Technical Specs</a></li>
                </ul>
            </div>
            <div class="uk-width-3-4@m">
                <ul id="component-tab-left" class="uk-switcher" style="touch-action: pan-y pinch-zoom;">
                    <!-- storyline -->
                    <li>
                        <div class="title-keywords">
                            <div class="title-keywords-content">
                                <div class="key-list">Storyline</div>
                                <?= $movie['storyline'] ?>
                            </div>
                        </div>
                        <div class="title-keywords">
                            <div class="title-keywords-content">
                                <div class="key-list">Genres</div>
                                <div class="keywords">
                                    <?php foreach (json_decode($movie['genres'], true) as $key => $genre) : ?>
                                        <span class="commaSeparated"><?= $genre ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="title-keywords">
                            <div class="title-keywords-content">
                                <div class="key-list">Certificates/Ratings</div>
                                <div class="keywords">
                                    <?php foreach (json_decode($movie['certificates'], true) as $key => $certificate) : ?>
                                        <span class="commaSeparated"><?= $certificate ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- details -->
                    <li>
                        <div class="uk-child-width-1-2@m uk-grid-small" uk-grid>
                            <div>
                                <div class="title-keywords">
                                    <div class="title-keywords-content">
                                        <div class="key-list">Project type</div>
                                        <div class="keywords">
                                            <?= $movie['project'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title-keywords">
                                    <div class="title-keywords-content">
                                        <div class="key-list">Production Company</div>
                                        <div class="keywords">
                                            <?= $movie['production_company'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title-keywords">
                                    <div class="title-keywords-content">
                                        <div class="key-list">Languages</div>
                                        <div class="keywords">
                                            <?php foreach ($movie['languages'] as $key => $language) : ?>
                                                <span class="commaSeparated"><?= $language['name'] ?><?= $language['attribute'] && !empty($language['attribute']) ? '(' . $language['attribute'] . ')' : '' ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="title-keywords">
                                    <div class="title-keywords-content">
                                        <div class="key-list">Budget</div>
                                        <div class="keywords">
                                            <?= number_to_currency($movie['budget_amount'], $movie['budget_currency'], 'en_us') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- producers -->
                    <li>
                        <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>
                            <?php foreach ($movie['producers'] as $key => $producer) : ?>
                                <div>
                                    <div class="title-keywords">
                                        <div class="title-keywords-content">
                                            <div class="keywords"><?= $producer['name'] ?></div>
                                            <div class="key-list"><?= $producer['attribute'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </li>
                    <!-- writers -->
                    <li>
                        <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>
                            <?php foreach ($movie['writers'] as $key => $writer) : ?>
                                <div>
                                    <div class="title-keywords">
                                        <div class="title-keywords-content">
                                            <div class="keywords"><?= $writer['name'] ?></div>
                                            <div class="key-list"><?= $writer['attribute'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </li>
                    <!-- composers -->
                    <li>
                        <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>
                            <?php foreach ($movie['composers'] as $key => $composer) : ?>
                                <div>
                                    <div class="title-keywords">
                                        <div class="title-keywords-content">
                                            <div class="keywords"><?= $composer['name'] ?></div>
                                            <div class="key-list"><?= $composer['attribute'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </li>
                    <!-- cinematographers -->
                    <li>
                        <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>
                            <?php foreach ($movie['cinematographers'] as $key => $cinematographer) : ?>
                                <div>
                                    <div class="title-keywords">
                                        <div class="title-keywords-content">
                                            <div class="keywords"><?= $cinematographer['name'] ?></div>
                                            <div class="key-list"><?= $cinematographer['attribute'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </li>
                    <!-- editors -->
                    <li>
                        <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>
                            <?php foreach ($movie['editors'] as $key => $editor) : ?>
                                <div>
                                    <div class="title-keywords">
                                        <div class="title-keywords-content">
                                            <div class="keywords"><?= $editor['name'] ?></div>
                                            <div class="key-list"><?= $editor['attribute'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </li>
                    <li>
                        <div class="title-keywords">
                            <div class="title-keywords-content">
                                <div class="key-list">Sound Mix</div>
                                <div class="keywords">
                                    <?php foreach ($movie['sound_mix'] as $key => $sound_mix) : ?>
                                        <span class="commaSeparated"><?= $sound_mix['name'] ?><?= $sound_mix['attribute'] && !empty($sound_mix['attribute']) ? '(' . $sound_mix['attribute'] . ')' : '' ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="title-keywords">
                            <div class="title-keywords-content">
                                <div class="key-list">Axpect Ratio</div>
                                <div class="keywords">
                                    <?php foreach ($movie['aspect_ratio'] as $key => $aspect_ratio) : ?>
                                        <span class="commaSeparated"><?= $aspect_ratio['name'] ?><?= $aspect_ratio['attribute'] && !empty($aspect_ratio['attribute']) ? '(' . $aspect_ratio['attribute'] . ')' : '' ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="uk-section-small">
    <div class="uk-container">
        <div class="about-text-title winner-item-title uk-padding-remove-top">Related Titles</div>
        <div uk-slider="" class="uk-slider">
            <div class="uk-position-relative">
                <div class="uk-slider-container uk-light">
                    <ul class="uk-slider-items uk-child-width-1-3@s uk-child-width-1-4@m uk-grid" style="transform: translate3d(0px, 0px, 0px);">
                        <li tabindex="-1" class="uk-active">
                            <div class="gt-name-item">
                                <div class="schedule">
                                    <a href="Mzc="></a>
                                    <img src="http://sky360.in/mini_box_office/mini@1357admin/img/filmfestival/userform/1626162337-list-box-3.jpg" alt="">
                                    <div class="schedule-details">
                                        <h3 class="schedule-title">
                                            <a href="">movie name</a>
                                        </h3>
                                        <div class="schedule-list">Crime, Drama, Horror</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li tabindex="-1" class="uk-active">
                            <div class="gt-name-item">
                                <div class="schedule">
                                    <a href="NDA="></a>
                                    <img src="http://sky360.in/mini_box_office/mini@1357admin/img/filmfestival/userform/1626162337-list-box-3.jpg" alt="">
                                    <div class="schedule-details">
                                        <h3 class="schedule-title">
                                            <a href="">movie name</a>
                                        </h3>
                                        <div class="schedule-list">Crime, Drama, Horror</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li tabindex="-1" class="uk-active">
                            <div class="gt-name-item">
                                <div class="schedule">
                                    <a href="NDY="></a>
                                    <img src="http://sky360.in/mini_box_office/mini@1357admin/img/filmfestival/userform/1626162337-list-box-3.jpg" alt="">
                                    <div class="schedule-details">
                                        <h3 class="schedule-title">
                                            <a href="">movie name</a>
                                        </h3>
                                        <div class="schedule-list">Crime, Drama, Horror</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li tabindex="-1" class="uk-active">
                            <div class="gt-name-item">
                                <div class="schedule">
                                    <a href="NDc="></a>
                                    <img src="http://sky360.in/mini_box_office/mini@1357admin/img/filmfestival/userform/1626162337-list-box-3.jpg" alt="">
                                    <div class="schedule-details">
                                        <h3 class="schedule-title">
                                            <a href="">movie name</a>
                                        </h3>
                                        <div class="schedule-list">Crime, Drama, Horror</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li tabindex="-1" class="">
                            <div class="gt-name-item">
                                <div class="schedule">
                                    <a href="NDg="></a>
                                    <img src="http://sky360.in/mini_box_office/mini@1357admin/img/filmfestival/userform/1626162337-list-box-3.jpg" alt="">
                                    <div class="schedule-details">
                                        <h3 class="schedule-title">
                                            <a href="">movie name</a>
                                        </h3>
                                        <div class="schedule-list">Crime, Drama, Horror</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li tabindex="-1">
                            <div class="gt-name-item">
                                <div class="schedule">
                                    <a href="NDk="></a>
                                    <img src="http://sky360.in/mini_box_office/mini@1357admin/img/filmfestival/userform/1626162337-list-box-3.jpg" alt="">
                                    <div class="schedule-details">
                                        <h3 class="schedule-title">
                                            <a href="">movie name</a>
                                        </h3>
                                        <div class="schedule-list">Crime, Drama, Horror</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="uk-hidden@s  uk-light">
                    <a class="uk-position-center-left uk-position-small uk-icon uk-slidenav-previous uk-slidenav" href="#" uk-slidenav-previous="" uk-slider-item="previous"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                            <polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline>
                        </svg></a>
                    <a class="uk-position-center-right uk-position-small uk-icon uk-slidenav-next uk-slidenav" href="#" uk-slidenav-next="" uk-slider-item="next"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                            <polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 "></polyline>
                        </svg></a>
                </div>
                <div class="uk-visible@s">
                    <a class="uk-position-center-left-out uk-position-small uk-icon uk-slidenav-previous uk-slidenav" href="#" uk-slidenav-previous="" uk-slider-item="previous"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                            <polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "></polyline>
                        </svg></a>
                    <a class="uk-position-center-right-out uk-position-small uk-icon uk-slidenav-next uk-slidenav" href="#" uk-slidenav-next="" uk-slider-item="next"><svg width="14" height="24" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg">
                            <polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 "></polyline>
                        </svg></a>
                </div>
            </div>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin">
                <li uk-slider-item="0" class="uk-active"><a href=""></a></li>
                <li uk-slider-item="1"><a href=""></a></li>
                <li uk-slider-item="2"><a href=""></a></li>
                <li uk-slider-item="3"><a href=""></a></li>
                <li uk-slider-item="4"><a href=""></a></li>
                <li uk-slider-item="5"><a href=""></a></li>
            </ul>
        </div>
    </div>
</section>
<div class="uk-container">
    <hr>
</div>
<section class="uk-section-small">
    <div class="uk-container">
        <div class="gridlove-author-links m-0 uk-text-center">
            <a href="https://twitter.com/" target="_blank" class="gridlove-sl-item fa fa-facebook"></a>
            <a href="https://twitter.com/" target="_blank" class="gridlove-sl-item fa fa-twitter"></a>
            <a href="https://www.instagram.com/" class="gridlove-sl-item fa fa-instagram"></a>
            <a href="https://api.whatsapp.com/send/?phone=1234567890" class="gridlove-sl-item fa fa-whatsapp"></a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<?= $this->endSection() ?>