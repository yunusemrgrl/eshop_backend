<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        if(strlen($request->email)>5){
            if(User::where('email',$request->email)->first()){
                return response()->json(['message' => 'This e-mail address is used.'], 401);
            }}
        $userCreate = new User();
        $userCreate->adi = $request->adi;
        $userCreate->email = $request->email;
        $userCreate->adres = $request->adres;
        $userCreate->password = bcrypt($request->password);
        if($userCreate->save())
        {
            return response()->json(['status'=>true,'message' => 'Your registration has been successfully registered.','data'=>$userCreate], 200);
        }else{
            return response()->json(['message' => 'Registration failed.'], 401);
        }

    }

    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email veya Şifre Hatalı'], 401);
        }

        return $this->respondWithToken($token);
    }
    /*
    public function me()
    {
        $user = auth()->user();


        return response()->json([

            'user' => $user
        ]);

    }
    */

    public function me()
    {
        if (auth()->check()) {
            $user = auth()->user();
            return response()->json([
                'user' => $user
            ]);
        }
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function sifreDegistir(Request $request)
    {
        $auth = User::where('id','=', auth()->user()->id)->first();
        $auth->email = $request->username;
        if($request->password)
        {
            $auth->password = Hash::make($request->password);
        }
        if($auth->save())
        {
            return ['status'=>true,'message'=>"İşlem Başarılı"];
        }else{
            return ['status'=>true,'message'=>"İşlem Başarılı"];
        }
    }
    protected function respondWithToken($token)
    {

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function update(Request $request){
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'Kullanıcı bulunamadı'], 404);
        }

        $user->adi = $request->adi;
        $user->email = $request->email;
        $user->adres = $request->adres;
        if($request->password){
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return response()->json(['message' => 'Kullanıcı güncellendi'], 200);
    }
}
