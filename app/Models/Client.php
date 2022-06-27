<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public function Bl()
    {
    return $this->hasMany('App\Models\Bl','ClientId','id');
    }

    public function Facture()
    {
    return $this->hasMany('App\Models\Facture','ClientId','id');
    }
    public function Credit()
    {
    return $this->hasMany('App\Models\Clientcredit','ClientId','id');
    }

}
