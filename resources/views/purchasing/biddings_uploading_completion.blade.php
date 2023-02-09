@extends('project_layout.project')



@section('title')
    Assigned PM
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-10 offset-1">
                <div class="card card-gray">
                    <div class="card-header">
                        <h3 class="card-title">Project for Designing</h3>


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
                    <form action="{{url('bidding-uploaded')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="card-body">
                            <input type="hidden" name="id" value="{{$sales->id}}">
                            <input type="hidden" name="old_project_files" value="{{$sales->project_requirement_files}}">

                            <div class="form-group">
                                <label for="inputName"><i class="fas fa-check-circle"></i> Approved Project ! </label>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputName">Mall Name</label>
                                        <input name="mall_name" class="form-control" value="{{$sales->mall_name}}" readonly>
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

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputDescription">Uploaded CER Files</label>
                                        @foreach(json_decode($sales->cer_files) as $cer)
                                            <a class="form-control btn-outline-info" target="_blank" href="{{asset('/files/project_completion/'.$cer)}}"><i class="fas fa-file mr-2"></i>
                                                {{$cer}}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputDescription">Uploaded COPA Files</label>
                                        @foreach(json_decode($sales->first_copa) as $copa)
                                            <a class="form-control btn-outline-info" target="_blank" href="{{asset('/files/project_completion/'.$copa)}}"><i class="fas fa-file mr-2"></i>
                                                {{$copa}}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputDescription">Uploaded COCA Files</label>
                                        @foreach(json_decode($sales->coca) as $coca)
                                            <a class="form-control btn-outline-info" target="_blank" href="{{asset('/files/project_completion/'.$coca)}}"><i class="fas fa-file mr-2"></i>
                                                {{$coca}}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                            </div>




                            {{--                            <div class="form-inline increment" >--}}
                            {{--                                <input type="file" name="filename[]" class="form-control">--}}
                            {{--                                <div class="input-group-btn">--}}
                            {{--                                    <button class="btn btn-success" type="button">Add</button>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="clone d-none">--}}
                            {{--                                <div class="form-inline" style="margin-top:10px">--}}
                            {{--                                    <input type="file" name="filename[]" class="form-control">--}}
                            {{--                                    <div class="input-group-btn">--}}
                            {{--                                        <button class="btn btn-danger" type="button"> Remove</button>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputDescription">Contractor NTP</label>
                                        <div class="input-group mb-3 increment">
                                            <input type="file" name="ntp[]" class="form-control" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text primary"><i class="fas fa-plus"></i></span>
                                            </div>
                                        </div>
                                        <div class="clone d-none">
                                            <div class="input-group mb-3">
                                                <input type="file" name="ntp[]" class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text secondary"><i class="fas fa-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputDescription">Contractor PO</label>
                                        <div class="input-group mb-3 increment3">
                                            <input type="file" name="po[]" class="form-control" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text primary3"><i class="fas fa-plus"></i></span>
                                            </div>
                                        </div>
                                        <div class="clone3 d-none">
                                            <div class="input-group mb-3 tertiary" >
                                                <input type="file" name="po[]" class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text secondary3"><i class="fas fa-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="inputDescription">CARI</label>
                                        <div class="input-group mb-3 increment2">
                                            <input type="file" name="cari[]" class="form-control" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text primary2"><i class="fas fa-plus"></i></span>
                                            </div>
                                        </div>
                                        <div class="clone2 d-none">
                                            <div class="input-group mb-3 danger">
                                                <input type="file" name="cari[]" class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text secondary2"><i class="fas fa-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


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



        // $(document).ready(function() {
        //
        //     $("#plus").click(function(){
        //         var html = $(".clone2").html();
        //         $(".increment2").after(html);
        //     });
        //
        //     $("body").on("click","#minus",function(){
        //         $(this).parents(".input-group-text").remove();
        //     });
        //
        // });

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

        // // DropzoneJS Demo Code Start
        // Dropzone.autoDiscover = false
        //
        // // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        // var previewNode = document.querySelector("#template")
        // previewNode.id = ""
        // var previewTemplate = previewNode.parentNode.innerHTML
        // previewNode.parentNode.removeChild(previewNode)
        //
        // var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
        //     url: "/target-url", // Set the url
        //     thumbnailWidth: 80,
        //     thumbnailHeight: 80,
        //     parallelUploads: 20,
        //     previewTemplate: previewTemplate,
        //     autoQueue: false, // Make sure the files aren't queued until manually added
        //     previewsContainer: "#previews", // Define the container to display the previews
        //     clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        // })
        //
        // myDropzone.on("addedfile", function(file) {
        //     // Hookup the start button
        //     file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
        // })
        //
        // // Update the total progress bar
        // myDropzone.on("totaluploadprogress", function(progress) {
        //     document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        // })
        //
        // myDropzone.on("sending", function(file) {
        //     // Show the total progress bar when upload starts
        //     document.querySelector("#total-progress").style.opacity = "1"
        //     // And disable the start button
        //     file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        // })
        //
        // // Hide the total progress bar when nothing's uploading anymore
        // myDropzone.on("queuecomplete", function(progress) {
        //     document.querySelector("#total-progress").style.opacity = "0"
        // })
        //
        // // Setup the buttons for all transfers
        // // The "add files" button doesn't need to be setup because the config
        // // `clickable` has already been specified.
        // document.querySelector("#actions .start").onclick = function() {
        //     myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        // }
        // document.querySelector("#actions .cancel").onclick = function() {
        //     myDropzone.removeAllFiles(true)
        // }
        // DropzoneJS Demo Code End
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
