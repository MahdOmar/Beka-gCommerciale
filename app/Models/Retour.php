<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retour extends Model
{
    use HasFactory;
    public function bl()
    {
        return $this->belongsTo('App\Models\Bl','Bl_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','UserId','id');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client','ClientId','id');
    }



}
