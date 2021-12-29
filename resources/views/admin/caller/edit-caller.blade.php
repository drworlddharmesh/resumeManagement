@extends('admin.template.master')

@section('header-css')
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Caller</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/caller') }}">Caller</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Caller</strong>
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
                    <h5>Edit Caller</h5>

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

                    <form role="form" id="editHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/caller/update-caller') }}">
                        {{ csrf_field() }}

                        <input type="hidden" id="CallerId" name="CallerId" value="{{ $CallerData->CallerId }}">

                        <div class="row">
                            <div class="col-sm-6">

                            <div class="form-group">
                                    <label>Select Franchisee:</label>
                                  
                                    <select name="FranchiseeId" id="FranchiseeId" placeholder="Please Select Franchisee" class="form-control" autofocus>
                                    
                                    @foreach($FranchiseeData as $ahc)
                                    @if($CallerData->FranchiseeId == $ahc->FranchiseeId)
                                    <option value="{{$ahc->FranchiseeId }}" selected>{{ $ahc->FranchiseeName }}</option>
                                    @else
                                    <option value="{{$ahc->FranchiseeId }}">{{ $ahc->FranchiseeName }}</option>
                                    @endif
                                     @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Caller Name:</label>
                                    <input type="text" name="CallerName" id="CallerName" placeholder="Please Enter Caller Name"  value="{{ $CallerData->CallerName }}" class="form-control" autofocus>
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
                    CallerName: {
                        required: true,
                        checkeditcallername: true
                    },
                    FranchiseeId:{
                        required:true
                    },
                },
                messages: {
                    CallerName: {
                        checkeditcallername: 'Caller name already exist.',
                    },
                }
            });
        });

        $.validator.addMethod('checkeditcallername', function(value, element) {
            var rtn_val = true;

            $.ajax({
                url: '../check-edit-caller-name',
                type: 'POST',
                async: false,
                data: {
                    _token: '{{ csrf_field() }}',
                    CallerId: $('#CallerId').val(),
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