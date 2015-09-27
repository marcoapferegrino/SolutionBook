<div class="row">
    <div class="col-md-5 col-md-offset-3">
        @if(Session::has('message'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Exitoso! : </strong> {{Session::get('message')}} <i class="fa fa-check fa-lg"></i>
            </div>
        @endif

        @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error :(  </strong> {{Session::get('error')}} <i class="fa fa-close fa-lg"></i>
            </div>
        @endif

    </div>
</div>
@if($errors->any())
    <div class="alert alert-danger" role="alert">
        <p>Por favor corrige tus errores:</p>
        <ul>
            @foreach($errors->all() as $error)

                <li> {{ $error }} </li>

            @endforeach
        </ul>
        @endif
    </div>