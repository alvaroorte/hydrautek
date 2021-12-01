
<!DOCTYPE html>

<html lang="en">
  

<head>
    <meta charset="UTF-8">
    <title>REPORTE DE VENTAS</title>
    <link href="{{asset('assets/dashboard/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    
    <style>
        @page {
            margin: 0cm 0cm;
            font-size: 9pt;
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
            line-height: 30px;
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
            <a href="{{url('reportefechacaja')}}" class="config">
              <img src="{{asset('assets/dashboard/images/HC2.png')}}" alt="..." class="img-circle" width="100" height="54">
            </a>
            <div class="car-body" style="text-align: center" >
                <span><b>HYDRAUCRUZ</b></span>
            </div>
        </div>
    </header>
    <main><br>
            <br>
            <h5 style="text-align: center"> REPORTE DE CAJA</h5>
            <br>
        
        <h5 style="text-align: center">(Expresado en Bolivianos)</h5>
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="background:#d33c3c;color:#ffffff;text-align:center">
                <tr>
                    <th>FECHA</th>
                    <th>TRANSACCION</th>
                    <th>RAZON SOCIAL</th>
                    <th>CONCEPTO</th>
                    <th>IMPORTE(Bs.)</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                @foreach($sql as $caja)
                <tr class="gradeC" style="text-align: center;">
                    <td>{{$caja->fecha}}</td>
                    <td>{{$caja->tipo}}</td>
                    <td>{{$caja->razon_social}}</td>
                    <td>{{$caja->concepto}}</td>
                    <td style="text-align: right">{{number_format($caja->importe,2)}}</td>
                </tr>
                <?php $i += $caja->importe; ?>
                @endforeach
                <tr>
                    <td style="text-align: right"colspan="4"><b>TOTAL GENERAL(Bs.)</b></td>
                    <td style="text-align: right">{{number_format($i,2)}}</td>
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













