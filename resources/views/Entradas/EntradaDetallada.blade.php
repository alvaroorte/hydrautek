@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6" >
        <h4>COMPRA DETALLADA</h4>
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
                            <span class="badge bg-warning">{{$cantidad}}</span> Cantidad de Productos
                        </button>
                        <a href="{{url('mostrarentradas')}}" class="config" style="text-align: right"><button class='btn btn-warning dim'><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Volver</button></a>                     
                        @can('editcompra')
                        <button class="btn btn-primary" type="button" onclick="EditarDatos('{{$entrada->id}}');"><i class="glyphicon glyphicon-pencil"></i> Editar Datos</button>             
                        @endcan
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#05cca1;color:#e8f3f7;text-align:center">
                              <tr>
                                  <th width=12%>PROVEEDOR</th>
                                  <th width=10%>NIT/CI</th>
                                  
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="gradeC">
                                  <td style="text-align: center; font-size: 10pt;">{{$entrada->proveedor}}</td>
                                  <td style="text-align: center; font-size: 10pt;">{{$entrada->nit_proveedor}}</td>
                               
                              </tr>
                              </tbody>
                        </table>
                        <table class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#05cca1;color:#e8f3f7;text-align:center">
                                <tr>
                                    <th>CODIGO</th>
                                    <th>FECHA</th>
                                    <th>NUMERO DE DOCUMENTO</th>
                                    <th>DOCUMENTO</th>
                                    <th>TIPO DE PAGO</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="gradeC">
                                    <td style="text-align: center; font-size: 10pt;">{{$entrada->codigo}}</td>
                                    <td style="text-align: center; font-size: 10pt;">{{$entrada->fecha}}</td>
                                    <td style="text-align: center; font-size: 10pt;">{{$entrada->num_factura}}</td>
                                    <td style="text-align: center; font-size: 10pt;">@if ( $entrada->csfactura == 1)
                                        <button type="button" class="btn btn-success"> Factura </button>
                                    @else
                                        <button type="button" class="btn btn-danger"> Nota Remision </button>
                                    @endif</td>
                                    <td style="text-align: center; font-size: 10pt;"> 
                                        @if ( $entrada->cscredito == 1)
                                            <button type="button" class="btn btn-warning"> Credito </button>
                                        @else
                                            @if ($entrada->cscredito == 2)
                                                <button type="button" class="btn btn-secondary"> Banco {{$banco->nombre_banco}}</button>
                                            @else
                                                <button type="button" class="btn btn-primary"> Efectivo </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table id="datatableentradadet" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#05cca1;color:#e8f3f7;text-align:center">
                                <tr>
                                    <th width=10%>GRUPO</th>
                                    <th>ARTICULO</th>
                                    <th width=10%>MARCA</th>
                                    <th width=10%>CANTIDAD</th>
                                    <th width=10%>P. UNITARIO</th>
                                    <th width=10%>Sub Total Bs. </th>
                                    @can('editcompra')<th width=8%>Editar</th>@endcan
                                    @can('deletecompra')<th width=8%>Eliminar</th>@endcan
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach($sql as $entradas)
                                <tr class="gradeC">
                                    <td style="text-align: center;">{{$entradas->nombre_bien}}</td>
                                    <td style="text-align: center;">{{$entradas->nombre_articulo}}</td>
                                    <td style="text-align: center;">{{$entradas->marca}}</td>
                                    <td style="text-align: center;">{{$entradas->cantidad}} {{$entradas->unidad}}(s) </td>
                                    <td style="text-align: center;">{{$entradas->p_unitario}}</td>
                                    <td style="text-align: center;">{{$entradas->p_total}}</td>
                                     @can('editcompra')
                                     <td style="text-align: center;">
                                        <button class="btn btn-primary" type="button" onclick="Editar('{{$entradas->id}}');"><i class="glyphicon glyphicon-pencil"></i></button>                                    
                                    </td>
                                    @endcan
                                    @can('deletecompra')
                                    <td>
                                        <form class="form-horizontal preguntar-eliminar" role="form" method="POST" action="{{url('eliminarentrada')}}/{{$entradas->id}}">
                                        {{ csrf_field() }} @method('DELETE')
                                        <button class="btn btn-danger" type="submit" name="ejecutar" ><i class="glyphicon glyphicon-trash"></i></button>
                                        </form>
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="modal-content panel-primary">
                            <div class="modal-body">
                                <div class="card" style="text-align: center">
                                    <strong> <h3><b> TOTAL Bs. {{$entrada->total}} </b></h3></strong>
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

@section('modal')

<div class="modal fade" id="Editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">EDITAR COMPRA</h4>
            </div>
            <div class="modal-body">
            <form class="form-horizontal" role="form" method="POST" action="{{url('updateentrada')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-8">
                            <strong>GRUPO, ARTICULO (MARCA)</strong> <strong style="color: red;">*</strong>
                            <input name="grupo" id="grupo" class="form-control" required readonly>
                        </div>
                    </div> 
                                     
                    <div class="row"> 
                        <div class="col-lg-3 "><br>
                            <strong>P. UNITARIO</strong>
                            <input type="number" name="p_unitario" id="p_unitario" onkeyup="unitario(this);" class='form-control' required>
                        </div>
        
                        <div class="col-lg-2"><br>
                            <strong>CANTIDAD </strong> <strong style="color: red;">*</strong>
                            <input type="number" name="cantidad" id="cantidad" onkeyup="cantidadd(this);" class='form-control' required>
                        </div>
                        
                        <div class="col-lg-2"><br>
                            <strong>P. TOTAL </strong> <strong style="color: red;">*</strong>
                            <input type="number" name="p_total" id="p_total" step="0.01"class='form-control' readonly>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-3">
                            <strong>TOTAL </strong>
                            <input type="number" id="total" name="total" class='form-control' required readonly>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                    <input hidden id="id" name="id" type="text">
                        <div class="col-lg-12">
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Guardar">
                        </div>
                    </div>

            </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="EditarDatos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">EDITAR DATOS COMPRA</h4>
            </div>
            <div class="modal-body">
            <form class="form-horizontal" role="form" method="POST" action="{{url('updatedatosentrada')}}" autocomplete="off">
                    {{ csrf_field() }}
                                     
                    <div class="row"> 
                        <div class="col-lg-4 "><br>
                            <strong>NUMERO DOCUMENTO</strong>
                            <input type="number" name="num_factura" id="num_factura" class='form-control' required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-3">
                            <strong>NIT/CI PROVEEDOR</strong>
                            <input type="number" id="nit_proveedor" name="nit_proveedor" onkeyup="nit_prov(this);" class='form-control'>
                        </div>
                        <div class="col-lg-3">
                            <strong>NOMBRE PROVEEDOR</strong>
                            <input type="text" id="proveedor" name="proveedor" class='form-control'>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                    <input hidden id="ided" name="id" type="text">
                    <input hidden id="id_proveedor" name="id_proveedor" type="text">
                        <div class="col-lg-12">
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Guardar">
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
        $('#datatableentradadet').DataTable({
            dom: 'fr',
        buttons: [
            'excel', 'pdf', 'print'
        ],
      "order": [[ 0, 'asc']],
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

    function nit_prov(id) {
        nit = id.value;
        url = '{{ asset("/index.php/buscarproveedornit")}}/' + nit;
                $.getJSON(url, null, function(data) 
                {
                    if (data.length > 0) 
                    {
                        $.each(data, function(field, e) 
                        {
                            console.log("sssssss");
                            $('#proveedor').val(e.nombre);
                            $('#id_proveedor').val(e.id);
                        });
                    }
                    else {
                        $('#proveedor').val("");
                        $('#id_proveedor').val("");
                    }        
                });
    }


    function Editar(id) {
        url = '{{ asset("/index.php/buscarentrada")}}/' + id;
        $.getJSON(url, null, function(data) {
            if (data.length > 0) {
                $.each(data, function(field, e) {
                    url = '{{ asset("/index.php/encontrarpeps")}}/' + e.id;
                    $.getJSON(url, null, function(data) {
                        if (data.length > 0) {
                            $.each(data, function(field, h) {
                                if (h.estado) {
                                    url = '{{ asset("/index.php/editarbien")}}/' + e.id_bien;
                                    $.getJSON(url, null, function(data) {
                                        if (data.length > 0) {
                                            $.each(data, function(field, f) {
                                                url = '{{ asset("/index.php/encontrararticulo")}}/' + e.id_articulo;
                                                $.getJSON(url, null, function(data) {
                                                    if (data.length > 0) {
                                                        $.each(data, function(field, g) {
                                                            $('#id').val(e.id);
                                                            $('#grupo').val(f.nombre+', '+g.nombre+" ("+g.marca+")");
                                                            $('#p_unitario').val(e.p_unitario);
                                                            $('#cantidad').val(e.cantidad);
                                                            $('#p_total').val(e.p_total);
                                                            $('#num_factura').val(e.num_factura);
                                                            $('#total').val(e.total);  
                                                            $("#Editar").modal('show');  
                                                        });
                                                    }
                                                });
                                            });
                                        }
                                    });
                                }
                                else {
                                    Swal.fire(
                                    'No es Posible la Acción!',
                                    'Los datos de la Compra ya fueron utilizados.',
                                    'warning'
                                    )
                                }
                            });
                        }
                    });    
                });
            }
        });
    }


    function EditarDatos(id) {
        url = '{{ asset("/index.php/buscarentrada")}}/' + id;
        $.getJSON(url, null, function(data) {
            if (data.length > 0) {
                $.each(data, function(field, e) {
                    $('#ided').val(e.id);
                    $('#num_factura').val(e.num_factura);
                    $('#proveedor').val(e.proveedor);
                    $('#nit_proveedor').val(e.nit_proveedor);  
                    $("#EditarDatos").modal('show'); 
                });
            }
        });
    }



    $('.preguntar-eliminar').submit(function(e){
        e.preventDefault();

        Swal.fire({
        title: 'Estas Seguro?',
        text: "Tu deseas Elininar los datos de la compra!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SI, Eliminar'
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
        })
    });


    function cantidadd(id) {
        id = id.value*1;
        st = $("#p_total").val();
        $("#p_total").empty();
        $("#p_total").val($('#p_unitario').val()*id);
        st2 = $("#p_total").val();
        console.log(st2);
        $("#total").empty();
        $("#total").val(($("#total").val()*1)-(st-st2));
    }
    $("#cantidad").change(function()
    {
        idc = this.value*1;
        st = $("#p_total").val();
        $("#p_total").empty();
        $("#p_total").val($('#p_unitario').val()*idc);
        st2 = $("#p_total").val();
        $("#total").empty();
        $("#total").val(($("#total").val()*1)-(st-st2));     
    });

    function unitario(id) {
        id = id.value*1;
        st = $("#p_total").val();
        $("#p_total").empty();
        $("#p_total").val($('#cantidad').val()*id);
        st2 = $("#p_total").val();
        console.log(st2);
        $("#total").empty();
        $("#total").val(($("#total").val()*1)-(st-st2));
    }
    $("#p_unitario").change(function()
    {
        idc = this.value*1;
        st = $("#p_total").val();
        $("#p_total").empty();
        $("#p_total").val($('#cantidad').val()*idc);
        st2 = $("#p_total").val();
        $("#total").empty();
        $("#total").val(($("#total").val()*1)-(st-st2));     
    });


    function Eliminar(id) {
        url = '{{ asset("/index.php/eliminarentrada")}}/' + id;
    }

</script>

@if (Session::has('noeliminar'))
    <script>
        Swal.fire(
        'No es Posible la Acción!',
        'Los datos de la Compra ya fueron utilizados.',
        'warning'
        )
    </script>
@endif

@if (Session::has('editdatos'))
    <script>
        Swal.fire(
        'Correcto!',
        'Los datos se actualizaron correctamente.',
        'success'
        )
    </script>
@endif

@endsection
