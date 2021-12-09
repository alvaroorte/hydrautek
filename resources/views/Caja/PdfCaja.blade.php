<!DOCTYPE html>

<html lang="en">
  
<head>
    <meta charset="UTF-8">
    <title>REPORTE DE ENTRADA</title>
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
            <a href="{{url('mostrarcaja')}}" class="config">
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
            <h4 style="text-align: center">Control de Caja</h4>
            <br>
            <h5 style="text-align: center"> (Expresado en Bolivianos)</h5>
            <br>
        
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="background:#d33c3c;color:#ffffff;text-align:center">
                <tr>
                    <th>FECHA</th>
                    <th>CODIGO</th>
                    <th>TRANSACCION</th>
                    <th>RAZON SOCIAL</th>
                    <th>CONCEPTO</th>
                    <th>IMPORTE(Bs.)</th>
                    <th>SALDO(Bs.)</th>

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
                    <td style="text-align: right">{{number_format($caja->importe,2)}}</td>
                    @php $saldo += $caja->importe; @endphp
                    <td style="text-align: right">{{number_format($saldo,2)}}</td>
                </tr>
                @endforeach
                <tr>
                    <td style="text-align: right"colspan="6"><b>SALDO(Bs.):</b></td>
                    <td style="text-align: right">{{number_format($saldo,2)}}</td>
                </tr>
            </tbody>
          </table>
        <br>       
    </main>
    <footer>
        <p><strong>HYDRAUCRUZ</strong></p>
    </footer>
</body>
</html>