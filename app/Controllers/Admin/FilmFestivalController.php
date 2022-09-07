<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AwardsCategoryModel;
use App\Models\AwardsModel;
use App\Models\Common\FilmzinetoModule;
use App\Models\Festival\DynamicPagesData;
use App\Models\Festival\FestivalAbout;
use App\Models\Festival\FestivalAwards;
use App\Models\Festival\FestivalAwardsPage;
use App\Models\Festival\FestivalBanners;
use App\Models\Festival\FestivalDeadlines;
use App\Models\Festival\FestivalJury;
use App\Models\Festival\FestivalModel;
use App\Models\Festival\FestivalSchedules;
use App\Models\Festival\FestivalSponsorship;
use App\Models\Festival\FestivalTypeOfFilms;
use App\Models\Festival\FestivalVenueItem;
use App\Models\Festival\FestivalVenues;
use App\Models\Festival\FestivalTeam;
use App\Models\Festival\FestivalJuryGallery;
use App\Models\Festival\FestivalVolunteer;
use App\Models\Festival\FestivalDelegatePackages;
use App\Models\Festival\FestivalGallery;
use App\Models\Festival\FestivalPress;
use App\Models\Filmzine\NewsModel;

class FilmFestivalController extends BaseController
{
    protected $data;
    protected $festivalDb;
    public function __construct()
    {
        $this->data = [];
        $this->festivalDb = new FestivalModel();
        $this->data['optionalJs'] = false;
        $this->data['pagename'] = 'Film Festivals';
    }
    public function index()
    {
        $response = ['success' => false, 'message' => '', 'data' => []];
        // return json_encode($this->request->getVar());
        if ($this->request->getPost()) {
            if ($this->request->getVar('festival_add')) {
                $fData = [];
                if ($this->request->getVar('id') != 0) {
                    $fData['id'] = $this->request->getVar('id');
                }
                $fData['name'] = $this->request->getVar('name');
                $fData['status'] = $this->request->getVar('status');

                if ($this->festivalDb->where('name', $fData['name'])->first()) {
                    $response['message'] = 'Festival already exists.';
                    $response['success'] = false;
                    // return json_encode($response);
                } else {
                    $response['message'] = 'Unable to save festival, please try after some time.';
                    if ($this->festivalDb->save($fData)) {
                        $response['success'] = true;
                        $response['message'] = 'Festival saved successfully.';
                    }
                }

                // return json_encode($response);
            }
            if ($this->request->getVar('getData')) {

                $response['message'] = 'Unable to save data, please try after some time.';

                if ($data = $this->festivalDb->select($this->request->getVar('dataType'))->find($this->request->getVar('id'))) {
                    $response['message'] = 'Data find successfully.';
                    $response['success'] = true;
                    // $response['data'] = $data[$this->request->getVar('dataType')];
                    $response['data'] = $data;
                }

                // return json_encode($response);
            }
            if ($this->request->getVar('setData')) {
                $fData = [];
                $fData['id'] = $this->request->getVar('id');
                $fData[$this->request->getVar('dataType')] = $this->request->getVar('data');

                $response['message'] = 'Unable to save data, please try after some time.';
                if ($this->festivalDb->save($fData)) {
                    $response['success'] = true;
                    $response['message'] = 'Data updated successfully.';
                }
            }
            if ($this->request->getVar('deleteFestival')) {
                $festivalId = $this->request->getVar('id');

                $response['message'] = 'Unable to delete festival, please try after some time.';
                if ($this->festivalDb->delete($festivalId)) {
                    $response['success'] = true;
                    $response['message'] = 'Delete festival successfully.';
                }
            }
            if ($this->request->getVar('changeStatus')) {
                $fData = [];
                $fData['status'] = intval($this->request->getVar('status'));
                if ($this->festivalDb->update(intval($this->request->getVar('id')), $fData)) {
                    $response['success'] = true;
                    $response['message'] = 'Status changed successfully.';
                }
            }
            if ($this->request->getVar('saveLogo')) {
                $fData = ['id' => $this->request->getVar('id')];

                $response['message'] = 'Unable to save logo, please try after some time.';

                if ($img = $this->request->getFile('logo')) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('public/uploads/logos/main', $newName);
                        $uploadedPath = '/public/uploads/logos/main/' . $newName;
                        $fData['logo'] = $uploadedPath;
                        if ($this->festivalDb->save($fData)) {
                            $response['message'] = 'Logo saved successfully.';
                            $response['success'] = true;
                        }
                    }
                } else {
                    $response['message'] = 'No data to update.';
                    $response['success'] = false;
                }
            }
            return json_encode($response);
        }

        $this->data['festivals'] = $this->festivalDb->getAdminList();

        return view('Admin/Pages/filmfestivals/list', $this->data);
    }

    public function festivalDetails($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);

        if ($festival) {
            $awardCatsDb = new AwardsCategoryModel();
            $awardCats = $awardCatsDb->findAll();
            $filmTypesDb = new FestivalTypeOfFilms();
            $allProjectTypes = $filmTypesDb->findAll();
            $this->data['allProjectTypes'] = $allProjectTypes;

            $festival['project_types'] = json_decode($festival['project_types']);
            $festival['award_category_to_show'] = json_decode($festival['award_category_to_show']);
            $festival['awards_to_show'] = json_decode($festival['awards_to_show']);

            $this->data['awardCats'] = $awardCats;

            $awardsDb = new AwardsModel();
            if (count($festival['award_category_to_show'])) {
                foreach ($awardCats as $key => $awardCategory) {
                    if (in_array($awardCategory['id'], $festival['award_category_to_show'])) {
                        $this->data['awardCats'][$key]['awards'] = $awardsDb->where(['category_id' => $awardCategory['id']])->findAll();
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


            $this->data['festival'] = $festival;

            $this->data['pagename'] = $this->data['festival']['name'];
            $deadlineDb = new FestivalDeadlines();

            $deadlines = $deadlineDb->where('festival_id', $id)->orderBy('deadline', 'asc')->findAll();
            $this->data['festival']['deadlines'] = $deadlines;

            if ($this->request->getPost()) {
                if ($this->request->getVar('saveLogo')) {
                    $fData = ['id' => $id];

                    $response['message'] = 'Unable to save logo, please try after some time.';

                    if ($img = $this->request->getFile('logo')) {
                        if ($img->isValid() && !$img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $img->move('public/uploads/logos/yearly/' . $id . '/', $newName);
                            $uploadedPath = '/public/uploads/logos/yearly/' . $id . '/' . $newName;
                            $fData['logo'] = $uploadedPath;
                            if ($this->festivalDb->save($fData)) {
                                $response['message'] = 'Logo saved successfully.';
                                $response['success'] = true;
                            }
                        }
                    } else {
                        $response['message'] = 'No data to update.';
                        $response['success'] = false;
                    }
                    return json_encode($response);
                }
                if ($this->request->getPost('updateData')) {
                    $dataToUpdate = [
                        'id' => $id,
                        $this->request->getPost('columnName') => $this->request->getPost('columnValue')
                    ];
                    $response['message'] = 'Unable to change data, please try after some time.';
                    if ($this->festivalDb->save($dataToUpdate)) {
                        $response['message'] = 'Data updated succesfully.';
                        $response['success'] = true;
                    }
                    return json_encode($response);
                }
                if ($this->request->getPost('saveDeadline')) {
                    $dataToSave = $this->request->getPost();
                    // return json_encode($dataToSave);
                    unset($dataToSave['saveDeadline']);
                    $response['message'] = 'Unable to Add/Update Deadline, please try after some time.';
                    if ($dataToSave['id'] == 0 || $dataToSave['id'] == '0') {
                        unset($dataToSave['id']);
                    }
                    $dataToSave['festival_id'] = $id;
                    $deadlineSaved = $deadlineDb->save($dataToSave);
                    if ($deadlineSaved) {
                        $response['message'] = 'Deadline add/updated succesfully.';
                        $response['success'] = true;
                        if (isset($dataToSave['id'])) {
                            $response['data'] = $dataToSave;
                        } else {
                            $response['data'] = $deadlineDb->where(['festival_id' => $festival['id'], 'name' => $dataToSave['name'], 'deadline' => $dataToSave['deadline']])->first();
                        }
                    }
                    return json_encode($response);
                }
                if ($this->request->getPost('deleteDeadline')) {
                    $response['message'] = 'Unable to delete deadline, please try after some time.';
                    if ($deadlineDb->delete($this->request->getPost('id'))) {
                        $response['message'] = 'Deadline deleted succesfully.';
                        $response['success'] = true;
                    }
                    return json_encode($response);
                }
                if ($this->request->getPost('getDeadline')) {
                    $deadline = $deadlineDb->find($this->request->getPost('id'));
                    $response['message'] = 'Unable to found deadline, please try after some time.';
                    if ($deadline) {
                        $response['success'] = true;
                        $response['data'] = $deadline;
                        $response['message'] = 'Deadline Found.';
                    }
                    return json_encode($response);
                }
                if ($this->request->getPost('awardTypeChange')) {
                    $dataToUpdate = [
                        'id' => $id,
                        $this->request->getPost('type') => $this->request->getPost('value')
                    ];
                    $response['message'] = 'Unable to change data, please try after some time.';
                    if ($this->festivalDb->save($dataToUpdate)) {
                        $response['message'] = 'Data updated succesfully.';
                        $response['success'] = true;
                    }
                    return json_encode($response);
                }
                if ($this->request->getPost('saveAwardCategories')) {
                    $dataToUpdate = [
                        'id' => $id,
                        'award_category_to_show' => json_encode($this->request->getPost('award_category_to_show'))
                    ];
                    $response['message'] = 'Unable to change data, please try after some time.';
                    if ($this->festivalDb->save($dataToUpdate)) {
                        $response['message'] = 'Data updated succesfully.';
                        $response['success'] = true;
                    }
                    return json_encode($response);
                }
                if ($this->request->getPost('saveAwards')) {
                    // return json_encode($this->request->getPost());
                    $dataToUpdate = [
                        'id' => $id,
                        'awards_to_show' => json_encode($this->request->getPost('awards_to_show'))
                    ];
                    $response['message'] = 'Unable to change data, please try after some time.';
                    if ($this->festivalDb->save($dataToUpdate)) {
                        $response['message'] = 'Data updated succesfully.';
                        $response['success'] = true;
                    }
                    return json_encode($response);
                }
                if ($this->request->getPost('saveProjectTypes')) {
                    // return json_encode($this->request->getPost());
                    $dataToUpdate = [
                        'id' => $id,
                        'project_types' => json_encode($this->request->getPost('project_types'))
                    ];
                    $response['message'] = 'Unable to change data, please try after some time.';
                    if ($this->festivalDb->save($dataToUpdate)) {
                        $response['message'] = 'Data updated succesfully.';
                        $response['success'] = true;
                    }
                    return json_encode($response);
                }
                if ($this->request->getPost('changeAwardPriceType')) {
                    // return json_encode($this->request->getPost());
                    $dataToUpdate = [
                        'id' => $id,
                        'awards_prices' => $this->request->getPost('value')
                    ];
                    if ($this->request->getPost('value') == 'global') {
                        $blankArray = array();
                        $dataToUpdate['short_awards_prices'] = json_encode($blankArray);
                        $dataToUpdate['feature_awards_prices'] = json_encode($blankArray);
                    }
                    $response['message'] = 'Unable to change data, please try after some time.';
                    if ($this->festivalDb->save($dataToUpdate)) {
                        $response['message'] = 'Data updated succesfully.';
                        $response['success'] = true;
                        $response['data'] = $dataToUpdate;
                    }
                    return json_encode($response);
                }
                if ($this->request->getPost('saveShortAwardsPrices')) {
                    // return json_encode($this->request->getPost());
                    $awardsData = $this->request->getPost('short_awards_prices');
                    $dataToUpdate = [
                        'id' => $id,
                        'short_awards_prices' => json_encode($awardsData)
                    ];
                    $response['message'] = 'Unable to change data, please try after some time.';
                    if ($this->festivalDb->save($dataToUpdate)) {
                        $response['message'] = 'Data updated succesfully.';
                        $response['success'] = true;
                        $response['data'] = $dataToUpdate;
                    }
                    return json_encode($response);
                }
                if ($this->request->getPost('saveFeatureAwardsPrices')) {
                    // return json_encode($this->request->getPost());
                    $awardsData = $this->request->getPost('feature_awards_prices');
                    $dataToUpdate = [
                        'id' => $id,
                        'feature_awards_prices' => json_encode($awardsData)
                    ];
                    $response['message'] = 'Unable to change data, please try after some time.';
                    if ($this->festivalDb->save($dataToUpdate)) {
                        $response['message'] = 'Data updated succesfully.';
                        $response['success'] = true;
                        $response['data'] = $dataToUpdate;
                    }
                    return json_encode($response);
                }
                if ($this->request->getPost('rulesForm')) {
                    $dataToUpdate = [
                        'id' => $id,
                        'rules' => $this->request->getPost('rules')
                    ];
                    $response['message'] = 'Unable to save rules data, please try after some time.';
                    if ($this->festivalDb->save($dataToUpdate)) {
                        $response['message'] = 'Rules updated succesfully.';
                        $response['success'] = true;
                    }
                    return json_encode($response);
                }
                return json_encode($response);
            }
            return view('Admin/Pages/filmfestivals/festival_details', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }

    // pages only
    public function festivalAbout($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);

        if ($festival) {
            $this->data['festival'] = $festival;

            $aboutDb = new FestivalAbout();
            if ($this->request->getPost('updateData')) {
                if (intval($this->request->getPost('dataId')) > 0) {
                    $dataToUpdate['id'] = $this->request->getPost('dataId');
                }
                $dataToUpdate['festival_id'] = $festival['id'];
                $dataToUpdate[$this->request->getPost('columnName')] = $this->request->getPost('columnValue');
                $response['message'] = 'Unable to change data, please try after some time.';
                if ($aboutDb->save($dataToUpdate)) {
                    $response['message'] = 'Data updated succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }
            $page = $aboutDb->where('festival_id', $id)->first();

            $realPageData = [
                'title' => $page && !empty($page['title']) ? $page['title'] : 'Your Page Title',
                'content' => $page && !empty($page['content']) ? $page['content'] : 'Your page description or content.',
                'icon1' => $page && !empty($page['icon1']) ? $page['icon1'] : 'fa-solid fa-heart',
                'icon_title1' => $page && !empty($page['icon_title1']) ? $page['icon_title1'] : 'box title 1',
                'icon_content1' => $page && !empty($page['icon_content1']) ? $page['icon_content1'] : 'box subtitle 1',
                'icon2' => $page && !empty($page['icon2']) ? $page['icon2'] : 'fa-solid fa-heart',
                'icon_title2' => $page && !empty($page['icon_title2']) ? $page['icon_title2'] : 'box title 2',
                'icon_content2' => $page && !empty($page['icon_content2']) ? $page['icon_content2'] : 'box subtitle 2',
                'icon3' => $page && !empty($page['icon3']) ? $page['icon3'] : 'fa-solid fa-heart',
                'icon_title3' => $page && !empty($page['icon_title3']) ? $page['icon_title3'] : 'box title 3',
                'icon_content3' => $page && !empty($page['icon_content3']) ? $page['icon_content3'] : 'box subtitle 3',
                'icon4' => $page && !empty($page['icon4']) ? $page['icon4'] : 'fa-solid fa-heart',
                'icon_title4' => $page && !empty($page['icon_title4']) ? $page['icon_title4'] : 'box title 4',
                'icon_content4' => $page && !empty($page['icon_content4']) ? $page['icon_content4'] : 'box subtitle 4',
            ];

            $this->data['pagedata'] = $realPageData;
            $this->data['pageId'] = $page && $page['id'] ? $page['id'] : 0;
            $this->data['pagename'] = 'About - ' . $festival['name'];

            $this->data['icons'] = getIcons();

            // print_r($icons);
            // return;

            // return print_r( $this->data['pagedata']);

            return view('Admin/Pages/filmfestivals/festival_details_about_plus_sponsor', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalSponsorshipPromotion($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);

        if ($festival) {
            $this->data['festival'] = $festival;

            $sponsorshipDb = new FestivalSponsorship();
            if ($this->request->getPost('updateData')) {
                if (intval($this->request->getPost('dataId')) > 0) {
                    $dataToUpdate['id'] = $this->request->getPost('dataId');
                }
                $dataToUpdate['festival_id'] = $festival['id'];
                $dataToUpdate[$this->request->getPost('columnName')] = $this->request->getPost('columnValue');
                $response['message'] = 'Unable to change data, please try after some time.';
                if ($sponsorshipDb->save($dataToUpdate)) {
                    $response['message'] = 'Data updated succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }
            $page = $sponsorshipDb->where('festival_id', $id)->first();

            $realPageData = [
                'title' => $page && !empty($page['title']) ? $page['title'] : 'Your Page Title',
                'content' => $page && !empty($page['content']) ? $page['content'] : 'Your page description or content.',
                'icon1' => $page && !empty($page['icon1']) ? $page['icon1'] : 'fa-solid fa-heart',
                'icon_title1' => $page && !empty($page['icon_title1']) ? $page['icon_title1'] : 'box title 1',
                'icon_content1' => $page && !empty($page['icon_content1']) ? $page['icon_content1'] : 'box subtitle 1',
                'icon2' => $page && !empty($page['icon2']) ? $page['icon2'] : 'fa-solid fa-heart',
                'icon_title2' => $page && !empty($page['icon_title2']) ? $page['icon_title2'] : 'box title 2',
                'icon_content2' => $page && !empty($page['icon_content2']) ? $page['icon_content2'] : 'box subtitle 2',
                'icon3' => $page && !empty($page['icon3']) ? $page['icon3'] : 'fa-solid fa-heart',
                'icon_title3' => $page && !empty($page['icon_title3']) ? $page['icon_title3'] : 'box title 3',
                'icon_content3' => $page && !empty($page['icon_content3']) ? $page['icon_content3'] : 'box subtitle 3',
                'icon4' => $page && !empty($page['icon4']) ? $page['icon4'] : 'fa-solid fa-heart',
                'icon_title4' => $page && !empty($page['icon_title4']) ? $page['icon_title4'] : 'box title 4',
                'icon_content4' => $page && !empty($page['icon_content4']) ? $page['icon_content4'] : 'box subtitle 4',
            ];

            $this->data['pagedata'] = $realPageData;
            $this->data['pagedata']['id'] = $page && $page['id'] ? $page['id'] : 0;
            $this->data['pageId'] = $page && $page['id'] ? $page['id'] : 0;
            $this->data['pagename'] = 'Sponsorship & Promotion - ' . $festival['name'];

            $this->data['icons'] = getIcons();

            // print_r($this->data['pagedata']);
            // return;

            // return print_r( $this->data['pagedata']);

            return view('Admin/Pages/filmfestivals/festival_details_about_plus_sponsor', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalAwards($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);

        if ($festival) {
            $this->data['festival'] = $festival;

            $awardsPage = new FestivalAwardsPage();
            $festivalAwardDb = new FestivalAwards();

            if ($this->request->getPost('updateData')) {
                if (intval($this->request->getPost('dataId')) > 0) {
                    $dataToUpdate['id'] = $this->request->getPost('dataId');
                }
                $dataToUpdate['festival_id'] = $festival['id'];
                $dataToUpdate[$this->request->getPost('columnName')] = $this->request->getPost('columnValue');
                $response['message'] = 'Unable to change data, please try after some time.';
                if ($awardsPage->save($dataToUpdate)) {
                    $response['message'] = 'Data updated succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }

            if ($this->request->getPost('addUpdateAward')) {
                $imageValid = true;
                if ($img = $this->request->getFile('image')) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('public/uploads/festival/awards/' . $festival['id'], $newName);
                        $uploadedPath = '/public/uploads/festival/awards/' . $festival['id'] . '/' . $newName;
                        $dataToUpdateAward['image'] = $uploadedPath;
                        $imageValid = true;
                    } else {
                        $imageValid = false;
                    }
                } else {
                    $imageValid = false;
                }

                if (intval($this->request->getPost('id')) > 0) {
                    $dataToUpdateAward['id'] = $this->request->getPost('id');
                } else {
                    if (!$imageValid) {
                        $response['message'] = 'Please select an image before adding new data.';
                        $response['success'] = false;
                        return json_encode($response);
                    }
                }
                $dataToUpdateAward['festival_id'] = $festival['id'];
                $dataToUpdateAward['title'] = $this->request->getPost('title');
                $dataToUpdateAward['content'] = $this->request->getPost('content');

                if ($festivalAwardDb->save($dataToUpdateAward)) {
                    $response['message'] = 'Award Added/Updated succesfully.';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'Unable to change data, please try after some time.';
                    $response['success'] = false;
                }
                return json_encode($response);
            }

            if ($this->request->getPost('deleteFestivalAward')) {
                $response['message'] = 'Unable to delete award, please try after some time.';
                if ($festivalAwardDb->delete($this->request->getPost('id'))) {
                    $imageFile = $this->request->getPost('image');
                    if (file_exists($imageFile)) {
                        @unlink($imageFile);
                    }
                    $response['message'] = 'Award deleted succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }

            $page = $awardsPage->where('festival_id', $id)->first();

            $realPageData = [
                'title' => $page && !empty($page['title']) ? $page['title'] : 'Your Page Title',
                'content' => $page && !empty($page['content']) ? $page['content'] : 'Your page description or content.'
            ];

            $this->data['pagedata'] = $realPageData;
            $this->data['pageId'] = $page && $page['id'] ? $page['id'] : 0;
            $this->data['pagename'] = 'Awards - ' . $festival['name'];

            $festivalAwards = $festivalAwardDb->where('festival_id', $id)->orderBy('id', 'desc')->findAll();
            $this->data['festivalAwards'] = $festivalAwards;

            return view('Admin/Pages/filmfestivals/festival_details_awards', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalShedules($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);

        if ($festival) {
            $this->data['festival'] = $festival;

            $schedulesDb = new FestivalSchedules();

            if ($this->request->getPost('addUpdateSchedule')) {
                $imageValid = true;
                $pdfValid = true;
                if ($img = $this->request->getFile('image')) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('public/uploads/festival/schedule/image/' . $festival['id'], $newName);
                        $uploadedPath = '/public/uploads/festival/schedule/image/' . $festival['id'] . '/' . $newName;
                        $dataToUpdateSchedule['image'] = $uploadedPath;
                        $imageValid = true;
                    } else {
                        $imageValid = false;
                    }
                } else {
                    $imageValid = false;
                }
                if ($img = $this->request->getFile('pdf')) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('public/uploads/festival/schedule/pdf/' . $festival['id'], $newName);
                        $uploadedPath = '/public/uploads/festival/schedule/pdf/' . $festival['id'] . '/' . $newName;
                        $dataToUpdateSchedule['pdf'] = $uploadedPath;
                        $pdfValid = true;
                    } else {
                        $pdfValid = false;
                    }
                } else {
                    $pdfValid = false;
                }


                if (intval($this->request->getPost('id')) > 0) {
                    $dataToUpdateSchedule['id'] = $this->request->getPost('id');
                } else {
                    if (!$imageValid) {
                        $response['message'] = 'Please select an image before adding new data.';
                        $response['success'] = false;
                        return json_encode($response);
                    }
                    if (!$pdfValid) {
                        $response['message'] = 'Please select an PDF Schedule before adding new data.';
                        $response['success'] = false;
                        return json_encode($response);
                    }
                }
                $dataToUpdateSchedule['festival_id'] = $festival['id'];
                $dataToUpdateSchedule['festival_year'] = $this->request->getPost('festival_year');
                $dataToUpdateSchedule['title'] = $this->request->getPost('title');
                $dataToUpdateSchedule['content'] = $this->request->getPost('content');

                if ($schedulesDb->save($dataToUpdateSchedule)) {
                    $response['message'] = 'Schedule Added/Updated succesfully.';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'Unable to change data, please try after some time.';
                    $response['success'] = false;
                }
                return json_encode($response);
            }

            if ($this->request->getPost('deleteFestivalSchedule')) {
                $response['message'] = 'Unable to delete Schedule, please try after some time.';
                if ($schedulesDb->delete($this->request->getPost('id'))) {
                    $imageFile = $this->request->getPost('image');
                    if (file_exists($imageFile)) {
                        @unlink($imageFile);
                    }
                    $response['message'] = 'Schedule deleted succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }

            $this->data['pagename'] = 'Schedules - ' . $festival['name'];

            $festivalSchedules = $schedulesDb->where('festival_id', $id)->orderBy('festival_year', 'desc')->findAll();
            $this->data['festivalSchedules'] = $festivalSchedules;

            return view('Admin/Pages/filmfestivals/festival_details_schedules', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalVenues($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);

        if ($festival) {
            $this->data['festival'] = $festival;

            $pageData = new FestivalVenues();
            $venueItemsDb = new FestivalVenueItem();

            if ($this->request->getPost('updateData')) {
                if (intval($this->request->getPost('dataId')) > 0) {
                    $dataToUpdate['id'] = $this->request->getPost('dataId');
                }
                $dataToUpdate['festival_id'] = $festival['id'];
                $dataToUpdate[$this->request->getPost('columnName')] = $this->request->getPost('columnValue');
                $response['message'] = 'Unable to change data, please try after some time.';
                if ($pageData->save($dataToUpdate)) {
                    $response['message'] = 'Data updated succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }

            if ($this->request->getPost('addUpdateVenue')) {
                $imageValid = true;
                if ($img = $this->request->getFile('image')) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('public/uploads/festival/venue/' . $festival['id'], $newName);
                        $uploadedPath = '/public/uploads/festival/venue/' . $festival['id'] . '/' . $newName;
                        $dataToUpdateVenue['image'] = $uploadedPath;
                        $imageValid = true;
                    } else {
                        $imageValid = false;
                    }
                } else {
                    $imageValid = false;
                }

                if (intval($this->request->getPost('id')) > 0) {
                    $dataToUpdateVenue['id'] = $this->request->getPost('id');
                } else {
                    if (!$imageValid) {
                        $response['message'] = 'Please select an image before adding new data.';
                        $response['success'] = false;
                        return json_encode($response);
                    }
                }
                $dataToUpdateVenue['festival_id'] = $festival['id'];
                $dataToUpdateVenue['festival_year'] = $this->request->getPost('festival_year');
                $dataToUpdateVenue['title'] = $this->request->getPost('title');
                $dataToUpdateVenue['content'] = $this->request->getPost('content');

                if ($venueItemsDb->save($dataToUpdateVenue)) {
                    $response['message'] = 'Venue Added/Updated succesfully.';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'Unable to change data, please try after some time.';
                    $response['success'] = false;
                }
                return json_encode($response);
            }

            if ($this->request->getPost('deleteFestivalVenue')) {
                $response['message'] = 'Unable to delete venue, please try after some time.';
                if ($venueItemsDb->delete($this->request->getPost('id'))) {
                    $imageFile = $this->request->getPost('image');
                    if (file_exists($imageFile)) {
                        @unlink($imageFile);
                    }
                    $response['message'] = 'Venue deleted succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }

            $page = $pageData->where('festival_id', $id)->first();

            $realPageData = [
                'title' => $page && !empty($page['title']) ? $page['title'] : 'Your Page Title',
                'content' => $page && !empty($page['content']) ? $page['content'] : 'Your page description or content.'
            ];

            $this->data['pagedata'] = $realPageData;
            $this->data['pageId'] = $page && $page['id'] ? $page['id'] : 0;
            $this->data['pagename'] = 'Venues - ' . $festival['name'];

            $festivalVenues = $venueItemsDb->where('festival_id', $id)->orderBy('id', 'desc')->findAll();
            $this->data['festivalVenues'] = $festivalVenues;

            return view('Admin/Pages/filmfestivals/festival_details_venues', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function dynamicPagesHeaders($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);

        if ($festival) {
            $this->data['festival'] = $festival;

            $pageDb = new DynamicPagesData();
            if ($this->request->getPost('updateData')) {
                if (intval($this->request->getPost('dataId')) > 0) {
                    $dataToUpdate['id'] = $this->request->getPost('dataId');
                }
                $dataToUpdate['festival_id'] = $festival['id'];
                $dataToUpdate[$this->request->getPost('columnName')] = $this->request->getPost('columnValue');
                $response['message'] = 'Unable to change data, please try after some time.';
                if ($pageDb->save($dataToUpdate)) {
                    $response['message'] = 'Data updated succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }
            if ($this->request->getPost('deleteData')) {
                if (intval($this->request->getPost('dataId')) > 0) {
                    $dataToUpdate['id'] = $this->request->getPost('dataId');
                }
                $dataToUpdate['festival_id'] = $festival['id'];
                $dataToUpdate[$this->request->getPost('columnName')] = NULL;
                $response['message'] = 'Unable to change data, please try after some time.';
                if ($pageDb->save($dataToUpdate)) {
                    $response['message'] = 'Data updated succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }
            $nopageData = [
                'team_title' => '',
                'team_content' => '',
                'volunteer_title' => '',
                'volunteer_content' => '',
                'schedule_title' => '',
                'schedule_content' => '',
                'delegate_title' => '',
                'delegate_content' => '',
                'support_title' => '',
                'support_content' => '',
                'winners_title' => '',
                'winners_content' => '',
                'entry_form_title' => '',
                'entry_form_content' => '',
                'official_selection_title' => '',
                'official_selection_content' => '',
                'jury_title' => '',
                'jury_content' => '',
                'gallery_title' => '',
                'gallery_content' => '',
                'filmmakers_title' => '',
                'filmmakers_content' => '',
                'knowledge_center_title' => '',
                'knowledge_center_content' => '',
                'press_title' => '',
                'press_content' => ''
            ];
            $pagedata = $pageDb->where('festival_id', $id)->first();

            $this->data['pagedata'] = $pagedata ? $pagedata : $nopageData;
            $this->data['pageId'] = $pagedata && $pagedata['id'] ? $pagedata['id'] : 0;
            $this->data['pagename'] = 'Pages Data - ' . $festival['name'];
            $this->data['totalPages'] = array(
                array(
                    'name' => 'Team',
                    'key' => 'team_'
                ),
                array(
                    'name' => 'Volunteer',
                    'key' => 'volunteer_'
                ),
                array(
                    'name' => 'Schedule',
                    'key' => 'schedule_'
                ),
                array(
                    'name' => 'Delegate Registration',
                    'key' => 'delegate_'
                ),
                array(
                    'name' => 'Support',
                    'key' => 'support_'
                ),
                array(
                    'name' => 'Winners',
                    'key' => 'winners_'
                ),
                array(
                    'name' => 'Entry Form',
                    'key' => 'entry_form_'
                ),
                array(
                    'name' => 'Official Selection',
                    'key' => 'official_selection_'
                ),
                array(
                    'name' => 'Juries',
                    'key' => 'jury_'
                ),
                array(
                    'name' => 'Gallery',
                    'key' => 'gallery_'
                ),
                array(
                    'name' => 'Film Makers',
                    'key' => 'filmmakers_'
                ),
                array(
                    'name' => 'Knowledge Center',
                    'key' => 'knowledge_center_'
                ),
                array(
                    'name' => 'Press',
                    'key' => 'press_'
                ),
            );


            return view('Admin/Pages/filmfestivals/festival_details_pages_dynamic_data', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }

    public function festivalFilmzine($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);

        if ($festival) {
            $this->data['festival'] = $festival;

            $filmzineModule = new FilmzinetoModule();
            $filmzineData = $filmzineModule->distinct()
                ->select('filmzinetomodules.*, filmzine.title, filmzine.type_id')
                ->join('filmzine', 'filmzine.id = filmzinetomodules.news_id')
                ->where('filmzinetomodules.table_name', 'festival')
                ->where('filmzinetomodules.data_id', $id)
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
                    'table_name' => 'festival',
                    'data_id'  => $id
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

            return view('Admin/Pages/filmfestivals/festival_filmzine', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }

    // dynamic
    public function festivalEvents($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);
        $this->data['festival'] = $festival;

        if ($festival) {
            return view('Admin/Pages/filmfestivals/festival_details_events', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalTeam($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);

        if ($festival) {
            $this->data['festival'] = $festival;

            $teamDb = new FestivalTeam();

            if ($this->request->getPost('addUpdateTeam')) {
                $imageValid = true;
                if ($img = $this->request->getFile('image')) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('public/uploads/festival/team/image/' . $festival['id'], $newName);
                        $uploadedPath = '/public/uploads/festival/team/image/' . $festival['id'] . '/' . $newName;
                        $dataToUpdate['image'] = $uploadedPath;
                        $imageValid = true;
                    } else {
                        $imageValid = false;
                    }
                } else {
                    $imageValid = false;
                }

                if (intval($this->request->getPost('id')) > 0) {
                    $dataToUpdate['id'] = $this->request->getPost('id');
                } else {
                    if (!$imageValid) {
                        $response['message'] = 'Please select an image before adding new data.';
                        $response['success'] = false;
                        return json_encode($response);
                    }
                }
                $dataToUpdate['festival_id'] = $festival['id'];
                $dataToUpdate['first_name'] = $this->request->getPost('first_name');
                $dataToUpdate['last_name'] = $this->request->getPost('last_name');
                $dataToUpdate['profession'] = $this->request->getPost('profession');
                $dataToUpdate['about'] = $this->request->getPost('about');

                if ($teamDb->save($dataToUpdate)) {
                    $response['message'] = 'Team Member Added/Updated succesfully.';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'Unable to change data, please try after some time.';
                    $response['success'] = false;
                }
                return json_encode($response);
            }

            if ($this->request->getPost('deleteMember')) {
                $response['message'] = 'Unable to delete team member, please try after some time.';
                if ($teamDb->delete($this->request->getPost('id'))) {
                    $imageFile = $this->request->getPost('image');
                    if (file_exists($imageFile)) {
                        @unlink($imageFile);
                    }
                    $response['message'] = 'Team member deleted succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }
            if ($this->request->getPost('getMember')) {
                $response['message'] = 'Unable to find team member, please try after some time.';
                if ($member = $teamDb->find($this->request->getPost('id'))) {
                    $response['message'] = 'Team member found succesfully.';
                    $response['success'] = true;
                    $response['data'] = $member;
                }
                return json_encode($response);
            }

            $this->data['pagename'] = 'Team - ' . $festival['name'];

            $festivalTeamMembers = $teamDb->where('festival_id', $id)->orderBy('id', 'desc')->findAll();
            $this->data['festivalTeamMembers'] = $festivalTeamMembers;

            // return print_r($festivalTeamMembers);

            return view('Admin/Pages/filmfestivals/festival_details_team', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalJuries($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);

        if ($festival) {
            $this->data['festival'] = $festival;

            $juryDb = new FestivalJury();

            if ($this->request->getPost('appUpdateJury')) {
                $imageValid = true;
                if ($img = $this->request->getFile('image')) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('public/uploads/festival/jury/image/' . $festival['id'], $newName);
                        $uploadedPath = '/public/uploads/festival/jury/image/' . $festival['id'] . '/' . $newName;
                        $dataToUpdate['image'] = $uploadedPath;
                        $imageValid = true;
                    } else {
                        $imageValid = false;
                    }
                } else {
                    $imageValid = false;
                }

                if (intval($this->request->getPost('id')) > 0) {
                    $dataToUpdate['id'] = $this->request->getPost('id');
                } else {
                    if (!$imageValid) {
                        $response['message'] = 'Please select an image before adding new data.';
                        $response['success'] = false;
                        return json_encode($response);
                    }
                }
                $dataToUpdate['festival_id'] = $festival['id'];
                $dataToUpdate['festival_year'] = $this->request->getPost('festival_year');
                $dataToUpdate['first_name'] = $this->request->getPost('first_name');
                $dataToUpdate['last_name'] = $this->request->getPost('last_name');
                $dataToUpdate['profession'] = $this->request->getPost('profession');
                $dataToUpdate['about'] = $this->request->getPost('about');

                // $dataToUpdate['facebook'] = $this->request->getPost('facebook');
                // $dataToUpdate['twitter'] = $this->request->getPost('twitter');
                // $dataToUpdate['instagram'] = $this->request->getPost('instagram');
                // $dataToUpdate['whatsapp'] = $this->request->getPost('whatsapp');

                $dataToUpdate['title'] = $this->request->getPost('title');
                $dataToUpdate['content'] = $this->request->getPost('content');

                $dataToUpdate['video'] = $this->request->getPost('video');

                if ($juryDb->save($dataToUpdate)) {
                    $response['message'] = 'Jury Added/Updated succesfully.';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'Unable to change data, please try after some time.';
                    $response['success'] = false;
                }
                return json_encode($response);
            }

            if ($this->request->getPost('deleteMember')) {
                $response['message'] = 'Unable to delete jury, please try after some time.';
                if ($juryDb->delete($this->request->getPost('id'))) {
                    $imageFile = $this->request->getPost('image');
                    if (file_exists($imageFile)) {
                        @unlink($imageFile);
                    }
                    $response['message'] = 'Jury deleted succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }
            if ($this->request->getPost('getJury')) {

                $response['message'] = 'Unable to find jury, please try after some time.';
                if ($member = $juryDb->find($this->request->getPost('id'))) {
                    $response['message'] = 'Jury found succesfully.';
                    $response['success'] = true;
                    $response['data'] = $member;
                }
                return json_encode($response);
            }
            if ($this->request->getPost('addJuryGallery')) {
                $dataToUpdate['jury_id'] = $this->request->getPost('id');
                if ($imagefile = $this->request->getFiles()) {
                    foreach ($imagefile['galleryImages'] as $key => $img) {
                        if ($img->isValid() && !$img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $img->move('public/uploads/festival/jury/gallery/' . $festival['id'], $newName);
                            $uploadedPath = '/public/uploads/festival/jury/gallery/' . $festival['id'] . '/' . $newName;
                            $dataToUpdate['image'] = $uploadedPath;

                            $galleryDb = new FestivalJuryGallery();
                            if ($insertId = $galleryDb->insertID($galleryDb->save($dataToUpdate))) {
                                $response['success'] = true;
                                $response['data'][]['key'] = $key;
                                $response['data'][]['id'] = $insertId;
                            }
                        }
                    }
                }
                return json_encode($response);
            }
            if ($this->request->getPost('getJuryGallery')) {
                $response['message'] = 'Unable to find gallery, please try after some time.';
                $galleryDb = new FestivalJuryGallery();
                if ($gallery = $galleryDb->where('jury_id', $this->request->getPost('jury_id'))->findAll()) {
                    if (count($gallery)) {
                        $response['message'] = 'Found succesfully.';
                        $response['success'] = true;
                        $response['data'] = $gallery;
                    }
                }
                return json_encode($response);
            }
            if ($this->request->getPost('deleteGalleryImage')) {
                $response['message'] = 'Unable to delete gallery image, please try after some time.';
                $galleryDb = new FestivalJuryGallery();
                $gallery = $galleryDb->find($this->request->getPost('id'));
                if ($galleryDb->delete($gallery['id'])) {
                    $imageFile = $gallery['image'];
                    if (file_exists($imageFile)) {
                        @unlink($imageFile);
                    }
                    $response['message'] = 'Gallery Image deleted succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }

            $this->data['pagename'] = 'Jury - ' . $festival['name'];

            $juryMembers = $juryDb->where('festival_id', $id)->orderBy('id', 'desc')->findAll();
            $this->data['juryMembers'] = $juryMembers;

            // return print_r($juryMembers);

            return view('Admin/Pages/filmfestivals/festival_details_jury', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalGallery($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);

        if ($festival) {
            $this->data['festival'] = $festival;

            $entityDb = new FestivalGallery();

            if ($this->request->getPost('add_banner')) {
                $imageValid = true;
                if ($img = $this->request->getFile('image')) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('public/uploads/festival/gallery/' . $festival['id'], $newName);
                        $uploadedPath = '/public/uploads/festival/gallery/' . $festival['id'] . '/' . $newName;
                        $dataToUpdate['image'] = $uploadedPath;
                        $imageValid = true;
                    } else {
                        $imageValid = false;
                    }
                } else {
                    $imageValid = false;
                }

                if (intval($this->request->getPost('id')) > 0) {
                    $dataToUpdate['id'] = $this->request->getPost('id');
                } else {
                    if (!$imageValid) {
                        $response['message'] = 'Please select an image before adding new data.';
                        $response['success'] = false;
                        return json_encode($response);
                    }
                }
                $dataToUpdate['festival_id'] = $festival['id'];
                $dataToUpdate['caption'] = trim($this->request->getPost('caption'));

                if ($entityDb->save($dataToUpdate)) {
                    $response['message'] = 'Added/Updated succesfully.';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'Unable to change data, please try after some time.';
                    $response['success'] = false;
                }
                return json_encode($response);
            }

            if ($this->request->getPost('deleteBanner')) {
                $response['message'] = 'Unable to delete, please try after some time.';
                if ($entityDb->delete($this->request->getPost('id'))) {
                    $imageFile = $this->request->getPost('image');
                    if (file_exists($imageFile)) {
                        @unlink($imageFile);
                    }
                    $response['message'] = 'Deleted succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }

            $this->data['pagename'] = 'Gallery - ' . $festival['name'];

            $entity = $entityDb->where('festival_id', $id)->orderBy('id', 'desc')->findAll();
            $this->data['entities'] = $entity;

            return view('Admin/Pages/filmfestivals/festival_details_gallery', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalBanners($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);

        if ($festival) {
            $this->data['festival'] = $festival;

            $entityDb = new FestivalBanners();

            if ($this->request->getPost('add_banner')) {
                if ($img = $this->request->getFile('image')) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('public/uploads/festival/banners/' . $festival['id'], $newName);
                        $uploadedPath = '/public/uploads/festival/banners/' . $festival['id'] . '/' . $newName;
                        $dataToUpdate['image'] = $uploadedPath;
                    }
                }

                $dataToUpdate['festival_id'] = $festival['id'];

                if ($entityDb->save($dataToUpdate)) {
                    $response['message'] = 'Added succesfully.';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'Unable to add image, please try after some time.';
                    $response['success'] = false;
                }
                return json_encode($response);
            }

            if ($this->request->getPost('deleteBanner')) {
                $response['message'] = 'Unable to delete, please try after some time.';
                if ($entityDb->delete($this->request->getPost('id'))) {
                    $imageFile = $this->request->getPost('image');
                    if (file_exists($imageFile)) {
                        @unlink($imageFile);
                    }
                    $response['message'] = 'Deleted succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }

            $this->data['pagename'] = 'Banners - ' . $festival['name'];

            $entity = $entityDb->where('festival_id', $id)->orderBy('id', 'desc')->findAll();
            $this->data['entities'] = $entity;

            return view('Admin/Pages/filmfestivals/festival_details_banners', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalPress($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);

        if ($festival) {
            $this->data['festival'] = $festival;

            $entityDb = new FestivalPress();

            if ($this->request->getPost('addUpdateData')) {
                if (intval($this->request->getPost('id')) > 0) {
                    $dataToUpdate['id'] = $this->request->getPost('id');
                }
                $dataToUpdate['festival_id'] = $festival['id'];
                $dataToUpdate['festival_year'] = $this->request->getPost('festival_year');
                $dataToUpdate['title'] = $this->request->getPost('title');
                $dataToUpdate['url'] = $this->request->getPost('url');

                if ($entityDb->save($dataToUpdate)) {
                    $response['message'] = 'Added/Updated succesfully.';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'Unable to change data, please try after some time.';
                    $response['success'] = false;
                }
                return json_encode($response);
            }

            if ($this->request->getPost('deleteData')) {
                $response['message'] = 'Unable to delete, please try after some time.';
                if ($entityDb->delete($this->request->getPost('id'))) {
                    $response['message'] = 'Deleted succesfully.';
                    $response['success'] = true;
                }
                return json_encode($response);
            }

            $this->data['pagename'] = 'Press - ' . $festival['name'];

            $entity = $entityDb->where('festival_id', $id)->orderBy('festival_year', 'desc')->findAll();
            $this->data['entities'] = $entity;

            return view('Admin/Pages/filmfestivals/festival_details_press', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }

    // form submitions
    public function festivalMovieSubmitions($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);
        $this->data['festival'] = $festival;

        if ($festival) {
            return view('Admin/Pages/filmfestivals/festival_details_movie_submitions', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalDelegate($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);
        $this->data['festival'] = $festival;

        if ($festival) {
            return view('Admin/Pages/filmfestivals/festival_details_delegate', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalDelegatePackages($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);
        $this->data['festival'] = $festival;

        if ($festival) {
            $packagesDb = new FestivalDelegatePackages();
            $allPackages = $packagesDb->where('festival_id', $festival['id'])->findAll();
            $this->data['allPackages'] = $allPackages;

            if ($this->request->getPost('addUpdate')) {
                if (intval($this->request->getPost('id')) > 0) {
                    $dataToUpdate['id'] = $this->request->getPost('id');
                }
                $dataToUpdate['festival_id'] = $festival['id'];
                $dataToUpdate['details'] = $this->request->getPost('details');
                $dataToUpdate['fee_inr'] = $this->request->getPost('fee_inr');
                $dataToUpdate['fee_eur'] = $this->request->getPost('fee_eur');

                if ($packagesDb->save($dataToUpdate)) {
                    $response['message'] = 'Package Added/Updated succesfully.';
                    $response['success'] = true;
                } else {
                    $response['message'] = 'Unable to change data, please try after some time.';
                    $response['success'] = false;
                }
                return json_encode($response);
            }
            return view('Admin/Pages/filmfestivals/festival_details_delegate_packages', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalVolunteers($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);
        $this->data['festival'] = $festival;

        if ($festival) {

            $volunteerDb = new FestivalVolunteer();
            $volunteers = $volunteerDb->distinct()
                ->select('festival_volunteers.*, countries.name as country, states.name as state, cities.name as city')
                ->join('countries', 'countries.id = festival_volunteers.country')
                ->join('states', 'states.id = festival_volunteers.state')
                ->join('cities', 'cities.id = festival_volunteers.city')
                ->where(['festival_volunteers.festival_id' => $festival['id'], 'festival_volunteers.festival_year' => $festival['current_year']])
                ->findAll();

            $this->data['volunteers'] = $volunteers;

            $this->data['pagename'] = 'Volunteers - ' . $festival['name'];
            return view('Admin/Pages/filmfestivals/festival_details_volunteer', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalSupport($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);
        $this->data['festival'] = $festival;

        if ($festival) {
            return view('Admin/Pages/filmfestivals/festival_details_support', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }

    // administration
    public function festivalSelections($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);
        $this->data['festival'] = $festival;

        if ($festival) {
            return view('Admin/Pages/filmfestivals/festival_details_official_selections', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }
    public function festivalWinners($id)
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        $festival = $this->festivalDb->find($id);
        $this->data['festival'] = $festival;

        if ($festival) {
            return view('Admin/Pages/filmfestivals/festival_details_winners', $this->data);
        } else {
            return redirect()->route('admin_film_festivals');
        }
    }

    public function checkout()
    {
    }
}
