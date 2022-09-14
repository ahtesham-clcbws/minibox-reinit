<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CommonController extends BaseController
{
    public function index()
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        if ($this->request->getPost('getStatesByCountryId')) {
            $data = getStatesByCountryId($this->request->getPost('id'));
            if ($data) {
                $response['message'] = 'Data Found';
                $response['success'] = true;
                $response['data'] = $data;
            } else {
                $response['message'] = 'Unable to find data, please try after some time.';
                $response['success'] = false;
            }
            return json_encode($response);
        }
        if ($this->request->getPost('getCitiesByCountryId')) {
            $data = getCitiesByCountryId($this->request->getPost('id'));
            if ($data) {
                $response['message'] = 'Data Found';
                $response['success'] = true;
                $response['data'] = $data;
            } else {
                $response['message'] = 'Unable to find data, please try after some time.';
                $response['success'] = false;
            }
            return json_encode($response);
        }
        if ($this->request->getPost('getCitiesByStateId')) {
            $data = getCitiesByStateId($this->request->getPost('id'));
            if ($data) {
                $response['message'] = 'Data Found';
                $response['success'] = true;
                $response['data'] = $data;
            } else {
                $response['message'] = 'Unable to find data, please try after some time.';
                $response['success'] = false;
            }
            return json_encode($response);
        }
    }

}
