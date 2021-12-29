<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\User;
use App\Models\Franchisee;
use App\Models\Caller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use Session;
use Illuminate\Support\Carbon;


class ReportController extends Controller
{
    protected $common;

    public function __construct(Request $request)
    {
        $this->common = new Common;
    }

    // Login
    public function Report(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $ReportData =  Franchisee::with([
            'Caller' => function ($query) {
                $query->with([
                    'User' => function ($queryUser) {
                        $queryUser->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                        // $queryUser->where('resumeAllow', Constant::resumeAllow['Allow']);
                        $queryUser->whereDate('UserStartDate', Carbon::today());
                    },
                ]);
                $query->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            },
        ])
        ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
        ->get();
//return $ReportData;

        $arrReportData = [];
        foreach ($ReportData as $rd) {

           
            $userCount = 0;
            $totalCount = 0;

            $arrCaller = [];
            if(count($rd->Caller) > 0) {
               

                foreach($rd->Caller as $clr) {
                    $userCount = count($clr->User);

                    $varCaller = [
                        'CallerId' => $clr->CallerId,
                        'CallerName' => $clr->CallerName,
                        'UserCount' => $userCount,
                    ];

                    $totalCount += $userCount;

                    array_push($arrCaller, $varCaller);
                }
            }

            $varReportData = [
                'FranchiseeId' => $rd->FranchiseeId,
                'FranchiseeName' => $rd->FranchiseeName,
                'ArrCaller' => $arrCaller,
                'TotalCount' => $totalCount,
            ];

            array_push($arrReportData, $varReportData);
        }




        $ReportDataMonth =  Franchisee::with([
            'Caller' => function ($query) {
                $query->with([
                    'User' => function ($queryUser) {
                        $queryUser->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                        // $queryUser->where('resumeAllow', Constant::resumeAllow['Allow']);
                        $queryUser->whereMonth('UserStartDate', Carbon::now()->month);
                    },
                ]);
                $query->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            },
        ])
        ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
        ->get();
//return $ReportData;

        $arrReportDataMonth = [];
        foreach ($ReportDataMonth as $rd) {

           
            $userCount = 0;
            $totalCount = 0;

            $arrCaller = [];
            if(count($rd->Caller) > 0) {
               

                foreach($rd->Caller as $clr) {
                    $userCount = count($clr->User);

                    $varCaller = [
                        'CallerId' => $clr->CallerId,
                        'CallerName' => $clr->CallerName,
                        'UserCount' => $userCount,
                    ];

                    $totalCount += $userCount;

                    array_push($arrCaller, $varCaller);
                }
            }

            $varReportData = [
                'FranchiseeId' => $rd->FranchiseeId,
                'FranchiseeName' => $rd->FranchiseeName,
                'ArrCaller' => $arrCaller,
                'TotalCount' => $totalCount,
            ];

            array_push($arrReportDataMonth, $varReportData);
        }
        
        return view('admin.report.report')->with([
            'ReportData' => $arrReportData,
            'ReportDataMonth' => $arrReportDataMonth,
        ]);
    }
}