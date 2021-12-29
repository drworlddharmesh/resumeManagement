<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateUserResumeDataStatus;
use App\Models\Caller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\Franchisee;
use App\Models\Resume_allow;
use App\Models\Resume_detail;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Session;
use Storage;

ini_set('memory_limit', '-1');
class ResumeDetailsController extends Controller {
    protected $common;

    public function __construct(Request $request) {
        $this->common = new Common;
    }

    public function users(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $value = $request->get('value');
        if ($value) {
            Session::put('franchiseeid', $value);
        }
        if ($value == 'all') {
            Session::forget('franchiseeid');
        }

        $startDateRange = '';
        $endDateRange   = '';
        $selectField    = '';
        $fieldSearch    = '';
        if ($request->startDateRange || $request->endDateRange) {
            $startDateRange = $request->startDateRange;
            $endDateRange   = $request->endDateRange;
        }
        if ($request->selectField && $request->fieldSearch) {
            $selectField = $request->selectField;
            $fieldSearch = $request->fieldSearch;
        }

        $Franchisee = Franchisee::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->get();
        return view('admin.resumedetails.userreview')->with([

            'Franchisees'    => $Franchisee,
            'startDateRange' => $startDateRange,
            'endDateRange'   => $endDateRange,
        ]);
    }
    public function usersDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        date_default_timezone_set('Asia/Kolkata');
        $CurrentDay = date("Y-m-d");
        if ($request->startDateRange || $request->endDateRange) {
            $startDateRange = explode('-', $request->startDateRange);
            $endDateRange   = explode('-', $request->endDateRange);

            $startfrom = Carbon::parse($startDateRange[0])->startOfDay()->toDateTimeString();
            $startto   = Carbon::parse($startDateRange[1])->endOfDay()->toDateTimeString();

            $endfrom = Carbon::parse($endDateRange[0])->startOfDay()->toDateTimeString();
            $endtto  = Carbon::parse($endDateRange[1])->endOfDay()->toDateTimeString();

            $user = User::where(function ($query) use ($startfrom, $startto, $endfrom, $endtto) {
                $query->whereBetween('UserStartDate', [$startfrom, $startto]);
                $query->orWhereBetween('UserEndDate', [$endfrom, $endtto]);
            })

                ->with('Caller')->whereHas('Caller', function ($qc) {
                $qc->with('Franchisee')->whereHas('Franchisee', function ($qf) {
                    $qf->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                    if (Session::has('franchiseeid')) {
                        $qf->where('FranchiseeId', Session::get('franchiseeid'));
                    }
                });
                $qc->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            })
                ->whereDate('UserEndDate', '<', $CurrentDay)
                ->where('ResumeSubmitStatus', Constant::UserResumeStatus['Submit'])
                ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
                ->get();
        } else {

            $user = User::with('Caller')->whereHas('Caller', function ($qc) {
                $qc->with('Franchisee')->whereHas('Franchisee', function ($qf) {
                    $qf->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                    if (Session::has('franchiseeid')) {
                        $qf->where('FranchiseeId', Session::get('franchiseeid'));
                    }
                });
                $qc->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            })
                ->whereDate('UserEndDate', '<', $CurrentDay)
                ->where('ResumeSubmitStatus', Constant::UserResumeStatus['Submit'])
                ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
                ->get();

        }

        $arrData = [];
        foreach ($user as $cd) {
            // $TotalCount = $cd->Resume_allow_total; // count($cd->self);

            // if ($cd->Resume_allow >= $TotalCount) {
            // if ($cd->User) {
            // if ($cd->User->Caller) {
            // if ($cd->User->Caller->Franchisee) {
            $url    = url('admin/resumedetails') . '/' . $cd->UserId;
            $action = '<center>
                            <a href="' . $url . '" title="Edit">
                                <i class="fa fa-eye"></i>
                            </a>
                        </center>';
            $varData = [

                'UserName'           => $cd->UserName,
                'ResumeFailCount'    => $cd->ResumeFailCount,
                'UserRegistrationId' => $cd->UserRegistrationId,
                'UserEmail'          => $cd->UserEmail,
                'UserMoblieNumber'   => $cd->UserMoblieNumber,
                'FranchiseeName'     => $cd->Caller->Franchisee->FranchiseeName,
                'CallerName'         => $cd->Caller->CallerName,
                'UserStartDate'      => Common::dateformat($cd->UserStartDate),
                'UserEndDate'        => Common::dateformat($cd->UserEndDate),
                'action'             => $action,
            ];

            array_push($arrData, $varData);
            // }
            // }
            // }
            // }
        }

        return Datatables::of($arrData)->addIndexColumn()->make(true);

    }
    public function userssubmit(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        $value = $request->get('value');
        if ($value) {
            Session::put('franchiseeid', $value);
        }
        if ($value == 'all') {
            Session::forget('franchiseeid');
        }

        $startDateRange = '';
        $endDateRange   = '';
        if ($request->startDateRange || $request->endDateRange) {
            $startDateRange = $request->startDateRange;
            $endDateRange   = $request->endDateRange;
        }

        $Franchisee = Franchisee::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->get();

        return view('admin.resumedetailssubmit.userreview')->with([

            'Franchisees'    => $Franchisee,
            'startDateRange' => $startDateRange,
            'endDateRange'   => $endDateRange,

        ]);
    }

    public function usersDataTableSubmit(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        date_default_timezone_set('Asia/Kolkata');
        $CurrentDay = date("Y-m-d");

        if ($request->startDateRange || $request->endDateRange) {
            $startDateRange = explode('-', $request->startDateRange);
            $endDateRange   = explode('-', $request->endDateRange);

            $startfrom = Carbon::parse($startDateRange[0])->startOfDay()->toDateTimeString();
            $startto   = Carbon::parse($startDateRange[1])->endOfDay()->toDateTimeString();

            $endfrom = Carbon::parse($endDateRange[0])->startOfDay()->toDateTimeString();
            $endtto  = Carbon::parse($endDateRange[1])->endOfDay()->toDateTimeString();

            $user = User::where(function ($query) use ($startfrom, $startto, $endfrom, $endtto) {
                $query->whereBetween('UserStartDate', [$startfrom, $startto]);
                $query->orWhereBetween('UserEndDate', [$endfrom, $endtto]);
            })
                ->with('Caller')->whereHas('Caller', function ($qc) {
                $qc->with('Franchisee')->whereHas('Franchisee', function ($qf) {
                    $qf->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                    if (Session::has('franchiseeid')) {
                        $qf->where('FranchiseeId', Session::get('franchiseeid'));
                    }
                });
                $qc->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            })
                ->whereDate('UserEndDate', '<', $CurrentDay)
                ->where('ResumeSubmitStatus', Constant::UserResumeStatus['NotSubmit'])
                ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
                ->get();
        } else {
            $user = User::with('Caller')->whereHas('Caller', function ($qc) {
                $qc->with('Franchisee')->whereHas('Franchisee', function ($qf) {
                    $qf->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                    if (Session::has('franchiseeid')) {
                        $qf->where('FranchiseeId', Session::get('franchiseeid'));
                    }
                });
                $qc->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            })
                ->whereDate('UserEndDate', '<', $CurrentDay)
                ->where('ResumeSubmitStatus', Constant::UserResumeStatus['NotSubmit'])
                ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
                ->get();
        }

        $arrData = [];
        foreach ($user as $cd) {
            // $TotalCount = $cd->Resume_allow_total; // count($cd->self);

            // if ($cd->Resume_allow < $TotalCount) {
            // if ($cd->User) {

            // if ($cd->User->Caller) {
            // if ($cd->User->Caller->Franchisee) {
            //     $urlmove = url('admin/resumedetailsubmit/move') . '/' . $cd->User->UserId;
            //     $move = '<center>
            //     <a href="' . $urlmove . '" class="btn btn-success btn-sm">
            //     Move to submit
            //     </a>
            // </center>';
            //     $url = url('admin/resumedetails') . '/' . $cd->User->UserId;
            //     $action = '<center>
            //     <a href="' . $url . '" title="Edit">
            //         <i class="fa fa-pencil"></i>
            //     </a>
            // </center>';
            $varData = [
                'UserId'             => $cd->UserId,
                'UserName'           => $cd->UserName,
                'UserRegistrationId' => $cd->UserRegistrationId,
                'UserEmail'          => $cd->UserEmail,
                'UserMoblieNumber'   => $cd->UserMoblieNumber,
                'UserStartDate'      => Common::dateformat($cd->UserStartDate),
                'UserEndDate'        => Common::dateformat($cd->UserEndDate),
                'FranchiseeName'     => $cd->Caller->Franchisee->FranchiseeName,
                'CallerName'         => $cd->Caller->CallerName,
                'ResumeSubmitCount'  => $cd->ResumeSubmitCount/*$cd->Resume_allow_count*/,
                // 'move'             => $move,
                // 'action'             => $action,

            ];
            array_push($arrData, $varData);
            // }
            // }
            // }
            // }
        }

        return Datatables::of($arrData)->addIndexColumn()->addColumn('move', function ($row) {
            $urlmove = url('admin/resumedetailsubmit/move') . '/' . $row['UserId'];
            $btn     = '<center>
                        <a href="' . $urlmove . '" class="btn btn-success btn-sm">
                        Move to submit
                        </a>
                    </center>';

            return $btn;
        })
            ->addColumn('action', function ($row) {
                $url = url('admin/resumedetailsubmit') . '/' . $row['UserId'];
                $btn = '<center>
                        <a href="' . $url . '" title="Edit">
                            <i class="fa fa-eye"></i>
                        </a>
                    </center>';

                return $btn;
            })
            ->rawColumns(['move', 'action'])
            ->make(true);

    }
    public function Resume(Request $request, $UserId) {

        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $ResumeFailCount = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('UserId', $UserId)
            ->first();
        $selectField = '';
        $fieldSearch = '';
        if ($request->selectField || $request->fieldSearch) {
            $selectField = $request->selectField;
            $fieldSearch = $request->fieldSearch;
        }

        return view('admin.resumedetails.resume')->with([
            'UserId'          => $UserId,
            'ResumeFailCount' => $ResumeFailCount->ResumeFailCount,
            'selectField'     => $selectField,
            'fieldSearch'     => $fieldSearch,
        ]);
    }
    public function ResumeSubmitDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $UserId     = decrypt(Session::get('UserIdDataTable'));
        $ResumeData = [];
        $UserStatus = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('UserId', $UserId)
            ->first();
        if ($UserStatus->ResumeSubmitStatus == Constant::UserResumeStatus['Submit']) {
            if ($request->selectField) {
                $selectField = $request->selectField;
                $fieldSearch = $request->fieldSearch;
                $ResumeData  = Resume_allow::where('IsRemoved', Constant::isRemoved['NotRemoved'])
                    ->where('ResumeAllowUserId', $UserId)
                    ->where('ResumeStatus', '!=', Constant::resumeStatus['NotSubmit'])
                    ->with('Resume')->whereHas('Resume', function ($qp) {
                    $qp->orderBy('ResumeId', 'desc');
                })
                    ->with('Resume_detail')->whereHas('Resume_detail', function ($qp) use ($selectField, $fieldSearch) {
                    $qp->where($selectField, $fieldSearch);
                })
                //
                // ->orderBy('ResumeId', 'desc')
                    ->get();
                $arrItem      = [];
                $arrResumeIds = [];
                foreach ($ResumeData as $itm) {

                    $varItem = [
                        'ResumeAllowUserId' => $itm->ResumeAllowUserId,
                        'ResumeAllowId'     => $itm->ResumeAllowId,
                        'ResumeId'          => $itm->Resume->ResumeId,
                        'ResumeName'        => $itm->Resume->ResumeName,
                        'ResumeStatus'      => $itm->ResumeStatus,

                    ];
                    array_push($arrResumeIds, $itm['ResumeAllowId']);
                    array_push($arrItem, $varItem);
                }

            } else {
                $ResumeData = Resume_allow::where('resume_allows.IsRemoved', Constant::isRemoved['NotRemoved'])
                    ->where('resume_allows.ResumeAllowUserId', $UserId)
                    ->where('resume_allows.ResumeStatus', '!=', Constant::resumeStatus['NotSubmit'])
                    ->join('resumes', 'resumes.ResumeId', '=', 'resume_allows.ResumeAllowResumeId')
                    ->orderBy('resumes.ResumeId', 'desc')
                    ->get();

                $arrItem      = [];
                $arrResumeIds = [];
                foreach ($ResumeData as $itm) {

                    $varItem = [
                        'ResumeAllowUserId' => $itm->ResumeAllowUserId,
                        'ResumeAllowId'     => $itm->ResumeAllowId,
                        'ResumeId'          => $itm->ResumeId,
                        'ResumeName'        => $itm->ResumeName,
                        'ResumeStatus'      => $itm->ResumeStatus,

                    ];
                    array_push($arrResumeIds, $itm['ResumeAllowId']);
                    array_push($arrItem, $varItem);
                }
            }

        }

        Session::put('arrResumeIds', encrypt($arrResumeIds));
        return Datatables::of($arrItem)->addIndexColumn()->addColumn('action', function ($row) {

            $url    = url('admin/resumedetails/resume-details') . '/' . $row['ResumeAllowUserId'] . '/' . $row['ResumeAllowId'];
            $action = '<center>
                <a href="' . $url . '" title="View">
                    <i class="fa fa-eye"></i>
                </a>

            </center>';

            return $action;

        })
            ->addColumn('Status', function ($row) {

                $Status = '';
                if ($row['ResumeStatus'] == 2) {
                    $Status = '<center>
                <a href="#"  class="text-success">
                Not Submitted
                </a>
                </center>';
                    $notreview = ' <a class="text-success">Not Submitted</a>';

                }
                if ($row['ResumeStatus'] == 0) {
                    $Status = '<center>
                        <a href="#"  class="text-danger">
                        Fail
                        </a>
                    </center>';
                }
                if ($row['ResumeStatus'] == 1) {

                    $Status = '<center>
                        <a href="#"  class="text-warning">
                        Pass
                        </a>
                    </center>';
                }
                if ($row['ResumeStatus'] == 3) {
                    $Status = '<center>
                    <a href="#"  class="text-info">
                    Submitted
                    </a>
                    </center>';
                }

                return $Status;

            })
            ->rawColumns(['action', 'Status'])
            ->make(true);
    }

    public function Resume1($UserId) {

        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $ResumeData = [];
        $UserStatus = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('UserId', $UserId)
            ->first();
        if ($UserStatus->ResumeSubmitStatus == Constant::UserResumeStatus['NotSubmit']) {
            $ResumeData = Resume_allow::where('resume_allows.IsRemoved', Constant::isRemoved['NotRemoved'])
                ->where('resume_allows.ResumeAllowUserId', $UserId)
                ->join('resumes', 'resumes.ResumeId', '=', 'resume_allows.ResumeAllowResumeId')
                ->orderBy('resumes.ResumeId', 'desc')
                ->get();
        }
        return view('admin.resumedetailssubmit.resume')->with([
            'ResumeData' => $ResumeData,
        ]);
    }

    public function ResumeDetails($UserId, $ResumeAllowId) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $ResumeDetail = Resume_detail::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('ResumeAllowId', $ResumeAllowId)
            ->first();

        $UserData = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('UserId', $UserId)
            ->first();

        $resume = Resume_allow::where('resume_allows.IsRemoved', Constant::isRemoved['NotRemoved'])

            ->join('resumes', 'resumes.ResumeId', '=', 'resume_allows.ResumeAllowResumeId')
            ->where('resumes.IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('resume_allows.ResumeAllowId', $ResumeAllowId)
            ->first();

        $filePath    = 'pdf/' . $resume->ResumeName;
        $url         = Storage::disk('s3')->url($filePath);
        $url_segment = \Request::segment(2);
        if ($url_segment == 'resumedetailsubmit') {
            return view('admin.resumedetailssubmit.details')->with([
                'Resume'       => $url,
                'ResumeId'     => $resume->ResumeAllowId,
                'UserId'       => $UserId,
                'ResumeStatus' => $resume->ResumeStatus,
                'ResumeDetail' => $ResumeDetail,
                'UserData'     => $UserData,
            ]);
        } else {
            return view('admin.resumedetails.details')->with([
                'Resume'       => $url,
                'ResumeId'     => $resume->ResumeAllowId,
                'UserId'       => $UserId,
                'ResumeStatus' => $resume->ResumeStatus,
                'ResumeDetail' => $ResumeDetail,
                'UserData'     => $UserData,
            ]);
        }
    }

    public function ReviewResumeDetails(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $ResumeAllowId = $request->ResumeId;
        $ResumeDetail  = $request->ResumeDetail;
        $UserId        = $request->UserId;

        $ResumeDetailsUpdate = Resume_detail::where('ResumeDetailId', $ResumeDetail)
            ->update([
                'ResumeAllowId'                  => $request->ResumeId,
                'FirstName'                      => $request->FirstName,
                'FirstNameStatus'                => $request->FirstNameStatus,
                'MiddleName'                     => $request->MiddleName,
                'MiddleNameStatus'               => $request->MiddleNameStatus,
                'LastName'                       => $request->LastName,
                'LastNameStatus'                 => $request->LastNameStatus,
                'DateOfBirth'                    => $request->DateOfBirth,
                'DateOfBirthStatus'              => $request->DateOfBirthStatus,
                'Gender'                         => $request->Gender,
                'GenderStatus'                   => $request->GenderStatus,
                'Nationality'                    => $request->Nationality,
                'NationalityStatus'              => $request->NationalityStatus,
                'Marital'                        => $request->Marital,
                'MaritalStatus'                  => $request->MaritalStatus,
                'Passport'                       => $request->Passport,
                'PassportStatus'                 => $request->PassportStatus,
                'Hobbies'                        => $request->Hobbies,
                'HobbiesStatus'                  => $request->HobbiesStatus,
                'languageKnown'                  => $request->languageKnown,
                'languageKnownStatus'            => $request->languageKnownStatus,
                'Address'                        => $request->Address,
                'AddressStatus'                  => $request->AddressStatus,
                'LandMark'                       => $request->LandMark,
                'LandMarkStatus'                 => $request->LandMarkStatus,
                'City'                           => $request->City,
                'CityStatus'                     => $request->CityStatus,
                'State'                          => $request->State,
                'StateStatus'                    => $request->StateStatus,
                'Pincode'                        => $request->Pincode,
                'PincodeStatus'                  => $request->PincodeStatus,
                'Mobile'                         => $request->Mobile,
                'MobileStatus'                   => $request->MobileStatus,
                'EmailId'                        => $request->EmailId,
                'EmailIdStatus'                  => $request->EmailIdStatus,
                'SSCResult'                      => $request->SSCResult,
                'SSCResultStatus'                => $request->SSCResultStatus,
                'SSCPassingYear'                 => $request->SSCPassingYear,
                'SSCPassingYearStatus'           => $request->SSCPassingYearStatus,
                'SSCBoardUniversity'             => $request->SSCBoardUniversity,
                'SSCBoardUniversityStatus'       => $request->SSCBoardUniversityStatus,
                'HSCResult'                      => $request->HSCResult,
                'HSCResultStatus'                => $request->HSCResultStatus,
                'HSCBoardUniversity'             => $request->HSCBoardUniversity,
                'HSCBoardUniversityStatus'       => $request->HSCBoardUniversityStatus,
                'HSCPassingYear'                 => $request->HSCPassingYear,
                'HSCPassingYearStatus'           => $request->HSCPassingYearStatus,
                'DiplomaDegree'                  => $request->DiplomaDegree,
                'DiplomaDegreeStatus'            => $request->DiplomaDegreeStatus,
                'DiplomaResult'                  => $request->DiplomaResult,
                'DiplomaResultStatus'            => $request->DiplomaResultStatus,
                'DiplomaUniversity'              => $request->DiplomaUniversity,
                'DiplomaUniversityStatus'        => $request->DiplomaUniversityStatus,
                'DiplomaYear'                    => $request->DiplomaYear,
                'DiplomaYearStatus'              => $request->DiplomaYearStatus,
                'GraduationResult'               => $request->GraduationResult,
                'GraduationResultStatus'         => $request->GraduationResultStatus,
                'GraduationUniversity'           => $request->GraduationUniversity,
                'GraduationUniversityStatus'     => $request->GraduationUniversityStatus,
                'GraduationYear'                 => $request->GraduationYear,
                'GraduationYearStatus'           => $request->GraduationYearStatus,
                'GraduationDegree'               => $request->GraduationDegree,
                'GraduationDegreeStatus'         => $request->GraduationDegreeStatus,
                'PostGraduationDegree'           => $request->PostGraduationDegree,
                'PostGraduationDegreeStatus'     => $request->PostGraduationDegreeStatus,
                'PostGraduationResult'           => $request->PostGraduationResult,
                'PostGraduationResultStatus'     => $request->PostGraduationResultStatus,
                'PostGraduationUniversity'       => $request->PostGraduationUniversity,
                'PostGraduationUniversityStatus' => $request->PostGraduationUniversityStatus,
                'PostGraduationYear'             => $request->PostGraduationYear,
                'PostGraduationYearStatus'       => $request->PostGraduationYearStatus,
                'HighestLevelEducation'          => $request->HighestLevelEducation,
                'HighestLevelEducationStatus'    => $request->HighestLevelEducationStatus,
                'TotalWorkExpesienceYear'        => $request->TotalWorkExpesienceYear,
                'TotalWorkExpesienceYearStatus'  => $request->TotalWorkExpesienceYearStatus,
                'TotalWorkExpesienceMonth'       => $request->TotalWorkExpesienceMonth,
                'TotalWorkExpesienceMonthStatus' => $request->TotalWorkExpesienceMonthStatus,
                'TotalCompaniesWorked'           => $request->TotalCompaniesWorked,
                'TotalCompaniesWorkedStatus'     => $request->TotalCompaniesWorkedStatus,
                'LastCurrentEmployer'            => $request->LastCurrentEmployer,
                'LastCurrentEmployerStatus'      => $request->LastCurrentEmployerStatus,

            ]);

        $data = [
            'FirstNameStatus',
            'MiddleNameStatus',
            'LastNameStatus',
            'DateOfBirthStatus',
            'GenderStatus',
            'NationalityStatus',
            'MaritalStatus',
            'PassportStatus',
            'HobbiesStatus',
            'languageKnownStatus',
            'AddressStatus',
            'LandMarkStatus',
            'CityStatus',
            'StateStatus',
            'PincodeStatus',
            'MobileStatus',
            'EmailIdStatus',
            'SSCResultStatus',
            'SSCPassingYearStatus',
            'SSCBoardUniversityStatus',
            'HSCResultStatus',
            'HSCBoardUniversityStatus',
            'HSCPassingYearStatus',
            'DiplomaDegreeStatus',
            'DiplomaResultStatus',
            'DiplomaUniversityStatus',
            'DiplomaYearStatus',
            'GraduationResultStatus',
            'GraduationUniversityStatus',
            'GraduationYearStatus',
            'GraduationDegreeStatus',
            'PostGraduationDegreeStatus',
            'PostGraduationResultStatus',
            'PostGraduationUniversityStatus',
            'PostGraduationYearStatus',
            'HighestLevelEducationStatus',
            'TotalWorkExpesienceYearStatus',
            'TotalWorkExpesienceMonthStatus',
            'TotalCompaniesWorkedStatus',
            'LastCurrentEmployerStatus',
        ];
        $Status = Resume_detail::select($data)
            ->where('ResumeDetailId', $ResumeDetail)
            ->first()->toArray();

        if (in_array('1', $Status)) {
            $Fail = Resume_allow::where('ResumeAllowId', $ResumeAllowId)
                ->update([
                    'ResumeStatus' => 0,
                ]);
        } else {
            $Pass = Resume_allow::where('ResumeAllowId', $ResumeAllowId)
                ->update([
                    'ResumeStatus' => 1,
                ]);
        }

        // Queue job
        UpdateUserResumeDataStatus::dispatch($ResumeAllowId, Config('constants.queueItem.created'));

        $arrResumeIds = decrypt(Session::get('arrResumeIds'));
        $count        = count($arrResumeIds);

        $ResumeIdKey = array_search($ResumeAllowId, $arrResumeIds) + 1;

        if ($ResumeIdKey == $count) {
            $ResumeNextId = $arrResumeIds[0];
        } else {
            $ResumeNextId = $arrResumeIds[$ResumeIdKey];
        }

        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgUpdateResumeDetails']);
        return redirect('admin/resumedetails/resume-details/' . $UserId . '/' . $ResumeNextId);
    }

    public function pass(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        // date_default_timezone_set('Asia/Kolkata');
        // $CurrentDay = date("Y-m-d");

        // $user = User::with('Caller')->whereHas('Caller', function ($qc) {
        //     $qc->with('Franchisee')->whereHas('Franchisee', function ($qf) {
        //         $qf->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        //     });
        //     $qc->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        // })->withCount('Resume_allow')->whereHas('Resume_allow', function ($qra) {
        //     $qra->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        //     $qra->where('ResumeStatus', '=', Constant::resumeStatus['Fail']);
        // })->withCount('Resume_allow_total')->whereHas('Resume_allow_total', function ($qrat) {
        //     $qrat->where('IsRemoved', Constant::isRemoved['NotRemoved']);
        // })
        //     ->having('Resume_allow_count', '<=', DB::raw('round(Resume_allow_total_count)*12/100'))
        //     ->whereDate('UserEndDate', '<', $CurrentDay)
        //     ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
        //     ->get();

        // return $user;
        $startDateRange = '';
        $endDateRange   = '';
        if ($request->startDateRange || $request->endDateRange) {
            $startDateRange = $request->startDateRange;
            $endDateRange   = $request->endDateRange;
        }

        // return view('admin.pass.pass');
        return view('admin.pass.pass')->with([
            'startDateRange' => $startDateRange,
            'endDateRange'   => $endDateRange,

        ]);
    }
    public function PassDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        date_default_timezone_set('Asia/Kolkata');
        $CurrentDay = date("Y-m-d");

        if ($request->startDateRange || $request->endDateRange) {
            $startDateRange = explode('-', $request->startDateRange);
            $endDateRange   = explode('-', $request->endDateRange);

            $startfrom = Carbon::parse($startDateRange[0])->startOfDay()->toDateTimeString();
            $startto   = Carbon::parse($startDateRange[1])->endOfDay()->toDateTimeString();

            $endfrom = Carbon::parse($endDateRange[0])->startOfDay()->toDateTimeString();
            $endtto  = Carbon::parse($endDateRange[1])->endOfDay()->toDateTimeString();

            $user = User::where(function ($query) use ($startfrom, $startto, $endfrom, $endtto) {
                $query->whereBetween('UserStartDate', [$startfrom, $startto]);
                $query->orWhereBetween('UserEndDate', [$endfrom, $endtto]);
            })

                ->with('Caller')->whereHas('Caller', function ($qc) {
                $qc->with('Franchisee')->whereHas('Franchisee', function ($qf) {
                    $qf->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                });
                $qc->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            })
                ->whereDate('UserEndDate', '<', $CurrentDay)
                ->where('ResumeSubmitStatus', Constant::UserResumeStatus['Pass'])
                ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
                ->get();
        } else {
            $user = User::with('Caller')->whereHas('Caller', function ($qc) {
                $qc->with('Franchisee')->whereHas('Franchisee', function ($qf) {
                    $qf->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                });
                $qc->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            })
                ->whereDate('UserEndDate', '<', $CurrentDay)
                ->where('ResumeSubmitStatus', Constant::UserResumeStatus['Pass'])
                ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
                ->get();
        }

        $arrData = [];
        foreach ($user as $usr) {

            $startDate = Common::dateformat($usr->UserStartDate);
            $endDate   = Common::dateformat($usr->UserEndDate);
            $varData   = [
                'UserName'           => $usr->UserName,
                'UserRegistrationId' => $usr->UserRegistrationId,
                'UserEmail'          => $usr->UserEmail,
                'UserMoblieNumber'   => $usr->UserMoblieNumber,
                'UserStartDate'      => $startDate,
                'UserEndDate'        => $endDate,
                'FranchiseeName'     => $usr->Caller->Franchisee->FranchiseeName,
                'CallerName'         => $usr->Caller->CallerName,
            ];

            array_push($arrData, $varData);
            // }
        }

        return Datatables::of($arrData)->addIndexColumn()->make(true);
    }
    public function fail(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        $startDateRange = '';
        $endDateRange   = '';
        if ($request->startDateRange || $request->endDateRange) {
            $startDateRange = $request->startDateRange;
            $endDateRange   = $request->endDateRange;
        }

        return view('admin.fail.fail')->with([
            'startDateRange' => $startDateRange,
            'endDateRange'   => $endDateRange,

        ]);
    }
    public function FailDataTable(Request $request) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

        date_default_timezone_set('Asia/Kolkata');
        $CurrentDay = date("Y-m-d");

        if ($request->startDateRange || $request->endDateRange) {
            $startDateRange = explode('-', $request->startDateRange);
            $endDateRange   = explode('-', $request->endDateRange);

            $startfrom = Carbon::parse($startDateRange[0])->startOfDay()->toDateTimeString();
            $startto   = Carbon::parse($startDateRange[1])->endOfDay()->toDateTimeString();

            $endfrom = Carbon::parse($endDateRange[0])->startOfDay()->toDateTimeString();
            $endtto  = Carbon::parse($endDateRange[1])->endOfDay()->toDateTimeString();

            $user = User::where(function ($query) use ($startfrom, $startto, $endfrom, $endtto) {
                $query->whereBetween('UserStartDate', [$startfrom, $startto]);
                $query->orWhereBetween('UserEndDate', [$endfrom, $endtto]);
            })
                ->with('Caller')->whereHas('Caller', function ($qc) {
                $qc->with('Franchisee')->whereHas('Franchisee', function ($qf) {
                    $qf->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                });
                $qc->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            })
                ->where('ResumeSubmitStatus', Constant::UserResumeStatus['Fail'])
                ->whereDate('UserEndDate', '<', $CurrentDay)
                ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
                ->get();
        } else {

            $user = User::with('Caller')->whereHas('Caller', function ($qc) {
                $qc->with('Franchisee')->whereHas('Franchisee', function ($qf) {
                    $qf->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                });
                $qc->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            })
                ->where('ResumeSubmitStatus', Constant::UserResumeStatus['Fail'])
                ->whereDate('UserEndDate', '<', $CurrentDay)
                ->where('IsRemoved', Constant::isRemoved['NotRemoved'])
                ->get();
        }

        $arrData = [];
        foreach ($user as $usr) {
            // $resume_allow = Resume_allow::where('ResumeAllowUserId', $usr->UserId)
            //     ->where('ResumeStatus', Constant::resumeStatus['Fail'])
            //     ->count();

            // $statuspass = $this->common->pass($resume_allow, $usr->count);

            // if ($statuspass == false) {
            //     $userData = User::with([
            //         'Caller' => function ($q) {
            //             $q->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            //             $q->with([
            //                 'Franchisee' => function ($query) {
            //                     $query->where('IsRemoved', Constant::isRemoved['NotRemoved']);
            //                 },
            //             ]);
            //         },
            //     ])
            //         ->where('UserId', $usr->UserId)
            //         ->first();
            $startDate = Common::dateformat($usr->UserStartDate);
            $endDate   = Common::dateformat($usr->UserEndDate);
            $varData   = [
                'UserId'             => $usr->UserId,
                'UserName'           => $usr->UserName,
                'UserRegistrationId' => $usr->UserRegistrationId,
                'UserEmail'          => $usr->UserEmail,
                'UserMoblieNumber'   => $usr->UserMoblieNumber,
                'UserStartDate'      => $startDate,
                'UserEndDate'        => $endDate,
                'FranchiseeName'     => $usr->Caller->Franchisee->FranchiseeName,
                'CallerName'         => $usr->Caller->CallerName,
            ];

            array_push($arrData, $varData);
            // }
        }

        return Datatables::of($arrData)->addIndexColumn()->addColumn('move', function ($row) {
            $urlmove = url('admin/resumedetailsubmit/move') . '/' . $row['UserId'];
            $btn     = '<center>
                        <a href="' . $urlmove . '" class="btn btn-success btn-sm">
                        Move to submit
                        </a>
                    </center>';

            return $btn;
        })
            ->rawColumns(['move'])
            ->make(true);
    }
    public function MoveToSubmit($UserId) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        User::where('UserId', $UserId)
            ->update([
                'ResumeSubmitStatus' => Constant::UserResumeStatus['Submit'],
            ]);
        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgMoveToSubmit']);
        return redirect()->back();
    }
    public function FailAllResume($UserId) {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }
        User::where('UserId', $UserId)
            ->update([
                'ResumeSubmitStatus' => Constant::UserResumeStatus['Fail'],
            ]);
        Session::flash('SuccessMessage', Constant::adminSessionMessage['msgMoveToFail']);
        return redirect('admin/fail');
    }
}
