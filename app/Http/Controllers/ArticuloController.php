<?php

namespace App\Http\Controllers;

use App\Models\articulo;
use App\Models\Bien;
use App\Models\peps;
use App\Models\Salida;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function ListaArticulo($id)
    {

        $sql=articulo::join("biens","articulos.id_bien","=","biens.id")
        ->where('articulos.id_bien', '=', $id) 
        ->select("biens.nombre as nombre_bien","biens.id","articulos.*")
        ->orderBy('id_bien')
        ->get();
        $dato=Bien::find($id);
        $cantidad=articulo::where('articulos.id_bien', '=', $id)->count();
        return view('/Articulo.ListaArticulos',compact('cantidad','sql','dato'));
    }

    public function ArticulosMenoresAForm()
    {
        return view('/Articulo.ArticulosMenoresAForm');
    }

    public function ArticulosMenoresA(Request $request)
    {
        $articulos = articulo::where('cantidad','<=', $request->cantidad)->get();
        $cantidad = $request->cantidad;
        $cantidadarti = $articulos->count();
        return view('/Articulo.ArticulosMenoresA',compact('cantidad','cantidadarti','articulos'));
    }

    
    public function crearArticulo(Request $request)
    {
        $articulo=new articulo();
        $articulo->id_bien=$request->id_bien;
        $articulo->codigo_empresa=$request->codigo_empresa;
        $articulo->codigo_barra=$request->codigo_barra;
        $articulo->codigo=$request->codigo;
        $articulo->nombre=$request->nombre;
        $articulo->ubicacion=$request->ubicacion;
        $articulo->marca=$request->marca;
        $articulo->unidad=$request->unidad;
        $articulo->reservado = 0;
        $articulo->saldo_articulo = 0;
        if (articulo::where('nombre', '=', $articulo->nombre)->exists()) {
            if (articulo::where('marca', '=', $articulo->marca)->exists()) {
                    return redirect(url('mostrararticulos/'.$articulo->id_bien))->with('message','El articulo ya existe'); 
            }
        }
        if ($articulo->codigo_empresa != null) {
            if (articulo::where('codigo_empresa', $articulo->codigo_empresa)->exists()) {
                return redirect(url('mostrararticulos/'.$articulo->id_bien))->with('yaexiste','El Codigo de Empresa ya existe'); 
            }
        }
        if ($articulo->codigo != null) {
            if (articulo::where('codigo', $articulo->codigo)->exists()) {
                return redirect(url('mostrararticulos/'.$articulo->id_bien))->with('yaexistec','El Codigo de Empresa ya existe'); 
            }
        }
        
        $articulo->save();
        return redirect(url('mostrararticulos/'.$articulo->id_bien))->with('articulo','El articulo se creo correctamente');
         
    }

    public function editarArticulo($id)
    {
        $articulo = articulo::where('id',$id)->get();
        return $articulo;
    }

    public function updateArticulo(Request $request)
    {
        $articulo = articulo::find($request->id);
        
        if ($request->codigo_empresa != null) {
            $c = articulo::where('codigo_empresa', $request->codigo_empresa)->where('id','!=',$articulo->id)->get()->count();
            if ($c > 0) {
                return redirect(url('mostrararticulos/'.$articulo->id_bien))->with('yaexiste','El Codigo de Empresa ya existe'); 
            }
        }
        if ($request->codigo != null) {
            $c = articulo::where('codigo', $request->codigo)->where('id','!=',$articulo->id)->get()->count();
            if ($c > 0) {
                return redirect(url('mostrararticulos/'.$articulo->id_bien))->with('yaexistec','El Codigo de Empresa ya existe'); 
            }
        }
        $articulo->nombre = $request->nombre;
        $articulo->marca = $request->marca;
        $articulo->ubicacion = $request->ubicacion;
        $articulo->unidad = $request->unidad;
        $articulo->codigo_empresa = $request->codigo_empresa;
        $articulo->codigo = $request->codigo;
        $articulo->costo = $request->costo;
        $peps = peps::where('id_articulo',$articulo->id)->Where('cantidad','>',0)
                ->orderBy('id','Desc')
                ->first();
        if ($peps != null) {
            $peps->costo = $articulo->costo;
            $peps->save();
        }
        $articulo->p_venta = $request->p_venta;
        $articulo->p_ventapm = $request->p_ventapm;
        $articulo->save();
        return redirect(url('mostrararticulos/'.$articulo->id_bien))->with('guardado', 'Articulo   actualizado satisfactoriamente');
    }

    public function EncontrarArticulos($id)
    {
        $articulo=articulo::where("id_bien",$id)->get();
        return $articulo;
    }
    public function EncontrarArticulo($id)
    {
        $articulo=articulo::where("id",$id)->get();
        return $articulo;
    }
    public function EncontrarArticuloBarra($codigo)
    {
        $articulo=articulo::where("codigo_barra",$codigo)->get();
        return $articulo;
    }
    public function EncontrarArticuloEmpresa($codigo)
    {
        $articulo=articulo::where("codigo_empresa",$codigo)->get();
        return $articulo;
    }
    public function EncontrarArticuloEmpresa2($codigo,$codigo2)
    {
        $codigo = $codigo.'/'.$codigo2;
        $articulo=articulo::where("codigo_empresa",$codigo)->get();
        return $articulo;
    }

    public function EncontrarArticuloFabrica($codigo)
    {
        $articulo=articulo::where("codigo",$codigo)->get();
        return $articulo;
    }

    public function EncontrarArticuloFabrica2($codigo,$codigo2)
    {
        $codigo = $codigo.'/'.$codigo2;
        $articulo=articulo::where("codigo",$codigo)->get();
        return $articulo;
    }

    public function EncontrarArticuloNombre($nombre)
    {
        $articulo=articulo::where('nombre','LIKE',"%".$nombre."%")->get();
        return $articulo;
    }

    public function EncontrarArticuloNombre2($nombre,$nombre2)
    {
        $nombre = $nombre.'/'.$nombre2;
        $articulo=articulo::where('nombre','LIKE',"%".$nombre."%")->get();
        return $articulo;
    }


    public function KardexArticuloProducto($id)
    {
        $articulo = articulo::find($id);
        $bien = Bien::find($articulo->id_bien);
        $sqle=articulo::join("entradas","articulos.id","=","entradas.id_articulo")
        ->where('entradas.id_articulo',$id )->where('entradas.id','!=',0) 
        ->orderBy('fecha','Asc')
        ->select("entradas.cantidad as cantidad_e","entradas.*") 
        ->get();
        $sqls=articulo::join("salidas","articulos.id","=","salidas.id_articulo")
        ->where('salidas.id_articulo',$id )->where('salidas.id','!=',0)->where('salidas.estado',true) 
        ->orderBy('fecha','Asc')
        ->select("salidas.cantidad as cantidad_s","salidas.*",) 
        ->get();
        $sql = $sqle->concat($sqls)->sortBy('created_at')->sortBy('fecha');
        $saldoi = null;
        $cantidad = null;
        $fecha = null;
        
        return view('/Articulo.InventarioFisicoProducto',compact('fecha','saldoi','cantidad','articulo','bien','sql'));
    }
    public function KardexArticuloFecha(Request $request)
    {
        $fi = '2021-01-01';
        $ff = date("Y-m-d", strtotime($request->fi.'- 1 days'));
        $articulo = articulo::find($request->id);
        $bien = Bien::find($articulo->id_bien);


        $sqle=articulo::join("entradas","articulos.id","=","entradas.id_articulo")
        ->where('entradas.id_articulo',$request->id )->whereBetween('fecha',[$fi,$ff]) 
        ->orderBy('fecha','Asc')
        ->select("entradas.cantidad as cantidad_e","entradas.*") 
        ->get();
        $sqls=articulo::join("salidas","articulos.id","=","salidas.id_articulo")
        ->where('salidas.id_articulo',$request->id )->whereBetween('fecha',[$fi,$ff])->where('salidas.estado',true) 
        ->orderBy('fecha','Asc')
        ->select("salidas.cantidad as cantidad_s","salidas.*",) 
        ->get();
        $sql = $sqle->concat($sqls)->sortBy('created_at')->sortBy('fecha');
        
        $saldoi = 0;
        $cantidad = 0;
        $fecha = $request->fi;
        foreach ($sql as $articulos) {
            $cantidad += $articulos->cantidad_e - $articulos->cantidad_s;
            $saldoi += ($articulos->costo_s * -1) + ($articulos->costo_e * $articulos->cantidad_e);
        }
        
        
        $sqle = articulo::join("entradas","articulos.id","=","entradas.id_articulo")
        ->where('articulos.id',$request->id )->whereBetween('fecha',[$request->fi,$request->ff]) 
        ->orderBy('fecha')
        ->select("entradas.cantidad as cantidad_e","entradas.*") 
        ->get();
        $sqls = articulo::join("salidas","articulos.id","=","salidas.id_articulo")
        ->where('articulos.id',$request->id )->whereBetween('fecha',[$request->fi,$request->ff])->where('salidas.estado',true)
        ->orderBy('fecha')
        ->select("salidas.cantidad as cantidad_s","salidas.*",) 
        ->get();
        $sql = $sqle->concat($sqls)->sortBy('created_at')->sortBy('fecha');
        
        return view('/Articulo.InventarioFisicoProducto',compact('fecha','saldoi','cantidad','articulo','bien','sql'));
    }


    public function KardexArticuloProductosf($id)
    {
        $articulo = articulo::find($id);
        $bien = Bien::find($articulo->id_bien);
        $sqle=articulo::join("entradas","articulos.id","=","entradas.id_articulo")
        ->where('entradas.id_articulo',$id )->where('entradas.id','!=',0) 
        ->orderBy('fecha','Asc')
        ->select("entradas.cantidad as cantidad_e","entradas.*") 
        ->get();
        $sqls=articulo::join("salidas","articulos.id","=","salidas.id_articulo")
        ->where('salidas.id_articulo',$id )->where('salidas.id','!=',0)
        ->where('salidas.scfactura',true)->where('salidas.estado',true)
        ->orderBy('fecha','Asc')
        ->select("salidas.cantidad as cantidad_s","salidas.*",) 
        ->get();
        $sql = $sqle->concat($sqls)->sortBy('created_at')->sortBy('fecha');
        $saldoi = null;
        $cantidad = null;
        $fecha = null;
        
        return view('/Articulo.InventarioFisicoProductosf',compact('fecha','saldoi','cantidad','articulo','bien','sql'));
    }
    public function KardexArticuloFechasf(Request $request)
    {
        $fi = '2021-01-01';
        $ff = date("Y-m-d", strtotime($request->fi.'- 1 days'));
        $articulo = articulo::find($request->id);
        $bien = Bien::find($articulo->id_bien);


        $sqle=articulo::join("entradas","articulos.id","=","entradas.id_articulo")
        ->where('articulos.id',$request->id )->whereBetween('fecha',[$fi,$ff]) 
        ->orderBy('fecha','Asc')
        ->select("entradas.cantidad as cantidad_e","entradas.*") 
        ->get();
        $sqls=articulo::join("salidas","articulos.id","=","salidas.id_articulo")
        ->where('articulos.id',$request->id )->whereBetween('fecha',[$fi,$ff])->where('salidas.estado',true)
        ->where('salidas.scfactura',true)
        ->orderBy('fecha','Asc')
        ->select("salidas.cantidad as cantidad_s","salidas.*",) 
        ->get();
        $sql = $sqle->concat($sqls)->sortBy('created_at')->sortBy('fecha');
        
        $saldoi = 0;
        $cantidad = 0;
        $fecha = $request->fi;
        foreach ($sql as $articulos) {
            $cantidad += $articulos->cantidad_e - $articulos->cantidad_s;
            $saldoi += ($articulos->costo_s * -1) + ($articulos->costo_e * $articulos->cantidad_e);
        }
        
        
        $sqle = articulo::join("entradas","articulos.id","=","entradas.id_articulo")
        ->where('articulos.id',$request->id )->whereBetween('fecha',[$request->fi,$request->ff]) 
        ->orderBy('fecha')
        ->select("entradas.cantidad as cantidad_e","entradas.*") 
        ->get();
        $sqls = articulo::join("salidas","articulos.id","=","salidas.id_articulo")
        ->where('articulos.id',$request->id )->whereBetween('fecha',[$request->fi,$request->ff]) 
        ->where('salidas.scfactura',true)->where('salidas.estado',true)
        ->orderBy('fecha')
        ->select("salidas.cantidad as cantidad_s","salidas.*",) 
        ->get();
        $sql = $sqle->concat($sqls)->sortBy('created_at')->sortBy('fecha');
        
        return view('/Articulo.InventarioFisicoProductosf',compact('fecha','saldoi','cantidad','articulo','bien','sql'));
    }

    public function ListaInventario()
    {
        $bien=Bien::Paginate(100);
        return view('/Inventario.ListaInventario',compact('bien'));
    }

    public function InventarioDetallado($id)
    {

        $sql=articulo::join("biens","articulos.id_bien","=","biens.id")
        ->where('articulos.id_bien', '=', $id)
        ->select("biens.nombre as nombre_bien","biens.id","articulos.*")
        ->orderBy('id_bien')
        ->get();
        $dato=Bien::find($id);
        $cantidad=articulo::where('articulos.id_bien', '=', $id)->count();
        return view('/Inventario.InventarioDetallado',compact('cantidad','sql','dato'));
    }

    public function ListaInventarioTodo()
    {

        $articulos = articulo::where('id','!=',0)->get();
        $cantidad = $articulos->count()-1;
        $cs = FALSE;
        return view('/Inventario.InventarioTodoDet',compact('cantidad','cs'));
    }

    public function ListaInventarioTodoDatatable()
    {

        $articulos = articulo::where('id','!=',0)->select('id','codigo_empresa','nombre','marca','cantidad','reservado','ubicacion','costo','saldo_articulo','p_venta','p_ventapm')->get();
        return datatables()->of($articulos)->toJson();
    }

    public function ListaInventarioTodoSaldo()
    {

        $articulos=articulo::join("biens","articulos.id_bien","=","biens.id")
        ->where("articulos.cantidad",">",0)
        ->select("biens.nombre as nombre_bien","biens.id","articulos.*")
        ->orderBy('id_bien')
        ->get();
        $cantidad = $articulos->count();
        $cs = TRUE;
        return view('/Inventario.InventarioTodoDet',compact('cantidad','articulos','cs'));
    }

    public function ListaInventarioTodosf()
    {

        $articulos=articulo::join("biens","articulos.id_bien","=","biens.id")
        ->select("biens.nombre as nombre_bien","biens.id","articulos.*")
        ->orderBy('id_bien')
        ->get();

        foreach ($articulos as $arti) {
            $sql = Salida::where('id_articulo',$arti->id)->where('scfactura',false)->get();
            $saldo = 0;
            $cantidad = 0;
            foreach ($sql as $salida) {
                $cantidad += $salida->cantidad;
                $saldo += $salida->costo_s;
            }
            $arti->saldo_articulo += $saldo;
            $arti->cantidad += $cantidad;
        }

        $cantidad = $articulos->count();
        return view('/Inventario.InventarioTodoDetsf',compact('cantidad','articulos'));
    }

    public function ListaInventarioTodoSaldosf()
    {

        $articulos=articulo::join("biens","articulos.id_bien","=","biens.id")
        ->where("articulos.cantidad",">",0)
        ->select("biens.nombre as nombre_bien","biens.id","articulos.*")
        ->orderBy('id_bien')
        ->get();

        foreach ($articulos as $arti) {
            $sql = Salida::where('id_articulo',$arti->id)->where('scfactura',false)->get();
            $saldo = 0;
            $cantidad = 0;
            foreach ($sql as $salida) {
                $cantidad += $salida->cantidad;
                $saldo += $salida->costo_s;
            }
            $arti->saldo_articulo += $saldo;
            $arti->cantidad += $cantidad;
        }

        $cantidad = $articulos->count();
        return view('/Inventario.InventarioTodoDetsf',compact('cantidad','articulos'));
    }

    public function InventarioDetalladoFecha(Request $request)
    {

        $articulos=articulo::join("biens","articulos.id_bien","=","biens.id")
        ->select("biens.nombre as nombre_bien","articulos.*")
        ->orderBy('id_bien')
        ->get();

        $fi = '2021-01-01';
        foreach ($articulos as $arti) 
        {
            $sqle=articulo::join("entradas","articulos.id","=","entradas.id_articulo")
            ->where('entradas.id_articulo',$arti->id )->whereBetween('fecha',[$fi,$request->ff]) 
            ->orderBy('fecha')
            ->select("entradas.cantidad as cantidad_e","entradas.*") 
            ->get();
            $sqls=articulo::join("salidas","articulos.id","=","salidas.id_articulo")
            ->where('salidas.id_articulo',$arti->id )->whereBetween('fecha',[$fi,$request->ff]) 
            ->orderBy('fecha')
            ->select("salidas.cantidad as cantidad_s","salidas.*",) 
            ->get();
            $sql = $sqle->concat($sqls)->sortBy('fecha');
            
            $saldoi = 0;
            $cantidad = 0;
            $costo = 0;
            $fecha = $request->fi;
            //return $sql;
            foreach ($sql as $ar) {
                $cantidad += $ar->cantidad_e - $ar->cantidad_s;
                $saldoi += ($ar->costo_s * -1) + ($ar->costo_e * $ar->cantidad_e);
                if ($ar->costo_e != null) {
                    $costo = $ar->costo_e;
                }    
            }
            $arti->costo = $costo;
            $arti->cantidad = $cantidad;
            $arti->saldo_articulo = $saldoi;
        }

        $cantidad=articulo::all()->count()-1;
        $cs = FALSE;
        return view('/Inventario.InventarioTodoDetFecha',compact('cantidad','articulos','cs'));
    }


    public function InventarioDetalladoFechasf(Request $request)
    {

        $articulos=articulo::join("biens","articulos.id_bien","=","biens.id")
        ->select("biens.nombre as nombre_bien","articulos.*")
        ->orderBy('id_bien')
        ->get();

        $fi = '2021-01-01';
        foreach ($articulos as $arti) 
        {
            $sqle=articulo::join("entradas","articulos.id","=","entradas.id_articulo")
            ->where('entradas.id_articulo',$arti->id )->whereBetween('entradas.fecha',[$fi,$request->ff]) 
            ->orderBy('fecha')
            ->select("entradas.cantidad as cantidad_e","entradas.*") 
            ->get();
            $sqls=articulo::join("salidas","articulos.id","=","salidas.id_articulo")
            ->where('salidas.id_articulo',$arti->id )->whereBetween('salidas.fecha',[$fi,$request->ff]) 
            ->where('salidas.scfactura',true)
            ->orderBy('fecha')
            ->select("salidas.cantidad as cantidad_s","salidas.*",) 
            ->get();
            $sql = $sqle->concat($sqls)->sortBy('fecha');
            
            $saldoi = 0;
            $cantidad = 0;
            $costo = 0;
            $fecha = $request->fi;
            //return $sql;
            foreach ($sql as $ar) {
                $cantidad += $ar->cantidad_e - $ar->cantidad_s;
                $saldoi += ($ar->costo_s * -1) + ($ar->costo_e * $ar->cantidad_e);
                if ($ar->costo_e != null) {
                    $costo = $ar->costo_e;
                }    
            }
            $arti->costo = $costo;
            $arti->cantidad = $cantidad;
            $arti->saldo_articulo = $saldoi;
        }

        $cantidad=articulo::all()->count()-1;
        return view('/Inventario.InventarioTodoDetsf',compact('cantidad','articulos'));
    }




    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function show(articulo $articulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function edit(articulo $articulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, articulo $articulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(articulo $articulo)
    {
        //
    }
}
    
