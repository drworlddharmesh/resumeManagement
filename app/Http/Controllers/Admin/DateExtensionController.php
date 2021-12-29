<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Session;

class DateExtensionController extends Controller
{
    protected $common;

    public function __construct(Request $request)
    {
        $this->common = new Common;
    }

    public function date_extension(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        return view('admin.dateextension.dateextension');
    }

    public function update(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $UserRegistrationId =  $request->UserRegistrationId;
        $Date = $request->Date;
       $enddate =  Carbon::parse($Date)->endOfDay()->format('Y-m-d H:i:s');
       User::where('UserRegistrationId',$UserRegistrationId)
            ->update([
                'UserEndDate' => $enddate,
            ]);
            Session::flash('SuccessMessage', Constant::adminSessionMessage['msgDateExtension']);
            return redirect('admin/date-extension');
    }

    public function check_UserRegistrationId(Request $request)
    {
        $UserRegistrationId = $request->UserRegistrationId;
        $UserRegistrationIdData =  User::where('UserRegistrationId', $UserRegistrationId)
        ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
        ->first();
         if($UserRegistrationIdData)
         {
            $UserEndDate = $UserRegistrationIdData->UserEndDate;
         }
         else
         {
            $UserRegistrationIdData = '';
         }
      
 
         if ($UserRegistrationIdData) {
            return $UserEndDate;
         } else {
             
             return false;
         }

    }
    
}
