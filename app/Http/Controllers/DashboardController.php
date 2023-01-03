<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

use App\Models\Bl;
use App\Models\Client;
use App\Models\Bldetails;
use App\Models\Caisse;
use App\Models\Facture;
use App\Models\Fdetails;
use App\Models\Clientcredit;
use App\Models\Retour;
use Illuminate\Support\Facades\DB;



class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
      }

      public function index(){

        $Bls = Bl::with('user')->with('client')->orderBy('created_at','DESC')->get();
        $Bds = Bldetails::all();
        $Payments = Caisse::all();
        $banks = DB::table('banks')->select('Total_Amount','Mode','ClientId','Date_Enc')->groupBy('Mode')->get();
        $return = Retour::select( 'ClientId',DB::raw('SUM(Amount)  as rn'))->groupBy('ClientId')->get(); 

        $Facture = Bl::where('Status','!=','Not Factured')->get();
      

        $Normal = Facture::where('Type','Normal')->get();
        $Proforma = Facture::where('Type','!=','Normal')->get();

       $clients = Client::all();
       $credits = Clientcredit::select(
        DB::raw('SUM((Amount))  as total'))
        ->get();


        $salesData = Caisse::whereYear('created_at', date('Y'))
                                ->where('Operation','Encaissement de Facture')
                                ->orWhere('Operation','Encaissement de Bl')

                                ->select(DB::raw('sum(Amount )as amount'))
                                ->groupBy(DB::raw("Month(created_at) "))
                                ->pluck('amount');

        $salesDataBank = Bank::whereYear('created_at', date('Y'))
                                
                                ->select(DB::raw('sum(Total_Amount )as amount'))
                                ->groupBy(DB::raw("Month(created_at) "))
                                ->pluck('amount');  

        $salesData2 = Caisse::whereYear('created_at', date('Y'))
                                ->where('Operation','Reglement de depenses')
                                ->select(DB::raw('sum(Amount )as amount'))
                                ->groupBy(DB::raw("Month(created_at) "))
                                ->pluck('amount');     
                         

         $Months = Caisse::select(DB::raw('Month(created_at)as month'))
                                ->whereYear('created_at', date('Y'))
                                ->groupBy(DB::raw("Month(created_at) "))
                                
                                ->pluck('month');      
              if(count($Months) == 0){
                $Months = Bank::select(DB::raw('Month(created_at)as month'))
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw("Month(created_at) "))
                
                ->pluck('month');



              }                                    

                  
                     
                     $datas = array(0,0,0,0,0,0,0,0,0,0,0,0); 

                     $datas2 = array(0,0,0,0,0,0,0,0,0,0,0,0); 
                   

                     foreach($Months as $index => $month)
                     {
                      if(count($salesData) > 0  && count($salesDataBank) > 0 )
                      {

                        $datas[$month-1] = $salesData[$index] + $salesDataBank[$index] ;

                      }
                      else if(count($salesData) > 0)
                      {

                        $datas[$month-1] = $salesData[$index]  ;

                      }
                      else if(count($salesDataBank) > 0)
                      {
                        $datas[$month-1] = $salesDataBank[$index]  ;

                      }

                      if(count($salesData2) > 0 )
                      {
                        $datas2[$month-1] = $salesData2[$index] ;

                      }


                     }
                     
               /*      foreach($Months as $index => $month)
                     {
                      if(count($salesData2) > 0 && count($salesData) > 0)
                      {
                        $datas[$month-1] = $salesData[$index] - $salesData2[$index] ;

                      }
                      else if(count($salesData) > 0){
                        $datas[$month-1] = $salesData[$index] ;

                      }
                      else if(count($salesData2) > 0){
                        $datas[$month-1] = -$salesData2[$index] ;

                      }
                      else
                      {
                        $datas[$month-1] = 0;

                      }
                       
                        
              
                       
                      
                     }*/
 
               
                     

                   


$rembo = Caisse::select( 'ClientId',DB::raw('SUM(Amount)  as total'))->where('Operation','Reglement de depenses')->groupBy('ClientId')->get(); 

$tbls = Bl::select(
  'bls.ClientId',

  DB::raw('SUM((bldetails.Price_Ht * bldetails.Quantity))  as total'))

  ->leftJoin('bldetails', 'bldetails.Bl_id', '=', 'bls.id')
  ->where('bls.Status','Not Factured')
  ->groupBy('bls.ClientId')
  ->get();

  $tbls_fac = Bl::select(
  'bls.ClientId',

  DB::raw('SUM((bldetails.Price_Ht * bldetails.Quantity))  as total'))

  ->leftJoin('bldetails', 'bldetails.Bl_id', '=', 'bls.id')
  ->where('bls.Status','!=','Not Factured')
  ->groupBy('bls.ClientId')
  ->get();


/************************************************** */

  ///********************************* */

  $total_romb = 0;
  $creances = 0;
  $left = 0;
  $dettes = 0;

  foreach ($clients as $client) {
    $total_payed = 0;
    $total_tax = 0;
    $total_left = 0;
    $total_romb = 0;
        foreach($Payments as $cais)
        {
          if ($cais->ClientId == $client->id)
          {
            if($cais->Operation == "Encaissement de Facture" || $cais->Operation == "Encaissement de Bl")
            {
              $total_payed += $cais->Amount;

            }
            if($cais->Operation == "Encaissement de Facture")
          {
            $caisdetails = \App\Models\Caisdetails::where('Caisse_id',$cais->id)->get();
            foreach($caisdetails as $details)
            {
              $total_tax += $details->Amount /1.01 * 0.01;

              
            }
          }
          }
        }

        foreach($banks as $item)
        {
          if ($item->ClientId == $client->id)
          {
            $total_payed = $total_payed + $item->Total_Amount;
            
          }
        }

        foreach ($rembo as $item) {
          if($item->ClientId == $client->id )
          {
            $total_romb += $item->total;


          }
        }

        $total_payed -= $total_romb;


         $total_bls =0;

        foreach($tbls as $bl)
        {
          if($bl->ClientId == $client->id)
          {
            $total_bls += $bl->total ;
            
          }

         
        }

        foreach($tbls_fac as $bl)
        {
          if($bl->ClientId == $client->id)
          {
            $total_bls += $bl->total;
            
          }

         
        }


        $total_left = $total_bls + $total_tax - $total_payed;


        foreach($return as $rtn)
            {
              if($rtn->ClientId == $client->id ){
                $total_left -= $rtn->rn;

              }
            }




        if($total_left < 0)
        {
          $dettes += -$total_left;
        

        }
        else{
          $creances += $total_left;
          error_log("Creances: ".$creances);


        }
        

       




}
   






        /*********************************** */


/*********************************************** */


        return view('Dashboard.index',["bls" => $Bls,
        "Bds" => $Bds , "Payments" => $Payments , 'Facture' => $Facture, 'tbls' =>$tbls,'tbls_f' =>$tbls_fac,
        "Normal" => $Normal , 'Proforma' => $Proforma , "Clients" =>$clients,'rembo' =>$rembo,
        "credit" => $credits,'banks' => $banks, "salesData" => $datas ,'salesData2' => $datas2,
        'return'=>$return] );

      }
   
}
