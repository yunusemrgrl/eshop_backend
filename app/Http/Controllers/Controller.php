<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function dosya($file, $fileDirectory){
        $destinationPath = 'uploads/' . $fileDirectory . '/';
        $fileName = str_replace(" ", "_", $file->getClientOriginalName());
        $yeniurl = date_format(Carbon::now(), "YmdHis") . "_" . $fileName;
        $file->move($destinationPath, $yeniurl);
        return array("status" => true,
            "message" => "Dosyanız başarıyla yüklenmiştir..",
            "url" => $destinationPath . $yeniurl,
            "fileType" => $file->getClientOriginalExtension()
        );
    }

    function XMLPOST($PostAddress,$xmlData)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$PostAddress);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
        $result = curl_exec($ch);
        return $result;
    }

}
