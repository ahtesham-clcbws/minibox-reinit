<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Festival Entry</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    * {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    /**
   * Avoid browser level font resizing.
   * 1. Windows Mobile
   * 2. iOS / OSX
   */
    body,
    table,
    td,
    a {
      -ms-text-size-adjust: 100%;
      /* 1 */
      -webkit-text-size-adjust: 100%;
      /* 2 */
    }

    /**
   * Remove extra space added to tables and cells in Outlook.
   */
    table,
    td {
      mso-table-rspace: 0pt;
      mso-table-lspace: 0pt;
    }

    /**
   * Better fluid images in Internet Explorer.
   */
    img {
      -ms-interpolation-mode: bicubic;
    }

    /**
   * Remove blue links for iOS devices.
   */
    a[x-apple-data-detectors] {
      font-family: inherit !important;
      font-size: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
      color: inherit !important;
      text-decoration: none !important;
    }

    /**
   * Fix centering issues in Android 4.4.
   */
    div[style*="margin: 16px 0;"] {
      margin: 0 !important;
    }

    body {
      width: 100% !important;
      height: 100% !important;
      padding: 0 !important;
      margin: 0 !important;
    }

    /**
   * Collapse table borders to avoid space between cells.
   */
    table {
      border-collapse: collapse !important;
    }

    a {
      color: black;
    }

    img {
      height: auto;
      line-height: 100%;
      text-decoration: none;
      border: 0;
      outline: none;
    }
  </style>

</head>

<body style="background-color: #e9ecef;">


  <!-- start body -->
  <table border="0" cellpadding="0" cellspacing="0" width="100%">

    <!-- start logo -->
    <tr>
      <td align="center" bgcolor="#e9ecef">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
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

    <!-- start copy block -->
    <tr>
      <td align="center" bgcolor="#e9ecef">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

          <!-- start copy -->
          <tr>
            <td bgcolor="#ffffff" align="left" style="padding: 24px;  font-size: 16px; line-height: 24px;">
              <h1 style="margin: 0 0 12px; font-size: 32px; font-weight: 400; line-height: 48px;">Welcome, <?= $user_name ?>!</h1>
              <p style="margin: 0;">
                Thank you for signing up with us on <b>(<?= $festival_name ?>)</b>.<br />
                Please fill out all the details about your movie/film for Festival Catalogue.<br /><br />
                <?php if (isset($user_email, $user_password)) : ?>
                  Please use email: <b><?= $user_email ?></b> & password: <b><?= $user_password ?></b> for login.
                <?php else : ?>
                  Please use your email & password for login. If you dont have your credentials please mail: <b><?= CUSTOMER_SUPPORT_EMAIL ?></b> or call: <b><?= CUSTOMER_SUPPORT_PHONE ?></b> us.
                <?php endif; ?>
              </p>
            </td>
          </tr>
          <!-- end copy -->

          <!-- start button -->
          <tr>
            <td align="left" bgcolor="#ffffff">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td align="center" bgcolor="#ffffff" style="padding: 12px;">
                    <table border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="center" bgcolor="#1a82e2" style="border-radius: 6px;">
                          <a href="<?= $entry_form_link ?>" target="_blank" rel="noopener noreferrer" style="display: inline-block; padding: 16px 36px;  font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;">
                            Complete Movie details
                          </a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <!-- end button -->

          <!-- start copy -->
          <tr>
            <td align="left" bgcolor="#ffffff" style="padding: 24px;  font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf">
              <p style="margin: 0;">
                Have a Good Day,<br>
                Best Regard,<br>
                Mini Box Office Team
              </p>
            </td>
          </tr>
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

    <!-- start footer -->
    <tr>
      <td align="center" bgcolor="#e9ecef" style="padding: 24px;">
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
          <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 12px 24px; font-family: DejaVu Sans, sans-serif; font-size: 14px; line-height: 20px; color: #666;">
              <p style="margin: 0;">If you have any questions or concerns, please mail us at <?= CUSTOMER_SUPPORT_EMAIL ?></p>
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
  <!-- end body -->

</body>

</html>