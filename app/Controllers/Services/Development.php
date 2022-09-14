<?php

namespace App\Controllers\Services;

use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Knp\Snappy\Pdf;
use TCPDF;

class Development extends Controller
{
    public function index()
    {
        //
    }
    public function email($type = 'others')
    {
        helper(['number']);

        $currency = 'USD';
        // $currency_symbol = '&#8377;';

        $data['currency'] = $currency;
        // $data['currency_symbol'] = $currency_symbol;
        $data['type_of_action'] = 'Registration';

        $data['user_name'] = 'Chaudhary Ahtesham';
        $data['user_address'] = '143/3, 4th floor, Zakir Nagar, Jamia Nagar, New Delhi, 110025';
        $data['type_of_action'] = 'Delegate Registration';

        if ($type == 'receipt') {
            $data['receipt_number'] = strtoupper('77d7ac4daabc8');
            $data['items'] = array(
                array(
                    'name' => 'Ticket details',
                    'amount' => number_to_currency(2000, $currency, 'en_US', 2)
                ),
                array(
                    'name' => 'Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ ',
                    'amount' => number_to_currency(800, $currency, 'en_US', 2)
                )
            );
            $data['taxes'] = array(
                'name' => 'GST 18%',
                'amount' => number_to_currency(504, $currency, 'en_US', 2)
            );
            $data['total'] = number_to_currency(3304, $currency, 'en_US', 2);
        }

        return view('Components/emails/' . $type, $data);
    }
    public function invoice()
    {
        //
    }
    public function ticket()
    {
        //
    }
    public function htmlToPdf($id)
    {
        // 'type', = 'welcome','receipt','ticket','invoice','email_validation','otp','password_reset','others'

        // test here start
        helper(['number']);

        $currency = 'INR';
        $currency_symbol = '&#8377;';

        $data['currency'] = $currency;
        $data['currency_symbol'] = $currency_symbol;

        $data['user_name'] = 'Chaudhary Ahtesham';
        $data['user_address'] = '143/3, 4th floor, Zakir Nagar, Jamia Nagar, New Delhi, 110025';
        $data['type_of_action'] = 'Delegate Registration';

        $data['receipt_number'] = strtoupper('77d7ac4daabc8');
        $data['items'] = array(
            array(
                'name' => 'Ticket details',
                'amount' => number_to_currency(2000, $currency, 'en_US', 2)
            ),
            array(
                'name' => 'Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ ',
                'amount' => number_to_currency(800, $currency, 'en_US', 2)
            ),
            array(
                'name' => 'Ticket details',
                'amount' => number_to_currency(2000, $currency, 'en_US', 2)
            ),
            array(
                'name' => 'Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ ',
                'amount' => number_to_currency(800, $currency, 'en_US', 2)
            ),
            array(
                'name' => 'Ticket details',
                'amount' => number_to_currency(2000, $currency, 'en_US', 2)
            ),
            array(
                'name' => 'Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ ',
                'amount' => number_to_currency(800, $currency, 'en_US', 2)
            ),
            array(
                'name' => 'Ticket details',
                'amount' => number_to_currency(2000, $currency, 'en_US', 2)
            ),
            array(
                'name' => 'Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ Ticket details XYZ ',
                'amount' => number_to_currency(800, $currency, 'en_US', 2)
            ),
        );
        $data['taxes'] = array(
            'name' => 'GST 18%',
            'amount' => number_to_currency(504, $currency, 'en_US', 2)
        );
        $data['total'] = number_to_currency(3304, $currency, 'en_US', 2);
        // test here ends

        // $html = `view('Components/emails/receipt', $data);`
        $html = view('Components/emails/receipt', $data);
        $html = '<h4>PDF Example</h4><br><p>Welcome to the Jungle</p>';

        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();
        ob_clean();
        return $pdf->Output('example_006.pdf', 'I');
        
        // return $html;


    }
}
