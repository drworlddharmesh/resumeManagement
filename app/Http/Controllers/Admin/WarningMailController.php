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

class WarningMailController extends Controller {
    protected $common;

    public function __construct(Request $request) {
        $this->common = new Common;
    }

    public function WarningMail(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        return view('admin.warningmail.warningmail');
    }

    public function WarningMailSend(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $UserRegistration = $request->UserRegistrationId;
        $Phone            = $request->Phone;

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
                    'Phone'        => $Phone,
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
                    'phone'   => $Phone,
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
    public function StartDate($UserId) {
       
        $User = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->whereDate('UserStartDate','>=',Carbon::now()->startOfDay()->addDays(-3))
            ->whereDate('UserStartDate','<=',Carbon::now()->endOfDay()->addDays(-3))
            ->get();

            foreach($User as $UserData)
            {
                $phone    = $UserData->UserMoblieNumber;
                $Name     = $UserData->UserRegistrationId;
                $Password = $UserData->ResendPassword;
        
                $url      = "http://dnd.bulksmssurat.in/httpapi/smsapi?uname=SYNLEG&password=030314&sender=INDJOB&receiver=$phone&route=TA&msgtype=1&sms=Registration Id:- $Name        Password:-$Password";
                $apiCall  = new Client;
                $response = $apiCall->get($url);
        
                $UserData = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
                ->where('UserId', $UserId)
                ->first();
            $EmailAddress = Constant::email;
            $user         = [
                'email' => $UserData->UserEmail,
                'name'  => $UserData->UserName,
            ];
            $data = [
                'UserName' => $UserData->UserRegistrationId,
                'Password' => $UserData->ResendPassword,
            ];
        
            Mail::send('mail.new-user', $data, function ($message) use ($user, $EmailAddress) {
        
                $message->from($EmailAddress, 'Search Jobs For You')
                    ->to($user['email'], $user['name'])
                    ->bcc(Constant::toEmail, $user['name'])
                    ->subject('New Registration');
            });
            }
        
    }
    public function EndDate($UserId) {
        $User = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
        ->whereDate('UserEndDate','>=',Carbon::now()->startOfDay())
        ->whereDate('UserEndDate','<=',Carbon::now()->endOfDay())
        ->get();

        foreach($User as $UserData)
        {
            $phone    = $UserData->UserMoblieNumber;
            $Name     = $UserData->UserRegistrationId;
            $Password = $UserData->ResendPassword;
    
            $url      = "http://dnd.bulksmssurat.in/httpapi/smsapi?uname=SYNLEG&password=030314&sender=INDJOB&receiver=$phone&route=TA&msgtype=1&sms=Registration Id:- $Name        Password:-$Password";
            $apiCall  = new Client;
            $response = $apiCall->get($url);
    
            $UserData = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('UserId', $UserId)
            ->first();
        $EmailAddress = Constant::email;
        $user         = [
            'email' => $UserData->UserEmail,
            'name'  => $UserData->UserName,
        ];
        $data = [
            'UserName' => $UserData->UserRegistrationId,
            'Password' => $UserData->ResendPassword,
        ];
    
        Mail::send('mail.new-user', $data, function ($message) use ($user, $EmailAddress) {
    
            $message->from($EmailAddress, 'Search Jobs For You')
                ->to($user['email'], $user['name'])
                ->bcc(Constant::toEmail, $user['name'])
                ->subject('New Registration');
        });
        }
    }
}
