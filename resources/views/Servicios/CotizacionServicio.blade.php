@php
    
use App\Models\Cliente;
@endphp
@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>COTIZACION DE SERVICIO</h2>
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
    
    <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">NUEVA COTIZACION</h4>
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
        </div>
        <div class="modal-body">
            <div class="col-lg-2">
                <strong>GRUPO</strong> <strong style="color: red;">*</strong>
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
                
            <div class="col-lg-2 ">
                <strong>CANTIDAD </strong> <strong style="color: red;">*</strong>
                <input type="number" name="cantidad" id="cantidad" onkeyup="cantidad(this);" class='form-control' required>
            </div>

            <div class="col-lg-2">
                <strong>Cantidad disponible </strong>
                <input type="number" name="cantidad_m" id="cantidad_m" class='form-control' required readonly>
            </div>
        </div>
        <div class="modal-body">
                <input type="hidden" name="p_venta" id="p_venta" onkeyup="p_ventas(this);" class='form-control' required >
                <input type="hidden" name="sub_total" id="sub_total" class='form-control' required readonly>
            
            <div class="col-lg-2">
                <b onclick="insertar()" class="btn btn-success"> <i class="fa fa-plus">Agregar</i> </b>    
            </div> 
        </div>
                  
        <div class="col-auto p-5 text-center">
        <form class="form-horizontal" role="form" method="POST" action="{{('crearcotizacion')}}" autocomplete="off">
            {{ csrf_field() }}
            <div class="modal-content panel-primary">
                <div class="modal-body">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <strong>SERVICIO</strong>
                        <input type="text" name="detalle" id="detalle" onkeyup="mayus(this);" class="form-control" >
                    </div>
                </div>
                <div class="modal-body">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-3">
                        <strong>FECHA</strong>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="{{date('Y-m-d')}}">
                    </div>
                    <div class="col-lg-2 ">
                        <strong>VALIDEZ(dias)</strong>
                        <input type="number" name="validez" id="validez" class='form-control' required>
                    </div>
                </div>
    
                <div class="modal-body">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-3 ">
                        <strong>CODIGO CLIENTE</strong>
                        <input type="text" name="codigo_cli" id="codigo_cli" onkeyup="codigo_clien(this);" class='form-control'>
                    </div>
                    <div class="col-lg-3 ">
                        <strong>NIT CLIENTE</strong>
                        <input type="number" name="nit_cliente" id="nit_cliente" onkeyup="nit_cli(this);" class='form-control' required>
                    </div>
                    <div class="col-lg-3">
                        <strong>CLIENTE</strong> <strong style="color: rgb(255, 0, 0);">*</strong>
                        <input type="text" name="cliente" id="cliente" class='form-control' required>
                    </div>
                </div>
                    
            </div>
            <table class="table table-bordered table-hover table-striped table-sm">
                <thead>
                    <tr class="col-auto bg-secondary">
                        <th>GRUPO</th> 
                        <th>ARTICULO</th>
                        <th width=10%>CANTIDAD</th>
                        <th width=10%>P. VENTA</th>
                        <th width=10%>SUB TOTAL</th>
                        <th width=8%>Borrar</th>
                        
                    </tr>
                </thead>
                <tbody id="cuerpo" >

                </tbody>
            </table>
            <div class="row" >
                <div class="col-lg-4"></div>
                <div class="col-lg-2"> 
                    <strong>Total(Bs.)</strong>
                    <input type="number" name="total" id="total" value="" step="0.01" class='form-control' style="text-align: center" required>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-2">
                    <strong>Descuento(Bs.) </strong>
                    <input type="number" name="descuento" id="descuento" step="0.01" value="0" class='form-control' style="text-align: center" required>
                </div>
            </div>
            <div class="modal-dialog modal-lg">
                <div class="modal-content panel-primary">
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
                    $('#p_venta').val(0);
                });
            }
        });
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
                            $('#id_cliente').val(e.id);
                            $('#codigo_cli').val(e.codigo_cli);
                        });
                    }
                    else {
                        $('#id_cliente').val("");
                        $('#cliente').val("");
                        $('#codigo_cli').val("");
                    }        
                });
    }

    function codigo_clien(id) {
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
                        $('#id_cliente').val("");
                        $('#cliente').val("");
                        $('#nit_cliente').val("");
                    }        
                });
    }


    function cantidad(id) {
        id = id.value*1;
        url = '{{ asset("/index.php/encontrararticulo")}}/' + $("#id_articulo").val();
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $.each(data, function(field, e) 
                {
                        $("#sub_total").empty();
                        $("#sub_total").val($("#p_venta").val()*id);
                    
                });
            }
        });
    }

    $("#cantidad").change(function()
    {
        id = this.value;
        url = '{{ asset("/index.php/encontrararticulo")}}/' + $("#id_articulo").val();
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $.each(data, function(field, e) 
                {
                        $("#sub_total").empty();
                        $("#sub_total").val($("#p_venta").val()*id);
                    
                });
            }
        });
    });

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

    function mayus(e) {
        e.value = e.value.toUpperCase();
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
                            });
                        }
                    });
                });
            }
        });
    }

    
</script>

<script type="text/javascript">
    var lista = new Array();
   
  
    function insertarTabla(item, index) {
      
      var html =  "<tr>"+
                  "<td><input type='hidden' name='id_bien[]' id='id_bien' class='form-control' value='"+item.id_bien+"'>"+item.biens+"</td>"+
                  "<td><input type='hidden' name='id_articulo[]' id='id_articulo' class='form-control' value='"+item.id_articulo+"'>"+item.articulos+" </td>" +                  
                  "<td><input type='hidden' name='cantidad[]' id='cantidad' class='form-control' value='"+item.cantidad+"'>"+item.cantidad+"</td>" +
                  "<td><input type='hidden' name='p_venta[]' id='p_venta' class='form-control' value='"+item.p_venta+"'>"+item.p_venta+"</td>" +
                  "<td><input type='hidden' name='sub_total[]' id='sub_total' class='form-control' value='"+item.sub_total+"'>"+item.sub_total+"</td>" +
                  "<td><b onclick=\"eliminarSeleccion("+index+")\" class=\"btn btn-danger\" > <i class=\"fa fa-trash-o\"></i> </b></td>"+
                  "</tr>";
       
       $('#cuerpo').append(html);
       
    }


    function eliminarSeleccion(id){
    delete lista[id];
    $('#cuerpo').html("");
    lista.forEach(insertarTabla);
  }
  to = 0;
    function insertar(){

      to += $('#sub_total').val()*1;
      $('#total').val(to);

      var id_bien = $('#id_bien').val();
      var id_articulo = $('#id_articulo').val();
      var cantidad = $('#cantidad').val();
      var fecha = $('#fecha').val();
      var sub_total = 0;
      var p_venta = 0;
      var biens = $('#id_bien option:selected').text();
      var articulos = $('#id_articulo option:selected').text();
  
      
      var ingreso = {
          id_bien: id_bien,
          biens: biens,
          id_articulo: id_articulo,
          articulos: articulos,
          cantidad: cantidad,
          fecha: fecha,
          sub_total: sub_total,
          p_venta: p_venta,
  
      };
      lista.push(ingreso);
      $('#cuerpo').html("");
      
      lista.forEach(insertarTabla);
  
      $('#id_bien').val("");
      $('#id_articulo').val("");
      $('#cantidad').val("");
      $('#cantidad_m').val("");
      $('#codigo_empre').val("");
      $('#codigo_fabric').val("");
      
      $('#bien').focus();
    }
   
  
  </script>
  


@endsection
