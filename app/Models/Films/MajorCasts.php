<?php

namespace App\Models\Films;

use CodeIgniter\Model;

class MajorCasts extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'films_major_casts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'movie_id', // unique_id
        'image', // 100x100 only
        'name',
        'gender',
        'cast_character',
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


    public function getCastesWithCount($unique_id, $start, $length, $stepValue)
    {
        $cache = cache();
        $currentTime = date('Y-m-d H:i:s');

        $query = $unique_id . $start . $length;

        // $cache->save('cache_item_id', 'data_to_cache');
        // $foo = $cache->get('my_cached_item');
        $cache->delete('getCastesWithCount' . $query);
        $cache->delete('getCastesWithCountTime' . $query);

        if ($cache->get('getCastesWithCount' . $query)) {
            $date1 = date_create($cache->get('getCastesWithCountTime' . $query));
            $date2 = date_create($currentTime);
            $diff = date_diff($date1, $date2);
            if ($diff->h > 24) {
                $data = $this->getCastesWithCountCurrent($unique_id, $start, $length, $stepValue);
                $cache->save('getCastesWithCount' . $query, $data);
                $cache->save('getCastesWithCountTime' . $query, $currentTime);
            } else {
                $data = $cache->get('getInfoDataWithCount' . $query);
            }
        } else {
            $data = $this->getCastesWithCountCurrent($unique_id, $start, $length, $stepValue);
            $cache->save('getCastesWithCount' . $query, $data);
            $cache->save('getCastesWithCountTime' . $query, $currentTime);
        }

        return $data;
    }
    private function getCastesWithCountCurrent($unique_id, $start, $length, $stepValue)
    {
        $infoList = $this->where(['movie_id' => $unique_id]);
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
            $itemImage = $listItem['image'];
            $itemName = $listItem['name'];
            $itemGender = $listItem['gender'];
            $itemCharacter = $listItem['cast_character'];
            $itemAttr = $listItem['attribute'];

            if ($listItem['image'] && !empty($listItem['image']) && file_exists('./' . $listItem['image'])) {
                $itemImage = $listItem['image'];
                $previewImage = '<img class="uk-preserve-width uk-border-circle" src="' . $itemImage . '" width="40" height="40" alt="">';
            } else {
                $previewImage = '<img class="uk-preserve-width uk-border-circle" src="/public/images/avatar.jpg" width="40" height="40" alt="">';
            }
            $infoList[$key]['previewImage'] = $previewImage;

            if ($stepValue != 'locked') {
                $infoList[$key]['actions'] = '<div class="uk-button-group"><button class="addButton uk-button uk-button-secondary uk-button-small" onclick="editCastetem(';
                $infoList[$key]['actions'] .= "'" . $itemId . "',";
                $infoList[$key]['actions'] .= "'" . $itemImage . "',";
                $infoList[$key]['actions'] .= "'" . $itemName . "',";
                $infoList[$key]['actions'] .= "'" . $itemGender . "',";
                $infoList[$key]['actions'] .= "'" . $itemCharacter . "',";
                $infoList[$key]['actions'] .= "'" . $itemAttr . "')";
                $infoList[$key]['actions'] .= '" title="Edit"><span uk-icon="icon: file-edit;"></span></button><button class="deleteButton uk-button uk-button-danger uk-button-small" onclick="deleteCasteItem(';
                $infoList[$key]['actions'] .= "'" . $itemId . "'";
                $infoList[$key]['actions'] .= ')" title="Delete"><span uk-icon="icon: trash;"></span></button></div>';
            }
        }
        $infoListCount = $this->where(['movie_id' => $unique_id])->countAllResults();
        $data = [
            "list" => $infoList,
            "count" => count($infoList),
            "countAll" => $infoListCount,
        ];
        return $data;
    }

    public function getCastesWithCountAdmin($unique_id, $start, $length, $stepValue)
    {
        $cache = cache();
        $currentTime = date('Y-m-d H:i:s');

        $query = $unique_id . $start . $length;

        // $cache->save('cache_item_id', 'data_to_cache');
        // $foo = $cache->get('my_cached_item');
        $cache->delete('getCastesWithCountAdmin' . $query);
        $cache->delete('getCastesWithCountAdminTime' . $query);

        if ($cache->get('getCastesWithCountAdmin' . $query)) {
            $date1 = date_create($cache->get('getCastesWithCountAdminTime' . $query));
            $date2 = date_create($currentTime);
            $diff = date_diff($date1, $date2);
            if ($diff->h > 24) {
                $data = $this->getCastesWithCountCurrentAdmin($unique_id, $start, $length, $stepValue);
                $cache->save('getCastesWithCountAdmin' . $query, $data);
                $cache->save('getCastesWithCountAdminTime' . $query, $currentTime);
            } else {
                $data = $cache->get('getInfoDataWithCount' . $query);
            }
        } else {
            $data = $this->getCastesWithCountCurrentAdmin($unique_id, $start, $length, $stepValue);
            $cache->save('getCastesWithCountAdmin' . $query, $data);
            $cache->save('getCastesWithCountAdminTime' . $query, $currentTime);
        }

        return $data;
    }
    private function getCastesWithCountCurrentAdmin($unique_id, $start, $length, $stepValue)
    {
        $infoList = $this->where(['movie_id' => $unique_id]);
        if (intval($start) && intval($start) > 0) {
            $infoList = $infoList->offset($start);
        }
        if ($length != null && intval($length) && intval($length) > 0) {
            $infoList = $infoList->findAll($length);
        } else {
            $infoList = $infoList->findAll();
        }
        foreach ($infoList as $key => $listItem) {
            $infoList[$key]['key'] = $key+1;

            $itemId = $listItem['id'];
            $itemImage = $listItem['image'];
            $itemName = $listItem['name'];
            $itemGender = $listItem['gender'];
            $itemCharacter = $listItem['cast_character'];
            $itemAttr = $listItem['attribute'];

            if ($listItem['image'] && !empty($listItem['image']) && file_exists('./' . $listItem['image'])) {
                $itemImage = $listItem['image'];
                $previewImage = '<img class="rounded" src="' . $itemImage . '" width="40" height="40" alt="">';
            } else {
                $previewImage = '<img class="rounded" src="/public/images/avatar.jpg" width="40" height="40" alt="">';
            }
            $infoList[$key]['previewImage'] = $previewImage;

            $infoList[$key]['actions'] = '<div class="btn-group"><button class="addButton btn btn-secondary btn-sm" onclick="editCastetem(';
            $infoList[$key]['actions'] .= "'" . $itemId . "',";
            $infoList[$key]['actions'] .= "'" . $itemImage . "',";
            $infoList[$key]['actions'] .= "'" . $itemName . "',";
            $infoList[$key]['actions'] .= "'" . $itemGender . "',";
            $infoList[$key]['actions'] .= "'" . $itemCharacter . "',";
            $infoList[$key]['actions'] .= "'" . $itemAttr . "')";
            $infoList[$key]['actions'] .= '" title="Edit">Edit</button><button class="deleteButton btn btn-danger btn-sm" onclick="deleteCasteItem(';
            $infoList[$key]['actions'] .= "'" . $itemId . "'";
            $infoList[$key]['actions'] .= ')" title="Delete">Delete</button></div>';
        }
        $infoListCount = $this->where(['movie_id' => $unique_id])->countAllResults();
        $data = [
            "list" => $infoList,
            "count" => count($infoList),
            "countAll" => $infoListCount,
        ];
        return $data;
    }
}
