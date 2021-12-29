@extends('admin.template.master')

@section('header-css')
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>View Customer Helpline</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/customer-helpline') }}">Customer Helpline</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>View Customer Helpline</strong>
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
                    <h5>View Customer Helpline</h5>

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
                        <div class="col-sm-6">
                            <embed  src="{{ $resumeUrl }}" width="100%" height="600px"/>
                        </div>

                        <div class="col-sm-6">
                            <form role="form" id="editCustomerHelplineForm" method="post" enctype="multipart/form-data" action="{{ url('admin/customer-helpline/update-customer-helpline') }}">

                                {{ csrf_field() }}

                                <input type="hidden" name="CustomerHelplineId"  value="{{ $customerHelpline->CustomerHelplineId }}" >

                                <div class="form-group">
                                    <label>Field Name</label>

                                    <select class="form-control" disabled>
                                        @foreach($resumeField as $key => $value)
                                            <option value="{{ $key }}" {{ $key == $customerHelpline->ResumeFieldId ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Resume Field Question</label>

                                    <textarea class="form-control" rows="4" disabled>{{ $customerHelpline->ResumeFieldQuestion }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Resume Field Answer</label>

                                    <textarea class="form-control" placeholder="Please Enter Resume Field Answer" name="ResumeFieldAnswer" id="ResumeFieldAnswer" rows="4">{{ $customerHelpline->ResumeFieldAnswer }}</textarea>
                                </div>

                                <button class="btn btn-sm btn-primary m-t-n-xs" type="submit">
                                    <strong>Submit</strong>
                                </button>
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

    <script>
        $(document).ready(function(){
            $("#editCustomerHelplineForm").validate({
                rules: {
                    ResumeFieldAnswer: {
                        required: true,
                    },
                },
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