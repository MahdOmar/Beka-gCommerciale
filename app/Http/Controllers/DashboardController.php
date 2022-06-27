<?php

namespace App\Http\Controllers;

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
        $Facture = Bl::where('Status','!=','Not Factured')->get();

        $Normal = Facture::where('Type','Normal')->get();
        $Proforma = Facture::where('Type','!=','Normal')->get();

       $clients = Client::all();
       $credits = Clientcredit::select(
        DB::raw('SUM((Amount))  as total'))
        ->get();


        $salesData = Caisse::whereYear('created_at', date('Y'))
                                ->where('Operation','Encaissement de Facture/Bl')
                                ->select(DB::raw('sum(Amount )as amount'))
                                ->groupBy(DB::raw("Month(created_at) "))
                                ->pluck('amount');

        $salesData2 = Caisse::whereYear('created_at', date('Y'))
                                ->where('Operation','Reglement de depenses')
                                ->select(DB::raw('sum(Amount )as amount'))
                                ->groupBy(DB::raw("Month(created_at) "))
                                ->pluck('amount');     
                         
                                error_log(print_r($salesData2, TRUE) );                      

         $Months = Caisse::select(DB::raw('Month(created_at)as month'))
                                ->whereYear('created_at', date('Y'))
                                ->groupBy(DB::raw("Month(created_at) "))
                                
                                ->pluck('month');                        

                  
                     
                     $datas = array(0,0,0,0,0,0,0,0,0,0,0,0); 

                     $datas2 = array(0,0,0,0,0,0,0,0,0,0,0,0); 

                     foreach($Months as $index => $month)
                     {
                      if(count($salesData) > 0 )
                      {
                        $datas[$month-1] = $salesData[$index] ;

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

               
                     

                   




        




        return view('Dashboard.index',["bls" => $Bls,
        "Bds" => $Bds , "Payments" => $Payments , 'Facture' => $Facture,
        "Normal" => $Normal , 'Proforma' => $Proforma , "Clinets" =>$clients,
        "credit" => $credits, "salesData" => $datas ,'salesData2' => $datas2] );

      }
   
}
