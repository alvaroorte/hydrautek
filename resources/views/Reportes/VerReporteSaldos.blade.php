<!DOCTYPE html>

<html lang="en">
  
<head>
    <meta charset="UTF-8">
    <title>REPORTE DE SALDOS</title>
    <link href="{{asset('assets/dashboard/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        .pagenum:before {
            content: counter(page);
        }

    
        @page {
            margin: 0cm 0cm;
            font-size: 10pt;
        }
        body {
            margin: 1cm 1cm 1cm;
        }
        header {
            left: 0cm;
            right: 0cm;
            height: 1.3cm;
            background-color: #d33c3c;
            color: white;
            line-height: 35px;
        }
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1.3cm;
            background-color: #d33c3c;
            color: white;
            text-align: center;
            line-height: 35px;
        }
    </style>
</head>
<body>
    <header>
        <div class="card">
            <a href="{{url('reportegeneralsaldos')}}" class="config">
              <img src="{{asset('assets/dashboard/images/Captura2.png')}}" alt="..." class="img-circle" width="100" height="54">
            </a>
            <div class="car-body" style="text-align: center" >
              <span><b>HYDRAUTEK</b></span>
            </div>
          </div>
    </header>
    <main><br>
            <h4 style="text-align: center">HYDRAUTEK</h4>
            <h5 style="text-align: center"> Arqueo de Caja</h5>
            <br>
        
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="background:#d33c3c;color:#ffffff;text-align:center">
                <tr style="background:#ffffff">
                    <th colspan="2">Del {{\Carbon\Carbon::parse($fi)->format('d-m-Y')}} al {{\Carbon\Carbon::parse($ff)->format('d-m-Y')}} </th>
                </tr>
                <tr>
                    <th width="70%">DESCRIPCION</th>
                    <th>IMPORTE (Bs.)</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>VENTAS - INGRESOS</td>
                    <td style="text-align: right" >{{number_format($ventas,2)}}</td>
                </tr>
                <tr>
                    <td>GASTOS</td>
                    <td style="text-align: right" >{{number_format($gastos*-1,2)}}</td>
                </tr>
                <tr>
                    <td style="text-align: center">Saldo del mes de {{\Carbon\Carbon::parse($ff)->formatLocalized('%B')}}</td>
                    <td style="text-align: right">{{number_format($ventas+$gastos,2)}}</td>
                </tr>
            </tbody>
        </table>
        <br><br><br>
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="background:#945e5e;color:#ffffff;text-align:center">
                <tr>
                    <th width="70%"><b> Saldo a favor de Hydrautek desde {{\Carbon\Carbon::parse($fii->fecha)->format('d-m-Y')}} hasta {{\Carbon\Carbon::parse($ff)->format('d-m-Y')}}</b></th>
                    <th style="text-align: right">{{number_format($tb+$efectivo->saldo,2)}}</th>
                </tr>
            </thead>
          </table><br>
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="background:#d33c3c;color:#ffffff;text-align:center">
                <tr>
                    <th width="15%"></th>
                    <th width="60%" >DESCRIPCION</th>
                    <th>IMPORTE (Bs.)</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Al {{\Carbon\Carbon::parse($ff)->format('d-m-Y')}}</td>
                    <td>EFECTIVO CAJA</td>
                    <td style="text-align: right" >{{number_format($efectivo->saldo,2)}}</td>
                </tr>
                @foreach ($bancos as $banco)
                    <tr>
                        <td>Al {{\Carbon\Carbon::parse($ff)->format('d-m-Y')}}</td>
                        <td>EFECTIVO BANCO {{$banco->nombre_banco}}</td>
                        <td style="text-align: right" >{{number_format($banco->saldo_inicial,2)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td style="text-align: right" colspan="2" >TOTAL:</td>
                    <td style="text-align: right">{{number_format($tb+$efectivo->saldo,2)}}</td>
                </tr>
            </tbody>
          </table><br><br>
          <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="background:#d33c3c;color:#ffffff;text-align:center">
                <tr>
                    <th width="15%"></th>
                    <th width="60%" >DESCRIPCION</th>
                    <th>IMPORTE (Bs.)</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Al {{\Carbon\Carbon::parse($ff)->format('d-m-Y')}}</td>
                    <td>CUENTAS POR COBRAR</td>
                    <td style="text-align: right" >{{number_format($porcobrar,2)}}</td>
                </tr>
                <tr>
                    <td>Al {{\Carbon\Carbon::parse($ff)->format('d-m-Y')}}</td>
                    <td>CUENTAS POR PAGAR</td>
                    <td style="text-align: right" >{{number_format($porpagar,2)}}</td>
                </tr>
            </tbody>
          </table>    
    </main>
    <footer>
        <p><strong>HYDRAUTEK</strong></p>
    </footer>
</body>
</html>