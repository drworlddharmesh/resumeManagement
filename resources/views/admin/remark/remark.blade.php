<?php
?>
@extends('admin.template.master')

@section('header-css')
<link href="{{ url('public/inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ url('public/inspinia/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Remark</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Remark</strong>
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
                    <h5>Remark List</h5>

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
                        <table id="healthConditionDatatable" class="table table-striped table-bordered table-hover dataTables-example" style="width: 100%;" >
                            <thead>
                                <tr>

                                    <th>#</th>
                                    <th>Remark Id</th>
                                    <th>User Registration Id</th>
                                    <th>Name</th>
                                    <th>Remark Text</th>
                                    <th>Moblie Number</th>
                                    <th>Email</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Create Date</th>
                                    <th>Ip Address</th>
                                    

                                    <!-- <th width="60px">Action</th> -->
                                </tr>
                            </thead>

                           {{-- <tbody>
                                @foreach($ClientData as $ahc)
                                <tr>

                                    <td>{{ $ahc['UserName'] }}</td>
                                    <td>{{ $ahc['UserRegistrationId'] }}</td>
                                    <td>{{ $ahc['ResendPassword'] }}</td>
                                    <td>{{ $ahc['UserMoblieNumber'] }}</td>
                                    <td>{{ $ahc['UserEmail'] }}</td>


                                    <td> @if($ahc['plan']) {{ $ahc['plan']->PlanName }} @endif</td>




                                    <td>@if($ahc['caller']) @if($ahc['caller']->franchisee) {{ $ahc['caller']->franchisee->FranchiseeName }}@endif @endif</td>

                                    <td>@if($ahc['caller']) {{ $ahc['caller']->CallerName }} @endif</td>

                                    <td>

                                            {{ Common::dateformat($ahc['UserStartDate']) }}

                                    </td>
                                    <td>

                                            {{ Common::dateformat($ahc['UserEndDate']) }}

                                    </td>
                                    <td>{{ $ahc['UserIpAddress'] }}</td>
                                    <td>{{count($ahc['resume_allow'])}}</td>



                                </tr>
                                @endforeach
                            </tbody> --}}
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
            ajax: '{!! route('RemarkDataTable') !!}',
            columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'RemarkId',
                        name: 'RemarkId',
                    },
                    {
                        data: 'UserRegistrationId',
                        name: 'UserRegistrationId',
                    },
                    {
                        data: 'UserName',
                        name: 'UserName',

                    },
                    {
                        data: 'RemarkText',
                        name: 'RemarkText',
                    },
                    {
                        data: 'UserMoblieNumber',
                        name: 'UserMoblieNumber',
                    },
                    {
                        data: 'UserEmail',
                        name: 'UserEmail',
                    },
                    
                    {
                        data: 'UserStartDate',
                        name: 'UserStartDate',
                    },
                    {
                        data: 'UserEndDate',
                        name: 'UserEndDate',
                    },
                    {
                        data: 'CreateDate',
                        name: 'CreateDate',
                    },
                    {
                        data: 'UserIpAddress',
                        name: 'UserIpAddress',
                    },
                ],
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [ {
    extend: 'excel',
    exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10]
                }
    },],
            "aaSorting": [],
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': []
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


</script>
@endsection