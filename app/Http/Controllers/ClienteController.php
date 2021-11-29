<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ListaClientes()
    {
        $cantidad=Cliente::all()->count()-1;
        $clientes=Cliente::where('id', '!=', 0)->orderBy('id','asc')->get();
        return view('Clientes.ListaClientes',compact('cantidad','clientes'));
    }

    public function CrearCliente(Request $request)
    {
        $cli = Cliente::latest('id')->first();
        $cliente=new Cliente();
        $cliente->codigo_cli="CLI-0".($cli->id+1);
        $cliente->nombre=$request->nombre;
        $cliente->ci=$request->ci;
        $cliente->celular=$request->celular;
        if (Cliente::where('ci', '=', $cliente->ci)->exists()) {
            Session ::flash('yaexiste','Ya existe un Cliente con el mismo NIT/CI');
            return Redirect ::to('/mostrarclientes');
        } else {
            $cliente->save();
            Session::flash('creado','El Cliente se creo correctamente');
            return Redirect::to('/mostrarclientes');
        }
    }

    public function BuscarCliente($id)
    {
        $cliente = Cliente::where('id',$id)->get();
        return $cliente;
    }

    public function BuscarClienteCi($ci)
    {
        $cliente = Cliente::where('ci',$ci)->get();
        return $cliente;
    }

    public function BuscarClienteCodigo($codigo)
    {
        $cliente = Cliente::where('codigo_cli',$codigo)->get();
        return $cliente;
    }

    public function UpdateCliente(Request $request)
    {
        Cliente::find($request->id)->update($request->all());
        return redirect('mostrarclientes')->with('success', 'Clientes actualizado satisfactoriamente');
    }

    public function EliminarCliente($id)
    {
        Cliente::find($id)->delete();
        return redirect('mostrarclientes');
    }
    
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    
}
