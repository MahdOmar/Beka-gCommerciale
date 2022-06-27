<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fdetails;
use App\Models\Facture;
use Illuminate\Support\Facades\Auth;

use App\Models\Caisse;




class FDetailsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
      }

      public function Fac_details($id){
       

            

     
        $fdetails = Fdetails::where('Fac_id',$id)->get();
          $Fac = Facture::find($id);
          $user = Auth::id();

         
        return view('Facture.details',['fdetails' => $fdetails , 'Fac' => $Fac , 'user' => $user]);
    }

    public function store(){ 

       
        $fd =new Fdetails() ;

        $fac = Facture::find(request('id'));
       

        $fd->Designation = request('Des');
        $fd->Quantity = request('Quantity');
        $fd->Price_HT = request('price');
        $fd->Fac_id = request('id');
       
       
        $fd->save();

      
       

        $fdetails = Fdetails::where('Fac_id',request('id'))->get();
       

        return $fdetails;
   
      } 

      public function getDetails()
  {
    $fdetails = Fdetails::find(request('id'));
    return $fdetails;
  }


  public function update(){ 

      

       
    $fd =Fdetails::find(request('id'));

 

    $fd->Designation = request('Des');
  


    $fd->Quantity = request('Quantity');

    $fd->Price_HT = request('price');
   
 
    
    $fd->save();

    

     
        
   

   

    $bldetails = Fdetails::where('Fac_id',request('idB'))->get();
   

    return $bldetails;

  } 
  
  public function showView($id)
  {

    $Fac = Facture::with('client')->findOrfail($id);
   
    $Fdetails = Fdetails::where('Fac_id',$id)->get();

    return view('Facture.show',compact('Fac'),compact('Fdetails'));
    
  }






      public function destroy(){
        $Fac = Fdetails::findOrfail(request('id'));
        $id = $Fac->Fac_id;
       
    
        $Fac->delete();
        
        $Facs = Fdetails::where('Fac_id', $id )->get();
    
    
         return $Facs;
    }


}
