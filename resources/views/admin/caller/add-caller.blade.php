@extends('admin.template.master')

@section('header-css')
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Caller </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/caller') }}">Caller</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Add Caller</strong>
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
                    <h5>Add Caller</h5>

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

                    <form role="form" id="addHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/caller/insert-caller') }}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-6">
                                
                            <div class="form-group">
                                    <label>Select Franchisee:</label>
                                  
                                    <select name="FranchiseeId" id="FranchiseeId" placeholder="Please Select Franchisee" class="form-control" autofocus>
                                    <option value="">Please Select Franchisee</option>
                                    @foreach($FranchiseeData as $ahc)
                                     <option value="{{$ahc->FranchiseeId }}">{{ $ahc->FranchiseeName }}</option>
                                     @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Caller Name:</label>
                                    <input type="text" name="CallerName" id="CallerName" placeholder="Please Enter Caller Name" class="form-control" autofocus>
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
            $("#addHealthConditionForm").validate({
                rules: {
                    CallerName: {
                        required: true,
                        checkcallername: true
                    },
                    FranchiseeId:{
                        required:true
                    },
                },
                messages: {
                    CallerName: {
                        checkcallername: 'Caller name already exist.',
                    },
                }
            });
        });

        $.validator.addMethod('checkcallername', function(value, element) {
            var rtn_val = true;

            $.ajax({
                url: 'check-caller-name',
                type: 'POST',
                async: false,
                data: {
                    _token: '{{ csrf_field() }}',
                    CallerName: value
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
@endsection