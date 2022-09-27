<?php

use App\Models\Common\CitiesModel;
use App\Models\Common\CountriesModel;
use App\Models\Common\LanguagesModel;
use App\Models\Common\LogsModel;
use App\Models\Common\SiteSettings;
use App\Models\Common\StatesModel;
use App\Models\Festival\FestivalModel;
use App\Models\Festival\FestivalTypeOfFilms;
use App\Models\Films\FilmInfosData;
use App\Models\HomePageBannersModel;
use App\Models\UserModel;
use Config\Database;

$response = ['success' => false, 'message' => '', 'data' => []];
function getCustomerCare()
{
    return array('email' => CUSTOMER_SUPPORT_EMAIL, 'phone' => CUSTOMER_SUPPORT_PHONE);
}
function createMainAdmin()
{
    $data = [

        'first_name' => 'Ahtesham',
        'last_name' => 'Chaudhary',
        'email' => 'ahtesham2000@gmail.com',
        'mobile' => '9810763314',
        'password' => createPassword('23988725'),
        'role' => 'admin',
        'module' => 'super',
        'permissions' => 'all',
        'email_status' => 'verified',
        'mobile_status' => 'verified',
        'status' => 'verified',
    ];
    $userDb = new UserModel();
    $userDb->save($data);
}

function getUri()
{
    return service('uri');
}
function getDB()
{
    return Database::connect();
}
function getUrlSegment($number)
{
    $service = service('uri');
    if ($service->getTotalSegments() >= $number) {
        return getUri()->getSegment($number);
    } else {
        return false;
    }
}
function dontShowSidenav()
{
    if (!getUrlSegment(2)) {
        return true;
    }
    if (getUrlSegment(2) == 'film-festivals' && getUrlSegment(3) == 'official-submissions') {
        return true;
    }
    if (getUrlSegment(2) == 'film-festivals' && intval(getUrlSegment(4)) && getUrlSegment(5)) {
        return true;
    }
    // if (getUrlSegment(2) == 'film-zine') {
    //     return true;
    // }
    if (getUrlSegment(3) && getUrlSegment(3) == 'orders') {
        return true;
    }
    if (getUrlSegment(2) == 'settings' && !getUrlSegment(3)) {
        return true;
    }
    return false;
}

function getFooter($pagename = '')
{
    $modules = [
        'film-festival'
    ];
    if (in_array($pagename, $modules)) {
        return true;
    }
    return false;
}
function verifySuperAdmin()
{
    if (session()->get('adminAuth')) {
        $token = session()->get('user.token');
        $userDb = new UserModel();
        if ($userDb->select('id')->where('token', $token)->first()) {
            return true;
        }
        return false;
    }
    return false;
}

function verifyPermissionAdd($userId, $module)
{
    $userDb = new UserModel();
    $roles = ['admin', 'staff'];
    $permissions = ['add', 'all'];
    if ($userDb->select('id')->where(['id' => $userId, 'module' => $module])->whereIn('role', $roles)->whereIn('permissions', $permissions)->first()) {
        return true;
    }
    return false;
}
function verifyPermissionEdit($userId, $module)
{
    $userDb = new UserModel();
    $roles = ['admin', 'staff'];
    $permissions = ['edit', 'all'];
    if ($userDb->select('id')->where(['id' => $userId, 'module' => $module])->whereIn('role', $roles)->whereIn('permissions', $permissions)->first()) {
        return true;
    }
    return false;
}
function verifyPermissionDelete($userId, $module)
{
    $userDb = new UserModel();
    $roles = ['admin', 'staff'];
    $permissions = ['delete', 'all'];
    if ($userDb->select('id')->where(['id' => $userId, 'module' => $module])->whereIn('role', $roles)->whereIn('permissions', $permissions)->first()) {
        return true;
    }
    return false;
}
function verifyPermissionAdminPanelLogin($email)
{
    $userDb = new UserModel();
    $roles = ['admin', 'staff'];
    if ($userDb->select('id')->where(['email' => $email])->whereIn('role', $roles)->first()) {
        return true;
    }
    return false;
}
function createPassword($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function user_login($userEmail, $userPassword, $device = 'web')
{
    $response = ['success' => false, 'message' => '', 'user_data' => []];
    $userDb = new UserModel();
    $getUser = $userDb->where('email', $userEmail)->first();

    // return $getUser;

    // if (isset($getUser['status']))
    if ($getUser) {
        if (!$getUser['status'] || $getUser['status'] == '0') {
            $response['message'] = 'You are not activated, please contact adminstration.';
        } else {
            if (password_verify($userPassword, $getUser['password']) && $getUser['status']) {
                unset($getUser['password']);

                $getUser['token'] = createAppToken($getUser['id'], $device);
                $getUser['device'] = $device;

                $sessionData['userLoggedIn'] = true;
                $sessionData['loginType'] = $getUser['role'];
                $sessionData['user'] = $getUser;
                session()->set($sessionData);
                $response['success'] = true;
                $response['user_data'] = $getUser;
                $response['message'] = 'Login successfully.';
            } else {
                // return print_r('not match or not activated');
                $response['message'] = 'Password or email not matched. Or User not activated yet.';
            }
        }
    } else {
        $response['message'] = 'Password or email not matched. Or User not activated yet.';
    }

    $getRedirect = session()->get('auth_redirect');
    if ($getRedirect) {
        $response['auth_redirect'] = $getRedirect;
    }
    return $response;
}
function createAppToken($userId, $device = 'web')
{
    $werd = array($userId, time(), rand());
    $token = base64_encode(json_encode($werd));

    return saveTokenToUserTable($userId, $token, $device);
}
function saveTokenToUserTable($userId, $token, $device = 'web')
{
    $userDb = new UserModel();
    $userDataSave = $userDb->save(['id' => $userId, 'token' => $token, 'device' => $device]);
    if ($userDataSave) {
        return $token;
    } else {
        return '';
    }
}
function getFestivalsList()
{
    $festivalDb = new FestivalModel();
    return $festivalDb->select('id, name, slug, edition, current_year')->findAll();
}
function getActiveFestivalsList()
{
    $festivalDb = new FestivalModel();
    return $festivalDb->select('id, name, slug, edition, current_year')->where('status', '1')->findAll();
}

function getFestivalById($id)
{
    $festivalDb = new FestivalModel();
    return $festivalDb->select('id, name, slug')->find($id);
}

// fontEnd only functions
function getAllFrontEndFestivalsListWithSlug()
{
    $festivalDb = new FestivalModel();
    return $festivalDb->where('status', '1')->findAll();
}
function getOtherFrontEndFestivalsListWithSlug()
{
    $festivalDb = new FestivalModel();
    return $festivalDb->where('status', '1')->findAll();
}
function getHomepageBanners()
{
    $bannersDb = new HomePageBannersModel();
    $banners = $bannersDb->where('status', '1')->findAll();
    return $banners;
}


// world data

function getLanguages()
{
    $sessionData = session()->get('languages_list');
    if ($sessionData) {
        return $sessionData;
    } else {
        $db = new LanguagesModel();
        $thisdata = $db->getAllLanguages();
        session()->set('languages_list', $thisdata);
        return $thisdata;
    }
}
function getAllCountries()
{
    $sessionData = session()->get('countries_list');
    if ($sessionData) {
        return $sessionData;
    } else {
        $db = new CountriesModel();
        $thisdata = $db->select('id, name')->findAll();
        session()->set('languages_list', $thisdata);
        return $thisdata;
    }
}

function getStatesByCountryId($country_id)
{
    // $statesDb = new StatesModel();
    // return $statesDb->select('id, name')->where(['country_id' => $country_id])->findAll();

    $sessionData = session()->get('states_by_country_id_' . $country_id);
    if ($sessionData) {
        return $sessionData;
    } else {
        $db = new StatesModel();
        $thisdata = $db->select('id, name')->where(['country_id' => $country_id])->findAll();
        session()->get('states_by_country_id_' . $country_id, $thisdata);
        return $thisdata;
    }
}
function getStatesByCountryCode($country_code)
{
    // $statesDb = new StatesModel();
    // return $statesDb->select('id, name')->where(['country_code' => $country_code])->findAll();

    $sessionData = session()->get('states_by_country_code_' . $country_code);
    if ($sessionData) {
        return $sessionData;
    } else {
        $db = new StatesModel();
        $thisdata = $db->select('id, name')->where(['country_code' => $country_code])->findAll();
        session()->get('states_by_country_code_' . $country_code, $thisdata);
        return $thisdata;
    }
}

function getCitiesByCountryId($country_id)
{
    // $cityDb = new CitiesModel();
    // return $cityDb->select('id, name')->where(['country_id' => $country_id])->findAll();

    $sessionData = session()->get('cities_by_country_id_' . $country_id);
    if ($sessionData) {
        return $sessionData;
    } else {
        $db = new CitiesModel();
        $thisdata = $db->select('id, name')->where(['country_id' => $country_id])->findAll();
        session()->get('cities_by_country_id_' . $country_id, $thisdata);
        return $thisdata;
    }
}
function getCitiesByCountryCode($country_code)
{
    // $cityDb = new CitiesModel();
    // return $cityDb->select('id, name')->where(['country_code' => $country_code])->findAll();

    $sessionData = session()->get('cities_by_country_code_' . $country_code);
    if ($sessionData) {
        return $sessionData;
    } else {
        $db = new CitiesModel();
        $thisdata = $db->select('id, name')->where(['country_code' => $country_code])->findAll();
        session()->get('cities_by_country_code_' . $country_code, $thisdata);
        return $thisdata;
    }
}
function getCitiesByStateId($state_id)
{
    // $cityDb = new CitiesModel();
    // return $cityDb->select('id, name')->where(['state_id' => $state_id])->findAll();

    $sessionData = session()->get('cities_by_state_id_' . $state_id);
    if ($sessionData) {
        return $sessionData;
    } else {
        $db = new CitiesModel();
        $thisdata = $db->select('id, name')->where(['state_id' => $state_id])->findAll();
        session()->get('cities_by_state_id_' . $state_id, $thisdata);
        return $thisdata;
    }
}
function getCitiesByStateCode($state_code)
{
    $cityDb = new CitiesModel();
    return $cityDb->select('id, name')->where(['state_code' => $state_code])->findAll();

    $sessionData = session()->get('cities_by_state_code_' . $state_code);
    if ($sessionData) {
        return $sessionData;
    } else {
        $db = new CitiesModel();
        $thisdata = $db->select('id, name')->where(['state_code' => $state_code])->findAll();
        session()->get('cities_by_state_code_' . $state_code, $thisdata);
        return $thisdata;
    }
}
function getWorldName($id, $type = 'country')
{
    $name = false;
    if ($type == 'country') {
        $entityDb = new CountriesModel();
    }
    if ($type == 'state') {
        $entityDb = new StatesModel();
    }
    if ($type == 'city') {
        $entityDb = new CitiesModel();
    }
    $entity = $entityDb->find($id);
    if ($entity) {
        $name = $entity['name'];
    }
    return $name;
}
function getWorldNameByName($name, $type = 'country')
{
    $name = false;
    if ($type == 'country') {
        $entityDb = new CountriesModel();
        $entity = $entityDb->select('id')->where('iso2', $name)->first();
    }
    if ($type == 'state') {
        $entityDb = new StatesModel();
        $entity = $entityDb->select('id')->like('name', $name)->first();
    }
    if ($type == 'city') {
        $entityDb = new CitiesModel();
        $entity = $entityDb->select('id')->like('name', $name)->first();
    }

    if ($entity) {
        $id = $entity['id'];
        return $id;
    }
    return false;
}
function convertNumberToWord($num = false)
{
    $num = str_replace(array(',', ' '), '', trim($num));
    if (!$num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array(
        '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array(
        '', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ($tens < 20) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}
function slugify($text, string $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return false;
    }

    return $text;
}
function uniqueSlugify($text, $dbModel, $ids = [], string $slugKey = 'slug', string $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return false;
    }
    $counts = $dbModel->where($slugKey, $text)->whereNotIn('id', $ids)->countAllResults();
    if ($counts > 0) {
        $text = $text . $divider . $counts;
    }

    return $text;
}


//font awesome icons list
function getIcons()
{
    $icons = [
        "fas fa-ad",
        "fas fa-address-book",
        "fas fa-address-card",
        "fas fa-adjust",
        "fas fa-air-freshener",
        "fas fa-align-center",
        "fas fa-align-justify",
        "fas fa-align-left",
        "fas fa-align-right",
        "fas fa-allergies",
        "fas fa-ambulance",
        "fas fa-american-sign-language-interpreting",
        "fas fa-anchor",
        "fas fa-angle-double-down",
        "fas fa-angle-double-left",
        "fas fa-angle-double-right",
        "fas fa-angle-double-up",
        "fas fa-angle-down",
        "fas fa-angle-left",
        "fas fa-angle-right",
        "fas fa-angle-up",
        "fas fa-angry",
        "fas fa-ankh",
        "fas fa-apple-alt",
        "fas fa-archive",
        "fas fa-archway",
        "fas fa-arrow-alt-circle-down",
        "fas fa-arrow-alt-circle-left",
        "fas fa-arrow-alt-circle-right",
        "fas fa-arrow-alt-circle-up",
        "fas fa-arrow-circle-down",
        "fas fa-arrow-circle-left",
        "fas fa-arrow-circle-right",
        "fas fa-arrow-circle-up",
        "fas fa-arrow-down",
        "fas fa-arrow-left",
        "fas fa-arrow-right",
        "fas fa-arrow-up",
        "fas fa-arrows-alt",
        "fas fa-arrows-alt-h",
        "fas fa-arrows-alt-v",
        "fas fa-assistive-listening-systems",
        "fas fa-asterisk",
        "fas fa-at",
        "fas fa-atlas",
        "fas fa-atom",
        "fas fa-audio-description",
        "fas fa-award",
        "fas fa-baby",
        "fas fa-baby-carriage",
        "fas fa-backspace",
        "fas fa-backward",
        "fas fa-bacon",
        "fas fa-bahai",
        "fas fa-balance-scale",
        "fas fa-balance-scale-left",
        "fas fa-balance-scale-right",
        "fas fa-ban",
        "fas fa-band-aid",
        "fas fa-barcode",
        "fas fa-bars",
        "fas fa-baseball-ball",
        "fas fa-basketball-ball",
        "fas fa-bath",
        "fas fa-battery-empty",
        "fas fa-battery-full",
        "fas fa-battery-half",
        "fas fa-battery-quarter",
        "fas fa-battery-three-quarters",
        "fas fa-bed",
        "fas fa-beer",
        "fas fa-bell",
        "fas fa-bell-slash",
        "fas fa-bezier-curve",
        "fas fa-bible",
        "fas fa-bicycle",
        "fas fa-biking",
        "fas fa-binoculars",
        "fas fa-biohazard",
        "fas fa-birthday-cake",
        "fas fa-blender",
        "fas fa-blender-phone",
        "fas fa-blind",
        "fas fa-blog",
        "fas fa-bold",
        "fas fa-bolt",
        "fas fa-bomb",
        "fas fa-bone",
        "fas fa-bong",
        "fas fa-book",
        "fas fa-book-dead",
        "fas fa-book-medical",
        "fas fa-book-open",
        "fas fa-book-reader",
        "fas fa-bookmark",
        "fas fa-border-all",
        "fas fa-border-none",
        "fas fa-border-style",
        "fas fa-bowling-ball",
        "fas fa-box",
        "fas fa-box-open",
        "fas fa-boxes",
        "fas fa-braille",
        "fas fa-brain",
        "fas fa-bread-slice",
        "fas fa-briefcase",
        "fas fa-briefcase-medical",
        "fas fa-broadcast-tower",
        "fas fa-broom",
        "fas fa-brush",
        "fas fa-bug",
        "fas fa-building",
        "fas fa-bullhorn",
        "fas fa-bullseye",
        "fas fa-burn",
        "fas fa-bus",
        "fas fa-bus-alt",
        "fas fa-business-time",
        "fas fa-calculator",
        "fas fa-calendar",
        "fas fa-calendar-alt",
        "fas fa-calendar-check",
        "fas fa-calendar-day",
        "fas fa-calendar-minus",
        "fas fa-calendar-plus",
        "fas fa-calendar-times",
        "fas fa-calendar-week",
        "fas fa-camera",
        "fas fa-camera-retro",
        "fas fa-campground",
        "fas fa-candy-cane",
        "fas fa-cannabis",
        "fas fa-capsules",
        "fas fa-car",
        "fas fa-car-alt",
        "fas fa-car-battery",
        "fas fa-car-crash",
        "fas fa-car-side",
        "fas fa-caravan",
        "fas fa-caret-down",
        "fas fa-caret-left",
        "fas fa-caret-right",
        "fas fa-caret-square-down",
        "fas fa-caret-square-left",
        "fas fa-caret-square-right",
        "fas fa-caret-square-up",
        "fas fa-caret-up",
        "fas fa-carrot",
        "fas fa-cart-arrow-down",
        "fas fa-cart-plus",
        "fas fa-cash-register",
        "fas fa-cat",
        "fas fa-certificate",
        "fas fa-chair",
        "fas fa-chalkboard",
        "fas fa-chalkboard-teacher",
        "fas fa-charging-station",
        "fas fa-chart-area",
        "fas fa-chart-bar",
        "fas fa-chart-line",
        "fas fa-chart-pie",
        "fas fa-check",
        "fas fa-check-circle",
        "fas fa-check-double",
        "fas fa-check-square",
        "fas fa-cheese",
        "fas fa-chess",
        "fas fa-chess-bishop",
        "fas fa-chess-board",
        "fas fa-chess-king",
        "fas fa-chess-knight",
        "fas fa-chess-pawn",
        "fas fa-chess-queen",
        "fas fa-chess-rook",
        "fas fa-chevron-circle-down",
        "fas fa-chevron-circle-left",
        "fas fa-chevron-circle-right",
        "fas fa-chevron-circle-up",
        "fas fa-chevron-down",
        "fas fa-chevron-left",
        "fas fa-chevron-right",
        "fas fa-chevron-up",
        "fas fa-child",
        "fas fa-church",
        "fas fa-circle",
        "fas fa-circle-notch",
        "fas fa-city",
        "fas fa-clinic-medical",
        "fas fa-clipboard",
        "fas fa-clipboard-check",
        "fas fa-clipboard-list",
        "fas fa-clock",
        "fas fa-clone",
        "fas fa-closed-captioning",
        "fas fa-cloud",
        "fas fa-cloud-download-alt",
        "fas fa-cloud-meatball",
        "fas fa-cloud-moon",
        "fas fa-cloud-moon-rain",
        "fas fa-cloud-rain",
        "fas fa-cloud-showers-heavy",
        "fas fa-cloud-sun",
        "fas fa-cloud-sun-rain",
        "fas fa-cloud-upload-alt",
        "fas fa-cocktail",
        "fas fa-code",
        "fas fa-code-branch",
        "fas fa-coffee",
        "fas fa-cog",
        "fas fa-cogs",
        "fas fa-coins",
        "fas fa-columns",
        "fas fa-comment",
        "fas fa-comment-alt",
        "fas fa-comment-dollar",
        "fas fa-comment-dots",
        "fas fa-comment-medical",
        "fas fa-comment-slash",
        "fas fa-comments",
        "fas fa-comments-dollar",
        "fas fa-compact-disc",
        "fas fa-compass",
        "fas fa-compress",
        "fas fa-compress-alt",
        "fas fa-compress-arrows-alt",
        "fas fa-concierge-bell",
        "fas fa-cookie",
        "fas fa-cookie-bite",
        "fas fa-copy",
        "fas fa-copyright",
        "fas fa-couch",
        "fas fa-credit-card",
        "fas fa-crop",
        "fas fa-crop-alt",
        "fas fa-cross",
        "fas fa-crosshairs",
        "fas fa-crow",
        "fas fa-crown",
        "fas fa-crutch",
        "fas fa-cube",
        "fas fa-cubes",
        "fas fa-cut",
        "fas fa-database",
        "fas fa-deaf",
        "fas fa-democrat",
        "fas fa-desktop",
        "fas fa-dharmachakra",
        "fas fa-diagnoses",
        "fas fa-dice",
        "fas fa-dice-d20",
        "fas fa-dice-d6",
        "fas fa-dice-five",
        "fas fa-dice-four",
        "fas fa-dice-one",
        "fas fa-dice-six",
        "fas fa-dice-three",
        "fas fa-dice-two",
        "fas fa-digital-tachograph",
        "fas fa-directions",
        "fas fa-divide",
        "fas fa-dizzy",
        "fas fa-dna",
        "fas fa-dog",
        "fas fa-dollar-sign",
        "fas fa-dolly",
        "fas fa-dolly-flatbed",
        "fas fa-donate",
        "fas fa-door-closed",
        "fas fa-door-open",
        "fas fa-dot-circle",
        "fas fa-dove",
        "fas fa-download",
        "fas fa-drafting-compass",
        "fas fa-dragon",
        "fas fa-draw-polygon",
        "fas fa-drum",
        "fas fa-drum-steelpan",
        "fas fa-drumstick-bite",
        "fas fa-dumbbell",
        "fas fa-dumpster",
        "fas fa-dumpster-fire",
        "fas fa-dungeon",
        "fas fa-edit",
        "fas fa-egg",
        "fas fa-eject",
        "fas fa-ellipsis-h",
        "fas fa-ellipsis-v",
        "fas fa-envelope",
        "fas fa-envelope-open",
        "fas fa-envelope-open-text",
        "fas fa-envelope-square",
        "fas fa-equals",
        "fas fa-eraser",
        "fas fa-ethernet",
        "fas fa-euro-sign",
        "fas fa-exchange-alt",
        "fas fa-exclamation",
        "fas fa-exclamation-circle",
        "fas fa-exclamation-triangle",
        "fas fa-expand",
        "fas fa-expand-alt",
        "fas fa-expand-arrows-alt",
        "fas fa-external-link-alt",
        "fas fa-external-link-square-alt",
        "fas fa-eye",
        "fas fa-eye-dropper",
        "fas fa-eye-slash",
        "fas fa-fan",
        "fas fa-fast-backward",
        "fas fa-fast-forward",
        "fas fa-fax",
        "fas fa-feather",
        "fas fa-feather-alt",
        "fas fa-female",
        "fas fa-fighter-jet",
        "fas fa-file",
        "fas fa-file-alt",
        "fas fa-file-archive",
        "fas fa-file-audio",
        "fas fa-file-code",
        "fas fa-file-contract",
        "fas fa-file-csv",
        "fas fa-file-download",
        "fas fa-file-excel",
        "fas fa-file-export",
        "fas fa-file-image",
        "fas fa-file-import",
        "fas fa-file-invoice",
        "fas fa-file-invoice-dollar",
        "fas fa-file-medical",
        "fas fa-file-medical-alt",
        "fas fa-file-pdf",
        "fas fa-file-powerpoint",
        "fas fa-file-prescription",
        "fas fa-file-signature",
        "fas fa-file-upload",
        "fas fa-file-video",
        "fas fa-file-word",
        "fas fa-fill",
        "fas fa-fill-drip",
        "fas fa-film",
        "fas fa-filter",
        "fas fa-fingerprint",
        "fas fa-fire",
        "fas fa-fire-alt",
        "fas fa-fire-extinguisher",
        "fas fa-first-aid",
        "fas fa-fish",
        "fas fa-fist-raised",
        "fas fa-flag",
        "fas fa-flag-checkered",
        "fas fa-flag-usa",
        "fas fa-flask",
        "fas fa-flushed",
        "fas fa-folder",
        "fas fa-folder-minus",
        "fas fa-folder-open",
        "fas fa-folder-plus",
        "fas fa-font",
        "fas fa-football-ball",
        "fas fa-forward",
        "fas fa-frog",
        "fas fa-frown",
        "fas fa-frown-open",
        "fas fa-funnel-dollar",
        "fas fa-futbol",
        "fas fa-gamepad",
        "fas fa-gas-pump",
        "fas fa-gavel",
        "fas fa-gem",
        "fas fa-genderless",
        "fas fa-ghost",
        "fas fa-gift",
        "fas fa-gifts",
        "fas fa-glass-cheers",
        "fas fa-glass-martini",
        "fas fa-glass-martini-alt",
        "fas fa-glass-whiskey",
        "fas fa-glasses",
        "fas fa-globe",
        "fas fa-globe-africa",
        "fas fa-globe-americas",
        "fas fa-globe-asia",
        "fas fa-globe-europe",
        "fas fa-golf-ball",
        "fas fa-gopuram",
        "fas fa-graduation-cap",
        "fas fa-greater-than",
        "fas fa-greater-than-equal",
        "fas fa-grimace",
        "fas fa-grin",
        "fas fa-grin-alt",
        "fas fa-grin-beam",
        "fas fa-grin-beam-sweat",
        "fas fa-grin-hearts",
        "fas fa-grin-squint",
        "fas fa-grin-squint-tears",
        "fas fa-grin-stars",
        "fas fa-grin-tears",
        "fas fa-grin-tongue",
        "fas fa-grin-tongue-squint",
        "fas fa-grin-tongue-wink",
        "fas fa-grin-wink",
        "fas fa-grip-horizontal",
        "fas fa-grip-lines",
        "fas fa-grip-lines-vertical",
        "fas fa-grip-vertical",
        "fas fa-guitar",
        "fas fa-h-square",
        "fas fa-hamburger",
        "fas fa-hammer",
        "fas fa-hamsa",
        "fas fa-hand-holding",
        "fas fa-hand-holding-heart",
        "fas fa-hand-holding-usd",
        "fas fa-hand-lizard",
        "fas fa-hand-middle-finger",
        "fas fa-hand-paper",
        "fas fa-hand-peace",
        "fas fa-hand-point-down",
        "fas fa-hand-point-left",
        "fas fa-hand-point-right",
        "fas fa-hand-point-up",
        "fas fa-hand-pointer",
        "fas fa-hand-rock",
        "fas fa-hand-scissors",
        "fas fa-hand-spock",
        "fas fa-hands",
        "fas fa-hands-helping",
        "fas fa-handshake",
        "fas fa-hanukiah",
        "fas fa-hard-hat",
        "fas fa-hashtag",
        "fas fa-hat-cowboy",
        "fas fa-hat-cowboy-side",
        "fas fa-hat-wizard",
        "fas fa-hdd",
        "fas fa-heading",
        "fas fa-headphones",
        "fas fa-headphones-alt",
        "fas fa-headset",
        "fas fa-heart",
        "fas fa-heart-broken",
        "fas fa-heartbeat",
        "fas fa-helicopter",
        "fas fa-highlighter",
        "fas fa-hiking",
        "fas fa-hippo",
        "fas fa-history",
        "fas fa-hockey-puck",
        "fas fa-holly-berry",
        "fas fa-home",
        "fas fa-horse",
        "fas fa-horse-head",
        "fas fa-hospital",
        "fas fa-hospital-alt",
        "fas fa-hospital-symbol",
        "fas fa-hot-tub",
        "fas fa-hotdog",
        "fas fa-hotel",
        "fas fa-hourglass",
        "fas fa-hourglass-end",
        "fas fa-hourglass-half",
        "fas fa-hourglass-start",
        "fas fa-house-damage",
        "fas fa-hryvnia",
        "fas fa-i-cursor",
        "fas fa-ice-cream",
        "fas fa-icicles",
        "fas fa-icons",
        "fas fa-id-badge",
        "fas fa-id-card",
        "fas fa-id-card-alt",
        "fas fa-igloo",
        "fas fa-image",
        "fas fa-images",
        "fas fa-inbox",
        "fas fa-indent",
        "fas fa-industry",
        "fas fa-infinity",
        "fas fa-info",
        "fas fa-info-circle",
        "fas fa-italic",
        "fas fa-jedi",
        "fas fa-joint",
        "fas fa-journal-whills",
        "fas fa-kaaba",
        "fas fa-key",
        "fas fa-keyboard",
        "fas fa-khanda",
        "fas fa-kiss",
        "fas fa-kiss-beam",
        "fas fa-kiss-wink-heart",
        "fas fa-kiwi-bird",
        "fas fa-landmark",
        "fas fa-language",
        "fas fa-laptop",
        "fas fa-laptop-code",
        "fas fa-laptop-medical",
        "fas fa-laugh",
        "fas fa-laugh-beam",
        "fas fa-laugh-squint",
        "fas fa-laugh-wink",
        "fas fa-layer-group",
        "fas fa-leaf",
        "fas fa-lemon",
        "fas fa-less-than",
        "fas fa-less-than-equal",
        "fas fa-level-down-alt",
        "fas fa-level-up-alt",
        "fas fa-life-ring",
        "fas fa-lightbulb",
        "fas fa-link",
        "fas fa-lira-sign",
        "fas fa-list",
        "fas fa-list-alt",
        "fas fa-list-ol",
        "fas fa-list-ul",
        "fas fa-location-arrow",
        "fas fa-lock",
        "fas fa-lock-open",
        "fas fa-long-arrow-alt-down",
        "fas fa-long-arrow-alt-left",
        "fas fa-long-arrow-alt-right",
        "fas fa-long-arrow-alt-up",
        "fas fa-low-vision",
        "fas fa-luggage-cart",
        "fas fa-magic",
        "fas fa-magnet",
        "fas fa-mail-bulk",
        "fas fa-male",
        "fas fa-map",
        "fas fa-map-marked",
        "fas fa-map-marked-alt",
        "fas fa-map-marker",
        "fas fa-map-marker-alt",
        "fas fa-map-pin",
        "fas fa-map-signs",
        "fas fa-marker",
        "fas fa-mars",
        "fas fa-mars-double",
        "fas fa-mars-stroke",
        "fas fa-mars-stroke-h",
        "fas fa-mars-stroke-v",
        "fas fa-mask",
        "fas fa-medal",
        "fas fa-medkit",
        "fas fa-meh",
        "fas fa-meh-blank",
        "fas fa-meh-rolling-eyes",
        "fas fa-memory",
        "fas fa-menorah",
        "fas fa-mercury",
        "fas fa-meteor",
        "fas fa-microchip",
        "fas fa-microphone",
        "fas fa-microphone-alt",
        "fas fa-microphone-alt-slash",
        "fas fa-microphone-slash",
        "fas fa-microscope",
        "fas fa-minus",
        "fas fa-minus-circle",
        "fas fa-minus-square",
        "fas fa-mitten",
        "fas fa-mobile",
        "fas fa-mobile-alt",
        "fas fa-money-bill",
        "fas fa-money-bill-alt",
        "fas fa-money-bill-wave",
        "fas fa-money-bill-wave-alt",
        "fas fa-money-check",
        "fas fa-money-check-alt",
        "fas fa-monument",
        "fas fa-moon",
        "fas fa-mortar-pestle",
        "fas fa-mosque",
        "fas fa-motorcycle",
        "fas fa-mountain",
        "fas fa-mouse",
        "fas fa-mouse-pointer",
        "fas fa-mug-hot",
        "fas fa-music",
        "fas fa-network-wired",
        "fas fa-neuter",
        "fas fa-newspaper",
        "fas fa-not-equal",
        "fas fa-notes-medical",
        "fas fa-object-group",
        "fas fa-object-ungroup",
        "fas fa-oil-can",
        "fas fa-om",
        "fas fa-otter",
        "fas fa-outdent",
        "fas fa-pager",
        "fas fa-paint-brush",
        "fas fa-paint-roller",
        "fas fa-palette",
        "fas fa-pallet",
        "fas fa-paper-plane",
        "fas fa-paperclip",
        "fas fa-parachute-box",
        "fas fa-paragraph",
        "fas fa-parking",
        "fas fa-passport",
        "fas fa-pastafarianism",
        "fas fa-paste",
        "fas fa-pause",
        "fas fa-pause-circle",
        "fas fa-paw",
        "fas fa-peace",
        "fas fa-pen",
        "fas fa-pen-alt",
        "fas fa-pen-fancy",
        "fas fa-pen-nib",
        "fas fa-pen-square",
        "fas fa-pencil-alt",
        "fas fa-pencil-ruler",
        "fas fa-people-carry",
        "fas fa-pepper-hot",
        "fas fa-percent",
        "fas fa-percentage",
        "fas fa-person-booth",
        "fas fa-phone",
        "fas fa-phone-alt",
        "fas fa-phone-slash",
        "fas fa-phone-square",
        "fas fa-phone-square-alt",
        "fas fa-phone-volume",
        "fas fa-photo-video",
        "fas fa-piggy-bank",
        "fas fa-pills",
        "fas fa-pizza-slice",
        "fas fa-place-of-worship",
        "fas fa-plane",
        "fas fa-plane-arrival",
        "fas fa-plane-departure",
        "fas fa-play",
        "fas fa-play-circle",
        "fas fa-plug",
        "fas fa-plus",
        "fas fa-plus-circle",
        "fas fa-plus-square",
        "fas fa-podcast",
        "fas fa-poll",
        "fas fa-poll-h",
        "fas fa-poo",
        "fas fa-poo-storm",
        "fas fa-poop",
        "fas fa-portrait",
        "fas fa-pound-sign",
        "fas fa-power-off",
        "fas fa-pray",
        "fas fa-praying-hands",
        "fas fa-prescription",
        "fas fa-prescription-bottle",
        "fas fa-prescription-bottle-alt",
        "fas fa-print",
        "fas fa-procedures",
        "fas fa-project-diagram",
        "fas fa-puzzle-piece",
        "fas fa-qrcode",
        "fas fa-question",
        "fas fa-question-circle",
        "fas fa-quidditch",
        "fas fa-quote-left",
        "fas fa-quote-right",
        "fas fa-quran",
        "fas fa-radiation",
        "fas fa-radiation-alt",
        "fas fa-rainbow",
        "fas fa-random",
        "fas fa-receipt",
        "fas fa-record-vinyl",
        "fas fa-recycle",
        "fas fa-redo",
        "fas fa-redo-alt",
        "fas fa-registered",
        "fas fa-remove-format",
        "fas fa-reply",
        "fas fa-reply-all",
        "fas fa-republican",
        "fas fa-restroom",
        "fas fa-retweet",
        "fas fa-ribbon",
        "fas fa-ring",
        "fas fa-road",
        "fas fa-robot",
        "fas fa-rocket",
        "fas fa-route",
        "fas fa-rss",
        "fas fa-rss-square",
        "fas fa-ruble-sign",
        "fas fa-ruler",
        "fas fa-ruler-combined",
        "fas fa-ruler-horizontal",
        "fas fa-ruler-vertical",
        "fas fa-running",
        "fas fa-rupee-sign",
        "fas fa-sad-cry",
        "fas fa-sad-tear",
        "fas fa-satellite",
        "fas fa-satellite-dish",
        "fas fa-save",
        "fas fa-school",
        "fas fa-screwdriver",
        "fas fa-scroll",
        "fas fa-sd-card",
        "fas fa-search",
        "fas fa-search-dollar",
        "fas fa-search-location",
        "fas fa-search-minus",
        "fas fa-search-plus",
        "fas fa-seedling",
        "fas fa-server",
        "fas fa-shapes",
        "fas fa-share",
        "fas fa-share-alt",
        "fas fa-share-alt-square",
        "fas fa-share-square",
        "fas fa-shekel-sign",
        "fas fa-shield-alt",
        "fas fa-ship",
        "fas fa-shipping-fast",
        "fas fa-shoe-prints",
        "fas fa-shopping-bag",
        "fas fa-shopping-basket",
        "fas fa-shopping-cart",
        "fas fa-shower",
        "fas fa-shuttle-van",
        "fas fa-sign",
        "fas fa-sign-in-alt",
        "fas fa-sign-language",
        "fas fa-sign-out-alt",
        "fas fa-signal",
        "fas fa-signature",
        "fas fa-sim-card",
        "fas fa-sitemap",
        "fas fa-skating",
        "fas fa-skiing",
        "fas fa-skiing-nordic",
        "fas fa-skull",
        "fas fa-skull-crossbones",
        "fas fa-slash",
        "fas fa-sleigh",
        "fas fa-sliders-h",
        "fas fa-smile",
        "fas fa-smile-beam",
        "fas fa-smile-wink",
        "fas fa-smog",
        "fas fa-smoking",
        "fas fa-smoking-ban",
        "fas fa-sms",
        "fas fa-snowboarding",
        "fas fa-snowflake",
        "fas fa-snowman",
        "fas fa-snowplow",
        "fas fa-socks",
        "fas fa-solar-panel",
        "fas fa-sort",
        "fas fa-sort-alpha-down",
        "fas fa-sort-alpha-down-alt",
        "fas fa-sort-alpha-up",
        "fas fa-sort-alpha-up-alt",
        "fas fa-sort-amount-down",
        "fas fa-sort-amount-down-alt",
        "fas fa-sort-amount-up",
        "fas fa-sort-amount-up-alt",
        "fas fa-sort-down",
        "fas fa-sort-numeric-down",
        "fas fa-sort-numeric-down-alt",
        "fas fa-sort-numeric-up",
        "fas fa-sort-numeric-up-alt",
        "fas fa-sort-up",
        "fas fa-spa",
        "fas fa-space-shuttle",
        "fas fa-spell-check",
        "fas fa-spider",
        "fas fa-spinner",
        "fas fa-splotch",
        "fas fa-spray-can",
        "fas fa-square",
        "fas fa-square-full",
        "fas fa-square-root-alt",
        "fas fa-stamp",
        "fas fa-star",
        "fas fa-star-and-crescent",
        "fas fa-star-half",
        "fas fa-star-half-alt",
        "fas fa-star-of-david",
        "fas fa-star-of-life",
        "fas fa-step-backward",
        "fas fa-step-forward",
        "fas fa-stethoscope",
        "fas fa-sticky-note",
        "fas fa-stop",
        "fas fa-stop-circle",
        "fas fa-stopwatch",
        "fas fa-store",
        "fas fa-store-alt",
        "fas fa-stream",
        "fas fa-street-view",
        "fas fa-strikethrough",
        "fas fa-stroopwafel",
        "fas fa-subscript",
        "fas fa-subway",
        "fas fa-suitcase",
        "fas fa-suitcase-rolling",
        "fas fa-sun",
        "fas fa-superscript",
        "fas fa-surprise",
        "fas fa-swatchbook",
        "fas fa-swimmer",
        "fas fa-swimming-pool",
        "fas fa-synagogue",
        "fas fa-sync",
        "fas fa-sync-alt",
        "fas fa-syringe",
        "fas fa-table",
        "fas fa-table-tennis",
        "fas fa-tablet",
        "fas fa-tablet-alt",
        "fas fa-tablets",
        "fas fa-tachometer-alt",
        "fas fa-tag",
        "fas fa-tags",
        "fas fa-tape",
        "fas fa-tasks",
        "fas fa-taxi",
        "fas fa-teeth",
        "fas fa-teeth-open",
        "fas fa-temperature-high",
        "fas fa-temperature-low",
        "fas fa-tenge",
        "fas fa-terminal",
        "fas fa-text-height",
        "fas fa-text-width",
        "fas fa-th",
        "fas fa-th-large",
        "fas fa-th-list",
        "fas fa-theater-masks",
        "fas fa-thermometer",
        "fas fa-thermometer-empty",
        "fas fa-thermometer-full",
        "fas fa-thermometer-half",
        "fas fa-thermometer-quarter",
        "fas fa-thermometer-three-quarters",
        "fas fa-thumbs-down",
        "fas fa-thumbs-up",
        "fas fa-thumbtack",
        "fas fa-ticket-alt",
        "fas fa-times",
        "fas fa-times-circle",
        "fas fa-tint",
        "fas fa-tint-slash",
        "fas fa-tired",
        "fas fa-toggle-off",
        "fas fa-toggle-on",
        "fas fa-toilet",
        "fas fa-toilet-paper",
        "fas fa-toolbox",
        "fas fa-tools",
        "fas fa-tooth",
        "fas fa-torah",
        "fas fa-torii-gate",
        "fas fa-tractor",
        "fas fa-trademark",
        "fas fa-traffic-light",
        "fas fa-trailer",
        "fas fa-train",
        "fas fa-tram",
        "fas fa-transgender",
        "fas fa-transgender-alt",
        "fas fa-trash",
        "fas fa-trash-alt",
        "fas fa-trash-restore",
        "fas fa-trash-restore-alt",
        "fas fa-tree",
        "fas fa-trophy",
        "fas fa-truck",
        "fas fa-truck-loading",
        "fas fa-truck-monster",
        "fas fa-truck-moving",
        "fas fa-truck-pickup",
        "fas fa-tshirt",
        "fas fa-tty",
        "fas fa-tv",
        "fas fa-umbrella",
        "fas fa-umbrella-beach",
        "fas fa-underline",
        "fas fa-undo",
        "fas fa-undo-alt",
        "fas fa-universal-access",
        "fas fa-university",
        "fas fa-unlink",
        "fas fa-unlock",
        "fas fa-unlock-alt",
        "fas fa-upload",
        "fas fa-user",
        "fas fa-user-alt",
        "fas fa-user-alt-slash",
        "fas fa-user-astronaut",
        "fas fa-user-check",
        "fas fa-user-circle",
        "fas fa-user-clock",
        "fas fa-user-cog",
        "fas fa-user-edit",
        "fas fa-user-friends",
        "fas fa-user-graduate",
        "fas fa-user-injured",
        "fas fa-user-lock",
        "fas fa-user-md",
        "fas fa-user-minus",
        "fas fa-user-ninja",
        "fas fa-user-nurse",
        "fas fa-user-plus",
        "fas fa-user-secret",
        "fas fa-user-shield",
        "fas fa-user-slash",
        "fas fa-user-tag",
        "fas fa-user-tie",
        "fas fa-user-times",
        "fas fa-users",
        "fas fa-users-cog",
        "fas fa-utensil-spoon",
        "fas fa-utensils",
        "fas fa-vector-square",
        "fas fa-venus",
        "fas fa-venus-double",
        "fas fa-venus-mars",
        "fas fa-vial",
        "fas fa-vials",
        "fas fa-video",
        "fas fa-video-slash",
        "fas fa-vihara",
        "fas fa-voicemail",
        "fas fa-volleyball-ball",
        "fas fa-volume-down",
        "fas fa-volume-mute",
        "fas fa-volume-off",
        "fas fa-volume-up",
        "fas fa-vote-yea",
        "fas fa-vr-cardboard",
        "fas fa-walking",
        "fas fa-wallet",
        "fas fa-warehouse",
        "fas fa-water",
        "fas fa-wave-square",
        "fas fa-weight",
        "fas fa-weight-hanging",
        "fas fa-wheelchair",
        "fas fa-wifi",
        "fas fa-wind",
        "fas fa-window-close",
        "fas fa-window-maximize",
        "fas fa-window-minimize",
        "fas fa-window-restore",
        "fas fa-wine-bottle",
        "fas fa-wine-glass",
        "fas fa-wine-glass-alt",
        "fas fa-won-sign",
        "fas fa-wrench",
        "fas fa-x-ray",
        "fas fa-yen-sign",
        "fas fa-yin-yang",
        "far fa-address-book",
        "far fa-address-card",
        "far fa-angry",
        "far fa-arrow-alt-circle-down",
        "far fa-arrow-alt-circle-left",
        "far fa-arrow-alt-circle-right",
        "far fa-arrow-alt-circle-up",
        "far fa-bell",
        "far fa-bell-slash",
        "far fa-bookmark",
        "far fa-building",
        "far fa-calendar",
        "far fa-calendar-alt",
        "far fa-calendar-check",
        "far fa-calendar-minus",
        "far fa-calendar-plus",
        "far fa-calendar-times",
        "far fa-caret-square-down",
        "far fa-caret-square-left",
        "far fa-caret-square-right",
        "far fa-caret-square-up",
        "far fa-chart-bar",
        "far fa-check-circle",
        "far fa-check-square",
        "far fa-circle",
        "far fa-clipboard",
        "far fa-clock",
        "far fa-clone",
        "far fa-closed-captioning",
        "far fa-comment",
        "far fa-comment-alt",
        "far fa-comment-dots",
        "far fa-comments",
        "far fa-compass",
        "far fa-copy",
        "far fa-copyright",
        "far fa-credit-card",
        "far fa-dizzy",
        "far fa-dot-circle",
        "far fa-edit",
        "far fa-envelope",
        "far fa-envelope-open",
        "far fa-eye",
        "far fa-eye-slash",
        "far fa-file",
        "far fa-file-alt",
        "far fa-file-archive",
        "far fa-file-audio",
        "far fa-file-code",
        "far fa-file-excel",
        "far fa-file-image",
        "far fa-file-pdf",
        "far fa-file-powerpoint",
        "far fa-file-video",
        "far fa-file-word",
        "far fa-flag",
        "far fa-flushed",
        "far fa-folder",
        "far fa-folder-open",
        "far fa-frown",
        "far fa-frown-open",
        "far fa-futbol",
        "far fa-gem",
        "far fa-grimace",
        "far fa-grin",
        "far fa-grin-alt",
        "far fa-grin-beam",
        "far fa-grin-beam-sweat",
        "far fa-grin-hearts",
        "far fa-grin-squint",
        "far fa-grin-squint-tears",
        "far fa-grin-stars",
        "far fa-grin-tears",
        "far fa-grin-tongue",
        "far fa-grin-tongue-squint",
        "far fa-grin-tongue-wink",
        "far fa-grin-wink",
        "far fa-hand-lizard",
        "far fa-hand-paper",
        "far fa-hand-peace",
        "far fa-hand-point-down",
        "far fa-hand-point-left",
        "far fa-hand-point-right",
        "far fa-hand-point-up",
        "far fa-hand-pointer",
        "far fa-hand-rock",
        "far fa-hand-scissors",
        "far fa-hand-spock",
        "far fa-handshake",
        "far fa-hdd",
        "far fa-heart",
        "far fa-hospital",
        "far fa-hourglass",
        "far fa-id-badge",
        "far fa-id-card",
        "far fa-image",
        "far fa-images",
        "far fa-keyboard",
        "far fa-kiss",
        "far fa-kiss-beam",
        "far fa-kiss-wink-heart",
        "far fa-laugh",
        "far fa-laugh-beam",
        "far fa-laugh-squint",
        "far fa-laugh-wink",
        "far fa-lemon",
        "far fa-life-ring",
        "far fa-lightbulb",
        "far fa-list-alt",
        "far fa-map",
        "far fa-meh",
        "far fa-meh-blank",
        "far fa-meh-rolling-eyes",
        "far fa-minus-square",
        "far fa-money-bill-alt",
        "far fa-moon",
        "far fa-newspaper",
        "far fa-object-group",
        "far fa-object-ungroup",
        "far fa-paper-plane",
        "far fa-pause-circle",
        "far fa-play-circle",
        "far fa-plus-square",
        "far fa-question-circle",
        "far fa-registered",
        "far fa-sad-cry",
        "far fa-sad-tear",
        "far fa-save",
        "far fa-share-square",
        "far fa-smile",
        "far fa-smile-beam",
        "far fa-smile-wink",
        "far fa-snowflake",
        "far fa-square",
        "far fa-star",
        "far fa-star-half",
        "far fa-sticky-note",
        "far fa-stop-circle",
        "far fa-sun",
        "far fa-surprise",
        "far fa-thumbs-down",
        "far fa-thumbs-up",
        "far fa-times-circle",
        "far fa-tired",
        "far fa-trash-alt",
        "far fa-user",
        "far fa-user-circle",
        "far fa-window-close",
        "far fa-window-maximize",
        "far fa-window-minimize",
        "far fa-window-restore",
        "fab fa-500px",
        "fab fa-accessible-icon",
        "fab fa-accusoft",
        "fab fa-acquisitions-incorporated",
        "fab fa-adn",
        "fab fa-adobe",
        "fab fa-adversal",
        "fab fa-affiliatetheme",
        "fab fa-airbnb",
        "fab fa-algolia",
        "fab fa-alipay",
        "fab fa-amazon",
        "fab fa-amazon-pay",
        "fab fa-amilia",
        "fab fa-android",
        "fab fa-angellist",
        "fab fa-angrycreative",
        "fab fa-angular",
        "fab fa-app-store",
        "fab fa-app-store-ios",
        "fab fa-apper",
        "fab fa-apple",
        "fab fa-apple-pay",
        "fab fa-artstation",
        "fab fa-asymmetrik",
        "fab fa-atlassian",
        "fab fa-audible",
        "fab fa-autoprefixer",
        "fab fa-avianex",
        "fab fa-aviato",
        "fab fa-aws",
        "fab fa-bandcamp",
        "fab fa-battle-net",
        "fab fa-behance",
        "fab fa-behance-square",
        "fab fa-bimobject",
        "fab fa-bitbucket",
        "fab fa-bitcoin",
        "fab fa-bity",
        "fab fa-black-tie",
        "fab fa-blackberry",
        "fab fa-blogger",
        "fab fa-blogger-b",
        "fab fa-bluetooth",
        "fab fa-bluetooth-b",
        "fab fa-bootstrap",
        "fab fa-btc",
        "fab fa-buffer",
        "fab fa-buromobelexperte",
        "fab fa-buy-n-large",
        "fab fa-buysellads",
        "fab fa-canadian-maple-leaf",
        "fab fa-cc-amazon-pay",
        "fab fa-cc-amex",
        "fab fa-cc-apple-pay",
        "fab fa-cc-diners-club",
        "fab fa-cc-discover",
        "fab fa-cc-jcb",
        "fab fa-cc-mastercard",
        "fab fa-cc-paypal",
        "fab fa-cc-stripe",
        "fab fa-cc-visa",
        "fab fa-centercode",
        "fab fa-centos",
        "fab fa-chrome",
        "fab fa-chromecast",
        "fab fa-cloudscale",
        "fab fa-cloudsmith",
        "fab fa-cloudversify",
        "fab fa-codepen",
        "fab fa-codiepie",
        "fab fa-confluence",
        "fab fa-connectdevelop",
        "fab fa-contao",
        "fab fa-cotton-bureau",
        "fab fa-cpanel",
        "fab fa-creative-commons",
        "fab fa-creative-commons-by",
        "fab fa-creative-commons-nc",
        "fab fa-creative-commons-nc-eu",
        "fab fa-creative-commons-nc-jp",
        "fab fa-creative-commons-nd",
        "fab fa-creative-commons-pd",
        "fab fa-creative-commons-pd-alt",
        "fab fa-creative-commons-remix",
        "fab fa-creative-commons-sa",
        "fab fa-creative-commons-sampling",
        "fab fa-creative-commons-sampling-plus",
        "fab fa-creative-commons-share",
        "fab fa-creative-commons-zero",
        "fab fa-critical-role",
        "fab fa-css3",
        "fab fa-css3-alt",
        "fab fa-cuttlefish",
        "fab fa-d-and-d",
        "fab fa-d-and-d-beyond",
        "fab fa-dailymotion",
        "fab fa-dashcube",
        "fab fa-delicious",
        "fab fa-deploydog",
        "fab fa-deskpro",
        "fab fa-dev",
        "fab fa-deviantart",
        "fab fa-dhl",
        "fab fa-diaspora",
        "fab fa-digg",
        "fab fa-digital-ocean",
        "fab fa-discord",
        "fab fa-discourse",
        "fab fa-dochub",
        "fab fa-docker",
        "fab fa-draft2digital",
        "fab fa-dribbble",
        "fab fa-dribbble-square",
        "fab fa-dropbox",
        "fab fa-drupal",
        "fab fa-dyalog",
        "fab fa-earlybirds",
        "fab fa-ebay",
        "fab fa-edge",
        "fab fa-elementor",
        "fab fa-ello",
        "fab fa-ember",
        "fab fa-empire",
        "fab fa-envira",
        "fab fa-erlang",
        "fab fa-ethereum",
        "fab fa-etsy",
        "fab fa-evernote",
        "fab fa-expeditedssl",
        "fab fa-facebook",
        "fab fa-facebook-f",
        "fab fa-facebook-messenger",
        "fab fa-facebook-square",
        "fab fa-fantasy-flight-games",
        "fab fa-fedex",
        "fab fa-fedora",
        "fab fa-figma",
        "fab fa-firefox",
        "fab fa-firefox-browser",
        "fab fa-first-order",
        "fab fa-first-order-alt",
        "fab fa-firstdraft",
        "fab fa-flickr",
        "fab fa-flipboard",
        "fab fa-fly",
        "fab fa-font-awesome",
        "fab fa-font-awesome-alt",
        "fab fa-font-awesome-flag",
        "fab fa-fonticons",
        "fab fa-fonticons-fi",
        "fab fa-fort-awesome",
        "fab fa-fort-awesome-alt",
        "fab fa-forumbee",
        "fab fa-foursquare",
        "fab fa-free-code-camp",
        "fab fa-freebsd",
        "fab fa-fulcrum",
        "fab fa-galactic-republic",
        "fab fa-galactic-senate",
        "fab fa-get-pocket",
        "fab fa-gg",
        "fab fa-gg-circle",
        "fab fa-git",
        "fab fa-git-alt",
        "fab fa-git-square",
        "fab fa-github",
        "fab fa-github-alt",
        "fab fa-github-square",
        "fab fa-gitkraken",
        "fab fa-gitlab",
        "fab fa-gitter",
        "fab fa-glide",
        "fab fa-glide-g",
        "fab fa-gofore",
        "fab fa-goodreads",
        "fab fa-goodreads-g",
        "fab fa-google",
        "fab fa-google-drive",
        "fab fa-google-play",
        "fab fa-google-plus",
        "fab fa-google-plus-g",
        "fab fa-google-plus-square",
        "fab fa-google-wallet",
        "fab fa-gratipay",
        "fab fa-grav",
        "fab fa-gripfire",
        "fab fa-grunt",
        "fab fa-gulp",
        "fab fa-hacker-news",
        "fab fa-hacker-news-square",
        "fab fa-hackerrank",
        "fab fa-hips",
        "fab fa-hire-a-helper",
        "fab fa-hooli",
        "fab fa-hornbill",
        "fab fa-hotjar",
        "fab fa-houzz",
        "fab fa-html5",
        "fab fa-hubspot",
        "fab fa-ideal",
        "fab fa-imdb",
        "fab fa-instagram",
        "fab fa-instagram-square",
        "fab fa-intercom",
        "fab fa-internet-explorer",
        "fab fa-invision",
        "fab fa-ioxhost",
        "fab fa-itch-io",
        "fab fa-itunes",
        "fab fa-itunes-note",
        "fab fa-java",
        "fab fa-jedi-order",
        "fab fa-jenkins",
        "fab fa-jira",
        "fab fa-joget",
        "fab fa-joomla",
        "fab fa-js",
        "fab fa-js-square",
        "fab fa-jsfiddle",
        "fab fa-kaggle",
        "fab fa-keybase",
        "fab fa-keycdn",
        "fab fa-kickstarter",
        "fab fa-kickstarter-k",
        "fab fa-korvue",
        "fab fa-laravel",
        "fab fa-lastfm",
        "fab fa-lastfm-square",
        "fab fa-leanpub",
        "fab fa-less",
        "fab fa-line",
        "fab fa-linkedin",
        "fab fa-linkedin-in",
        "fab fa-linode",
        "fab fa-linux",
        "fab fa-lyft",
        "fab fa-magento",
        "fab fa-mailchimp",
        "fab fa-mandalorian",
        "fab fa-markdown",
        "fab fa-mastodon",
        "fab fa-maxcdn",
        "fab fa-mdb",
        "fab fa-medapps",
        "fab fa-medium",
        "fab fa-medium-m",
        "fab fa-medrt",
        "fab fa-meetup",
        "fab fa-megaport",
        "fab fa-mendeley",
        "fab fa-microblog",
        "fab fa-microsoft",
        "fab fa-mix",
        "fab fa-mixcloud",
        "fab fa-mixer",
        "fab fa-mizuni",
        "fab fa-modx",
        "fab fa-monero",
        "fab fa-napster",
        "fab fa-neos",
        "fab fa-nimblr",
        "fab fa-node",
        "fab fa-node-js",
        "fab fa-npm",
        "fab fa-ns8",
        "fab fa-nutritionix",
        "fab fa-odnoklassniki",
        "fab fa-odnoklassniki-square",
        "fab fa-old-republic",
        "fab fa-opencart",
        "fab fa-openid",
        "fab fa-opera",
        "fab fa-optin-monster",
        "fab fa-orcid",
        "fab fa-osi",
        "fab fa-page4",
        "fab fa-pagelines",
        "fab fa-palfed",
        "fab fa-patreon",
        "fab fa-paypal",
        "fab fa-penny-arcade",
        "fab fa-periscope",
        "fab fa-phabricator",
        "fab fa-phoenix-framework",
        "fab fa-phoenix-squadron",
        "fab fa-php",
        "fab fa-pied-piper",
        "fab fa-pied-piper-alt",
        "fab fa-pied-piper-hat",
        "fab fa-pied-piper-pp",
        "fab fa-pied-piper-square",
        "fab fa-pinterest",
        "fab fa-pinterest-p",
        "fab fa-pinterest-square",
        "fab fa-playstation",
        "fab fa-product-hunt",
        "fab fa-pushed",
        "fab fa-python",
        "fab fa-qq",
        "fab fa-quinscape",
        "fab fa-quora",
        "fab fa-r-project",
        "fab fa-raspberry-pi",
        "fab fa-ravelry",
        "fab fa-react",
        "fab fa-reacteurope",
        "fab fa-readme",
        "fab fa-rebel",
        "fab fa-red-river",
        "fab fa-reddit",
        "fab fa-reddit-alien",
        "fab fa-reddit-square",
        "fab fa-redhat",
        "fab fa-renren",
        "fab fa-replyd",
        "fab fa-researchgate",
        "fab fa-resolving",
        "fab fa-rev",
        "fab fa-rocketchat",
        "fab fa-rockrms",
        "fab fa-safari",
        "fab fa-salesforce",
        "fab fa-sass",
        "fab fa-schlix",
        "fab fa-scribd",
        "fab fa-searchengin",
        "fab fa-sellcast",
        "fab fa-sellsy",
        "fab fa-servicestack",
        "fab fa-shirtsinbulk",
        "fab fa-shopify",
        "fab fa-shopware",
        "fab fa-simplybuilt",
        "fab fa-sistrix",
        "fab fa-sith",
        "fab fa-sketch",
        "fab fa-skyatlas",
        "fab fa-skype",
        "fab fa-slack",
        "fab fa-slack-hash",
        "fab fa-slideshare",
        "fab fa-snapchat",
        "fab fa-snapchat-ghost",
        "fab fa-snapchat-square",
        "fab fa-soundcloud",
        "fab fa-sourcetree",
        "fab fa-speakap",
        "fab fa-speaker-deck",
        "fab fa-spotify",
        "fab fa-squarespace",
        "fab fa-stack-exchange",
        "fab fa-stack-overflow",
        "fab fa-stackpath",
        "fab fa-staylinked",
        "fab fa-steam",
        "fab fa-steam-square",
        "fab fa-steam-symbol",
        "fab fa-sticker-mule",
        "fab fa-strava",
        "fab fa-stripe",
        "fab fa-stripe-s",
        "fab fa-studiovinari",
        "fab fa-stumbleupon",
        "fab fa-stumbleupon-circle",
        "fab fa-superpowers",
        "fab fa-supple",
        "fab fa-suse",
        "fab fa-swift",
        "fab fa-symfony",
        "fab fa-teamspeak",
        "fab fa-telegram",
        "fab fa-telegram-plane",
        "fab fa-tencent-weibo",
        "fab fa-the-red-yeti",
        "fab fa-themeco",
        "fab fa-themeisle",
        "fab fa-think-peaks",
        "fab fa-trade-federation",
        "fab fa-trello",
        "fab fa-tripadvisor",
        "fab fa-tumblr",
        "fab fa-tumblr-square",
        "fab fa-twitch",
        "fab fa-twitter",
        "fab fa-twitter-square",
        "fab fa-typo3",
        "fab fa-uber",
        "fab fa-ubuntu",
        "fab fa-uikit",
        "fab fa-umbraco",
        "fab fa-uniregistry",
        "fab fa-unity",
        "fab fa-untappd",
        "fab fa-ups",
        "fab fa-usb",
        "fab fa-usps",
        "fab fa-ussunnah",
        "fab fa-vaadin",
        "fab fa-viacoin",
        "fab fa-viadeo",
        "fab fa-viadeo-square",
        "fab fa-viber",
        "fab fa-vimeo",
        "fab fa-vimeo-square",
        "fab fa-vimeo-v",
        "fab fa-vine",
        "fab fa-vk",
        "fab fa-vnv",
        "fab fa-vuejs",
        "fab fa-waze",
        "fab fa-weebly",
        "fab fa-weibo",
        "fab fa-weixin",
        "fab fa-whatsapp",
        "fab fa-whatsapp-square",
        "fab fa-whmcs",
        "fab fa-wikipedia-w",
        "fab fa-windows",
        "fab fa-wix",
        "fab fa-wizards-of-the-coast",
        "fab fa-wolf-pack-battalion",
        "fab fa-wordpress",
        "fab fa-wordpress-simple",
        "fab fa-wpbeginner",
        "fab fa-wpexplorer",
        "fab fa-wpforms",
        "fab fa-wpressr",
        "fab fa-xbox",
        "fab fa-xing",
        "fab fa-xing-square",
        "fab fa-y-combinator",
        "fab fa-yahoo",
        "fab fa-yammer",
        "fab fa-yandex",
        "fab fa-yandex-international",
        "fab fa-yarn",
        "fab fa-yelp",
        "fab fa-yoast",
        "fab fa-youtube",
        "fab fa-youtube-square",
        "fab fa-zhihu"
    ];
    return $icons;
}

function getYoutubeId($url)
{
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    return $match[1];
}

function getVimeoId($url)
{
    preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $match);
    return $match[1];
}



function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }
    // if ($ipaddress == '::1') {
    // if (getenv('CI_ENVIRONMENT') == 'development') {
    $customIp = getSiteSettingsByName('custom_ip_address');
    if ($customIp && $customIp['enable']) {
        // $ips = json_decode($customIp['value'], true);
        // foreach ($ips as $ip) {
        // if ($ip['enabled']) {
        $ipaddress = $customIp['value'];
        // $ipaddress = $ip['ip'];
        // break;
        // }
        // }
    }

    return $ipaddress;
}
function getUserCountry()
{
    $PublicIP = get_client_ip();
    $url = "http://ipinfo.io/" . $PublicIP . "/geo";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $curlResponse = curl_exec($ch);
    curl_close($ch);
    // $response = json_decode($response);

    $json     = json_decode($curlResponse, true);
    // return $json;
    $country = 'IN';
    if (isset($json['country'])) {
        $country = $json['country'];
    }
    return $country;
    // $region   = $json['region'];
    // $city     = $json['city'];
}
function getCurrencySymbol()
{
    $country = getUserCountry();
    $currency_symbol = '&#8377;';
    if ($country == 'IN') {
        $currency_symbol = '&#8377;';
    } else {
        $currency_symbol = '&#8364;';
    }
    return $currency_symbol;
}

function deadlineClass($deadline, $current)
{
    $classToShow = '';
    if ($deadline > $current && $deadline != $current) {
        $classToShow = 'is-upcoming';
    }
    if ($deadline < $current && $deadline != $current) {
        $classToShow = 'is-outdated';
    }
    if ($deadline == $current) {
        $classToShow = 'is-current';
    }
    return $classToShow;
}


function isEmbeddableYoutubeURL($url)
{

    // Let's check the host first
    $parse = parse_url($url);
    $host = $parse['host'];
    if (!in_array($host, array('youtube.com', 'www.youtube.com'))) {
        return false;
    }

    $ch = curl_init();
    $oembedURL = 'www.youtube.com/oembed?url=' . urlencode($url) . '&format=json';
    curl_setopt($ch, CURLOPT_URL, $oembedURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($output);

    if (!$data) return false; // Either 404 or 401 (Unauthorized)
    if (!$data->{'html'}) return false; // Embeddable video MUST have 'html' provided 

    return true;
}


function getStars($rate)
{
    $rating = floatval($rate);
    $starFill = '<span class="fa-solid fa-star"></span>';
    $starHalf = '<span class="fa-solid fa-star-half"></span>';
    $starBlank = '<span class="fa-regular fa-star"></span>';

    $stars = [
        $starBlank,
        $starBlank,
        $starBlank,
        $starBlank,
        $starBlank
    ];
    if ($rating == 0.5) {
        $stars[0] = $starHalf;
    }
    if ($rating == 1 || $rating == 1.0) {
        $stars[0] = $starFill;
    }
    if ($rating == 1.5) {
        $stars[0] = $starFill;
        $stars[1] = $starHalf;
    }
    if ($rating == 2 || $rating == 2.0) {
        $stars[0] = $starFill;
        $stars[1] = $starFill;
    }
    if ($rating == 2.5) {
        $stars[0] = $starFill;
        $stars[1] = $starFill;
        $stars[2] = $starHalf;
    }
    if ($rating == 3 || $rating == 3.0) {
        $stars[0] = $starFill;
        $stars[1] = $starFill;
        $stars[2] = $starFill;
    }
    if ($rating == 3.5) {
        $stars[0] = $starFill;
        $stars[1] = $starFill;
        $stars[2] = $starFill;
        $stars[3] = $starHalf;
    }
    if ($rating == 4 || $rating == 4.0) {
        $stars[0] = $starFill;
        $stars[1] = $starFill;
        $stars[2] = $starFill;
        $stars[3] = $starFill;
    }
    if ($rating == 4.5) {
        $stars[0] = $starFill;
        $stars[1] = $starFill;
        $stars[2] = $starFill;
        $stars[3] = $starFill;
        $stars[4] = $starHalf;
    }
    if ($rating == 5 || $rating == 5.0) {
        $stars[0] = $starFill;
        $stars[1] = $starFill;
        $stars[2] = $starFill;
        $stars[3] = $starFill;
        $stars[4] = $starFill;
    }
    return $stars;
}

function uniqidReal($lenght = 13)
{
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $lenght);
}

function getNameofString($string)
{
    $str = str_replace('_', ' ', $string);
    return ucfirst($str);
}

function createSiteSettings($name, $value, $enable = true)
{
    $settingsMd = new SiteSettings();

    $settings = array();
    if ($thisSettings = $settingsMd->where(['name' => $name])->first()) {
        $settings['id'] = $thisSettings['id'];
    } else {
        $settings['name'] = $name;
    }
    $settings['value'] = $value;
    $settings['enable'] = $enable ? 1 : 0;

    if ($settingsMd->save($settings)) {
        return true;
    }
    return false;
}
function getAllSiteSettings()
{
    $settingsMd = new SiteSettings();
    return $settingsMd->findAll();
}
function getSiteSettingsByName($name)
{
    $settingsMd = new SiteSettings();
    return $settingsMd->where(['name' => $name])->first();
}
function getHoursFromMinutes($minutes)
{
    if ($minutes < 60) {
        return '0h ' . $minutes . 'min';
    } else {
        $hours = floor($minutes / 60);
        $mins = $minutes - ($hours * 60);
        return $hours . 'h ' . $mins . 'min';
    }
}

function getFilmInfoSelectData($type)
{
    $filmInfoSelectDb = new FilmInfosData();
    return $filmInfoSelectDb->where('type', $type)->orderBy('id', 'asc')->findAll();
}

function getFilmStatus()
{
    return array([
        'name' => 'Released',
        'info' => 'Released and screened / available to the public (or firm date set in relatively near future)'
    ], [
        'name' => 'Completed (Privately)',
        'info' => 'Completed and only limited non-public screenings (friends / family / fellow students / faculty members)'
    ], [
        'name' => 'Completed',
        'info' => 'Completed but not shown anywhere'
    ]);
}

function isUserLogin()
{
    if (session()->get('userLoggedIn')) {
        return true;
    }
    return false;
}
function getFilmEditAuth($email)
{
    if (isUserLogin()) {
        if (session()->get('user.email') == $email || session()->get('user.role') == ('admin' || 'staff')) {
            return true;
        }
    }
    return false;
}

function isAdmin()
{
    if (session()->get('user.role') == 'admin') {
        return true;
    }
    return false;
}

function getEntryFormHeaderIcon($value)
{
    // // <span uk-icon="icon: <?= $movie['step1'] == 'open' ? 'warning' : ($movie['step1'] == 'completed' ? 'check' : 'lock')
    $icon = '';
    $color = '';
    $title = '';
    if ($value == 'open') {
        $icon = 'warning';
        $color = '#ff9966';
        $title = 'Update Needed!';
    } else {
        if ($value == 'completed') {
            $icon = 'future';
            $color = '#4BB543';
            $title = 'In-Review, Please Wait!';
        } else {
            $icon = 'lock';
            $color = '#0275d8';
            $title = 'Listing locked & published.';
        }
    }
    return '<span uk-icon="icon:' . $icon . ';ratio:0.7;" style="color:' . $color . ';" title="' . $title . '">';
}


function saveLog($type, $task, $content, $status = 0)
{
    $LogsModel = new LogsModel();
    return $LogsModel->createLog($type, $task, $content, $status = 0);
}

function getCurrencies()
{
    $infoDataDB = new FilmInfosData();
    return $infoDataDB->where('type', 'currency')->findAll();
}
function getGenres()
{
    $infoDataDB = new FilmInfosData();
    return $infoDataDB->where('type', 'genres')->findAll();
}
function getCertificates()
{
    $infoDataDB = new FilmInfosData();
    return $infoDataDB->where('type', 'certificates')->findAll();
}
function getProjectTypes()
{
    $projectTypeDb = new FestivalTypeOfFilms();
    return $projectTypeDb->findAll();
}
function ordinal($number)
{
    $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
    if ((($number % 100) >= 11) && (($number % 100) <= 13))
        return $number . 'th';
    else
        return $number . $ends[$number % 10];
}
function getOrdinalHtml($ordinal)
{
    $getArrayOrdinal = explode(' ', $ordinal);
    $array = array('th', 'st', 'nd', 'rd');
    $newOrdinal = $getArrayOrdinal[0];
    foreach ($array as $key => $value) {
        if (strpos($getArrayOrdinal[0], $value) !== false) {
            $newValue = '<sup>' . $value . '</sup>';
            $newOrdinal = str_replace($value, $newValue, $getArrayOrdinal[0]);
        }
    }
    $createOrdinal = '';
    foreach ($getArrayOrdinal as $key => $value) {
        if ($key == 0) {
            $createOrdinal = $createOrdinal . ' ' . $newOrdinal;
        } else {
            $createOrdinal = $createOrdinal . ' ' . $value;
        }
    }
    return $createOrdinal;
}
function removeOrdinalHtml($ordinal)
{
    $ordinal = str_replace('<sup>', '', $ordinal);
    $ordinal = str_replace('</sup>', '', $ordinal);
    return $ordinal;
}


function getFestivalNameSlug($id)
{
    $sessionFestivals = session()->get('festivals_list');

    if ($sessionFestivals) {
        $array_search = array_search($id, array_column($sessionFestivals, 'id'));
        return $sessionFestivals[$array_search];
    } else {
        $festivalDb = new FestivalModel();
        $festivals = $festivalDb->select('id, name, slug')->findAll();
        session()->set('festivals_list', $festivals);

        $array_search = array_search($id, array_column($festivals, 'id'));
        return $festivals[$array_search];
    }
}
function getCountryName($id)
{
    $sessionCountries = getAllCountries();

    $array_search = array_search($id, array_column($sessionCountries, 'id'));
    $country = $sessionCountries[$array_search];
    $countryName = $country ? $country['name'] : 'N/A';

    return $countryName;
}
