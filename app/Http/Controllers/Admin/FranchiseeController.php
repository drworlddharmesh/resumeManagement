<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\Franchisee;
use Illuminate\Http\Request;
use DataTables;
use Session;

class FranchiseeController extends Controller
{
    protected $common;

    public function __construct(Request $request)
    {
        $this->common = new Common;
    }
    public function Franchisee(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

     
        return view('admin.franchisee.franchisee');
    }
    public function FranchiseerDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $FranchiseeData = Franchisee::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('FranchiseeId', 'desc')
            ->get();

        $arrItem = [];
        foreach ($FranchiseeData as $itm) {
          

            $varItem = [
                'FranchiseeId'             => $itm->FranchiseeId,
                'FranchiseeName'           => $itm->FranchiseeName,
               
            ];

            array_push($arrItem, $varItem);
        }
        return Datatables::of($arrItem)->addIndexColumn()->addColumn('action', function ($row) {
               
                $url    = url('admin/franchisee/edit-franchisee') . '/' . $row['FranchiseeId'];
                $action = '<center>
                <a href="' . $url . '" title="Edit">
                    <i class="fa fa-pencil"></i>
                </a>
                &nbsp

                <a href="javascript:void(0)" onclick="DeleteHealthCondition(' . $row['FranchiseeId'] . ')" data-toggle="tooltip" title="Delete">
                    <i class="fa fa-trash"></i>
                </a>
            </center>';

                return $action;

            })
            ->rawColumns(['action'])
            ->make(true);
        }
    // Add Health Condition
    public function AddFranchisee(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        return view('admin.franchisee.add-franchisee');
    }
    public function DeleteFranchisee(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $FranchiseeId = $request['FranchiseeId'];

        Franchisee::where('FranchiseeId', $FranchiseeId)
            ->update([
                'IsRemoved' => Constant::isRemoved['Removed'],
            ]);

        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgDeleteFranchisee']);
    }
    // Insert Franchisee
    public function InsertFranchisee(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $adminId = $this->common->DecryptAdminId(Session::get('AdminId'));
        $FranchiseeName = $request->FranchiseeName;
        $FranchiseeInsert = Franchisee::create([
            'FranchiseeName' => $FranchiseeName,
        ]);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertFranchisee']);

        return redirect('admin/franchisee');
    }
    // Edit Franchisee
    public function EditFranchisee($FranchiseeId)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $FranchiseeData = Franchisee::where('FranchiseeId', $FranchiseeId)->first();

        return view('admin.franchisee.edit-franchisee')->with([
            'FranchiseeData'   => $FranchiseeData,
        ]);
    }
    // Update Franchisee
    public function UpdateFranchisee(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $FranchiseeId = $request->FranchiseeId;
        $FranchiseeName = $request->FranchiseeName;
        Franchisee::where('FranchiseeId', $FranchiseeId)
            ->update([

                'FranchiseeName' => $FranchiseeName,


            ]);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgUpdateFranchisee']);

        return redirect('admin/franchisee');
    }

    public function CheckFranchiseeName(Request $request)
    {
        $FranchiseeName = $request->FranchiseeName;
       $FranchiseeData =  Franchisee::where('FranchiseeName', $FranchiseeName)
       ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
       ->first();

        if ($FranchiseeData) {
            echo true;
        } else {
            echo false;
        }
    }
    public function CheckEditFranchiseeName(Request $request) {
        $healthConditionId = $request->FranchiseeId;

        $healthCondition = Franchisee::where('FranchiseeId', '!=', $healthConditionId)
            ->where('FranchiseeName', $request->FranchiseeName)
            ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->first();

        if ($healthCondition) {
            echo "1";
        } else {
            echo "0";
        }
    }

}
