@extends('admin.template.master')

@section('header-css')
<link href="{{ url('public/inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ url('public/inspinia/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Resume Details Review</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/resumedetails') }}">Resume Details</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/resumedetails').'/'.$UserId }}">Resume Details View</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Resume Details Review</strong>
            </li>
        </ol>
    </div>
</div>
<!-- End Breadcromb Row -->

<?php
$arrResumeIds = decrypt(Session::get('arrResumeIds'));
?>

<div class="wrapper wrapper-content animated fadeInRight" style="padding-bottom: 0px;">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content" style="padding-bottom: unset;">
                    <div class="row">
                        <label class="col-sm-1 col-form-label">Resume</label>

                        <div class="col-sm-2">
                            <select class="form-control m-b" id="resumeselect">
                                @foreach ($arrResumeIds as $key => $value)
                                    <option value="{{ $value }}" {{ $value == Request::segment(5) ? 'selected' : '' }}>{{ $key + 1 }}</option>
                                @endforeach
                            </select>

                        </div>
                        <label class="p-2">{{$UserData->UserName}}</label>

                            <label class="p-2">{{$UserData->UserRegistrationId}}</label>
                            <a href="{{ url('admin/resumedetails/fail-all-resume').'/'.$UserId }}" class="btn btn-danger btn-lg mb-3">Fail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Resume Details</h5>

                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <div class="sk-spinner sk-spinner-double-bounce">
                        <div class="sk-double-bounce1"></div>
                        <div class="sk-double-bounce2"></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">

                            <embed src="{{ $Resume }}" width="100%" height="600px" />

                        </div>



                        <div class="col-xl-6">

                            <form role="form" id="addHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/resumedetails/review-resume-details') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="NextResumeId" value="">
                                <input type="hidden" name="ResumeId"  value="{{$ResumeId}}" >
                                 <input type="hidden" name="ResumeDetail"  value="{{$ResumeDetail->ResumeDetailId}}" >
                                 <input type="hidden" name="UserId"  value="{{ $UserId }}" >
                                 <div style="overflow-y:scroll; height:550px;">
                                <div class="form-group">
                                    <label>First Name:</label>
                                    <input type="text" name="FirstName" id="FirstName" placeholder="Please Enter First Name" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->FirstName}}" class="form-control" autofocus>

                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="FirstNameStatus" value="1" >

                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="FirstNameStatus" value="2" checked>

                                    </div>
                                </div>



                                <div class="form-group">
                                    <label>Middle Name:</label>
                                    <input type="text" name="MiddleName" id="MiddleName" placeholder="Please Enter Middle Name" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->MiddleName}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="MiddleNameStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="MiddleNameStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Last Name:</label>
                                    <input type="text" name="LastName" id="LastName" placeholder="Please Enter Last Name" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->LastName}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="LastNameStatus" value="1"  >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="LastNameStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Date Of Birth:</label>
                                    <input type="text" name="DateOfBirth" id="DateOfBirth" placeholder="Please Enter Date Of Birth" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->DateOfBirth}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="DateOfBirthStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="DateOfBirthStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Gender:</label><br>
                                    <label class="text-success">Male:</label>
                                    <input type="radio" name="Gender" value="1"  @if($ResumeDetail->Gender == 1) checked @endif>
                                    <label class="text-success">Female:</label>
                                    <input type="radio" name="Gender" value="2" @if($ResumeDetail->Gender == 2) checked  @endif>
                                    <label class="text-success">NA:</label>
                                    <input type="radio" name="Gender" value="3" @if($ResumeDetail->Gender == 3) checked  @endif>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="GenderStatus" value="1"  >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="GenderStatus" value="2"  checked>

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label>Nationality:</label>
                                    <input type="text" name="Nationality" id="Nationality" placeholder="Please Enter Nationality" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->Nationality}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="NationalityStatus" value="1"  >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="NationalityStatus" value="2"  checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Marital:</label><br>
                                    <label class="text-success">Single:</label>

                                    <input type="radio" name="Marital" value="1" @if($ResumeDetail->Marital == 1) checked @endif>


                                    <label class="text-success">Married:</label>

                                    <input type="radio" name="Marital" value="2"  @if($ResumeDetail->Marital == 2) checked @endif>
                                    <label class="text-success">NA:</label>

                                    <input type="radio" name="Marital" value="3"  @if($ResumeDetail->Marital == 3) checked @endif>

                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="MaritalStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="MaritalStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Passport:</label>
                                    <input type="text" name="Passport" id="Passport" placeholder="Please Enter Passport" value="{{$ResumeDetail->Passport}}" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="PassportStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="PassportStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Hobbies:</label>
                                    <input type="text" name="Hobbies" id="Hobbies" placeholder="Please Enter Hobbies" value="{{$ResumeDetail->Hobbies}}" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="HobbiesStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="HobbiesStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Language Known:</label>
                                    <input type="text" name="languageKnown" id="languageKnown" placeholder="Please Enter Language Known" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->languageKnown}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="languageKnownStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="languageKnownStatus" value="2"  checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Address:</label>
                                    <input type="text" name="Address" id="Address" placeholder="Please Enter Address" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->Address}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="AddressStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="AddressStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Landmark:</label>
                                    <input type="text" name="LandMark" id="LandMark" placeholder="Please Enter Landmark" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->LandMark}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="LandMarkStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="LandMarkStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>City:</label>
                                    <input type="text" name="City" id="City" placeholder="Please Enter City" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->City}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="CityStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="CityStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>State:</label>
                                    <input type="text" name="State" id="State" placeholder="Please Enter State" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->State}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="StateStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="StateStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Pincode:</label>
                                    <input type="text" name="Pincode" id="Pincode" placeholder="Please Enter Pincode" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->Pincode}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="PincodeStatus" value="1"  >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="PincodeStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Mobile:</label>
                                    <input type="text" name="Mobile" id="Mobile" placeholder="Please Enter Mobile" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->Mobile}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="MobileStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="MobileStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Email Id:</label>
                                    <input type="text" name="EmailId" id="EmailId" placeholder="Please Enter Email Id" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->EmailId}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="EmailIdStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="EmailIdStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>SSC Result:</label>
                                    <input type="text" name="SSCResult" id="SSCResult" placeholder="Please Enter SSC Result" value="{{$ResumeDetail->SSCResult}}" class="form-control" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="SSCResultStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="SSCResultStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>SSC Passing Year:</label>
                                    <input type="text" name="SSCPassingYear" id="SSCPassingYear" placeholder="Please Enter SSC Passing Year" value="{{$ResumeDetail->SSCPassingYear}}" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="SSCPassingYearStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="SSCPassingYearStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>SSC Board University:</label>
                                    <input type="text" name="SSCBoardUniversity" id="SSCBoardUniversity" placeholder="Please Enter SSC Board University" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->SSCBoardUniversity}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="SSCBoardUniversityStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="SSCBoardUniversityStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>HSC Result:</label>
                                    <input type="text" name="HSCResult" id="HSCResult" placeholder="Please Enter HSC Result" value="{{$ResumeDetail->HSCResult}}" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="HSCResultStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="HSCResultStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>HSC Board University:</label>
                                    <input type="text" name="HSCBoardUniversity" id="HSCBoardUniversity" placeholder="Please Enter HSC Board University" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->HSCBoardUniversity}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="HSCBoardUniversityStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="HSCBoardUniversityStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>HSC Passing Year:</label>
                                    <input type="text" name="HSCPassingYear" id="HSCPassingYear" placeholder="Please Enter HSC Passing Year" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->HSCPassingYear}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="HSCPassingYearStatus" value="1"  >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="HSCPassingYearStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Diploma Degree:</label>
                                    <input type="text" name="DiplomaDegree" id="DiplomaDegree" placeholder="Please Enter Diploma Degree" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->DiplomaDegree}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="DiplomaDegreeStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="DiplomaDegreeStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Diploma Result:</label>
                                    <input type="text" name="DiplomaResult" id="DiplomaResult" placeholder="Please Enter Diploma Result" value="{{$ResumeDetail->DiplomaResult}}" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="DiplomaResultStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="DiplomaResultStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Diploma University:</label>
                                    <input type="text" name="DiplomaUniversity" id="DiplomaUniversity" placeholder="Please Enter Diploma University" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->DiplomaUniversity}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="DiplomaUniversityStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="DiplomaUniversityStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Diploma Year:</label>
                                    <input type="text" name="DiplomaYear" id="DiplomaYear" placeholder="Please Enter Diploma Year" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->DiplomaYear}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="DiplomaYearStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="DiplomaYearStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Graduation Result:</label>
                                    <input type="text" name="GraduationResult" id="GraduationResult" placeholder="Please Enter Graduation Result" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->GraduationResult}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="GraduationResultStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="GraduationResultStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Graduation University:</label>
                                    <input type="text" name="GraduationUniversity" id="GraduationUniversity" placeholder="Please Enter Graduation University" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->GraduationUniversity}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="GraduationUniversityStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="GraduationUniversityStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Graduation Year:</label>
                                    <input type="text" name="GraduationYear" id="GraduationYear" placeholder="Please Enter Graduation Year" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->GraduationYear}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="GraduationYearStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="GraduationYearStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Graduation Degree:</label>
                                    <input type="text" name="GraduationDegree" id="GraduationDegree" placeholder="Please Enter Graduation Degree" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->GraduationDegree}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="GraduationDegreeStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="GraduationDegreeStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Post Graduation Degree:</label>
                                    <input type="text" name="PostGraduationDegree" id="PostGraduationDegree" placeholder="Please Enter Post Graduation Degree" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->PostGraduationDegree}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="PostGraduationDegreeStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="PostGraduationDegreeStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Post Graduation Result:</label>
                                    <input type="text" name="PostGraduationResult" id="PostGraduationResult" placeholder="Please Enter Post Graduation Result" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->PostGraduationResult}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="PostGraduationResultStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="PostGraduationResultStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Post Graduation University:</label>
                                    <input type="text" name="PostGraduationUniversity" id="PostGraduationUniversity" placeholder="Please Enter Post Graduation University" value="{{$ResumeDetail->PostGraduationUniversity}}" class="form-control" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="PostGraduationUniversityStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="PostGraduationUniversityStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Post Graduation Year:</label>
                                    <input type="text" name="PostGraduationYear" id="PostGraduationYear" placeholder="Please Enter Post Graduation Year" value="{{$ResumeDetail->PostGraduationYear}}" class="form-control" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="PostGraduationYearStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="PostGraduationYearStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Highest Level Education:</label>
                                    <input type="text" name="HighestLevelEducation" id="HighestLevelEducation" placeholder="Please Enter Highest Level Education" value="{{$ResumeDetail->HighestLevelEducation}}" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="HighestLevelEducationStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="HighestLevelEducationStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Total Work Experience Year:</label>
                                    <input type="text" name="TotalWorkExpesienceYear" id="TotalWorkExpesienceYear" placeholder="Please Enter Total Work Experience Year" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->TotalWorkExpesienceYear}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="TotalWorkExpesienceYearStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="TotalWorkExpesienceYearStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Total Work Experience Month:</label>
                                    <input type="text" name="TotalWorkExpesienceMonth" id="TotalWorkExpesienceMonth" placeholder="Please Enter Total Work Experience Month" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->TotalWorkExpesienceMonth}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="TotalWorkExpesienceMonthStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="TotalWorkExpesienceMonthStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Total Companies Worked:</label>
                                    <input type="text" name="TotalCompaniesWorked" id="TotalCompaniesWorked" placeholder="Please Enter Total Companies Worked" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->TotalCompaniesWorked}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="TotalCompaniesWorkedStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="TotalCompaniesWorkedStatus" value="2" checked>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Last Current Employer:</label>
                                    <input type="text" name="LastCurrentEmployer" id="LastCurrentEmployer" placeholder="Please Enter Last Current Employer" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" value="{{$ResumeDetail->LastCurrentEmployer}}" class="form-control" autofocus>
                                    <div class="mt-2">


                                    <label class="text-danger">Not Approve:</label>
                                    <input type="radio" name="LastCurrentEmployerStatus" value="1" >


                                    <label class="text-success">Approve:</label>
                                    <input type="radio" name="LastCurrentEmployerStatus" value="2" checked>

                                    </div>
                                </div>

                                 </div>
                                <br>
                                @if($ResumeStatus == 1)
                                <button type="submit" id="submit" class="btn btn-sm btn-primary m-t-n-xs" disabled>
                                    <strong>Submit</strong>
                                </button>
                                @else
                                <button type="submit" id="submit" class="btn btn-sm btn-primary m-t-n-xs">
                                    <strong>Submit</strong>
                                </button>
                                @endif
                            </form>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="{{ url('/public/inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ url('/public/inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('/public/inspinia/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
      $(document).ready(function(){
            $("#addHealthConditionForm").validate({
                rules: {
                    FirstName: {
                        required: true,
                        noSpace:true,
                    },
                    MiddleName: {
                        required: true,
                        noSpace:true,
                    },
                    LastName: {
                        required: true,
                        noSpace:true,
                    },
                    DateOfBirth:{
                        required: true,
                        noSpace:true,
                    },
                    Gender: {
                        required: true,
                    },
                    Nationality: {
                        required: true,
                        noSpace:true,
                    },
                    Marital: {
                        required: true,
                    },
                    Passport: {
                        required: true,
                        noSpace:true,
                    },
                    Hobbies: {
                        required: true,
                        noSpace:true,
                    },

                    languageKnown: {
                        required: true,
                        noSpace:true,
                    },
                    Address: {
                        required: true,
                        noSpace:true,
                    },
                    LandMark: {
                        required: true,
                        noSpace:true,
                    },
                    City: {
                        required: true,
                    },
                    State: {
                        required: true,
                        noSpace:true,
                    },
                    Pincode: {
                        required: true,
                        noSpace:true,
                    },
                    Mobile: {
                        required: true,
                        noSpace:true,

                    },
                    EmailId: {
                        required: true,
                        noSpace:true,

                    },
                    SSCResult: {
                        required: true,
                        noSpace:true,
                    },
                    SSCPassingYear:{
                        required: true,
                        noSpace:true,
                    },
                    SSCBoardUniversity: {
                        required: true,
                        noSpace:true,
                    },
                    HSCResult: {
                        required: true,
                        noSpace:true,
                    },
                    HSCBoardUniversity: {
                        required: true,
                        noSpace:true,
                    },
                    HSCPassingYear:{
                        required: true,
                        noSpace:true,
                    },
                    DiplomaDegree: {
                        required: true,
                        noSpace:true,
                    },
                    DiplomaResult: {
                        required: true,
                        noSpace:true,
                    },

                    DiplomaUniversity: {
                        required: true,
                        noSpace:true,
                    },
                    DiplomaYear:{
                        required: true,
                        noSpace:true,
                    },
                    GraduationResult: {
                        required: true,
                        noSpace:true,
                    },
                    GraduationUniversity: {
                        required: true,
                        noSpace:true,
                    },

                    GraduationDegree: {
                        required: true,
                        noSpace:true,
                    },
                    GraduationYear:{
                        required: true,
                        noSpace:true,
                    },
                    PostGraduationDegree: {
                        required: true,
                        noSpace:true,
                    },
                    PostGraduationResult: {
                        required: true,
                        noSpace:true,
                    },
                    PostGraduationUniversity: {
                        required: true,
                        noSpace:true,
                    },
                    PostGraduationYear:{
                        required: true,
                        noSpace:true,
                    },
                    HighestLevelEducation: {
                        required: true,
                        noSpace:true,
                    },
                    TotalWorkExpesienceYear: {
                        required: true,
                        noSpace:true,

                    },
                    TotalWorkExpesienceMonth: {
                        required: true,
                        noSpace:true,

                    },
                    TotalCompaniesWorked: {
                        required: true,
                        noSpace:true,

                    },
                    LastCurrentEmployer: {
                        required: true,
                        noSpace:true,
                    },

                }

            });

            $('#resumeselect').on('change', function() {
                window.location.href = this.value;
            });
            jQuery.validator.addMethod("noSpace", function(value, element) {
                return $.trim(value) != '';
            }, "Space are not allowed");

            $('#submit').click(function() {
                if ($("#addHealthConditionForm").valid()) {
                    $('.ibox-content').addClass('sk-loading');
                    // $("#addResumeForm").submit();
                    // $('.ibox-content').removeClass('sk-loading');
                } else {
                    $('.ibox-content').removeClass('sk-loading');
                }
            });
        });
</script>
<script>
        $(document).ready(function(){


            @if(Session::has('SuccessMessage'))
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 3000
                    };

                    toastr.success('{!! Session::get("SuccessMessage") !!}', '');
                }, 1000);
            @endif

            @if(Session::has('ErrorMessage'))
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 3000
                    };

                    toastr.error('{!! Session::get("ErrorMessage") !!}', '');
                }, 1000);
            @endif
        });

    </script>
@endsection