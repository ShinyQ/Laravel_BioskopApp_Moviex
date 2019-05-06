<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\Customers;
use ApiBuilder;
use Session;
use Hash;
use Bcrypt;
use App\User;

class RegisterController extends Controller
{

  public function index(){
    if (Auth::user()) {
   		return redirect('/studio');
   	} else {
    return view('auth/register');
    }
  }

  public function doRegister(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'email' => 'required|email',
      'password' => 'required',
      'phone'=> 'required',
    ]);

    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'role' => 'admin',
      'password' => Bcrypt($request->password),
      'phone'=> $request->phone
    ]);
    return redirect('/login');
  }

  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'phone' => ['required', 'numeric'],
        'role' => ['required', 'string', 'max:255']
    ]);

    if ($validator->fails()) {
        return ApiBuilder::apiResponseValidationFails('Validation error messages!', $validator->errors()->all());
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'role' => $request->role,
        'password' => Bcrypt($request->password)
    ]);

    $success['user'] = $user;
    $success['token'] = $user->createToken('myApp')->accessToken;

    return ApiBuilder::apiResponseSuccess('Register Sukses!', $success, 200);
  }

}
