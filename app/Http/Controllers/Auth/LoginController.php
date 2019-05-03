<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ApiBuilder;
use Session;
use Hash;
use Bcrypt;
use App\User;

class LoginController extends Controller
{

  public function index(){
    return view('auth/login');
  }

  public function doLogin(Request $request){
      $email = $request->email;
      $password = $request->password;
      dd($request);
      $data = User::where('email',$email)->first();

      if($data){
          if(User::where('password',$password)->first()){
            Session::put('first_name',$data->first_name);
            Session::put('last_name',$data->last_name);
            Session::put('email',$data->email);
            Session::put('login',TRUE);
            Session::flash('sukses', 'Sukses Masuk Ke Akun Anda');
            return redirect('/genre');
          }
          else{
            Session::flash('gagal', 'Username Atau Password Salah');
            return redirect()->back();
          }
      }
      else{
        Session::flash('gagal', 'Username Atau Password Salah');
        return redirect()->back();
      }
    }


  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
        'email' => ['required', 'email'],
        'password' => ['required']
    ]);

    if ($validator->fails()) {
        return ApiBuilder::apiResponseValidationFails('Login validation fails!', $validator->errors()->all(), 422);
    }

    if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password
    ])) {
        $user = Auth::user();
        $success['user'] = $user;
        $success['token'] = $user->createToken('myApp')->accessToken;
        return ApiBuilder::apiResponseSuccess('Anda berhasil login!', $success, 200);
    } else {
        return ApiBuilder::apiResponseErrors('Gagal login!', [
            'User belum terdaftar atau password anda salah'
        ], 401);
    }
  }

  /**
  * logout user
  */

  public function logout()
  {
    Auth::logout();
    return ApiBuilder::apiResponseSuccess('Anda berhasil logout', null, 200);
  }

  public function dologout()
  {
    Session::flush();
    return redirect()->back();
  }


}
