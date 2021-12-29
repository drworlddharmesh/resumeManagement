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
                <strong>Add Registration</strong>
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
                    <h5>Add Registration</h5>

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

                    <form role="form" id="addHealthConditionForm" method="post" enctype="multipart/form-data" action="{{ url('admin/client/insert-client') }}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" name="Name" id="Name" placeholder="Please Enter Name" class="form-control" autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Moblie Number:</label>
                                    <input type="text" name="MoblieNumber" id="MoblieNumber" placeholder="Please Enter Moblie Number" class="form-control" autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email" name="Email" id="Email" placeholder="Please Enter Email" class="form-control" autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Address:</label>
                                    <textarea name="Address" id="Address" placeholder="Please Enter Address" class="form-control" autofocus></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Plan:</label>

                                    <select name="PlanId" id="PlanId" class="form-control" autofocus>

                                        @foreach($PlanData as $ahc)
                                        <option value="{{$ahc->PlanId }}">{{ $ahc->PlanName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Franchisee:</label>

                                    <select name="FranchiseeId" id="FranchiseeId" class="form-control dynamic" data-dependent="CallerId" autofocus>
                                        <option value="">Please Select Franchisee</option>
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
                                        <option value="">Please Select Caller</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Agreement:</label>

                                    <select name="AgreementId" id="AgreementId" class="form-control" autofocus>
                                        <option value="">Please Select Agreement</option>
                                        @foreach($AgreementData as $ahc)
                                        @if($SelectAgreement == $ahc->AgreementNo)
                                        <option value="{{$ahc->AgreementNo }}" selected>{{ $ahc->AgreementNo }}</option>
                                        @else
                                        <option value="{{$ahc->AgreementNo }}">{{ $ahc->AgreementNo }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <button type="button" id="sbmt" class="btn btn-sm btn-primary m-t-n-xs">
                                    <strong>Submit</strong>
                                </button>
                            </div>
                        </div>

                    </form>
                    <br>
                     @if(Session::has('UserRegistrationId'))
                    <div class="table-responsive">
                        <table class="table  table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Last Registration</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Registration Id:- {{ Session::get('UserRegistrationId') }}</td>
                                </tr>
                                <tr>
                                <td>Password:- {{ Session::get('UserPassword') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
 <!-- Delete Modal -->
 <div class="modal fade" id="confirm_deletes">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <a href="javascript:void(0)" class="close" id="cancel" data-dismiss="modal">&times;</a>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-body">
            <b class="label-change">This email address already use?</b> <br>
            <hr>
            <button class="btn btn-success" id="submitBtn" data-dismiss="modal">Ok</button>
            <a href="#"  class="btn btn-danger"  data-dismiss="modal">Cancel</a>

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
                Address: {
                    required: true
                },
                PlanId: {
                    required: true
                },
                FranchiseeId: {
                    required: true
                },
                CallerId: {
                    required: true
                },
                AgreementId: {
                    required: true
                },

            },
            messages: {
                HealthCondition: {
                    required: adminMessage['msgHealthConditionRequired']
                },
            }
        });
    });


    $(document).ready(function() {
        $("#submitBtn").click(function(){
        console.log('2');
        $("#addHealthConditionForm").submit(); // Submit the form
    });
        $('#sbmt').click(function() {

            value = $('#Email').val();
            $.ajax({
                url: 'check-dublication-email',
                type: 'POST',
                async: false,
                data: {
                    _token: '{{ csrf_field() }}',
                    Email: value
                },
                success: function(data) {
                    if (data == 1) {
                        $("#confirm_deletes").modal('show');

                    }
                    else
                    {
                    console.log('1');
                     $('#addHealthConditionForm').submit();
                    }
                }
            });

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