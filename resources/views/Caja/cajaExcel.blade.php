<table class="table table-bordered table-hover table-striped table-sm">
    
    <thead style="background:#3c46d3;color:#ffffff;text-align:center">
        <tr>
            <td colspan="2"></td>
            <td colspan="3" style="font-size:22pt"><b>HYDRAUCRUZ</b></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="3" style="font-size:18pt">Control de Caja</td>
        </tr>
        <tr></tr>
        <tr>
            <th style="text-align:center; background:#c72419; color:#ffffff">FECHA</th>
            <th style="text-align:center; background:#c72419; color:#ffffff">CODIGO</th>
            <th style="text-align:center; background:#c72419; color:#ffffff">TRANSACCION</th>
            <th style="text-align:center; background:#c72419; color:#ffffff">RAZON SOCIAL</th>
            <th style="text-align:center; background:#c72419; color:#ffffff">CONCEPTO</th>
            <th style="text-align:center; background:#c72419; color:#ffffff">IMPORTE(Bs.)</th>
            <th style="text-align:center; background:#c72419; color:#ffffff">SALDO(Bs.)</th>

        </tr>
    </thead>
    <tbody>
        @php $saldo = 0; @endphp
        @foreach($cajas as $caja)
        <tr class="gradeC" style="text-align: center;">
            <td>{{$caja->fecha}}</td>
            <td>{{$caja->num_documento}}</td>
            <td>{{$caja->tipo}}</td>
            <td>{{$caja->razon_social}}</td>
            <td>{{$caja->concepto}}</td>
            <td style="text-align: right">{{$caja->importe}}</td>
            @php $saldo += $caja->importe; @endphp
            <td style="text-align: right">{{$saldo}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="6" style="text-align:right "><b>Saldo(Bs.):</b></td>
            <td><b>{{$saldo}}</b></td>
        </tr>
    </tbody>
</table>