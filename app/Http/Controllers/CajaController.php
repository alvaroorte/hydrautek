<?php

namespace App\Http\Controllers;

use App\Exports\cajasExport;
use App\Models\Banco;
use App\Models\Caja;
use App\Models\Credito;
use App\Models\Movimiento_Banco;
use App\Models\Salida;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

class CajaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function ListaCaja()
    {
        $cajas = Caja::orderBy('fecha')->orderBy('id')->get();
        return View('/Caja.VerCaja',compact('cajas'));
    }

    public function ListaCajaFecha(Request $request)
    {
        $fi = '2021-01-01';
        $ff = date("Y-m-d", strtotime($request->fi.'- 1 days'));
        $ca = Caja::whereBetween('fecha',[$fi,$ff])->orderby('id','DESC')->get();
        $saldo = 0;
        $fecha = $request->fi;
        foreach ($ca as $caja) {
            $saldo += $caja->importe;
        }
        $cajas = Caja::whereBetween('fecha',[$request->fi,$request->ff])
        ->orderBy('fecha')->orderBy('id')->get();
        
        return View('/Caja.VerCajaFecha',compact('cajas','ca','saldo','fecha'));
    }

    public function CrearCaja(Request $request)
    {
        
        $cajau = Caja::latest('id')->first();
        $caja = New Caja();
        $caja->fecha = $request->fecha;
        $caja->tipo = $request->transaccion;
        $caja->razon_social = $request->razon_social;
        $caja->concepto = $request->concepto;
        if ($request->transaccion == 'EGRESO') {
            $caja->importe = $request->importe*-1;
        }
        else {
            $caja->importe = $request->importe;
        }
        $caja->saldo = $cajau->saldo+$caja->importe;
        $caja->save();
        if ($request->transaccion == 'EGRESO') {
            return redirect('mostrarcaja')->with('egreso','si');
        }
        return redirect('mostrarcaja')->with('ingreso','si');
    }


    public function CrearSaldoIni(Request $request)
    {
        $caja = New Caja();
        $caja->fecha = $request->fecha;
        $caja->tipo = 'ENTRADA';
        $caja->num_documento = 'SI-00';
        $caja->razon_social = $request->razon_social;
        $caja->concepto = 'Saldo inicial de Caja';
        $caja->importe = $request->saldo;
        $caja->saldo = $request->saldo;
        $caja->save();
        return redirect('mostrarcaja');
    }

    public function MostrarForm()
    {
        return View('/Caja.CrearSaldoIni');
    }


    public function PdfCaja()
    {
        $caja = Caja::latest('id')->first();
        $cajas = Caja::orderBy('fecha')->orderBy('id')->get();
        $pdf = PDF::loadView('/Caja.PdfCaja', compact('cajas','caja'));
        return $pdf->setPaper('a4')->stream('Caja.pdf');
        
    }

    public function ExcelCaja() 
    {
        return Excel::download(new cajasExport, 'Caja.xlsx');
    }

    public function ReporteFechaCaja(Request $request)
    {
        $fi=$request->fi;
        $ff=$request->ff;
        if ($request->tipo == 'todo') {
            $sql=Caja::whereBetween('fecha',[$fi,$ff])->orderBy('fecha')->orderBy('id')
            ->get();
        } else {
            if ($request->tipo2 == '1' ) {
                $sql=Caja::whereBetween('fecha',[$fi,$ff])->where('importe','>',0)
                ->orderBy('fecha')->orderBy('id')
                ->get();
            } else {
                $sql=Caja::whereBetween('fecha',[$fi,$ff])->where('importe','<',0)
                ->orderBy('fecha')->orderBy('id')
                ->get();
            }
        }
        
        $pdf = PDF::loadView('/Reportes.VerReportesCaja',compact('sql' ));
        return $pdf->setPaper('a4')->stream('reporteCaja.pdf');
       

        //return view('/Reportes.VerReportes',compact('salida','sql' ));
    }

    public function ReporteFechaCajaForm()
    {
        
        return view('/Reportes.ReporteFormCaja');
    }

    public function ReporteGastos(Request $request)
    {
        $fi=$request->fi;
        $ff=$request->ff;
        $gastosc = Caja::whereBetween('fecha',[$fi,$ff])->where('importe','<',0)->get();
        $gastosb = Movimiento_Banco::whereBetween('fecha',[$fi,$ff])->where('importe','<',0)->get();
        $gastos = $gastosc->concat($gastosb)->sortBy('created_at')->sortBy('fecha');


        return view('/Reportes.VerReportesEntradaMes',compact('gastos','ff'));
    }

    public function ReporteGastosForm()
    {
        return view('/Reportes.ReporteFormEntradaMes');
    }

    public function ReporteFechaSalidaDia(Request $request)
    {
        $fi=$request->fi;
        $ff=$request->ff;
        //$ff = date("Y-m-d", strtotime($request->fi.'- 1 days'));
        $ventas = Salida::whereBetween('fecha',[$fi,$ff])->distinct('fecha') ->get();
        foreach ($ventas as $venta) {
            $saldo = 0;
            $salidas = Salida::where('fecha',$venta->fecha)->where('estado',true)->distinct('identificador')->get();
            foreach ($salidas as $salida) {
                $saldo += $salida->total-$salida->descuento;
            }
            $venta->total = $saldo;
        }
        $ingresosc = Caja::whereBetween('fecha',[$fi,$ff])->where('importe','>',0)
        ->where('concepto', '!=','Venta al Contado')->get();
        $ingresosb = Movimiento_Banco::whereBetween('fecha',[$fi,$ff])->where('importe','>',0)
        ->where('concepto', '!=','Venta')->get();
        $ingresos = $ingresosc->concat($ingresosb)->sortBy('created_at')->sortBy('fecha');
        
        
        return view('/Reportes.VerReportesSalidaDia',compact('ventas','fi','ff','ingresos'));
    }

    public function ReporteFechaSalidaDiaForm()
    {
        return view('/Reportes.ReporteFormSalidaDia');
    }

    public function ReporteFechaCuentasPagar(Request $request)
    {
        $fi=$request->fi;
        $ff=$request->ff;

        $creditos = Credito::join("proveedors","proveedors.id","=","creditos.id_proveedor")
            ->where('creditos.tipo', 'compra' )->where('saldo','>',0)
            ->select("proveedors.*","creditos.*")
            ->get();
        $pagar = $creditos->sum('saldo');
        return view('/Reportes.VerReportesCuentasPagar',compact('pagar', 'creditos', 'ff'));
    }

    public function ReporteFechaCuentasPagarForm()
    {
        return view('/Reportes.ReporteFormCuentasPagar');
    }

    public function ReporteFechaCuentasCobrar(Request $request)
    {
        $fi=$request->fi;
        $ff=$request->ff;

        $creditos = Credito::join("clientes","clientes.id","=","creditos.id_cliente")
        ->where('creditos.tipo', 'venta' )->where('creditos.saldo','>',0)
        ->select("clientes.nombre",DB::raw('sum(creditos.saldo) as tsaldo'))
        ->groupBy('clientes.id')
        ->get();

        $pagar = $creditos->sum('saldo');
        return view('/Reportes.VerReportesCuentasCobrar',compact('pagar', 'creditos', 'ff'));
    }

    public function ReporteFechaCuentasCobrarForm()
    {
        return view('/Reportes.ReporteFormCuentasCobrar');
    }

    public function ReporteGeneralSaldos(Request $request)
    {
        $fi=$request->fi;
        $ff=$request->ff;
        $fii = Caja::select('fecha')->orderBy('id')->first();

        $ventas = Salida::whereBetween('fecha',[$fi,$ff])->where('estado',true)->distinct('fecha')->get();
        foreach ($ventas as $venta) {
            $saldo = 0;
            $salidas = Salida::where('fecha',$venta->fecha)->where('estado',true)->distinct('identificador')->get();
            foreach ($salidas as $salida) {
                $saldo += $salida->total-$salida->descuento;
            }
            $venta->total = $saldo;
        }
        $tv = $ventas->sum('total');
        $ingresosc = Caja::whereBetween('fecha',[$fi,$ff])->where('importe','>',0)
        ->where('concepto', '!=','Venta al Contado')->get();
        $ingresosb = Movimiento_Banco::whereBetween('fecha',[$fi,$ff])->where('importe','>',0)
        ->where('concepto', '!=','Venta')->get();
        $ingresos = $ingresosc->concat($ingresosb)->sortBy('created_at')->sortBy('fecha');
        $ti = $ingresos->sum('importe');
        $ventas = $tv+$ti;
        
        $gastosc = Caja::whereBetween('fecha',[$fi,$ff])->where('importe','<',0)->get();
        $gastosb = Movimiento_Banco::whereBetween('fecha',[$fi,$ff])->where('importe','<',0)->get();
        $gastos = $gastosc->concat($gastosb)->sortBy('created_at')->sortBy('fecha');
        $gastos = $gastos->sum('importe');

        $efectivo = Caja::select('saldo')->latest('id')->first();
        $bancos = Banco::all();
        foreach ($bancos as $banco) {
            $banco->saldo_inicial = Movimiento_Banco::where('id_banco',$banco->id)->get()->sum('importe');
        }
        $tb = $bancos->sum('saldo_inicial');
        $pdf = PDF::loadView('/Reportes.VerReporteSaldos', compact('fii','tb','ventas','gastos','efectivo','bancos','fi','ff'));
        return $pdf->setPaper('a4')->stream('ReporteSaldos.pdf');
        
    }

    public function ReporteGeneralSaldosForm()
    {
        return view('/Reportes.ReporteFormSaldos');
    }

    public function edit(Caja $caja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caja $caja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caja $caja)
    {
        //
    }
}
