@extends('admin.template.master')

@section('header-css')
    <link href="{{ url('public/inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ url('public/inspinia/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Resume Details View</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/resumedetails') }}">Resume Details</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Resume Details View</strong>
            </li>
        </ol>
    </div>
</div>
<?php
Session::put('UserIdDataTable', encrypt($UserId));
?>
<!-- End Breadcromb Row -->

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Resume List</h5>

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
                    <form>
                    @csrf
                    <div class="row mb-5">
                    <div class="col-md-12">
                   <div class="row">
                   <div class="col-sm-2">
                   <label class="font-normal" >Select Field:</label>
                   </div>
                   <div class="col-sm-3">
                   <select class="form-control" id="selectField" name="selectField">
                   <option value="FirstName">First Name</option>
                   <option value="MiddleName">Middle Name</option>
                   <option value="LastName">Last Name</option>
                   <option value="DateOfBirth">Date Of Birth</option>
                   <option value="Gender">Gender</option>
                   <option value="Nationality">Nationality</option>
                   <option value="Marital">Marital</option>
                   <option value="Passport">Passport</option>
                   <option value="Hobbies">Hobbies</option>
                   <option value="languageKnown">language Known</option>
                   <option value="Address">Address</option>
                   <option value="LandMark">LandMark</option>
                   <option value="City">City</option>
                   <option value="State">State</option>
                   <option value="Pincode">Pin code</option>
                   <option value="Mobile">Mobile</option>
                   <option value="EmailId">Email Id</option>
                   <option value="SSCResult">SSC Result</option>
                   <option value="SSCPassingYear">SSC Passing Year</option>
                   <option value="SSCBoardUniversity">SSC Board University</option>
                   <option value="HSCResult">HSC Result</option>
                   <option value="HSCBoardUniversity">HSC Board University</option>
                   <option value="HSCPassingYear">HSC Passing Year</option>
                   <option value="DiplomaDegree">Diploma Degree</option>
                   <option value="DiplomaResult">Diploma Result</option>
                   <option value="DiplomaUniversity">Diploma University</option>
                   <option value="DiplomaYear">Diploma Year</option>
                   <option value="GraduationResult">Graduation Result</option>
                   <option value="GraduationUniversity">Graduation University</option>
                   <option value="GraduationYear">Graduation Year</option>
                   <option value="GraduationDegree">Graduation Degree</option>
                   <option value="PostGraduationDegree">Post Graduation Degree</option>
                   <option value="PostGraduationResult">Post Graduation Result</option>
                   <option value="PostGraduationUniversity">Post Graduation University</option>
                   <option value="PostGraduationYear">Post Graduation Year</option>
                   <option value="HighestLevelEducation">Highest Level Education</option>
                   <option value="TotalWorkExpesienceYear">Total WorkExpesience Year</option>
                   <option value="TotalWorkExpesienceMonth">Total Work Expesience Month</option>
                   <option value="TotalCompaniesWorked">Total Companies Worked</option>
                   <option value="LastCurrentEmployer">Last Current Employer</option>
                   </select>
                   </div>
                   <div class="col-sm-2">
                   <label class="font-normal">Search:</label>
                   </div>
                   <div class="col-sm-3">
                   <input type="text" name="fieldSearch" id="fieldSearch" class="form-control" value="" />
                   </div>
                   <div class="col-sm-2">
                   <div class="form-group">
                        <button id="date" class=" btn btn-primary float-right">submit</button>
                        </div>
                   </div>
                   </div> 
                    </div>
                </div>
                    </form>
                    <div class="row">
                    <div class="col-md-12">
                   <label class="font-normal text-success">Resume Fail Count:{{$ResumeFailCount}}</label>
                   </div>
                    </div>
                    <div class="table-responsive">
                        <table id="healthConditionDatatable" class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Resume Id</th>
                                    <th>Resume Name</th>
                                    <th class="text-center">Resume Status </th>
                                    <th width="60px">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                           
                            </tbody>
                        </table>
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
             // Show Data Table Datas
             var oTable = $('#healthConditionDatatable').DataTable({
            proccessing: true,
            serverSide: true,
            ajax: {
          url: "{{ route('ResumeSubmitDataTable') }}",
          data: function (d) {
                d.selectField = '{{$selectField}}',
                d.fieldSearch = '{{$fieldSearch}}'
            }
        },
            columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'ResumeId',
                        name: 'ResumeId',

                    },
                    {
                        data: 'ResumeName',
                        name: 'ResumeName',

                    },
                    {
                        data: 'Status',
                        name: 'Status',

                    },
                    {
                        data: 'action',
                        name: 'action',
                    },
                ],
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [ {
    extend: 'excel',
    exportOptions: {
                    columns: [0,1,2,3]
                }
    },],
                "aaSorting": [],
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [4]}
                ],
            });
            $('#healthConditionDatatable_filter input').unbind();
            $('#healthConditionDatatable_filter input').bind('keyup', function(e) { 
                if (e.keyCode == 13) {    
                    oTable.search(this.value).draw();
                }
            });
            $("#date").click(function(){
                var selected12= $('#selectField').val();
       var urlpath = url('admin/resumedetails/').$UserId;
      
                $.ajax({
                    url: urlpath,
                    data: {
                        fieldSearch: $('#fieldSearch').val(),
                        selectField: selected12
                    },
                    success: function(data) {
                        alert(data);
                    }
                   
                });
    }); 
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