@extends('project_layout.project')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-10 offset-1">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Review Sales Request</h3>


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
                    <form action="{{url('pm-review-approve')}}" method="POST">
                        {{csrf_field()}}
                        <div class="card-body">
                            <input type="hidden" name="id" value="{{$sales->id}}">
                            <input type="hidden" name="old_project_files" value="{{$sales->project_requirement_files}}">
                            <div class="form-group">
                                <label for="inputName">Mall Name</label>
                                <input name="mall_name" class="form-control" value="{{$sales->mall_name}}" readonly>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Quotation Addressee</label>
                                        <input type="text" name="quotation_addressee" readonly class="form-control" value="{{$sales->quotation_addressee}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
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
                            <!-- Date
                            <div class="form-group">
                                <label>Date:</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>-->

                            <div class="form-group">
                                <label for="inputDescription">Remarks</label>
                                <textarea id="inputDescription" name="remarks" class="form-control" readonly rows="2">{{$sales->remarks}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Project Requirement Files</label>
                                <a class="form-control" target="_blank" href="{{asset('/images/project_requirements_files/'.$sales->project_requirement_files)}}"><i class="fas fa-file mr-2"></i>
                                    {{$sales->project_requirement_files}}
                                </a>
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
                                    <textarea id="inputDescription" name="pm_remarks" class="form-control" rows="2">{{$sales->pm_remarks}}</textarea>
                                </div>
                            </div>
                            <div id="show_pm">
                                <div class="form-group">
                                    <label for="remarks">Assign To: </label>
                                    <div class="col-sm-12">
                                        <select name='pm_assigned_id' class="form-control">
                                            <option readonly selected disabled> -- Choose --</option>
                                            <option value="Engineer1">Engineer1</option>
                                            <option value="Engineer2">Engineer2</option>
                                            <option value="Engineer3">Engineer3</option>
                                            <option value="Engineer4">Engineer4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <input type="submit" value="Submit">
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

    <!-- Select2 -->
    <script src="{{asset('backend/plugins/select2/js/select2.full.min.js')}}"></script>

    <!-- bs-custom-file-input -->
    <script src="{{asset('backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <!-- jquery-validation -->
    <script src="{{asset('backend/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('backend/plugins/jquery-validation/additional-methods.min.js')}}"></script>
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
