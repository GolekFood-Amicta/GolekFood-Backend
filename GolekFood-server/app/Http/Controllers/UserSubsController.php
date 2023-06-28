<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\UserSubs;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Validator;

class UserSubsController extends Controller
{
    public function getUserSubs($id = null)
    {
        try {
            if (isset($id)) {
                $data = UserSubs::where('user_id', $id)->first();
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

            $data = [
                'user_id' => $request->user_id,
                'subscription' => $request->subscription,
                'status' => 'Inactive',
            ];
            $feedback = UserSubs::create($data);


            return new PostResource(true, "subscription berhasil ditambahkan", $feedback);
        } catch (\Throwable $th) {
            return new PostResource(false, "subscription gagal ditambahkan");
        }
    }
    

    // public function addUserSubs(Request $request)
    // {
    //     try {
    //         $rules = [
    //             'user_id' => 'required',
    //             'subscription' => 'required'
    //         ];
    //         $validation = Validator::make($request->all(), $rules);
    //         if ($validation->fails()) {
    //             return new PostResource(false, "Subscription gagal ditambahkan", $validation->errors()->all());
    //         }
    //         $user = User::where('id', $request->user_id)->first();
    //         if (!$user) {
    //             return new PostResource(false, "User tidak ditemukan");
    //         }

    //         if(($request->subscription) == "Mingguan"){
    //             $subscription_end = Carbon::now()->addDays(7);
    //         }

    //         if(($request->subscription) == "Bulanan"){
    //             $subscription_end = Carbon::now()->addMonth();
    //         }

    //         if(($request->subscription) == "Tahunan"){
    //             $subscription_end = Carbon::now()->addYear();
    //         }


    //         $data = [
    //             'user_id' => $request->user_id,
    //             'subscription' => $request->subscription,
    //             'subscription_start' => Carbon::now(),
    //             'subscription_end' => $subscription_end
    //         ];
    //         $feedback = UserSubs::create($data);


    //         return new PostResource(true, "subscription berhasil ditambahkan", $feedback);
    //     } catch (\Throwable $th) {
    //         return new PostResource(false, "subscription gagal ditambahkan");
    //     }
    // }
}
