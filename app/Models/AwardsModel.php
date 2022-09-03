<?php

namespace App\Models;

use CodeIgniter\Model;

class AwardsModel extends Model
{
    protected $table            = 'awards';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id',
        'name',
        'isShort',
        'isFeature',
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

    public function getAllAwardsByMain($category_id)
    {
        return $this->where('category_id', $category_id)->orderBy('name', 'ASC')->findAll();
    }
    public function getAwardsWithCategory()
    {
        return $this->distinct()->select('awards.*, award_categories.name AS award_category, award_categories.id AS award_category_id')
        ->join('award_categories', 'award_categories.id = awards.category_id')
        ->orderBy('id', 'desc')
        ->findAll();
    }

    public function getAllAwardsInAdmin()
    {
        $awardsCategoriesDb = new AwardsCategoryModel();
        $select = 'id,image,name,short_name,short_student_inr,short_student_eur,short_professional_inr,short_professional_eur,feature_student_inr,feature_student_eur,feature_professional_inr,feature_professional_eur';
        $allAwardsCategory = $awardsCategoriesDb->select($select)->findAll();
        // foreach ($allAwardsCategory as $key => $cat) {
        //     $allAwardsCategory[$key]['awards'] = $this->where('category_id', $cat['id'])->orderBy('name', 'ASC')->findAll();
        // }
        return $allAwardsCategory;
    }
    public function getAwardCatById($id)
    {
        $awardsCategoriesDb = new AwardsCategoryModel();
        return $awardsCategoriesDb->find($id);
    }
    public function getAwardById($id)
    {
        return $this->find($id);
    }
}
