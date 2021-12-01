@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6" >
        <h4>DETALLADE DE LA RESERVA</h4>
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
                        <a href="{{url('mostrarreservas')}}" class="config" style="text-align: right"><button class='btn btn-warning'><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Volver</button></a>
                        @if ($reserva->saldo <= 0)
                            @if (!strpos($reserva->codigo_reserva, 'V') !== false)
                            <button class="btn btn-outline-secondary"  type="button" onclick="insertar('{{$id}}');"><i class="glyphicon glyphicon-plus"></i>Agregar para Ventas</button>
                            @endif
                        @else
                            <a href="#NuevoPago" data-toggle="modal" class="config"><button class='btn btn-outline-secondary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Pago</button></a>
                        @endif
                                                            
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#42a8c7;color:#ffffff;text-align:center">
                              <tr>
                                  <th width=12%>CLIENTE</th>
                                  <th width=10%>NIT/CI</th>
                                  
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="gradeC">
                                  <td style="text-align: center; font-size: 10pt;">{{$reserva->cliente}}</td>
                                  <td style="text-align: center; font-size: 10pt;">{{$reserva->nit_cliente}}</td>
                               
                              </tr>
                              </tbody>
                        </table>
                        <table class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#42a8c7;color:#ffffff;text-align:center">
                              <tr>
                                  <th width=12%>FECHA</th>
                                  <th width=10%>CODIGO</th>
                                  <th width=10%>PLAZO</th>
                                  <th width=10%>ESTADO</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="gradeC">
                                  <td style="text-align: center; font-size: 10pt;">{{$reserva->fecha}}</td>
                                  <td style="text-align: center; font-size: 10pt;">{{$reserva->codigo_reserva}}</td>
                                  <td style="text-align: center; font-size: 10pt;">{{$reserva->plazo}} Días</td>
                                  <td style="text-align: center;">
                                    @if ($reserva->estado)
                                        <button class='btn btn-warning'>Pendiente</button>
                                    @else
                                        <button class='btn btn-success'>Cancelado</button>
                                    @endif
                                </td>
                              </tr>
                              </tbody>
                        </table>
                        @if ($reserva->detalle == null)
                            <table id="datatablereservadet" class="table table-bordered table-hover table-striped table-sm">
                                <thead style="background:#42a8c7;color:#ffffff;text-align:center">
                                    <tr>
                                        <th>GRUPO</th>
                                        <th>ARTICULO</th>
                                        <th width=10%>MARCA</th>
                                        <th width=8%>CANTIDAD</th>
                                        <th width=10%>P. VENTA</th>
                                        <th width=10%>SUB TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sql as $reserva)
                                    <tr class="gradeC">
                                        <td style="text-align: center;">{{$reserva->nombre_bien}}</td>
                                        <td style="text-align: center;">{{$reserva->nombre_articulo}}</td>
                                        <td style="text-align: center;">{{$reserva->marca}}</td>
                                        <td style="text-align: center;">{{$reserva->cantidad}}</td>
                                        <td style="text-align: center;">{{$reserva->p_venta}}</td>
                                        <td style="text-align: center;"> <h5> {{$reserva->sub_total}} </h5></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>   
                        @else
                            <table id="" class="table table-bordered table-hover table-striped table-sm">
                                <thead style="background:#42a8c7;color:#ffffff;text-align:center">
                                    <tr>
                                        <th width=10%>N°</th>
                                        <th>ARTICULOS A UTILIZAR</th>
                                        <th width=15%>CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1;  @endphp
                                    @foreach($sql as $reserva)
                                    <tr class="gradeC">
                                        <td style="text-align: center;"><?php echo $i++; ?></td>
                                        <td style="text-align: center;">{{$reserva->nombre_bien}}, {{$reserva->nombre_articulo}} ({{$reserva->marca}})</td>
                                        <td style="text-align: center;">{{$reserva->cantidad}}</td> 
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table id="" class="table table-bordered table-hover table-striped table-sm">
                                <thead style="background:#42a8c7;color:#ffffff;text-align:center">
                                    <tr>
                                        <th>SERVICIO</th>
                                        <th width=10%>TOTAL(Bs.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center; font-size: 14pt;">{{$reserva->detalle}}</td>
                                        <td style="text-align: center;"> <h5> {{$reserva->total}} </h5></td>
                                    </tr>
                                </tbody>
                            </table>   
                        @endif
                        
                        <div class="modal-content panel-primary">
                            <div class="modal-body">
                                <div class="card" style="text-align: center">
                                    <strong> <h4><b> TOTAL Bs. {{$reserva->total}} </b></h4></strong>
                                </div>
                                <div class="card" style="text-align: center">
                                    <strong> <h5><b> Descuento Bs. {{$reserva->descuento}} </b></h5></strong>
                                </div>
                                <div class="card" style="text-align: center">
                                    <strong> <h3><b> TOTAL NETO Bs. {{$reserva->total-$reserva->descuento}} </b></h3></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-hover table-striped table-sm">
                        <thead style="background:#343a40;color:#D0D3D4;text-align:center"> 
                            <tr>
                                <th><h5>DATOS</h5></th>
                                <th><h5>MONTO (Bs.)</h5></th>
                                <th><h5>IMPRIMIR</h5></th>
                            </tr>
                        </thead>
                        @php
                            $i= $reserva->total - $reserva->descuento;
                        @endphp
                        <tbody style="background:#42a8c7;color:#ffffff;text-align:center">
                        @foreach($sql2 as $pago)
                                <tr class="gradeC">
                                    <td width=65%>
                                        <h2>{{$pago->nombre}}</h2>
                                        <h5><b>CI:</b>{{$pago->ci}}</h5>
                                        <h2>{{$pago->fecha}}</h2>
                                    </td>
                                    <td width=30% >
                                        <h4><b>{{number_format($pago->monto,2)}}</b></h4>
                                        @if ($pago->tipo == 0)
                                            EFECTIVO
                                        @else
                                            BANCO 
                                        @endif
                                    </td>
                                    <td><br><a href="{{url('verpagoreportereserva/'.$pago->id)}}" ><button class='btn btn-warning' title="Imprimir" ><i  class="fas fa-print"></i> </button></a></td>
                                </tr>
                            @php
                                $i = $i-$pago->monto;
                            @endphp
                        @endforeach
                        </tbody>
                    </table>
                    <div class="modal-content panel-primary">
                        <div class="modal-body">
                            <div class="card" style="text-align:center; color: red">
                                <strong> <h3><b> SALDO Bs. {{$reserva->saldo}} </b></h3></strong>
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

<div class="modal fade" id="NuevoPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">NUEVO PAGO</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal crearpagoreserva" role="form" method="POST" action="{{url('crearpago')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-5">
                            <strong>CLIENTE (CI)</strong> <strong style="color: red;">*</strong>
                            <input type="text" name="cliente" value="{{$reserva->cliente}} ({{$reserva->nit_cliente}})" class='form-control' required readonly>
                        </div>
                        
                    </div>
                    <div class="row"> 
                        <div class="col-lg-3"> <br>
                            <strong>FECHA</strong> <strong style="color: red;">*</strong>
                            <input type="date" name="fecha" class='form-control' value="{{date('Y-m-d')}}" required>
                        </div>
                        <div class="col-lg-4"><br>
                            <strong>NOMBRE (Pagante)</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" name="nombre" class='form-control' required>
                        </div>
                        <div class="col-lg-3"> <br>
                            <strong>C.I. o NIT</strong> <strong style="color: red;">*</strong>
                            <input type="number" name="ci" class='form-control' required>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-3"><br>
                            <strong>MONTO (Bs.)</strong> <strong style="color: red;">*</strong>
                            <input type="number" name="monto" id="monto" class='form-control' step="0.01" onChange="control_saldo(this.value,{{$reserva->saldo}});" required>
                        </div>
                    </div>
                    <input type="hidden" name="id_credito" value="{{$reserva->identificador}}">
                    <input type="hidden" name="tipo" value="reserva">
                    <input type="hidden" name="identificador" value="{{$reserva->identificador}}">
                    
                    <div class="row">
                        <div class="col-lg-12"><br>
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Guardar Pago">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




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
                    <input type="hidden" name="reserva" id="reserva" value="1" class='form-control'>
                    <input type="hidden" name="identificador_reserva" value="{{$reserva->identificador}}" class='form-control'>
                    <input type="hidden" name="id_cliente" id="id_cliente" class='form-control'>
                    <input  type="submit" name="ejecutar" class='float-right btn btn-primary' value="Guardar">
                </div>    
            </div>
        </form>
        </div>
        </div>
    </div>


@endsection



@section('js')

<script>

$('.crearpagoreserva').submit(function(e){
        e.preventDefault();

        Swal.fire({
        title: 'Estas Seguro?',
        text: "Estas a punto de añadir un Pago!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Añadir Pago',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
        })
    });


    $(document).ready( function () {
        $('#datatablereservadet').DataTable({
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


    function mayus(e) {
        e.value = e.value.toUpperCase();
    }

    $("#sccredito").change(function()
    {
        id = this.value;
        if (id == 2) {
            $('#div_banco').show();
        }
        else {
            $('#div_banco').hide();
        }
    });


    function control_saldo(id,saldo) 
    {
        if (id > saldo) {
            alert("EL MONTO INGRESADO ES MAYOR AL SALDO");
            $('#monto').val(saldo);
        } 
    }

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
        url = '{{ asset("/index.php/encontrarreservas")}}/' + identificador;
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

