@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h1>Saldo Inicial</h1>
    </div>
    
</div>
@endsection

@section('content')
<div class="modal-content panel-primary">
    
    <div class="modal-body">
        <form class="form-horizontal" role="form" method="POST" action="{{url('crearsaldoini')}}" autocomplete="off">
            {{ csrf_field() }}

            <div class="row">
                <div class="col-lg-4">
                    <strong>FECHA</strong> <strong style="color: red;">*</strong>
                    <input type="date" name="fecha" class='form-control' value="{{date('Y-m-d')}}" required>
                </div>
                <div class="col-lg-4">
                    <strong>RAZON SOCIAL</strong> <strong style="color: red;">*</strong>
                    <input type="text" onkeyup="mayus(this);" name="razon_social" class='form-control' required>
                </div>
                <div class="col-lg-4">
                    <strong>IMPORTE (Bs.)</strong> <strong style="color: red;">*</strong>
                    <input type="number" name="saldo" class='form-control' required>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"> <br>
                    <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Guardar">
                </div>
            </div>
        </form>
       
    </div>
</div>
@endsection

@section('js')

<script>
    function mayus(e) {
        e.value = e.value.toUpperCase();
    }
</script>
    
@endsection
