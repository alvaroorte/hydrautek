<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ListaProveedores()
    {
        $cantidad=Proveedor::all()->count()-1;
        $proveedores=Proveedor::where('id', '!=', 0)->simplePaginate();
        return view('Proveedores.ListaProveedores',compact('cantidad','proveedores'));
    }

    public function CrearProveedor(Request $request)
    {
        $prov = Proveedor::latest('id')->first();
        $proveedor=new Proveedor();
        $proveedor->codigo_prov="PROV-0".($prov->id+1);
        $proveedor->nombre=$request->nombre;
        $proveedor->nit=$request->nit;
        $proveedor->celular=$request->celular;

        if (Proveedor::where('nit', '=', $proveedor->nit)->exists()) {
            Session::flash('yaexiste','Ya existe un Proveedor con el mismo NIT/CI');
            return Redirect::to('/mostrarproveedores');
        } else {
            $proveedor->save();
            Session::flash('creado','El Proveedor se creo correctamente');
            return Redirect::to('/mostrarproveedores');
        }
    }

    public function BuscarProveedor($id)
    {
        $proveedor = Proveedor::where('id',$id)->get();
        return $proveedor;
    }

    public function BuscarProveedorNit($nit)
    {
        $proveedor = Proveedor::where('nit',$nit)->get();
        return $proveedor;
    }

    public function BuscarProveedorCod($codigo)
    {
        $proveedor = Proveedor::where('codigo_prov',$codigo)->get();
        return $proveedor;
    }

    public function UpdateProveedor(Request $request)
    {
        Proveedor::find($request->id)->update($request->all());
        return redirect('mostrarproveedores')->with('success', 'Proveedor actualizado satisfactoriamente');
    }

    public function EliminarProveedor($id)
    {
        Proveedor::find($id)->delete();
        return redirect('mostrarproveedores');
    }
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedor $proveedor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedor)
    {
        //
    }
}
