@extends('admin.template.master')

@section('header-css')
    <link href="{{ url('public/inspinia/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ url('public/inspinia/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('main-content')

<!-- Breadcromb Row Start -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Report</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('client/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Report</strong>
            </li>
        </ol>
    </div>
</div>
<!-- End Breadcromb Row -->

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
            @foreach($ReportData as $ahc)

                        <div class="col-md-4">
                        <div>
                               Today's {{ $ahc['FranchiseeName'] }}
                            </div>
                            <div>
                                {{ $ahc['TotalCount'] }}
                            </div>

                 <table class="table table-striped table-bordered table-hover">
                     <thead>
                         <tr>
                             <th class="bg-success">Caller Name</th>
                             <th class="bg-success">Count</th>
                         </tr>
                     </thead>
                     <tbody>
                             @foreach($ahc['ArrCaller'] as $ac)
                             <tr>
                             <td>{{ $ac['CallerName'] }}</td>
                             <td>{{ $ac['UserCount'] }}</td>
                             </tr>
                            @endforeach
                     </tbody>
                 </table>

                        </div>


                     @endforeach
            </div>

        </div>


                    <div class="col-lg-6">
                        <div class="row">
                        @foreach($ReportDataMonth as $ahc)

                                <div class="col-md-4">
                                   <div>
                                      Current Month's {{ $ahc['FranchiseeName'] }}
                                   </div>
                                   <div>
                                       {{ $ahc['TotalCount'] }}
                                   </div>

                        <table  class="table table-striped table-bordered table-hover">
                            <thead >
                                <tr>
                                    <th class="bg-success">CallerName</th>
                                    <th class="bg-success">Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($ahc['ArrCaller'] as $ac)
                                    <tr>
                                    <td>{{ $ac['CallerName'] }}</td>
                                    <td>{{ $ac['UserCount'] }}</td>
                                    </tr>
                                   @endforeach
                            </tbody>
                        </table>
                        </div>

                            @endforeach
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
        $(document).ready(function(){
            // Show Data Table Datas

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