<?php

namespace App\Models;

use CodeIgniter\Model;

class AwardsCategoryModel extends Model
{
    protected $table            = 'award_categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'image',
        'name',
        'short_name',
        'short_student_inr',
        'short_student_eur',
        'short_professional_inr',
        'short_professional_eur',
        'feature_student_inr',
        'feature_student_eur',
        'feature_professional_inr',
        'feature_professional_eur'
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


    public function isShortNameUnique($shortName, $id = 0)
    {
        $whereNotIn = [$id];
        if($this->where('short_name', $shortName)->whereNotIn('id', $whereNotIn)->first()) {
            return false;
        }
        return true;
    }
}
