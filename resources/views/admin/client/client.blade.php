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
                                    <th>Name</th>
                                    <th>User Registration Id</th>
                                    <th>User Address</th>
                                    <th>Password</th>
                                    <th>Moblie Number</th>
                                    <th>Email</th>
                                    <th>Plan</th>
                                    <th>Franchisee</th>
                                    <th>Caller</th>
                                    <th>Submited Resumes</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Ip Address</th>
                                    <th style="min-width: 90px;">Resend Mail</th>
                                    <th style="min-width: 90px;">Resend SMS</th>
                                    <th>User Signature</th>
                                    <th>Remark</th>
                                    <th style="min-width: 90px;">Action</th>
                                    <!-- <th width="60px">Action</th> -->
                                </tr>
                            </thead>
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
                            <div class="modal inmodal fade" id="Remark" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h2>Enter Your Remark</h2>

                                        </div>
                                        <div class="model-body">
                                                <form method="post" enctype="multipart/form-data"   action="{{ url('admin/remark/add-remark') }}">
                                                <input type="text" id="RemarkId" name="RemarkId" value="" hidden>
                                                <textarea class="form-control" id="RemarkText" name="RemarkText">Enter Your Remark</textarea>
                                                <br>
                                                <div class="form-control text-center">
                                                <button type="submit"  class="btn btn-primary mylink" >Submit</button>
                                                </div>
                                                
                                                </form>
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
        $('#startDateRange').daterangepicker({
            opens: 'left',
            maxDate: new Date()
        });
        $('#endDateRange').daterangepicker({
            opens: 'left',
            maxDate: new Date()
        });
        // Show Data Table Datas
       var oTable = $('#healthConditionDatatable').DataTable({
            proccessing: true,
            serverSide: true,
            ajax: {
          url: "{{ route('AddUserDataTable') }}",
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
                        data: 'UserAddress',
                        name: 'UserAddress',
                        searchable: false
                    },
                    {
                        data: 'ResendPassword',
                        name: 'ResendPassword',
                        searchable: false
                    },
                    {
                        data: 'UserMoblieNumber',
                        name: 'UserMoblieNumber',
                        searchable: false
                    },
                    {
                        data: 'UserEmail',
                        name: 'UserEmail',
                    },
                    {
                        data: 'PlanName',
                        name: 'PlanName',
                        searchable: false
                    },
                    {
                        data: 'FranchiseeName',
                        name: 'FranchiseeName',
                        searchable: false
                    },
                    {
                        data: 'CallerName',
                        name: 'CallerName',
                        searchable: false

                    },
                    {
                        data: 'resume_allow',
                        name: 'resume_allow',
                        searchable: false
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
                        data: 'UserIpAddress',
                        name: 'UserIpAddress',
                        searchable: false
                    },
                    {
                        data: 'resendmail',
                        name: 'resendmail',
                        searchable: false

                    },
                    {
                        data: 'resendsms',
                        name: 'resendsms',
                        searchable: false

                    },
                    {
                        data: 'UserSignature',
                        name: 'UserSignature',
                        searchable: false
                    },
                    {
                        data: 'remark',
                        name: 'remark',
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false
                    },
                ],
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [ {
    extend: 'excel',
    exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13]
                }
    },],
            "aaSorting": [],
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [13,14,15,16,17,18]
            }],
        });
           $('#healthConditionDatatable_filter input').unbind();
            $('#healthConditionDatatable_filter input').bind('keyup', function(e) { 
                if (e.keyCode == 13) {    
                    oTable.search(this.value).draw();
                }
            });
            $("#dateRange").click(function(){
       var urlpath = url('admin/client/approve');
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


            $("#myModal5").modal('show');
            $("a.mylink").attr("href", Url);
        }
        function Remark(id)
        {
            var data = id;
            $("#RemarkId").val(data);
            $("#Remark").modal('show');
            
        }
</script>
@endsection