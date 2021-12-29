@extends('admin.template.master')

@section('header-css')
<style>
    .hide
    {
        display: none;
    }
    </style>
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Payment Image</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/image') }}">Payment Image</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Payment Image</strong>
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
                    <h5>Edit Payment Image</h5>

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

                    <form role="form" id="editHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/image/update-image') }}">
                        {{ csrf_field() }}

                        <input type="hidden" id="ImageId" name="ImageId" value="{{ $ImageData->ImageId }}">

                        <div class="row">
                            <div class="col-sm-6">
                                <center>
                                    <div class="error-div">
                                        <img src="{{ $URL }}" id="video-thumb-img" width="200px">
                                        <br><br>
                                        <div class="btn-group">
                                            <label class="btn btn-sm btn-primary">
                                                <input type="file" name="ImageName" id="ImageName" class="form-control hide" accept="image/*">
                                                Upload image placeholder
                                            </label>
                                        </div>
                                    </div>
                                    <br>

                                <button type="submit" id="submit" class="btn btn-sm btn-primary m-t-n-xs">
                                    <strong>Submit</strong>
                                </button>
                                </center>      
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
                errorPlacement: function(error, element) {
                    if(element.closest('.error-div').length) {
                        error.insertAfter(element.closest('.error-div'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                ignore: [],
                rules: {
                'ImageName': {
                    required: true,
                    extension: "jpg|jpeg|png|ico|bmp"

                }
            },
            messages: {
                'ImageName': {
                    extension: "Please Select Image",
                }
            }
            });
            var ImageNameUrl = $('#video-thumb-img').attr('src');

                $("#ImageName").change(function(){
                    readURL(this);
                });

                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#video-thumb-img').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    } else {
                        $('#video-thumb-img').attr('src', ImageNameUrl);
                    }
                }
        });

       
    </script>
@endsection