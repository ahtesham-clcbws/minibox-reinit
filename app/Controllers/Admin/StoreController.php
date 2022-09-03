<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class StoreController extends BaseController
{
    protected $data;
    public function __construct()
    {
        $this->data = [];
        $this->data['optionalJs'] = false;
        $this->data['pagename'] = 'Store';
    }
    public function index()
    {
        //
    }
}
