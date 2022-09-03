<li><a href="<?= route_to('festival_details', $festivalSlug) ?>" class="active">Home</a></li>
<li>
    <a href="#" aria-expanded="false">About</a>
    <div class="uk-navbar-dropdown">
        <ul class="uk-nav uk-navbar-dropdown-nav">
            <li><a href="<?= route_to('festival_about', $festivalSlug) ?>">Festival</a></li>
            <li><a href="<?= route_to('festival_team', $festivalSlug) ?>">Team</a></li>
            <li><a href="<?= route_to('festival_sponsorship', $festivalSlug) ?>">Sponsorship & Promotion</a></li>
            <li><a href="<?= route_to('festival_volunteer', $festivalSlug) ?>">Volunteer</a></li>
            <li><a href="<?= route_to('festival_venue', $festivalSlug) ?>">Venue</a></li>
            <li><a href="<?= route_to('festival_schedule', $festivalSlug) ?>">Schedule</a></li>
            <li><a href="<?= route_to('festival_delegate_registration', $festivalSlug) ?>">Delegate Registration</a></li>
            <li><a href="<?= route_to('festival_support', $festivalSlug) ?>">Support</a></li>
        </ul>
    </div>
</li>
<li>
    <a href="<?= route_to('festival_winners', $festivalSlug) ?>">WINNERS </a>
</li>
<li>
    <a href="#" aria-expanded="false">Submit </a>
    <div class="uk-navbar-dropdown">
        <ul class="uk-nav uk-navbar-dropdown-nav">
            <li><a href="<?= route_to('festival_entry_form', $festivalSlug) ?>">Entry Form </a></li>
            <li><a href="#festivalRules" uk-toggle>Rules</a></li>
            <li><a href="<?= route_to('festival_awards', $festivalSlug) ?>">Awards</a></li>
        </ul>
    </div>
</li>
<li>
    <a href="<?= route_to('festival_official_selection', $festivalSlug) ?>">OFFICIAL SELECTION</a>
</li>
<li>
    <a href="<?= route_to('festival_jury', $festivalSlug) ?>">JURY</a>
</li>
<li>
    <a href="#">FILM MARKET</a>
</li>
<li>
    <a href="#">Incubator</a>
</li>
<li>
    <a href="#" aria-expanded="false">MEDIA</a>
    <div class="uk-navbar-dropdown">
        <ul class="uk-nav uk-navbar-dropdown-nav">
            <li><a href="#">Gallery</a></li>
            <li> <a href="#">Filmmakers Cut- Interviews & Trailers </a></li>
            <li><a href="#">KnowledgeCentre</a></li>
            <li><a href="#">Press</a></li>
            <li><a href="#" target="_blank">FilmZine</a></li>
        </ul>
    </div>
</li>
<li>
    <a href="#" uk-toggle="" aria-expanded="false">Store</a>
</li>