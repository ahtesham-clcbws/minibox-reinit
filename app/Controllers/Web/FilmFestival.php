<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Libraries\PayPalHelper;
use App\Models\AwardsCategoryModel;
use App\Models\Common\FilmzinetoModule;
use App\Models\Common\TestimonialModel;
use App\Models\Events\Events;
use App\Models\Events\EventsContacts;
use App\Models\Events\EventsTickets;
use App\Models\Festival\DynamicPagesData;
use App\Models\Festival\FestivalAbout;
use App\Models\Festival\FestivalAwards;
use App\Models\Festival\FestivalAwardsPage;
use App\Models\Festival\FestivalBanners;
use App\Models\Festival\FestivalDeadlines;
use App\Models\Festival\FestivalDelegatePackages;
use App\Models\Festival\FestivalDelegates;
use App\Models\Festival\FestivalEntries;
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
use App\Models\Payment\OrderModel;
use CodeIgniter\API\ResponseTrait;
use DateTime;

class FilmFestival extends BaseController
{
    protected $slug;
    protected $festivalModel;
    // protected $festivalYearlyModel;
    protected $festival_details;
    use ResponseTrait;

    public function __construct()
    {
        $this->data['gateway'] = 'razorpay';
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

        $bannersDb = new FestivalBanners();
        $this->data['banners'] = $bannersDb->getFestivalHomeBanners($this->festival_details['id']);


        $filmzineSelect = 'filmzinetomodules.news_id, filmzinetomodules.data_id, filmzine.title,, filmzine.summary, filmzine.slug, filmzine.featured, filmzine.media_url, filmzine.media_type, filmzine.video_type, filmzine.topic_id, filmzine.topic_name, filmzine.total_likes, filmzine.total_dislikes, filmzine.movie_rating, filmzine.total_views, filmzine.created_at';
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
        $testimonialsDb = new TestimonialModel();
        $testimonials = $testimonialsDb->where(['type' => 'festival', 'module_id' => $this->festival_details['id']])->orderBy('id', 'RANDOM')->findAll(6);
        $this->data['testimonials'] = $testimonials;

        $eventDb = new Events();
        $events = $eventDb->distinct()
            ->select('events.*, events_categories.name as categoryName, states.name as stateName')
            ->join('events_categories', 'events_categories.id = events.category')
            ->join('states', 'states.id = events.state')
            ->where('events.type', 'festival')
            ->where('events.module_id', $this->festival_details['id'])
            ->orderBy('events.id', 'desc')->findAll();
        $this->data['events'] = $events;

        // return print_r($filmzineInterviews);

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
        $this->data['pageName'] = 'Our Events';

        return view('Web/Events/index', $this->data);
    }
    public function festival_event_details($slug, $decodedId)
    {

        helper('payment');

        $paymentFirstLink = route_to('event_tickets_registration');
        $this->data['paymentFirstLink'] = $paymentFirstLink;

        $response = ['success' => false, 'message' => '', 'data' => []];

        $country = getUserCountry();

        $this->data['pageName'] = 'Entry Form';
        $this->data['paymentAssets'] = true;
        $this->data['productType'] = 'entry_form';

        $this->data['loadSelect2'] = true;
        $this->data['productDescription'] = 'Event Ticket';

        if ($country == 'IN') {
            $this->data['currency'] = 'INR';
            $this->data['currency_symbol'] = '&#8377;';
            $this->data['gst_note'] = ' <small>Excl. GST</small>';

            $this->data['gateway'] = 'razorpay';
            $this->data['callback_url'] = route_to('razorpayCallback');
        } else {
            $this->data['currency'] = 'EUR';
            $this->data['currency_symbol'] = '&#8364;';
            $this->data['gst_note'] = '';

            $this->data['gateway'] = 'other';
        }
        $eventId = base64_decode($decodedId);
        $eventMd = new Events();
        if ($event = $eventMd->find($eventId)) {
            $this->data['pageName'] = $event['title'];

            $earlier = new DateTime($event['from_date']);
            $later = new DateTime($event['to_date']);

            $abs_diff = $later->diff($earlier)->format("%a");

            $event['eventDays'] = $abs_diff;
            $contactDb = new EventsContacts();
            $contact = $contactDb->where('event_id', $event['id'])->findAll();
            if (count($contact)) {
                $contacts = $contact;
            } else {
                $contacts = $contactDb->where('type', 'global')->findAll();
            }
            $this->data['contacts'] = $contacts;

            $ticketsDb = new EventsTickets();
            $ticket = $ticketsDb->where('event_id', $event['id'])->findAll();
            if (count($ticket)) {
                $tickets = $ticket;
            } else {
                $tickets = $ticketsDb->where('type', 'global')->findAll();
            }
            $this->data['currency_symbol'] = getCurrencySymbol();
            foreach ($tickets as $key => $package) {
                if ($country == 'IN') {
                    $tickets[$key]['fee'] = $package['inr'];
                    $tickets[$key]['currency'] = 'INR';
                    $tickets[$key]['currency_symbol'] = '&#8377;';
                } else {
                    $tickets[$key]['fee'] = $package['eur'];
                    $tickets[$key]['currency'] = 'EUR';
                    $tickets[$key]['currency_symbol'] = '&#8364;';
                }
                $tickets[$key]['tickets'] = 0;
                $tickets[$key]['total'] = 0;
                unset($tickets[$key]['inr']);
                unset($tickets[$key]['eur']);
                unset($tickets[$key]['created_at']);
                unset($tickets[$key]['updated_at']);
                unset($tickets[$key]['deleted_at']);
                unset($tickets[$key]['event_id']);
            }
            $this->data['tickets'] = $tickets;

            $this->data['event'] = $event;
            return view('Web/Events/single_event', $this->data);
        } else {
            return redirect()->route('events');
        }
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
        helper('payment');

        $response = ['success' => false, 'message' => '', 'data' => []];

        $country = getUserCountry();

        $this->data['pageName'] = 'Entry Form';
        $this->data['paymentAssets'] = true;
        $this->data['productType'] = 'entry_form';

        $this->data['loadSelect2'] = true;
        $this->data['productDescription'] = 'Delegate Registration';

        if ($country == 'IN') {
            $this->data['currency'] = 'INR';
            $this->data['currency_symbol'] = '&#8377;';
            $this->data['gst_note'] = ' <small>Excl. GST</small>';

            $this->data['gateway'] = 'razorpay';
            $this->data['callback_url'] = route_to('razorpayCallback');
        } else {
            $this->data['currency'] = 'EUR';
            $this->data['currency_symbol'] = '&#8364;';
            $this->data['gst_note'] = '';

            $this->data['gateway'] = 'other';
        }

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
            $festivalFullName = $this->festival_details['title'] ? $this->festival_details['title'] : $this->festival_details['name'];
            if ($this->request->getPost('submitForm')) {
                $requestedData = $this->request->getVar();
                $receipt = uniqidReal();
                $requestedData['totalPricingArray'] = json_decode($this->request->getPost('totalPricingArray'), true);
                // $requestedData['awardsPricingArrayShort'] = json_decode($this->request->getPost('awardsPricingArrayShort'));
                // $requestedData['awardsPricingArrayFeature'] = json_decode($this->request->getPost('awardsPricingArrayFeature'));
                // $requestedData['award'] = json_decode($this->request->getPost('award'));
                // return json_encode($requestedData);

                $selected_awards = array();
                $project_type_small = strtolower($requestedData['project_type']);
                foreach ($requestedData['award'][$project_type_small] as $key => $thisaward) {
                    $award = array(
                        'id' => $key,
                        'award' => $thisaward['award'],
                        'subwards' => isset($thisaward['sub_awards']) ? $thisaward['sub_awards'] : []
                    );
                    $selected_awards[] = $award;
                }
                $requestedData['selected_awards'] = (array)$selected_awards;
                // return json_encode($requestedData);


                $entryFormData = [
                    "name" => $requestedData['name'],
                    "email" => $requestedData['email'],
                    "mobile" => $requestedData['mobile'],
                    "country" => $requestedData['country'],
                    'festival_id' => $this->festival_details['id'],
                    'festival_year' => $this->festival_details['current_year'],
                    "movie_name" => $requestedData['movie_name'],
                    "director" => $requestedData['director'],
                    "movie_preview_link" => $requestedData['movie_preview_link'],
                    "movie_password" => $requestedData['movie_password'],
                    "producer" => $requestedData['producer'],
                    "production_company" => $requestedData['production_company'],
                    "duration" => $requestedData['duration'], // in minutes
                    "debut_film" => $requestedData['debut_film'],
                    "language" => $requestedData['language'],
                    "synopsis" => $requestedData['synopsis'],
                    "occupation" => $requestedData['occupation'],
                    "project" => $requestedData['project'], // project type id
                    "project_type" => $requestedData['project_type'], // like : short or feature (for accessing awards from award array)
                    "currency" => $requestedData['currency'],
                    "festival_deadline" => $requestedData['festival_deadline'],
                    "selected_award_ids" => json_encode($requestedData['totalPricingArray']['awards']), //  totalPricingArray['awards'] = array of ids // NEW
                    "total_amount" => $requestedData['totalPricingArray']['total'], //  totalPricingArray['total'] // NEW
                    "amount" => $requestedData['totalPricingArray']['final'], //  totalPricingArray['final'] // NEW
                    "totalPricingArray" => json_encode($requestedData['totalPricingArray']),
                    "selected_awards" => json_encode($selected_awards), // award data will be converting to new array like array(award_id, sub_awards=array()) // NEW
                    'gateway' => $requestedData['gateway'],
                    'receipt' => $receipt,
                    'payment_status' => 'pending'
                ];
                if ($country == 'IN') {
                    $entryFormData['tax_amount'] = $requestedData['totalPricingArray']['tax'];
                }

                $response['message'] = 'Unable to add your order, please mail us on ' . getCustomerCare()['email'] . ' or call us on ' . getCustomerCare()['phone'];
                $response['data'] = $entryFormData;
                $festivalEntriesDb = new FestivalEntries();
                $saveEntry = $festivalEntriesDb->save($entryFormData);

                $response['message'] = 'Unable to add your order (FE), please mail us on ' . getCustomerCare()['email'] . ' or call us on ' . getCustomerCare()['phone'];
                // return json_encode($this->festivalDeadlines($this->festival_details)['show']);
                if ($saveEntry) {
                    $awardCateDb = new AwardsCategoryModel();

                    // $priceColumn = $project_type_small . '_' . $entryFormData['occupation'] . '_' . strtolower($this->data['currency']);

                    $awardIds = json_decode($entryFormData['selected_award_ids'], true);

                    // $this->festival_details['deadlines']['show']

                    // $selectedPackages = $awardCateDb->select('id, name, ' . $priceColumn . ' as amount')->whereIn('id', $awardIds)->findAll();

                    // $selectedPackages = $awardCateDb->whereIn('id', $awardIds)->findAll();

                    // $selectedPackages = $this->convertFestivalAwardPricesByDeadline2($this->festival_details['deadlines']['show'], $selectedPackages);
                    $selectedPackages = array();

                    $mainAwardPrizes = $this->festival_details[$project_type_small . '_awards_prices'];
                    foreach ($mainAwardPrizes as $key => $prize) {
                        if (in_array($prize['award_id'],  $awardIds)) {
                            $amount = $prize['prices'][strtolower($this->data['currency'])][$entryFormData['occupation']];
                            // $amount = $this->convertSingleFeeByDeadline($amount, $entryFormData['occupation'], strtolower($this->data['currency']));
                            $award = [
                                "id" => $prize['award_id'],
                                "name" => $prize['award_name'],
                                "details" => $prize['award_name'] . ' Awards',
                                "total" => $amount,
                                "type" => "award",
                                "quantity" => 1
                            ];
                            $selectedPackages[] = $award;
                        }
                    }

                    // foreach ($selectedPackages as $key => $value) {
                    //     return json_encode($value[$priceColumn]);
                    //     return json_encode($this->convertSingleFeeByDeadline($value[$priceColumn], $entryFormData['occupation'], strtolower($this->data['currency'])));
                    //     $selectedPackages[$key]['details'] = $value['name'] . ' Award';
                    //     // $amount = 0;
                    //     // if($requestedData['project_type'] == 'Feature' && $entryFormData['occupation'] = 'professional' &&  $this->data['currency'] == 'INR') {
                    //     //     $amount = $value['feature_professional_inr'];
                    //     // }
                    //     // if($requestedData['project_type'] == 'Feature' && $entryFormData['occupation'] = 'professional' &&  $this->data['currency'] == 'EUR') {
                    //     //     $amount = $value['feature_professional_eur'];
                    //     // }
                    //     // if($requestedData['project_type'] == 'Short' && $entryFormData['occupation'] = 'professional' &&  $this->data['currency'] == 'INR') {
                    //     //     $amount = $value['feature_student_inr'];
                    //     // }
                    //     // if($requestedData['project_type'] == 'Short' && $entryFormData['occupation'] = 'professional' &&  $this->data['currency'] == 'EUR') {
                    //     //     $amount = $value['feature_student_inr'];
                    //     // }
                    //     // if($requestedData['project_type'] == 'Feature' && $entryFormData['occupation'] = 'student' &&  $this->data['currency'] == 'INR') {
                    //     //     $amount = $value['feature_student_inr'];
                    //     // }
                    //     $selectedPackages[$key]['total'] = $this->convertSingleFeeByDeadline($value[$priceColumn], $entryFormData['occupation'], strtolower($this->data['currency']));
                    //     $selectedPackages[$key]['type'] = 'award';
                    //     $selectedPackages[$key]['quantity'] = 1;

                    //     unset($selectedPackages[$key]['created_at']);
                    //     unset($selectedPackages[$key]['deleted_at']);
                    //     unset($selectedPackages[$key]['feature_professional_eur']);
                    //     unset($selectedPackages[$key]['feature_professional_inr']);
                    //     unset($selectedPackages[$key]['feature_student_eur']);
                    //     unset($selectedPackages[$key]['feature_student_inr']);
                    //     unset($selectedPackages[$key]['image']);
                    //     unset($selectedPackages[$key]['short_name']);
                    //     unset($selectedPackages[$key]['short_professional_eur']);
                    //     unset($selectedPackages[$key]['short_professional_inr']);
                    //     unset($selectedPackages[$key]['short_student_eur']);
                    //     unset($selectedPackages[$key]['short_student_inr']);
                    //     unset($selectedPackages[$key]['updated_at']);
                    // }
                    // return json_encode($selectedPackages);

                    $selectedPackagesX  = array();

                    foreach ($selectedPackages as $key => $package) {
                        array_push($selectedPackagesX, $package);
                    }

                    $requestedData['selectedPackages'] = (array)$selectedPackagesX;
                    $orderData = [
                        'receipt' => $receipt,
                        'amount' => $entryFormData['amount'],
                        'product_information' => $selectedPackagesX,
                        'product_name' => 'Festival Entry - ' . $festivalFullName,
                        'user_name' => $entryFormData['name'],
                        'user_email' => $entryFormData['email'],
                        'user_phone' => $entryFormData['mobile'],
                        'other_user_info' => array(
                            "movie_name" => $entryFormData['movie_name'],
                            "director" => $entryFormData['director'],
                            "producer" => $entryFormData['producer'],
                            "language" => $entryFormData['language'],
                            "project_type" => $entryFormData['project_type'],
                            "occupation" => $entryFormData['occupation'],
                            "production_company" => $entryFormData['production_company'],
                        ),
                        'type_of_action' => 'festival_entry',
                        'user_country' => $entryFormData['country'],
                        'order_items' => 'festival_entry_awards'
                    ];
                    if ($this->data['gateway'] == 'razorpay') {
                        // create order then send the selected data to razorpay server;
                        // CREATE LOCAL ORDER FOR RAZORPAY
                        $orderDb = new OrderModel();
                        $orderData['tax_gst'] = $entryFormData['tax_amount'];

                        $response['message'] = 'Unable to add your order (RCO1), please mail us on ' . getCustomerCare()['email'] . ' or call us on ' . getCustomerCare()['phone'];

                        $createOrder = $orderDb->razorpayCreateOrder($orderData);
                        return json_encode($createOrder);

                        $thisEntry = $festivalEntriesDb->where(['receipt' => $receipt])->first();

                        $response['message'] = 'Unable to add your order (RCO2), please mail us on ' . getCustomerCare()['email'] . ' or call us on ' . getCustomerCare()['phone'];

                        if ($createOrder['success']) {
                            $oldEntry['id'] = $thisEntry['id'];
                            $oldEntry['order_id'] = $createOrder['data']['order']['id'];
                            $oldEntry['gateway_order_id'] = $createOrder['data']['response']['id'];
                            $oldEntry['payment_status'] = 'processing';
                            $festivalEntriesDb->save($oldEntry);

                            return json_encode($createOrder);
                        }
                        $oldEntry['id'] = $thisEntry['id'];
                        $oldEntry['payment_status'] = 'failed';
                        $festivalEntriesDb->save($oldEntry);
                    }
                    if ($this->request->getPost('paypalOrderCreate')) {
                        $paypalOrderData = json_encode($orderData);
                        $paypalOrderData = json_decode($paypalOrderData, true);

                        // return json_encode($paypalOrderData);

                        // 100 PERCENT WORKING CODE OF PAYPAL RIGHT NOW
                        $paypalHelper = new PayPalHelper;
                        return json_encode($paypalHelper->orderCreate($paypalOrderData));
                    }
                }
                return json_encode($response);

                // return json_encode($entryFormData);

                // sample data (would be changed in future for better performance)
                $sampleData = array(
                    "name" => "Mohammad Ahtesham",
                    "email" => "ahtesham2000@gmail.com",
                    "mobile" => "+919873350509",
                    "country" => "101",
                    "movie_name" => "Avenger Version 2",
                    "director" => "Some director",
                    "movie_preview_link" => "http://google.com",
                    "movie_password" => "",
                    "producer" => "Some Producer",
                    "production_company" => "Broadway Web Services",
                    "duration" => "120",
                    "debut_film" => "No",
                    "language" => "40",
                    "synopsis" => "",
                    "occupation" => "professional",
                    "project" => "2",
                    "currency" => "INR",
                    "festival_deadline" => "2022-09-16",
                    "award" => array(
                        "feature" => array(
                            "0" => array(
                                "award" => "Production",
                                "sub_awards" => array(
                                    "Best Feature Documentary",
                                    "Best Music Video",
                                    "Best Debut Director"
                                )
                            ),
                            "3" => array(
                                "award" => "Music"
                            )
                        )
                    ),
                    "totalPricingArray" => array(
                        "awards" => array(
                            "1",
                            "4"
                        ),
                        "total" => 9584,
                        "final" => 11309.12,
                        "tax" => 18
                    ),
                    "project_type" => "Feature",
                    "rules" => "on",
                    "submitForm" => "true",
                    "awardsPricingArrayShort" => null,
                    "awardsPricingArrayFeature" => null
                );
            }
            return json_encode($response);
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
        helper('payment');
        $response = ['success' => false, 'message' => '', 'data' => []];

        $this->data['pageName'] = 'Delegate Registration';
        $this->data['paymentAssets'] = true;
        $this->data['productType'] = 'deletegate_registration';
        $this->data['productDescription'] = 'Delegate Registration';

        if ($country == 'IN') {
            $this->data['gateway'] = 'razorpay';
            $this->data['callback_url'] = route_to('razorpayCallback');
        } else {
            $this->data['gateway'] = 'other';
        }

        $pageData = $this->getPageData('delegate', $this->festival_details['id']);
        $this->data['pagedata'] = $pageData;

        if ($this->request->getPost('submitForm')) {
            $requestedData = $this->request->getPost();
            // $requestedData["fullPackageJson"] = json_decode($requestedData["fullPackageJson"]);
            // sample JSON (maybe there is some changes)
            $sampleJson = array(
                "name" => "Mohammad Ahtesham",
                "movie_name" => "some movie",
                "email" => "ahtesham2000@gmail.com",
                "whatsapp" => "9810763314",
                "mobile" => "+919873350509",
                "organization" => "Broadway Web Services",
                "address" => "H No-143, 4th floor, Gali No-13,, Flat No-3, Jamia Nagar, Okhla",
                "country" => "101",
                "state" => "4021",
                "city" => "131679",
                "pin" => "110025",
                "package" => array(
                    array(
                        "details" => "Screening & networking with lunch & morning/evening tea coffee & snacks.",
                        "amount" => "800",
                        "tickets" => "1",
                        "total" => "800"
                    ),
                    array(
                        "details" => "Screening & Networking, Master Class on Film Funding [For emerging filmmakers], with lunch & morning/evening tea coffee.",
                        "amount" => "2000",
                        "tickets" => "2",
                        "total" => "4000"
                    ),
                    array(
                        "details" => "Screening & Networking, Master Class on Marketing, promotion, distribution & Revenue generation through Short films with lunch & morning/evening tea coffee.",
                        "amount" => "3000",
                        "tickets" => "0",
                        "total" => "0"
                    )
                ),
                "package_tickets" => "3",
                "package_amount" => "4800",
                "submitForm" => "true"
            );
            $receipt = uniqidReal();
            $delegateRegsitrationDb = new FestivalDelegates();
            $delegate = array(
                'festival_id' => $this->festival_details['id'],
                'festival_year' => $this->festival_details['current_year'],
                'name' => $requestedData['name'],
                'movie_name' => $requestedData['movie_name'],
                'email' => $requestedData['email'],
                'whatsapp' => $requestedData['whatsapp'],
                'mobile' => $requestedData['mobile'],
                'organization' => $requestedData['organization'],
                'address' => $requestedData['address'],
                'country' => $requestedData['country'],
                'state' => $requestedData['state'],
                'city' => $requestedData['city'],
                'pin' => $requestedData['pin'],
                'package_details' => json_encode($requestedData['package']),
                'tickets' => $requestedData['package_tickets'],
                'amount' => $requestedData['package_amount'],
                'gateway' => $requestedData['gateway'],
                'receipt' => $receipt
            );

            // $delegate['status'] = $this->festival_details['status'];    
            $response['message'] = 'Unable to get your order, please mail us on ' . getCustomerCare()['email'] . ' or call us on ' . getCustomerCare()['phone'];
            $response['data'] = $requestedData;
            $saveDelegate = $delegateRegsitrationDb->save($delegate);
            if ($saveDelegate) {
                $selectedPackages = array();
                $realAmountByPckages = 0;
                $realTicketsByPckages = 0;

                $requestedData['package'] = (array) $requestedData['package'];
                foreach ($requestedData['package'] as $package) {
                    $thisPackage = (array) $package;
                    // $selectedPackages[] = $thisPackage;
                    $realAmount = intval($thisPackage['amount']) * intval($thisPackage['tickets']);
                    $realAmountByPckages += $realAmount;
                    $realTicketsByPckages += intval($thisPackage['tickets']);

                    if ($thisPackage['tickets'] > 0 && $thisPackage['total'] > 0) {
                        // $thisPackage['name'] = $thisPackage['details'];
                        $thisPackage['type'] = 'ticket';
                        $thisPackage['quantity'] = $thisPackage['tickets'];
                        unset($thisPackage['tickets']);
                        $selectedPackages[] = $thisPackage;
                    }
                }

                if ($country == 'IN') {
                    $singlePercent = $realAmountByPckages / 100;
                    $taxGst = $singlePercent * 18;
                    $realAmountByPckages = $realAmountByPckages + $taxGst;
                }

                $response['message'] = 'In-Valid Request.';
                $requestedData['selectedPackages'] = $selectedPackages;
                if ($realAmountByPckages == $requestedData['package_amount'] && $realTicketsByPckages == $requestedData['package_tickets']) {
                    if ($this->data['gateway'] == 'razorpay') {
                        // create order then send the selected data to razorpay server;
                        // CREATE LOCAL ORDER FOR RAZORPAY
                        $orderData = [
                            'receipt' => $receipt,
                            'amount' => $requestedData['package_amount'],
                            'product_information' => $selectedPackages,
                            'product_name' => 'Delegate Registration - ' . $this->festival_details['title'] ? $this->festival_details['title'] : $this->festival_details['name'],
                            'user_name' => $requestedData['name'],
                            'user_email' => $requestedData['email'],
                            'user_phone' => $requestedData['mobile'],
                            'other_user_info' => array(
                                "movie_name" => $requestedData['movie_name'],
                                "whatsapp" => $requestedData['whatsapp'],
                                "organization" => $requestedData['organization'],
                                "address" => $requestedData['address'],
                                "country" => getWorldName($requestedData['country'], 'country'),
                                "state" => getWorldName($requestedData['state'], 'state'),
                                "city" => getWorldName($requestedData['city'], 'city'),
                                "pin" => $requestedData['pin'],
                            ),
                            'type_of_action' => 'delegate_registration',
                            'user_address' => $requestedData['address'],
                            'user_pincode' => $requestedData['pin'],
                            'user_city' => $requestedData['city'],
                            'user_state' => $requestedData['state'],
                            'user_country' => $requestedData['country'],
                            'order_items' => 'festival_delegate_packages',
                            'tax_gst' => $requestedData['tax_gst'],
                        ];
                        $orderDb = new OrderModel();
                        $createOrder = $orderDb->razorpayCreateOrder($orderData);

                        $thisDelegate = $delegateRegsitrationDb->where(['receipt' => $receipt])->first();

                        if ($createOrder['success']) {
                            $delegateDetails['id'] = $thisDelegate['id'];
                            $delegateDetails['order_id'] = $createOrder['data']['order']['id'];
                            $delegateDetails['gateway_order_id'] = $createOrder['data']['response']['id'];
                            $delegateDetails['payment_status'] = 'processing';
                            $delegateRegsitrationDb->save($delegateDetails);

                            $response = $createOrder;
                            return json_encode($response);
                        }
                        $delegateDetails['id'] = $thisDelegate['id'];
                        $delegateDetails['payment_status'] = 'failed';
                        $delegateRegsitrationDb->save($delegateDetails);
                    }
                    if ($this->request->getPost('paypalOrderCreate')) {
                        $orderData = [
                            'receipt' => $receipt,
                            'amount' => $requestedData['package_amount'],
                            'product_information' => $selectedPackages,
                            'product_name' => 'Delegate Registration - ' . $this->festival_details['title'] ? $this->festival_details['title'] : $this->festival_details['name'],
                            'user_name' => $requestedData['name'],
                            'user_email' => $requestedData['email'],
                            'user_phone' => $requestedData['mobile'],
                            'other_user_info' => array(
                                "movie_name" => $requestedData['movie_name'],
                                "whatsapp" => $requestedData['whatsapp'],
                                "organization" => $requestedData['organization'],
                                "address" => $requestedData['address'],
                                "country" => getWorldName($requestedData['country'], 'country'),
                                "state" => getWorldName($requestedData['state'], 'state'),
                                "city" => getWorldName($requestedData['city'], 'city'),
                                "pin" => $requestedData['pin'],
                            ),
                            'type_of_action' => 'delegate_registration',
                            'user_address' => $requestedData['address'],
                            'user_pincode' => $requestedData['pin'],
                            'user_city' => $requestedData['city'],
                            'user_state' => $requestedData['state'],
                            'user_country' => $requestedData['country'],
                            'order_items' => 'festival_delegate_packages',
                        ];
                        $orderData = json_encode($orderData);
                        $orderData = json_decode($orderData, true);

                        // 100 PERCENT WORKING CODE OF PAYPAL RIGHT NOW
                        $paypalHelper = new PayPalHelper;
                        return json_encode($paypalHelper->orderCreate($orderData));
                    }
                }
            }
            return json_encode($response);
        }

        $packagesDb = new FestivalDelegatePackages();
        $allPackages = $packagesDb->where('festival_id', $this->festival_details['id'])->findAll();
        $this->data['currency_symbol'] = getCurrencySymbol();
        foreach ($allPackages as $key => $package) {
            if ($country == 'IN') {
                $allPackages[$key]['fee'] = $package['fee_inr'];
                $allPackages[$key]['currency'] = 'INR';
                $allPackages[$key]['currency_symbol'] = '&#8377;';
            } else {
                $allPackages[$key]['fee'] = $package['fee_eur'];
                $allPackages[$key]['currency'] = 'EUR';
                $allPackages[$key]['currency_symbol'] = '&#8364;';
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

        // return print_r($this->data);

        return view('Web/Filmfestival/festival_delegate_registration', $this->data);
    }
    public function festival_support()
    {
        $this->data['pageName'] = 'Support & Contact';

        $pageData = $this->getPageData('support', $this->festival_details['id']);
        $this->data['pagedata'] = $pageData;

        return view('Web/Filmfestival/festival_support', $this->data);
    }


    // media
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
    public function festival_media($slug, $type)
    {
        $limit = 6;
        if ($type == 'interviews') {
            $this->data['pageName'] = 'Interviews';
        } else if ($type == 'trailers') {
            $this->data['pageName'] = 'Video Trailers';
        } else if ($type == 'knowledge-center') {
            $this->data['pageName'] = 'Knowledge Center';
        } else if ($type == 'headlines') {
            $this->data['pageName'] = 'Headlines';
            $limit = 3;
        } else {
            // redirect to festival homepage
        }

        $entityDb = new FilmzinetoModule();
        $entities = $entityDb->getWebData($type, $this->festival_details['id'], $limit);

        // return print_r($entities);

        $this->data['entities'] = $entities;
        $this->data['entityType'] = $type;

        return view('Web/Filmfestival/filmzine_media', $this->data);
    }
    public function festival_media_single($slug, $type, $id)
    {
        // return print_r($type);
        $entityDb = new FilmzinetoModule();
        $entities = $entityDb->getSingleWebData($type, $this->festival_details['id'], $id);

        $this->data['pageName'] = $entities['current']['title'];

        // return print_r($entities);

        $this->data['entities'] = $entities;
        $this->data['entityType'] = $type;

        return view('Web/Filmfestival/filmzine_media_single', $this->data);
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
                // $amountToDeduct = ($prices['prices']['inr']['student'] / 100) * $deadline['student_inr'];
                // $newAmount = $prices['prices']['inr']['student'] - $amountToDeduct;
                // $pricing[$key]['prices']['inr']['student'] = ceil($newAmount);
                $pricing[$key]['prices']['inr']['student'] = $this->convertSingleFeeByDeadline($prices['prices']['inr']['student'], 'student', 'inr');

                // $amountToDeduct = ($prices['prices']['eur']['student']  / 100) * $deadline['student_eur'];
                // $newAmount = $prices['prices']['eur']['student'] - $amountToDeduct;
                // $pricing[$key]['prices']['eur']['student'] = ceil($newAmount);
                $pricing[$key]['prices']['eur']['student'] = $this->convertSingleFeeByDeadline($prices['prices']['eur']['student'], 'student', 'eur');

                // $amountToDeduct = ($prices['prices']['inr']['professional']  / 100) * $deadline['professional_inr'];
                // $newAmount = $prices['prices']['inr']['professional'] - $amountToDeduct;
                // $pricing[$key]['prices']['inr']['professional'] = ceil($newAmount);
                $pricing[$key]['prices']['inr']['professional'] = $this->convertSingleFeeByDeadline($prices['prices']['inr']['professional'], 'professional', 'inr');

                // $amountToDeduct = ($prices['prices']['eur']['professional']  / 100) * $deadline['professional_eur'];
                // $newAmount = $prices['prices']['eur']['professional'] - $amountToDeduct;
                // $pricing[$key]['prices']['eur']['professional'] = ceil($newAmount);
                $pricing[$key]['prices']['eur']['professional'] = $this->convertSingleFeeByDeadline($prices['prices']['eur']['professional'], 'professional', 'eur');
            }
        }
        return $pricing;
    }
    private function convertFestivalAwardPricesByDeadline2($deadline, $pricing, $type = 'student', $currency = 'inr')
    {
        if ($deadline['id'] != 'event_date' && $deadline['id'] != 'opening_date') {
            foreach ($pricing as $key => $prices) {
                // short awards
                $amountToDeduct = ($prices['short_student_inr']  / 100) * $deadline['student_inr'];
                $newAmount = $prices['short_student_inr'] - $amountToDeduct;
                $pricing[$key]['short_student_inr'] = ceil($newAmount);

                $amountToDeduct = ($prices['short_student_eur']  / 100) * $deadline['student_eur'];
                $newAmount = $prices['short_student_eur'] - $amountToDeduct;
                $pricing[$key]['short_student_eur'] = ceil($newAmount);

                $amountToDeduct = ($prices['short_professional_inr']  / 100) * $deadline['professional_inr'];
                $newAmount = $prices['short_professional_inr'] - $amountToDeduct;
                $pricing[$key]['short_professional_inr'] = ceil($newAmount);

                $amountToDeduct = ($prices['short_professional_eur']  / 100) * $deadline['professional_eur'];
                $newAmount = $prices['short_professional_eur'] - $amountToDeduct;
                $pricing[$key]['short_professional_eur'] = ceil($newAmount);
                // feature awards
                $amountToDeduct = ($prices['feature_student_inr']  / 100) * $deadline['student_inr'];
                $newAmount = $prices['feature_student_inr'] - $amountToDeduct;
                $pricing[$key]['feature_student_inr'] = ceil($newAmount);

                $amountToDeduct = ($prices['feature_student_eur']  / 100) * $deadline['student_eur'];
                $newAmount = $prices['feature_student_eur'] - $amountToDeduct;
                $pricing[$key]['feature_student_eur'] = ceil($newAmount);

                $amountToDeduct = ($prices['feature_professional_inr']  / 100) * $deadline['professional_inr'];
                $newAmount = $prices['feature_professional_inr'] - $amountToDeduct;
                $pricing[$key]['feature_professional_inr'] = ceil($newAmount);

                $amountToDeduct = ($prices['feature_professional_eur']  / 100) * $deadline['professional_eur'];
                $newAmount = $prices['feature_professional_eur'] - $amountToDeduct;
                $pricing[$key]['feature_professional_eur'] = ceil($newAmount);
            }
        }
        return $pricing;
    }

    private function convertSingleFeeByDeadline($price, $type, $currency)
    {
        $deadline = $this->festivalDeadlines($this->festival_details);
        $current = $deadline['show'];
        $field = $type . '_' . $currency;
        $amountToDeduct = ($price  / 100) * $current[$field];
        $newAmount = $price - $amountToDeduct;
        return ceil($newAmount);
    }
}
