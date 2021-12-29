@extends('admin.template.master')

@section('header-css')
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Customer Care</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/customer-care') }}">Customer Care</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Customer Care</strong>
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
                    <h5>Edit Customer Care</h5>

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

                    <form role="form" id="editHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/customer-care/update-customer-care') }}">
                        {{ csrf_field() }}

                        <input type="hidden" id="CustomerCareId" name="CustomerCareId" value="{{ $CallerData->CustomerCareId }}">

                        <div class="row">
                            <div class="col-sm-6">

                          
                                
                                <div class="form-group">
                                    <label>Customer Care No:</label>
                                    <input type="text" name="CustomerCareNo" id="CustomerCareNo" placeholder="Please Enter Customer Care No"  value="{{ $CallerData->CustomerCareNo }}" class="form-control" autofocus>
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
                    CustomerCareNo: {
                        required: true,
                      
                    },
                  
                }
               
            });
        });

    </script>
@endsection