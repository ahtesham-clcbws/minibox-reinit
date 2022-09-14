<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class StoreController extends BaseController
{
    public function __construct()
    {
        $this->data['pagename'] = 'Store';
    }
    public function index()
    {
        //
    }
}
