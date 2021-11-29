@extends('layouts.app')

@section('ruta')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6" >
        <h4>EDITAR PERMISOS</h4>
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
@if (session('info'))
<div class="alert alert-success">
    <strong>{{session('info')}} </strong>
</div>
    
@endif

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="card">
        <div class="card-body">
            <div class="col-lg-3">
                <p class="h5">USUARIO</p>
                <p class="form-control">{{$user->name}}</p>
            </div>
        </div>
        <div class="card-body">
            <h2 class="h5">Roles Disponibles</h2>
            {!! Form::model($user, ['route' => ['users.update',$user], 'method' => 'put' ]) !!}
                @foreach ($roles as $role)
                    <div>
                        <label>
                            {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                            @if ($role->name == 'Admin')
                                Administrador
                            @else
                                Cajero
                            @endif
                        </label>
                        
                    </div>
                @endforeach
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary mt-2']) !!}
            {!! Form::close() !!}
        </div>
            
        
    </div>
</div>

@endsection


@section('js')


@endsection