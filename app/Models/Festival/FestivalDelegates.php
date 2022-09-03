<?php

namespace App\Models\Festival;

use CodeIgniter\Model;

class FestivalDelegates extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'festival_delegates';
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
        'movie_name',
        'email',
        'whatsapp',
        'mobile',
        'organization',
        'address',
        'country',
        'state',
        'city',
        'pin',
        'package_details',
        'ticket_details',
        'order_id',
        'amount',
        'gateway_order_id',
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
}
