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
            height: 1.3cm;
            background-color: #475161;
            color: white;
            line-height: 30px;
        }
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1.3cm;
            background-color: #475161;
            color: white;
            text-align: center;
            line-height: 35px;
        }
    </style>
</head>
<body>
    <header>
        <div class="card">
            <a href="{{url('mostrarcotizaciones')}}" class="config">
              <img src="{{asset('assets/dashboard/images/Captura2.png')}}" alt="..." class="img-circle" width="100" height="54">
            </a>
            <div class="car-body" style="text-align: center" >
                <span><b>{{$cotizacion->codigo_coti}}</b></span>
            </div>
          </div>
    </header>
    <main><br>
            <h4 style="text-align: center">HYDRAUTEK</h4>
            <br>
            <table class="table table-striped text-center">
            <tr>
                <th width="53%">Modalidad </th>
                @if ($cotizacion->detalle == null)
                <th>Cotizacion de Productos</th>
                @else
                <th>Cotizacion de Servicios</th>  
                @endif
                
            </tr>
            <tr>
                <th>Fecha de impresión</th>
                <td style="text-align: left"> {{date('d-m-Y')}} </td>
            </tr>
            <tr>
                <th>Cotizacion Valida por</th>
                <td style="text-align: left"> {{$cotizacion->validez}} Dias </td>
            </tr>
             
            </table>
        <br>
        
        <h4 style="text-align: center">Detalle</h4>
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="background:#343a40;color:#D0D3D4;text-align:center">
                <tr class="col-auto bg-secondary">
                    <th width=12%>Señor(es)</th>
                    <th width=10%>NIT/CI</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr class="gradeC">
                <td style="text-align: center; font-size: 10pt;">{{$cotizacion->cliente}} </td>
                <td style="text-align: center; font-size: 10pt;">{{$cotizacion->nit_cliente}} </td>
                </tr>
            </tbody>
        </table>
        @if ($cotizacion->detalle == null)
        <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="background:#343a40;color:#D0D3D4;text-align:center">
                <tr class="col-auto bg-secondary">
                    <th width=8%>CANTIDAD</th>
                    <th >GRUPO</th> 
                    <th >ARTICULO</th>
                    <th >MARCA</th>
                    <th width=8%>P. VENTA</th>
                    <th width=8%>SUB TOTAL</th>
                    
                </tr>
            </thead>
            <tbody style="text-align: center">
                @foreach($sql as $cotizacions)
                <tr class="gradeC">
                    <td>{{$cotizacions->cantidad}}</td>
                    <td>{{$cotizacions->nombre_bien}}</td>
                    <td>{{$cotizacions->nombre_articulo}}</td>
                    <td>{{$cotizacions->marca}}</td>
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
                <thead style="background:#343a40;color:#D0D3D4;text-align:center">
                    <tr class="col-auto bg-secondary">
                        <th>SERVICIO</th>
                        <th width=12%>SUB TOTAL</th>
                        
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    <tr class="gradeC">
                        <td>{{$cotizacion->detalle}}</td>
                        <td>{{$cotizacion->total}}</td>
                    </tr>
                    <tr><td colspan="2"><button class='btn btn-light dim'></button> </td></tr>
                    <tr>
                        <th style="text-align: right"  >TOTAL Bs:</th>
                        <th st>{{$cotizacion->total}} </th>
                    </tr>
                    <tr>
                        <th style="text-align: right"  >Descuento (Bs):</th>
                        <th st>{{$cotizacion->descuento}} </th>
                    </tr>
                    <tr>
                        <th style="text-align: right" >TOTAL NETO (Bs):</th>
                        <th st>{{$cotizacion->total-$cotizacion->descuento}}</th>
                    </tr>
                </tbody>
            </table>
        @endif
        
        
    </main>
    <footer>
        <p><strong>HYDRAUTEK</strong></p>
    </footer>
</body>
</html>