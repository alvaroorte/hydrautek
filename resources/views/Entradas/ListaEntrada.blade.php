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
                        <a href="#Nuevo" data-toggle="modal" class="config"><button class='btn btn-outline-success'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nueva Compra</button></a>
                        <button type="button" class="btn btn-secondary">
                            <span class="badge bg-success">{{$cantidad}}</span> Compras Registradas
                        </button>
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table id="datatableentrada" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#05cca1;color:#e8f3f7;text-align:center">
                                <tr>
                                    <th width=5%>N°</th>
                                    <th width=8%>CODIGO COMPRA</th>
                                    <th width=10%>FECHA</th>
                                    <th width=18%>PROVEEDOR (NIT)</th>
                                    <th width=10%>N° DOCUMENTO</th>
                                    <th>TOTAL(Bs.)</th>
                                    <th>DOCUMENTO</th>
                                    <th>PAGO</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($sql as $entradas)
                                <tr class="gradeC">
                                    <td style="text-align: center;">{{$entradas->num_entrada}}</td>
                                    <td style="text-align: center;">{{$entradas->codigo}}</td>
                                    <td style="text-align: center;">{{\Carbon\Carbon::parse($entradas->fecha)->format('d-m-Y')}}</td>                              
                                    <td style="text-align: center;">{{$entradas->proveedor}} ({{$entradas->nit_proveedor}})</td>
                                    <td style="text-align: center;">{{$entradas->num_factura}}</td>
                                    <td style="text-align: right;">{{number_format($entradas->total,2)}}</td>
                                    <td style="text-align: center;"> 
                                        @if ( $entradas->csfactura == 1)
                                            <button type="button" class="btn btn-success"> Factura </button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-sm"> Nota Remision </button>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">  
                                        @if ( $entradas->cscredito == 1)
                                            <button type="button" class="btn btn-warning"> Credito </button>
                                        @else
                                            @if ($entradas->cscredito == 2)
                                                <button type="button" class="btn btn-secondary"> Banco </button>
                                            @else
                                                <button type="button" class="btn btn-primary"> Efectivo </button>
                                            @endif
                                        @endif
                                     </td>
                                    <td style="text-align: center;"> <a href="{{'entradadetallada/'.$entradas->identificador}}"><button class='btn btn-info'>Ver Detalle</button></a></td>
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
</div>
</div>
</div>

@endsection

@section('modal')
<div class="modal fade" id="Nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">NUEVA COMPRA</h4>
            </div>

            
            <div class="modal-body">

                <div class="col-lg-3 ">
                    <strong>CODIGO DE EMPRESA</strong>
                    <input type="text" name="codigo_empre" id="codigo_empre" onchange="codigo_empresa(this);" class='form-control'>
                </div>
                <div class="col-lg-3 ">
                    <strong>DESCRIPCION</strong>
                    <input type="text" name="descripcion" id="descripcion" onchange="buscar_articulos(this);" class='form-control'>
                </div>
                <div class="col-lg-3">
                    <strong>ARTICULOS</strong>
                    <select name="articulos_encontrados" id="articulos_encontrados" onchange="articulo_seleccionado(this);" class="form-control" required>
                        <option value="">Seleccionar...</option>     
                    </select>
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

                <div class="col-lg-6" >
                    <strong>ARTICULO</strong> <strong style="color: rgb(255, 0, 0);">*</strong>
                    <select name="id_articulo" id="id_articulo" class="form-control" required>
                        <option value="">Seleccionar...</option>
                    </select>
                </div>

                <div class="col-lg-2" >
                    <strong>MARCA</strong> <strong style="color: rgb(255, 0, 0);">*</strong>
                    <select name="marca" id="marca" class="form-control" required>
                        <option value="">Seleccionar...</option>

                    </select>
                </div>
            </div>                  
            <div class="modal-body">  
                <div class="col-lg-2 ">
                    <strong>P. UNITARIO</strong>
                    <input type="number" name="p_unitario" id="p_unitario" value="" onkeyup="p_unitario(this);" class='form-control' required>
                </div>
                <div class="col-lg-2 " id="div_costo">
                    <strong>COSTO</strong>
                    <input type="number" name="costo" id="costo"  class='form-control' required readonly>
                </div>
                <div class="col-lg-2">
                    <strong>CANTIDAD </strong> <strong style="color: red;">*</strong>
                    <input type="number" name="cantidad" id="cantidad" value="" onkeyup="cantidad(this);" class='form-control' required>
                </div>
                
                <div class="col-lg-2">
                    <strong>SUB. TOTAL </strong> <strong style="color: red;">*</strong>
                    <input type="number" name="p_total" id="p_total" step="0.01" class='form-control' readonly>
                </div>
                <div class="col-lg-2">
                    <strong>P. de VENTA</strong>
                    <input type="number" name="p_venta" id="p_venta" value="" class='form-control' required>
                </div>

                
            </div>
            
            <div class="modal-body">
                <div class="col-lg-1"><br>
                    <b onclick="insertar()" class="btn btn-success" > <i class="fa fa-plus">Agregar</i> </b> 
                </div>

            </div>
            
            <br><br>
            <div class="col-auto p-5 text-center">
            <form  role="form" method="POST" class="crearentrada" action="{{('crearEntrada')}}" autocomplete="off">
                {{ csrf_field() }}
                <div class="modal-content panel-primary">
                    <div class="modal-body">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-2">
                            <strong>FECHA</strong>
                            <input type="date" name="fecha" id="fecha" class="form-control" value="{{date('Y-m-d')}}" required>
                        </div>
                        <div class="col-lg-2 ">
                            <strong>DOCUMENTO</strong>
                            <select name="csfactura" id="csfactura" class="form-control"  required>
                                <option value="1">Factura</option>
                                <option value="0">Con Retension</option>
                            </select>
                        </div>
        
                        <div class="col-lg-2 " id="div_num_factura">
                            <strong>NUMERO de DOCUMENTO</strong>
                            <input type="number" name="num_factura" id="num_factura" class='form-control' required>
                        </div>
        
                        <div class="col-lg-2 ">
                            <strong>FORMA DE PAGO</strong>
                            <select name="cscredito" id="cscredito" class="form-control" required>
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
                    </div>
        
                    <div class="modal-body">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-2 ">
                            <strong>CODIGO PROV.</strong>
                            <input type="text" name="codigo_prov" id="codigo_prov" onkeyup="codigo_prove(this);" class='form-control'>
                        </div>
                           
                        <div class="col-lg-2 ">
                            <strong>NIT PROVEEDOR</strong>
                            <input type="number" name="nit_proveedor" id="nit_proveedor"  onkeyup="nit_prov(this);" class='form-control'>
                        </div>
                        <div class="col-lg-3 ">
                            <strong>PROVEEDOR</strong>
                            <input onkeyup="mayus(this);" type="text" name="proveedor" id="proveedor" class='form-control'>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-hover table-striped table-sm">
                    <thead>
                        <tr class="col-auto bg-secondary">
                            <th>GRUPO</th> 
                            <th>ARTICULO</th>
                            <th width=8%>P. UNITARIO</th>
                            <th width=8%>CANTIDAD</th>
                            <th width=8%>SUB TOTAL</th>
                            <th width=8%>P. VENTA</th>
                            <th width=5%>Borrar</th>
                            
                        </tr>
                    </thead>
                    <tbody id="cuerpo" >

                    </tbody>
                </table>
                <div class="modal-body" >
                    <div ><br>
                        <strong>Total </strong>
                        <input type="number" name="total" id="total" value="" step="0.01" class='form-control' style="text-align: center" readonly>
                    </div><br>
                </div>

                <div class="modal-dialog modal-lg">
                    <div class="modal-content panel-primary" id="bguardar" style="display: none">
                        <input type="hidden" name="id_proveedor" id="id_proveedor" class='form-control'>
                        <input type="submit" name="ejecutar" id="ejecutar" class='float-right btn btn-primary' value="Guardar Compra">          
                    </div>
                </div>  
            </form>
            
        </div>
    </div>
        <!-- /.modal-content -->
    </div>
    

    <!-- /.modal-dialog -->

@endsection

@section('js')

<script>

$(document).ready( function () {
        $('#datatableentrada').DataTable({
            
      dom: '<"html5buttons"B>lfgtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>',
                title: 'Lista de Compras',
                titleAttr: 'Exportar a excel',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5] }
            },
            {
                extend: 'pdfHtml5',
                text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>',
                title: 'Lista de Compras',
                titleAttr: 'Exportar a PDF',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5] }
            },
            {
                extend: 'print',
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>',
                title: 'Lista de Compras',
                titleAttr: 'Imprimir',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
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

    $('.crearentrada').submit(function(e){
        e.preventDefault();

        Swal.fire({
        title: 'Estas Seguro?',
        text: "Estas a punto de añadir una compra!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Crear compra',
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

    
</script>

@if (Session::has('crearcompra'))
    <script>
        Swal.fire(
        'Correcto!',
        'La Compra se creo correctamente.',
        'success'
        )
    </script>
@endif

<script>

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
                            $('#codigo_prov').val(e.codigo_prov);
                            $('#id_proveedor').val(e.id);
                        });
                    }
                    else {
                        $('#proveedor').val("");
                        $('#codigo_prov').val("");
                        $('#id_proveedor').val("");
                    }        
                });
    }

    function codigo_prove(id) {
        codigo = id.value;
        url = '{{ asset("/index.php/buscarproveedorcodigo")}}/' + codigo;
                $.getJSON(url, null, function(data) 
                {
                    if (data.length > 0) 
                    {
                        $.each(data, function(field, e) 
                        {
                            console.log("sssssss");
                            $('#proveedor').val(e.nombre);
                            $('#nit_proveedor').val(e.nit);
                            $('#id_proveedor').val(e.id);
                        });
                    }
                    else {
                        $('#proveedor').val("");
                        $('#nit_proveedor').val("");
                        $('#id_proveedor').val("");
                    }        
                });
    }

    $("#id_bien").change(function()
        {
            id=this.value;
        $("#id_articulo").empty();
                url = '{{ asset("/index.php/encontrararticulos")}}/' + id;
                $.getJSON(url, null, function(data) 
                {
                    if (data.length > 0) 
                    {
                        $('#id_articulo').append('<option value="">Seleccionar..</option>');
                        $.each(data, function(field, e) 
                        {
                            $('#id_articulo').append('<option value="'+e.id+'">'+e.nombre+'</option>');
                        });
                    }        
                });
    });

    $("#id_articulo").change(function()
    {
        id=this.value;
        $("#marca").empty();
        url = '{{ asset("/index.php/encontrararticulo")}}/' + id;
        $.getJSON(url, null, function(data) 
        {
            if (data.length > 0) 
            {
                $.each(data, function(field, e) 
                {
                    $('#p_venta').val(e.p_venta);
                    $('#marca').append('<option value="'+e.id+'">'+e.marca+'</option>');
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
                        $("#p_total").empty();
                        $("#p_total").val($('#p_unitario').val()*id);
                    
                });
            }
        });
    }
    $("#cantidad").change(function()
    {
        id=this.value;
        $("#p_total").empty();
        $('#p_total').val($('#p_unitario').val()*$('#cantidad').val());
    });


    function p_unitario(id) {
        id = id.value*1;
        if (($("#csfactura").val()*1) == 1) {
            $("#costo").val(id*0.87);
        } else {
            $("#costo").val(id);
        }
        url = '{{ asset("/index.php/encontrararticulo")}}/' + $("#id_articulo").val();
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $.each(data, function(field, e) 
                {
                        $("#p_total").empty();
                        $("#p_total").val($('#cantidad').val()*id);
                    
                });
            }
        });
    }
    $("#p_unitario").change(function()
    {
        id=this.value*1;
        if (($("#csfactura").val()*1) == 1) {
            $("#costo").val(id*0.87);
        } else {
            $("#costo").val(id);
        }
        $("#p_total").empty();
        $('#p_total').val($('#p_unitario').val()*$('#cantidad').val());
    });

    $("#csfactura").change(function()
    {
        id=this.value*1;
        if (id == 1) {
            $("#costo").val($("#p_unitario").val()*0.87);
        } else {
            $("#costo").val($("#p_unitario").val());
        }
        $("#p_total").empty();
        $('#p_total').val($('#p_unitario').val()*$('#cantidad').val());
    });


    function codigo_barra(codigo) {
        codigo = codigo.value*1;
        url = '{{ asset("/index.php/encontrararticulocodigobarra")}}/' + codigo;
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $.each(data, function(field, e) 
                {
                    url = '{{ asset("/index.php/editarbien")}}/' + e.id_bien;
                    $.getJSON(url, null, function(data) {
                        if (data.length > 0) 
                        {
                            $.each(data, function(field, f) 
                            {
                                $('#id_bien').val(e.id_bien);
                                $('#marca').empty();
                                $('#marca').append('<option value="'+e.marca+'">'+e.marca+'</option>');
                                $("#p_venta").val(e.p_venta);
                                $('#id_articulo').empty();
                                $('#id_articulo').append('<option value="'+e.id+'">'+e.nombre+'</option>');
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
                $.each(data, function(field, e) 
                {
                    url = '{{ asset("/index.php/editarbien")}}/' + e.id_bien;
                    $.getJSON(url, null, function(data) {
                        if (data.length > 0) 
                        {
                            $.each(data, function(field, f) 
                            {
                                $('#id_bien').val(e.id_bien);
                                $('#id_articulo').empty();
                                $('#id_articulo').append('<option value="'+e.id+'">'+e.nombre+'</option>');
                                $('#marca').empty();
                                $('#marca').append('<option value="'+e.marca+'">'+e.marca+'</option>');
                                $("#p_venta").val(e.p_venta);
                            });
                        }
                    });
                });
            }
        });
    }

    function buscar_articulos(codigo) {
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
        $('#articulos_encontrados').empty();
        if (inicio > 0) {
            url = '{{ asset("/index.php/encontrararticulonombres")}}/'+p+'/'+p2;
        }
        else {
            url = '{{ asset("/index.php/encontrararticulonombre")}}/' + codigo;
        }
        console.log(codigo);
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $('#articulos_encontrados').append('<option value="">Seleccionar...</option>');
                $.each(data, function(field, e) 
                {    
                    $('#articulos_encontrados').append('<option value="'+e.id+'">'+e.nombre+"  ("+e.marca+')</option>');
                });
            }
        });
    }

    function articulo_seleccionado(id) {
        id = id.value;
        url = '{{ asset("/index.php/encontrararticulo")}}/' + id;
        $.getJSON(url, null, function(data) {
            if (data.length > 0) 
            {
                $.each(data, function(field, e) 
                {
                    $('#id_bien').val(e.id_bien);
                    $('#id_articulo').empty();
                    $('#marca').empty();
                    $('#id_articulo').append('<option value="'+e.id+'">'+e.nombre+"  ("+e.marca+')</option>');
                    $('#p_venta').val(e.p_venta);
                    $('#marca').append('<option value="'+e.id+'">'+e.marca+'</option>');
                });
            }
        });
    }


    $("#cscredito").change(function()
    {
        id = this.value;
        if (id == 2) {
            $('#div_banco').show();
            $('#div_plazo').hide();
            $('#codigo_prov').removeAttr("required");
        }
        else {
            if (id == 1){
                $('#div_plazo').show();
                $('#codigo_prov').prop("required", true);
                $('#div_banco').hide();
            }
             else {
                $('#div_banco').hide();
                $('#div_plazo').hide();
                $('#codigo_prov').removeAttr("required");
             }   
        }
    });


</script>

@if (Session::has('eliminar'))
    <script>
        Swal.fire(
        'Eliminado!',
        'Los datos de la compra fueron borrados.',
        'success'
        )
    </script>
@endif

<script type="text/javascript">
    var lista = new Array();
    to = 0;

    function insertarTabla(item,index) {
       
        var html =  "<tr>"+
            
            "<td><input type='hidden' name='id_bien[]' id='id_bien' class='form-control' value='"+item.bien+"'>"+item.biens+"</td>"+
            "<td><input type='hidden' name='id_articulo[]' id='id_articulo' class='form-control' value='"+item.articulo+"'>"+item.articulos+" </td>" +
            "<td><input type='hidden' name='p_unitario[]' id='p_unitario' class='form-control' value='"+item.p_unitario+"'>"+item.p_unitario+"</td>" +
            "<td><input type='hidden' name='cantidad[]' id='cantidad' class='form-control' value='"+item.cantidad+"'>"+item.cantidad+"</td>" +
            "<td><input type='hidden' name='p_total[]' id='p_total' class='form-control' value='"+item.p_total+"'>"+item.p_total+"</td>" +
            "<td><input type='hidden' name='p_venta[]' id='p_venta' class='form-control' value='"+item.p_venta+"'>"+item.p_venta+"</td>" +
            "<input type='hidden' name='costo' id='costo' class='form-control' value='"+item.detalle+"'>" +
            "<td><b onclick=\"eliminarSeleccion("+index+")\" class=\"btn btn-danger\" > <i class=\"fa fa-trash-o\"></i> </b></td>"+ 
            "</tr>";
        $('#cuerpo').append(html);
        console.log('insertar');
        console.log(lista);
    }

    function eliminarSeleccion(id){
        to -= lista[id].p_total;
        $('#total').val(to);
        lista.splice(id, 1);
        $('#cuerpo').html("");
        if(lista.length <= 0)
            $('#bguardar').hide();
        lista.forEach(insertarTabla);
    }

    function insertar(){
        to += $('#p_total').val()*1;
        $('#total').val(to);

        var bien = $('#id_bien').val();
        var articulo = $('#id_articulo').val();
        var marca = $('#marca').val();
        var cantidad = $('#cantidad').val();
        var costo = $('#costo').val();
        var p_unitario = $('#p_unitario').val();
        var p_total = $('#p_total').val();
        var p_venta = $('#p_venta').val();
        if(bien == "") {
            alert("POR FAVOR SELECCIONE UN GRUPO");
            return;
        } else {
            if (articulo == "") {
                alert("POR FAVOR SELECCIONE UN ARTICULO");
                return;
            } else {
                if (cantidad == "" || cantidad == 0 ) {
                    alert("POR FAVOR INTRODUZCA LA CANTIDAD");
                    return;
                } else {
                    if(p_unitario == "") {
                        alert("POR FAVOR INTRODUZCA EL PRECIO UNITARIO");
                        return;
                    }
                    else {
                        if(p_venta == "") {
                            alert("POR FAVOR INTRODUZCA EL PRECIO DE VENTA");
                            return;
                        }
                    }
                }
            }
        }


        var biens = $('#id_bien option:selected').text();
        var articulos = $('#id_articulo option:selected').text();
        var marcas = $('#marca option:selected').text();

        
        var ingreso = {
            bien: bien,
            biens: biens,
            articulo: articulo,
            articulos: articulos,
            marca: marca,
            marcas: marcas,
            cantidad: cantidad,
            costo: costo,
            p_unitario: p_unitario,
            p_total : p_total,
            p_venta : p_venta,
        };
        
        lista.push(ingreso);
        
        if(lista.length > 0)
            $('#bguardar').show();

        $('#cuerpo').html("");
        lista.forEach(insertarTabla);
        
        $('#id_bien').val("");
        $('#id_articulo').val("");
        $('#marca').val("");
        $('#cantidad').val("");
        $('#codigo_empre').val("");
        $('#descripcion').val("");
        $('#p_unitario').val("");
        $('#p_total').val("");
        $('#costo').val("");
        $('#p_venta').val("");
        
        $('#bien').focus();


        };
       
    

    </script>
@endsection
