<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Credito;
use App\Models\Entrada;
use App\Models\Movimiento_Banco;
use App\Models\Pago;
use App\Models\Proveedor;
use App\Models\Reserva;
use App\Models\Salida;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Date;

class PagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function VerPagos(Request $request)
    {
        $pago=new Pago();
        $pago->nombre = $request->nombre;
        $pago->ci = $request->ci;
        $pago->monto = $request->monto;
        $pago->id_credito = $request->idcredito;

        $pago->save();
        return redirect('creditodetallado/'.$request->identificador.'/'.$request->tipo);
    }

    public function CrearPago(Request $request)
    {
        //
        $credito = Credito::where('id', '=', $request->id_credito)->where('tipo', '=', $request->tipo)->first();
        $pago=new Pago();
        $pago->nombre = $request->nombre;
        $pago->ci = $request->ci;
        $pago->monto = $request->monto;
        $pago->id_credito = $request->id_credito;
        $pago->fecha = $request->fecha;
        $pago->tipo = $request->tipo;
        $pago->id_banco = $request->id_banco;
        $pago->save();

        if ($pago->tipo != "reserva") {
        
            $credito->saldo = round(($credito->saldo-$request->monto),2);
            if ($credito->saldo <= 0) {
                $credito->estado = false;
            }
            $credito->save();
            $ucaja = Caja::latest('id')->first();
            if ($credito->tipo == "venta") {
                $salida = Salida::where('identificador',$credito->identificador)->first();
                $cliente = Cliente::find($credito->id_cliente);
                if ($request->tipo_pago == 0 ) {
                    $caja = New Caja();
                    $caja->fecha = $request->fecha;
                    $caja->tipo = 'COBRO';
                    $caja->razon_social = $request->nombre;
                    if ($credito->estado) {
                        $caja->concepto = 'Cobro Parcial';
                    }
                    else {
                        $caja->concepto = 'Cobro Total';
                    }
                    $caja->num_documento = $credito->codigo;
                    $caja->importe = $request->monto;
                    $caja->saldo = $ucaja->saldo+$request->monto;
                    $caja->save();
                } else {
                    $banco = New Movimiento_Banco();
                    $banco->id_banco = $request->id_banco;
                    $banco->fecha = $request->fecha;
                    $banco->tipo = 'COBRO';
                    $banco->razon_social = $request->nombre;
                    if ($credito->estado) {
                        $banco->concepto = 'Cobro Parcial';
                    }
                    else {
                        $banco->concepto = 'Cobro Total';
                    }
                    $banco->num_documento = $credito->codigo;
                    $banco->importe = $request->monto;
                    $banco->save();
                }
                $cliente = Cliente::find($credito->id_cliente);
                $pdf = PDF::loadView('/Creditos.ReportePago', compact('salida','credito','pago','cliente'));
                return $pdf->setPaper('a4')->stream('reportepago.pdf');

            } else {
                $entrada = Entrada::where('identificador',$credito->identificador)->first();
                if ($request->tipo_pago == 0 ) {
                    $caja = New Caja();
                    $caja->fecha = $request->fecha;
                    $caja->tipo = 'PAGO';
                    $caja->razon_social = $request->nombre;
                    if ($credito->estado) {
                        $caja->concepto = 'Pago Parcial';
                    }
                    else {
                        $caja->concepto = 'Pago Total';
                    }
                    $caja->num_documento = $credito->codigo;
                    $caja->importe = ($request->monto)*-1;
                    $caja->saldo = $ucaja->saldo-$request->monto;
                    $caja->save();
                } else {
                    $banco = New Movimiento_Banco();
                    $banco->id_banco = $request->id_banco;
                    $banco->fecha = $request->fecha;
                    $banco->tipo = 'PAGO';
                    $banco->razon_social = $request->nombre;
                    if ($credito->estado) {
                        $banco->concepto = 'Pago Parcial';
                    }
                    else {
                        $banco->concepto = 'Pago Total';
                    }
                    $banco->num_documento = $credito->codigo;
                    $banco->importe = $request->monto * -1;
                    $banco->save();
                }
                return redirect('creditodetalladoe/'.$credito->id.'/'.$request->tipo);
            }
        }
        $reserva = Reserva::where('identificador',$request->identificador)->first();
        $saldo = $reserva->saldo - $pago->monto;
        if ($saldo <= 0) {
            Reserva::where('identificador', $reserva->identificador)->update(array('saldo' => $saldo, 'estado' => false));
        }
        else {
            Reserva::where('identificador', $reserva->identificador)->update(array('saldo' => $saldo));
        }
        $reserva = Reserva::where('identificador',$request->identificador)->first();
        $pdf = PDF::loadView('/Reservas.ReportePago', compact('reserva','credito','pago'));
        return $pdf->setPaper('a4')->stream('reportepago.pdf');
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function show(Pago $pago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function edit(Pago $pago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pago $pago)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pago $pago)
    {
        //
    }
}
