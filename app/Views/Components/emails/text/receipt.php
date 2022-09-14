<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Email Receipt</title>
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
    </style>

</head>

<body style="background-color:#f2f2f2;width: 100% !important;height: 100% !important;padding: 0 !important;margin: 0 !important;">

    <table border="0" cellpadding="0" cellspacing="0" style="width: 100% !important;">

        <!-- start logo -->
        <tr>
            <td align="center" bgcolor="#f2f2f2">
                <!--[if (gte mso 9)|(IE)]>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                    <tr>
                    <td align="center" valign="top" width="600">
                    <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 36px 24px;">
                            <a href="<?= base_url(route_to('homepage')) ?>" target="_blank" style="display: inline-block;">
                                <img src="<?= MINIBOX_LOGO_DATA ?>" alt="MINI BOX OFFICE" border="0" height="30" style="display: block; height: 30px; max-height: 30px; min-width: 48px;height: auto;line-height: 100%;text-decoration: none;border: 0;outline: none;">
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
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
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
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

                    <!-- start copy -->
                    <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px;">
                            <p style="margin: 0;">Here is a summary of your recent order.<br />If you have any questions or concerns about your order, please mail us at example@miniboxoffice.com with your Receipt number.</p>
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
                                        <td align="left" width="75%" style="padding: 6px 12px;font-family: DejaVu Sans, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 0.5px solid #D2C7BA;"><?= $item['name'] ?></td>
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
                <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
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
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

                    <!-- start permission -->
                    <tr>
                        <td align="center" bgcolor="#f2f2f2" style="padding: 12px 24px; font-family: DejaVu Sans, sans-serif; font-size: 14px; line-height: 20px; color: #666;">
                            <p style="margin: 0;">You received this email because we received a request for <?= $type_of_action ?> for your behalf. If you didn't request <?= $type_of_action ?> you can safely delete this email.</p>
                        </td>
                    </tr>
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

</body>

</html>