<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <!-- <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"> -->
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            body {
  padding : 10px ;
  
}

#exTab1 .tab-content {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}

#exTab2 h3 {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}

/* remove border radius for the tab */

#exTab1 .nav-pills > li > a {
  border-radius: 0;
}

/* change border radius for the tab , apply corners on top*/

#exTab3 .nav-pills > li > a {
  border-radius: 4px 4px 0 0 ;
}

#exTab3 .tab-content {
  color : white;
  background-color: #428bca;
  padding : 5px 15px;
}
        </style>
    </head>
    <body>
        <div class="container">
            <h1 class="text-center"> Panel de control</h1>
        </div>
        <div id="exTab1" class="container"> 
            <ul  class="nav nav-pills">
                <li class="active">
                    <a  href="#materias" data-toggle="tab">Materias</a>
                </li>
                <li>
                    <a href="#alumnos" data-toggle="tab">Alumnos</a>
                </li>
                <li>
                    <a href="#calificaciones" data-toggle="tab">Calificaciones</a>
                </li>
            </ul>

            <div class="tab-content clearfix">
                <div class="tab-pane active" id="materias">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                              <th scope="col">Nombre</th>
                              <th scope="col">Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materias as $materia)
                                <tr class="text-center">
                                  <td>{{$materia->nombre}}</td>
                                  <td>{{$materia->activo}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="alumnos">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Estatus</th>
                                <th scope="col">No. Materias</th>
                                <th scope="col">Promedio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumnos_promedio as $alumno_promedio)
                                <tr class="text-center">
                                    <td>{{$alumno_promedio['nombre']}}</td>
                                    <td>{{$alumno_promedio['apellido']}}</td>
                                    <td>{{$alumno_promedio['estatus']}}</td>
                                    <td>{{$alumno_promedio['num_materias']}}</td>
                                    <td>{{$alumno_promedio['promedio']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="calificaciones">
                    @foreach($array_materias as $key => $array_materia)
                    <h3>{{$key}}</h3>
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Materia</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Calificación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($array_materia as $alumno_materia)
                                <tr class="text-center">
                                  <td>{{$alumno_materia['nombre']}}</td>
                                  <td>{{$alumno_materia['apellido']}}</td>
                                  <td>{{$alumno_materia['calificacion']}}</td>
                                  <td>{{$alumno_materia['fecha']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endforeach
                </div>
            </div>
        </div>
    </body>
</html>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>