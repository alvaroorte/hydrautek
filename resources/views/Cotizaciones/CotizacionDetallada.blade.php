@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6" >
        <h4>DETALLADE DE COTIZACION</h4>
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
                        <a href="{{url('mostrarcotizaciones')}}" class="config" style="text-align: right"><button class='btn btn-warning'><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Volver</button></a>
                        <button class="btn btn-outline-secondary" type="button" onclick="insertar('{{$id}}');"><i class="glyphicon glyphicon-plus"></i>Agregar para Ventas</button>                                    
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#6d6d6d;color:#ffffff;text-align:center">
                              <tr>
                                  <th width=12%>CLIENTE</th>
                                  <th width=10%>NIT/CI</th>
                                  
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="gradeC">
                                  <td style="text-align: center; font-size: 10pt;">{{$cotizacion->cliente}}</td>
                                  <td style="text-align: center; font-size: 10pt;">{{$cotizacion->nit_cliente}}</td>
                               
                              </tr>
                              </tbody>
                        </table>
                        @if ($cotizacion->detalle == null)
                            <table id="datatablecotidet" class="table table-bordered table-hover table-striped table-sm">
                                <thead style="background:#6d6d6d;color:#ffffff;text-align:center">
                                    <tr>
                                        <th>GRUPO</th>
                                        <th>ARTICULO</th>
                                        <th>MARCA</th>
                                        <th width=8%>CANTIDAD</th>
                                        <th width=10%>P. VENTA</th>
                                        <th width=10%>SUB TOTAL</th>
                                        <th width=10%>Editar</th>
                                        <th width=10%>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sql as $cotizacion)
                                    <tr class="gradeC">
                                        <td style="text-align: center;">{{$cotizacion->nombre_bien}}</td>
                                        <td style="text-align: center;">{{$cotizacion->nombre_articulo}}</td>
                                        <td style="text-align: center;">{{$cotizacion->marca}}</td>
                                        <td style="text-align: center;">{{$cotizacion->cantidad}}</td>
                                        <td style="text-align: center;">{{$cotizacion->p_venta}}</td>
                                        <td style="text-align: center;"> <h5> {{$cotizacion->sub_total}} </h5></td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-primary" type="button" onclick="Editar('{{$cotizacion->id}}');"><i class="glyphicon glyphicon-pencil"></i></button>                                    
                                        </td>
                                        <td style="text-align: center">
                                            <form class="form-horizontal" role="form" method="POST" action="{{url('eliminarcotizacion')}}/{{$cotizacion->id}}">
                                            {{ csrf_field() }} @method('DELETE')
                                            <button class="btn btn-danger" type="submit" name="ejecutar" ><i class="glyphicon glyphicon-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>   
                        @else
                            <table id="" class="table table-bordered table-hover table-striped table-sm">
                                <thead style="background:#6d6d6d;color:#ffffff;text-align:center">
                                    <tr>
                                        <th width=10%>N°</th>
                                        <th>ARTICULOS A UTILIZAR</th>
                                        <th width=15%>CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1;  @endphp
                                    @foreach($sql as $cotizacion)
                                    <tr class="gradeC">
                                        <td style="text-align: center;"><?php echo $i++; ?></td>
                                        <td style="text-align: center;">{{$cotizacion->nombre_bien}}, {{$cotizacion->nombre_articulo}} ({{$cotizacion->marca}})</td>
                                        <td style="text-align: center;">{{$cotizacion->cantidad}}</td> 
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table id="" class="table table-bordered table-hover table-striped table-sm">
                                <thead style="background:#6d6d6d;color:#ffffff;text-align:center">
                                    <tr>
                                        <th>SERVICIO</th>
                                        <th width=10%>TOTAL(Bs.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center; font-size: 14pt;">{{$cotizacion->detalle}}</td>
                                        <td style="text-align: center;"> <h5> {{$cotizacion->total}} </h5></td>
                                    </tr>
                                </tbody>
                            </table>   
                        @endif
                        
                        <div class="modal-content panel-primary">
                            <div class="modal-body">
                                <div class="card" style="text-align: center">
                                    <strong> <h4><b> TOTAL Bs. {{$cotizacion->total}} </b></h4></strong>
                                </div>
                                <div class="card" style="text-align: center">
                                    <strong> <h5><b> Descuento Bs. {{$cotizacion->descuento}} </b></h5></strong>
                                </div>
                                <div class="card" style="text-align: center">
                                    <strong> <h3><b> TOTAL NETO Bs. {{$cotizacion->total-$cotizacion->descuento}} </b></h3></strong>
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

<div class="modal fade" id="Nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    
    <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">NUEVA VENTA</h4>
        </div>
                  
        <div class="col-auto p-5 text-center">
        <form class="form-horizontal" role="form" method="POST" action="{{url('crearsalida')}}" autocomplete="off">
            {{ csrf_field() }}
            <div class="modal-content panel-primary">
                <div class="modal-body">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-2 ">
                        <strong>DOCUMENTO</strong>
                        <select name="scfactura" id="scfactura" class="form-control"  onChange="mostrar_numfactura(this.value);" required>
                            <option value="">Seleccionar...</option>
                            <option value="1">Factura</option>
                            <option value="0">Con Retension</option>
                        </select>
                    </div>
    
                    <div class="col-lg-2 " id="div_num_factura" >
                        <strong>NUMERO de DOCUMENTO</strong>
                        <input type="number" name="num_factura" id="num_factura" class='form-control'>
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
    
                    <div class="col-lg-2">
                        <strong>FECHA</strong>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="{{date('Y-m-d')}}">
                    </div>
                </div>
    
                <div class="modal-body">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-3 ">
                        <strong>NIT CLIENTE</strong>
                        <input type="number" name="nit_cliente" id="nit_cliente" class='form-control'>
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
                        <th width=15%>GRUPO</th> 
                        <th width=20%>ARTICULO</th>
                        <th width=15%>CANTIDAD</th>
                        <th width=15%>P. VENTA</th>
                        <th width=15%>Sub Total</th>
                        
                    </tr>
                </thead>
                <tbody id="cuerpo" >

                </tbody>
            </table>
            <div class="row" id="div_servicio" style="display: none">
                <div class="col-lg-1"></div>
                <div class="col-lg-10"> 
                    <strong>SERVICIO</strong>
                    <input type="text" name="detalle" id="detalle" class='form-control' onkeyup="mayus(this);" style="text-align: center" >
                    <input type="hidden" name="tipo" id="tipo" value="0" class='form-control'>
                </div>
            </div>
            <div class="row" >
                <div class="col-lg-5"></div>
                <div class="col-lg-2"> <br>
                    <strong>Total(Bs.)</strong>
                    <input type="number" name="total" id="total" value="" step="0.01" class='form-control' style="text-align: center" required readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5"></div>
                <div class="col-lg-2">
                    <strong>Descuento(Bs.) </strong>
                    <input type="number" name="descuento" id="descuento" step="0.01" value="0" class='form-control' style="text-align: center" required>
                </div>
            </div>
            <div class="modal-dialog modal-lg">
                <div class="modal-content panel-primary">
                    <input type="hidden" name="reserva" id="reserva" value="0" class='form-control'>
                    <input type="hidden" name="id_cliente" id="id_cliente" class='form-control'>
                    <input  type="submit" name="ejecutar" class='float-right btn btn-primary' value="Guardar">
                </div>    
            </div>
        </form>
        </div>
        </div>
    </div>





<div class="modal fade" id="Editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">EDITAR COTIZACION</h4>
            </div>
            <div class="modal-body">
            <form class="form-horizontal" role="form" method="POST" action="{{url('updatecotizacion')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-3">
                            <strong>CANTIDAD </strong><strong style="color: red;">*</strong>
                            <input type="number" id="cantidad" name="cantidad" step="0.01" onkeyup="cantidad(this);" class='form-control' required>
                        </div>
                        <div class="col-lg-2">
                            <strong>SUB TOTAL </strong><strong style="color: red;">*</strong>
                            <input type="number" id="sub_total" name="sub_total" class='form-control' required readonly>
                        </div>
                        <div class="col-lg-2">
                            <strong>DESCUENTO </strong><strong style="color: red;">*</strong>
                            <input type="number" id="descuentoc" name="descuento" class='form-control' required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-3">
                            <strong>TOTAL </strong>
                            <input type="number" id="totalc" name="total" class='form-control' required readonly>
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

@endsection



@section('js')

<script>
    $(document).ready( function () {
        $('#datatablecotidet').DataTable({
            dom: 'f',
        
      "order": [[ 0, 'desc']],
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

    function Editar(id) {
        url = '{{ asset("/index.php/buscarcotizacion")}}/' + id;
        $.getJSON(url, null, function(data) {
            if (data.length > 0) {
                $.each(data, function(field, e) {
                    $('#id').val(e.id);
                    $('#cantidad').val(e.cantidad);
                    $('#sub_total').val(e.sub_total);
                    $('#totalc').val(e.total);
                    $("#descuentoc").val(e.descuento);
                    
                    $("#cantidad").keyup(function()
                    {
                        id = this.value*1;
                        url = '{{ asset("/index.php/encontrararticulo")}}/' + e.id_articulo;
                        $.getJSON(url, null, function(data) {
                            if (data.length > 0) 
                            {
                                $.each(data, function(field, f) 
                                {
                                    if (id>f.cantidad) {
                                        $("#cantidad").val(f.cantidad);
                                        alert("LA CANTIDAD INTRODUCIDA ES MAYOR AL STOCK DEL PRODUCTO");
                                    } else {
                                        st = $("#sub_total").val();
                                        $("#sub_total").empty();
                                        $("#sub_total").val(e.p_venta*id);
                                        st2 = $("#sub_total").val();
                                        $("#totalc").empty();
                                        $("#totalc").val(($("#totalc").val()*1)-(st-st2));
                                    }
                                });
                            }
                        });
                    });

                });
                $("#Editar").modal('show');
            }
        });
    }

    
    function Eliminar(id) {
        url = '{{ asset("/index.php/eliminarcotizacion")}}/' + id;
    }

    function mayus(e) {
        e.value = e.value.toUpperCase();
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

</script>



<script type="text/javascript">
    var lista = new Array();
    to = 0;
    function insertarTabla(item/*objeto*/, index/*posicion*/) {
        
      var html =  "<tr>"+
                  "<td><input type='hidden' name='id_bien[]' id='id_bien' class='form-control' value='"+item.id_bien+"'>"+item.bien+"</td>"+
                  "<td><input type='hidden' name='id_articulo[]' id='id_articulo' class='form-control' value='"+item.id_articulo+"'>"+item.articulo+' ('+item.marca+")</td>" +                  
                  "<td><input type='hidden' name='cantidad[]' id='cantidad' class='form-control' value='"+item.cantidad+"'>"+item.cantidad+"</td>" +
                  "<td><input type='hidden' name='p_venta[]' id='p_venta' class='form-control' value='"+item.p_venta+"'>"+item.p_venta+"</td>" +
                  "<td><input type='hidden' name='sub_total[]' id='sub_total' class='form-control' value='"+item.sub_total+"'>"+item.sub_total+"</td>" +
                  "</tr>";
       
       $('#cuerpo').append(html);   
    }

    function insertar(identificador){
      url = '{{ asset("/index.php/encontrarcotizaciones")}}/' + identificador;
                        $.getJSON(url, null, function(data) 
                        {
                            if (data.length > 0) 
                            {
                                $.each(data, function(field, e) 
                                {  
                                    url = '{{ asset("/index.php/editarbien")}}/' + e.id_bien;
                                    $.getJSON(url, null, function(data) 
                                    {
                                        if (data.length > 0) 
                                        {
                                            $.each(data, function(field, g) 
                                            {
                                                url = '{{ asset("/index.php/encontrararticulo")}}/' + e.id_articulo;
                                                $.getJSON(url, null, function(data) 
                                                {
                                                    if (data.length > 0) 
                                                    {
                                                        $.each(data, function(field, f) 
                                                        {
                                                            var id_bien = e.id_bien;
                                                            var id_articulo = e.id_articulo;
                                                            var cantidad = e.cantidad;
                                                            var p_venta = e.p_venta;
                                                            var sub_total = e.sub_total;
                                                            var articulo = f.nombre;
                                                            var bien = g.nombre;
                                                            var marca = f.marca;
                                                            console.log(f.nombre,"arti");

                                                            var ingreso = 
                                                            {
                                                                id_bien: id_bien,
                                                                id_articulo: id_articulo,
                                                                cantidad: cantidad, 
                                                                p_venta: e.p_venta,
                                                                sub_total: sub_total,
                                                                articulo: articulo,
                                                                bien: bien,
                                                                marca: marca,
                                                            };
                                                            lista.push(ingreso);
                                                            $('#nit_cliente').val(e.nit_cliente);
                                                            $('#cliente').val(e.cliente);
                                                            $('#total').val(e.total);
                                                            $('#descuento').val(e.descuento);
                                                            $('#cuerpo').html("");
                                                            if (e.detalle != null ) {
                                                                $('#detalle').val(e.detalle);
                                                                $('#tipo').val(1);
                                                                $('#div_servicio').show();
                                                            }
                                                            lista.forEach(insertarTabla);
                                                        });
                                                    } 
                                                });
                                            });
                                        }
                                        else {
                                            $('#detalle').val(e.detalle);
                                            $('#tipo').val(1);
                                            $('#div_servicio').show();
                                            $('#nit_cliente').val(e.nit_cliente);
                                            $('#cliente').val(e.cliente);
                                            $('#total').val(e.total);
                                            $('#descuento').val(e.descuento);
                                        } 
                                    });
                                                
                                });
                            }
                        });
      
      $('#bien').focus();
      $("#Nuevo").modal('show')
    }
   
  
  </script>



@endsection

