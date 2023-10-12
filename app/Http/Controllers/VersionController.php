<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class VersionController extends Controller
{
    public function index()
    {
        $this->createUser();

        echo "Güncelleme başarılı";
    }


    public function createUser()
    {

        if (!Schema::hasTable('users'))
        {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('adi');
                $table->string('email')->unique();
                $table->string('adres');
                $table->string('password');
                $table->timestamp('email_verified_at')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

}
