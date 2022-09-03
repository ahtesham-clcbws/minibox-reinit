<?php

namespace App\Models\Festival;

use CodeIgniter\Model;

class FestivalVolunteer extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'festival_volunteers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'festival_id',
        'festival_year',
        'name',
        'email',
        'whatsapp',
        'mobile',
        'address',
        'country',
        'state',
        'city',
        'pin'
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
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = ['afterInsertAdminEmail'];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];

    // private function afterInsertAdminEmail(array $data) {
    //     $name = $data['data']['name'];
    //     $email = $data['data']['email'];
    // }
}
