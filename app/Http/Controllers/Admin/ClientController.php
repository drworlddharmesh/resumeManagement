<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Caller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\CustomerCare;
use App\Models\Franchisee;
use App\Models\Manu;
use App\Models\ManuRelation;
use App\Models\Plan;
use App\Models\Resume;
use App\Models\Resume_allow;
use App\Models\User;
use DataTables;
use Elibyy\TCPDF\Facades\TCPDF;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Mail;
use Session;
use Storage;
ini_set('memory_limit', '-1');


class ClientController extends Controller {
    protected $common;
    protected $CurrentDate;
    public function __construct(Request $request) {
        $this->common = new Common;
        date_default_timezone_set('Asia/Kolkata');

        $this->CurrentDate = date("Y-m-d H:i:s");
    }
    public function Client(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $startDateRange = '';
            $endDateRange = '';
        if($request->startDateRange || $request->endDateRange)
        {
            $startDateRange = $request->startDateRange;
            $endDateRange = $request->endDateRange;
        }
        

        return view('admin.client.client')->with([
            'startDateRange' => $startDateRange,
            'endDateRange'  =>$endDateRange
        ]);
    }

    public function AddUserDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        if($request->startDateRange || $request->endDateRange)
        {
            $startDateRange = explode('-', $request->startDateRange);
            $endDateRange = explode('-', $request->endDateRange);
    
            $startfrom = Carbon::parse($startDateRange[0])->startOfDay()->toDateTimeString();
            $startto   = Carbon::parse($startDateRange[1])->endOfDay()->toDateTimeString();
    
            $endfrom = Carbon::parse($endDateRange[0])->startOfDay()->toDateTimeString();
            $endtto   = Carbon::parse($endDateRange[1])->endOfDay()->toDateTimeString();
    
            $ClientData = User::where(function($query) use ($startfrom, $startto,$endfrom,$endtto) {
                $query->whereBetween('UserStartDate', [$startfrom, $startto]);
                $query->orWhereBetween('UserEndDate', [$endfrom, $endtto]);
            })
                ->with('Caller')->whereHas('Caller', function ($qc) {
                $qc->with('Franchisee')->whereHas('Franchisee', function ($qf) {
                    $qf->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                });
                $qc->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            })->with('Plan')->whereHas('Plan', function ($qp) {
                $qp->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            })
                ->where('IsRemoved', '=', Constant::isRemoved['NotRemoved'])
                ->where('UserType', '=', Constant::userType['Client'])
                ->orderBy('UserEndDate', 'desc')
                ->get();
        }
        else
        {
            $ClientData = User::with('Caller')->whereHas('Caller', function ($qc) {
            $qc->with('Franchisee')->whereHas('Franchisee', function ($qf) {
                $qf->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            });
            $qc->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        })->with('Plan')->whereHas('Plan', function ($qp) {
            $qp->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        })
            ->where('IsRemoved', '=', Constant::isRemoved['NotRemoved'])
            ->where('UserType', '=', Constant::userType['Client'])
            ->orderBy('UserEndDate', 'desc')
            ->get();
        }
       

        $arrItem = [];
        foreach ($ClientData as $itm) {
            $startDate = '';
            $endDate   = '';
            if ($itm->resumeAllow == Constant::resumeAllow['Allow']) {
                $startDate = Common::dateformat($itm->UserStartDate);
                $endDate   = Common::dateformat($itm->UserEndDate);
            }

            $varItem = [
                'UserId'             => $itm->UserId,
                'UserName'           => $itm->UserName,
                'UserRegistrationId' => $itm->UserRegistrationId,
                'UserAddress'        => $itm->UserAddress,
                'ResendPassword'     => $itm->ResendPassword,
                'UserMoblieNumber'   => $itm->UserMoblieNumber,
                'UserEmail'          => $itm->UserEmail,
                'PlanName'           => $itm->Plan->PlanName, //$VarPlanName,
                'FranchiseeName'     => $itm->Caller->Franchisee->FranchiseeName, //$VarFranchiseeName,
                'CallerName'         => $itm->Caller->CallerName, //$VarCallerName,
                'resume_allow'       => $itm->ResumeSubmitCount,
                'UserStartDate'      => $startDate,
                'UserEndDate'        => $endDate,
                'UserIpAddress'      => $itm->UserIpAddress,
                // 'resend' => $resend,
                'UserSignatureId'    => $itm->UserSignature,
                'resumeAllowId'      => $itm->resumeAllow,
                // 'action' => $action,

            ];

            array_push($arrItem, $varItem);
        }
        return Datatables::of($arrItem)->addIndexColumn()->addColumn('resendmail', function ($row) {

            $resendurl  = url('admin/client/resend-mail') . '/' . $row['UserId'];
            $resendmail = '<a href="' . $resendurl . '" class="btn-sm btn-primary m-t-n-xs">Resend Mail</a>';
            return $resendmail;
        })
            ->addColumn('resendsms', function ($row) {

                $resendsmsurl = url('admin/client/resend-sms') . '/' . $row['UserId'];
                $resendsms    = '<a href="' . $resendsmsurl . '" class="btn-sm btn-primary m-t-n-xs"> Resend SMS</a>';
                return $resendsms;
            })
            ->addColumn('UserSignature', function ($row) {

                // $UserSignatureurl = url('storage/signture/') . '/' . $row['UserSignatureId'];
                $UserSignatureurl = Constant::clientUrl . '/storage/signture/' . $row['UserSignatureId'];
                $UserSignature    = '';
                if ($row['UserSignatureId']) {
                    $UserSignature = '<a href="' . $UserSignatureurl . '" class="btn-sm btn-primary m-t-n-xs" download >Download</a>';

                }

                return $UserSignature;
            })
             ->addColumn('remark', function ($row) {
              
                $remark = '<center>
                <a href="#" class="btn-sm btn-primary m-t-n-xs" onclick="Remark(' . $row['UserId'] . ')" data-toggle="tooltip" title="Remark">
                    Remark
                </a>
            </center>';

                return $remark;

            })
            ->addColumn('action', function ($row) {
                $notreview     = '';
                $disapproveurl = url('admin/client/resumeallow-client') . '/' . $row['UserId'] . '/1';
                $approveurl    = url('admin/client/resumeallow-client') . '/' . $row['UserId'] . '/2';
                if ($row['resumeAllowId'] == 0) {

                    $notreview = ' <a href="#" class="text-warning" onclick="DeactiveUrl(' . "'" . $disapproveurl . "'" . ')" title="Deactivate">
                    <i class="fa fa-close"></i></a>
                    &nbsp
                    <a href="' . $approveurl . '" class="text-primary" title="Approve">
                        <i class="fa fa-check"></i> </a>';

                }
                if ($row['resumeAllowId'] == 1) {

                    $notreview = '<a href="' . $approveurl . '" class="text-primary" title="Approve">
                        <i class="fa fa-check"></i> </a>';

                }
                if ($row['resumeAllowId'] == 2) {

                    $notreview = '<a href="#" class="text-warning" onclick="DeactiveUrl(' . "'" . $disapproveurl . "'" . ')" title="Deactivate">
                    <i class="fa fa-close"></i></a>';

                }
                $url    = url('admin/client/edit-client') . '/' . $row['UserId'];
                $action = '<center>
                <a href="' . $url . '" title="Edit">
                    <i class="fa fa-pencil"></i>
                </a>
                &nbsp

                <a href="#" onclick="DeleteHealthCondition(' . $row['UserId'] . ')" data-toggle="tooltip" title="Delete">
                    <i class="fa fa-trash"></i>
                </a>
                &nbsp
                ' . $notreview . '
            </center>';

                return $action;

            })
            ->rawColumns(['resendmail', 'resendsms', 'UserSignature', 'remark', 'action'])
            ->make(true);
    }
    // Add Client
    public function AddClient(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $FranchiseeData = Franchisee::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('FranchiseeId', 'desc')
            ->get();

        $PlanData = Plan::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('PlanId', 'desc')
            ->get();

        $CallerData = Caller::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('CallerId', 'desc')
            ->get();
        $AgreementData = Agreement::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('AgreementNo', 'asc')
            ->get();

        $UserRegistrationId = User::orderBy('UserId', 'desc')->first();
        $Agreement          = Agreement::where('AgreementId', $UserRegistrationId->AgreementId)->first();
        $arrData            = [];
        $parrData           = [];
        $SelectAgreement    = '';
        if ($AgreementData) {
            foreach ($AgreementData as $asc) {
                if ($asc->AgreementNo > $Agreement->AgreementNo) {
                    $varData = [
                        'AgreementNo' => $asc->AgreementNo,
                    ];
                    array_push($arrData, $varData);
                } else {
                    $varData = [
                        'AgreementNo' => $asc->AgreementNo,
                    ];
                    array_push($parrData, $varData);
                }
            }
            if (count($arrData) > 0) {
                $SelectAgreement = $arrData[0]['AgreementNo'];
            } else {
                $SelectAgreement = $parrData[0]['AgreementNo'];
            }
        }

        return view('admin.client.add-client')->with([
            'FranchiseeData'     => $FranchiseeData,
            'PlanData'           => $PlanData,
            'CallerData'         => $CallerData,
            'AgreementData'      => $AgreementData,
            'LastRegistrationId' => $UserRegistrationId,
            'SelectAgreement'    => $SelectAgreement,
        ]);
    }
    public function EditClient($UserId) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $UserRegistrationId = User::where('UserId', $UserId)->with(['Agreement', 'Plan'])
            ->with(['Caller' => function ($q) {
                $q->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                $q->with(['Franchisee' => function ($query) {
                    $query->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                }]);
            }])
            ->first();

        // return $UserRegistrationId;
        $FranchiseeData = Franchisee::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('FranchiseeId', 'desc')
            ->get();

        $PlanData = Plan::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('PlanId', 'desc')
            ->get();

        $CallerData = Caller::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('CallerId', 'desc')
            ->get();
        $AgreementData = Agreement::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('AgreementId', 'desc')
            ->get();

        return view('admin.client.edit-client')->with([
            'FranchiseeData'     => $FranchiseeData,
            'PlanData'           => $PlanData,
            'CallerData'         => $CallerData,
            'AgreementData'      => $AgreementData,
            'UserRegistrationId' => $UserRegistrationId,
        ]);
    }

    // Insert Client
    public function InsertClient(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $UserRegistrationId = 'R' . date('dmy') . $this->common->GenerateOTP();
        $AgreementId        = Agreement::where('AgreementNo', $request->AgreementId)
            ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->first();
        $Password   = $this->common->GenerateOTP();
        $UserEmail  = $request->Email;
        $UserName   = $request->Name;
        $Phone      = $request->MoblieNumber;
        $url        = "http://dnd.bulksmssurat.in/httpapi/smsapi?uname=SYNLEG&password=030314&sender=INDJOB&receiver=$Phone&route=TA&msgtype=1&sms=WELCOME TO SEARCH JOBS FOR YOU!!!!             Sign the contract through below details.  ID:$UserRegistrationId Password:$Password  link: " . Constant::clientUrl . "     Regards              Search Jobs For You";
        $apiCall    = new Client;
        $response   = $apiCall->get($url);
        $PlanInsert = User::create([
            'UserRegistrationId' => $UserRegistrationId,
            'UserName'           => $UserName,
            'UserMoblieNumber'   => $Phone,
            'UserEmail'          => $UserEmail,
            'UserAddress'        => $request->Address,
            'PlanId'             => $request->PlanId,
            'UserPassword'       => bcrypt($Password),
            'ResendPassword'     => $Password,
            'CallerId'           => $request->CallerId,
            'AgreementId'        => $AgreementId->AgreementId,
            'UserType'           => Constant::userType['Client'],

        ]);
        $EmailAddress = Constant::email;
        $user         = [
            'email' => $UserEmail,
            'name'  => $UserName,
        ];
        $data = [
            'UserName' => $UserRegistrationId,
            'Password' => $Password,
        ];

        try
        {
            Mail::send('mail.new-user', $data, function ($message) use ($user, $EmailAddress) {

                $message->from($EmailAddress, 'Search Jobs For You')
                    ->to($user['email'], $user['name'])
                    ->bcc(Constant::toEmail, $user['name'])
                    ->subject('New Registration');
            });
        } catch (Exception $ex) {

        }

        Session::put('UserRegistrationId', $UserRegistrationId);
        Session::put('UserPassword', $Password);
        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertClient']);

        return redirect('admin/client/add-client');
    }
    public function UpdateClient(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $UserId = $request->id;

        $PlanInsert = User::where('UserId', $UserId)->update([

            'UserName'         => $request->Name,
            'UserMoblieNumber' => $request->MoblieNumber,
            'UserEmail'        => $request->Email,
            'CallerId'         => $request->CallerId,

        ]);
        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgUpdateClient']);

        return redirect()->back();
    }
    public function Resendsms($UserId) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $UserData = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('UserId', $UserId)
            ->first();

        $phone    = $UserData->UserMoblieNumber;
        $Name     = $UserData->UserRegistrationId;
        $Password = $UserData->ResendPassword;

        $url      = "http://dnd.bulksmssurat.in/httpapi/smsapi?uname=SYNLEG&password=030314&sender=INDJOB&receiver=$phone&route=TA&msgtype=1&sms=Registration Id:- $Name        Password:-$Password";
        $apiCall  = new Client;
        $response = $apiCall->get($url);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgResendSMSClient']);
        return redirect('admin/client');
    }
    public function Resendmail($UserId) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
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

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgResendMailClient']);
        return redirect('admin/client');
    }
    public function dependentfetch(Request $request) {
        $value = (int) $request->get('value');
        $data  = Caller::where([['callers.IsRemoved', '=', Constant::isRemoved['NotRemoved']], ['callers.FranchiseeId', '=', $value]])
            ->join('franchisees', 'franchisees.FranchiseeId', '=', 'callers.FranchiseeId')
            ->orderBy('callers.CallerId', 'desc')
            ->get();

        $output = '<option value="">Select Caller</option>';
        foreach ($data as $row) {
            $output .= '<option value="' . $row->CallerId . '">' . $row->CallerName . '</option>';
        }
        echo $output;
    }

    public function resumeAllowStatus($UserId, $Status) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $resumeLimit = $this->common->resumeLimit($UserId);
        $checkstatus = User::where('UserId', $UserId)
            ->select('*')
            ->first();

        if ($Status == 2) {
            $UserData = User::where('UserId', $UserId)
                ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
                ->first();
            $phone         = $UserData->UserMoblieNumber;
            $AgreementData = Agreement::where('AgreementId', $UserData->AgreementId)
                ->first();

            if ($UserData->UserSignature) {
                // $UserSignture = 'signture/' . $UserData->UserSignature;
                $UserSignture = Constant::clientUrl . '/storage/signture/' . $UserData->UserSignature;
            } else {
                $UserSignture = "";
            }
            $PlanData = User::where('UserId', $UserId)
            ->first();
            // return Constant::clientUrl . '/storage/' . $UserSignture;
            // return base_path() . '../resumetofillclient/storage/';
            // return storage_path($UserSignture);
            $filePath     = 'agreement/' . $AgreementData->AgreementPDF;
            $AgreementImg = Storage::disk('s3')->url($filePath);
            $AgreementText = $PlanData->AgreementText;
            $Data         = [
                'UserData'     => $UserData,
                'UserSignture' => $UserSignture,
                'AgreementImg' => $AgreementImg,
                'AgreementText' =>$AgreementText,
            ];
            try
            {
                $view = \View::make('myPDF', $Data);
                $html = $view->render();
                $pdf  = new TCPDF();
                $pdf::SetTitle('Agreement');
                $pdf::AddPage();
                $pdf::writeHTML($html, true, true, true, true, '');
                $pdf::output($_SERVER['DOCUMENT_ROOT'] . 'storage/app/agreementmail/Agreement.pdf', 'F');

                $CustomerCare = CustomerCare::where('IsRemoved', Constant::isRemoved['NotRemoved'])->where('CustomerCareSatus', '!=', 1)->first();
                if ($CustomerCare) {
                    $CustomerCareNo = $CustomerCare->CustomerCareNo;
                } else {
                    CustomerCare::where('IsRemoved', Constant::isRemoved['NotRemoved'])->update([
                        'CustomerCareSatus' => 0,
                    ]);
                    $CustomerCare   = CustomerCare::where('IsRemoved', Constant::isRemoved['NotRemoved'])->where('CustomerCareSatus', '!=', 1)->first();
                    $CustomerCareNo = $CustomerCare->CustomerCareNo;
                }
                $EmailAddress = Constant::email;
                $user         = [
                    'email' => $UserData->UserEmail,
                    'name'  => $UserData->UserName,
                ];
                $data = [
                    'UserName'       => $UserData->UserRegistrationId,
                    'CustomerCareNo' => $CustomerCareNo,

                ];

                Mail::send('mail.sign-user', $data, function ($message) use ($user, $EmailAddress) {

                    $message->from($EmailAddress, 'Search Jobs For You')
                        ->to($user['email'], $user['name'])
                        ->bcc(Constant::toEmail, $user['name'])
                        ->subject('Verify Account')
                        ->attach(url('storage/app/agreementmail/Agreement.pdf'));
                });

                CustomerCare::where('CustomerCareNo', $CustomerCareNo)
                    ->update([
                        'CustomerCareSatus' => 1,
                    ]);
            } catch (Exception $ex) {

            }
            $url      = "http://dnd.bulksmssurat.in/httpapi/smsapi?uname=SYNLEG&password=030314&sender=INDJOB&receiver=$phone&route=TA&msgtype=1&sms=Greetings!      Your sign has been approved. Your account is active        Read the terms and instruction before starting the project.          Regards               Search Jobs For You";
            $apiCall  = new Client;
            $response = $apiCall->get($url);
        }
        if ($Status == 2) {
            $ResumeCount = Resume::where('IsRemoved', Constant::isRemoved['NotRemoved'])
                ->count('ResumeId');

            $Resume_allow_Count = 600/*Resume_allow::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->count('ResumeAllowId')*/;
            if ($Resume_allow_Count == 0) {
                $ResumeIds = Resume::where('IsRemoved', Constant::isRemoved['NotRemoved'])
                    ->select('ResumeId')
                    ->orderBy('ResumeId', 'desc')
                    ->limit($resumeLimit)
                    ->get();

                foreach ($ResumeIds as $ResumeId) {
                    Resume_allow::create([
                        'ResumeAllowUserId'   => $UserId,
                        'ResumeAllowResumeId' => $ResumeId->ResumeId,
                    ]);
                }
                $UserData = User::where('UserId', $UserId)->first();
                $plan     = Plan::where('PlanId', $UserData->PlanId)->first();
                User::where('UserId', $UserId)
                    ->update([
                        'resumeAllow'      => Constant::resumeAllow['Allow'],
                        'ResumeTotalCount' => $resumeLimit,
                        'UserStartDate'    => Carbon::parse($this->CurrentDate)->format('Y-m-d H:i:s'),
                        'UserEndDate'      => Carbon::parse($this->CurrentDate)->addDays($plan->PlanDays)->addDays(1)->endOfDay()->format('Y-m-d H:i:s'),
                    ]);
                Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertClientAllow']);
                return redirect()->back();
            } else {
                $check = Resume_allow::where('ResumeAllowUserId', $UserId)
                    ->select('*')
                    ->first();
                if ($check) {

                    User::where('UserId', $UserId)
                        ->update([
                            'resumeAllow' => $Status,
                        ]);

                    Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertClientStatus']);
                    return redirect()->back();
                } else {
                    $last_id   = Resume_allow::latest('ResumeAllowId')->first();
                    $ResumeIds = Resume::where('ResumeId', '<', $last_id->ResumeAllowResumeId)
                        ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
                        ->select('ResumeId')
                        ->orderBy('ResumeId', 'desc')
                        ->limit($resumeLimit)
                        ->get();
                    $recounter = count($ResumeIds);

                    if ($recounter == $resumeLimit) {
                        foreach ($ResumeIds as $ResumeId) {
                            Resume_allow::create([
                                'ResumeAllowUserId'   => $UserId,
                                'ResumeAllowResumeId' => $ResumeId->ResumeId,
                            ]);
                        }
                        $UserData = User::where('UserId', $UserId)->first();
                        $plan     = Plan::where('PlanId', $UserData->PlanId)->first();
                        User::where('UserId', $UserId)
                            ->update([
                                'resumeAllow'      => Constant::resumeAllow['Allow'],
                                'ResumeTotalCount' => $resumeLimit,
                                'UserStartDate'    => Carbon::parse($this->CurrentDate)->format('Y-m-d H:i:s'),
                                'UserEndDate'      => Carbon::parse($this->CurrentDate)->addDays($plan->PlanDays)->addDays(1)->endOfDay()->format('Y-m-d H:i:s'),
                            ]);

                        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertClientAllow']);
                        return redirect()->back();
                    } else {
                        $repeatresume = $resumeLimit - $recounter;
                        foreach ($ResumeIds as $ResumeId) {
                            Resume_allow::create([
                                'ResumeAllowUserId'   => $UserId,
                                'ResumeAllowResumeId' => $ResumeId->ResumeId,
                            ]);
                        }
                        $repeatresumeIds = Resume::where('IsRemoved', Constant::isRemoved['NotRemoved'])
                            ->select('ResumeId')
                            ->orderBy('ResumeId', 'desc')
                            ->limit($repeatresume)
                            ->get();
                        foreach ($repeatresumeIds as $ResumeId) {
                            Resume_allow::create([
                                'ResumeAllowUserId'   => $UserId,
                                'ResumeAllowResumeId' => $ResumeId->ResumeId,
                            ]);
                        }

                        $UserData = User::where('UserId', $UserId)->first();
                        $plan     = Plan::where('PlanId', $UserData->PlanId)->first();
                        User::where('UserId', $UserId)
                            ->update([
                                'resumeAllow'      => Constant::resumeAllow['Allow'],
                                'ResumeTotalCount' => $resumeLimit,
                                'UserStartDate'    => Carbon::parse($this->CurrentDate)->format('Y-m-d H:i:s'),
                                'UserEndDate'      => Carbon::parse($this->CurrentDate)->addDays($plan->PlanDays)->addDays(1)->endOfDay()->format('Y-m-d H:i:s'),
                            ]);
                        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertClientAllow']);
                        return redirect()->back();
                    }
                }
            }

        } else {

            User::where('UserId', $UserId)
                ->update([
                    'resumeAllow' => $Status,
                ]);
            Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertClientStatus']);
            return redirect()->back();
        }
    }

    public function DeleteClient(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $UserId = $request['UserId'];

        User::where('UserId', $UserId)
            ->update([
                'IsRemoved' => Constant::isRemoved['Removed'],
            ]);

        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgDeleteUser']);
        return redirect('admin/client');
    }
    public function DeleteClients(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        return view('admin.client.delete-clients');
    }

    public function pending(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $ClientData = User::where([['users.IsRemoved', '=', Constant::isRemoved['NotRemoved']], ['users.UserType', '=', Constant::userType['Client']], ['users.resumeAllow', '=', Constant::resumeAllow['Notreview']], ['users.UserSignature', '!=', '']])
            ->join('plans', 'plans.PlanId', '=', 'users.PlanId')
        // ->join('agreements','agreements.AgreementId','=','users.AgreementId')
            ->join('callers', 'callers.CallerId', '=', 'users.CallerId')
            ->join('franchisees', 'franchisees.FranchiseeId', '=', 'callers.FranchiseeId')
            ->orderBy('users.UserId', 'desc')
            ->get();

        return view('admin.client.pending')->with([
            'ClientData' => $ClientData,
        ]);

    }

    public function UserPendingDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $ClientData = User::where([['users.IsRemoved', '=', Constant::isRemoved['NotRemoved']], ['users.UserType', '=', Constant::userType['Client']], ['users.resumeAllow', '=', Constant::resumeAllow['Notreview']], ['users.UserSignature', '!=', '']])
            ->join('plans', 'plans.PlanId', '=', 'users.PlanId')
        // ->join('agreements','agreements.AgreementId','=','users.AgreementId')
            ->join('callers', 'callers.CallerId', '=', 'users.CallerId')
            ->join('franchisees', 'franchisees.FranchiseeId', '=', 'callers.FranchiseeId')
            ->orderBy('users.UserId', 'desc')
            ->get();

        $arrItem = [];
        foreach ($ClientData as $itm) {

            $varItem = [
                'UserId'             => $itm->UserId,
                'UserName'           => $itm->UserName,
                'UserRegistrationId' => $itm->UserRegistrationId,
                'UserEmail'          => $itm->UserEmail,
                'PlanName'           => $itm->Plan->PlanName, //$VarPlanName,
                'FranchiseeName'     => $itm->Caller->Franchisee->FranchiseeName, //$VarFranchiseeName,
                'CallerName'         => $itm->Caller->CallerName, //$VarCallerName,
                'UserSignatureId'    => $itm->UserSignature,
                'resumeAllowId'      => $itm->resumeAllow,

            ];

            array_push($arrItem, $varItem);
        }
        return Datatables::of($arrItem)->addIndexColumn()->addColumn('UserSignature', function ($row) {

            // $UserSignatureurl = url('storage/signture/') . '/' . $row['UserSignatureId'];
            $UserSignatureurl = Constant::clientUrl . '/storage/signture/' . $row['UserSignatureId'];
            $UserSignature    = '';
            if ($row['UserSignatureId']) {
                $UserSignature = '<a href="#" onclick="SignatureUrl(' . "'" . $UserSignatureurl . "'" . ')" class="btn-sm btn-primary m-t-n-xs" >View</a>';

            }

            return $UserSignature;
        })
            ->addColumn('resign', function ($row) {
                $resignurl = url('admin/client/remove-sign') . '/' . $row['UserId'];
                $resign    = '';
                if ($row['UserSignatureId']) {
                    $resign = '<a href="' . $resignurl . '" class="btn-sm btn-primary m-t-n-xs"> Resign</a>';
                }
                return $resign;
            })
            ->addColumn('action', function ($row) {
                $notreview     = '';
                $disapproveurl = url('admin/client/resumeallow-client') . '/' . $row['UserId'] . '/1';
                $approveurl    = url('admin/client/resumeallow-client') . '/' . $row['UserId'] . '/2';
                if ($row['resumeAllowId'] == 0) {

                    $notreview = '<a href="' . $approveurl . '" class="text-primary" title="Approve">
                        <i class="fa fa-check"></i> </a>';

                }
                if ($row['resumeAllowId'] == 1) {
                    $notreview = '<a href="' . $approveurl . '" class="text-primary" title="Approve">
                        <i class="fa fa-check"></i> </a>';

                }
                return $notreview;

            })
            ->rawColumns(['UserSignature', 'resign', 'action'])
            ->make(true);

    }

    public function approve(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        return view('admin.client.approve');
    }
    public function UserApproveDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

      
            $ClientData = User::where([['users.IsRemoved', '=', Constant::isRemoved['NotRemoved']], ['users.UserType', '=', Constant::userType['Client']], ['users.resumeAllow', '=', Constant::resumeAllow['Allow']]])
            ->join('plans', 'plans.PlanId', '=', 'users.PlanId')
        // ->join('agreements','agreements.AgreementId','=','users.AgreementId')
            ->join('callers', 'callers.CallerId', '=', 'users.CallerId')
            ->join('franchisees', 'franchisees.FranchiseeId', '=', 'callers.FranchiseeId')
            ->orderBy('users.UserId', 'desc')
            ->get();
           
        

        $arrItem = [];
        foreach ($ClientData as $itm) {

            $varItem = [
                'UserId'             => $itm->UserId,

                'UserRegistrationId' => $itm->UserRegistrationId,
                'UserEmail'          => $itm->UserEmail,
                'PlanName'           => $itm->Plan->PlanName, //$VarPlanName,
                'FranchiseeName'     => $itm->Caller->Franchisee->FranchiseeName, //$VarFranchiseeName,
                'CallerName'         => $itm->Caller->CallerName, //$VarCallerName,
                'UserSignatureId'    => $itm->UserSignature,
                'resumeAllowId'      => $itm->resumeAllow,

            ];

            array_push($arrItem, $varItem);
        }
        return Datatables::of($arrItem)->addIndexColumn()->addColumn('UserSignature', function ($row) {

            // $UserSignatureurl = url('storage/signture/') . '/' . $row['UserSignatureId'];
            $UserSignatureurl = Constant::clientUrl . '/storage/signture/' . $row['UserSignatureId'];
            $UserSignature    = '';
            if ($row['UserSignatureId']) {
                $UserSignature = '<a href="' . $UserSignatureurl . '" class="btn-sm btn-primary m-t-n-xs" download >Download</a>';

            }

            return $UserSignature;
        })

            ->addColumn('action', function ($row) {
                $notreview     = '';
                $disapproveurl = url('admin/client/resumeallow-client') . '/' . $row['UserId'] . '/1';
                $approveurl    = url('admin/client/resumeallow-client') . '/' . $row['UserId'] . '/2';
                if ($row['resumeAllowId'] == 0) {

                    $notreview = ' <a href="#" class="text-warning" onclick="DeactiveUrl(' . "'" . $disapproveurl . "'" . ')" title="Deactivate">
                    <i class="fa fa-close"></i></a>
                    &nbsp
                    <a href="' . $approveurl . '" class="text-primary" title="Approve">
                        <i class="fa fa-check"></i> </a>';

                }
                if ($row['resumeAllowId'] == 1) {

                    $notreview = '<a href="' . $approveurl . '" class="text-primary" title="Approve">
                        <i class="fa fa-check"></i> </a>';

                }
                if ($row['resumeAllowId'] == 2) {

                    $notreview = '<a href="#" class="text-warning" onclick="DeactiveUrl(' . "'" . $disapproveurl . "'" . ')" title="Deactivate">
                    <i class="fa fa-close"></i></a>';

                }

                return $notreview;

            })
            ->rawColumns(['UserSignature', 'action'])
            ->make(true);

    }
    public function disapprove(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        return view('admin.client.disapprove');

    }
    public function UserDisapproveDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $ClientData = User::where([['users.IsRemoved', '=', Constant::isRemoved['NotRemoved']], ['users.UserType', '=', Constant::userType['Client']], ['users.resumeAllow', '=', Constant::resumeAllow['Disallow']]])
            ->join('plans', 'plans.PlanId', '=', 'users.PlanId')
        // ->join('agreements','agreements.AgreementId','=','users.AgreementId')
            ->join('callers', 'callers.CallerId', '=', 'users.CallerId')
            ->join('franchisees', 'franchisees.FranchiseeId', '=', 'callers.FranchiseeId')
            ->orderBy('users.UserId', 'desc')
            ->get();

        $arrItem = [];
        foreach ($ClientData as $itm) {

            $varItem = [
                'UserId'             => $itm->UserId,

                'UserRegistrationId' => $itm->UserRegistrationId,
                'UserEmail'          => $itm->UserEmail,
                'PlanName'           => $itm->Plan->PlanName, //$VarPlanName,
                'FranchiseeName'     => $itm->Caller->Franchisee->FranchiseeName, //$VarFranchiseeName,
                'CallerName'         => $itm->Caller->CallerName, //$VarCallerName,
                'UserSignatureId'    => $itm->UserSignature,
                'resumeAllowId'      => $itm->resumeAllow,

            ];

            array_push($arrItem, $varItem);
        }
        return Datatables::of($arrItem)->addIndexColumn()->addColumn('UserSignature', function ($row) {

            // $UserSignatureurl = url('storage/signture/') . '/' . $row['UserSignatureId'];
            $UserSignatureurl = Constant::clientUrl . '/storage/signture/' . $row['UserSignatureId'];
            $UserSignature    = '';
            if ($row['UserSignatureId']) {
                $UserSignature = '<a href="' . $UserSignatureurl . '" class="btn-sm btn-primary m-t-n-xs" download >Download</a>';

            }

            return $UserSignature;
        })

            ->addColumn('action', function ($row) {
                $notreview     = '';
                $disapproveurl = url('admin/client/resumeallow-client') . '/' . $row['UserId'] . '/1';
                $approveurl    = url('admin/client/resumeallow-client') . '/' . $row['UserId'] . '/2';
                if ($row['resumeAllowId'] == 0) {

                    $notreview = ' <a href="#" class="text-warning" onclick="DeactiveUrl(' . "'" . $disapproveurl . "'" . ')" title="Deactivate">
                    <i class="fa fa-close"></i></a>
                    &nbsp
                    <a href="' . $approveurl . '" class="text-primary" title="Approve">
                        <i class="fa fa-check"></i> </a>';

                }
                if ($row['resumeAllowId'] == 1) {

                    $notreview = '<a href="' . $approveurl . '" class="text-primary" title="Approve">
                        <i class="fa fa-check"></i> </a>';

                }
                if ($row['resumeAllowId'] == 2) {

                    $notreview = '<a href="#" class="text-warning" onclick="DeactiveUrl(' . "'" . $disapproveurl . "'" . ')" title="Deactivate">
                    <i class="fa fa-close"></i></a>';

                }

                return $notreview;

            })
            ->rawColumns(['UserSignature', 'action'])
            ->make(true);

    }
    public function clients_delete(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $DeleteId  = $request->Name;
        $clientIds = explode("\n", str_replace("\r", "", $DeleteId));
        foreach ($clientIds as $clientId) {
            User::where('UserRegistrationId', $clientId)
                ->update([
                    'IsRemoved' => Constant::isRemoved['Removed'],
                ]);
        }
        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgClientMutipleDeleted']);
        return redirect('admin/client/delete-clients');
    }
    public function checkdublicationemail(Request $request) {
        $email = $request->Email;
        $Data  = User::where('UserEmail', $email)
            ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->first();
        if ($Data) {
            return 1;
        } else {
            return 0;
        }

    }
    public function RemoveSign($UserId) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $Sign = User::where('UserId', $UserId)->first();
        @unlink(storage_path('signture/') . $Sign->UserSignature);
        User::where('UserId', $UserId)->update([
            'UserSignature' => '',
        ]);
        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgResendSignClient']);
        return redirect('admin/client/pending');
    }
    public function SubAdmin(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        return view('admin.sub-admin.sub-admin');
    }

    public function AddSubAdminDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $subAdminData = User::/*with('Caller')->whereHas('Caller', function ($qc) {
        $qc->with('Franchisee')->whereHas('Franchisee', function ($qf) {
        $qf->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        });
        $qc->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        })
        ->*/    where('IsRemoved', '=', Constant::isRemoved['NotRemoved'])
            ->where('UserType', '=', Constant::userType['SubAdmin'])
            ->orderBy('UserId', 'desc')
            ->get();

        $arrItem = [];
        foreach ($subAdminData as $itm) {
            $varItem = [
                'UserId'           => $itm->UserId,
                'UserName'         => $itm->UserName,
                'UserAddress'      => $itm->UserAddress,
                'ResendPassword'   => $itm->ResendPassword,
                'UserMoblieNumber' => $itm->UserMoblieNumber,
                'UserEmail'        => $itm->UserEmail,
                'FranchiseeName'   => $itm->Caller->Franchisee->FranchiseeName,
                'CallerName'       => $itm->Caller->CallerName,
                'UserIpAddress'    => $itm->UserIpAddress,

            ];

            array_push($arrItem, $varItem);
        }

        return Datatables::of($arrItem)
            ->addIndexColumn()
            ->addColumn('resendmail', function ($row) {
                $resendurl  = url('admin/sub-admin/resend-mail') . '/' . $row['UserId'];
                $resendmail = '<a href="' . $resendurl . '" class="btn-sm btn-primary m-t-n-xs">Resend Mail</a>';
                return $resendmail;
            })
            ->addColumn('resendsms', function ($row) {

                $resendsmsurl = url('admin/sub-admin/resend-sms') . '/' . $row['UserId'];
                $resendsms    = '<a href="' . $resendsmsurl . '" class="btn-sm btn-primary m-t-n-xs"> Resend SMS</a>';
                return $resendsms;
            })
            ->addColumn('action', function ($row) {
                $url    = url('admin/sub-admin/edit-sub-admin') . '/' . $row['UserId'];
                $action = '<center>
                    <a href="' . $url . '" title="Edit">
                        <i class="fa fa-pencil"></i>
                    </a>

                    &nbsp

                    <a href="javascript:void(0)" onclick="DeleteSubAdmin(' . $row['UserId'] . ')" data-toggle="tooltip" title="Delete">
                        <i class="fa fa-trash"></i>
                    </a>
                </center>';

                return $action;

            })
            ->rawColumns(['resendmail', 'resendsms', 'action'])
            ->make(true);
    }

    // Add Sub Admin
    public function AddSubAdmin(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $FranchiseeData = Franchisee::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('FranchiseeId', 'desc')
            ->get();

        $CallerData = Caller::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('CallerId', 'desc')
            ->get();

        $UserRegistrationId = User::orderBy('UserId', 'desc')->first();

        $Manu = Manu::where('IsRemoved', Constant::isRemoved['NotRemoved'])->get();

        return view('admin.sub-admin.add-sub-admin')->with([
            'FranchiseeData'     => $FranchiseeData,
            'CallerData'         => $CallerData,
            'LastRegistrationId' => $UserRegistrationId,
            'Manu'               => $Manu,
        ]);
    }

    // Insert Sub Admin
    public function InsertSubAdmin(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $UserRegistrationId = 'R' . date('dmy') . $this->common->GenerateOTP();
        $Password           = $this->common->GenerateOTP();
        $UserEmail          = $request->Email;
        $UserName           = $request->Name;
        $Phone              = $request->MoblieNumber;
        $url                = "http://dnd.bulksmssurat.in/httpapi/smsapi?uname=SYNLEG&password=030314&sender=INDJOB&receiver=$Phone&route=TA&msgtype=1&sms=WELCOME TO Search Jobs For You!!!!             Sign the contract through below details.  ID:$UserEmail Password:$Password  link: " . url('/') . "     Regards              Search Jobs For You";
        $apiCall            = new Client;
        $response           = $apiCall->get($url);
        $PlanInsert         = User::create([
            'UserRegistrationId' => $UserRegistrationId,
            'UserName'           => $UserName,
            'UserMoblieNumber'   => $Phone,
            'UserEmail'          => $UserEmail,
            'UserAddress'        => $request->Address,
            'PlanId'             => 1,
            'UserPassword'       => bcrypt($Password),
            'ResendPassword'     => $Password,
            'CallerId'           => 1, // $request->CallerId,
            'AgreementId'        => 1,
            'UserType'           => Constant::userType['SubAdmin'],

        ]);

        foreach ($request->menu as $mn) {
            ManuRelation::create([
                'ManuId' => $mn,
                'UserId' => $PlanInsert->UserId,
                'Status' => Constant::ManuStatus['Active'],
            ]);
        }

        $EmailAddress = Constant::email;
        $user         = [
            'email' => $UserEmail,
            'name'  => $UserName,
        ];
        $data = [
            'UserName' => $UserEmail,
            'Password' => $Password,
        ];

        try
        {
            Mail::send('mail.new-sub-admin', $data, function ($message) use ($user, $EmailAddress) {

                $message->from($EmailAddress, 'Search Jobs For You')
                    ->to($user['email'], $user['name'])
                    ->bcc(Constant::toEmail, $user['name'])
                    ->subject('New Registration');
            });
        } catch (Exception $ex) {

        }

        Session::put('SubAdminRegistrationEmail', $UserEmail);
        Session::put('SubAdminPassword', $Password);
        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertSubAdmin']);

        return redirect('admin/add-sub-admin');
    }

    public function SubAdminResendmail($UserId) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $UserData = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('UserId', $UserId)
            ->first();
        $EmailAddress = Constant::email;
        $user         = [
            'email' => $UserData->UserEmail,
            'name'  => $UserData->UserName,
        ];
        $data = [
            'UserName' => $UserData->UserEmail,
            'Password' => $UserData->ResendPassword,
        ];

        Mail::send('mail.new-sub-admin', $data, function ($message) use ($user, $EmailAddress) {

            $message->from($EmailAddress, 'Search Jobs For You')
                ->to($user['email'], $user['name'])
                ->bcc(Constant::toEmail, $user['name'])
                ->subject('New Registration');
        });

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgResendMailClient']);

        return redirect('admin/sub-admin');
    }

    public function SubAdminResendsms($UserId) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $UserData = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('UserId', $UserId)
            ->first();

        $phone    = $UserData->UserMoblieNumber;
        $Name     = $UserData->UserEmail;
        $Password = $UserData->ResendPassword;

        $url      = "http://dnd.bulksmssurat.in/httpapi/smsapi?uname=SYNLEG&password=030314&sender=INDJOB&receiver=$phone&route=TA&msgtype=1&sms=Registration Id:- $Name        Password:-$Password";
        $apiCall  = new Client;
        $response = $apiCall->get($url);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgResendSMSClient']);

        return redirect('admin/sub-admin');
    }

    public function DeleteSubAdmin(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $UserId = $request['UserId'];

        User::where('UserId', $UserId)
            ->update([
                'IsRemoved' => Constant::isRemoved['Removed'],
            ]);

        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgDeleteSubAdmin']);

        return redirect('admin/sub-admin');
    }

    public function EditSubAdmin($UserId) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $UserRegistrationId = User::with([
            'Caller' => function ($q) {
                $q->with([
                    'Franchisee' => function ($query) {
                        $query->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                    },
                ]);
                $q->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            },
        ])
            ->where('UserId', $UserId)
            ->first();

        $FranchiseeData = Franchisee::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('FranchiseeId', 'desc')
            ->get();

        $CallerData = Caller::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('CallerId', 'desc')
            ->get();

        $Manu = Manu::with([
            'ManuRelation' => function ($query) use ($UserId) {
                $query->where('UserId', $UserId);
                $query->where('Status', Constant::ManuStatus['Active']);
                $query->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            },
        ])
            ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->get();

        return view('admin.sub-admin.edit-sub-admin')->with([
            'FranchiseeData'     => $FranchiseeData,
            'CallerData'         => $CallerData,
            'UserRegistrationId' => $UserRegistrationId,
            'Manu'               => $Manu,
        ]);
    }

    public function UpdateSubAdmin(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $UserId = $request->id;

        User::where('UserId', $UserId)->update([
            'UserName'         => $request->Name,
            'UserMoblieNumber' => $request->MoblieNumber,
            // 'CallerId'         => $request->CallerId,

        ]);

        ManuRelation::where('UserId', $UserId)->update([
            'Status' => Constant::ManuStatus['Inactive'],
        ]);

        foreach ($request->menu as $mn) {
            ManuRelation::updateorCreate([
                'ManuId'    => $mn,
                'UserId'    => $UserId,
                'IsRemoved' => Constant::isRemoved['NotRemoved'],
            ], [
                'Status' => Constant::ManuStatus['Active'],
            ]);
        }

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgUpdateSubAdmin']);

        return redirect('admin/sub-admin');
    }
}
