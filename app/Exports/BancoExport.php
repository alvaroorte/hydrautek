<?php

namespace App\Exports;

use App\Models\Movimiento_Banco;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;


class BancoExport implements FromView
{
    public function view(): View
    {
        return view('/Banco.BancoExcel', [
            'bancos' => Movimiento_Banco::orderBy('fecha')->orderBy('id'),
            'banco' => Movimiento_Banco::latest()->first()
        ]);
    }
}

