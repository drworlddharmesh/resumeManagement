@extends('admin.template.master')

@section('header-css')
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Sub Admin</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ url('admin/sub-admin') }}">Sub Admin</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Sub Admin</strong>
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
                    <h5>Edit Sub Admin</h5>

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

                    <form role="form" id="editSubAdminForm" method="post" enctype="multipart/form-data" action="{{ url('admin/update-sub-admin') }}">
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
                                    <input type="text" name="MoblieNumber" id="MoblieNumber" placeholder="Please Enter Moblie Number" value="{{$UserRegistrationId->UserMoblieNumber}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email" name="Email" id="Email" placeholder="Please Enter Email" value="{{$UserRegistrationId->UserEmail}}" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Address:</label>
                                    <textarea name="Address" id="Address" placeholder="Please Enter Address"  class="form-control" disabled>{{ $UserRegistrationId->UserAddress }}</textarea>
                                </div>
                            </div>
                            {{-- <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Franchisee:</label>

                                    <select name="FranchiseeId" id="FranchiseeId" class="form-control dynamic" data-dependent="CallerId">
                                        @foreach($FranchiseeData as $ahc)
                                            <option value="{{$ahc->FranchiseeId }}" {{$ahc->FranchiseeId == $UserRegistrationId->Caller->Franchisee->FranchiseeId ? 'selected' : '' }}>{{ $ahc->FranchiseeName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Caller:</label>

                                    <select name="CallerId" id="CallerId" class="form-control dynamic">
                                        <option value="{{$UserRegistrationId->caller->CallerId}}" selected>{{$UserRegistrationId->Caller->CallerName}}</option>

                                    </select>
                                </div>
                            </div> --}}

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Menu:</label>

                                    <div class="row">
                                        @foreach($Manu as $mn)
                                            <div class="col-sm-3">
                                                <label class="simple-checkbox">
                                                    <input type="checkbox" name="menu[]" value="{{ $mn->ManuId }}" {{ count($mn->ManuRelation) > 0 ? 'checked' : '' }}>

                                                    {{ $mn->ManuName }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
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
        $("#editSubAdminForm").validate({
            errorPlacement: function(error, element) {
                if(element.parent('.simple-checkbox').length) {
                    error.insertAfter(element.parent().parent().parent());
                } else {
                    error.insertAfter(element);
                }
            },
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
                FranchiseeId: {
                    required: true
                },
                CallerId: {
                    required: true
                },
                'menu[]': {
                    required: true
                },
            },
            messages: {

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