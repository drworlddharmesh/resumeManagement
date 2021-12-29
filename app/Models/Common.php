<?php

namespace App\Models;

use App\Models\ApiLog;
use App\Models\Constant;
use App\Models\CustomerHelpline;
use App\Models\FitnessTest;
use App\Models\JWT;
use App\Models\MedicalForm;
use App\Models\User;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Image;
use Session;
use Storage;

class Common extends Model {
    public function ValidateToken() {
        $user = User::where('Token', Session::get('Token'))->first();

        if ($user) {
            return $user->UserId;
        } else {
            Session::flush();
            return false;
        }

    }

    // Genrate Token
    public function GetnewToken() {
        error_reporting(0);

        $header  = '{"typ":"JWT","alg":"HS256"}';
        $payload = "FitnessDiary";

        $JWT = new JWT;

        return $JWT->encode($header, $payload, date('Y-m-d H:i:s'));
    }

    public static function image($name) {
        $filePath = 'agreement/' . $name;
        return Storage::disk('s3')->url($filePath);
    }
    public static function pdf($name) {
        $filePath = 'pdf/' . $name;
        return Storage::disk('s3')->url($filePath);
    }
    // Inesrt API logs
    public function ApiLog($apiUserId, $apiName, $apiRequest, $apiResponse) {
        ApiLog::create([
            'UserId'   => $apiUserId,
            'ApiName'  => $apiName,
            'Request'  => $apiRequest,
            'Response' => $apiResponse,
        ]);
    }
    public function CheckSignture($UserId) {
        $userdata = User::FindorFail($UserId);
        if ($userdata->UserSignature) {
            return true;
        } else {
            return false;
        }
    }

    public function CheckUserStatus($UserId) {
        $userdata = User::FindorFail($UserId);
        if ($userdata->resumeAllow != 0) {
            return true;
        } else {
            return false;
        }
    }

    // Convert NULL to empty string
    public function ResponseEmptyString($str) {
        $responseString = '';
        if ($str != NULL) {
            $responseString = $str;
        }

        return $responseString;
    }

    // Upload image
    public function UploadImage($file, $dir, $dirThumb, $filecount = null) {
        $fileName = time() . $filecount . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs($dir, $file, $fileName);

        $imgThumb = Image::make(storage_path('/app') . '/' . $dir . '/' . $fileName)->resize(70, 70, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imgThumb->save(storage_path('/app') . '/' . $dirThumb . '/' . $fileName);

        return $fileName;
    }

    // Upload video and it's thumbnail both
    public function UploadMedia($file, $dir, $filecount = null) {
        $fileName = time() . $filecount . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs($dir, $file, $fileName);

        return $fileName;
    }

    // Generate response medial link
    public function ResponseMediaLink($file, $dirfolder) {
        $fileResponseLink = url('storage/app') . '/' . $dirfolder . '/placeholder.png';
        if (strpos($file, 'http') !== false) {
            $fileResponseLink = $file;
        } else {
            if ($file != "" || $file != NULL) {
                $fileResponseLink = url('storage/app') . '/' . $dirfolder . '/' . $file;
            }
        }

        return $fileResponseLink;
    }

    // Remove image
    public function RemoveImageWithThumbnail($file, $dir, $dirThumb) {
        // Remove original image
        $existImage = storage_path() . '/app/' . $dir . '/' . $file;
        if (File::exists($existImage)) {
            File::delete($existImage);
        }

        // Remove thumbnail image
        $existImageThumbnail = storage_path() . '/app/' . $dirThumb . '/' . $file;
        if (File::exists($existImageThumbnail)) {
            File::delete($existImageThumbnail);
        }
    }

    // Remove post media
    public function RemovePostMedia($file, $fileType, $fileThumb, $dir, $dirThumb) {
        // Remove original media
        $existMedia = storage_path() . '/app/' . $dir . '/' . $file;
        if (File::exists($existMedia)) {
            File::delete($existMedia);
        }

        // Remove thumbnail media
        if ($fileType == Constant::mediaType['Image']) {
            $existMediaThumbnail = storage_path() . '/app/' . $dirThumb . '/' . $file;
            if (File::exists($existMediaThumbnail)) {
                File::delete($existMediaThumbnail);
            }
        } else if ($fileType == Constant::mediaType['Video']) {
            $existMediaThumbnail = storage_path() . '/app/' . $dirThumb . '/' . $fileThumb;
            if (File::exists($existMediaThumbnail)) {
                File::delete($existMediaThumbnail);
            }
        }
    }

    // Simple crypt
    public function MySimpleCrypt($string, $action = 'e') {
        // you may change these values to your own
        $secret_key = 'fitness_diary_secret_key';
        $secret_iv  = 'fitness_diary_secret_iv';

        $output         = false;
        $encrypt_method = "AES-256-CBC";
        $key            = hash('sha256', $secret_key);
        $iv             = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'e') {
            $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        } else if ($action == 'd') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    // Encrypt data
    public function Encrypt($data) {
        // return encrypt($data);
        return $this->MySimpleCrypt($data, 'e');
    }

    // Decrypt data
    public function Decrypt($data) {
        // return decrypt($data);
        return $this->MySimpleCrypt($data, 'd');
    }

    // Generate OTP
    public function GenerateOTP() {
        return mt_rand(100000, 999999);
    }

    // Convert boolean to integer
    public function BooleanToInteger($boolean) {
        $int = $boolean == true ? 1 : 0;

        return $int;
    }

    // Convert integer to boolean
    public function IntegerToBoolean($int) {
        $boolean = $int == 1 ? true : false;

        return $boolean;
    }

    // Check is medical form submited
    public function CheckMedicalFormSubmited($userId) {
        $isSubmitededMedicalForm = false;

        $medicalForm = MedicalForm::where('UserId', $userId)
            ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->get();

        if (count($medicalForm) > 0) {
            $isSubmitededMedicalForm = true;
        }

        return $isSubmitededMedicalForm;
    }

    // Check is fitness test submited
    public function CheckFitnessTestSubmited($userId) {
        $isSubmitededFitnessTest = false;

        $fitnessTest = FitnessTest::where('UserId', $userId)
            ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->get();

        if (count($fitnessTest) > 0) {
            $isSubmitededFitnessTest = true;
        }

        return $isSubmitededFitnessTest;
    }

    // Decrypt AdminId
    public function DecryptAdminId($admin) {
        return decrypt($admin);
    }
    public static function ClientQueryLimit() {
        $adminId    = decrypt(Session::get('ClientId'));
        $TotalQuery = CustomerHelpline::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('UserId', $adminId)
            ->count('UserId');
        $TotalResume = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('UserId', $adminId)->first();

        $TotalLimit = round($TotalResume->ResumeTotalCount * 15 / 100);
        if ($TotalQuery <= $TotalLimit) {
            return true;
        } else {
            return false;
        }
    }
    public function passfail($data) {
        $pass = 0;
        $fail = 0;
        foreach ($data as $dt) {
            if ($dt) {

                if ($dt->ResumeStatus == 1) {
                    $pass = $pass + 1;
                } else {
                    $fail = $fail + 1;
                }

            }

        }

        return $fail;
    }
    public function pass($fail, $total) {
        $TotalLimit = round($total * 12 / 100);
        if ($fail <= $TotalLimit) {
            return true;
        } else {
            return false;
        }
    }
    public static function ExpiredDate() {
        $adminId = decrypt(Session::get('ClientId'));
        $client  = User::where('UserId', $adminId)->first();
        return Carbon::parse($client->UserEndDate)->format('d-m-Y g:i A');
    }
    public static function dateformat($date) {
        return Carbon::parse($date)->format('d-m-Y g:i A');
    }
    public function resumeLimit($UserId) {
        $User = User::where('UserId', $UserId)->where('IsRemoved', Constant::isRemoved['NotRemoved'])->first();
        $Plan = Plan::where('PlanId', $User->PlanId)->where('IsRemoved', Constant::isRemoved['NotRemoved'])->first();
        return $Plan->PlanForms;

    }

    public function ResumeSubmitCount($UserId) {
        return $count = 600/*Resume_allow::where('IsRemoved', Constant::isRemoved['NotRemoved'])
        ->where('ResumeAllowUserId', $UserId)
        ->where('ResumeStatus', Constant::resumeStatus['NotSubmit'])
        ->count()*/;
    }
   public function DateRangeFilterStart($date)
   {
    return Carbon::parse($date)->startOfDay()->format('Y-m-d H:i:s');
   }
   public function DateRangeFilterEnd($date)
   {
    return Carbon::parse($date)->endOfDay()->format('Y-m-d H:i:s');
   }
    public function ResumeFail() {
        $adminId = decrypt(Session::get('ClientId'));

        date_default_timezone_set('Asia/Kolkata');
        $CurrentDate = date("Y-m-d H:i:s");

        $user = User::where('UserId', $adminId)->whereDate('UserEndDate', '<', Carbon::now())->first();

        if ($user) {
            return true;
        }

        return false;
    }

    public function AddResumeSubmitCount($UserId) {
        $User = User::where('UserId', $UserId)->first();
        if ($User->ResumeTotalCount > $User->ResumeSubmitCount) {
            User::where('UserId', $UserId)
                ->update([
                    'ResumeSubmitCount' => $User->ResumeSubmitCount + 1,
                ]);
        }

        if ($User->ResumeSubmitCount + 1 >= $User->ResumeTotalCount) {
            User::where('UserId', $UserId)
                ->update([
                    'ResumeSubmitStatus' => Constant::UserResumeStatus['Submit'],
                ]);
        }

    }

    public function ResumeSubmitDateCheck($ResumeDate) {
        date_default_timezone_set('Asia/Kolkata');
        $CurrentDate = date("Y-m-d H:i:s");

        if ($ResumeDate) {
            $TodayDate = Carbon::parse($this->CurrentDate)->format('Y-m-d H:i:s');

            $CheckDate = Carbon::parse($ResumeDate->ResumeSubmitDate)->addDays(2)->format('Y-m-d H:i:s');
            if ($TodayDate >= $CheckDate) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function ggGetBrowserName() {
        $browser = "";
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
            $browser = 'Internet explorer';
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false) {
            $browser = 'Internet explorer';
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false) {
            $browser = 'Mozilla Firefox';
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false) {
            $browser = 'Google Chrome';
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false) {
            $browser = "Opera Mini";
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
            $browser = "Opera";
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false) {
            $browser = "Safari";
        } else {
            $browser = 'Other';
        }
        return $browser;
    }

    public function getManu() {
        $adminId  = decrypt(Session::get('AdminId'));
        $SubAdmin = User::where('UserId', $adminId)
            ->where('userType', Constant::userType['SubAdmin'])
            ->first();

        if ($SubAdmin) {
            $Manu = ManuRelation::where('IsRemoved', Constant::isRemoved['NotRemoved'])
                ->where('Status', Constant::ManuStatus['Active'])
                ->where('UserId', $SubAdmin->UserId)
            // ->with('Manus')
                ->get()->toArray();

            // $ManuArray = array_column($Manu, 'manus');
            // return $ManuArray;
            $ManuNameArray = array_column($Manu, 'ManuId');
            return $ManuNameArray;
        } else {
            $Manu          = Manu::where('IsRemoved', Constant::isRemoved['NotRemoved'])->get()->toArray();
            $ManuNameArray = array_column($Manu, 'ManuId');
            return $ManuNameArray;
        }

    }

}
