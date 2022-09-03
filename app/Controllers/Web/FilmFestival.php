<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\Common\FilmzinetoModule;
use App\Models\Festival\DynamicPagesData;
use App\Models\Festival\FestivalAbout;
use App\Models\Festival\FestivalAwards;
use App\Models\Festival\FestivalAwardsPage;
use App\Models\Festival\FestivalDeadlines;
use App\Models\Festival\FestivalDelegatePackages;
use App\Models\Festival\FestivalGallery;
use App\Models\Festival\FestivalJury;
use App\Models\Festival\FestivalJuryGallery;
use App\Models\Festival\FestivalModel;
use App\Models\Festival\FestivalPress;
use App\Models\Festival\FestivalSchedules;
use App\Models\Festival\FestivalSponsorship;
use App\Models\Festival\FestivalTeam;
use App\Models\Festival\FestivalTypeOfFilms;
use App\Models\Festival\FestivalVenueItem;
use App\Models\Festival\FestivalVenues;
use App\Models\Festival\FestivalVolunteer;

class FilmFestival extends BaseController
{
    protected $data;
    protected $slug;
    protected $festivalModel;
    // protected $festivalYearlyModel;
    protected $festival_details;

    public function __construct()
    {
        $this->data = [];
        $this->data['optionalJs'] = false;
        $this->data['loadSelect2'] = false;

        $this->data['paymentAssets'] = false;
        $this->festivalModel = new FestivalModel();
        $slug = service('uri')->getSegment(2) ? service('uri')->getSegment(2) : 'nothing';
        $this->festival_details = $this->festivalModel->getFestivalBySlugFrontend($slug);

        // $this->festival_details['project_types'] = json_decode($this->festival_details['project_types']);
        // $this->festival_details['award_category_to_show'] = json_decode($this->festival_details['award_category_to_show']);
        // $this->festival_details['awards_to_show'] = json_decode($this->festival_details['awards_to_show']);
        if ($this->festival_details) {
            $this->slug = $slug;
            $this->data['festivalSlug'] = $slug;

            $this->data['pageName'] = $this->festival_details['name'];
            $this->data['pageTitle'] = !empty($this->festival_details['title']) ? $this->festival_details['title'] : $this->festival_details['name'] . ' ' . $this->festival_details['current_year'];

            $festivalDeadlines =  $this->festivalDeadlines($this->festival_details);
            $currentDeadline =  $festivalDeadlines['show'];

            $this->festival_details['deadlines'] = $festivalDeadlines;

            $this->festival_details['short_awards_prices'] = $this->convertFestivalAwardPricesByDeadline($currentDeadline, $this->festival_details['short_awards_prices']);
            $this->festival_details['feature_awards_prices'] = $this->convertFestivalAwardPricesByDeadline($currentDeadline, $this->festival_details['feature_awards_prices']);

            $this->data['festival_logo'] = $this->festival_details['logo'];

            for ($i = 0; $i < intval($this->festival_details['edition']); $i++) {
                $this->data['festival_editions'][] = intval($this->festival_details['current_year']) - $i;
            }

            // $this->data['selectedYear'] = (isset($_POST["current_year"])) ? $_POST["current_year"] : $this->festival_details['current_year'];
            $this->data['selectedYear'] = isset($_POST["selectedYear"]) ? $_POST["selectedYear"] : '';

            $this->data['festival_details'] = $this->festival_details;
        } else {
            header('Location: ' . base_url());
            // header('Location:/film-festival');
            exit();
        }
    }

    public function index()
    {
        // return view('Web/Filmfestival/details', $this->data);
    }
    public function festival_details()
    {
        $this->data['optionalJs'] = true;
        $this->data['pageName'] = $this->festival_details['name'];

        $filmzineSelect = 'filmzinetomodules.news_id, filmzinetomodules.data_id, filmzine.title, filmzine.slug, filmzine.featured, filmzine.media_url, filmzine.media_type, filmzine.video_type, filmzine.topic_id, filmzine.topic_name, filmzine.total_likes, filmzine.total_dislikes, filmzine.movie_rating, filmzine.total_views, filmzine.created_at';
        $filmzineModule = new FilmzinetoModule();
        $filmzineHeadlines = $filmzineModule->distinct()
            ->select($filmzineSelect)
            ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
            ->where('filmzinetomodules.table_name', 'festival')
            ->where('filmzinetomodules.data_id', $this->festival_details['id'])
            ->whereNotIn('filmzine.type_id', [3, 4])
            ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll(3);
        $filmzineTrailers = $filmzineModule->distinct()
        ->select($filmzineSelect)
            ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
            ->where('filmzinetomodules.table_name', 'festival')
            ->where('filmzinetomodules.data_id', $this->festival_details['id'])
            ->where('filmzine.type_id', '4')
            ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll(6);
        $filmzineInterviews = $filmzineModule->distinct()
        ->select($filmzineSelect)
            ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
            ->where('filmzinetomodules.table_name', 'festival')
            ->where('filmzinetomodules.data_id', $this->festival_details['id'])
            ->where('filmzine.type_id', '3')
            ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll(6);

        $this->data['headlines'] = $filmzineHeadlines;
        $this->data['trailers'] = $filmzineTrailers;
        $this->data['interviews'] = $filmzineInterviews;

        // return print_r($this->data);

        return view('Web/Filmfestival/festival_details', $this->data);
    }

    // pages only
    public function festival_about()
    {

        $this->data['pageName'] = $this->festival_details['name'];

        $pageData = new FestivalAbout();

        $page = $pageData->where('festival_id', $this->festival_details['id'])->first();

        $realPageData = [
            'title' => $page && !empty($page['title']) ? $page['title'] : 'Your Page Title',
            'content' => $page && !empty($page['content']) ? $page['content'] : 'Your page description or content.',
            'icon1' => $page && !empty($page['icon1']) ? $page['icon1'] : 'fa-solid fa-heart',
            'icon_title1' => $page && !empty($page['icon_title1']) ? $page['icon_title1'] : 'box title 1',
            'icon_content1' => $page && !empty($page['icon_content1']) ? $page['icon_content1'] : 'box subtitle 1',
            'icon2' => $page && !empty($page['icon2']) ? $page['icon2'] : 'fa-solid fa-heart',
            'icon_title2' => $page && !empty($page['icon_title2']) ? $page['icon_title2'] : 'box title 2',
            'icon_content2' => $page && !empty($page['icon_content2']) ? $page['icon_content2'] : 'box subtitle 2',
            'icon3' => $page && !empty($page['icon3']) ? $page['icon3'] : 'fa-solid fa-heart',
            'icon_title3' => $page && !empty($page['icon_title3']) ? $page['icon_title3'] : 'box title 3',
            'icon_content3' => $page && !empty($page['icon_content3']) ? $page['icon_content3'] : 'box subtitle 3',
            'icon4' => $page && !empty($page['icon4']) ? $page['icon4'] : 'fa-solid fa-heart',
            'icon_title4' => $page && !empty($page['icon_title4']) ? $page['icon_title4'] : 'box title 4',
            'icon_content4' => $page && !empty($page['icon_content4']) ? $page['icon_content4'] : 'box subtitle 4',
        ];

        $this->data['pagedata'] = $realPageData;
        $this->data['pageId'] = $page && $page['id'] ? $page['id'] : 0;
        $this->data['pagedata']['id'] = $page && $page['id'] ? $page['id'] : 0;

        return view('Web/Filmfestival/festival_about_and_sponsor', $this->data);
    }
    public function festival_sponsorship()
    {
        $this->data['pageName'] = 'Sponsorship & Promotion';

        $pageData = new FestivalSponsorship();

        $page = $pageData->where('festival_id', $this->festival_details['id'])->first();

        $realPageData = [
            'title' => $page && !empty($page['title']) ? $page['title'] : 'Your Page Title',
            'content' => $page && !empty($page['content']) ? $page['content'] : 'Your page description or content.',
            'icon1' => $page && !empty($page['icon1']) ? $page['icon1'] : 'fa-solid fa-heart',
            'icon_title1' => $page && !empty($page['icon_title1']) ? $page['icon_title1'] : 'box title 1',
            'icon_content1' => $page && !empty($page['icon_content1']) ? $page['icon_content1'] : 'box subtitle 1',
            'icon2' => $page && !empty($page['icon2']) ? $page['icon2'] : 'fa-solid fa-heart',
            'icon_title2' => $page && !empty($page['icon_title2']) ? $page['icon_title2'] : 'box title 2',
            'icon_content2' => $page && !empty($page['icon_content2']) ? $page['icon_content2'] : 'box subtitle 2',
            'icon3' => $page && !empty($page['icon3']) ? $page['icon3'] : 'fa-solid fa-heart',
            'icon_title3' => $page && !empty($page['icon_title3']) ? $page['icon_title3'] : 'box title 3',
            'icon_content3' => $page && !empty($page['icon_content3']) ? $page['icon_content3'] : 'box subtitle 3',
            'icon4' => $page && !empty($page['icon4']) ? $page['icon4'] : 'fa-solid fa-heart',
            'icon_title4' => $page && !empty($page['icon_title4']) ? $page['icon_title4'] : 'box title 4',
            'icon_content4' => $page && !empty($page['icon_content4']) ? $page['icon_content4'] : 'box subtitle 4',
        ];

        $this->data['pagedata'] = $realPageData;
        $this->data['pageId'] = $page && $page['id'] ? $page['id'] : 0;
        $this->data['pagedata']['id'] = $page && $page['id'] ? $page['id'] : 0;

        return view('Web/Filmfestival/festival_about_and_sponsor', $this->data);
    }
    public function festival_awards()
    {
        $this->data['pageName'] = 'Festival Awards';
        $pageData = new FestivalAwardsPage();
        $festivalAwardDb = new FestivalAwards();

        $page = $pageData->where('festival_id', $this->festival_details['id'])->first();

        $realPageData = [
            'title' => $page && !empty($page['title']) ? $page['title'] : 'Your Page Title',
            'content' => $page && !empty($page['content']) ? $page['content'] : 'Your page description or content.'
        ];

        $this->data['pagedata'] = $realPageData;
        $this->data['pageId'] = $page && $page['id'] ? $page['id'] : 0;
        $this->data['pagedata']['id'] = $page && $page['id'] ? $page['id'] : 0;

        $festivalAwards = $festivalAwardDb->where('festival_id', $this->festival_details['id'])->orderBy('id', 'desc')->findAll();
        $this->data['festivalAwards'] = $festivalAwards;

        return view('Web/Filmfestival/festival_awards', $this->data);
    }
    public function festival_venue()
    {
        $this->data['pageName'] = "Venue - " . $this->festival_details['name'];

        $pageData = new FestivalVenues();
        $venueItemsDb = new FestivalVenueItem();

        $page = $pageData->where('festival_id', $this->festival_details['id'])->first();

        $this->data['pagedata'] = $page;
        $this->data['pageId'] = $page && $page['id'] ? $page['id'] : 0;

        $venues = $venueItemsDb->where('festival_id', $this->festival_details['id'])->orderBy('festival_year', 'desc')->findAll();

        // $festivalsYearlyDb = new FestivalDetailsModel();
        // $select = 'id, year, prefix, venue_image, venue_title, venue_description';
        // $allFestivalYears = $festivalsYearlyDb->select($select)->where(['festival_id' => $this->festival_details['id'], 'status' => 1])->orderBy('year', 'desc')->findAll();
        // // return print_r($allFestivalYears);

        $this->data['venues'] = $venues;

        return view('Web/Filmfestival/festival_venue', $this->data);
    }

    // dynamic
    public function festival_team()
    {
        $this->data['pageName'] = 'Meet our team';
        $pageData = $this->getPageData('team', $this->festival_details['id']);
        $this->data['pagedata'] = $pageData;

        $teamDb = new FestivalTeam();
        $teamMembers = $teamDb->where('festival_id', $this->festival_details['id'])->orderBy('id', 'desc')->findAll();
        $this->data['teamMembers'] = $teamMembers;

        return view('Web/Filmfestival/festival_team', $this->data);
    }
    public function festival_jury()
    {
        // return print_r($this->data['selectedYear']);
        $this->data['pageName'] = 'Festival Juries';
        $pageData = $this->getPageData('jury', $this->festival_details['id']);
        $this->data['pagedata'] = $pageData;

        $juryDb = new FestivalJury();
        if (!empty($this->data['selectedYear'])) {
            $juryMembers = $juryDb->select('id, first_name, last_name, image, festival_year, about, profession')->where(['festival_id' => $this->festival_details['id'], 'festival_year' => $this->data['selectedYear']])->orderBy('festival_year', 'desc')->findAll();
        } else {
            $juryMembers = $juryDb->select('id, first_name, last_name, image, festival_year, about, profession')->where(['festival_id' => $this->festival_details['id'], 'festival_year' => $this->festival_details['current_year']])->orderBy('festival_year', 'desc')->findAll();
        }
        $this->data['juryMembers'] = $juryMembers;

        return view('Web/Filmfestival/festival_jury', $this->data);
    }
    public function festival_jury_single($slug, $juryIdEncoded)
    {
        $id = base64_decode($juryIdEncoded);
        $this->data['pageName'] = 'Festival Juries';
        $this->data['id'] = $id;

        $juryDb = new FestivalJury();
        $jury = $juryDb->find($id);
        $this->data['jury'] = $jury;
        $galleryDb = new FestivalJuryGallery();
        $this->data['jury']['gallery'] = $galleryDb->where('jury_id', $id)->findAll();

        $this->data['jury']['youtube'] = false;
        $this->data['jury']['vimeo'] = false;
        if ($jury['video']) {
            if (strpos($jury['video'], 'youtube') > 0) {
                $this->data['jury']['youtube'] = getYoutubeId($jury['video']);
            }
            if (strpos($jury['video'], 'vimeo') > 0) {
                $this->data['jury']['vimeo'] = getVimeoId($jury['video']);
            }
        }

        return view('Web/Filmfestival/festival_jury_single', $this->data);
    }
    public function festival_events()
    {
        $this->data['pageName'] = 'Meet our team';
        return view('Web/Filmfestival/festival_team', $this->data);
    }
    public function festival_schedule()
    {
        $this->data['pageName'] = 'Festival Schedule';
        $pageData = $this->getPageData('schedule', $this->festival_details['id']);
        $this->data['pagedata'] = $pageData;

        $scheduleDb = new FestivalSchedules();
        $festivalSchedules = $scheduleDb->where('festival_id', $this->festival_details['id'])->orderBy('festival_year', 'desc')->findAll();
        $this->data['festivalSchedules'] = $festivalSchedules;

        return view('Web/Filmfestival/festival_schedule', $this->data);
    }

    // form pages
    public function festival_entry_form()
    {
        // return print_r($this->festival_details);
        $country = getUserCountry();
        $this->data['loadSelect2'] = true;
        if ($country == 'IN') {
            $this->data['currency'] = 'INR';
            $this->data['currency_symbol'] = '&#8377;';
            $this->data['gst_note'] = ' <small>Excl. GST</small>';
        } else {
            $this->data['currency'] = 'EUR';
            $this->data['currency_symbol'] = '&#8364;';
            $this->data['gst_note'] = '';
        }

        $this->data['pageName'] = 'Entry Form';

        $filmTypesDb = new FestivalTypeOfFilms();
        $allProjectTypes = $filmTypesDb->orderBy('type', 'desc')->orderBy('name', 'asc')->findAll();
        $this->data['allProjectTypes'] = $allProjectTypes;

        $typesOfAwards = array();
        if ($this->festival_details['short_awards']) {
            $typesOfAwards[] = 'Short';
        }
        if ($this->festival_details['feature_awards']) {
            $typesOfAwards[] = 'Feature';
        }
        $this->data['typesOfAwards'] = $typesOfAwards;

        if ($this->request->getPost()) {
            if ($this->request->getPost('submitEntryForm')) {
                $requestData = $this->request->getPost();
                $requestData['totalPricingArray'] = json_decode($this->request->getPost('totalPricingArray'));
                $requestData['awardsPricingArrayShort'] = json_decode($this->request->getPost('awardsPricingArrayShort'));
                $requestData['awardsPricingArrayFeature'] = json_decode($this->request->getPost('awardsPricingArrayFeature'));

                return json_encode($requestData);
            }
        }

        $pageData = $this->getPageData('entry_form', $this->festival_details['id']);
        $this->data['pagedata'] = $pageData;

        // return print_r($typesOfAwards);

        return view('Web/Filmfestival/festival_entry_form', $this->data);
    }
    public function festival_volunteer()
    {
        $response = ['success' => false, 'message' => '', 'data' => []];
        $this->data['optionalJs'] = true;
        if ($this->request->getPost('submitVolunteer')) {
            $dataToInsert = $this->request->getPost();
            unset($dataToInsert['submitVolunteer']);
            $dataToInsert['festival_id'] = $this->festival_details['id'];
            $dataToInsert['festival_year'] = $this->festival_details['current_year'];

            $volunteerDb = new FestivalVolunteer();
            if ($volunteerDb->save($dataToInsert)) {
                $response['message'] = 'Your query has been succesfully submitted, please sit back & relax, we will get back to you soon.';
                $response['success'] = true;
            } else {
                $response['message'] = 'Unable to query, please change your connection.';
                $response['success'] = false;
            }
            return json_encode($response);
        }

        $this->data['pageName'] = 'Volunteer Registration';

        $pageData = $this->getPageData('volunteer', $this->festival_details['id']);
        $this->data['pagedata'] = $pageData;

        return view('Web/Filmfestival/festival_volunteer', $this->data);
    }
    public function festival_delegate_registration()
    {
        $country = getUserCountry();

        $response = ['success' => false, 'message' => '', 'data' => []];

        $this->data['pageName'] = 'Delegate Registration';
        $this->data['paymentAssets'] = true;

        $pageData = $this->getPageData('delegate', $this->festival_details['id']);
        $this->data['pagedata'] = $pageData;

        if ($this->request->getPost('submitForm')) {
            $requestedData = $this->request->getPost();
            $requestedData["fullPackageJson"] = json_decode($requestedData["fullPackageJson"]);
            $response['message'] = 'Good data';
            $response['success'] = true;
            $response['data'] = $requestedData;
            return json_encode($response);
        }

        $packagesDb = new FestivalDelegatePackages();
        $allPackages = $packagesDb->where('festival_id', $this->festival_details['id'])->findAll();
        $this->data['currency_symbol'] = '&#8377;';
        foreach ($allPackages as $key => $package) {
            if ($country == 'IN') {
                $allPackages[$key]['fee'] = $package['fee_inr'];
                $allPackages[$key]['currency'] = 'INR';
                $allPackages[$key]['currency_symbol'] = '&#8377;';
                $this->data['currency_symbol'] = '&#8377;';
            } else {
                $allPackages[$key]['fee'] = $package['fee_eur'];
                $allPackages[$key]['currency'] = 'EUR';
                $allPackages[$key]['currency_symbol'] = '&#8364;';
                $this->data['currency_symbol'] = '&#8364;';
            }
            $allPackages[$key]['tickets'] = 0;
            $allPackages[$key]['total'] = 0;
            unset($allPackages[$key]['fee_inr']);
            unset($allPackages[$key]['fee_eur']);
            unset($allPackages[$key]['created_at']);
            unset($allPackages[$key]['updated_at']);
            unset($allPackages[$key]['deleted_at']);
            unset($allPackages[$key]['festival_id']);
        }
        $this->data['allPackages'] = $allPackages;

        return view('Web/Filmfestival/festival_delegate_registration', $this->data);
    }
    public function festival_support()
    {
        $this->data['pageName'] = 'Support & Contact';

        $pageData = $this->getPageData('support', $this->festival_details['id']);
        $this->data['pagedata'] = $pageData;

        return view('Web/Filmfestival/festival_support', $this->data);
    }


    public function festival_press()
    {
        $this->data['pageName'] = 'Press';

        $pageData = $this->getPageData('press', $this->festival_details['id']);
        $this->data['pagedata'] = $pageData;

        $pressDb = new FestivalPress();
        $press = $pressDb->where('festival_id', $this->festival_details['id'])->orderBy('festival_year', 'desc')->findAll();

        $pressNews  = array();

        // return print_r($this->data['festival_editions']);
        foreach ($press as $news) {
            $pressNews[$news['festival_year']][] = $news;
        }
        // return print_r($pressNews);

        $this->data['pressNews'] = $pressNews;
        // return print_r($this->data['festival_editions']);
        // return print_r(array_reverse(array_reverse($pressNews)));

        return view('Web/Filmfestival/festival_press', $this->data);
    }
    public function festival_gallery()
    {
        $this->data['pageName'] = 'Gallery';

        $pageData = $this->getPageData('gallery', $this->festival_details['id']);
        $this->data['pagedata'] = $pageData;

        $galleryDb = new FestivalGallery();
        $gallery = $galleryDb->where('festival_id', $this->festival_details['id'])->orderBy('id', 'RANDOM')->findAll();

        $this->data['gallery'] = $gallery;

        return view('Web/Filmfestival/festival_gallery', $this->data);
    }

    // other pages
    public function festival_winners()
    {
        $this->data['pageName'] = 'Festival Winners';

        $pageData = $this->getPageData('winners', $this->festival_details['id']);
        $this->data['pagedata'] = $pageData;

        return view('Web/Filmfestival/festival_winners', $this->data);
    }
    public function festival_official_selection()
    {
        $this->data['pageName'] = 'Official Selection';

        $pageData = $this->getPageData('official_selection', $this->festival_details['id']);
        $this->data['pagedata'] = $pageData;

        return view('Web/Filmfestival/festival_official_selection', $this->data);
    }

    // private functions
    private function getPageData($key, $festivalId)
    {
        $pageData = new DynamicPagesData();
        $page = (array)$pageData->where('festival_id', $festivalId)->first();
        // return $page;
        $data['id'] = $page && $page['id'] ? $page['id'] : 0;
        $data['title'] = $page && $page[$key . '_title'] ? $page[$key . '_title'] : '';
        $data['content'] = $page && $page[$key . '_content'] ? $page[$key . '_content'] : '';
        return $data;
    }

    private function festivalDeadlines($festival)
    {
        $deadlinesDb = new FestivalDeadlines();
        $deadline1 = [
            'id' => 'opening_date',
            'name' => 'Opening Date',
            'deadline' => $festival['opening_date']
        ];
        $deadline2 = [
            'id' => 'event_date',
            'name' => 'Event Date',
            'deadline' => $festival['event_date']
        ];

        $allDeadlines['first'] = $deadline1;
        $allDeadlines['all'] = $deadlinesDb->where('festival_id', $festival['id'])->orderBy('deadline', 'asc')->findAll();
        $allDeadlines['last'] = $deadline2;

        $date = date('Y-m-d');
        $deadlines = $deadlinesDb->where(['festival_id' => $festival['id'], 'deadline >=' => $date])->findAll();
        if ($deadlines && count($deadlines) > 0) {
            $deadlineToShow = $deadlinesDb->where(['festival_id' => $festival['id'], 'deadline >=' => $date])->orderBy('deadline', 'asc')->first();
        } else {
            if ($festival['opening_date'] >= $date) {
                $deadlineToShow = $deadline1;
            } else {
                $deadlineToShow = $deadline2;
            }
        }
        $allDeadlines['show'] = $deadlineToShow;

        return $allDeadlines;
    }
    private function convertFestivalAwardPricesByDeadline($deadline, $pricing)
    {
        if ($deadline['id'] != 'event_date' && $deadline['id'] != 'opening_date') {
            foreach ($pricing as $key => $prices) {
                $amountToDeduct = $prices['prices']['inr']['student'] / $deadline['student_inr'];
                $newAmount = $prices['prices']['inr']['student'] - $amountToDeduct;
                $pricing[$key]['prices']['inr']['student'] = ceil($newAmount);

                $amountToDeduct = $prices['prices']['eur']['student'] / $deadline['student_eur'];
                $newAmount = $prices['prices']['eur']['student'] - $amountToDeduct;
                $pricing[$key]['prices']['eur']['student'] = ceil($newAmount);

                $amountToDeduct = $prices['prices']['inr']['professional'] / $deadline['professional_inr'];
                $newAmount = $prices['prices']['inr']['professional'] - $amountToDeduct;
                $pricing[$key]['prices']['inr']['professional'] = ceil($newAmount);

                $amountToDeduct = $prices['prices']['eur']['professional'] / $deadline['professional_eur'];
                $newAmount = $prices['prices']['eur']['professional'] - $amountToDeduct;
                $pricing[$key]['prices']['eur']['professional'] = ceil($newAmount);
            }
        }
        return $pricing;
    }
}
