<?php

namespace App\Http\Controllers;
use App\Models\Caisse;
use App\Models\Clientcredit;

use App\Models\Facture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Bldetails;
use Illuminate\Support\Str;


use App\Models\Bl;
use App\Models\Caisdetails;
use App\Models\Client;



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

       $caisse = Caisse::with('user')->orderBy('created_at','DESC')->paginate(10);
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

       public function store2()
       {
       
        
         $caisse = new Caisse();

       
         if(request('Type') == "Reglement de depenses")

         {
          if(request('Treg' == "Autre"))
          {
            $caisse->Designation = request('Des');
          }

          else
          {
            $Crclient = Clientcredit::with('client')->find(request("Client"));
           

            if(request('Price') > $Crclient->Amount )
            {
              error_log('/******/////');
              return response()->json([
                "Error"=>$Crclient->Amount,
                
              
              ]);

            }

            else
            {
              $Crclient->Amount = $Crclient->Amount - request('Price');
              $Crclient->save();

              $caisse->Designation = "Remboursement Client ".$Crclient->client->Name;
            }


          }
          $caisse->Operation = "Reglement de depenses";
         
          $caisse->Amount = request('Price');
         $caisse->UserId = Auth::id();
         $caisse->ClientId = 0;
         error_log('//////////////'); 
        
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
         else
         {
          $caisse->Operation = "Encaissement de Facture/Bl";

          $Bls = request('Bls');

          $credit = Clientcredit::where("ClientId",request('Client'))->get();

         
          if(count($credit) > 0)
          {
            $payment = request('Price') + $credit[0]->Amount;
          }

          else{
            $payment = request('Price');

          }
          
       
          foreach($Bls as $Bl)
          {
            error_log('in Bls');

            $total = 0;
            $cais = Caisse::where('Designation',$Bl)->get();
            $bds = Bldetails::where('Bl_id',$Bl)->get();
           
          
            foreach($bds as $bd)
            {
             
              $total = $total + ($bd->Price_HT *  $bd->Quantity);
             

            }

           

            if($payment >= ($total - $cais[0]->Amount))
            {
             error_log('//////////////////////');
              $payment = $payment - (($total - $cais[0]->Amount));

              $cdetails = new Caisdetails();
              $cdetails->Bl_id = $Bl;
              $cdetails->Caisse_id = $cais[0]->id;
              $cdetails->Amount = ($total - $cais[0]->Amount);
              $cdetails->UserId = Auth::id();
              $cdetails->save();



              $cais[0]->Amount = $cais[0]->Amount + ($total - $cais[0]->Amount);

              $cais[0]->save();

             
             

            }
            else{

            
             
              $cais[0]->Amount = $cais[0]->Amount + $payment;
            
              error_log('/////////'.$cais[0]->Amount);
              $cais[0]->save();
              
             
             
              $caisses = Caisse::with('user')->orderBy('created_at','DESC')->get();

              $cdetails = new Caisdetails();
            
              $cdetails->Bl_id = $Bl;
            
              $cdetails->Caisse_id = $cais[0]->id;
              $cdetails->Amount =  $payment;
              $cdetails->UserId = Auth::id();
              $cdetails->save();

              if(count($credit) > 0)
         {
          $credit[0]->Amount = 0;
          $credit[0]->save();
         }
        
       
       
         $user =  Auth::id();

         
     
      

         return response()->json([
           "user"=>$user,
           "caisses" => $caisses
         
         ]);

            }

          }


         }



         if(count($credit) > 0)
         {
          $credit[0]->Amount = $payment;
          $credit[0]->save();
         }
         else
         {
           
         $add = new Clientcredit();
        
         $add->Amount = $payment;
         $add->ClientId = request('Client');
     
       
        $add->save();

         }



       
         
         $caisses = Caisse::with('user')->orderBy('created_at','DESC')->get();
       
       
         $user =  Auth::id();

         
     
      

         return response()->json([
           "user"=>$user,
           "caisses" => $caisses
         
         ]);


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
          else{
            $Bls = Bl::where('ClientId',request('Client'))->get();
            if(count($Bls) == 0)
            {
             
              return response()->json([
                "Error"=>"Client Has No Debt",
                
              
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

    
            }

            $caisseClient = Caisse::where('ClientId',request('Client'))->where('Operation','Encaissement de Facture/Bl')->first();
           
            if(!$caisseClient || $caisseClient->Amount < $total)
            {
              error_log('/*/*********');
              return response()->json([
                "Error"=>"Client Has No Debt",
                
              
              ]);

            }

          $debt = $caisseClient->Amount - $total;
          if($debt < request('Price'))
          {
            return response()->json([
              "Error"=>"Debt inferieur to Amount",
              
            
            ]);


          }

         $caisseClient->Amount = $caisseClient->Amount - request('Price');
         $caisseClient->save();

         $caisse->Designation = "Remboursement Client ".$client->Name;
         $caisse->ClientId = $client->id;

          



          }
         

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

        /******* Encaissement de Factures */

        /** Count Total */
        $Bls = Bl::where('ClientId',request('Client'))->get();
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

        error_log('total *-----------------* '.$total);
        $caisse = Caisse::where('ClientId',request('Client'))->first();
        if($caisse)
        {

       

        if(($caisse->Amount - $total) > 1)
        {
          error_log($caisse->Amount - $total);
          
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
          $caisse->Operation = "Encaissement de Facture/Bl";
          $caisse->Designation = "Payement de ".$client->Name;
          $caisse->Amount = $payment;
           $caisse->UserId = Auth::id();
           $caisse->ClientId = request('Client');
          
           error_log($caisse);
          
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
    $Cais->save();


    

   

    $caisse->delete();
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

         
               $items =  Bl::where('ClientId',request('Client'))
                       ->get();

                      
    $html =array();
    
    

    foreach($items as $item) {


      $Bds = Bldetails::where('Bl_id',$item->id)->get();
      $pay =  Caisse::select(
        DB::raw('SUM((Amount))  as amount'))
        ->where('Designation',$item->id)
        ->get();

        error_log('//////////////'.$pay);

      $total =0; 

      foreach( $Bds as $Bd )
      {
        $total = $total + $Bd->Price_HT *  $Bd->Quantity;

      }

      

     if( $pay[0]->amount < $total )
     {

      $opt = new option();
    

      $opt->label = "Bon N°".$item->id;
      $opt->value = $item->id;

      array_push($html,$opt);
     }

      
     
     // $html.='<option value="'.$item->id.'">Bon N°'.$item->id.'</option>';
    
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
                    
                    return view('Caisse.print',["Cais" =>$Cais , "client"=>$client]);

                   }

                   public function remob($id)
                   {
                    $Cais = Caisse::find($id);
                 
                    return view('Caisse.remboursement',["Cais" =>$Cais ]);

                   }

          




}
