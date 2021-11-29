@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6" >
        <h4>Creditos De {{$tipo}}</h4>
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
                        @can('sicredito')
                        <a href="#Nuevo" data-toggle="modal" class="config"><button class='btn btn-outline-info'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Crear Saldo Inicial</button></a>          
                        @endcan
                        <button type="button" class="btn btn-secondary">
                            <span id="total" class="badge bg-info">{{$cantidad}}</span> Cantidad de Creditos
                        </button>
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table id="datatablecreditos" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#42a8c7;color:#ffffff;text-align:center">
                                <tr>
                                    <th width=12%>FECHA</th>
                                    <th width=10%>CODIGO</th>
                                    <th>CLIENTE</th>
                                    <th width=10%>SALDO(Bs.)</th>
                                    <th width=10%>ESTADO</th>
                                    <th width=15%>Ver detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $s = 0; ?>
                                @foreach($credito as $creditos)
                                <tr class="gradeC">
                                    <td style="text-align: center;">{{$creditos->fecha}}</td>
                                    <td style="text-align: center;">{{$creditos->codigo}}</td>
                                    @if ($creditos->tipo == 'venta')
                                        <td style="text-align: center;">{{$creditos->nombre}} ({{$creditos->ci}})</td>
                                    @else
                                        <td style="text-align: center;">{{$creditos->nombre}} ({{$creditos->nit}})</td>
                                    @endif
                                    
                                    <td style="text-align: center;">{{$creditos->saldo}}</td><?php $s += $creditos->saldo; ?>
                                    <td style="text-align: center;">
                                        @if ($creditos->estado)
                                            <button class='btn btn-warning'>Pendiente</button>
                                        @else
                                            <button class='btn btn-success'>Cancelado</button>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($creditos->tipo == "venta")
                                            <a href="{{url('creditodetallados/'.$creditos->id.'/'.$creditos->tipo)}}"><button class='btn btn-info'>Ver Detalle</button></a>
                                        @else
                                            <a href="{{url('creditodetalladoe/'.$creditos->id.'/'.$creditos->tipo)}}"><button class='btn btn-info'>Ver Detalle</button></a>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">CREAR SALDO INICIAL DE CREDTIO</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal crearcredito" role="form" method="POST" action="{{url('crearcredito')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="modal-body">
                            <div class="col-lg-2">
                                <strong>TIPO</strong> <strong style="color: red;">*</strong>
                                <input type="text" name="tipo" id="tipo" value="{{$tipo}}" class='form-control' required readonly>
                            </div>
                            <div class="col-lg-3">
                                <strong>FECHA</strong> <strong style="color: red;">*</strong>
                                <input type="date" name="fecha" class='form-control' value="{{date('Y-m-d')}}" required>
                            </div>
                            <div class="col-lg-2 ">
                                <strong>PLAZO (Días)</strong>
                                <input type="number" name="plazo" class='form-control' value="0" required>
                            </div>
                        </div>
                    </div>
                    @if ($tipo == 'Compra')
                        <div class="row">
                            <div class="modal-body">
                                <div class="col-lg-3">
                                    <strong>CODIGO PROV.</strong>
                                    <input type="text" name="codigo_prov" id="codigo_prov" onkeyup="codigo_prove(this);" class='form-control' required>
                                </div>
                                
                                <div class="col-lg-3">
                                    <strong>NIT PROVEEDOR</strong>
                                    <input type="number" name="nit_proveedor" id="nit_proveedor"  onkeyup="nit_prove(this);" class='form-control' required>
                                </div>
                                <div class="col-lg-5">
                                    <strong>PROVEEDOR</strong>
                                    <input type="text" name="proveedor" id="proveedor" class='form-control' readonly>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row"> 
                            <div class="modal-body">
                                <div class="col-lg-3 ">
                                    <strong>CODIGO CLIENTE</strong>
                                    <input type="text" name="codigo_cli" id="codigo_cli" onkeyup="codigo_cliente(this);" class='form-control' required>
                                </div>
                                <div class="col-lg-3 ">
                                    <strong>NIT CLIENTE</strong>
                                    <input type="number" name="nit_cliente" id="nit_cliente" onkeyup="nit_cli(this);" class='form-control' required>
                                </div>
                                <div class="col-lg-5">
                                    <strong>CLIENTE</strong> <strong style="color: rgb(255, 0, 0);">*</strong>
                                    <input type="text" name="cliente" id="cliente" class='form-control' readonly>
                                </div>
                                
                            </div>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-3"><br>
                            <strong>MONTO (Bs.)</strong> <strong style="color: red;">*</strong>
                            <input type="number" name="total" class='form-control' step="0.01" required>
                        </div>
                    </div>
                    <input type="hidden" name="identificador" value="-1">
                    <input type="hidden" name="id_proveedor" id="id_proveedor" class='form-control'>
                    <input type="hidden" name="id_cliente" id="id_cliente" class='form-control'>
                    <div class="row">
                        <div class="col-lg-12"><br>
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Guardar Credito">
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
        $('#datatablecreditos').DataTable({
            
      dom: '<"html5buttons"B>lfgtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>',
                title: 'Lista de Creditos',
                titleAttr: 'Exportar a excel',
                exportOptions: { columns: [0, 1, 2, 3, 4] }
            },
            {
                extend: 'pdfHtml5',
                text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>',
                title: 'Lista de Creditos',
                titleAttr: 'Exportar a PDF',
                exportOptions: { columns: [0, 1, 2, 3, 4] }
            },
            {
                extend: 'print',
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>',
                title: 'Lista de Creditos',
                titleAttr: 'Imprimir',
                exportOptions: { columns: [0, 1, 2, 3, 4] },
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

    function nit_prove(id) {
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
                        console.log("FFFFFFFFF");
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

    $('.crearcredito').submit(function(e){
        e.preventDefault();

        Swal.fire({
        title: 'Estas Seguro?',
        text: "Estas a punto de crear un Credito!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Crear Credito',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
        })
    });

    
</script>

@endsection
