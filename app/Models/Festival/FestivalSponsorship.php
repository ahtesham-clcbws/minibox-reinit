<?php

namespace App\Models\Festival;

use CodeIgniter\Model;

class FestivalSponsorship extends Model
{
    protected $table            = 'festival_sponsorship';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'festival_id',
        'title',
        'content',
        'icon1',
        'icon_title1',
        'icon_content1',
        'icon2',
        'icon_title2',
        'icon_content2',
        'icon3',
        'icon_title3',
        'icon_content3',
        'icon4',
        'icon_title4',
        'icon_content4',
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
