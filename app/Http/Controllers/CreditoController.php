<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Cliente;
use App\Models\Credito;
use App\Models\Entrada;
use App\Models\Pago;
use App\Models\Proveedor;
use App\Models\Salida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CreditoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ListaCredito($tipo)
    {   
        $credito = new Credito();
        if ($tipo == 'venta') {
            $credito = Credito::join("clientes","clientes.id","=","creditos.id_cliente")
            ->where('creditos.tipo', 'venta' )
            ->select("clientes.*","creditos.*")
            ->get();
            $tipo = "Venta";
        } else {
            $credito = Credito::join("proveedors","proveedors.id","=","creditos.id_proveedor")
            ->where('creditos.tipo', 'compra' )
            ->select("proveedors.*","creditos.*")
            ->get();
            $tipo = "Compra";
        }
        
        $cantidad = $credito->count(); 
        return view('/Creditos.ListaCreditos',compact('credito', 'cantidad', 'tipo'));
    }



    public function CreditoDetalladoEntrada($id,$tipo)
    {
        $bancos = Banco::all();
        $credito = Credito::where('id', $id)->where('tipo', 'compra')->first();
        $entradas = Entrada::join("biens","entradas.id_bien","=","biens.id")
        ->join("articulos", "entradas.id_articulo","=","articulos.id") 
        ->where('entradas.identificador', '=', $credito->identificador)
        ->select("articulos.nombre as nombre_articulo","articulos.marca","articulos.unidad","biens.nombre as nombre_bien","entradas.*")
        ->orderBy('entradas.id','desc')
        ->get();
        $proveedor = Proveedor::where('id',$credito->id_proveedor)->first();
        $ti = 'pra';
        
        $sql2 = Pago::join("creditos","creditos.id","=","pagos.id_credito")
        ->where('pagos.id_credito', '=', $credito->id)
        ->where('pagos.tipo','compra')
        ->select("pagos.*")
        ->get();
        return view('/Creditos.CreditoDetalladoEntrada',compact('tipo','credito','sql2','entradas','bancos','proveedor' ));
        
    }
    public function CreditoDetalladoSalida($id,$tipo)
    {
        $bancos = Banco::all();
        $credito = Credito::where('id', $id)->where('tipo', 'venta')->first();
        $salida = Salida::where('identificador',$credito->identificador)->first();
        $salidas = Salida::join("biens","salidas.id_bien","=","biens.id")
        ->join("articulos", "salidas.id_articulo","=","articulos.id")
        ->where('salidas.identificador', '=', $credito->identificador)
        ->select("articulos.nombre as nombre_articulo","articulos.marca","articulos.cantidad","biens.nombre as nombre_bien","salidas.*",)
        ->orderBy('salidas.fecha','Desc')
        ->get();
        $cliente = cliente::where('id',$credito->id_cliente)->first();
        $ti = 'ta';
        
        $sql2 = Pago::join("creditos","creditos.id","=","pagos.id_credito")
        ->where('pagos.id_credito', '=', $credito->id)
        ->where('pagos.tipo','venta')
        ->select("pagos.*")
        ->get();
        return view('/Creditos.CreditoDetalladoSalida',compact('tipo','credito','sql2','salidas','salida','bancos','cliente' ));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CrearCredito(Request $request)
    {
        $credito = new Credito();
        if ($request->tipo == 'Compra') {
            $credito->tipo = 'compra';
            $credito->codigo = 'SI-'.$request->nit_proveedor;
        } else {
            $credito->tipo = 'venta';
            $credito->codigo = 'SI-'.$request->nit_cliente;
        }
        $credito->fecha = $request->fecha ;
        $credito->identificador = $request->identificador ;
        $credito->plazo = $request->plazo ;
        $credito->id_cliente = $request->id_cliente ;
        $credito->id_proveedor = $request->id_proveedor ;
        $credito->total = $request->total ;
        $credito->saldo = $request->total ;
        $credito->estado = true ;
        $credito->save();
        
        return redirect(url('mostrarcreditos/'.$credito->tipo))->with('editdatos', 'si');
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
     * @param  \App\Models\Credito  $credito
     * @return \Illuminate\Http\Response
     */
    public function show(Credito $credito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Credito  $credito
     * @return \Illuminate\Http\Response
     */
    public function edit(Credito $credito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Credito  $credito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Credito $credito)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Credito  $credito
     * @return \Illuminate\Http\Response
     */
    public function destroy(Credito $credito)
    {
        //
    }
}
