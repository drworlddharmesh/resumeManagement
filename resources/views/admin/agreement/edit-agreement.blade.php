@extends('admin.template.master')

@section('header-css')
<link href="{{ url('public/inspinia/css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Agreement</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/agreement') }}">Agreement</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Agreement</strong>
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
                    <h5>Edit Agreement</h5>

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

                    <form role="form" id="editHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/agreement/update-agreement') }}">
                        {{ csrf_field() }}

                        <input type="hidden" id="AgreementId" name="AgreementId" value="{{ $AgreementData->AgreementId }}">

                        <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group">
                                    <label>Agreement No:</label>
                                    <input type="text" name="AgreementNo" id="AgreementNo" placeholder="Please Enter Agreement No" value="{{ $AgreementData->AgreementNo }}" class="form-control" autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Agreement Image:</label>
                                    <input type="file" name="AgreementName" id="AgreementName" placeholder="Please Enter Agreement Name"  value="{{ $AgreementData->AgreementPDF }}" class="form-control" autofocus>
                                </div>
                               
                                
                               

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
                    AgreementNo: {
                        required: true,
                        digits: true,
                        maxlength:8,
                        checkeditAgreementname: true
                    },
                    AgreementName: {
                        extension: "jpg|jpeg|png|ico|bmp"
                    }
                },
                messages: {
                    AgreementNo: {
                        checkeditAgreementname: 'Agreement No already exist.',
                    },
                    AgreementName: {
                        extension: 'Please Select Image'
                    } 
                }
            });
        });

        $.validator.addMethod('checkeditAgreementname', function(value, element) {
            var rtn_val = true;

            $.ajax({
                url: '../check-edit-agreement-name',
                type: 'POST',
                async: false,
                data: {
                    _token: '{{ csrf_field() }}',
                    AgreementId: $('#AgreementId').val(),
                    AgreementName: value
                },
                success: function(data) {
                    if(data == 1) {
                        rtn_val = false;
                    }
                }
            });

            return rtn_val;
        }, adminMessage['msgCheckAgreementName']);
    </script>
     <!-- SUMMERNOTE -->
     <script src="{{ url('/public/inspinia/js/plugins/summernote/summernote-bs4.js') }}"></script>
    <script>
        $(document).ready(function(){

            $('.summernote').summernote();

       });
    </script>
@endsection