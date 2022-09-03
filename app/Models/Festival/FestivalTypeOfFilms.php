<?php

namespace App\Models\Festival;

use App\Models\AwardsModel;
use CodeIgniter\Model;

class FestivalTypeOfFilms extends Model
{
    protected $table            = 'festival_type_of_films';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'type',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getAllTypes()
    {
        $allTypes =  $this->findAll();
        return $allTypes;
    }
    public function getAllTypesWithAwardsWhereAwardsNotNull()
    {
        $allTypes =  $this->where('award_ids !=', null)->findAll();
        // return $allTypes;
        foreach ($allTypes as $key => $value) {
            if ($value['award_ids']) {
                $awardsIds = json_decode($value['award_ids']);
                $awardDb = new AwardsModel();
                $allTypes[$key]['awards'] = $awardDb->distinct()
                    ->select('award_categories.short_name as sn, award_categories.name as main_name, awards.*')
                    ->join('award_categories', 'award_categories.id = awards.category_id')
                    ->whereIn('awards.id', $awardsIds)->findAll();
            }
        }
        return $allTypes;
    }
    public function getAllTypesWithAwardsByIds($idArrays)
    {
        $allTypes =  $this->select('id, name, award_ids')->whereIn('id', $idArrays)->findAll();
        // return $allTypes;
        foreach ($allTypes as $key => $value) {
            if ($value['award_ids']) {
                $awardsIds = json_decode($value['award_ids']);
                $awardDb = new AwardsModel();
                $allTypes[$key]['awards'] = $awardDb->distinct()
                    ->select('award_categories.short_name as sn, award_categories.name as main_name, awards.id, awards.name, awards.category_id')
                    ->join('award_categories', 'award_categories.id = awards.category_id')
                    ->whereIn('awards.id', $awardsIds)->findAll();
            }
        }
        return $allTypes;
    }
    public function getTypeById($id)
    {
        $allTypes =  $this->find($id);
        return $allTypes;
    }
}
