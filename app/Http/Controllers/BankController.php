<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Caisdetails;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Fdetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class option {
  public $label;
  public $value;
}

class BankController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
      }

      public function index(){

        $clients = Client::orderBy('Name','ASC')->get();
        $banks = Bank::with('client')->orderBy('created_at','DESC')->get();
        $payments = Bank::select('Mode','Total_Amount')->where('Date_Enc','<=',date("Y-m-d"))->groupBy('Mode')->get();
        $total = 0 ;
        foreach ($payments as $key ) {
           $total += $key->Total_Amount;
        }
        $user = Auth::id();


        return view('Bank.index',compact(['clients','banks','total','user']));

      }

      public function factures(){

        $factures = Facture::where('ClientId',request('Client'))->where('Type','Normal')->where('Status','Not Payed')->get();
        $html =array();
        foreach($factures as $item)
        {
          $check = Caisdetails::where('Bl_id',$item->id)->get();
          if( count($check) != 0){
             continue ;
            }

            $total =0;
            $fac_d = Fdetails::where('Fac_id',$item->id)->get();
            foreach($fac_d as $detail)
            { 

              $total += $detail->Price_HT * $detail->Quantity;
               
            }
            $payed = 0;
            $fac_pay = Bank::where("Fact_num",$item->Fac_num)->get();
            foreach($fac_pay as $key)
            { 

              $payed += $key->Fact_Amount;
               
            }

            if($item->tva == "19")
            {
              $total = $total * 1.19;

            }
            else
            {
              $total = $total * 1.09;

            }


         
        $opt = new option();


        $opt->label = "Facture N°".$item->Fac_num."  <small>  TTC: ".number_format($total,2,'.',',' )." Left: "
        .number_format($total - $payed,2,'.',',' )."  </small>";
        $opt->value = $item->id;
  
        array_push($html,$opt);
         
      }


      return response()->json([
        "html" => $html
      
      ]);

      }

      public function store()
      {
        $left_amount = request('Price');



        $exist_pay = Bank::where('Mode',request('Mode')." ".request('Num'))->get();
        if(count($exist_pay) > 0)
        {
          $exist_total = 0;
          foreach($exist_pay as $item)
          {
            $exist_total = $exist_total + $item->Fact_Amount;

          }

          if( abs( request('Price') - $exist_total) > 1 && abs(request('Price') - $exist_pay[0]->Total_Amount ) < 0.001 )
          {
            $left_amount = request('Price') - $exist_total;


          }
          else{
            return response()->json([
              "error" => 'This "'.request('Mode').'" is Totaly Payed'
        
            ]);


          }

        }
      
        $factures = request('Factures');
        foreach($factures as $item)
        {
          $facture = Facture::find($item);
          $factureDetails = Fdetails::where('Fac_id',$item)->get();
          $total = 0 ;
          /* *      Calculate Total Faxture     */
          foreach($factureDetails as $fd)
          {
            $total = $total + ($fd->Quantity * $fd->Price_HT);

          }
          if($facture->tva == "19")
          {
            $total = $total * 1.19;

          }
          else
          {
            $total = $total * 1.09;

          }
           /* *    END  Calculate Total Faxture     */
         
           /** Check If there is payments before */

           $payments = Bank::where('Fact_num',$facture->Fac_num)->get();

           $new_pay = new Bank();
           $new_pay->ClientId = request('Client');
           $new_pay->Fact_num = $facture->Fac_num;
           $user = Auth::id(); 
           $role = Auth::user()->role;

          
           $new_pay->Mode = request('Mode')." ".request('Num');
           $new_pay->Date_enc = request('Date');
           $new_pay->UserId = Auth::id();
           $new_pay->Total_Amount = request('Price');

           /** If First payment */
             if(count($payments) == 0 )
             {
              
               if($left_amount > $total)
               {
                $new_pay->Fact_Amount = $total;
                $facture->Status = "Payed";
                $facture->save();
                $left_amount = $left_amount - $total;

               }
               else
               {
                $new_pay->Fact_Amount = $left_amount;
                $new_pay->save();

                $banks = Bank::with('client')->orderBy('created_at','DESC')->get();
                $payments_b = Bank::select('Mode','Total_Amount')->where('Date_Enc','<=',date("Y-m-d"))->groupBy('Mode')->get();
                $total = 0 ;
                foreach ($payments_b as $key ) {
                   $total += $key->Total_Amount;
                }

                
                return response()->json([
                  "user" => $user,
                  "banks" => $banks,
                  "total" => $total,
                  "role" => $role
            
                ]);
                



               }


             }
        /**  End of first payment       */

        /**  if there are payment before  */
             else
             {
              $total_payed = 0;
              foreach($payments as $pay)
              {
                 $total_payed = $total_payed + $pay->Fact_Amount;

              }

              if($left_amount > ($total - $total_payed))
              {
                $new_pay->Fact_Amount = $total - $total_payed;
                $facture->Status = "Payed";
                $facture->save();
                $left_amount = $left_amount -($total - $total_payed);


              }
              else
              {
                $new_pay->Fact_Amount = $left_amount;
                $new_pay->save();

                $banks = Bank::with('client')->get();
                $payments_b = Bank::select('Mode','Total_Amount')->where('Date_Enc','<=',date("Y-m-d"))->groupBy('Mode')->get();
                $total = 0 ;
                foreach ($payments_b as $key ) {
                   $total += $key->Total_Amount;
                }

                
                return response()->json([
                  "user" => $user,
                  "banks" => $banks,
                  "total" =>$total,
                  "role" => $role
            
                ]);





              }





             }
        
             $new_pay->save();

        }

        

        $banks = Bank::with('client')->orderBy('created_at','DESC')->get();
        $payments_b = Bank::select('Mode','Total_Amount')->where('Date_Enc','<=',date("Y-m-d"))->groupBy('Mode')->get();
        $total = 0 ;
        foreach ($payments_b as $key ) {
           $total += $key->Total_Amount;
        }

        
        return response()->json([
          "user" => $user,
          "banks" => $banks,
          "total" => $total,
          "role" => $role
    
        ]);
       


      }

      public function destroy(){
        $bank = Bank::findOrfail(request('id'));
        $facture = Facture::where('Fac_num',$bank->Fact_num)->first();
        $facture->Status = "Not Payed";
        $facture->save();
       
    
        $bank->delete();
        $payments_b = Bank::select('Mode','Total_Amount')->where('Date_Enc','<=',date("Y-m-d"))->groupBy('Mode')->get();
        $user =  Auth::id();
        $role = Auth::user()->role;

  
         return response()->json([
          "user"=>$user,
          "banks" => $payments_b,
          "role" => $role
        ]);
    }


 public function print($id)
                   {
                    $bank = Bank::with('client')->find($id);
                    
                    
                    return view('Bank.print',["bank" =>$bank ]);

                   }


}
