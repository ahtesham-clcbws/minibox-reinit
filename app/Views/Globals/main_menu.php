<li><a href="<?= route_to('homepage') ?>">HOME</a></li>
<li>
    <a href="#" aria-expanded="false">FILM FESTIVAL</a>
    <div class="uk-navbar-dropdown uk-navbar-dropdown-bottom-left" style="left: 0px; top: 19px;">
        <ul class="uk-nav uk-navbar-dropdown-nav">
            <?php foreach (getAllFrontEndFestivalsListWithSlug() as $festivalSlug) : ?>
                <li><a href="<?= route_to('festival_details', $festivalSlug['slug']) ?>" target="_blank"><?= $festivalSlug['name'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</li>
<li>
    <a href="<?= route_to('film_market') ?>" target="_blank">FILM MARKET</a>
</li>
<!-- <li>
    <a href="#" target="_blank">FILM INCUBATOR</a>
</li> -->
<li>
    <a href="<?= route_to('film_zine') ?>" target="_blank">FILM ZINE</a>
</li>
<li>
    <a href="<?= route_to('prime_watch') ?>" target="_blank">PRIME WATCH</a>
</li>
<li>
    <a href="<?= route_to('prime_kids') ?>" target="_blank">PRIME KIDS</a>
</li>
<li>
    <a href="<?= route_to('store') ?>" target="_blank">STORE</a>
</li>
<!-- <li>
    <a href="#" target="_blank">HOME</a>
</li> -->