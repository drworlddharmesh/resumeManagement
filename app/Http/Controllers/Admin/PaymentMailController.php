<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use GuzzleHttp\Client;
use App\Models\User;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Exception;
use Illuminate\Http\Request;
use Mail;
use Session;

class PaymentMailController extends Controller {
    protected $common;

    public function __construct(Request $request) {
        $this->common = new Common;
    }

    public function PaymentMail(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        return view('admin.paymentmail.paymentmail');
    }

    public function PaymentMailSend(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $UserRegistration = $request->UserRegistrationId;
      //  $Phone            = $request->Phone;

        date_default_timezone_set('Asia/Kolkata');
        $CurrentDate         = date("Y-m-d");
        $UserRegistrationIds = explode("\n", str_replace("\r", "", $UserRegistration));

        foreach ($UserRegistrationIds as $UserRegistrationId) {
            try {
                $UserData = User::where('UserRegistrationId', $UserRegistrationId)
                    ->first();
                $Invoice = $this->common->GenerateOTP();
                $Data    = [
                    'UserName'     => $UserData->UserName,
                    'Phone'        => $UserData->UserMoblieNumber,
                    'Invoice'      => $Invoice,
                    'Current_date' => $CurrentDate,
                    'enddate'      => $UserData->UserEndDate,
                ];
                // echo '<pre>';
                // print_r($UserData);
                $view = \View::make('warningpdf', $Data);
                $html = $view->render();
                $pdf  = new TCPDF();
                $pdf::SetTitle('Warning');
                $pdf::AddPage();
                $pdf::writeHTML($html, true, false, true, false, '');
                $pdf::output($_SERVER['DOCUMENT_ROOT'] . 'storage/app/warningmail/Invoice.pdf', 'F');
                $pdf::reset();
                $EmailAddress = Constant::emailwarning;
                $user         = [
                    'email' => $UserData->UserEmail,
                    'name'  => $UserData->UserName,
                ];
                $data = [
                    'name'    => $UserData->UserName,
                    'address' => $UserData->UserAddress,
                    'phone'   => $UserData->UserMoblieNumber,
                ];

                putenv('MAIL_USERNAME=legal@searchjobsforyou.com');
                putenv('MAIL_PASSWORD=Jaishriram21');

                Mail::send('mail.warningmail', $data, function ($message) use ($user, $EmailAddress) {

                    $message->from($EmailAddress, 'Search Jobs For You')
                        ->to($user['email'], $user['name'])
                        ->bcc(Constant::toEmail, $user['name'])
                        ->subject('Warning Mail')
                        ->attach(url('storage/app/warningmail/Invoice.pdf'));
                });
            } catch (Exception $ex) {

            }
        }

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgMailSend']);
        return redirect()->back();

    }
   
  
}
