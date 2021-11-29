@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6" >
        <h4>VENTA DETALLADA</h4>
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
                            <span id="total" class="badge bg-warning">{{$cantidad}}</span> Cantidad de Productos
                        </button>
                        <a href="{{url('mostrarsalidas')}}" class="config" style="text-align: right"><button class='btn btn-warning dim'><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Volver</button></a>                     
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div class="table-responsive">
                        @if (!$salida->estado)
                        <table class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:red;color:#0c1011;text-align:center">
                              <tr>
                                  <th width=12%><button type="button" class="btn btn-danger"> Anulado </button></th>
                              </tr>
                            </thead>
                        </table>
                        @endif
                        <table class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#dfba14;color:#0c1011;text-align:center">
                              <tr>
                                  <th width=12%>CLIENTE</th>
                                  <th width=10%>NIT/CI</th>
                                  
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="gradeC">
                                  <td style="text-align: center; font-size: 10pt;">{{$salida->cliente}}</td>
                                  <td style="text-align: center; font-size: 10pt;">{{$salida->nit_cliente}}</td>
                               
                              </tr>
                              </tbody>
                        </table>
                        <table class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#dfba14;color:#0c1011;text-align:center">
                              <tr>
                                  <th>DOCUMENTO</th>
                                  <th>NUMERO DE DOCUMENTO</th>
                                  <th>TIPO DE PAGO</th>
                                  
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="gradeC">
                                  <td style="text-align: center; font-size: 10pt;">@if ( $salida->scfactura == 1)
                                    <button type="button" class="btn btn-success"> Factura </button>
                                @else
                                    <button type="button" class="btn btn-danger"> Nota Remision </button>
                                @endif</td>
                                    <td style="text-align: center; font-size: 10pt;">{{$salida->num_factura}}</td>
                                    <td style="text-align: center; font-size: 10pt;"> 
                                        @if ( $salida->sccredito == 1)
                                            <button type="button" class="btn btn-warning"> Credito </button>
                                        @else
                                            @if ($salida->sccredito == 2)
                                                <button type="button" class="btn btn-secondary"> Banco {{$banco->nombre_banco}}</button>
                                            @else
                                                <button type="button" class="btn btn-primary"> Efectivo </button>
                                            @endif
                                        @endif
                                    </td>
                              </tr>
                              </tbody>
                        </table>
                        <table id="datatablesalidadet" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#dfba14;color:#0c1011;text-align:center">
                                <tr>
                                    <th width=10%>N°</th>
                                    <th>GRUPO</th>
                                    <th>ARTICULO</th>
                                    <th width=15%>MARCA</th>
                                    <th width=10%>CANTIDAD</th>
                                    <th width=10%>P. VENTA</th>
                                    <th width=10%>SUB TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1;  @endphp
                                @foreach($sql as $salidas)
                                <tr class="gradeC">
                                    <td style="text-align: center;"><?php echo $i++; ?></td>
                                    <td style="text-align: center;">{{$salidas->nombre_bien}}</td>
                                    <td style="text-align: center;">{{$salidas->nombre_articulo}}</td>
                                    <td style="text-align: center;">{{$salidas->marca}}</td>
                                    <td style="text-align: center;">{{$salidas->cantidad}}</td>
                                    <td style="text-align: center;">{{$salidas->p_venta}}</td>
                                    <td style="text-align: center;"> <h5> {{$salidas->sub_total}} </h5></td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                        <div class="modal-content panel-primary">
                            <div class="modal-body">
                                <div class="card" style="text-align: center">
                                    <strong> <h4><b> TOTAL Bs. {{$salida->total}} </b></h4></strong>
                                </div>
                                <div class="card" style="text-align: center">
                                    <strong> <h5><b> Descuento Bs. {{$salida->descuento}} </b></h5></strong>
                                </div>
                                <div class="card" style="text-align: center">
                                    <strong> <h3><b> TOTAL NETO Bs. {{$salida->total-$salida->descuento}} </b></h3></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')

<script>
    $(document).ready( function () {
        $('#datatablesalidadet').DataTable({
            
      dom: '<"html5buttons">f',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>',
                title: 'Lista de Ventas',
                titleAttr: 'Exportar a excel',
            },
            {
                extend: 'pdfHtml5',
                text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>',
                title: 'Lista de Ventas',
                titleAttr: 'Exportar a PDF',
            },
            {
                extend: 'print',
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>',
                title: 'Lista de Ventas',
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