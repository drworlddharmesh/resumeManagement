<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Session;

class ActiveUserController extends Controller {
    protected $common;

    public function __construct(Request $request) {
        $this->common = new Common;
    }
    public function ActiveUser(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        // date_default_timezone_set('Asia/Kolkata');
        // $CurrentDate = date("Y-m-d H:i:s");
        // $ClientData  = User::with(['Caller' => function ($q) {
        //     $q->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        //     $q->with(['Franchisee' => function ($query) {
        //         $query->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        //     }]);

        // }])
        // ->with(['Resume_allow' => function ($q) {
        // $q->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        // $q->where('ResumeStatus', 3);
        // $q->select('ResumeAllowUserId');

        //                                 }])
        //     ->with('Plan')
        //     ->where([['IsRemoved', '=', Constant::isRemoved['NotRemoved']], ['UserType', '=', Constant::userType['Client']]])
        //     ->where('UserEndDate', '>=', $CurrentDate)

        //     ->get();

        return view('admin.active-user.active-user');
    }
    public function ActiveUserDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        date_default_timezone_set('Asia/Kolkata');
        $CurrentDate = date("Y-m-d H:i:s");
        $ClientData  = User::with(['Caller' => function ($q) {
            $q->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            $q->with(['Franchisee' => function ($query) {
                $query->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            }]);

        }])
        /* ->with(['Resume_allow' => function ($q) {
        $q->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        $q->where('ResumeStatus', 3);
        $q->select('ResumeAllowUserId');

        }])*/
            ->with('Plan')
            ->where([['IsRemoved', '=', Constant::isRemoved['NotRemoved']], ['UserType', '=', Constant::userType['Client']]])
            ->where('UserEndDate', '>=', $CurrentDate)

            ->get();

        $arrItem = [];
        foreach ($ClientData as $itm) {
            $VarPlanName       = '';
            $VarCallerName     = '';
            $VarFranchiseeName = '';
            if ($itm->Plan) {
                $VarPlanName = $itm->Plan->PlanName;
            }
            if ($itm->Caller) {
                if ($itm->Caller->Franchisee) {
                    $VarFranchiseeName = $itm->Caller->Franchisee->FranchiseeName;
                }
                $VarCallerName = $itm->Caller->CallerName;
            }

            $varItem = [
                'UserName'           => $itm->UserName,
                'UserRegistrationId' => $itm->UserRegistrationId,
                'ResendPassword'     => $itm->ResendPassword,
                'UserMoblieNumber'   => $itm->UserMoblieNumber,
                'UserEmail'          => $itm->UserEmail,
                'PlanName'           => $VarPlanName,
                'FranchiseeName'     => $VarFranchiseeName,
                'CallerName'         => $VarCallerName,
                'UserStartDate'      => Common::dateformat($itm->UserStartDate),
                'UserEndDate'        => Common::dateformat($itm->UserEndDate),
                'UserIpAddress'      => $itm->UserIpAddress,
                'resume_allow'       => $itm->ResumeSubmitCount,
            ];

            array_push($arrItem, $varItem);
        }

        return Datatables::of($arrItem)->addIndexColumn()->make(true);
    }
}
