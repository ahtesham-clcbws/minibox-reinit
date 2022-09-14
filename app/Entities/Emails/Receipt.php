<?php

namespace App\Entities\Emails;

use CodeIgniter\Entity\Entity;

class Receipt extends Entity
{
    protected $attributes = [
        'currency' => null,
        'type_of_action' => null,
        'user_name' => null,
        'user_address' => null,
        'receipt_number' => null,
        'items' => null,
        'taxes' => null,
        'total' => null,
        'link' => null,
        'email_view' => null
    ];
    protected $datamap = [];
    // protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'currency' => 'string',
        'type_of_action' => 'string',
        'user_name' => 'string',
        'user_address' => 'string',
        'receipt_number' => 'string',
        'items' => 'array',
        'taxes' => 'array',
        'total' => 'string',
        'link' => 'string',
        'email_view' => 'boolean'
    ];





    // $data['currency'] = 'INR';
    // $data['type_of_action'] = 'Registration';

    // $data['user_name'] = 'Chaudhary Ahtesham';
    // $data['user_address'] = '143/3, 4th floor, Zakir Nagar, Jamia Nagar, New Delhi, 110025';
    // $data['type_of_action'] = 'Delegate Registration';

    // // if ($type == 'receipt') {
    // $data['receipt_number'] = strtoupper('77d7ac4daabc8');
    // $data['items'] = array(
    //     array(
    //         'name' => 'Ticket details',
    //         'amount' => number_to_currency(2000, $currency, 'en_US', 2)
    //     ),
    //     array(
    //         'name' => 'Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ ',
    //         'amount' => number_to_currency(800, $currency, 'en_US', 2)
    //     )
    // );
    // $data['taxes'] = array(
    //     'name' => 'GST 18%',
    //     'amount' => number_to_currency(504, $currency, 'en_US', 2)
    // );
    // $data['total'] = number_to_currency(3304, $currency, 'en_US', 2);
    // $data['email_view'] = false;
}
