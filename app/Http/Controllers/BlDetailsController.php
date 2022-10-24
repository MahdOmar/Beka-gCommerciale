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
use App\Models\Fbl;
use App\Models\Fdetails;
use App\Models\Fdbld;







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
       
        $Bl->save();

        if($bl_client->Status != "Not Factured")
        {
          $F_id = Fbl::where("Bl_id",$bl_client->id)->get();


         
          $fd = new Fdetails();
          $fd->Designation = $Bl->Designation;
          $fd->Quantity = $Bl->Quantity ;
          $fd->Price_HT = $Bl->Price_HT / 1.19 ;
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
      

        $Bl->Quantity = request('Quantity');

        $Bl->Colis = request('Colis');

        $Bl->Price_HT = request('price');
       
        $Bl->save();

        $new =  $Bl->Price_HT * $Bl->Quantity;

       if( $bl_client->Status != 'Not Factured')
       {

        $Fdbl = Fdbld::where('Bldetails_id',$Bl->id)->get();

        $Fd = Fdetails::find($Fdbl[0]->Fdetails);

       
       

        $Fd->Designation = request('Des');
      
        $Fd->Quantity = request('Quantity');
      

        $Fd->Price_HT = request('price') / 1.19;
       
        $Fd->save();

       

      }
        


        $bldetails = Bldetails::where('Bl_id',request('idB'))->get();
       

        return $bldetails;
   
      }    


      public function showView($id)
  {

    $Bl = Bl::with('client')->findOrfail($id);
   
    $Bldetails = Bldetails::where('Bl_id',$id)->get();

    return view('BL.show',compact('Bl'),compact('Bldetails'));
    
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
