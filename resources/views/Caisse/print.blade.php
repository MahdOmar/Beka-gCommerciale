<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>gCommaertiale</title>
    
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="/css/main.css"  rel="stylesheet">
        <link href="/css/all.css"  rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <style>
            @media print {
                body * { visibility: hidden;}
                
                .print-page , .print-page *{
                 
                    visibility: visible}
            }
        </style>
      
    </head>

<body>

<button class="btn btn-success " style="margin-left: 1280px;margin-top:20px;margin-bottom:20px" onclick="window.print();">Print </button>



<div  class=" p-3 mb-5   font-weight-bolder  print-page"  style="font-size:20px; margin-left:10px;margin-right:10px">
<div class="container">
    <div class="brand-section">
        <div class="text-center">
           
                <img src="/img/logo2.png" alt="">
        </div>
          
    </div>

    <div class="body-section mt-5" >

        <div class="d-flex justify-content-end">

            <p class="text-right"><u>Tlemcen, le {{ $Cais->created_at->format('d/m/Y') }}</u> </p>

        </div>
        <div class="text-center">

            <h4><b>Reçu de Payment </b> </h4>

        </div>
       
    </div>
     

    <div class="body-section mt-5 ">

        <h4 class="m-3 font-weight-bold"><i>Client:</i> &nbsp; &nbsp; &nbsp; <b>{{ $client->Name }}</b>    </h4>
      
       @if ($caisse->Operation == "Encaissement de Bl")
       <table class="table table-bordered table-hover text-center">
        <thead>
            <tr>
                <th style="width: 30%">N° Operation</th>
             
                <th style="width: 40%">Montant</th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <td>{{   str_pad($Cais->id, 3, '0', STR_PAD_LEFT)   }}</td>
                <td> {{ number_format($Cais->Amount,2,'.',',')  }} </td>
            </tr>

            

        </tbody>
    </table>
           
       @else

       <table class="table table-bordered table-hover text-center">
        <thead>
            <tr>
                <th style="width: 20%">N° Facture</th>
                <th style="width: 50%">Mode de Payment</th>
                <th style="width: 30%">Montant </th>


            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ \App\Models\Facture::where('id',$Cais->Bl_id)->value('Fac_num')   }}</td>

                <td>Especes</td>
              
                <td> {{ number_format($caisse->Amount,2,'.',',')  }} </td>
            </tr>

            

        </tbody>
    </table>


           
       @endif
       
        <br>

       


       
    </div>

   

     
</div>   
</div>








</body>
</html>