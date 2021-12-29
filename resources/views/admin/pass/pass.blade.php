@extends('admin.template.master')

@section('header-css')
<link href="{{ url('public/inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ url('public/inspinia/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Pass</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Pass</strong>
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
                    <h5>Pass List</h5>

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
                    <form>
                    @csrf
                    <div class="row mb-5">
                    <div class="col-md-12">
                   <div class="row">
                   <div class="col-sm-2">
                   <label class="font-normal">Start Date:</label>
                   </div>
                   <div class="col-sm-3">
                   <input type="text" name="startDateRange" id="startDateRange" class="form-control" value="" />
                   </div>
                   <div class="col-sm-2">
                   <label class="font-normal">End Date:</label>
                   </div>
                   <div class="col-sm-3">
                   <input type="text" name="endDateRange" id="endDateRange" class="form-control" value="" />
                   </div>
                   <div class="col-sm-2">
                   <div class="form-group">
                        <button id="dateRange" class=" btn btn-primary float-right">submit</button>
                        </div>
                   </div>
                   </div> 
                    </div>
                </div>
                    </form>
                    <div class="table-responsive">
                        <table id="healthConditionDatatable" class="table table-striped table-bordered table-hover dataTables-example" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>User Registration Id</th>
                                    <th>Franchisee Name</th>
                                    <th>Caller Name</th>
                                    <th> User Email</th>
                                    <th>User Moblie Number</th>
                                    <th>User Start Date</th>
                                    <th>User End Date</th>


                                </tr>
                            </thead>

                           {{-- <tbody>

                                @foreach($Pass1 as $ahc)

                                <tr>
                                     <td>{{ $ahc['UserName'] }}</td>
                                    <td>{{ $ahc['UserRegistrationId'] }}</td>
                                    <td>{{ $ahc['FranchiseeName'] }}</td>
                                    <td>{{ $ahc['CallerName'] }}</td>
                                    <td>{{ $ahc['UserEmail'] }}</td>
                                    <td>{{ $ahc['UserMoblieNumber'] }}</td>
                                    <td>{{ $ahc['UserStartDate'] }}</td>
                                    <td>{{ $ahc['UserEndDate'] }}</td>
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
        $('#startDateRange').daterangepicker({
            opens: 'left',
            maxDate: new Date()
        });
        $('#endDateRange').daterangepicker({
            opens: 'left',
            maxDate: new Date()
        });
        // Show Data Table Datas
      var oTable =   $('#healthConditionDatatable').DataTable({
            proccessing: true,
                serverSide: true,
                ajax: {
          url: "{{ route('PassDataTable') }}",
          data: function (d) {
                d.startDateRange = '{{$startDateRange}}',
                d.endDateRange = '{{$endDateRange}}'
            }
        },
            columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'UserName',
                        name: 'UserName',

                    },
                    {
                        data: 'UserRegistrationId',
                        name: 'UserRegistrationId',
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
                        data: 'UserEmail',
                        name: 'UserEmail',
                    },
                    {
                        data: 'UserMoblieNumber',
                        name: 'UserMoblieNumber',
                    },
                    {
                        data: 'UserStartDate',
                        name: 'UserStartDate',
                    },
                    {
                        data: 'UserEndDate',
                        name: 'UserEndDate',
                    },


                ],
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [ {
    extend: 'excel',
    exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8]
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
            $("#dateRange").click(function(){
       var urlpath = url('admin/client/pass');
                $.ajax({
                    url: urlpath,
                    data: {
                        start:  $('#startDateRange').val(),
                        end: $('#endDateRange').val()
                    },
                    success: function(data) {
                        alert(data);
                    }
                   
                });
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