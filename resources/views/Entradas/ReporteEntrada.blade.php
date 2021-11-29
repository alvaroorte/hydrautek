<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>REPORTE DE ENTRADA</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        @page {
            margin: 0cm 0cm;
            font-size: 10pt;
        }
        body {
            margin: 3cm 2cm 2cm;
        }
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1.3cm;
            background-color: #475161;
            color: white;
            text-align: center;
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

    </header>
    <main>
        <div class="container">
            <h4 style="text-align: center">GOBIERNO AUTONOMO MUNICIPAL DE POTOSÍ</h4>
            <br>
            <h5 style="text-align: center"> UNIDAD DE MAESTRANZA</h5>
            <br>

            <h5 style="text-align: center"> Datos </h5>
            <table class="table table-striped text-center">
            <tr>
                <th align="left" width="20%">Tipo </th>
                <th align="left"> INGRESO </td>
            </tr>
             
             <tr>
               <th align="left" width="20%">Fecha de Impresion </th>
               <td align="left"> {{date('d-m-Y')}} </td>
             </tr>
             
            </table>
        <br>
        <br>
        <br>
        <h5 style="text-align: center">TABLA DE BIENES DE ENTRADA</h5>
        <table class="table table-striped text-center">
            
             <tr>
                <th align="left" width="20%">Bien </th>
                <td align="left">{{ $bien->nombre }}</td>
             </tr>
             <tr>
               <th style="text-align: left" width="20%">Tipo de Bien </th>
               <td align="left"> {{ $articulo->nombre }} </td>
             </tr>
             <tr>
                <th align="left" width="20%">Cantidad </th>
                <td align="left"> {{ $entrada->cantidad }} </td>
              </tr>
              <tr>
                <th align="left" width="20%">Detalle </th>
                <td align="left"> {{ $entrada->detalle }} </td>
              </tr>
              <tr>
                <th align="left" width="20%">Fecha de Ingreso </th>
                <td align="left"> {{ $entrada->fecha }} </td>
              </tr>
             
            </table>
        <br>
        <br>
        <br>
        <h6 style="align-content: fa-pull-left"> ENTREGUE CONFORME:</h6>
        <br><br><br><br><br><br>
        <h6 style="align-content: fa-pull-left">RECIBI CONFORME:</i></h6>
        </div>
    </main>
    <footer>
        <p><strong>GOBIERNO AUTÓNOMO MUNICIPAL DE POTOSÍ</strong></p>
    </footer>
</body>
</html>