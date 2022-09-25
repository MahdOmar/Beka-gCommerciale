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

   
  <div style="position: fixed ; right:0%">
    <button class=" mt-2 btn btn-success "  onclick="window.print();">Print </button>


</div>


<div  class=" p-3 mb-5   font-weight-bolder  print-page"  style="font-size:20px; margin-left:10px;margin-right:10px">
<div class="container">
  <div class="brand-section d-flex">
    <div >
       
            <img src="/img/log.png" alt="">
    </div>
    <div class="bg-white" style="font-size:14px; max-height:95px">
        <p class="mt-4 ml-2" style="line-height: 1.2;  ">Lot. 06, ilot 02, Z.A. Hennaya <br>
        Tlemcen 13550 - ALGERIE <br>
        Tél.: 043 434 434 fax: 043 434 435 <br>
        <b>www.beka-imprimerie.com</b>
        </p>


    </div>
      
</div>

    <div class="body-section mt-5" >

      @php
          $expNum = explode('/', $Fac->Fac_num);
      @endphp

        
        <div class="text-center">
        @if ($Fac->Type == 'Normal')
            
        <h4><b>Facture N<sup>o</sup>{{ $expNum[1] }}</b> </h4>

        @else
        <h4><b>Facture Proforma N<sup>o</sup>{{ $expNum[1] }}</b> </h4>

        @endif

        </div>
       
    </div>

    <div class="body-section mt-2 d-flex" style="font-size:15px" >
        <div class="w-50 m-2">
            <div class="border p-2">
                <p><i> Date: {{ $Fac->created_at->format('d/m/Y') }} </i></p>
            </div>

            <div class="border ps-2 pt-2">
                <p class="mb-0"><b>Client:</b></p>
                <h6 class="text-uppercase" ><b>{{ $Fac->client->Name }}</b></h6>
            </div>

            @if ($Fac->Type == 'Normal')
            <div class="border ps-2 pt-2">
                <p >Mode de paiement: {{ $Fac->ModePay }}</p>
            </div>
                
            @endif
           
           

        </div>


        <div class=" border w-50 m-2 p-2">

            <p class="text-uppercase">{{$Fac->client->Adress}}</p>
            <h4 style="font-size:15px"><b>R C: &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;{{ $Fac->client->RC }}</b></h4>
            <h4 style="font-size:15px"><b>N I F: &nbsp; &nbsp; &nbsp;{{ $Fac->client->NIF }}</b></h4>
            <h4 style="font-size:15px"><b>A I: &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;{{ $Fac->client->AI }}</b></h4>




            
        </div>

        
       
       
    </div>
    

    <div class="body-section mt-1 ">

      
       
        <table class="table table-bordered table-hover text-center" style="font-size:14px" >
            <thead>
                <tr>
                <th style="width: 45%">Désignation</th>
                <th style="width: 15%">Quantité</th>
                <th style="width: 20%">P.U HT</th>
                <th style="width: 20%">Montant</th>
                </tr>
            </thead>
            <tbody>
                
                @php
                $total = 0
            @endphp
                @foreach($Fdetails as $fac)

            
              @php
              $total = $total + ($fac->Price_HT * $fac->Quantity  )
          @endphp
              <tr>
                <td class="text-start">{{$fac->Designation}}</td>
                <td class="text-end">{{number_format($fac->Quantity,0,'.',',')}} </td>
                <td class="text-end">{{ number_format($fac->Price_HT,2,'.',',')}} </td>
                <td class="text-end">{{ number_format($fac->Price_HT * $fac->Quantity ,2,'.',',')}} </td>
              

            </tr>
            @endforeach


            

              

          
        

            <tr >
                <td style="border-right: 1px solid white;border-left: 1px solid white;"></td>
                <td style="border-bottom: 1px solid white;border-right: 1px solid white;"></td>

            </tr>

            <tr  >
                <td class="text-start"  style="border: 1px solid white">Arrêté la présente Facture  à la somme de :</td>
                <td  style="border-bottom: 1px solid white"></td>
                <td  class="text-start">Total HT</td>
                <td class="text-end">{{ number_format($total  ,2,'.',',')  }} </td>


              </tr>

              

              
            <tr >
                <td  id="word" class="text-start" rowspan="2"  style="border: 1px solid white"></td>
                <td  style="border-bottom: 1px solid white"></td>
                <td  class="text-start">Taux TVA 19%</td>
                <td class="text-end">{{ number_format($total*0.19  ,2,'.',',')  }} </td>


              </tr>

              <tr >
             
                <td  style="border-bottom: 1px solid white"></td>
                <td  class="text-start">Total TTC</td>
                <td class="text-end">{{ number_format($total*0.19 + $total  ,2,'.',',')  }} </td>


              </tr>
            </tbody>


        </table>

        <input type="number" id='total' value={{$total + $total * 0.19 }} style="display: none;">

        
    
    


        </div>
     
        <br>

       


    </div>

    

     
</div>   
</div>




<script>

word = document.getElementById('word');

//total = <?php echo $total + $total *0.19?>

total = $('#total').val();
total = (Math.round(total * 100) / 100).toFixed(2);



real = parseInt(total)
decimal = getDecimalPart(total);


console.log(doConvert(2398));
if(decimal != 0)
{
  document.getElementById('word').innerHTML = '<i>' +doConvert(real)+' Dinars <br>' + doConvert(decimal) + 'centimes </i> ';

}
else{
  document.getElementById('word').innerHTML = '<i>' +doConvert(real)+' Dinars zero centimes <br></i>' ;

}


function getDecimalPart(num) {
  if (Number.isInteger(num)) {
    return 0;
  }

  const decimalStr = num.toString().split('.')[1];
  return Number(decimalStr);
}



// System for American Numbering 
function doConvert (s){
    let numberInput = s;
    let myDiv = document.getElementById('word');

    let oneToTwenty = ['','un ','deux ','trois ','quatre ', 'cinq ','six ','sept ','huit ','neuf ','dix ',
    'Onze  ','douze ','treize ','quatorze ','quinze  ','seize ','dix-sept ','dix-huit ','dix-neuf '];
    let tenth = ['', '', 'vingt','trente','quarante','cinquante', 'soixante','soixante dix','quatre vingts','quatre vingt dix'];

    if(numberInput.toString().length > 7) return myDiv.innerHTML = 'overlimit' ;
    console.log(numberInput);
    //let num = ('0000000000'+ numberInput).slice(-10).match(/^(\d{1})(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
  let num = ('0000000'+ numberInput).slice(-7).match(/^(\d{1})(\d{1})(\d{2})(\d{1})(\d{2})$/);
    console.log(num);
    if(!num) return;

    let outputText = num[1] != 0 ? (oneToTwenty[Number(num[1])] || `${tenth[num[1][0]]} ${oneToTwenty[num[1][1]]}` )+' million ' : ''; 
  
    outputText +=num[2] != 0 ? (oneToTwenty[Number(num[2])] || `${tenth[num[2][0]]} ${oneToTwenty[num[2][1]]}` )+'cent ' : ''; 
//    outputText +=num[3] != 0 ? (oneToTwenty[Number(num[3])] || `${tenth[num[3][0]]} ${oneToTwenty[num[3][1]]}`)+' mile ' : ''; 


switch (num[3]) {
  case "71":
    outputText += "soixante onze mile ";
    break;
  case "72":
    outputText += "soixante douze mile ";
    break;
  case "73":
     outputText += "soixante treize mile ";
    break;
  case "74":
    outputText += "soixante quatorze mile ";
    break;
  case "75":
    outputText += "soixante quinze mile ";
    break;
  case "76":
    outputText += "soixante seize mile ";
    break;
  case "77":
    outputText += "soixante dix-sept mile ";
    break;

    case "78":
    outputText += "soixante dix-huit mile ";
    break;

    case "79":
    outputText += "soixante dix-neuf mile ";
    break;

    case "91":
    outputText += "quatre vingt onze mile ";
    break;

    case "92":
    outputText += "quatre vingt douze mile ";
    break;

    case "93":
    outputText += "quatre vingt treize mile ";
    break;

    case "94":
    outputText += "quatre vingt quatorze mile ";
    break;

    case "95":
    outputText += "quatre-vingt quinze mile ";
    break;

    case "96":
    outputText += "quatre vingt seize mile ";
    break;

    case "97":
    outputText += "quatre vingt dix sept mile ";
    break;

    case "98":
    outputText += "quatre vingt dix-huit mile ";
    break;

    case "99":
    outputText += "quatre vingt dix-neuf mile ";
    break;

   default:

  outputText +=num[3] != 0 ? (oneToTwenty[Number(num[3])] || `${tenth[num[3][0]]} ${oneToTwenty[num[3][1]]}`)+' mile ' : ''; 



    
}





    outputText +=num[4] != 0 ? (oneToTwenty[Number(num[4])] || `${tenth[num[4][0]]} ${oneToTwenty[num[4][1]]}`) +'cent ': ''; 
   // outputText +=num[5] != 0 ? (oneToTwenty[Number(num[5])] || `${tenth[num[5][0]]} ${oneToTwenty[num[5][1]]} `) : ''; 


   
    switch (num[5]) {
  case "71":
    outputText += "soixante onze";
    break;
  case "72":
    outputText += "soixante douze";
    break;
  case "73":
     outputText += "soixante treize";
    break;
  case "74":
    outputText += "soixante quatorze";
    break;
  case "75":
    outputText += "soixante quinze";
    break;
  case "76":
    outputText += "soixante seize";
    break;
  case "77":
    outputText += "soixante dix-sept";
    break;

    case "78":
    outputText += "soixante dix-huit";
    break;

    case "79":
    outputText += "soixante dix-neuf";
    break;

    case "91":
    outputText += "quatre vingt onze";
    break;

    case "92":
    outputText += "quatre vingt douze";
    break;

    case "93":
    outputText += "quatre vingt treize";
    break;

    case "94":
    outputText += "quatre vingt quatorze";
    break;

    case "95":
    outputText += "quatre-vingt quinze";
    break;

    case "96":
    outputText += "quatre vingt seize";
    break;

    case "97":
    outputText += "quatre vingt dix sept";
    break;

    case "98":
    outputText += "quatre vingt dix-huit";
    break;

    case "99":
    outputText += "quatre vingt dix-neuf";
    break;

   default:
   outputText += (oneToTwenty[Number(num[5])] || `${tenth[num[5][0]]} ${oneToTwenty[num[5][1]]} `); 




    
}

   

    if(outputText.startsWith("un"))
    {
        outputText = outputText.replace("un", "");
    }
    return outputText;
}
</script>



</body>
</html>