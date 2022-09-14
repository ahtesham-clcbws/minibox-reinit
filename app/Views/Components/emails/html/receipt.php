<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Purchase Receipt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style type="text/css">
        body,
        table,
        td,
        a {
            text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
        }

        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }

        table {
            border-collapse: collapse !important;
        }

        a {
            color: #1a82e2;
        }

        #printArea {
            max-width: 600px;
            margin: auto;
        }
    </style>
    <?php if (!$email_view) : ?>
        <style>
            /* Absolute Center Spinner */
            .loading {
                display: none;
                position: fixed;
                z-index: 999;
                height: 2em;
                width: 2em;
                overflow: show;
                margin: auto;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
            }

            /* Transparent Overlay */
            .loading:before {
                content: '';
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));

                background: -webkit-radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
            }

            /* :not(:required) hides these rules from IE9 and below */
            .loading:not(:required) {
                /* hide "loading..." text */
                font: 0/0 a;
                color: transparent;
                text-shadow: none;
                background-color: transparent;
                border: 0;
            }

            .loading:not(:required):after {
                content: '';
                display: block;
                font-size: 10px;
                width: 1em;
                height: 1em;
                margin-top: -0.5em;
                -webkit-animation: spinner 150ms infinite linear;
                -moz-animation: spinner 150ms infinite linear;
                -ms-animation: spinner 150ms infinite linear;
                -o-animation: spinner 150ms infinite linear;
                animation: spinner 150ms infinite linear;
                border-radius: 0.5em;
                -webkit-box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
                box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
            }

            /* Animation */

            @-webkit-keyframes spinner {
                0% {
                    -webkit-transform: rotate(0deg);
                    -moz-transform: rotate(0deg);
                    -ms-transform: rotate(0deg);
                    -o-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    -moz-transform: rotate(360deg);
                    -ms-transform: rotate(360deg);
                    -o-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @-moz-keyframes spinner {
                0% {
                    -webkit-transform: rotate(0deg);
                    -moz-transform: rotate(0deg);
                    -ms-transform: rotate(0deg);
                    -o-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    -moz-transform: rotate(360deg);
                    -ms-transform: rotate(360deg);
                    -o-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @-o-keyframes spinner {
                0% {
                    -webkit-transform: rotate(0deg);
                    -moz-transform: rotate(0deg);
                    -ms-transform: rotate(0deg);
                    -o-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    -moz-transform: rotate(360deg);
                    -ms-transform: rotate(360deg);
                    -o-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @keyframes spinner {
                0% {
                    -webkit-transform: rotate(0deg);
                    -moz-transform: rotate(0deg);
                    -ms-transform: rotate(0deg);
                    -o-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    -moz-transform: rotate(360deg);
                    -ms-transform: rotate(360deg);
                    -o-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }
        </style>
        <style>
            body {
                padding-bottom: 50px;
                position: relative;
                /* overflow: hidden; */
            }

            #printButtons {
                position: fixed;
                bottom: 1%;
                left: 1%;
            }

            #printButtons .icon {
                display: inline-block;
                height: 35px;
                width: 35px;
                padding: 15px;
                border-radius: 50%;
                cursor: pointer;
            }

            #printButtons .icon svg {
                height: 100%;
                width: 100%;
            }

            #printButtons .icon.downloadicon {
                background-color: #00A36C;
            }

            #printButtons .icon.printicon {
                background-color: #088F8F;
            }

            .icon {
                transition: all .2s ease-in-out;
            }

            .icon:hover {
                transform: scale(1.1);
            }
        </style>
    <?php endif; ?>

</head>

<body style="background-color:#f2f2f2;width: 100% !important;height: 100% !important;margin: 0 !important;">

    <table border="0" cellpadding="0" cellspacing="0" id="printArea">

        <!-- start logo -->
        <tr>
            <td align="center" bgcolor="#f2f2f2">
                <!--[if (gte mso 9)|(IE)]>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                    <tr>
                    <td align="center" valign="top" width="600">
                    <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" valign="top" style="padding: 36px 24px;">
                            <a href="<?= base_url(route_to('homepage')) ?>" target="_blank" style="display: inline-block;">
                                <img src="<?= base_url(MINIBOX_LOGO); ?>" alt="MINI BOX OFFICE" border="0" height="30" style="display: block; height: 30px; max-height: 30px; min-width: 48px;height: auto;line-height: 100%;text-decoration: none;border: 0;outline: none;">
                            </a>
                        </td>
                    </tr>
                </table>
                <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
            </td>
        </tr>
        <!-- end logo -->

        <!-- start hero -->
        <tr>
            <td align="center" bgcolor="#f2f2f2">
                <!--[if (gte mso 9)|(IE)]>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                    <tr>
                    <td align="center" valign="top" width="600">
                    <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: DejaVu Sans, sans-serif; border-top: 3px solid #d4dadf;">
                            <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">Thank you for your order!</h1>
                        </td>
                    </tr>
                </table>
                <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
            </td>
        </tr>
        <!-- end hero -->

        <!-- start copy block -->
        <tr>
            <td align="center" bgcolor="#f2f2f2">
                <!--[if (gte mso 9)|(IE)]>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                    <tr>
                    <td align="center" valign="top" width="600">
                    <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">

                    <!-- start copy -->
                    <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px;">
                            <p style="margin: 0;">Dear <?= $user_name ?><br /><br />Here is a summary of your recent order.</p>
                        </td>
                    </tr>
                    <!-- end copy -->

                    <!-- start receipt table -->
                    <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px;">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="left" bgcolor="#f2f2f2" width="75%" style="padding: 12px;font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px;"><strong>Receipt #</strong></td>
                                    <td align="left" bgcolor="#f2f2f2" width="25%" style="padding: 12px;font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px; text-align:right;"><strong><?= $receipt_number ?></strong></td>
                                </tr>
                                <?php foreach ($items as $key => $item) : ?>
                                    <tr>
                                        <td align="left" width="75%" style="padding: 6px 12px;font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 0.5px solid #D2C7BA;"><?= $item['details'] ?></td>
                                        <td align="left" width="25%" style="padding: 6px 12px;font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 0.5px solid #D2C7BA; text-align:right;"><?= $item['amount'] ?></td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (isset($taxes)) : ?>
                                    <tr>
                                        <td align="left" width="75%" style="padding: 6px 12px;font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px;"><?= $taxes['name'] ?></td>
                                        <td align="left" width="25%" style="padding: 6px 12px;font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px; text-align:right;"><?= $taxes['amount'] ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td align="left" width="75%" style="padding: 12px; font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA;"><strong>Total</strong></td>
                                    <td align="left" width="25%" style="padding: 12px; font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px; border-top: 2px dashed #D2C7BA; border-bottom: 2px dashed #D2C7BA; text-align:right;"><strong><?= $total ?></strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- end reeipt table -->

                    <!-- start copy -->
                    <?php if ($email_view && isset($ticket_link)) : ?>
                        <tr>
                            <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px;">
                                <p style="margin: 0;">
                                    You can download your tickets from <a href="<?= $ticket_link ?>">Here.</a>
                                </p>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <!-- end copy -->
                </table>
                <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
            </td>
        </tr>
        <!-- end copy block -->

        <!-- start receipt address block -->
        <tr>
            <td align="center" bgcolor="#f2f2f2" valign="top" width="100%">
                <!--[if (gte mso 9)|(IE)]>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                    <tr>
                    <td align="center" valign="top" width="600">
                    <![endif]-->
                <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" valign="top" style="font-size: 0; border-bottom: 3px solid #d4dadf">
                            <!--[if (gte mso 9)|(IE)]>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                <tr>
                                <td align="left" valign="top" width="300">
                                <![endif]-->
                            <div style="display: inline-block; width: 100%; max-width: 50%; min-width: 240px; vertical-align: top;">
                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 300px;">
                                    <tr>
                                        <td align="left" valign="top" style="padding-bottom: 36px; padding-left: 36px; font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px;">
                                            <p><strong>Billing Address</strong></p>
                                            <p style="max-width: 200px;"><?= $user_address ?></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!--[if (gte mso 9)|(IE)]>
                                </td>
                                <td align="left" valign="top" width="300">
                                <![endif]-->
                            <div style="display: inline-block; width: 100%; max-width: 50%; min-width: 240px; vertical-align: top;">
                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 300px;">
                                    <tr>
                                        <td align="left" valign="top" style="padding-bottom: 36px; padding-left: 36px; font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px;">
                                            <p><strong>By: MINIBOXOFFICE</strong></p>
                                            <p style="max-width: 200px;">
                                                <?= MINIBOX_ADDRESS ?><br>
                                                <?= CUSTOMER_SUPPORT_EMAIL ?><br>
                                                <?= CUSTOMER_SUPPORT_PHONE ?>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!--[if (gte mso 9)|(IE)]>
                                </td>
                                </tr>
                                </table>
                                <![endif]-->
                        </td>
                    </tr>
                </table>
                <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
            </td>
        </tr>
        <!-- end receipt address block -->

        <!-- start footer -->
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 24px;">
                <!--[if (gte mso 9)|(IE)]>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                    <tr>
                    <td align="center" valign="top" width="600">
                    <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">

                    <!-- start permission -->
                    <?php if ($email_view) : ?>
                        <tr>
                            <td align="center" bgcolor="#f2f2f2" style="padding: 12px 24px; font-family: DejaVu Sans, sans-serif; font-size: 14px; line-height: 20px; color: #666;">
                                <p style="margin: 0;"><a href="<?= $link ?>">Print & Download Receipt From Here</a></p>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td align="center" bgcolor="#f2f2f2" style="padding: 12px 24px; font-family: DejaVu Sans, sans-serif; font-size: 14px; line-height: 20px; color: #666;">
                            <p style="margin: 0;">If you have any questions or concerns about your order, please mail us at <?= CUSTOMER_SUPPORT_EMAIL ?> with your Receipt number.</p>
                        </td>
                    </tr>
                    <?php if ($email_view) : ?>
                        <tr>
                            <td align="center" bgcolor="#f2f2f2" style="padding: 12px 24px; font-family: DejaVu Sans, sans-serif; font-size: 14px; line-height: 20px; color: #666;">
                                <p style="margin: 0;">You received this email because we received a request for <?= $type_of_action ?> for your behalf. If you didn't request <?= $type_of_action ?> you can safely delete this email.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <!-- end permission -->

                </table>
                <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
            </td>
        </tr>
        <!-- end footer -->

    </table>

    <?php if (!$email_view) : ?>
        <div class="loading" id="loading">Loading&#8230;</div>
        <div id="printButtons">
            <div class="icon downloadicon" id="downloadicon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" class="bi bi-download" viewBox="0 0 16 16">
                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                </svg>
            </div>
            <div class="icon printicon" id="printicon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" class="bi bi-printer" viewBox="0 0 16 16">
                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                    <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                </svg>
            </div>
        </div>
        <script src="/public/js/jquery.min.js" type="text/javascript"></script>
        <script src="/public/js/html2canvas.min.js" type="text/javascript"></script>
        <script>
            document.getElementById("printicon").addEventListener("click", function() {
                var originalContents = document.body.innerHTML;

                var printContents = document.getElementById("printArea").innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            });
            document.getElementById("downloadicon").addEventListener("click", function() {
                loaderStart();
                $('#downloadicon').attr('disabled', 'disabled');
                html2canvas(document.getElementById("printArea"), {
                    allowTaint: true,
                    useCORS: true
                }).then(function(canvas) {
                    var anchorTag = document.createElement("a");
                    document.body.appendChild(anchorTag);
                    document.createElement("div").appendChild(canvas);
                    var fileName = Date.now();
                    anchorTag.download = fileName + ".jpg";
                    anchorTag.href = canvas.toDataURL();
                    anchorTag.target = '_blank';
                    anchorTag.click();
                    setTimeout(() => {
                        loaderStop();
                        $('#downloadicon').removeAttr('disabled');
                    }, 700);
                }).catch((function(error) {
                    console.error(error);
                    loaderStop();
                    $('#downloadicon').removeAttr('disabled');
                }))
            });

            function loaderStart() {
                // $('body').addClass('loading');
                $('#loading').show();
            }

            function loaderStop() {
                // if ($('body').hasClass('loading')) {
                //     $('body').removeClass('loading');
                // }
                $('#loading').hide();
            }
        </script>
    <?php endif; ?>
</body>

</html>