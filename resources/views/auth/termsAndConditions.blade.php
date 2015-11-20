@extends('app')

@section('content')
    <div class="container">

        @include('partials.messages')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-success">
                    <div class="panel-heading"><h4>Términos de Solution Book</h4></div>

                    <div class="panel-body">
                        {!! Form::open([
                        'route' => 'account.termsConditions',
                        'method' => 'get',
                        'class'=>'form-horizontal'])
                        !!}

                        <input type="text" value="{{$nombre}}"  name="nombre" hidden>

                        <input type="text" value="{{$correo}}"  name="correo" hidden>

                        <input type="text" value="{{$avatar}}"  name="avatar" hidden>

                        <div class="form-group ">
                            <div class="row"><center><img width="120px" src="{{ asset('/oie_transparent.png') }}"></center></div>

                            <div class="col-sm-10 col-sm-offset-1">
                                <h4>
                                    Para registrarte a Solution Book debes aceptar los siguientes puntos:
                                </h4>
                            <blockquote data-spy="scroll" style="overflow-y: scroll; max-height:200px;" >
                                <h4>
                                    <b>
                                        Al acceder y utilizar este servicio, usted acepta y accede a estar obligado por los términos y disposiciones de este acuerdo. Toda participación en este servicio constituirá la aceptación de este acuerdo. Si no acepta cumplir con lo anterior, por favor, no lo utilice.
                                    </b><br><br>
                                <ul>
                                    <li>
                                        Esta página y sus componentes se ofrecen únicamente con fines informativos; esta página no se hace responsable de la exactitud, utilidad o disponibilidad de cualquier información que se transmita o ponga a disposición a través de la misma; no será responsable por cualquier error u omisión en dicha información
                                    </li>
                                    <li>
                                        Al registrar una solución todo el contenido estará disponible para visualizar o descargar en nuestro sitio, se podrá editar y borrar dicha solución solo si tú la creaste, al borrar la solución se borrará toda la información y archivos de código e imágenes.
                                    </li>
                                    <li>
                                        AMONESTACIONES.- Los problemas y las soluciones pueden ser amonestadas por otros usuarios de acuerdo a los siguientes puntos:
                                <ul>
                                    <li>
                                       Código copiado
                                    </li>
                                    <li>
                                        Código fraude
                                    </li>
                                    <li>
                                       Contenido inapropiado
                                    </li>
                                    <li>
                                        Problema repetido (solo a problemas)
                                    </li>
                                    </ul>
                                        Al ser amonestados tus problemas o soluciones tendrás únicamente 14 días para resolver la situación, en dado caso de que se llegue al límite de tiempo será responsabilidad del administrador borrar la solución o bloquear al usuario.
                                    </li>
                                    <li>
                                        RANKEO.- Todo usuario con soluciones  será parte del ranking del sitio, este ranking se tomara a partir del número de soluciones y los likes que tengan dichas soluciones.
                                    </li>
                                        <li>Cuando un usuario Problem setter borre un problema el usuario pierde la propiedad sobre el mismo y pasará a propiedad del sistema.

                                            </li>
                                        <li>
                                            Si un usuario Solver da de baja su perfil sus soluciones se seguirán mostrando con su autoría.

                                        </li>
                                        <li>
                                            Si un usuario Problem setter da de baja su perfil los problemas pasarán a ser autoria del sistema.
                                        </li>
                                    </ul>
                                </h4>
                            </blockquote>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">
                                <button type=button onClick="parent.location='/home'" class="btn form-control btn-primary" >No gracias</button>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-4">
                                {!!Form::submit('He leído y acepto los términos y condiciones',['class'=>'form-control btn-warning'])!!}
                            </div>
                            <div class="col-sm-1"></div>
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
