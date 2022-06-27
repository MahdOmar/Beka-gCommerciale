<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bl extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User','User_id','id');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client','ClientId','id');
    }


}
