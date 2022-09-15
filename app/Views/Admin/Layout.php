<!DOCTYPE html>
<html lang="en-GB" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="clcbws">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="/public/admin/images/favicon.png">

    <title>MiniBoxOffice</title>

    <script>
        var newUserby = 'user';
        var defaultProfilePic = '/public/images/avatar.jpg';
        var placeholder2 = '/public/images/placeholder2.jpg';
		var commonFunctions = '<?= route_to('commonFunctions') ?>';
    </script>
    <!-- <link rel="stylesheet" href="/public/libs/bootstrap/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="/public/admin/css/dashlite.css">
 <link rel="stylesheet" type="text/css" href="/public/libs/sweetalert/borderless.min.css" media="all">
    <link id="skin-default" rel="stylesheet" href="/public/admin/css/theme.css">
    <?= $this->renderSection('css') ?>
    <style>
        .spinnerActivated {
            overflow: hidden;
        }

        #customLoader {
            position: absolute;
            height: 100vh;
            width: 100%;
            top: 0;
            left: 0;
            background: #3d3d3d87;
            z-index: 9999999;
            /* display: none; */
        }

        #customLoader .loaderBlock {
            top: 50%;
            position: absolute;
        }
    </style>
    <div id="customLoader">
        <div class="loaderBlock h-100 w-100">
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <!-- <script>
        startLoader();
    </script> -->
</head>

<body class="nk-body bg-white npc-default has-aside spinnerActivated">
    <script>
        var dark_mode = localStorage.getItem('dark_mode');
        if (dark_mode) {
            document.body.classList.add("dark-mode");
        }
    </script>
    <div class="nk-app-root">

        <div class="nk-main ">

            <div class="nk-wrap ">
                <?= view('Admin/Globals/header'); ?>
                <div class="nk-content ">
                    <div class="container wide-xl">
                        <div class="nk-content-inner">
                            <?= view('Admin/Globals/sideNav'); ?>

                            <div class="nk-content-body">
                                <div class="nk-content-wrap">
                                    <?php // view('Admin/Globals/page_breadcrumb'); 
                                    ?>
                                    <?= $this->renderSection('content') ?>
                                </div>

                                <div class="nk-footer d-none">
                                    <div class="container wide-xl">
                                        <div class="nk-footer-wrap g-2">
                                            <div class="nk-footer-copyright"> &copy; 2022 DashLite. Template by <a href="#">Softnio</a>
                                            </div>
                                            <div class="nk-footer-links">
                                                <ul class="nav nav-sm">
                                                    <li class="nav-item dropup">
                                                        <a href="#" class="dropdown-toggle dropdown-indicator has-indicator nav-link text-base" data-bs-toggle="dropdown" data-offset="0,10"><span>English</span></a>
                                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                            <ul class="language-list">
                                                                <li>
                                                                    <a href="#" class="language-item">
                                                                        <span class="language-name">English</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="language-item">
                                                                        <span class="language-name">Español</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="language-item">
                                                                        <span class="language-name">Français</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="language-item">
                                                                        <span class="language-name">Türkçe</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="" data-bs-toggle="modal" data-bs-target="#region" class="nav-link"><em class="icon ni ni-globe"></em><span class="ms-1">Select Region</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>


    <!-- <script src="/public/libs/bootstrap/js/bootstrap.bundle.js"></script> -->
    <script src="/public/admin/js/bundle.js"></script>
    <script src="/public/admin/js/scripts.js"></script>
    <script defer src="/public/libs/fontawesome/js/all.js"></script>
    <?= $this->renderSection('js') ?>
    <script>
        $(window).bind("load", function() {
            stopLoader();
        });
    </script>
</body>

</html>