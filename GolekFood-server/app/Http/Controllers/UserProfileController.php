<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    //
    public function index()
    {
        //
        return view('profile'); 
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        $user = $request->user();
        $user = User::where('id',$user->id)->first();

        $avatar = $user->avatar;
        if($request->file('avatar') ){
            $fileName = $this->generateRandomString();
            $extension = $request->file('avatar')->extension();
            $avatar = $fileName.'.'.$extension;
            //jika bukan default
           if($user->avatar != 'default-profile.png'){
               Storage::delete('image/'.$user->avatar);
           }
            Storage::putFileAs('image', $request->file('avatar'), $avatar);
        }
        
        $validatedData['avatar'] = $avatar;

        $user->update($validatedData);
        return redirect('/dashboard-admin')->with('success', 'Profile telah berhasil diperbaharui');
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
