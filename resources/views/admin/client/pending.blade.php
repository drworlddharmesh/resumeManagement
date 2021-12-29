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
                                     <th>Name</th>
                                    <th>User Registration Id</th>

                                    <th>Email</th>

                                    <th>Plan</th>
                                    <th>Franchisee</th>
                                    <th>Caller</th>
                                    <th>User Signature</th>
                                    <th>Resend Sign</th>
                                    <th style="width: 60px">Action</th>
                                    <!-- <th width="60px">Action</th> -->
                                </tr>
                            </thead>

                            <tbody>
                            {{--   @foreach($ClientData as $ahc)
                                <tr>

                                     <td>{{ $ahc['UserName'] }}</td>
                                    <td>{{ $ahc['UserRegistrationId'] }}</td>

                                    <td>{{ $ahc['UserEmail'] }}</td>
                                    <td>{{ $ahc['PlanName'] }}</td>
                                    <td>{{ $ahc['FranchiseeName'] }}</td>
                                    <td>{{ $ahc['CallerName'] }}</td>
                                    <td align="center"> @if($ahc['UserSignature']) <a href="#" onclick="SignatureUrl('{{ url('storage/signture/').'/'. $ahc['UserSignature'] }}')" class="btn-sm btn-primary m-t-n-xs">View</a> @endif</td>
                                    <td align="center">@if($ahc['UserSignature']) <a href="{{ url('admin/client/remove-sign').'/'.$ahc['UserId'] }}" class="btn-sm btn-primary m-t-n-xs" >Resign</a>@endif</td>
                                    <td align="center">

                                        @if($ahc['resumeAllow'] == 0)
                                      
                                        <a href="{{ url('admin/client/resumeallow-client').'/'.$ahc['UserId'].'/2' }}" class="text-primary" title="Approve">
                                            <i class="fa fa-check"></i>
                                        </a>
                                        &nbsp
                                        @endif
                                        @if($ahc['resumeAllow'] == 1)
                                        <a href="{{ url('admin/client/resumeallow-client').'/'.$ahc['UserId'].'/2' }}" class="text-primary" title="Approve">
                                            <i class="fa fa-check"></i>
                                        </a>
                                        
                                        @endif
                                    </td>
                                </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Are you sure you want to Deactive this Client?</h4>

                                        </div>


                                        <div class="modal-footer">
                                        <a href="#" data-dismiss="modal"  class="btn btn-white" >No</a>
                                            <a href="#"  class="btn btn-primary mylink" id="url">Yes</a>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Signature</h4>

                                        </div>
                                        <div class="modal-body">
                                        <img src="#" alt="Signature" class="mylink1">
                                        </div>

                                        <div class="modal-footer">
                                        <a href="#" data-dismiss="modal"  class="btn btn-danger" >Close</a>
                                        </div>
                                        </form>
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
            ajax: '{!! route('UserPendingDataTable') !!}',
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
                        data: 'resign',
                        name: 'resign',

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
                    columns: [0,1,2,3,4,5,6]
                }
    },],
            "aaSorting": [],
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [7,8,9]
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
        function DeactiveUrl(Url)
        {

            $("a.mylink").attr("href", Url);
            $("#myModal5").modal('show');
        }
        function SignatureUrl(Url)
        {

            $("img.mylink1").attr("src", Url);
            $("#myModal6").modal('show');
        }
</script>
@endsection