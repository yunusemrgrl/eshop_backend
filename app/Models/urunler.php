<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class urunler extends Model
{
    public function user()
    {
        return $this->hasOne('App\Models\User','id','kullanici_id')->select(['id','adi']);
    }

}
