@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>ARTICULOS</h2>
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
        @if(Session::has('message'))
            <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get('message')}}
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
                        <a href="#Nuevo" data-toggle="modal" class="config"><button class='btn btn-primary dim'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo Articulo</button></a>
                        <button type="button" class="btn btn-secondary">
                            <span id="total" class="badge bg-primary">{{$cantidad}}</span> Articulos Registrados
                        </button>
                        <a href="{{url('mostrarbienes')}}" class="config" ><button class='btn btn-light' style="background:#3c46d3;color:#ffffff;text-align:center"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Volver</button></a>                     
                    </div>
                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table id="datatablearticulo" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#3c46d3;color:#ffffff;text-align:center">
                                <tr>
                                    <th width="5%">Nª</th>
                                    <th>ARTICULO</th>
                                    <th width="10%">MARCA</th>      
                                    <th width="10%">UNIDAD</th>
                                    <th width="10%">UBICACION</th>
                                    <th width="12%">CODIGO EMPRESA</th> 
                                    @can('editarticulo')                                   
                                    <th width="10%">Editar</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($sql as $articulos)
                                <tr class="gradeC">
                                    <td style="text-align: center;"><?php echo $i++; ?></td>
                                    <td style="text-align: center;">{{$articulos->nombre}}</td>
                                    <td style="text-align: center;">{{$articulos->marca}}</td>
                                    <td style="text-align: center;">{{$articulos->unidad}}</td>
                                    <td style="text-align: center;">{{$articulos->ubicacion}}</td>
                                    <td style="text-align: center;">{{$articulos->codigo_empresa}}</td>
                                    @can('editarticulo')
                                    <td style="text-align: center;">
                                        <button class="btn btn-primary" type="button" onclick="Editar('{{$articulos->id}}');"><i class="glyphicon glyphicon-pencil"></i></button>
                                    </td>
                                    @endcan
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
                <h4 class="modal-title">NUEVO ARTICULO</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{url('creararticulo')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-3">
                            <strong>CODIGO EMPRESA</strong>
                            <input onkeyup="mayus(this);" type="text" name="codigo_empresa" class='form-control'>
                        </div>
                        <div class="col-lg-3">
                            <strong>CODIGO FABRICA</strong>
                            <input onkeyup="mayus(this);" type="text" name="codigo" class='form-control'>
                        </div>
                        <div class="col-lg-3">
                            <strong>UBICACIÓN</strong>
                            <input onkeyup="mayus(this);" type="text" name="ubicacion" class='form-control'>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-sm-6"><br>
                            <strong>GRUPO</strong> <strong style="color: red;">*</strong>
                            <select name="id_bien" id="id_bien" class="form-control" required>
                                <option value="{{$dato->id}}">{{$dato->nombre}}</option>  
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12"><br>
                            <strong>MARCA</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" name="marca" class='form-control' required>
                        </div>
                        
                        <div class="col-lg-3"><br>
                            <strong>UNIDAD</strong> <strong style="color: red;">*</strong>
                            <select name="unidad" id="unidad" class="form-control" required>
                                <option value="pieza">Pieza</option>
                                <option value="metro">Metro</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-8">
                            <strong>ARTICULO</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" name="nombre" class='form-control' required>
                        </div>
            
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Registrar">
                        </div>
                    </div>
                </form>
               
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="Editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">EDITAR ARTICULO</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{url('mostrararticulos')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-8">
                            <strong>NOMBRE ARTICULO </strong><strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" id="nombre" name="nombre" class='form-control' required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <strong>MARCA </strong><strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" id="marca" name="marca" class='form-control' required>
                        </div>
                        <div class="col-lg-3">
                            <strong>UBICACIÓN</strong><strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" id="ubicacion" name="ubicacion" class='form-control'>
                        </div>
                        <div class="col-lg-2">
                            <strong>UNIDAD </strong><strong style="color: red;">*</strong>
                            <select name="unidad" id="unidade" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4"><br>
                            <strong>CODIGO EMPRESA</strong><strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" id="codigo_empresa" name="codigo_empresa" class='form-control' >
                        </div>
                        <div class="col-lg-4"><br>
                            <strong>CODIGO FABRICA</strong><strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" id="codigo" name="codigo" class='form-control' >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3"><br>
                            <strong>COSTO (Bs.)</strong><strong style="color: red;">*</strong>
                            <input type="number" id="costo" name="costo" step="0.01" class='form-control'>
                        </div>
                        <div class="col-lg-3"><br>
                            <strong>P. VENTA (Bs.)</strong><strong style="color: red;">*</strong>
                            <input type="number" id="p_venta" name="p_venta" step="0.01" class='form-control' >
                        </div>
                        <div class="col-lg-3"><br>
                            <strong>P. POR MAYOR (Bs.)</strong><strong style="color: red;">*</strong>
                            <input type="number" id="p_ventapm" name="p_ventapm" step="0.01" class='form-control' >
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

    @if (Session::has('guardado'))
        <script>
            Swal.fire({
            icon: 'success',
            title: 'Se Guardo correctamente los Cambios',
            showConfirmButton: false,
            timer: 1500
            })
        </script>
    @endif

    @if (Session::has('yaexiste'))
        <script>
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El Codigo de Empresa ya existe!, los cambios no se guardaran',
            })
        </script>
    @endif

    @if (Session::has('yaexistec'))
        <script>
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'El Codigo de Fabrica ya existe!, los cambios no se guardaran',
            })
        </script>
    @endif

<script>
    $(document).ready( function () {
        $('#datatablearticulo').DataTable({
            
      dom: '<"html5buttons"B>lfgtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>',
                title: 'Lista de Articulos',
                titleAttr: 'Exportar a excel',
                exportOptions: { columns: [0, 1,2,3,4,5,6,7] }
            },
            {
                extend: 'pdfHtml5',
                text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>',
                title: 'Lista de Articulos',
                titleAttr: 'Exportar a PDF',
                exportOptions: { columns: [0, 1,2,3,4,5,6,7] }
            },
            {
                extend: 'print',
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>',
                title: 'Lista de Articulos',
                titleAttr: 'Imprimir',
                exportOptions: { columns: [0, 1,2,3,4,5,6,7] },
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
                    $('#marca').val(e.marca);
                    $('#ubicacion').val(e.ubicacion);
                    $('#unidade').empty();
                    $('#unidade').append('<option value="'+e.unidad+'">'+e.unidad+'</option>');
                    if ($('#unidade').val() == 'pieza') {
                        $('#unidade').append('<option value="metro">Metro</option>');
                    } else {
                        $('#unidade').append('<option value="pieza">Pieza</option>');
                    }
                    $('#codigo_empresa').val(e.codigo_empresa);
                    $('#codigo').val(e.codigo);
                    $('#costo').val(e.costo);
                    $('#p_venta').val(e.p_venta);
                    $('#p_ventapm').val(e.p_ventapm);
                });
                $("#Editar").modal('show');
            }
        });
    }
</script>

@if (Session::has('articulo'))
    <script>
        Swal.fire(
        'Correcto!',
        'El Articulo se creo correctamente.',
        'success'
        )
    </script>
@endif



@endsection
