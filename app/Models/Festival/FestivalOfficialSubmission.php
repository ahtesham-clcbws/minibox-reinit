<?php

namespace App\Models\Festival;

use CodeIgniter\Model;

class FestivalOfficialSubmission extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'official_submissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        // title & details
        'festival_id', // by entry form
        'festival_year', // by entry form
        'unique_id', // receipl id of entry form if the entry form need to be connected
        'title', // by entry form
        'project', // by entry form - id
        'film_status', // Released // Completed (Privately) // Completed
        'film_status_info', // Released and screened / available to the public (or firm date set in relatively near future) // Completed and only limited non-public screenings (friends / family / fellow students / faculty members) // Completed but not shown anywhere
        'year', // (of its premiere or projected release or projected completed)
        'country', // by entry form - id
        'official_web_link',
        'budget_currency', // select
        'budget_amount',

        // basic information
        'director', // by entry form
        'production_company', // by entry form
        'duration', // by entry form
        'debut_film', // by entry form
        'color',
        'genres', // multiple
        'certificates', // multiple
        'synopsis', // by entry form
        'storyline',

        // Banners & Videos
        'banner', // size limitation
        'poster', // size limited
        'trailer',
        'trailer_type', // youtube / vimeo
        'movie',
        'movie_type', // youtube / vimeo
        'distribution', // yes / no
        'rating', // only for admin

        // steps for verify
        'step1', // completed / locked / open // (title, type, status, year, country, link, budget)
        'step2', // completed / locked / open // (director, production_company, duration, debut_film, color, genres, genres, certificates, synopsis, storyline)
        'step3', // completed / locked / open // (banner, poster, trailer, movie, distribution, rating)
        'step4', // completed / locked / open // (after adding/updating major caste)
        'step5', // completed / locked / open // (writers, producers, composers, cinematographers, editors)
        'step6', // completed / locked / open // (languages, sound_mix, aspect_ratio)
        'allsteps', // completed / locked / open

        // Major casts
        // cast & crews
        // technical/other specs/specifications

        'reason',
        'user_reason',
        'approved', // boolean status 0/1/2/4 (0=review/1=approved/2=reject/4=user_needs_review) (2 = see reason) // default=0
        'edit_status', // added_partially / completed / update_needed(if admin reject the submitted data) // default=update_needed
        'unlocked_inputs', // Admin flag inputs for editing
        'locked_inputs', // Admin flag inputs for editing

        // for moview to view on frontend
        // all steps needs to (locked)
        // reason & user_reason will be (null)
        // approved will be (1)
        // edit_status will be (completed)

        // for internal purposes
        'likes', // 0
        'dislikes', // 0
        'views' // 0

    ];

    // Dates
    protected $useTimestamps = false;
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
