<?php

namespace App\Models\Common;

use CodeIgniter\Model;

class LanguagesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'languages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'code',
        'name',
        'native_name',
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

    public function getAllLanguages()
    {
        $cache = cache();
        $cache->delete('allLanguages');
        $cachedCLanguages   = cache('allLanguages');
        $allLanguages = array();
        if ($cachedCLanguages) {
            $allLanguages = $cachedCLanguages;
        } else {
            $allLanguages = $this->select('id, code, name, native_name')->where('status', '1')->findAll();
        }
        return $allLanguages;
    }
}
