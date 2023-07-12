<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\UserSubs;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserSubsController extends Controller
{
    public function getUserSubs($id = null)
    {
        try {
            if (isset($id)) {
                $data = UserSubs::where('user_id', $id)->latest()->get();
                if ($data == null) {
                    return new PostResource(false, "data subscription tidak ditemukan");
                }
            } else {
                $data = UserSubs::all();
            }

            return new PostResource(true, "data subscription ditemukan", $data);
        } catch (\Throwable $th) {
            return new PostResource(false, "data subscription tidak ada");
        }
    }


     public function requestUserSubs(Request $request)
    {
        try {
            $rules = [
                'user_id' => 'required',
                'subscription' => 'required'
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                return new PostResource(false, "Subscription gagal ditambahkan", $validation->errors()->all());
            }
            $user = User::where('id', $request->user_id)->first();
            if (!$user) {
                return new PostResource(false, "User tidak ditemukan");
            }

            $purchase_image = null;
            if($request->file){
                $fileName = $this->generateRandomString();
                $extension = $request->file->extension();
                $purchase_image = $fileName.'.'.$extension;

                Storage::putFileAs('image', $request->file, $purchase_image);
            }

            $data = [
                'user_id' => $request->user_id,
                'subscription' => $request->subscription,
                'status' => 'Inactive',
                'purchase_image' => $purchase_image
            ];
            $feedback = UserSubs::create($data);


            return new PostResource(true, "subscription berhasil ditambahkan", $feedback);
        } catch (\Throwable $th) {
            return new PostResource(false, "subscription gagal ditambahkan");
        }
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
