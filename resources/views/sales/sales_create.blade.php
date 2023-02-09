@extends('project_layout.project')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-10 offset-1">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">New Sales Request</h3>


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
                    <form action="{{url('sales-sales-store')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Mall Name</label>
                                <select class="form-control select2" name="mall_id" data-dropdown-css-class="select2" style="width: 100%;" required>
                                    <option value="{{null}}">Choose Mall</option>
                                    @foreach($malls as $mall)
                                        <option value="{{$mall->id}}">{{$mall->mall_name}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Quotation Addressee</label>
                                        <input type="text" name="quotation_addressee" class="form-control" required placeholder="Enter ...">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Requester</label>
                                        <input type="text"  name="requester" class="form-control" required placeholder="Enter ...">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Project Title</label>
                                <textarea id="inputDescription" name="project_title" class="form-control" required rows="3"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Proposal Target Date</label>
                                        <input type="date" name="date_needed" class="form-control" required placeholder="Enter ...">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select id="" name="category" class="form-control custom-select" required>
                                            <option selected disabled value="{{null}}">Select one</option>
                                            <option value="small">Small</option>
                                            <option value="medium">Medium</option>
                                            <option value="large">Large</option>
                                            <option value="special">Special</option>
                                        </select>
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
                                <textarea id="inputDescription" name="remarks" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword3" >Project Requirement Files</label>
                                <div class="col-sm-12">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="project_requirement_files" id="inputPassword3" required placeholder="Mall Logo">
                                        <label class="custom-file-label" for="exampleInputFile">Upload Project Require Files</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Create new Project" class="btn btn-success float-left">
                            </div>

                        </div>
                    </form>
                    <!-- /.card-body -->
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
@endsection
