<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\Image;
use Illuminate\Http\Request;
use DataTables;
use Session;
use Storage;
class ImageController extends Controller
{
    protected $common;

    public function __construct(Request $request)
    {
        $this->common = new Common;
    }
    public function Image(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        
        return view('admin.image.image');
    }

    public function ImageDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $ImageData = Image::where('IsRemoved', Constant::isRemoved['NotRemoved'])
        ->orderBy('ImageId', 'desc')
        ->get();

        $arrItem = [];
        foreach ($ImageData as $itm) {
          
             $pdf = Common::image($itm['ImageName']); 
             $date = date('Y-m-d',strtotime($itm['created_at']));
            $varItem = [
                'ImageId'             => $itm->ImageId,
                'ImageName'             => $itm->ImageName,
                'created_at'             => $date,
                'Image'           => $pdf,
               
            ];

            array_push($arrItem, $varItem);
        }
        return Datatables::of($arrItem)->addIndexColumn()->addColumn('action', function ($row) {
               
                $url    = url('admin/image/edit-image') . '/' . $row['ImageId'];
                $action = '<center>
                <a href="' . $url . '" title="Edit">
                    <i class="fa fa-pencil"></i>
                </a>
                &nbsp

                <a href="javascript:void(0)" onclick="DeleteHealthCondition(' . $row['ImageId'] . ')" data-toggle="tooltip" title="Delete">
                    <i class="fa fa-trash"></i>
                </a>
            </center>';

                return $action;

            })
            ->rawColumns(['action'])
            ->make(true);
        }
    // Add Health Condition
    public function AddImage(Request $request)
    {
        return view('admin.image.add-image');
    }
    public function DeleteImage(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $ImageId = $request['ImageId'];

        Image::where('ImageId', $ImageId)
            ->update([
                'IsRemoved' => Constant::isRemoved['Removed'],
            ]);
            $Image = Image::where('ImageId', $ImageId)->first();
            $filePath = 'agreement/' . $Image->ImageName;
            Storage::disk('s3')->delete($filePath);
            
        Session::flash('ErrorMessage', Constant::adminSessionMessage['msgDeleteImage']);
    }
    // Insert Agreement
    public function InsertImage(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        
        $file = $request->file('ImageName');
        $folder = 'agreement';
        $file_name = $this->upload_image($file,$folder);
        $content = Storage::disk('s3')->get($folder . '/' . $file_name);
           

        $ImageInsert = Image::create([
            'ImageName' => $file_name,
        ]);

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgInsertImage']);

        return redirect('admin/image');
    }
    // Edit Franchisee
    public function EditImage($ImageId)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $ImageData = Image::where('ImageId', $ImageId)->first();
        $filePath = 'agreement/' . $ImageData->ImageName;
        $url = Storage::disk('s3')->url($filePath);
        return view('admin.image.edit-image')->with([
            'ImageData'   => $ImageData,
            'URL' => $url
        ]);
    }
    // Update Franchisee
    public function UpdateImage(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $ImageId = $request->ImageId;
        

        if ($request->ImageName) {
            $image = Image::where('ImageId', $ImageId)->first();
            $filePath = 'agreement/' . $image->ImageName;
            Storage::disk('s3')->delete($filePath);
           
            $file = $request->file('ImageName');
            $folder = 'agreement';
            $file_name = $this->upload_image($file, $folder);      
            $content = Storage::disk('s3')->get($folder . '/' . $file_name);
            $filename = str_replace(' ', '_', $file_name);

            Image::where('ImageId', $ImageId)
                ->update([
                    'ImageName' => $file_name,
                ]);
        } 
        

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgUpdateImage']);

        return redirect('admin/image');
    }

    public function upload_image($file, $folder)
    {

        $name = time() . $file->getClientOriginalName();
        $filePath = 'agreement/' . $name;
        Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');
        return $name;
    }
}
