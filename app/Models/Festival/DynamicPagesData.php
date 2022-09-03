<?php

namespace App\Models\Festival;

use CodeIgniter\Model;

class DynamicPagesData extends Model
{
    protected $table            = 'dynamicpagesdatas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'festival_id',
        'team_title',
        'team_content',
        'volunteer_title',
        'volunteer_content',
        'schedule_title',
        'schedule_content',
        'delegate_title',
        'delegate_content',
        'support_title',
        'support_content',
        'winners_title',
        'winners_content',
        'entry_form_title',
        'entry_form_content',
        'official_selection_title',
        'official_selection_content',
        'jury_title',
        'jury_content',
        'gallery_title',
        'gallery_content',
        'filmmakers_title',
        'filmmakers_content',
        'knowledge_center_title',
        'knowledge_center_content',
        'press_title',
        'press_content',
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
