@extends('admin.template.master')

@section('header-css')
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>User</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/client') }}">User</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Registration</strong>
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
                    <h5>Edit Registration</h5>

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

                    <form role="form" id="addHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/client/update-client') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id" value="{{$UserRegistrationId->UserId}}">
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" name="Name" id="Name" placeholder="Please Enter Name" value="{{$UserRegistrationId->UserName}}" class="form-control" autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Moblie Number:</label>
                                    <input type="text" name="MoblieNumber" id="MoblieNumber" placeholder="Please Enter Moblie Number" value="{{$UserRegistrationId->UserMoblieNumber}}" class="form-control" autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email" name="Email" id="Email" placeholder="Please Enter Email" value="{{$UserRegistrationId->UserEmail}}" class="form-control" autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Address:</label>
                                    <textarea name="Address" id="Address" placeholder="Please Enter Address"  class="form-control" autofocus disabled>{{ $UserRegistrationId->UserAddress }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Plan:</label>

                                    <select name="PlanId" id="PlanId" class="form-control" autofocus disabled>
                                        <option value="">Please Select Plan</option>
                                        @if($UserRegistrationId->Plan)
                                       <option value="" selected>{{$UserRegistrationId->Plan->PlanName}}</option>
                                      @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Franchisee:</label>

                                    <select name="FranchiseeId" id="FranchiseeId" class="form-control dynamic" data-dependent="CallerId" autofocus>
                                        <option value="{{$UserRegistrationId->caller->franchisee->FranchiseeId}}" selected>{{$UserRegistrationId->Caller->Franchisee->FranchiseeName}}</option>
                                        @foreach($FranchiseeData as $ahc)
                                        <option value="{{$ahc->FranchiseeId }}">{{ $ahc->FranchiseeName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Caller:</label>

                                    <select name="CallerId" id="CallerId" class="form-control dynamic" autofocus>
                                        <option value="{{$UserRegistrationId->caller->CallerId}}" selected>{{$UserRegistrationId->Caller->CallerName}}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Agreement:</label>
                     
                                    <select name="AgreementId" id="AgreementId" class="form-control" autofocus disabled>
                                        <option value="">Please Select Agreement</option>
                                       @if($UserRegistrationId->Agreement)
                                       <option value="" selected>{{$UserRegistrationId->Agreement->AgreementNo}}</option>
                                      @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <button type="submit" id="sbmt" class="btn btn-sm btn-primary m-t-n-xs">
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

    $(document).ready(function() {


        $("#addHealthConditionForm").validate({
            rules: {
                Name: {
                    required: true
                },
                MoblieNumber: {
                    required: true,
                    digits: true,
                    maxlength: 10,
                    minlength: 10
                },
                Email: {
                    required: true,
                    email: true,
                },
               
               
                FranchiseeId: {
                    required: true
                },
                CallerId: {
                    required: true
                },
              
            },
            messages: {
                HealthCondition: {
                    required: adminMessage['msgHealthConditionRequired']
                },
            }
        });

      
       
        $('.dynamic').change(function() {
            if ($(this).val() != '') {
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('ClientController.dependentfetch')}}",
                    method: "POST",
                    data: {
                        select: select,
                        value: value,
                        _token: _token,
                        dependent: dependent
                    },
                    success: function(result) {
                        $('#' + dependent).html(result);
                    }
                })
            }
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