@extends('layouts.app')

@section('ruta')
<br>
<br>
<br>
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">LA CANTIDAD INTRODUCIDA SUPERA LA CANTIDAD EN EL INVENTARIO</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible" role="alert"></div>
            </div>
            <div class="modal-body" style="text-align: center;">
                <a href="{{'mostrarsalidas'}}"><button class='btn btn-primary'><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Volver</button></a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>
@endsection




