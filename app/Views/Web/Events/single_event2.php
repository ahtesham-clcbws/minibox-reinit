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
    }

    .eventImgaeBlock {
        position: relative;
    }
    .eventImgaeBlock img {
        width: 100%;
        height: auto;
    }

    .eventcontainer,
    .eventcontainer * {
        margin-top: -50%;
        color: #ffffff !important;
        max-width: 700px;
        margin: auto;
    }

    #overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="eventHeader">
    <div class="eventImgaeBlock">
        <img src="<?= $event['image'] ?>" alt="<?= $event['title'] ?>">
        <div id="overlay"></div>
    </div>
    <div class="eventcontainer container">
        <h1 class="animated fadeInDown"><a href="#">The Annual Conference 2015</a></h1>
        <p class="subtitle animated fadeInDown">1 track, 3 conference days, 4 workshops, 10 excellent speakers and <strong><a href="#">just 300 available seats</a></strong>.</p>
        <div class="when">
            <div class="icon-holder">
                <i class="fa fa-calendar"></i>
            </div>
            <div>
                <p><strong>When</strong></p>
                <p><span>7th to 9th October 2014</span><br>Starting at 10am</p>
            </div>
        </div>
        <div class="where">
            <div class="icon-holder">
                <i class="fa fa-map-marker"></i>
            </div>
            <div>
                <p><strong>Where</strong></p>
                <p><span>London</span><br><a href="#">Awesome Venue Name</a></p>
            </div>
        </div>
        <div class="register-now">
            <p>Tickets are on sale now, get 10% off till November 1st!</p>
            <a href="#registration" class="button">Register Now</a>
        </div>

    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<?= $this->endSection() ?>