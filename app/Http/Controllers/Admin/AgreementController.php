<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\Agreement;
use Illuminate\Http\Request;
use DataTables;

use Session;
use Storage;
class AgreementController extends Controller
{
    protected $common;

    public function __construct(Request $request)
    {
        $this->common = new Common;
    }
    public function Agreement(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        
        return view('admin.agreement.agreement');
    }
    public function AgreementDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $AgreementData = Agreement::where('IsRemoved', Constant::isRemoved['NotRemoved'])
        ->orderBy('AgreementId', 'desc')
        ->get();

        $arrItem = [];
        foreach ($AgreementData as $itm) {
          
             $pdf = Common::image($itm->AgreementPDF); 
            $varItem = [
                'AgreementId'             => $itm->AgreementId,
                'AgreementNo'             => $itm->AgreementNo,
                'AgreementPDF'           => $pdf
            ];

            array_push($arrItem, $varItem);
        }
        return Datatables::of($arrItem)->addIndexColumn()->addColumn('action', function ($row) {
               
                $url    = url('admin/agreement/edit-agreement') . '/' . $row['AgreementId'];
                $action = '<center>
                <a href="' . $url . '" title="Edit">
                    <i class="fa fa-pencil"></i>
                </a>
                &nbsp

                <a href="javascript:void(0)" onclick="DeleteHealthCondition(' . $row['AgreementId'] . ')" data-toggle="tooltip" title="Delete">
                    <i class="fa fa-trash"></i>
                </a>
            </center>';

                return $action;

            })
            ->rawColumns(['action'])
            ->make(true);
        }
    // Add Health Condition
    public function AddAgreement(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        return view('admin.agreement.add-agreement');
    }
    public function DeleteAgreement(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $AgreementId = $request['AgreementId'];

        Agreement::where('AgreementId', $AgreementId)
            ->update([
                'IsRemoved' => Constant::isRemoved['Removed'],
            ]);
            $agreement = Agreement::where('AgreementId', $AgreementId)->first();
            $filePath = 'agreement/' . $agreement->AgreementPDF;
            Storage::disk('s3')->delete($filePath);
            $local = str_replace(' ', '_', $agreement->AgreementPDF);
          
        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgDeleteAgreement']);
    }
    // Insert Agreement
    public function InsertAgreement(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $adminId = $this->common->DecryptAdminId(Session::get('AdminId'));
        $file = $request->file('AgreementName');
        $folder = 'agreement';
        $file_name = $this->upload_image($file,$folder);
        $content = Storage::disk('s3')->get($folder . '/' . $file_name);
            $filename = str_replace(' ', '_', $file_name);
            
        
        $AgreementInsert = Agreement::create([
            'AgreementPDF' => $file_name,
            'AgreementNo' => $request->AgreementNo,
        ]);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertAgreement']);

        return redirect('admin/agreement');
    }
    // Edit Franchisee
    public function EditAgreement($AgreementId)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $AgreementData = Agreement::where('AgreementId', $AgreementId)->first();

        return view('admin.agreement.edit-agreement')->with([
            'AgreementData'   => $AgreementData,
        ]);
    }
    // Update Franchisee
    public function UpdateAgreement(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $AgreementId = $request->AgreementId;
        $AgreementNo = $request->AgreementNo;
       
        if ($request->AgreementName) {
            $agreement = Agreement::where('AgreementId', $AgreementId)->first();
            $filePath = 'agreement/' . $agreement->AgreementPDF;
            Storage::disk('s3')->delete($filePath);
            $local = str_replace(' ', '_', $agreement->AgreementPDF);
          
            $file = $request->file('AgreementName');
            $folder = 'agreement';
            $file_name = $this->upload_image($file, $folder);
                        // Get the file contents
                 
            $content = Storage::disk('s3')->get($folder . '/' . $file_name);
            $filename = str_replace(' ', '_', $file_name);
           

            Agreement::where('AgreementId', $AgreementId)
                ->update([
                    'AgreementPDF' => $file_name,
                    'AgreementNo' => $AgreementNo,
                    
                ]);
        } else {
            Agreement::where('AgreementId', $AgreementId)
                ->update([
                    'AgreementNo' => $AgreementNo,
                   
                ]);
        }

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgUpdateAgreement']);

        return redirect('admin/agreement');
    }

    public function CheckAgreementName(Request $request)
    {
        $AgreementName = $request->AgreementName;
        $AgreementData =  Agreement::where('AgreementNo', $AgreementName)
            ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->first();

        if ($AgreementData) {
            echo true;
        } else {
            echo false;
        }
    }
    public function CheckEditAgreementName(Request $request)
    {
        $healthConditionId = $request->AgreementId;

        $healthCondition = Agreement::where('AgreementId', '!=', $healthConditionId)
            ->where('AgreementNo', $request->AgreementName)
            ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->first();

        if ($healthCondition) {
            echo "1";
        } else {
            echo "0";
        }
    }
    public function upload_image($file, $folder)
    {

        $name = time() . $file->getClientOriginalName();
        $filePath = 'agreement/' . $name;
        Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');


        return $name;
    }
}
