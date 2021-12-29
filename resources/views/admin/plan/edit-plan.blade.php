@extends('admin.template.master')

@section('header-css')
<link href="{{ url('public/inspinia/css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Plan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/plan') }}">Plan</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Plan</strong>
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
                    <h5>Edit Plan</h5>

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

                    <form role="form" id="editHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/plan/update-plan') }}">
                        {{ csrf_field() }}

                        <input type="hidden" id="PlanId" name="PlanId" value="{{ $PlanData->PlanId }}">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Plan No:</label>
                                    <input type="text" name="PlanNo" id="PlanNo" placeholder="Please Enter Plan No"  value="{{ $PlanData->PlanNo }}" class="form-control" disabled readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Plan Name:</label>
                                    <input type="text" name="PlanName" id="PlanName" placeholder="Please Enter Plan Name"  value="{{ $PlanData->PlanName }}" class="form-control" autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Days:</label>
                                    <input type="text" name="Days" id="Days" placeholder="Please Enter Days"  value="{{ $PlanData->PlanDays }}" class="form-control" autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Forms:</label>
                                    <input type="text" name="Forms" id="Forms" placeholder="Please Enter Forms"  value="{{ $PlanData->PlanForms }}" class="form-control" autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Qc-Cutoff:</label>
                                    <input type="text" name="QcCutoff" id="QcCutoff" placeholder="Please Enter Qc-Cutoff"  value="{{ $PlanData->PlanQcCutoff }}" class="form-control" autofocus >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Fees:</label>
                                    <input type="text" name="Fees" id="Fees" placeholder="Please Enter Fees"  value="{{ $PlanData->PlanFees }}" class="form-control" autofocus >
                                </div>
                            </div>
                            <div class="form-group">
                                    <label>Agreement:</label>
                                    <textarea  name="AgreementText" id="AgreementText" class="form-control summernote" autofocus style="height:150px;">{{ $PlanData->AgreementText }}</textarea>
                                </div>
                                <br>
                                <div class="col-sm-6">
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
                    PlanName: {
                        required: true  
                    },
                    Days: {
                        required: true,
                        digits:true,
                        maxlength:9 
                    },
                    Forms: {
                        required: true,
                        digits:true,
                        maxlength:9   
                    },
                    QcCutoff: {
                        required: true,
                        number:true,
                        maxlength:19  
                    },
                    Fees: {
                        required: true,
                        number:true,
                        maxlength:19   
                    },
                    AgreementText:{
                        required:true,
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
    <script src="{{ url('/public/inspinia/js/plugins/summernote/summernote-bs4.js') }}"></script>
      <script>
        $(document).ready(function(){

            $('.summernote').summernote();

       });
    </script>
@endsection