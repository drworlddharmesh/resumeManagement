<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\Plan;
use Illuminate\Http\Request;
use Session;
use DataTables;
class PlanController extends Controller
{
    protected $common;

    public function __construct(Request $request)
    {
        $this->common = new Common;
    }
    public function Plan(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

       
        return view('admin.plan.plan');
    }

    public function PlanDataTable(Request $request)
    {
        $PlanData = Plan::where('IsRemoved', Constant::isRemoved['NotRemoved'])
        ->orderBy('PlanId', 'desc')
        ->get();
        $arrItem = [];
            foreach ($PlanData as $itm) {
                $varItem = [
                    'PlanId'          =>$itm->PlanId,
                    'PlanNo'          => $itm->PlanNo,
                    'PlanName'        =>$itm->PlanName,
                    'PlanDays'        => $itm->PlanDays,
                    'PlanForms'       => $itm->PlanForms,
                    'PlanQcCutoff'    => $itm->PlanQcCutoff,
                    'PlanFees'        => $itm->PlanFees,
                   
                ];
                array_push($arrItem, $varItem);
            }
            
            return Datatables::of($arrItem)->addIndexColumn()->addColumn('action', function ($row) {
                  
                   
                $url    = url('admin/plan/edit-plan') . '/' . $row['PlanId'];
                $action = '<center>
                <a href="' . $url . '" title="Edit">
                    <i class="fa fa-pencil"></i>
                </a>
                &nbsp

                <a href="javascript:void(0)" onclick="DeleteHealthCondition(' . $row['PlanId'] . ')" data-toggle="tooltip" title="Delete">
                    <i class="fa fa-trash"></i>
                </a>
            </center>';

                return $action;
    
                })
                ->rawColumns(['action'])
                ->make(true);
    }
    // Add Health Condition
    public function AddPlan(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $PlanNo = "P".date('dmyhis');
        

        return view('admin.plan.add-plan')->with([
            'PlanNo' => $PlanNo,
        ]);
    }
    public function DeletePlan(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $PlanId = $request['PlanId'];

        Plan::where('PlanId', $PlanId)
            ->update([
                'IsRemoved' => Constant::isRemoved['Removed'],
            ]);

        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgDeletePlan']);
    }
    // Insert Plan
    public function InsertPlan(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $AgreementText = $request->AgreementText;
    
        $PlanInsert = Plan::create([
            'PlanNo' => "P".date('dmyy'),
            'PlanName' => $request->PlanName,
            'PlanDays' => $request->Days,
            'PlanForms' => $request->Forms,
            'PlanQcCutoff' => $request->QcCutoff,
            'PlanFees' => $request->Fees,
            'AgreementText' => $AgreementText

        ]);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertPlan']);

        return redirect('admin/plan');
    }
    // Edit Plan
    public function EditPlan($PlanId)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }



        $PlanData = Plan::where('PlanId', $PlanId)->first();

        return view('admin.plan.edit-plan')->with([
            'PlanData'   => $PlanData,
        ]);
    }
    // Update Plan
    public function UpdatePlan(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $PlanId = $request->PlanId;
        $AgreementText = $request->AgreementText;
        Plan::where('PlanId', $PlanId)
            ->update([
                
                'PlanName' => $request->PlanName,
                'PlanDays' => $request->Days,
                'PlanForms' => $request->Forms,
                'PlanQcCutoff' => $request->QcCutoff,
                'PlanFees' => $request->Fees,
                'AgreementText' =>$AgreementText,

            ]);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgUpdatePlan']);

        return redirect('admin/plan');
    }
}
