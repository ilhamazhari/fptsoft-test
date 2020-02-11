<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtistsController extends Controller
{
    public function index()
    {
      return view('artistcrud', ['usertoken' => auth()->user()->api_token]);
    }
}
