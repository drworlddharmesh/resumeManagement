@extends('admin.template.master')

@section('header-css')
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Change Password</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Change Password</strong>
            </li>
        </ol>
    </div>
</div>
<!-- End Breadcromb Row -->

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-2"></div>

        <div class="col-lg-8">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Change Password</h5>

                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">
                    <form role="form" id="changePasswordForm" method="post" action="{{ url('admin/update-password') }}">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Old Password</label>

                            <div class="col-lg-9">
                                <input type="password" name="OldPassword" id="OldPassword" placeholder="Please Enter Old Password" class="form-control" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">New Password</label>

                            <div class="col-lg-9">
                                <input type="password" name="NewPassword" id="NewPassword" placeholder="Please Enter New Password" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Confirm Password</label>

                            <div class="col-lg-9">
                                <input type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Please Enter Confirm Password" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-2"></div>
    </div>
</div>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $("#changePasswordForm").validate({
                rules: {
                    OldPassword: {
                        required: true,
                        checkoldpassword: true,
                    },
                    NewPassword: {
                        required: true,
                    },
                    ConfirmPassword: {
                        required: true,
                        equalTo: "#NewPassword"
                    }
                },
                messages: {
                    OldPassword: {
                        required: adminMessage['msgOldPasswordRequired'],
                    },
                    NewPassword: {
                        required: adminMessage['msgNewPasswordRequired'],
                    },
                    ConfirmPassword: {
                        required: adminMessage['msgConfirmPasswordRequired'],
                        equalTo: adminMessage['msgMatchPassword'],
                    }
                }
            });
        });

        $.validator.addMethod('checkoldpassword', function(value, element) {
            var rtn_val = true;

            $.ajax({
                url: 'check-old-password',
                type: 'POST',
                async: false,
                data: {
                  
                    OldPassword: value
                },
                success: function(data) {
                    if(data == 1) {
                        rtn_val = false;
                    }
                }
            });

            return rtn_val;
        }, adminMessage['msgIncorrectOldPassword']);
    </script>
    
@endsection