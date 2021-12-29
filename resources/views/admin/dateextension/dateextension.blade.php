@extends('admin.template.master')

@section('header-css')
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Date Extension</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Date Extension</strong>
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
                    <h5>Date Extension</h5>

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

                    <form role="form" id="addHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/date-extension/update') }}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>User Registration Id:</label>
                                    <input type="text" name="UserRegistrationId" id="UserRegistrationId" placeholder="Please Enter User Registration Id" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Date:</label>
                                    <input type="date" name="Date" id="Date" placeholder="Please Enter Date" class="form-control">
                                    <input type="text" name="UserEndDate" id="UserEndDate"  class="form-control" disabled>
                                </div>
                            </div>
                                
                               
                               
                                <div class="col-sm-6">
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

@endsection

@section('footer')

    <script>
        $(document).ready(function(){
            $("#addHealthConditionForm").validate({
                rules: {
                    UserRegistrationId: {
                        required: true,
                        checkUserRegistrationId: true 
                    },
                    Date: {
                        required: true                           
                    }
                },
                messages: {
                    UserRegistrationId: {
                        checkUserRegistrationId: 'User Registration Id Not Found.',
                    },
                }
               
            });
        
        });
        $.validator.addMethod('checkUserRegistrationId', function(value, element) {
            var rtn_val = true;

            $.ajax({
                url: 'check-UserRegistrationId',
                type: 'POST',
                async: false,
                data: {
                    _token: '{{ csrf_field() }}',
                    UserRegistrationId: value
                },
                success: function(data) {
                    if(data != false) {
                        $('#UserEndDate').val(data);
                        rtn_val = true;
                    }
                    else
                    {
                        rtn_val = false;
                    }
                }
            });

            return rtn_val;
        }, adminMessage['msgCheckExistHealthCondition']);
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