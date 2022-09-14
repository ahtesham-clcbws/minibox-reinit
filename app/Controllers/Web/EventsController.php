<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Libraries\PayPalHelper;
use App\Models\Events\Events;
use App\Models\Events\EventsContacts;
use App\Models\Events\EventsTickets;
use App\Models\Events\EventTicketRegistration;
use App\Models\Payment\OrderModel;
use DateTime;

class EventsController extends BaseController
{
    protected $eventMd;

    public function __construct()
    {
        $this->data['pageName'] = 'Events';
        $this->eventMd = new Events();
    }
    public function index()
    {
        // load all events
        return view('Web/Events/index', $this->data);
    }
    public function single($decodedId)
    {
        helper('payment');

        $response = ['success' => false, 'message' => '', 'data' => []];

        $country = getUserCountry();
        $paymentFirstLink = route_to('event_tickets_registration');
        $this->data['paymentFirstLink'] = $paymentFirstLink;
        // route_to('event_tickets_registration')

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

        $eventId = base64_decode($decodedId);
        if ($event = $this->eventMd->find($eventId)) {
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
            // return print_r($this->data);
            return view('Web/Events/single_event', $this->data);
        } else {
            return redirect()->route('events');
        }
    }

    public function eventRegistration()
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $payload = $this->request->getPost();

        $currency = $this->request->getPost('currency');

        $eventType = $this->request->getPost('event_type');

        $gateway = $this->request->getPost('gateway');

        if ($gateway == 'other') {
            $gateway = $this->request->getPost('othergateway');
        }

        $selectedPackages = array();
        $realAmountByPckages = 0;
        $realTicketsByPckages = 0;

        $payload['package'] = (array) $payload['package'];

        foreach ($payload['package'] as $package) {
            $thisPackage = (array) $package;
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

        if ($gateway == 'razorpay') {
            $singlePercent = $realAmountByPckages / 100;
            $taxGst = $singlePercent * 18;
            $realAmountByPckages = $realAmountByPckages + $taxGst;
        }

        $receipt = uniqidReal();

        $response['message'] = 'In-Valid Request.';

        $response['data'] = $payload;

        if ($realAmountByPckages == $payload['package_amount'] && $realTicketsByPckages == $payload['package_tickets']) {
            $ticketData = [
                'event_id' => $payload['event_id'],
                'event_type' => $eventType,
                'module_id' => $payload['module_id'],
                'ticket_ids' => $payload['package_tickets'],
                'receipt' => $receipt,
                'name' => $payload['name'],
                'email' => $payload['email'],
                'whatsapp' => $payload['whatsapp'],
                'mobile' => $payload['mobile'],
                'address' => $payload['address'],
                'country' => $payload['country'],
                'state' => $payload['state'],
                'city' => $payload['city'],
                'pin' => $payload['pincode'],
                'package_details' => json_encode($selectedPackages),
                'tickets' => $payload['package_tickets'],
                // 'order_id',
                'amount' => $payload['package_amount'],
                'gateway' => $gateway,
                // 'gateway_order_id',
                'payment_status' => 'initiated'
            ];
            $response['message'] = 'Unable to get you a ticket, please mail us on ' . getCustomerCare()['email'] . ' or call us on ' . getCustomerCare()['phone'];
            $response['data'] = $payload;

            $eventTicketDb = new EventTicketRegistration();
            $saveTicket = $eventTicketDb->save($ticketData);
            if ($saveTicket) {
                $thisTicket = $eventTicketDb->where('receipt', $receipt)->first();
                $localOrderData =  [
                    'receipt' => $receipt,
                    'amount' => $payload['package_amount'],
                    'product_information' => $selectedPackages,
                    'product_name' => 'Event Registration',
                    'user_name' => $payload['name'],
                    'user_email' => $payload['email'],
                    'user_phone' => $payload['mobile'],
                    'other_user_info' => array(
                        "whatsapp" => $payload['whatsapp'],
                        "address" => $payload['address'],
                        "country" => getWorldName($payload['country'], 'country'),
                        "state" => getWorldName($payload['state'], 'state'),
                        "city" => getWorldName($payload['city'], 'city'),
                        "pin" => $payload['pincode'],
                    ),
                    'type_of_action' => 'event_ticket',
                    'user_address' => $payload['address'],
                    'user_pincode' => $payload['pincode'],
                    'user_city' => $payload['city'],
                    'user_state' => $payload['state'],
                    'user_country' => $payload['country'],
                    'order_items' => 'event_ticket_registration'
                ];
                // if ($gateway == 'paypal') {
                if ($this->request->getPost('paypalOrderCreate')) {
                    $localOrderData = json_encode($localOrderData);
                    $localOrderData = json_decode($localOrderData, true);

                    // 100 PERCENT WORKING CODE OF PAYPAL RIGHT NOW
                    $paypalHelper = new PayPalHelper;
                    return json_encode($paypalHelper->orderCreate($localOrderData));
                }
                if ($gateway == 'razorpay') {
                    $localOrderData['tax_gst'] = $this->request->getPost('tax_gst');
                    $orderDb = new OrderModel();
                    $createOrder = $orderDb->razorpayCreateOrder($localOrderData);

                    $response['message'] = 'Unable to get you a ticket OR maybe your payment failed, please mail us on ' . getCustomerCare()['email'] . ' or call us on ' . getCustomerCare()['phone'];
                    $ticketDetails = array();
                    $ticketDetails['id'] = $thisTicket['id'];
                    if ($createOrder['success']) {
                        $ticketDetails['order_id'] = $createOrder['data']['order']['id'];
                        $ticketDetails['gateway_order_id'] = $createOrder['data']['response']['id'];
                        $ticketDetails['payment_status'] = 'processing';
                        $eventTicketDb->save($ticketDetails);

                        return json_encode($createOrder);
                    }
                    $thisTicket['payment_status'] = 'failed';
                    $eventTicketDb->save($thisTicket);
                }
                if ($gateway == 'stripe') {
                }

                // if ($eventType == 'festival') {
                // }
            }
        }

        return json_encode($response);
    }
}
