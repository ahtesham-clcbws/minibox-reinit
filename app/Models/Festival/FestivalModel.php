<?php

namespace App\Models\Festival;

use App\Models\AwardsCategoryModel;
use App\Models\AwardsModel;
use CodeIgniter\Model;

class FestivalModel extends Model
{
    protected $table            = 'festivals';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'title',
        'logo',
        'about',
        'sponsorship',
        'rules',
        'info_stats',
        'slug',
        'edition',
        'current_year',
        'opening_date',
        'event_date',
        'short_awards', // boolean 0/1
        'feature_awards', // boolean 0/1
        'project_types', // array, default []
        'award_category_to_show', // array, default []
        'awards_to_show', // array, default []
        'awards_prices', // custom/global
        'short_awards_prices', // array, default []
        'feature_awards_prices', // array, default []
        'status',
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


    public function getAdminList()
    {
        $allFestivals = $this->select('id, name, edition, current_year, status')->findAll();
        foreach ($allFestivals as $key => $festival) {
            $movieDb = new FestivalOfficialSubmission();
            $allFestivals[$key]['submitions'] = $movieDb->where(['festival_id' => $festival['id']])->countAllResults();
            $allFestivals[$key]['selections'] = $movieDb->where(['festival_id' => $festival['id'], 'approved' => 1])->countAllResults();
            $allFestivals[$key]['winners'] = $movieDb->where(['festival_id' => $festival['id'], 'isWinner' => 1])->countAllResults();
        }
        return $allFestivals;
    }
    public function getFestivalBySlugFrontend($slug)
    {
        $festival = $this->where(['slug' => $slug, 'status' => 1])->first();
        if ($festival) {
            $awardCatsDb = new AwardsCategoryModel();
            $awardCats = $awardCatsDb->findAll();
            $filmTypesDb = new FestivalTypeOfFilms();
            $allProjectTypes = $filmTypesDb->findAll();
            // $this->data['allProjectTypes'] = $allProjectTypes;

            $festival['project_types'] = json_decode($festival['project_types']);
            $festival['award_category_to_show'] = json_decode($festival['award_category_to_show']);
            $festival['awards_to_show'] = json_decode($festival['awards_to_show']);

            // $this->data['awardCats'] = $awardCats;

            $awardsDb = new AwardsModel();
            if (count($festival['award_category_to_show'])) {
                foreach ($awardCats as $key => $awardCategory) {
                    if (in_array($awardCategory['id'], $festival['award_category_to_show'])) {
                        $awardCats[$key]['awards'] = $awardsDb->where(['category_id' => $awardCategory['id']])->findAll();
                    }
                }
            }

            if ($festival['awards_prices'] == 'global') {
                $awardsPricingJson = array();
                foreach ($awardCats as $acKey => $awardCat) {

                    $shortAwards = $awardsDb->select('id, name')->where(['category_id' => $awardCat['id'], 'isShort' => '1'])->findAll();
                    $featureAwards = $awardsDb->select('id, name')->where(['category_id' => $awardCat['id'], 'isFeature' => '1'])->findAll();

                    $awardsPricingJson['short'][$acKey]['award_id'] = $awardCat['id'];
                    $awardsPricingJson['short'][$acKey]['award_name'] = $awardCat['name'];
                    $awardsPricingJson['short'][$acKey]['award_image'] = $awardCat['image'];
                    $awardsPricingJson['short'][$acKey]['award_count'] = count($shortAwards);
                    $awardsPricingJson['short'][$acKey]['awards'] = $shortAwards;
                    $awardsPricingJson['short'][$acKey]['prices']['inr']['student'] = $awardCat['short_student_inr'];
                    $awardsPricingJson['short'][$acKey]['prices']['inr']['professional'] = $awardCat['short_professional_inr'];
                    $awardsPricingJson['short'][$acKey]['prices']['eur']['student'] = $awardCat['short_student_eur'];
                    $awardsPricingJson['short'][$acKey]['prices']['eur']['professional'] = $awardCat['short_professional_eur'];

                    $awardsPricingJson['feature'][$acKey]['award_id'] = $awardCat['id'];
                    $awardsPricingJson['feature'][$acKey]['award_name'] = $awardCat['name'];
                    $awardsPricingJson['feature'][$acKey]['award_image'] = $awardCat['image'];
                    $awardsPricingJson['feature'][$acKey]['award_count'] = count($featureAwards);
                    $awardsPricingJson['feature'][$acKey]['awards'] = $featureAwards;
                    $awardsPricingJson['feature'][$acKey]['prices']['inr']['student'] = $awardCat['feature_student_inr'];
                    $awardsPricingJson['feature'][$acKey]['prices']['inr']['professional'] = $awardCat['feature_professional_inr'];
                    $awardsPricingJson['feature'][$acKey]['prices']['eur']['student'] = $awardCat['feature_student_eur'];
                    $awardsPricingJson['feature'][$acKey]['prices']['eur']['professional'] = $awardCat['feature_professional_eur'];
                }
                $festival['short_awards_prices'] = $awardsPricingJson['short'];
                $festival['feature_awards_prices'] = $awardsPricingJson['feature'];
            } else {
                if (count(json_decode($festival['short_awards_prices'], true))) {
                    $short_awards_prices = (array)json_decode($festival['short_awards_prices'], true);
                    foreach ($short_awards_prices as $acKey => $awardCat) {

                        $shortAwards = $awardsDb->select('id, name')->where(['category_id' => $awardCat['award_id'], 'isShort' => '1'])->findAll();

                        $short_awards_prices[$acKey]['award_count'] = count($shortAwards);
                        $short_awards_prices[$acKey]['awards'] = $shortAwards;
                    }
                    $festival['short_awards_prices'] = $short_awards_prices;
                } else {
                    $awardsPricingJson = array();
                    foreach ($awardCats as $acKey => $awardCat) {

                        $shortAwards = $awardsDb->select('id, name')->where(['category_id' => $awardCat['id'], 'isShort' => '1'])->findAll();

                        $awardsPricingJson['short'][$acKey]['award_id'] = $awardCat['id'];
                        $awardsPricingJson['short'][$acKey]['award_name'] = $awardCat['name'];
                        $awardsPricingJson['short'][$acKey]['award_image'] = $awardCat['image'];
                        $awardsPricingJson['short'][$acKey]['award_count'] = count($shortAwards);
                        $awardsPricingJson['short'][$acKey]['awards'] = $shortAwards;
                        $awardsPricingJson['short'][$acKey]['prices']['inr']['student'] = $awardCat['short_student_inr'];
                        $awardsPricingJson['short'][$acKey]['prices']['inr']['professional'] = $awardCat['short_professional_inr'];
                        $awardsPricingJson['short'][$acKey]['prices']['eur']['student'] = $awardCat['short_student_eur'];
                        $awardsPricingJson['short'][$acKey]['prices']['eur']['professional'] = $awardCat['short_professional_eur'];
                    }
                    $festival['short_awards_prices'] = $awardsPricingJson['short'];
                }
                if (count(json_decode($festival['feature_awards_prices'], true))) {
                    $feature_awards_prices = (array)json_decode($festival['feature_awards_prices'], true);
                    foreach ($feature_awards_prices as $acKey => $awardCat) {

                        $featureAwards = $awardsDb->select('id, name')->where(['category_id' => $awardCat['award_id'], 'isFeature' => '1'])->findAll();

                        $feature_awards_prices[$acKey]['award_count'] = count($featureAwards);
                        $feature_awards_prices[$acKey]['awards'] = $featureAwards;
                    }
                    $festival['feature_awards_prices'] = $feature_awards_prices;
                } else {
                    $awardsPricingJson = array();
                    foreach ($awardCats as $acKey => $awardCat) {

                        $featureAwards = $awardsDb->select('id, name')->where(['category_id' => $awardCat['id'], 'isFeature' => '1'])->findAll();

                        $awardsPricingJson['feature'][$acKey]['award_id'] = $awardCat['id'];
                        $awardsPricingJson['feature'][$acKey]['award_name'] = $awardCat['name'];
                        $awardsPricingJson['feature'][$acKey]['award_image'] = $awardCat['image'];
                        $awardsPricingJson['feature'][$acKey]['award_count'] = count($featureAwards);
                        $awardsPricingJson['feature'][$acKey]['awards'] = $featureAwards;
                        $awardsPricingJson['feature'][$acKey]['prices']['inr']['student'] = $awardCat['feature_student_inr'];
                        $awardsPricingJson['feature'][$acKey]['prices']['inr']['professional'] = $awardCat['feature_professional_inr'];
                        $awardsPricingJson['feature'][$acKey]['prices']['eur']['student'] = $awardCat['feature_student_eur'];
                        $awardsPricingJson['feature'][$acKey]['prices']['eur']['professional'] = $awardCat['feature_professional_eur'];
                    }
                    $festival['feature_awards_prices'] = $awardsPricingJson['feature'];
                }
            }
            return $festival;
        }
        return false;
    }
}
