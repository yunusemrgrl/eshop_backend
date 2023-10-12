<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class siparisler extends Model
{
    public function siparis_urun()
    {
        return $this->hasMany('App\Models\siparis_urun','siparis_id','id');
    }


}
