<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Events\Events;
use App\Models\Events\EventsCategory;
use App\Models\Events\EventsContacts;
use App\Models\Events\EventsContactSubmitions;
use App\Models\Events\EventsTickets;
use App\Models\Festival\FestivalModel;

class EventsController extends BaseController
{
    public function __construct()
    {
        $this->data['pagename'] = 'Events';
    }
    public function add()
    {
        $response = ['success' => false, 'message' => '', 'data' => []];
        $this->data['pagename'] = 'Add Event';

        if ($this->request->getPost()) {
            if ($this->request->getPost('getmoduleData')) {
                $type = $this->request->getPost('getmoduleData');
                $moduleData = array();
                if ($type == 'festival') {
                    $festivalDb = new FestivalModel();
                    $moduleData = $festivalDb->select('id, name')->orderBy('name', 'asc')->findAll();
                }
                if (count($moduleData)) {
                    $response['data'] = $moduleData;
                    $response['success'] = true;
                } else {
                    $response['message'] = 'unable to find data';
                    $response['success'] = false;
                }
            }
            if ($this->request->getPost('addEvent')) {
                $postData = $this->request->getPost();
                if ($postData['google_map']) {
                    $mapUrl = $this->request->getPost('google_map');
                    $longlat = $this->getCoordinatesAttribute($mapUrl);
                    $postData['latitude'] = $longlat['lat'];
                    $postData['longitude'] = $longlat['long'];
                }
                $postData['content'] = htmlentities($postData['content']);
                $mediaIsValid = true;
                // return json_encode($postData);

                if ($img = $this->request->getFile('image')) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $dateYear = date('Y');
                        $dateMonth = date('F');
                        $path = 'uploads/event/' . $dateYear . '/' . $dateMonth;
                        $img->move($path, $newName);
                        $mediaPath = '/' . $path . '/' . $newName;
                        $postData['image'] = $mediaPath;
                        $mediaIsValid = true;
                    } else {
                        $mediaIsValid = false;
                    }
                } else {
                    $mediaIsValid = false;
                }

                if (!$mediaIsValid) {
                    $response['message'] = 'Please select an image before adding new data.';
                    $response['success'] = false;
                    return json_encode($response);
                }
                $eventDb = new Events();
                if ($inertId = $eventDb->getInsertID($eventDb->save($postData))) {
                    $response['message'] = 'Data Added succesfully';
                    $response['success'] = true;
                    $response['data'] =  route_to('admin_event_update', $inertId);
                } else {
                    $response['message'] = 'Unable to add data, please try after some time.';
                    $response['success'] = false;
                }
            }
            return json_encode($response);
        }

        $catDb = new EventsCategory();
        $categories = $catDb->orderBy('id', 'desc')->findAll();
        $this->data['categories'] = $categories;

        return view('Admin/Pages/events/add', $this->data);
    }
    public function categories()
    {
        $this->data['pagename'] = 'Event Categories';
        $response = ['success' => false, 'message' => '', 'data' => []];
        $entityDb = new EventsCategory();
        if ($this->request->getPost()) {
            if ($this->request->getPost('addUpdate')) {
                $dataToUpload = array(
                    'name' => $this->request->getPost('name')
                );
                if ($this->request->getPost('id') !== 0 || $this->request->getPost('id') > 0) {
                    $dataToUpload['id'] = $this->request->getPost('id');
                }
                if ($entityDb->save($dataToUpload)) {
                    $response['message'] = 'Added';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'unable to add data';
                    $response['success'] = false;
                }
            }
            if ($this->request->getPost('deleteData')) {
                if ($entityDb->delete($this->request->getPost('id'))) {
                    $response['message'] = 'Deleted';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'unable to delete data.';
                    $response['success'] = false;
                }
            }
            return json_encode($response);
        }
        $entities = $entityDb->orderBy('id', 'desc')->findAll();
        $eventsDb = new Events();
        foreach ($entities as $eKey => $entity) {
            $entities[$eKey]['events'] = $eventsDb->where('category', $entity['id'])->countAllResults();
        }
        $this->data['entities'] = $entities;
        return view('Admin/Pages/events/categories', $this->data);
    }
    public function contacts()
    {
        $response = ['success' => false, 'message' => '', 'data' => []];
        $this->data['pagename'] = 'Event Contacts';
        $entityDb = new EventsContacts();
        // only global contacts
        if ($this->request->getPost()) {
            if ($this->request->getPost('addContact')) {
                $dataToUpload = array(
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                    'whatsapp' => $this->request->getPost('whatsapp')
                );
                if ($this->request->getPost('id') !== 0 || $this->request->getPost('id') > 0) {
                    $dataToUpload['id'] = $this->request->getPost('id');
                }
                if ($entityDb->save($dataToUpload)) {
                    $response['message'] = 'Added';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'unable to add data';
                    $response['success'] = false;
                }
            }
            if ($this->request->getPost('deleteContact')) {
                if ($entityDb->delete($this->request->getPost('id'))) {
                    $response['message'] = 'Deleted';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'unable to delete data.';
                    $response['success'] = false;
                }
            }
            return json_encode($response);
        }
        $contacts = $entityDb->where('type', 'global')->orderBy('id', 'desc')->findAll();
        $this->data['contacts'] = $contacts;

        return view('Admin/Pages/events/contacts', $this->data);
    }
    public function details($id)
    {
        $eventDb = new Events();
        if ($event = $eventDb->find($id)) {
            $this->data['event_id'] = $id;
            $this->data['event'] = $event;
            $response = ['success' => false, 'message' => '', 'data' => []];
            $this->data['pagename'] = 'Event Details';
            if ($event['type'] == 'festival') {
                $festivalDb = new FestivalModel();
                $festivalData = $festivalDb->select('id, name')->orderBy('title', 'asc')->findAll();
                $this->data['festivalData'] = $festivalData;
            }
            $this->data['statesData'] = getStatesByCountryId($event['country']);
            $this->data['cityData'] = getCitiesByStateId($event['state']);

            $ticketsDB = new EventsTickets();
            $tickets = $ticketsDB->where(['type' => 'event', 'event_id' => $id])->orderBy('id', 'desc')->findAll();
            $this->data['tickets'] = $tickets;

            $globalTickets = $ticketsDB->where(['type' => 'global'])->orderBy('id', 'desc')->findAll();
            $this->data['globalTickets'] = $globalTickets;

            $contactsDb = new EventsContacts();
            $contacts = $contactsDb->where(['type' => 'event', 'event_id' => $id])->orderBy('id', 'desc')->findAll();
            $this->data['contacts'] = $contacts;

            $globalContacts = $contactsDb->where(['type' => 'global'])->orderBy('id', 'desc')->findAll();
            $this->data['globalContacts'] = $globalContacts;

            if ($this->request->getPost()) {
                if ($this->request->getPost('getmoduleData')) {
                    $type = $this->request->getPost('getmoduleData');
                    $moduleData = array();
                    if ($type == 'festival') {
                        $festivalDb = new FestivalModel();
                        $moduleData = $festivalDb->select('id, name')->orderBy('title', 'asc')->findAll();
                    }
                    if (count($moduleData)) {
                        $response['data'] = $moduleData;
                        $response['success'] = true;
                    } else {
                        $response['message'] = 'unable to find data';
                        $response['success'] = false;
                    }
                }
                if ($this->request->getPost('addEvent')) {
                    $postData = $this->request->getPost();
                    $postData['id'] = $id;
                    if ($postData['google_map']) {
                        $mapUrl = $this->request->getPost('google_map');
                        $longlat = $this->getCoordinatesAttribute($mapUrl);
                        $postData['latitude'] = $longlat['lat'];
                        $postData['longitude'] = $longlat['long'];
                    }
                    $postData['content'] = htmlentities($postData['content']);

                    if ($img = $this->request->getFile('image')) {
                        if ($img->isValid() && !$img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $dateYear = date('Y');
                            $dateMonth = date('F');
                            $path = 'uploads/event/' . $dateYear . '/' . $dateMonth;
                            $img->move($path, $newName);
                            $mediaPath = '/' . $path . '/' . $newName;
                            $postData['image'] = $mediaPath;
                        }
                    }
                    if ($eventDb->save($postData)) {
                        $response['message'] = 'Data Updated succesfully';
                        $response['success'] = true;
                    } else {
                        $response['message'] = 'Unable to update data, please try after some time.';
                        $response['success'] = false;
                    }
                }
                if ($this->request->getPost('addTicket')) {
                    $dataToUpload = array(
                        'inr' => $this->request->getPost('inr'),
                        'eur' => $this->request->getPost('eur'),
                        'details' => $this->request->getPost('details'),
                        'type' => 'event',
                        'event_id' => $id
                    );
                    if ($this->request->getPost('id') !== 0 || $this->request->getPost('id') > 0) {
                        $dataToUpload['id'] = $this->request->getPost('id');
                    }
                    if ($ticketsDB->save($dataToUpload)) {
                        $response['message'] = 'Added';
                        $response['success'] = true;
                    } else {
                        $response['message'] = 'unable to add data';
                        $response['success'] = false;
                    }
                }
                if ($this->request->getPost('copyTicket')) {
                    $newTicket = $ticketsDB->find($this->request->getPost('copyTicket'));
                    if ($newTicket) {
                        $dataToUpload = array(
                            'inr' => $newTicket['inr'],
                            'eur' => $newTicket['eur'],
                            'details' => $newTicket['details'],
                            'type' => 'event',
                            'event_id' => $id
                        );
                        if ($ticketsDB->save($dataToUpload)) {
                            $response['message'] = 'Added';
                            $response['success'] = true;
                        } else {
                            $response['message'] = 'unable to add data';
                            $response['success'] = false;
                        }
                    } else {
                        $response['message'] = 'unable to find copied ticket, please create new one manually.';
                        $response['success'] = false;
                    }
                }
                if ($this->request->getPost('deleteTicket')) {
                    if ($ticketsDB->delete($this->request->getPost('id'))) {
                        $response['message'] = 'Deleted';
                        $response['success'] = true;
                    } else {
                        $response['message'] = 'unable to delete data.';
                        $response['success'] = false;
                    }
                }
                if ($this->request->getPost('addContact')) {
                    $dataToUpload = array(
                        'name' => $this->request->getPost('name'),
                        'email' => $this->request->getPost('email'),
                        'phone' => $this->request->getPost('phone'),
                        'whatsapp' => $this->request->getPost('whatsapp')
                    );
                    if ($this->request->getPost('id') !== 0 || $this->request->getPost('id') > 0) {
                        $dataToUpload['id'] = $this->request->getPost('id');
                    }
                    if ($contactsDb->save($dataToUpload)) {
                        $response['message'] = 'Added';
                        $response['success'] = true;
                    } else {
                        $response['message'] = 'unable to add data';
                        $response['success'] = false;
                    }
                }
                if ($this->request->getPost('deleteContact')) {
                    if ($contactsDb->delete($this->request->getPost('id'))) {
                        $response['message'] = 'Deleted';
                        $response['success'] = true;
                    } else {
                        $response['message'] = 'unable to delete data.';
                        $response['success'] = false;
                    }
                }
                if ($this->request->getPost('copyContact')) {
                    $newContact = $contactsDb->find($this->request->getPost('copyContact'));
                    if ($newContact) {
                        $dataToUpload = array(
                            'name' => $newContact['name'],
                            'email' => $newContact['email'],
                            'phone' => $newContact['phone'],
                            'whatsapp' => $newContact['whatsapp'],
                            'type' => 'event',
                            'event_id' => $id
                        );
                        if ($contactsDb->save($dataToUpload)) {
                            $response['message'] = 'Added';
                            $response['success'] = true;
                        } else {
                            $response['message'] = 'unable to add data';
                            $response['success'] = false;
                        }
                    } else {
                        $response['message'] = 'unable to find copied contact, please create new one manually.';
                        $response['success'] = false;
                    }
                }
                return json_encode($response);
            }

            $catDb = new EventsCategory();
            $categories = $catDb->orderBy('id', 'desc')->findAll();
            $this->data['categories'] = $categories;

            // return print_r($this->data);

            return view('Admin/Pages/events/details', $this->data);
        } else {
            return redirect()->route('admin_events');
        }
    }
    // details
    public function index()
    {
        $eventDb = new Events();
        $response = ['success' => false, 'message' => '', 'data' => []];
        $events = $eventDb->distinct()
            ->select('events.id, events.title, events.from_date, events.to_date, events.type, events.module_id, events_categories.name as categoryName, states.name as stateName')
            ->join('events_categories', 'events_categories.id = events.category')
            ->join('states', 'states.id = events.state')
            ->orderBy('events.id', 'desc')->findAll();
        foreach ($events as $key => $event) {
            $festivalDb = new FestivalModel();
            if ($event['type'] == 'festival') {
                $events[$key]['festival_name'] = 'N/A';
                $festival = $festivalDb->find($event['module_id']);
                if ($festival) {
                    $events[$key]['festival_name'] = $festival['name'];
                }
            }
        }
        $this->data['events'] = $events;
        // return print_r($this->data);
        if ($this->request->getPost()) {
            if ($this->request->getPost('deleteEvent')) {
                if ($eventDb->delete($this->request->getPost('deleteEvent'))) {
                    $response['message'] = 'Deleted';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'unable to delete data.';
                    $response['success'] = false;
                }
            }
            return json_encode($response);
        }
        return view('Admin/Pages/events/index', $this->data);
    }
    public function messages()
    {
        $response = ['success' => false, 'message' => '', 'data' => []];
        return view('Admin/Pages/events/messages', $this->data);
    }
    public function tickets()
    {
        $response = ['success' => false, 'message' => '', 'data' => []];
        $this->data['pagename'] = 'Event Tickets';
        $entityDb = new EventsTickets();
        // only global tickets
        if ($this->request->getPost()) {
            if ($this->request->getPost('addTicket')) {
                $dataToUpload = array(
                    'inr' => $this->request->getPost('inr'),
                    'eur' => $this->request->getPost('eur'),
                    'details' => $this->request->getPost('details')
                );
                if ($this->request->getPost('id') !== 0 || $this->request->getPost('id') > 0) {
                    $dataToUpload['id'] = $this->request->getPost('id');
                }
                if ($entityDb->save($dataToUpload)) {
                    $response['message'] = 'Added';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'unable to add data';
                    $response['success'] = false;
                }
            }
            if ($this->request->getPost('deleteTicket')) {
                if ($entityDb->delete($this->request->getPost('id'))) {
                    $response['message'] = 'Deleted';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'unable to delete data.';
                    $response['success'] = false;
                }
            }
            return json_encode($response);
        }
        $tickets = $entityDb->where('type', 'global')->orderBy('id', 'desc')->findAll();
        $this->data['tickets'] = $tickets;
        return view('Admin/Pages/events/tickets', $this->data);
    }

    private function getCoordinatesAttribute($url)
    {
        $url_coordinates_position = strpos($url, '@') + 1;
        $coordinates = [];

        if ($url_coordinates_position != false) {
            $coordinates_string = substr($url, $url_coordinates_position);
            $coordinates_array = explode(',', $coordinates_string);

            if (count($coordinates_array) >= 2) {
                $longitude = $coordinates_array[0];
                $latitude = $coordinates_array[1];

                $coordinates = [
                    "lat" => $longitude,
                    "long" => $latitude
                ];
            }

            return $coordinates;
        }

        return $coordinates;
    }
}
