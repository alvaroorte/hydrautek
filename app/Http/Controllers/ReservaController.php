<?php

namespace App\Http\Controllers;

use App\Models\articulo;
use App\Models\Banco;
use App\Models\Bien;
use App\Models\Cliente;
use App\Models\Pago;
use App\Models\Reserva;
use App\Models\Salida;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function ListaReserva()
    {
        $articulos = articulo::all();
        $clientes = Cliente::all();
        $bienes = Bien::all();
        $sql = Reserva::where('id', "!=", 0)->distinct("identificador")
        ->get();
        $cantidad = $sql->count();
        //return $sql;
        return view('/Reservas.VerReserva',compact('cantidad','bienes','articulos','sql','clientes'));
    }

    public function MostrarFormServicio()
    {
        $bienes= Bien::all();
        return View('/Servicios.ReservaServicio',compact('bienes'));
    }

    public function ReservaDetallada($id)
    {
        $articulos=articulo::all();
        $bienes= Bien::all();
        $bancos = Banco::all();
        $clientes = Cliente::all();
        $reserva = Reserva::where('identificador',$id)->first();
        $sql=Reserva::join("biens","reservas.id_bien","=","biens.id")
        ->join("articulos", "reservas.id_articulo","=","articulos.id")
        ->where('reservas.identificador', '=', $id)
        ->select("articulos.nombre as nombre_articulo","articulos.*","biens.nombre as nombre_bien","reservas.*",)
        ->orderBy('reservas.id','desc')
        ->get();
        $cantidad=$sql->count();

        $sql2 = Pago::where('id_credito', $reserva->identificador)
        ->where('tipo','reserva')
        ->get();
        $saldo = 0; 
        foreach ($sql2 as $pago) {
            $saldo += $pago->monto;
        }
        $saldo = $reserva->total-$reserva->descuento-$saldo;
        //return $sql2;
        return view('/Reservas.ReservaDetallada',compact('cantidad','sql2','reserva','bienes','articulos','sql','id','clientes', 'bancos', 'saldo' ));
    }

   
    public function CrearReserva(Request $request)
    {
        $ide = Reserva::latest('id')->first();
        if (!(is_countable($request->id_bien)?$request->id_bien:[]) ) {
            $co = Reserva::latest('id')->first();
            $reserva=new Reserva();
            $reserva->fecha=$request->fecha;
            $reserva->codigo_reserva="R-0".($ide->num_reserva+1);
            $reserva->cliente=$request->cliente;
            $reserva->detalle=$request->detalle;
            $reserva->nit_cliente=$request->nit_cliente;
            $reserva->id_cliente=$request->id_cliente;
            $reserva->identificador = ($ide->id)+1;
            $reserva->num_reserva = ($ide->num_reserva)+1;
            $reserva->id_bien=0;
            $reserva->id_articulo=0;
            $reserva->cantidad=0;
            $reserva->p_venta=0;
            $reserva->sub_total=0;
            $reserva->estado = true;
            $reserva->total=$request->total;
            $reserva->plazo=$request->plazo;
            $reserva->saldo=$request->total-$request->descuento;
            $reserva->descuento=$request->descuento;
            
            $reserva->save();
        }
        else {
            for($i=0;$i<count($request->id_bien);$i++)
            {
                $reserva=new Reserva();
                $reserva->fecha=$request->fecha;
                $reserva->codigo_reserva="R-0".($ide->num_reserva+1);
                $reserva->cliente=$request->cliente;
                $reserva->detalle=$request->detalle;
                $reserva->nit_cliente=$request->nit_cliente;
                $reserva->id_cliente=$request->id_cliente;
                $reserva->identificador = ($ide->id)+1;
                $reserva->num_reserva = ($ide->num_reserva)+1;
                $reserva->id_bien=$request->id_bien[$i];
                $reserva->id_articulo=$request->id_articulo[$i];
                $reserva->cantidad=$request->cantidad[$i];
                $reserva->p_venta=$request->p_venta[$i];
                $reserva->sub_total=$request->sub_total[$i];
                $reserva->estado = true;
                $reserva->total=$request->total;
                $reserva->plazo=$request->plazo;
                $reserva->saldo=$request->total-$request->descuento;
                $reserva->descuento=$request->descuento;

                $articulo = articulo::find($reserva->id_articulo);
                $articulo->reservado += $reserva->cantidad;  
                
                $reserva->save();
                $articulo->save();

            }
        }
        
        $reserva = Reserva::latest('id')->first();
        $plazo = date("Y-m-d", strtotime($reserva->fecha.'+ '.$reserva->plazo.' days'));
        $sql = Reserva::join("biens","reservas.id_bien","=","biens.id")
        ->join("articulos", "reservas.id_articulo","=","articulos.id")
        ->where('reservas.identificador', '=', $reserva->identificador) 
        ->select("articulos.nombre as nombre_articulo","articulos.*","biens.nombre as nombre_bien","reservas.*",)
        ->orderBy('reservas.id','Asc')
        ->get();
        
        $pdf = PDF::loadView('/Reservas.ReporteReserva', compact('reserva','sql','request','plazo'));
       
        return $pdf->setPaper('a4')->stream('reserva.pdf');
    
    }

    public function ReporteReserva()
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

    public function BuscarReserva($id)
    {
        $cotizacion = Reserva::where('id',$id)->get();
        return $cotizacion;
    }

    public function UpdateReserva(Request $request)
    {
        Reserva::find($request->id)->update($request->all());
        $cotizacion = Reserva::find($request->id);

        $cotizacion->descuento = $request->descuento;
        $cotizacion->save();
        Reserva::where('identificador', $cotizacion->identificador)->update(array('total' => $cotizacion->total, 'descuento' => $cotizacion->descuento )); 
       
        return redirect(url('cotizaciondetallada/'.$cotizacion->identificador))->with('success', 'Cotizacion actualizada satisfactoriamente');
    }

    public function EliminarReserva($id)
    {
        $cotizacion = Reserva::find($id);
        $sql = Reserva::where('identificador', $cotizacion->identificador)->get();
        if ( $sql->count() > 1 ) {
            $total = $cotizacion->total-$cotizacion->sub_total;
            Reserva::where('identificador', $cotizacion->identificador)->update(array('total' => $total )); 
            Reserva::find($id)->delete();
            return redirect(url('cotizaciondetallada/'.$cotizacion->identificador))->with('success', 'Cotizacion eliminada correctamente');
        } else {
            Reserva::find($id)->delete();
            return redirect(url('mostrarcotizaciones'))->with('success', 'Cotizacion eliminada completamente');
        }
        
        
    }

    public function BuscarReservas($identificador)
    {
        $reservas = Reserva::where('identificador',$identificador)->get();
        return $reservas;
    }

    public function destroy(Reserva $reserva)
    {
        //
    }
}
