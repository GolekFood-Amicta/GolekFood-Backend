<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionNews;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionNewsController extends Controller
{

    public function addSubscriptionNews(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email|unique:subscription_news',
            ];
            $messages = [
                'email.required' => 'email tidak boleh kosong',
                'email.email' => 'email tidak valid',
                'email.unique' => 'email sudah terdaftar',
            ];
            $validator = Validator::make($request->only('email'), $rules, $messages);
            if ($validator->fails()) {
                return new PostResource(false, $validator->errors()->first());
            }
            $subscriptionNews = SubscriptionNews::create($request->only('email')    );
            return new PostResource(true, "data berhasil ditambahkan", $subscriptionNews);
        } catch (\Throwable $th) {
            return new PostResource(false, "data gagal ditambahkan");
        }
    }
}
