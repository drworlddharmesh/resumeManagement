@extends('admin.template.master')

@section('header-css')
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Invoice Generator</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
          
            <li class="breadcrumb-item active">
                <strong>Invoice Generator</strong>
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
                    <h5>Invoice Generator</h5>

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

                    <form role="form" id="invoice" method="post" enctype="multipart/form-data" action="{{ url('admin/invoice-generator/download') }}">
                        {{ csrf_field() }}

                        <div class="row">
                            


                                <div class="col-sm-6">
                                <div class="form-group">
                                    <label>User Registration Id:</label>
                                    <input type="text" name="UserRegistrationId" id="UserRegistrationId" placeholder="Please Enter User Registration Id" class="form-control" autofocus>
                                </div>
                                </div>
                                <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Amount:</label>
                                    <input type="text" name="Amount" id="Amount" placeholder="Please Enter Amount" class="form-control" autofocus>
                                </div>
                                </div>

                                <div class="col-sm-6">
                                <div class="form-group">
                                    <label>GST Number:</label>
                                    <input type="text" name="GSTNumber" id="GSTNumber" placeholder="Please Enter GST Number" class="form-control" autofocus>
                                </div>
                                </div>
                                <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Action:</label><br>
                                    <label class="text-success">Download:</label>
                                    <input type="radio" name="Action" value="1">
                                    <label class="text-success">E-Mail:</label>
                                    <input type="radio" name="Action" value="2">
                                </div>
                                </div>
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
            $("#invoice").validate({
                rules: {
                    UserRegistrationId: {
                        required: true  
                    },
                    Amount: {
                        required: true,
                        number:true,
                    },
                    GSTNumber: {
                        required: true,
                    },
                    Action: {
                        required: true,
                    },

                }
               
            });
        });

      
    </script>
@endsection