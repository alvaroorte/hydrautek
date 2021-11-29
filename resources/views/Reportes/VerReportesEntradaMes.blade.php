@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>COMPRAS</h2>
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
    <div class="modal-content panel-primary">
            <div class="ibox ">
                <div class="modal-header panel-heading">
                        <a href="{{url('reportefechaentradames')}}" class="config" style="text-align: right"><button class='btn btn-warning dim'><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Volver</button></a>        
                </div>
                <div class="modal-header panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">REPORTE DE GASTOS</h4>
                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table id="datatableentradames" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#dfba14;color:#0c1011;text-align:center">
                                <tr>
                                    <th>FECHA</th>
                                    <th>DESCRIPCION</th>
                                    <th>IMPORTE Bs.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $suma = 0; ?>
                                @foreach($gastos as $gasto)
                                <tr class="gradeC">
                                    <td style="text-align: center;">{{$gasto->fecha}}</td>
                                    <td style="text-align: center;">{{$gasto->concepto}}</td>
                                    <td style="text-align: right;">{{number_format($gasto->importe*-1,2)}}</td>
                                    <?php $suma += $gasto->importe*-1; ?>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td style="text-align: right"><h5><b>Total en Bs:</b></h5></td>
                                    <td style="text-align: right;">{{number_format($suma,2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div><br><br>
    <div class="wrapper wrapper-content animated fadeInRight">
    <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">REPORTE DE CUENTAS POR PAGAR</h4>
            </div>
            <br>
            <div class="ibox-content">
                <div id="divCargaDistritos" class="table-responsive">
                    <table id="datatablegastosporpagar" class="table table-bordered table-hover table-striped table-sm">
                        <thead style="background:#dfba14;color:#0c1011;text-align:center">
                            <tr>
                                <th>FECHA</th>
                                <th>PROVEEDOR</th>
                                <th>IMPORTE Bs.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $suma = 0; ?>
                            @foreach($creditos as $credito)
                            <tr class="gradeC">
                                <td style="text-align: center;">{{$ff}}</td>
                                <td style="text-align: center;">{{$credito->nombre}}</td>
                                <td style="text-align: right;">{{number_format($credito->saldo,2)}}</td>
                                <?php $suma += $credito->saldo; ?>
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td style="text-align: right"><h5><b>Total en Bs:</b></h5></td>
                                <td style="text-align: right;">{{number_format($suma,2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>
</div>
    
</div>



@endsection


@section('js')

<script>

$(document).ready( function () {
        $('#datatableentradames').DataTable({
        dom: '<"html5buttons"B>lfgtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>',
                title: 'REPORTE DE GASTOS',
                titleAttr: 'Exportar a excel',
            },
            {
                extend: 'pdfHtml5',
                text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>',
                title: 'REPORTE DE GASTOS',
                titleAttr: 'Exportar a PDF',
            },
            {
                extend: 'print',
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>',
                title: 'REPORTE DE GASTOS',
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

    $(document).ready( function () {
        $('#datatablegastosporpagar').DataTable({
        dom: '<"html5buttons"B>lfgtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>',
                title: 'REPORTE DE CUENTAS POR PAGAR',
                titleAttr: 'Exportar a excel',
            },
            {
                extend: 'pdfHtml5',
                text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>',
                title: 'REPORTE DE CUENTAS POR PAGAR',
                titleAttr: 'Exportar a PDF',
            },
            {
                extend: 'print',
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>',
                title: 'REPORTE DE CUENTAS POR PAGAR',
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













