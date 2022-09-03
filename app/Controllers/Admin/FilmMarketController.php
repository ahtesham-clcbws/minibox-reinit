<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class FilmMarketController extends BaseController
{
    protected $data;
    public function __construct()
    {
        $this->data = [];
        $this->data['optionalJs'] = false;
        $this->data['pagename'] = 'Film Market';
    }
    public function index()
    {
        //
    }
}
