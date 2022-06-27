@extends('layouts.dashboard')
@section('content')

<div class="m-3">

    <h4>Dashborad / <a class="text-info" href="/dashboard/stats">Stats</a> </h4>
  
  
  </div>
  
  <div  class=" shadow p-3 mb-5 bg-white rounded"  style=" margin-left:10px;margin-right:10px">
  
  
    
    <div class="row">

        @php

        $countP = 0;
        $countN = 0;

        foreach ($bls as $bl ) 
        {
          $total = 0 ;

          foreach ($Bds as $Bd)
          {
            if($Bd->Bl_id == $bl->id)
               {
                 $total = $total + $Bd->Price_HT *  $Bd->Quantity;
               }
          }

          foreach ($Payments as $item)
            if ($item->Designation == $bl->id)
            {
                if ($item->Amount == $total)
                {
                  
                    $countP ++ ;
                }

                else
                {
                    
                    $countN ++ ;
                }

            }
            



        }



            
        @endphp

@php
$totalCais = 0 ;
$enc = 0 ;
$reg = 0;
   foreach($Payments as $cais)
    {
      if($cais->Operation == "Encaissement de Facture/Bl")
      {
        $totalCais = $totalCais + $cais->Amount;
        $enc = $enc + $cais->Amount;

      }

      else {
        $totalCais = $totalCais - $cais->Amount;
        $reg = $reg + $cais->Amount;

      }



      

    }

    $totalbdl = 0 ;

foreach ($Bds as $Bd)
{
 
     
       $totalbdl = $totalbdl + $Bd->Price_HT *  $Bd->Quantity;
     
}

$totalCaisse = 0;
foreach($Payments as $cais)
    {
      if($cais->Operation == "Encaissement de Facture/Bl")
      {
        $totalCaisse = $totalCaisse + $cais->Amount;
      
      }
    }



  
   

@endphp

  
  
  
        <div class="col-md-4 col-xl-4">
            <div class="card support-bar overflow-hidden">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-md-8">
                            <h1 class="m-0">{{ count($bls) }}</h1><br>
  
                        </div>
                        <div class="col-md-4 cl">
                            <img src="/img/BL.png" width="70" height="90" alt="">
                        </div>
                    </div>
                    <span class="text-c-blue">Total Bls</span>
  
                    <p class="mb-3 mt-3">Total number of Bls.</p>
  
                </div>
                <div id="support-chart"></div>
                <div class="card-footer bg-primary text-white">
                    <div class="row text-center">
                        <div class="col">
                            <h4 class="m-0 text-white">{{$countP }}</h4>
                            <span>Payé</span>
                        </div>
                        <div class="col">
                            <h4 class="m-0 text-white">{{$countN }}</h4>
                            <span>Non Payé</span>
                        </div>
                        <div class="col">
                            <h4 class="m-0 text-white">{{count($Facture) }}</h4>
                            <span>Facturé</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
        <div class="col-md-4 col-xl-4">
          <div class="card support-bar overflow-hidden">
              <div class="card-body pb-0">
                  <div class="row">
                      <div class="col-md-8">
                          <h1 class="m-0">{{ count($Normal) + count($Proforma) }}</h1><br>
  
                      </div>
                      <div class="col-md-4 cl">
                          <img src="/img/fac.jpg" width="70" height="90" alt="">
                      </div>
                  </div>
                  <span class="text-c-blue">Total Factures</span>
  
                  <p class="mb-3 mt-3">Total number of Factures.</p>
  
              </div>
              <div id="support-chart"></div>
              <div class="card-footer bg-success text-white">
                  <div class="row text-center">
                      <div class="col">
                          <h4 class="m-0 text-white">{{ count($Normal)}}</h4>
                          <span>Normal</span>
                      </div>
                      <div class="col">
                          <h4 class="m-0 text-white">{{ count($Proforma)}}</h4>
                          <span>Proforma</span>
                      </div>
                     
                  </div>
              </div>
          </div>
      </div>
  

      <div class="col-md-4 col-xl-4">
        <div class="card support-bar overflow-hidden">
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="m-0">{{ count($Clinets)}}</h1><br>

                    </div>
                    <div class="col-md-4 cl">
                        <img src="/img/clients.jpg" width="70" height="90" alt="">
                    </div>
                </div>
                <span class="text-c-blue">Total Clients</span>

                <p class="mb-3 mt-3">Total number of Clients.</p>

            </div>
            <div id="support-chart"></div>
            <div class="card-footer bg-warning text-white">
                <div class="row text-center">
                    <div class="col">
                        <h4 class="m-0 text-white">{{ number_format( $totalbdl - $totalCaisse,2,'.',',' )}} DA</h4>
                        <span>Créance</span>
                    </div>
                    <div class="col">
                        <h4 class="m-0 text-white">{{ number_format( $credit[0]->total,2,'.',',') }} DA</h4>
                        <span>Dettes</span>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

      
  
  
  
  
    </div>
  
    <div class="row  m-2">
  
      <div id="cont" class="col-md-8" style="overflow: scroll">
  
  
      </div>

      <div class=" col-md-4">

        <div class="  w-100   "  style="height: 110px; ">
            <div class="card card-stats mb-4 mb-xl-0" style=" background: linear-gradient(45deg,#4099ff,#73b4ff);">
              <div class="card-body text-white">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase  mb-0">Caisse</h5>
                    <span class="h2 font-weight-bold mb-0">{{ number_format($totalCais+$credit[0]->total,2,'.',',')  }} DA </span>
                  </div>
                 
                </div>
               
              </div>
            </div>
          </div>
        
          <div class="w-100   "  style="height: 110px"> 
            <div class="card card-stats mb-4 mb-xl-0" style=" background: linear-gradient(45deg,#2ed8b6,#59e0c5)">
              <div class="card-body text-white">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase  mb-0">Encaissemets</h5>
                    <span class="h2 font-weight-bold mb-0">{{ number_format($enc,2,'.',',') }} DA</span>
                  </div>
                  
                </div>
              
              </div>
            </div>
          </div>
        
          <div class="w-100  " style="height: 110px">
            <div class="card card-stats mb-4 mb-xl-0" style=" background: linear-gradient(45deg,#FFB64D,#ffcb80);">
              <div class="card-body text-white">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase  mb-0">Reglement de dépenses</h5>
                    <span class="h2 font-weight-bold mb-0">{{ number_format($reg,2,'.',',') }} DA</span>
                  </div>
                
                </div>
              
              </div>
            </div>
          </div>

          <div class="w-100 "  style="height: 110px">
            <div class="card card-stats mb-4 mb-xl-0" style="    background: linear-gradient(45deg,#FF5370,#ff869a);
            ">
              <div class="card-body text-white">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase  mb-0">Dettes</h5>
                    <span class="h2 font-weight-bold mb-0"> {{ number_format( $credit[0]->total,2,'.',',') }} DA</span>
                  </div>
                
                </div>
              
              </div>
            </div>
          </div>
       
    </div>
</div>




  
    
    <div class="row m-2 mt-4  ">
      <div class=" card col-md-6 p-0" >
        <div class="card-header bg-info text-white"><h3>Bls Chart</h3></div>
        <div class="card-body" >
            <div class="chart-container pie-chart">
                <canvas id="Pay" width="500" height="400" style="max-height: 200px"></canvas>
            </div>
        </div>

        
      
     </div>


          <div class="card col-md-6  p-0">
            <div class="card-header bg-info text-white"><h3>Caisse Chart</h3></div>
            <div class="card-body" >
                <div class="chart-container pie-chart">
                    <canvas id="doughnut_chart" style="max-height: 200px"></canvas>
                </div>
            </div>
           





          </div>

  
  </div>

  

  
  
           
        
    
  </div>   
  
  
  





@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

$(document).ready(function(){

  var userData = <?php echo json_encode($salesData)?>;
  var userData2 = <?php echo json_encode($salesData2)?>;

  var data = userData

  const date = new Date();

  console.log(userData);
  console.log(userData2); 


   Highcharts.chart('cont', {
       title: {
           text: 'Sales in '+date.getFullYear()
       },
       subtitle: {
           text: ''
       },
       xAxis: {
           categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep',
               'Oct', 'Nov', 'Dec'
           ]
       },
       yAxis: {
           title: {
               text: 'Amount of Slaes'
           }
       },
       legend: {
           layout: 'vertical',
           align: 'right',
           verticalAlign: 'middle'
       },
       plotOptions: {
           series: {
               allowPointSelect: true
           }
       },
       series: [{
           name: 'Encaissements',
           data:userData
       },
       {
           name: 'Règlemnts',
           data:userData2
       }
      ],
       responsive: {
           rules: [{
               condition: {
                   maxWidth: 500
               },
               chartOptions: {
                   legend: {
                       layout: 'horizontal',
                       align: 'center',
                       verticalAlign: 'bottom'
                   }
               }
           }]
       }
   });

  });
   

</script>

<script>
  $(document).ready(function(){
    var  comp =  <?php echo json_encode($enc)?>;
    var pen =  <?php echo json_encode($reg)?>;

    let barchart = new Chart('doughnut_chart',{
        type:'doughnut',
        data:{
            labels:['Encaissements','Réglements'],
            datasets: [
                {
                    label:'Points',
                    backgroundColor:['#00FF00','#FF0000'],
                    data:[comp,pen]
                }
            ]
        }
    })

    var  comp =  <?php echo json_encode($countP)?>;
    var pen =  <?php echo json_encode($countN)?>;

    let barchart2 = new Chart('Pay',{
        type:'doughnut',
        data:{
            labels:['Payés','Non Payés'],
            datasets: [
                {
                    label:'Points',
                    backgroundColor:['#4169E1','#FFA500'],
                    data:[comp,pen]
                }
            ]
        }
    })

   

  })

</script>