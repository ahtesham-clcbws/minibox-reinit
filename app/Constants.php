<?php

define('MINIBOX_LOGO', '/public/images/1619170047-logo.png');
define('MINIBOX_LOGO_ROTATED', '/public/images/rotated-logo.png');
define('MINIBOX_LOGO_DATA', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAN4AAAAZCAMAAABpVGCJAAAAbFBMVEX////YsGkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADYsGnYsGnYsGnYsGkAAAAAAAAAAAAAAAAAAAAAAADYsGnYsGnYsGkAAADYsGnYsGnYsGnYsGnYsGnYsGnYsGnYsGnYsGnYsGkAAADYsGne5ecnAAAAInRSTlMAAAARVbvdmSJmJKvuJYhEdzOq7ibvKMytr/L087MpKiew+xpxPQAAA8ZJREFUWMPdmNty3CAMhjcc7SY1wjR1k7ZJS97/HQviYDB4vYfOdKZc2YBBH0j6tXs6/W/tYW3ujZJe6/f+m8a4tUIOzigprOXj+dke79Pj09PjZ8STXbrpaiMUhKaG20E0THwGVndOFpsig8EHfoj35enDteevHs+yzpyJX20a2NTEeBvcKOICBgrnUb5nse4WuB8SdjjE+/aB7QXxTOuIzN6DZ6285eaWYgGznvns3jShA9FhYU0O8V4D3nfEa1GoiX1qhj1XbEZKPAvX0wXPE5yHFbIHmHRafoPhwKyA96PCa4zhEXnYNbQzAhgf7ub9LYib6KJT4gqZL+/kNyDnzYp4LwHvZ8SzujEU8fSun3VGEh6hItlxRfNEnFaeoPfw9Fn3d3hvz5ha3hPesjU9Oudkl51AbkcyHpHX48HGCFgzZIt3xqwoDL9eXl9/vz0kPFvoAB7+janlZjznmmbYxEdcrYN3qHuFrCdVSU3aO/H8+cxXCnd9wlEO5G14dYuZmBY77eANTrTZIR6VZTBrOPtRodybhC9SfjrA00oVhQRzu410g+ezVjxvXxksCU+lC3GuAnRG7oVWI11hMCnr6ZjlBUt+IePXRm9dcWP2jF3Ktq3cPFYCPLyCibJU4wHPiZj7IOjhyaS68zEeHypPSGmeLuHBey+QAzy4BE/mA6Xlm5U13pBCG9CAHp6bMCks/47xYtGBNeKkFB6qiuLmrg2a2OzgTRfgAVoFk8DC0r9JFVSTVXh4zkvQhJn08dCdptizgyed63OTREsmn9BpwdFv474VtMWjO8Rt7KXNhxwrrBD7k3cOUeOhKeAH/DV38cayZwdPVaKVyyk8FZoeTPMpflHnH5qFcB8PqoTk3gx+Ofrr0zUexsUcv+vi0YvxYlrQq83r9KVbkeomV0OWin28uSoFZlyCSazu5AYv1CpxyR7eQi7HC4/FnPVRtTVglAE71kV9qp/38Xh1Jt7GKbCxTebMqSH7Q4PHr8CTaNuwmszq2xO0p+uFVqAvTeT49orSPeTNmq38xcDzud6J5x3BhNjj+WRNCsJCZDcyl51WLcUZnI89VZeprFe1QHIIIPfhgSshQCZLs4xDemBef3gv+mi41skvEGRIE3JB5gzThuLtRKGLRxgnd+LlhvkaA0gALEl3vRCy0K37fKty5gn7eOFfmBlA4OwQXZOzVXXx8t9jd+PFX27xF3i2lge31N3wyyUVlh3r8Bm8tU5ZqqpF0C4e+St4i8wjVJrC2ilRQTf8CIVwg/in30V4m5ozv610fwAWVeHLOqvV9gAAAABJRU5ErkJggg==');
define('RUPEE_DATA_URI', '/public/images/1619170047-logo.png');
define('EURO_DATA_URI', '/public/images/1619170047-logo.png');
define('DEFAULTPROFILEPIC', '/public/images/avatar.jpg');
define('PLACEHOLDER2', '/public/images/placeholder2.jpg');
define('CUSTOMER_SUPPORT_EMAIL', 'care@miniboxoffice.com');
define('CUSTOMER_SUPPORT_PHONE', '+91 9999 999 999');
define('MINIBOX_ADDRESS', 'Paste 1234 S. Broadway St. City, State 12345');

define('ADMIN_NOTIFICATION_EMAILS', ['ahtesham2000@gmail.com']);


//PAYMENT GATEWAY VARIABLES
// razorpay variables
define('RAZORPAY_KEY_ID', 'rzp_test_c8M3til0e98SDu');
define('RAZORPAY_SECRET', '5r0GZFwdA0JCflToMouUZFkk');

define("RAZORPAY_ENVIRONMENT", getenv('RAZORPAY_ENV'));

define("PAZORPAY_CREDENTIALS", array(
    "test" => [
        "KEY_ID" => "rzp_test_c8M3til0e98SDu",
        "SECRET" => "5r0GZFwdA0JCflToMouUZFkk"
    ],
    "production" => [
        "KEY_ID" => "",
        "SECRET" => ""
    ]
));
// stripe variables
define('STRIPE_SECRET', '808');
// paypal variables
define('PAYPAL_API_USERNAME', 'YOUR USER NAME HERE');
define('PAYPAL_API_PASSWORD', 'YOUR PASSWORD HERE');
define('PAYPAL_API_SIGNATURE', 'YOUR API SIGNATURE HERE');
define('PAYPAL_API_ENDPOINT', 'https://api-3t.paypal.com/nvp');
define('PAYPAL_USE_PROXY', FALSE);
define('PAYPAL_PROXY_HOST', '127.0.0.1');
define('PAYPAL_PROXY_PORT', '808');
define('PAYPAL_PAYPAL_URL', 'https://www.PayPal.com/webscr&cmd=_express-checkout&token=');
define('PAYPAL_VERSION', '53.0');
// PayPal Environment 
define("PAYPAL_ENVIRONMENT", getenv('PAYPAL_ENV'));

// PayPal REST API endpoints
define("PAYPAL_ENDPOINTS", array(
    "sandbox" => "https://api.sandbox.paypal.com",
    "production" => "https://api.paypal.com"
));

// PayPal REST App credentials
define("PAYPAL_CREDENTIALS", array(
    "sandbox" => [
        "client_id" => "Aa2IfcoEvHnfJRnVQLSFrSs3SmTTkv5N1weMEL66ysqYIeHfAqXpDVkjOv3vLhkhbP4eKB6MpRlQIcJw",
        "client_secret" => "EF6l6PDQJEZbdKTeg35pbBSft6WRdALQC3Xrl5vvG0VNgBUehQyTCQ09QdIauxoccvJOf5Aoy-OGsH5G"
    ],
    "production" => [
        "client_id" => "",
        "client_secret" => ""
    ]
));

// PayPal REST API version
define("PAYPAL_REST_VERSION", "v2");

// ButtonSource Tracker Code
define("SBN_CODE", "PP-DemoPortal-EC-Psdk-ORDv2-php");
