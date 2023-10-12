<?php

use Carbon\Carbon;



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
