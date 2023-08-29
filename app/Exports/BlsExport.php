<?php

namespace App\Exports;

use App\Models\Bl;
use App\Models\Client;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BlsExport implements FromView
{
    protected $id;

 function __construct($id) {
        $this->id = $id;
 }
    public function view(): View
    {
        $Client = Client::find($this->id);
        $bls = Bl::where('ClientId',$this->id)->get();
        return view('exports.export_bls', [
            'bls' => $bls, 'client' =>$Client
        ]);
    }
}
