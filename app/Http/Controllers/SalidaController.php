<?php

namespace App\Http\Controllers;

use App\Models\Salida;
use App\Models\articulo;
use App\Models\Automovil;
use App\Models\Banco;
use App\Models\Bien;
use App\Models\Caja;
use App\Models\Chofer;
use App\Models\Cliente;
use App\Models\Credito;
use App\Models\Movimiento_Banco;
use App\Models\Operador;
use App\Models\Pago;
use App\Models\peps;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Hamcrest\Type\IsInteger;
use PhpParser\Node\Stmt\Break_;
use Ramsey\Uuid\Type\Integer;

class SalidaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function listaSalida()
    {
        $articulos=articulo::all();
        $clientes = Cliente::all();
        $bienes= Bien::all();
        $bancos= Banco::all();
        $salida = Salida::latest('id')->first();
        $sql=Salida::where('id', '!=', '0' )
        ->distinct("identificador")
        ->orderBy('identificador','desc')
        ->get();
        $cantidad = $sql->count();
        return view('/Salidas.ListaSalida',compact('cantidad','bienes','articulos','sql','clientes','bancos','salida' ));
    }
    public function MostrarFormServicio()
    {
        $bienes= Bien::all();
        $bancos = Banco::all();
        return View('/Servicios.ListaServicio',compact('bienes', 'bancos'));
    }

    public function SalidaDetallada($id)
    {
        $articulos=articulo::all();
        $bienes= Bien::all();
        $salida = Salida::where('identificador',$id)->first();
        $banco = Banco::where('id',$salida->id_banco)->first();
        $sql=Salida::join("biens","salidas.id_bien","=","biens.id")
        ->join("articulos", "salidas.id_articulo","=","articulos.id")
        ->where('salidas.identificador', '=', $id)
        ->select("articulos.nombre as nombre_articulo","articulos.marca","articulos.cantidad","biens.nombre as nombre_bien","salidas.*",)
        ->orderBy('salidas.fecha','Desc')
        ->get();
        $cantidad=Salida::where('identificador', $id)->count();
        if ($salida->detalle != null ) {
            return view('/Servicios.ServicioDetallado',compact('cantidad','bienes','articulos','sql','salida','banco' ));
        }
        return view('/Salidas.SalidaDetallada',compact('cantidad','bienes','articulos','sql','salida','banco' ));
    }

   
    public function crearSalida(Request $request)
    {
        $ide = Salida::latest('id')->first();
        if ($request->tipo == 1) {
            $cv = 'VS-0'.($ide->num_venta+1);
        } else {
            $cv = 'VP-0'.($ide->num_venta+1);
        }
        $credito = new Credito();
        $credito->total = 0;
        $credito->saldo = 0;
        if (!(is_countable($request->id_bien)?$request->id_bien:[]) ) {
            
            $salida=new Salida();
            $salida->scfactura = $request->scfactura;
            $salida->num_factura = $request->num_factura;
            $salida->sccredito = $request->sccredito;
            $salida->id_banco = $request->banco;
            $salida->fecha = $request->fecha;
            $salida->total = $request->total;
            $salida->descuento = $request->descuento;
            $salida->codigo_cli = $request->codigo_cli;
            $salida->nit_cliente = $request->nit_cliente;
            $salida->id_cliente = $request->id_cliente;
            $salida->cliente = $request->cliente;
            $salida->detalle = $request->detalle;
            $salida->identificador = ($ide->id)+1;
            $salida->num_venta = ($ide->num_venta)+1;
            $salida->codigo_venta = $cv;
            $salida->estado = true;
            $credito->identificador = ($ide->id)+1;

            $salida->id_bien=0;
            $salida->id_articulo=0;
            $salida->cantidad=0;
            $salida->sub_total=0;
            $salida->p_venta=0;
            $credito->total = $request->total;
            $credito->saldo = $request->total;
            
            $salida->save();

            if ($request->reserva == 1) {
                $reserva = Reserva::where('identificador',$request->identificador_reserva)->first();
                $reserva->codigo_reserva = $reserva->codigo_reserva." "."V";
                $reserva->save();
                
            }

        }
        else {
            for($i=0;$i<count($request->id_bien);$i++)
            {

                $salida=new Salida();
                $salida->scfactura=$request->scfactura;
                $salida->num_factura=$request->num_factura;
                $salida->sccredito=$request->sccredito;
                $salida->id_banco = $request->banco;
                $salida->fecha=$request->fecha;
                $salida->total=$request->total;
                $salida->descuento=$request->descuento;
                $salida->codigo_cli=$request->codigo_cli;
                $salida->nit_cliente=$request->nit_cliente;
                $salida->id_cliente=$request->id_cliente;
                $salida->cliente=$request->cliente;
                $salida->detalle=$request->detalle;
                $salida->identificador = ($ide->id)+1;
                $salida->num_venta = ($ide->num_venta)+1;
                $salida->codigo_venta = $cv;
                $salida->estado = true;
                $credito->identificador = ($ide->id)+1;

                $articulo=new articulo();
                $articulo= articulo::find($request->id_articulo[$i]);
                $articulo->cantidad = $articulo->cantidad - $request->cantidad[$i];
                $peps = peps::where('id_articulo',$articulo->id)->Where('cantidad','>',0)
                ->orderBy('id')
                ->get();
                $c = $request->cantidad[$i];
                if ($peps != null) {
                    
                    foreach ($peps as $pe) {
                        if ($c <= $pe->cantidad) {
                            $pe->cantidad = $pe->cantidad - $c;
                            $pe->estado = false;
                            $salida->costo_s = $salida->costo_s + ($pe->costo * $c);
                            $pe->save();
                            break;
                        } else {
                            $c = $c - $pe->cantidad;
                            $salida->costo_s = $salida->costo_s + ($pe->costo * $pe->cantidad);
                            $pe->cantidad = 0;
                            $pe->estado = false;
                            $pe->save();
                        }
                    }
                } else {
                    $salida->costo_s = $c * $articulo->costo;
                }   
               
                
                $salida->id_bien=$request->id_bien[$i];
                $salida->id_articulo=$request->id_articulo[$i];
                $salida->cantidad=$request->cantidad[$i];
                $salida->sub_total=$request->sub_total[$i];
                $salida->p_venta=$request->p_venta[$i];
                $credito->total = $request->total-$request->descuento;
                $credito->saldo = $request->total-$request->descuento;
                $articulo->saldo_articulo -= $salida->costo_s;
                if ($request->reserva == 1) {
                    $articulo->reservado -= $request->cantidad[$i];
                    $reserva = Reserva::where('identificador',$request->identificador_reserva)->where('id_articulo',$request->id_articulo[$i])->first();
                    $reserva->codigo_reserva = $reserva->codigo_reserva." "."V";
                    $reserva->save();
                    
                }
                
                $salida->save();
                $articulo->save();

            
            }
        }

        if ($request->sccredito == 1) {
            $credito->fecha = $request->fecha;
            $credito->id_cliente = $request->id_cliente;
            $credito->codigo = $cv;
            $credito->tipo = 'venta';
            $credito->estado = true;
            $credito->plazo = $request->plazo;
            $credito->save();
        }
        else {
            if ($request->sccredito == 0) {
                $ucaja = Caja::latest('id')->first();
                $caja = New Caja();
                $caja->fecha = $request->fecha;
                if ($request->tipo == 1) {
                    $caja->tipo = 'VENTA DE SERVICIO';
                } else {
                    $caja->tipo = 'VENTA DE PRODUCTO';
                }
                $caja->razon_social = $request->cliente;
                $caja->concepto = 'Venta al Contado';
                $caja->num_documento = $cv;
                $caja->importe = $request->total-$request->descuento;
                $caja->saldo = $ucaja->saldo+$caja->importe;
                $caja->save();
            } else {
                $banco = New Movimiento_Banco();
                $banco->id_banco = $request->banco;
                $banco->fecha = $request->fecha;
                if ($request->tipo == 1) {
                    $banco->tipo = 'VENTA DE SERVICIO';
                } else {
                    $banco->tipo = 'VENTA DE PRODUCTO';
                }
                $banco->razon_social = $request->cliente;
                $banco->concepto = 'Venta';
                $banco->num_documento = $cv;
                $banco->importe = $request->total-$request->descuento;
                $banco->save();
            }
            
            
        }
        

        $salida = Salida::latest('id')->first();
        $cliente = Cliente::where('ci', '=', $request->nit_cliente)->get(); 
        $sql=Salida::join("biens","salidas.id_bien","=","biens.id")
        ->join("articulos", "salidas.id_articulo","=","articulos.id")
        ->where('salidas.identificador', '=', $salida->identificador) 
        ->select("articulos.nombre as nombre_articulo","articulos.*","biens.nombre as nombre_bien","salidas.*",)
        ->orderBy('salidas.id','desc')
        ->get();

        if ($request->tipo == 1) {
            $pdf = PDF::loadView('/Servicios.ReporteServicio', compact('salida','sql','cliente','request'));
        } else {
            $pdf = PDF::loadView('/Salidas.ReporteSalida', compact('salida','sql','cliente','request'));
        }
       
        return $pdf->setPaper('a4')->stream('reporte.pdf');
        
        
        //return view('/Salidas.ReporteSalida',compact('request'));
        //return redirect('reportesalida');
    }

    public function ReporteSalida($identificador)
    {

        $salida = Salida::where('identificador',$identificador)->first();
        $cliente = Cliente::where('ci', $salida->nit_cliente)->get();
        $sql=Salida::join("biens","salidas.id_bien","=","biens.id")
        ->join("articulos", "salidas.id_articulo","=","articulos.id")
        ->where('salidas.identificador', '=', $identificador) 
        ->select("articulos.nombre as nombre_articulo","articulos.*","biens.nombre as nombre_bien","salidas.*",)
        ->orderBy('salidas.id','asc')
        ->get();

        if ($salida->detalle != null ) {
            $pdf = PDF::loadView('/Servicios.ReporteServicio', compact('salida','sql','cliente'));
        }
        else {
            $pdf = PDF::loadView('/Salidas.ReporteSalida', compact('salida','sql','cliente'));
        }
        
        return $pdf->setPaper('a4')->stream('ReporteVenta.pdf');
        
    }

    public function ReporteFechaSalida(Request $request)
    {
        $fi=$request->fi;
        $ff=$request->ff;
        
        if ($request->tipo == 'todo') {
            $sql=Salida::whereBetween('fecha',[$fi,$ff])->distinct('identificador')
            ->get();
        } else {
            if ($request->tipo_venta == 'VP-' ) {
                if ($request->documento == '2') {
                    if ($request->pago == '3') {
                        $sql=Salida::whereBetween('fecha',[$fi,$ff])->where('codigo_venta','LIKE', $request->tipo_venta."%")
                        ->distinct('identificador')
                        ->get();
                    } else {
                        $sql=Salida::whereBetween('fecha',[$fi,$ff])->where('codigo_venta','LIKE', $request->tipo_venta."%")
                        ->where('sccredito',$request->pago)
                        ->distinct('identificador')
                        ->get();
                    }
                } else {
                    if ($request->pago == '3') {
                        $sql=Salida::whereBetween('fecha',[$fi,$ff])->where('codigo_venta','LIKE', $request->tipo_venta."%")
                        ->where('scfactura',$request->documento)
                        ->distinct('identificador')
                        ->get();
                    } else {
                        $sql=Salida::whereBetween('fecha',[$fi,$ff])->where('codigo_venta','LIKE', $request->tipo_venta."%")
                        ->where('scfactura',$request->documento)
                        ->where('sccredito',$request->pago)
                        ->distinct('identificador')
                        ->get();
                    }
                }
            } else {
                if ($request->tipo_venta == 'VS-' ) {   
                    if ($request->documento == '2') {
                        if ($request->pago == '3') {
                            $sql=Salida::whereBetween('fecha',[$fi,$ff])->where('codigo_venta','LIKE', $request->tipo_venta."%")
                            ->distinct('identificador')
                            ->get();
                        } else {
                            $sql=Salida::whereBetween('fecha',[$fi,$ff])->where('codigo_venta','LIKE', $request->tipo_venta."%")
                            ->where('sccredito',$request->pago)
                            ->distinct('identificador')
                            ->get();
                        }
                    } else {
                        if ($request->pago == '3') {
                            $sql=Salida::whereBetween('fecha',[$fi,$ff])->where('codigo_venta','LIKE', $request->tipo_venta."%")
                            ->where('scfactura',$request->documento)
                            ->distinct('identificador')
                            ->get();
                        } else {
                            $sql=Salida::whereBetween('fecha',[$fi,$ff])->where('codigo_venta','LIKE', $request->tipo_venta."%")
                            ->where('scfactura',$request->documento)
                            ->where('sccredito',$request->pago)
                            ->distinct('identificador')
                            ->get();
                        }
                    }
                }
                else {
                    if ($request->documento == '2') {
                        if ($request->pago == '3') {
                            $sql=Salida::whereBetween('fecha',[$fi,$ff])
                            ->distinct('identificador')
                            ->get();
                        } else {
                            $sql=Salida::whereBetween('fecha',[$fi,$ff])
                            ->where('sccredito',$request->pago)
                            ->distinct('identificador')
                            ->get();
                        }
                    } else {
                            if ($request->pago == '3') {
                                $sql=Salida::whereBetween('fecha',[$fi,$ff])
                                ->where('scfactura',$request->documento)
                                ->distinct('identificador')
                                ->get();
                            } else {
                                $sql=Salida::whereBetween('fecha',[$fi,$ff])
                                ->where('scfactura',$request->documento)
                                ->where('sccredito',$request->pago)
                                ->distinct('identificador')
                                ->get();
                            }
                    }
                }
            }
        }
        $sql = $sql->sortBy('id')->sortBy('fecha');
        $pdf = PDF::loadView('/Reportes.VerReportesSalida',compact('sql' ));
        return $pdf->setPaper('a4')->stream('reportesalida.pdf');
       

        //return view('/Reportes.VerReportes',compact('salida','sql' ));
    }

    public function ReporteFechaSalidaForm()
    {
        return view('/Reportes.ReporteFormSalida');
    }


    public function LibroDeVentas(Request $request)
    {
        $fi=$request->fi;
        $ff=$request->ff;
        $autorizacion = $request->autorizacion;
        $salidas = Salida::whereBetween('fecha',[$fi,$ff])
        ->where('scfactura',true)
        ->distinct('identificador')->get();
        $cantidad = $salidas->count();
        return view('/Salidas.LibroDeVentas',compact('salidas','fi','ff','autorizacion','cantidad'));
        
    }

    public function LibroDeVentasForm()
    {
        return view('/Salidas.LibroDeVentasForm');
    }

    public function EncontrarUltimaVenta($id)
    {
        $sa = Salida::where('scfactura',$id)->latest('id')->first();
        $salida = Salida::where('id',$sa->id)->get();
        return $salida;
    }
    
    public function EliminarSalida($identificador)
    {
        $salida = Salida::where('identificador',$identificador)->first();
        $salidas = Salida::where('identificador',$identificador)->get();
        foreach ($salidas as $salida) {
            $costo = $salida->costo_s / $salida->cantidad;
            $peps = peps::where('costo',$costo)->Where('id_articulo',$salida->id_articulo)
            ->orderBy('id')->first();
            $peps->cantidad += $salida->cantidad;
            $peps->save();
        }
        if ($salida->sccredito == 0) {
            $caja = Caja::where('num_documento',$salida->codigo_venta)->first();
                $cajas = Caja::where('id', '>=',$caja->id)->get();
                foreach ($cajas as $ca) {
                    $ca->saldo = $ca->saldo - $salida->total;
                    $ca->save();
                }
                Caja::find($caja->id)->delete();
        }
        else {
            if ($salida->sccredito == 2) {
                Movimiento_Banco::where('num_documento',$salida->codigo_venta)->first()->delete();
            }
            else {
                Credito::where('codigo',$salida->codigo_venta)->first()->delete();
            }
        }
        foreach ($salidas as $salida) {
            $salida->estado = false;
            $salida->save();
        }
        
        return redirect(url('mostrarsalidas'))->with('eliminar','si');
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salida  $salida
     * @return \Illuminate\Http\Response
     */
    public function show(Salida $salida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salida  $salida
     * @return \Illuminate\Http\Response
     */
    public function edit(Salida $salida)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salida  $salida
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salida $salida)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salida  $salida
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salida $salida)
    {
        //
    }
}
