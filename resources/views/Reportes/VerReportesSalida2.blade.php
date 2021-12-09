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
            height: 1.8cm;
            background-color: #5e5a5a;
            color: rgb(255, 255, 255);
            line-height: 30px;
        }
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1.3cm;
            background-color: #575757;
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
            <div class="car-body" style="text-align: right" >
                <p style="line-height: 120%" >Correas y Manguera Hidraulicas <br>
                Km. 3 1/2 Av. villazon #4259 Sacaba <br>
                Telf: 79949061 - 4019942 <br>
                www.hydrautekbolivia.com</p>
            </div>
        </div>
    </header>
    <main><br>
            <h5 style="text-align: center"> VENTAS</h5>
            <h6 style="text-align: center"> Del {{$fi}} al {{$ff}}</h6>        
        <h6 style="text-align: center">(Expresado en Bolivianos)</h6>
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="text-align:center">
                <tr>
                    <th width="8%">CODIGO VENTA</th>
                    <th width="10%">FECHA</th>
                    <th>CLIENTE</th>
                    <th width="10%">N° DOCUMENTO</th>
                    <th width="5%">ESTADO</th>
                    <th width="10%">CONTADO</th>
                    <th width="10%">CREDITO</th>
                    <th width="10%">BANCOS</th>

                </tr>
            </thead>
            <tbody>
                <?php $e = 0;$c = 0;$b = 0; ?>
                @foreach($sql as $salida)
                <tr class="gradeC" style="text-align: center;">
                    <td>{{$salida->codigo_venta}}</td>
                    <td>{{$salida->fecha}}</td>
                    <td>{{$salida->cliente}}</td>
                    <td>{{$salida->num_factura}}</td>
                    <td>@if ($salida->estado == true)
                            V
                        @else
                            A
                        @endif
                    </td>
                    @if ( $salida->sccredito == 1)
                        <td style="text-align: right;">{{number_format(0,2)}}</td>
                        <td style="text-align: right;">{{number_format(($salida->total-$salida->descuento),2)}}</td>
                        <td style="text-align: right;">{{number_format(0,2)}}</td>
                        <?php $c += $salida->total-$salida->descuento; ?>
                    @else
                        @if ( $salida->sccredito == 2)
                            <td style="text-align: right;">{{number_format(0,2)}}</td>
                            <td style="text-align: right;">{{number_format(0,2)}}</td>
                            <td style="text-align: right;">{{number_format(($salida->total-$salida->descuento),2)}}</td>
                            <?php $b += $salida->total-$salida->descuento; ?>
                        @else
                            <td style="text-align: right;">{{number_format(($salida->total-$salida->descuento),2)}}</td>
                            <td style="text-align: right;">{{number_format(0,2)}}</td>
                            <td style="text-align: right;">{{number_format(0,2)}}</td>
                            <?php $e += $salida->total-$salida->descuento; ?>
                        @endif
                    @endif
                </tr>
                @endforeach
                <tr>
                    <td style="text-align: right"colspan="5"><b>TOTALES(Bs.)</b></td>
                    <td style="text-align: right"><b>{{number_format($e,2)}}</b></td>
                    <td style="text-align: right"><b>{{number_format($c,2)}}</b></td>
                    <td style="text-align: right"><b>{{number_format($b,2)}}</b></td>
                </tr><tr><td colspan="8"></td></tr>
                <tr>
                    <td style="text-align: right" colspan="5"><b>TOTAL GENERAL(Bs.)</b></td>
                    <td style="text-align: right" colspan="3"><b>{{number_format($b+$e+$c,2)}}</b></td>
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













