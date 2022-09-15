<?php

namespace App\Models\Films;

use CodeIgniter\Model;

class OtherInfoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'films_other_infos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'movie_id', // unique_id
        'type', // languages / writers / producers(dropdown-attr) / composers / Cinematographers / Editors / sound_mix / aspect_ratio / 
        'name',
        'attribute'
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

    public function getAllinfoGroup($id)
    {
        $types = $this->select('type')->groupBy('type')->findAll();
        // return $allTypes;
        $groupData = array();
        foreach ($types as $key => $type) {
            $data = [
                'type' => $type['type'],
                'values' => $this->select('name, attribute')->where(['type' => $type['type'], 'movie_id' => $id])->findAll()
            ];
            array_push($groupData, $data);
        }
        return $groupData;
    }
    public function getAllinfoByType($id, $type)
    {
        return $this->select('name, attribute')->where(['type' => $type, 'movie_id' => $id])->findAll();
    }
}
