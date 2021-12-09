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
        <a href="{{url('creditodetallados/'.$credito->id.'/'.$credito->tipo)}}" class="config">
          <img src="{{asset('assets/dashboard/images/HC2.png')}}" alt="..." class="img-circle" width="100" height="54">
        </a>
        <div class="car-body" style="text-align: center" >
          <span>Codigo: <b>{{$credito->codigo}}</b></span>
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
            <h5 style="text-align: center"> NOTA DE PAGO</h5><h6 style="text-align: center"> N° 0{{$pago->id}}</h6>
            
            <table class="table table-striped text-center" style="font-size: 7pt" >
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
            <tr>
              <th>Cliente </th>
              <td style="text-align: left">{{$cliente->nombre}} ({{$cliente->ci}}) </td>
            </tr>
          </table>
        
        <h4 style="text-align: center">Detalle</h4>
          <table class="table table-bordered table-hover table-striped table-sm">
            <thead style="text-align:center">
              <tr>
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
                <td>{{number_format($pago->monto,2)}}</td>
                <td>{{number_format($credito->total-$suma,2)}}</td>
              </tr>
              <tr><td colspan="4" ><button class='btn btn-light dim'></button> </td></tr>
              <tr>
                <th style="text-align: right" colspan="3" >TOTAL SALDO(Bs):</th>
                <th st>{{number_format($credito->total-$suma,2)}} </th>
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
        <p><strong>HYDRAUCRUZ</strong></p>
    </footer>
</body>
</html>













