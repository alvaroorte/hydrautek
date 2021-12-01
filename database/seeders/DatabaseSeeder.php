<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoloSeeder::class);

        $user = User::create([
            'name' => 'Darwin Fernandez',
            'email' => 'darwin@gmail.com',
            'password' => bcrypt('hydraucruz')
        ])->assignRole('Admin');

        $user1 = User::create([
            'name' => 'Neida',
            'email' => 'neida@gmail.com',
            'password' => bcrypt('N3id4')
        ])->assignRole('Admin');


        $articulos = [
            ['id' => '0','nombre' => 's', 'id_bien' => '0','unidad' => 'pieza','marca' => '-']

        ];
        foreach ($articulos as $articulo) {
            \App\Models\articulo::create($articulo);
        }

        $clientes = [
            ['id' => '0','nombre' => ' ', 'ci' => '0','codigo_cli' => '0','celular' => '0']

        ];
        foreach ($clientes as $cliente) {
            \App\Models\Cliente::create($cliente);
        }

        $proveedor = [
            ['id' => '0','nombre' => ' ', 'nit' => '0','codigo_prov' => '0','celular' => '0']

        ];
        foreach ($proveedor as $proveedors) {
            \App\Models\Proveedor::create($proveedors);
        }


        $salida = [
            ['id' => '0','fecha' => '2009-06-30 00:00:00', 'detalle' => 'Saldo Inicial','id_bien' => '0','num_venta' => '0','codigo_venta' => '0', 'id_articulo' => '0','scfactura' => '1','sccredito' => '1','total' => '0','p_venta' => '0','sub_total' => '1', 'codigo_cli' => '0', 'cantidad' => '0', 'nit_cliente' => '0','cliente' => 'aaaa', 'identificador' => '0', 'costo_s' => '0']

        ];
        foreach ($salida as $salidas) {
            \App\Models\Salida::create($salidas);
        }

        $cotizacion = [
            ['id' => '0','fecha' => '2009-06-30 00:00:00', 'id_bien' => '1', 'num_coti' => '0', 'id_articulo' => '0', 'sub_total' => '1','p_venta' => '0', 'codigo_coti' => '0', 'cantidad' => '0','descuento' => '0', 'nit_cliente' => '0','validez' => '0', 'identificador' => '0', 'total' => '0']

        ];
        foreach ($cotizacion as $cotizacions) {
            \App\Models\Cotizacion::create($cotizacions);
        }

        $reserva = [
            ['id' => '0','fecha' => '2009-06-30 00:00:00', 'plazo' => '0','id_bien' => '1', 'num_reserva' => '0', 'id_articulo' => '0', 'sub_total' => '1','p_venta' => '0', 'codigo_reserva' => '0', 'cantidad' => '0','descuento' => '0', 'nit_cliente' => '0', 'identificador' => '0', 'total' => '0', 'saldo' => '0', 'estado' => false]

        ];
        foreach ($reserva as $reservas) {
            \App\Models\Reserva::create($reservas);
        }

        $entrada = [
            ['id' => '0','num_entrada' => '0','fecha' => '1992-05-30 00:00:00', 'detalle' => 'Saldo Inicial','id_bien' => '0', 'id_articulo' => '0','cantidad' => '0','p_unitario' => '0','p_total' => '0','total' => '0','proveedor' => 'prueba','nit_proveedor' => '123','csfactura' => '0','cscredito' => '1','codigo' => '0','identificador' => '0', 'costo_e' => '0']

        ];
        foreach ($entrada as $entradas) {
            \App\Models\Entrada::create($entradas);
        }
    }
}
