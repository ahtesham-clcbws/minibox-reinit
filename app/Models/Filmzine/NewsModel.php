<?php

namespace App\Models\Filmzine;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table            = 'filmzine';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'type_id',
        'type_name',
        'slug',
        'featured',
        'title',
        'content',
        'media_url',
        'media_type', // image / video
        'video_type', // youtube / vimeo
        'topic_id',
        'topic_name',
        'total_likes',
        'total_dislikes',
        'movie_rating',
        'total_views',
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

    public function allAdminNews()
    {
        $news = $this->distinct()
            ->select('*')
            // ->join()
            // ->orderBy()
            ->findAll();
        return $news;
    }
}
