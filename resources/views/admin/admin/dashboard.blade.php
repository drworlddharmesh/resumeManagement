@extends('admin.template.master')

@section('header-css')
<link href="{{ url('public/inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ url('public/inspinia/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('main-content')

<div class="wrapper wrapper-content" style="padding-bottom: unset;">
<div class="row dashboard-count">
                    <div class="col-lg-3">

                        <div class="ibox">
                            <div class="ibox-title blue-bg">

                                <h5>Total Today Fill Resumes</h5>
                            </div>
                            <div class="ibox-content blue-bg ">
                                <h1 class="no-margins">{{ $Today_Total_Fill_Resumes}}</h1>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">

                        <div class="ibox">
                            <div class="ibox-title navy-bg">

                                <h5>Today Users</h5>
                            </div>
                            <div class="ibox-content navy-bg ">
                                <h1 class="no-margins">{{ $Total_User}}</h1>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title lazur-bg ">

                                <h5>Active Users</h5>
                            </div>
                            <div class="ibox-content lazur-bg ">
                                <h1 class="no-margins">{{ $Active_User}}</h1>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title yellow-bg">

                                <h5>Total Franchisees</h5>
                            </div>
                            <div class="ibox-content yellow-bg">
                                <h1 class="no-margins">{{ $Total_Franchisee }}</h1>

                            </div>
                        </div>
                    </div>
</div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight" style="padding-top: unset;">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Franchisee List</h5>

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
                                    <th>Franchisee Name</th>
                                    <th>Total User</th>
                                    <th>Approve User</th>
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
            ajax: '{!! route('DashboardDataTable') !!}',
            columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'FranchiseeName',
                        name: 'FranchiseeName',

                    },
                    {
                        data: 'TotalUser',
                        name: 'TotalUser',
                    },

                    {
                        data: 'ApproveUser',
                        name: 'ApproveUser',
                    },


                ],
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [],
                "aaSorting": [],
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': []}
                ],
            });
            $('#healthConditionDatatable_filter input').unbind();
            $('#healthConditionDatatable_filter input').bind('keyup', function(e) {
                if (e.keyCode == 13) {
                    oTable.search(this.value).draw();
                }
            });
            @if(Session::has('WelcomeMessage'))
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 3000
                    };

                    toastr.success('', 'Welcome to Search Jobs For You');
                }, 1000);
            @endif

            {{ Session::forget('WelcomeMessage') }}

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
            {{ Session::forget('SuccessMessage') }}
        });
    </script>
@endsection