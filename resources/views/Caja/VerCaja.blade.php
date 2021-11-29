@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h3>CAJA</h3>
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
                <div class="col-lg-8">
                    @can('in-eg-ca-ba')
                    <a href="#NuevoIngreso" data-toggle="modal" class="config"><button class='btn btn-outline-primary'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo Ingreso</button></a> 
                    <a href="#NuevoEgreso" data-toggle="modal" class="config"><button class='btn btn-outline-warning'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo Egreso</button></a>                    
                    @endcan
                    <a href="#PorFecha" data-toggle="modal" class="config"><button class='btn btn-outline-primary'><span class="fa fa-calendar" aria-hidden="true"></span> Por Fecha</button></a> 
                </div>
                <br>
                <div class="ibox-content">
                    <div class="table-responsive">
                            <div class="col-lg-2">  
                                <a href="{{url('pdfcaja')}}" ><button class='btn btn-danger'><i  class="fa fa-file-pdf-o"></i> </button></a>
                                <a href="{{url('excelcaja')}}" ><button class='btn btn-success'><i  class="fa fa-file-excel-o"></i> </button></a>
                            </div>
                                         
                        
                        <table id="datatablecaja" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#3c46d3;color:#ffffff;text-align:center">
                                <tr>
                                    <th>FECHA</th>
                                    <th>CODIGO</th>
                                    <th>TRANSACCION</th>
                                    <th>RAZON SOCIAL</th>
                                    <th>CONCEPTO</th>
                                    <th>IMPORTE(Bs.)</th>
                                    <th>SALDO(Bs.)</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php $saldo = 0; @endphp
                                @foreach($cajas as $caja)
                                <tr class="gradeC" style="text-align: center;">
                                    <td>{{$caja->fecha}}</td>
                                    <td>{{$caja->num_documento}}</td>
                                    <td>{{$caja->tipo}}</td>
                                    <td>{{$caja->razon_social}}</td>
                                    <td>{{$caja->concepto}}</td>
                                    <td style="text-align: right">{{number_format($caja->importe,2)}}</td>
                                    @php $saldo += $caja->importe; @endphp
                                    <td style="text-align: right"><b>{{number_format($saldo,2)}}</b></td>
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
<div class="modal fade" id="NuevoIngreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">NUEVO INGRESO</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal crearingreso" role="form" method="POST" action="{{url('crearcaja')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-3">
                            <strong>FECHA</strong>
                            <input onkeyup="mayus(this);" type="date" name="fecha" value="{{date('Y-m-d')}}" class='form-control' required>
                        </div>
                        <div class="col-lg-3">
                            <strong>TRANSACCION</strong>
                            <input type="text" name="transaccion" value="INGRESO" class='form-control' readonly>
                        </div>
                        <div class="col-lg-4">
                            <strong>RAZON SOCIAL</strong> <strong style="color: red;">*</strong>
                            <input type="text" onkeyup="mayus(this);" name="razon social" class='form-control' required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8"><br>
                            <strong>CONCEPTO</strong> <strong style="color: red;">*</strong>
                            <input type="text" name="concepto" class='form-control' required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3"><br>
                            <strong>IMPORTE</strong> <strong style="color: red;">*</strong>
                            <input type="number" name="importe" step="0.01" class='form-control' required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="GUARDAR">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->      
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="NuevoEgreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">NUEVO EGRESO</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal crearegreso" role="form" method="POST" action="{{url('crearcaja')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-3">
                            <strong>FECHA</strong>
                            <input type="date" name="fecha" value="{{date('Y-m-d')}}" class='form-control' required>
                        </div>
                        <div class="col-lg-3">
                            <strong>TRANSACCION</strong>
                            <input type="text" name="transaccion" value="EGRESO" class='form-control' readonly>
                        </div>
                        <div class="col-lg-4">
                            <strong>RAZON SOCIAL</strong> <strong style="color: red;">*</strong>
                            <input type="text" onkeyup="mayus(this);"  name="razon social" class='form-control' required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8"><br>
                            <strong>CONCEPTO</strong> <strong style="color: red;">*</strong>
                            <input type="text" name="concepto" class='form-control' required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3"><br>
                            <strong>IMPORTE (Bs.)</strong> <strong style="color: red;">*</strong>
                            <input type="number" name="importe" step="0.01" class='form-control' required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="GUARDAR">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->      
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="PorFecha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">FECHAS</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{url('mostrarcajafecha')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-3">
                            <strong>FECHA INICIO</strong>
                            <input onkeyup="mayus(this);" type="date" name="fi" value="{{date('Y-m-d')}}" class='form-control' required>
                        </div>
                        <div class="col-lg-3">
                            <strong>FECHA FIN</strong>
                            <input onkeyup="mayus(this);" type="date" name="ff" value="{{date('Y-m-d')}}" class='form-control' required>
                        </div>
                    </div>
                        
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Ver Reporte">
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
@if (Session::has('egreso'))
    <script>
        Swal.fire({
        icon: 'success',
        title: 'Se creo correctamente el Egreso',
        showConfirmButton: false,
        timer: 1500
        })
    </script>
@endif

@if (Session::has('ingreso'))
    <script>
        Swal.fire({
        icon: 'success',
        title: 'Se creo correctamente el Ingreso',
        showConfirmButton: false,
        timer: 1500
        })
    </script>
@endif


<script>

    $('.crearingreso').submit(function(e){
        e.preventDefault();
        this.submit();
    });

    $('.crearegreso').submit(function(e){
        e.preventDefault();
        this.submit();
    });


    function mayus(e) {
        e.value = e.value.toUpperCase();
    }

    $(document).ready( function () {
        $('#datatablecaja').DataTable({
            "ordering": false,
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
</script>


@endsection
