<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cotizacion</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
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
            line-height: 30px;
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
            <a href="{{url('mostrarcotizaciones')}}" class="config">
              <img src="{{asset('assets/dashboard/images/HC2.png')}}" alt="..." class="img-circle" width="100" height="54">
            </a>
            <div class="car-body" style="text-align: center" >
                <span><b>{{$cotizacion->codigo_coti}}</b></span>
            </div>
            <div class="car-body" style="text-align: right" >
                <p style="line-height: 120%" >Correas y Manguera Hidraulicas <br>
                Km. 3 1/2 Av. villazon #4259 Sacaba <br>
                Telf: 79949061 - 4019942 <br>
                www.hydrautekbolivia.com</p>
            </div>

        </div>
    </header>
    <main><br>
            <h5 style="text-align: center">COTIZACION</h5>
            <table class="table table-striped text-center" style="font-size: 7pt">
                <tr>
                    <th>Cliente</th>
                    <td style="text-align: left"> {{$cotizacion->cliente}} ({{$cotizacion->nit_cliente}})</td>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <td style="text-align: left"> {{date('d-m-Y')}} </td>
                </tr>
                <tr>
                    <th>Cotizacion Valida por</th>
                    <td style="text-align: left"> {{$cotizacion->validez}} Dias </td>
                </tr>
            </table>
        <h4 style="text-align: center">Detalle</h4>
        @if ($cotizacion->detalle == null)
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="text-align:center">
                <tr>
                    <th >ARTICULO</th>
                    <th width=12%>MARCA</th>
                    <th width=8%>CANTIDAD</th>
                    <th width=8%>UNIDAD</th>
                    <th width=10%>P. UNITARIO (Bs)</th>
                    <th width=12%>SUB TOTAL (Bs)</th>
                    
                </tr>
            </thead>
            <tbody style="text-align: center">
                @foreach($sql as $cotizacions)
                <tr class="gradeC">
                    <td>{{$cotizacions->nombre_articulo}}</td>
                    <td>{{$cotizacions->marca}}</td>
                    <td>{{$cotizacions->cantidad}}</td>
                    <td>{{$cotizacions->unidad}}(s)</td>
                    <td>{{$cotizacions->p_venta}}</td>
                    <td>{{$cotizacions->sub_total}}</td>
                </tr>
                @endforeach
                <tr><td colspan="6"><button class='btn btn-light dim'></button> </td></tr>
                <tr>
                    <th style="text-align: right" colspan="5" >TOTAL Bs:</th>
                    <th st>{{$cotizacion->total}} </th>
                </tr>
                <tr>
                    <th style="text-align: right" colspan="5" >Descuento (Bs):</th>
                    <th st>{{$cotizacion->descuento}} </th>
                </tr>
                <tr>
                    <th style="text-align: right" colspan="5" >TOTAL NETO (Bs):</th>
                    <th st>{{$cotizacion->total-$cotizacion->descuento}}</th>
                </tr>
            </tbody>
        </table>
        @else
            <table class="table table-bordered table-hover table-striped table-sm">
                <thead style="text-align:center">
                    <tr>
                        <th>SERVICIO</th>
                        <th width=12%>CANTIDAD</th>
                        <th width=12%>P. VENTA</th>
                        <th width=12%>SUB TOTAL</th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @foreach ($sql2 as $coti)
                        <tr class="gradeC">
                            <td style="text-align: center">{{$coti->detalle}}</td>
                            <td style="text-align: center">{{$coti->cantidad}}</td>
                            <td style="text-align: right">{{number_format($coti->p_venta,2)}}</td>
                            <td style="text-align: right">{{number_format($coti->sub_total,2)}}</td>
                        </tr>
                    @endforeach
                   
                    <tr><td colspan="4"></td></tr>
                    <tr>
                        <th style="text-align: right" colspan="3" >TOTAL Bs:</th>
                        <th style="text-align: right">{{number_format($cotizacion->total,2)}} </th>
                    </tr>
                    <tr>
                        <th style="text-align: right" colspan="3" >Descuento (Bs):</th>
                        <th style="text-align: right">{{number_format($cotizacion->descuento,2)}} </th>
                    </tr>
                    <tr>
                        <th style="text-align: right" colspan="3" >TOTAL NETO (Bs):</th>
                        <th style="text-align: right">{{number_format($cotizacion->total-$cotizacion->descuento,2)}}</th>
                    </tr>
                </tbody>
            </table>
        @endif
        <br><br>
        <table class="table" style="border: hidden">
            <tbody style="border: hidden">
                <tr style="border: hidden">
                    <td style="text-align: center; border: hidden" width=50%><br><br><br>---------------------<br> Recibi conforme</td>
                    <td style="text-align: center; border: hidden" width=50%><br><br><br>----------------------- <br> Entregue conforme</td>
                    
                </tr>
            </tbody>
          </table>
        
    </main>
    <footer>
        <p><strong>HYDRAUCRUZ</strong></p>
    </footer>
</body>
</html>