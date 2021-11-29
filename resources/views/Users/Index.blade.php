@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6" >
        <h4>LISTA DE USUARIOS</h4>
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
                            <span id="total" class="badge bg-warning">{{$cantidad}}</span> Cantidad de Usuarios Registrados
                        </button>
                        <a href="{{url('crearusuario')}}"  class="config"><button class='btn btn-outline-dark' onclick="vaciar()" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Usuario</button></a>
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table id="listausuarios" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#343a40;color:#D0D3D4;text-align:center">
                                <tr>
                                    <th width="5%">Nª</th>
                                    <th>NOMBRE</th>
                                    <th>CORREO ELECTRONICO</th>
                                    <th width="15%">EDITAR PERMISOS</th>
                                    <th width="15%">EDITAR DATOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($users as $user)
                                <tr class="gradeC">
                                    <td style="text-align: center;"><?php echo $i++; ?></td>
                                    <td style="text-align: center;">{{$user->name}}</td>
                                    <td style="text-align: center;">{{$user->email}}</td>
                                    <td style="text-align: center"> 
                                        <a class="btn btn-primary" href="{{route('users.edit', $user)}}"><i class="glyphicon glyphicon-pencil"></i></a>
                                        
                                    </td>
                                    <td style="text-align: center;">
                                        <button class="btn btn-primary" type="button" onclick="Editar('{{$user->id}}');"><i class="glyphicon glyphicon-pencil"></i></button>
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
                <h4 class="modal-title">NUEVO USUARIO</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{route('users.store') }}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <strong>NOMBRE </strong> <strong style="color: red;">*</strong>
                            <input  type="text" name="name" id="name" class='form-control' required>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <strong>CORREO ELECTRONICO</strong> <strong style="color: red;">*</strong>
                            <input  type="email" name="email" id="email" class='form-control' required>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12"><br>
                            <strong>CONTRASEÑA</strong> <strong style="color: red;">*</strong>
                            <input  type="password" name="password" id="password" class='form-control' required>
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
                <h4 class="modal-title">EDITAR USUARIO</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{url('updateusuario')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-12">
                            <strong>NOMBRE</strong><strong style="color: red;">*</strong>
                            <input type="text" id="namee" name="name" class='form-control' required>
                        </div>
                        <div class="col-lg-12">
                            <strong>CORREO ELECTRONICO </strong><strong style="color: red;">*</strong>
                            <input type="text" id="emaile" name="email" class='form-control' required>
                        </div>
                        <div class="col-lg-12">
                            <strong>CONTRASEÑA</strong> <strong style="color: red;">*</strong>
                            <input  type="password" name="password" id="passworde" class='form-control' required>
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
        $('#listausuarios').DataTable({
            
      dom: '<"html5buttons"B>lfgtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>',
                title: 'LISTA DE USUARIOS',
                titleAttr: 'Exportar a excel',
                exportOptions: { columns: [0, 1, 2] },
            },
            {
                extend: 'pdfHtml5',
                text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>',
                title: 'LISTA DE USUARIOS',
                titleAttr: 'Exportar a PDF',
                exportOptions: { columns: [0, 1, 2] },
            },
            {
                extend: 'print',
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>',
                title: 'LISTA DE USUARIOS',
                titleAttr: 'Imprimir',
                exportOptions: { columns: [0, 1, 2] },
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
        url = '{{ asset("/index.php/editarusuario")}}/' + id;
        console.log(id);
        $.getJSON(url, null, function(data) {
            if (data.length > 0) {

                $.each(data, function(field, e) {
                    $('#id').val(e.id);
                    $('#namee').val(e.name);
                    $('#emaile').val(e.email);
                    $('#passworde').val(e.password);
                });
                $("#Editar").modal('show');
            }
        });
    }

    function vaciar() {
        $('#email').val("");
        $('#password').val("");
    }



</script>




@endsection

