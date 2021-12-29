@extends('admin.template.master')

@section('header-css')
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Profile</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Profile</strong>
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
            <h5>Profile</h5>

           <div class="ibox-tools">
                <a href="#" id="sub" class="btn btn-sm btn-primary m-t-n-xs" onclick="openModal();">
                    <strong>reset password</strong>
                </a>

                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">

                    <form role="form" id="editHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/profile/update-profile') }}">
                        {{ csrf_field() }}

                        <input type="hidden" id="UserId" name="UserId" value="{{ $user->UserId }}">





                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Name:</label>
                                    <div class="col-lg-9">
                                    <input type="text" name="UserName" id="UserName" placeholder="Please Enter User Name"  value="{{ $user->UserName }}" class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Email:</label>
                                    <div class="col-lg-9">
                                    <input type="text" name="UserEmail" id="UserEmail" placeholder="Please Enter Email Name"  value="{{ $user->UserEmail }}" class="form-control" disabled readonly>
                                </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Moblie Number:</label>
                                    <div class="col-lg-9">
                                    <input type="text" name="UserMoblieNumber" id="UserMoblieNumber" placeholder="Please Enter Moblie Number"  value="{{ $user->UserMoblieNumber }}" class="form-control" autofocus>
                                </div>
                                </div>

                                <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
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
<div class="modal inmodal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Reset Password.</h4>

                                        </div>
                                        <form method="post" action="{{ url('admin/profile/reset-password') }}">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                        <div class="form-group">
                                        <label>Password:</label>
                                        <input type="password" name="Password" id="Password" placeholder="Please Enter Password" value="" class="form-control" autofocus>
                                       </div>
                                        </div>

                                        <div class="modal-footer">
                                        <a href="{{ url('admin/dashboard') }}" class="btn btn-white" >Close</a>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
@endsection

@section('footer')
<script>
    function openModal() {
        $('#myModal').modal('show');
 }
        $(document).ready(function() {
            $("#editHealthConditionForm").validate({
                rules: {
                    UserName: {
                        required: true,

                    },

                    UserMoblieNumber: {
                        required: true,
                        digits: true,
                        maxlength:10,
                        minlength:10
                    }
                }

            });
        });

        $(document).ready(function() {
            @if(Session::has('WelcomeMessage'))
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 3000
                    };

                    toastr.success('', 'Welcome to Search Jobs For You');
                }, 1000);
            @endif

            {{ Session::forget('WelcomeMessage') }}

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
        });
    </script>
@endsection