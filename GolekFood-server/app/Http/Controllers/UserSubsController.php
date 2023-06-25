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

    public function addUserSubs(Request $request)
    {
        try {
            $rules = [
                'user_id' => 'required',
                'subscription' => 'required'
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                return new PostResource(false, "Feedback gagal ditambahkan", $validation->errors()->all());
            }
            $user = User::where('id', $request->user_id)->first();
            if (!$user) {
                return new PostResource(false, "User tidak ditemukan");
            }

            if(($request->subscription) == "Mingguan"){
                $subscription_end = Carbon::now()->addDays(7)->format('Y-m-d H:i:s');
            }

            if(($request->subscription) == "Bulanan"){
                $subscription_end = Carbon::now()->addMonth()->format('Y-m-d H:i:s');
            }

            if(($request->subscription) == "Tahunan"){
                $subscription_end = Carbon::now()->addYear()->format('Y-m-d H:i:s');
            }


            $data = [
                'user_id' => $request->user_id,
                'subscription' => $request->subscription,
                'subscription_start' => Carbon::now()->format('Y-m-d H:i:s'),
                'subscription_end' => $subscription_end
            ];
            $feedback = UserSubs::create($data);


            return new PostResource(true, "subscription berhasil ditambahkan", $feedback);
        } catch (\Throwable $th) {
            return new PostResource(false, "subscription gagal ditambahkan");
        }
    }
}
