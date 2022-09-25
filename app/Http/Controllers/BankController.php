<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Facture;
use Illuminate\Http\Request;

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

        $clients = Client::all();

        return view('Bank.index',compact(['clients']));

      }

      public function factures(){

        $factures = Facture::where('ClientId',request('Client'))->where('Type','Normal')->get();
        $html =array();
        error_log('/**********************************'.$factures);
        foreach($factures as $item)
        {
         
        $opt = new option();
        error_log("dkhaaaaaaaaaaaaaaaalt");


        $opt->label = "Facture N°".$item->Fac_num;
        $opt->value = $item->id;
  
        array_push($html,$opt);
         
      }


      return response()->json([
        "html" => $html
      
      ]);

      }





}
