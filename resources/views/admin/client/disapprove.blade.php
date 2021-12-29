@extends('admin.template.master')

@section('header-css')
<link href="{{ url('public/inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ url('public/inspinia/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
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
            <li class="breadcrumb-item active">
                <strong>User</strong>
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
                    <h5>Client List</h5>

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

                    <div class="table-responsive">
                        <table id="healthConditionDatatable" class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>


                                    <th>#</th>
                                    <th>User Registration Id</th>

                                    <th>Email</th>

                                    <th>Plan</th>
                                    <th>Franchisee</th>
                                    <th>Caller</th>
                                    <th>User Signature</th>
                                    <th style="width: 60px">Action</th>
                                    <!-- <th width="60px">Action</th> -->
                                </tr>
                            </thead>

                            <tbody>
                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
<script src="{{ url('/public/inspinia/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ url('/public/inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('/public/inspinia/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Show Data Table Datas
        var oTable = $('#healthConditionDatatable').DataTable({
            proccessing: true,
            serverSide: true,
            ajax: '{!! route('UserDisapproveDataTable') !!}',
            columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                  
                    {
                        data: 'UserRegistrationId',
                        name: 'UserRegistrationId',
                    },
                 
                    {
                        data: 'UserEmail',
                        name: 'UserEmail',
                    },
                    {
                        data: 'PlanName',
                        name: 'PlanName',
                    },
                    {
                        data: 'FranchiseeName',
                        name: 'FranchiseeName',
                    },
                    {
                        data: 'CallerName',
                        name: 'CallerName',

                    },
                 
                   
                    {
                        data: 'UserSignature',
                        name: 'UserSignature',
                    },
                   
                    {
                        data: 'action',
                        name: 'action',
                    },
                ],
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [ {
    extend: 'excel',
    exportOptions: {
                    columns: [0,1,2,3,4,5]
                }
    },],
            "aaSorting": [],
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [6,7]
            }],
        });
        $('#healthConditionDatatable_filter input').unbind();
            $('#healthConditionDatatable_filter input').bind('keyup', function(e) { 
                if (e.keyCode == 13) {    
                    oTable.search(this.value).draw();
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

    function DeleteHealthCondition(UserId) {
            swal({
                title: "Delete Client",
                text: "Are you sure you want to delete this Client?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    url: 'client/delete-client',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        UserId: UserId,
                    },
                    success: function(data) {
                        location.reload();
                    }
                });

                swal.close();
            });
        }
</script>
@endsection