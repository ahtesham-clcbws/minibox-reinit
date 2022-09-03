<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class PrimWatchController extends BaseController
{
    protected $data;
    public function __construct()
    {
        $this->data = [];
        $this->data['optionalJs'] = false;
        $this->data['pagename'] = 'Prime Watch';
    }
    public function index()
    {
        //
    }
}
