
<!DOCTYPE html>

<html lang="en">
  

<head>
    <meta charset="UTF-8">
    <title>REPORTE DE BANCO</title>
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
            <a href="{{url('reportefechabanco')}}" class="config">
              <img src="{{asset('assets/dashboard/images/Captura2.png')}}" alt="..." class="img-circle" width="100" height="54">
            </a>
            <div class="car-body" style="text-align: center" >
                <span><b>HYDRAUTEK</b></span>
            </div>
        </div>
      </header>
      <main><br>
              <h4 style="text-align: center">Control de Banco</h4>
              <h4 style="text-align: center">{{$ba->nombre_banco}}</h4>
              <br>
              <h5 style="text-align: center"> (Expresado en Bolivianos)</h5>
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="background:#d33c3c;color:#ffffff;text-align:center">
                <tr>
                    <th>FECHA</th>
                    <th>CODIGO</th>
                    <th>TRANSACCION</th>
                    <th>RAZON SOCIAL</th>
                    <th>CONCEPTO</th>
                    <th>IMPORTE(Bs.)</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                @foreach($sql as $banco)
                <tr class="gradeC" style="text-align: center;">
                    <td>{{$banco->fecha}}</td>
                    <td>{{$banco->num_documento}}</td>
                    <td>{{$banco->tipo}}</td>
                    <td>{{$banco->razon_social}}</td>
                    <td>{{$banco->concepto}}</td>
                    <td style="text-align: right">{{number_format($banco->importe,2)}}</td>
                </tr>
                <?php $i += $banco->importe; ?>
                @endforeach
                <tr>
                    <td style="text-align: right"colspan="5"><b>TOTAL GENERAL(Bs.)</b></td>
                    <td style="text-align: right">{{number_format($i,2)}}</td>
                </tr>
            </tbody>
          </table>
        <br>       
    </main>
    <footer>
        <p><strong>HYDRAUTEK</strong></p>
    </footer>
</body>
</html>













