<?php

namespace App\Http\Controllers;

use App\Models\Bl;
use App\Models\Caisse;
use App\Models\Client;
use App\Models\Clientcredit;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
      }

      public function index(){

        $clients = Client::orderBy('created_at',"DESC")->paginate(10);
    /*    $Etats = Client::select(
          'clients.id',
          'clients.Name',
          'caisses.Amount',
          
          DB::raw('count( Distinct( caisses.Designation) )  as bls'),
          DB::raw('SUM((caisses.Amount))  as pay'))
        
          ->leftJoin('caisses', 'caisses.ClientId', '=', 'clients.id')
          ->groupBy('clients.id')
          ->paginate(10);*/

          $caisses = Caisse::where('Operation','Encaissement de Facture/Bl')->get(); 
          $allBl = Bl::select(
            'bls.ClientId',
         
            DB::raw('Count(bls.id)  as allBl'))
          
            ->groupBy('bls.ClientId')
            ->get();


          $Bls = Bl::select(
            'bls.ClientId',
         
            DB::raw('SUM((bldetails.Price_Ht * bldetails.Quantity))  as total'))
          
            ->leftJoin('bldetails', 'bldetails.Bl_id', '=', 'bls.id')
            ->groupBy('bls.ClientId')
            ->get();

 
            $credits = Clientcredit::all();
          
            error_log($allBl);


       
          return view('Clients.index',[ 'clients' => $clients,"caisses" =>$caisses,"allBl" =>$allBl,
                                       'Bls' => $Bls , 'credits' => $credits  ]);
          
         
            }

            public function details($id)
            {

              $Client = Client::where("id",$id)->get();


              $Bls = Caisse::where('ClientId',$id)->get();

              
          $Bds = Bl::select(
            'bls.id',
  
            DB::raw('SUM((bldetails.Price_Ht * bldetails.Quantity))  as total'))
          
            ->leftJoin('bldetails', 'bldetails.Bl_id', '=', 'bls.id')
            ->groupBy('bls.id')
            ->get();

            error_log('///////'.$Bds);

              

              return view('Clients.Etatdetails',["Bls" => $Bls ,"Bds" => $Bds, "Client" => $Client]);



            }

            public function store(){ 

                $client =new Client() ;
    
                $client->Name = request('ClientName');
                $client->Phone = request('ClientPhone');
                $client->Adress = request('ClientAdress');
                $client->Contact = request('Contact');
                $client->RC = request('rc');
                $client->NIF = request('nif');
                $client->AI = request('ai');
              
                $client->save();
    
                $clients = Client::orderBy('created_at',"DESC")->get();
                
    
             
              
  
                return $clients;
           
              }    

              public function showData(){

          
                $client = Client::find(request('id'));
               
                 return response()->json([
                 'client'=>$client,
              ]);
             }

             public function update(){

        
              $client = Client::find(request('id'));
           

              $client->Name = request('ClientName');
              $client->Phone = request('ClientPhone');
              $client->Adress = request('ClientAdress');
              $client->Contact = request('Contact');
              $client->RC = request('rc');
              $client->NIF = request('nif');
              $client->AI = request('ai');
              $client->save();
  
        
             
              $Clients = Client::orderBy('created_at',"DESC")->get();

            
              
  
             return $Clients;

             }

             public function destroy(){
              $client = Client::findOrfail(request('id'));
              $Bls = Bl::where('ClientId',$client->id)->get();

              if(count($Bls) > 0)
              {

              

                return response()->json([
                 "error"=>'Ce Client a des Bls',
               
               ]);

              }
            else{
              $client->delete();

              return response()->json([
               "success"=>'Item removed',
             
             ]);

            }
             
          }



}
