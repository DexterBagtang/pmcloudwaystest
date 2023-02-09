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
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form class="form-horizontal" method="POST" action="{{route('sales-malls-update')}}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$mall->id}}">
                            <input type="hidden" name="old_mall_logo" value="{{$mall->mall_logo}}">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Region</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="region" id="inputEmail3" value="{{$mall->region}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Mall Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="mall_name" id="inputPassword3" value="{{$mall->mall_name}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Mall Code</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="mall_code" id="inputPassword3" value="{{$mall->mall_code}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Mall Logo</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="mall_logo" id="inputPassword3" value="{{$mall->mall_logo}}">
                                            <label class="custom-file-label" for="exampleInputFile">{{$mall->mall_logo}}</label>
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
    <!-- Page specific script -->
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endsection
