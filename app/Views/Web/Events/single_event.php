<?php
if ($event['type'] == 'festival') {
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
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.8), rgba(900, 0, 150, 0.3)), url(<?= $event['image'] ?>) 50% 0 no-repeat;
        background-size: cover;
        -webkit-clip-path: polygon(0% 100%, 0% 0%, 100% 0%, 100% 80%);
        clip-path: polygon(0% 100%, 0% 0%, 100% 0%, 100% 80%);
        overflow: visible;
    }

    .eventBanner {
        width: 100%;
        height: auto;
    }

    .eventcontainer {
        max-width: 850px;
        margin: auto;
        margin-top: -620px;
        margin-bottom: 50px;
    }

    .eventcontainer .uk-card-media-top {
        overflow: visible;
        position: relative;
    }

    .eventcontainer .uk-card-media-top figure {
        min-height: 55vh;
        width: 100%;
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .videoIcon {
        top: 50%;
    }

    .eventcontainer a {
        color: inherit;
    }

    .icon-box {
        display: inline-flex;
    }

    .icon-box div:not(:first-child) {
        margin-left: 15px;
    }

    .icon-holder {
        background-color: #d8b069;
        width: 64px;
        height: 64px;
        min-width: 64px;
        min-height: 64px;
        text-align: center;
        font-size: 1.5em;
        line-height: 64px;
        color: #ffffff;
    }

    .eventcontainer .uk-card-title {
        text-transform: uppercase;
        font-weight: 600;
    }

    .eventDetails {
        background-color: #ffffff;
    }

    #event-directions {
        margin-top: 30px;
    }

    .eventcontainer .uk-button-secondary {
        color: #ffffff;
    }

    #contactOrganizer form .uk-form-controls .uk-inline {
        width: 100%;
    }

    .messageBlock .uk-form-icon {
        height: 40px;
    }

    .uk-form-icon:not(.uk-form-icon-flip)~.uk-textarea {
        padding-left: 40px !important;
    }

    .organizerDetails .uk-card-title {
        font-size: 1.2rem;
    }

    .uk-table tfoot {
        font-size: inherit;
    }

    .uk-table tfoot tr td {
        font-weight: bold;
        color: #fff;
        background: grey;
    }

    * {
        -webkit-user-select: none;
        /* Safari */
        -ms-user-select: none;
        /* IE 10 and IE 11 */
        user-select: none;
        /* Standard syntax */
    }

    #fullPackageJson,
    #packageCounts,
    .fullTicketDetails {
        display: none;
    }

    /* #feeTable thead tr th {
        padding-top: 2px;
        padding-bottom: 2px;
    } */
    #feeTable tr th:first-child,
    #feeTable tr td:first-child {
        padding-left: 10px;
    }

    #feeTable tr th:last-child,
    #feeTable tr td:last-child {
        padding-right: 10px;
    }

    /* .amountColumn {
		min-width: 70px;
	} */
    .Particulars {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="eventHeader">
</div>
<div class="eventcontainer container">
    <div class="uk-card uk-card-default uk-card-hover uk-width-1-1" id="eventCard">
        <div class="uk-card-media-top">

            <?php if (!$event['video'] && empty(trim($event['video']))) : ?>
                <img src="<?= $event['image'] ?>" width="1800" height="1200" alt="<?= $event['title'] ?>">
            <?php endif; ?>

            <?php if ($event['video'] && !empty($event['video'])) : ?>
                <?php if ($event['video_type'] === 'youtube') : ?>
                    <figure class="videoThumb" style="background-image:url(https://img.youtube.com/vi/<?= $event['video'] ?>/hqdefault.jpg);"></figure>
                    <span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon youtubeIcon youtubeThumb" data-video="<?= $event['video'] ?>"></span>
                <?php endif; ?>
                <?php if ($event['video_type'] === 'vimeo') : ?>
                    <figure class="videoThumb" style="background-image:url(https://vumbnail.com/<?= $event['video'] ?>.jpg);"></figure>
                    <span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon vimeoIcon vimeoThumb" data-video="<?= $event['video'] ?>"></span>
                <?php endif; ?>
            <?php endif; ?>

        </div>
        <div class="uk-card-body">
            <div class="eventHeaderDetails" uk-grid>
                <div class="uk-width-1-1">
                    <h3 class="uk-card-title">
                        <?= $event['title'] ?>
                    </h3>
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
                            <?= ' - ' . $event['pincode'] . ', ' . getWorldName($event['city'], 'city') . ', ' . getWorldName($event['state'], 'state') . ', ' . getWorldName($event['country'], 'country') ?>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-3@m">
                    <button type="button" onclick="clickRegisterNow()" title="Get Tickets" class="uk-button uk-button-secondary uk-width-1-1">Register now</button>
                    <!-- <p>Tickets are on sale now!</p> -->
                </div>
                <div class="uk-width-1-3@m uk-text-center@m">
                    <a href="#contactOrganizer" uk-toggle class="uk-button uk-button-secondary uk-width-1-1">Contact Organizer</a>
                </div>
                <div class="uk-width-1-3@m uk-text-right@m">
                    <a href="#event-directions" class="uk-button uk-button-secondary uk-width-1-1">Get Directions</a>
                    <!-- <p>Location Map</p> -->
                </div>
                <div class="uk-width-1-1 uk-text-center@m">
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
            </div>
            <h3 class="uk-card-title">
                For <?= convertNumberToWord($event['eventDays']) ?> days
            </h3>
            <div class="eventDescription">
                <?= html_entity_decode($event['content']) ?>
            </div>
            <hr>
            <div class="eventTicktes" id="eventTicktes">

                <div id="feeTable">
                    <h3>Event Tickets:</h3>
                    <span id="packageCounts"><?= count($tickets) ?></span>
                    <div class="uk-margin uk-overflow-auto">
                        <table class="uk-table uk-table-justify uk-table-hover uk-table-divider Particulars">
                            <thead>
                                <tr>
                                    <th scope="col">Particulars</th>
                                    <th scope="col" class="uk-text-nowrap">Price</th>
                                    <th scope="col" class="uk-text-nowrap">Tickets</th>
                                    <th scope="col" class="uk-text-right uk-text-nowrap">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tickets as $key => $package) : ?>
                                    <tr>
                                        <td><label><?= $package['details'] ?></label></td>
                                        <td class="uk-text-nowrap">
                                            <?= $currency_symbol ?> <span class="ticket_amount" id="ticket_amount<?= $key ?>" key="<?= $key ?>"><?= $package['fee'] ?></span>
                                        </td>
                                        <td class="uk-padding-remove-top uk-text-nowrap">
                                            <div class="ticket_counter">
                                                <icon class="ticketDecrease" key="<?= $key ?>">
                                                    <i class="fa-solid fa-minus"></i>
                                                </icon>
                                                <span class="ticket_numbers" id="ticket_numbers<?= $key ?>" key="<?= $key ?>">0</span>
                                                <icon class="ticketIncrease" key="<?= $key ?>">
                                                    <i class="fa-solid fa-plus"></i>
                                                </icon>
                                            </div>
                                        </td>
                                        <td class="uk-text-right uk-text-nowrap">
                                            <span class="ticket_total" id="ticket_total<?= $key ?>" key="<?= $key ?>"></span>
                                            <span class="fullTicketDetails" id="fullTicketDetails<?= $key ?>" key="<?= $key ?>"><?= json_encode($package) ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td class="uk-text-center uk-text-nowrap">Tickets <span id="grandTotalTickets">0</span></td>
                                    <td class="uk-text-right uk-text-nowrap"><?= $currency_symbol ?> <span id="grandTotal">0</span></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="uk-width-1-1 uk-text-right">
                            <button type="button" class="uk-button uk-button-secondary">Buy Now</button>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="eventMap">
                <iframe id="event-directions" src="https://maps.google.com/maps?q=<?= $event['latitude'] ?>,<?= $event['longitude'] ?>&z=15&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<div id="contactOrganizer" class="uk-flex-top uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
        <div class="uk-grid-collapse uk-flex-middle" uk-grid>
            <div class="organizerDetails uk-width-1-2@m uk-padding-small">
                <h4>Organizer/s Details</h4>
                <div class="uk-grid-small" uk-grid>
                    <?php foreach ($contacts as $key => $contact) : ?>
                        <div class="uk-width-1-2@m">
                            <div class="uk-card uk-card-default uk-card-hover uk-padding-small">
                                <div class="">
                                    <h3 class="uk-card-title"><?= $contact['name'] ?></h3>
                                    <div class="uk-button-group">
                                        <button type="button" class="uk-button uk-button-secondary copyData" uk-tooltip="<?= $contact['email'] ?>" copyData="<?= $contact['email'] ?>"><span uk-icon="icon: mail"></span></button>
                                        <button type="button" class="uk-button uk-button-primary copyData" uk-tooltip="<?= $contact['phone'] ?>" copyData="<?= $contact['phone'] ?>"><span uk-icon="icon: receiver"></span></button>
                                        <button type="button" class="uk-button uk-button-secondary copyData" uk-tooltip="<?= $contact['whatsapp'] ?>" copyData="<?= $contact['whatsapp'] ?>"><span uk-icon="icon: whatsapp"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <form class="uk-form-stacked uk-width-1-2@m">

                <div class="uk-margin">
                    <label class="uk-form-label" for="event_form_name">Name</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: user"></span>
                            <input class="uk-input" id="event_form_name" name="name" type="text" required>
                        </div>
                    </div>
                </div>

                <div uk-grid>
                    <div class="uk-margin-remove uk-width-1-2@m">
                        <label class="uk-form-label" for="event_form_email">Email</label>
                        <div class="uk-form-controls">
                            <div class="uk-inline">
                                <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                <input class="uk-input" id="event_form_email" name="email" type="email" required>
                            </div>
                        </div>
                    </div>

                    <div class="uk-margin-remove uk-width-1-2@m">
                        <label class="uk-form-label" for="event_form_mobile">Mobile</label>
                        <div class="uk-form-controls">
                            <div class="uk-inline">
                                <span class="uk-form-icon" uk-icon="icon: receiver"></span>
                                <input class="uk-input" id="event_form_mobile" name="mobile" type="tel" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="uk-margin messageBlock">
                    <label class="uk-form-label" for="event_form_message">Message</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: comments"></span>
                            <textarea class="uk-textarea" id="event_form_message" name="message" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="uk-margin uk-text-right">
                    <button class="uk-button uk-button-secondary">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('html, body').animate({
            scrollTop: eval($('#eventCard').offset().top - 5)
        }, 1000);
    });

    function clickRegisterNow(){
        $('html, body').animate({
            scrollTop: eval($('#eventTicktes').offset().top - 50)
        }, 500);
    }
    var grandTotal = 0;
    var grandTotalTickets = 0;
    getAllData();
    $('.ticketDecrease').on('click', function(event) {
        event.stopPropagation();
        event.stopImmediatePropagation();

        var counterId = '#ticket_numbers' + $(this).attr('key');
        var oldValue = parseInt($(counterId).html());
        if (oldValue >= 1) {
            var newValueSingle = oldValue - 1;
            $(counterId).html(newValueSingle);
        }
        getAllData();
    })
    $('.ticketIncrease').on('click', function(event) {
        event.stopPropagation();
        event.stopImmediatePropagation();

        var counterId = '#ticket_numbers' + $(this).attr('key');
        var oldValue = parseInt($(counterId).html());
        var newValueSingle = oldValue + 1;
        $(counterId).html(newValueSingle);

        getAllData();
    })

    function getAllData() {
        var totalPackages = parseInt($('#packageCounts').html());
        var totalJson = [];
        for (let index = 0; index < totalPackages; index++) {
            var tickets = $('#ticket_numbers' + index);
            // tickets.html(parseInt(tickets.html())+1);

            var element = $('#fullTicketDetails' + index);
            var detailsJson = JSON.parse(element.html());
            var totalAmount = detailsJson.fee * parseInt(tickets.html());
            $('#ticket_total' + index).html(totalAmount);

            detailsJson.total = totalAmount;
            detailsJson.tickets = parseInt(tickets.html());
            totalJson[index] = detailsJson;
            element.html(JSON.stringify(detailsJson));
            console.log(detailsJson);
            console.log(totalJson);
        }
        var totalAmountJson = {
            tickets: 0,
            amount: 0
        }
        totalJson.forEach(package => {
            totalAmountJson['tickets'] += parseInt(package.tickets);
            totalAmountJson['amount'] += parseInt(package.total);
        })
        var fullJson = {
            packages: totalJson,
            total: totalAmountJson,
        }
        grandTotal = totalAmountJson.amount;
        grandTotalTickets = totalAmountJson.tickets;
        $('#grandTotal').html(totalAmountJson.amount);
        $('#grandTotalTickets').html(totalAmountJson.tickets);

        $('#fullPackageJson').val(JSON.stringify(fullJson));
        console.log(fullJson);
    }

    function getSingleTicketDetails(index, tickets) {
        var element = $('#fullTicketDetails' + index);
        var detailsJson = JSON.parse(element.html());
        var totalAmount = detailsJson.fee * tickets;
        detailsJson.total = totalAmount;
        detailsJson.tickets = tickets;

        element.html(JSON.stringify(detailsJson))
        console.log(detailsJson);
    }
</script>
<?= $this->endSection() ?>