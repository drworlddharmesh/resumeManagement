<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\Remark;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Session;
use Storage;
class RemarkController extends Controller
{
    protected $common;

    public function __construct(Request $request)
    {
        $this->common = new Common;
    }
    public function Remark(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        
        return view('admin.remark.remark');
    }

    public function RemarkDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $ClientData  = Remark::with('remark')
            ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->get();
        $arrItem = [];
        foreach ($ClientData as $itm) {
           if($itm->remark)
           {

           }
          
            $varItem = [
                'RemarkId'           => $itm->RemarkId,
                'CreateDate'        =>Carbon::parse($itm->created_at)->format('d-m-Y h:m:s'),
                'UserRegistrationId' => $itm->remark->UserRegistrationId,
                'UserName'           => $itm->remark->UserName,
                'RemarkText'     => $itm->RemarkText,
                'UserMoblieNumber'   => $itm->remark->UserMoblieNumber,
                'UserEmail'          => $itm->remark->UserEmail,
                'UserStartDate'      => Common::dateformat($itm->remark->UserStartDate),
                'UserEndDate'        => Common::dateformat($itm->remark->UserEndDate),
                'UserIpAddress'      => $itm->remark->UserIpAddress,
            ];

            array_push($arrItem, $varItem);
        }

        
        return Datatables::of($arrItem)->addIndexColumn()->make(true);
        }
  
    
    // Insert Agreement
    public function InsertRemark(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $RemarkInsert = Remark::create([
            'RemarkUserId'=>$request->RemarkId,
            'RemarkText' => $request->RemarkText,
        ]);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertRemark']);

        return back();
    }
}
