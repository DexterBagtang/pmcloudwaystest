@extends('project_layout.project')
@section('title')
    PhilCom | Malls
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-10 offset-1">

                    <!-- Horizontal Form -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Add Mall</h3>
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
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="quickForm" class="form-horizontal" method="POST" action="{{route('sales-malls-store')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Region</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="region" id="inputEmail3" placeholder="Region">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Mall Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="mall_name" id="inputPassword3" placeholder="Mall name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Mall Code</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="mall_code" id="inputPassword3" placeholder="Mall Code">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Mall Logo</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="mall_logo" id="inputPassword3" placeholder="Mall Logo">
                                                <label class="custom-file-label" for="exampleInputFile">Choose logo</label>
                                            </div>
                                        </div>
                                </div>



{{--                                <div class="form-group row">--}}
{{--                                    <div class="offset-sm-2 col-sm-10">--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input type="checkbox" class="form-check-input" id="exampleCheck2">--}}
{{--                                            <label class="form-check-label" for="exampleCheck2">Remember me</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">Submit</button>
{{--                                <button href="{{url('sales-malls')}}" class="btn btn-default float-right">Cancel</button>--}}
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')

    <!-- bs-custom-file-input -->
    <script src="{{asset('backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <!-- jquery-validation -->
    <script src="{{asset('backend/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('backend/plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <!-- Page specific script -->
    <script>
        $(function () {
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
