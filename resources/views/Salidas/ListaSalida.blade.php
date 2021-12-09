@php
    
use App\Models\Cliente;
@endphp
@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>VENTAS</h2>
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
                        <a href="#Nuevo" data-toggle="modal" class="config"><button class='btn btn-outline-warning'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nueva Venta</button></a>
                        <button type="button" class="btn btn-secondary">
                            <span  class="badge bg-warning">{{$cantidad}}</span> <i class="far fa-calendar-edit"></i> Ventas Registradas
                        </button>
                        <a href="{{url('mostrarservicioform')}}" class="config"><button class='btn btn-outline-warning'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Venta de Servicio</button></a>
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table id="datatablesalida" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#dfba14;color:#0c1011;text-align:center text-center; ">
                                <tr>
                                    <th width=5%>N°</th>
                                    <th width=10%>FECHA</th>
                                    <th width=10%>CODIGO VENTA</th>
                                    <th width=20%>CLIENTE (NIT)</th>
                                    <th width=12%>N° DOCUMENTO</th>
                                    <th width=10%>TOTAL (Bs.)</th>
                                    <th width=10%>DOCUMENTO</th>
                                    <th>TIPO DE COBRO</th>
                                    <th>OPCIONES</th>
                                    <th>ANULAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sql as $salidas)
                                <tr class="gradeC">
                                    <td style="text-align: center;">{{$salidas->num_venta}}</td>
                                    <td style="text-align: center;">{{$salidas->fecha}}</td>  
                                    <td style="text-align: center;">{{$salidas->codigo_venta}}</td>                                
                                    <td style="text-align: center;">{{$salidas->cliente}} ({{$salidas->nit_cliente}})</td>
                                    <td style="text-align: center;">{{$salidas->num_factura}}</td>
                                    <td style="text-align: right;">{{number_format($salidas->total-$salidas->descuento,2)}}</td>
                                    <td style="text-align: center;"> 
                                        @if ( $salidas->scfactura == 1)
                                            <button type="button" class="btn btn-success"> Factura </button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-sm"> Nota Remision </button>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">  
                                        @if ( $salidas->sccredito == 1)
                                            <button type="button" class="btn btn-warning"> Credito </button>
                                        @else
                                            @if ($salidas->sccredito == 2)
                                                <button type="button" class="btn btn-secondary"> Banco </button>
                                            @else
                                                <button type="button" class="btn btn-primary"> Efectivo </button>
                                            @endif
                                        @endif
                                     </td>
                                    <td style="text-align: center;"> 
                                        <a href="{{'salidadetallada/'.$salidas->identificador}}"><button class='btn btn-info btn-sm'>Ver Detalle</button></a>
                                        <a href="{{url('reportesalida/'.$salidas->identificador)}}" ><button class='btn btn-danger' title="Ver PDF" ><i  class="fa fa-file-pdf-o"></i> </button></a>
                                    </td>
                                    <td>
                                    @if ($salidas->estado)
                                        <form class="form-horizontal preguntar-eliminar" role="form" method="POST" action="{{url('eliminarsalida')}}/{{$salidas->identificador}}">
                                            {{ csrf_field() }} @method('DELETE')
                                            <button class="btn btn-warning" type="submit" title="Anular Venta" name="ejecutar" ><i class="glyphicon glyphicon-trash"></i></button>
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-danger"> Anulado </button>
                                    @endif
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
    
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">NUEVA VENTA </h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-3 ">
                    <strong>CODIGO DE EMPRESA</strong>
                    <input type="text" name="codigo_empre" id="codigo_empre" onchange="codigo_empresa(this);" class='form-control'>
                </div>
                <div class="col-lg-3 ">
                    <strong>CODIGO DE FABRICA</strong>
                    <input type="text" name="codigo_fabric" id="codigo_fabric" onchange="codigo_fabrica(this);" class='form-control'>
                </div>
                <div class="col-lg-2">
                    <strong>UBICACÍON</strong>
                    <input type="text" name="ubicacion" id="ubicacion" class='form-control' readonly>
                </div>
                <div class="col-lg-2">
                    <strong>P. POR MAYOR</strong>
                    <input type="text" name="p_ventapm" id="p_ventapm" class='form-control' readonly>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-lg-2">
                    <strong>BIEN</strong> <strong style="color: red;">*</strong>
                    <select name="id_bien" id="id_bien" class="form-control" required>
                        <option value="">Seleccionar...</option>
                        @foreach($bienes as $bien)
                            <option value="{{$bien->id}}">{{$bien->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-lg-6">
                    <strong>ARTICULO</strong> <strong style="color: rgb(255, 0, 0);">*</strong>
                    <select name="id_articulo" id="id_articulo" class="form-control" required>
                        <option value="">Seleccionar...</option>     
                    </select>
                </div>                   
                    
                <div class="col-lg-2">
                    <strong>CANTIDAD </strong> <strong style="color: red;">*</strong>
                    <input type="number" name="cantidad" id="cantidad" onkeyup="cantidad(this);" class='form-control' required>
                </div>

                <div class="col-lg-1">
                    <strong>Disponible </strong>
                    <input type="number" name="cantidad_m" id="cantidad_m" class='form-control' required readonly>
                </div>
                
            </div>
            <div class="modal-body">
                <div class="col-lg-2">
                    <strong>Precio de Venta </strong>
                    <input type="number" name="p_venta" id="p_venta" onkeyup="p_ventas(this);" class='form-control' required>
                </div>
                <div class="col-lg-2">
                    <strong>Sub Total </strong>
                    <input type="number" name="sub_total" id="sub_total" step="0.01" class='form-control' required readonly>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-1"><br>
                    <b onclick="insertar()" class="btn btn-success"> <i class="fa fa-plus">Agregar</i> </b>    
                </div>              
            </div>
                      
            <div class="col-auto p-5 text-center">
            <form class="form-horizontal crearsalida" role="form" method="POST" action="{{('crearsalida ')}}" autocomplete="off">
                {{ csrf_field() }}
                <div class="modal-content panel-primary">
                    <div class="modal-body">
                        <div class="col-lg-1"></div>
                        <!--<div class="col-lg-2">
                            <strong>CODIGO DE VENTA </strong> <strong style="color: red;">*</strong>
                            <input type="number" name="codigo_venta" id="codigo_venta" class='form-control' required>
                        </div>-->
                        
                        <div class="col-lg-2 ">
                            <strong>DOCUMENTO</strong>
                            <select name="scfactura" id="scfactura"  class="form-control"  required>
                                <option value="">Seleccionar...</option>
                                <option value="1">Factura</option>
                                <option value="0">Nota Remision</option>
                            </select>
                        </div>
    
                        <div class="col-lg-2">
                            <strong>NUMERO de DOCUMENTO</strong>
                            <input type="number" name="num_factura" id="num_factura" class='form-control' required>
                        </div>
    
                        <div class="col-lg-2 ">
                            <strong>FORMA DE PAGO</strong>
                            <select name="sccredito" id="sccredito" class="form-control" required>
                                <option value="0">Efectivo</option>
                                <option value="1">Credito</option>
                                <option value="2">Banco</option>
                            </select>
                        </div>
                        <div class="col-lg-2 " id="div_banco" style="display: none">
                            <strong>BANCO</strong>
                            <select name="banco" class="form-control">
                                @foreach($bancos as $banco)
                                    <option value="{{$banco->id}}">{{$banco->nombre_banco}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 " id="div_plazo" style="display: none">
                            <strong>PLAZO (Días)</strong>
                            <input type="number" name="plazo" value="0"  class='form-control' required>
                        </div>
    
                        <div class="col-lg-2">
                            <strong>FECHA</strong>
                            <input type="date" name="fecha" id="fecha" class="form-control" value="{{date('Y-m-d')}}">
                        </div>
                    </div>
    
                    <div class="modal-body">
                        <div class="col-lg-3 ">
                            <strong>CODIGO CLIENTE</strong>
                            <input type="text" name="codigo_cli" id="codigo_cli" onkeyup="codigo_cliente(this);" class='form-control'>
                        </div>
                        <div class="col-lg-3 ">
                            <strong>NIT CLIENTE</strong>
                            <input type="number" name="nit_cliente" id="nit_cliente" onkeyup="nit_cli(this);" class='form-control'>
                        </div>
                        <div class="col-lg-3">
                            <strong>CLIENTE</strong> <strong style="color: rgb(255, 0, 0);">*</strong>
                            <input type="text" name="cliente" id="cliente" class='form-control'>
                        </div>
                        
                    </div>
                </div>
                <table class="table table-bordered table-hover table-striped table-sm">
                    <thead>
                        <tr class="col-auto bg-secondary">
                            <th width=15%>BIEN</th> 
                            <th width=20%>ARTICULO</th>
                            <th width=15%>CANTIDAD</th>
                            <th width=15%>P. Venta</th>
                            <th width=15%>Sub Total</th>
                            <th width=5%>Borrar</th>
                            
                        </tr>
                    </thead>
                    <tbody id="cuerpo" >

                    </tbody>
                </table>
                <div class="row" >
                    <div class="col-lg-4"></div>
                    <div class="col-lg-2"> 
                        <strong>Total(Bs.)</strong>
                        <input type="number" name="total" id="total" value="" step="0.01" class='form-control' style="text-align: center" required readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-2">
                        <strong>Descuento(Bs.) </strong>
                        <input type="number" name="descuento" id="descuento" step="0.01" value="0" style="text-align: center" class='form-control' required>
                    </div>
                </div>
                <div class="modal-dialog modal-lg">
                    <div class="modal-content panel-primary" id="bguardar" style="display: none" >
                        <input type="hidden" name="tipo" value="0" class='form-control'>
                        <input type="hidden" name="id_cliente" id="id_cliente" class='form-control'>
                        <input  type="submit" name="ejecutar" class='float-right btn btn-primary' value="Guardar">
                    </div>    
                </div>
            </form>
            </div>
        </div>
</div>
        <!-- /.modal-content -->
    
    <!-- /.modal-dialog -->

@endsection

@section('js')

@if (Session::has('eliminar'))
    <script>
        Swal.fire(
        'Eliminado!',
        'Los datos de la Venta fueron borrados.',
        'success'
        )
    </script>
@endif

<script>

$('.preguntar-eliminar').submit(function(e){
        e.preventDefault();

        Swal.fire({
        title: 'Estas Seguro?',
        text: "Tu deseas Anular la Venta!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SI, Anular'
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
        })
    });


function nit_cli(id) {
        ci = id.value;
        url = '{{ asset("/index.php/buscarclienteci")}}/' + ci;
                $.getJSON(url, null, function(data) 
                {
                    if (data.length > 0) 
                    {
                        $.each(data, function(field, e) 
                        {
                            console.log("sssssss");
                            $('#cliente').val(e.nombre);
                            $('#codigo_cli').val(e.codigo_cli);
                            $('#id_cliente').val(e.id);
                        });
                    }
                    else {
                        $('#cliente').val("");
                        $('#codigo_cli').val("");
                        $('#id_cliente').val("");
                    }        
                });
    }

    function codigo_cliente(id) {
        codigo = id.value;
        url = '{{ asset("/index.php/buscarclientecodigo")}}/' + codigo;
                $.getJSON(url, null, function(data)
                {
                    if (data.length > 0) 
                    {
                        $.each(data, function(field, e) 
                        {
                            $('#cliente').val(e.nombre);
                            $('#nit_cliente').val(e.ci);
                            $('#id_cliente').val(e.id);
                        });
                    }
                    else {
                        $('#cliente').val("");
                        $('#nit_cliente').val("");
                        $('#id_cliente').val("");
                    }        
                });
    }

    $(document).ready( function () {
        $('#datatablesalida').DataTable({
            
      dom: '<"html5buttons"B>lfgtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>',
                title: 'Lista de Ventas',
                titleAttr: 'Exportar a excel',
                exportOptions: { columns: [0, 1, 2,3,4,5] },
            },
            {
                extend: 'pdfHtml5',
                text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>',
                title: 'Lista de Ventas',
                titleAttr: 'Exportar a PDF',
                exportOptions: { columns: [0, 1, 2,3,4,5] },
            },
            {
                extend: 'print',
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>',
                title: 'Lista de Ventas',
                titleAttr: 'Imprimir',
                exportOptions: { columns: [0, 1, 2,3,4,5] },
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

    $('.crearsalida').submit(function(e){
        e.preventDefault();

        Swal.fire({
        title: 'Estas Seguro?',
        text: "Estas a punto de realizar una venta!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Realizar Venta',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
        })
    });

    function mayus(e) {
        e.value = e.value.toUpperCase();
    }
    

    $("#id_bien").change(function()
        {
            id=this.value;  
            $("#id_articulo").empty();
            url = '{{ asset("/index.php/encontrararticulos")}}/' + id;
            $.getJSON(url, null, function(data) {
                if (data.length > 0) 
                {
                    $('#id_articulo').append('<option value="">Seleccionar...</option>');
                    $.each(data, function(field, e) 
                    {
                        $('#id_articulo').append('<option value="'+e.id+'">'+e.nombre+"  ("+e.marca+')</option>');
                    });
                } 
            });
        });

    $("#id_articulo").change(function()
        {
            id=this.value;  
            $("#cantidad_m").empty();
            $("#p_venta").empty();
            url = '{{ asset("/index.php/encontrararticulo")}}/' + id;
            $.getJSON(url, null, function(data) {
                if (data.length > 0) 
                {
                    $.each(data, function(field, e) 
                    {
                        $('#cantidad_m').val(e.cantidad-e.reservado);
                        $('#p_venta').val(e.p_venta);
                        $('#p_ventapm').val(e.p_ventapm);
                        $('#ubicacion').val(e.ubicacion);
                    });
                }
            });
        });

    function cantidad(id) {
        id = id.value*1;
        url = '{{ asset("/index.php/encontrararticulo")}}/' + $("#id_articulo").val();
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $.each(data, function(field, e) 
                {
                    if (id>(e.cantidad-e.reservado)) {
                        $("#cantidad").val(e.cantidad-e.reservado);
                        $("#sub_total").empty();
                        $("#sub_total").val(e.p_venta*$('#cantidad').val());
                        alert("LA CANTIDAD INTRODUCIDA ES MAYOR AL STOCK DEL ARTICULO");
                    } else {
                        $("#sub_total").empty();
                        $("#sub_total").val($("#p_venta").val()*id);
                    }
                    
                });
            }
        });
    }


    $("#cantidad").change(function()
    {
        id = this.value*1;
        url = '{{ asset("/index.php/encontrararticulo")}}/' + $("#id_articulo").val();
        
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $.each(data, function(field, e) 
                {
                    if (id>(e.cantidad-e.reservado)) {
                        $("#cantidad").val(e.cantidad-e.reservado);
                        $("#sub_total").empty();
                        $("#sub_total").val($("#p_venta").val()*$("#cantidad").val());
                        alert("LA CANTIDAD INTRODUCIDA ES MAYOR AL STOCK DEL PRODUCTO");
                    } else {
                        $("#sub_total").empty();
                        $("#sub_total").val($("#p_venta").val()*id);
                    }
                });
            }
        });
    });


    function p_ventas(id) {
        id = id.value*1;
        url = '{{ asset("/index.php/encontrararticulo")}}/' + $("#id_articulo").val();
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $.each(data, function(field, e) 
                {
                    $("#sub_total").empty();
                    $("#sub_total").val($("#cantidad").val()*id);
                });
            }
        });
    };

    $("#p_venta").change(function()
    {
        id = $("#p_venta").val()*1;
        url = '{{ asset("/index.php/encontrararticulo")}}/' + $("#id_articulo").val();
        
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $.each(data, function(field, e) 
                {
                    $("#sub_total").empty();
                    $("#sub_total").val($("#cantidad").val()*id);
                });
            }
        });
    });

    function codigo_barra(codigo) {
        codigo = codigo.value*1;
        url = '{{ asset("/index.php/encontrararticulocodigobarra")}}/' + codigo;
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $("#cantidad_m").empty();
                $("#p_venta").empty();
                $.each(data, function(field, e) 
                {
                    url = '{{ asset("/index.php/editarbien")}}/' + e.id_bien;
                    $.getJSON(url, null, function(data) {
                        if (data.length > 0) 
                        {
                            $.each(data, function(field, f) 
                            {
                                $("#cantidad_m").val((e.cantidad-e.reservado));
                                $('#id_bien').val(e.id_bien);
                                $('#id_articulo').empty();
                                $('#id_articulo').append('<option value="'+e.id+'">'+e.nombre+"  ("+e.marca+')</option>');
                                $('#p_venta').val(e.p_venta);
                                $('#p_ventapm').val(e.p_ventapm);
                                $('#ubicacion').val(e.ubicacion);
                            });
                        }
                    });
                });
            }
        });
    }

    function codigo_empresa(codigo) {
        codigo = codigo.value;
        t = codigo.length;
        inicio = 0,p=0,p2=0;
        for (i = 0; i < t; i++) {
            if(codigo.charAt(i) == '/') {
                p = codigo.slice(inicio,i)
                inicio = i+1;
                p2 = codigo.slice(inicio,t)
                break;
            }
        }
        if (inicio > 0) {
            url = '{{ asset("/index.php/encontrararticulocodigoempresas")}}/'+p+'/'+p2;
        }
        else {
            url = '{{ asset("/index.php/encontrararticulocodigoempresa")}}/' + codigo;
        }
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $("#cantidad_m").empty();
                $("#p_venta").empty();
                $.each(data, function(field, e) 
                {
                    url = '{{ asset("/index.php/editarbien")}}/' + e.id_bien;
                    $.getJSON(url, null, function(data) {
                        if (data.length > 0) 
                        {
                            $.each(data, function(field, f) 
                            {
                                $("#cantidad_m").val(e.cantidad-e.reservado);
                                $('#id_bien').val(e.id_bien);
                                $('#id_articulo').empty();
                                $('#id_articulo').append('<option value="'+e.id+'">'+e.nombre+"  ("+e.marca+')</option>');
                                $('#p_venta').val(e.p_venta);
                                $('#p_ventapm').val(e.p_ventapm);
                                $('#ubicacion').val(e.ubicacion);
                                
                            });
                        }
                    });
                });
            }
        });
    }

    function codigo_fabrica(codigo) {
        codigo = codigo.value;
        t = codigo.length;
        inicio = 0,p=0,p2=0;
        for (i = 0; i < t; i++) {
            if(codigo.charAt(i) == '/') {
                p = codigo.slice(inicio,i)
                inicio = i+1;
                p2 = codigo.slice(inicio,t)
                break;
            }
        }
        if (inicio > 0) {
            url = '{{ asset("/index.php/encontrararticulocodigofabricas")}}/'+p+'/'+p2;
        }
        else {
            url = '{{ asset("/index.php/encontrararticulocodigofabrica")}}/' + codigo;
        }
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $("#cantidad_m").empty();
                $("#p_venta").empty();
                $.each(data, function(field, e) 
                {
                    url = '{{ asset("/index.php/editarbien")}}/' + e.id_bien;
                    $.getJSON(url, null, function(data) {
                        if (data.length > 0) 
                        {
                            $.each(data, function(field, f) 
                            {
                                $("#cantidad_m").val(e.cantidad-e.reservado);
                                $('#id_bien').val(e.id_bien);
                                $('#id_articulo').empty();
                                $('#id_articulo').append('<option value="'+e.id+'">'+e.nombre+"  ("+e.marca+')</option>');
                                $('#p_venta').val(e.p_venta);
                                $('#p_ventapm').val(e.p_ventapm);
                                $('#ubicacion').val(e.ubicacion);
                            });
                        }
                    });
                });
            }
        });
    }


    $("#sccredito").change(function()
    {
        id = this.value;
        if (id == 2) {
            $('#div_banco').show();
            $('#div_plazo').hide();
            $('#codigo_cli').removeAttr("required");
        }
        else {
            if (id == 1){
                $('#div_plazo').show();
                $('#codigo_cli').prop("required", true);
                $('#div_banco').hide();
            }
             else {
                $('#div_banco').hide();
                $('#div_plazo').hide();
                $('#codigo_cli').removeAttr("required");
             }   
        }
    });


    $("#scfactura").change(function()
    {
        id = this.value;
        url = '{{ asset("/index.php/encontrarultimaventa")}}/' + id;
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $.each(data, function(field, e) 
                {
                    console.log(e.num_factura, e.scfactura);
                    $('#num_factura').val(e.num_factura+1);
                });
            } 
        });
    });

    
</script>


<script type="text/javascript">
    var lista = new Array();
    to = 0;
    function insertarTabla(item/*objeto*/, index/*posicion*/) {
    
      var html =  "<tr>"+
                  "<td><input type='hidden' name='id_bien[]' id='id_bien' class='form-control' value='"+item.id_bien+"'>"+item.biens+"</td>"+
                  "<td><input type='hidden' name='id_articulo[]' id='id_articulo' class='form-control' value='"+item.id_articulo+"'>"+item.articulos+" </td>" +                  
                  "<td><input type='hidden' name='cantidad[]' id='cantidad' class='form-control' value='"+item.cantidad+"'>"+item.cantidad+"</td>" +
                  "<td><input type='hidden' name='p_venta[]' id='p_venta' class='form-control' value='"+item.p_venta+"'>"+item.p_venta+"</td>" +
                  "<td><input type='hidden' name='sub_total[]' id='sub_total' class='form-control' value='"+item.sub_total+"'>"+item.sub_total+"</td>" +
                  "<input type='hidden' name='detalle[]'>" +
                  "<td><b onclick=\"eliminarSeleccion("+index+")\" class=\"btn btn-danger\" > <i class=\"fa fa-trash-o\"></i> </b></td>"+
                  "</tr>"
                  "<tr>"+
                  "<td><input type='number' name='total' id='total' class='form-control' value='"+item.total+"'>"+item.total+"</td>"+
                  "</tr>";
       
       $('#cuerpo').append(html);   
    }


    function eliminarSeleccion(id){
        to -= lista[id].sub_total;
        $('#total').val(to);
        lista.splice(id, 1);
        $('#cuerpo').html("");
        if(lista.length <= 0)
            $('#bguardar').hide();
        lista.forEach(insertarTabla);
    }

    function insertar(){

      to += $('#sub_total').val()*1;
      $('#total').val(to);

      var id_bien = $('#id_bien').val();
      var id_articulo = $('#id_articulo').val();
      var cantidad = $('#cantidad').val();      
      var p_venta = $('#p_venta').val();
      var sub_total = $('#sub_total').val();
      var total = $('#total').val();
  
      var biens = $('#id_bien option:selected').text();
      var articulos = $('#id_articulo option:selected').text();
  
      
      var ingreso = {
          id_bien: id_bien,
          biens: biens,
          id_articulo: id_articulo,
          articulos: articulos,
          cantidad: cantidad,
          p_venta: p_venta,
          sub_total: sub_total,
          total: total, 
      };
      
        lista.push(ingreso);
        if(lista.length > 0)
            $('#bguardar').show();

      
      $('#cuerpo').html("");
      lista.forEach(insertarTabla);
  
      $('#id_bien').val("");
      $('#id_articulo').val("");
      $('#cantidad').val("");
      $('#cantidad_m').val("");
      $('#sub_total').val("");
      $('#p_venta').val("");
      $('#codigo_empre').val("");
      $('#codigo_fabric').val("");
      $('#ubicacion').val("");
      $('#p_ventapm').val("");
      
      $('#bien').focus();
    }
   
  
  </script>

@endsection
