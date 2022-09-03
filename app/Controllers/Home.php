<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $data;
    public function __construct()
    {
        $this->data = [];
        $this->data['optionalJs'] = false;
    }
    public function index()
    {
        $this->data['optionalJs'] = true;
        // print_r(json_encode(getUri()->getSegment(1)));
        // return view('welcome_message');
        return view('Web/homepage', $this->data);
    }
}
