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
            <input type="hidden" name="id_bien" id="id_bien" value="0" class='form-control' required>
            <input type="hidden" name="id_articulo" id="id_articulo" value="0" class='form-control' required>
            <div class="col-lg-10">
                <strong>SERVICIO </strong> <strong style="color: red;">*</strong>
                <input type="text" name="detalle" id="detalle" onkeyup="mayus(this);" class='form-control' required>
            </div>
        </div>
        <div class="modal-body">
            <div class="col-lg-2 ">
                <strong>P. VENTA </strong> <strong style="color: red;">*</strong>
                <input type="number" name="p_venta" id="p_venta" step="0.01" onkeyup="p_ventas(this);" class='form-control' required>
            </div>
            <div class="col-lg-2">
                <strong>CANTIDAD </strong> <strong style="color: red;">*</strong>
                <input type="number" name="cantidad" id="cantidad" onkeyup="cantidad(this);" class='form-control' required>
            </div>
            <div class="col-lg-2">
                <strong>SUB TOTAL </strong> <strong style="color: red;">*</strong>
                <input type="number" name="sub_total" id="sub_total" step="0.01" class='form-control' required readonly>
            </div>   

        </div>
        <div class="modal-body">
            
            <div class="col-lg-2">
                <b onclick="insertar()" class="btn btn-success"> <i class="fa fa-plus">Agregar</i> </b>    
            </div> 
        </div>
                  
        <div class="col-auto p-5 text-center">
        <form class="form-horizontal preguntarcoti" role="form" method="POST" action="{{('crearcotizacion')}}" autocomplete="off">
            {{ csrf_field() }}
            <div class="modal-content panel-primary">
                
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
                        <th>SERVICIO</th> 
                        <th width=15%>CANTIDAD</th>
                        <th width=15%>P. VENTA</th>
                        <th width=15%>SUB TOTAL</th>
                        <th width=10%>Borrar</th>
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
                    <input type="number" name="descuento" id="descuento" step="0.01" value="0" class='form-control' style="text-align: center" required>
                </div>
            </div>
            <div class="modal-dialog modal-lg">
                <div class="modal-content panel-primary" id="bguardar" style="display: none">
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

$('.preguntarcoti').submit(function(e){
        e.preventDefault();

        Swal.fire({
        title: 'Estas Seguro?',
        text: "Estas a punto de crear una Cotizacion!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Crear Cotizacion',
        cancelButtonText: 'Cancelar',
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
        $("#sub_total").empty();
        $("#sub_total").val($("#p_venta").val()*id);
                    
       
    }

    $("#cantidad").change(function()
    {
        id = this.value;
        $("#sub_total").empty();
        $("#sub_total").val($("#p_venta").val()*id);
    });

    $("#p_venta").change(function()
    {
        id = $("#p_venta").val()*1;
        $("#sub_total").empty();
        $("#sub_total").val($("#cantidad").val()*id);
    });


    function p_ventas(id) {
        id = id.value*1;
        $("#sub_total").empty();
        $("#sub_total").val($("#cantidad").val()*id);
    };

    function mayus(e) {
        e.value = e.value.toUpperCase();
    }

</script>

<script type="text/javascript">
    var lista = new Array();
    
    to = 0;
  
    function insertarTabla(item, index) {
      
      var html =  "<tr>"+
        "<td><input type='hidden' name='detalle[]' id='detalle' class='form-control' value='"+item.detalle+"'>"+item.detalle+"</td>"+
        "<input type='hidden' name='id_bien[]' id='id_bien' class='form-control' value='"+item.id_bien+"'>"+
        "<input type='hidden' name='id_articulo[]' id='id_articulo' class='form-control' value='"+item.id_articulo+"'>"+                  
        "<td><input type='hidden' name='cantidad[]' id='cantidad' class='form-control' value='"+item.cantidad+"'>"+item.cantidad+"</td>" +
        "<td><input type='hidden' name='p_venta[]' id='p_venta' class='form-control' value='"+item.p_venta+"'>"+item.p_venta+"</td>" +
        "<td><input type='hidden' name='sub_total[]' id='sub_total' class='form-control' value='"+item.sub_total+"'>"+item.sub_total+"</td>" +
        "<td><b onclick=\"eliminarSeleccion("+index+")\" class=\"btn btn-danger\" > <i class=\"fa fa-trash-o\"></i> </b></td>"+
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
        var detalle = $('#detalle').val();
        var sub_total = $('#sub_total').val()
        var p_venta = $('#p_venta').val()
        var biens = $('#id_bien option:selected').text();
        var articulos = $('#id_articulo option:selected').text();
  
      
        var ingreso = {
            id_bien: id_bien,
            biens: biens,
            id_articulo: id_articulo,
            articulos: articulos,
            detalle: detalle,
            cantidad: cantidad,
            fecha: fecha,
            sub_total: sub_total,
            p_venta: p_venta,
  
        };
        lista.push(ingreso);
        if(lista.length > 0)
            $('#bguardar').show();
        $('#cuerpo').html("");
        lista.forEach(insertarTabla);
    
        $('#detalle').val("");
        $('#cantidad').val("");
        $('#sub_total').val("");
        $('#p_venta').val("");
        
        $('#bien').focus();
    }
   
  
  </script>
  


@endsection
