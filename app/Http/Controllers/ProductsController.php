<?php

namespace App\Http\Controllers;

use App\Models\siparisler;
use App\Models\siparis_urun;
use App\Models\urunler;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductsController extends Controller
{
    public function getProducts(){
        $products = urunler::with('user')->get();
        return $products;
    }

    public function getProduct(Request $request){
        $product = urunler::where('id','=',$request->id)->with('user')->first();
        return $product;
    }

    public function addShoppingCart(Request $request){
        return $request;
        $id = $request->id;
        $urun = urunler::where('id','=',$id)->first();
        return $urun;
    }

    public function store(Request $request){

        $status = "success";
        $msg = "Talep kaydedildi.";

        $product = new urunler();
        $product->adi = $request->product['adi'];
        $product->aciklama = $request->product['aciklama'];
        $product->adet = $request->product['adet'];
        $product->fiyat = $request->product['fiyat'];
        $product->satista_mi = $request->product['satista_mi'];
        $product->kullanici_id = $request->userId;

        if($request->product['file']){
            $product_gorsel = $this->dosya($request->product['file'], 'formImage');
            $product_gorsel = $product_gorsel['url'];
            $product->foto1 = $product_gorsel;
        }
        if($product->save()){

        }else {
            $status = "warning";
            $msg = "Talep kaydetme işlemi başarısız!";
        }

        return ['status'=>$status, 'message'=>$msg, 'product'=>$product];

    }

    public function addOrder(Request $request) {
        $status = "success";
        $msg = "Talep kaydedildi.";

        $siparis = new siparisler();
        $siparis->kullanici_id = $request->userId;
        $siparis->toplam_tutar = $request->total;
        $siparis->adres = $request->adres;
        $bugun = Carbon::now();
        $ikiGunSonra = $bugun->addDays(2);
        $siparis->teslim_tarihi = $ikiGunSonra;

        if($siparis->save()){

            $products = collect($request->product);
            $products->map(function ($product) use ($siparis){
                $siparis_urun = new siparis_urun();
                $siparis_urun->siparis_id = $siparis->id;
                $siparis_urun->urun_id = $product['id'];
                $siparis_urun->adet = $product['quantity'];
                if($siparis_urun->save()){

                }else {
                    Log::error('Sipariş ürünü kaydedilemedi', ['siparis_urun' => $siparis_urun]);
                    return response()->json(['error' => 'Sipariş ürünü eklenirken hata oluştu'], 500);
                }
            });


        }else {
            $status = "warning";
            $msg = "Talep kaydetme işlemi başarısız!";

        }
        return ['status'=>$status, 'message'=>$msg, 'siparis'=>$siparis];
    }

    public function getOrder(Request $request){
        $siparis = siparisler::where('kullanici_id','=',$request->userId)->with('siparis_urun.urun')->get();
        return $siparis;
    }


    public function getAllOrder(){
        $siparisler = siparisler::with('siparis_urun.urun')->get();
        return $siparisler;
    }

    public function confirmOrder(Request $request){
        $status = "success";
        $msg = "Onaylama kaydedildi.";

        $siparis = siparisler::where('id','=',$request->id)->first();
        
        if ($siparis->status == 0 && empty($request->status)){
            $siparis->status = 1;
        }
        else if($siparis->status == 1 && empty($request->status) ) {
            $siparis->status = 2;
        }
        else if ($request->status == "iptal"){
            $siparis->status = 3;
        }

        if($siparis->save()){

        }
        else {
            $status = "warning";
            $msg = "Onaylama işlemi başarısız!";
        }

        return ['status'=>$status, 'message'=>$msg, 'siparis'=>$siparis];


    }



}
