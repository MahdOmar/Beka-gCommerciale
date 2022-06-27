<?php

namespace App\Http\Controllers;
use App\Models\Bl;
use App\Models\Client;
use App\Models\Bldetails;
use App\Models\Caisdetails;
use App\Models\Caisse;
use App\Models\Facture;
use App\Models\Fdetails;
use App\Models\Fdbld;
use App\Models\Fbl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class BlController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
      }

      public function index(){

        $Bls = Bl::with('user')->with('client')->orderBy('created_at','DESC')->paginate(10);
        $Bds = Bldetails::all();
        $Payments = Caisse::all();
 
        $Clients = Client::all();
        

        foreach($Bls as $bl)
        {
          $total = 0;
          foreach($Bds as $bd)
          {
            if($bd->Bl_id == $bl->id)
            {
              $total = $total + $bd->Price_HT *  $bd->Quantity;
            }
          }

          foreach ($Payments as $pay)
          {
            if ($pay->Designation == $bl->id)
            {
          
              
              if($pay->Amount == $total)
              {
               
                   error_log("payé");

              }
              else{
                
                error_log('non payé');
              }
            }
            
          }
          

        }

       

        $user = Auth::id();
      
          return view('BL.index',["bls" => $Bls, 'user' => $user ,'clients' => $Clients,
                                  "Bds" => $Bds , "Payments" => $Payments] );
          
         
            }

            public function store(){ 

              $Bl =new Bl() ;

              $record = Bl::latest()->first();

              if($record == '' || $record == null)
              {
                $nextInvoiceNumber = date('Y').'/1';
              }

              else
              {

              $expNum = explode('/', $record->Bl_num);
              
           
              if ( date('Y-m-d') == date('2013-01-01') ){
               error_log('*//////////*');
                  $nextInvoiceNumber = date('Y').'/1';
              } else {
                  //increase 1 with last invoice number
                  $nextInvoiceNumber = $expNum[0].'/'. $expNum[1]+1;
              }
            }

              $Bl->Bl_num = $nextInvoiceNumber;
  
              $Bl->ClientId= request('ClientName');
              $Bl->Status = 'Not Factured';
           
              $Bl->User_id = Auth::id();
              $Bl->save();
  
              $Bls = Bl::with('user')->with('client')->orderBy('created_at','DESC')->get();
  
              $user =  Auth::id();
              $Bds = Bldetails::all();
              $Payments = Caisse::all();
      
  
              return response()->json([
                "user"=>$user,
                "bls" => $Bls,
                "Bds" =>$Bds,
                "Payments" => $Payments
              
              ]);
         
            }    


            public function transform(){ 

              $Bl = Bl::find(request('id'));
              $Bds = Bldetails::where('Bl_id',request('id'))->get();

              $Bl->Status = "factured";

              $Bl->save();

              $Fac =new Facture() ;
              $Fac->ClientId= $Bl->ClientId;
            
              if(request('Type') == "Facture Proforma")
              
              {
                $Fac->Type= "Proformat";
                  $Fac->ModePay= "-";
              }

              else
              {
                $Fac->Type="Normal";
                  $Fac->ModePay = '-';
              }
           
           
              $Fac->UserId = Auth::id();
            
             
              $Fac->save();

            
              foreach ($Bds as $Bd) {

                $fd = new Fdetails();
                $fd->Designation = $Bd->Designation;
                $fd->Quantity = $Bd->Quantity ;
                $fd->Price_HT = $Bd->Price_HT / 1.19 ;
                $fd->Fac_id = $Fac->id ;
               
               
                $fd->save();
                



              }
             
              return response()->json([
                'success'=>'success',
             ]);

            
         
            }    
            

            public function showData(){

          
              $Bl = Bl::with('client')->find(request('id'));
             
               return response()->json([
               'order'=>$Bl,
            ]);
           }

           public function update(){

          

            $Bl = Bl::find(request('id'));
            $Bl->ClientId = request('ClientName');
            
            $Bl->save();

            $user =  Auth::id();
           
            $Bls = Bl::with('user')->with('client')->orderBy('created_at','DESC')->get();
            

            return response()->json([
              "user"=>$user,
              "bls" => $Bls
            
            ]);
 
          }



            public function destroy(){
              $Bl = Bl::findOrfail(request('id'));

              $Fbls =  Fbl::where('Bl_id',$Bl->id)->get();

              if(count($Fbls) > 0 )
              {
                return response()->json([
                  "error"=>'Bl déja Factured',
                
                ]);


              }


              Bldetails::where('Bl_id',request('id'))->delete();

            /*  if($Bl->Status != "Not Factured")
              {
                $Fbls =  Fbl::where('Bl_id',$Bl->id)->get();

                foreach($Fbls as $Fb)
                {
                  $Fac = Facture::find($Fb->Facture_id);
                     Fdetails::where('Fac_id',$Fac->id)->delete();

                  $Fac->delete();   


                }

              }*/

              error_log('//////////////////////////');

              $Cais = Caisse::where('Designation',request('id'))->get();

              if(count($Cais) > 0 )
              {

                Caisdetails::where("Caisse_id",$Cais[0]->id)->delete();
                $Cais[0]->delete();


              }
            
               
            
              $Bl->delete();

               return response()->json([
                "success"=>'Item removed',
              
              ]);
          }

          public function filter()
          {
            $user =  Auth::id();
           

            if(request('date') == "tod")
            {
              $today = Carbon::today();
              
              $Bls = Bl::with('user')->with('client')->whereDate('created_at',"=",$today)->get();
    
              return response()->json([
                "user"=>$user,
                "bls" => $Bls
              
              ]);
            }
    
            else if(request('date') == "yes")
            {
              $yesterday = Carbon::yesterday();

              
              $Bls = Bl::with('user')->with('client')->whereDate('created_at',"=",$yesterday)->get();

    
              return response()->json([
                "user"=>$user,
                "bls" => $Bls
              
              ]);
            }
            else if(request('date') == "lw")
            {
    
              $date = Carbon::now()->subDays(7);
              $Bls = Bl::with('user')->with('client')->whereBetween('created_at',  [$date,Carbon::now()])->get();
    
              return response()->json([
                "user"=>$user,
                "bls" => $Bls
              
              ]);
    
    
            }
    
            else if(request('date') == "lm")
            {
              $date = Carbon::now()->subDays(30);
              $Bls = Bl::with('user')->with('client')->whereBetween('created_at',  [$date,Carbon::now()])->get();
    
              return response()->json([
                "user"=>$user,
                "bls" => $Bls
              
              ]);
    
    
            }
            else{
    
              $Bls = Bl::with('user')->with('client')->orderBy('created_at', 'DESC')->get();
              return response()->json([
                "user"=>$user,
                "bls" => $Bls
              
              ]);
    
    
            }
    
    
    
    
          }

         





}

