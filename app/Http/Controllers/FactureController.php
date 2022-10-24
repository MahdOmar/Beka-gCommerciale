<?php

namespace App\Http\Controllers;

use App\Models\Bl;
use App\Models\Bldetails;

use Illuminate\Http\Request;

use App\Models\Client;
use Illuminate\Support\Carbon;
use App\Models\Fdetails;

use App\Models\Fdbld;
use App\Models\Fbl;

use Illuminate\Support\Facades\Auth;

use App\Models\Facture;

class option
{
  public $label;
  public $value;
}

class FactureController extends Controller
{
  public function index()
  {

    $Clients = Client::all();

    $Facs = Facture::with('user')->with('client')->orderBy('created_at', 'DESC')->paginate(10);

    $user = Auth::id();


    return view('Facture.index', ['clients' => $Clients, 'facs' => $Facs, 'user' => $user]);
  }


  public function store()
  {





    $Fac = new Facture();

    if (request('Type') == "Normal") {

      $record = Facture::where('Type', 'Normal')->latest()->first();
    } else {
      $record = Facture::where('Type', 'like', 'Proforma%')->latest()->first();
    }


    if ($record == '' || $record == null) {
      if (date('Y') == '2022') {
        if (request('Type') == "Normal") {
          $nextInvoiceNumber = date('Y') . '/500';
        } else {
          $nextInvoiceNumber = date('Y') . '/400';
        }
      } else {
        $nextInvoiceNumber = date('Y') . '/1';
      }
    } else {

      $expNum = explode('/', $record->Fac_num);


      if (date('Y-m-d') == date('Y-01-01')) {
        $nextInvoiceNumber = date('Y') . '/1';
      } else {
        //increase 1 with last invoice number
        $nextInvoiceNumber = $expNum[0] . '/' . $expNum[1] + 1;
      }
    }

    $Fac->Fac_num = $nextInvoiceNumber;


    $Fac->ClientId = request('ClientName');
    $Fac->Type = request('Type');

    if (request('Type') == "Proforma") {
      $Fac->ModePay = "-";
      if (request('TypeP') == "new") {


        $Fac->UserId = Auth::id();

        $Fac->Type = request('Type') . ' N';

        $Fac->save();


        $Facs = Facture::with('user')->with('client')->orderBy('created_at', 'DESC')->get();

        $user =  Auth::id();

        return response()->json([
          "user" => $user,
          "facs" => $Facs

        ]);
      }
    } else {
      $Fac->ModePay = request('Mode');
      $Fac->Status = "Not Payed";
    }




    $Fac->UserId = Auth::id();

    $Fac->save();



    $bls = request('Bls');





    foreach ($bls as $bl) {
      $Bl = Bl::find($bl);

      // insert into fbls table 
      $Fbl = new Fbl();
      $Fbl->Facture_id = $Fac->id;
      $Fbl->Bl_id = $Bl->id;
      $Fbl->save();




      $Bl->status = 'Facture N°' . $Fac->Fac_num;
      $Bl->save();

      $Bds = Bldetails::where('Bl_id', $bl)->get();

      foreach ($Bds as $Bd) {


        $fd = new Fdetails();
        $fd->Designation = $Bd->Designation;
        $fd->Quantity = $Bd->Quantity;
        $fd->Price_HT = $Bd->Price_HT / 1.19;
        $fd->Fac_id = $Fac->id;

        $fd->save();



        // insert into fdblds table
        $Fdb = new Fdbld();

        $Fdb->Fdetails = $fd->id;
        $Fdb->Bldetails_id = $Bd->id;
        $Fdb->save();
      }
    }









    $Facs = Facture::with('user')->with('client')->orderBy('created_at', 'DESC')->get();

    $user =  Auth::id();

    return response()->json([
      "user" => $user,
      "facs" => $Facs

    ]);
  }


  public function showData()
  {


    $Bl = Facture::with('client')->find(request('id'));

    return response()->json([
      'order' => $Bl,
    ]);
  }

  public function update()
  {



    $Fc = Facture::find(request('id'));
    $Fc->ClientId = request('ClientName');
    $Fc->Type = request('Type');

    if (request('Type') == "Proformat") {
      $Fc->ModePay = "-";
    } else {
      $Fc->ModePay = request('Mode');
    }



    $Fc->save();

    $user =  Auth::id();

    $Fcs = Facture::with('user')->with('client')->orderBy('created_at', 'DESC')->get();


    return response()->json([
      "user" => $user,
      "facs" => $Fcs

    ]);
  }



  public function destroy()
  {
    $Fac = Facture::findOrfail(request('id'));

    $Fbls =  Fbl::where('Facture_id', $Fac->id)->get();


    foreach ($Fbls as $Fbl) {
      $Bl = Bl::find($Fbl->Bl_id);
      $Bl->Status = "Not Factured";
      $Bl->save();
      $Fbl->delete();
    }


    $fds =   FDetails::where('Fac_id', request('id'))->get();

    foreach ($fds as $fd) {
      Fdbld::where('Fdetails', $fd->id)->delete();
      $fd->delete();
    }


    $Fac->delete();


    return response()->json([
      "success" => 'Item removed',

    ]);
  }

  public function filter()
  {
    $user =  Auth::id();


    if (request('date') == "tod") {
      $today = Carbon::today();

      $facs = Facture::with('user')->with('client')->whereDate('created_at', "=", $today)->get();

      return response()->json([
        "user" => $user,
        "facs" => $facs

      ]);
    } else if (request('date') == "yes") {
      $yesterday = Carbon::yesterday();


      $facs = Facture::with('user')->with('client')->whereDate('created_at', "=", $yesterday)->get();


      return response()->json([
        "user" => $user,
        "facs" => $facs

      ]);
    } else if (request('date') == "lw") {

      $date = Carbon::now()->subDays(7);
      $facs = Facture::with('user')->with('client')->whereBetween('created_at',  [$date, Carbon::now()])->get();

      return response()->json([
        "user" => $user,
        "facs" => $facs

      ]);
    } else if (request('date') == "lm") {
      $date = Carbon::now()->subDays(30);
      $facs = Facture::with('user')->with('client')->whereBetween('created_at',  [$date, Carbon::now()])->get();

      return response()->json([
        "user" => $user,
        "facs" => $facs

      ]);
    } else {

      $facs = Facture::with('user')->with('client')->orderBy('created_at', 'DESC')->get();
      return response()->json([
        "user" => $user,
        "facs" => $facs

      ]);
    }
  }

  public function bls()
  {

    if (request('Type') == 'Proforma') {
      $items =  Bl::where('ClientId', request('Client'))
        ->get();
    } else {
      $items =  Bl::where('ClientId', request('Client'))->where('Status', 'Not Factured')
        ->get();
    }


    $html = array();


    foreach ($items as $item) {
      $opt = new option();
      $opt->label = "Bon N°" . $item->Bl_num;
      $opt->value = $item->id;

      array_push($html, $opt);
      // $html.='<option value="'.$item->id.'">Bon N°'.$item->id.'</option>';

    }



    return response()->json([
      "html" => $html

    ]);
  }
}
