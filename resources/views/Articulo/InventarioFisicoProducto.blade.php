@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>INVENTARIO FISICO VALORADO POR PRODUCTO</h2>
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
        @if(Session::has('message'))
            <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get('message')}}
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
                        <a href="{{url('inventariodetallado/'.$articulo->id_bien)}}" class="config" ><button class='btn btn-light' style="background:#3c46d3;color:#ffffff;text-align:center"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Volver</button></a>                     
                        <a href="#PorFecha" data-toggle="modal" class="config"><button class='btn btn-outline-primary'><span class="fa fa-calendar" aria-hidden="true"></span> Por Fecha</button></a> 
                    </div>
                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#3c46d3;color:#ffffff;text-align:center">
                              <tr>
                                  <th>ID ARTICULO</th>
                                  <th>CODIGO EMPRESA</th>
                                  <th>GRUPO</th>
                                  <th>ARTICULO</th>
                                  <th>MARCA</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="gradeC">
                                  <td style="text-align: center;">{{$articulo->id}}</td>
                                  <td style="text-align: center;">{{$articulo->codigo_empresa}}</td>
                                  <td style="text-align: center;">{{$bien->nombre}}</td>
                                  <td style="text-align: center;">{{$articulo->nombre}}</td>
                                  <td style="text-align: center;">{{$articulo->marca}}</td>
                              </tr>
                              </tbody>
                        </table>
                        <table id="datatablearticulopro" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#3c46d3;color:#ffffff;text-align:center">
                                
                                <tr>
                                    <th rowspan="2" >FECHA</th>
                                    <th rowspan="2">DETALLE</th>
                                    <th rowspan="2">CODIGO</th>      
                                    <th rowspan="2">COSTO</th>
                                    <th colspan="3" >CANTIDAD ({{$articulo->unidad}})</th>
                                    <th colspan="3" >COSTO(Bs.)</th>
                                </tr>
                                <tr>
                                    <th>ENTRADA</th>
                                    <th>SALIDA</th>
                                    <th>SALDO</th>
                                    <th>ENTRADA</th>
                                    <th>SALIDA</th>
                                    <th>SALDO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; $saldo = 0; $saldo_p = 0 ?>
                                @if ($saldoi != null)
                                    <?php $saldo_p = $saldoi; $saldo = $cantidad; ?>
                                    <tr>
                                        <td style="text-align: center;">{{$fecha}}</td>
                                        <td style="text-align: center;">Saldo Inicial</td>
                                        <td style="text-align: center;">S.I.</td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;">{{$cantidad}}</td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: right;"><b>{{number_format($saldoi,2)}}</b></td>
                                    </tr>
                                @endif
                                
                                @foreach($sql as $articulos)
                                <?php $saldo=$saldo+$articulos->cantidad_e-$articulos->cantidad_s;
                                    $articulos->costo_s *= -1; 
                                    $saldo_p = $saldo_p + $articulos->costo_s + ($articulos->costo_e * $articulos->cantidad_e);?>
                                <tr class="gradeC">
                                    <td style="text-align: center;">{{$articulos->fecha}}</td>
                                    @if ($articulos->codigo != null)
                                        <td style="text-align: center;">Compra</td>
                                        <td style="text-align: center;">{{$articulos->codigo}}</td>
                                        <td style="text-align: center;">{{$articulos->costo_e}}</td>
                                    @else
                                        <td style="text-align: center;">Venta</td>
                                        <td style="text-align: center;">{{$articulos->codigo_venta}}</td>
                                        <td style="text-align: center;"></td>
                                    @endif
                                    <td style="text-align: center;">{{$articulos->cantidad_e}}</td>
                                    <td style="text-align: center;">{{$articulos->cantidad_s}}</td>
                                    <td style="text-align: center;"><b>{{$saldo}}</b></td>
                                    <td style="text-align: right;">{{number_format($articulos->costo_e * $articulos->cantidad_e,2)}}</td>
                                    <td style="text-align: right;">{{number_format($articulos->costo_s,2)}}</td>
                                    <td style="text-align: right;"><b>{{number_format($saldo_p,2)}}</b></td>
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
                <form class="form-horizontal" role="form" method="POST" action="{{url('mostrarkardexarticuloporfecha')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-3">
                            <strong>FECHA INICIO</strong>
                            <input onkeyup="mayus(this);" type="date" name="fi" value="{{date('Y-m-d')}}" class='form-control' required>
                        </div>
                        <div class="col-lg-3">
                            <strong>FECHA FIN</strong>
                            <input onkeyup="mayus(this);" type="date" name="ff" value="{{date('Y-m-d')}}" class='form-control' required>
                        </div>
                    </div>
                        
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <input type="hidden" name="id" value="{{$articulo->id}}" >
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
        $('#datatablearticulopro').DataTable({
            
      dom: '<"html5buttons"B>lfgtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>',
                title: 'INVENTARIO FISICO VALORADO POR PRODUCTO',
                titleAttr: 'Exportar a excel',
            },
            {
                extend: 'pdfHtml5',
                text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>',
                title: 'INVENTARIO FISICO VALORADO POR PRODUCTO',
                titleAttr: 'Exportar a PDF',
            },
            {
                extend: 'print',
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>',
                title: 'INVENTARIO FISICO VALORADO POR PRODUCTO',
                titleAttr: 'Imprimir',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '15pt');
                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                }
            },
        ],
        "ordering": false,
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
