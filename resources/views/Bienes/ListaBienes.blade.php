@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>GRUPOS</h2>
    </div>
    <div class="col-lg-6">

    @if(Session::has('message'))
        <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get('message')}}
        </div>
    @endif

        @if(Session::has('success'))
        <div class="alert alert-success">
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
                        <a href="#Nuevo" data-toggle="modal" class="config"><button class='btn btn-primary dim'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo Grupo</button></a>
                        <button type="button" class="btn btn-secondary">
                            <span id="total" class="badge bg-primary">{{$cantidad}}</span> Grupos Registrados
                        </button>
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table id="datatablebien" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#3c46d3;color:#ffffff;text-align:center">
                                <tr>
                                    <th width=5%>Nª</th>
                                    <th>GRUPO</th>
                                    @can('editarticulo')
                                    <th width="12%">EDITAR</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($bien as $bienes)
                                <tr class="gradeC">
                                    <td style="text-align: center;"><?php echo $i++; ?></td>
                                    <td style="text-align: center;"><a href="{{'mostrararticulos/'.$bienes->id}}" >{{$bienes->nombre}}</a></td>
                                    @can('editarticulo')
                                    <td style="text-align: center;">
                                        <button class="btn btn-primary" type="button" onclick="Editar('{{$bienes->id}}');"><i class="glyphicon glyphicon-pencil"></i></button>
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $bien->links()}}
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
                <h4 class="modal-title">NUEVO GRUPO</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{('crearbien')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <strong>NOMBRE DEL GRUPO</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" onchange='verificar_igual(this)' type="text" name="nombre" class='form-control' required>
                        </div>
            
                    </div>
                    <br>
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
                <h4 class="modal-title">EDITAR GRUPO</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{('mostrarbienes')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <strong>NOMBRE DE GRUPO </strong><strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" id="nombre" name="nombre" class='form-control' required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <input hidden id="id" name="id" type="text">
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

@endsection

@section('js')

<script>
    function mayus(e) {
        e.value = e.value.toUpperCase();
    }

    

</script>

<script>

$(document).ready( function () {
        $('#datatablebien').DataTable({
            responsive: true,
      "language": {
        "bDeferRender": true,
        "sEmtpyTable": "No existen registros",
        "decimal": ",",
        "thousands": ".",
        "lengthMenu": "Mostrar _MENU_ datos por registros",
        "zeroRecords": "No se encontraron coincidencias",
        "info": "Pàgina _PAGE_ de _PAGES_",
        "infoEmpty": "No existen grupos",
        "search": "Buscar ",
        "infoFiltered": "(Busqueda de _MAX_ registros en total)",
        "oPaginate":{
          "sLast":"Final",
          "sFirst":"Principio",
          "sNext":"Siguiente",
          "sPrevious":"Anterior"
        }
      },
      dom: '<"html5buttons"B>lfgip',
        buttons: [
            {extend: 'excelHtml5', text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>', title: 'Lista de Grupos', exportOptions: { columns: [0, 1] },},
            {extend: 'pdfHtml5', text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>', title: 'Lista de Grupos', exportOptions: { columns: [0, 1] },},
            {extend: 'print', text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>', title: 'Lista de Grupos', exportOptions: { columns: [0, 1] },
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '15pt');
                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                }
            }
        ]
    });
    } );

    function Editar(id) {
         url = '{{ asset("/index.php/editarbien")}}/' + id;
         $.getJSON(url, null, function(data) {
             if (data.length > 0) {
 
                 $.each(data, function(field, e) {
                     $('#id').val(e.id);
                     $('#nombre').val(e.nombre);
                 });
                 $("#Editar").modal('show');
             }
         });
     }
 </script>


@endsection
