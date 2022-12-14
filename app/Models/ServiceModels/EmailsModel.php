<?php

namespace App\Models\ServiceModels;

// use App\Entities\Emails\Receipt;

use App\Models\Common\LanguagesModel;
use App\Models\Events\Events;
use App\Models\Events\EventTicketRegistration;
use App\Models\Festival\FestivalDelegates;
use App\Models\Festival\FestivalEntries;
use App\Models\Festival\FestivalModel;
use App\Models\Festival\FestivalOfficialSubmission;
use App\Models\Films\OtherInfoModel;
use App\Models\Payment\OrderModel;
use App\Models\UserModel;
use CodeIgniter\Email\Email;
use CodeIgniter\Model;
use DateTime;

class EmailsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'service_emails';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'unique_id',
        'to_email', // user email
        'to_name', // user name
        'subject',
        'html_content',
        'text_content',
        'schedule', // boolean
        'schedule_time', // datetime
        'send', // boolean
        'type', // 'welcome','receipt','ticket','invoice','email_validation','otp','password_reset','others'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function sendEmail($uniqueId, $to, $subject, $message1, $type, $name, $message2 = '')
    {
        // test url
        // http://localhost:8080/service/online/backup

        $emailData = [
            'unique_id' => $uniqueId,
            'to_email' => $to,
            'to_name' => $name,
            'subject' => $subject,
            'html_content' => $message1,
            'type' => $type,
        ];
        $emailSaved = $this->save($emailData);

        if ($message2 && !empty($message2)) {
            // send email here
            $email = new Email();

            helper('internalsettings');

            $email->initialize(getEmailConfigration());

            $email->setTo($to);

            $email->setFrom('no-reply@miniboxoffice.com', 'Mini Box Office');

            $email->setSubject($subject);
            $email->setMessage(html_entity_decode($message2));

            if ($emailSended = $email->send()) {
                $thisEmailData = $this->where('unique_id', $uniqueId)->first();
                $thisEmailData['send'] = 1;
                $this->save($thisEmailData);
            }
            return $emailSended;
        }

        return $emailSaved;
    }
    public function sendOrderEmail($order, $type = [])
    {
        if (in_array('delegate', $type)) {
            $subject = 'Delegate Registration Receipt - MiniBoxOffice.';
        }
        if (in_array('festival', $type)) {
            if (in_array('entry', $type)) {
                $subject = 'Festival Entry Receipt - MiniBoxOffice.';
            }
        }
        if (in_array('event', $type)) {
            if (in_array('ticket', $type)) {
                $subject = 'Event ticket Receipt';
            }
        }

        helper(['number', 'common']);

        $uniqueId = uniqidReal();
        $message1 = htmlentities($this->getReceipt($order, $uniqueId, false));
        if (in_array('ticket', $type)) {
            if (in_array('delegate', $type)) {
                $subject2 = 'Delegate Ticket Confirmation - Delegate Registration - MiniBoxOffice.';
                $messagex = htmlentities($this->getDelegateTicket($order));

                $uniqueId2 = uniqidReal();

                $this->sendEmail($uniqueId2, $order['user_email'], $subject2, $messagex, 'ticket', $order['user_name']);
                $decodedId = base64_encode($uniqueId2);
                $order['ticket_link'] = base_url(route_to('online_email_view', $decodedId));
            }
            if (in_array('event', $type)) {
                $subject2 = 'Event Ticket Confirmation - Event Registration - MiniBoxOffice.';
                $messagex = htmlentities($this->getEventTicket($order));

                $uniqueId2 = uniqidReal();

                $this->sendEmail($uniqueId2, $order['user_email'], $subject2, $messagex, 'ticket', $order['user_name']);
                $decodedId = base64_encode($uniqueId2);
                $order['ticket_link'] = base_url(route_to('online_email_view', $decodedId));
            }
        }
        if (in_array('festival', $type) && in_array('entry', $type)) {
            $subject2 = 'Festival Entry Form - MiniBoxOffice.';

            $uniqueId2 = uniqidReal();

            $messagex = htmlentities($this->getFestivalEntryEmail($order));

            $this->sendEmail($uniqueId2, $order['user_email'], $subject2, $messagex, 'ticket', $order['user_name'], $messagex);
            $decodedId = base64_encode($uniqueId2);
            $order['ticket_link'] = base_url(route_to('online_email_view', $decodedId));
        }
        $message2 = htmlentities($this->getReceipt($order, $uniqueId));

        $this->sendEmail($uniqueId, $order['user_email'], $subject, $message1, 'receipt', $order['user_name'], $message2);
    }
    public function getReceipt($order, $uniqueId, $email_view = true)
    {
        $decodedId = base64_encode($uniqueId);
        helper(['number', 'common']);

        $userAddress = isset($order['user_address']) ? $order['user_address'] . ' ' : '';
        $userPin = isset($order['user_pincode']) ? $order['user_pincode'] . ' ' : '';
        $userCity = isset($order['user_city']) ? getWorldName($order['user_city'], 'city') . ' ' : '';
        $userState = isset($order['user_state']) ? getWorldName($order['user_state'], 'state') . ' ' : '';
        $userCountry = isset($order['user_country']) ? getWorldName($order['user_country'], 'country') : '';

        $userFullAddress = $userAddress . $userPin . $userCity . $userState . $userCountry;

        $receipt = array();
        $receipt['currency'] = $order['currency'];
        $receipt['type_of_action'] = $this->getTitle($order['type_of_action']);
        $receipt['user_name'] = $order['user_name'];
        $receipt['user_address'] = $userFullAddress;
        $receipt['receipt_number'] = strtoupper($order['receipt']);

        $package_details = json_decode($order['product_information'], true);
        foreach ($package_details as $key => $package_detail) {
            $package_detail = (array)$package_detail;
            $package_details[$key]['name'] = $package_detail['details'] ? $package_detail['details'] : $package_detail['name'];
            $package_details[$key]['amount'] = number_to_currency($package_detail['total'], $order['currency'], 'en_US', 2);
        }
        $receipt['items'] = $package_details;

        if ($order['currency'] == 'INR') {
            $receipt['taxes'] = array(
                'name' => 'GST 18%',
                'amount' => number_to_currency($order['tax_gst'], $order['currency'], 'en_US', 2)
            );
        }
        $receipt['total'] = number_to_currency($order['amount'], $order['currency'], 'en_US', 2);

        $receipt['email_view'] = $email_view;

        $receipt['link'] = base_url(route_to('online_email_view', $decodedId));
        if (isset($order['ticket_link']) && !empty($order['ticket_link'])) {
            $receipt['ticket_link'] = $order['ticket_link'];
        }

        return view('Components/emails/html/receipt', (array)$receipt);
    }
    public function getDelegateTicket($order)
    {
        helper(['number', 'common']);

        $receipt = array();
        $package_details = json_decode($order['product_information'], true);
        $receipt['items'] = $package_details;

        $receipt['user_name'] = $order['user_name'];
        $receipt['receipt_number'] = strtoupper($order['receipt']);
        $receipt['ticket_type'] = 'DELEGATE REGISTRATION';

        $delegateDb = new FestivalDelegates();
        $delegate = $delegateDb->select('festival_id, movie_name')->where(['receipt' => $order['receipt']])->first();
        $festivalDb = new FestivalModel();
        $festival = $festivalDb->select('name, title')->find($delegate['festival_id']);

        $receipt['movie_name'] = $delegate['movie_name'];
        $receipt['festival_name'] = $festival['title'] ? $festival['title'] : $festival['name'];


        return view('Components/emails/html/delegate-ticket', (array)$receipt);
    }
    public function getEventTicket($order)
    {
        helper(['number', 'common']);

        $receipt = array();
        $package_details = json_decode($order['product_information'], true);
        $receipt['items'] = $package_details;

        $receipt['user_name'] = $order['user_name'];
        $receipt['receipt_number'] = strtoupper($order['receipt']);
        $receipt['ticket_type'] = 'EVENT REGISTRATION';

        $eventTicketDb = new EventTicketRegistration();
        $ticket = $eventTicketDb->where(['receipt' => $order['receipt']])->first();

        $eventDb = new Events();
        $event = $eventDb->find($ticket['event_id']);

        $earlier = new DateTime($event['from_date']);
        $later = new DateTime($event['to_date']);

        $abs_diff = $later->diff($earlier)->format("%a");

        $event['eventDays'] = $abs_diff;

        $receipt['event'] = $event;

        return view('Components/emails/html/event_ticket', (array)$receipt);
    }
    public function getFestivalEntryEmail($order)
    {

        $rcpNumber = $order['receipt']; // e559be72219f1 // create official submission from receipt number as unique id

        $entryDb = new FestivalEntries();
        $entry = $entryDb->where('receipt', $rcpNumber)->first();

        $festivalDb = new FestivalModel();
        $festival = $festivalDb->select('slug, name, title')->find($entry['festival_id']);
        $slug = $festival['slug']; // festival slug

        $officialDb = new FestivalOfficialSubmission();
        $officialData = [
            'festival_id' => $entry['festival_id'],
            'festival_year' => $entry['festival_year'],
            'user_email' => $order['user_email'],
            'unique_id' => $rcpNumber,
            'title' => $entry['movie_name'],
            'project' => $entry['project'],
            'country' => $entry['country'],
            'director' => $entry['director'],
            'production_company' => $entry['production_company'],
            'duration' => $entry['duration'],
            'debut_film' => $entry['debut_film'],
            'synopsis' => $entry['synopsis'],
            'locked_inputs' => json_encode([
                'country',
                'title',
                'director',
                'production_company',
                'duration',
                'debut_film',
                'synopsis',
                'project'
            ])
        ];
        $officialDb->save($officialData);

        $languageDb = new LanguagesModel();
        $language = $languageDb->find($entry['language']);

        $otherInfoDb = new OtherInfoModel();
        $languageData = [
            'movie_id' => $rcpNumber,
            'type' => 'languages',
            'name' => $language['name'],
            'attribute' => 'Main language'
        ];
        $otherInfoDb->save($languageData);
        $producer = [
            'movie_id' => $rcpNumber,
            'type' => 'producers',
            'name' => $entry['producer'],
            'attribute' => 'producer'
        ];
        $otherInfoDb->save($producer);


        $receipt = array();

        $receipt['movie_name'] = $entry['movie_name'];
        $receipt['festival_name'] = !empty($festival['title']) ? $festival['title'] : $festival['name'];
        $receipt['type_of_action'] = '(' . $this->getTitle($order['type_of_action']) . ')';
        $receipt['user_name'] = $order['user_name'];

        $userEmail = $order['user_email'];
        $receiptUpperCase = strtoupper($order['receipt']);
        $userPass = createPassword($receiptUpperCase);
        $userDb = new UserModel();
        $userData = [
            'first_name' => $order['user_name'],
            'email' => $order['user_email'],
            'mobile' => $order['user_phone'],
            'password' => $userPass,
            'email_status' => 'verified',
            'status' => 1,
            'text_status' => 'verified'
        ];
        if (!$userDb->where('email', $order['user_email'])->first()) {
            $userDb->save($userData);
            $receipt['user_email'] = $userEmail;
            $receipt['user_password'] = $receiptUpperCase;
        }

        $receipt['entry_form_link'] = base_url(route_to('festival_entry_form_extended', $slug, base64_encode($rcpNumber)));

        return view('Components/emails/html/festival_entry_welcome', (array)$receipt);
    }

    private function getTitle($string)
    {
        $str = str_replace('_', ' ', $string);
        return ucfirst($str);
    }

    public function sendEmailOld($type, $data)
    {
        // getType of the email from $type
        // getData from $data
        // set data to view as like below

        // text email according to data

        // for saving
        $textEmail = view('Components/text/emails/' . $type, $data);
        $htmlEmail = view('Components/html/emails/' . $type, $data);
        // for saving

        // for sending
        $data['email_view'] = false; // only for html
        // for sending

        // start email service

        // put html to email htmlPart
        // also put text email to textPart also if available
    }

    public function notifyAdmin($subject, $message)
    {
        helper('internalsettings');
        $emails = getNotificationEmails();
        if (!count($emails)) {
            $emails = ADMIN_NOTIFICATION_EMAILS;
        }
        $email = new Email();

        $email->initialize(getEmailConfigration());

        $email->setTo($emails);

        $email->setFrom('no-reply@miniboxoffice.com', 'Mini Box Office');

        $email->setSubject($subject);
        $email->setMessage(html_entity_decode($message));
        $logStatus = 0;
        if ($email->send()) {
            $logStatus = 1;
        }
        saveLog('email', 'admin_notification', json_encode($subject), $logStatus);
    }
    public function userFilmEntryStatusNotification($id, $isApproved = false, $rejectMessage = NULL)
    {
        $entryDb = new FestivalOfficialSubmission();
        $movie = $entryDb->select('id, unique_id, festival_id, user_email, title')->find($id);

        $festivalDb = new FestivalModel();
        $festival = $festivalDb->select('slug, name, title')->find($movie['festival_id']);
        $slug = $festival['slug'];

        $userDb = new UserModel();
        $user = $userDb->select('first_name, last_name')->where('email', $movie['user_email'])->first();
        if ($user) {
            // return $user;
            $receipt = array();

            $receipt['movie_name'] = $movie['title'];
            $receipt['festival_name'] = !empty($festival['title']) ? $festival['title'] : $festival['name'];
            $receipt['user_name'] = $user['first_name'] . ' ' . $user['last_name'];

            if ($isApproved) {
                $receipt['link'] = base_url(route_to('festival_official_selection_details', $slug, base64_encode($movie['id'])));
            } else {
                $receipt['link'] = base_url(route_to('festival_entry_form_extended', $slug, base64_encode($movie['unique_id'])));
            }

            $receipt['isApproved'] = $isApproved;
            $receipt['rejectMessage'] = $rejectMessage;

            $htmlEmail = view('Components/emails/html/festival_entry_update', (array)$receipt);

            $uniqueId = uniqidReal();

            $email = new Email();

            helper('internalsettings');

            $email->initialize(getEmailConfigration());

            $email->setTo($movie['user_email']);

            $email->setFrom('test@clcbws.online', 'Mini Box Office');

            $email->setSubject('Your movie/film update on MiniBoxOffice');
            $email->setMessage($htmlEmail);
            $emailSended = $email->send();
            if ($emailSended) {
                $thisEmailData = $this->where('unique_id', $uniqueId)->first();
                $thisEmailData['send'] = 1;
                $this->save($thisEmailData);
            }
            return $emailSended;
        }
        return false;
    }
    public function sendNewEntryEmail($data)
    {
        $response = ['success' => false, 'message' => 'Email send error, plese try again after some time.'];
        $festivalDb = new FestivalModel();
        $festival = $festivalDb->select('slug, name, title')->find($data['festival_id']);
        $slug = $festival['slug'];

        $receipt = array();

        $receipt['movie_name'] = 'New Movie';
        $receipt['festival_name'] = !empty($festival['title']) ? $festival['title'] : $festival['name'];
        $receipt['type_of_action'] = 'New movie Entry';
        $receipt['user_name'] = $data['full_name'];


        if (isset($data['user_email'], $data['user_password'])) {
            $receipt['user_email'] = $data['user_email'];
            $receipt['user_password'] = $data['user_password'];
        }

        $receipt['entry_form_link'] = base_url(route_to('festival_entry_form_extended', $slug, base64_encode($data['unique_id'])));

        $htmlEmail = view('Components/emails/html/festival_entry_welcome_new_request', (array)$receipt);

        $email = new Email();

        helper('internalsettings');

        $email->initialize(getEmailConfigration());

        $email->setTo($data['user_email']);

        $email->setFrom('test@clcbws.online', 'Mini Box Office');

        $email->setSubject('Entry Form | Mini Box Office');
        $email->setMessage($htmlEmail);
        $emailSended = $email->send();
        if ($emailSended) {
            $thisEmailData = $this->where('unique_id', $data['unique_id'])->first();
            $thisEmailData['send'] = 1;
            $this->save($thisEmailData);
            $response['success'] = true;
            $response['message'] = 'Request send successfully.';
        }
        return $response;
    }
}
