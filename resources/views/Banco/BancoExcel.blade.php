<table class="table table-bordered table-hover table-striped table-sm">
    
    <thead style="background:#3c46d3;color:#ffffff;text-align:center">
        <tr>
            <td colspan="2"></td>
            <td colspan="3" style="font-size:22pt"><b>HYDRAUCRUZ</b></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="3" style="font-size:18pt">Control de Banco</td>
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
        @foreach($bancos as $banco)
        <tr class="gradeC" style="text-align: center;">
            <td>{{$banco->fecha}}</td>
            <td>{{$banco->num_documento}}</td>
            <td>{{$banco->tipo}}</td>
            <td>{{$banco->razon_social}}</td>
            <td>{{$banco->concepto}}</td>
            <td style="text-align: right">{{$banco->importe}}</td>
            @php $saldo += $banco->importe @endphp
            <td style="text-align: right">{{$saldo}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="6" style="text-align:right "><b>Saldo(Bs.):</b></td>
            <td><b>{{$saldo}}</b></td>
        </tr>
    </tbody>
</table>