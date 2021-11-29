@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6" >
        <h4>INVENTARIO DETALLADO POR GRUPOS</h4>
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
                            <span id="total" class="badge bg-primary" style="background:#3c46d3">{{$cantidad}}</span> Tipos de Bien registrados
                        </button>
                        <a href="{{url('mostrarinventario')}}" class="config" ><button class='btn btn-light' style="background:#3c46d3;color:#ffffff;text-align:center"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Volver</button></a>                     
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table id="inventariodetallado" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#3c46d3;color:#ffffff;text-align:center">
                                <tr>
                                    <th width="5%">Nª</th>
                                    <th width="10%">GRUPO</th>
                                    <th>ARTICULO</th>
                                    <th width="10%">MARCA</th>                                    
                                    <th width="8%">CANTIDAD</th>
                                    <th width="8%">RESERVADO</th>
                                    <th width="10%">UBICACIÓN</th>
                                    <th width="8%">COSTO</th>
                                    <th width="8%">P. de VENTA </th>
                                    <th width="8%">P. por MAYOR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($sql as $articulos)
                                <tr class="gradeC">
                                    <td style="text-align: center;"><?php echo $i++; ?></td>
                                    <td style="text-align: center;">{{$articulos->nombre_bien}}</td>
                                    <td style="text-align: center;"><b><a href="{{url('mostrararticuloproducto/'.$articulos->id)}}" title="Ver Kardex del Producto" ><span style="color:blue" >{{$articulos->nombre}}</span></a></b></td>
                                    <td style="text-align: center;">{{$articulos->marca}}</td>
                                    <td style="text-align: center;">{{$articulos->cantidad}} {{$articulos->unidad}}(s)</td>
                                    <td style="text-align: center;">{{$articulos->reservado}}</td>
                                    <td style="text-align: center;">{{$articulos->ubicacion}}</td>
                                    <td style="text-align: right;">{{number_format($articulos->costo,2)}}</td>
                                    <td style="text-align: right;">{{number_format($articulos->p_venta,2)}}</td>
                                    <td style="text-align: right;">{{number_format($articulos->p_ventapm,2)}}</td>
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
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print "></i> </button>',
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





<script>
   function Editar(id) {
        url = '{{ asset("/index.php/editararticulo")}}/' + id;
        $.getJSON(url, null, function(data) {
            if (data.length > 0) {

                $.each(data, function(field, e) {
                    $('#id').val(e.id);
                    $('#nombre').val(e.nombre);
                });
                $("#Editar").modal('show');
            }
        });
    }
</script>




@endsection
