@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6" >
        <h4>DETALLE DEL CREDITO DE COMPRA</h4>
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
                        @if ($credito->saldo > 0)
                            <a href="#Nuevo" data-toggle="modal" class="config"><button class='btn btn-outline-info'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Pago</button></a>
                        @endif
                        <a href="{{url('mostrarcreditos/'.$tipo)}}" class="config" style="text-align: right"><button class='btn btn-warning dim'><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Volver</button></a>                     
                    </div>

                </div>
                <br>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#42a8c7;color:#ffffff;text-align:center">
                              <tr>
                                  <th width=12%>PROVEEDOR</th>
                                  <th width=10%>NIT/CI</th>
                                  
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="gradeC">
                                  @if ($credito->id_proveedor == null)
                                    <td style="text-align: center; font-size: 10pt;">{{$entrada->proveedor}}</td>
                                    <td style="text-align: center; font-size: 10pt;">{{$entrada->nit_proveedor}}</td>
                                  @else
                                    <td style="text-align: center; font-size: 10pt;">{{$proveedor->nombre}}</td>
                                    <td style="text-align: center; font-size: 10pt;">{{$proveedor->nit}}</td>
                                  @endif
                                  
                              </tr>
                              </tbody>
                        </table>
                        <table class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#42a8c7;color:#ffffff;text-align:center">
                              <tr>
                                  <th width=12%>FECHA</th>
                                  <th width=10%>CODIGO VENTA</th>
                                  <th width=10%>PLAZO</th>
                                  <th width=10%>ESTADO</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="gradeC">
                                  <td style="text-align: center; font-size: 10pt;">{{$credito->fecha}}</td>
                                  <td style="text-align: center; font-size: 10pt;">{{$credito->codigo}}</td>
                                  <td style="text-align: center; font-size: 10pt;">{{$credito->plazo}} Días</td>
                                  <td style="text-align: center;">
                                    @if ($credito->estado)
                                        <button class='btn btn-warning'>Pendiente</button>
                                    @else
                                        <button class='btn btn-success'>Cancelado</button>
                                    @endif
                                </td>
                              </tr>
                              </tbody>
                        </table>
                        <table id="datatablecreditodet" class="table table-bordered table-hover table-striped table-sm">
                            <thead style="background:#42a8c7;color:#ffffff;text-align:center">
                                <tr>
                                    <th width=5%>N°</th>
                                    <th width=7%>BIEN</th>
                                    <th width=10%>ARTICULO</th>
                                    <th width=10%>MARCA</th>
                                    <th width=5%>P. UNITARIO</th>
                                    <th width=5%>CANTIDAD</th>
                                    <th width=13%>SUB TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $u = 1 ?>
                                @foreach($entradas as $sqls)
                                <tr class="gradeC">
                                    <td style="text-align: center;">{{$u}}</td>
                                    <td style="text-align: center;">{{$sqls->nombre_bien}}</td>
                                    <td style="text-align: center;">{{$sqls->nombre_articulo}}</td>
                                    <td style="text-align: center;">{{$sqls->marca}}</td>
                                    <td style="text-align: center;">{{$sqls->p_unitario}}</td>
                                    <td style="text-align: center;">{{$sqls->cantidad}}</td>
                                    <td style="text-align: center;"> <h5> {{$sqls->p_total}} </h5></td>
                                    <?php $u++;?>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                        <div class="modal-content panel-primary">
                            <div class="modal-body">
                                <div class="card" style="text-align: center">
                                    <strong> <h3><b> TOTAL Bs. {{$credito->total}} </b></h3></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-hover table-striped table-sm">
                        <thead style="background:#343a40;color:#D0D3D4;text-align:center"> 
                            <tr>
                                <th><h5>DATOS</h5></th>
                                <th><h5>MONTO (Bs.)</h5></th>
                            </tr>
                        </thead>
                        @php
                            $i= $credito->total;
                        @endphp
                        <tbody style="background:#42a8c7;color:#ffffff;text-align:center">
                        @foreach($sql2 as $pago)
                                <tr class="gradeC">
                                    <td width=65%>
                                        <h2>{{$pago->nombre}}</h2>
                                        <h5><b>CI:</b>{{$pago->ci}}</h5>
                                        <h2>{{$pago->fecha}}</h2>
                                    </td>
                                    <td width=30%>
                                        <h4><b>{{number_format($pago->monto,2)}}</b></h4>
                                        @if ($pago->id_banco == null)
                                            EFECTIVO
                                        @else
                                            BANCO 
                                        @endif
                                    </td>
                                </tr>
                            @php
                                $i = $i-$pago->monto;
                            @endphp
                        @endforeach
                        </tbody>
                    </table>
                    <div class="modal-content panel-primary">
                        <div class="modal-body">
                            <div class="card" style="text-align:center; color: red">
                                <strong> <h3><b> SALDO Bs. {{$credito->saldo}} </b></h3></strong>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">NUEVO PAGO</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal crearpago" role="form" method="POST" action="{{url('crearpago')}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-2 ">
                            <strong>FORMA DE PAGO</strong>
                            <select name="tipo_pago" id="tipo_pago" class="form-control" required>
                                <option value="0">Efectivo</option>
                                <option value="2">Banco</option>
                            </select>
                        </div>
                        <div class="col-lg-4 " id="div_banco" style="display: none">
                            <strong>BANCO</strong>
                            <select name="id_banco" class="form-control">
                                <option value="">Seleccionar</option>
                                @foreach($bancos as $banco)
                                    <option value="{{$banco->id}}">{{$banco->nombre_banco}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5"><br>
                            <strong>NOMBRE DEL PAGANTE</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="text" name="nombre" class='form-control' required>
                        </div>
                        <div class="col-lg-3"><br>
                            <strong>C.I. o NIT</strong> <strong style="color: red;">*</strong>
                            <input type="number" name="ci" class='form-control' required>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-3"><br>
                            <strong>FECHA</strong> <strong style="color: red;">*</strong>
                            <input type="date" name="fecha" class='form-control' value="{{date('Y-m-d')}}" required>
                        </div>
                        <div class="col-lg-2"><br>
                            <strong>MONTO (Bs.)</strong> <strong style="color: red;">*</strong>
                            <input type="number" name="monto" id="monto" class='form-control' step="0.01" onChange="control_saldo(this.value,{{$credito->saldo}});" required>
                        </div>
                    </div>
                    <input type="hidden" name="id_credito" value="{{$credito->id}}">
                    <input type="hidden" name="tipo" value="{{$credito->tipo}}">
                    <input type="hidden" name="identificador" value="{{$credito->identificador}}">
                    
                    <div class="row">
                        <div class="col-lg-12"><br>
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Guardar Pago">
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
    $('.crearpago').submit(function(e){
        e.preventDefault();

        Swal.fire({
        title: 'Estas Seguro?',
        text: "Estas a punto de realizar un Pago!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Realizar Pago',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
        })
    });


    $(document).ready( function () {
        $('#datatablecreditodet').DataTable({
            dom: 'f',
        buttons: [
            'excel', 'pdf', 'print'
        ],
      "order": [[ 0, 'asc']],
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

    function control_saldo(id,saldo) 
    {
        if (id > saldo) {
            alert("EL MONTO INGRESADO ES MAYOR AL SALDO");
            $('#monto').val(saldo);
        } 
    }

    $("#tipo_pago").change(function()
    {
        id = this.value;
        if (id == 2) {
            $('#div_banco').show();
        }
        else {
            $('#div_banco').hide();
        }
    });
   
</script>

@endsection