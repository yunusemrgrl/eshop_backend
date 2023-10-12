<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class siparis_urun extends Model
{
    public function urun()
    {
        return $this->hasOne('App\Models\urunler','id','urun_id');
    }
}
