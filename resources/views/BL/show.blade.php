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

            <p class="text-right"><u>Tlemcen, le {{ $Bl->created_at->format('d/m/Y') }}</u> </p>

        </div>
        <div class="text-center">

            <h4><b>Bon de livraison N<sup>o</sup>{{ $Bl->Bl_num  }}</b> </h4>

        </div>
       
    </div>
    

    <div class="body-section mt-5 ">

        <h4 class="m-3 font-weight-bold"><i>Client:</i> &nbsp; &nbsp; &nbsp; <b>{{ $Bl->client->Name }}</b>    </h4>
      
       
        <table class="table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th style="width: 40%">Désignation</th>
                    <th style="width: 15%">Quantité</th>
                    <th style="width: 10%">Colis</th>
                    <th style="width: 15%">Prix Unitaire</th>
                    <th style="width: 20%">Montant</th>
                </tr>
            </thead>
            <tbody>
                

                @php
                $total = 0;
            @endphp
            @foreach($Bldetails as $Bl)

            
            
            @php
            $total = $total + ($Bl->Price_HT * $Bl->Quantity  )
        @endphp
            <tr>
                <td>{{$Bl->Designation}}</td>
                <td>{{number_format($Bl->Quantity,0,'.',',')}} </td>
                <td>{{$Bl->Colis}} </td>
            
             
              <td>{{ number_format($Bl->Price_HT,2,'.',',')}} </td>
              
              <td>{{ number_format($Bl->Price_HT * $Bl->Quantity ,2,'.',',')}}</td>
            

          </tr>

           
           

              @endforeach
                
              <tr>
                <td style="border-right: 1px solid white;border-bottom: 1px solid white; border-left: 1px solid white;"></td>
                <td style="border-bottom: 1px solid white;border-right: 1px solid white;"></td>
                <td style="border-bottom: 1px solid white;border-left: 1px solid white;"></td>


                <td  class="text-end">TOTAL</td>
                <td>{{ number_format($total  ,2,'.',',')  }} </td>


              </tr>
          




            </tbody>
        </table>
        <br>

       


       <p><b>Tranportateur:</b></p>
    </div>

    <div class="d-flex justify-content-between " style="margin-top: 100px">

        <div>

            <p>Signature de BEKA</p>

        </div>

        <div>
            <p>Signature du CLIENT</p>


        </div>

    </div>

     
</div>   
</div>








</body>
</html>