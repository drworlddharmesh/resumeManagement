<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Dotenv\Validator;
use App\Models\Common;
use App\Models\Constant;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Session;
use Storage;
use DataTables;

class ResumeController extends Controller
{
    protected $common;

    public function __construct(Request $request)
    {
        $this->common = new Common;
    }
    public function Resume(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        
          
        return view('admin.resume.resume');
    }
    public function ResumeDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $ResumeData = Resume::where('IsRemoved', Constant::isRemoved['NotRemoved'])
        ->orderBy('ResumeId', 'desc')
        ->get();

        $arrItem = [];
        foreach ($ResumeData as $itm) {
          
            $date = date('Y-m-d',strtotime($itm['created_at']));

            $varItem = [
                'ResumeId'             => $itm->ResumeId,
                'ResumeName'             => $itm->ResumeName,
                'created_at'           => $date,
               
            ];

            array_push($arrItem, $varItem);
        }
        return Datatables::of($arrItem)->addIndexColumn()->addColumn('action', function ($row) {
               
                $url    = url('admin/resume/edit-resume') . '/' . $row['ResumeId'];
                $pdf =  Common::pdf($row['ResumeName']);
                $action = '<center>
                <a href="' . $url . '" title="Edit">
                    <i class="fa fa-pencil"></i>
                </a>
                &nbsp
                
                <a href="' . $pdf . '" title="view" target="__blank">
                    <i class="fa fa-eye"></i>
                </a>
                &nbsp
                <a href="javascript:void(0)" onclick="DeleteHealthCondition(' . $row['ResumeId'] . ')" data-toggle="tooltip" title="Delete">
                    <i class="fa fa-trash"></i>
                </a>
            </center>';

                return $action;

            })
            ->rawColumns(['action'])
            ->make(true);
        }
    // Add Health Condition
    public function AddResume(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        return view('admin.resume.add-resume');
    }
    public function DeleteResume(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $ResumeId = $request['ResumeId'];

        Resume::where('ResumeId', $ResumeId)
            ->update([
                'IsRemoved' => Constant::isRemoved['Removed'],
            ]);
            $resume = Resume::where('ResumeId',$ResumeId)->first();
        $filePath = 'pdf/' . $resume->ResumeName;
          Storage::disk('s3')->delete($filePath);

        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgDeleteResume']);
    }
    // Insert Resume
    public function InsertResume(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $adminId = $this->common->DecryptAdminId(Session::get('AdminId'));
       //     $resume = Resume::where('ResumeId',7)->first();
    //     $filePath = 'pdf/' . $resume->ResumeName;
    //     $url = Storage::disk('s3')->url($filePath);
    //   dd($url);
        $files = $request->file('ResumeName');
        $folder = 'pdf';
        $i = 1;
        foreach($files as $file)
        {
           
            $file_name = $this->upload_image($file,$folder,$i);   
            $ResumeInsert = Resume::create([
                'ResumeName' => $file_name,
            ]);
            $i++;
        }
        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertResume']);
        return redirect('admin/resume');
    }
    public function upload_image($file, $folder,$i)
    {
    
            $name=time().$i;
            $filePath = 'pdf/' . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file),'public');
    
        
        return $name;
    }
    // Edit Resume
    public function EditResume($ResumeId)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }



        $ResumeData = Resume::where('ResumeId', $ResumeId)->first();

        return view('admin.resume.edit-resume')->with([
            'ResumeData'   => $ResumeData,
        ]);
    }
    // Update Resume
    public function UpdateResume(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $ResumeId = $request->ResumeId;
        //get the file
        $file = $request->file('ResumeName');
        //get the file name
        if($file)
        {
            $file = $request->file('ResumeName');
            $folder = 'pdf';
                   $resume = Resume::where('ResumeId',$ResumeId)->first();
        $filePath = 'pdf/' . $resume->ResumeName;
          Storage::disk('s3')->delete($filePath);
          $i = 1;
            $file_name = $this->upload_image($file,$folder,$i);
            Resume::where('ResumeId', $ResumeId)
                ->update([
                    'ResumeName' => $file_name,
                ]);
        }
       
        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgUpdateResume']);
        return redirect('admin/resume');
    }

    public function DeleteResumes(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        return view('admin.resume.delete-resumes');
    }
    public function resumes_delete(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
      $DeleteId = $request->Name;
      $resumeIds = explode("\n", str_replace("\r", "", $DeleteId));
      foreach($resumeIds as $resumeId)
      {
          
        $filePath = 'pdf/'.$resumeId;
        Storage::disk('s3')->delete($filePath);
        Resume::where('ResumeName', $resumeId)
        ->update([
            'IsRemoved' => Constant::isRemoved['Removed'],
        ]);
        
      }
      Session::flash('ErrorMessage', Constant::adminSessionMessage['msgResumeMutipleDeleted']);
      return redirect('admin/resume/delete-resumes');
    }
}
