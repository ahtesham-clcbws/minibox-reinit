<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AwardsCategoryModel;
use App\Models\AwardsModel;
use App\Models\Common\FilmzinetoModule;
use App\Models\Common\SupportModel;
use App\Models\Common\TestimonialModel;
use App\Models\Festival\FestivalModel;
use App\Models\Festival\FestivalTypeOfFilms;
use App\Models\Filmzine\NewsModel;
use App\Models\HomePageBannersModel;
use App\Models\Payment\OrderModel;

class SettingsController extends BaseController
{
    public function __construct()
    {
        $this->data['pagename'] = 'Settings';
    }
    public function index()
    {
        return view('Admin/Pages/Settings/main', $this->data);
    }
    public function filmFestivalAwards()
    {
        $this->data['pagename'] = 'Festival Awards';
        $response = ['success' => false, 'message' => '', 'data' => []];
        $awardb = new AwardsModel();
        $awards = $awardb->getAllAwardsInAdmin();
        $this->data['awardCategories'] = $awards;

        $allAwards = $awardb->getAwardsWithCategory();
        $this->data['allAwards'] = $allAwards;

        // return print_r($awards);

        if ($this->request->getPost('getAwardCat')) {
            $response['message'] = 'Unable to found Award, please try after some time.';
            $awardData = $awardb->getAwardCatById($this->request->getPost('id'));
            if ($awardData) {
                $response['data'] = $awardData;
                $response['message'] = 'Award Found.';
                $response['success'] = true;
            }
            return json_encode($response);
        }
        if ($this->request->getPost('update_award_cat')) {
            $response['message'] = 'Unable to Update Award, please try after some time.';
            $dataToUpdate = $this->request->getPost();
            unset($dataToUpdate['update_award_cat']);

            $awardCatDb = new AwardsCategoryModel();

            // check unique short name
            if (!$awardCatDb->isShortNameUnique($dataToUpdate['short_name'], $dataToUpdate['id'])) {
                $response['message'] = 'Change your short name, this is already in our database. It must be uniqe.';
                $response['success'] = false;
                return json_encode($response);
            }


            $imageValid = true;
            if ($img = $this->request->getFile('image')) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move('public/uploads/awards_cat/', $newName);
                    $uploadedPath = '/public/uploads/awards_cat/' . $newName;
                    $dataToUpdate['image'] = $uploadedPath;
                    $imageValid = true;
                } else {
                    $imageValid = false;
                }
            } else {
                $imageValid = false;
            }

            if (intval($this->request->getPost('id')) == 0) {
                if (!$imageValid) {
                    $response['message'] = 'Please select an image before adding new data.';
                    $response['success'] = false;
                    return json_encode($response);
                }
                unset($dataToUpdate['id']);
            }

            $awardData = $awardCatDb->save($dataToUpdate);

            if ($awardData) {
                $response['data'] = $awardData;
                $response['message'] = 'Award Updated Succesfully.';
                $response['success'] = true;
            }
            return json_encode($response);
        }
        if ($this->request->getPost('getAward')) {
            $response['message'] = 'Unable to found Award, please try after some time.';
            $awardData = $awardb->getAwardById($this->request->getPost('id'));
            if ($awardData) {
                $response['data'] = $awardData;
                $response['message'] = 'Award Found.';
                $response['success'] = true;
            }
            return json_encode($response);
        }
        if ($this->request->getPost('add_update_award')) {
            $response['message'] = 'Unable to Update Award, please try after some time.';
            $dataToUpdate = $this->request->getPost();
            if ($this->request->getPost('id') == 0) {
                unset($dataToUpdate['id']);
            }
            unset($dataToUpdate['add_update_award']);
            $awardData = $awardb->save($dataToUpdate);
            if ($awardData) {
                $response['data'] = $this->request->getPost();
                $response['message'] = 'Award Updated Succesfully.';
                $response['success'] = true;
            }
            return json_encode($response);
        }
        if ($this->request->getPost('deleteAward')) {
            $response['message'] = 'Unable to Delete Award, please try after some time.';
            $id = $this->request->getPost('id');
            $awardData = $awardb->delete($id);
            if ($awardData) {
                $response['message'] = 'Award Delete Succesfully.';
                $response['success'] = true;
            }
            return json_encode($response);
        }
        // return print_r($this->data);
        return view('Admin/Pages/Settings/awards', $this->data);
    }
    public function filmTypes()
    {
        $this->data['pagename'] = 'Film Types';
        $response = ['success' => false, 'message' => '', 'data' => []];

        $filmTypeDb = new FestivalTypeOfFilms();
        $film_types = $filmTypeDb->getAllTypes();
        $this->data['film_types'] = $film_types;

        if ($this->request->getPost('getFilmType')) {
            $response['message'] = 'Unable to found Film type, please try after some time.';
            $TypeData = $filmTypeDb->find($this->request->getPost('id'));
            if ($TypeData) {
                $response['data'] = $TypeData;
                $response['message'] = 'Film Type Found.';
                $response['success'] = true;
            }
            return json_encode($response);
        }
        if ($this->request->getPost('update_film_type')) {
            $response['message'] = 'Unable to Film Type, please try after some time.';
            $dataToUpdate = $this->request->getPost();
            if ($dataToUpdate['id'] == 0) {
                unset($dataToUpdate['id']);
            }
            unset($dataToUpdate['update_film_type']);
            $awardData = $filmTypeDb->save($dataToUpdate);
            if ($awardData) {
                $response['data'] = $awardData;
                $response['message'] = 'Type Added/Updated Succesfully.';
                $response['success'] = true;
            }
            return json_encode($response);
        }
        if ($this->request->getPost('deleteType')) {
            $response['message'] = 'Unable to Delete, please try after some time.';
            $id = $this->request->getPost('id');
            $awardData = $filmTypeDb->delete($id);
            if ($awardData) {
                $response['message'] = 'Delete Succesfully.';
                $response['success'] = true;
            }
            return json_encode($response);
        }
        // return print_r($this->data);
        return view('Admin/Pages/Settings/film_types', $this->data);
    }
    public function homepageBanners()
    {
        $this->data['pagename'] = 'Homepage Banners';
        $response = ['success' => false, 'message' => '', 'data' => []];

        $bannersDb = new HomePageBannersModel();
        $banners = $bannersDb->findAll();
        $this->data['banners'] = $banners;

        if ($this->request->getPost('add_banner')) {
            $banner = [
                'title' => trim($this->request->getPost('title')),
                'sub_title' => trim($this->request->getPost('sub_title')),
                'url' => trim($this->request->getPost('url')),
            ];
            if ($this->request->getPost('id') != '0' && $this->request->getPost('id') != 0) {
                $banner['id'] = $this->request->getPost('id');
                if ($img = $this->request->getFile('image')) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('public/images/home_banners', $newName);
                        $bannerPath = '/public/images/home_banners/' . $newName;
                        $banner['image'] = $bannerPath;
                    }
                }
                if ($bannersDb->save($banner)) {
                    $response['message'] = 'Banner add/update successfully.';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'Unable to save banner, please try after some time.';
                    $response['success'] = false;
                }
            } else {
                if ($img = $this->request->getFile('image')) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('public/images/home_banners', $newName);
                        $bannerPath = '/public/images/home_banners/' . $newName;
                        $banner['image'] = $bannerPath;
                        if ($bannersDb->save($banner)) {
                            $response['message'] = 'Banner add/update successfully.';
                            $response['success'] = true;
                        } else {
                            $response['message'] = 'Unable to save banner, please try after some time.';
                            $response['success'] = false;
                        }
                    } else {
                        $response['message'] = 'No banner found please add banner image to add the banner';
                    }
                } else {
                    $response['message'] = 'No banner found please add banner image to add the banner';
                }
            }
            return json_encode($response);
        }

        return view('Admin/Pages/Settings/homepage_banners', $this->data);
    }
    public function supportForms()
    {
        $this->data['pagename'] = 'Support Forms';
        $response = ['success' => false, 'message' => '', 'data' => []];

        $supportDb = new SupportModel();
        $forms = $supportDb->findAll();
        $this->data['forms'] = $forms;

        return view('Admin/Pages/Settings/support_forms', $this->data);
    }
    public function homepageFilmzine()
    {
        $this->data['pagename'] = 'Homepage FilmZine Content';
        $response = ['success' => false, 'message' => '', 'data' => []];

        $filmzineModule = new FilmzinetoModule();
        $filmzineData = $filmzineModule->distinct()
            ->select('filmzinetomodules.*, filmzine.title, filmzine.type_id')
            ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
            ->where('filmzinetomodules.table_name', 'homepage')
            ->orderBy('filmzinetomodules.id', 'desc')->findAll();
        $this->data['entities'] = $filmzineData;

        if ($this->request->getPost('getFilmzines')) {
            $type = $this->request->getPost('getFilmzines');

            $filmZineIds = [0];
            foreach ($filmzineData as $key => $filmzineId) {
                $filmZineIds[$key] = $filmzineId['news_id'];
            }

            $newsMd = new NewsModel();

            $getFilmzines = $newsMd->select('id, title as text')->whereNotIn('id', $filmZineIds);
            if ($type == 'headlines') {
                $getFilmzines = $getFilmzines->whereNotIn('type_id', [2, 3, 4]);
            }
            if ($type == 'trailers') {
                $getFilmzines = $getFilmzines->where('type_id', 4);
            }
            if ($type == 'interviews') {
                $getFilmzines = $getFilmzines->where('type_id', 3);
            }
            if ($type == 'knowledgecenter') {
                $getFilmzines = $getFilmzines->where('type_id', 5);
            }
            $getFilmzines = $getFilmzines->orderBy('id', 'desc')->findAll();
            $response['message'] = 'No Data Found with this type, please try after add some articles in this type.';
            // if ($getFilmzines) {
            $response['success'] = true;
            $response['data'] = $getFilmzines;
            $response['message'] = 'Data Found.';
            // }
            return json_encode($response);
        }
        if ($this->request->getPost('addFilmzines')) {
            $articleData = array(
                'news_id' => $this->request->getPost('news_id'),
                'table_name' => 'homepage'
            );
            $response['message'] = 'Unable to attach article, please try after add some articles in this type.';
            if ($filmzineModule->save($articleData)) {
                $response['success'] = true;
                $response['data'] = $articleData;
                $response['message'] = 'Data Found.';
            }
            return json_encode($response);
        }
        if ($this->request->getPost('deleteData')) {
            $response['message'] = 'Unable to Un-Attach article, please try after add some articles in this type.';
            if ($filmzineModule->delete($this->request->getPost('deleteData'))) {
                $response['success'] = true;
                $response['data'] = $this->request->getPost('deleteData');
                $response['message'] = 'Data Found.';
            }
            return json_encode($response);
        }

        return view('Admin/Pages/Settings/homepage_filmzine', $this->data);
    }
    public function testimonials()
    {
        $this->data['pagename'] = 'Testimonials';
        $response = ['success' => false, 'message' => '', 'data' => []];
        $entityDb = new TestimonialModel();

        if ($this->request->getPost()) {
            if ($this->request->getPost('getmoduleData')) {
                $type = $this->request->getPost('getmoduleData');
                $moduleData = array();
                if ($type == 'festival') {
                    $festivalDb = new FestivalModel();
                    $moduleData = $festivalDb->select('id, name')->orderBy('name', 'asc')->findAll();
                }
                if (count($moduleData)) {
                    $response['data'] = $moduleData;
                    $response['success'] = true;
                } else {
                    $response['message'] = 'unable to find data';
                    $response['success'] = false;
                }
            }
            if ($this->request->getPost('addTestimonial')) {
                $postData = array(
                    'type' => $this->request->getPost('type'),
                    'rating' => $this->request->getPost('rating'),
                    'name' => $this->request->getPost('name'),
                    'content' => htmlentities($this->request->getPost('content')),
                    'designation' => $this->request->getPost('designation')
                );
                if ($this->request->getPost('type') == 'global') {
                    $postData['module_id'] = NULL;
                } else {
                    $postData['module_id'] = $this->request->getPost('module_id');
                }
                if ($this->request->getPost('id') > '0' || $this->request->getPost('id') > 0) {
                    $postData['id'] = $this->request->getPost('id');
                } else {
                    $postData['id'] = NULL;
                }

                if ($entityDb->save($postData)) {
                    $response['message'] = 'Data Added succesfully';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'Unable to add data, please try after some time.';
                    $response['success'] = false;
                }
            }
            return json_encode($response);
        }

        $testimonials = $entityDb->orderBy('id', 'desc')->findAll();
        foreach ($testimonials as $key => $testimonial) {
            if ($testimonial['type'] == 'festival') {
                $festivalDb = new FestivalModel();
                $data = $festivalDb->select('name')->find($testimonial['module_id']);
                if ($data) {
                    $testimonials[$key]['festival_name'] = $data['name'];
                } else {
                    $testimonials[$key]['festival_name'] = 'N/A';
                }
            }
        }
        $this->data['testimonials'] = $testimonials;
        return view('Admin/Pages/Settings/testimonials', $this->data);
    }

    public function allOrders(){
        $this->data['pagename'] = 'ORDERS';
        $response = ['success' => false, 'message' => '', 'data' => []];

        $entityDb = new OrderModel();

        $select = 'id, user_name, user_email, user_phone, currency, payment_status, gateway, order_id, receipt, amount, product_name, type_of_action, created_at, updated_at';

        $completedOrders = $entityDb->select($select)->where('payment_status', 'completed')->orderBy('id', 'desc')->findAll();
        $incompleteOrders = $entityDb->select($select)->where('payment_status !=', 'completed')->orderBy('id', 'desc')->findAll();

        $this->data['completedOrders'] = $completedOrders;
        $this->data['incompleteOrders'] = $incompleteOrders;

        return view('Admin/Pages/Settings/allOrders', $this->data);
    }
}
