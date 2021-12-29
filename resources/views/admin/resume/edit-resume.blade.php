@extends('admin.template.master')

@section('header-css')
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Resume</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/resume') }}">Resume</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Resume</strong>
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
                    <h5>Edit Resume</h5>

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

                    <form role="form" id="editHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/resume/update-resume') }}">
                        {{ csrf_field() }}

                        <input type="hidden" id="ResumeId" name="ResumeId" value="{{ $ResumeData->ResumeId }}">

                        <div class="row">
                            <div class="col-sm-6">
                                
                                <div class="form-group">
                                    <label>Resume:</label>
                                    <input type="file" name="ResumeName" id="ResumeName" placeholder="Please Enter Resume"  value="{{ $ResumeData->ResumeName }}" class="form-control" autofocus>
                                </div>

                                <br>
                               

                                <button type="submit" id="submit" class="btn btn-sm btn-primary m-t-n-xs">
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
@endsection

@section('footer')

    <script>
        $(document).ready(function(){
            $("#editHealthConditionForm").validate({
                rules: {
                    ResumeName: {
                        extension: "pdf"
                        
                    },
                },
                messages:{
                    ResumeName:{
                        extension: "Please Select PDF" ,
                    }
                }
               
            });
        });

        $.validator.addMethod('checkexistedithealthcondition', function(value, element) {
            var rtn_val = true;

            $.ajax({
                url: '../check-exist-edit-health-condition',
                type: 'POST',
                async: false,
                data: {
                    _token: '{{ csrf_field() }}',
                    HealthConditionId: $('#HealthConditionId').val(),
                    HealthCondition: value
                },
                success: function(data) {
                    if(data == 1) {
                        rtn_val = false;
                    }
                }
            });

            return rtn_val;
        }, adminMessage['msgCheckExistHealthCondition']);
    </script>
@endsection