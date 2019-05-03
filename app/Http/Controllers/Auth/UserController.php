<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ApiBuilder;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  public function detail()
  {
    $user = Auth::user();
    // $id = Auth::id();
    return ApiBuilder::apiResponseSuccess('Detail user login', $user, 200);
  }
}
