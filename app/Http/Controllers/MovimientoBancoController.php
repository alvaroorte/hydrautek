<?php

namespace App\Http\Controllers;

use App\Models\Movimiento_Banco;
use Illuminate\Http\Request;

class MovimientoBancoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function CrearMovimientoBanco(Request $request)
    {

        $mov_banco = New Movimiento_Banco();
        $mov_banco->id_banco = $request->id;
        $mov_banco->fecha = $request->fecha;
        $mov_banco->tipo = $request->transaccion;
        $mov_banco->razon_social = $request->razon_social;
        $mov_banco->concepto = $request->concepto;
        $mov_banco->importe = $request->saldo_inicial;
        if ($request->transaccion == 'EGRESO') {
            $mov_banco->importe = $request->importe*-1;
        }
        else {
            $mov_banco->importe = $request->importe;
        }
        $mov_banco->save();
        if ($request->transaccion == 'EGRESO') {
            return redirect('movimientobanco/'.$request->id)->with('egreso','si');
        }
        return redirect('movimientobanco/'.$request->id)->with('ingreso','si');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movimiento_Banco  $movimiento_Banco
     * @return \Illuminate\Http\Response
     */
    public function show(Movimiento_Banco $movimiento_Banco)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movimiento_Banco  $movimiento_Banco
     * @return \Illuminate\Http\Response
     */
    public function edit(Movimiento_Banco $movimiento_Banco)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movimiento_Banco  $movimiento_Banco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movimiento_Banco $movimiento_Banco)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movimiento_Banco  $movimiento_Banco
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movimiento_Banco $movimiento_Banco)
    {
        //
    }
}
