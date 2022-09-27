<div class="nk-aside <?= dontShowSidenav() ? 'd-lg-none' : '' ?>" data-content="sideNav" data-toggle-overlay="true" data-toggle-screen="lg" data-toggle-body="true">

    <div class="nk-sidebar-menu" data-simplebar>
        <ul class="nk-menu nk-menu-main">

            <!-- MAIN MENU START -->
            <?= view('Admin/Globals/menu'); ?>
            <!-- MAIN MENU END -->

        </ul><!-- .nk-menu -->
        <ul class="nk-menu d-md-none d-lg-block">
            <?php if (getUrlSegment(2) == 'film-festivals') : ?>

                <?php if (!getUrlSegment(3)) : ?>
                    <?php foreach (getFestivalsList() as $key => $festival) { ?>
                        <li class="nk-menu-item">
                            <a href="<?= route_to('admin_festival_details', $festival['id']) ?>" class="nk-menu-link">
                                <!-- <span class="nk-menu-icon"><em class="icon ni ni-grid-alt"></em></span> -->
                                <span class="nk-menu-text"><?= $festival['name'] ?></span>
                            </a>
                        </li>
                    <?php } ?>
                <?php endif ?>
                <?php if (getUrlSegment(3) && intval(getUrlSegment(3)) && !getUrlSegment(4)) : ?>
                    <?= view('Admin/Globals/festivalMenu', ['id' => getUrlSegment(3)]); ?>
                <?php endif ?>
                <?php if (getUrlSegment(3) && getUrlSegment(3) && intval(getUrlSegment(4))) : ?>
                    <?= view('Admin/Globals/festivalMenu', ['id' => getUrlSegment(4)]); ?>
                <?php endif ?>

            <?php endif ?>
            <?php if (getUrlSegment(2) == 'settings') : ?>
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">
                        Menu
                    </h6>
                </li>
                <?= view('Admin/Globals/settingsMenu'); ?>

            <?php endif ?>
            <?php if (getUrlSegment(2) == 'film-zine') : ?>
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">
                        Menu
                    </h6>
                </li>
                <?= view('Admin/Globals/filmzineMenu'); ?>

            <?php endif ?>
            <?php if (getUrlSegment(2) == 'events') : ?>
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">
                        Menu
                    </h6>
                </li>
                <?= view('Admin/Globals/eventsMenu'); ?>

            <?php endif ?>
        </ul>

    </div>

    <div class="nk-aside-close">
        <a href="#" class="toggle" data-target="sideNav"><em class="icon ni ni-cross"></em></a>
    </div>
</div>