<?php

namespace App\Controllers\Services;

use App\Models\Payment\OrderModel;
use App\Models\ServiceModels\EmailsModel;
use CodeIgniter\Controller;
use SimpleSoftwareIO\QrCode\Generator;


class Emails extends Controller
{
    protected $emailDb;
    public function __construct()
    {
        $this->emailDb = new EmailsModel();
    }
    public function emailView($encodedId)
    {
        $type = 'receipt';

        $decodedId = base64_decode($encodedId);

        $findEmail = $this->emailDb->where(['unique_id' => $decodedId])->first();
        if ($findEmail) {
            $html_content = $findEmail['html_content'];

            // $header = view('Components/emails/html/_view_email_headers');
            $htmlEmail = html_entity_decode($html_content);

            // $finalView = str_replace('<body style="background-color:#f2f2f2;width: 100% !important;height: 100% !important;padding: 0 !important;margin: 0 !important;">', $header, $htmlEmail);
            // $finalView = str_replace(' <table border="0" cellpadding="0" cellspacing="0" style="width: 100% !important;">', ' <table border="0" cellpadding="0" cellspacing="0" style="width: 100% !important;" id="mainTable">', $finalView);

            echo $htmlEmail;

            return;
            // $data['html_content'] = $html_content;
            // return view('Components/html_email_view', $data);
        } else {
            return view('Components/no_email_found');
        }
    }

    public function invoice()
    {
        //
    }
    public function ticket()
    {
        //
    }
    public function backup()
    {
        // $data = [
        //     'user_name' => 'Ahtesham Abdul Aziz',
        //     'email_view' => true,
        //     'type_of_action' => '(Festival Entry)',
        //     'entry_form_link' => '#'
        // ];
        // return view('Components/emails/html/festival_entry_welcome', $data);

        // getEventTicket

        $orderDb = new OrderModel();
        $order = $orderDb->find(154);
        $emailMd = new EmailsModel();

        return $emailMd->getFestivalEntryEmail($order);
        die();
        
        ///////////////////////
        helper(['number', 'common']);

        $uniqueId = uniqidReal();

        $orderDb = new OrderModel();
        $order = $orderDb->find(91);
        $emailMd = new EmailsModel();
        $email = $emailMd->sendOrderEmail($order, ['festival', 'entry']);


        // $email = $emailMd->getReceipt($order, $uniqueId, true);
        return $email;

        $data = array();

        // 'to_email', // user email
        // 'to_name', // user name
        // 'subject',
        // 'html_content',
        // 'text_content',
        // 'schedule', // boolean
        // 'schedule_time', // datetime
        // 'send', // boolean
        // 'type', // 'welcome','receipt','ticket','invoice','email_validation','otp','password_reset','others'

        $currency = 'INR';

        $data['currency'] = $currency;
        $data['type_of_action'] = 'Registration';

        $data['user_name'] = 'Chaudhary Ahtesham';
        $data['user_address'] = '143/3, 4th floor, Zakir Nagar, Jamia Nagar, New Delhi, 110025';
        $data['type_of_action'] = 'Delegate Registration';

        // if ($type == 'receipt') {
        $data['receipt_number'] = strtoupper('77d7ac4daabc8');
        $data['items'] = array(
            array(
                'details' => 'Ticket details',
                'amount' => number_to_currency(2000, $currency, 'en_US', 2)
            ),
            array(
                'details' => 'Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ ',
                'amount' => number_to_currency(800, $currency, 'en_US', 2)
            ),
            array(
                'details' => 'Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ ',
                'amount' => number_to_currency(800, $currency, 'en_US', 2)
            )
        );
        $data['taxes'] = array(
            'name' => 'GST 18%',
            'amount' => number_to_currency(504, $currency, 'en_US', 2)
        );
        $data['total'] = number_to_currency(3304, $currency, 'en_US', 2);
        $data['email_view'] = false;

        // $data['link'] = base_url(route_to('online_email_view', $decodedId));
        // $link = 'http://localhost:8080/service/online/backup';
        // $data['link'] = $link;
        // }
        // $type = 'receipt';
        $generator = new Generator;
        // $qrCode = QrCode::generate($link);
        // $qrCode2 = $generator->size(80)->generate($link);
        $qrCode = $generator->style('round')->gradient(0, 163, 108, 8, 143, 143, 'diagonal')->size(80)->generate('http://miniboxoffice.com');

        // $uniqueId2 = uniqidReal();
        // $subject = 'Ticket Confirmation - Delegate Registration - MiniBoxOffice.';
        // $message1 = htmlentities($this->getDelegateTicket($order, $uniqueId, false));
        // $emailMd->sendEmail($uniqueId2, $order['user_email'], $subject, $message1, 'receipt', $order['user_name']);
        // $decodedId = base64_encode($uniqueId);
        // $order['ticket_link'] = base_url(route_to('online_email_view', $decodedId));

        // $data['qrCode'] = $qrCode;
        // echo getQrCode($link);
        // echo '<img src="'.$qrCode.'">';
        // echo $qrCode;
        // return;

        // $data['qrCode'] = $qrCode;
        // $data['qrCode2'] = $qrCode2;

        return view('Components/emails/html/receipt', $data);
        // return view('Components/emails/html/delegate-ticket', $data);
    }
}
