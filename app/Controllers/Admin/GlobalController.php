<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Festival\FestivalOfficialSubmission;
use App\Models\Payment\OrderModel;

class GlobalController extends BaseController
{
    public function __construct()
    {
    }
    public function index()
    {
        if ($this->request->getPost()) {
            return json_encode($this->indexPostHandler($this->request->getPost()));
        }
        $ordersMd = new OrderModel();
        $completedOrdersPaypal = 0;
        $query = $ordersMd->select('amount')->where(['payment_status' => 'completed', 'gateway' => 'paypal'])->findAll();
        foreach ($query as $key => $value) {
            $completedOrdersPaypal = $completedOrdersPaypal + floatval($value['amount']);
        }
        // return print_r($completedOrdersPaypal);

        $completedOrdersRazorpay = 0;
        $query = $ordersMd->select('amount')->where(['payment_status' => 'completed', 'gateway' => 'razorpay'])->findAll();
        foreach ($query as $key => $value) {
            $completedOrdersRazorpay = $completedOrdersRazorpay + floatval($value['amount']);
        }
        // return print_r($completedOrdersRazorpay);

        $failedOrdersPaypal = 0;
        $query = $ordersMd->select('amount')->where(['payment_status !=' => 'completed', 'gateway' => 'paypal', 'order_id !=' => NULL])->findAll();
        foreach ($query as $key => $value) {
            $failedOrdersPaypal = $failedOrdersPaypal + floatval($value['amount']);
        }
        // return print_r($failedOrdersPaypal);

        $failedOrdersRazorpay = 0;
        $query = $ordersMd->select('amount')->where(['payment_status !=' => 'completed', 'gateway' => 'razorpay', 'order_id !=' => NULL])->findAll();
        foreach ($query as $key => $value) {
            $failedOrdersRazorpay = $failedOrdersRazorpay + floatval($value['amount']);
        }
        // return print_r($failedOrdersRazorpay);

        $otherOrdersPaypal = 0;
        $query = $ordersMd->select('amount')->where(['gateway' => 'paypal', 'order_id is' => NULL])->findAll();
        foreach ($query as $key => $value) {
            $otherOrdersPaypal = $otherOrdersPaypal + floatval($value['amount']);
        }
        // return print_r($totalOrdersPaypal);

        $otherOrdersRazorpay = 0;
        $query = $ordersMd->select('amount')->where(['gateway' => 'razorpay', 'order_id is' => NULL])->findAll();
        foreach ($query as $key => $value) {
            $otherOrdersRazorpay = $otherOrdersRazorpay + floatval($value['amount']);
        }
        // return print_r($totalOrdersRazorpay);

        $paypalPayments = array(
            'gateway' => 'paypal',
            'currency' => 'EUR',
            'name' => 'PayPal',
            'other' => $otherOrdersPaypal,
            'completed' => $completedOrdersPaypal,
            'failed' => $failedOrdersPaypal,
            'total' => $otherOrdersPaypal + $completedOrdersPaypal + $failedOrdersPaypal,
            // 'other_currency' => number_to_currency($otherOrdersPaypal, 'EUR', 'en_US', 2),
            'completed_currency' => number_to_currency($completedOrdersPaypal, 'EUR', 'en_US', 2),
            'failed_currency' => number_to_currency($failedOrdersPaypal, 'EUR', 'en_US', 2),
            'total_currency' => number_to_currency($otherOrdersPaypal + $completedOrdersPaypal + $failedOrdersPaypal, 'EUR', 'en_US', 2),
        );
        $this->data['paypalPayments'] = $paypalPayments;
        $razorpayPayments = array(
            'gateway' => 'razorpay',
            'currency' => 'INR',
            'name' => 'Razorpay',
            'other' => $otherOrdersRazorpay,
            'completed' => $completedOrdersRazorpay,
            'failed' => $failedOrdersRazorpay,
            'total' => $otherOrdersRazorpay + $completedOrdersRazorpay + $failedOrdersRazorpay,
            // 'other_currency' => number_to_currency($otherOrdersRazorpay, 'INR', 'en_US', 2),
            'completed_currency' => number_to_currency($completedOrdersRazorpay, 'INR', 'en_US', 2),
            'failed_currency' => number_to_currency($failedOrdersRazorpay, 'INR', 'en_US', 2),
            'total_currency' => number_to_currency($otherOrdersRazorpay + $completedOrdersRazorpay + $failedOrdersRazorpay, 'INR', 'en_US', 2),
        );
        $this->data['razorpayPayments'] = $razorpayPayments;

        // $festivalEntries
        // return print_r($paymentAmounts);

        // $completedOrdersRazorpay = $ordersMd->select('amount')->where('payment_status', 'completed')->findAll();

        // return print_r(session()->get('user'));

        $this->data['dashboard'] = true;

        return view('Admin/Pages/dashboard', $this->data);
    }

    private function indexPostHandler($postData)
    {
        if ($postData['festivalEntries']) {
            return $this->getFestivalEntries($postData['festivalEntries']);
        }
    }
    private function getFestivalEntries($type = 'new')
    {
        $response = ['success' => false, 'message' => 'No data found'];
        $submissionsDb = new FestivalOfficialSubmission();
        $select = 'official_submissions.id, official_submissions.festival_id, official_submissions.title, official_submissions.trailer, official_submissions.year, official_submissions.country, official_submissions.genres, official_submissions.created_at, official_submissions.updated_at,';
        $select .= 'festivals.name as festival_name, countries.name as country_name';
        if ($type == 'new') {
            $submissions = $submissionsDb->distinct()
                ->select($select)
                ->join('festivals', 'festivals.id = official_submissions.festival_id')
                ->join('countries', 'countries.id = official_submissions.country')
                ->where(['official_submissions.allsteps !=' => 'locked',])
                ->where(['official_submissions.approved' => 0])
                // ->where(['official_submissions.edit_status !=' => 'completed'])
                ->where(['official_submissions.edit_status !=' => 'completed'])
                ->findAll(5);
            $counts = $submissionsDb->select('id')->where(['allsteps !=' => 'locked', 'approved !=' => 1, 'edit_status !=' => 'completed'])->countAllResults();
            foreach ($submissions as $key => $submission) {
                $submissions[$key]['key'] = $key + 1;
                // $submissions[$key]['status'] = 'status';

                $openingLink = route_to('admin_film_festivals_official_submissions_single', $submission['id']);
                $submissions[$key]['openingLink'] = 'openingLink';
                // $submissions[$key]['actions'] = '<a class="btn btn-icon btn-dim btn-primary btn-sm" href="' . $openingLink . '"><em class="icon ni ni-external"></em></a>';
                // $submissions[$key]['title'] = '<a href="' . $openingLink . '">' . $submission['title'] . '</a>';

                $submissions[$key]['genres'] = json_decode($submission['genres'], true);
                $submissions[$key]['created_at'] = date('d M, Y', strtotime($submission['created_at']));
                $submissions[$key]['updated_at'] = date('d M, Y', strtotime($submission['updated_at']));
            }
            if ($submissions) {
                $response['success'] = true;
                $response['data'] = $submissions;
                $response['counts'] = $counts;
            }
        }
        if ($type == 'review') {
            $submissions = $submissionsDb->distinct()
                ->select($select)
                ->join('festivals', 'festivals.id = official_submissions.festival_id')
                ->join('countries', 'countries.id = official_submissions.country')
                ->where(['official_submissions.allsteps' => 'locked', 'official_submissions.approved' => 4])
                ->findAll(5);
            $counts = $submissionsDb->select('id')->where(['allsteps' => 'locked', 'approved' => 4])->countAllResults();
            foreach ($submissions as $key => $submission) {
                $submissions[$key]['key'] = $key + 1;
                // $submissions[$key]['status'] = 'status';

                $openingLink = route_to('admin_film_festivals_official_submissions_single', $submission['id']);
                $submissions[$key]['openingLink'] = 'openingLink';
                // $submissions[$key]['actions'] = '<a class="btn btn-icon btn-dim btn-primary btn-sm" href="' . $openingLink . '"><em class="icon ni ni-external"></em></a>';
                // $submissions[$key]['title'] = '<a href="' . $openingLink . '">' . $submission['title'] . '</a>';

                $submissions[$key]['genres'] = json_decode($submission['genres'], true);
                $submissions[$key]['created_at'] = date('d M, Y', strtotime($submission['created_at']));
                $submissions[$key]['updated_at'] = date('d M, Y', strtotime($submission['updated_at']));
            }
            if ($submissions) {
                $response['success'] = true;
                $response['data'] = $submissions;
                $response['counts'] = $counts;
            }
        }
        if ($type == 'approval') {
            $submissions = $submissionsDb->distinct()
                ->select($select)
                ->join('festivals', 'festivals.id = official_submissions.festival_id')
                ->join('countries', 'countries.id = official_submissions.country')
                ->where(['official_submissions.allsteps' => 'locked'])
                ->where(['official_submissions.approved' => 0])
                ->findAll(5);
            $counts = $submissionsDb->select('id')->where(['allsteps' => 'locked', 'approved' => 0])->countAllResults();
            foreach ($submissions as $key => $submission) {
                $submissions[$key]['key'] = $key + 1;
                // $submissions[$key]['status'] = 'status';

                $openingLink = route_to('admin_film_festivals_official_submissions_single', $submission['id']);
                $submissions[$key]['openingLink'] = 'openingLink';
                // $submissions[$key]['actions'] = '<a class="btn btn-icon btn-dim btn-primary btn-sm" href="' . $openingLink . '"><em class="icon ni ni-external"></em></a>';
                // $submissions[$key]['title'] = '<a href="' . $openingLink . '">' . $submission['title'] . '</a>';

                $submissions[$key]['genres'] = json_decode($submission['genres'], true);
                $submissions[$key]['created_at'] = date('d M, Y', strtotime($submission['created_at']));
                $submissions[$key]['updated_at'] = date('d M, Y', strtotime($submission['updated_at']));
            }
            if ($submissions) {
                $response['success'] = true;
                $response['data'] = $submissions;
                $response['counts'] = $counts;
            }
        }
        return $response;
    }
}
