<?php
if ($event['type'] = 'festival') {
    echo $this->extend('Layouts/Web/film_festival');
} else {
    echo $this->extend('Layouts/Web/home');
}
?>
<?= $this->section('css') ?>
<style>
    .eventHeader {
        width: 100%;
        height: 700px;
        /* background-position: center center; */
        /* background-repeat: no-repeat; */
        background: linear-gradient(0deg, rgba(255, 0, 150, 0.3), rgba(255, 0, 150, 0.3)), url(<?= $event['image'] ?>) 50% 0 no-repeat;
        background: linear-gradient(0deg, rgb(80 78 79 / 30%), rgb(9 8 9 / 46%)), url(<?= $event['image'] ?>) 50% 0 no-repeat;
        background-size: cover;
        -webkit-clip-path: polygon(0% 100%, 0% 0%, 100% 0%, 100% 80%);
        clip-path: polygon(0% 100%, 0% 0%, 100% 0%, 100% 80%);
        overflow: visible;
    }

    .eventBanner {
        width: 100%;
        height: auto;
    }

    .eventDetails,
    .eventcontainer {
        max-width: 800px;
        margin: auto;
    }

    .eventcontainer {
        margin-top: -620px;
    }

    .eventHeaderDetails * {
        color: #ffffff !important;
    }

    .icon-box {
        display: inline-flex;
    }

    .icon-box div:not(:first-child) {
        margin-left: 15px;
    }

    .icon-holder {
        /* display: inline-block; */
        background-color: #d8b069;
        width: 64px;
        height: 64px;
        min-width: 64px;
        min-height: 64px;
        text-align: center;
        font-size: 1.5em;
        line-height: 64px;
        /* margin-right: 10px; */
        /* margin-top: 10px; */
    }

    .eventTitle {
        font-weight: 600;
    }

    .eventDays {
        text-transform: uppercase;
        font-weight: 600;
    }

    .eventDetails {
        background-color: #ffffff;
    }
    #event-directions {
        margin-top: 30px;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="eventHeader">
</div>
<div class="eventcontainer container">
    <div class="uk-card uk-card-body uk-width-1-1">
        <div class="eventHeaderDetails" uk-grid>
            <div class="uk-width-1-1">
                <h1 class="animated fadeInDown eventTitle">
                    <?= $event['title'] ?>
                </h1>
            </div>
            <!-- when -->
            <div class="uk-width-1-2@m">
                <div class="icon-box">
                    <div class="icon-holder">
                        <!-- <i class="fa fa-calendar"></i> -->
                        <span uk-icon="icon: calendar; ratio: 2"></span>
                    </div>
                    <div>
                        <p><strong>When</strong></p>
                        <p>
                            <span>
                                <?php if ($event['eventDays'] > 1) {
                                    echo date('d M Y', strtotime($event['from_date'])) . ' to ' . date('d M Y', strtotime($event['to_date']));
                                } else {
                                    echo date('d M Y', strtotime($event['from_date']));
                                } ?>
                            </span>
                            <br>
                            <?php if ($event['eventDays'] > 1) {
                                echo 'Everyday at ' . date('g:s A', strtotime($event['from_time'])) . ' to ' . date('g:s A', strtotime($event['to_time']));
                            } else {
                                echo 'Startig at ' . date('g:s A', strtotime($event['from_time']));
                            } ?>
                        </p>
                    </div>
                </div>
            </div>
            <!-- where -->
            <div class="uk-width-1-2@m">
                <div class="icon-box">
                    <div class="icon-holder">
                        <!-- <i class="fa fa-map-marker"></i> -->
                        <span uk-icon="icon: location; ratio: 2"></span>
                    </div>
                    <div>
                        <p><strong>Where</strong></p>
                        <a href="#">
                            <?= $event['address'] ?>
                        </a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="uk-width-1-3@m">
                <a href="#register-now" title="Get Tickets" class="uk-button uk-button-primary uk-width-1-1">Register now</a>
                <!-- <p>Tickets are on sale now!</p> -->
            </div>
            <div class="uk-width-1-3@m uk-text-center@m">
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
            <div class="uk-width-1-3@m uk-text-right@m">
                <a href="#event-directions" class="uk-button uk-button-primary uk-width-1-1">Get Directions</a>
                <!-- <p>Location Map</p> -->
            </div>
        </div>
    </div>
    <div class="uk-card uk-card-body uk-width-1-1 eventDetails">
        <h3 class="uk-card-title eventDays">For <?= convertNumberToWord($event['eventDays']) ?> days</h3>
        <?= html_entity_decode($event['content']) ?>
        <iframe id="event-directions" src="https://maps.google.com/maps?q=<?= $event['latitude'] ?>,<?= $event['longitude'] ?>&z=15&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<?= $this->endSection() ?>