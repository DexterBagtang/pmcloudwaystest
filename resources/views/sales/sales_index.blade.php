@extends('project_layout.project')
@section('title')
    PhilCom | Sales Request
@endsection

@section('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('backend/plugins/toastr/toastr.min.css')}}">
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <a href="{{url('sales-sales-create')}}">
                                <h3 class="btn btn-outline-primary">Add Sales Request</h3>
                            </a>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
{{--                                    <th hidden>id</th>--}}
                                    <th>Mall Name</th>
                                    <th>Quotation Addressee</th>
                                    <th>Requester</th>
                                    <th>Project Title</th>
                                    <th>Proposal Date</th>
                                    <th>Date Requested</th>
                                    <th>Project Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($salesrequests as $salesrequest)
                                <tr>
{{--                                    <td hidden>{{$salesrequest->id}}</td>--}}
                                    <td>{{$salesrequest->mall_name}}</td>
                                    <td>{{$salesrequest->quotation_addressee}}</td>
                                    <td>{{$salesrequest->requester}}</td>
                                    <td>{{$salesrequest->project_title}}</td>
                                    <td>{{Carbon\Carbon::parse($salesrequest->date_needed)->format('d-M-Y')}}</td>
                                    <td>{{Carbon\Carbon::parse($salesrequest->created_at)->format('d-M-Y')}}</td>
                                    <td>{{$salesrequest->status}}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="{{url('sales-sales-edit-'.$salesrequest->id)}}">
                                            <i class="fas fa-pencil-alt"></i>
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Mall Name</th>
                                    <th>Quotation Addressee</th>
                                    <th>Requester</th>
                                    <th>Project Title</th>
                                    <th>Proposal Date</th>
                                    <th>Date Requested</th>
                                    <th>Project Status</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('backend/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

    <!-- Toastr -->
    <script src="{{asset('backend/plugins/toastr/toastr.min.js')}}"></script>

    <!-- Page specific script -->
    <script>
        $(function () {
            $("#example2").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>

    <script>
        @if(Session::has('message'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.success("{{ session('message') }}");
        @endif

            @if(Session::has('error'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.error("{{ session('error') }}");
        @endif

            @if(Session::has('info'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.info("{{ session('info') }}");
        @endif

            @if(Session::has('warning'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.warning("{{ session('warning') }}");
        @endif
    </script>
@endsection
