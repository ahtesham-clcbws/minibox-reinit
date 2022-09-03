<div class="nk-aside <?= dontShowSidenav() ? 'd-lg-none' : '' ?>" data-content="sideNav" data-toggle-overlay="true" data-toggle-screen="lg" data-toggle-body="true">

    <div class="nk-sidebar-menu" data-simplebar>
        <ul class="nk-menu nk-menu-main">

            <!-- MAIN MENU START -->
            <?= view('Admin/Globals/menu'); ?>
            <!-- MAIN MENU END -->

        </ul><!-- .nk-menu -->
        <ul class="nk-menu d-md-none d-lg-block">
            <?php if (getUrlSegment(2) == 'film-festivals') : ?>
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">
                        Menu
                    </h6>
                </li>

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
                    <?= view('Admin/Globals/festivalMenu', ['id' => getUrlSegment(4), 'year' => getUrlSegment(5)]); ?>
                <?php endif ?>
                <?php if (getUrlSegment(5)) : ?>
                    <?= view('Admin/Globals/festivalMenu', ['id' => getUrlSegment(4), 'year' => getUrlSegment(5)]); ?>
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
            <?php if (getUrlSegment(2) == 'blogs' || getUrlSegment(2) == 'blog') : ?>
                <li class="nk-menu-heading">5
                    <h6 class="overline-title text-primary-alt">Blogs</h6>
                </li>

                <li class="nk-menu-item">
                    <a href="/administrator/blogs" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-dashlite"></em></span>
                        <span class="nk-menu-text">All Blogs</span>
                    </a>
                </li>

                <li class="nk-menu-item">
                    <a href="/administrator/blog/add" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-growth"></em></span>
                        <span class="nk-menu-text">Add Blog</span>
                    </a>
                </li>

                <li class="nk-menu-item">
                    <a href="/administrator/blog/categories" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-growth"></em></span>
                        <span class="nk-menu-text">Categories</span>
                    </a>
                </li>

                <li class="nk-menu-item">
                    <a href="/administrator/blog/comments" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-growth"></em></span>
                        <span class="nk-menu-text">Comments</span>
                    </a>
                </li>
            <?php endif ?>
            <?php if (getUrlSegment(2) == 'projects' || getUrlSegment(2) == 'project') : ?>
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">Projects</h6>
                </li>

                <li class="nk-menu-item">
                    <a href="/administrator/projects" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-dashlite"></em></span>
                        <span class="nk-menu-text">All Projects</span>
                    </a>
                </li>

                <li class="nk-menu-item">
                    <a href="/administrator/project/add" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-growth"></em></span>
                        <span class="nk-menu-text">Add Project</span>
                    </a>
                </li>

                <li class="nk-menu-item">
                    <a href="/administrator/project/categories" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-growth"></em></span>
                        <span class="nk-menu-text">Categories</span>
                    </a>
                </li>
            <?php endif ?>
            <?php if (getUrlSegment(2) == 'teams' || getUrlSegment(2) == 'team') : ?>
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">Team</h6>
                </li>

                <li class="nk-menu-item">
                    <a href="/administrator/team" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-dashlite"></em></span>
                        <span class="nk-menu-text">Team Members</span>
                    </a>
                </li>

                <li class="nk-menu-item">
                    <a href="/administrator/team/add" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-growth"></em></span>
                        <span class="nk-menu-text">Add Team Member</span>
                    </a>
                </li>
            <?php endif ?>
            <?php if (getUrlSegment(2) == 'other') : ?>
                <li class="nk-menu-heading">
                    <h6 class="overline-title text-primary-alt">Others</h6>
                </li>

                <li class="nk-menu-item">
                    <a href="/administrator/other/testimonials" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-dashlite"></em></span>
                        <span class="nk-menu-text">Testimonials</span>
                    </a>
                </li>

                <li class="nk-menu-item">
                    <a href="/administrator/other/contact-submission" class="nk-menu-link">
                        <span class="nk-menu-icon"><em class="icon ni ni-growth"></em></span>
                        <span class="nk-menu-text">Contact Submission</span>
                    </a>
                </li>
            <?php endif ?>
        </ul>

    </div>

    <div class="nk-aside-close">
        <a href="#" class="toggle" data-target="sideNav"><em class="icon ni ni-cross"></em></a>
    </div>
</div>