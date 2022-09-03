<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AwardsCategoryModel;
use App\Models\AwardsModel;
use App\Models\Common\SupportModel;
use App\Models\Festival\FestivalTypeOfFilms;
use App\Models\HomePageBannersModel;

class SettingsController extends BaseController
{
    protected $data;
    public function __construct()
    {
        $this->data = [];
        $this->data['optionalJs'] = false;
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
}
