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
        'step5', // completed / locked / open // (producers, writers, composers, cinematographers, editors)
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
        'locked_inputs', // Admin flag inputs for locked
        'edited_inputs', // Flag automatically when changed ny user
        'approved_inputs', // Admin flag inputs as approved & good to go to be live

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

    public function getSingleFestivalEntryAdmin($id)
    {
        $movie = $this->find($id);

        // Genres
        $movie['genres'] = json_decode($movie['genres'], true);

        // certificates
        $movie['certificates'] = json_decode($movie['certificates'], true);

        // unlocked_inputs
        $movie['unlocked_inputs'] = json_decode($movie['unlocked_inputs'], true);

        // locked_inputs
        $movie['locked_inputs'] = json_decode($movie['locked_inputs'], true);

        // edited_inputs
        $movie['edited_inputs'] = json_decode($movie['edited_inputs'], true);

        // approved_inputs
        $movie['approved_inputs'] = json_decode($movie['approved_inputs'], true);

        // all_inputs
        $movie['all_inputs'] = json_decode($movie['all_inputs'], true);

        // <span class="badge bg-primary">...</span>
        // boolean status 0/1/2/4 (0=review/1=approved/2=reject/4=user_needs_review) (2 = see reason) // default=0
        if($movie['approved'] == 0) {
            $movie['status_badge'] = '<span class="badge badge-dot bg-primary">In Admin Review</span>';
        }
        if($movie['approved'] == 1) {
            $movie['status_badge'] = '<span class="badge badge-dot bg-success">Approved & Live</span>';
        }
        if($movie['approved'] == 2) {
            $movie['status_badge'] = '<span class="badge badge-dot bg-danger">In User Review</span>';
        }
        if($movie['approved'] == 4) {
            $movie['status_badge'] = '<span class="badge badge-dot bg-secondary">Re-Review in Admin</span>';
        }
        // edited_inputs
        // $movie['edited_inputs'] = json_decode($movie['edited_inputs'], true);

        return $movie;
    }
    public function getFestivalEntriesAdmin($postData)
    {
        $draw = @$postData['draw'];
        $dataType = @$postData['dataType'];
        $response['success'] = true;
        $response['draw'] = $draw;

        $start = isset($postData['start']) ? $postData['start'] : 0;
        $limit = isset($postData['length']) ? $postData['length'] : 0;
        $type = isset($postData['dataType']) ? $postData['dataType'] : NULL;
        $search_value = isset($postData['search']) ? $postData['search']['value'] : '';

        $response = ['success' => false, 'message' => 'No data found'];
        $submissionsDb = new FestivalOfficialSubmission();
        $select = 'official_submissions.id, official_submissions.festival_id, official_submissions.title, official_submissions.trailer, official_submissions.year, official_submissions.country, official_submissions.genres, official_submissions.created_at, official_submissions.updated_at, festivals.name as festival_name, countries.name as country_name';

        $submissions = $submissionsDb->distinct()->select($select)->join('festivals', 'festivals.id = official_submissions.festival_id')->join('countries', 'countries.id = official_submissions.country');

        if (!empty($search_value)) {
            $submissions = $submissions->like('festivals.name', $search_value);
            $submissions = $submissions->orLike('official_submissions.title', $search_value);
            $submissions = $submissions->orLike('official_submissions.year', $search_value);
            $submissions = $submissions->orLike('official_submissions.genres', $search_value);
        }
        
        $where = ['official_submissions.allsteps' => 'open', 'official_submissions.approved' => 0, 'official_submissions.edit_status' => 'update_needed'];

        if ($type == 'approval') {
            $where = ['official_submissions.allsteps' => 'locked', 'official_submissions.approved' => 0, 'official_submissions.edit_status' => 'completed'];
            $submissions = $submissions->where($where);
        } elseif ($type == 'review_admin') {
            $where = ['official_submissions.allsteps !=' => 'locked', 'official_submissions.edit_status !=' => 'completed'];
            $submissions = $submissions->where($where);
            $submissions = $submissions->whereIn('official_submissions.approved', [0,4]);
        } elseif ($type == 'review_user') {
            $where = ['official_submissions.allsteps' => 'open', 'official_submissions.approved' => 2, 'official_submissions.edit_status' => 'update_needed'];
            $submissions = $submissions->where($where);
        } elseif ($type == 'live') {
            $where = ['official_submissions.allsteps' => 'locked', 'official_submissions.approved' => 1, 'official_submissions.edit_status' => 'completed'];
            $submissions = $submissions->where($where);
        } else {
            $submissions = $submissions->where($where);
        }

        $submissions = $submissions->offset($start)->findAll($limit);

        foreach ($submissions as $key => $submission) {
            // $submissions[$key]['actions'] = '';
            $submissions[$key]['key'] = $key + 1;
            $submissions[$key]['status'] = 'status';
            $submissions[$key]['trailer'] = '<a target="_blank" href="' . $submission['trailer'] . '">View trailer</a>';

            $genres = json_decode($submission['genres'], true);
            $allGenres = '';
            foreach ($genres as $genre) {
                $allGenres = $allGenres . '<span class="commaSeperated">' . $genre . '</span>';
            }
            $submissions[$key]['genres'] = $allGenres;
            $openingLink = route_to('admin_film_festivals_official_submissions_single', $submission['id']);
            $submissions[$key]['actions'] = '<a class="btn btn-icon btn-dim btn-primary btn-sm" href="' . $openingLink . '"><em class="icon ni ni-external"></em></a>';
            $submissions[$key]['title'] = '<a href="' . $openingLink . '">' . $submission['title'] . '</a>';

            $submissions[$key]['created_at'] = date('d M, Y', strtotime($submission['created_at']));
            $submissions[$key]['updated_at'] = date('d M, Y', strtotime($submission['updated_at']));
        }
        $response['data'] = $submissions;

        // countings
        $submissionsDb = new FestivalOfficialSubmission();
        $submissionsDb = $submissionsDb->distinct()->select($select)->join('festivals', 'festivals.id = official_submissions.festival_id')->join('countries', 'countries.id = official_submissions.country');
        $submissionCount = $submissionsDb->where($where)->countAllResults();


        $response['recordsTotal'] = $submissionCount;
        $response['recordsFiltered'] = $submissionCount;

        return $response;
    }
}
