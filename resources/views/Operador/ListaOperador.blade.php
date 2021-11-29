@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>OPERADORES</h2>
    </div>
    <div class="col-lg-6">

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(Session::has('success'))
        <div class="alert alert-info">
            {{Session::get('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="row">
                    <div class="col-lg-8">
                        <a href="#Nuevo" data-toggle="modal" class="config"><button class='btn btn-primary dim'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo Operador</button></a>
                        <button type="button" class="btn btn-secondary">
                            <span id="total" class="badge bg-warning">{{$cantidad}}</span> Operadores Registrados
                        </button>
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table id="datatableoperador" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#343a40;color:#D0D3D4;text-align:center">
                                <tr>
                                    <th width=5%>Nª</th>
                                    <th>NOMBRE(S)</th>
                                    <th>APELLIDOS</th>
                                    <th>CARGO</th>
                                    <th width="12%">Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($operador as $operadores)
                                <tr class="gradeC">
                                    <td align="center"><?php echo $i++; ?></td>
                                    <td style="text-align: center;">{{$operadores->nombre}}</td>
                                    <td style="text-align: center;">{{$operadores->apellidopat}} {{$operadores->apellidomat}}</td>
                                    <td style="text-align: center;">{{$operadores->cargo}}</td>
                                    <td style="text-align: center;">
                                        <button class="btn btn-primary" type="button" onclick="Editar('{{$operadores->id}}');"><i class="glyphicon glyphicon-pencil"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')
<div class="modal fade" id="Nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">NUEVO OPERADOR</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{('crearoperador')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-8 col-md-6 col-sm-12">
                            <strong>NOMBRES</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" name="nombre" class='form-control' required>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <strong>APELLIDO PATERNO</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" name="apellidopat" class='form-control' required>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <strong>APELLIDO MATERNO</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" name="apellidomat" class='form-control' required>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <strong>CARGO</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" name="cargo" class='form-control' required>
                        </div>
            
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Registrar">
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="Editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">EDITAR OPERADOR</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{('mostraroperadores')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <strong>NOMBRES</strong><strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" id="nombre" name="nombre" class='form-control' required>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <strong>APELLIDO PATERNO</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" id="apellidopat" name="apellidopat" class='form-control' required>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <strong>APELLIDO MATERNO</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" id="apellidomat" name="apellidomat" class='form-control' required>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <strong>CARGO</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" id="cargo" name="cargo" class='form-control' required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <input hidden id="id" name="id" type="text">
                        <div class="col-lg-12">
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Registrar">
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

@section('js')

<script>
    function mayus(e) {
        e.value = e.value.toUpperCase();
    }

</script>

<script>

$(document).ready( function () {
        $('#datatableoperador').DataTable({
            responsive: true,
      "order": [[ 0, 'asc']],
      "language": {
        "bDeferRender": true,
        "sEmtpyTable": "No existen registros",
        "decimal": ",",
        "thousands": ".",
        "lengthMenu": "Mostrar _MENU_ datos por registros",
        "zeroRecords": "No se encontraron coincidencias",
        "info": "Pàgina _PAGE_ de _PAGES_",
        "infoEmpty": "No existen Bienes",
        "search": "Buscar ",
        "infoFiltered": "(Busqueda de _MAX_ registros en total)",
        "oPaginate":{
          "sLast":"Final",
          "sFirst":"Principio",
          "sNext":"Siguiente",
          "sPrevious":"Anterior"
        }
      },
      dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            {extend: 'csv'},
            {extend: 'excel', title: 'ListaExcel'},
            {extend: 'pdf', title: 'ListaPDF'},

            {extend: 'print',
             customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            }
            }
        ]
    });
    } );

    function Editar(id) {
         url = '{{ asset("/index.php/editaroperador")}}/' + id;
         $.getJSON(url, null, function(data) {
             if (data.length > 0) {
 
                 $.each(data, function(field, e) {
                     $('#id').val(e.id);
                     $('#nombre').val(e.nombre);
                     $('#apellidopat').val(e.apellidopat);
                     $('#apellidomat').val(e.apellidomat);
                     $('#cargo').val(e.cargo);
                 });
                 $("#Editar").modal('show');
             }
         });
     }
 </script>


@endsection