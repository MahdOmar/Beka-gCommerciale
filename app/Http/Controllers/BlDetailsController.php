<?php

namespace App\Http\Controllers;

use App\Models\Bl;
use App\Models\Bldetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Caisse;
use App\Models\Caisdetails;
use App\Models\Client;
use App\Models\Clientcredit;
use App\Models\Facture;
use App\Models\Fbl;
use App\Models\Fdetails;
use App\Models\Fdbld;
use App\Models\Retour;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class BlDetailsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
      }

      public function bl_details($id){
            
       $Bl= Bl::find($id);  

       $user = Auth::id();


        
       


       $bl_details = Bldetails::where('Bl_id',$id)->get();
        

        return view('BL.details',['bldetails' => $bl_details ,'Bl' => $Bl, 'user' => $user]);
    }

    public function store(){ 

       $bl_client = Bl::find(request('id'));
        $Bl =new Bldetails() ;

        $Bl->Designation = request('Des');
        $Bl->Quantity = request('Quantity');
        $Bl->Colis = request('Colis');
        $Bl->Price_HT = request('price');
        $Bl->Bl_id = request('id');
        $bl_client->total += request('Quantity') * request('price');
        $bl_client->save();
       
        $Bl->save();

        if($bl_client->Status != "Not Factured")
        {
          $F_id = Fbl::where("Bl_id",$bl_client->id)->get();


         
          $fd = new Fdetails();
          $Fact = Facture::find($fd->Fac_id);
          $fd->Designation = $Bl->Designation;
          
          $fd->Quantity = $Bl->Quantity ;
          $fd->Price_HT = $Bl->Price_HT;

          // if($Fact->tva == "19")
          // {
          //   $fd->Price_HT = $Bl->Price_HT / 1.19 ;
          // }
          // else
          // {
          //   $fd->Price_HT = $Bl->Price_HT / 1.09 ;
          // }
          $Fact->total_HT += $Bl->Quantity  * $fd->Price_HT;
          $Fact->save();
         
         
          $fd->Fac_id = $F_id[0]->Facture_id;

          
          $fd->save();

          $Fdb = new Fdbld();
                   
          $Fdb->Fdetails = $F_id[0]->Facture_id;
          $Fdb->Bldetails_id = $Bl->id;
          $Fdb->save();


        }

        $bldetails = Bldetails::where('Bl_id',request('id'))->get();
       

        return $bldetails;
   
      }    


      public function update(){ 


      
        $bl_client = Bl::find(request('idB'));
       
        $Bl =Bldetails::find(request('id'));


        $Bl->Designation = request('Des');

        $bl_client->total -= ($Bl->Quantity * $Bl->Price_HT);
        $quantity = $Bl->Quantity;
        $price = $Bl->Price_HT;
      

        $Bl->Quantity = request('Quantity');

        $Bl->Colis = request('Colis');

        $Bl->Price_HT = request('price');
        $bl_client->total += ($Bl->Quantity * $Bl->Price_HT);
        $bl_client->save();
        $Bl->save();

        $new =  $Bl->Price_HT * $Bl->Quantity;

       if( $bl_client->Status != 'Not Factured')
       {

        $Fdbl = Fdbld::where('Bldetails_id',$Bl->id)->get();

        $Fd = Fdetails::find($Fdbl[0]->Fdetails);

        $Facture = Facture::find($Fd->Fac_id);
        $Facture->total_HT -= ($quantity * $price);

       
       

        $Fd->Designation = request('Des');
      
        $Fd->Quantity = request('Quantity');

        $Fd->Price_HT = $Bl->Price_HT;
      // if($Facture->tva == "19")
      // {
      //   $Fd->Price_HT = request('price') / 1.19;
      // }
      // else
      // {
      //   $Fd->Price_HT = request('price') / 1.09;

      // }

      $Facture->total_HT += $Fd->Price_HT * $Fd->Quantity;
      $Facture->save();



       
        $Fd->save();

       

      }
        


        $bldetails = Bldetails::where('Bl_id',request('idB'))->get();
       

        return $bldetails;
   
      }    


      public function showView($id)
  {

    $Bl = Bl::with('client')->where('id',$id)->first();
   
    $Bldetails = Bldetails::where('Bl_id',$id)->get();


    $caisses = Caisse::where('Operation','!=','Reglement de depenses')->where('ClientId',$Bl->ClientId)->get(); 
          $rembo = Caisse::select( 'ClientId',DB::raw('SUM(Amount)  as total'))->where('Operation','Reglement de depenses')->where('ClientId',$Bl->ClientId)->groupBy('ClientId')->get(); 
          $return = Retour::select( 'ClientId',DB::raw('SUM(Amount)  as rn'))->where('ClientId',$Bl->ClientId)->groupBy('ClientId')->get(); 
       
       
          $banks = DB::table('banks')->select('Total_Amount','Mode','ClientId')->where('ClientId',$Bl->ClientId)->groupBy('Mode')->get();
         

          $Bls_fac = Bl::select(
            'bls.ClientId',
             
            
         
            DB::raw('SUM((bldetails.Price_Ht * bldetails.Quantity))  as total'))
          
            ->leftJoin('bldetails', 'bldetails.Bl_id', '=', 'bls.id')
            ->where('bls.Status','!=','Not Factured')
            ->where('bls.ClientId',$Bl->ClientId)
            ->groupBy('bls.ClientId')
            ->get();

            $Bls = Bl::select(
              'bls.ClientId',
               
              
           
              DB::raw('SUM((bldetails.Price_Ht * bldetails.Quantity))  as total'))
            
              ->leftJoin('bldetails', 'bldetails.Bl_id', '=', 'bls.id')
              ->where('bls.Status','Not Factured')
              ->where('bls.ClientId',$Bl->ClientId)
              ->groupBy('bls.ClientId')
              ->get();

           
           // Total
           
           $total =0;
           
         
           foreach($Bls as $bl)
           {
             
                 $total += $bl->total;
            
           
            }
     
           foreach($Bls_fac as $bl)
           {
            
             
                 $total += $bl->total + $bl->total * 0.19 ;
           
           
           }
//*******End Total ********** */     
$total_payed = 0;
$total_tax = 0;
    foreach($caisses as $cais)
    {
      
        $total_payed += $cais->Amount;
        if($cais->Operation == "Encaissement de Facture")
      {
        $caisdetails = \App\Models\Caisdetails::where('Caisse_id',$cais->id)->get();
        foreach($caisdetails as $details)
        {
          $total_tax += $details->Amount /1.01 * 0.01;

          
        }
      }
      
    }
    foreach($banks as $bank)
    {
     
        $total_payed = $total_payed + $bank->Total_Amount;
        
      
    }

     $total_romb = 0;

    foreach ($rembo as $item) {
      
        $total_romb += $item->total;


      
    }

    $total_payed -= $total_romb;

    /**************** */
    $total_left = 0;
        
          foreach($Bls as $bl)
          {
            
              $total_left = $total + $total_tax - $total_payed;
            
              
            
          }
          foreach($return as $rtn)
              {
               
                  $total_left -= $rtn->rn;

                
              }

          if($total_left < 0)
          {
          
            $total_left = 0;
          

          }
          $sold =0;
          $sold = $total_left;


                   
            
            
            
            
            
                   







    $retour = Retour::where('Bl_id',$id)->first();



    return view('BL.show',compact(['Bl','Bldetails','sold','retour']));
    
  }
 
  public function getDetails()
  {
    $Bldetails = Bldetails::find(request('id'));
    return $Bldetails;
  }

  public function destroy(){
    $Bl = Bldetails::findOrfail(request('id'));
    $Bon = Bl::find($Bl->Bl_id);
    $id = $Bl->Bl_id;

    if( $Bon->Status != "Not Factured")
    {
      $fd_id = Fdbld::where('Bldetails_id', $Bl->id)->get();
    
 
      $Fd = Fdetails::where('id',$fd_id[0]->Fdetails)->delete();
      $fd_id[0]->delete();
  
    }

    
    $Bl->delete();
    
    $bls = Bldetails::where('Bl_id', $id )->get();


     return $bls;
}


  



}
