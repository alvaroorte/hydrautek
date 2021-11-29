@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>REPORTE DE INGRESOS</h2>
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
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">REPORTE DE INGRESOS</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="{{url('reportefechasalidadia')}}" autocomplete="off">
                    {{ csrf_field() }}
                    
                    <div class="row">
                        
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <strong>FECHA DE INICIO </strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="date" name="fi" value="{{date('Y-m-d')}}" class='form-control' required>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <strong>FECHA FIN</strong> <strong style="color: red;">*</strong>
                            <input onkeyup="mayus(this);" type="date" name="ff" value="{{date('Y-m-d')}}" class='form-control' required>
                        </div>
                    </div>
                    
                    <br>                               
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="submit" name="ejecutar" class='float-right btn btn-primary' value="Ver Reporte">
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- /.modal-content -->
   
@endsection


@section('js')

<script>

$("#tipo2").change(function()
        {
            id=this.value;  
            $("#personalizado").show();
        });

$("#tipo").change(function()
        {
            id=this.value;  
            $("#personalizado").hide();
        });






</script>

@endsection