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

        <link href="/css/main.css"  rel="stylesheet">
        <link href="/css/all.css"  rel="stylesheet">
        <link href="{{ asset('css/font.css') }}" rel="stylesheet">


        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <style>
            @media print {
                body * { visibility: hidden;}
                #imp {
                    display: none
                }
              
                
                .print-page , .print-page *  {
                 
                    visibility: visible;
                    
                }
               

                
            }
        </style>
      
    </head>

<body>

    
    <div class="form-group m-2 " style="position: fixed; right:40%">
        <label for="sold" class="mb-2">Sold:</label>
        <select name="sold" id="sold" class="form-control form-select">
          <option value="" disabled selected>Selectionner Sold</option>
          <option value="Avec">Avec Sold</option>
          <option value="Sans" >Sans Sold</option>

     </select>    
        
       </div>



        
            <div class="form-group m-2 " style="position: fixed; right:15%">
                <label for="nameE" class="mb-2">Type Impression:</label>
                <select name="nameE" id="ImpType" class="form-control form-select">
                  <option value="" disabled selected>Selectionner Type D'Impression</option>
                  <option value="Avec">Avec Détails TVA</option>
                  <option value="Sans" >Sans Détails TVA</option>
                  <option value="Montant" >Sans Montant</option>

             </select>    
                
               </div>

        
        <div style="position: fixed ; right:0%">
            <button class=" mt-2 btn btn-success "  onclick="window.print();">Print </button>


        </div>





<div  class=" p-3 mb-5   font-weight-bolder  print-page"  style="font-size:20px; margin-left:10px;margin-right:10px">
<div class="container">
    <div class="brand-section d-flex">
        <div >
           
                <img width="220" height="83" src="/img/log.png" alt="">
        </div>
        <div class="bg-white" style="font-size:14px; max-height:95px">
            <p class="mt-3 ml-2" style="line-height: 1.2;  ">Lot. 06, ilot 02, Z.A. Hennaya <br>
            Tlemcen 13550 - ALGERIE <br>
            Tél.: 043 434 434 fax: 043 434 435 <br>
            <b>www.beka-imprimerie.com</b>
            </p>


        </div>
          
    </div>

    <div class="body-section mt-5" >

        <div class="d-flex justify-content-end">

            <p class="text-right" style="font-size:14px"><u>Tlemcen, le {{ $Bl->created_at->format('d/m/Y') }}</u> </p>

        </div>
        <div class="text-center">

            <h4><b>Bon de livraison N<sup>o</sup>{{ $Bl->Bl_num  }}</b> </h4>

        </div>
       
    </div>
    

    <div class="body-section mt-5 ">

        <h4 class="m-3 font-weight-bold"><i>Client:</i> &nbsp; &nbsp; &nbsp; <b>{{ $Bl->client->Name }}</b>    </h4>
      
       
        <table class="table table-bordered table-hover text-center" style="font-size:14px">
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
                <td class="text-start">{{$Bl->Designation}}</td>
                <td>{{number_format($Bl->Quantity,0,'.',',')}} </td>
                @if ($Bl->Colis == 0)
                <td>-</td>

                    
                @else
                <td>{{$Bl->Colis}} </td>

                @endif
            
             
              <td class="text-end">{{ number_format($Bl->Price_HT,2,'.',',')}} </td>
              
              <td class="text-end">{{ number_format($Bl->Price_HT * $Bl->Quantity ,2,'.',',')}}</td>
            

          </tr>

           
           

              @endforeach
                
              <tr>
                <td style="border-right: 1px solid white;border-bottom: 1px solid white; border-left: 1px solid white;"></td>
                <td style="border-bottom: 1px solid white;border-right: 1px solid white;"></td>
                <td style="border-bottom: 1px solid white;border-left: 1px solid white;"></td>


                <td  class="text-start">TOTAL</td>
                <td  class="text-end">{{ number_format($total  ,2,'.',',')  }} </td>


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
  

    <div class="bottom" style="position: fixed; bottom: 0px; visibility:hidden ">
        <div >
            <p style="font-size: 11px"> <b>R.C.N°:</b>  1331046/A/01 &nbsp;&nbsp; <b> M.F:</b> 1973 130 102 708 33 &nbsp;&nbsp; <b>A.I :</b> 13260551433 &nbsp;&nbsp; <b>NIS </b> 197313010270833 &nbsp;&nbsp;  <b>C.B: SGA :</b>  021 004021130005514-62
                 </p>
        </div>
      
    
    </div>

</div>










<script>

var userData = <?php echo json_encode($Bldetails)?>;
var sold = <?php echo json_encode($sold)?>;

$('#ImpType').change(function(){

    console.log(userData)

        
var type = $(this).val();

if( type == "Avec")
{



    $('tbody').html('')

              $.each(userData, function(key, item){

             
              
                if(item.Colis > 0)
                {

                $('tbody').append('\
              <tr>\
            <td  class="text-start">'+item.Designation+'</td>\
            <td>'+item.Quantity.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td>\
            <td>'+item.Colis+'</td>\
            <td  class="text-end">'+(item.Price_HT / 1.19).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
            <td  class="text-end">'+((item.Price_HT / 1.19) * item.Quantity).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
              </tr>')
            }
            else
            {
                $('tbody').append('\
              <tr>\
            <td  class="text-start">'+item.Designation+'</td>\
            <td>'+item.Quantity.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td>\
            <td>-</td>\
            <td  class="text-end">'+(item.Price_HT / 1.19).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
            <td  class="text-end">'+((item.Price_HT / 1.19) * item.Quantity).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
              </tr>')


            }

             })
            

             $('tbody').append(' <tr>\
                <td  style="border-bottom: 1px solid white;border-left: 1px solid white;border-right: 1px solid white"></td>\
                <td  style="border-bottom: 1px solid white;border-right: 1px solid white"></td>\
                <td  style="border-bottom: 1px solid white ;"></td>\
                <td  class="text-start">TOTAL HT</td>\
                <td  class="text-end">{{ number_format($total /1.19 ,2,'.',',')  }} </td>\
              </tr>\
            <tr >\
                <td  id="word" class="text-start" rowspan="2"  style="border: 1px solid white"></td>\
                <td  style="border-bottom: 1px solid white;border-right: 1px solid white"></td>\
                <td  style="border-bottom: 1px solid white;"></td>\
                <td  class="text-start"> TVA </td>\
                <td  class="text-end">{{ number_format($total/1.19 * 0.19  ,2,'.',',')  }} </td>\
              </tr>\
              <tr >\
                <td  style="border-bottom: 1px solid white;border-right: 1px solid white"></td>\
                <td  style="border-bottom: 1px solid white;border-left: 1px solid white"></td>\
                <td class="text-start" class="text-end">TTC</td>\
                <td  class="text-end" >{{ number_format($total ,2,'.',',')  }} </td>\
              </tr>')

  
}
else if( type == "Montant"){
  
    $('tbody').html('')

$.each(userData, function(key, item){



    if(item.Colis > 0)
    {
 
            $('tbody').append('\
            <tr>\
            <td  class="text-start">'+item.Designation+'</td>\
            <td>'+item.Quantity.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td>\
            <td>'+item.Colis+'</td>\
            <td></td>\
            <td></td>\
            </tr>')
    }        
    else{
        $('tbody').append('\
            <tr>\
            <td  class="text-start">'+item.Designation+'</td>\
            <td>'+item.Quantity.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td>\
            <td>-</td>\
            <td></td>\
            <td></td>\
            </tr>')

    }

})

$('tbody').append(' <tr>\
  <td  style="border-bottom: 1px solid white;border-left: 1px solid white;border-right: 1px solid white"></td>\
  <td  style="border-bottom: 1px solid white;border-right: 1px solid white"></td>\
  <td  style="border-bottom: 1px solid white ;"></td>\
  <td class="text-start"  >TOTAL </td>\
  <td> </td>\
</tr>')



}
else{
    $('tbody').html('')

              $.each(userData, function(key, item){

             
              
                
               if(item.Colis > 0)
               {
                
               
                $('tbody').append('<tr>\
            <td  class="text-start">'+item.Designation+'</td>\
            <td >'+item.Quantity.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td>\
            <td>'+item.Colis+'</td>\
            <td  class="text-end">'+(item.Price_HT ).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
            <td  class="text-end">'+(item.Price_HT * item.Quantity).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
              </tr>')
               }
               else
               {
                $('tbody').append('<tr>\
            <td  class="text-start">'+item.Designation+'</td>\
            <td >'+item.Quantity.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td>\
            <td>-</td>\
            <td  class="text-end">'+(item.Price_HT ).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
            <td  class="text-end">'+(item.Price_HT * item.Quantity).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")+'</td>\
              </tr>')

               }


            })
              $('tbody').append(' <tr>\
                <td  style="border-bottom: 1px solid white;border-left: 1px solid white;border-right: 1px solid white"></td>\
                <td  style="border-bottom: 1px solid white;border-right: 1px solid white"></td>\
                <td  style="border-bottom: 1px solid white ;"></td>\
                <td class="text-start"  >TOTAL </td>\
                <td  class="text-end">{{ number_format($total ,2,'.',',')  }} </td>\
              </tr>')
            

}


});

$('#sold').change(function(){


    
var type = $(this).val();

if(type == "Avec")
{
    $('tbody').append('<tr id="tsold">\
        <td  style="border-bottom: 1px solid white;border-left: 1px solid white;border-right: 1px solid white"></td>\
                <td  style="border-bottom: 1px solid white;border-right: 1px solid white"></td>\
                <td  style="border-bottom: 1px solid white ;"></td>\
                <td class="text-start" >SOLD </td>\
                <td  class="text-end">{{ number_format($sold ,2,'.',',')  }}</td>\
                </tr>\
    ')





}
else{
    $('#tsold').remove();

}



});



</script>


</body>
</html>