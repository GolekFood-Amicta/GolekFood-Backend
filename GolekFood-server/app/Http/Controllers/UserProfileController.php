<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    //
    public function index()
    {
        //
        return view('profile'); 
    }

}
