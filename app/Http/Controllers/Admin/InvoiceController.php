<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Elibyy\TCPDF\Facades\TCPDF;
use Mail;
use Session;

class InvoiceController extends Controller
{
    protected $common;

    public function __construct(Request $request)
    {
        $this->common = new Common;
    }

    public function InvoiceGenerator(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        return view('admin.invoice.invoice-generator');
    }

    public function Download(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $UserRegistrationId = $request->UserRegistrationId;
        $TotalAmount = $request->Amount;
        $GSTNumber = $request->GSTNumber;
        $Action = $request->Action;
       $WithoutGSTAmount = ($TotalAmount*100)/(Constant::InvoiceGST+100);
       $GSTAmount  = ($WithoutGSTAmount*Constant::InvoiceGST)/100;
       $GST = Constant::InvoiceGST;
      
       date_default_timezone_set('Asia/Kolkata');
       $CurrentDate = date("Y-m-d H:i:s");
       $User = User::where('UserRegistrationId',$UserRegistrationId)
                    ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
                    ->first();
       $InvoiceNo = $this->common->GenerateOTP();

       if ($Action == 2) {
        try {
            $EmailAddress = Constant::email;
            $user         = [
                'email' => $User->UserEmail,
                'name'  => $User->UserName,
            ];
            $data        = [
                'TotalAmount' =>$TotalAmount,
                'GSTNumber' =>$GSTNumber,
                'GSTAmount' =>$GSTAmount,
                'WithoutGSTAmount'=>$WithoutGSTAmount,
                'GST' =>$GST,
                'CurrentDate' =>$CurrentDate,
                'InvoiceNo' =>$InvoiceNo,
                'User' =>$User,
            ];
            $view = \View::make('admin.invoice.invoice', $data);
            $html = $view->render();
            $pdf  = new TCPDF();
            $pdf::SetTitle('Invoice');
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
    else
    {
        try {
            $EmailAddress = Constant::email;
            $user         = [
                'email' => $User->UserEmail,
                'name'  => $User->UserName,
            ];
            $data        = [
                'TotalAmount' =>$TotalAmount,
                'GSTNumber' =>$GSTNumber,
                'GSTAmount' =>$GSTAmount,
                'WithoutGSTAmount'=>$WithoutGSTAmount,
                'GST' =>$GST,
                'CurrentDate' =>$CurrentDate,
                'InvoiceNo' =>$InvoiceNo,
                'User' =>$User,
            ];
            $view = \View::make('admin.invoice.invoice', $data);
            $html = $view->render();
            $pdf  = new TCPDF();
            $pdf::SetTitle('Invoice');
            $pdf::AddPage();
            $pdf::writeHTML($html, true, false, true, false, '');
            $pdf::Output('Invoice.pdf', 'D');
        } catch (Exception $ex) {

          }  
       }
    }
}
