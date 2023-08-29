<?php

namespace App\Http\Controllers;

use App\Models\Bl;
use App\Models\Bldetails;
use App\Models\Client;
use App\Models\Retour;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class option {
    public $label;
    public $value;
  }
class RetourController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
      }

      public function index($id){
        $bl = Bl::with('client')->where('id',$id)->first();
        $retours = Retour::with('user')->with('bl')->with('client')->where('Bl_id',$id)->orderBy('created_at','DESC')->get();
        $user =Auth::id();

          return view('Retour.index',compact(['bl','retours','user']) );
          
         
            }



            public function bls()
            {

         
              $bls = Bl::where('ClientId',request('Client'))->get();

        $html ="<option value='' disabled selected> Selectionner Bl</option>";
        foreach($bls as $item)
        {
        

            $html.='<option value="'.$item->id.'">BL N°'.$item->Bl_num.'</option>';



      
         
      }


      return response()->json([
        "html" => $html
      
      ]);



            }


            public function store(){ 

              $Bl = Retour::where('Bl_id',request('id'))->get();

              if(count($Bl) > 0)
              { return response()->json([
                "error"=>'Ce Bl est déja retourné'
              
              ]);
                

              }

             
              $blds = Bldetails::where('Bl_id',request('id'))->get();
              $total = 0;
              foreach($blds as $bd)
              {
                $total = $total + $bd->Quantity * $bd->Price_HT;
              }


              if(request('Amount') > $total){
                return response()->json([
                  "error"=>'Montant superieur à Total Bl (Total = '. number_format($total,2,'.',',').' )'
                
                ]);
           

              }

             $Bl = Bl::find(request('id'));

              $retour =new Retour() ;

             $retour->ClientId = $Bl->ClientId;
              $retour->Bl_id = $Bl->id;
              $retour->Designation = request('Des');
  
              $retour->Amount= request('Amount');

            
           
              $retour->UserId = Auth::id();
              $retour->save();
  
              $retours = Retour::with('user')->with('bl')->with('client')->where('Bl_id',$Bl->id)->orderBy('created_at','DESC')->get();
  
              $user =  Auth::id();
              
      
  
              return response()->json([
                "user"=>$user,
                'retours' => $retours
              
              ]);
         
            }    

            public function destroy(){
              $retour = Retour::findOrfail(request('id'));
             
              $retour->delete();

              return response()->json([
               "success"=>'Item removed',
             
             ]);

            
             
          }
     



}
