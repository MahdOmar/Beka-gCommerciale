<?php

namespace App\Http\Controllers;

use App\Models\Bl;
use App\Models\Bldetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Caisse;
use App\Models\Caisdetails;
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

          error_log('///////'.$fd);
          
          $fd->save();

          $Fdb = new Fdbld();
                   
          $Fdb->Fdetails = $F_id[0]->Facture_id;
          $Fdb->Bldetails_id = $Bl->id;
          $Fdb->save();


        }

        $facture = request('id');

      

        $Cais = Caisse::where('Designation',$facture)->get();

     
        
        if(count($Cais) !=0)
        {


          $Cais[0]->Amount = $Cais[0]->Amount + ($Bl->Price_HT *  $Bl->Quantity)/2;
         
          $Cais[0]->save();

          error_log('//////////');
          $cd = Caisdetails::where('Caisse_id',$Cais[0]->id)->where('Bl_id',$Bl->Bl_id)->get();

          $cd[0]->Amount = $cd[0]->Amount + ($Bl->Price_HT *  $Bl->Quantity)/2;
         
          $cd[0]->save();
          



         
        }

        else
        {

          $caisse = new Caisse();
         
          $caisse->Operation = "Encaissement de Facture/Bl";
         
          $caisse->Designation = request('id');
         
          $caisse->Amount = ($Bl->Price_HT *  $Bl->Quantity)/2;

          $caisse->UserId = Auth::id();
          $caisse->ClientId = $bl_client->ClientId;
         
          $caisse->save();

          $cd =  new Caisdetails();
          $cd->Bl_id = request('id');
          $cd->Caisse_id = $caisse->id;
          $cd->Amount = ($Bl->Price_HT *  $Bl->Quantity)/2;
          $cd->UserId = Auth::id();

          $cd->save();



        }






        $bldetails = Bldetails::where('Bl_id',request('id'))->get();
       

        return $bldetails;
   
      }    


      public function update(){ 

        $Bds = Bldetails::where('Bl_id',request('idB'))->get();

        $total_1 = 0;


        foreach ($Bds as $Bd)
        {
          $total_1 = $total_1 + $Bd->Price_HT *  $Bd->Quantity;

        }

      
        $bl_client = Bl::find(request('idB'));
       
        $Bl =Bldetails::find(request('id'));

        $old = $Bl->Quantity * $Bl->Price_HT;



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
      
        error_log('///////////');
        $Fd->Quantity = request('Quantity');
      

        $Fd->Price_HT = request('price') / 1.19;
       
        $Fd->save();

       

      }
        






        $facture = request('idB');

      

        $Cais = Caisse::where('Designation',$facture)->get();

        $Bds_2 = Bldetails::where('Bl_id',request('idB'))->get();

        $total = 0;


        foreach ($Bds_2 as $Bd)
        {
          $total = $total + $Bd->Price_HT *  $Bd->Quantity;

        }

        if( $Cais[0]->Amount <= $total/2)
        {
          $Cais[0]->Amount = $Cais[0]->Amount - $old/2 + $new/2;
         
          $Cais[0]->save();

      
          $cd = Caisdetails::where('Caisse_id',$Cais[0]->id)->where('Bl_id',$Bl->Bl_id)->get();

          $cd[0]->Amount = $cd[0]->Amount - $total_1/2 +$total/2;
         
          $cd[0]->save();

        }

        else
        {
          $Cais[0]->Amount = $Cais[0]->Amount - $total_1 + $total;
         
          $Cais[0]->save();

          $cdetails = new Caisdetails();
          $cdetails->Bl_id = $Bl;
          $cdetails->Caisse_id = $Cais[0]->id;
          $cdetails->Amount = - ($Bl->Price_HT * $Bl->Quantity) ;
          $cdetails->UserId = Auth::id();
          $cdetails->save();



        }

         

          if($Cais[0]->Amount > $total)
          {

            $credit = Clientcredit::where("ClientId",$bl_client->ClientId)->get();

            if(count($credit) > 0)
            {
             $credit[0]->Amount =  $credit[0]->Amount + ($Cais[0]->Amount - $total);
             $credit[0]->save();
            }
            else
            {
              
            $add = new Clientcredit();
           
            $add->Amount = $Cais[0]->Amount - $total ;
            $add->ClientId = request('Client');
        
          
           $add->save();
   
            }



          }

          else
          {
            $credit = Clientcredit::where("ClientId",$bl_client->ClientId)->get();
            if(count( $credit) > 0 &&  $credit[0]->Amount > 0 )
            {
              if(($Cais[0]->Amount + $credit[0]->Amount) <= $total )
              {
                $Cais[0]->Amount = $Cais[0]->Amount + $credit[0]->Amount;
                $Cais[0]->save();
                $credit[0]->Amount = 0;
                $credit[0]->save();


              }
              else{

               
                $credit[0]->Amount =  $credit[0]->Amount - ($total - $Cais[0]->Amount );
                $Cais[0]->Amount = $total;
                $Cais[0]->save();
                $credit[0]->save();


              }

            }



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

    
    $Cais = Caisse::where('Designation',$id)->get();
    $CaisD = Caisdetails::where('Caisse_id',$Cais[0]->id)->get();
    

   /* $CaisD[0]->Amount = $CaisD[0]->Amount - ($Bl->Price_HT * $Bl->Quantity) / 2;
    $CaisD[0]->save();

    $Cais[0]->Amount = $Cais[0]->Amount  -  ($Bl->Price_HT * $Bl->Quantity) /2;*/



    $Blds = Bldetails::where('Bl_id', $id)->get(); 

    $total = 0;

    foreach($Blds as $bld )
    {
      $total = $total + $bld->Price_HT * $bld->Quantity ;


    }


    if($Cais[0]->Amount <= ($total/2)+1)
    {
      error_log('///////////////////'.$Cais[0]->Amount-$total/2);
      
      $Cais[0]->Amount = $Cais[0]->Amount  -  ($Bl->Price_HT * $Bl->Quantity) /2;

      $CaisD[0]->Amount = $CaisD[0]->Amount - ($Bl->Price_HT * $Bl->Quantity) / 2;

      if( $Cais[0]->Amount == 0)
      {
        $Cais[0]->delete();
      }
      else
      {
        $Cais[0]->save();
      }

    


    $CaisD[0]->save();

    }
    else 
    {
      error_log('****************'.$Cais[0]->Amount-$total/2);
      $Cais[0]->Amount = $Cais[0]->Amount  -  ($Bl->Price_HT * $Bl->Quantity);
      $cdetails = new Caisdetails();
      $cdetails->Bl_id = $Bl->id;
      $cdetails->Caisse_id = $Cais[0]->id;
      $cdetails->Amount = - ($Bl->Price_HT * $Bl->Quantity) ;
      $cdetails->UserId = Auth::id();
      $cdetails->save();
      $Cais[0]->save();

    }


    
    $Bl->delete();
    
    $bls = Bldetails::where('Bl_id', $id )->get();


     return $bls;
}


  



}
