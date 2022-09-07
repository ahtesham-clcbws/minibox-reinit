<?php

namespace App\Models\Common;

use CodeIgniter\Model;

class FilmzinetoModule extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'filmzinetomodules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'news_id',
        'table_name', // homepage / festival
        'data_id' // other than homepage. eg: festival_id
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

    public function getWebData($type, $festivalId)
    {
        $filmzineSelect = 'filmzinetomodules.news_id, filmzinetomodules.data_id, filmzine.title, filmzine.type_id, filmzine.slug, filmzine.media_url, filmzine.media_type, filmzine.video_type, filmzine.topic_id, filmzine.topic_name, filmzine.total_likes, filmzine.total_dislikes, filmzine.movie_rating, filmzine.total_views, filmzine.created_at';

        if ($type == 'interviews') {
            $filmzineData = $this->distinct()
                ->select($filmzineSelect)
                ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
                ->where('filmzinetomodules.table_name', 'festival')
                ->where('filmzinetomodules.data_id', $festivalId)
                ->where('filmzine.type_id', '3')
                ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll();
        } else if ($type == 'trailers') {
            $filmzineData = $this->distinct()
                ->select($filmzineSelect)
                ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
                ->where('filmzinetomodules.table_name', 'festival')
                ->where('filmzinetomodules.data_id', $festivalId)
                ->where('filmzine.type_id', '4')
                ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll();
        } else if ($type == 'knowledge-center') {
            $filmzineData = $this->distinct()
                ->select($filmzineSelect)
                ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
                ->where('filmzinetomodules.table_name', 'festival')
                ->where('filmzinetomodules.data_id', $festivalId)
                ->where('filmzine.type_id', '5')
                ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll();
        } else if ($type == 'headlines') {
            $filmzineData = $this->distinct()
                ->select($filmzineSelect)
                ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
                ->where('filmzinetomodules.table_name', 'festival')
                ->where('filmzinetomodules.data_id', $festivalId)
                ->whereNotIn('filmzine.type_id', [3, 4, 5])
                ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll();
        } else {
            $filmzineData = array();
        }

        return $filmzineData;
    }
    public function getSingleWebData($type, $festivalId, $id)
    {
        $filmzineSelect = 'filmzinetomodules.news_id, filmzinetomodules.data_id, filmzine.title, filmzine.summary, filmzine.type_id, filmzine.slug, filmzine.media_url, filmzine.media_type, filmzine.video_type, filmzine.topic_id, filmzine.topic_name, filmzine.total_likes, filmzine.total_dislikes, filmzine.movie_rating, filmzine.total_views, filmzine.created_at';

        $currentId = base64_decode($id);
        $currentData = $this->distinct()
            ->select('filmzinetomodules.news_id, filmzinetomodules.data_id, filmzine.*')
            ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
            ->where('filmzine.id', $currentId)->first();

        if ($type == 'interviews') {
            $filmzineData = $this->distinct()
                ->select($filmzineSelect)
                ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
                ->where('filmzinetomodules.table_name', 'festival')
                ->where('filmzinetomodules.data_id', $festivalId)
                ->where('filmzine.type_id', '3')
                ->whereNotIn('filmzine.id', [$currentId])
                ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll();
        } else if ($type == 'trailers') {
            $filmzineData = $this->distinct()
                ->select($filmzineSelect)
                ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
                ->where('filmzinetomodules.table_name', 'festival')
                ->where('filmzinetomodules.data_id', $festivalId)
                ->where('filmzine.type_id', '4')
                ->whereNotIn('filmzine.id', [$currentId])
                ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll();
        } else if ($type == 'knowledge-center') {
            $filmzineData = $this->distinct()
                ->select($filmzineSelect)
                ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
                ->where('filmzinetomodules.table_name', 'festival')
                ->where('filmzinetomodules.data_id', $festivalId)
                ->where('filmzine.type_id', '5')
                ->whereNotIn('filmzine.id', [$currentId])
                ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll();
        } else if ($type == 'headlines') {
            $filmzineData = $this->distinct()
                ->select($filmzineSelect)
                ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
                ->where('filmzinetomodules.table_name', 'festival')
                ->where('filmzinetomodules.data_id', $festivalId)
                ->whereNotIn('filmzine.type_id', [3, 4, 5])
                ->whereNotIn('filmzine.id', [$currentId])
                ->orderBy('filmzinetomodules.id', 'RANDOM')->findAll();
        } else {
            $filmzineData = array();
        }

        $data = array(
            'all' => $filmzineData,
            'current' => $currentData,
        );

        return $data;
    }
}
