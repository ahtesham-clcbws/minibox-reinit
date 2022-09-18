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
        'type', // languages / writers / producers(dropdown-attr) / composers / Cinematographers / Editors / sound_mix(dropdown-name,dropdown-attr) / aspect_ratio(dropdown-name)
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
    public function getInfoDataWithCount($type, $unique_id, $start, $length, $stepValue)
    {
        $cache = cache();
        $currentTime = date('Y-m-d H:i:s');

        $query = $type . $unique_id . $start . $length;

        // $cache->save('cache_item_id', 'data_to_cache');
        // $foo = $cache->get('my_cached_item');
        $cache->delete('getInfoDataWithCount' . $query);
        $cache->delete('getInfoDataWithCountTime' . $query);

        if ($cache->get('getInfoDataWithCount' . $query)) {
            $date1 = date_create($cache->get('getInfoDataWithCountTime' . $query));
            $date2 = date_create($currentTime);
            $diff = date_diff($date1, $date2);
            if ($diff->h > 24) {
                $data = $this->getInfoDataWithCountCurrent($type, $unique_id, $start, $length, $stepValue);
                $cache->save('getInfoDataWithCount' . $query, $data);
                $cache->save('getInfoDataWithCountTime' . $query, $currentTime);
            } else {
                $data = $cache->get('getInfoDataWithCount' . $query);
            }
        } else {
            $data = $this->getInfoDataWithCountCurrent($type, $unique_id, $start, $length, $stepValue);
            $cache->save('getInfoDataWithCount' . $query, $data);
            $cache->save('getInfoDataWithCountTime' . $query, $currentTime);
        }

        return $data;
    }
    private function getInfoDataWithCountCurrent($type, $unique_id, $start, $length, $stepValue)
    {
        $infoList = $this->select('id, movie_id, name, attribute, type');
        $infoList = $infoList->where(['type' => $type, 'movie_id' => $unique_id]);
        if (intval($start) && intval($start) > 0) {
            $infoList = $infoList->offset($start);
        }
        if ($length != null && intval($length) && intval($length) > 0) {
            $infoList = $infoList->findAll($length);
        } else {
            $infoList = $infoList->findAll();
        }
        foreach ($infoList as $key => $listItem) {
            $itemId = $listItem['id'];
            $itemName = $listItem['name'];
            $itemAttr = $listItem['attribute'];

            if ($stepValue != 'locked') {
                $infoList[$key]['actions'] = '<div class="uk-button-group"><button class="addButton uk-button uk-button-secondary uk-button-small" onclick="addInfoItem(';
                $infoList[$key]['actions'] .= "'" . $type . "',";
                $infoList[$key]['actions'] .= "true,";
                $infoList[$key]['actions'] .= "'" . $itemId . "',";
                $infoList[$key]['actions'] .= "'" . $itemName . "',";
                $infoList[$key]['actions'] .= "'" . $itemAttr . "')";
                $infoList[$key]['actions'] .= '" title="Edit"><span uk-icon="icon: file-edit;"></span></button><button class="deleteButton uk-button uk-button-danger uk-button-small" onclick="deleteInfoItem(';
                $infoList[$key]['actions'] .= "'" . $type . "',";
                $infoList[$key]['actions'] .= "'" . $itemId . "'";
                $infoList[$key]['actions'] .= ')" title="Delete"><span uk-icon="icon: trash;"></span></button></div>';
            }
        }
        $infoListCount = $this->where(['type' => $type, 'movie_id' => $unique_id])->countAllResults();
        $data = [
            "list" => $infoList,
            "count" => count($infoList),
            "countAll" => $infoListCount,
        ];
        return $data;
    }
}
