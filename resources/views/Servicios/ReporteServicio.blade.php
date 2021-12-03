
<!DOCTYPE html>

<html lang="en">
  
<head>
    <meta charset="UTF-8">
    <title>REPORTE DE SALIDA</title>
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
        <a href="{{url('mostrarsalidas')}}" class="config">
          <img src="{{asset('assets/dashboard/images/Captura2.png')}}" alt="..." class="img-circle" width="100" height="54">
        </a>
        <div class="car-body" style="text-align: center" >
          <span>Cod. Venta: <b>{{$salida->codigo_venta}}</b></span>
        </div>
      </div>
    </header>
    <main><br>
            <h4 style="text-align: center">HYDRAUTEK</h4>
            <br>
            <h5 style="text-align: center"> NOTA DE REMISION</h5>
            <br>
            <table class="table table-striped text-center">
            <tr>
                <th width="53%">Modalidad de Pago </th>
                <th>@if ($salida->sccredito == 1)
                      Credito
                    @else
                      @if ($salida->sccredito == 0)
                          Efectivo
                      @else
                          Banco
                      @endif
                    @endif </th>
            </tr>
            <tr>
              <th>Fecha de Venta </th>
              <td style="text-align: left"> {{$salida->fecha}} </td>
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
                <td style="text-align: center; font-size: 10pt;">{{$salida->cliente}}</td>
                <td style="text-align: center; font-size: 10pt;">{{$salida->nit_cliente}}</td>
              
              
            </tr>
            </tbody>
          </table>
          <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="background:#343a40;color:#D0D3D4;text-align:center">
              <tr class="col-auto bg-secondary">
                  <th width="70%">SERVICIO</th>
                  <th >P_UNITARIO (Bs)</th>
                  <th >SUB TOTAL (Bs)</th>
                  
              </tr>
            </thead>
            <tbody style="text-align: center">
              <?php $i = 0; ?>
              <tr class="gradeC">
                <td>{{$salida->detalle}}</td>
                <td>{{$salida->total}}</td>
                <td>{{$salida->total}}</td>
                <?php $i = $i+$salida->sub_total ?>
              </tr>
              <tr><td colspan="3" ><button class='btn btn-light dim'></button> </td></tr>
              <tr>
                <th style="text-align: right" colspan="2" >TOTAL (Bs):</th>
                <th st>{{$salida->total}} </th>
              </tr>
              <tr>
                <th style="text-align: right" colspan="2" >Descuento (Bs):</th>
                <th st>{{$salida->descuento}} </th>
              </tr>
              <tr>
                <th style="text-align: right" colspan="2" >TOTAL NETO (Bs):</th>
                <th st>{{$salida->total-$salida->descuento}}</th>
              </tr>
            </tbody>
          </table>

        <br>
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
        <p><strong>HYDRAUTEK</strong></p>
    </footer>
</body>
</html>