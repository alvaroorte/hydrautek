<?php

namespace App\Exports;

use App\Models\Caja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;


/*class cajasExport implements FromCollection
{

    public function collection()
    {
        return Caja::all();
    }
}*/

class cajasExport implements FromView
{
    
    public function view(): View
    {
        return view('/Caja.cajaExcel', [
            'cajas' => Caja::orderBy('fecha')->orderBy('id')->get(),
            'caja' => Caja::latest()->first()
        ]);
    }
}
