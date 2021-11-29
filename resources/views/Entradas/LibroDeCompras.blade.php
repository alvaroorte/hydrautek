@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6" >
        <h4>LIBRO DE COMPRAS</h4>
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
                            <span class="badge bg-primary" style="background:#3c46d3">{{$cantidad}}</span> Compras registradas
                        </button>
                        <a href="{{url('librodecompras')}}" class="config" ><button class='btn btn-light' style="background:#3c46d3;color:#ffffff;text-align:center"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Volver</button></a>                     
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table id="librodecompras" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#3c46d3;color:#ffffff;text-align:center">
                                <tr>
                                    <th>Nª</th>
                                    <th>ESPECIFICACIÓN</th>
                                    <th>NIT</th>
                                    <th>RAZON SOCIAL</th>                                    
                                    <th>AUTORIZACION</th>
                                    <th>N° FACTURA</th>
                                    <th>N° DUI/DIM</th>
                                    <th>FECHA</th>
                                    <th>IMPORTE TOTAL</th>
                                    <th>ICE</th>
                                    <th>IEHD</th>
                                    <th>IPJ</th>
                                    <th>TASAS</th>
                                    <th>NO SUJETO AL C.F.</th>
                                    <th>EXENTOS</th>
                                    <th>TASA CERO</th>
                                    <th>SUBTOTAL</th>
                                    <th>DESC/REBAJAS</th>
                                    <th>GIFT CARD</th>
                                    <th>IMPORTE BASE C.F.</th>
                                    <th>CREDITO FISCAL</th>
                                    <th>TIPO COMPRA</th>
                                    <th>COD. CONTROL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($entradas as $entrada)
                                <tr class="gradeC">
                                    <td style="text-align: center;"><?php echo $i++; ?></td>
                                    <td style="text-align: center;">1</td>
                                    <td style="text-align: center;">{{$entrada->nit_proveedor}}</td>
                                    <td style="text-align: center;">{{$entrada->proveedor}}</td>
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: center;">{{$entrada->num_factura}}</td>
                                    <td style="text-align: center;">0</td>
                                    <td style="text-align: center;">{{\Carbon\Carbon::parse($entrada->fecha)->format('d/m/Y')}}</td>
                                    <td style="text-align: right;">{{number_format($entrada->total,2)}}</td>
                                    <td style="text-align: right;">{{number_format(0,2)}}</td>
                                    <td style="text-align: right;">{{number_format(0,2)}}</td>
                                    <td style="text-align: right;">{{number_format(0,2)}}</td>
                                    <td style="text-align: right;">{{number_format(0,2)}}</td>
                                    <td style="text-align: right;">{{number_format(0,2)}}</td>
                                    <td style="text-align: right;">{{number_format(0,2)}}</td>
                                    <td style="text-align: right;">{{number_format(0,2)}}</td>
                                    <td style="text-align: right;">{{number_format($entrada->total,2)}}</td>
                                    <td style="text-align: right;">{{number_format(0,2)}}</td>
                                    <td style="text-align: right;">{{number_format(0,2)}}</td>
                                    <td style="text-align: center;">{{number_format($entrada->total,2)}}</td>
                                    <td style="text-align: center;">{{number_format($entrada->total*0.13,2)}}</td>
                                    <td style="text-align: center;">1</td>
                                    <td style="text-align: center;">0</td>
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


@section('js')

<script>
    $(document).ready( function () {
        $('#librodecompras').DataTable({
            
      dom: '<"html5buttons"B>lfgtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>',
                title: 'Libro de Compras',
                titleAttr: 'Exportar a excel',
            },
            {
                extend: 'pdfHtml5',
                text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>',
                title: 'Libro de Compras',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger'
            },
            {
                extend: 'print',
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>',
                title: 'Libro de Compras',
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
