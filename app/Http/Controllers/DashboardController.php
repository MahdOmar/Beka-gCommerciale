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
  
  ->groupBy('bls.ClientId')
  ->get();


/************************************************** */

  ///********************************* */

  $total_payed = 0;
  $total_tax = 0;
  $dettes=0;
      foreach($Payments as $cais)
      {
        if ($cais->ClientId == 2)
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
        if ($item->ClientId == 2)
        {
          $total_payed = $total_payed + $item->Total_Amount;
          
        }
      }

      $total_left = 0;
      foreach ($rembo as $item) {
        if($item->ClientId == 2)
        {
          $dettes -= $item->total;
          $total_payed -= $item->total;


        }
      }


      foreach($tbls as $bl)
      {
        if($bl->ClientId == 2)
        {
          $total_left = $bl->total + $total_tax - $total_payed;
          
        }
      }

      if($total_left < 0)
      {
        $dettes += -$total_left;
      

      }










        /*********************************** */


/*********************************************** */


        return view('Dashboard.index',["bls" => $Bls,
        "Bds" => $Bds , "Payments" => $Payments , 'Facture' => $Facture, 'tbls' =>$tbls,
        "Normal" => $Normal , 'Proforma' => $Proforma , "Clients" =>$clients,'rembo' =>$rembo,
        "credit" => $credits,'banks' => $banks, "salesData" => $datas ,'salesData2' => $datas2] );

      }
   
}
