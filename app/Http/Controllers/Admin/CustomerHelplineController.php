<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\CustomerHelpline;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Session;
use Storage;

ini_set('memory_limit', '-1');

class CustomerHelplineController extends Controller {
    protected $common;

    public function __construct(Request $request) {
        $this->common = new Common;

    }

    public function CustomerHelpline(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        // $customerHelpline = CustomerHelpline::with(['User' => function ($q) {
        //     $q->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        // }])
        //     ->with(['Resume' => function ($query) {
        //         $query->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        //     }])

        //     ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
        //     ->orderBy('CustomerHelplineId', 'desc')
        //     ->get();

        return view('admin.customerhelpline.customerhelpline');
    }

    public function CustomerHelplineDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $customerHelpline = CustomerHelpline::with(['User' => function ($q) {
            $q->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        }])
            ->with(['Resume' => function ($query) {
                $query->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            }])

            ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->orderBy('CustomerHelplineId', 'desc')
            ->get();
        $arrItem = [];
        foreach ($customerHelpline as $itm) {
            if ($itm->User && $itm->Resume) {
                $fieldName   = Constant::resumeField[$itm->ResumeFieldId];
                $Create_Date = Carbon::parse($itm->created_at)->addHour(5)->addMinutes(30)->format('d-m-Y g:i A');
                $varItem     = [
                    'CustomerHelplineId'  => $itm->CustomerHelplineId,
                    'UserId'              => $itm->User->UserId,
                    'UserName'            => $itm->User->UserName,
                    'UserRegistrationId'  => $itm->User->UserRegistrationId,
                    'ResumeId'            => $itm->Resume->ResumeId,
                    'ResumeName'          => $itm->Resume->ResumeName,
                    'ResumeFieldId'       => $itm->ResumeFieldId,
                    'ResumeFieldQuestion' => $itm->ResumeFieldQuestion,
                    'ResumeFieldAnswer'   => $itm->ResumeFieldAnswer,
                    'ResumeFieldName'     => $fieldName,
                    'CreatedDate'         => $Create_Date,

                ];
                array_push($arrItem, $varItem);
            }
        }
        return Datatables::of($arrItem)->addIndexColumn()->addColumn('action', function ($row) {

            $url    = url('admin/customer-helpline/view-customer-helpline') . '/' . $row['CustomerHelplineId'];
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

    public function ViewCustomerHelpline($CustomerHelplineId) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $customerHelpline = CustomerHelpline::with('Resume')
            ->where('CustomerHelplineId', $CustomerHelplineId)
            ->first();

        $resumeField = Constant::resumeField;

        $filePath  = 'pdf/' . $customerHelpline->Resume->ResumeName;
        $resumeUrl = Storage::disk('s3')->url($filePath);

        return view('admin.customerhelpline.viewcustomerhelpline')->with([
            'customerHelpline' => $customerHelpline,
            'resumeField'      => $resumeField,
            'resumeUrl'        => $resumeUrl,
        ]);
    }

    public function UpdateCustomerHelpline(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $customerHelpline = CustomerHelpline::where('CustomerHelplineId', $request->CustomerHelplineId)
            ->update([
                'ResumeFieldAnswer' => $request->ResumeFieldAnswer,
            ]);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgCustomerHelplineAnswer']);

        return redirect('admin/customer-helpline');
    }
}
