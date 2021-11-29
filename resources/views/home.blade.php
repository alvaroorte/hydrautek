@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2> Bienvenido {{Auth::user()->name}} </h2></div>
                
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Ya puede utilizar el sistema, que deseas realizar?
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection
