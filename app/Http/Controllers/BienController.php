<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BienController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function ListaBien()
    {
        $cantidad=Bien::all()->count();
        $bien=Bien::Paginate(100);
        return view('/Bienes.ListaBienes',compact('cantidad','bien'));
    }

    
    public function crearBien(Request $request)
    {
        $bien=new Bien();
        $bien->nombre=$request->nombre;
        if (Bien::where('nombre', '=', $bien->nombre)->exists()) {
            Session::flash('message','El Grupo ya existe');
            return Redirect::to('/mostrarbienes');
        } else {
            $bien->save();
            Session::flash('success','El Grupo se creo correctamente');
            return Redirect::to('/mostrarbienes');
        }
    }

   
    public function store(Request $request)
    {
        //
    }

    public function editarbien($id)
    {
        $bien = Bien::where('id',$id)->get();
        return $bien;
    }

    public function updatebien(Request $request)
    {
        Bien::find($request->id)->update($request->all());
        return redirect('mostrarbienes')->with('success', 'Bien actualizado satisfactoriamente');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bien  $bien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bien $bien)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bien  $bien
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bien $bien)
    {
        //
    }
}
