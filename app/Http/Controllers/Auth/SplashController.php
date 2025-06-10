<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SplashController extends Controller
{
  public function show()
  {
    return view('auth.splash');
  }
}