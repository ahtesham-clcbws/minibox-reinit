<?php

namespace App\Models\Festival;

use CodeIgniter\Model;

class FestivalJury extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'festival_juries';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'festival_id',
        'festival_year',
        'first_name',
        'last_name',
        'profession',
        'image',
        'about',
        'email',
        'mobile',
        'facebook',
        'twitter',
        'instagram',
        'whatsapp',
        'title',
        'content',
        'video',
        'gallery'
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
