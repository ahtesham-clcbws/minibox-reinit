<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UsersController extends BaseController
{
    protected $data;
    protected $userDb;
    public function __construct()
    {
        $this->data = [];
        $this->userDb = new UserModel();
    }
    public function index()
    {
        //
    }
    public function addUser()
    {
        $response = ['success' => false, 'message' => '', 'data' => []];
        helper('form', 'url');
        $requestedUserData = $this->request->getVar();
        $userData = [
            'first_name' => $requestedUserData['first_name'],
            'last_name' => $requestedUserData['last_name'],
            'email' => $requestedUserData['email'],
            'mobile' => $requestedUserData['mobile']
        ];
        if (isset($requestedUserData['status']) && !empty($requestedUserData['status'])) {
            $userData['status'] = $requestedUserData['status'] == 1 ? 'verified' : 'pending';
            $userData['status'] = $requestedUserData['status'];
        }
        if (isset($requestedUserData['profession']) && !empty(trim($requestedUserData['profession']))) {
            $userData['profession'] = $requestedUserData['profession'];
        }
        if (isset($requestedUserData['about']) && !empty(trim($requestedUserData['about']))) {
            $userData['about'] = $requestedUserData['about'];
        }
        if (isset($requestedUserData['password']) && !empty(trim($requestedUserData['password']))) {
            $userData['password'] = createPassword($requestedUserData['password']);
        }

        // first check whether the user Already.
        $checkUser = $this->userDb->where('email', $userData['email'])->first();
        if ($checkUser) {
            $response['message'] = 'User email already exists';
            $response['data'] = $checkUser;
        } else {
            $checkUser = $this->userDb->where('mobile', $userData['mobile'])->first();
            if ($checkUser) {
                $response['message'] = 'User mobile already exists';
                $response['data'] = $checkUser;
            } else {
                if ($img = $this->request->getFile('profile_pic')) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('uploads/profile_pic', $newName);
                        $picPath = '/uploads/profile_pic/' . $newName;
                        $userData['profile_pic'] = $picPath;
                    }
                }
                $userSave = $this->userDb->save($userData);
                if ($userSave) {
                    $response['message'] = 'User saved succesfully.';
                    $userId = $this->userDb->insertID();
                    $response['data'] = $userId;
                    $response['success'] = true;
                    if (isset($requestedUserData['team_type'])) {
                        $teamMember = [
                            'user_id' => $userId,
                            'role' => $requestedUserData['team_type'],
                            'festival_id' => $requestedUserData['festival_id'],
                            'festival_year' => $requestedUserData['festival_year']
                        ];
                        // $teamDb = new FestivalTeamModel();
                        // $teamSave = $teamDb->save($teamMember);
                        // if ($teamSave) {
                        //     $response['message'] = 'Team saved succesfully.';
                        //     $response['data'] = $teamSave;
                        //     $response['success'] = true;
                        // }
                    }
                }
            }
        }
        return json_encode($response);
    }
}
