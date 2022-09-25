<?php

use App\Models\Common\SiteSettings;

function getSettings()
{
    $cache = cache();
    $currentTime = date('Y-m-d H:i:s');

    if (getenv('CI_ENVIRONMENT') == 'development') {
        $cache->delete('siteSettings');
        $cache->delete('siteSettingsTime');
    }

    if ($cache->get('siteSettings')) {
        $date1 = date_create($cache->get('siteSettingsTime'));
        $date2 = date_create($currentTime);
        $diff = date_diff($date1, $date2);
        if ($diff->h > 24) {

            $settingsMd = new SiteSettings();
            $allSetting = $settingsMd->findAll();

            $cache->save('siteSettings', $allSetting);
            $cache->save('siteSettingsTime', $currentTime);
        } else {
            $allSetting = $cache->get('siteSettings');
        }
    } else {

        $settingsMd = new SiteSettings();
        $allSetting = $settingsMd->findAll();

        $cache->save('siteSettings', $allSetting);
        $cache->save('siteSettingsTime', $currentTime);
    }

    $settings = [];
    foreach ($allSetting as $key => $setting) {
        $settings[$setting['name']] = $setting['value'];
    }
    return $settings;
}
function getNotificationEmails()
{
    $emails = isset(getSettings()['ADMIN_NOTIFICATION_EMAILS']) ? json_decode(getSettings()['ADMIN_NOTIFICATION_EMAILS'], true) : [];
    return $emails;
}
function getEmailConfigration()
{
    $config['charset']  = 'utf-8';
    $config['mailType'] = 'html';

    $config['protocol'] = 'sendmail';

    $siteSetting = getSettings();
    if (isset($siteSetting['email_protocol'])) {
        if ($siteSetting['email_protocol'] === 'smtp') {
            $config['protocol'] = $siteSetting['email_protocol'];
            $config['SMTPHost'] = $siteSetting['smtp_host'];
            $config['SMTPPort'] = $siteSetting['smtp_port'];
            $config['SMTPUser'] = $siteSetting['smtp_user'];
            $config['SMTPPass'] = $siteSetting['smtp_password'];
        }
    }

    return $config;
}
