<?php

namespace App\Http\Controllers;

use App\Exports\EntradaExport;
use App\Models\Entrada;
use App\Models\articulo;
use App\Models\Banco;
use App\Models\Bien;
use App\Models\Caja;
use App\Models\Credito;
use App\Models\Movimiento_Banco;
use App\Models\peps;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class EntradaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function ListaEntrada()
    {
        $articulos=articulo::all();
        $bienes= Bien::all();
        $bancos = Banco::all();
        $sql=Entrada::join("biens","entradas.id_bien","=","biens.id")
        ->join("articulos", "entradas.id_articulo","=","articulos.id")
        ->where('entradas.identificador', '!=', 0)
        ->select ("articulos.nombre as nombre_articulo","articulos.marca","biens.nombre as nombre_bien","biens.id","entradas.*")
        ->distinct("entradas.identificador")
        ->orderBy('entradas.identificador','asc')
        ->get();
        $cantidad = $sql->count();
        $entrada=Entrada::simplePaginate(100);
        //return $sql;
        return view('/Entradas.ListaEntrada',compact('cantidad','entrada','bienes','articulos','sql','bancos' ));
        
    }

    public function EntradaDetallada($id)
    {
        $articulos=articulo::all();
        $bienes= Bien::all();
        $entrada = Entrada::where('identificador', $id)->first();
        $banco = Banco::where('id',$entrada->id_banco)->first();
        $sql=Entrada::join("biens","entradas.id_bien","=","biens.id")
        ->join("articulos", "entradas.id_articulo","=","articulos.id") 
        ->where('entradas.identificador', '=', $id)
        ->select("articulos.nombre as nombre_articulo","articulos.marca","articulos.unidad","biens.nombre as nombre_bien","entradas.*")
        ->orderBy('entradas.id','desc')
        ->get();
        $cantidad = $sql->count();
        //return $sql;
        return view('/Entradas.EntradaDetallada',compact('cantidad','entrada','bienes','articulos','sql','banco' ));

     
        
    }

    public function crearEntrada(Request $request)
    {
        $ide = Entrada::latest('id')->first();
        $credito = new Credito();
        $credito->total = 0;
        $credito->saldo = 0;
        for($i=0;$i<count($request->id_bien);$i++)
        {
            $entrada=new Entrada();
            $entrada->fecha = $request->fecha;
            $entrada->codigo = $request->codigo;
            $entrada->cscredito = $request->cscredito;
            $entrada->id_banco = $request->banco ;
            $entrada->csfactura = $request->csfactura;
            $entrada->num_factura = $request->num_factura;
            $entrada->proveedor = $request->proveedor;
            $entrada->id_proveedor = $request->id_proveedor;
            $entrada->nit_proveedor = $request->nit_proveedor;
            $entrada->detalle = $request->detalle;
            $entrada->total = $request->total;
            
            $entrada->id_bien=$request->id_bien[$i];
            $entrada->id_articulo=$request->id_articulo[$i];
            $entrada->cantidad=$request->cantidad[$i];
            $entrada->p_unitario=$request->p_unitario[$i];
            $entrada->p_total=$request->p_total[$i];
            $credito->total += $request->p_total[$i];
            $credito->saldo += $request->p_total[$i];
            $entrada->identificador = ($ide->id)+1;
            $entrada->num_entrada = ($ide->num_entrada)+1;
            $entrada->codigo = 'CP-0'.($ide->num_entrada+1);
            $credito->identificador = ($ide->id)+1;
            
        
            $articulo=new articulo();
            $articulo= articulo::find($request->id_articulo[$i]);
            if ($request->csfactura == 1) {
                $articulo->costo = $request->p_unitario[$i]*0.87;
                $entrada->costo_e = $articulo->costo;
            } else {
                $articulo->costo = $request->p_unitario[$i];
                $entrada->costo_e = $articulo->costo;
            }
            $peps = new peps;
            $peps->costo = $articulo->costo;
            $peps->id_articulo = $articulo->id;
            $peps->cantidad = $entrada->cantidad; 
            $peps->estado = true;
            $articulo->cantidad=$articulo->cantidad + $request->cantidad[$i];
            $articulo->p_unitario=$request->p_unitario[$i];
            $articulo->p_venta=$request->p_venta[$i];
            $articulo->saldo_articulo = $articulo->saldo_articulo + ($request->cantidad[$i] * $articulo->costo);
            $articulo->save();
            $entrada->save();
            $peps->save();

        }
        if ($request->cscredito == 1) {
            $credito->fecha = $request->fecha;
            $credito->tipo = 'compra';
            $credito->estado = true;
            $credito->codigo = $entrada->codigo;
            $credito->id_proveedor = $request->id_proveedor;
            $credito->plazo = $request->plazo;
            $credito->save();
        }
        else {
            if ($request->cscredito == 0) {
                $ucaja = Caja::latest('id')->first();
                $caja = New Caja();
                $caja->fecha = $request->fecha;
                $caja->tipo = 'COMPRA';
                $caja->razon_social = $request->proveedor;
                $caja->concepto = 'Compra al Contado';
                $caja->num_documento = $entrada->codigo;
                $caja->importe = ($request->total)*-1;
                $caja->saldo = $ucaja->saldo-$request->total;
                $caja->save();
            } else {
                $banco = New Movimiento_Banco();
                $banco->id_banco = $request->banco;
                $banco->fecha = $request->fecha;
                $banco->tipo = 'COMPRA DE PRODUCTO';
                $banco->razon_social = $entrada->proveedor;
                $banco->concepto = 'Compra por Banco';
                $banco->num_documento = $entrada->codigo;
                $banco->importe = $request->total*-1;
                $banco->save();
            }
            
        }
        
        return redirect('mostrarentradas')->with('crearcompra','si se creo');
    }

    public function reporteEntrada()
    {

        $entrada = Entrada::latest('id')->first();
        $articulo= articulo::find($entrada->id_articulo);
        $bien= Bien::find($entrada->id_bien);


        $pdf = PDF::loadView('/Entradas.ReporteEntrada', compact('entrada','articulo','bien'));
        //return $entrada;
        return $pdf->stream('reporte.pdf');
        
    }

    public function BuscarEntrada($id)
    {
        $entrada = Entrada::where('id',$id)->get();
        return $entrada;
       
    }

    public function UpdateDatosEntrada(Request $request)
    {
        $entrada = Entrada::find($request->id);
        Entrada::where('identificador', $entrada->identificador)
        ->update(array('num_factura' => $request->num_factura, 'nit_proveedor' => $request->nit_proveedor, 'proveedor' => $request->proveedor, 'id_proveedor' => $request->id_proveedor  ));
        return redirect(url('entradadetallada/'.$entrada->identificador))->with('editdatos', 'si');
    }


    public function UpdateEntrada(Request $request)
    {
        $entrada = Entrada::find($request->id);
        $peps = peps::find($request->id);
        $saa = $peps->cantidad * $peps->costo;
        Entrada::find($request->id)->update($request->all());
        $articulo = articulo::find($entrada->id_articulo);
        $articulo->p_unitario = $request->p_unitario;
        $peps->cantidad = $request->cantidad;
        $articulo->cantidad -= ($entrada->cantidad-$request->cantidad);
        if ($entrada->csfactura) {
            $articulo->costo = ($request->p_unitario)*0.87;
            $peps->costo = $articulo->costo;
        }
        else {
            $articulo->costo = $request->p_unitario;
            $peps->costo = $articulo->costo;
        }
        $sa = $articulo->costo * $request->cantidad;
        $articulo->saldo_articulo = $articulo->saldo_articulo + ($sa-$saa); 
        $total = $entrada->total-$request->total;
        if ($entrada->cscredito == 0) {
            $caja = Caja::where('num_documento',$entrada->codigo)->first();
            $caja->importe = $request->total*-1;
            $cajas = Caja::where('id', '>=',$caja->id)->get();
            foreach ($cajas as $ca) {
                $ca->saldo = $ca->saldo + $total;
                $ca->save();
            }
            $caja->save();
        }
        else {
            if ($entrada->cscredito == 1) {
                $credito = Credito::where('codigo', $entrada->codigo)->first();
                $credito->total = $request->total;
                $credito->saldo = $credito->saldo - $total;
                $credito->save(); 
            }
            else {
                $banco = Movimiento_Banco::where('num_documento',$entrada->codigo)->first();
                $banco->importe = $request->total*-1;
                $banco->save(); 
            }
        }
        $entrada = Entrada::find($request->id);
        $entrada->costo_e =  $articulo->costo;
        $entrada->save();
        $articulo->save();
        $peps->save();
        Entrada::where('identificador', $entrada->identificador)->update(array('total' => $request->total )); 

        return redirect(url('entradadetallada/'.$entrada->identificador))->with('success', 'Compra actualizada satisfactoriamente');
    }

    public function EliminarEntrada($id)
    {
        $entrada = Entrada::find($id);
        $peps = peps::find($id);
        if (!($peps->estado)) {
            return redirect(url('entradadetallada/'.$entrada->identificador))->with('noeliminar','no');
        }
        $sql = Entrada::where('identificador', $entrada->identificador)->get();
        if ( $sql->count() > 1 ) {
            $total = $entrada->total-$entrada->p_total;
            $articulo = articulo::find($entrada->id_articulo);
            $articulo->cantidad -= $entrada->cantidad;
            $articulo->saldo_articulo = $articulo->saldo_articulo - ($entrada->costo_e * $entrada->cantidad); 
            $articulo->save();
            if ($entrada->cscredito == 0) {
                $caja = Caja::where('num_documento',$entrada->codigo)->first();
                $caja->importe = $caja->importe + $entrada->p_total;
                $caja->save();
                $cajas = Caja::where('id', '>=',$caja->id)->get();
                foreach ($cajas as $ca) {
                    $ca->saldo = $ca->saldo + $entrada->p_total;
                    $ca->save();
                }
            } else {
                if ($entrada->cscredito == 1) {
                    $credito = Credito::where('codigo', $entrada->codigo)->first();
                    $credito->total = $credito->total-$entrada->p_total;
                    $credito->saldo = $credito->saldo - $entrada->p_total;
                    $credito->save(); 
                }
                else {
                    $banco = Movimiento_Banco::where('num_documento',$entrada->codigo)->first();
                    $banco->importe = $banco->importe + $entrada->p_total;
                    $banco->save();
                }
            }
            
            
            Entrada::where('identificador', $entrada->identificador)->update(array('total' => $total )); 
            Entrada::find($id)->delete();
            peps::find($id)->delete();
            return redirect(url('entradadetallada/'.$entrada->identificador))->with('eliminar','si');
        } else {
            $articulo = articulo::find($entrada->id_articulo);
            $articulo->cantidad -= $entrada->cantidad;
            $articulo->saldo_articulo = $articulo->saldo_articulo - ($entrada->costo_e * $entrada->cantidad); 
            $articulo->save();
            if ($entrada->cscredito == 0) {
                $caja = Caja::where('num_documento',$entrada->codigo)->first();
                $cajas = Caja::where('id', '>=',$caja->id)->get();
                foreach ($cajas as $ca) {
                    $ca->saldo = $ca->saldo + $entrada->total;
                    $ca->save();
                }
                Caja::find($caja->id)->delete();
            }
            else {
                if ($entrada->cscredito == 1) {
                    Credito::where('codigo', $entrada->codigo)->first()->delete();
                }
                else {
                    Movimiento_Banco::where('num_documento',$entrada->codigo)->first()->delete();
                }
            }
            
            Entrada::find($id)->delete();
            peps::find($id)->delete();
            return redirect(url('mostrarentradas'))->with('eliminar','si');
        }
    }

    public function BuscarEntradas($identificador)
    {
        $entrada = Entrada::where('identificador',$identificador)->get();
        return $entrada;
    }


    public function ReporteFechaEntrada(Request $request)
    {
        $fi=$request->fi;
        $ff=$request->ff;
        
        if ($request->tipo == 'todo') {
            $sql=Entrada::whereBetween('fecha',[$fi,$ff])->distinct('identificador')
            ->get();
        } else {
                if ($request->documento == '2') {
                    if ($request->pago == '3') {
                        $sql=Entrada::whereBetween('fecha',[$fi,$ff])
                        ->distinct('identificador')
                        ->get();
                    } else {
                        $sql=Entrada::whereBetween('fecha',[$fi,$ff])
                        ->where('cscredito',$request->pago)
                        ->distinct('identificador')
                        ->get();
                    }
                } else {
                    if ($request->pago == '3') {
                        $sql=Entrada::whereBetween('fecha',[$fi,$ff])
                        ->where('csfactura',$request->documento)
                        ->distinct('identificador')
                        ->get();
                    } else {
                        $sql=Entrada::whereBetween('fecha',[$fi,$ff])
                        ->where('csfactura',$request->documento)
                        ->where('cscredito',$request->pago)
                        ->distinct('identificador')
                        ->get();
                    }
                }
            
        }
        $sql = $sql->sortBy('id')->sortBy('fecha');
        $pdf = PDF::loadView('/Reportes.VerReportesentrada',compact('sql','fi','ff' ));
        return $pdf->setPaper('a4')->stream('reporteentrada.pdf');

        //return view('/Reportes.VerReportes',compact('salida','sql' ));
    }

    public function ReporteFechaEntradaForm()
    {
        return view('/Reportes.ReporteFormEntrada');
    }


    public function ExcelEntrada() 
    {
        return Excel::download(new EntradaExport, 'ReporteCompra.xlsx');
    }

    public function LibroDeCompras(Request $request)
    {
        $fi=$request->fi;
        $ff=$request->ff;
        $entradas = Entrada::whereBetween('fecha',[$fi,$ff])
        ->where('csfactura',true)
        ->distinct('identificador')->get();
        $cantidad = $entradas->count();
        return view('/Entradas.LibroDeCompras',compact('entradas','fi','ff','cantidad'));
        
    }

    public function LibroDeComprasForm()
    {
        return view('/Entradas.LibroDeComprasForm');
    }



    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function show(Entrada $entrada)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function edit(Entrada $entrada)
    {
        Entrada::find($entrada->bien)->update($entrada->cantidad);
        return redirect('mostarentradas')->with('success', 'Inventario actualizado satisfactoriamente');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entrada $entrada)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entrada $entrada)
    {
        //
    }
}
