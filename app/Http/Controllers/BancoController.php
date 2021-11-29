<?php

namespace App\Http\Controllers;

use App\Exports\BancoExport;
use App\Models\Banco;
use App\Models\Movimiento_Banco;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;

class BancoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function ListaBanco()
    {
        $bancos = Banco::all();
        $cantidad = count($bancos);
        return view('/Banco.ListaBancos', compact('bancos', 'cantidad'));
    }

    public function CrearBanco(Request $request)
    {
        $banco = new Banco();
        $banco->nombre_banco = $request->nombre_banco; 
        $banco->propietario = $request->propietario;
        $banco->cuenta = $request->cuenta;
        $banco->saldo_inicial = $request->saldo_inicial;
        $banco->save();

        $ba = Banco::latest('id')->first();
        $mov_banco = New Movimiento_Banco();
        $mov_banco->id_banco = $ba->id;
        $mov_banco->fecha = date('Y-m-d');
        $mov_banco->tipo = 'ENTRADA';
        $mov_banco->razon_social = $request->propietario;
        $mov_banco->concepto = 'Saldo Inicial de banco';
        $mov_banco->num_documento = 'SI-00';
        $mov_banco->importe = $request->saldo_inicial;
        $mov_banco->save();
        return redirect('mostrarbancos')->with('crearbanco', 'Banco Creado Correctamente');
    }

    public function EncontrarBanco($id)
    {
        $banco = Banco::where('id',$id)->get();
        return $banco;
    }

    
    public function UpdateBanco(Request $request)
    {
        $ba = Banco::find($request->id);
        Banco::find($request->id)->update($request->all());
        if ($ba->saldo_inicial != $request->saldo_inicial) {
            $mb = Movimiento_Banco::where('id_banco',$ba->id)->where('tipo','ENTRADA')->first();
            $mb->importe = $request->saldo_inicial;
            $mb->save();
        }
        return redirect('mostrarbancos')->with('success', 'Banco actualizado Correctamente');
    }
    
    public function EliminarBanco($id)
    {
        Banco::find($id)->delete();
        return redirect('mostrarbancos');
    }

    public function MovimientoBanco($id)
    {
        $ba = Banco::where('id',$id)->first();
        $banco = Movimiento_Banco::where('id_banco',$id)->first();
        $bancos = Movimiento_Banco::where('id_banco',$id)
        ->orderBy('fecha')->orderBy('id')
        ->get();

        return view('/Banco.MovimientoBanco', compact('bancos','banco','ba'));
    }

    public function MovimientoBancoFecha(Request $request)
    {
        $fi = '2021-01-01';
        $ff = date("Y-m-d", strtotime($request->fi.'- 1 days'));
        $banco = Movimiento_Banco::whereBetween('fecha',[$fi,$ff])
        ->where('id_banco',$request->id)
        ->orderby('fecha')->orderBy('id')->get();

        $saldo = 0;
        $fecha = $request->fi;
        foreach ($banco as $ba) {
            $saldo += $ba->importe;
        }

        $banco = Banco::where('id',$request->id)->first();
        $bancos = Movimiento_Banco::whereBetween('fecha',[$request->fi,$request->ff])
        ->where('id_banco',$request->id)
        ->orderBy('fecha')->orderBy('id')
        ->get();

        return view('/Banco.MovimientoBancoFecha', compact('bancos','saldo','banco','fecha'));
    }

    public function PdfBanco($id_banco)
    {
        $ba = Banco::where('id',$id_banco)->first();
        $banco = Movimiento_Banco::where('id_banco',$id_banco)->first();
        $bancos = Movimiento_Banco::where('id_banco',$id_banco)
        ->orderBy('fecha')->orderBy('id')
        ->get();
        $pdf = PDF::loadView('/Banco.PdfBanco', compact('bancos','banco','ba'));
        return $pdf->setPaper('a4')->stream('Banco.pdf');
        
    }

    public function ExcelBanco() 
    {
        return Excel::download(new BancoExport, 'Banco.xlsx');
    }

    public function ReporteFechaBanco(Request $request)
    {
        $ba = Banco::where('id',$request->banco)->first();
        $fi=$request->fi;
        $ff=$request->ff;
        if ($request->tipo == 'todo') {
            $sql=Movimiento_Banco::whereBetween('fecha',[$fi,$ff])
            ->where('id_banco',$request->banco)
            ->orderBy('fecha')->orderBy('id')
            ->get();
        } else {
            if ($request->tipo2 == '1' ) {
                $sql=Movimiento_Banco::whereBetween('fecha',[$fi,$ff])->where('importe','>',0)
                ->where('id_banco',$request->banco)
                ->orderBy('fecha')->orderBy('id')
                ->get();
            } else {
                $sql=Movimiento_Banco::whereBetween('fecha',[$fi,$ff])->where('importe','<',0)
                ->where('id_banco',$request->banco)
                ->orderBy('fecha')->orderBy('id')
                ->get();
            }
        }
        
        $pdf = PDF::loadView('/Reportes.VerReportesBanco',compact('sql','ba' ));
        return $pdf->setPaper('a4')->stream('reporteBanco.pdf');
       

        //return view('/Reportes.VerReportes',compact('salida','sql' ));
    }

    public function ReporteFechaBancoForm()
    {
        $bancos = Banco::all();
        return view('/Reportes.ReporteFormBanco', compact('bancos'));
    }
}
