@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6" >
        <h4>INVENTARIO DE ARTICULOS</h4>
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
                        <button type="button" class="btn btn-secondary">
                            <span id="total" class="badge bg-primary">{{$cantidad}}</span> Cantidad de Articulos
                        </button>
                        <a href="#PorFecha" data-toggle="modal" class="config"><button class='btn btn-outline-primary'><span class="fa fa-calendar" aria-hidden="true"></span> Por Fecha</button></a> 
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="inventariodetallado" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#3c46d3;color:#ffffff;text-align:center">
                                <tr>
                                    <th width="5%">Nª</th>
                                    <th width="15%">CODIGO</th>
                                    <th>ARTICULO</th>                            
                                    <th width="10%">CANTIDAD</th>
                                    <th width="10%">UNIDAD</th>
                                    <th width="10%">COSTO</th>
                                    <th width="10%">SALDO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($articulos as $articulo)
                                <tr class="gradeC">
                                    <td style="text-align: center;"><?php echo $i++; ?></td>
                                    <td style="text-align: center;">{{$articulo->codigo_empresa}}</td>
                                    <td style="text-align: center;">
                                        <b><a href="{{'mostrararticuloproductosf/'.$articulo->id}}" title="Ver Kardex del Producto">
                                            <span style="color:blue" >{{$articulo->nombre_bien}} {{$articulo->nombre}} {{$articulo->marca}}</span></a></b></td>
                                    <td style="text-align: center;">{{$articulo->cantidad}}</td>
                                    <td style="text-align: center;">{{$articulo->unidad}}(s)</td>
                                    <td style="text-align: right;">{{number_format($articulo->costo,2)}}</td>
                                    <td style="text-align: right;">{{number_format($articulo->saldo_articulo,2)}}</td>
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
<div class="modal fade" id="PorFecha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">FECHAS</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{url('mostrararticuloporfechasf')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-3">
                            <strong>HASTA FECHA</strong>
                            <input onkeyup="mayus(this);" type="date" name="ff" value="{{date('Y-m-d')}}" class='form-control' required>
                        </div>
                    </div>
                        
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Ver Reporte">
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
    $(document).ready( function () {
        $('#inventariodetallado').DataTable({
            
      dom: '<"html5buttons"B>lfgtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>',
                title: 'Lista de Articulos',
                titleAttr: 'Exportar a excel',
            },
            {
                extend: 'pdfHtml5',
                text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>',
                title: 'Lista de Articulos',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger'
            },
            {
                extend: 'print',
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>',
                title: 'Lista de Articulos',
                titleAttr: 'Imprimir',
                class: 'btn btn-info',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '15pt');
                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                }
            },
        ],
      "language": {
        "bDeferRender": true,
        "sEmtpyTable": "No existen registros",
        "decimal": ",",
        "thousands": ".",
        "lengthMenu": "Mostrar _MENU_ datos por registros",
        "zeroRecords": "No se encontraron coincidencias",
        "info": "Pàgina _PAGE_ de _PAGES_",
        "infoEmpty": "No existen Registros",
        "search": "Buscar ",
        "infoFiltered": "(Busqueda de _MAX_ registros en total)",
        "oPaginate":{
          "sLast":"Final",
          "sFirst":"Principio",
          "sNext":"Siguiente",
          "sPrevious":"Anterior"
        }
      }
    });
    } );
    


    function mayus(e) {
        e.value = e.value.toUpperCase();
    }

    
</script>







@endsection
