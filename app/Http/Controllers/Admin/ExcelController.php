<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Constant;
use App\Models\Franchisee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Session;

class ExcelController extends Controller
{
    protected $common;

    public function __construct(Request $request)
    {
        $this->common = new Common;
    }
    public function Excel(Request $request)
    {
        if (!Session::has('AdminId')) {
            return redirect('admin');
        }

     
        return view('admin.excel.excel');
    }
    public function Download(Request $request)
    {
        $UserRegistrationId = explode("\n", str_replace("\r", "", $request->UserRegistrationId));
        $ExcelDataArray = [];
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
        foreach($UserRegistrationId as $User)
        {
            $ExcelData = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('UserRegistrationId', $User)
            ->with(['excel' => function ($query) {
                $query->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                $query->with(['excelData' => function ($q) {
                    $q->where('IsRemoved', Constant::isRemoved['NotRemoved']);
                }]);
            }])
            ->first();
           
            if($ExcelData)
            {
                if($ExcelData->excel)
                {
                    
                    foreach($ExcelData->excel as $ed)
                    {
                        
                        if($ed->excelData)
                        {
                            $varItem = [
                            'UserRegistrationId' => $ExcelData->UserRegistrationId,
                            'FirstName'                      => $ed->excelData->FirstName,
                            'FirstNameStatus'                => $ed->excelData->FirstNameStatus,
                            'MiddleName'                     => $ed->excelData->MiddleName,
                            'MiddleNameStatus'               => $ed->excelData->MiddleNameStatus,
                            'LastName'                       => $ed->excelData->LastName,
                            'LastNameStatus'                 => $ed->excelData->LastNameStatus,
                            'DateOfBirth'                    => $ed->excelData->DateOfBirth,
                            'DateOfBirthStatus'              => $ed->excelData->DateOfBirthStatus,
                            'Gender'                         => $ed->excelData->Gender,
                            'GenderStatus'                   => $ed->excelData->GenderStatus,
                            'Nationality'                    => $ed->excelData->Nationality,
                            'NationalityStatus'              => $ed->excelData->NationalityStatus,
                            'Marital'                        => $ed->excelData->Marital,
                            'MaritalStatus'                  => $ed->excelData->MaritalStatus,
                            'Passport'                       => $ed->excelData->Passport,
                            'PassportStatus'                 => $ed->excelData->PassportStatus,
                            'Hobbies'                        => $ed->excelData->Hobbies,
                            'HobbiesStatus'                  => $ed->excelData->HobbiesStatus,
                            'languageKnown'                  => $ed->excelData->languageKnown,
                            'languageKnownStatus'            => $ed->excelData->languageKnownStatus,
                            'Address'                        => $ed->excelData->Address,
                            'AddressStatus'                  => $ed->excelData->AddressStatus,
                            'LandMark'                       => $ed->excelData->LandMark,
                            'LandMarkStatus'                 => $ed->excelData->LandMarkStatus,
                            'City'                           => $ed->excelData->City,
                            'CityStatus'                     => $ed->excelData->CityStatus,
                            'State'                          => $ed->excelData->State,
                            'StateStatus'                    => $ed->excelData->StateStatus,
                            'Pincode'                        => $ed->excelData->Pincode,
                            'PincodeStatus'                  => $ed->excelData->PincodeStatus,
                            'Mobile'                         => $ed->excelData->Mobile,
                            'MobileStatus'                   => $ed->excelData->MobileStatus,
                            'EmailId'                        => $ed->excelData->EmailId,
                            'EmailIdStatus'                  => $ed->excelData->EmailIdStatus,
                            'SSCResult'                      => $ed->excelData->SSCResult,
                            'SSCResultStatus'                => $ed->excelData->SSCResultStatus,
                            'SSCPassingYear'                 => $ed->excelData->SSCPassingYear,
                            'SSCPassingYearStatus'           => $ed->excelData->SSCPassingYearStatus,
                            'SSCBoardUniversity'             => $ed->excelData->SSCBoardUniversity,
                            'SSCBoardUniversityStatus'       => $ed->excelData->SSCBoardUniversityStatus,
                            'HSCResult'                      => $ed->excelData->HSCResult,
                            'HSCResultStatus'                => $ed->excelData->HSCResultStatus,
                            'HSCBoardUniversity'             => $ed->excelData->HSCBoardUniversity,
                            'HSCBoardUniversityStatus'       => $ed->excelData->HSCBoardUniversityStatus,
                            'HSCPassingYear'                 => $ed->excelData->HSCPassingYear,
                            'HSCPassingYearStatus'           => $ed->excelData->HSCPassingYearStatus,
                            'DiplomaDegree'                  => $ed->excelData->DiplomaDegree,
                            'DiplomaDegreeStatus'            => $ed->excelData->DiplomaDegreeStatus,
                            'DiplomaResult'                  => $ed->excelData->DiplomaResult,
                            'DiplomaResultStatus'            => $ed->excelData->DiplomaResultStatus,
                            'DiplomaUniversity'              => $ed->excelData->DiplomaUniversity,
                            'DiplomaUniversityStatus'        => $ed->excelData->DiplomaUniversityStatus,
                            'DiplomaYear'                    => $ed->excelData->DiplomaYear,
                            'DiplomaYearStatus'              => $ed->excelData->DiplomaYearStatus,
                            'GraduationResult'               => $ed->excelData->GraduationResult,
                            'GraduationResultStatus'         => $ed->excelData->GraduationResultStatus,
                            'GraduationUniversity'           => $ed->excelData->GraduationUniversity,
                            'GraduationUniversityStatus'     => $ed->excelData->GraduationUniversityStatus,
                            'GraduationYear'                 => $ed->excelData->GraduationYear,
                            'GraduationYearStatus'           => $ed->excelData->GraduationYearStatus,
                            'GraduationDegree'               => $ed->excelData->GraduationDegree,
                            'GraduationDegreeStatus'         => $ed->excelData->GraduationDegreeStatus,
                            'PostGraduationDegree'           => $ed->excelData->PostGraduationDegree,
                            'PostGraduationDegreeStatus'     => $ed->excelData->PostGraduationDegreeStatus,
                            'PostGraduationResult'           => $ed->excelData->PostGraduationResult,
                            'PostGraduationResultStatus'     => $ed->excelData->PostGraduationResultStatus,
                            'PostGraduationUniversity'       => $ed->excelData->PostGraduationUniversity,
                            'PostGraduationUniversityStatus' => $ed->excelData->PostGraduationUniversityStatus,
                            'PostGraduationYear'             => $ed->excelData->PostGraduationYear,
                            'PostGraduationYearStatus'       => $ed->excelData->PostGraduationYearStatus,
                            'HighestLevelEducation'          => $ed->excelData->HighestLevelEducation,
                            'HighestLevelEducationStatus'    => $ed->excelData->HighestLevelEducationStatus,
                            'TotalWorkExpesienceYear'        => $ed->excelData->TotalWorkExpesienceYear,
                            'TotalWorkExpesienceYearStatus'  => $ed->excelData->TotalWorkExpesienceYearStatus,
                            'TotalWorkExpesienceMonth'       => $ed->excelData->TotalWorkExpesienceMonth,
                            'TotalWorkExpesienceMonthStatus' => $ed->excelData->TotalWorkExpesienceMonthStatus,
                            'TotalCompaniesWorked'           => $ed->excelData->TotalCompaniesWorked,
                            'TotalCompaniesWorkedStatus'     => $ed->excelData->TotalCompaniesWorkedStatus,
                            'LastCurrentEmployer'            => $ed->excelData->LastCurrentEmployer,
                            'LastCurrentEmployerStatus'      => $ed->excelData->LastCurrentEmployerStatus,
                
                            ];
                            
                                foreach ($varItem as $keya => $valuea) {
                                    if (in_array($keya, $data)) {
                                        if($varItem[$keya] = 1)
                                        {
                                            $varItem[$keya] = 'Not Approve';
                                        }
                                        else if($varItem[$keya] = 2)
                                        {
                                            $varItem[$keya] = 'Approve';
                                        }
                                        else
                                        {
                                            $varItem[$keya] = 'Not Review';
                                        }
                                        
                                    }
                            }
                            array_push($ExcelDataArray, $varItem);
                        }
                    }
                }
            }
        }
        return view('admin.excel.excelData')->with([
            'ExcelData' => $ExcelDataArray,
        ]);
    //   dd($ExcelDataArray);
     
    }
  

}
