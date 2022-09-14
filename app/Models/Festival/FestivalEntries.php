<?php

namespace App\Models\Festival;

use CodeIgniter\Model;

class FestivalEntries extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'festival_entries';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "name",
        "email",
        "mobile",
        "country",
        "festival_id",
        "festival_year",
        "movie_name",
        "director",
        "movie_preview_link",
        "movie_password",
        "producer",
        "production_company",
        "duration", // in minutes
        "debut_film",
        "language",
        "synopsis",
        "occupation",
        "project", // project type id
        "project_type", // like : short or feature (for accessing awards from award array)
        "currency",
        "festival_deadline",
        "selected_award_ids", //  totalPricingArray['awards'] = array of ids // NEW
        "total_amount", //  totalPricingArray['total'] // NEW
        "amount", //  totalPricingArray['final'] // NEW
        "tax_amount", //  totalPricingArray['tax'] // NEW
        "totalPricingArray",
        "selected_awards", // award data will be converting to new array like array(award_id, sub_awards=array()) // NEW
        'gateway',
        'receipt',
        'order_id',
        'gateway_order_id',
        'payment_status'
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
