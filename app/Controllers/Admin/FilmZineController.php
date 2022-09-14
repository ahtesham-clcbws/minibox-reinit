<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Common\FilmzinetoModule;
use App\Models\Filmzine\NewsLikes;
use App\Models\Filmzine\NewsModel;
use App\Models\Filmzine\NewsTopics;
use App\Models\Filmzine\NewsType;

class FilmZineController extends BaseController
{
    public function __construct()
    {
        $this->data['pagename'] = 'Film Zine';
    }
    public function index()
    {
        $response = ['success' => false, 'message' => '', 'data' => []];
        $newsMd = new NewsModel();
        if ($this->request->getPost()) {
            if ($this->request->getPost('deleteData')) {
                $response['message'] = 'Unable to Delete, please try after some type.';
                if ($newsMd->delete($this->request->getPost('deleteData'))) {
                    $moduleDb = new FilmzinetoModule();
                    $moduleDb->where('news_id', $this->request->getPost('deleteData'))->delete();
                    $response['success'] = true;
                    $response['message'] = 'Data Deleted.';
                }
            }
            return json_encode($response);
        }

        $this->data['AllNews'] = $newsMd->allAdminNews();
        return view('Admin/Pages/filmzine/list', $this->data);
    }
    public function topics()
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $topicsMd = new NewsTopics();
        if ($this->request->getPost()) {
            // return json_encode($this->request->getPost());
            if ($this->request->getPost('add_update')) {
                $postData = $this->request->getPost();
                unset($postData['add_update']);
                if ($this->request->getPost('id') == 0) {
                    unset($postData['id']);
                }
                if ($topicsMd->save($postData)) {
                    $response['message'] = 'topic added';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'unable to add topic';
                    $response['success'] = false;
                }
            }
            if ($this->request->getPost('deleteData')) {
                $topicid = $this->request->getPost('id');
                if ($topicsMd->delete($topicid)) {
                    $response['message'] = 'topic deleted';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'unable to delete topic';
                    $response['success'] = false;
                }
            }
            return json_encode($response);
        }

        $topics = $topicsMd->orderBy('id', 'desc')->findAll();
        $newsMd = new NewsModel();
        foreach ($topics as $key => $topic) {
            $topics[$key]['articles'] = $newsMd->where('topic_id', $topic['id'])->countAllResults();
        }
        $this->data['topics'] = $topics;

        $this->data['pagename'] = 'Film Zine -Topics';
        return view('Admin/Pages/filmzine/topics', $this->data);
    }
    public function types()
    {
        $this->data['pagename'] = 'Film Zine - Types';
        return view('Admin/Pages/filmzine/types', $this->data);
    }
    public function likes()
    {
        $this->data['pagename'] = 'Film Zine - Like Logs';
        $likeMd = new NewsLikes();
        $allLikeLogs = $likeMd->distinct()
            ->select('filmzine_likes.*, filmzine.title as news_title, filmzine.id as news_id')
            ->join('filmzine', 'filmzine.id = filmzine_likes.news_id')
            ->orderBy('filmzine_likes.id', 'desc')->findAll();
        $this->data['allLikeLogs'] = $allLikeLogs;
        return view('Admin/Pages/filmzine/like_logs', $this->data);
    }
    public function addupdate($id = null)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];
        $this->data['optionalJs'] = true;
        $this->data['pagename'] = 'Add Article';

        $this->data['news'] = null;

        $typesMd = new NewsType();
        $topicsMd = new NewsTopics();

        $this->data['types'] = $typesMd->select('id, name, rating')->findAll();
        $this->data['topics'] = $topicsMd->select('id, name')->findAll();

        if ($id) {
            $this->data['pagename'] = 'Update Article';
            $newsMd = new NewsModel();
            $news = $newsMd->find($id);
            if (!$news) {
                return redirect()->route('admin_film_zine_add');
            } else {
                $this->data['news'] = $news;
            }
        }
        if ($this->request->getPost()) {
            if ($this->request->getPost('add_update')) {
                // $postData = $this->request->getPost();
                // return json_encode($postData);
                $mediaIsValid = true;
                $mediaType = $this->request->getPost('media_type');
                $postData['user_id'] = session()->get('user.id');
                $postData['type_id'] = $this->request->getPost('type_id');
                $postData['type_name'] = $this->request->getPost('type_name');
                $postData['slug'] = $this->createSlug($this->request->getPost('title'));
                $postData['featured'] = $this->request->getPost('featured');
                $postData['title'] = $this->request->getPost('title');
                $postData['summary'] = $this->request->getPost('summary');
                $postData['content'] = htmlentities($this->request->getPost('content'));
                // $postData['media_url'] = $this->request->getPost('media_url');
                $postData['media_type'] = $mediaType;
                $postData['topic_id'] = $this->request->getPost('topic_id');
                $postData['topic_name'] = $this->request->getPost('topic_name');
                $postData['movie_rating'] = $this->request->getPost('movie_rating') ? $this->request->getPost('movie_rating') : NULL;
                // image upload here
                if ($mediaType == 'image') {
                    if ($img = $this->request->getFile('image_input')) {
                        if ($img->isValid() && !$img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $dateYear = date('Y');
                            $dateMonth = date('F');
                            $path = 'uploads/filmzine/' . $dateYear . '/' . $dateMonth;
                            $img->move($path, $newName);
                            $mediaPath = '/' . $path . '/' . $newName;
                            $postData['media_url'] = $mediaPath;
                            $mediaIsValid = true;
                        } else {
                            $mediaIsValid = false;
                        }
                    } else {
                        $mediaIsValid = false;
                    }
                    $postData['video_type'] = NULL;
                } else {
                    $videoType = $this->request->getPost('video_type');
                    $postData['video_type'] = $videoType;
                    $postData['media_url'] = $this->request->getPost('video_url');
                    $mediaIsValid = true;
                }

                if ($id && $id > 0) {
                    $postData['id'] = $id;
                    $responseMessage = 'Data Updated succesfully';
                    $responseErrorMessage = 'Unable to change data, please try after some time.';
                } else {
                    $responseMessage = 'Data Added succesfully';
                    $responseErrorMessage = 'Unable to add data, please try after some time.';
                    if (!$mediaIsValid) {
                        $response['message'] = 'Please select an image or video before adding new data.';
                        $response['success'] = false;
                        return json_encode($response);
                    }
                }
                $newsMd = new NewsModel();
                if ($newsMd->save($postData)) {
                    $response['message'] = $responseMessage;
                    $response['success'] = true;
                } else {
                    $response['message'] = $responseErrorMessage;
                    $response['success'] = false;
                }
            }
            return json_encode($response);
        }

        return view('Admin/Pages/filmzine/add', $this->data);
    }

    private function createSlug($title, $id = null)
    {
        $slug = uniqueSlugify($title, new NewsModel(), [$id]);
        return $slug;
    }

    // unused functions
    private function checkUniqueSlug($slug, $id = 0)
    {
        $whereNotIn = [$id];
        $newsMd = new NewsModel();
        $counts = $newsMd->where('slug', $slug)->whereNotIn('id', $whereNotIn)->countAllResults();
        if ($counts > 0) {
            return ['success' => false, 'numbers' => $counts];
        }
        return ['success' => true];
    }
}
