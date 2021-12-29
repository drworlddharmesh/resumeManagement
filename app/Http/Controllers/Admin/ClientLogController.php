<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\Logger_data;
use App\Models\Logger_user;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Session;

class ClientLogController extends Controller
{
    protected $common;

    public function __construct(Request $request)
    {
        $this->common = new Common;
    }
    public function ClientLog(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }


        return view('admin.clientlog.clientlog');
    }
    public function ClientLogDataTable(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $ClientData  = Logger_user::with(['User' => function ($query) {
            $query->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        }])
            ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->get();

        $arrItem = [];
        foreach ($ClientData as $itm) {
            if ($itm->User) {
            $varItem = [
                'Id'           => $itm->Id,
                'UserId'           => $itm->User->UserId,
                'UserName'           => $itm->User->UserName,
                'UserRegistrationId' => $itm->User->UserRegistrationId,
                'ResendPassword'     => $itm->User->ResendPassword,
                'UserMoblieNumber'   => $itm->User->UserMoblieNumber,
                'UserEmail'          => $itm->User->UserEmail,
                'UserStartDate'      => Common::dateformat($itm->User->UserStartDate),
                'UserEndDate'        => Common::dateformat($itm->User->UserEndDate),
                'UserIpAddress'      => $itm->User->UserIpAddress,

            ];

            array_push($arrItem, $varItem);
        }
        }

        return Datatables::of($arrItem)->addIndexColumn()
            ->addColumn('action', function ($row) {

                $url    = url('admin/client-log/details') . '/' . $row['Id'];
                $action = '<center>
                <a href="' . $url . '" title="View">
                    <i class="fa fa-eye"></i>
                </a>
               
            </center>';

                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function Details($Id)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
      
        
        return view('admin.clientlog.userdata')->with([
            'Id' => $Id,
        ]);
    }
    public function DetailsDataTable(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $Id = decrypt(Session::get('LogIdDataTable'));
        $ClientData  = Logger_data::where('Id',$Id)
            ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->get();

            
        $arrItem = [];
        foreach ($ClientData as $itm) {
           $msg = '';
           if($itm->LoggerStatus == 1)
           {
               $msg = Constant::LoggerData['1'];
           }else if ($itm->LoggerStatus == 2)
           {
            $msg = Constant::LoggerData['2'];
           }
           else{
            $msg = Constant::LoggerData['3'];  
           }
            $varItem = [
               
                'LoggerBrower'      => $itm->LoggerBrower,
                'LoggerIpAddress'      => $itm->LoggerIpAddress,
                'LoggerResumeNo'   => $itm->LoggerResumeNo,
                'LoggerStatus'      => $msg,
                'CreatedDate' => $this->common->dateformat($itm->created_at), 
               

            ];

            array_push($arrItem, $varItem);
      
        }

        return Datatables::of($arrItem)->addIndexColumn()->make(true);
    }
}
