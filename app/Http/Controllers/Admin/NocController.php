<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\User;
use Elibyy\TCPDF\Facades\TCPDF;
use Exception;
use Illuminate\Http\Request;
use Mail;
use Session;

class NocController extends Controller {
    protected $common;

    public function __construct(Request $request) {
        $this->common = new Common;
    }

    public function noc(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        return view('admin.noc.noc');
    }
    public function password(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $adminId = $this->common->DecryptAdminId(Session::get('AdminId'));
        $user    = User::where('UserId', $adminId)->where('UserType', Constant::userType['Admin'])->first();
        if ($user) {
            if ($request->Password == $user->UserAdminPassword) {

                return redirect('admin/nocs');
            }
        }
        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgIncorrectPassword']);
        return redirect('admin/noc');
    }

    public function password1(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $adminId = $this->common->DecryptAdminId(Session::get('AdminId'));
        $user    = User::where('UserId', $adminId)->where('UserType', Constant::userType['Admin'])->first();
        if ($user) {
            if ($request->Password == $user->UserAdminPassword) {

                return redirect('admin/date-extension');
            }
        }
        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgIncorrectPassword']);
        return redirect('admin/date-extensions');
    }

    public function password2(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $adminId = $this->common->DecryptAdminId(Session::get('AdminId'));
        $user    = User::where('UserId', $adminId)->where('UserType', Constant::userType['Admin'])->first();
        if ($user) {
            if ($request->Password == $user->UserAdminPassword) {

                return redirect('admin/profile');
            }
        }
        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgIncorrectPassword']);
        return redirect('admin/profiles');
    }

    public function paymentmail(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $UserRegistrationId = $request->UserRegistrationId;
        $Amount             = $request->Amount;
        $UserData           = User::where('UserRegistrationId', $UserRegistrationId)->first();

        if ($UserData) {
            try {
                $EmailAddress = Constant::email;
                $user         = [
                    'email' => $UserData->UserEmail,
                    'name'  => $UserData->UserName,
                ];
                date_default_timezone_set('Asia/Kolkata');
                $CurrentDate = date("Y-m-d H:i:s");
                $data        = [
                    'name'        => $UserData->UserName,
                    'Amount'      => $Amount,
                    'CurrentDate' => $CurrentDate,
                ];
                $view = \View::make('nocpdf', $data);
                $html = $view->render();
                $pdf  = new TCPDF();
                $pdf::SetTitle('Noc');
                $pdf::AddPage();
                $pdf::writeHTML($html, true, false, true, false, '');
                $pdf::Output($_SERVER['DOCUMENT_ROOT'] . 'storage/app/warningmail/Noc.pdf', 'F');

                Mail::send('mail.payment', $data, function ($message) use ($user, $EmailAddress) {

                    $message->from($EmailAddress, 'Search Jobs For You')
                        ->to($user['email'], $user['name'])
                        ->bcc(Constant::toEmail, $user['name'])
                        ->subject('Payment')
                        ->attach(url('storage/app/warningmail/Noc.pdf'));
                });
            } catch (Exception $ex) {

            }
            Session::flash('SuccessMessage', Constant::adminSessionMessage['msgMailSend']);
            return redirect()->back();
        }
        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgDataNotFound']);
        return redirect()->back();
    }

}
