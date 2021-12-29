@extends('admin.template.master')

@section('header-css')
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Excel Download</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Excel Download</strong>
            </li>
        </ol>
    </div>
</div>
<!-- End Breadcromb Row -->

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Excel Download</h5>

                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content sk-loading">
                    <div class="sk-spinner sk-spinner-double-bounce">
                        <div class="sk-double-bounce1"></div>
                        <div class="sk-double-bounce2"></div>
                    </div>

                    <form role="form" id="addHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/excel-download/download') }}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>User Registration Id:</label>
                                    <textarea name="UserRegistrationId" id="UserRegistrationId" placeholder="Please Enter User Registration Id" class="form-control"></textarea>
                                    
                                </div>
                                <button type="submit" id="submitBtn" class="btn btn-sm btn-primary m-t-n-xs">
                                    <strong>Submit</strong>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<table class="table2excel" id="table2excel" style="display: none;">
<thead>
<tr>
<th>UserRegistrationId</th>
<th>FirstName</th>
<th>FirstNameStatus</th>
<th>MiddleName</th>
<th>MiddleNameStatus</th>
<th>LastName</th>
<th>LastNameStatus</th>
<th>DateOfBirth</th>
<th>DateOfBirthStatus</th>
<th>Gender</th>
<th>GenderStatus</th>
<th>Nationality</th>
<th>NationalityStatus</th>
<th>Marital</th>
<th>MaritalStatus</th>
<th>Passport</th>
<th>PassportStatus</th>
<th>Hobbies</th>
<th>HobbiesStatus</th>
<th>languageKnown</th>
<th>languageKnownStatus</th>
<th>Address</th>
<th>AddressStatus</th>
<th>LandMark</th>
<th>LandMarkStatus</th>
<th>City</th>
<th>CityStatus</th>
<th>State</th>
<th>StateStatus</th>
<th>Pincode</th>
<th>PincodeStatus</th>
<th>Mobile</th>
<th>MobileStatus</th>
<th>EmailId</th>
<th>EmailIdStatus</th>
<th>SSCResult</th>
<th>SSCResultStatus</th>
<th>SSCPassingYear</th>
<th>SSCPassingYearStatus</th>
<th>SSCBoardUniversity</th>
<th>SSCBoardUniversityStatus</th>
<th>HSCResult</th>
<th>HSCResultStatus</th>
<th>HSCBoardUniversity</th>
<th>HSCBoardUniversityStatus</th>
<th>HSCPassingYear</th>
<th>HSCPassingYearStatus</th>
<th>DiplomaDegree</th>
<th>DiplomaDegreeStatus</th>
<th>DiplomaResult</th>
<th>DiplomaResultStatus</th>
<th>DiplomaUniversity</th>
<th>DiplomaUniversityStatus</th>
<th>DiplomaYear</th>
<th>DiplomaYearStatus</th>
<th>GraduationResult</th>
<th>GraduationResultStatus</th>
<th>GraduationUniversity</th>
<th>GraduationUniversityStatus</th>
<th>GraduationYear</th>
<th>GraduationYearStatus</th>
<th>GraduationDegree</th>
<th>GraduationDegreeStatus</th>
<th>PostGraduationDegree</th>
<th>PostGraduationDegreeStatus</th>
<th>PostGraduationResult</th>
<th>PostGraduationResultStatus</th>
<th>PostGraduationUniversity</th>
<th>PostGraduationUniversityStatus</th>
<th>PostGraduationYear</th>
<th>PostGraduationYearStatus</th>
<th>HighestLevelEducation</th>
<th>HighestLevelEducationStatus</th>
<th>TotalWorkExpesienceYear</th>
<th>TotalWorkExpesienceYearStatus</th>
<th>TotalWorkExpesienceMonth</th>
<th>TotalWorkExpesienceMonthStatus</th>
<th>TotalCompaniesWorked</th>
<th>TotalCompaniesWorkedStatus</th>
<th>LastCurrentEmployer</th>
<th>LastCurrentEmployerStatus</th>
</tr>
</thead>
<tbody>
@foreach($ExcelData as $data)
<tr>
<td>{{ $data['UserRegistrationId'] }}</td>
<td>{{ $data['FirstName'] }}</td>
<td>{{ $data['FirstNameStatus'] }}</td>
<td>{{ $data['MiddleName'] }}</td>
<td>{{ $data['MiddleNameStatus'] }}</td>
<td>{{ $data['LastName'] }}</td>
<td>{{ $data['LastNameStatus'] }}</td>
<td>{{ $data['DateOfBirth'] }}</td>
<td>{{ $data['DateOfBirthStatus'] }}</td>
@if($data['Gender'] == 1)
<td>Male</td>
@elseif($data['Gender'] == 2)
<td>Female</td>
@else
<td>NA</td>
@endif
<td>{{ $data['GenderStatus'] }}</td>
<td>{{ $data['Nationality'] }}</td>
<td>{{ $data['NationalityStatus'] }}</td>
@if($data['Marital'] == 1)
<td>Single</td>
@elseif($data['Marital'] == 2)
<td>Married</td>
@else
<td>NA</td>
@endif
<td>{{ $data['MaritalStatus'] }}</td>
<td>{{ $data['Passport'] }}</td>
<td>{{ $data['PassportStatus'] }}</td>
<td>{{ $data['Hobbies'] }}</td>
<td>{{ $data['HobbiesStatus'] }}</td>
<td>{{ $data['languageKnown'] }}</td>
<td>{{ $data['languageKnownStatus'] }}</td>
<td>{{ $data['Address'] }}</td>
<td>{{ $data['AddressStatus'] }}</td>
<td>{{ $data['LandMark'] }}</td>
<td>{{ $data['LandMarkStatus'] }}</td>
<td>{{ $data['City'] }}</td>
<td>{{ $data['CityStatus'] }}</td>
<td>{{ $data['State'] }}</td>
<td>{{ $data['StateStatus'] }}</td>
<td>{{ $data['Pincode'] }}</td>
<td>{{ $data['PincodeStatus'] }}</td>
<td>{{ $data['Mobile'] }}</td>
<td>{{ $data['MobileStatus'] }}</td>
<td>{{ $data['EmailId'] }}</td>
<td>{{ $data['EmailIdStatus'] }}</td>
<td>{{ $data['SSCResult'] }}</td>
<td>{{ $data['SSCResultStatus'] }}</td>
<td>{{ $data['SSCPassingYear'] }}</td>
<td>{{ $data['SSCPassingYearStatus'] }}</td>
<td>{{ $data['SSCBoardUniversity'] }}</td>
<td>{{ $data['SSCBoardUniversityStatus'] }}</td>
<td>{{ $data['HSCResult'] }}</td>
<td>{{ $data['HSCResultStatus'] }}</td>
<td>{{ $data['HSCBoardUniversity'] }}</td>
<td>{{ $data['HSCBoardUniversityStatus'] }}</td>
<td>{{ $data['HSCPassingYear'] }}</td>
<td>{{ $data['HSCPassingYearStatus'] }}</td>
<td>{{ $data['DiplomaDegree'] }}</td>
<td>{{ $data['DiplomaDegreeStatus'] }}</td>
<td>{{ $data['DiplomaResult'] }}</td>
<td>{{ $data['DiplomaResultStatus'] }}</td>
<td>{{ $data['DiplomaUniversity'] }}</td>
<td>{{ $data['DiplomaUniversityStatus'] }}</td>
<td>{{ $data['DiplomaYear'] }}</td>
<td>{{ $data['DiplomaYearStatus'] }}</td>
<td>{{ $data['GraduationResult'] }}</td>
<td>{{ $data['GraduationResultStatus'] }}</td>
<td>{{ $data['GraduationUniversity'] }}</td>
<td>{{ $data['GraduationUniversityStatus'] }}</td>
<td>{{ $data['GraduationYear'] }}</td>
<td>{{ $data['GraduationYearStatus'] }}</td>
<td>{{ $data['GraduationDegree'] }}</td>
<td>{{ $data['GraduationDegreeStatus'] }}</td>
<td>{{ $data['PostGraduationDegree'] }}</td>
<td>{{ $data['PostGraduationDegreeStatus'] }}</td>
<td>{{ $data['PostGraduationResult'] }}</td>
<td>{{ $data['PostGraduationResultStatus'] }}</td>
<td>{{ $data['PostGraduationUniversity'] }}</td>
<td>{{ $data['PostGraduationUniversityStatus'] }}</td>
<td>{{ $data['PostGraduationYear'] }}</td>
<td>{{ $data['PostGraduationYearStatus'] }}</td>
<td>{{ $data['HighestLevelEducation'] }}</td>
<td>{{ $data['HighestLevelEducationStatus'] }}</td>
<td>{{ $data['TotalWorkExpesienceYear'] }}</td>
<td>{{ $data['TotalWorkExpesienceYearStatus'] }}</td>
<td>{{ $data['TotalWorkExpesienceMonth'] }}</td>
<td>{{ $data['TotalWorkExpesienceMonthStatus'] }}</td>
<td>{{ $data['TotalCompaniesWorked'] }}</td>
<td>{{ $data['TotalCompaniesWorkedStatus'] }}</td>
<td>{{ $data['LastCurrentEmployer'] }}</td>
<td>{{ $data['LastCurrentEmployerStatus'] }}</td>
</tr>
@endforeach
</tbody>
</table>
@endsection

@section('footer')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="{{ url('/public/js/jquery.table2excel.js') }}"></script>
<script>
$(document).ready(function(){
$("#table2excel").table2excel({
    // exclude CSS class
    exclude:".noExl",
    name:"Worksheet Name",
    filename:"resumetofill",//do not include extension
    fileext:".xls" // file extension
  });
  var url      = window.location.href; 
  window.location.href = '../../admin/excel-download';
});
</script>
@endsection