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
            height: 1.8cm;
            line-height: 35px;
        }
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1.3cm;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="card">
            <a href="{{url('reportegeneralsaldos')}}" class="config">
              <img src="{{asset('assets/dashboard/images/HC2.png')}}" alt="..." class="img-circle" width="100" height="54">
            </a>
            <div class="car-body" style="text-align: right" >
                <p style="line-height: 120%" >Correas y Manguera Hidraulicas <br>
                Km. 3 1/2 Av. villazon #4259 Sacaba <br>
                Telf: 79949061 - 4019942 <br>
                www.hydrautekbolivia.com</p>
            </div>
        </div>
    </header>
    <main><br>
            <h5 style="text-align: center"> Arqueo General</h5>
            <br>
        
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="text-align:center">
                <tr style="background:#ffffff;color:#1b1919;text-align:center">
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
            <thead style="text-align:center">
                <tr>
                    <th width="70%"><b> Saldo a favor de Hydraucruz desde {{\Carbon\Carbon::parse($fii->fecha)->format('d-m-Y')}} hasta {{\Carbon\Carbon::parse($ff)->format('d-m-Y')}}</b></th>
                    <th style="text-align: right">{{number_format($tb+$efectivo,2)}}</th>
                </tr>
            </thead>
          </table><br>
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="text-align:center">
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
                    <td style="text-align: right" >{{number_format($efectivo,2)}}</td>
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
                    <td style="text-align: right">{{number_format($tb+$efectivo,2)}}</td>
                </tr>
            </tbody>
          </table><br><br>
          <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="text-align:center">
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
        <p><strong>HYDRAUCRUZ</strong></p>
    </footer>
</body>
</html>