<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'password',
        'profile_pic',
        'token',
        'about',
        'profession',
        'device', //['web', 'android', 'ios', 'others']
        'role', //['user', 'admin', 'staff']
        'module', //['default', 'super', 'festival', 'market', 'incubator', 'filmzine', 'primewatch',  'primekids',  'store', 'management']
        'permissions', //['view', 'add', 'edit', 'delete', 'all']
        'email_status', //['verified', 'pending', 'rejected']
        'mobile_status', //['verified', 'pending', 'rejected']
        'text_status', //['verified', 'pending', 'rejected']
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function addUser($data)
    {
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'role' => $data['role'],
            'text_status' => $data['status'] == 1 ? 'verified' : 'pending',
            'status' => $data['status'],
        ];
        if ($data['profession']) {
            $userData['profession'] = $data['profession'];
        }
        if ($data['about']) {
            $userData['about'] = $data['about'];
        }
        if ($data['password']) {
            $userData['password'] = createPassword($data['password']);
        }
        if ($img = $this->request->getFile('profile_pic')) {
            if ($img->isValid() && !$img->hasMoved()) {
                $newName = $img->getRandomName();
                $img->move('uploads/profile_pic', $newName);
                $picPath = '/uploads/profile_pic/' . $newName;
                $userData['profile_pic'] = $picPath;
            }
        }
        return $userData;
    }
}
