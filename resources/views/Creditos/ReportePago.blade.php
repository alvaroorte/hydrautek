
<!DOCTYPE html>

<html lang="en">
  
<head>
    <meta charset="UTF-8">
    <title>REPORTE DE PAGO</title>
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
        <a href="{{url('creditodetallados/'.$credito->id.'/'.$credito->tipo)}}" class="config">
          <img src="{{asset('assets/dashboard/images/Captura2.png')}}" alt="..." class="img-circle" width="100" height="54">
        </a>
        <div class="car-body" style="text-align: center" >
          <span>Codigo: <b>{{$credito->codigo}}</b></span>
        </div>
      </div>
    </header>
    <main><br>
            <h4 style="text-align: center">HYDRAUTEK</h4>
            <br>
            <h5 style="text-align: center"> NOTA DE PAGO</h5><h6 style="text-align: center"> N° 0{{$pago->id}}</h6>
            <br>
            <table class="table table-striped text-center">
            <tr>
                <th width="53%">Modalidad de Pago</th>
                @if ($pago->id_banco != null)
                  <th>Banco</th>
                @else
                  <th>Efectivo</th>
                @endif
                
            </tr>
            <tr>
              <th>Fecha de Pago </th>
              <td style="text-align: left"> {{$pago->fecha}} </td>
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
                <td style="text-align: center; font-size: 10pt;">{{$cliente->nombre}}</td>
                <td style="text-align: center; font-size: 10pt;">{{$cliente->ci}}</td>
            </tr>
            </tbody>
          </table>
          <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="background:#343a40;color:#D0D3D4;text-align:center">
              <tr class="col-auto bg-secondary">
                  <th >PAGANTE</th> 
                  <th >NIT/CI</th>
                  <th >MONTO (Bs.)</th>
                  <th width=12%>SALDO (Bs.)</th>
                  
              </tr>
            </thead>
            <tbody style="text-align: center">
              <?php $i = 0; ?>
              
              <tr class="gradeC">
                <td>{{$pago->nombre}}</td>
                <td>{{$pago->ci}}</td>
                <td>{{$pago->monto}}</td>
                <td>{{$credito->saldo}}</td>
              </tr>
              <tr><td colspan="4" ><button class='btn btn-light dim'></button> </td></tr>
              <tr>
                <th style="text-align: right" colspan="3" >TOTAL SALDO(Bs):</th>
                <th st>{{$credito->saldo}} </th>
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













