<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\Events\Events;
use App\Models\Events\EventsContacts;
use App\Models\Events\EventsTickets;
use DateTime;

class EventsController extends BaseController
{
    protected $data;
    protected $eventMd;

    public function __construct()
    {
        $this->data = [];
        $this->data['optionalJs'] = false;
        $this->data['loadSelect2'] = false;

        $this->data['paymentAssets'] = false;
        $this->eventMd = new Events();
    }
    public function index()
    {
        // load all events
        return view('Web/Events/index', $this->data);
    }
    public function single($decodedId)
    {
        $this->data['paymentAssets'] = true;
        $country = getUserCountry();
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
}
