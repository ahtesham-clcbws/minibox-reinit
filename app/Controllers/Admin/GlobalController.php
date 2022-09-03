<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class GlobalController extends BaseController
{
    protected $data;
    public function __construct()
    {
        $this->data = [];
        $this->data['optionalJs'] = false;
    }
    public function index()
    {
        // return print_r(session()->get('user'));
        $this->data['dashboard'] = true;
        return view('Admin/Pages/dashboard', $this->data);
    }
}
