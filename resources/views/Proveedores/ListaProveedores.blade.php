@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>PROVEEDORES</h2>
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
                        <a href="#Nuevo" data-toggle="modal" class="config"><button class='btn btn-outline-dark'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo Proveedor</button></a>
                        <button type="button" class="btn btn-secondary">
                            <span id="total" class="badge bg-warning">{{$cantidad}}</span> Proveedores Registrados
                        </button>
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table id="datatableprov" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#343a40;color:#D0D3D4;text-align:center">
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>CODIGO</th>
                                    <th>NIT/CI</th>
                                    <th>CONTACTO</th>
                                    <th width=8%>EDITAR</th>
                                    <th width=8%>ELIMINAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($proveedores as $proveedor)
                                <tr class="gradeC">
                                    <!-- <td><?php echo $i++; ?></td> -->
                                    <td style="text-align: center;">{{$proveedor->nombre}}</td>
                                    <td style="text-align: center;">{{$proveedor->codigo_prov}}</td>
                                    <td style="text-align: center;">{{$proveedor->nit}}</td>
                                    <td style="text-align: center;">{{$proveedor->celular}}</td>
                                    <td style="text-align: center;">
                                        <button class="btn btn-primary" type="button" onclick="Editar('{{$proveedor->id}}');"><i class="glyphicon glyphicon-pencil"></i></button>                                    
                                    </td>
                                    <td style="text-align: center">
                                        <form class="form-horizontal eliminar-proveedor" role="form" method="POST" action="{{('eliminarcliente')}}/{{$proveedor->id}}">
                                        {{ csrf_field() }} @method('DELETE')
                                        <button class="btn btn-danger" type="submit" name="ejecutar" ><i class="glyphicon glyphicon-trash"></i></button>
                                        </form>
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
                <h4 class="modal-title">NUEVO PROVEEDOR</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{('crearproveedor')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        
                        <div class="col-lg-5">
                            <strong>NOMBRE </strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" name="nombre" id="nombre" class='form-control' required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4">
                            <strong>NIT </strong> <strong style="color: red;">*</strong>
                            <input type="number" name="nit" class='form-control' required>
                        </div>
                        <div class="col-lg-4">
                            <strong>CONTACTO </strong> <strong style="color: red;">*</strong>
                            <input  type="number" name="celular" class='form-control' required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
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

<div class="modal fade" id="Editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">EDITAR PROVEEDOR</h4>
            </div>
            <div class="modal-body">
            <form class="form-horizontal" role="form" method="POST" action="{{('updateproveedor')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-3">
                            <strong>NOMBRE </strong><strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" id="nombree" name="nombre" class='form-control' required>
                        </div>
                        <div class="col-lg-3">
                            <strong>NIT/CI </strong> <strong style="color: red;">*</strong>
                            <input type="number" id="nit" name="nit" class='form-control' required>
                        </div>
                        <div class="col-lg-3">
                            <strong>CELULAR </strong> <strong style="color: red;">*</strong>
                            <input type="number" id="celular" name="celular" class='form-control' required>
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
@if (Session::has('yaexiste'))
    <script>
        Swal.fire(
        'Lo siento!',
        'Ya existe un Proveedor con el mismo NIT/CI.',
        'warning'
        )
    </script>
@endif

@if (Session::has('creado'))
    <script>
        Swal.fire(
        'Correcto!',
        'El Proveedor se creo Correctamente.',
        'success'
        )
    </script>
@endif

<script>

$('.eliminar-proveedor').submit(function(e){
        e.preventDefault();

        Swal.fire({
        title: 'Estas Seguro?',
        text: "Estas a punto de Eliminar un Proveedor!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SI, eliminar'
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
        })
    });


$(document).ready( function () {
        $('#datatableprov').DataTable({
        dom: '<"html5buttons"B>lfgtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>',
                title: 'Lista de Proveedores',
                titleAttr: 'Exportar a excel',
                exportOptions: { columns: [0, 1, 2, 3] }
            },
            {
                extend: 'pdfHtml5',
                text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>',
                title: 'Lista de Proveedores',
                titleAttr: 'Exportar a PDF',
                exportOptions: { columns: [0, 1, 2, 3] }
            },
            {
                extend: 'print',
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>',
                title: 'Lista de Proveedores',
                titleAttr: 'Imprimir',
                exportOptions: { columns: [0, 1, 2, 3] },
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

    $("#nombre").change(function()
    {
        id=this.value;
        cod = id.substring(0,3);
        $("#codigo_prov").val("PROV-"+cod);
    });

    function Editar(id) {
        url = '{{ asset("/index.php/buscarproveedor")}}/' + id;
        $.getJSON(url, null, function(data) {
            if (data.length > 0) {
                $.each(data, function(field, e) {
                    $('#id').val(e.id);
                    $('#nombree').val(e.nombre);
                    $('#nit').val(e.nit);
                    $('#celular').val(e.celular);
                });
                $("#Editar").modal('show');
            }
        });
    }

    function Eliminar(id) {
        url = '{{ asset("/index.php/eliminarproveedor")}}/' + id;
    }
</script>
@endsection