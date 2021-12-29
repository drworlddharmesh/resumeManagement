@extends('admin.template.master')

@section('header-css')


@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Agreement </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/agreement') }}">Agreement</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Add Agreement</strong>
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
                    <h5>Add Agreement</h5>

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

                    <form role="form" id="addHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/agreement/insert-agreement') }}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-6">
                                
                            <div class="form-group">
                                    <label>Agreement No:</label>
                                    <input type="text" name="AgreementNo" id="AgreementNo" placeholder="Please Enter Agreement No" class="form-control" autofocus>
                                </div>

                                <div class="form-group">
                                    <label>Agreement Image:</label>
                                    <input type="file" name="AgreementName" id="AgreementName" placeholder="Please Enter Agreement Name" class="form-control " autofocus>
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
            $("#addHealthConditionForm").validate({
                rules: {
                    AgreementNo:{
                        required: true,
                        digits: true,
                        maxlength:8,
                        checkagreementname: true
                    },
                    AgreementName: {
                        required: true,
                        extension: "jpg|jpeg|png|ico|bmp"
                       
                    }
                },
                messages: {
                    AgreementNo: {
                        checkagreementname: 'Agreement No already exist.',
                    },
                    AgreementName: {
                        extension: 'Please Select Image'
                    } 
                }
               
               
            });
        });

        $.validator.addMethod('checkagreementname', function(value, element) {
            var rtn_val = true;

            $.ajax({
                url: 'check-agreement-name',
                type: 'POST',
                async: false,
                data: {
                    _token: '{{ csrf_field() }}',
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
  
@endsection