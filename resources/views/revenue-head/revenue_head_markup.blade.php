@extends('project_layout.project')

@section('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('title')
    Purchasing
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-10 offset-1">
                <div class="card card-cyan">
                    <div class="card-header">
                        <h3 class="card-title">Project for Bidding</h3>


                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{url('revenue-head-marked')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="card-body">
                            <input type="hidden" name="id" value="{{$sales->id}}">
                            <input type="hidden" name="old_project_files" value="{{$sales->project_requirement_files}}">

                            <div class="form-group">
                                <label for="inputName" class="text-primary"><i class="fas fa-check-circle text-primary"></i> Bidders Uploaded by Purchasing ! </label>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputName">Mall Name</label>
                                        <input name="mall_name" class="form-control " value="{{$sales->mall_name}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Quotation Addressee</label>
                                        <input type="text" name="quotation_addressee" readonly class="form-control" value="{{$sales->quotation_addressee}}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Requester</label>
                                        <input type="text"  name="requester" class="form-control" value="{{$sales->requester}}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Project Title</label>
                                <textarea id="inputDescription" name="project_title" class="form-control" readonly rows="3">{{$sales->project_title}}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Proposal Target Date</label>
                                        <input type="date" name="date_needed" class="form-control" value="{{$sales->date_needed}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <input type="text" name="category" class="form-control"  readonly value="{{$sales->category}}">
                                    </div>
                                </div>
                            </div>
                            {{--                            Date--}}
                            {{--                            <div class="form-group">--}}
                            {{--                                <label>Date:</label>--}}
                            {{--                                <div class="input-group date" id="reservationdate" data-target-input="nearest">--}}
                            {{--                                    <input type="date" class="form-control datetimepicker-input" data-target="#reservationdate"/>--}}
                            {{--                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">--}}
                            {{--                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            @if($sales->remarks != null)
                                <div class="form-group">
                                    <label for="inputDescription">Remarks</label>
                                    <textarea id="inputDescription" name="remarks" class="form-control" readonly rows="2">{{$sales->remarks}}</textarea>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="inputDescription">Project Requirement Files</label>
                                <a class="form-control" target="_blank|_top" readonly href="{{asset('/images/project_requirements_files/'.$sales->project_requirement_files)}}"><i class="fas fa-file mr-2"></i>
                                    {{$sales->project_requirement_files}}
                                </a>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputDescription">Uploaded Single-Line Diagram </label>
                                        <div class="form-group">
                                            @foreach($data_sld as $sld)
                                                <a class="form-control overflow-hidden" readonly="" target="_blank" href="{{asset('/files/sld/'.$sld)}}"><i class="fas fa-file mr-2"></i>
                                                    {{$sld}}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputDescription">Uploaded Bill of Quantities </label>
                                        <div class="form-group">
                                            @foreach($data_bof as $bof)
                                                <a class="form-control overflow-hidden" readonly="" target="_blank" href="{{asset('/files/bof/'.$bof)}}"><i class="fas fa-file mr-2"></i>
                                                    {{$bof}}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputDescription">Upload Layout </label>
                                        <div class="form-group">
                                            @foreach($data_layout as $layout)
                                                <a class="form-control overflow-hidden" readonly="" target="_blank" href="{{asset('/files/layout/'.$layout)}}"><i class="fas fa-file mr-2"></i>
                                                    {{$layout}}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr>


                            {{--                            <div class="form-group">--}}
                            {{--                                <label for="inputDescription">Bidders</label>--}}
                            {{--                                <table id="example1" class="table table-bordered table-hover">--}}
                            {{--                                    <thead class="bg-gradient-primary">--}}
                            {{--                                    <tr>--}}
                            {{--                                        <th>Trade</th>--}}
                            {{--                                        <th>Contractor Name</th>--}}
                            {{--                                        <th>Total Cost</th>--}}
                            {{--                                        <th></th>--}}
                            {{--                                    </tr>--}}
                            {{--                                    </thead>--}}
                            {{--                                    <tbody class="increment5">--}}
                            {{--                                    <tr>--}}
                            {{--                                        <td><input type="text" name="trade[]" class="form-control" required></td>--}}
                            {{--                                        <td><input type="text" name="contractor_name[]" class="form-control" required></td>--}}
                            {{--                                        <td><input type="number" name="total_cost[]" class="form-control" required></td>--}}
                            {{--                                        <td><span class="btn btn-primary"><i class="fa fa-plus-square"></i></span></td>--}}
                            {{--                                    </tr>--}}
                            {{--                                    </tbody>--}}
                            {{--                                    <tbody class="clone5 d-none">--}}
                            {{--                                    <tr class="trclone">--}}
                            {{--                                        <td><input type="text" name="trade[]" class="form-control"></td>--}}
                            {{--                                        <td><input type="text" name="contractor_name[]" class="form-control"></td>--}}
                            {{--                                        <td><input type="number" name="total_cost[]" class="form-control"></td>--}}
                            {{--                                        <td><span class="btn btn-danger"><i class="fa fa-trash-alt"></i></span></td>--}}
                            {{--                                    </tr>--}}
                            {{--                                    </tbody>--}}

                            {{--                                </table>--}}
                            {{--                            </div>--}}

                            <div class="form-group">
                                <label for="inputDescription">Bid Winner</label>
                                <table class="table table-bordered table-hover">
                                    <thead class="bg-gradient-primary">
                                    <tr>
                                        <th>Trade</th>
                                        <th>Contractor Name</th>
                                        <th>Total Cost</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody class="increment5">
                                    @foreach($bidders as $bidder)
                                        <tr>
                                            <td>{{$bidder->trade}}</td>
                                            <td>{{$bidder->contractor_name}}</td>
                                            <td>{{$bidder->total_cost}}</td>
                                            <td>
                                                <input class="form-control" type="checkbox" checked >
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>

                            {{--                            <div class="form-group">--}}
                            {{--                                <label for="inputPassword3" >Upload Bid File</label>--}}
                            {{--                                <div class="col-sm-12">--}}
                            {{--                                    <div class="custom-file">--}}
                            {{--                                        <input type="file" class="custom-file-input" name="bid_file" id="inputPassword3" required placeholder="Mall Logo">--}}
                            {{--                                        <label class="custom-file-label" for="exampleInputFile">Bid File</label>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputDescription">Bid File</label>
                                        <a class="form-control" target="_blank|_top" readonly href="{{asset('/files/bidfiles/'.$sales->bid_file)}}"><i class="fas fa-file mr-2"></i>
                                            {{$sales->bid_file}}
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputDescription">Proposal File</label>
                                        <a class="form-control" target="_blank|_top" readonly href="{{asset('/files/proposal_files/'.$sales->proposal_files)}}"><i class="fas fa-file mr-2"></i>
                                            {{$sales->proposal_files}}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-inline">
                                <label for="remarks" class="mr-2">Approve:</label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="status" value="Yes"
                                           onclick="yesnoCheck();"
                                           id="yesCheck">
                                    <label class="form-check-label mr-1"> Yes </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="status" value="No"
                                           onclick="yesnoCheck();"
                                           id="noCheck">
                                    <label class="form-check-label mr-1"> No </label>
                                </div>
                            </div>
                            <br>
                            <div id="show_remark">
                                <div class="form-group">
                                    <label for="inputDescription">Remarks</label>
                                    <textarea id="inputDescription" name="pm_bidders_remarks" class="form-control" rows="2" ></textarea>
                                </div>
                            </div>
                            <div id="show_pm" >
                                    <div class="form-group">
                                        <label for="inputPassword3" >P&L File</label>
                                        <div class="col-sm-12">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="pnl_file" id="inputPassword3">
                                                <label class="custom-file-label" for="exampleInputFile">Upload P&L File</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            {{--                                <div class="col-sm-6">--}}
                            {{--                                    <div class="form-group">--}}
                            {{--                                        <label>Project Size</label>--}}
                            {{--                                        <select name="project_size" class="form-control custom-select" required>--}}
                            {{--                                            <option selected disabled value="{{null}}">Select one</option>--}}
                            {{--                                            <option value="small">Small</option>--}}
                            {{--                                            <option value="big">Big</option>--}}
                            {{--                                        </select>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}

                            {{--                            </div>--}}






                            {{--                            <div class="form-inline">--}}
                            {{--                                <label for="remarks" class="mr-2">Approve:</label>--}}
                            {{--                                <div class="form-check">--}}
                            {{--                                    <input type="radio" class="form-check-input" name="status" value="Yes"--}}
                            {{--                                           onclick="yesnoCheck();"--}}
                            {{--                                           id="yesCheck">--}}
                            {{--                                    <label class="form-check-label mr-1"> Yes </label>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="form-check">--}}
                            {{--                                    <input type="radio" class="form-check-input" name="status" value="No"--}}
                            {{--                                           onclick="yesnoCheck();"--}}
                            {{--                                           id="noCheck">--}}
                            {{--                                    <label class="form-check-label mr-1"> No </label>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <br>--}}
                            {{--                            <div id="show_remark">--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <label for="inputDescription">Remarks</label>--}}
                            {{--                                    <textarea id="inputDescription" name="pm_design_remarks" class="form-control" rows="2">{{$sales->remarks}}</textarea>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}



                            <div class="form-group">
                                <input type="submit" class="btn btn-outline-primary" value="Submit">
                            </div>

                        </div>
                        <!-- /.card-body -->

                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
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

    <!-- Select2 -->
    <script src="{{asset('backend/plugins/select2/js/select2.full.min.js')}}"></script>

    <!-- bs-custom-file-input -->
    <script src="{{asset('backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <!-- jquery-validation -->
    <script src="{{asset('backend/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('backend/plugins/jquery-validation/additional-methods.min.js')}}"></script>

    <script src="{{asset('backend/plugins/dropzone/min/dropzone.min.js')}}"></script>
    <!-- Page specific script -->


    <script>
        $(function () {
            //Initialize Select2 Elements
            // $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            bsCustomFileInput.init();
        });


    </script>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

    <script>
        $(function () {
            $('#example1').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });
    </script>

    <script type="text/javascript">

        $(document).ready(function() {

            $(".primary").click(function(){
                var html = $(".clone").html();
                $(".increment").after(html);
            });

            $("body").on("click",".secondary",function(){
                $(this).parents(".input-group").remove();
            });

        });

        $(document).ready(function() {

            $(".primary3").click(function(){
                var html = $(".clone3").html();
                $(".increment3").after(html);
            });

            $("body").on("click",".secondary3",function(){
                $(this).parents(".tertiary").remove();
            });

        });

        $(document).ready(function() {

            $(".primary2").click(function(){
                var html = $(".clone2").html();
                $(".increment2").after(html);
            });

            $("body").on("click",".secondary2",function(){
                $(this).parents(".danger").remove();
            });

        });

        $(document).ready(function() {

            $(".btn-primary").click(function(){
                var html = $(".clone5").html();
                $(".increment5").after(html);
            });

            $("body").on("click",".btn-danger",function(){
                $(this).parents(".trclone").remove();
            });

        });

    </script>

    <script>
        $(function () {
            // $.validator.setDefaults({
            //     submitHandler: function () {
            //         alert( "Form successful submitted!" );
            //     }
            // });
            $('#quickForm').validate({
                rules: {
                    region: {
                        required: true,
                    },
                    mall_name: {
                        required: true,
                    },
                    mall_code: {
                        required: true
                    },
                },
                messages: {
                    region: {
                        required: "Please provide a Region",
                    },
                    mall_name: {
                        required: "Please provide a Mall Name",
                    },
                    mall_code:{
                    }, required: "Please enter a Mall Code"
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });

    </script>

    <script type="text/javascript">
        document.getElementById('show_remark').style.display = 'none';
        document.getElementById('show_pm').style.display = 'none';

        function yesnoCheck() {
            if (document.getElementById('yesCheck').checked) {
                document.getElementById('show_remark').style.display = 'none';
                document.getElementById('show_pm').style.display = 'block';
                document.getElementById('remarks').required = false;
            } else {
                document.getElementById('show_remark').style.display = 'block';
                document.getElementById('show_pm').style.display = 'none';
                document.getElementById('remarks').required = true;

            }

        }

    </script>
@endsection
