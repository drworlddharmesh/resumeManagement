<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\CustomerCare;
use Illuminate\Http\Request;
use DataTables;

use Session;

class CustomerCareController extends Controller
{
    protected $common;

    public function __construct(Request $request)
    {
        $this->common = new Common;
    }
    public function CustomerCare(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        return view('admin.customer-care.customer-care');
    }

    public function CustomerCareDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $CallerData = CustomerCare::where('IsRemoved', Constant::isRemoved['NotRemoved'])
        ->orderBy('CustomerCareId', 'asc')
        ->get();

        $arrItem = [];
        foreach ($CallerData as $itm) {
          

            $varItem = [
                'CustomerCareId'             => $itm->CustomerCareId,
                'CustomerCareNo'           => $itm->CustomerCareNo,
               
            ];

            array_push($arrItem, $varItem);
        }
        return Datatables::of($arrItem)->addIndexColumn()->addColumn('action', function ($row) {
               
                $url    = url('admin/customer-care/edit-customer-care') . '/' . $row['CustomerCareId'];
                $action = '<center>
                <a href="' . $url . '" title="Edit">
                    <i class="fa fa-pencil"></i>
                </a>
                &nbsp

                <a href="javascript:void(0)" onclick="DeleteHealthCondition(' . $row['CustomerCareId'] . ')" data-toggle="tooltip" title="Delete">
                    <i class="fa fa-trash"></i>
                </a>
            </center>';

                return $action;

            })
            ->rawColumns(['action'])
            ->make(true);
        }
    // Add Health Condition
    public function AddCustomerCare(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
 
        return view('admin.customer-care.add-customer-care');
    }
    public function DeleteCustomerCare(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $CallerId = $request['CallerId'];

        CustomerCare::where('CustomerCareId', $CallerId)
            ->update([
                'IsRemoved' => Constant::isRemoved['Removed'],
            ]);

        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgDeleteCustomerCare']);
    }
    // Insert Caller
    public function InsertCustomerCare(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
       
        $CustomerCareNo = $request->CustomerCareNo;
        $CustomerCare = CustomerCare::create([
            'CustomerCareNo' => $CustomerCareNo,
        ]);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertCustomerCare']);

        return redirect('admin/customer-care');
    }
    // Edit Caller
    public function EditCustomerCare($CustomerCareId)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
 
        $CallerData = CustomerCare::where('CustomerCareId', $CustomerCareId)->first();

        return view('admin.customer-care.edit-customer-care')->with([
            'CallerData'   => $CallerData,
           
        ]);
    }
    // Update Caller
    public function UpdateCustomerCare(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $CustomerCareId = $request->CustomerCareId;
       
        $CustomerCareNo = $request->CustomerCareNo;
        CustomerCare::where('CustomerCareId', $CustomerCareId)
            ->update([

                'CustomerCareNo' => $CustomerCareNo,
               

            ]);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgUpdateCustomerCare']);

        return redirect('admin/customer-care');
    }
   
}
