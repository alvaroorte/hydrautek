@extends('layouts.app')
@section('content')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>BANCOS</h2>
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
                        <a href="#Nuevo" data-toggle="modal" class="config"><button class='btn btn-outline-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo Banco</button></a>
                        <button type="button" class="btn btn-secondary">
                            <span id="total" class="badge bg-primary">{{$cantidad}}</span> Bancos Registrados
                        </button>
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div id="divCargaDistritos" class="table-responsive">
                        <table id="datatablebancos" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#3c46d3;color:#ffffff;text-align:center">
                                <tr>
                                    <th width=5%>Nª</th>
                                    <th>PROPIETARIO</th>
                                    <th>BANCO</th>
                                    <th>N° CUENTA</th>
                                    <th width="12%">SALDO INICIAL (Bs.)</th>
                                    @can('editdeletebanco')
                                    <th width="10%">EDITAR</th>
                                    <th width="10%">ELIMINAR</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($bancos as $banco)
                                <tr class="gradeC">
                                    <td style="text-align: center;"><?php echo $i++; ?></td>
                                    <td style="text-align: center;">{{$banco->propietario}}</a></td>
                                    <td style="text-align: center;">{{$banco->nombre_banco}}</a></td>
                                    <td style="text-align: center;">{{$banco->cuenta}}</a></td>
                                    <td style="text-align: right;">{{number_format($banco->saldo_inicial,2)}}</a></td>
                                    @can('editdeletebanco')
                                    <td style="text-align: center;">
                                        <button class="btn btn-primary" type="button" onclick="Editar('{{$banco->id}}');"><i class="glyphicon glyphicon-pencil"></i></button>
                                    </td>
                                    <td style="text-align: center">
                                        <form class="form-horizontal eliminar-banco" role="form" method="POST" action="{{('eliminarbanco')}}/{{$banco->id}}">
                                        {{ csrf_field() }} @method('DELETE')
                                        <button class="btn btn-danger" type="submit" name="ejecutar" ><i class="glyphicon glyphicon-trash"></i></button>
                                        </form>
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
                <h4 class="modal-title">NUEVO BANCO</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{('crearbanco')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6">
                            <strong>PROPIETARIO</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" name="propietario" class='form-control' required>
                        </div>
                        <div class="col-lg-6">
                            <strong>NOMBRE DEL BANCO</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" name="nombre_banco" class='form-control' required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6"><br>
                            <strong>NUMERO DE CUENTA</strong> <strong style="color: red;">*</strong>
                            <input type="number" onchange='verificar_igual(this)' name="cuenta" class='form-control' required>
                        </div>
                        <div class="col-lg-3"><br>
                            <strong>SALDO INICIAL</strong> <strong style="color: red;">*</strong>
                            <input type="number" name="saldo_inicial" step="0.01" class='form-control' required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Guardar Banco">
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
                <h4 class="modal-title">EDITAR BANCO</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{('updatebanco')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6">
                            <strong>PROPIETARIO</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" id="propietario" name="propietario" class='form-control' required>
                        </div>
                        <div class="col-lg-6">
                            <strong>NOMBRE DEL BANCO </strong><strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" id="nombre_banco" name="nombre_banco" class='form-control' required>
                        </div>
                    </div>
                    <div class="row"><br>
                        <div class="col-lg-6"><br>
                            <strong>NUMERO DE CUENTA</strong> <strong style="color: red;">*</strong>
                            <input type="number" id="cuenta" name="cuenta" class='form-control' required>
                        </div>
                        <div class="col-lg-3"><br>
                            <strong>SALDO INICIAL</strong> <strong style="color: red;">*</strong>
                            <input type="number" id="saldo_inicial" name="saldo_inicial" step="0.01" class='form-control' required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <input hidden id="id" name="id" type="text">
                        <div class="col-lg-12">
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Guardar Cambios">
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

    @if (Session::has('crearbanco'))
        <script>
            Swal.fire({
            icon: 'success',
            title: 'Se creo correctamente el Banco',
            showConfirmButton: false,
            timer: 1500
            })
        </script>
    @endif

<script>
    $('.eliminar-banco').submit(function(e){
        e.preventDefault();

        Swal.fire({
        title: 'Estas Seguro?',
        text: "Estas a punto de Eliminar el Banco!",
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

    function mayus(e) {
        e.value = e.value.toUpperCase();
    }

</script>

<script>

$(document).ready( function () {
        $('#datatablebancos').DataTable({
            
      dom: '<"html5buttons"B>lfgtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<button class="btn btn-success btn-sm"><i  class="far fa-file-excel"></i> </button>',
                title: 'Bancos',
                titleAttr: 'Exportar a excel',
                exportOptions: { columns: [0, 1, 2, 3 ,4] },
            },
            {
                extend: 'pdfHtml5',
                text: '<button class="btn btn-danger btn-sm"><i  class="far fa-file-pdf"></i> </button>',
                title: 'Bancos',
                titleAttr: 'Exportar a PDF',
                exportOptions: { columns: [0, 1, 2, 3 ,4] },
            },
            {
                extend: 'print',
                text: '<button class="btn btn-info btn-sm"><i  class="fas fa-print"></i> </button>',
                title: 'Bancos',
                titleAttr: 'Imprimir',
                exportOptions: { columns: [0, 1, 2, 3 ,4] },
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

    function Editar(id) {
         url = '{{ asset("/index.php/encontrarbanco")}}/' + id;
         $.getJSON(url, null, function(data) {
             if (data.length > 0) {
                
        console.log(id);
                 $.each(data, function(field, e) {
                     $('#id').val(e.id);
                     $('#nombre_banco').val(e.nombre_banco);
                     $('#propietario').val(e.propietario);
                     $('#cuenta').val(e.cuenta);
                     $('#saldo_inicial').val(e.saldo_inicial);
                 });
                 $("#Editar").modal('show');
             }
         });
     }

     function Eliminar(id) {
        url = '{{ asset("/index.php/eliminarbanco")}}/' + id;
    }
 </script>


@endsection