@extends('app')
@section('styles')
    {!! Html::style('css/dropzone.css') !!}

@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-info">
                    <div class="panel-heading">Agregar Solución para el problema {{$idProblem}} mi Id</div>

                    <div class="panel-body">
                        {!! Form::open([
                        'route' => 'solution.addSolution',
                        'method' => 'post',
                        'class'=>'dropzone',
                        'id'=>'my-dropzone',
                        'files'=>true]) !!}


                        {!! Form::hidden('idProblem',$idProblem,array('id' => 'idProblem')) !!}

                        <div class="form-group">
                            <h3><label for="language"><strong>Lenguaje</strong></label></h3>
                            {!!Form::select('language', config('optionsLanguages.lenguajes'),null,['class'=>'form-control'])!!}

                        </div>

                        <div class="form-group">
                            <h3><label for="explanation"><strong>Explicación</strong></label></h3>
                            {!! Form::textarea('explanation',null,array('id' => 'explanation','class'=>'form-control','placeholder'=>'Tu explicación debe ser clara y detallada...:D ')) !!}
                        </div>


                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Imágenes </h3>
                            </div>
                            <div class="panel-body">
                                <div class="dz-message">
                                    <blockquote>
                                        <p class="lead">Avienta tus archivos aquí</p>
                                        <footer>Dale en guardar cuando los agregues</footer>
                                    </blockquote>
                                </div>
                                <div class="dropzone-previews"></div> <!-- this is were the previews should be shown. -->
                            </div>
                        </div>


                        <button type="submit" class="btn btn-success btn-lg btn-block" id="submit-all">Guardar</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {!!Html::script('js/dropzone.js')!!}
    <script>
        Dropzone.options.myDropzone = {

            // Prevents Dropzone from uploading dropped files immediately
            autoProcessQueue: false,
            uploadMultiple: true, //process all files not individually
            maxFilesize: 3, //MB
            maxFiles: 5,
            parallelUploads: 4,
            acceptedFiles : "image/*,text/x-python-script,.c,.cpp,.class,.py,.pdf,.docx",
            paramName:'images',

            init: function() {
                var submitButton = document.querySelector("#submit-all")
                myDropzone = this; // closure


                submitButton.addEventListener("click", function (e) {
                    // alert("Presionaste el boton de submit");
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue(); // Tell Dropzone to process all queued files.
                    console.log('termine los archivos');
                });
                this.on("addedfile", function(file) {

                    // Create the remove button
                    var removeButton = Dropzone.createElement("<button type='button' class='btn btn-warning btn-sm'>Quitar</button>");


                    // Capture the Dropzone instance as closure.
                    var _this = this;

                    // Listen to the click event
                    removeButton.addEventListener("click", function(e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();

                        // Remove the file preview.
                        _this.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                    });

                    // Add the button to the file preview element.
                    file.previewElement.appendChild(removeButton);
                });


                // of the sending event because uploadMultiple is set to true.
                this.on("sendingmultiple", function() {
                    //alert ("Me estoy enviando");
                    console.log('Enviando multiple');
                });

                this.on("successmultiple", function(files, response) {
                    // alert("todo fue exitoso");
                    console.log('Exitoso multiple');
                    /* $('#email').text(response.email).removeClass("hide");
                     $('#name').text(response.name).removeClass("hide");*/

                });

                this.on("errormultiple", function(files, response) {
                    console.log(response);
                });

            }
        };


    </script>

@endsection
