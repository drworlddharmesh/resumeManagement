<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume_detail extends Model {
    protected $table      = 'resume_detail';
    protected $primaryKey = 'ResumeDetailId';

    protected $fillable = [ 
        'ResumeDetailId',
        'ResumeAllowId',
        'ResumeSubmitDate',
        'FirstName',
        'FirstNameStatus',
        'MiddleName',
        'MiddleNameStatus',
        'LastName',
        'LastNameStatus',
        'DateOfBirth',
        'DateOfBirthStatus',
        'Gender',
        'GenderStatus',
        'Nationality',
        'NationalityStatus',
        'Marital',
        'MaritalStatus',
        'Passport',
        'PassportStatus',
        'Hobbies',
        'HobbiesStatus',
        'languageKnown',
        'languageKnownStatus',
        'Address',
        'AddressStatus',
        'LandMark',
        'LandMarkStatus',
        'City',
        'CityStatus',
        'State',
        'StateStatus',
        'Pincode',
        'PincodeStatus',
        'Mobile',
        'MobileStatus',
        'EmailId',
        'EmailIdStatus',
        'SSCResult',
        'SSCResultStatus',
        'SSCPassingYear',
        'SSCPassingYearStatus',
        'SSCBoardUniversity',
        'SSCBoardUniversityStatus',
        'HSCResult',
        'HSCResultStatus',
        'HSCBoardUniversity',
        'HSCBoardUniversityStatus',
        'HSCPassingYear',
        'HSCPassingYearStatus',
        'DiplomaDegree',
        'DiplomaDegreeStatus',
        'DiplomaResult',
        'DiplomaResultStatus',
        'DiplomaUniversity',
        'DiplomaUniversityStatus',
        'DiplomaYear',
        'DiplomaYearStatus',
        'GraduationResult',
        'GraduationResultStatus',
        'GraduationUniversity',
        'GraduationUniversityStaus',
        'GraduationYear',
        'GraduationYearStatus',
        'GraduationDegree',
        'GraduationDegreeStatus',
        'PostGraduationDegree',
        'PostGraduationDegreeStatus',
        'PostGraduationResult',
        'PostGraduationResultStatus',
        'PostGraduationUniversity',
        'PostGraduationUniversityStatus',
        'PostGraduationYear',
        'PostGraduationYearStatus',
        'HighestLevelEducation',
        'HighestLevelEducationStatus',
        'TotalWorkExpesienceYear',
        'TotalWorkExpesienceYearStatus',
        'TotalWorkExpesienceMonth',
        'TotalWorkExpesienceMonthStatus',
        'TotalCompaniesWorked',
        'TotalCompaniesWorkedStatus',
        'LastCurrentEmployer',
        'LastCurrentEmployerStatus',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];
   
}