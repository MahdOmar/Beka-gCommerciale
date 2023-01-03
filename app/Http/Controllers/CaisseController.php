<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Caisse;
use App\Models\Clientcredit;

use App\Models\Facture;
use App\Models\Fdetails;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Bldetails;
use Illuminate\Support\Str;


use App\Models\Bl;
use App\Models\Caisdetails;
use App\Models\Client;
use App\Models\Retour;
use Illuminate\Http\Request;
use Prophecy\Call\Call;

class option {
  public $label;
  public $value;
}
class CaisseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
      }

      public function index(){

       $caisse = Caisse::with('user')->orderBy('created_at','DESC')->get();
       $Credits = Clientcredit::all();
       $user =  Auth::id();

 
    

       

     $Clients = Client::all();
      
          return view('Caisse.index',["caisse"=>$caisse , 'user' => $user,
                                       "clients" => $Clients, "Credits" => $Credits]);
          
         
            }

            public function details($id)
            {
              $Caisses = Caisdetails::with('user')->where('Caisse_id',$id)->get();
              $client = Caisse::find($Caisses[0]->Caisse_id);
              $user = Auth::id();

              return view('Caisse.Caissedetails',["Caisses"=>$Caisses , 'user' => $user,
                                                 'client'=>$client]);



            }

        

      public function store(){
        $client = Client::find(request('Client'));


         if(request('Type') == "Reglement de depenses")

        
         {
          $caisse = new Caisse();
          if(request('Treg')  == "Autre")
          {
          
            $caisse->Designation = request('Des');
            $caisse->ClientId = 0;
          }
     /**//////******* Remboussemet Client      */ */

          else{
            $caisses_pay = Caisse::where('Operation','!=','Reglement de depenses')->where('ClientId',request('Client'))->get(); 
            $banks = Bank::where('ClientId',request('Client'))->get();
            $rembo = Caisse::select( DB::raw('SUM(Amount)  as total'))->where('Designation',"Remboursement Client ".$client->Name)->get(); 
            $return = Retour::select( 'ClientId',DB::raw('SUM(Amount)  as rn'))->groupBy('ClientId')->get(); 

            $Bls = Bl::select(
              'bls.ClientId',
               
              
           
              DB::raw('SUM((bldetails.Price_Ht * bldetails.Quantity))  as total'))
            
              ->leftJoin('bldetails', 'bldetails.Bl_id', '=', 'bls.id')
              ->where('bls.Status','Not Factured')
              ->where('bls.ClientId',request('Client'))
              ->get();

              $Bls_fac = Bl::select(
                'bls.ClientId',
                 
                DB::raw('SUM((bldetails.Price_Ht * bldetails.Quantity))  as total'))
              
                ->leftJoin('bldetails', 'bldetails.Bl_id', '=', 'bls.id')
                ->where('bls.Status','!=','Not Factured')
                ->where('bls.ClientId',request('Client'))
                ->get();
              
              $total_payed = 0;
              $total_tax = 0;
          foreach($caisses_pay as $cais)
          {
            
              $total_payed += $cais->Amount;
              if($cais->Operation == "Encaissement de Facture"){

              
              $caisdetails = \App\Models\Caisdetails::where('Caisse_id',$cais->id)->get();
              foreach($caisdetails as $details)
              {
                $total_tax += $details->Amount /1.01 * 0.01;

                
              }
            }
            
          }
          foreach($banks as $bank)
          {
            
              $total_payed = $total_payed + $bank->Fact_Amount;
             
              
            
          }
        
          $total_left = 0;
          $total_credit = 0;
        
          $total_left = $Bls[0]->total + $Bls_fac[0]->total + $Bls_fac[0]->total * 0.19  + $total_tax - $total_payed;

          foreach($return as $rtn)
              {
                if($rtn->ClientId == request('Client') ){
                  $total_left -= $rtn->rn;

                }
              }
          

          if($total_left < 0)
          {
            $total_credit = -$total_left;
            $total_left = 0;
          

          }

         

           
            if(abs(request('Price') - ($total_credit - $rembo[0]->total) > 1 ))
            {
              return response()->json([
                "Error"=>"Montant superieur a Credit",
                
              
              ]);

            }

         $caisse->Designation = "Remboursement Client ".$client->Name;
         $caisse->ClientId = $client->id;

          



          }

          /**//////*******  END Remboussemet Client      */ */
         

        $caisse->Operation = "Reglement de depenses";
         
        $caisse->Amount = request('Price');
         $caisse->UserId = Auth::id();
        
        
         $caisse->save();
         $caisses = Caisse::with('user')->orderBy('created_at','DESC')->get();

         $user =  Auth::id();

         
         $Credits = Clientcredit::all();
      

         return response()->json([
           "user"=>$user,
           "caisses" => $caisses,
           "Credits" => $Credits
         
         ]);
        

        }

        /******* Autre Encaissement */
        if(request('Type') == "Autre Encaissement")
        {

        $caisse = new Caisse();
        $caisse->Operation = request('Type');
        $caisse->Designation = request('Des');
        $caisse->Amount = request('Price');
        $caisse->UserId = Auth::id();
        $caisse->ClientId = 0;
        $user = Auth::id();
        
        
         $caisse->save();
         $caisses = Caisse::with('user')->orderBy('created_at','DESC')->get();

                
         return response()->json([
           "user" => $user,
           "caisses" => $caisses
     
         ]);

        }




        /******* End Autre Encaissement */


        /******* Encaissement de Factures */

        if(request('Type') == "Encaissement de Bl")
        {

        /** Count Total */
        $Bls = Bl::where('ClientId',request('Client'))->where('Status','Not Factured')->get();
        if(count($Bls) == 0)
        {
         
          return response()->json([
            "Error"=>"Client Has No Bl",
            
          
          ]);
        }
        
        $total = 0;
        foreach($Bls as $Bl)
        {

        
        
          $bds = Bldetails::where('Bl_id',$Bl->id)->get();
         
        
          foreach($bds as $bd)
          {
           
            $total = $total + ($bd->Price_HT *  $bd->Quantity);
           

          }


        }/** End Count Total */

        $caisse = Caisse::where('ClientId',request('Client'))->where('Operation','Encaissement de Bl')->first();
        if($caisse)
        {

       

        if(($caisse->Amount - $total) > 1)
        {
          
          return response()->json([
            "Error"=>"Client Has No Credits",
            
          
          ]);

        }
      }

     //   $credit = Clientcredit::where("ClientId",request('Client'))->get();


       /*** Check if Has Credit */
        // if(count($credit) > 0)
        // {
        //   $payment = request('Price') + $credit[0]->Amount;
        //   $credit[0]->Amount = 0;
        //   $credit[0]->save();
      
        // }

        // else{
        //   $payment = request('Price');

        // }

        $payment = request('Price');
     
        if($caisse){

          $caisse->Amount = $caisse->Amount + $payment;
          
          $caisse->save();
          
        }
        else{
          $caisse = new Caisse();
          $caisse->Operation = "Encaissement de Bl";
          $caisse->Designation = "Payement de ".$client->Name;
          $caisse->Amount = $payment;
           $caisse->UserId = Auth::id();
           $caisse->ClientId = request('Client');
          
          
           $caisse->save();
        }

        


          /************Check if there is Money left */
          // if($caisse->Amount - $total > 0.00001)
          // {
          //   if(count($credit) > 0)
          //   {
              
             
          //     $credit[0]->Amount = $caisse->Amount - $total;
          //     $credit[0]->save();
    
          //   }
          //   else{
          //    $add = new Clientcredit();
           
          //    $add->Amount = $caisse->Amount - $total;
          //    $add->ClientId = request('Client');
         
           
          //   $add->save();
          //   }



          // }
          
        /****** End check ********* */
 
         /**** Save Caisse Details */
 
          $cd =  new Caisdetails();
          $cd->Bl_id = 0;
          $cd->Caisse_id = $caisse->id;
          $cd->Amount = $payment;
          $cd->UserId = Auth::id();
 
          $cd->save();
         
         /**** End Caisse Details */
 
        
 
          
          $caisses = Caisse::with('user')->orderBy('created_at','DESC')->get();
 
          $user =  Auth::id();
 
          
          $Credits = Clientcredit::all();
       
 
          return response()->json([
            "user"=>$user,
            "caisses" => $caisses,
            "Credits" => $Credits
          
          ]);
        }
        else
        {
          $factures = request('Bls');
          
        $left_amount = request('Price');

        $caisse = new Caisse();
        $caisse->Operation = "Encaissement de Facture";
        $caisse->Designation = "Payement de ".$client->Name." Facture: ";

        foreach($factures as $item)
        {


          $facture = Facture::find($item);


          $caisse->Designation .= $facture->Fac_num.", ";
        }
        $caisse->Amount = request('Price');
        $caisse->UserId = Auth::id();
        $caisse->ClientId = request('Client');
        $caisse->save();

         $user = Auth::id();



     
        foreach($factures as $item)
        {


          $facture = Facture::find($item);


          $caisse->Designation .= $facture->Fac_num.", ";


          $factureDetails = Fdetails::where('Fac_id',$item)->get();
          $total = 0 ;

          /* *      Calculate Total Faxture     */
          foreach($factureDetails as $fd)
          {
            $total = $total + ($fd->Quantity * $fd->Price_HT);

          }
          $total = $total + $total * 0.19;
          $total = $total + $total * 0.01;
           /* *    END  Calculate Total Faxture     */
         
           /** Check If there is payments before */

           $payments = Caisdetails::where('Bl_id',$facture->id)->get();

           $new_pay = new Caisdetails();
           $new_pay->Bl_id = $facture->id;
           $new_pay->Caisse_id = $caisse->id;
           $new_pay->UserId = Auth::id();


          

           /** If First payment */
             if(count($payments) == 0 )
             {
              
               if($left_amount > $total)
               {

              
                $new_pay->Amount = $total;
                $facture->Status = "Payed";
                $facture->save();
                $left_amount = $left_amount - $total;

               }
               else
               {
               
                $new_pay->Amount = $left_amount;
                $new_pay->save();

                $caisses = Caisse::with('user')->orderBy('created_at','DESC')->get();

                
                return response()->json([
                  "user" => $user,
                  "caisses" => $caisses
            
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
                 $total_payed = $total_payed + $pay->Amount;

              }

              if($left_amount > ($total - $total_payed))
              {
               
                $new_pay->Amount = $total - $total_payed;
                $facture->Status = "Payed";
                $facture->save();
                $left_amount = $left_amount -($total - $total_payed);


              }
              else
              {
                $new_pay->Amount = $left_amount;
                $new_pay->save();

                $caisses = Caisse::with('user')->orderBy('created_at','DESC')->get();

                
                return response()->json([
                  "user" => $user,
                  "caisses" => $caisses
            
                ]);




              }





             }
        
             $new_pay->save();

        }


        

        $caisses = Caisse::with('user')->orderBy('created_at','DESC')->get();


        
        return response()->json([
          "user" => $user,
          "caisses" => $caisses
    
        ]);
       




        }

 
 
        }
        

      
  



       public function showData(){

          
        $caisse = Caisse::find(request('id'));
       
         return $caisse;
      

     }

     public function showData2(){

          
      $caisse = Caisdetails::find(request('id'));
     
       return $caisse;
    

   }


     public function update(){

          

      $caisse = Caisse::find(request('id'));
      if(Str::contains($caisse->Designation, 'Remboursement'))
      {
        $Bls = Bl::where('ClientId',$caisse->ClientId)->get();
        $total = 0;
        foreach($Bls as $Bl)
        {

          $bds = Bldetails::where('Bl_id',$Bl->id)->get();
         
        
          foreach($bds as $bd)
          {
           
            $total = $total + ($bd->Price_HT *  $bd->Quantity);
           

          }


        }

        $caisseClient = Caisse::where('ClientId',$caisse->ClientId)->first();

        $debt = ($caisseClient->Amount + $caisse->Amount) - $total ;
       
        if($debt < request('Price'))
        {
          return response()->json([
            "error"=>"Debt inferieur to Amount",
            
          
          ]);


        }

        $caisseClient->Amount = $caisseClient->Amount + $caisse->Amount - request('Price');
        $caisse->Amount = request('Price');
        $caisseClient->save();





      }
      else{
        $caisse->Amount = request('Price');
        $caisse->Designation = request('Des');


      }
        
       $caisse->save();
      
       $caisses = Caisse::with('user')->orderBy('created_at','DESC')->get();

     $user =  Auth::id();
     
      

      return response()->json([
        "user"=>$user,
        "caisses" => $caisses
      
      ]);

    }

    public function update2(){

      $caisseD = Caisdetails::find(request('id'));

      $caisse = Caisse::find($caisseD->Caisse_id);

      $caisse->Amount = $caisse->Amount - $caisseD->Amount + request('Price');

      $caisseD->Amount = request('Price');

      $caisse->save();
      $caisseD->save();

          

       $caisses = Caisdetails::with('user')->where('Caisse_id',$caisseD->Caisse_id)->orderBy('created_at','DESC')->get();

     $user =  Auth::id();
     
      

      return response()->json([
        "user"=>$user,
        "caisses" => $caisses,
        "client" => $caisse
      
      ]);

    }






    public function destroy(){
      $caisse = Caisse::findOrfail(request('id'));
     
  
      $caisse->delete();
      $caisses = Caisse::with('user')->orderBy('created_at','DESC')->get();

      $user =  Auth::id();
    

       return response()->json([
        "user"=>$user,
        "caisses" => $caisses
      ]);
  }


  public function destroyDetails(){
    $caisse = Caisdetails::findOrfail(request('id'));

    $Cais = Caisse::find( $caisse->Caisse_id);
    $Cais->Amount =  $Cais->Amount - $caisse->Amount;
    

    $caisse->delete();

    $caissesD = Caisdetails::where('Caisse_id',$Cais->id)->get();
    if(count($caissesD) != 0){
      $Cais->save();

    }
    else
    {
      $Cais->delete();


    }


    $caisses = Caisse::with('user')->orderBy('created_at','DESC')->get();

    $user =  Auth::id();
  

     return response()->json([
      "user"=>$user,
      "caisses" => $caisses
    ]);
}




  public function filter()
          {
            $user =  Auth::id();
           

            if(request('date') == "tod")
            {
              $today = Carbon::today();
              
              $caisses = Caisse::with('user')->whereDate('created_at',"=",$today)->get();
    
              return response()->json([
                "user"=>$user,
                "caisses" => $caisses
              
              ]);
            }
    
            else if(request('date') == "yes")
            {
              $yesterday = Carbon::yesterday();

              
              $caisses = Caisse::with('user')->whereDate('created_at',"=",$yesterday)->get();

    
              return response()->json([
                "user"=>$user,
                "caisses" => $caisses
              
              ]);
            }
            else if(request('date') == "lw")
            {
    
              $date = Carbon::now()->subDays(7);
              $caisses = Caisse::with('user')->whereBetween('created_at',  [$date,Carbon::now()])->get();
    
              return response()->json([
                "user"=>$user,
                "caisses" => $caisses
              
              ]);
    
    
            }
    
            else if(request('date') == "lm")
            {
              $date = Carbon::now()->subDays(30);
              $caisses = Caisse::with('user')->whereBetween('created_at',  [$date,Carbon::now()])->get();
    
              return response()->json([
                "user"=>$user,
                "caisses" => $caisses
              
              ]);
    
    
            }
            else{
    
              $caisses = Caisse::with('user')->orderBy('created_at', 'DESC')->get();
              return response()->json([
                "user"=>$user,
                "caisses" => $caisses
              
              ]);
    
    
            }
    
    
    
    
          }

           public function bls()
            {

         
              $factures = Facture::where('ClientId',request('Client'))->where('Type','Normal')->where('Status','Not Payed')
             
              ->get();

        $html =array();
        foreach($factures as $item)
        {
          $check = Bank::where('Fact_num',$item->Fac_num)->get();
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
              $fac_pay = Caisdetails::where("Bl_id",$item->id)->get();
              foreach($fac_pay as $key)
              { 

                $payed += $key->Amount;
                 
              }

            
            
        $opt = new option();
        $total = $total + $total * 0.19;
        $total += $total * 0.01;


        $opt->label = "Facture N°".$item->Fac_num."   <small>  TTC: ".number_format($total,2,'.',',' )." Left: "
        .number_format($total - $payed,2,'.',',' )."</small>";
        $opt->value = $item->id;
  
        array_push($html,$opt);
         
      }


      return response()->json([
        "html" => $html
      
      ]);



            }


            public function CredisClients(){

            
              
            $Clients = Client::all();

             
            $cls =' <option value="" disabled selected>Selectionner Client</option>';

            

    
    
            foreach($Clients as $item) {
            
              $cls .= '<option value="'.$item->id.'">'.$item->Name.'</option>';
             
        
            
            
            }

            return response()->json([
              "html" => $cls
            
            ]);
                 
                
                   }

                   public function print($id)
                   {
                    $Cais = Caisdetails::find($id);
                    $caisse = Caisse::find($Cais->Caisse_id);
                    $client = Client::find( $caisse->ClientId);
                    
                    return view('Caisse.print',["Cais" =>$Cais , "client"=>$client,"caisse" =>$caisse]);

                   }

                   public function remob($id)
                   {
                    $Cais = Caisse::find($id);
                 
                    return view('Caisse.remboursement',["Cais" =>$Cais ]);

                   }

          




}
