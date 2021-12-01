
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
            <a href="{{url('reportefechasalida')}}" class="config">
              <img src="{{asset('assets/dashboard/images/HC2.png')}}" alt="..." class="img-circle" width="100" height="54">
            </a>
            <div class="car-body" style="text-align: center" >
                <span><b>HYDRAUCRUZ</b></span>
            </div>
        </div>
    </header>
    <main><br>
            <h5 style="text-align: center"> VENTAS</h5>
            <br>
        
        <h5 style="text-align: center">(Expresado en Bolivianos)</h5>
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="background:#d33c3c;color:#ffffff;text-align:center">
                <tr>
                    <th width="5%">N°</th>
                    <th width="8%">CODIGO VENTA</th>
                    <th width="10%">FECHA</th>
                    <th>CLIENTE</th>
                    <th width="10%">DOCUMENTO</th>
                    <th width="10%">TIPO DE PAGO</th>
                    <th width="10%">IMPORTE (Bs.)</th>
                    <th width="10%">DESCUENTO (Bs.)</th>
                    <th width="10%">TOTAL (Bs.)</th>

                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                @foreach($sql as $salida)
                <tr class="gradeC" style="text-align: center;">
                    <td>{{$salida->num_venta}}</td>
                    <td>{{$salida->codigo_venta}}</td>
                    <td>{{$salida->fecha}}</td>
                    <td>{{$salida->cliente}} ({{$salida->nit_cliente}})</td>
                    <td style="text-align: center;"> 
                        @if ( $salida->scfactura == 1)
                            Factura 
                        @else
                            Con Remision 
                        @endif  
                    </td>
                    <td style="text-align: center;"> 
                        @if ( $salida->sccredito == 1)
                            Credito
                        @else
                            @if ( $salida->sccredito == 2)
                                Banco
                            @else
                                Efectivo
                            @endif
                        @endif
                    </td>
                    <td style="text-align: right">{{number_format($salida->total,2)}}</td>
                    <td style="text-align: right">{{number_format($salida->descuento,2)}}</td>
                    <td style="text-align: right">{{number_format(($salida->total-$salida->descuento),2)}}</td>
                </tr>
                <?php $i += $salida->total-$salida->descuento; ?>
                @endforeach
                <tr>
                    <td style="text-align: right"colspan="8"><b>TOTAL GENERAL(Bs.)</b></td>
                    <td style="text-align: right"><b>{{number_format($i,2)}}</b></td>
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













