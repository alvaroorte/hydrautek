<?php

namespace App\Http\Controllers;

use App\Models\articulo;
use App\Models\Banco;
use App\Models\Bien;
use App\Models\Cliente;
use App\Models\Cotizacion;
use App\Models\Credito;
use App\Models\Salida;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class CotizacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function ListaCotizacion()
    {
        $articulos = articulo::all();
        $clientes = Cliente::all();
        $bienes = Bien::all();
        $sql = Cotizacion::where('id', "!=", 0)->distinct("cotizacions.identificador")
        ->get();
        $cantidad = $sql->count();
        //return $sql;
        return view('/Cotizaciones.VerCotizaciones',compact('cantidad','bienes','articulos','sql','clientes'));
    }

    public function MostrarFormServicio()
    {
        $bienes= Bien::all();
        return View('/Servicios.CotizacionServicio',compact('bienes'));
    }

    public function CotizacionDetallada($id)
    {
        $articulos=articulo::all();
        $bienes= Bien::all();
        $bancos = Banco::all();
        $clientes = Cliente::all();
        $cotizacion = Cotizacion::where('identificador',$id)->first();
        $sql=Cotizacion::join("biens","cotizacions.id_bien","=","biens.id")
        ->join("articulos", "cotizacions.id_articulo","=","articulos.id")
        ->where('cotizacions.identificador', '=', $id)
        ->select("articulos.nombre as nombre_articulo","articulos.*","biens.nombre as nombre_bien","cotizacions.*",)
        ->orderBy('cotizacions.id','desc')
        ->get();
        $cantidad=$sql->count();
        //return $sql;
        return view('/Cotizaciones.CotizacionDetallada',compact('cantidad','cotizacion','bienes','articulos','sql','id','clientes', 'bancos' ));
    }

   
    public function CrearCotizacion(Request $request)
    {
        $ide = Cotizacion::latest('id')->first();
        if (!(is_countable($request->id_bien)?$request->id_bien:[]) ) {
            $co = Cotizacion::latest('id')->first();
            $cotizacion=new Cotizacion();
            $cotizacion->fecha=$request->fecha;
            $cotizacion->codigo_coti="COT-0".($ide->num_coti+1);
            $cotizacion->cliente=$request->cliente;
            $cotizacion->detalle=$request->detalle;
            $cotizacion->nit_cliente=$request->nit_cliente;
            $cotizacion->id_cliente=$request->id_cliente;
            $cotizacion->validez=$request->validez;
            $cotizacion->identificador = ($ide->id)+1;
            $cotizacion->num_coti = ($ide->num_coti)+1;
            $cotizacion->id_bien=0;
            $cotizacion->id_articulo=0;
            $cotizacion->cantidad=0;
            $cotizacion->p_venta=0;
            $cotizacion->sub_total=0;
            $cotizacion->total=$request->total;
            $cotizacion->descuento=$request->descuento;
            
            $cotizacion->save();
        }
        else {
            for($i=0;$i<count($request->id_bien);$i++)
            {
                $co = Cotizacion::latest('id')->first();
                $cotizacion=new Cotizacion();
                $cotizacion->fecha=$request->fecha;
                $cotizacion->codigo_coti="COT-0".($ide->num_coti+1);
                $cotizacion->cliente=$request->cliente;
                $cotizacion->detalle=$request->detalle;
                $cotizacion->nit_cliente=$request->nit_cliente;
                $cotizacion->id_cliente=$request->id_cliente;
                $cotizacion->validez=$request->validez;
                $cotizacion->identificador = ($ide->id)+1;
                $cotizacion->num_coti = ($ide->num_coti)+1;
                $cotizacion->id_bien=$request->id_bien[$i];
                $cotizacion->id_articulo=$request->id_articulo[$i];
                $cotizacion->cantidad=$request->cantidad[$i];
                $cotizacion->p_venta=$request->p_venta[$i];
                $cotizacion->sub_total=$request->sub_total[$i];
                $cotizacion->total=$request->total;
                $cotizacion->descuento=$request->descuento;
                
                $cotizacion->save();

            }
        }
        
        $cotizacion = Cotizacion::latest('id')->first();
        $sql = Cotizacion::join("biens","cotizacions.id_bien","=","biens.id")
        ->join("articulos", "cotizacions.id_articulo","=","articulos.id")
        ->where('cotizacions.identificador', '=', $cotizacion->identificador) 
        ->select("articulos.nombre as nombre_articulo","articulos.*","biens.nombre as nombre_bien","cotizacions.*",)
        ->orderBy('cotizacions.id','desc')
        ->get();
        
        $pdf = PDF::loadView('/Cotizaciones.ReporteCotizacion', compact('cotizacion','sql','request'));
       
        return $pdf->setPaper('a4')->stream('reporte.pdf');
    
    }

    public function ReporteCotizacion()
    {

        $salida = Salida::latest('id')->first();



        $sql2=Salida::join("chofers", "salidas.id_chofer","=","chofers.idChofer")
        ->join("automovils", "salidas.id_automovil","=","automovils.idAutomovil")
        ->where('salidas.identificador', '=', $salida->identificador) 
        ->select("automovils.placa",
        "chofers.nombre as nombre_chofer","chofers.apellidoPat as apellido_chofer","salidas.*",)
        ->orderBy('salidas.id','desc')
        ->first();



        $sql=Salida::join("biens","salidas.id_bien","=","biens.id")
        ->join("articulos", "salidas.id_articulo","=","articulos.id")
        ->where('salidas.identificador', '=', $salida->identificador) 
        ->select("articulos.nombre as nombre_articulo","articulos.marca","biens.nombre as nombre_bien","salidas.*",)
        ->orderBy('salidas.id','desc')
        ->get();

        

        $pdf = PDF::loadView('/Salidas.ReporteSalida', compact('salida','sql','sql2'));
       
        return $pdf->setPaper('a4')->stream('reporte.pdf');
        
    }

    public function BuscarCotizacion($id)
    {
        $cotizacion = Cotizacion::where('id',$id)->get();
        return $cotizacion;
    }

    public function UpdateCotizacion(Request $request)
    {
        Cotizacion::find($request->id)->update($request->all());
        $cotizacion = Cotizacion::find($request->id);

        $cotizacion->descuento = $request->descuento;
        $cotizacion->save();
        Cotizacion::where('identificador', $cotizacion->identificador)->update(array('total' => $cotizacion->total, 'descuento' => $cotizacion->descuento )); 
       
        return redirect(url('cotizaciondetallada/'.$cotizacion->identificador))->with('success', 'Cotizacion actualizada satisfactoriamente');
    }

    public function EliminarCotizacion($id)
    {
        $cotizacion = Cotizacion::find($id);
        $sql = Cotizacion::where('identificador', $cotizacion->identificador)->get();
        if ( $sql->count() > 1 ) {
            $total = $cotizacion->total-$cotizacion->sub_total;
            Cotizacion::where('identificador', $cotizacion->identificador)->update(array('total' => $total )); 
            Cotizacion::find($id)->delete();
            return redirect(url('cotizaciondetallada/'.$cotizacion->identificador))->with('success', 'Cotizacion eliminada correctamente');
        } else {
            Cotizacion::find($id)->delete();
            return redirect(url('mostrarcotizaciones'))->with('success', 'Cotizacion eliminada completamente');
        }
        
        
    }

    public function BuscarCotizaciones($identificador)
    {
        $cotizacion = Cotizacion::where('identificador',$identificador)->get();
        return $cotizacion;
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function show(Cotizacion $cotizacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Cotizacion $cotizacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cotizacion $cotizacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cotizacion  $cotizacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cotizacion $cotizacion)
    {
        //
    }
}
