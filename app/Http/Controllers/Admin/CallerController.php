<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\Caller;
use App\Models\Franchisee;
use Illuminate\Http\Request;
use DataTables;

use Session;

class CallerController extends Controller
{
    protected $common;

    public function __construct(Request $request)
    {
        $this->common = new Common;
    }
    public function Caller(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $CallerData = Caller::where('callers.IsRemoved', Constant::isRemoved['NotRemoved'])
        ->join('franchisees','franchisees.FranchiseeId','=','callers.FranchiseeId')
            ->orderBy('callers.CallerId', 'desc')
            ->get();


        return view('admin.caller.caller');
    }
    public function CallerDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $CallerData = Caller::where('callers.IsRemoved', Constant::isRemoved['NotRemoved'])
        ->join('franchisees','franchisees.FranchiseeId','=','callers.FranchiseeId')
            ->orderBy('callers.CallerId', 'desc')
            ->get();

        $arrItem = [];
        foreach ($CallerData as $itm) {
          

            $varItem = [
                'CallerId'             => $itm->CallerId,
                'CallerName'             => $itm->CallerName,
                'FranchiseeName'           => $itm->FranchiseeName,
               
            ];

            array_push($arrItem, $varItem);
        }
        return Datatables::of($arrItem)->addIndexColumn()->addColumn('action', function ($row) {
               
                $url    = url('admin/caller/edit-caller') . '/' . $row['CallerId'];
                $action = '<center>
                <a href="' . $url . '" title="Edit">
                    <i class="fa fa-pencil"></i>
                </a>
                &nbsp

                <a href="javascript:void(0)" onclick="DeleteHealthCondition(' . $row['CallerId'] . ')" data-toggle="tooltip" title="Delete">
                    <i class="fa fa-trash"></i>
                </a>
            </center>';

                return $action;

            })
            ->rawColumns(['action'])
            ->make(true);
        }
    // Add Health Condition
    public function AddCaller(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $FranchiseeData = Franchisee::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('FranchiseeId', 'desc')
            ->get();

        return view('admin.caller.add-caller')->with([
            'FranchiseeData' => $FranchiseeData,
        ]);;
    }
    public function DeleteCaller(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $CallerId = $request['CallerId'];

        Caller::where('CallerId', $CallerId)
            ->update([
                'IsRemoved' => Constant::isRemoved['Removed'],
            ]);

        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgDeleteCaller']);
    }
    // Insert Caller
    public function InsertCaller(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $FranchiseeId = $request->FranchiseeId;
        $CallerName = $request->CallerName;


        $CallerInsert = Caller::create([

            'CallerName' => $CallerName,
            'FranchiseeId' => $FranchiseeId,

        ]);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertCaller']);

        return redirect('admin/caller');
    }
    // Edit Caller
    public function EditCaller($CallerId)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }


        $FranchiseeData = Franchisee::where('IsRemoved', Constant::isRemoved['NotRemoved'])
        ->orderBy('FranchiseeId', 'desc')
        ->get();
        
        $CallerData = Caller::where('CallerId', $CallerId)->first();

        return view('admin.caller.edit-caller')->with([
            'CallerData'   => $CallerData,
            'FranchiseeData' => $FranchiseeData,
        ]);
    }
    // Update Caller
    public function UpdateCaller(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $CallerId = $request->CallerId;
        $FranchiseeId = $request->FranchiseeId;
        $CallerName = $request->CallerName;
        Caller::where('CallerId', $CallerId)
            ->update([

                'CallerName' => $CallerName,
                'FranchiseeId' => $FranchiseeId,

            ]);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgUpdateCaller']);

        return redirect('admin/caller');
    }
    public function CheckCallerName(Request $request)
    {
        $CallerName = $request->CallerName;
       $CallerData =  Caller::where('CallerName', $CallerName)
       ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
       ->first();

        if ($CallerData) {
            echo true;
        } else {
            echo false;
        }
    }
    public function CheckEditCallerName(Request $request) {
        $healthConditionId = $request->CallerId;

        $healthCondition = Caller::where('CallerId', '!=', $healthConditionId)
            ->where('CallerName', $request->CallerName)
            ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->first();

        if ($healthCondition) {
            echo "1";
        } else {
            echo "0";
        }
    }
}
