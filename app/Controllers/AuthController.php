<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userDb;
    public function __construct()
    {
        $this->userDb = new UserModel();
    }
    public function register()
    {
        if ($this->request->getPost('register')) {
        }
        return view('Auth/register', $this->data);
    }
    public function login()
    {
        if ($this->request->getPost('login')) {
            // echo 'form submit';
            // return;
            $isAjax = $this->request->getVar('isAjax') || $this->request->isAJAX();
            $requestFrom = $this->request->getVar('requestFrom');
            $requestGoBack = $this->request->getVar('requestGoBack');

            $loginResponse = user_login($this->request->getVar('email'), $this->request->getVar('password'));

            // return print_r($loginResponse);
            if ($isAjax) {
                return json_encode($loginResponse);
            }

            if (!$loginResponse['success']) {
                $sessionData = [
                    'loginError' => $loginResponse['message']
                ];
                session()->setFlashdata($sessionData);
                return redirect()->back();
            } else {
                // return print_r($loginResponse);
                $user = $loginResponse['user_data'];
                if ($requestGoBack) {
                    return redirect()->to($requestFrom);
                } else {
                    if (in_array($user['role'], ['admin', 'staff'])) {
                        return redirect()->route('admin_index');
                    } else {
                        return redirect()->route('homepage');
                    }
                }
            }
        }
        return view('Auth/login', $this->data);
    }
    public function forget()
    {
        if ($this->request->getPost('forget')) {
        }
        return view('Auth/forget', $this->data);
    }
    public function recover()
    {
        if ($this->request->getPost('recover')) {
        }
        return view('Auth/recover', $this->data);
    }
    public function logout()
    {
        session()->destroy();
        // echo 'session destroyed';
        // return;
        return redirect()->route('login');
    }
}
