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
        'user_email', // belongs to this user
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
        'views', // 0

        'source', // only for admin or automatic (default Direct)
        'subtitle',  // eg: 5th IFF-15 | Best Actor ( festival details | award name )
        'awardName',
        'isWinner',
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
        if ($movie['approved'] == 0) {
            $movie['status_badge'] = '<span class="badge badge-dot bg-primary">In Admin Review</span>';
        }
        if ($movie['approved'] == 1) {
            $movie['status_badge'] = '<span class="badge badge-dot bg-success">Approved & Live</span>';
        }
        if ($movie['approved'] == 2) {
            $movie['status_badge'] = '<span class="badge badge-dot bg-danger">In User Review</span>';
        }
        if ($movie['approved'] == 4) {
            $movie['status_badge'] = '<span class="badge badge-dot bg-secondary">Re-Review in Admin</span>';
        }
        // edited_inputs
        // $movie['edited_inputs'] = json_decode($movie['edited_inputs'], true);

        return $movie;
    }
    public function getFestivalEntriesAdmin($postData)
    {
        $response = ['success' => false, 'message' => 'No data found'];

        $draw = @$postData['draw'];
        // $dataType = @$postData['dataType'];
        $response['success'] = true;
        $response['draw'] = $draw;

        $start = isset($postData['start']) ? $postData['start'] : 0;
        $limit = isset($postData['length']) ? $postData['length'] : 0;
        $type = $postData['dataType'] ? $postData['dataType'] : 'new';
        $search_value = isset($postData['search']) ? $postData['search']['value'] : '';

        $submissionsDb = new FestivalOfficialSubmission();
        $select = 'id, festival_id, title, trailer, year, country, genres, source, created_at, updated_at';

        $submissions = $submissionsDb->select($select);

        if ($type === 'approval') {
            $where = ['allsteps' => 'locked', 'approved' => '0', 'edit_status' => 'completed'];
            $submissions = $submissions->where($where);
        } elseif ($type === 'review_admin') {
            $where = ['allsteps !=' => 'locked', 'edit_status !=' => 'completed'];
            $submissions = $submissions->where($where);
            $submissions = $submissions->whereNotIn('approved', ['0', '4']);
        } elseif ($type === 'review_user') {
            $where = ['allsteps' => 'open', 'approved' => 2, 'edit_status' => 'update_needed'];
            $submissions = $submissions->where($where);
        } elseif ($type === 'live') {
            $where = ['approved' => '1', 'edit_status' => 'completed'];
            $submissions = $submissions->where($where);
        } else {
            $where = ['approved' => '0', 'edit_status' => 'update_needed'];
            $submissions = $submissions->where($where);
        }

        // if (!empty($search_value)) {
        //     $submissions = $submissions->like('festivals.name', $search_value);
        //     $submissions = $submissions->orLike('title', $search_value);
        //     $submissions = $submissions->orLike('year', $search_value);
        //     $submissions = $submissions->orLike('genres', $search_value);
        // }

        // $countings = $submissions;
        $allSubmissions = $submissions->offset($start)->findAll($limit);

        foreach ($allSubmissions as $key => $submission) {
            // $allSubmissions[$key]['actions'] = '';
            $allSubmissions[$key]['key'] = $key + 1;
            $allSubmissions[$key]['status'] = 'status';
            $allSubmissions[$key]['trailer'] = trim($submission['trailer']) ? '<a target="_blank" href="' . $submission['trailer'] . '">View trailer</a>' : 'N/A';

            $genres = json_decode($submission['genres'], true);
            if (count($genres)) {
                $allGenres = '';
                foreach ($genres as $genre) {
                    $allGenres = $allGenres . '<span class="commaSeperated">' . $genre . '</span>';
                }
                $allSubmissions[$key]['genres'] = $allGenres;
            } else {
                $allSubmissions[$key]['genres'] = 'N/A';
            }
            $openingLink = route_to('admin_film_festivals_official_submissions_single', $submission['id']);

            $festival = getFestivalNameSlug($submission['festival_id']);

            $formLink = route_to('festival_official_selection_details', $festival['slug'], base64_encode($submission['id']));

            $allSubmissions[$key]['actions'] = '<a class="btn btn-icon btn-dim btn-primary btn-sm" href="' . $openingLink . '"><em class="icon ni ni-row-mix"></em></a>';
            $allSubmissions[$key]['actions'] .= '<a class="btn btn-icon btn-dim btn-primary btn-sm ms-2" href="' . $formLink . '"><em class="icon ni ni-external"></em></a>';
            // $allSubmissions[$key]['title'] = '<a href="' . $openingLink . '">' . $submission['title'] ? $submission['title'] : 'N/A' . '</a>';
            // $allSubmissions[$key]['title'] = '<a href="' . $openingLink . '">' . $submission['title'] . '</a>';
            $allSubmissions[$key]['title'] = $submission['title'] ? $submission['title'] : 'N/A';
            $allSubmissions[$key]['year'] = $submission['year'] ? $submission['year'] : 'N/A';

            $allSubmissions[$key]['created_at'] = date('d M, Y', strtotime($submission['created_at']));
            $allSubmissions[$key]['updated_at'] = date('d M, Y', strtotime($submission['updated_at']));

            $allSubmissions[$key]['country_name'] = $submission['country'] != 0 ? getCountryName($submission['country']) : 'N/A';
            $allSubmissions[$key]['festival_name'] = $festival['name'];
        }

        // start counting here
        $countings = $submissionsDb->select($select);
        if ($type === 'approval') {
            $where = ['allsteps' => 'locked', 'approved' => '0', 'edit_status' => 'completed'];
            $countings = $countings->where($where);
        } elseif ($type === 'review_admin') {
            $where = ['allsteps !=' => 'locked', 'edit_status !=' => 'completed'];
            $countings = $countings->where($where);
            $countings = $countings->whereNotIn('approved', ['0', '4']);
        } elseif ($type === 'review_user') {
            $where = ['allsteps' => 'open', 'approved' => 2, 'edit_status' => 'update_needed'];
            $countings = $countings->where($where);
        } elseif ($type === 'live') {
            $where = ['approved' => '1', 'edit_status' => 'completed'];
            $countings = $countings->where($where);
        } else {
            $where = ['approved' => '0', 'edit_status' => 'update_needed'];
            $countings = $countings->where($where);
        }
        $submissionCount = $countings->countAllResults();

        $response['data'] = $allSubmissions;
        $response['recordsTotal'] = $submissionCount;
        $response['recordsFiltered'] = $submissionCount;

        return $response;

        // countings
        // $submissionsDb = new FestivalOfficialSubmission();
        // $submissionsDb = $submissionsDb->distinct()->select($select)->join('festivals', 'festivals.id = festival_id')->join('countries', 'countries.id = country');
    }
}
